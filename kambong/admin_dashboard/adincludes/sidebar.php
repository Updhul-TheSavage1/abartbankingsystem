<?php
$current = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" type="text/css" href="../../style/sidebar.css">

<!-- Mobile backdrop -->
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<aside class="sidebar" id="sidebar">

    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="logo-icon">
                <i data-lucide="shield-check"></i>
            </div>

            <div class="logo-text">
                <h2>Admin Dashboard</h2>
                <span class="logo-subtitle">Untold Enterprise</span>
            </div>
        </div>

        <button
            type="button"
            class="sidebar-close-btn"
            id="sidebarCloseBtn"
            aria-label="Close navigation menu">
            <i data-lucide="x"></i>
        </button>
    </div>

    <nav class="sidebar-menu">

        <span class="menu-section-label">Core</span>

        <a href="../home/adminboard.php"
           class="nav-item <?= ($current == 'adminboard.php') ? 'active' : ''; ?>">
            <i data-lucide="layout-dashboard"></i>
            <span>Dashboard</span>
        </a>

        <a href="../customer/customer.php"
           class="nav-item <?= ($current == 'customer.php') ? 'active' : ''; ?>">
            <i data-lucide="users"></i>
            <span>Customers</span>
        </a>

        <a href="../books/book.php"
           class="nav-item <?= ($current == 'book.php') ? 'active' : ''; ?>">
            <i data-lucide="book-open"></i>
            <span>Books</span>
        </a>

        <a href="../transactions"
           class="nav-item <?= ($current == 'transaction.php') ? 'active' : ''; ?>">
            <i data-lucide="arrow-left-right"></i>
            <span>Transactions</span>
        </a>

        <span class="menu-section-label">Administration</span>

        <a href="../admin/staffmgt.php"
           class="nav-item <?= ($current == 'staffmgt.php') ? 'active' : ''; ?>">
            <i data-lucide="user-cog"></i>
            <span>Staff</span>
        </a>

        <a href="reports.php"
           class="nav-item <?= ($current == 'reports.php') ? 'active' : ''; ?>">
            <i data-lucide="chart-column"></i>
            <span>Reports</span>
        </a>

        <a href="../admin/audit_logs.php"
           class="nav-item <?= ($current == 'audit_logs.php') ? 'active' : ''; ?>">
            <i data-lucide="file-clock"></i>
            <span>Audit Logs</span>
        </a>

        <a href="../admin/settings.php"
           class="nav-item <?= ($current == 'settings.php') ? 'active' : ''; ?>">
            <i data-lucide="settings"></i>
            <span>Settings</span>
        </a>

    </nav>

    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar">
                <span>SV</span>
                <span class="status-indicator"></span>
            </div>

            <div class="user-info">
                <span class="user-name">Savage Untold</span>
                <span class="user-role">Head Administrator</span>
            </div>
        </div>
    </div>

</aside>

<script src="https://unpkg.com/lucide@latest"></script>
<script src="../../script/sidebar.js"></script>

