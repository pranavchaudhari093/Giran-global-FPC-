<?php
/**
 * Admin Panel - Testimonials Module (CRUD)
 */

$adminTitle = "Testimonials Module";

require_once __DIR__ . '/includes/header.php';

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);

if ($action === 'delete' && $id > 0) {
    verify_csrf();
    $t = DB::fetch("SELECT photo FROM testimonials WHERE id = ?", [$id]);
    if ($t && !empty($t['photo']) && file_exists(UPLOAD_DIR . $t['photo'])) {
        @unlink(UPLOAD_DIR . $t['photo']);
    }
    DB::query("DELETE FROM testimonials WHERE id = ?", [$id]);
    set_flash('success', 'Testimonial deleted successfully.');
    header("Location: " . ADMIN_URL . "/testimonials.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    
    $name = trim($_POST['name'] ?? '');
    $village = trim($_POST['village'] ?? '');
    $rating = (int)($_POST['rating'] ?? 5);
    $review = trim($_POST['review'] ?? '');
    $video_url = trim($_POST['video_url'] ?? '');

    $oldTest = ($id > 0) ? DB::fetch("SELECT * FROM testimonials WHERE id = ?", [$id]) : null;
    $photoPath = upload_image('photo', 'testimonials', $oldTest['photo'] ?? '');

    if ($id > 0) {
        DB::query("UPDATE testimonials SET name = ?, photo = ?, village = ?, rating = ?, review = ?, video_url = ? WHERE id = ?",
            [$name, $photoPath, $village, $rating, $review, $video_url, $id]
        );
        set_flash('success', 'Testimonial updated successfully.');
    } else {
        DB::query("INSERT INTO testimonials (name, photo, village, rating, review, video_url) VALUES (?, ?, ?, ?, ?, ?)",
            [$name, $photoPath, $village, $rating, $review, $video_url]
        );
        set_flash('success', 'New Testimonial added successfully.');
    }

    header("Location: " . ADMIN_URL . "/testimonials.php");
    exit;
}

if ($action === 'add' || $action === 'edit'):
    $t = ($id > 0) ? DB::fetch("SELECT * FROM testimonials WHERE id = ?", [$id]) : null;
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-primary mb-0"><?= ($id > 0) ? 'Edit Testimonial' : 'Add New Testimonial' ?></h4>
    <a href="<?= ADMIN_URL ?>/testimonials.php" class="btn btn-outline-secondary rounded-pill btn-sm">Back to List</a>
</div>

<div class="admin-card p-4 max-w-700">
    <form action="<?= ADMIN_URL ?>/testimonials.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Customer / Farmer Name *</label>
                <input type="text" name="name" class="form-control" value="<?= e($t['name'] ?? '') ?>" required placeholder="Suresh Patil">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Village / Location *</label>
                <input type="text" name="village" class="form-control" value="<?= e($t['village'] ?? '') ?>" required placeholder="Raver, Jalgaon">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Star Rating (1 to 5)</label>
            <select name="rating" class="form-select">
                <?php for($r=5; $r>=1; $r--): ?>
                    <option value="<?= $r ?>" <?= (($t['rating'] ?? 5) == $r) ? 'selected' : '' ?>><?= $r ?> Stars</option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Review Comment *</label>
            <textarea name="review" class="form-control" rows="4" required><?= e($t['review'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Video Testimonial Link (Optional)</label>
            <input type="url" name="video_url" class="form-control" value="<?= e($t['video_url'] ?? '') ?>" placeholder="https://youtube.com/watch?v=...">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Photo</label>
            <div class="image-preview-container mb-2" style="max-width:90px; height:90px; border-radius:50%;">
                <img src="<?= get_image_url($t['photo'] ?? '', 'testimonials', 'Photo') ?>" id="testiPreview" alt="Preview">
            </div>
            <input type="file" name="photo" class="form-control form-control-sm" data-preview="testiPreview" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success py-2 px-4 rounded-pill fw-bold">Save Testimonial</button>
    </form>
</div>

<?php 
else: 
    $testimonials = DB::fetchAll("SELECT * FROM testimonials ORDER BY id DESC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-primary mb-0">Testimonials Manager</h4>
    <a href="<?= ADMIN_URL ?>/testimonials.php?action=add" class="btn btn-success rounded-pill px-4">
        <i class="bi bi-plus-circle me-1"></i> Add New Testimonial
    </a>
</div>

<div class="admin-card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($testimonials as $t): ?>
                    <tr>
                        <td>
                            <img src="<?= get_image_url($t['photo'], 'testimonials', $t['name']) ?>" class="rounded-circle" width="45" height="45" style="object-fit:cover;">
                        </td>
                        <td class="fw-bold text-primary"><?= e($t['name']) ?></td>
                        <td><small class="text-muted"><?= e($t['village']) ?></small></td>
                        <td><span class="text-warning fw-bold"><?= $t['rating'] ?> ★</span></td>
                        <td class="small text-muted"><?= e(mb_strimwidth($t['review'], 0, 60, "...")) ?></td>
                        <td class="text-end">
                            <a href="<?= ADMIN_URL ?>/testimonials.php?action=edit&id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="<?= ADMIN_URL ?>/testimonials.php?action=delete&id=<?= $t['id'] ?>" method="POST" class="d-inline">
                                <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
