<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Performance Report - HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        .performance-report {
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

        .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .metric-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }

        .metric-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 24px;
        }

        .metric-icon.efficiency {
            background: #d1fae5;
            color: #065f46;
        }

        .metric-icon.productivity {
            background: #dbeafe;
            color: #1e40af;
        }

        .metric-icon.quality {
            background: #fef3c7;
            color: #92400e;
        }

        .metric-icon.satisfaction {
            background: #e0e7ff;
            color: #3730a3;
        }

        .metric-value {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 5px;
        }

        .metric-label {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }

        .metric-change {
            font-size: 12px;
            margin-top: 10px;
        }

        .metric-change.positive {
            color: #10b981;
        }

        .metric-change.negative {
            color: #ef4444;
        }

        .performance-charts {
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

        .staff-performance {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .staff-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .staff-table {
            width: 100%;
            border-collapse: collapse;
        }

        .staff-table th,
        .staff-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .staff-table th {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
        }

        .performance-score {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .score-excellent {
            background: #d1fae5;
            color: #065f46;
        }

        .score-good {
            background: #dbeafe;
            color: #1e40af;
        }

        .score-average {
            background: #fef3c7;
            color: #92400e;
        }

        .score-poor {
            background: #fee2e2;
            color: #991b1b;
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

        .btn-edit {
            background: #fef3c7;
            color: #92400e;
        }

        .btn-edit:hover {
            background: #fde68a;
        }

        @media (max-width: 768px) {
            .performance-charts {
                grid-template-columns: 1fr;
            }
            
            .metrics-grid {
                grid-template-columns: 1fr;
            }
            
            .filters-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'partials/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'partials/header.php'; ?>
        
        <div class="performance-report">
            <div class="page-header">
                <h1 class="page-title">Performance Report</h1>
                <p class="page-subtitle">Comprehensive analysis of hospital staff and department performance</p>
            </div>

            <div class="filters-section">
                <h3 class="filters-title">Report Filters</h3>
                <div class="filters-grid">
                    <div class="filter-group">
                        <label class="filter-label">Department</label>
                        <select class="filter-input">
                            <option value="">All Departments</option>
                            <option value="emergency">Emergency</option>
                            <option value="cardiology">Cardiology</option>
                            <option value="orthopedics">Orthopedics</option>
                            <option value="pediatrics">Pediatrics</option>
                            <option value="surgery">Surgery</option>
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

            <div class="metrics-grid">
                <div class="metric-card">
                    <div class="metric-icon efficiency">📈</div>
                    <div class="metric-value">87%</div>
                    <div class="metric-label">Overall Efficiency</div>
                    <div class="metric-change positive">+5% from last month</div>
                </div>
                
                <div class="metric-card">
                    <div class="metric-icon productivity">⚡</div>
                    <div class="metric-value">92%</div>
                    <div class="metric-label">Staff Productivity</div>
                    <div class="metric-change positive">+3% from last month</div>
                </div>
                
                <div class="metric-card">
                    <div class="metric-icon quality">🏆</div>
                    <div class="metric-value">94%</div>
                    <div class="metric-label">Service Quality</div>
                    <div class="metric-change positive">+2% from last month</div>
                </div>
                
                <div class="metric-card">
                    <div class="metric-icon satisfaction">😊</div>
                    <div class="metric-value">89%</div>
                    <div class="metric-label">Patient Satisfaction</div>
                    <div class="metric-change positive">+7% from last month</div>
                </div>
            </div>

            <div class="performance-charts">
                <div class="chart-card">
                    <h3 class="chart-title">Performance Trends Over Time</h3>
                    <div class="chart-placeholder">
                        📊 Interactive Chart: Performance metrics trends over the selected period
                    </div>
                </div>
                
                <div class="chart-card">
                    <h3 class="chart-title">Department Comparison</h3>
                    <div class="chart-placeholder">
                        📈 Interactive Chart: Performance comparison across departments
                    </div>
                </div>
            </div>

            <div class="staff-performance">
                <h3 class="staff-title">Staff Performance Details</h3>
                <table class="staff-table">
                    <thead>
                        <tr>
                            <th>Staff Member</th>
                            <th>Department</th>
                            <th>Efficiency</th>
                            <th>Quality</th>
                            <th>Overall Score</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Dr. Maria Santos</td>
                            <td>Cardiology</td>
                            <td>95%</td>
                            <td>98%</td>
                            <td><span class="performance-score score-excellent">96%</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn btn-view">View</button>
                                    <button class="action-btn btn-edit">Edit</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Dr. Juan Dela Cruz</td>
                            <td>Emergency</td>
                            <td>88%</td>
                            <td>92%</td>
                            <td><span class="performance-score score-good">90%</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn btn-view">View</button>
                                    <button class="action-btn btn-edit">Edit</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Nurse Ana Reyes</td>
                            <td>Pediatrics</td>
                            <td>82%</td>
                            <td>85%</td>
                            <td><span class="performance-score score-average">83%</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn btn-view">View</button>
                                    <button class="action-btn btn-edit">Edit</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Dr. Carlos Mendoza</td>
                            <td>Surgery</td>
                            <td>78%</td>
                            <td>75%</td>
                            <td><span class="performance-score score-poor">76%</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn btn-view">View</button>
                                    <button class="action-btn btn-edit">Edit</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Nurse Pedro Garcia</td>
                            <td>Orthopedics</td>
                            <td>91%</td>
                            <td>89%</td>
                            <td><span class="performance-score score-good">90%</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn btn-view">View</button>
                                    <button class="action-btn btn-edit">Edit</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/auth.js') ?>"></script>
</body>
</html>
