<?php
/**
 * Girna Global - Clients Portfolio Page
 */

$pageTitle = "Global Importers & Clients";
$pageDesc = "Girna Global's international distribution partners and client network across Middle East, Europe, and Asia.";

require_once __DIR__ . '/includes/header.php';

$clients = DB::fetchAll("SELECT * FROM clients ORDER BY sort_order ASC, id DESC");
?>

<section class="bg-primary-dark text-white py-5">
    <div class="container py-4 text-center">
        <span class="badge-gold mb-2">Global Reach</span>
        <h1 class="heading-serif display-4 text-white">Our Clients & Trade Partners</h1>
        <p class="lead text-light max-w-700 mx-auto opacity-75">Delivering Quality Agricultural Produce to International Distributors & Supermarket Chains.</p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($clients as $client): ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-4 text-center d-flex flex-column align-items-center">
                        <div class="mb-3 p-3 bg-light rounded-circle" style="width:90px; height:90px; display:flex; align-items:center; justify-content:center;">
                            <i class="bi bi-buildings-fill fs-1 text-primary"></i>
                        </div>
                        <h3 class="h5 fw-bold text-primary mb-1"><?= e($client['name']) ?></h3>
                        <span class="badge bg-warning-subtle text-dark border border-warning px-3 py-1 rounded-pill mb-3">
                            <i class="bi bi-geo-alt-fill me-1 text-danger"></i><?= e($client['location']) ?>
                        </span>
                        <p class="small text-muted mb-4 flex-grow-1"><?= e($client['description']) ?></p>
                        
                        <?php if (!empty($client['website'])): ?>
                            <a href="<?= e($client['website']) ?>" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill">
                                Visit Partner Site <i class="bi bi-box-arrow-up-right ms-1"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
