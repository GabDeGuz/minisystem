<?php

declare(strict_types=1);

$sessionDirectory = dirname(__DIR__) . '/storage/sessions';
session_save_path($sessionDirectory);
session_start();

$page_title = 'Services';
$page_heading = 'Services';
$page_description = 'Curate the experiences available to every resort guest.';
$active_page = 'services';

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/save-data.php';
require_once __DIR__ . '/includes/record-renderer.php';

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$formErrors = [];
$formData = [
    'service_name' => '',
    'category' => '',
    'duration' => '',
    'price' => '',
    'status' => 'Available',
];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && ($_POST['action'] ?? '') === 'add_service') {
    $submittedToken = (string) ($_POST['csrf_token'] ?? '');

    foreach (array_keys($formData) as $field) {
        $formData[$field] = trim((string) ($_POST[$field] ?? ''));
    }

    if (!hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        $formErrors[] = 'Your session expired. Please refresh the page and try again.';
    } else {
        $saveError = saveService($pdo, $formData, $_FILES['image'] ?? []);

        if ($saveError === null) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            header('Location: services.php?added=1');
            exit;
        }

        $formErrors[] = $saveError;
    }
}

$serviceColumns = [
    'image' => 'Image',
    'service_id' => 'Service ID',
    'service_name' => 'Service Name',
    'category' => 'Category',
    'duration' => 'Duration',
    'price' => 'Price',
    'status' => 'Status',
];

$serviceColumnTypes = [
    'image' => 'image',
];

$serviceRecords = $pdo->query(
    "SELECT
        service_id,
        service_name,
        category,
        duration,
        CONCAT('PHP ', FORMAT(price, 2)) AS price,
        status
     FROM services
     ORDER BY service_id"
)->fetchAll();

$serviceImageDirectory = dirname(__DIR__) . '/images';
$allowedImageExtensions = ['jpg', 'jpeg', 'png', 'webp'];

foreach ($serviceRecords as &$serviceRecord) {
    $imageBaseName = 'service_' . strtolower((string) $serviceRecord['service_id']);
    $serviceRecord['image'] = '';

    foreach ($allowedImageExtensions as $extension) {
        $imageFileName = $imageBaseName . '.' . $extension;

        if (is_file($serviceImageDirectory . '/' . $imageFileName)) {
            $serviceRecord['image'] = '../images/' . rawurlencode($imageFileName);
            break;
        }
    }
}
unset($serviceRecord);

$serviceSummary = $pdo->query(
    "SELECT
        COUNT(*) AS total_services,
        COUNT(DISTINCT category) AS category_count,
        SUM(status = 'Available') AS available_services,
        SUM(status = 'Limited') AS limited_services
     FROM services"
)->fetch();

$totalServices = (int) $serviceSummary['total_services'];
$categoryCount = (int) $serviceSummary['category_count'];
$availableServices = (int) $serviceSummary['available_services'];
$limitedServices = (int) $serviceSummary['limited_services'];

include __DIR__ . '/includes/admin-head.php';
?>

<section class="management-page-header">
    <div>
        <p class="section-kicker"><i class="fa-solid fa-star"></i> Guest experiences</p>
        <h2>Deliver memorable moments at every stay.</h2>
        <p>Review the resort services, availability, and guest experience offerings.</p>
    </div>
    <button type="button" class="btn btn-primary admin-primary-button" id="open-service-dialog">
        <i class="fa-solid fa-plus"></i> Add Service
    </button>
</section>

<?php if (isset($_GET['added'])): ?>
    <div class="admin-alert admin-alert-success" role="status">
        <i class="fa-solid fa-circle-check"></i>
        <span>Service added successfully.</span>
    </div>
<?php endif; ?>

