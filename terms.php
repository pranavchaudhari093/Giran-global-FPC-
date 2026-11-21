<?php
/**
 * Girna Global - Terms & Conditions
 */

$pageTitle = "Terms & Conditions";
$pageDesc = "Terms and Conditions governing agricultural export quotes and website usage for Girna Global.";

require_once __DIR__ . '/includes/header.php';
?>

<section class="bg-primary-dark text-white py-5">
    <div class="container py-4 text-center">
        <h1 class="heading-serif text-white">Terms & Conditions</h1>
        <p class="small text-light opacity-75">Effective Date: <?= date('F j, Y') ?></p>
    </div>
</section>

<section class="section-padding">
    <div class="container max-w-900 bg-white p-5 rounded-4 shadow-sm border">
        <h3 class="fw-bold text-primary mb-3">1. Agreement to Terms</h3>
        <p class="text-muted">By accessing the Girna Global platform, you agree to comply with these terms, export guidelines, and all applicable international trade regulations.</p>

        <h3 class="fw-bold text-primary mt-4 mb-3">2. Quotations & Commodity Pricing</h3>
        <p class="text-muted">FOB and CIF quotes provided on the platform are subject to seasonal market fluctuations, reefer container freight rates, and currency conversion adjustments until confirmed via an executed Sales Contract.</p>

        <h3 class="fw-bold text-primary mt-4 mb-3">3. Product Specifications</h3>
        <p class="text-muted">All fresh banana shipments and bio-fertilizer products meet standard specifications detailed in proforma invoices. Official phytosanitary certificates and inspection reports are issued at loading port.</p>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
