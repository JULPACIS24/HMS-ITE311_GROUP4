<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Analytics - HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        .patient-analytics {
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

        .analytics-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

        .overview-card.demographics {
            border-left-color: #10b981;
        }

        .overview-card.visits {
            border-left-color: #f59e0b;
        }

        .overview-card.satisfaction {
            border-left-color: #8b5cf6;
        }

        .overview-card.trends {
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

        .demographics-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .demographics-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .demographics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .demographic-chart {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .chart-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .chart-label {
            font-size: 16px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 10px;
        }

        .chart-description {
            font-size: 14px;
            color: #64748b;
            line-height: 1.5;
        }

        .patient-insights {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .insights-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .insights-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .insight-card {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
        }

        .insight-card.positive {
            border-left-color: #10b981;
        }

        .insight-card.warning {
            border-left-color: #f59e0b;
        }

        .insight-card.info {
            border-left-color: #8b5cf6;
        }

        .insight-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .insight-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 20px;
        }

        .insight-icon.positive {
            background: #d1fae5;
            color: #065f46;
        }

        .insight-icon.warning {
            background: #fef3c7;
            color: #92400e;
        }

        .insight-icon.info {
            background: #e0e7ff;
            color: #3730a3;
        }

        .insight-title {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
        }

        .insight-description {
            font-size: 14px;
            color: #64748b;
            line-height: 1.5;
        }

        .trend-analysis {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .trend-title {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .trend-table {
            width: 100%;
            border-collapse: collapse;
        }

        .trend-table th,
        .trend-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .trend-table th {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
        }

        .trend-indicator {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .trend-up {
            background: #d1fae5;
            color: #065f46;
        }

        .trend-down {
            background: #fee2e2;
            color: #991b1b;
        }

        .trend-stable {
            background: #dbeafe;
            color: #1e40af;
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

        @media (max-width: 768px) {
            .charts-section {
                grid-template-columns: 1fr;
            }
            
            .analytics-overview {
                grid-template-columns: 1fr;
            }
            
            .filters-grid {
                grid-template-columns: 1fr;
            }
            
            .demographics-grid {
                grid-template-columns: 1fr;
            }
            
            .insights-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <?php include 'partials/sidebar.php'; ?>
    
    <div class="main-content">
        <?php include 'partials/header.php'; ?>
        
        <div class="patient-analytics">
            <div class="page-header">
                <h1 class="page-title">Patient Analytics</h1>
                <p class="page-subtitle">Comprehensive analysis of patient demographics, trends, and insights</p>
            </div>

            <div class="filters-section">
                <h3 class="filters-title">Analytics Filters</h3>
                <div class="filters-grid">
                    <div class="filter-group">
                        <label class="filter-label">Time Period</label>
                        <select class="filter-input">
                            <option value="">All Time</option>
                            <option value="last7days">Last 7 Days</option>
                            <option value="last30days">Last 30 Days</option>
                            <option value="last3months">Last 3 Months</option>
                            <option value="last6months">Last 6 Months</option>
                            <option value="lastyear">Last Year</option>
                        </select>
                    </div>
                    
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
                        <label class="filter-label">Age Group</label>
                        <select class="filter-input">
                            <option value="">All Ages</option>
                            <option value="0-18">0-18 years</option>
                            <option value="19-30">19-30 years</option>
                            <option value="31-50">31-50 years</option>
                            <option value="51-65">51-65 years</option>
                            <option value="65+">65+ years</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label class="filter-label">&nbsp;</label>
                        <button class="filter-btn">Generate Analytics</button>
                    </div>
                </div>
            </div>

            <div class="analytics-overview">
                <div class="overview-card demographics">
                    <div class="overview-number">12,847</div>
                    <div class="overview-label">Total Patients</div>
                    <div class="overview-change positive">+15% from last month</div>
                </div>
                
                <div class="overview-card visits">
                    <div class="overview-number">3,245</div>
                    <div class="overview-label">Monthly Visits</div>
                    <div class="overview-change positive">+8% from last month</div>
                </div>
                
                <div class="overview-card satisfaction">
                    <div class="overview-number">4.7/5</div>
                    <div class="overview-label">Patient Satisfaction</div>
                    <div class="overview-change positive">+0.2 from last month</div>
                </div>
                
                <div class="overview-card trends">
                    <div class="overview-number">89%</div>
                    <div class="overview-label">Retention Rate</div>
                    <div class="overview-change positive">+3% from last month</div>
                </div>
            </div>

            <div class="charts-section">
                <div class="chart-card">
                    <h3 class="chart-title">Patient Demographics Distribution</h3>
                    <div class="chart-placeholder">
                        📊 Interactive Chart: Age, gender, and location distribution of patients
                    </div>
                </div>
                
                <div class="chart-card">
                    <h3 class="chart-title">Visit Trends Over Time</h3>
                    <div class="chart-placeholder">
                        📈 Interactive Chart: Patient visit patterns and seasonal trends
                    </div>
                </div>
            </div>

            <div class="demographics-section">
                <h3 class="demographics-title">Demographic Insights</h3>
                <div class="demographics-grid">
                    <div class="demographic-chart">
                        <div class="chart-icon">👥</div>
                        <div class="chart-label">Age Distribution</div>
                        <div class="chart-description">
                            Largest patient group: 31-50 years (42%)<br>
                            Pediatric patients: 18%<br>
                            Senior patients: 25%
                        </div>
                    </div>
                    
                    <div class="demographic-chart">
                        <div class="chart-icon">🌍</div>
                        <div class="chart-label">Geographic Distribution</div>
                        <div class="chart-description">
                            Local residents: 78%<br>
                            Regional patients: 15%<br>
                            International: 7%
                        </div>
                    </div>
                    
                    <div class="demographic-chart">
                        <div class="chart-icon">🏥</div>
                        <div class="chart-label">Department Preferences</div>
                        <div class="chart-description">
                            Emergency: 35%<br>
                            Outpatient: 45%<br>
                            Specialized: 20%
                        </div>
                    </div>
                </div>
            </div>

            <div class="patient-insights">
                <h3 class="insights-title">Key Insights & Recommendations</h3>
                <div class="insights-grid">
                    <div class="insight-card positive">
                        <div class="insight-header">
                            <div class="insight-icon positive">📈</div>
                            <div class="insight-title">Growing Patient Base</div>
                        </div>
                        <div class="insight-description">
                            Patient registrations increased by 15% this month, indicating strong market presence and service quality.
                        </div>
                    </div>
                    
                    <div class="insight-card warning">
                        <div class="insight-header">
                            <div class="insight-icon warning">⚠️</div>
                            <div class="insight-title">Peak Hours Analysis</div>
                        </div>
                        <div class="insight-description">
                            Emergency department sees 40% higher traffic between 6-9 PM. Consider additional staffing during these hours.
                        </div>
                    </div>
                    
                    <div class="insight-card info">
                        <div class="insight-header">
                            <div class="insight-icon info">💡</div>
                            <div class="insight-title">Patient Satisfaction Trends</div>
                        </div>
                        <div class="insight-description">
                            Satisfaction scores improved in cardiology and pediatrics. Emergency department shows room for improvement.
                        </div>
                    </div>
                    
                    <div class="insight-card positive">
                        <div class="insight-header">
                            <div class="insight-icon positive">🎯</div>
                            <div class="insight-title">Retention Success</div>
                            <div class="insight-description">
                                High patient retention rate (89%) suggests excellent follow-up care and patient relationship management.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="trend-analysis">
                <h3 class="trend-title">Patient Trend Analysis</h3>
                <table class="trend-table">
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th>Current Month</th>
                            <th>Previous Month</th>
                            <th>Change</th>
                            <th>Trend</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>New Patient Registrations</td>
                            <td>1,245</td>
                            <td>1,082</td>
                            <td>+15%</td>
                            <td><span class="trend-indicator trend-up">↗️ Up</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn btn-view">View</button>
                                    <button class="action-btn btn-export">Export</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Emergency Visits</td>
                            <td>856</td>
                            <td>789</td>
                            <td>+8.5%</td>
                            <td><span class="trend-indicator trend-up">↗️ Up</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn btn-view">View</button>
                                    <button class="action-btn btn-export">Export</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Outpatient Appointments</td>
                            <td>2,134</td>
                            <td>2,001</td>
                            <td>+6.6%</td>
                            <td><span class="trend-indicator trend-up">↗️ Up</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn btn-view">View</button>
                                    <button class="action-btn btn-export">Export</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Patient Wait Times</td>
                            <td>18 min</td>
                            <td>22 min</td>
                            <td>-18%</td>
                            <td><span class="trend-indicator trend-up">↗️ Improved</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn btn-view">View</button>
                                    <button class="action-btn btn-export">Export</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Follow-up Compliance</td>
                            <td>76%</td>
                            <td>72%</td>
                            <td>+5.6%</td>
                            <td><span class="trend-indicator trend-up">↗️ Up</span></td>
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
        </div>
    </div>

    <script src="<?= base_url('assets/js/auth.js') ?>"></script>
</body>
</html>
