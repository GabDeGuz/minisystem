<?php
$management_links = [
    'staff' => ['label' => 'Staff Records', 'href' => 'staff-records.php', 'icon' => 'fa-id-badge'],
    'services' => ['label' => 'Services', 'href' => 'services.php', 'icon' => 'fa-bell-concierge'],
    'customers' => ['label' => 'Customers', 'href' => 'customers.php', 'icon' => 'fa-users'],
];
?>
<aside class="admin-sidebar" aria-label="Management navigation">
    <div class="sidebar-brand">
        <a href="staff-records.php" class="sidebar-logo" aria-label="De Guzman Resort management">
            <span class="sidebar-logo-mark"><i class="fa-solid fa-umbrella-beach"></i></span>
            <span><strong>DE GUZMAN</strong><small>RESORT MANAGEMENT</small></span>
        </a>
    </div>

    <div class="sidebar-menu">
        <p class="sidebar-label">Management</p>
        <nav>
            <ul class="sidebar-nav">
                <?php foreach ($management_links as $key => $link): ?>
                    <li>
                        <a href="<?php echo $link['href']; ?>" class="sidebar-link <?php echo $active_page === $key ? 'active' : ''; ?>">
                            <i class="fa-solid <?php echo $link['icon']; ?>"></i>
                            <span><?php echo $link['label']; ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div class="sidebar-divider"></div>
        <p class="sidebar-label">Website</p>
        <a href="../index.php" class="sidebar-link sidebar-link-muted">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>View Resort Website</span>
        </a>
    </div>

    <div class="sidebar-user">
        <span class="avatar avatar-gold">EG</span>
        <div>
            <strong>Earl Gabriel De Guzman</strong>
            <small>Resort Administrator</small>
        </div>
        <i class="fa-solid fa-ellipsis"></i>
    </div>

    <label for="sidebar-toggle" class="sidebar-backdrop" aria-label="Close navigation menu"></label>
</aside>
