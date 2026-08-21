<?php

declare(strict_types=1);

$page_title = 'Staff Records';
$page_heading = 'Staff Records';
$page_description = 'View and organize your resort team in one place.';
$active_page = 'staff';

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/includes/record-renderer.php';

$staffColumns = [
    'employee_id' => 'Employee ID',
    'name' => 'Staff Member',
    'position' => 'Position',
    'department' => 'Department',
    'email' => 'Email Address',
    'phone' => 'Phone Number',
    'status' => 'Status',
];

$staffRecords = $pdo->query(
    'SELECT employee_id, name, position, department, email, phone, status
     FROM staff
     ORDER BY employee_id'
)->fetchAll();

$staffSummary = $pdo->query(
    "SELECT
        COUNT(*) AS total_staff,
        SUM(status = 'On Duty') AS on_duty_staff,
        COUNT(DISTINCT department) AS department_count,
        SUM(status = 'On Leave') AS on_leave_staff
     FROM staff"
)->fetch();

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
    <button type="button" class="btn btn-primary admin-primary-button">
        <i class="fa-solid fa-plus"></i> Add Staff Member
    </button>
</section>

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

<?php renderRecords('Staff', $staffColumns, $staffRecords); ?>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
