<?php
/**
 * Admin Panel - Customer Inquiries Message Center
 */

$adminTitle = "Customer Inquiries";

require_once __DIR__ . '/includes/header.php';

$action = $_GET['action'] ?? 'list';
$id = (int)($_GET['id'] ?? 0);

// Mark Read Action
if ($action === 'mark_read' && $id > 0) {
    verify_csrf();
    DB::query("UPDATE inquiries SET is_read = 1 WHERE id = ?", [$id]);
    set_flash('success', 'Inquiry marked as read.');
    header("Location: " . ADMIN_URL . "/inquiries.php");
    exit;
}

// Delete Action
if ($action === 'delete' && $id > 0) {
    verify_csrf();
    DB::query("DELETE FROM inquiries WHERE id = ?", [$id]);
    set_flash('success', 'Inquiry deleted.');
    header("Location: " . ADMIN_URL . "/inquiries.php");
    exit;
}

// Single View
if ($id > 0 && $action === 'view'):
    DB::query("UPDATE inquiries SET is_read = 1 WHERE id = ?", [$id]);
    $inq = DB::fetch("SELECT * FROM inquiries WHERE id = ?", [$id]);
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-primary mb-0">Inquiry Message Details</h4>
    <a href="<?= ADMIN_URL ?>/inquiries.php" class="btn btn-outline-secondary rounded-pill btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Inquiries
    </a>
</div>

<div class="admin-card p-4 max-w-800">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
        <div>
            <h5 class="fw-bold text-primary mb-1"><?= e($inq['subject'] ? $inq['subject'] : 'General Export Contact') ?></h5>
            <small class="text-muted"><i class="bi bi-clock me-1"></i> Received on <?= date('F j, Y \a\t H:i', strtotime($inq['created_at'])) ?></small>
        </div>
        <a href="mailto:<?= e($inq['email']) ?>?subject=RE: <?= urlencode($inq['subject']) ?>" class="btn btn-success rounded-pill btn-sm">
            <i class="bi bi-reply-fill me-1"></i> Reply via Email
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <small class="text-muted d-block">Sender Name:</small>
            <strong class="text-dark fs-6"><?= e($inq['name']) ?></strong>
        </div>
        <div class="col-md-4">
            <small class="text-muted d-block">Email Address:</small>
            <strong class="text-dark fs-6"><?= e($inq['email']) ?></strong>
        </div>
        <div class="col-md-4">
            <small class="text-muted d-block">Phone / WhatsApp:</small>
            <strong class="text-dark fs-6"><?= e($inq['phone'] ? $inq['phone'] : 'N/A') ?></strong>
        </div>
    </div>

    <div class="p-4 bg-light rounded-3 border mb-4">
        <h6 class="fw-bold text-secondary mb-2">Message Body:</h6>
        <div class="text-dark leading-relaxed" style="white-space: pre-line;">
            <?= e($inq['message']) ?>
        </div>
    </div>

    <form action="<?= ADMIN_URL ?>/inquiries.php?action=delete&id=<?= $inq['id'] ?>" method="POST" class="d-inline">
        <input type="hidden" name="csrf_token" value="<?= CSRF_TOKEN ?>">
        <button type="submit" class="btn btn-outline-danger rounded-pill btn-delete-confirm">
            <i class="bi bi-trash me-1"></i> Delete Message
        </button>
    </form>
</div>

<?php 
else: 
    $inquiries = DB::fetchAll("SELECT * FROM inquiries ORDER BY id DESC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-primary mb-0">Customer Inquiries Center</h4>
</div>

<div class="admin-card p-4">
    <?php if (empty($inquiries)): ?>
        <p class="text-muted mb-0 py-3">No customer inquiries recorded yet.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Received Date</th>
                        <th>Sender Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inquiries as $inq): ?>
                        <tr class="<?= $inq['is_read'] ? '' : 'table-warning' ?>">
                            <td class="small text-muted"><?= date('M j, Y H:i', strtotime($inq['created_at'])) ?></td>
                            <td class="fw-bold text-primary"><?= e($inq['name']) ?></td>
                            <td class="small"><a href="mailto:<?= e($inq['email']) ?>"><?= e($inq['email']) ?></a></td>
                            <td class="small text-muted"><?= e($inq['phone'] ? $inq['phone'] : 'N/A') ?></td>
                            <td class="small fw-semibold"><?= e($inq['subject'] ? $inq['subject'] : 'General Contact') ?></td>
                            <td>
                                <?php if ($inq['is_read']): ?>
                                    <span class="badge bg-secondary-subtle text-secondary border">Read</span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger">Unread</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= ADMIN_URL ?>/inquiries.php?action=view&id=<?= $inq['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Read
                                </a>

                                <form action="<?= ADMIN_URL ?>/inquiries.php?action=delete&id=<?= $inq['id'] ?>" method="POST" class="d-inline">
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
    <?php endif; ?>
</div>

<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
