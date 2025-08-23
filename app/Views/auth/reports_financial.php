<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Reports - HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        .financial-reports {
            padding: 20px;
            background: #f8fafc;
            min-height: 100vh;
        }

        .page-header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 10px;
        }

        .page-subtitle {
            color: #64748b;
            font-size: 16px;
        }

        .filters-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .filters-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 15px;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-label {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 5px;
        }

        .filter-input {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }

        .filter-btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .filter-btn:hover {
            background: #2563eb;
        }

        .financial-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .overview-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-left: 4px solid #3b82f6;
        }

        .overview-card.revenue {
            border-left-color: #10b981;
        }

        .overview-card.expenses {
            border-left-color: #f59e0b;
        }

        .overview-card.profit {
            border-left-color: #8b5cf6;
        }

        .overview-card.cashflow {
            border-left-color: #ef4444;
        }

        .overview-number {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .overview-label {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }

        .overview-change {
            font-size: 12px;
            margin-top: 10px;
        }

        .overview-change.positive {
            color: #10b981;
        }

        .overview-change.negative {
            color: #ef4444;
        }

        .charts-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .chart-placeholder {
            height: 300px;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 16px;
        }

        .financial-details {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .details-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .details-tabs {
            display: flex;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 20px;
        }

        .tab-button {
            padding: 12px 24px;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #64748b;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .tab-button.active {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
        }

        .tab-button:hover {
            color: #3b82f6;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .financial-table {
            width: 100%;
            border-collapse: collapse;
        }

        .financial-table th,
        .financial-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .financial-table th {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
        }

        .amount {
            font-family: 'Courier New', monospace;
            font-weight: 600;
        }

        .amount.positive {
            color: #10b981;
        }

        .amount.negative {
            color: #ef4444;
        }

        .department-tag {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .dept-emergency {
            background: #fee2e2;
            color: #991b1b;
        }

        .dept-cardiology {
            background: #dbeafe;
            color: #1e40af;
        }

        .dept-orthopedics {
            background: #d1fae5;
            color: #065f46;
        }

        .dept-pediatrics {
            background: #fef3c7;
            color: #92400e;
        }

        .dept-surgery {
            background: #e0e7ff;
            color: #3730a3;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-view {
            background: #dbeafe;
            color: #1e40af;
        }

        .btn-view:hover {
            background: #bfdbfe;
        }

        .btn-export {
            background: #fef3c7;
            color: #92400e;
        }

        .btn-export:hover {
            background: #fde68a;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .summary-card {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .summary-value {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .summary-label {
            font-size: 12px;
            color: #64748b;
        }

        @media (max-width: 768px) {
            .charts-section {
                grid-template-columns: 1fr;
            }
            
            .financial-overview {
                grid-template-columns: 1fr;
            }
            
            .filters-grid {
                grid-template-columns: 1fr;
            }
            
            .details-tabs {
                flex-wrap: wrap;
            }
        }
    </style>
</head>
<body>
    <?php include 'partials/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'partials/header.php'; ?>
        
        <div class="financial-reports">
            <div class="page-header">
                <h1 class="page-title">Financial Reports</h1>
                <p class="page-subtitle">Comprehensive financial analysis and reporting</p>
            </div>

            <div class="filters-section">
                <h3 class="filters-title">Report Filters</h3>
                <div class="filters-grid">
                    <div class="filter-group">
                        <label class="filter-label">Report Type</label>
                        <select class="filter-input">
                            <option value="">All Reports</option>
                            <option value="revenue">Revenue Report</option>
                            <option value="expenses">Expenses Report</option>
                            <option value="profit">Profit & Loss</option>
                            <option value="cashflow">Cash Flow</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">Date Range</label>
                        <input type="date" class="filter-input" value="2024-12-01">
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">To</label>
                        <input type="date" class="filter-input" value="2024-12-31">
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">&nbsp;</label>
                        <button class="filter-btn">Generate Report</button>
                    </div>
                </div>
            </div>

            <div class="financial-overview">
                <div class="overview-card revenue">
                    <div class="overview-number">₱2.4M</div>
                    <div class="overview-label">Total Revenue</div>
                    <div class="overview-change positive">+8.5% from last month</div>
                </div>
                
                <div class="overview-card expenses">
                    <div class="overview-number">₱1.8M</div>
                    <div class="overview-label">Total Expenses</div>
                    <div class="overview-change negative">+5.2% from last month</div>
                </div>
                
                <div class="overview-card profit">
                    <div class="overview-number">₱600K</div>
                    <div class="overview-label">Net Profit</div>
                    <div class="overview-change positive">+15.3% from last month</div>
                </div>
                
                <div class="overview-card cashflow">
                    <div class="overview-number">₱450K</div>
                    <div class="overview-label">Cash Flow</div>
                    <div class="overview-change positive">+12.1% from last month</div>
                </div>
            </div>

            <div class="charts-section">
                <div class="chart-card">
                    <h3 class="chart-title">Revenue vs Expenses Trend</h3>
                    <div class="chart-placeholder">
                        📊 Interactive Chart: Monthly revenue and expenses comparison
                    </div>
                </div>
                
                <div class="chart-card">
                    <h3 class="chart-title">Department Revenue Distribution</h3>
                    <div class="chart-placeholder">
                        🥧 Interactive Chart: Revenue breakdown by department
                    </div>
                </div>
            </div>

            <div class="financial-details">
                <h3 class="details-title">Detailed Financial Analysis</h3>
                
                <div class="details-tabs">
                    <button class="tab-button active" onclick="showTab('revenue')">Revenue Details</button>
                    <button class="tab-button" onclick="showTab('expenses')">Expenses Details</button>
                    <button class="tab-button" onclick="showTab('departments')">Department Analysis</button>
                </div>

                <div id="revenue" class="tab-content active">
                    <table class="financial-table">
                        <thead>
                            <tr>
                                <th>Revenue Source</th>
                                <th>Amount</th>
                                <th>Change</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Patient Consultations</td>
                                <td class="amount positive">₱850,000</td>
                                <td class="overview-change positive">+12%</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view">View</button>
                                        <button class="action-btn btn-export">Export</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Laboratory Tests</td>
                                <td class="amount positive">₱420,000</td>
                                <td class="overview-change positive">+8%</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view">View</button>
                                        <button class="action-btn btn-export">Export</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Pharmacy Sales</td>
                                <td class="amount positive">₱380,000</td>
                                <td class="overview-change positive">+15%</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view">View</button>
                                        <button class="action-btn btn-export">Export</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Emergency Services</td>
                                <td class="amount positive">₱320,000</td>
                                <td class="overview-change positive">+6%</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view">View</button>
                                        <button class="action-btn btn-export">Export</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Other Services</td>
                                <td class="amount positive">₱430,000</td>
                                <td class="overview-change positive">+9%</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view">View</button>
                                        <button class="action-btn btn-export">Export</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="expenses" class="tab-content">
                    <table class="financial-table">
                        <thead>
                            <tr>
                                <th>Expense Category</th>
                                <th>Amount</th>
                                <th>Change</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Staff Salaries</td>
                                <td class="amount negative">₱950,000</td>
                                <td class="overview-change negative">+3%</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view">View</button>
                                        <button class="action-btn btn-export">Export</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Medical Supplies</td>
                                <td class="amount negative">₱320,000</td>
                                <td class="overview-change negative">+8%</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view">View</button>
                                        <button class="action-btn btn-export">Export</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Equipment Maintenance</td>
                                <td class="amount negative">₱180,000</td>
                                <td class="overview-change negative">+12%</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view">View</button>
                                        <button class="action-btn btn-export">Export</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Utilities</td>
                                <td class="amount negative">₱150,000</td>
                                <td class="overview-change negative">+5%</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view">View</button>
                                        <button class="action-btn btn-export">Export</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Other Expenses</td>
                                <td class="amount negative">₱200,000</td>
                                <td class="overview-change negative">+7%</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view">View</button>
                                        <button class="action-btn btn-export">Export</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div id="departments" class="tab-content">
                    <table class="financial-table">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>Revenue</th>
                                <th>Expenses</th>
                                <th>Profit</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="department-tag dept-emergency">Emergency</span></td>
                                <td class="amount positive">₱320,000</td>
                                <td class="amount negative">₱180,000</td>
                                <td class="amount positive">₱140,000</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view">View</button>
                                        <button class="action-btn btn-export">Export</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="department-tag dept-cardiology">Cardiology</span></td>
                                <td class="amount positive">₱450,000</td>
                                <td class="amount negative">₱220,000</td>
                                <td class="amount positive">₱230,000</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view">View</button>
                                        <button class="action-btn btn-export">Export</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="department-tag dept-orthopedics">Orthopedics</span></td>
                                <td class="amount positive">₱380,000</td>
                                <td class="amount negative">₱190,000</td>
                                <td class="amount positive">₱190,000</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view">View</button>
                                        <button class="action-btn btn-export">Export</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="department-tag dept-pediatrics">Pediatrics</span></td>
                                <td class="amount positive">₱290,000</td>
                                <td class="amount negative">₱150,000</td>
                                <td class="amount positive">₱140,000</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view">View</button>
                                        <button class="action-btn btn-export">Export</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="department-tag dept-surgery">Surgery</span></td>
                                <td class="amount positive">₱520,000</td>
                                <td class="amount negative">₱280,000</td>
                                <td class="amount positive">₱240,000</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn btn-view">View</button>
                                        <button class="action-btn btn-export">Export</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="summary-cards">
                    <div class="summary-card">
                        <div class="summary-value">₱2.4M</div>
                        <div class="summary-label">Total Revenue</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-value">₱1.8M</div>
                        <div class="summary-label">Total Expenses</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-value">₱600K</div>
                        <div class="summary-label">Net Profit</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-value">25%</div>
                        <div class="summary-label">Profit Margin</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/auth.js') ?>"></script>
    <script>
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Remove active class from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => button.classList.remove('active'));
            
            // Show selected tab content
            document.getElementById(tabName).classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
        }
    </script>
</body>
</html>
