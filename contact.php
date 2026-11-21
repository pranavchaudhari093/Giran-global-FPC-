<?php
/**
 * Girna Global - Contact Page & Inquiry Handler
 */

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/mailer.php';

// Handle Direct POST Form Submission if JavaScript is disabled
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!empty($name) && !empty($email) && !empty($message)) {
        send_contact_email($name, $email, $phone, $subject, $message);
        set_flash('success', 'Thank you! Your message has been sent successfully. Our team will contact you shortly.');
    } else {
        set_flash('danger', 'Please complete all required fields.');
    }
    
    header('Location: ' . SITE_URL . '/contact.php');
    exit;
}

$pageTitle = "Contact Us | Export Desk & Enquiries";
$pageDesc = "Get in touch with Girna Global for banana export quotes, bio-fertilizer supply, or contract farming partnerships.";

require_once __DIR__ . '/includes/header.php';
?>

<section class="bg-primary-dark text-white py-5">
    <div class="container py-4 text-center">
        <span class="badge-gold mb-2">Get In Touch</span>
        <h1 class="heading-serif display-4 text-white">Contact Export Desk</h1>
        <p class="lead text-light max-w-700 mx-auto opacity-75">Connect With Our Global Trade Specialists & Agronomy Advisory Team.</p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        
        <?php display_flash(); ?>

        <div class="row g-5">
            
            <!-- Contact Information Cards -->
            <div class="col-lg-5">
                <h3 class="fw-bold text-primary mb-4">Corporate Office & Hub</h3>
                
                <div class="card border-0 shadow-sm p-4 rounded-4 mb-3 d-flex flex-row align-items-center gap-3">
                    <div class="fs-2 text-gold"><i class="bi bi-geo-alt-fill"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Physical Address</h6>
                        <small class="text-muted"><?= e($settings['address'] ?? 'Jalgaon, Maharashtra, India') ?></small>
                    </div>
                </div>

                <div class="card border-0 shadow-sm p-4 rounded-4 mb-3 d-flex flex-row align-items-center gap-3">
                    <div class="fs-2 text-gold"><i class="bi bi-telephone-fill"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Phone Number</h6>
                        <a href="tel:<?= e($settings['phone'] ?? '') ?>" class="text-primary font-weight-bold"><?= e($settings['phone'] ?? '+91 98765 43210') ?></a>
                    </div>
                </div>

                <div class="card border-0 shadow-sm p-4 rounded-4 mb-3 d-flex flex-row align-items-center gap-3">
                    <div class="fs-2 text-gold"><i class="bi bi-envelope-fill"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Official Email</h6>
                        <a href="mailto:<?= e($settings['email'] ?? '') ?>" class="text-primary font-weight-bold"><?= e($settings['email'] ?? 'contact@girnaglobal.com') ?></a>
                    </div>
                </div>

                <div class="card border-0 shadow-sm p-4 rounded-4 mb-4 d-flex flex-row align-items-center gap-3 bg-success-subtle border-success">
                    <div class="fs-2 text-success"><i class="bi bi-whatsapp"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1 text-success">Instant WhatsApp Desk</h6>
                        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $settings['whatsapp'] ?? '919876543210') ?>" target="_blank" class="fw-bold text-success">
                            Chat live on WhatsApp <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-lg p-4 p-md-5 rounded-4 bg-white">
                    <h3 class="fw-bold text-primary mb-2">Send an Export Inquiry</h3>
                    <p class="text-muted small mb-4">Fill out the details below and our trade officer will respond with specifications and pricing.</p>
                    
                    <form action="<?= SITE_URL ?>/contact.php" method="POST" id="ajaxContactForm">
                        <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary">Your Name *</label>
                                <input type="text" name="name" class="form-control form-control-lg bg-light border-0" required placeholder="John Smith">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary">Email Address *</label>
                                <input type="email" name="email" class="form-control form-control-lg bg-light border-0" required placeholder="john@example.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary">Phone / WhatsApp</label>
                                <input type="text" name="phone" class="form-control form-control-lg bg-light border-0" placeholder="+91 98765 43210">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary">Inquiry Subject</label>
                                <input type="text" name="subject" class="form-control form-control-lg bg-light border-0" placeholder="Banana Export Quote / Fertilizer Supply">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold text-secondary">Message Details *</label>
                                <textarea name="message" class="form-control form-control-lg bg-light border-0" rows="5" required placeholder="Describe your product requirements, container quantity, and destination port..."></textarea>
                            </div>
                        </div>

                        <div id="formFeedback" class="mt-3"></div>

                        <div class="mt-4">
                            <button type="submit" class="btn-primary-gold w-100 py-3 fs-5">
                                <i class="bi bi-send-fill me-2"></i> Submit Inquiry Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Google Maps Embed Container -->
        <?php if (!empty($settings['google_maps'])): ?>
            <div class="mt-5 rounded-4 overflow-hidden shadow-md border">
                <?= $settings['google_maps'] ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
