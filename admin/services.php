<?php
/**
 * Admin Panel - Services Module (CRUD)
 */

$adminTitle = "Services Module";

require_once __DIR__ . '/includes/header.php';

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);

// Delete Service Action
if ($action === 'delete' && $id > 0) {
    verify_csrf();
    $srv = DB::fetch("SELECT image FROM services WHERE id = ?", [$id]);
    if ($srv && !empty($srv['image']) && file_exists(UPLOAD_DIR . $srv['image'])) {
        @unlink(UPLOAD_DIR . $srv['image']);
    }
    DB::query("DELETE FROM services WHERE id = ?", [$id]);
    set_flash('success', 'Service deleted successfully.');
    header("Location: " . ADMIN_URL . "/services.php");
    exit;
}

// Toggle Hide / Show Action
if ($action === 'toggle' && $id > 0) {
    verify_csrf();
    $srv = DB::fetch("SELECT status FROM services WHERE id = ?", [$id]);
    if ($srv) {
        $newStatus = ($srv['status'] === 'published') ? 'hidden' : 'published';
        DB::query("UPDATE services SET status = ? WHERE id = ?", [$newStatus, $id]);
        set_flash('success', "Service status changed to {$newStatus}.");
    }
    header("Location: " . ADMIN_URL . "/services.php");
    exit;
}

// Save (Add / Edit) Handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    
    $title = trim($_POST['title'] ?? '');
    $short_description = trim($_POST['short_description'] ?? '');
    $full_description = trim($_POST['full_description'] ?? '');
    $status = $_POST['status'] ?? 'published';
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    $oldService = ($id > 0) ? DB::fetch("SELECT * FROM services WHERE id = ?", [$id]) : null;
    $imagePath = upload_image('image', 'services', $oldService['image'] ?? '');
    
    $slug = !empty($_POST['slug']) ? slugify($_POST['slug']) : slugify($title);

    // FAQs array to JSON
    $faqQuestions = $_POST['faq_questions'] ?? [];
    $faqAnswers = $_POST['faq_answers'] ?? [];
    $faqsList = [];
    for ($i = 0; $i < count($faqQuestions); $i++) {
        if (!empty(trim($faqQuestions[$i])) && !empty(trim($faqAnswers[$i]))) {
            $faqsList[] = [
                'question' => trim($faqQuestions[$i]),
                'answer' => trim($faqAnswers[$i])
            ];
        }
    }
    $faqsJson = json_encode($faqsList);

    if ($id > 0) {
        DB::query("UPDATE services SET title = ?, slug = ?, image = ?, short_description = ?, full_description = ?, faqs_json = ?, status = ?, sort_order = ? WHERE id = ?",
            [$title, $slug, $imagePath, $short_description, $full_description, $faqsJson, $status, $sort_order, $id]
        );
        set_flash('success', 'Service updated successfully.');
    } else {
        DB::query("INSERT INTO services (title, slug, image, short_description, full_description, faqs_json, status, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            [$title, $slug, $imagePath, $short_description, $full_description, $faqsJson, $status, $sort_order]
        );
        set_flash('success', 'New Service added successfully.');
    }

    header("Location: " . ADMIN_URL . "/services.php");
    exit;
}

// Edit or Add View
if ($action === 'add' || $action === 'edit'):
    $srv = ($id > 0) ? DB::fetch("SELECT * FROM services WHERE id = ?", [$id]) : null;
    $faqs = !empty($srv['faqs_json']) ? json_decode($srv['faqs_json'], true) : [];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-primary mb-0"><?= ($id > 0) ? 'Edit Service' : 'Add New Service' ?></h4>
    <a href="<?= ADMIN_URL ?>/services.php" class="btn btn-outline-secondary rounded-pill btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Services List
    </a>
</div>

