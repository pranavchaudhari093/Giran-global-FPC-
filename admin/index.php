<?php
/**
 * Admin Panel - Dashboard Index
 */

$adminTitle = "Dashboard Overview";

require_once __DIR__ . '/includes/header.php';

// Calculate Real-Time KPIs
$totalProducts = DB::count("SELECT COUNT(*) FROM products");
$totalServices = DB::count("SELECT COUNT(*) FROM services");
$totalClients = DB::count("SELECT COUNT(*) FROM clients");
$totalGallery = DB::count("SELECT COUNT(*) FROM gallery");
$totalInquiries = DB::count("SELECT COUNT(*) FROM inquiries");
$unreadInquiries = DB::count("SELECT COUNT(*) FROM inquiries WHERE is_read = 0");

// Recent Inquiries
$recentInquiries = DB::fetchAll("SELECT * FROM inquiries ORDER BY id DESC LIMIT 5");
?>

<!-- KPI Stat Cards -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="dash-card">
            <div class="dash-icon bg-success-subtle text-success">
                <i class="bi bi-box-seam"></i>
            </div>
            <div>
                <h3 class="fw-bold text-dark mb-0"><?= $totalProducts ?></h3>
                <span class="text-muted small">Total Products</span>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="dash-card">
            <div class="dash-icon bg-warning-subtle text-warning">
                <i class="bi bi-gear-wide-connected"></i>
            </div>
            <div>
                <h3 class="fw-bold text-dark mb-0"><?= $totalServices ?></h3>
                <span class="text-muted small">Total Services</span>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="dash-card">
            <div class="dash-icon bg-primary-subtle text-primary">
                <i class="bi bi-buildings"></i>
            </div>
            <div>
                <h3 class="fw-bold text-dark mb-0"><?= $totalClients ?></h3>
                <span class="text-muted small">Global Clients</span>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="dash-card">
            <div class="dash-icon bg-danger-subtle text-danger">
                <i class="bi bi-envelope-paper"></i>
            </div>
            <div>
                <h3 class="fw-bold text-dark mb-0"><?= $unreadInquiries ?></h3>
                <span class="text-muted small">Unread Inquiries</span>
            </div>
        </div>
    </div>
</div>

<!-- Quick Action Shortcuts -->
<div class="admin-card p-4 mb-4">
    <h5 class="fw-bold text-primary mb-3"><i class="bi bi-lightning-charge text-gold me-2"></i> Quick Manager Shortcuts</h5>
    <div class="d-flex gap-3 flex-wrap">
        <a href="<?= ADMIN_URL ?>/products.php?action=add" class="btn btn-outline-success rounded-pill">
            <i class="bi bi-plus-circle me-1"></i> Add New Product
        </a>
        <a href="<?= ADMIN_URL ?>/services.php?action=add" class="btn btn-outline-warning text-dark rounded-pill">
            <i class="bi bi-plus-circle me-1"></i> Add New Service
        </a>
        <a href="<?= ADMIN_URL ?>/gallery.php" class="btn btn-outline-primary rounded-pill">
            <i class="bi bi-upload me-1"></i> Upload Gallery Photos
        </a>
        <a href="<?= ADMIN_URL ?>/settings.php" class="btn btn-outline-secondary rounded-pill">
            <i class="bi bi-sliders me-1"></i> Site Settings & Logo
        </a>
    </div>
</div>

<!-- Recent Inquiries Table -->
<div class="admin-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-primary mb-0"><i class="bi bi-clock-history me-2"></i> Recent Customer Inquiries</h5>
        <a href="<?= ADMIN_URL ?>/inquiries.php" class="btn btn-sm btn-link text-primary text-decoration-none">View All (<?= $totalInquiries ?>) &rarr;</a>
    </div>

    <?php if (empty($recentInquiries)): ?>
        <p class="text-muted mb-0 py-3">No customer inquiries submitted yet.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recentInquiries as $inq): ?>
                        <tr>
                            <td class="small text-muted"><?= date('M j, Y H:i', strtotime($inq['created_at'])) ?></td>
                            <td class="fw-semibold text-dark"><?= e($inq['name']) ?></td>
                            <td><a href="mailto:<?= e($inq['email']) ?>"><?= e($inq['email']) ?></a></td>
                            <td class="small"><?= e($inq['subject'] ? $inq['subject'] : 'General Contact') ?></td>
                            <td>
                                <?php if ($inq['is_read']): ?>
                                    <span class="badge bg-secondary-subtle text-secondary border">Read</span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger border border-danger">New Inquiry</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= ADMIN_URL ?>/inquiries.php?id=<?= $inq['id'] ?>" class="btn btn-sm btn-outline-dark">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
