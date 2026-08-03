<?php
$page_title = 'Staff Records';
$page_heading = 'Staff Records';
$page_description = 'View and organize your resort team in one place.';
$active_page = 'staff';
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
        <div><span>Total Staff</span><strong>1</strong><small><i class="fa-solid fa-arrow-up"></i> 1 sample record</small></div>
    </article>
    <article class="stat-card">
        <div class="stat-icon stat-icon-success"><i class="fa-solid fa-user-check"></i></div>
        <div><span>On Duty Today</span><strong>1</strong><small><i class="fa-solid fa-circle"></i> 100% team availability</small></div>
    </article>
    <article class="stat-card">
        <div class="stat-icon stat-icon-gold"><i class="fa-solid fa-building"></i></div>
        <div><span>Departments</span><strong>1</strong><small>Across resort operations</small></div>
    </article>
    <article class="stat-card">
        <div class="stat-icon stat-icon-rose"><i class="fa-solid fa-calendar-xmark"></i></div>
        <div><span>On Leave</span><strong>0</strong><small>No staff currently on leave</small></div>
    </article>
</section>

<section class="data-panel">
    <div class="panel-heading">
        <div>
            <h2>Staff Directory</h2>
            <p>Showing 1 of 1 staff member</p>
        </div>
        <button type="button" class="text-button"><i class="fa-solid fa-arrow-down-wide-short"></i> Sort: Newest</button>
    </div>

    <div class="record-toolbar">
        <label class="search-field">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" placeholder="Search staff member" aria-label="Search staff member">
        </label>
        <div class="toolbar-filters">
            <button type="button" class="filter-button"><i class="fa-solid fa-building"></i> All Departments <i class="fa-solid fa-chevron-down"></i></button>
            <button type="button" class="filter-button"><i class="fa-solid fa-circle-dot"></i> All Statuses <i class="fa-solid fa-chevron-down"></i></button>
        </div>
    </div>

    <div class="table-scroll">
        <table class="records-table">
            <thead>
                <tr>
                    <th>Staff Member</th>
                    <th>Employee ID</th>
                    <th>Department</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th><span class="sr-only">Actions</span></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><div class="person-cell"><span class="avatar avatar-sky">JM</span><div><strong>Juan Miguel Reyes</strong><span>Front Office Manager</span></div></div></td>
                    <td><span class="record-id">DGR-1001</span></td>
                    <td><span class="department-tag">Front Office</span></td>
                    <td><div class="contact-cell"><span>juan.reyes@dgr.com</span><span>+63 917 234 8102</span></div></td>
                    <td><span class="status-badge status-active"><i class="fa-solid fa-circle"></i> On Duty</span></td>
                    <td><button type="button" class="row-action" aria-label="View Juan Miguel Reyes"><i class="fa-solid fa-ellipsis"></i></button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-footer">
        <p>Showing <strong>1</strong> of <strong>1</strong> record</p>
        <nav class="pagination" aria-label="Staff records pages">
            <button type="button" class="pagination-button" aria-label="Previous page" disabled><i class="fa-solid fa-chevron-left"></i></button>
            <button type="button" class="pagination-button active" aria-current="page">1</button>
            <button type="button" class="pagination-button" aria-label="Next page" disabled><i class="fa-solid fa-chevron-right"></i></button>
        </nav>
    </div>
</section>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
