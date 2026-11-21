<?php
/**
 * Girna Global - Core Functions & Helpers
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/db.php';

/**
 * XSS Clean Escape
 */
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Verify CSRF Token
 */
function verify_csrf() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if (!hash_equals(CSRF_TOKEN, $token)) {
            http_response_code(403);
            die("CSRF validation failed. Refresh the page and try again.");
        }
    }
}

/**
 * Generate URL-friendly Slugs
 */
function slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return empty($text) ? 'n-a' : $text;
}

/**
 * Flash Messages Helper
 */
function set_flash($type, $message) {
    $_SESSION['flash_msg'] = [
        'type' => $type, // success, danger, warning, info
        'text' => $message
    ];
}

function display_flash() {
    if (!empty($_SESSION['flash_msg'])) {
        $type = e($_SESSION['flash_msg']['type']);
        $text = e($_SESSION['flash_msg']['text']);
        unset($_SESSION['flash_msg']);
        echo "<div class='alert alert-{$type} alert-dismissible fade show my-3' role='alert'>
                {$text}
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
    }
}

/**
 * Fetch Global Settings Row
 */
function get_settings() {
    static $settings = null;
    if ($settings === null) {
        $row = DB::fetch("SELECT * FROM settings WHERE id = 1");
        if (!$row) {
            $settings = [
                'site_name' => 'Girna Global',
                'tagline' => 'Premium Agricultural Produce & Global Banana Export',
                'logo' => '',
                'favicon' => '',
                'phone' => '+91 98765 43210',
                'whatsapp' => '+91 98765 43210',
                'email' => 'contact@girnaglobal.com',
                'address' => 'Girna Valley Agri Hub, NH-6 Highway, Jalgaon, Maharashtra, India',
                'google_maps' => '',
                'hero_title' => 'Connecting Fertile Lands to Global Markets',
                'hero_subtitle' => 'Exporter of Premium G9 Cavendish Bananas & Bio-Fertilizers.',
                'hero_image' => '',
                'about_title' => 'Pioneering Sustainable Agriculture & Fresh Exports',
                'about_summary' => 'Girna Global specializes in contract banana farming, cold-chain logistics, and premium bio-fertilizers.',
                'about_image' => '',
                'meta_title' => 'Girna Global | Premium Banana Exporter',
                'meta_description' => 'Exporter of premium Cavendish bananas, organic fertilizers, and fresh farm produce.',
                'footer_about' => 'Girna Global delivers world-class agricultural products directly from farms to global markets.',
                'facebook_url' => '#', 'linkedin_url' => '#', 'instagram_url' => '#', 'twitter_url' => '#'
            ];
        } else {
            $settings = $row;
        }
    }
    return $settings;
}

/**
 * Handle File Upload safely into subfolders
 */
function upload_image($fileKey, $subFolder = 'site', $oldImage = '') {
    if (!isset($_FILES[$fileKey]) || $_FILES[$fileKey]['error'] !== UPLOAD_ERR_OK) {
        return $oldImage;
    }

    $file = $_FILES[$fileKey];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'];
    $fileType = mime_content_type($file['tmp_name']);

    if (!in_array($fileType, $allowedTypes)) {
        set_flash('danger', 'Invalid file type. Only JPG, PNG, WEBP, GIF, and SVG files are allowed.');
        return $oldImage;
    }

    // Max 10MB limit
    if ($file['size'] > 10 * 1024 * 1024) {
        set_flash('danger', 'File size exceeds 10MB limit.');
        return $oldImage;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $newFileName = uniqid($subFolder . '_', true) . '.' . $ext;
    $targetDir = UPLOAD_DIR . $subFolder . '/';

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $targetFilePath = $targetDir . $newFileName;

    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        // Delete previous image if exists
        if (!empty($oldImage) && file_exists(UPLOAD_DIR . $oldImage)) {
            @unlink(UPLOAD_DIR . $oldImage);
        }
        return $subFolder . '/' . $newFileName;
    }

    return $oldImage;
}

/**
 * Render Image or Elegant SVG Placeholder if missing
 */
function get_image_url($relativePath, $type = 'general', $label = 'Girna Global') {
    if (!empty($relativePath) && file_exists(UPLOAD_DIR . $relativePath)) {
        return UPLOAD_URL . $relativePath;
    }

    // Dynamic clean inline SVG data uri generator if image not uploaded yet
    $bgColor = '%23062c1e'; // Luxury Emerald Green
    $textColor = '%23d4af37'; // Warm Gold
    $encodedLabel = rawurlencode($label);
    
    return "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='800' height='600' viewBox='0 0 800 600'><rect width='100%' height='100%' fill='{$bgColor}'/><circle cx='400' cy='240' r='80' fill='%230b422e'/><path d='M360 260 L400 200 L440 260 Z' fill='{$textColor}' opacity='0.8'/><text x='50%' y='420' font-family='Arial, sans-serif' font-size='26' font-weight='bold' fill='{$textColor}' text-anchor='middle'>{$encodedLabel}</text><text x='50%' y='460' font-family='Arial, sans-serif' font-size='16' fill='%23a1a1aa' text-anchor='middle'>GIRNA GLOBAL PREMIUM AGRI</text></svg>";
}
