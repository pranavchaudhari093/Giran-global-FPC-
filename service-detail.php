<?php
/**
 * Girna Global - Service Detail Page
 */

require_once __DIR__ . '/includes/functions.php';

$slug = $_GET['slug'] ?? '';
$service = DB::fetch("SELECT * FROM services WHERE slug = ? AND status = 'published'", [$slug]);

if (!$service) {
    header("Location: " . SITE_URL . "/services.php");
    exit;
}

$pageTitle = $service['title'];
$pageDesc = $service['short_description'];

require_once __DIR__ . '/includes/header.php';

$faqs = !empty($service['faqs_json']) ? json_decode($service['faqs_json'], true) : [];
?>

<section class="bg-primary-dark text-white py-5">
    <div class="container py-4">
        <a href="<?= SITE_URL ?>/services.php" class="text-gold small fw-bold mb-2 d-inline-block"><i class="bi bi-arrow-left me-1"></i> Back to All Services</a>
        <h1 class="heading-serif display-4 text-white"><?= e($service['title']) ?></h1>
        <p class="lead text-light max-w-700 opacity-75"><?= e($service['short_description']) ?></p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border mb-5">
                    <h3 class="fw-bold text-primary mb-3">Service Overview</h3>
                    <div class="text-muted leading-relaxed mb-4 fs-5" style="white-space: pre-line;">
                        <?= e($service['full_description']) ?>
                    </div>

                    <?php if (!empty($faqs)): ?>
                        <h4 class="fw-bold text-primary mt-5 mb-3">Frequently Asked Questions</h4>
                        <div class="accordion" id="faqAccordion">
                            <?php foreach ($faqs as $idx => $faq): ?>
                                <div class="accordion-item border-0 mb-3 shadow-sm rounded-3 overflow-hidden">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button <?= $idx !== 0 ? 'collapsed' : '' ?> fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?= $idx ?>">
                                            <i class="bi bi-question-circle text-gold me-2"></i> <?= e($faq['question']) ?>
                                        </button>
                                    </h2>
                                    <div id="faq<?= $idx ?>" class="accordion-collapse collapse <?= $idx === 0 ? 'show' : '' ?>" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body text-muted">
                                            <?= e($faq['answer']) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sticky-top" style="top: 100px;">
                    <div class="card border-0 shadow-lg p-4 rounded-4 bg-primary-dark text-white">
                        <h4 class="fw-bold text-gold mb-3">Inquire About This Service</h4>
                        <p class="small text-light opacity-75 mb-4">Our agronomy and technical export team is ready to discuss custom solutions for your requirements.</p>
                        
                        <form action="<?= SITE_URL ?>/contact.php" method="POST" id="ajaxContactForm">
                            <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">
                            <input type="hidden" name="subject" value="Inquiry for Service: <?= e($service['title']) ?>">
                            
                            <div class="mb-3">
                                <label class="form-label small text-gold fw-bold">Full Name</label>
                                <input type="text" name="name" class="form-control rounded-3" required placeholder="John Smith">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-gold fw-bold">Email Address</label>
                                <input type="email" name="email" class="form-control rounded-3" required placeholder="john@example.com">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-gold fw-bold">Phone / WhatsApp</label>
                                <input type="text" name="phone" class="form-control rounded-3" placeholder="+91 ...">
                            </div>
                            <div class="mb-4">
                                <label class="form-label small text-gold fw-bold">Message Details</label>
                                <textarea name="message" class="form-control rounded-3" rows="3" required placeholder="Describe your farm cluster or volume requirement..."></textarea>
                            </div>
                            
                            <div id="formFeedback" class="mb-3"></div>
                            
                            <button type="submit" class="btn-primary-gold w-100 py-3">
                                <i class="bi bi-send-fill me-1"></i> Submit Service Inquiry
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
