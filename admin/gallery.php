<?php
/**
 * Admin Panel - Gallery Module (CRUD)
 */

$adminTitle = "Gallery Module";

require_once __DIR__ . '/includes/header.php';

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);

if ($action === 'delete' && $id > 0) {
    verify_csrf();
    $g = DB::fetch("SELECT image_path FROM gallery WHERE id = ?", [$id]);
    if ($g && !empty($g['image_path']) && file_exists(UPLOAD_DIR . $g['image_path'])) {
        @unlink(UPLOAD_DIR . $g['image_path']);
    }
    DB::query("DELETE FROM gallery WHERE id = ?", [$id]);
    set_flash('success', 'Gallery image deleted.');
    header("Location: " . ADMIN_URL . "/gallery.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? 'Harvesting');
    $caption = trim($_POST['caption'] ?? '');

    $oldGal = ($id > 0) ? DB::fetch("SELECT * FROM gallery WHERE id = ?", [$id]) : null;
    $imagePath = upload_image('image_path', 'gallery', $oldGal['image_path'] ?? '');

    if ($id > 0) {
        DB::query("UPDATE gallery SET title = ?, category = ?, image_path = ?, caption = ? WHERE id = ?",
            [$title, $category, $imagePath, $caption, $id]
        );
        set_flash('success', 'Gallery item updated.');
    } else {
        DB::query("INSERT INTO gallery (title, category, image_path, caption) VALUES (?, ?, ?, ?)",
            [$title, $category, $imagePath, $caption]
        );
        set_flash('success', 'New Gallery item added.');
    }

    header("Location: " . ADMIN_URL . "/gallery.php");
    exit;
}

if ($action === 'add' || $action === 'edit'):
    $g = ($id > 0) ? DB::fetch("SELECT * FROM gallery WHERE id = ?", [$id]) : null;
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-primary mb-0"><?= ($id > 0) ? 'Edit Gallery Photo' : 'Upload Gallery Photo' ?></h4>
    <a href="<?= ADMIN_URL ?>/gallery.php" class="btn btn-outline-secondary rounded-pill btn-sm">Back to List</a>
</div>

<div class="admin-card p-4 max-w-700">
    <form action="<?= ADMIN_URL ?>/gallery.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">

        <div class="mb-3">
            <label class="form-label fw-semibold">Photo Title *</label>
            <input type="text" name="title" class="form-control" value="<?= e($g['title'] ?? '') ?>" required placeholder="e.g. Modern Cold Pack-House">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Category Tag *</label>
            <input type="text" name="category" class="form-control" value="<?= e($g['category'] ?? 'Harvesting') ?>" required placeholder="Harvesting / Processing / Export / Technology">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Caption / Description</label>
            <textarea name="caption" class="form-control" rows="3"><?= e($g['caption'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Photo File *</label>
            <div class="image-preview-container mb-2">
                <img src="<?= get_image_url($g['image_path'] ?? '', 'gallery', 'Photo') ?>" id="galPreview" alt="Preview">
            </div>
            <input type="file" name="image_path" class="form-control form-control-sm" data-preview="galPreview" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success py-2 px-4 rounded-pill fw-bold">Save Gallery Item</button>
    </form>
</div>

<?php 
else: 
    $items = DB::fetchAll("SELECT * FROM gallery ORDER BY id DESC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-primary mb-0">Gallery Manager</h4>
    <a href="<?= ADMIN_URL ?>/gallery.php?action=add" class="btn btn-success rounded-pill px-4">
        <i class="bi bi-upload me-1"></i> Upload New Photo
    </a>
</div>

<div class="row g-4">
    <?php foreach ($items as $item): ?>
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="admin-card overflow-hidden h-100 d-flex flex-column">
                <div style="height:180px; overflow:hidden; background:#000;">
                    <img src="<?= get_image_url($item['image_path'], 'gallery', $item['title']) ?>" class="w-100 h-100" style="object-fit:cover;">
                </div>
                <div class="p-3 d-flex flex-column flex-grow-1">
                    <span class="badge bg-warning text-dark me-auto mb-1"><?= e($item['category']) ?></span>
                    <h6 class="fw-bold mb-1 text-primary"><?= e($item['title']) ?></h6>
                    <small class="text-muted flex-grow-1 mb-3"><?= e($item['caption']) ?></small>
                    
                    <div class="d-flex justify-content-between pt-2 border-top">
                        <a href="<?= ADMIN_URL ?>/gallery.php?action=edit&id=<?= $item['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil me-1"></i> Edit</a>
                        <form action="<?= ADMIN_URL ?>/gallery.php?action=delete&id=<?= $item['id'] ?>" method="POST" class="d-inline">
                            <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">
                            <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
