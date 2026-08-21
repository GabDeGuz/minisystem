<?php

declare(strict_types=1);

$page_title = 'Customers';
$page_heading = 'Customers';
$page_description = 'Build stronger relationships with every resort guest.';
$active_page = 'customers';

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/includes/record-renderer.php';

$customerColumns = [
    'customer_id' => 'Customer ID',
    'name' => 'Customer',
    'email' => 'Email Address',
    'phone' => 'Phone Number',
    'last_stay' => 'Last Stay',
    'guest_type' => 'Guest Type',
    'status' => 'Status',
];

$customerRecords = $pdo->query(
    'SELECT customer_id, name, email, phone, last_stay, guest_type, status
     FROM customers
     ORDER BY customer_id'
)->fetchAll();

$customerSummary = $pdo->query(
    "SELECT
        COUNT(*) AS total_customers,
        SUM(status = 'Active') AS active_customers,
        SUM(guest_type = 'New Guest') AS new_customers,
        SUM(guest_type = 'Loyalty Member') AS loyalty_members
     FROM customers"
)->fetch();

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
    <button type="button" class="btn btn-primary admin-primary-button">
        <i class="fa-solid fa-user-plus"></i> Add Customer
    </button>
</section>

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

<?php renderRecords('Customer', $customerColumns, $customerRecords); ?>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
