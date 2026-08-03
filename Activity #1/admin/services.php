<?php
$page_title = 'Services';
$page_heading = 'Services';
$page_description = 'Curate the experiences available to every resort guest.';
$active_page = 'services';
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
    <article class="stat-card"><div class="stat-icon stat-icon-primary"><i class="fa-solid fa-bell-concierge"></i></div><div><span>Active Services</span><strong>1</strong><small><i class="fa-solid fa-arrow-up"></i> 1 sample record</small></div></article>
    <article class="stat-card"><div class="stat-icon stat-icon-gold"><i class="fa-solid fa-layer-group"></i></div><div><span>Categories</span><strong>1</strong><small>Recreation</small></div></article>
    <article class="stat-card"><div class="stat-icon stat-icon-success"><i class="fa-solid fa-calendar-check"></i></div><div><span>Bookings This Month</span><strong>0</strong><small>No bookings this month</small></div></article>
    <article class="stat-card"><div class="stat-icon stat-icon-rose"><i class="fa-solid fa-star"></i></div><div><span>Average Rating</span><strong>—</strong><small>No guest reviews yet</small></div></article>
</section>

<section class="data-panel">
    <div class="panel-heading">
        <div><h2>Service Catalog</h2><p>Manage 1 available resort experience</p></div>
        <button type="button" class="text-button"><i class="fa-solid fa-sliders"></i> Manage Categories</button>
    </div>

    <div class="record-toolbar">
        <label class="search-field"><i class="fa-solid fa-magnifying-glass"></i><input type="search" placeholder="Search a service" aria-label="Search a service"></label>
        <div class="toolbar-filters">
            <button type="button" class="filter-button"><i class="fa-solid fa-layer-group"></i> All Categories <i class="fa-solid fa-chevron-down"></i></button>
            <button type="button" class="filter-button"><i class="fa-solid fa-circle-dot"></i> Active <i class="fa-solid fa-chevron-down"></i></button>
        </div>
    </div>

    <div class="service-grid">
        <article class="service-card">
            <div class="service-card-top"><span class="service-icon icon-water"><i class="fa-solid fa-water"></i></span><span class="status-badge status-active"><i class="fa-solid fa-circle"></i> Available</span></div>
            <p class="service-category">Recreation</p><h3>Private Pool Access</h3><p class="service-description">Exclusive access to a private pool area with lounge chairs and towel service.</p>
            <div class="service-meta"><span><i class="fa-regular fa-clock"></i> Full day</span><strong>₱2,500 <small>/ guest</small></strong></div>
            <div class="service-actions"><button type="button" class="btn btn-secondary compact-button">View Details</button><button type="button" class="square-button" aria-label="Edit Private Pool Access"><i class="fa-solid fa-pen"></i></button></div>
        </article>
    </div>

    <div class="table-footer"><p>Showing <strong>1</strong> of <strong>1</strong> service</p><button type="button" class="text-button">View All Services <i class="fa-solid fa-arrow-right"></i></button></div>
</section>

<?php include __DIR__ . '/includes/admin-footer.php'; ?>
