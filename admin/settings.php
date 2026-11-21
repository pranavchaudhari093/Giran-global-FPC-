<?php
/**
 * Admin Panel - Global Site Settings Manager
 */

$adminTitle = "Global Site Settings";

require_once __DIR__ . '/includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $settings = get_settings();

    // Handle Logo & Favicon Uploads
    $logoPath = upload_image('logo', 'site', $settings['logo'] ?? '');
    $faviconPath = upload_image('favicon', 'site', $settings['favicon'] ?? '');
    $heroImgPath = upload_image('hero_image', 'site', $settings['hero_image'] ?? '');
    $aboutImgPath = upload_image('about_image', 'site', $settings['about_image'] ?? '');

    $site_name = trim($_POST['site_name'] ?? '');
    $tagline = trim($_POST['tagline'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $whatsapp = trim($_POST['whatsapp'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $google_maps = trim($_POST['google_maps'] ?? '');
    
    $hero_title = trim($_POST['hero_title'] ?? '');
    $hero_subtitle = trim($_POST['hero_subtitle'] ?? '');
    
    $about_title = trim($_POST['about_title'] ?? '');
    $about_summary = trim($_POST['about_summary'] ?? '');
    
    $meta_title = trim($_POST['meta_title'] ?? '');
    $meta_description = trim($_POST['meta_description'] ?? '');
    $footer_about = trim($_POST['footer_about'] ?? '');

    $facebook_url = trim($_POST['facebook_url'] ?? '');
    $linkedin_url = trim($_POST['linkedin_url'] ?? '');
    $instagram_url = trim($_POST['instagram_url'] ?? '');
    $twitter_url = trim($_POST['twitter_url'] ?? '');

    DB::query("UPDATE settings SET 
        site_name = ?, tagline = ?, logo = ?, favicon = ?, phone = ?, whatsapp = ?, email = ?, address = ?, google_maps = ?,
        hero_title = ?, hero_subtitle = ?, hero_image = ?, about_title = ?, about_summary = ?, about_image = ?,
        meta_title = ?, meta_description = ?, footer_about = ?, facebook_url = ?, linkedin_url = ?, instagram_url = ?, twitter_url = ?
        WHERE id = 1",
        [
            $site_name, $tagline, $logoPath, $faviconPath, $phone, $whatsapp, $email, $address, $google_maps,
            $hero_title, $hero_subtitle, $heroImgPath, $about_title, $about_summary, $aboutImgPath,
            $meta_title, $meta_description, $footer_about, $facebook_url, $linkedin_url, $instagram_url, $twitter_url
        ]
    );

    set_flash('success', 'Global site settings and assets updated successfully!');
    header("Location: " . ADMIN_URL . "/settings.php");
    exit;
}

$settings = get_settings();
?>

<form action="<?= ADMIN_URL ?>/settings.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">

    <div class="row g-4">
        
        <!-- Left Column: Branding & Media -->
        <div class="col-lg-6">
            
            <div class="admin-card p-4 mb-4">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-palette text-gold me-2"></i> Branding & Assets</h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Company Logo</label>
                        <div class="image-preview-container mb-2">
                            <img src="<?= get_image_url($settings['logo'] ?? '', 'logo', 'Logo') ?>" id="logoPreview" alt="Logo Preview">
                        </div>
                        <input type="file" name="logo" class="form-control form-control-sm" data-preview="logoPreview" accept="image/*">
                        <small class="text-muted">PNG / SVG with transparent background recommended.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Favicon Icon</label>
                        <div class="image-preview-container mb-2" style="max-width:80px; height:80px;">
                            <img src="<?= get_image_url($settings['favicon'] ?? '', 'favicon', 'Favicon') ?>" id="favPreview" alt="Favicon Preview">
                        </div>
                        <input type="file" name="favicon" class="form-control form-control-sm" data-preview="favPreview" accept="image/*">
                        <small class="text-muted">32x32 or 64x64 PNG format.</small>
                    </div>
                </div>

                <hr class="my-4">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Website Title / Brand Name</label>
                    <input type="text" name="site_name" class="form-control" value="<?= e($settings['site_name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Tagline</label>
                    <input type="text" name="tagline" class="form-control" value="<?= e($settings['tagline']) ?>">
                </div>
            </div>

            <!-- Contact & Social Details -->
            <div class="admin-card p-4 mb-4">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-telephone-outbound text-gold me-2"></i> Corporate Contact Information</h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="<?= e($settings['phone']) ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">WhatsApp Desk Number</label>
                        <input type="text" name="whatsapp" class="form-control" value="<?= e($settings['whatsapp']) ?>" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Official Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?= e($settings['email']) ?>" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Physical Office Address</label>
                        <textarea name="address" class="form-control" rows="2"><?= e($settings['address']) ?></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Google Maps Embed HTML / iframe</label>
                        <textarea name="google_maps" class="form-control" rows="3"><?= e($settings['google_maps']) ?></textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Hero, About, SEO & Footer -->
        <div class="col-lg-6">
            
            <div class="admin-card p-4 mb-4">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-window-sidebar text-gold me-2"></i> Homepage Hero & About Sections</h5>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Hero Main Headline</label>
                    <input type="text" name="hero_title" class="form-control" value="<?= e($settings['hero_title']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Hero Subtitle</label>
                    <textarea name="hero_subtitle" class="form-control" rows="2"><?= e($settings['hero_subtitle']) ?></textarea>
                </div>

                <hr class="my-4">

                <div class="mb-3">
                    <label class="form-label fw-semibold">About Section Headline</label>
                    <input type="text" name="about_title" class="form-control" value="<?= e($settings['about_title']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">About Section Overview Text</label>
                    <textarea name="about_summary" class="form-control" rows="4"><?= e($settings['about_summary']) ?></textarea>
                </div>
            </div>

            <!-- SEO & Footer Settings -->
            <div class="admin-card p-4 mb-4">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-search text-gold me-2"></i> Global SEO Meta Tags & Footer</h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Default Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="<?= e($settings['meta_title']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Default Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="2"><?= e($settings['meta_description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Footer Brand Paragraph</label>
                    <textarea name="footer_about" class="form-control" rows="2"><?= e($settings['footer_about']) ?></textarea>
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label small fw-semibold">Facebook URL</label>
                        <input type="url" name="facebook_url" class="form-control form-control-sm" value="<?= e($settings['facebook_url']) ?>">
                    </div>
                    <div class="col-6">
                        <label class="form-label small fw-semibold">LinkedIn URL</label>
                        <input type="url" name="linkedin_url" class="form-control form-control-sm" value="<?= e($settings['linkedin_url']) ?>">
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="sticky-bottom bg-white p-3 border-top shadow-lg rounded-4 mb-4 d-flex justify-content-end gap-3">
        <button type="submit" class="btn btn-success btn-lg rounded-pill px-5 fw-bold">
            <i class="bi bi-check-circle-fill me-1"></i> Save All Settings Changes
        </button>
    </div>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
