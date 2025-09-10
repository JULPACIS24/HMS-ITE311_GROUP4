<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Requests - San Miguel HMS</title>
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
        
        .summary-card.total .number { color: #6c757d; }
        .summary-card.new .number { color: #007bff; }
        .summary-card.progress .number { color: #ffc107; }
        .summary-card.urgent .number { color: #dc3545; }
        
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
        
        .btn-new-request {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-new-request:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,123,255,0.3);
        }
        
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 2000;
        }
        
        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 90%;
            max-width: 600px;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6c757d;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px;
            transition: border-color 0.3s;
        }
        
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }
        
        .btn-cancel {
            background: #6c757d;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            color: white;
            margin-right: 10px;
        }
        
        .btn-create {
            background: #28a745;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #dee2e6;
        }
        
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-routine { background-color: #e3f2fd; color: #1976d2; }
        .badge-urgent { background-color: #fff3e0; color: #f57c00; }
        .badge-stat { background-color: #ffebee; color: #d32f2f; }
        .badge-new-request { background-color: #e8f5e8; color: #2e7d32; }
        .badge-in-progress { background-color: #e3f2fd; color: #1976d2; }
        .badge-completed { background-color: #e8f5e8; color: #2e7d32; }
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
                <a class="nav-link active" href="<?= site_url('laboratory/test/request') ?>">
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
                    <h2 class="mb-1">Test Requests</h2>
                    <p class="text-muted mb-0">Manage laboratory test requests from doctors and nurses</p>
                </div>
                <div>
                    <button class="btn btn-outline-secondary me-2">
                        <i class="fas fa-filter me-2"></i> Filters
                    </button>
                    <button class="btn btn-new-request" onclick="openModal()">
                        <i class="fas fa-plus me-2"></i> New Request
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="summary-card total">
                    <i class="fas fa-clipboard-list fa-2x text-muted mb-2"></i>
                    <h6 class="text-muted">Total Requests</h6>
                    <div class="number">0</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card new">
                    <i class="fas fa-plus-circle fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted">New Requests</h6>
                    <div class="number">0</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card progress">
                    <i class="fas fa-play-circle fa-2x text-warning mb-2"></i>
                    <h6 class="text-muted">In Progress</h6>
                    <div class="number">0</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card urgent">
                    <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                    <h6 class="text-muted">Urgent/High Priority</h6>
                    <div class="number">0</div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Patient</th>
                        <th>Test</th>
                        <th>Requested By</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($requests)): ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-clipboard-list"></i>
                                    <h5>No test requests available</h5>
                                    <p>Click "New Request" to create your first test request</p>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($requests as $request): ?>
                            <tr>
                                <td><?= esc($request['lab_id']) ?></td>
                                <td><?= esc($request['patient_name']) ?></td>
                                <td><?= esc($request['tests']) ?></td>
                                <td><?= esc($request['doctor_name']) ?></td>
                                <td>
                                    <span class="badge badge-<?= strtolower($request['priority']) ?>">
                                        <?= esc($request['priority']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-<?= strtolower(str_replace(' ', '-', $request['status'])) ?>">
                                        <?= esc($request['status']) ?>
                                    </span>
                                </td>
                                <td><?= esc($request['expected_date']) ?></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal-overlay" id="requestModal">
        <div class="modal-content">
            <div class="modal-header">
                <h4>New Test Request</h4>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            
            <form id="requestForm">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="patientId">Patient ID</label>
                            <input type="text" class="form-control" id="patientId" placeholder="Enter patient ID" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="testType">Test Type</label>
                            <select class="form-control" id="testType" required>
                                <option value="">Select test type</option>
                                <option value="blood">Blood Test</option>
                                <option value="urine">Urine Test</option>
                                <option value="imaging">Imaging</option>
                                <option value="serum">Serum Test</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="priority">Priority</label>
                            <select class="form-control" id="priority" required>
                                <option value="">Select priority</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="requester">Requesting Doctor/Nurse</label>
                            <select class="form-control" id="requester" required>
                                <option value="">Select requester</option>
                                <option value="dr-rodriguez">Dr. Rodriguez</option>
                                <option value="dr-martinez">Dr. Martinez</option>
                                <option value="nurse-garcia">Nurse Garcia</option>
                                <option value="nurse-patricia">Nurse Patricia</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="department">Department</label>
                            <select class="form-control" id="department" required>
                                <option value="">Select department</option>
                                <option value="internal-medicine">Internal Medicine</option>
                                <option value="cardiology">Cardiology</option>
                                <option value="nephrology">Nephrology</option>
                                <option value="emergency">Emergency</option>
                                <option value="gastroenterology">Gastroenterology</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="roomNumber">Room Number</label>
                            <input type="text" class="form-control" id="roomNumber" placeholder="e.g., Room 204, ER Bay 3">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="clinicalNotes">Clinical Notes</label>
                    <textarea class="form-control" id="clinicalNotes" rows="4" placeholder="Enter clinical notes and symptoms"></textarea>
                </div>
                
                <div class="text-end">
                    <button type="button" class="btn btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-create">Create Request</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('requestModal').style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('requestModal').style.display = 'none';
            document.getElementById('requestForm').reset();
        }
        
        document.getElementById('requestForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                patientId: document.getElementById('patientId').value,
                testType: document.getElementById('testType').value,
                priority: document.getElementById('priority').value,
                requester: document.getElementById('requester').value,
                department: document.getElementById('department').value,
                roomNumber: document.getElementById('roomNumber').value,
                clinicalNotes: document.getElementById('clinicalNotes').value
            };
            
            console.log('New Test Request:', formData);
            alert('Test request created successfully! (Check console for details)');
            closeModal();
        });
        
        // Close modal when clicking outside
        document.getElementById('requestModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>