<?php
/**
 * Girna Global - Products Catalog Page
 */

$pageTitle = "Export Products | Cavendish Bananas & Bio-Fertilizers";
$pageDesc = "Browse Girna Global's catalog of premium G9 Cavendish bananas, organic fertilizers, tissue culture plantlets, and dehydrated banana flour.";

require_once __DIR__ . '/includes/header.php';

$products = DB::fetchAll("SELECT * FROM products WHERE status = 'published' ORDER BY id DESC");
$categories = DB::fetchAll("SELECT DISTINCT category FROM products WHERE status = 'published'");
?>

<section class="bg-primary-dark text-white py-5">
    <div class="container py-4 text-center">
        <span class="badge-gold mb-2">Export Catalog</span>
        <h1 class="heading-serif display-4 text-white">Agricultural Products</h1>
        <p class="lead text-light max-w-700 mx-auto opacity-75">Premium Fresh Fruit, Bio-Fertilizers & Value-Added Agricultural Commodities.</p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        
        <!-- Category Filter Tabs -->
        <div class="d-flex justify-content-center gap-2 flex-wrap mb-5">
            <button class="btn btn-outline-dark rounded-pill px-4 active" data-filter="all">All Products</button>
            <?php foreach ($categories as $cat): ?>
                <button class="btn btn-outline-dark rounded-pill px-4" data-filter="<?= e($cat['category']) ?>"><?= e($cat['category']) ?></button>
            <?php endforeach; ?>
        </div>

        <!-- Products Grid -->
        <div class="product-grid">
            <?php foreach ($products as $prod): ?>
                <div class="product-card" data-category="<?= e($prod['category']) ?>">
                    <div class="product-img-wrap">
                        <span class="product-badge"><?= e($prod['category']) ?></span>
                        <img src="<?= get_image_url($prod['main_image'], 'product', $prod['title']) ?>" alt="<?= e($prod['title']) ?>" class="product-img">
                    </div>
                    <div class="product-body">
                        <h3 class="product-title"><?= e($prod['title']) ?></h3>
                        <p class="product-desc"><?= e(mb_strimwidth(strip_tags($prod['description']), 0, 110, "...")) ?></p>

                        <?php 
                        $specs = !empty($prod['specifications_json']) ? json_decode($prod['specifications_json'], true) : [];
                        if (!empty($specs)): 
                        ?>
                            <div class="mb-3 p-2 bg-light rounded small">
                                <ul class="list-unstyled mb-0">
                                    <?php $i=0; foreach ($specs as $sp): if ($i>=2) break; ?>
                                        <li class="d-flex justify-content-between py-1 border-bottom border-light-subtle">
                                            <span class="text-muted"><?= e($sp['key']) ?>:</span>
                                            <strong class="text-dark"><?= e($sp['value']) ?></strong>
                                        </li>
                                    <?php $i++; endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                            <span class="fw-bold text-success small"><i class="bi bi-tag-fill me-1"></i><?= e($prod['price_unit']) ?></span>
                            <a href="<?= SITE_URL ?>/product-detail.php?slug=<?= e($prod['slug']) ?>" class="btn btn-sm btn-dark rounded-pill px-3">
                                Full Specs <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
