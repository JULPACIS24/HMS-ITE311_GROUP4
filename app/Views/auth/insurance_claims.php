<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insurance Claims - San Miguel HMS</title>
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

        .submit-claim-btn {
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

        .submit-claim-btn:hover {
            background: #1d4ed8;
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

        .stat-icon.approved { background: #22c55e; }
        .stat-icon.pending { background: #f59e0b; }
        .stat-icon.rejected { background: #ef4444; }
        .stat-icon.rate { background: #2563eb; }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
        }

        /* Action Bar */
        .action-bar {
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

        /* Claims Table */
        .claims-table {
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

        .claims-table {
            width: 100%;
            border-collapse: collapse;
        }

        .claims-table th {
            background: #f8fafc;
            padding: 16px 20px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        .claims-table td {
            padding: 16px 20px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }

        .claim-details {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .claim-id {
            font-weight: 600;
            color: #1f2937;
        }

        .patient-name {
            font-weight: 600;
            color: #1f2937;
        }

        .claim-description {
            font-size: 12px;
            color: #6b7280;
        }

        .insurance-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .insurance-provider {
            font-weight: 600;
            color: #1f2937;
        }

        .policy-number {
            font-size: 12px;
            color: #6b7280;
        }

        .amount-details {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .claimed-amount {
            font-weight: 600;
            color: #1f2937;
        }

        .approved-amount {
            font-size: 12px;
            color: #16a34a;
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

        .status-approved { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-partial { background: #dbeafe; color: #1e40af; }
        .status-rejected { background: #fee2e2; color: #991b1b; }

        .date-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .submitted-date {
            color: #6b7280;
            font-size: 14px;
        }

        .processed-date {
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
        .btn-download { background: #10b981; color: white; }

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

            .action-bar {
                flex-direction: column;
                align-items: stretch;
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
                    <h1>Insurance Claims</h1>
                    <div class="header-subtitle">Manage and track insurance claim submissions</div>
                </div>
                <a href="<?= site_url('insurance/submit-claim') ?>" class="submit-claim-btn">
                    <span>➕</span> Submit New Claim
                </a>
            </header>

            <!-- Page Content -->
            <div class="page-content">
                <!-- Summary Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Total Approved</span>
                            <div class="stat-icon approved">💰</div>
                        </div>
                        <div class="stat-value">₱47,000</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Pending Claims</span>
                            <div class="stat-icon pending">⏰</div>
                        </div>
                        <div class="stat-value">₱8,500</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Rejected Claims</span>
                            <div class="stat-icon rejected">❌</div>
                        </div>
                        <div class="stat-value">₱5,500</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Approval Rate</span>
                            <div class="stat-icon rate">📊</div>
                        </div>
                        <div class="stat-value">85%</div>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="action-bar">
                    <div class="search-container">
                        <span class="search-icon">🔍</span>
                        <input type="text" class="search-bar" placeholder="Search claims...">
                    </div>
                    <select class="filter-dropdown">
                        <option>All Claims</option>
                        <option>Approved</option>
                        <option>Pending</option>
                        <option>Partial</option>
                        <option>Rejected</option>
                    </select>
                </div>

                <!-- Claims Table -->
                <div class="claims-table">
                    <div class="table-header">
                        <h2 class="table-title">Claims Table</h2>
                    </div>
                    
                    <div class="table-container">
                        <table class="claims-table">
                            <thead>
                                <tr>
                                    <th>CLAIM DETAILS</th>
                                    <th>INSURANCE INFO</th>
                                    <th>AMOUNT</th>
                                    <th>STATUS</th>
                                    <th>DATES</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="claim-details">
                                            <div class="claim-id">CLM-2024-001</div>
                                            <div class="patient-name">John Dela Cruz</div>
                                            <div class="claim-description">Consultation, Laboratory Tests, X-Ray</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="insurance-info">
                                            <div class="insurance-provider">PhilHealth</div>
                                            <div class="policy-number">PH-123456789</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="amount-details">
                                            <div class="claimed-amount">Claimed: ₱15,000</div>
                                            <div class="approved-amount">Approved: ₱12,000</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-approved">Approved</span>
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            <div class="submitted-date">Submitted: 2024-01-10</div>
                                            <div class="processed-date">Processed: 2024-01-14</div>
                                        </div>
                                    </td>
                                    <td class="actions">
                                        <a href="#" class="btn-action btn-view">View</a>
                                        <a href="#" class="btn-action btn-download">Download</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="claim-details">
                                            <div class="claim-id">CLM-2024-002</div>
                                            <div class="patient-name">Ana Rodriguez</div>
                                            <div class="claim-description">Pediatric Check-up, Vaccination</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="insurance-info">
                                            <div class="insurance-provider">Maxicare</div>
                                            <div class="policy-number">MC-987654321</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="amount-details">
                                            <div class="claimed-amount">Claimed: ₱8,500</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-pending">Pending</span>
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            <div class="submitted-date">Submitted: 2024-01-12</div>
                                        </div>
                                    </td>
                                    <td class="actions">
                                        <a href="#" class="btn-action btn-view">View</a>
                                        <a href="#" class="btn-action btn-download">Download</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="claim-details">
                                            <div class="claim-id">CLM-2024-003</div>
                                            <div class="patient-name">Carlos Martinez</div>
                                            <div class="claim-description">Surgery Consultation, Pre-operative Tests</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="insurance-info">
                                            <div class="insurance-provider">Intellicare</div>
                                            <div class="policy-number">IC-456789123</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="amount-details">
                                            <div class="claimed-amount">Claimed: ₱25,000</div>
                                            <div class="approved-amount">Approved: ₱20,000</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-partial">Partial</span>
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            <div class="submitted-date">Submitted: 2024-01-08</div>
                                            <div class="processed-date">Processed: 2024-01-13</div>
                                        </div>
                                    </td>
                                    <td class="actions">
                                        <a href="#" class="btn-action btn-view">View</a>
                                        <a href="#" class="btn-action btn-download">Download</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="claim-details">
                                            <div class="claim-id">CLM-2024-004</div>
                                            <div class="patient-name">Sofia Reyes</div>
                                            <div class="claim-description">Dermatology Consultation</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="insurance-info">
                                            <div class="insurance-provider">PhilHealth</div>
                                            <div class="policy-number">PH-789123456</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="amount-details">
                                            <div class="claimed-amount">Claimed: ₱5,500</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-rejected">Rejected</span>
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            <div class="submitted-date">Submitted: 2024-01-09</div>
                                            <div class="processed-date">Processed: 2024-01-12</div>
                                        </div>
                                    </td>
                                    <td class="actions">
                                        <a href="#" class="btn-action btn-view">View</a>
                                        <a href="#" class="btn-action btn-download">Download</a>
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
            const rows = document.querySelectorAll('.claims-table tbody tr');
            
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
            const rows = document.querySelectorAll('.claims-table tbody tr');
            
            rows.forEach(row => {
                const status = row.querySelector('.status-badge').textContent.toLowerCase();
                if (filterValue === 'all claims' || status === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Action button handlers
        document.querySelectorAll('.btn-view').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const row = this.closest('tr');
                const claimId = row.querySelector('.claim-id').textContent;
                alert(`View claim ${claimId}`);
            });
        });

        document.querySelectorAll('.btn-download').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const row = this.closest('tr');
                const claimId = row.querySelector('.claim-id').textContent;
                alert(`Download claim ${claimId}`);
            });
        });
    </script>
</body>
</html>
