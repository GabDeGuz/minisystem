<?php

declare(strict_types=1);

$sessionDirectory = dirname(__DIR__) . '/storage/sessions';

if (!is_dir($sessionDirectory)) {
    mkdir($sessionDirectory, 0755, true);
}

session_save_path($sessionDirectory);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$page_title = 'Staff Records';
$page_heading = 'Staff Records';
$page_description = 'View and organize your resort team in one place.';
$active_page = 'staff';

require_once __DIR__ . '/../Model/DB_Model.php';
require_once __DIR__ . '/includes/admin-helpers.php';

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$formErrors = [];
$formData = [
    'name' => '',
    'position' => '',
    'department' => '',
    'email' => '',
    'phone' => '',
    'status' => 'On Duty',
];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && ($_POST['action'] ?? '') === 'add_staff') {
    $submittedToken = (string) ($_POST['csrf_token'] ?? '');

    foreach (array_keys($formData) as $field) {
        $formData[$field] = trim((string) ($_POST[$field] ?? ''));
    }

    if (!hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        $formErrors[] = 'Your session expired. Please refresh the page and try again.';
    } else {
        $saveError = validate_form('staff', $formData);

        if ($saveError === null) {
            $employeeId = next_record_id('staff', 'employee_id', 'DGR-', 1000);
            $name = mysqli_real_escape_string($connection, $formData['name']);
            $position = mysqli_real_escape_string($connection, $formData['position']);
            $department = mysqli_real_escape_string($connection, $formData['department']);
            $email = mysqli_real_escape_string($connection, $formData['email']);
            $phone = mysqli_real_escape_string($connection, $formData['phone']);
            $status = mysqli_real_escape_string($connection, $formData['status']);

            $newStaff = "INSERT INTO staff
                (employee_id, name, position, department, email, phone, status)
                VALUES ('$employeeId', '$name', '$position', '$department', '$email', '$phone', '$status')";

            save($newStaff);
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            redirect_to('staff-records.php?added=1');
        }

        if ($saveError !== null) {
            $formErrors[] = $saveError;
        }
    }
}

$staffColumns = [
    'employee_id' => 'Employee ID',
    'name' => 'Staff Member',
    'position' => 'Position',
    'department' => 'Department',
    'email' => 'Email Address',
    'phone' => 'Phone Number',
    'status' => 'Status',
];

$staffSql =
    'SELECT employee_id, name, position, department, email, phone, status
     FROM staff
     ORDER BY employee_id';

$staffSummary = fetch_record_summary(
    "SELECT
        COUNT(*) AS total_staff,
        SUM(status = 'On Duty') AS on_duty_staff,
        COUNT(DISTINCT department) AS department_count,
        SUM(status = 'On Leave') AS on_leave_staff
     FROM staff"
);

$totalStaff = (int) $staffSummary['total_staff'];
$onDutyStaff = (int) $staffSummary['on_duty_staff'];
$departmentCount = (int) $staffSummary['department_count'];
$onLeaveStaff = (int) $staffSummary['on_leave_staff'];

include __DIR__ . '/includes/admin-head.php';
?>

<section class="management-page-header">
    <div>
        <p class="section-kicker"><i class="fa-solid fa-user-shield"></i> Team directory</p>
        <h2>Keep your staff information up to date.</h2>
        <p>Monitor staff roles, departments, and daily availability across the resort.</p>
    </div>
    <button type="button" class="btn btn-primary admin-primary-button" id="open-staff-dialog">
        <i class="fa-solid fa-plus"></i> Add Staff Member
    </button>
</section>

<?php if (isset($_GET['added'])): ?>
    <div class="admin-alert admin-alert-success" role="status">
        <i class="fa-solid fa-circle-check"></i>
        <span>Staff member added successfully.</span>
    </div>
<?php endif; ?>

