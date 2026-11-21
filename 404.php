<?php
/**
 * Girna Global - 404 Error Page
 */

http_response_code(404);
$pageTitle = "Page Not Found (404)";

require_once __DIR__ . '/includes/header.php';
?>

<section class="section-padding my-5 text-center">
    <div class="container py-5">
        <div class="display-1 text-gold font-weight-bold mb-3 heading-serif">404</div>
        <h2 class="fw-bold text-primary mb-3">Page Not Found</h2>
        <p class="text-muted lead max-w-600 mx-auto mb-4">The page or product specification you are searching for might have been moved, renamed, or is currently unavailable.</p>
        
        <div class="d-flex justify-content-center gap-3">
            <a href="<?= SITE_URL ?>/index.php" class="btn-primary-gold"><i class="bi bi-house-door-fill me-1"></i> Return Home</a>
            <a href="<?= SITE_URL ?>/products.php" class="btn-outline-white text-dark border-dark"><i class="bi bi-box-seam me-1"></i> View Catalog</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
