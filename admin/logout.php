<?php
/**
 * Admin Panel - Logout Handler
 */

require_once __DIR__ . '/../includes/auth.php';

admin_logout();
set_flash('info', 'You have been logged out safely.');
header("Location: " . ADMIN_URL . "/login.php");
exit;
