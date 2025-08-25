<?php echo view('auth/partials/header', ['title' => 'View Bill - ' . $bill['bill_id']]); ?>

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

    .bill-container {
        max-width: 800px;
        margin: 0 auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .bill-header {
        background: #2563eb;
        color: #fff;
        padding: 30px;
        text-align: center;
    }

    .bill-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .bill-subtitle {
        font-size: 16px;
        opacity: 0.9;
    }

    .bill-content {
        padding: 40px;
    }

    .bill-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 40px;
    }

    .info-section h3 {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 16px;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 8px;
    }

    .info-item {
        margin-bottom: 12px;
    }

    .info-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 4px;
    }

    .info-value {
        color: #6b7280;
    }

    .services-section {
        margin-bottom: 40px;
    }

    .services-section h3 {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 16px;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 8px;
    }

    .services-list {
        background: #f9fafb;
        padding: 20px;
        border-radius: 8px;
        border-left: 4px solid #2563eb;
    }

    .services-list p {
        color: #374151;
        font-size: 16px;
    }

    .bill-summary {
        background: #f8fafc;
        padding: 24px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .summary-row:last-child {
        border-bottom: none;
        font-weight: 700;
        font-size: 18px;
        color: #1f2937;
        border-top: 2px solid #e5e7eb;
        padding-top: 16px;
        margin-top: 8px;
    }

    .summary-label {
        color: #374151;
    }

    .summary-value {
        color: #1f2937;
        font-weight: 500;
    }

    .bill-actions {
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

    .btn-print {
        background: #10b981;
        color: #fff;
    }

    .btn-print:hover {
        background: #059669;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-paid { background: #dcfce7; color: #166534; }
    .status-overdue { background: #fecaca; color: #dc2626; }
    .status-partial { background: #dbeafe; color: #1d4ed8; }

    @media print {
        body { background: #fff; }
        .sidebar { display: none; }
        .main-content { margin-left: 0; }
        .bill-container { box-shadow: none; margin: 0; }
        .bill-actions { display: none; }
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
        .bill-info {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container">
    <!-- Sidebar -->
    <?php echo view('auth/partials/sidebar'); ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="bill-container">
            <div class="bill-header">
                <h1 class="bill-title"><?= esc($bill['bill_id']) ?></h1>
                <p class="bill-subtitle">Hospital Bill</p>
            </div>

            <div class="bill-content">
                <div class="bill-info">
                    <div class="info-section">
                        <h3>Patient Information</h3>
                        <div class="info-item">
                            <div class="info-label">Name</div>
                            <div class="info-value"><?= esc($bill['patient_name'] ?: ($bill['first_name'] . ' ' . $bill['last_name'])) ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Phone</div>
                            <div class="info-value"><?= esc($bill['phone'] ?? 'N/A') ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?= esc($bill['email'] ?? 'N/A') ?></div>
                        </div>
                        <?php if (!empty($bill['address'])): ?>
                        <div class="info-item">
                            <div class="info-label">Address</div>
                            <div class="info-value"><?= esc($bill['address']) ?></div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="info-section">
                        <h3>Bill Information</h3>
                        <div class="info-item">
                            <div class="info-label">Bill Date</div>
                            <div class="info-value"><?= date('F j, Y', strtotime($bill['bill_date'])) ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Due Date</div>
                            <div class="info-value"><?= date('F j, Y', strtotime($bill['due_date'])) ?></div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                <span class="status-badge status-<?= strtolower($bill['status']) ?>">
                                    <?= esc($bill['status']) ?>
                                </span>
                            </div>
                        </div>
                        <?php if (!empty($bill['payment_method'])): ?>
                        <div class="info-item">
                            <div class="info-label">Payment Method</div>
                            <div class="info-value"><?= esc($bill['payment_method']) ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($bill['insurance_provider'])): ?>
                        <div class="info-item">
                            <div class="info-label">Insurance Provider</div>
                            <div class="info-value"><?= esc($bill['insurance_provider']) ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="services-section">
                    <h3>Services</h3>
                    <div class="services-list">
                        <p><?= esc($bill['services'] ?: 'Medical Services') ?></p>
                    </div>
                </div>

                <div class="bill-summary">
                    <h3>Bill Summary</h3>
                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value">₱<?= number_format($bill['subtotal'], 2) ?></span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Tax</span>
                        <span class="summary-value">₱<?= number_format($bill['tax'], 2) ?></span>
                    </div>
                    <?php if ($bill['discount'] > 0): ?>
                    <div class="summary-row">
                        <span class="summary-label">Discount</span>
                        <span class="summary-value">-₱<?= number_format($bill['discount'], 2) ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="summary-row">
                        <span class="summary-label">Total Amount</span>
                        <span class="summary-value">₱<?= number_format($bill['total_amount'], 2) ?></span>
                    </div>
                </div>

                <?php if (!empty($bill['notes'])): ?>
                <div class="services-section">
                    <h3>Notes</h3>
                    <div class="services-list">
                        <p><?= esc($bill['notes']) ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <div class="bill-actions">
                    <a href="<?= site_url('billing/edit/' . $bill['bill_id']) ?>" class="btn btn-primary">
                        ✏️ Edit Bill
                    </a>
                    <a href="<?= site_url('billing/download/' . $bill['bill_id']) ?>" class="btn btn-print">
                        📥 Download
                    </a>
                    <a href="<?= site_url('billing') ?>" class="btn btn-secondary">
                        ← Back to Billing
                    </a>
                    <button onclick="window.print()" class="btn btn-print">
                        🖨️ Print
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo view('auth/partials/footer'); ?>