<dialog class="admin-dialog" id="staff-dialog" <?php echo $formErrors !== [] ? 'data-reopen' : ''; ?>>
    <div class="dialog-heading">
        <div>
            <p class="section-kicker"><i class="fa-solid fa-user-plus"></i> New staff member</p>
            <h2>Add a staff member</h2>
            <p>Enter the staff information below. An employee ID will be generated automatically.</p>
        </div>
        <button type="button" class="dialog-close" id="close-staff-dialog" aria-label="Close form">
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

    <form method="post" class="admin-form">
        <input type="hidden" name="action" value="add_staff">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">

        <div class="form-grid">
            <label class="form-field form-field-wide">
                <span>Name</span>
                <input type="text" name="name" maxlength="100" required value="<?php echo htmlspecialchars($formData['name'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="e.g. Juan Dela Cruz">
            </label>

            <label class="form-field">
                <span>Position</span>
                <input type="text" name="position" maxlength="100" required value="<?php echo htmlspecialchars($formData['position'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="e.g. Front Desk Officer">
            </label>

            <label class="form-field">
                <span>Department</span>
                <input type="text" name="department" maxlength="100" required value="<?php echo htmlspecialchars($formData['department'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="e.g. Front Office">
            </label>

            <label class="form-field">
                <span>Email Address</span>
                <input type="email" name="email" maxlength="100" required value="<?php echo htmlspecialchars($formData['email'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="name@example.com">
            </label>

            <label class="form-field">
                <span>Phone Number</span>
                <input type="text" name="phone" maxlength="30" required value="<?php echo htmlspecialchars($formData['phone'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="+63 917 000 0000">
            </label>

            <label class="form-field form-field-wide">
                <span>Status</span>
                <select name="status" required>
                    <?php foreach (['On Duty', 'On Leave', 'Off Duty'] as $status): ?>
                        <option value="<?php echo $status; ?>" <?php echo $formData['status'] === $status ? 'selected' : ''; ?>>
                            <?php echo $status; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>

        <div class="dialog-actions">
            <button type="button" class="btn btn-secondary" id="cancel-staff-dialog">Cancel</button>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Save Staff
            </button>
        </div>
    </form>
</dialog>

<section class="stats-grid" aria-label="Staff summary">
    <article class="stat-card">
        <div class="stat-icon stat-icon-primary"><i class="fa-solid fa-users"></i></div>
        <div><span>Total Staff</span><strong><?php echo $totalStaff; ?></strong><small>Database staff records</small></div>
    </article>
    <article class="stat-card">
        <div class="stat-icon stat-icon-success"><i class="fa-solid fa-user-check"></i></div>
        <div><span>On Duty Today</span><strong><?php echo $onDutyStaff; ?></strong><small>Available team members</small></div>
    </article>
    <article class="stat-card">
        <div class="stat-icon stat-icon-gold"><i class="fa-solid fa-building"></i></div>
        <div><span>Departments</span><strong><?php echo $departmentCount; ?></strong><small>Across resort operations</small></div>
    </article>
    <article class="stat-card">
        <div class="stat-icon stat-icon-rose"><i class="fa-solid fa-calendar-xmark"></i></div>
        <div><span>On Leave</span><strong><?php echo $onLeaveStaff; ?></strong><small>Staff members on leave</small></div>
    </article>
</section>

<?php
display_all($staffSql, $staffColumns, 'staff-records.php');
?>

<script>
    const staffDialog = document.getElementById('staff-dialog');
    const openStaffDialog = document.getElementById('open-staff-dialog');
    const closeStaffDialog = document.getElementById('close-staff-dialog');
    const cancelStaffDialog = document.getElementById('cancel-staff-dialog');

    openStaffDialog.addEventListener('click', () => staffDialog.showModal());
    closeStaffDialog.addEventListener('click', () => staffDialog.close());
    cancelStaffDialog.addEventListener('click', () => staffDialog.close());

    staffDialog.addEventListener('click', (event) => {
        if (event.target === staffDialog) {
            staffDialog.close();
        }
    });

    if (staffDialog.hasAttribute('data-reopen')) {
        staffDialog.showModal();
    }
</script>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
