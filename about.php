<?php
/**
 * Girna Global - About Us Page
 */

$pageTitle = "About Us | Corporate Story & Agri Vision";
$pageDesc = "Learn about Girna Global's journey in sustainable banana farming, cold-chain export, and agronomic excellence in the Girna Valley.";

require_once __DIR__ . '/includes/header.php';
?>

<!-- Header Banner -->
<section class="bg-primary-dark text-white py-5 position-relative">
    <div class="container py-4 text-center">
        <span class="badge-gold mb-2">Corporate Identity</span>
        <h1 class="heading-serif display-4 text-white">About Girna Global</h1>
        <p class="lead text-light max-w-700 mx-auto opacity-75">Transforming traditional river-basin farming into a modern, export-oriented agri enterprise.</p>
    </div>
</section>

<!-- Main Corporate Story -->
<section class="section-padding">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="badge-gold mb-2">Our Heritage</span>
                <h2 class="section-title">Rooted in Fertile Soils, Connected to Global Markets</h2>
                <p class="text-muted leading-relaxed mb-3">
                    Girna Global was established with a singular objective: to bring the extraordinary agricultural potential of the Girna River Valley to international markets. The valley’s rich alluvial soil, combined with ideal tropical humidity and water availability, produces bananas of exceptional calibration, sweetness, and shelf-life.
                </p>
                <p class="text-muted leading-relaxed mb-4">
                    Over the past decade, we have scaled our operations from a local farming cluster into a comprehensive agri-export corporation managing over 500+ contract farms, modern pack-houses, and bio-fertilizer production facilities.
                </p>

                <div class="row g-4">
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3 border-start border-3 border-success">
                            <h4 class="fw-bold text-primary mb-1">500+</h4>
                            <small class="text-muted">Contracted Farm Clusters</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3 border-start border-3 border-warning">
                            <h4 class="fw-bold text-primary mb-1">45 Days</h4>
                            <small class="text-muted">Guaranteed Reefer Shelf Life</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <?php $aboutImgUrl = get_image_url($settings['about_image'] ?? '', 'about', 'Girna Global Agro Overview'); ?>
                <img src="<?= $aboutImgUrl ?>" alt="Girna Global Enterprise" class="rounded-4 shadow-lg w-100" style="min-height:400px; object-fit:cover;">
            </div>
        </div>
    </div>
</section>

<!-- Vision, Mission, Values -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
                    <div class="fs-1 text-gold mb-3"><i class="bi bi-eye-fill"></i></div>
                    <h4 class="fw-bold text-primary mb-3">Our Vision</h4>
                    <p class="text-muted small">To be recognized globally as the most trusted exporter of premium tropical fruit and sustainable agricultural solutions from South Asia.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
                    <div class="fs-1 text-gold mb-3"><i class="bi bi-bullseye"></i></div>
                    <h4 class="fw-bold text-primary mb-3">Our Mission</h4>
                    <p class="text-muted small">To empower contract farmers with precision agronomy and bio-fertilizers while delivering flawless, 100% compliant reefer produce to international buyers.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4 rounded-4">
                    <div class="fs-1 text-gold mb-3"><i class="bi bi-shield-check"></i></div>
                    <h4 class="fw-bold text-primary mb-3">Core Values</h4>
                    <p class="text-muted small">Quality Uncompromised • Farmer Prosperity • Environmental Sustainability • Transparency & International Standard Compliance.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quality & Compliance Banner -->
<section class="section-padding">
    <div class="container">
        <div class="section-title-wrap">
            <span class="badge-gold mb-2">Standards & Certifications</span>
            <h2 class="section-title">Export Compliance & Quality Standards</h2>
            <p class="section-subtitle">Our facilities adhere strictly to APEDA, Phytosanitary, and Global GAP norms.</p>
        </div>

        <div class="row g-4 text-center">
            <div class="col-6 col-md-3">
                <div class="p-4 rounded-4 border bg-white shadow-sm">
                    <i class="bi bi-award fs-1 text-success mb-2"></i>
                    <h6 class="fw-bold mb-1">Global GAP</h6>
                    <small class="text-muted">Good Agricultural Practices</small>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-4 rounded-4 border bg-white shadow-sm">
                    <i class="bi bi-shield-lock fs-1 text-warning mb-2"></i>
                    <h6 class="fw-bold mb-1">APEDA Certified</h6>
                    <small class="text-muted">Agri Export Authority India</small>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-4 rounded-4 border bg-white shadow-sm">
                    <i class="bi bi-check-all fs-1 text-primary mb-2"></i>
                    <h6 class="fw-bold mb-1">Phytosanitary</h6>
                    <small class="text-muted">Pest & Disease Free Guarantee</small>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="p-4 rounded-4 border bg-white shadow-sm">
                    <i class="bi bi-flower1 fs-1 text-success mb-2"></i>
                    <h6 class="fw-bold mb-1">NPOP Organic</h6>
                    <small class="text-muted">Certified Organic Fertilizers</small>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