<dialog class="admin-dialog" id="service-dialog" <?php echo $formErrors !== [] ? 'data-reopen' : ''; ?>>
    <div class="dialog-heading">
        <div>
            <p class="section-kicker"><i class="fa-solid fa-bell-concierge"></i> New service</p>
            <h2>Add a resort service</h2>
            <p>Enter the service information below. A service ID will be generated automatically.</p>
        </div>
        <button type="button" class="dialog-close" id="close-service-dialog" aria-label="Close form">
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
        <input type="hidden" name="action" value="add_service">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">

        <div class="form-grid">
            <label class="form-field form-field-wide">
                <span>Service Name</span>
                <input type="text" name="service_name" maxlength="100" required value="<?php echo htmlspecialchars($formData['service_name'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="e.g. Kayak Rental">
            </label>

            <label class="form-field">
                <span>Category</span>
                <input type="text" name="category" maxlength="100" required value="<?php echo htmlspecialchars($formData['category'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="e.g. Recreation">
            </label>

            <label class="form-field">
                <span>Duration</span>
                <input type="text" name="duration" maxlength="50" required value="<?php echo htmlspecialchars($formData['duration'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="e.g. 2 hours">
            </label>

            <label class="form-field">
                <span>Price (PHP)</span>
                <input type="number" name="price" min="0.01" max="99999999.99" step="0.01" required value="<?php echo htmlspecialchars($formData['price'], ENT_QUOTES, 'UTF-8'); ?>" placeholder="0.00">
            </label>

            <label class="form-field">
                <span>Status</span>
                <select name="status" required>
                    <?php foreach (['Available', 'Limited', 'Unavailable'] as $status): ?>
                        <option value="<?php echo $status; ?>" <?php echo $formData['status'] === $status ? 'selected' : ''; ?>>
                            <?php echo $status; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>

            <label class="form-field form-field-wide">
                <span>Service Image</span>
                <input
                    type="file"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    required
                >
                <small class="form-help">JPG, PNG, or WebP only. Maximum file size: 5 MB.</small>
            </label>
        </div>

        <div class="dialog-actions">
            <button type="button" class="btn btn-secondary" id="cancel-service-dialog">Cancel</button>
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk"></i> Save Service
            </button>
        </div>
    </form>
</dialog>

<section class="stats-grid" aria-label="Service summary">
    <article class="stat-card">
        <div class="stat-icon stat-icon-primary"><i class="fa-solid fa-bell-concierge"></i></div>
        <div><span>Total Services</span><strong><?php echo $totalServices; ?></strong><small>Database service records</small></div>
    </article>
    <article class="stat-card">
        <div class="stat-icon stat-icon-gold"><i class="fa-solid fa-layer-group"></i></div>
        <div><span>Categories</span><strong><?php echo $categoryCount; ?></strong><small>Across guest experiences</small></div>
    </article>
    <article class="stat-card">
        <div class="stat-icon stat-icon-success"><i class="fa-solid fa-calendar-check"></i></div>
        <div><span>Available Today</span><strong><?php echo $availableServices; ?></strong><small>Services currently available</small></div>
    </article>
    <article class="stat-card">
        <div class="stat-icon stat-icon-rose"><i class="fa-solid fa-star"></i></div>
        <div><span>Limited Services</span><strong><?php echo $limitedServices; ?></strong><small>Services with limited slots</small></div>
    </article>
</section>

<?php
// Reusable record renderer: Service data with image support.
renderRecords('Service', $serviceColumns, $serviceRecords, $serviceColumnTypes);
?>

<script>
    const serviceDialog = document.getElementById('service-dialog');
    const openServiceDialog = document.getElementById('open-service-dialog');
    const closeServiceDialog = document.getElementById('close-service-dialog');
    const cancelServiceDialog = document.getElementById('cancel-service-dialog');

    openServiceDialog.addEventListener('click', () => serviceDialog.showModal());
    closeServiceDialog.addEventListener('click', () => serviceDialog.close());
    cancelServiceDialog.addEventListener('click', () => serviceDialog.close());

    serviceDialog.addEventListener('click', (event) => {
        if (event.target === serviceDialog) {
            serviceDialog.close();
        }
    });

    if (serviceDialog.hasAttribute('data-reopen')) {
        serviceDialog.showModal();
    }
</script>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
