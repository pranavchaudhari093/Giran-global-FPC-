<?php
/**
 * Girna Global - Photo Gallery Page
 */

$pageTitle = "Farm & Pack-House Photo Gallery";
$pageDesc = "High-resolution photos showcasing Girna Global's banana plantations, harvesting, cold pack-houses, and reefer loading.";

require_once __DIR__ . '/includes/header.php';

$galleryItems = DB::fetchAll("SELECT * FROM gallery ORDER BY id DESC");
$categories = DB::fetchAll("SELECT DISTINCT category FROM gallery");
?>

<section class="bg-primary-dark text-white py-5">
    <div class="container py-4 text-center">
        <span class="badge-gold mb-2">Visual Showcase</span>
        <h1 class="heading-serif display-4 text-white">Farm & Facility Gallery</h1>
        <p class="lead text-light max-w-700 mx-auto opacity-75">Inside Our Managed Plantations, Automated Pack-Houses, and Cold-Chain Logistics.</p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        
        <!-- Category Filter Tabs -->
        <div class="d-flex justify-content-center gap-2 flex-wrap mb-5">
            <button class="btn btn-outline-dark rounded-pill px-4 active" data-filter="all">All Photos</button>
            <?php foreach ($categories as $cat): ?>
                <button class="btn btn-outline-dark rounded-pill px-4" data-filter="<?= e($cat['category']) ?>"><?= e($cat['category']) ?></button>
            <?php endforeach; ?>
        </div>

        <!-- Gallery Items Grid -->
        <div class="gallery-grid">
            <?php foreach ($galleryItems as $item): ?>
                <div class="gallery-item" data-category="<?= e($item['category']) ?>" data-bs-toggle="modal" data-bs-target="#imgModal<?= $item['id'] ?>">
                    <img src="<?= get_image_url($item['image_path'], 'gallery', $item['title']) ?>" alt="<?= e($item['title']) ?>">
                    <div class="gallery-overlay">
                        <span class="badge bg-warning text-dark me-auto mb-2"><?= e($item['category']) ?></span>
                        <h5 class="fw-bold text-white mb-1"><?= e($item['title']) ?></h5>
                        <p class="small text-light opacity-75 mb-0"><?= e($item['caption']) ?></p>
                    </div>
                </div>

                <!-- Lightbox Modal for Item -->
                <div class="modal fade" id="imgModal<?= $item['id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content bg-dark text-white border-warning">
                            <div class="modal-header border-bottom border-secondary">
                                <h5 class="modal-title text-gold"><?= e($item['title']) ?></h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0 text-center bg-black">
                                <img src="<?= get_image_url($item['image_path'], 'gallery', $item['title']) ?>" alt="<?= e($item['title']) ?>" class="img-fluid max-h-80vh">
                            </div>
                            <div class="modal-footer border-top border-secondary justify-content-between">
                                <span class="badge bg-secondary"><?= e($item['category']) ?></span>
                                <p class="small text-light mb-0"><?= e($item['caption']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
