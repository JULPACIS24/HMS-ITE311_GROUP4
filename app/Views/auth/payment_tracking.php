<?php echo view('auth/partials/header', ['title' => 'Payment Tracking']); ?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        background-color: #f5f7fa;
        overflow-x: hidden;
    }

    .container {
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar Styles */
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

    /* Main Content */
    .main-content {
        flex: 1;
        margin-left: 250px;
        padding: 0;
    }

    /* Header */
    .header {
        background: white;
        padding: 20px 30px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header h1 {
        font-size: 24px;
        color: #0f172a;
        font-weight: 600;
    }

    .header-subtitle {
        color: #64748b;
        font-size: 14px;
        margin-top: 4px;
    }

    .back-btn {
        background: #6b7280;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.3s ease;
    }

    .back-btn:hover {
        background: #4b5563;
    }

    /* Page Content */
    .page-content {
        padding: 30px;
    }

    /* Summary Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: #2563eb;
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .stat-title {
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
    }

    .stat-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }

    .stat-icon.revenue { background: #22c55e; }
    .stat-icon.pending { background: #f59e0b; }
    .stat-icon.overdue { background: #ef4444; }
    .stat-icon.invoices { background: #2563eb; }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .stat-detail {
        font-size: 12px;
        color: #64748b;
    }

    /* Search and Filter Section */
    .search-filter-section {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        display: flex;
        gap: 16px;
        align-items: center;
    }

    .search-container {
        flex: 1;
        position: relative;
    }

    .search-bar {
        width: 100%;
        padding: 12px 16px 12px 44px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
    }

    .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .filter-dropdown {
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        min-width: 140px;
    }

    .export-btn {
        background: #2563eb;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.3s ease;
    }

    .export-btn:hover {
        background: #1d4ed8;
    }

    /* Payment Records Table */
    .payment-records {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .table-header {
        padding: 20px;
        border-bottom: 1px solid #ecf0f1;
    }

    .table-title {
        font-size: 18px;
        font-weight: 600;
        color: #0f172a;
    }

    .table-container {
        overflow-x: auto;
    }

    .payment-table {
        width: 100%;
        border-collapse: collapse;
    }

    .payment-table th {
        background: #f8fafc;
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        color: #374151;
        font-size: 14px;
        border-bottom: 1px solid #e5e7eb;
    }

    .payment-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
    }

    .invoice-details {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .invoice-id {
        font-weight: 600;
        color: #1f2937;
    }

    .invoice-description {
        font-size: 12px;
        color: #6b7280;
    }

    .insurance-info {
        font-size: 12px;
        color: #6b7280;
    }

    .patient-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .patient-name {
        font-weight: 600;
        color: #1f2937;
    }

    .patient-id {
        font-size: 12px;
        color: #6b7280;
    }

    .amount-details {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .total-amount {
        font-weight: 600;
        color: #1f2937;
    }

    .paid-amount {
        font-size: 12px;
        color: #16a34a;
    }

    .balance-amount {
        font-size: 12px;
        color: #dc2626;
    }

    .payment-status {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        display: inline-block;
        width: fit-content;
    }

    .status-paid { background: #dcfce7; color: #166534; }
    .status-partial { background: #fef3c7; color: #92400e; }
    .status-unpaid { background: #fee2e2; color: #991b1b; }
    .status-processing { background: #dbeafe; color: #1e40af; }

    .payment-method {
        font-size: 12px;
        color: #6b7280;
    }

    .date-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .due-date {
        color: #6b7280;
        font-size: 14px;
    }

    .paid-date {
        font-size: 12px;
        color: #16a34a;
    }

    .actions {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        transition: opacity 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-view { background: #3b82f6; color: white; }
    .btn-payment { background: #22c55e; color: white; }
    .btn-print { background: #8b5cf6; color: white; }
    .btn-email { background: #f59e0b; color: white; }

    .btn-action:hover {
        opacity: 0.8;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-state-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #374151;
    }

    .empty-state-subtitle {
        font-size: 14px;
        margin-bottom: 20px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }

        .main-content {
            margin-left: 0;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }

        .search-filter-section {
            flex-direction: column;
            align-items: stretch;
        }

        .table-container {
            overflow-x: auto;
        }
    }
</style>

<div class="container">
    <!-- Sidebar -->
    <?php echo view('auth/partials/sidebar'); ?>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div>
                <h1>Payment Tracking</h1>
                <div class="header-subtitle">Monitor all bills, payments, and outstanding balances</div>
            </div>
            <a href="<?= site_url('billing') ?>" class="back-btn">
                <span>←</span> Back to Billing
            </a>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            <!-- Summary Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Total Revenue</span>
                        <div class="stat-icon revenue">💰</div>
                    </div>
                    <div class="stat-value">₱<?= number_format($stats['total_revenue'] ?? 0, 2) ?></div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Pending Amount</span>
                        <div class="stat-icon pending">⏰</div>
                    </div>
                    <div class="stat-value">₱<?= number_format($stats['pending_amount'] ?? 0, 2) ?></div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Overdue Bills</span>
                        <div class="stat-icon overdue">🚨</div>
                    </div>
                    <div class="stat-value"><?= $stats['overdue_bills'] ?? 0 ?></div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Total Invoices</span>
                        <div class="stat-icon invoices">📄</div>
                    </div>
                    <div class="stat-value"><?= $stats['total_bills'] ?? 0 ?></div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="search-filter-section">
                <div class="search-container">
                    <span class="search-icon">🔍</span>
                    <input type="text" class="search-bar" id="searchBar" placeholder="Search by patient name, invoice ID...">
                </div>
                <select class="filter-dropdown" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="Paid">Paid</option>
                    <option value="Partial">Partial</option>
                    <option value="Unpaid">Unpaid</option>
                    <option value="Processing">Processing</option>
                </select>
                <button class="export-btn" onclick="exportData()">
                    <span>📥</span> Export
                </button>
            </div>

            <!-- Payment Records Table -->
            <div class="payment-records">
                <div class="table-header">
                    <h2 class="table-title">Payment Records</h2>
                </div>
                
                <div class="table-container">
                    <table class="payment-table">
                        <thead>
                            <tr>
                                <th>INVOICE DETAILS</th>
                                <th>PATIENT</th>
                                <th>AMOUNT</th>
                                <th>PAYMENT STATUS</th>
                                <th>DUE DATE</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody id="paymentTableBody">
                            <?php if (!empty($bills)): ?>
                                <?php foreach ($bills as $bill): ?>
                                    <tr data-status="<?= strtolower($bill['status']) ?>" 
                                        data-amount="<?= $bill['total_amount'] ?>"
                                        data-patient="<?= strtolower($bill['patient_name']) ?>"
                                        data-bill-id="<?= strtolower($bill['bill_id']) ?>">
                                        <td>
                                            <div class="invoice-details">
                                                <div class="invoice-id"><?= esc($bill['bill_id']) ?></div>
                                                <div class="invoice-description"><?= esc($bill['services'] ?? 'Medical Services') ?></div>
                                                <?php if (!empty($bill['insurance_provider'])): ?>
                                                    <div class="insurance-info"><?= esc($bill['insurance_provider']) ?> - <?= esc($bill['insurance_details'] ? json_decode($bill['insurance_details'], true)['philhealth_number'] ?? 'N/A' : 'N/A') ?></div>
                                                <?php else: ?>
                                                    <div class="insurance-info">None</div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="patient-info">
                                                <div class="patient-name"><?= esc($bill['patient_name']) ?></div>
                                                <div class="patient-id">P<?= str_pad($bill['patient_id'], 3, '0', STR_PAD_LEFT) ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="amount-details">
                                                <div class="total-amount">₱<?= number_format($bill['total_amount'], 2) ?></div>
                                                <?php if ($bill['status'] === 'Paid'): ?>
                                                    <div class="paid-amount">Paid: ₱<?= number_format($bill['total_amount'], 2) ?></div>
                                                <?php elseif ($bill['status'] === 'Partial'): ?>
                                                    <div class="paid-amount">Paid: ₱<?= number_format($bill['total_amount'] * 0.4, 2) ?></div>
                                                    <div class="balance-amount">Balance: ₱<?= number_format($bill['total_amount'] * 0.6, 2) ?></div>
                                                <?php else: ?>
                                                    <div class="paid-amount">Paid: ₱0</div>
                                                    <div class="balance-amount">Balance: ₱<?= number_format($bill['total_amount'], 2) ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="payment-status">
                                                <span class="status-badge status-<?= strtolower($bill['status']) ?>">
                                                    <?= esc($bill['status']) ?>
                                                </span>
                                                <div class="payment-method"><?= esc($bill['payment_method'] ?? 'Pending') ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="date-info">
                                                <div class="due-date"><?= date('Y-m-d', strtotime($bill['due_date'])) ?></div>
                                                <?php if ($bill['status'] === 'Paid'): ?>
                                                    <div class="paid-date">Paid: <?= date('Y-m-d', strtotime($bill['payment_date'] ?? $bill['created_at'])) ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="actions">
                                            <button class="btn-action btn-view" title="View" onclick="viewBill('<?= $bill['bill_id'] ?>')">👁️</button>
                                            <button class="btn-action btn-payment" title="Payment" onclick="recordPayment('<?= $bill['bill_id'] ?>')">💰</button>
                                            <button class="btn-action btn-print" title="Print" onclick="printBill('<?= $bill['bill_id'] ?>')">🖨️</button>
                                            <button class="btn-action btn-email" title="Email" onclick="emailBill('<?= $bill['bill_id'] ?>')">✉️</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">📋</div>
                                            <div class="empty-state-title">No payment records found</div>
                                            <div class="empty-state-subtitle">Generate your first bill to get started</div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    // Search and filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchBar = document.getElementById('searchBar');
        const statusFilter = document.getElementById('statusFilter');
        
        // Add event listeners
        [searchBar, statusFilter].forEach(element => {
            element.addEventListener('input', filterPayments);
            element.addEventListener('change', filterPayments);
        });
    });
    
    function filterPayments() {
        const searchTerm = document.getElementById('searchBar').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        
        const rows = document.querySelectorAll('#paymentTableBody tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            if (row.cells.length === 1) return; // Skip empty state row
            
            const status = row.dataset.status;
            const amount = parseFloat(row.dataset.amount);
            const patient = row.dataset.patient;
            const billId = row.dataset.billId;
            
            // Text search
            const matchesSearch = !searchTerm || 
                patient.includes(searchTerm) || 
                billId.includes(searchTerm) || 
                amount.toString().includes(searchTerm);
            
            // Status filter
            const matchesStatus = !statusFilter || status === statusFilter;
            
            // Show/hide row
            if (matchesSearch && matchesStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
    }
    
    // Payment action functions
    function viewBill(billId) {
        alert(`View bill ${billId} - This will open bill details`);
        // TODO: Implement bill viewing functionality
    }
    
    function recordPayment(billId) {
        alert(`Record payment for ${billId} - This will open payment form`);
        // TODO: Implement payment recording functionality
    }
    
    function printBill(billId) {
        alert(`Print bill ${billId} - This will generate printable version`);
        // TODO: Implement bill printing functionality
    }
    
    function emailBill(billId) {
        alert(`Email bill ${billId} - This will open email form`);
        // TODO: Implement bill emailing functionality
    }
    
    function exportData() {
        alert('Exporting payment records...');
        // TODO: Implement data export functionality
    }
</script>

<?php echo view('auth/partials/footer'); ?>
