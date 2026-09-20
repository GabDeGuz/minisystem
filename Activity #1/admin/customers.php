<?php

declare(strict_types=1);

$sessionDirectory = dirname(__DIR__) . '/storage/sessions';
session_save_path($sessionDirectory);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$page_title = 'Customers';
$page_heading = 'Customers';
$page_description = 'Build stronger relationships with every resort guest.';
$active_page = 'customers';

require_once __DIR__ . '/../Model/DB_Model.php';

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$formErrors = [];
$formData = [
    'name' => '',
    'email' => '',
    'phone' => '',
    'last_stay' => '',
    'guest_type' => 'New Guest',
    'status' => 'Active',
];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && ($_POST['action'] ?? '') === 'add_customer') {
    $submittedToken = (string) ($_POST['csrf_token'] ?? '');

    foreach (array_keys($formData) as $field) {
        $formData[$field] = trim((string) ($_POST[$field] ?? ''));
    }

    if (!hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        $formErrors[] = 'Your session expired. Please refresh the page and try again.';
    } else {
        $saveError = validate_form('customer', $formData);

        if ($saveError === null) {
            $customerId = next_record_id('customers', 'customer_id', 'CUS-', 2000);
            $name = mysqli_real_escape_string($connection, $formData['name']);
            $email = mysqli_real_escape_string($connection, $formData['email']);
            $phone = mysqli_real_escape_string($connection, $formData['phone']);
            $lastStay = mysqli_real_escape_string($connection, $formData['last_stay']);
            $guestType = mysqli_real_escape_string($connection, $formData['guest_type']);
            $status = mysqli_real_escape_string($connection, $formData['status']);

            $newCustomer = "INSERT INTO customers
                (customer_id, name, email, phone, last_stay, guest_type, status)
                VALUES ('$customerId', '$name', '$email', '$phone', '$lastStay', '$guestType', '$status')";
            $GLOBALS['uploadFileName'] = 'customer_' . strtolower($customerId) . '.jpg';

            save($newCustomer);
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            redirect_to('customers.php?added=1');
        }

        if ($saveError !== null) {
            $formErrors[] = $saveError;
        }
    }
}

$customerColumns = [
    'customer_id' => 'Customer ID',
    'name' => 'Customer',
    'email' => 'Email Address',
    'phone' => 'Phone Number',
    'last_stay' => 'Last Stay',
    'guest_type' => 'Guest Type',
    'status' => 'Status',
];

$customerSql =
    'SELECT customer_id, name, email, phone, last_stay, guest_type, status
     FROM customers
     ORDER BY customer_id';

$customerSummary = fetch_record_summary(
    "SELECT
        COUNT(*) AS total_customers,
        SUM(status = 'Active') AS active_customers,
        SUM(guest_type = 'New Guest') AS new_customers,
        SUM(guest_type = 'Loyalty Member') AS loyalty_members
     FROM customers"
);

$totalCustomers = (int) $customerSummary['total_customers'];
$activeCustomers = (int) $customerSummary['active_customers'];
$newCustomers = (int) $customerSummary['new_customers'];
$loyaltyMembers = (int) $customerSummary['loyalty_members'];

include __DIR__ . '/includes/admin-head.php';
?>

<section class="management-page-header">
    <div>
        <p class="section-kicker"><i class="fa-solid fa-heart"></i> Guest relationships</p>
        <h2>Know the guests who make your resort special.</h2>
        <p>Review guest profiles, recent stays, and loyalty status from one directory.</p>
    </div>
    <button type="button" class="btn btn-primary admin-primary-button" id="open-customer-dialog">
        <i class="fa-solid fa-user-plus"></i> Add Customer
    </button>
</section>

<?php if (isset($_GET['added'])): ?>
    <div class="admin-alert admin-alert-success" role="status">
        <i class="fa-solid fa-circle-check"></i>
        <span>Customer added successfully.</span>
    </div>
<?php endif; ?>

