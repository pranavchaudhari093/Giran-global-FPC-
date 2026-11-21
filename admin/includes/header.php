<?php
/**
 * Admin Panel - Header Component
 */

require_once __DIR__ . '/../../includes/auth.php';
require_admin();

$settings = get_settings();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($adminTitle ?? 'Dashboard') ?> | <?= e($settings['site_name'] ?? 'Girna Global') ?> CMS</title>
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    
    <!-- Admin Styling -->
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/admin.css">
</head>
<body class="admin-body">

<div class="d-flex">
    <!-- Sidebar Included -->
    <?php require_once __DIR__ . '/sidebar.php'; ?>

    <!-- Main Content Right Area -->
    <div class="admin-main flex-grow-1">
        <!-- Topbar Header -->
        <div class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-secondary d-lg-none" id="sidebarToggleBtn">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <h4 class="mb-0 fw-bold text-dark"><?= e($adminTitle ?? 'Dashboard Overview') ?></h4>
            </div>

            <div class="d-flex align-items-center gap-3">
                <a href="<?= SITE_URL ?>/index.php" target="_blank" class="btn btn-sm btn-outline-success rounded-pill">
                    <i class="bi bi-globe me-1"></i> View Live Site
                </a>
                <div class="dropdown">
                    <button class="btn btn-dark rounded-circle p-2 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-fill text-gold fs-5"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li class="dropdown-header">Logged in as <strong><?= e($_SESSION['admin_username'] ?? 'Admin') ?></strong></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?= ADMIN_URL ?>/settings.php"><i class="bi bi-gear me-2"></i> Site Settings</a></li>
                        <li><a class="dropdown-item text-danger" href="<?= ADMIN_URL ?>/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Log Out</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="admin-content">
            <?php display_flash(); ?>
