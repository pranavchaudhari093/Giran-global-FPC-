<?php
/**
 * Girna Global - Dynamic XML Sitemap Generator
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/db.php';

header("Content-Type: application/xml; charset=utf-8");

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemap.org/schemas/sitemap/0.9">
    <url>
        <loc><?= SITE_URL ?>/index.php</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc><?= SITE_URL ?>/about.php</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?= SITE_URL ?>/services.php</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?= SITE_URL ?>/products.php</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc><?= SITE_URL ?>/clients.php</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc><?= SITE_URL ?>/gallery.php</loc>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc><?= SITE_URL ?>/testimonials.php</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    <url>
        <loc><?= SITE_URL ?>/contact.php</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>

    <?php 
    $products = DB::fetchAll("SELECT slug FROM products WHERE status = 'published'");
    foreach ($products as $p):
    ?>
    <url>
        <loc><?= SITE_URL ?>/product-detail.php?slug=<?= $p['slug'] ?></loc>
        <changefreq>weekly</changefreq>
        <priority>0.85</priority>
    </url>
    <?php endforeach; ?>

    <?php 
    $services = DB::fetchAll("SELECT slug FROM services WHERE status = 'published'");
    foreach ($services as $s):
    ?>
    <url>
        <loc><?= SITE_URL ?>/service-detail.php?slug=<?= $s['slug'] ?></loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <?php endforeach; ?>
</urlset>
