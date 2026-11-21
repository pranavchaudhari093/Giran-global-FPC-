/**
 * GIRNA GLOBAL - Admin Panel JavaScript Helper
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Image Upload Live Preview
    const fileInputs = document.querySelectorAll('input[type="file"][data-preview]');
    fileInputs.forEach(input => {
        input.addEventListener('change', (e) => {
            const previewTargetId = input.getAttribute('data-preview');
            const previewElem = document.getElementById(previewTargetId);
            if (previewElem && input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (evt) => {
                    previewElem.src = evt.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    });

    // 2. Delete Confirmation Handler
    const deleteBtns = document.querySelectorAll('.btn-delete-confirm');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            if (!confirm('Are you sure you want to delete this record? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });

    // 3. Dynamic Product Specification Rows Adder
    const addSpecBtn = document.getElementById('addSpecRowBtn');
    const specContainer = document.getElementById('specRowsContainer');

    if (addSpecBtn && specContainer) {
        addSpecBtn.addEventListener('click', () => {
            const row = document.createElement('div');
            row.className = 'row g-2 mb-2 spec-row align-items-center';
            row.innerHTML = `
                <div class="col-5">
                    <input type="text" name="spec_keys[]" class="form-control" placeholder="Key (e.g. Calibration)">
                </div>
                <div class="col-6">
                    <input type="text" name="spec_values[]" class="form-control" placeholder="Value (e.g. 39mm to 46mm)">
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-spec-btn"><i class="bi bi-trash"></i></button>
                </div>
            `;
            specContainer.appendChild(row);
        });

        specContainer.addEventListener('click', (e) => {
            if (e.target.closest('.remove-spec-btn')) {
                e.target.closest('.spec-row').remove();
            }
        });
    }
});
