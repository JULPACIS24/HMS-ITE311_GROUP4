<?php echo view('auth/partials/header', ['title' => 'Edit Bill - ' . $bill['bill_id']]); ?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        background-color: #f5f7fa;
        line-height: 1.6;
    }

    .container {
        display: flex;
        min-height: 100vh;
    }

    .sidebar {
        width: 250px;
        background: #fff;
        color: #0f172a;
        position: fixed;
        height: 100vh;
        overflow-y: auto;
        z-index: 1000;
        border-right: 1px solid #e5e7eb;
    }

    .main-content {
        flex: 1;
        margin-left: 250px;
        padding: 20px;
    }

    .form-container {
        max-width: 800px;
        margin: 0 auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .form-header {
        background: #2563eb;
        color: #fff;
        padding: 30px;
        text-align: center;
    }

    .form-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .form-subtitle {
        font-size: 16px;
        opacity: 0.9;
    }

    .form-content {
        padding: 40px;
    }

    .form-section {
        margin-bottom: 30px;
    }

    .form-section h3 {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 16px;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 8px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.2s;
        background: #fff;
    }

    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-actions {
        display: flex;
        gap: 16px;
        justify-content: center;
        margin-top: 40px;
        padding-top: 30px;
        border-top: 1px solid #e5e7eb;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #2563eb;
        color: #fff;
    }

    .btn-primary:hover {
        background: #1d4ed8;
    }

    .btn-secondary {
        background: #6b7280;
        color: #fff;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .btn-danger {
        background: #ef4444;
        color: #fff;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .alert {
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border-color: #bbf7d0;
    }

    .alert-error {
        background: #fecaca;
        color: #dc2626;
        border-color: #fca5a5;
    }

    .amount-preview {
        background: #f8fafc;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        margin-top: 20px;
    }

    .amount-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .amount-row:last-child {
        border-bottom: none;
        font-weight: 700;
        font-size: 18px;
        color: #1f2937;
        border-top: 2px solid #e5e7eb;
        padding-top: 16px;
        margin-top: 8px;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }
        .main-content {
            margin-left: 0;
        }
        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container">
    <!-- Sidebar -->
    <?php echo view('auth/partials/sidebar'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="form-container">
            <div class="form-header">
                <h1 class="form-title">Edit Bill</h1>
                <p class="form-subtitle"><?= esc($bill['bill_id']) ?></p>
            </div>

            <div class="form-content">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-error">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('billing/update/' . $bill['bill_id']) ?>" method="POST">
                    <div class="form-section">
                        <h3>Patient Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Patient</label>
                                <select name="patient_id" class="form-select" required>
                                    <option value="">Select Patient</option>
                                    <?php foreach ($patients as $patient): ?>
                                        <option value="<?= $patient['id'] ?>" <?= $patient['id'] == $bill['patient_id'] ? 'selected' : '' ?>>
                                            <?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Bill ID</label>
                                <input type="text" class="form-input" value="<?= esc($bill['bill_id']) ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Bill Details</h3>
                        <div class="form-group full-width">
                            <label class="form-label">Services</label>
                            <textarea name="services" class="form-textarea" placeholder="Enter services provided..." required><?= esc($bill['services']) ?></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Bill Date</label>
                                <input type="date" name="bill_date" class="form-input" value="<?= $bill['bill_date'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date" class="form-input" value="<?= $bill['due_date'] ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Financial Details</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Subtotal</label>
                                <input type="number" name="subtotal" class="form-input" step="0.01" min="0" value="<?= $bill['subtotal'] ?>" required onchange="calculateTotal()">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tax</label>
                                <input type="number" name="tax" class="form-input" step="0.01" min="0" value="<?= $bill['tax'] ?>" required onchange="calculateTotal()">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Discount</label>
                                <input type="number" name="discount" class="form-input" step="0.01" min="0" value="<?= $bill['discount'] ?>" onchange="calculateTotal()">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Total Amount</label>
                                <input type="number" name="total_amount" class="form-input" step="0.01" min="0" value="<?= $bill['total_amount'] ?>" required>
                            </div>
                        </div>

                        <div class="amount-preview">
                            <h4>Amount Preview</h4>
                            <div class="amount-row">
                                <span>Subtotal:</span>
                                <span id="preview-subtotal">₱<?= number_format($bill['subtotal'], 2) ?></span>
                            </div>
                            <div class="amount-row">
                                <span>Tax:</span>
                                <span id="preview-tax">₱<?= number_format($bill['tax'], 2) ?></span>
                            </div>
                            <div class="amount-row">
                                <span>Discount:</span>
                                <span id="preview-discount">-₱<?= number_format($bill['discount'], 2) ?></span>
                            </div>
                            <div class="amount-row">
                                <span>Total:</span>
                                <span id="preview-total">₱<?= number_format($bill['total_amount'], 2) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Insurance Information</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Insurance Provider</label>
                                <select name="insurance_provider" class="form-select">
                                    <option value="">No Insurance</option>
                                    <option value="PhilHealth" <?= $bill['insurance_provider'] === 'PhilHealth' ? 'selected' : '' ?>>PhilHealth</option>
                                    <option value="Maxicare" <?= $bill['insurance_provider'] === 'Maxicare' ? 'selected' : '' ?>>Maxicare</option>
                                    <option value="Intellicare" <?= $bill['insurance_provider'] === 'Intellicare' ? 'selected' : '' ?>>Intellicare</option>
                                    <option value="Other" <?= $bill['insurance_provider'] && !in_array($bill['insurance_provider'], ['PhilHealth', 'Maxicare', 'Intellicare']) ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Insurance Details</label>
                                <input type="text" name="insurance_details" class="form-input" value="<?= esc($bill['insurance_details']) ?>" placeholder="Policy number, member details, etc.">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Additional Information</h3>
                        <div class="form-group full-width">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-textarea" placeholder="Any additional notes..."><?= esc($bill['notes']) ?></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            💾 Update Bill
                        </button>
                        <a href="<?= site_url('billing/view/' . $bill['bill_id']) ?>" class="btn btn-secondary">
                            👁️ View Bill
                        </a>
                        <a href="<?= site_url('billing') ?>" class="btn btn-secondary">
                            ← Back to Billing
                        </a>
                        <button type="button" class="btn btn-danger" onclick="deleteBill('<?= $bill['bill_id'] ?>')">
                            🗑️ Delete Bill
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function calculateTotal() {
        const subtotal = parseFloat(document.querySelector('input[name="subtotal"]').value) || 0;
        const tax = parseFloat(document.querySelector('input[name="tax"]').value) || 0;
        const discount = parseFloat(document.querySelector('input[name="discount"]').value) || 0;
        
        const total = subtotal + tax - discount;
        
        document.querySelector('input[name="total_amount"]').value = total.toFixed(2);
        
        // Update preview
        document.getElementById('preview-subtotal').textContent = '₱' + subtotal.toFixed(2);
        document.getElementById('preview-tax').textContent = '₱' + tax.toFixed(2);
        document.getElementById('preview-discount').textContent = '-₱' + discount.toFixed(2);
        document.getElementById('preview-total').textContent = '₱' + total.toFixed(2);
    }

    function deleteBill(billId) {
        if (confirm(`Are you sure you want to delete bill ${billId}? This action cannot be undone.`)) {
            window.location.href = `<?= site_url('billing/delete/') ?>${billId}`;
        }
    }

    // Auto-calculate on page load
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotal();
    });
</script>

<?php echo view('auth/partials/footer'); ?>
