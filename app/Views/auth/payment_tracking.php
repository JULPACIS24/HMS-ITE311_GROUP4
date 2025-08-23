<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Tracking - San Miguel HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/appointments.css') ?>">
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

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-icon {
            width: 32px;
            height: 32px;
            background: #2563eb;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            color: #fff;
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }

        .sidebar-subtitle {
            font-size: 12px;
            color: #64748b;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            display: block;
            padding: 12px 20px;
            color: #334155;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-item:hover {
            background-color: #f1f5f9;
            color: #0f172a;
            border-left-color: #2563eb;
        }

        .menu-item.active {
            background-color: #eef2ff;
            color: #1d4ed8;
            border-left-color: #2563eb;
        }

        .menu-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
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

        .header-actions {
            display: flex;
            gap: 12px;
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

        .record-payment-btn {
            background: #22c55e;
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

        .record-payment-btn:hover {
            background: #16a34a;
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
            padding: 24px;
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
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }

        .stat-icon.revenue { background: #22c55e; }
        .stat-icon.pending { background: #f59e0b; }
        .stat-icon.overdue { background: #ef4444; }
        .stat-icon.invoices { background: #2563eb; }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
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
            padding: 8px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 14px;
            transition: opacity 0.3s ease;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-view { background: #3b82f6; color: white; }
        .btn-payment { background: #22c55e; color: white; }
        .btn-print { background: #8b5cf6; color: white; }
        .btn-email { background: #f59e0b; color: white; }

        .btn-action:hover {
            opacity: 0.8;
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

            .header-actions {
                flex-direction: column;
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php echo view('auth/partials/sidebar'); ?>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <div>
                    <h1>Payment Tracking</h1>
                    <div class="header-subtitle">Monitor payments and outstanding balances</div>
                </div>
                <div class="header-actions">
                    <a href="<?= site_url('billing') ?>" class="back-btn">
                        <span>←</span> Back to Billing
                    </a>
                    <a href="<?= site_url('billing/record-payment') ?>" class="record-payment-btn">
                        <span>➕</span> Record Payment
                    </a>
                </div>
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
                        <div class="stat-value">₱25,000</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Pending Amount</span>
                            <div class="stat-icon pending">⏰</div>
                        </div>
                        <div class="stat-value">₱70,500</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Overdue Bills</span>
                            <div class="stat-icon overdue">🚨</div>
                        </div>
                        <div class="stat-value">1</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Total Invoices</span>
                            <div class="stat-icon invoices">📄</div>
                        </div>
                        <div class="stat-value">5</div>
                    </div>
                </div>

                <!-- Search and Filter Section -->
                <div class="search-filter-section">
                    <div class="search-container">
                        <span class="search-icon">🔍</span>
                        <input type="text" class="search-bar" placeholder="Search by patient name, invoice ID...">
                    </div>
                    <select class="filter-dropdown">
                        <option>All Status</option>
                        <option>Paid</option>
                        <option>Partial</option>
                        <option>Unpaid</option>
                        <option>Processing</option>
                    </select>
                    <button class="export-btn">
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
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="invoice-details">
                                            <div class="invoice-id">INV001</div>
                                            <div class="invoice-description">Consultation, Laboratory Tests</div>
                                            <div class="insurance-info">PhilHealth - 3000</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-name">Juan Dela Cruz</div>
                                            <div class="patient-id">P001</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="amount-details">
                                            <div class="total-amount">₱15,000</div>
                                            <div class="paid-amount">Paid: ₱15,000</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="payment-status">
                                            <span class="status-badge status-paid">Paid</span>
                                            <div class="payment-method">Cash</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            <div class="due-date">2024-01-10</div>
                                            <div class="paid-date">Paid: 2024-01-15</div>
                                        </div>
                                    </td>
                                    <td class="actions">
                                        <button class="btn-action btn-view" title="View">👁️</button>
                                        <button class="btn-action btn-payment" title="Payment">💰</button>
                                        <button class="btn-action btn-print" title="Print">🖨️</button>
                                        <button class="btn-action btn-email" title="Email">✉️</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="invoice-details">
                                            <div class="invoice-id">INV002</div>
                                            <div class="invoice-description">Surgery, Room Charges</div>
                                            <div class="insurance-info">HMO Coverage - 5000</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-name">Maria Santos</div>
                                            <div class="patient-id">P002</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="amount-details">
                                            <div class="total-amount">₱25,000</div>
                                            <div class="paid-amount">Paid: ₱10,000</div>
                                            <div class="balance-amount">Balance: ₱15,000</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="payment-status">
                                            <span class="status-badge status-partial">Partial</span>
                                            <div class="payment-method">Credit Card</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            <div class="due-date">2024-01-20</div>
                                            <div class="paid-date">Paid: 2024-01-14</div>
                                        </div>
                                    </td>
                                    <td class="actions">
                                        <button class="btn-action btn-view" title="View">👁️</button>
                                        <button class="btn-action btn-payment" title="Payment">💰</button>
                                        <button class="btn-action btn-print" title="Print">🖨️</button>
                                        <button class="btn-action btn-email" title="Email">✉️</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="invoice-details">
                                            <div class="invoice-id">INV003</div>
                                            <div class="invoice-description">Emergency Care, Medicines</div>
                                            <div class="insurance-info">None</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-name">Pedro Garcia</div>
                                            <div class="patient-id">P003</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="amount-details">
                                            <div class="total-amount">₱8,500</div>
                                            <div class="paid-amount">Paid: ₱0</div>
                                            <div class="balance-amount">Balance: ₱8,500</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="payment-status">
                                            <span class="status-badge status-unpaid">Unpaid</span>
                                            <div class="payment-method">Pending</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            <div class="due-date">2024-01-25</div>
                                        </div>
                                    </td>
                                    <td class="actions">
                                        <button class="btn-action btn-view" title="View">👁️</button>
                                        <button class="btn-action btn-payment" title="Payment">💰</button>
                                        <button class="btn-action btn-print" title="Print">🖨️</button>
                                        <button class="btn-action btn-email" title="Email">✉️</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="invoice-details">
                                            <div class="invoice-id">INV004</div>
                                            <div class="invoice-description">Physical Therapy, X-Ray</div>
                                            <div class="insurance-info">Medicare - Processing</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="patient-info">
                                            <div class="patient-name">Ana Rodriguez</div>
                                            <div class="patient-id">P004</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="amount-details">
                                            <div class="total-amount">₱12,000</div>
                                            <div class="paid-amount">Paid: ₱0</div>
                                            <div class="balance-amount">Balance: ₱12,000</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="payment-status">
                                            <span class="status-badge status-processing">Processing</span>
                                            <div class="payment-method">Insurance Processing</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            <div class="due-date">2024-01-18</div>
                                        </div>
                                    </td>
                                    <td class="actions">
                                        <button class="btn-action btn-view" title="View">👁️</button>
                                        <button class="btn-action btn-payment" title="Payment">💰</button>
                                        <button class="btn-action btn-print" title="Print">🖨️</button>
                                        <button class="btn-action btn-email" title="Email">✉️</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Highlight active menu item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                const href = item.getAttribute('href') || '';
                if (href && currentPath.includes(href)) {
                    item.classList.add('active');
                }
            });
        });

        // Search functionality
        document.querySelector('.search-bar').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.payment-table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Filter functionality
        document.querySelector('.filter-dropdown').addEventListener('change', function(e) {
            const filterValue = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.payment-table tbody tr');
            
            rows.forEach(row => {
                const status = row.querySelector('.status-badge').textContent.toLowerCase();
                if (filterValue === 'all status' || status === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Action button handlers
        document.querySelectorAll('.btn-view').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const invoiceId = row.querySelector('.invoice-id').textContent;
                alert(`View invoice ${invoiceId}`);
            });
        });

        document.querySelectorAll('.btn-payment').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const invoiceId = row.querySelector('.invoice-id').textContent;
                alert(`Record payment for ${invoiceId}`);
            });
        });

        document.querySelectorAll('.btn-print').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const invoiceId = row.querySelector('.invoice-id').textContent;
                alert(`Print invoice ${invoiceId}`);
            });
        });

        document.querySelectorAll('.btn-email').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const invoiceId = row.querySelector('.invoice-id').textContent;
                alert(`Email invoice ${invoiceId}`);
            });
        });

        // Export functionality
        document.querySelector('.export-btn').addEventListener('click', function() {
            alert('Exporting payment records...');
        });
    </script>
</body>
</html>
