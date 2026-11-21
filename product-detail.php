<?php
/**
 * Girna Global - Product Detail Page
 */

require_once __DIR__ . '/includes/functions.php';

$slug = $_GET['slug'] ?? '';
$product = DB::fetch("SELECT * FROM products WHERE slug = ? AND status = 'published'", [$slug]);

if (!$product) {
    header("Location: " . SITE_URL . "/products.php");
    exit;
}

$pageTitle = $product['title'];
$pageDesc = mb_strimwidth(strip_tags($product['description']), 0, 150, "...");

require_once __DIR__ . '/includes/header.php';

$specs = !empty($product['specifications_json']) ? json_decode($product['specifications_json'], true) : [];
?>

<section class="bg-primary-dark text-white py-5">
    <div class="container py-4">
        <a href="<?= SITE_URL ?>/products.php" class="text-gold small fw-bold mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Back to Product Catalog</a>
        <div class="d-flex align-items-center gap-3 flex-wrap">
            <h1 class="heading-serif display-4 text-white mb-0"><?= e($product['title']) ?></h1>
            <span class="badge bg-warning text-dark font-weight-bold px-3 py-2 rounded-pill"><?= e($product['category']) ?></span>
        </div>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row g-5">
            
            <!-- Left Col: Product Image & Specs -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5">
                    <img src="<?= get_image_url($product['main_image'], 'product', $product['title']) ?>" alt="<?= e($product['title']) ?>" class="w-100" style="max-height:480px; object-fit:cover;">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="fw-bold text-primary mb-3">Product Description</h3>
                        <p class="text-muted leading-relaxed mb-4 fs-5" style="white-space: pre-line;">
                            <?= e($product['description']) ?>
                        </p>

                        <?php if (!empty($specs)): ?>
                            <h4 class="fw-bold text-primary mt-5 mb-3"><i class="bi bi-sliders me-2 text-gold"></i> Technical Specifications</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover border align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Specification Parameter</th>
                                            <th>Export Grade Standard</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($specs as $sp): ?>
                                            <tr>
                                                <td class="fw-semibold text-secondary"><?= e($sp['key']) ?></td>
                                                <td class="fw-bold text-primary"><?= e($sp['value']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                        <!-- Cold Chain & Packaging Note -->
                        <div class="p-4 bg-light rounded-4 border border-warning mt-4">
                            <h5 class="fw-bold text-primary mb-2"><i class="bi bi-box-seam text-gold me-2"></i> Export Packaging & Quality Guarantee</h5>
                            <p class="small text-muted mb-0">
                                All fresh shipments undergo anti-fungal alum treatment, ethylene absorber poly-bagging, and pre-cooling to 13.5°C before sealing into 40ft High Cube Reefer Containers.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Col: Instant Quote Request Form -->
            <div class="col-lg-5">
                <div class="sticky-top" style="top: 100px;">
                    <div class="card border-0 shadow-lg p-4 rounded-4 bg-primary-dark text-white">
                        <span class="badge-gold mb-2 w-auto me-auto"><i class="bi bi-lightning-charge-fill me-1"></i> Direct Quote Request</span>
                        <h3 class="fw-bold text-white mb-2">Request FOB / CIF Pricing</h3>
                        <p class="small text-light opacity-75 mb-4">Pricing for <strong><?= e($product['title']) ?></strong> varies based on destination port and container volume.</p>
                        
                        <form action="<?= SITE_URL ?>/contact.php" method="POST" id="ajaxContactForm">
                            <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">
                            <input type="hidden" name="subject" value="Price Inquiry for Product: <?= e($product['title']) ?>">
                            
                            <div class="mb-3">
                                <label class="form-label small text-gold fw-bold">Company / Buyer Name</label>
                                <input type="text" name="name" class="form-control rounded-3" required placeholder="Fruit Trading LLC">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-gold fw-bold">Business Email</label>
                                <input type="email" name="email" class="form-control rounded-3" required placeholder="import@buyer.com">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-gold fw-bold">Destination Port / Country</label>
                                <input type="text" name="phone" class="form-control rounded-3" placeholder="Jebel Ali, Dubai / Hamburg, Germany">
                            </div>
                            <div class="mb-4">
                                <label class="form-label small text-gold fw-bold">Estimated Order Volume & Schedule</label>
                                <textarea name="message" class="form-control rounded-3" rows="3" required placeholder="e.g. Require 2 x 40ft Reefer containers weekly starting next month..."></textarea>
                            </div>
                            
                            <div id="formFeedback" class="mb-3"></div>
                            
                            <button type="submit" class="btn-primary-gold w-100 py-3">
                                <i class="bi bi-send-fill me-1"></i> Request Official Proforma Quote
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
