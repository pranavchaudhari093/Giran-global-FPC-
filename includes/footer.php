<?php
/**
 * Girna Global - Footer Component
 */

$settings = get_settings();
?>

    <!-- Floating WhatsApp Widget -->
    <?php if (!empty($settings['whatsapp'])): ?>
        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $settings['whatsapp']) ?>?text=Hello%20Girna%20Global%20Team,%20I%20would%20like%20to%20inquire%20about%20banana%20exports." 
           target="_blank" 
           class="floating-whatsapp-btn" 
           title="Chat on WhatsApp"
           style="position: fixed; bottom: 30px; right: 30px; z-index: 999; background: #25d366; color: #fff; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; box-shadow: 0 10px 25px rgba(37,211,102,0.4); transition: transform 0.3s ease;">
            <i class="bi bi-whatsapp"></i>
        </a>
    <?php endif; ?>

    <!-- Site Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-grid">
                
                <!-- Col 1: Brand Info -->
                <div>
                    <div class="logo-container mb-3">
                        <?php if (!empty($settings['logo']) && file_exists(UPLOAD_DIR . $settings['logo'])): ?>
                            <img src="<?= UPLOAD_URL . e($settings['logo']) ?>" alt="<?= e($settings['site_name']) ?>" class="logo-img">
                        <?php else: ?>
                            <svg width="36" height="36" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="100" height="100" rx="20" fill="#0b422e"/>
                                <path d="M50 18 C30 35 30 75 50 82 C70 75 70 35 50 18 Z" fill="#d4af37"/>
                            </svg>
                        <?php endif; ?>
                        <span class="brand-name text-white"><?= e($settings['site_name'] ?? 'Girna Global') ?></span>
                    </div>
                    <p class="text-muted small mb-4">
                        <?= e($settings['footer_about'] ?? 'Girna Global delivers world-class agricultural products from our rich river basin farms directly to global markets with guaranteed quality and freshness.') ?>
                    </p>
                    <div class="d-flex gap-3">
                        <a href="<?= e($settings['facebook_url'] ?? '#') ?>" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="bi bi-facebook"></i></a>
                        <a href="<?= e($settings['linkedin_url'] ?? '#') ?>" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="bi bi-linkedin"></i></a>
                        <a href="<?= e($settings['instagram_url'] ?? '#') ?>" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="bi bi-instagram"></i></a>
                        <a href="<?= e($settings['twitter_url'] ?? '#') ?>" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h5 class="footer-title">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="<?= SITE_URL ?>/index.php"><i class="bi bi-chevron-right me-1 text-gold"></i> Home</a></li>
                        <li><a href="<?= SITE_URL ?>/about.php"><i class="bi bi-chevron-right me-1 text-gold"></i> About Company</a></li>
                        <li><a href="<?= SITE_URL ?>/services.php"><i class="bi bi-chevron-right me-1 text-gold"></i> Agri Services</a></li>
                        <li><a href="<?= SITE_URL ?>/products.php"><i class="bi bi-chevron-right me-1 text-gold"></i> Export Products</a></li>
                        <li><a href="<?= SITE_URL ?>/gallery.php"><i class="bi bi-chevron-right me-1 text-gold"></i> Farm Gallery</a></li>
                        <li><a href="<?= SITE_URL ?>/testimonials.php"><i class="bi bi-chevron-right me-1 text-gold"></i> Testimonials</a></li>
                    </ul>
                </div>

                <!-- Col 3: Export Products -->
                <div>
                    <h5 class="footer-title">Agri Exports</h5>
                    <ul class="footer-links">
                        <li><a href="<?= SITE_URL ?>/products.php"><i class="bi bi-chevron-right me-1 text-gold"></i> G9 Cavendish Bananas</a></li>
                        <li><a href="<?= SITE_URL ?>/products.php"><i class="bi bi-chevron-right me-1 text-gold"></i> Bio-Gro Fertilizers</a></li>
                        <li><a href="<?= SITE_URL ?>/products.php"><i class="bi bi-chevron-right me-1 text-gold"></i> Tissue Culture Plantlets</a></li>
                        <li><a href="<?= SITE_URL ?>/products.php"><i class="bi bi-chevron-right me-1 text-gold"></i> Dehydrated Banana Powder</a></li>
                    </ul>
                </div>

                <!-- Col 4: Corporate Contact -->
                <div>
                    <h5 class="footer-title">Global Headquarters</h5>
                    <p class="small text-muted mb-2">
                        <i class="bi bi-geo-alt-fill text-gold me-2"></i><?= e($settings['address'] ?? 'Jalgaon, Maharashtra, India') ?>
                    </p>
                    <p class="small text-muted mb-2">
                        <i class="bi bi-telephone-fill text-gold me-2"></i><?= e($settings['phone'] ?? '+91 98765 43210') ?>
                    </p>
                    <p class="small text-muted mb-3">
                        <i class="bi bi-envelope-fill text-gold me-2"></i><?= e($settings['email'] ?? 'contact@girnaglobal.com') ?>
                    </p>
                    <a href="<?= SITE_URL ?>/admin/login.php" class="btn btn-sm btn-outline-warning rounded-pill">
                        <i class="bi bi-shield-lock me-1"></i> Admin Portal
                    </a>
                </div>

            </div>

            <!-- Copyright Bar -->
            <div class="copyright-bar">
                <div>
                    &copy; <?= date('Y') ?> <strong><?= e($settings['site_name'] ?? 'Girna Global') ?></strong>. All Rights Reserved. Designed for Excellence.
                </div>
                <div class="d-flex gap-3">
                    <a href="<?= SITE_URL ?>/privacy.php" class="text-muted">Privacy Policy</a>
                    <span>|</span>
                    <a href="<?= SITE_URL ?>/terms.php" class="text-muted">Terms of Service</a>
                    <span>|</span>
                    <a href="<?= SITE_URL ?>/sitemap.php" class="text-muted">XML Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Client Script -->
    <script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>
