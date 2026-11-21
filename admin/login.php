<?php
/**
 * Girna Global - Admin Login Screen
 */

require_once __DIR__ . '/../includes/auth.php';

if (is_admin_logged_in()) {
    header("Location: " . ADMIN_URL . "/index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        if (admin_login($username, $password)) {
            header("Location: " . ADMIN_URL . "/index.php");
            exit;
        } else {
            $error = 'Invalid username or password. Please try again.';
        }
    } else {
        $error = 'Please fill in both fields.';
    }
}

$settings = get_settings();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | <?= e($settings['site_name'] ?? 'Girna Global') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #041d14 0%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Outfit', sans-serif;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 24px;
            width: 100%;
            max-width: 440px;
            padding: 3rem 2.5rem;
            color: #ffffff;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="login-card">
        <div class="text-center mb-4">
            <svg width="56" height="56" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" class="mb-3">
                <rect width="100" height="100" rx="20" fill="#0b422e"/>
                <path d="M50 18 C30 35 30 75 50 82 C70 75 70 35 50 18 Z" fill="#d4af37"/>
            </svg>
            <h3 class="fw-bold text-white mb-1"><?= e($settings['site_name'] ?? 'Girna Global') ?></h3>
            <span class="badge bg-warning text-dark font-weight-bold px-3 py-1 rounded-pill">CMS Admin Portal</span>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger py-2 px-3 small rounded-3 mb-3"><?= e($error) ?></div>
        <?php endif; ?>

        <?php display_flash(); ?>

        <form action="<?= ADMIN_URL ?>/login.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">
            
            <div class="mb-3">
                <label class="form-label text-warning small fw-bold">Username or Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-gold"><i class="bi bi-person"></i></span>
                    <input type="text" name="username" class="form-control bg-dark text-white border-secondary" required placeholder="admin">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label text-warning small fw-bold">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-dark border-secondary text-gold"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control bg-dark text-white border-secondary" required placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="btn btn-warning w-100 py-3 fw-bold rounded-pill text-dark" style="background:#d4af37; border:none;">
                <i class="bi bi-shield-lock-fill me-1"></i> Log In to Dashboard
            </button>
        </form>

        <div class="text-center mt-4 pt-3 border-top border-secondary">
            <a href="<?= SITE_URL ?>/index.php" class="text-light opacity-75 small text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Back to Live Website</a>
        </div>
    </div>
</div>

</body>
</html>
