<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing & Payments - San Miguel HMS</title>
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

        .generate-bill-btn {
            background: #2563eb;
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

        .generate-bill-btn:hover {
            background: #1d4ed8;
        }

        /* Page Content */
        .page-content {
            padding: 30px;
        }

        /* Summary Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }

        .stat-icon.revenue { background: #22c55e; }
        .stat-icon.pending { background: #f59e0b; }
        .stat-icon.overdue { background: #ef4444; }
        .stat-icon.collection { background: #2563eb; }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .stat-detail {
            font-size: 14px;
            color: #64748b;
        }

        /* Main Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .panel {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .panel-header {
            padding: 20px;
            border-bottom: 1px solid #ecf0f1;
        }

        .panel-title {
            font-size: 18px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 16px;
        }

        .search-filter {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }

        .search-bar {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
        }

        .filter-dropdown {
            padding: 8px 12px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            min-width: 120px;
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
        }

        .bills-table {
            width: 100%;
            border-collapse: collapse;
        }

        .bills-table th {
            background: #f8fafc;
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        .bills-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }

        .bill-id {
            font-weight: 600;
            color: #1f2937;
        }

        .patient-info {
            display: flex;
            flex-direction: column;
        }

        .patient-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .service-type {
            font-size: 12px;
            color: #6b7280;
        }

        .amount {
            font-weight: 600;
            color: #1f2937;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            display: inline-block;
        }

        .status-paid { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-overdue { background: #fee2e2; color: #991b1b; }
        .status-partial { background: #fef3c7; color: #92400e; }

        .due-date {
            color: #6b7280;
            font-size: 14px;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            padding: 6px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: opacity 0.3s ease;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-view { background: #3b82f6; color: white; }
        .btn-download { background: #10b981; color: white; }
        .btn-edit { background: #f59e0b; color: white; }

        .btn-action:hover {
            opacity: 0.8;
        }

        /* Recent Payments */
        .payments-list {
            padding: 0 20px 20px;
        }

        .payment-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .payment-item:last-child {
            border-bottom: none;
        }

        .payment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #eef2ff;
            display: grid;
            place-items: center;
            color: #2563eb;
            font-weight: 800;
            font-size: 16px;
        }

        .payment-info {
            flex: 1;
        }

        .payment-patient {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .payment-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .payment-amount {
            font-weight: 600;
            color: #1f2937;
        }

        .payment-time {
            font-size: 12px;
            color: #6b7280;
        }

        .payment-method {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .method-cash { background: #dcfce7; color: #166534; }
        .method-card { background: #dbeafe; color: #1e40af; }
        .method-insurance { background: #fef3c7; color: #92400e; }
        .method-transfer { background: #dcfce7; color: #166534; }

        .view-all-link {
            padding: 16px 20px;
            text-align: center;
            border-top: 1px solid #ecf0f1;
        }

        .view-all-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .view-all-link a:hover {
            text-decoration: underline;
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

            .content-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .search-filter {
                flex-direction: column;
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
                    <h1>Billing & Payments</h1>
                    <div class="header-subtitle">Manage billing, invoices and payment tracking</div>
                </div>
                <a href="<?= site_url('billing/generate') ?>" class="generate-bill-btn">
                    <span>➕</span> Generate Bill
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
                        <div class="stat-value">₱2,847,500</div>
                        <div class="stat-detail">+12% from last month</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Pending Bills</span>
                            <div class="stat-icon pending">📄</div>
                        </div>
                        <div class="stat-value">₱458,000</div>
                        <div class="stat-detail">23 invoices</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Overdue</span>
                            <div class="stat-icon overdue">⚠️</div>
                        </div>
                        <div class="stat-value">₱85,000</div>
                        <div class="stat-detail">5 overdue bills</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Today's Collection</span>
                            <div class="stat-icon collection">👁️</div>
                        </div>
                        <div class="stat-value">₱125,000</div>
                        <div class="stat-detail">45 payments</div>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="content-grid">
                    <!-- Recent Bills Panel -->
                    <div class="panel">
                        <div class="panel-header">
                            <h2 class="panel-title">Recent Bills</h2>
                            <div class="search-filter">
                                <input type="text" class="search-bar" placeholder="Search bills...">
                                <select class="filter-dropdown">
                                    <option>All Status</option>
                                    <option>Paid</option>
                                    <option>Pending</option>
                                    <option>Overdue</option>
                                    <option>Partial</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="table-container">
                            <table class="bills-table">
                                <thead>
                                    <tr>
                                        <th>BILL ID</th>
                                        <th>PATIENT</th>
                                        <th>AMOUNT</th>
                                        <th>STATUS</th>
                                        <th>DUE DATE</th>
                                        <th>ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="bill-id">B001</td>
                                        <td>
                                            <div class="patient-info">
                                                <div class="patient-name">Juan Dela Cruz</div>
                                                <div class="service-type">Consultation</div>
                                            </div>
                                        </td>
                                        <td class="amount">₱15,000</td>
                                        <td><span class="status-badge status-paid">Paid</span></td>
                                        <td class="due-date">2024-01-20</td>
                                        <td class="actions">
                                            <button class="btn-action btn-view" title="View">👁️</button>
                                            <button class="btn-action btn-download" title="Download">📥</button>
                                            <button class="btn-action btn-edit" title="Edit">✏️</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bill-id">B002</td>
                                        <td>
                                            <div class="patient-info">
                                                <div class="patient-name">Maria Santos</div>
                                                <div class="service-type">Surgery</div>
                                            </div>
                                        </td>
                                        <td class="amount">₱25,000</td>
                                        <td><span class="status-badge status-pending">Pending</span></td>
                                        <td class="due-date">2024-01-21</td>
                                        <td class="actions">
                                            <button class="btn-action btn-view" title="View">👁️</button>
                                            <button class="btn-action btn-download" title="Download">📥</button>
                                            <button class="btn-action btn-edit" title="Edit">✏️</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bill-id">B003</td>
                                        <td>
                                            <div class="patient-info">
                                                <div class="patient-name">Pedro Garcia</div>
                                                <div class="service-type">Laboratory</div>
                                            </div>
                                        </td>
                                        <td class="amount">₱8,500</td>
                                        <td><span class="status-badge status-overdue">Overdue</span></td>
                                        <td class="due-date">2024-01-17</td>
                                        <td class="actions">
                                            <button class="btn-action btn-view" title="View">👁️</button>
                                            <button class="btn-action btn-download" title="Download">📥</button>
                                            <button class="btn-action btn-edit" title="Edit">✏️</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bill-id">B004</td>
                                        <td>
                                            <div class="patient-info">
                                                <div class="patient-name">Ana Rodriguez</div>
                                                <div class="service-type">Emergency</div>
                                            </div>
                                        </td>
                                        <td class="amount">₱12,000</td>
                                        <td><span class="status-badge status-paid">Paid</span></td>
                                        <td class="due-date">2024-01-20</td>
                                        <td class="actions">
                                            <button class="btn-action btn-view" title="View">👁️</button>
                                            <button class="btn-action btn-download" title="Download">📥</button>
                                            <button class="btn-action btn-edit" title="Edit">✏️</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bill-id">B005</td>
                                        <td>
                                            <div class="patient-info">
                                                <div class="patient-name">Carlos Mendoza</div>
                                                <div class="service-type">Pharmacy</div>
                                            </div>
                                        </td>
                                        <td class="amount">₱18,500</td>
                                        <td><span class="status-badge status-partial">Partial</span></td>
                                        <td class="due-date">2024-01-19</td>
                                        <td class="actions">
                                            <button class="btn-action btn-view" title="View">👁️</button>
                                            <button class="btn-action btn-download" title="Download">📥</button>
                                            <button class="btn-action btn-edit" title="Edit">✏️</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Recent Payments Panel -->
                    <div class="panel">
                        <div class="panel-header">
                            <h2 class="panel-title">Recent Payments</h2>
                        </div>
                        
                        <div class="payments-list">
                            <div class="payment-item">
                                <div class="payment-avatar">J</div>
                                <div class="payment-info">
                                    <div class="payment-patient">Juan Dela Cruz</div>
                                    <div class="payment-details">
                                        <span class="payment-amount">₱15,000</span>
                                        <span class="payment-time">2024-01-15 14:30</span>
                                    </div>
                                </div>
                                <span class="payment-method method-cash">Cash</span>
                            </div>
                            
                            <div class="payment-item">
                                <div class="payment-avatar">A</div>
                                <div class="payment-info">
                                    <div class="payment-patient">Ana Rodriguez</div>
                                    <div class="payment-details">
                                        <span class="payment-amount">₱12,000</span>
                                        <span class="payment-time">2024-01-15 11:20</span>
                                    </div>
                                </div>
                                <span class="payment-method method-card">Card</span>
                            </div>
                            
                            <div class="payment-item">
                                <div class="payment-avatar">C</div>
                                <div class="payment-info">
                                    <div class="payment-patient">Carlos Mendoza</div>
                                    <div class="payment-details">
                                        <span class="payment-amount">₱10,000</span>
                                        <span class="payment-time">2024-01-14 16:45</span>
                                    </div>
                                </div>
                                <span class="payment-method method-insurance">Insurance</span>
                            </div>
                            
                            <div class="payment-item">
                                <div class="payment-avatar">S</div>
                                <div class="payment-info">
                                    <div class="payment-patient">Sofia Lopez</div>
                                    <div class="payment-details">
                                        <span class="payment-amount">₱7,500</span>
                                        <span class="payment-time">2024-01-14 09:15</span>
                                    </div>
                                </div>
                                <span class="payment-method method-transfer">Bank Transfer</span>
                            </div>
                        </div>
                        
                        <div class="view-all-link">
                            <a href="<?= site_url('billing/payments') ?>">View All Payments</a>
                        </div>
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
            const rows = document.querySelectorAll('.bills-table tbody tr');
            
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
            const rows = document.querySelectorAll('.bills-table tbody tr');
            
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
                const billId = row.querySelector('.bill-id').textContent;
                alert(`View bill ${billId}`);
            });
        });

        document.querySelectorAll('.btn-download').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const billId = row.querySelector('.bill-id').textContent;
                alert(`Download bill ${billId}`);
            });
        });

        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const billId = row.querySelector('.bill-id').textContent;
                alert(`Edit bill ${billId}`);
            });
        });
    </script>
</body>
</html>
