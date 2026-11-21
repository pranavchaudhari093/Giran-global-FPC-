<?php
/**
 * Admin Panel - Products Module (CRUD)
 */

$adminTitle = "Products Module";

require_once __DIR__ . '/includes/header.php';

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);

// Delete Product Action
if ($action === 'delete' && $id > 0) {
    verify_csrf();
    $prod = DB::fetch("SELECT main_image FROM products WHERE id = ?", [$id]);
    if ($prod && !empty($prod['main_image']) && file_exists(UPLOAD_DIR . $prod['main_image'])) {
        @unlink(UPLOAD_DIR . $prod['main_image']);
    }
    DB::query("DELETE FROM products WHERE id = ?", [$id]);
    set_flash('success', 'Product deleted successfully.');
    header("Location: " . ADMIN_URL . "/products.php");
    exit;
}

// Toggle Featured Action
if ($action === 'toggle_featured' && $id > 0) {
    verify_csrf();
    $prod = DB::fetch("SELECT is_featured FROM products WHERE id = ?", [$id]);
    if ($prod) {
        $newFlag = $prod['is_featured'] ? 0 : 1;
        DB::query("UPDATE products SET is_featured = ? WHERE id = ?", [$newFlag, $id]);
        set_flash('success', 'Product featured status updated.');
    }
    header("Location: " . ADMIN_URL . "/products.php");
    exit;
}

// Save (Add / Edit) Handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? 'Banana Export');
    $price_unit = trim($_POST['price_unit'] ?? 'On Request');
    $description = trim($_POST['description'] ?? '');
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $status = $_POST['status'] ?? 'published';

    $oldProd = ($id > 0) ? DB::fetch("SELECT * FROM products WHERE id = ?", [$id]) : null;
    $mainImagePath = upload_image('main_image', 'products', $oldProd['main_image'] ?? '');
    
    $slug = !empty($_POST['slug']) ? slugify($_POST['slug']) : slugify($title);

    // Specifications array to JSON
    $specKeys = $_POST['spec_keys'] ?? [];
    $specValues = $_POST['spec_values'] ?? [];
    $specsList = [];
    for ($i = 0; $i < count($specKeys); $i++) {
        if (!empty(trim($specKeys[$i])) && !empty(trim($specValues[$i]))) {
            $specsList[] = [
                'key' => trim($specKeys[$i]),
                'value' => trim($specValues[$i])
            ];
        }
    }
    $specsJson = json_encode($specsList);

    if ($id > 0) {
        DB::query("UPDATE products SET title = ?, slug = ?, category = ?, main_image = ?, price_unit = ?, specifications_json = ?, description = ?, is_featured = ?, status = ? WHERE id = ?",
            [$title, $slug, $category, $mainImagePath, $price_unit, $specsJson, $description, $is_featured, $status, $id]
        );
        set_flash('success', 'Product updated successfully.');
    } else {
        DB::query("INSERT INTO products (title, slug, category, main_image, price_unit, specifications_json, description, is_featured, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [$title, $slug, $category, $mainImagePath, $price_unit, $specsJson, $description, $is_featured, $status]
        );
        set_flash('success', 'New Product added successfully.');
    }

    header("Location: " . ADMIN_URL . "/products.php");
    exit;
}

// Edit or Add View
if ($action === 'add' || $action === 'edit'):
    $prod = ($id > 0) ? DB::fetch("SELECT * FROM products WHERE id = ?", [$id]) : null;
    $specs = !empty($prod['specifications_json']) ? json_decode($prod['specifications_json'], true) : [];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-primary mb-0"><?= ($id > 0) ? 'Edit Product' : 'Add New Product' ?></h4>
    <a href="<?= ADMIN_URL ?>/products.php" class="btn btn-outline-secondary rounded-pill btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Products List
    </a>
</div>

