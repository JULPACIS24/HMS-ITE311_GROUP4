<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Results - San Miguel HMS</title>
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
        .summary-card.pending .number { color: #3b82f6; }
        .summary-card.critical .number { color: #ef4444; }
        .summary-card.today .number { color: #10b981; }
        
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
        
        .btn-export {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-enter-results {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-enter-results:hover {
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
        .print-link { color: #3b82f6; }
        .send-link { color: #3b82f6; }

        .status-completed { color: #10b981; font-weight: 600; }
        .status-ready { color: #3b82f6; font-weight: 600; }
        .status-pending { color: #f59e0b; font-weight: 600; }

        .flags-critical { color: #ef4444; font-weight: 600; }

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
            max-width: 800px;
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

        .test-parameters {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .test-parameters h5 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .parameters-table {
            width: 100%;
            border-collapse: collapse;
        }

        .parameters-table th {
            background: #e9ecef;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            border: 1px solid #dee2e6;
        }

        .parameters-table td {
            padding: 12px;
            border: 1px solid #dee2e6;
            background: white;
        }

        .parameters-table input, .parameters-table select {
            width: 100%;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 8px;
            font-size: 13px;
        }

        .add-parameter-link {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
            margin-top: 10px;
            display: inline-block;
        }

        .add-parameter-link:hover {
            text-decoration: underline;
        }

        .comments-section {
            margin: 20px 0;
        }

        .comments-section label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .comments-textarea {
            width: 100%;
            min-height: 100px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            resize: vertical;
        }

        .comments-textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
            outline: none;
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

        .btn-save {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-save:hover {
            background: #218838;
        }

        /* View Details Modal Styles */
        .view-modal-content {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 85%;
            max-width: 700px;
            max-height: 85vh;
            overflow-y: auto;
        }

        .patient-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
        }

        .patient-info h5 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .info-value {
            color: #2c3e50;
            font-size: 16px;
            font-weight: 500;
        }

        .test-status {
            background: #e8f5e8;
            padding: 12px;
            border-radius: 8px;
            margin: 15px 0;
            border-left: 4px solid #28a745;
        }

        .test-status h5 {
            color: #2c3e50;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .status-completed {
            color: #28a745;
            font-weight: 600;
            font-size: 18px;
        }

        .technician-info {
            color: #6c757d;
            margin: 5px 0;
        }

        .critical-alert {
            color: #dc3545;
            font-weight: 600;
            margin: 10px 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .test-results-table {
            margin: 15px 0;
        }

        .test-results-table h5 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .results-table th {
            background: #f8f9fa;
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #dee2e6;
            font-size: 13px;
        }

        .results-table td {
            padding: 8px;
            border-bottom: 1px solid #dee2e6;
            font-size: 13px;
        }

        .results-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .flag-high { color: #dc3545; font-weight: 600; }
        .flag-normal { color: #28a745; font-weight: 600; }
        .flag-low { color: #fd7e14; font-weight: 600; }

        .view-modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #e9ecef;
        }

        .btn-close-modal {
            background: #6c757d;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-close-modal:hover {
            background: #5a6268;
        }

        .btn-print {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-print:hover {
            background: #218838;
        }

        .btn-send {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-send:hover {
            background: #0056b3;
        }

        /* Print Styles */
        @media print {
            body * {
                visibility: hidden;
            }
            .print-content, .print-content * {
                visibility: visible;
            }
            .print-content {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none !important;
            }
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
                <a class="nav-link active" href="<?= site_url('laboratory/test/results') ?>">
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
                    <h2 class="mb-1">Test Results</h2>
                    <p class="text-muted mb-0">View and manage laboratory test results</p>
                </div>
                <div>
                    <button class="btn btn-export me-2">
                        <i class="fas fa-download me-2"></i> Export
                    </button>
                    <button class="btn btn-enter-results">
                        <i class="fas fa-plus me-2"></i> + Enter Results
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="summary-card total">
                    <i class="fas fa-file-alt fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted">Total Results</h6>
                    <div class="number">89</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card pending">
                    <i class="fas fa-eye fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted">Pending Review</h6>
                    <div class="number">12</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card critical">
                    <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                    <h6 class="text-muted">Critical Results</h6>
                    <div class="number">5</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card today">
                    <i class="fas fa-calendar-day fa-2x text-success mb-2"></i>
                    <h6 class="text-muted">Today's Results</h6>
                    <div class="number">23</div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>RESULT ID</th>
                        <th>PATIENT</th>
                        <th>TEST</th>
                        <th>STATUS</th>
                        <th>TECHNICIAN</th>
                        <th>COMPLETED</th>
                        <th>FLAGS</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-bold">LAB-001</td>
                        <td>Maria Santos (P-12345)</td>
                        <td>Complete Blood Count</td>
                        <td><span class="status-completed">Completed</span></td>
                        <td>John Martinez</td>
                        <td>2024-01-16</td>
                        <td><span class="flags-critical">▲ Critical</span></td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="openViewDetailsModal('LAB-001', 'Maria Santos', 'P-12345', 'Complete Blood Count', '2024-01-16', 'John Martinez')">View</a>
                            <a href="#" class="action-link print-link" onclick="printResult('LAB-001')">Print</a>
                            <a href="#" class="action-link send-link" onclick="sendResult('LAB-001')">Send</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">LAB-002</td>
                        <td>Juan Dela Cruz (P-12346)</td>
                        <td>Lipid Profile</td>
                        <td><span class="status-completed">Completed</span></td>
                        <td>Sarah Garcia</td>
                        <td>2024-01-16</td>
                        <td></td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="openViewDetailsModal('LAB-001', 'Maria Santos', 'P-12345', 'Complete Blood Count', '2024-01-16', 'John Martinez')">View</a>
                            <a href="#" class="action-link print-link" onclick="printResult('LAB-001')">Print</a>
                            <a href="#" class="action-link send-link" onclick="sendResult('LAB-001')">Send</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">LAB-003</td>
                        <td>Ana Reyes (P-12347)</td>
                        <td>Urinalysis</td>
                        <td><span class="status-ready">Ready for Review</span></td>
                        <td>Mike Rodriguez</td>
                        <td>2024-01-16</td>
                        <td></td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="openViewDetailsModal('LAB-001', 'Maria Santos', 'P-12345', 'Complete Blood Count', '2024-01-16', 'John Martinez')">View</a>
                            <a href="#" class="action-link print-link" onclick="printResult('LAB-001')">Print</a>
                            <a href="#" class="action-link send-link" onclick="sendResult('LAB-001')">Send</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">LAB-004</td>
                        <td>Carlos Mendoza (P-12348)</td>
                        <td>Blood Chemistry</td>
                        <td><span class="status-pending">Pending</span></td>
                        <td>Lisa Wilson</td>
                        <td>2024-01-16</td>
                        <td></td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="openViewDetailsModal('LAB-001', 'Maria Santos', 'P-12345', 'Complete Blood Count', '2024-01-16', 'John Martinez')">View</a>
                            <a href="#" class="action-link print-link" onclick="printResult('LAB-001')">Print</a>
                            <a href="#" class="action-link send-link" onclick="sendResult('LAB-001')">Send</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-bold">LAB-005</td>
                        <td>Lisa Wong (P-12349)</td>
                        <td>Thyroid Function</td>
                        <td><span class="status-completed">Completed</span></td>
                        <td>David Kim</td>
                        <td>2024-01-16</td>
                        <td><span class="flags-critical">▲ Critical</span></td>
                        <td>
                            <a href="#" class="action-link view-link" onclick="openViewDetailsModal('LAB-001', 'Maria Santos', 'P-12345', 'Complete Blood Count', '2024-01-16', 'John Martinez')">View</a>
                            <a href="#" class="action-link print-link" onclick="printResult('LAB-001')">Print</a>
                            <a href="#" class="action-link send-link" onclick="sendResult('LAB-001')">Send</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Enter Results Modal -->
    <div class="modal-overlay" id="enterResultsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Enter Test Results</h4>
                <button class="close-btn" onclick="closeEnterResultsModal()">&times;</button>
            </div>
            
            <form id="enterResultsForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="testRequestId">Test Request ID</label>
                            <select class="form-select" id="testRequestId" name="testRequestId" required>
                                <option value="">Select test request</option>
                                <option value="LAB-001">LAB-001 - Maria Santos (Complete Blood Count)</option>
                                <option value="LAB-002">LAB-002 - Juan Dela Cruz (Lipid Profile)</option>
                                <option value="LAB-003">LAB-003 - Ana Reyes (Urinalysis)</option>
                                <option value="LAB-004">LAB-004 - Carlos Mendoza (Blood Chemistry)</option>
                                <option value="LAB-005">LAB-005 - Lisa Wong (Thyroid Function)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="technician">Technician</label>
                            <input type="text" class="form-control" id="technician" name="technician" value="John Martinez" readonly>
                        </div>
                    </div>
                </div>

                <div class="test-parameters">
                    <h5>Test Parameters</h5>
                    <table class="parameters-table">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Result</th>
                                <th>Unit</th>
                                <th>Flag</th>
                            </tr>
                        </thead>
                        <tbody id="parametersTableBody">
                            <tr>
                                <td>
                                    <input type="text" class="form-control" value="WBC" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="10.5" placeholder="Enter result">
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="x10³/μL" readonly>
                                </td>
                                <td>
                                    <select class="form-select">
                                        <option value="Normal" selected>Normal</option>
                                        <option value="High">High</option>
                                        <option value="Low">Low</option>
                                        <option value="Critical">Critical</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="#" class="add-parameter-link" onclick="addParameter()">+ Add Parameter</a>
                </div>

                <div class="comments-section">
                    <label for="comments">Comments/Notes</label>
                    <textarea class="comments-textarea" id="comments" name="comments" placeholder="Enter any additional comments or observations"></textarea>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeEnterResultsModal()">Cancel</button>
                    <button type="submit" class="btn-save">Save Results</button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Details Modal -->
    <div class="modal-overlay" id="viewDetailsModal">
        <div class="view-modal-content">
            <div class="modal-header">
                <h4>Test Result Details</h4>
                <button class="close-btn" onclick="closeViewDetailsModal()">&times;</button>
            </div>
            
            <div class="print-content">
                <!-- Patient Information -->
                <div class="patient-info">
                    <h5>Patient Information</h5>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Patient Name</div>
                            <div class="info-value" id="viewPatientName">Maria Santos</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Patient ID</div>
                            <div class="info-value" id="viewPatientId">P-12345</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Test Type</div>
                            <div class="info-value" id="viewTestType">Complete Blood Count</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Completed Date</div>
                            <div class="info-value" id="viewCompletedDate">2024-01-16</div>
                        </div>
                    </div>
                </div>

                <!-- Test Status -->
                <div class="test-status">
                    <h5>Test Status</h5>
                    <div class="status-completed">Completed</div>
                    <div class="technician-info">Technician: <span id="viewTechnician">John Martinez</span></div>
                    <div class="critical-alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        Critical Values Detected
                    </div>
                </div>

                <!-- Test Results -->
                <div class="test-results-table">
                    <h5>Test Results</h5>
                    <table class="results-table">
                        <thead>
                            <tr>
                                <th>PARAMETER</th>
                                <th>RESULT</th>
                                <th>UNIT</th>
                                <th>REFERENCE RANGE</th>
                                <th>FLAG</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>WBC</strong></td>
                                <td>12.5</td>
                                <td>x10⁵/µL</td>
                                <td>4.0-11.0</td>
                                <td><span class="flag-high">High</span></td>
                            </tr>
                            <tr>
                                <td><strong>RBC</strong></td>
                                <td>4.2</td>
                                <td>x10⁵/µL</td>
                                <td>4.2-5.4</td>
                                <td><span class="flag-normal">Normal</span></td>
                            </tr>
                            <tr>
                                <td><strong>Hemoglobin</strong></td>
                                <td>8.5</td>
                                <td>g/dL</td>
                                <td>12.0-15.5</td>
                                <td><span class="flag-low">Low</span></td>
                            </tr>
                            <tr>
                                <td><strong>Hematocrit</strong></td>
                                <td>25.2</td>
                                <td>%</td>
                                <td>36.0-46.0</td>
                                <td><span class="flag-low">Low</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="view-modal-actions no-print">
                <button class="btn-close-modal" onclick="closeViewDetailsModal()">Close</button>
                <button class="btn-print" onclick="printTestResult()">Print Report</button>
                <button class="btn-send" onclick="sendToDoctor()">Send to Doctor</button>
            </div>
        </div>
    </div>

    <script>
        // Add any JavaScript functionality here
        document.querySelector('.btn-export').addEventListener('click', function() {
            alert('Export functionality would be implemented here');
        });

        document.querySelector('.btn-enter-results').addEventListener('click', function() {
            openEnterResultsModal();
        });

        // Modal functions
        function openEnterResultsModal() {
            document.getElementById('enterResultsModal').style.display = 'flex';
        }

        function closeEnterResultsModal() {
            document.getElementById('enterResultsModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('enterResultsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEnterResultsModal();
            }
        });

        // Add parameter row
        function addParameter() {
            const tbody = document.getElementById('parametersTableBody');
            const newRow = tbody.insertRow();
            
            newRow.innerHTML = `
                <td>
                    <input type="text" class="form-control" placeholder="Enter parameter">
                </td>
                <td>
                    <input type="text" class="form-control" placeholder="Enter result">
                </td>
                <td>
                    <input type="text" class="form-control" placeholder="Enter unit">
                </td>
                <td>
                    <select class="form-select">
                        <option value="Normal">Normal</option>
                        <option value="High">High</option>
                        <option value="Low">Low</option>
                        <option value="Critical">Critical</option>
                    </select>
                </td>
            `;
        }

        // Form submission
        document.getElementById('enterResultsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            const testRequestId = formData.get('testRequestId');
            const technician = formData.get('technician');
            const comments = formData.get('comments');
            
            // Get parameters data
            const parameters = [];
            const rows = document.querySelectorAll('#parametersTableBody tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length === 4) {
                    const parameter = cells[0].querySelector('input').value;
                    const result = cells[1].querySelector('input').value;
                    const unit = cells[2].querySelector('input').value;
                    const flag = cells[3].querySelector('select').value;
                    
                    if (parameter && result) {
                        parameters.push({ parameter, result, unit, flag });
                    }
                }
            });
            
            console.log('Test Results Data:', {
                testRequestId,
                technician,
                parameters,
                comments
            });
            
            alert('Test results saved successfully!');
            closeEnterResultsModal();
        });

        // View Details Modal functions
        function openViewDetailsModal(resultId, patientName, patientId, testType, completedDate, technician) {
            // Update modal content with passed data
            document.getElementById('viewPatientName').textContent = patientName;
            document.getElementById('viewPatientId').textContent = patientId;
            document.getElementById('viewTestType').textContent = testType;
            document.getElementById('viewCompletedDate').textContent = completedDate;
            document.getElementById('viewTechnician').textContent = technician;
            
            // Show modal
            document.getElementById('viewDetailsModal').style.display = 'flex';
        }

        function closeViewDetailsModal() {
            document.getElementById('viewDetailsModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('viewDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeViewDetailsModal();
            }
        });

        // Print functionality
        function printTestResult() {
            window.print();
        }

        function printResult(resultId) {
            // Open view modal first, then print
            openViewDetailsModal('LAB-001', 'Maria Santos', 'P-12345', 'Complete Blood Count', '2024-01-16', 'John Martinez');
            setTimeout(() => {
                window.print();
            }, 500);
        }

        // Send functionality
        function sendToDoctor() {
            alert('Test result sent to doctor successfully!');
            closeViewDetailsModal();
        }

        function sendResult(resultId) {
            alert('Test result sent to doctor successfully!');
        }
    </script>
</body>
</html>