<form action="<?= ADMIN_URL ?>/services.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card p-4 mb-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Service Title *</label>
                    <input type="text" name="title" class="form-control form-control-lg" value="<?= e($srv['title'] ?? '') ?>" required placeholder="e.g. Contract Banana Farming">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">URL Slug (Auto-generated if left blank)</label>
                    <input type="text" name="slug" class="form-control" value="<?= e($srv['slug'] ?? '') ?>" placeholder="contract-banana-farming">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Short Summary *</label>
                    <textarea name="short_description" class="form-control" rows="3" required><?= e($srv['short_description'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Description & Process Details *</label>
                    <textarea name="full_description" class="form-control" rows="7" required><?= e($srv['full_description'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- FAQs Editor -->
            <div class="admin-card p-4">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-question-circle text-gold me-2"></i> Service FAQs</h5>
                <div id="faqList">
                    <?php 
                    if (!empty($faqs)): 
                        foreach ($faqs as $fq): 
                    ?>
                        <div class="border rounded p-3 mb-3 bg-light position-relative">
                            <input type="text" name="faq_questions[]" class="form-control mb-2 fw-semibold" value="<?= e($fq['question']) ?>" placeholder="Question">
                            <textarea name="faq_answers[]" class="form-control" rows="2" placeholder="Answer"><?= e($fq['answer']) ?></textarea>
                        </div>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
                        <div class="border rounded p-3 mb-3 bg-light">
                            <input type="text" name="faq_questions[]" class="form-control mb-2 fw-semibold" placeholder="Question">
                            <textarea name="faq_answers[]" class="form-control" rows="2" placeholder="Answer"></textarea>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card p-4 mb-4">
                <h5 class="fw-bold text-primary mb-3">Settings & Image</h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Service Featured Image</label>
                    <div class="image-preview-container mb-2">
                        <img src="<?= get_image_url($srv['image'] ?? '', 'services', 'Service Image') ?>" id="srvPreview" alt="Preview">
                    </div>
                    <input type="file" name="image" class="form-control form-control-sm" data-preview="srvPreview" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Publication Status</label>
                    <select name="status" class="form-select">
                        <option value="published" <?= (($srv['status'] ?? '') === 'published') ? 'selected' : '' ?>>Published</option>
                        <option value="hidden" <?= (($srv['status'] ?? '') === 'hidden') ? 'selected' : '' ?>>Hidden</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= e($srv['sort_order'] ?? 0) ?>">
                </div>

                <button type="submit" class="btn btn-success w-100 py-3 rounded-pill fw-bold">
                    <i class="bi bi-check-circle me-1"></i> Save Service
                </button>
            </div>
        </div>
    </div>
</form>

<?php 
else: 
    $services = DB::fetchAll("SELECT * FROM services ORDER BY sort_order ASC, id DESC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-primary mb-0">Services Manager</h4>
    <a href="<?= ADMIN_URL ?>/services.php?action=add" class="btn btn-success rounded-pill px-4">
        <i class="bi bi-plus-circle me-1"></i> Add New Service
    </a>
</div>

<div class="admin-card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Order</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Summary</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $srv): ?>
                    <tr>
                        <td><span class="badge bg-secondary"><?= $srv['sort_order'] ?></span></td>
                        <td>
                            <img src="<?= get_image_url($srv['image'], 'services', $srv['title']) ?>" class="rounded" width="50" height="50" style="object-fit:cover;">
                        </td>
                        <td class="fw-bold text-primary"><?= e($srv['title']) ?></td>
                        <td class="small text-muted"><?= e(mb_strimwidth($srv['short_description'], 0, 70, "...")) ?></td>
                        <td>
                            <?php if ($srv['status'] === 'published'): ?>
                                <span class="badge bg-success-subtle text-success border border-success">Published</span>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary border">Hidden</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <form action="<?= ADMIN_URL ?>/services.php?action=toggle&id=<?= $srv['id'] ?>" method="POST" class="d-inline">
                                <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">
                                <button type="submit" class="btn btn-sm btn-outline-warning" title="Toggle Status">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </form>

                            <a href="<?= ADMIN_URL ?>/services.php?action=edit&id=<?= $srv['id'] ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="<?= ADMIN_URL ?>/services.php?action=delete&id=<?= $srv['id'] ?>" method="POST" class="d-inline">
                                <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-delete-confirm">
                                    <i class="bi bi-trash"></i>
                                </button>
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
