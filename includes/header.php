<?php
/**
 * Girna Global - Header & Navigation Bar
 */

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/seo.php';

$settings = get_settings();
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Dynamic SEO Tags -->
    <?php render_seo_tags($pageTitle ?? '', $pageDesc ?? '', $pageImage ?? ''); ?>

    <!-- Favicon -->
    <?php $faviconUrl = get_image_url($settings['favicon'] ?? '', 'favicon', 'Favicon'); ?>
    <link rel="icon" type="image/png" href="<?= $faviconUrl ?>">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <!-- Custom Luxury Style -->
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container top-bar-flex">
            <div class="d-flex align-items-center gap-4">
                <span><i class="bi bi-geo-alt-fill text-gold me-2"></i>Jalgaon River Basin, Maharashtra, India</span>
                <span><i class="bi bi-envelope-fill text-gold me-2"></i><a href="mailto:<?= e($settings['email'] ?? 'contact@girnaglobal.com') ?>"><?= e($settings['email'] ?? 'contact@girnaglobal.com') ?></a></span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span><i class="bi bi-telephone-fill text-gold me-2"></i><a href="tel:<?= e($settings['phone'] ?? '+919876543210') ?>"><?= e($settings['phone'] ?? '+91 98765 43210') ?></a></span>
                <span class="text-gold">|</span>
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $settings['whatsapp'] ?? '919876543210') ?>" target="_blank" class="text-gold"><i class="bi bi-whatsapp me-1"></i> WhatsApp Export Desk</a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="site-header">
        <div class="container header-flex">
            
            <!-- Logo Container -->
            <a href="<?= SITE_URL ?>/index.php" class="logo-container">
                <?php if (!empty($settings['logo']) && file_exists(UPLOAD_DIR . $settings['logo'])): ?>
                    <img src="<?= UPLOAD_URL . e($settings['logo']) ?>" alt="<?= e($settings['site_name']) ?>" class="logo-img">
                <?php else: ?>
                    <svg width="42" height="42" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="100" height="100" rx="20" fill="#0b422e"/>
                        <path d="M50 18 C30 35 30 75 50 82 C70 75 70 35 50 18 Z" fill="#d4af37"/>
                        <path d="M50 30 L50 72" stroke="#062c1e" stroke-width="4"/>
                    </svg>
                <?php endif; ?>
                <div class="logo-text">
                    <span class="brand-name"><?= e($settings['site_name'] ?? 'Girna Global') ?></span>
                    <span class="brand-sub">AGRI EXPORTS & PRODUCE</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav>
                <ul class="nav-menu">
                    <li><a href="<?= SITE_URL ?>/index.php" class="nav-link <?= ($currentPage === 'index' || $currentPage === '') ? 'active' : '' ?>">Home</a></li>
                    <li><a href="<?= SITE_URL ?>/about.php" class="nav-link <?= ($currentPage === 'about') ? 'active' : '' ?>">About Us</a></li>
                    <li><a href="<?= SITE_URL ?>/services.php" class="nav-link <?= ($currentPage === 'services' || $currentPage === 'service-detail') ? 'active' : '' ?>">Services</a></li>
                    <li><a href="<?= SITE_URL ?>/products.php" class="nav-link <?= ($currentPage === 'products' || $currentPage === 'product-detail') ? 'active' : '' ?>">Products</a></li>
                    <li><a href="<?= SITE_URL ?>/gallery.php" class="nav-link <?= ($currentPage === 'gallery') ? 'active' : '' ?>">Gallery</a></li>
                    <li><a href="<?= SITE_URL ?>/testimonials.php" class="nav-link <?= ($currentPage === 'testimonials') ? 'active' : '' ?>">Testimonials</a></li>
                    <li><a href="<?= SITE_URL ?>/contact.php" class="nav-link <?= ($currentPage === 'contact') ? 'active' : '' ?>">Contact</a></li>
                </ul>
            </nav>

            <!-- Right CTA Button -->
            <div class="d-none d-lg-block">
                <a href="<?= SITE_URL ?>/contact.php" class="btn-primary-gold">
                    <i class="bi bi-box-seam me-1"></i> Get Export Quote
                </a>
            </div>

            <!-- Mobile Hamburger Toggle -->
            <button class="mobile-nav-toggle" aria-label="Toggle navigation">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </header>
