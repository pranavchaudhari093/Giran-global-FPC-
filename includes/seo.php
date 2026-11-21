<?php
/**
 * Girna Global - Dynamic SEO & Schema.org Generator
 */

require_once __DIR__ . '/functions.php';

function render_seo_tags($customTitle = '', $customDesc = '', $customImage = '', $canonicalUrl = '') {
    $settings = get_settings();
    
    $siteName = $settings['site_name'] ?? 'Girna Global';
    $defaultTitle = $settings['meta_title'] ?? 'Girna Global | Premium Banana Exporter & Agricultural Trading';
    $defaultDesc = $settings['meta_description'] ?? 'Girna Global is a leading exporter of premium Cavendish bananas, bio-fertilizers, and cold-chain agricultural produce.';
    
    $title = !empty($customTitle) ? e($customTitle) . ' | ' . e($siteName) : e($defaultTitle);
    $description = !empty($customDesc) ? e($customDesc) : e($defaultDesc);
    
    $currentUrl = !empty($canonicalUrl) ? $canonicalUrl : SITE_URL . e($_SERVER['REQUEST_URI'] ?? '');
    
    $ogImage = !empty($customImage) ? get_image_url($customImage) : get_image_url($settings['logo'] ?? '', 'logo', $siteName);
    ?>
    <!-- SEO Standard Meta Tags -->
    <title><?= $title ?></title>
    <meta name="description" content="<?= $description ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= $currentUrl ?>">

    <!-- Open Graph / Facebook Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $currentUrl ?>">
    <meta property="og:title" content="<?= $title ?>">
    <meta property="og:description" content="<?= $description ?>">
    <meta property="og:image" content="<?= $ogImage ?>">
    <meta property="og:site_name" content="<?= e($siteName) ?>">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $title ?>">
    <meta name="twitter:description" content="<?= $description ?>">
    <meta name="twitter:image" content="<?= $ogImage ?>">

    <!-- Schema.org JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "<?= e($siteName) ?>",
      "url": "<?= SITE_URL ?>",
      "logo": "<?= $ogImage ?>",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "<?= e($settings['phone'] ?? '') ?>",
        "contactType": "customer service",
        "email": "<?= e($settings['email'] ?? '') ?>"
      },
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "<?= e($settings['address'] ?? '') ?>",
        "addressCountry": "IN"
      },
      "sameAs": [
        "<?= e($settings['facebook_url'] ?? '#') ?>",
        "<?= e($settings['linkedin_url'] ?? '#') ?>",
        "<?= e($settings['instagram_url'] ?? '#') ?>",
        "<?= e($settings['twitter_url'] ?? '#') ?>"
      ]
    }
    </script>
    <?php
}