<form action="<?= ADMIN_URL ?>/products.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card p-4 mb-4">
                <div class="row g-3 mb-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Product Title *</label>
                        <input type="text" name="title" class="form-control form-control-lg" value="<?= e($prod['title'] ?? '') ?>" required placeholder="e.g. Premium G9 Cavendish Bananas">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Category *</label>
                        <input type="text" name="category" class="form-control form-control-lg" value="<?= e($prod['category'] ?? 'Banana Export') ?>" required placeholder="Banana Export / Fertilizer">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">URL Slug</label>
                        <input type="text" name="slug" class="form-control" value="<?= e($prod['slug'] ?? '') ?>" placeholder="premium-g9-cavendish-bananas">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Price / Unit Tag *</label>
                        <input type="text" name="price_unit" class="form-control" value="<?= e($prod['price_unit'] ?? 'FOB / CIF Competitive Pricing') ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Detailed Description & Export Standards *</label>
                    <textarea name="description" class="form-control" rows="6" required><?= e($prod['description'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Dynamic Specifications Editor -->
            <div class="admin-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-primary mb-0"><i class="bi bi-sliders text-gold me-2"></i> Product Specifications</h5>
                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill" id="addSpecRowBtn">
                        <i class="bi bi-plus me-1"></i> Add Parameter Row
                    </button>
                </div>

                <div id="specRowsContainer">
                    <?php 
                    if (!empty($specs)): 
                        foreach ($specs as $sp): 
                    ?>
                        <div class="row g-2 mb-2 spec-row align-items-center">
                            <div class="col-5">
                                <input type="text" name="spec_keys[]" class="form-control" value="<?= e($sp['key']) ?>" placeholder="Key">
                            </div>
                            <div class="col-6">
                                <input type="text" name="spec_values[]" class="form-control" value="<?= e($sp['value']) ?>" placeholder="Value">
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-spec-btn"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    <?php 
                        endforeach; 
                    else: 
                    ?>
                        <div class="row g-2 mb-2 spec-row align-items-center">
                            <div class="col-5">
                                <input type="text" name="spec_keys[]" class="form-control" placeholder="Variety">
                            </div>
                            <div class="col-6">
                                <input type="text" name="spec_values[]" class="form-control" placeholder="Grand Naine (G9)">
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-spec-btn"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card p-4 mb-4">
                <h5 class="fw-bold text-primary mb-3">Image & Featured</h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Main Image</label>
                    <div class="image-preview-container mb-2">
                        <img src="<?= get_image_url($prod['main_image'] ?? '', 'product', 'Product Image') ?>" id="prodPreview" alt="Preview">
                    </div>
                    <input type="file" name="main_image" class="form-control form-control-sm" data-preview="prodPreview" accept="image/*">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="featuredCheck" <?= (!empty($prod['is_featured'])) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-semibold" for="featuredCheck">Highlight on Homepage</label>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Publication Status</label>
                    <select name="status" class="form-select">
                        <option value="published" <?= (($prod['status'] ?? '') === 'published') ? 'selected' : '' ?>>Published</option>
                        <option value="hidden" <?= (($prod['status'] ?? '') === 'hidden') ? 'selected' : '' ?>>Hidden</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success w-100 py-3 rounded-pill fw-bold">
                    <i class="bi bi-check-circle me-1"></i> Save Product
                </button>
            </div>
        </div>
    </div>
</form>

<?php 
else: 
    $products = DB::fetchAll("SELECT * FROM products ORDER BY id DESC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-primary mb-0">Products Catalog Manager</h4>
    <a href="<?= ADMIN_URL ?>/products.php?action=add" class="btn btn-success rounded-pill px-4">
        <i class="bi bi-plus-circle me-1"></i> Add New Product
    </a>
</div>

<div class="admin-card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Price / Unit</th>
                    <th>Featured</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td>
                            <img src="<?= get_image_url($p['main_image'], 'product', $p['title']) ?>" class="rounded" width="50" height="50" style="object-fit:cover;">
                        </td>
                        <td class="fw-bold text-primary"><?= e($p['title']) ?></td>
                        <td><span class="badge bg-warning text-dark"><?= e($p['category']) ?></span></td>
                        <td class="small fw-semibold"><?= e($p['price_unit']) ?></td>
                        <td>
                            <form action="<?= ADMIN_URL ?>/products.php?action=toggle_featured&id=<?= $p['id'] ?>" method="POST" class="d-inline">
                                <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">
                                <button type="submit" class="btn btn-sm <?= $p['is_featured'] ? 'btn-warning' : 'btn-outline-secondary' ?>">
                                    <i class="bi bi-star-fill"></i> <?= $p['is_featured'] ? 'Featured' : 'Standard' ?>
                                </button>
                            </form>
                        </td>
                        <td>
                            <?php if ($p['status'] === 'published'): ?>
                                <span class="badge bg-success-subtle text-success border border-success">Published</span>
                            <?php else: ?>
                                <span class="badge bg-secondary-subtle text-secondary border">Hidden</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <a href="<?= ADMIN_URL ?>/products.php?action=edit&id=<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="<?= ADMIN_URL ?>/products.php?action=delete&id=<?= $p['id'] ?>" method="POST" class="d-inline">
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
