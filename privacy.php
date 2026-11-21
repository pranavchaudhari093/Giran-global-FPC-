<?php
/**
 * Girna Global - Privacy Policy
 */

$pageTitle = "Privacy Policy";
$pageDesc = "Privacy Policy for Girna Global website and customer inquiries.";

require_once __DIR__ . '/includes/header.php';
?>

<section class="bg-primary-dark text-white py-5">
    <div class="container py-4 text-center">
        <h1 class="heading-serif text-white">Privacy Policy</h1>
        <p class="small text-light opacity-75">Last updated: <?= date('F j, Y') ?></p>
    </div>
</section>

<section class="section-padding">
    <div class="container max-w-900 bg-white p-5 rounded-4 shadow-sm border">
        <h3 class="fw-bold text-primary mb-3">1. Information We Collect</h3>
        <p class="text-muted">When you submit an inquiry on Girna Global, we collect information including your name, email address, telephone number, destination port, and order specifications to process your export request.</p>

        <h3 class="fw-bold text-primary mt-4 mb-3">2. How We Use Information</h3>
        <p class="text-muted">Your information is strictly used to prepare proforma invoices, coordinate shipment logistics, and communicate regarding your agricultural commodity inquiries. We do not sell or rent your personal data to third parties.</p>

        <h3 class="fw-bold text-primary mt-4 mb-3">3. Data Protection & Security</h3>
        <p class="text-muted">We employ industry-standard encryption, SSL protection, and secure server procedures to protect your submitted data from unauthorized access or disclosure.</p>

        <h3 class="fw-bold text-primary mt-4 mb-3">4. Contact Us</h3>
        <p class="text-muted">If you have any questions regarding this Privacy Policy, please email us at <a href="mailto:<?= e($settings['email'] ?? 'contact@girnaglobal.com') ?>" class="text-primary fw-bold"><?= e($settings['email'] ?? 'contact@girnaglobal.com') ?></a>.</p>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
