<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Reports - San Miguel HMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
	<style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            background-color: #2c3e50;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
        }
        
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 20px;
            border-radius: 5px;
            margin: 2px 10px;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover {
            background-color: #34495e;
            color: #fff;
        }
        
        .sidebar .nav-link.active {
            background-color: #3498db;
            color: #fff;
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .header {
            background: #fff;
            padding: 15px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .summary-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            text-align: center;
        }
        
        .summary-card .number {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .summary-card.total .number { color: #3b82f6; }
        .summary-card.this-month .number { color: #10b981; }
        .summary-card.scheduled .number { color: #8b5cf6; }
        .summary-card.templates .number { color: #f59e0b; }
        
        .table-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }
        
        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .table tbody tr:hover {
            background-color: #e9ecef;
        }
        
        .btn-templates {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-templates:hover {
            background: #5a6268;
        }
        
        .btn-schedule {
            background: #8b5cf6;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-schedule:hover {
            background: #7c3aed;
        }
        
        .btn-generate {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-generate:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,123,255,0.3);
        }
        
        .action-link {
            text-decoration: underline;
            font-size: 14px;
            margin-right: 15px;
            font-weight: 500;
        }

        .view-link { color: #3b82f6; }
        .download-link { color: #3b82f6; }
        .share-link { color: #8b5cf6; }

        .status-completed { 
            background: #d1fae5; 
            color: #065f46; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 12px; 
            font-weight: 600; 
        }
        .status-in-progress { 
            background: #fef3c7; 
            color: #92400e; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 12px; 
            font-weight: 600; 
        }

        .report-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .report-id {
            font-size: 12px;
            color: #6b7280;
        }

        .search-filter-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .search-input {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .search-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
            outline: none;
        }

        .btn-filter {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-filter:hover {
            background: #5a6268;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .modal-header h4 {
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            color: #6c757d;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn:hover {
            color: #dc3545;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
            display: block;
        }

        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }

        .time-input-group {
            position: relative;
        }

        .time-input-group .form-control {
            padding-right: 40px;
        }

        .time-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
        }

        .date-input-group {
            position: relative;
        }

        .date-input-group .form-control {
            padding-right: 40px;
        }

        .date-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            pointer-events: none;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .radio-item input[type="radio"] {
            margin: 0;
        }

        .checkbox-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 10px;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-item input[type="checkbox"] {
            margin: 0;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background: #5a6268;
        }

        .btn-schedule-report {
            background: #8b5cf6;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-schedule-report:hover {
            background: #7c3aed;
        }

        .btn-generate-report {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-generate-report:hover {
            background: #0056b3;
        }

        /* Report Details Modal Styles */
        .report-details-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 90%;
            max-width: 700px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .report-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin: 20px 0;
        }

        .report-info-item {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .report-info-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .report-info-value {
            color: #2c3e50;
            font-size: 16px;
            font-weight: 500;
        }

        .report-summary-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .report-summary-section h5 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .summary-card-small {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .summary-card-small .number {
            font-size: 1.8rem;
            font-weight: bold;
            margin: 8px 0;
        }

        .summary-card-small .label {
            font-size: 12px;
            color: #6c757d;
            font-weight: 600;
        }

        .summary-card-total .number { color: #3b82f6; }
        .summary-card-critical .number { color: #ef4444; }
        .summary-card-normal .number { color: #10b981; }

        .report-details-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
        }

        .btn-download-report {
            background: #10b981;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-download-report:hover {
            background: #059669;
        }

        .btn-share-report {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-share-report:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="text-center mb-4 pt-3">
            <i class="fas fa-hospital fa-2x text-white mb-2"></i>
            <h4 class="text-white">Laboratory</h4>
            <small class="text-muted">San Miguel Hospital</small>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory') ?>">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory/test/request') ?>">
                    <i class="fas fa-clipboard-list me-2"></i> Test Requests
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory/test/results') ?>">
                    <i class="fas fa-file-medical-alt me-2"></i> Test Results
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory/equipment/status') ?>">
                    <i class="fas fa-tools me-2"></i> Equipment
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory/tracking') ?>">
                    <i class="fas fa-search me-2"></i> Sample Tracking
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="<?= site_url('laboratory/reports') ?>">
                    <i class="fas fa-chart-bar me-2"></i> Lab Reports
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory/quality') ?>">
                    <i class="fas fa-shield-alt me-2"></i> Quality Control
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory/inventory') ?>">
                    <i class="fas fa-flask me-2"></i> Lab Inventory
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory/settings') ?>">
                    <i class="fas fa-cog me-2"></i> Settings
                </a>
            </li>
        </ul>
        
        <div class="mt-auto pt-3">
            <a href="<?= site_url('auth/logout') ?>" class="nav-link">
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Laboratory Reports</h2>
                    <p class="text-muted mb-0">Generate and manage laboratory reports and analytics</p>
                </div>
                <div>
                    <button class="btn btn-templates me-2">
                        <i class="fas fa-file-alt me-2"></i> Templates
                    </button>
                    <button class="btn btn-schedule me-2">
                        <i class="fas fa-calendar me-2"></i> Schedule Report
                    </button>
                    <button class="btn btn-generate">
                        <i class="fas fa-plus me-2"></i> + Generate Report
                    </button>
				</div>
			</div>
			</div>

        <!-- Summary Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="summary-card total">
                    <i class="fas fa-file-alt fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted">Total Reports</h6>
                    <div class="number">156</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card this-month">
                    <i class="fas fa-calendar fa-2x text-success mb-2"></i>
                    <h6 class="text-muted">This Month</h6>
                    <div class="number">42</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card scheduled">
                    <i class="fas fa-clock fa-2x text-purple mb-2"></i>
                    <h6 class="text-muted">Scheduled</h6>
                    <div class="number">8</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card templates">
                    <i class="fas fa-file-alt fa-2x text-warning mb-2"></i>
                    <h6 class="text-muted">Templates</h6>
                    <div class="number">12</div>
                </div>
            </div>
				</div>

        <!-- Search and Filter Section -->
        <div class="search-filter-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <input type="text" class="form-control search-input" placeholder="Search reports...">
                </div>
                <div class="col-md-4 text-end">
                    <button class="btn btn-filter">
                        <i class="fas fa-filter me-2"></i> Filter
                    </button>
                </div>
				</div>
			</div>

        <!-- Recent Reports Section -->
        <div class="table-container">
            <div class="p-3 border-bottom">
                <h5 class="mb-0">Recent Reports</h5>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>REPORT</th>
                        <th>TYPE</th>
                        <th>PERIOD</th>
                        <th>GENERATED</th>
                        <th>STATUS</th>
                        <th>SIZE</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="report-name">Daily Laboratory Summary</div>
                            <div class="report-id">RPT-001</div>
                        </td>
                        <td>Daily Report</td>
                        <td>January 15, 2024</td>
                        <td>2024-01-16 (John Martinez)</td>
                        <td><span class="status-completed">Completed</span></td>
                        <td>2.3 MB</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewReport('RPT-001')">View</a>
                            <a href="#" class="action-link download-link" onclick="downloadReport('RPT-001')">Download</a>
                            <a href="#" class="action-link share-link" onclick="shareReport('RPT-001')">Share</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="report-name">Monthly Quality Control Report</div>
                            <div class="report-id">RPT-002</div>
                        </td>
                        <td>QC Report</td>
                        <td>December 2023</td>
                        <td>2024-01-01 (Sarah Garcia)</td>
                        <td><span class="status-completed">Completed</span></td>
                        <td>5.7 MB</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewReport('RPT-002')">View</a>
                            <a href="#" class="action-link download-link" onclick="downloadReport('RPT-002')">Download</a>
                            <a href="#" class="action-link share-link" onclick="shareReport('RPT-002')">Share</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="report-name">Equipment Maintenance Report</div>
                            <div class="report-id">RPT-003</div>
                        </td>
                        <td>Maintenance Report</td>
                        <td>Q4 2023</td>
                        <td>2024-01-10 (Mike Rodriguez)</td>
                        <td><span class="status-completed">Completed</span></td>
                        <td>1.8 MB</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewReport('RPT-003')">View</a>
                            <a href="#" class="action-link download-link" onclick="downloadReport('RPT-003')">Download</a>
                            <a href="#" class="action-link share-link" onclick="shareReport('RPT-003')">Share</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="report-name">Weekly Inventory Report</div>
                            <div class="report-id">RPT-004</div>
                        </td>
                        <td>Inventory Report</td>
                        <td>Week 2, January 2024</td>
                        <td>2024-01-15 (Lisa Chen)</td>
                        <td><span class="status-in-progress">In Progress</span></td>
                        <td>0.9 MB</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewReport('RPT-004')">View</a>
                            <a href="#" class="action-link download-link" onclick="downloadReport('RPT-004')">Download</a>
                            <a href="#" class="action-link share-link" onclick="shareReport('RPT-004')">Share</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="report-name">Patient Test Results Summary</div>
                            <div class="report-id">RPT-005</div>
                        </td>
                        <td>Test Results Report</td>
                        <td>January 1-15, 2024</td>
                        <td>2024-01-16 (David Park)</td>
                        <td><span class="status-completed">Completed</span></td>
                        <td>3.2 MB</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewReport('RPT-005')">View</a>
                            <a href="#" class="action-link download-link" onclick="downloadReport('RPT-005')">Download</a>
                            <a href="#" class="action-link share-link" onclick="shareReport('RPT-005')">Share</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Schedule Report Modal -->
    <div class="modal-overlay" id="scheduleReportModal">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Schedule Automatic Report</h4>
                <button class="close-btn" onclick="closeScheduleReportModal()">&times;</button>
            </div>
            
            <form id="scheduleReportForm">
                <div class="form-group">
                    <label for="reportTemplate">Report Template</label>
                    <select class="form-select" id="reportTemplate" name="reportTemplate" required>
                        <option value="">Select template</option>
                        <option value="daily-summary" selected>Daily Summary Template</option>
                        <option value="weekly-summary">Weekly Summary Template</option>
                        <option value="monthly-qc">Monthly QC Template</option>
                        <option value="equipment-maintenance">Equipment Maintenance Template</option>
                        <option value="inventory-report">Inventory Report Template</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="frequency">Frequency</label>
                    <select class="form-select" id="frequency" name="frequency" required>
                        <option value="daily" selected>Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="quarterly">Quarterly</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="time">Time</label>
                    <div class="time-input-group">
                        <input type="time" class="form-control" id="time" name="time" value="08:00" required>
                        <i class="fas fa-clock time-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="startDate">Start Date</label>
                    <div class="date-input-group">
                        <input type="date" class="form-control" id="startDate" name="startDate" required>
                        <i class="fas fa-calendar-alt date-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="recipients">Recipients</label>
                    <input type="email" class="form-control" id="recipients" name="recipients" value="admin@hospital.com" required>
                </div>

                <div class="form-group">
                    <label for="additionalEmails">Additional Email Recipients</label>
                    <textarea class="form-control" id="additionalEmails" name="additionalEmails" rows="3" placeholder="Enter email addresses separated by commas"></textarea>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeScheduleReportModal()">Cancel</button>
                    <button type="submit" class="btn-schedule-report">Schedule Report</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Generate Report Modal -->
    <div class="modal-overlay" id="generateReportModal">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Generate New Report</h4>
                <button class="close-btn" onclick="closeGenerateReportModal()">&times;</button>
            </div>
            
            <form id="generateReportForm">
                <div class="form-group">
                    <label for="reportTemplateGen">Report Template</label>
                    <select class="form-select" id="reportTemplateGen" name="reportTemplate" required>
                        <option value="">Select template</option>
                        <option value="daily-summary">Daily Summary Template</option>
                        <option value="weekly-summary">Weekly Summary Template</option>
                        <option value="monthly-qc">Monthly QC Template</option>
                        <option value="equipment-maintenance">Equipment Maintenance Template</option>
                        <option value="inventory-report">Inventory Report Template</option>
                        <option value="patient-results">Patient Results Template</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="reportName">Report Name</label>
                    <input type="text" class="form-control" id="reportName" name="reportName" placeholder="Enter report name" required>
                </div>

                <div class="form-group">
                    <label for="department">Department</label>
                    <select class="form-select" id="department" name="department" required>
                        <option value="all" selected>All Departments</option>
                        <option value="hematology">Hematology</option>
                        <option value="chemistry">Chemistry</option>
                        <option value="pathology">Pathology</option>
                        <option value="microbiology">Microbiology</option>
                        <option value="immunology">Immunology</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dateFrom">Date From</label>
                            <div class="date-input-group">
                                <input type="date" class="form-control" id="dateFrom" name="dateFrom" required>
                                <i class="fas fa-calendar-alt date-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dateTo">Date To</label>
                            <div class="date-input-group">
                                <input type="date" class="form-control" id="dateTo" name="dateTo" required>
                                <i class="fas fa-calendar-alt date-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Report Format</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" id="formatPdf" name="reportFormat" value="pdf" checked>
                            <label for="formatPdf">PDF</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="formatExcel" name="reportFormat" value="excel">
                            <label for="formatExcel">Excel</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="formatWord" name="reportFormat" value="word">
                            <label for="formatWord">Word</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Include Sections</label>
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="executiveSummary" name="includeSections[]" value="executive-summary" checked>
                            <label for="executiveSummary">Executive Summary</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="criticalResults" name="includeSections[]" value="critical-results" checked>
                            <label for="criticalResults">Critical Results</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="testStatistics" name="includeSections[]" value="test-statistics" checked>
                            <label for="testStatistics">Test Statistics</label>
                        </div>
                        <div class="checkbox-item">
                            <input type="checkbox" id="equipmentStatus" name="includeSections[]" value="equipment-status">
                            <label for="equipmentStatus">Equipment Status</label>
                        </div>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeGenerateReportModal()">Cancel</button>
                    <button type="submit" class="btn-generate-report">Generate Report</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Details Modal -->
    <div class="modal-overlay" id="reportDetailsModal">
        <div class="report-details-content">
            <div class="modal-header">
                <h4>Report Details</h4>
                <button class="close-btn" onclick="closeReportDetailsModal()">&times;</button>
            </div>
            
            <div class="report-info-grid">
                <div>
                    <div class="report-info-item">
                        <div class="report-info-label">Report Name</div>
                        <div class="report-info-value" id="detailReportName">Daily Laboratory Summary</div>
                    </div>
                    <div class="report-info-item">
                        <div class="report-info-label">Report ID</div>
                        <div class="report-info-value" id="detailReportId">RPT-001</div>
                    </div>
                    <div class="report-info-item">
                        <div class="report-info-label">Type</div>
                        <div class="report-info-value" id="detailReportType">Daily Report</div>
                    </div>
                    <div class="report-info-item">
                        <div class="report-info-label">Department</div>
                        <div class="report-info-value" id="detailDepartment">All Departments</div>
                    </div>
                </div>
                <div>
                    <div class="report-info-item">
                        <div class="report-info-label">Period Covered</div>
                        <div class="report-info-value" id="detailPeriod">January 15, 2024</div>
                    </div>
                    <div class="report-info-item">
                        <div class="report-info-label">Generated Date</div>
                        <div class="report-info-value" id="detailGeneratedDate">2024-01-16</div>
                    </div>
                    <div class="report-info-item">
                        <div class="report-info-label">Generated By</div>
                        <div class="report-info-value" id="detailGeneratedBy">John Martinez</div>
                    </div>
                    <div class="report-info-item">
                        <div class="report-info-label">File Size</div>
                        <div class="report-info-value" id="detailFileSize">2.3 MB</div>
                    </div>
                </div>
            </div>

            <div class="report-summary-section">
                <h5>Report Summary</h5>
                <div class="summary-cards">
                    <div class="summary-card-small summary-card-total">
                        <div class="number" id="detailTotalTests">89</div>
                        <div class="label">Total Tests</div>
                    </div>
                    <div class="summary-card-small summary-card-critical">
                        <div class="number" id="detailCriticalResults">5</div>
                        <div class="label">Critical Results</div>
                    </div>
                    <div class="summary-card-small summary-card-normal">
                        <div class="number" id="detailNormalResults">84</div>
                        <div class="label">Normal Results</div>
                    </div>
                </div>
            </div>

            <div class="report-details-actions">
                <button class="btn-cancel" onclick="closeReportDetailsModal()">Close</button>
                <button class="btn-download-report" onclick="downloadReportFromDetails()">Download</button>
                <button class="btn-share-report" onclick="shareReportFromDetails()">Share</button>
            </div>
        </div>
    </div>

    <script>
        // Lab Reports functions
        document.querySelector('.btn-templates').addEventListener('click', function() {
            alert('Templates functionality would be implemented here');
        });

        document.querySelector('.btn-schedule').addEventListener('click', function() {
            openScheduleReportModal();
        });

        document.querySelector('.btn-generate').addEventListener('click', function() {
            openGenerateReportModal();
        });

        document.querySelector('.btn-filter').addEventListener('click', function() {
            alert('Filter functionality would be implemented here');
        });

        // Schedule Report Modal functions
        function openScheduleReportModal() {
            document.getElementById('scheduleReportModal').style.display = 'flex';
        }

        function closeScheduleReportModal() {
            document.getElementById('scheduleReportModal').style.display = 'none';
        }

        // Generate Report Modal functions
        function openGenerateReportModal() {
            document.getElementById('generateReportModal').style.display = 'flex';
        }

        function closeGenerateReportModal() {
            document.getElementById('generateReportModal').style.display = 'none';
        }

        // Close modals when clicking outside
        document.getElementById('scheduleReportModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeScheduleReportModal();
            }
        });

        document.getElementById('generateReportModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGenerateReportModal();
            }
        });

        // Form submissions
        document.getElementById('scheduleReportForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const reportTemplate = formData.get('reportTemplate');
            const frequency = formData.get('frequency');
            const time = formData.get('time');
            const startDate = formData.get('startDate');
            const recipients = formData.get('recipients');
            const additionalEmails = formData.get('additionalEmails');
            
            console.log('Schedule Report Data:', {
                reportTemplate,
                frequency,
                time,
                startDate,
                recipients,
                additionalEmails
            });
            
            alert('Report scheduled successfully!');
            closeScheduleReportModal();
        });

        document.getElementById('generateReportForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const reportTemplate = formData.get('reportTemplate');
            const reportName = formData.get('reportName');
            const department = formData.get('department');
            const dateFrom = formData.get('dateFrom');
            const dateTo = formData.get('dateTo');
            const reportFormat = formData.get('reportFormat');
            const includeSections = formData.getAll('includeSections[]');
            
            console.log('Generate Report Data:', {
                reportTemplate,
                reportName,
                department,
                dateFrom,
                dateTo,
                reportFormat,
                includeSections
            });
            
            alert('Report generated successfully!');
            closeGenerateReportModal();
        });

        // Report Details Modal functions
        function openReportDetailsModal(reportId, reportName, reportType, department, period, generatedDate, generatedBy, fileSize, totalTests, criticalResults, normalResults) {
            // Update modal content with passed data
            document.getElementById('detailReportName').textContent = reportName;
            document.getElementById('detailReportId').textContent = reportId;
            document.getElementById('detailReportType').textContent = reportType;
            document.getElementById('detailDepartment').textContent = department;
            document.getElementById('detailPeriod').textContent = period;
            document.getElementById('detailGeneratedDate').textContent = generatedDate;
            document.getElementById('detailGeneratedBy').textContent = generatedBy;
            document.getElementById('detailFileSize').textContent = fileSize;
            document.getElementById('detailTotalTests').textContent = totalTests;
            document.getElementById('detailCriticalResults').textContent = criticalResults;
            document.getElementById('detailNormalResults').textContent = normalResults;
            
            // Show modal
            document.getElementById('reportDetailsModal').style.display = 'flex';
        }

        function closeReportDetailsModal() {
            document.getElementById('reportDetailsModal').style.display = 'none';
        }

        function downloadReportFromDetails() {
            const reportId = document.getElementById('detailReportId').textContent;
            alert('Download Report: ' + reportId);
        }

        function shareReportFromDetails() {
            const reportId = document.getElementById('detailReportId').textContent;
            alert('Share Report: ' + reportId);
        }

        // Close modal when clicking outside
        document.getElementById('reportDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReportDetailsModal();
            }
        });

        function viewReport(reportId) {
            // Sample data for different reports
            const reportData = {
                'RPT-001': {
                    name: 'Daily Laboratory Summary',
                    type: 'Daily Report',
                    department: 'All Departments',
                    period: 'January 15, 2024',
                    generatedDate: '2024-01-16',
                    generatedBy: 'John Martinez',
                    fileSize: '2.3 MB',
                    totalTests: 89,
                    criticalResults: 5,
                    normalResults: 84
                },
                'RPT-002': {
                    name: 'Monthly Quality Control Report',
                    type: 'QC Report',
                    department: 'Quality Control',
                    period: 'December 2023',
                    generatedDate: '2024-01-01',
                    generatedBy: 'Sarah Garcia',
                    fileSize: '5.7 MB',
                    totalTests: 156,
                    criticalResults: 12,
                    normalResults: 144
                },
                'RPT-003': {
                    name: 'Equipment Maintenance Report',
                    type: 'Maintenance Report',
                    department: 'Equipment Management',
                    period: 'Q4 2023',
                    generatedDate: '2024-01-10',
                    generatedBy: 'Mike Rodriguez',
                    fileSize: '1.8 MB',
                    totalTests: 45,
                    criticalResults: 2,
                    normalResults: 43
                },
                'RPT-004': {
                    name: 'Weekly Inventory Report',
                    type: 'Inventory Report',
                    department: 'Lab Inventory',
                    period: 'Week 2, January 2024',
                    generatedDate: '2024-01-15',
                    generatedBy: 'Lisa Chen',
                    fileSize: '0.9 MB',
                    totalTests: 23,
                    criticalResults: 1,
                    normalResults: 22
                },
                'RPT-005': {
                    name: 'Patient Test Results Summary',
                    type: 'Test Results Report',
                    department: 'All Departments',
                    period: 'January 1-15, 2024',
                    generatedDate: '2024-01-16',
                    generatedBy: 'David Park',
                    fileSize: '3.2 MB',
                    totalTests: 234,
                    criticalResults: 18,
                    normalResults: 216
                }
            };

            const data = reportData[reportId] || reportData['RPT-001'];
            openReportDetailsModal(
                reportId,
                data.name,
                data.type,
                data.department,
                data.period,
                data.generatedDate,
                data.generatedBy,
                data.fileSize,
                data.totalTests,
                data.criticalResults,
                data.normalResults
            );
        }

        function downloadReport(reportId) {
            alert('Download Report: ' + reportId);
        }

        function shareReport(reportId) {
            alert('Share Report: ' + reportId);
        }
    </script>
</body>
</html>