<dialog class="admin-dialog" id="customer-dialog" <?php echo $formErrors !== [] ? 'data-reopen' : ''; ?>>
    <div class="dialog-heading">
        <div>
            <p class="section-kicker"><i class="fa-solid fa-user-plus"></i> New customer</p>
            <h2>Add a customer</h2>
            <p>Enter the customer information below. A customer ID will be generated automatically.</p>
        </div>
        <button type="button" class="dialog-close" id="close-customer-dialog" aria-label="Close form">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <?php if ($formErrors !== []): ?>
        <div class="admin-alert admin-alert-error" role="alert">
            <i class="fa-solid fa-circle-exclamation"></i>
            <ul>
                <?php foreach ($formErrors as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="admin-form">
        <input type="hidden" name="action" value="add_customer">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">

        <div class="form-grid">
            <label class="form-field form-field-wide">
                <span>Name</span>
                <input type="text" name="name" maxlength="100" required value="<?php echo htmlspecialchars($formData['name'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="e.g. Maria Santos">
            </label>

            <label class="form-field">
                <span>Email Address</span>
                <input type="email" name="email" maxlength="100" required value="<?php echo htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="name@example.com">
            </label>

            <label class="form-field">
                <span>Phone Number</span>
                <input type="text" name="phone" maxlength="30" required value="<?php echo htmlspecialchars($formData['phone'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="+63 917 000 0000">
            </label>

            <label class="form-field">
                <span>Last Stay</span>
                <input type="text" name="last_stay" maxlength="50" required value="<?php echo htmlspecialchars($formData['last_stay'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="e.g. August 20-22, 2026">
            </label>

            <label class="form-field">
                <span>Guest Type</span>
                <select name="guest_type" required>
                    <?php foreach (['VIP Guest', 'Returning Guest', 'New Guest', 'Loyalty Member'] as $guestType): ?>
                        <option value="<?php echo $guestType; ?>" <?php echo $formData['guest_type'] === $guestType ? 'selected' : ''; ?>>
                            <?php echo $guestType; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label class="form-field form-field-wide">
                <span>Status</span>
                <select name="status" required>
                    <?php foreach (['Active', 'Inactive'] as $status): ?>
                        <option value="<?php echo $status; ?>" <?php echo $formData['status'] === $status ? 'selected' : ''; ?>>
                            <?php echo $status; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label class="form-field form-field-wide">
                <span>Customer Profile Image</span>
                <input
                    type="file"
                    name="fileField"
                    id="fileField"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    required
                >
                <small class="form-help">JPG, PNG, or WebP only. Maximum file size: 5 MB.</small>
            </label>
        </div>

        <div class="dialog-actions">
            <button type="button" class="btn btn-secondary" id="cancel-customer-dialog">Cancel</button>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Save Customer
            </button>
        </div>
    </form>
</dialog>

<section class="stats-grid" aria-label="Customer summary">
    <article class="stat-card">
        <div class="stat-icon stat-icon-primary"><i class="fa-solid fa-users"></i></div>
        <div><span>Total Customers</span><strong><?php echo $totalCustomers; ?></strong><small>Database customer records</small></div>
    </article>
    <article class="stat-card">
        <div class="stat-icon stat-icon-success"><i class="fa-solid fa-person-walking-luggage"></i></div>
        <div><span>Active Guests</span><strong><?php echo $activeCustomers; ?></strong><small>Active guest profiles</small></div>
    </article>
    <article class="stat-card">
        <div class="stat-icon stat-icon-gold"><i class="fa-solid fa-user-clock"></i></div>
        <div><span>New Guests</span><strong><?php echo $newCustomers; ?></strong><small>New guest profiles</small></div>
    </article>
    <article class="stat-card">
        <div class="stat-icon stat-icon-rose"><i class="fa-solid fa-crown"></i></div>
        <div><span>Loyalty Members</span><strong><?php echo $loyaltyMembers; ?></strong><small>Registered loyalty members</small></div>
    </article>
</section>

<?php
display_all($customerSql, $customerColumns, 'customers.php');
?>

<script>
    const customerDialog = document.getElementById('customer-dialog');
    const openCustomerDialog = document.getElementById('open-customer-dialog');
    const closeCustomerDialog = document.getElementById('close-customer-dialog');
    const cancelCustomerDialog = document.getElementById('cancel-customer-dialog');

    openCustomerDialog.addEventListener('click', () => customerDialog.showModal());
    closeCustomerDialog.addEventListener('click', () => customerDialog.close());
    cancelCustomerDialog.addEventListener('click', () => customerDialog.close());

    customerDialog.addEventListener('click', (event) => {
        if (event.target === customerDialog) {
            customerDialog.close();
        }
    });

    if (customerDialog.hasAttribute('data-reopen')) {
        customerDialog.showModal();
    }
</script>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
