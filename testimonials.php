<?php
/**
 * Girna Global - Testimonials Page
 */

$pageTitle = "Client & Farmer Testimonials";
$pageDesc = "Read reviews and feedback from Girna Global's contracted banana farmers and international buyers.";

require_once __DIR__ . '/includes/header.php';

$testimonials = DB::fetchAll("SELECT * FROM testimonials ORDER BY id DESC");
?>

<section class="bg-primary-dark text-white py-5">
    <div class="container py-4 text-center">
        <span class="badge-gold mb-2">Testimonials</span>
        <h1 class="heading-serif display-4 text-white">Farmer & Importer Reviews</h1>
        <p class="lead text-light max-w-700 mx-auto opacity-75">Hear Directly From the Growers We Empower & Importers We Serve Worldwide.</p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($testimonials as $t): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="testimonial-card h-100 d-flex flex-column">
                        <div class="star-rating mb-3">
                            <?php for ($i=0; $i<$t['rating']; $i++): ?><i class="bi bi-star-fill text-warning"></i><?php endfor; ?>
                        </div>
                        <p class="text-muted fst-italic mb-4 flex-grow-1">"<?= e($t['review']) ?>"</p>
                        
                        <div class="d-flex align-items-center gap-3 pt-3 border-top mt-auto">
                            <img src="<?= get_image_url($t['photo'], 'testimonial', $t['name']) ?>" alt="<?= e($t['name']) ?>" class="rounded-circle" width="55" height="55" style="object-fit:cover;">
                            <div>
                                <h5 class="fw-bold mb-0 text-primary h6"><?= e($t['name']) ?></h5>
                                <small class="text-muted"><i class="bi bi-geo-alt me-1 text-gold"></i><?= e($t['village']) ?></small>
                            </div>
                        </div>

                        <?php if (!empty($t['video_url'])): ?>
                            <div class="mt-3">
                                <a href="<?= e($t['video_url']) ?>" target="_blank" class="btn btn-sm btn-outline-danger w-100 rounded-pill">
                                    <i class="bi bi-youtube me-1"></i> Watch Video Testimonial
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
