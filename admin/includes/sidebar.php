<?php
/**
 * Admin Panel - Sidebar Navigation Component
 */

$currentAdminPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <a href="<?= ADMIN_URL ?>/index.php" class="d-flex align-items-center gap-2 text-decoration-none">
            <svg width="32" height="32" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="100" height="100" rx="20" fill="#0b422e"/>
                <path d="M50 18 C30 35 30 75 50 82 C70 75 70 35 50 18 Z" fill="#d4af37"/>
            </svg>
            <div>
                <strong class="text-white d-block lead mb-0">GIRNA GLOBAL</strong>
                <small class="text-gold" style="font-size:0.65rem; letter-spacing:1px;">ADMIN PANEL</small>
            </div>
        </a>
    </div>

    <ul class="sidebar-menu">
        <li>
            <a href="<?= ADMIN_URL ?>/index.php" class="sidebar-link <?= ($currentAdminPage === 'index') ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="<?= ADMIN_URL ?>/settings.php" class="sidebar-link <?= ($currentAdminPage === 'settings') ? 'active' : '' ?>">
                <i class="bi bi-sliders"></i> Global Site Settings
            </a>
        </li>
        <li>
            <a href="<?= ADMIN_URL ?>/services.php" class="sidebar-link <?= ($currentAdminPage === 'services') ? 'active' : '' ?>">
                <i class="bi bi-gear-wide-connected"></i> Services Module
            </a>
        </li>
        <li>
            <a href="<?= ADMIN_URL ?>/products.php" class="sidebar-link <?= ($currentAdminPage === 'products') ? 'active' : '' ?>">
                <i class="bi bi-box-seam"></i> Products Module
            </a>
        </li>
        <li>
            <a href="<?= ADMIN_URL ?>/clients.php" class="sidebar-link <?= ($currentAdminPage === 'clients') ? 'active' : '' ?>">
                <i class="bi bi-buildings"></i> Clients Module
            </a>
        </li>
        <li>
            <a href="<?= ADMIN_URL ?>/testimonials.php" class="sidebar-link <?= ($currentAdminPage === 'testimonials') ? 'active' : '' ?>">
                <i class="bi bi-chat-square-quote"></i> Testimonials Module
            </a>
        </li>
        <li>
            <a href="<?= ADMIN_URL ?>/gallery.php" class="sidebar-link <?= ($currentAdminPage === 'gallery') ? 'active' : '' ?>">
                <i class="bi bi-images"></i> Gallery Module
            </a>
        </li>
        <li>
            <a href="<?= ADMIN_URL ?>/inquiries.php" class="sidebar-link <?= ($currentAdminPage === 'inquiries') ? 'active' : '' ?>">
                <i class="bi bi-envelope-paper"></i> Customer Inquiries
            </a>
        </li>
    </ul>

    <div class="p-3 border-top border-secondary border-opacity-25 mt-auto">
        <a href="<?= ADMIN_URL ?>/logout.php" class="btn btn-outline-danger w-100 btn-sm rounded-pill">
            <i class="bi bi-box-arrow-right me-1"></i> Log Out
        </a>
    </div>
</aside>
