<?php
$page_title = 'Customers';
$page_heading = 'Customers';
$page_description = 'Build stronger relationships with every resort guest.';
$active_page = 'customers';
include __DIR__ . '/includes/admin-head.php';
?>

<section class="management-page-header">
    <div>
        <p class="section-kicker"><i class="fa-solid fa-heart"></i> Guest relationships</p>
        <h2>Know the guests who make your resort special.</h2>
        <p>Review guest profiles, recent stays, and loyalty status from one directory.</p>
    </div>
    <button type="button" class="btn btn-primary admin-primary-button"><i class="fa-solid fa-user-plus"></i> Add Customer</button>
</section>

<section class="stats-grid" aria-label="Customer summary">
    <article class="stat-card"><div class="stat-icon stat-icon-primary"><i class="fa-solid fa-users"></i></div><div><span>Total Customers</span><strong>1</strong><small><i class="fa-solid fa-arrow-up"></i> 1 sample record</small></div></article>
    <article class="stat-card"><div class="stat-icon stat-icon-success"><i class="fa-solid fa-person-walking-luggage"></i></div><div><span>Current Guests</span><strong>0</strong><small>No guests checked in today</small></div></article>
    <article class="stat-card"><div class="stat-icon stat-icon-gold"><i class="fa-solid fa-user-clock"></i></div><div><span>New This Month</span><strong>0</strong><small>No new customers this month</small></div></article>
    <article class="stat-card"><div class="stat-icon stat-icon-rose"><i class="fa-solid fa-crown"></i></div><div><span>Loyalty Members</span><strong>1</strong><small>100% of all guests</small></div></article>
</section>

<section class="data-panel">
    <div class="panel-heading">
        <div><h2>Customer Directory</h2><p>Showing 1 of 1 registered guest</p></div>
        <button type="button" class="text-button"><i class="fa-solid fa-file-export"></i> Export Directory</button>
    </div>

    <div class="record-toolbar">
        <label class="search-field"><i class="fa-solid fa-magnifying-glass"></i><input type="search" placeholder="Search name, email, or phone" aria-label="Search customer"></label>
        <div class="toolbar-filters"><button type="button" class="filter-button"><i class="fa-solid fa-tag"></i> All Guest Types <i class="fa-solid fa-chevron-down"></i></button><button type="button" class="filter-button"><i class="fa-solid fa-circle-dot"></i> All Statuses <i class="fa-solid fa-chevron-down"></i></button></div>
    </div>

    <div class="table-scroll">
        <table class="records-table customer-table">
            <thead><tr><th>Customer</th><th>Contact Details</th><th>Last Stay</th><th>Guest Type</th><th>Status</th><th><span class="sr-only">Actions</span></th></tr></thead>
            <tbody>
                <tr><td><div class="person-cell"><span class="avatar avatar-gold">MC</span><div><strong>Maria C. Santos</strong><span>Customer since Mar 2023</span></div></div></td><td><div class="contact-cell"><span>maria.santos@email.com</span><span>+63 917 423 0921</span></div></td><td><div class="stay-cell"><strong>Jul 22–24, 2026</strong><span>Executive Lagoon Villa</span></div></td><td><span class="guest-tag guest-vip"><i class="fa-solid fa-crown"></i> VIP Guest</span></td><td><span class="status-badge status-active"><i class="fa-solid fa-circle"></i> Active</span></td><td><button type="button" class="row-action" aria-label="View Maria C. Santos"><i class="fa-solid fa-ellipsis"></i></button></td></tr>
            </tbody>
        </table>
    </div>

    <div class="table-footer"><p>Showing <strong>1</strong> of <strong>1</strong> record</p><nav class="pagination" aria-label="Customer records pages"><button type="button" class="pagination-button" aria-label="Previous page" disabled><i class="fa-solid fa-chevron-left"></i></button><button type="button" class="pagination-button active" aria-current="page">1</button><button type="button" class="pagination-button" aria-label="Next page" disabled><i class="fa-solid fa-chevron-right"></i></button></nav></div>
</section>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
