<?php
/**
 * Admin Panel - Clients Module (CRUD)
 */

$adminTitle = "Clients Module";

require_once __DIR__ . '/includes/header.php';

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);

if ($action === 'delete' && $id > 0) {
    verify_csrf();
    $c = DB::fetch("SELECT logo FROM clients WHERE id = ?", [$id]);
    if ($c && !empty($c['logo']) && file_exists(UPLOAD_DIR . $c['logo'])) {
        @unlink(UPLOAD_DIR . $c['logo']);
    }
    DB::query("DELETE FROM clients WHERE id = ?", [$id]);
    set_flash('success', 'Client deleted successfully.');
    header("Location: " . ADMIN_URL . "/clients.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    
    $name = trim($_POST['name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $website = trim($_POST['website'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    $oldClient = ($id > 0) ? DB::fetch("SELECT * FROM clients WHERE id = ?", [$id]) : null;
    $logoPath = upload_image('logo', 'clients', $oldClient['logo'] ?? '');

    if ($id > 0) {
        DB::query("UPDATE clients SET name = ?, logo = ?, location = ?, website = ?, description = ?, sort_order = ? WHERE id = ?",
            [$name, $logoPath, $location, $website, $description, $sort_order, $id]
        );
        set_flash('success', 'Client updated successfully.');
    } else {
        DB::query("INSERT INTO clients (name, logo, location, website, description, sort_order) VALUES (?, ?, ?, ?, ?, ?)",
            [$name, $logoPath, $location, $website, $description, $sort_order]
        );
        set_flash('success', 'New Client added successfully.');
    }

    header("Location: " . ADMIN_URL . "/clients.php");
    exit;
}

if ($action === 'add' || $action === 'edit'):
    $client = ($id > 0) ? DB::fetch("SELECT * FROM clients WHERE id = ?", [$id]) : null;
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-primary mb-0"><?= ($id > 0) ? 'Edit Client' : 'Add New Client' ?></h4>
    <a href="<?= ADMIN_URL ?>/clients.php" class="btn btn-outline-secondary rounded-pill btn-sm">Back to List</a>
</div>

<div class="admin-card p-4 max-w-700">
    <form action="<?= ADMIN_URL ?>/clients.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">

        <div class="mb-3">
            <label class="form-label fw-semibold">Client / Company Name *</label>
            <input type="text" name="name" class="form-control" value="<?= e($client['name'] ?? '') ?>" required placeholder="e.g. Middle East Fruit Importers LLC">
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Location / Country *</label>
                <input type="text" name="location" class="form-control" value="<?= e($client['location'] ?? '') ?>" required placeholder="Dubai, UAE">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Website Link</label>
                <input type="url" name="website" class="form-control" value="<?= e($client['website'] ?? '') ?>" placeholder="https://example.com">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Client Description</label>
            <textarea name="description" class="form-control" rows="3"><?= e($client['description'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Client Logo</label>
            <div class="image-preview-container mb-2" style="max-width:120px; height:80px;">
                <img src="<?= get_image_url($client['logo'] ?? '', 'clients', 'Logo') ?>" id="clientPreview" alt="Preview">
            </div>
            <input type="file" name="logo" class="form-control form-control-sm" data-preview="clientPreview" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Sort Order</label>
            <input type="number" name="sort_order" class="form-control" value="<?= e($client['sort_order'] ?? 0) ?>">
        </div>

        <button type="submit" class="btn btn-success py-2 px-4 rounded-pill fw-bold">Save Client</button>
    </form>
</div>

<?php 
else: 
    $clients = DB::fetchAll("SELECT * FROM clients ORDER BY sort_order ASC, id DESC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-primary mb-0">Clients Manager</h4>
    <a href="<?= ADMIN_URL ?>/clients.php?action=add" class="btn btn-success rounded-pill px-4">
        <i class="bi bi-plus-circle me-1"></i> Add New Client
    </a>
</div>

<div class="admin-card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Website</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $c): ?>
                    <tr>
                        <td>
                            <img src="<?= get_image_url($c['logo'], 'clients', $c['name']) ?>" class="rounded" width="40" height="40" style="object-fit:cover;">
                        </td>
                        <td class="fw-bold text-primary"><?= e($c['name']) ?></td>
                        <td><span class="badge bg-light text-dark border"><?= e($c['location']) ?></span></td>
                        <td class="small"><a href="<?= e($c['website']) ?>" target="_blank"><?= e($c['website']) ?></a></td>
                        <td class="text-end">
                            <a href="<?= ADMIN_URL ?>/clients.php?action=edit&id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                            <form action="<?= ADMIN_URL ?>/clients.php?action=delete&id=<?= $c['id'] ?>" method="POST" class="d-inline">
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
