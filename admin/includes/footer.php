<?php
/**
 * Admin Panel - Footer Component
 */
?>
        </div> <!-- End .admin-content -->
    </div> <!-- End .admin-main -->
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Admin JS -->
<script src="<?= SITE_URL ?>/assets/js/admin.js"></script>

<script>
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const adminSidebar = document.getElementById('adminSidebar');
    if (sidebarToggleBtn && adminSidebar) {
        sidebarToggleBtn.addEventListener('click', () => {
            adminSidebar.classList.toggle('open');
        });
    }
</script>

</body>
</html>
