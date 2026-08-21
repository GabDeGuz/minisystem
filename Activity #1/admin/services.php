<?php

declare(strict_types=1);

$page_title = 'Services';
$page_heading = 'Services';
$page_description = 'Curate the experiences available to every resort guest.';
$active_page = 'services';

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/includes/record-renderer.php';

$serviceColumns = [
    'service_id' => 'Service ID',
    'service_name' => 'Service Name',
    'category' => 'Category',
    'duration' => 'Duration',
    'price' => 'Price',
    'status' => 'Status',
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
    <button type="button" class="btn btn-primary admin-primary-button">
        <i class="fa-solid fa-plus"></i> Add Service
    </button>
</section>

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

<?php renderRecords('Service', $serviceColumns, $serviceRecords); ?>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
