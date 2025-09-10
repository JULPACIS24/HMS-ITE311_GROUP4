<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Status - San Miguel HMS</title>
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
        
        .summary-card.operational .number { color: #10b981; }
        .summary-card.maintenance .number { color: #f59e0b; }
        .summary-card.out-of-service .number { color: #ef4444; }
        .summary-card.total .number { color: #3b82f6; }
        
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
        
        .btn-schedule {
            background: #f59e0b;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-schedule:hover {
            background: #d97706;
        }
        
        .btn-add {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-add:hover {
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
        .maintain-link { color: #10b981; }
        .calibrate-link { color: #f59e0b; }

        .status-operational { 
            background: #d1fae5; 
            color: #065f46; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 12px; 
            font-weight: 600; 
        }
        .status-maintenance { 
            background: #fef3c7; 
            color: #92400e; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 12px; 
            font-weight: 600; 
        }
        .status-out-of-service { 
            background: #fee2e2; 
            color: #991b1b; 
            padding: 4px 8px; 
            border-radius: 4px; 
            font-size: 12px; 
            font-weight: 600; 
        }

        .usage-bar {
            width: 100%;
            height: 8px;
            background-color: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 4px;
        }

        .usage-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .usage-low { background-color: #10b981; }
        .usage-medium { background-color: #f59e0b; }
        .usage-high { background-color: #ef4444; }
        .usage-none { background-color: #6b7280; }

        .equipment-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .equipment-model {
            font-size: 12px;
            color: #6b7280;
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

        .btn-schedule-maintenance {
            background: #f59e0b;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-schedule-maintenance:hover {
            background: #d97706;
        }

        .btn-add-equipment {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-add-equipment:hover {
            background: #0056b3;
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

        /* Equipment Details Modal Styles */
        .equipment-details-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 90%;
            max-width: 700px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin: 20px 0;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
        }

        .detail-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .detail-value {
            color: #2c3e50;
            font-size: 16px;
            font-weight: 500;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-operational-badge {
            background: #d1fae5;
            color: #065f46;
        }

        .status-maintenance-badge {
            background: #fef3c7;
            color: #92400e;
        }

        .status-out-of-service-badge {
            background: #fee2e2;
            color: #991b1b;
        }

        .usage-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .usage-section h5 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .usage-bar-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .usage-bar-large {
            flex: 1;
            height: 12px;
            background-color: #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
        }

        .usage-fill-large {
            height: 100%;
            background-color: #f59e0b;
            border-radius: 6px;
            transition: width 0.3s ease;
        }

        .usage-percentage {
            font-weight: 600;
            color: #2c3e50;
            font-size: 16px;
        }

        .equipment-details-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
        }

        .btn-update-status {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-update-status:hover {
            background: #0056b3;
        }

        /* Maintain Equipment Modal Styles */
        .maintain-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .maintenance-type-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .maintenance-type-section h5 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .maintenance-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .maintenance-option {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }

        .maintenance-option:hover {
            border-color: #007bff;
            background: #f8f9ff;
        }

        .maintenance-option.selected {
            border-color: #007bff;
            background: #e3f2fd;
        }

        .maintenance-option i {
            font-size: 24px;
            margin-bottom: 8px;
            display: block;
        }

        .maintenance-option h6 {
            margin: 0;
            color: #2c3e50;
            font-weight: 600;
        }

        .maintenance-option p {
            margin: 5px 0 0 0;
            color: #6c757d;
            font-size: 12px;
        }

        .btn-maintain-equipment {
            background: #10b981;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-maintain-equipment:hover {
            background: #059669;
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
                <a class="nav-link active" href="<?= site_url('laboratory/equipment/status') ?>">
                    <i class="fas fa-tools me-2"></i> Equipment
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory/tracking') ?>">
                    <i class="fas fa-search me-2"></i> Sample Tracking
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= site_url('laboratory/reports') ?>">
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
                    <h2 class="mb-1">Equipment Status</h2>
                    <p class="text-muted mb-0">Monitor and manage laboratory equipment status</p>
                </div>
                <div>
                    <button class="btn btn-schedule me-2">
                        <i class="fas fa-wrench me-2"></i> Schedule Maintenance
                    </button>
                    <button class="btn btn-add">
                        <i class="fas fa-plus me-2"></i> + Add Equipment
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="summary-card total">
                    <i class="fas fa-tools fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted">Total Equipment</h6>
                    <div class="number">24</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card operational">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h6 class="text-muted">Operational</h6>
                    <div class="number">18</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card maintenance">
                    <i class="fas fa-wrench fa-2x text-warning mb-2"></i>
                    <h6 class="text-muted">Needs Maintenance</h6>
                    <div class="number">4</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card out-of-service">
                    <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                    <h6 class="text-muted">Out of Service</h6>
                    <div class="number">2</div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>EQUIPMENT</th>
                        <th>LOCATION</th>
                        <th>STATUS</th>
                        <th>USAGE</th>
                        <th>NEXT MAINTENANCE</th>
                        <th>TECHNICIAN</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="equipment-name">Automated Hematology Analyzer</div>
                            <div class="equipment-model">Sysmex XN-1000</div>
                        </td>
                        <td>Hematology Lab</td>
                        <td><span class="status-operational">Operational</span></td>
                        <td>
                            <div>85%</div>
                            <div class="usage-bar">
                                <div class="usage-fill usage-high" style="width: 85%"></div>
                            </div>
                        </td>
                        <td>2024-02-10</td>
                        <td>John Martinez</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewEquipment('EQ-001')">View</a>
                            <a href="#" class="action-link maintain-link" onclick="maintainEquipment('EQ-001')">Maintain</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="equipment-name">Chemistry Analyzer</div>
                            <div class="equipment-model">Roche Cobas 8000</div>
                        </td>
                        <td>Chemistry Lab</td>
                        <td><span class="status-maintenance">Maintenance Required</span></td>
                        <td>
                            <div>95%</div>
                            <div class="usage-bar">
                                <div class="usage-fill usage-high" style="width: 95%"></div>
                            </div>
                        </td>
                        <td>2024-01-15</td>
                        <td>Sarah Garcia</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewEquipment('EQ-002')">View</a>
                            <a href="#" class="action-link maintain-link" onclick="maintainEquipment('EQ-002')">Maintain</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="equipment-name">Microscope</div>
                            <div class="equipment-model">Olympus BX53</div>
                        </td>
                        <td>Pathology Lab</td>
                        <td><span class="status-operational">Operational</span></td>
                        <td>
                            <div>60%</div>
                            <div class="usage-bar">
                                <div class="usage-fill usage-medium" style="width: 60%"></div>
                            </div>
                        </td>
                        <td>2024-04-05</td>
                        <td>Mike Rodriguez</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewEquipment('EQ-003')">View</a>
                            <a href="#" class="action-link maintain-link" onclick="maintainEquipment('EQ-003')">Maintain</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="equipment-name">PCR Machine</div>
                            <div class="equipment-model">Applied Biosystems 7500</div>
                        </td>
                        <td>Molecular Lab</td>
                        <td><span class="status-out-of-service">Out of Service</span></td>
                        <td>
                            <div>0%</div>
                            <div class="usage-bar">
                                <div class="usage-fill usage-none" style="width: 0%"></div>
                            </div>
                        </td>
                        <td>2024-01-20</td>
                        <td>Lisa Chen</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewEquipment('EQ-004')">View</a>
                            <a href="#" class="action-link maintain-link" onclick="maintainEquipment('EQ-004')">Maintain</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="equipment-name">Centrifuge</div>
                            <div class="equipment-model">Eppendorf 5430R</div>
                        </td>
                        <td>General Lab</td>
                        <td><span class="status-operational">Operational</span></td>
                        <td>
                            <div>70%</div>
                            <div class="usage-bar">
                                <div class="usage-fill usage-medium" style="width: 70%"></div>
                            </div>
                        </td>
                        <td>2024-03-12</td>
                        <td>David Park</td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="viewEquipment('EQ-005')">View</a>
                            <a href="#" class="action-link maintain-link" onclick="maintainEquipment('EQ-005')">Maintain</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Schedule Maintenance Modal -->
    <div class="modal-overlay" id="scheduleMaintenanceModal">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Schedule Maintenance</h4>
                <button class="close-btn" onclick="closeScheduleMaintenanceModal()">&times;</button>
            </div>
            
            <form id="scheduleMaintenanceForm">
                <div class="form-group">
                    <label for="equipment">Equipment</label>
                    <select class="form-select" id="equipment" name="equipment" required>
                        <option value="">Select equipment</option>
                        <option value="EQ-001">Automated Hematology Analyzer - Sysmex XN-1000</option>
                        <option value="EQ-002">Chemistry Analyzer - Roche Cobas 8000</option>
                        <option value="EQ-003">Microscope - Olympus BX53</option>
                        <option value="EQ-004">PCR Machine - Applied Biosystems 7500</option>
                        <option value="EQ-005">Centrifuge - Eppendorf 5430R</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="maintenanceType">Maintenance Type</label>
                    <select class="form-select" id="maintenanceType" name="maintenanceType" required>
                        <option value="preventive">Preventive Maintenance</option>
                        <option value="corrective">Corrective Maintenance</option>
                        <option value="emergency">Emergency Maintenance</option>
                        <option value="calibration">Calibration</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select class="form-select" id="priority" name="priority" required>
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="scheduledDate">Scheduled Date</label>
                    <div class="date-input-group">
                        <input type="date" class="form-control" id="scheduledDate" name="scheduledDate" required>
                        <i class="fas fa-calendar-alt date-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="assignedTechnician">Assigned Technician</label>
                    <select class="form-select" id="assignedTechnician" name="assignedTechnician" required>
                        <option value="">Select technician</option>
                        <option value="john-martinez" selected>John Martinez</option>
                        <option value="sarah-garcia">Sarah Garcia</option>
                        <option value="mike-rodriguez">Mike Rodriguez</option>
                        <option value="lisa-chen">Lisa Chen</option>
                        <option value="david-park">David Park</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe the maintenance work to be performed"></textarea>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeScheduleMaintenanceModal()">Cancel</button>
                    <button type="submit" class="btn-schedule-maintenance">Schedule Maintenance</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Equipment Modal -->
    <div class="modal-overlay" id="addEquipmentModal">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Add New Equipment</h4>
                <button class="close-btn" onclick="closeAddEquipmentModal()">&times;</button>
            </div>
            
            <form id="addEquipmentForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="equipmentName">Equipment Name</label>
                            <input type="text" class="form-control" id="equipmentName" name="equipmentName" placeholder="Enter equipment name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="model">Model</label>
                            <input type="text" class="form-control" id="model" name="model" placeholder="Enter model number" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="serialNumber">Serial Number</label>
                            <input type="text" class="form-control" id="serialNumber" name="serialNumber" placeholder="Enter serial number" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <select class="form-select" id="location" name="location" required>
                                <option value="">Select location</option>
                                <option value="hematology-lab">Hematology Lab</option>
                                <option value="chemistry-lab">Chemistry Lab</option>
                                <option value="pathology-lab">Pathology Lab</option>
                                <option value="molecular-lab">Molecular Lab</option>
                                <option value="general-lab">General Lab</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="assignedTechnician">Assigned Technician</label>
                            <select class="form-select" id="assignedTechnicianAdd" name="assignedTechnician" required>
                                <option value="">Select technician</option>
                                <option value="john-martinez">John Martinez</option>
                                <option value="sarah-garcia">Sarah Garcia</option>
                                <option value="mike-rodriguez">Mike Rodriguez</option>
                                <option value="lisa-chen">Lisa Chen</option>
                                <option value="david-park">David Park</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purchaseDate">Purchase Date</label>
                            <div class="date-input-group">
                                <input type="date" class="form-control" id="purchaseDate" name="purchaseDate" required>
                                <i class="fas fa-calendar-alt date-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="warrantyEndDate">Warranty End Date</label>
                            <div class="date-input-group">
                                <input type="date" class="form-control" id="warrantyEndDate" name="warrantyEndDate" required>
                                <i class="fas fa-calendar-alt date-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="maintenanceInterval">Maintenance Interval (days)</label>
                            <input type="number" class="form-control" id="maintenanceInterval" name="maintenanceInterval" value="30" min="1" required>
                        </div>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeAddEquipmentModal()">Cancel</button>
                    <button type="submit" class="btn-add-equipment">Add Equipment</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Equipment Details Modal -->
    <div class="modal-overlay" id="equipmentDetailsModal">
        <div class="equipment-details-content">
            <div class="modal-header">
                <h4>Equipment Details</h4>
                <button class="close-btn" onclick="closeEquipmentDetailsModal()">&times;</button>
            </div>
            
            <div class="details-grid">
                <div>
                    <div class="detail-item">
                        <div class="detail-label">Equipment ID</div>
                        <div class="detail-value" id="detailEquipmentId">EQ-001</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Name</div>
                        <div class="detail-value" id="detailEquipmentName">Automated Hematology Analyzer</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Model</div>
                        <div class="detail-value" id="detailModel">Sysmex XN-1000</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Location</div>
                        <div class="detail-value" id="detailLocation">Hematology Lab</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Status</div>
                        <div class="detail-value">
                            <span class="status-badge status-operational-badge" id="detailStatus">Operational</span>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="detail-item">
                        <div class="detail-label">Assigned Technician</div>
                        <div class="detail-value" id="detailTechnician">John Martinez</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Last Maintenance</div>
                        <div class="detail-value" id="detailLastMaintenance">2024-01-10</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Next Maintenance</div>
                        <div class="detail-value" id="detailNextMaintenance">2024-02-10</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Calibration Date</div>
                        <div class="detail-value" id="detailCalibrationDate">2024-01-15</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Warranty Status</div>
                        <div class="detail-value" id="detailWarrantyStatus">Active until 2025-06-30</div>
                    </div>
                </div>
            </div>

            <div class="usage-section">
                <h5>Usage Statistics</h5>
                <div class="usage-bar-container">
                    <div class="usage-bar-large">
                        <div class="usage-fill-large" id="detailUsageBar" style="width: 85%"></div>
                    </div>
                    <div class="usage-percentage" id="detailUsagePercentage">85%</div>
                </div>
            </div>

            <div class="equipment-details-actions">
                <button class="btn-cancel" onclick="closeEquipmentDetailsModal()">Close</button>
                <button class="btn-schedule-maintenance" onclick="scheduleMaintenanceFromDetails()">Schedule Maintenance</button>
                <button class="btn-update-status" onclick="updateEquipmentStatus()">Update Status</button>
            </div>
        </div>
    </div>

    <!-- Maintain Equipment Modal -->
    <div class="modal-overlay" id="maintainEquipmentModal">
        <div class="maintain-content">
            <div class="modal-header">
                <h4>Maintain Equipment</h4>
                <button class="close-btn" onclick="closeMaintainEquipmentModal()">&times;</button>
            </div>
            
            <form id="maintainEquipmentForm">
                <div class="form-group">
                    <label for="maintainEquipmentSelect">Equipment</label>
                    <select class="form-select" id="maintainEquipmentSelect" name="equipment" required>
                        <option value="">Select equipment to maintain</option>
                        <option value="EQ-001">Automated Hematology Analyzer - Sysmex XN-1000</option>
                        <option value="EQ-002">Chemistry Analyzer - Roche Cobas 8000</option>
                        <option value="EQ-003">Microscope - Olympus BX53</option>
                        <option value="EQ-004">PCR Machine - Applied Biosystems 7500</option>
                        <option value="EQ-005">Centrifuge - Eppendorf 5430R</option>
                    </select>
                </div>

                <div class="maintenance-type-section">
                    <h5>Maintenance Type</h5>
                    <div class="maintenance-options">
                        <div class="maintenance-option" onclick="selectMaintenanceType('preventive')">
                            <i class="fas fa-tools text-primary"></i>
                            <h6>Preventive</h6>
                            <p>Regular maintenance</p>
                        </div>
                        <div class="maintenance-option" onclick="selectMaintenanceType('corrective')">
                            <i class="fas fa-wrench text-warning"></i>
                            <h6>Corrective</h6>
                            <p>Fix issues</p>
                        </div>
                        <div class="maintenance-option" onclick="selectMaintenanceType('calibration')">
                            <i class="fas fa-cog text-info"></i>
                            <h6>Calibration</h6>
                            <p>Adjust settings</p>
                        </div>
                        <div class="maintenance-option" onclick="selectMaintenanceType('emergency')">
                            <i class="fas fa-exclamation-triangle text-danger"></i>
                            <h6>Emergency</h6>
                            <p>Urgent repair</p>
                        </div>
                    </div>
                    <input type="hidden" id="selectedMaintenanceType" name="maintenanceType" required>
                </div>

                <div class="form-group">
                    <label for="maintenanceDescription">Description</label>
                    <textarea class="form-control" id="maintenanceDescription" name="description" rows="4" placeholder="Describe the maintenance work performed" required></textarea>
                </div>

                <div class="form-group">
                    <label for="maintenanceTechnician">Technician</label>
                    <select class="form-select" id="maintenanceTechnician" name="technician" required>
                        <option value="">Select technician</option>
                        <option value="john-martinez">John Martinez</option>
                        <option value="sarah-garcia">Sarah Garcia</option>
                        <option value="mike-rodriguez">Mike Rodriguez</option>
                        <option value="lisa-chen">Lisa Chen</option>
                        <option value="david-park">David Park</option>
                    </select>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeMaintainEquipmentModal()">Cancel</button>
                    <button type="submit" class="btn-maintain-equipment">Complete Maintenance</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Equipment status functions
        document.querySelector('.btn-schedule').addEventListener('click', function() {
            openScheduleMaintenanceModal();
        });

        document.querySelector('.btn-add').addEventListener('click', function() {
            openAddEquipmentModal();
        });

        // Schedule Maintenance Modal functions
        function openScheduleMaintenanceModal() {
            document.getElementById('scheduleMaintenanceModal').style.display = 'flex';
        }

        function closeScheduleMaintenanceModal() {
            document.getElementById('scheduleMaintenanceModal').style.display = 'none';
        }

        // Add Equipment Modal functions
        function openAddEquipmentModal() {
            document.getElementById('addEquipmentModal').style.display = 'flex';
        }

        function closeAddEquipmentModal() {
            document.getElementById('addEquipmentModal').style.display = 'none';
        }

        // Close modals when clicking outside
        document.getElementById('scheduleMaintenanceModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeScheduleMaintenanceModal();
            }
        });

        document.getElementById('addEquipmentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddEquipmentModal();
            }
        });

        // Form submissions
        document.getElementById('scheduleMaintenanceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const equipment = formData.get('equipment');
            const maintenanceType = formData.get('maintenanceType');
            const priority = formData.get('priority');
            const scheduledDate = formData.get('scheduledDate');
            const assignedTechnician = formData.get('assignedTechnician');
            const description = formData.get('description');
            
            console.log('Schedule Maintenance Data:', {
                equipment,
                maintenanceType,
                priority,
                scheduledDate,
                assignedTechnician,
                description
            });
            
            alert('Maintenance scheduled successfully!');
            closeScheduleMaintenanceModal();
        });

        document.getElementById('addEquipmentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const equipmentName = formData.get('equipmentName');
            const model = formData.get('model');
            const serialNumber = formData.get('serialNumber');
            const location = formData.get('location');
            const assignedTechnician = formData.get('assignedTechnician');
            const purchaseDate = formData.get('purchaseDate');
            const warrantyEndDate = formData.get('warrantyEndDate');
            const maintenanceInterval = formData.get('maintenanceInterval');
            
            console.log('Add Equipment Data:', {
                equipmentName,
                model,
                serialNumber,
                location,
                assignedTechnician,
                purchaseDate,
                warrantyEndDate,
                maintenanceInterval
            });
            
            alert('Equipment added successfully!');
            closeAddEquipmentModal();
        });

        // Equipment Details Modal functions
        function openEquipmentDetailsModal(equipmentId, equipmentName, model, location, status, technician, lastMaintenance, nextMaintenance, calibrationDate, warrantyStatus, usage) {
            // Update modal content with passed data
            document.getElementById('detailEquipmentId').textContent = equipmentId;
            document.getElementById('detailEquipmentName').textContent = equipmentName;
            document.getElementById('detailModel').textContent = model;
            document.getElementById('detailLocation').textContent = location;
            document.getElementById('detailTechnician').textContent = technician;
            document.getElementById('detailLastMaintenance').textContent = lastMaintenance;
            document.getElementById('detailNextMaintenance').textContent = nextMaintenance;
            document.getElementById('detailCalibrationDate').textContent = calibrationDate;
            document.getElementById('detailWarrantyStatus').textContent = warrantyStatus;
            document.getElementById('detailUsagePercentage').textContent = usage + '%';
            document.getElementById('detailUsageBar').style.width = usage + '%';
            
            // Update status badge
            const statusBadge = document.getElementById('detailStatus');
            statusBadge.textContent = status;
            statusBadge.className = 'status-badge';
            if (status === 'Operational') {
                statusBadge.classList.add('status-operational-badge');
            } else if (status === 'Maintenance Required') {
                statusBadge.classList.add('status-maintenance-badge');
            } else if (status === 'Out of Service') {
                statusBadge.classList.add('status-out-of-service-badge');
            }
            
            // Show modal
            document.getElementById('equipmentDetailsModal').style.display = 'flex';
        }

        function closeEquipmentDetailsModal() {
            document.getElementById('equipmentDetailsModal').style.display = 'none';
        }

        function scheduleMaintenanceFromDetails() {
            closeEquipmentDetailsModal();
            openScheduleMaintenanceModal();
        }

        function updateEquipmentStatus() {
            alert('Update Equipment Status functionality would be implemented here');
        }

        // Maintain Equipment Modal functions
        function openMaintainEquipmentModal(equipmentId) {
            if (equipmentId) {
                document.getElementById('maintainEquipmentSelect').value = equipmentId;
            }
            document.getElementById('maintainEquipmentModal').style.display = 'flex';
        }

        function closeMaintainEquipmentModal() {
            document.getElementById('maintainEquipmentModal').style.display = 'none';
            // Reset form
            document.getElementById('maintainEquipmentForm').reset();
            document.querySelectorAll('.maintenance-option').forEach(option => {
                option.classList.remove('selected');
            });
        }

        function selectMaintenanceType(type) {
            // Remove selected class from all options
            document.querySelectorAll('.maintenance-option').forEach(option => {
                option.classList.remove('selected');
            });
            
            // Add selected class to clicked option
            event.currentTarget.classList.add('selected');
            
            // Set hidden input value
            document.getElementById('selectedMaintenanceType').value = type;
        }

        // Close modals when clicking outside
        document.getElementById('equipmentDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEquipmentDetailsModal();
            }
        });

        document.getElementById('maintainEquipmentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeMaintainEquipmentModal();
            }
        });

        // Maintain Equipment form submission
        document.getElementById('maintainEquipmentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const equipment = formData.get('equipment');
            const maintenanceType = formData.get('maintenanceType');
            const description = formData.get('description');
            const technician = formData.get('technician');
            
            console.log('Maintain Equipment Data:', {
                equipment,
                maintenanceType,
                description,
                technician
            });
            
            alert('Maintenance completed successfully!');
            closeMaintainEquipmentModal();
        });

        function viewEquipment(equipmentId) {
            // Sample data for different equipment
            const equipmentData = {
                'EQ-001': {
                    name: 'Automated Hematology Analyzer',
                    model: 'Sysmex XN-1000',
                    location: 'Hematology Lab',
                    status: 'Operational',
                    technician: 'John Martinez',
                    lastMaintenance: '2024-01-10',
                    nextMaintenance: '2024-02-10',
                    calibrationDate: '2024-01-15',
                    warrantyStatus: 'Active until 2025-06-30',
                    usage: 85
                },
                'EQ-002': {
                    name: 'Chemistry Analyzer',
                    model: 'Roche Cobas 8000',
                    location: 'Chemistry Lab',
                    status: 'Maintenance Required',
                    technician: 'Sarah Garcia',
                    lastMaintenance: '2024-01-05',
                    nextMaintenance: '2024-01-15',
                    calibrationDate: '2024-01-12',
                    warrantyStatus: 'Active until 2025-03-15',
                    usage: 95
                },
                'EQ-003': {
                    name: 'Microscope',
                    model: 'Olympus BX53',
                    location: 'Pathology Lab',
                    status: 'Operational',
                    technician: 'Mike Rodriguez',
                    lastMaintenance: '2024-01-08',
                    nextMaintenance: '2024-04-05',
                    calibrationDate: '2024-01-20',
                    warrantyStatus: 'Active until 2026-01-10',
                    usage: 60
                },
                'EQ-004': {
                    name: 'PCR Machine',
                    model: 'Applied Biosystems 7500',
                    location: 'Molecular Lab',
                    status: 'Out of Service',
                    technician: 'Lisa Chen',
                    lastMaintenance: '2024-01-12',
                    nextMaintenance: '2024-01-20',
                    calibrationDate: '2024-01-18',
                    warrantyStatus: 'Active until 2025-09-30',
                    usage: 0
                },
                'EQ-005': {
                    name: 'Centrifuge',
                    model: 'Eppendorf 5430R',
                    location: 'General Lab',
                    status: 'Operational',
                    technician: 'David Park',
                    lastMaintenance: '2024-01-15',
                    nextMaintenance: '2024-03-12',
                    calibrationDate: '2024-01-22',
                    warrantyStatus: 'Active until 2025-12-20',
                    usage: 70
                }
            };

            const data = equipmentData[equipmentId] || equipmentData['EQ-001'];
            openEquipmentDetailsModal(
                equipmentId,
                data.name,
                data.model,
                data.location,
                data.status,
                data.technician,
                data.lastMaintenance,
                data.nextMaintenance,
                data.calibrationDate,
                data.warrantyStatus,
                data.usage
            );
        }

        function maintainEquipment(equipmentId) {
            openMaintainEquipmentModal(equipmentId);
        }
    </script>
</body>
</html>