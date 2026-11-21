<?php
/**
 * Girna Global - Services Listing Page
 */

$pageTitle = "Our Services | Contract Farming & Cold-Chain Export";
$pageDesc = "Explore Girna Global's comprehensive agricultural services including contract banana farming, pack-house processing, bio-fertilizer supply, and drone surveying.";

require_once __DIR__ . '/includes/header.php';

$allServices = DB::fetchAll("SELECT * FROM services WHERE status = 'published' ORDER BY sort_order ASC");
?>

<section class="bg-primary-dark text-white py-5">
    <div class="container py-4 text-center">
        <span class="badge-gold mb-2">Capabilities</span>
        <h1 class="heading-serif display-4 text-white">Agricultural Services</h1>
        <p class="lead text-light max-w-700 mx-auto opacity-75">End-to-end Solutions for Modern Contract Farming, Processing & Global Export Logistics.</p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($allServices as $srv): ?>
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-md rounded-4 overflow-hidden d-flex flex-column">
                        <div class="bg-primary-dark p-4 text-white d-flex align-items-center justify-content-between">
                            <h3 class="h4 fw-bold text-white mb-0"><?= e($srv['title']) ?></h3>
                            <div class="fs-2 text-gold"><i class="bi bi-box-seam"></i></div>
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1 bg-white">
                            <p class="text-muted leading-relaxed mb-4 flex-grow-1"><?= e($srv['short_description']) ?></p>
                            
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold">
                                    <i class="bi bi-check-circle me-1"></i> Available Now
                                </span>
                                <a href="<?= SITE_URL ?>/service-detail.php?slug=<?= e($srv['slug']) ?>" class="btn btn-outline-dark rounded-pill px-4">
                                    Full Details <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
