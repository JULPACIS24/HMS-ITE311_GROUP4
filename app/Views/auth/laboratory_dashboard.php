<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratory Management - San Miguel HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        .lab-dashboard {
            padding: 20px;
            background: #f8fafc;
            min-height: 100vh;
        }
        
        .lab-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .lab-title h1 {
            color: #1e293b;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        
        .lab-title p {
            color: #64748b;
            margin: 5px 0 0 0;
            font-size: 16px;
        }
        
        .new-test-btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.3s ease;
        }
        
        .new-test-btn:hover {
            background: #1d4ed8;
        }
        
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .summary-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }
        
        .card-number {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        
        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .card-icon.blue { background: #dbeafe; color: #1e40af; }
        .card-icon.orange { background: #fed7aa; color: #ea580c; }
        .card-icon.green { background: #bbf7d0; color: #16a34a; }
        .card-icon.red { background: #fecaca; color: #dc2626; }
        
        .card-trend {
            font-size: 14px;
            color: #059669;
            margin: 0;
        }
        
        .card-status {
            font-size: 14px;
            color: #64748b;
            margin: 0;
        }
        
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }
        
        .test-requests-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }
        
        .search-filter {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        
        .search-input {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            width: 200px;
        }
        
        .filter-dropdown {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            background: white;
        }
        
        .test-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .test-table th {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }
        
        .test-table td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #374151;
        }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
            display: inline-block;
        }
        
        .status-completed { background: #dcfce7; color: #16a34a; }
        .status-progress { background: #dbeafe; color: #1e40af; }
        .status-pending { background: #fef3c7; color: #d97706; }
        .status-ready { background: #e9d5ff; color: #7c3aed; }
        
        .priority-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
            display: inline-block;
        }
        
        .priority-normal { background: #f3f4f6; color: #6b7280; }
        .priority-urgent { background: #fecaca; color: #dc2626; }
        .priority-high { background: #fed7aa; color: #ea580c; }
        
        .action-btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        
        .action-btn:hover {
            background: #2563eb;
        }
        
        .equipment-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        
        .equipment-item {
            padding: 16px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .equipment-item:last-child {
            border-bottom: none;
        }
        
        .equipment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        
        .equipment-name {
            font-weight: 600;
            color: #1e293b;
            font-size: 16px;
        }
        
        .equipment-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-operational { background: #dcfce7; color: #16a34a; }
        .status-maintenance { background: #fecaca; color: #dc2626; }
        
        .equipment-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            font-size: 14px;
            color: #64748b;
        }
        
        .equipment-detail {
            display: flex;
            justify-content: space-between;
        }
        
        .equipment-detail span:first-child {
            font-weight: 500;
        }
        
        .view-all-link {
            text-align: center;
            margin-top: 20px;
        }
        
        .view-all-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
        }
        
        .view-all-link a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 1200px) {
            .summary-cards {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .content-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .summary-cards {
                grid-template-columns: 1fr;
            }
            
            .lab-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            
            .search-filter {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
</head>
<body>
    <?= $this->include('auth/partials/sidebar') ?>
    
    <div class="main-content">
        <?= $this->include('auth/partials/header') ?>
        
        <div class="lab-dashboard">
            <div class="lab-header">
                <div class="lab-title">
                    <h1>Laboratory Management</h1>
                    <p>Manage lab tests, results and equipment</p>
                </div>
                <button class="new-test-btn" onclick="openNewTestModal()">
                    <span>+</span>
                    New Test Request
                </button>
            </div>
            
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-number">127</h2>
                            <p class="card-trend">+15% from yesterday</p>
                        </div>
                        <div class="card-icon blue">🧪</div>
                    </div>
                    <p class="card-status">Total Tests Today</p>
                </div>
                
                <div class="summary-card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-number">28</h2>
                            <p class="card-status">Awaiting processing</p>
                        </div>
                        <div class="card-icon orange">⏰</div>
                    </div>
                    <p class="card-status">Pending Results</p>
                </div>
                
                <div class="summary-card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-number">85</h2>
                            <p class="card-status">Results ready</p>
                        </div>
                        <div class="card-icon green">✅</div>
                    </div>
                    <p class="card-status">Completed Tests</p>
                </div>
                
                <div class="summary-card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-number">14</h2>
                            <p class="card-status">Requires attention</p>
                        </div>
                        <div class="card-icon red">🔔</div>
                    </div>
                    <p class="card-status">Urgent Tests</p>
                </div>
            </div>
            
            <div class="content-grid">
                <div class="test-requests-section">
                    <div class="section-header">
                        <h3 class="section-title">Test Requests</h3>
                        <div class="search-filter">
                            <input type="text" class="search-input" placeholder="Search tests...">
                            <select class="filter-dropdown">
                                <option>All Status</option>
                                <option>Completed</option>
                                <option>In Progress</option>
                                <option>Pending</option>
                                <option>Ready</option>
                            </select>
                        </div>
                    </div>
                    
                    <div style="overflow-x: auto;">
                        <table class="test-table">
                            <thead>
                                <tr>
                                    <th>TEST ID</th>
                                    <th>PATIENT</th>
                                    <th>TEST TYPE</th>
                                    <th>STATUS</th>
                                    <th>PRIORITY</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>LAB001</strong></td>
                                    <td>Juan Dela Cruz<br><small>by Dr. Martinez</small></td>
                                    <td>Complete Blood Count</td>
                                    <td><span class="status-badge status-completed">Completed</span></td>
                                    <td><span class="priority-badge priority-normal">Normal</span></td>
                                    <td><button class="action-btn" onclick="viewTestDetails('LAB001')">👁️</button></td>
                                </tr>
                                <tr>
                                    <td><strong>LAB002</strong></td>
                                    <td>Maria Santos<br><small>by Dr. Rodriguez</small></td>
                                    <td>X-Ray Chest</td>
                                    <td><span class="status-badge status-progress">In Progress</span></td>
                                    <td><span class="priority-badge priority-urgent">Urgent</span></td>
                                    <td><button class="action-btn" onclick="viewTestDetails('LAB002')">👁️</button></td>
                                </tr>
                                <tr>
                                    <td><strong>LAB003</strong></td>
                                    <td>Pedro Garcia<br><small>by Dr. Chen</small></td>
                                    <td>Blood Chemistry</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td><span class="priority-badge priority-normal">Normal</span></td>
                                    <td><button class="action-btn" onclick="viewTestDetails('LAB003')">👁️</button></td>
                                </tr>
                                <tr>
                                    <td><strong>LAB004</strong></td>
                                    <td>Ana Lopez<br><small>by Dr. Mendoza</small></td>
                                    <td>CT Scan</td>
                                    <td><span class="status-badge status-ready">Ready</span></td>
                                    <td><span class="priority-badge priority-high">High</span></td>
                                    <td><button class="action-btn" onclick="viewTestDetails('LAB004')">👁️</button></td>
                                </tr>
                                <tr>
                                    <td><strong>LAB005</strong></td>
                                    <td>Carlos Reyes<br><small>by Dr. Martinez</small></td>
                                    <td>Urine Analysis</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td><span class="priority-badge priority-normal">Normal</span></td>
                                    <td><button class="action-btn" onclick="viewTestDetails('LAB005')">👁️</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="equipment-section">
                    <h3 class="section-title">Equipment Status</h3>
                    
                    <div class="equipment-item">
                        <div class="equipment-header">
                            <span class="equipment-name">X-Ray Machine</span>
                            <span class="equipment-status status-operational">Operational</span>
                        </div>
                        <div class="equipment-details">
                            <div class="equipment-detail">
                                <span>Utilization:</span>
                                <span>85%</span>
                            </div>
                            <div class="equipment-detail">
                                <span>Last Maintenance:</span>
                                <span>2024-01-10</span>
                            </div>
                            <div class="equipment-detail">
                                <span>Next Due:</span>
                                <span>2024-02-10</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="equipment-item">
                        <div class="equipment-header">
                            <span class="equipment-name">CT Scanner</span>
                            <span class="equipment-status status-maintenance">Maintenance</span>
                        </div>
                        <div class="equipment-details">
                            <div class="equipment-detail">
                                <span>Utilization:</span>
                                <span>0%</span>
                            </div>
                            <div class="equipment-detail">
                                <span>Last Maintenance:</span>
                                <span>2024-01-08</span>
                            </div>
                            <div class="equipment-detail">
                                <span>Next Due:</span>
                                <span>2024-02-08</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="equipment-item">
                        <div class="equipment-header">
                            <span class="equipment-name">Blood Analyzer</span>
                            <span class="equipment-status status-operational">Operational</span>
                        </div>
                        <div class="equipment-details">
                            <div class="equipment-detail">
                                <span>Utilization:</span>
                                <span>92%</span>
                            </div>
                            <div class="equipment-detail">
                                <span>Last Maintenance:</span>
                                <span>2024-01-12</span>
                            </div>
                            <div class="equipment-detail">
                                <span>Next Due:</span>
                                <span>2024-02-12</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="equipment-item">
                        <div class="equipment-header">
                            <span class="equipment-name">Ultrasound</span>
                            <span class="equipment-status status-operational">Operational</span>
                        </div>
                        <div class="equipment-details">
                            <div class="equipment-detail">
                                <span>Utilization:</span>
                                <span>78%</span>
                            </div>
                            <div class="equipment-detail">
                                <span>Last Maintenance:</span>
                                <span>2024-01-05</span>
                            </div>
                            <div class="equipment-detail">
                                <span>Next Due:</span>
                                <span>2024-02-05</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="view-all-link">
                        <a href="<?= site_url('laboratory/equipment') ?>">View All Equipment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function openNewTestModal() {
            alert('New Test Request modal would open here');
        }
        
        function viewTestDetails(testId) {
            alert(`Viewing details for ${testId}`);
        }
        
        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.test-table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Filter functionality
        document.querySelector('.filter-dropdown').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const rows = document.querySelectorAll('.test-table tbody tr');
            
            rows.forEach(row => {
                if (filterValue === 'All Status') {
                    row.style.display = '';
                } else {
                    const statusCell = row.querySelector('td:nth-child(4)');
                    const status = statusCell.textContent.trim();
                    row.style.display = status === filterValue ? '' : 'none';
                }
            });
        });
    </script>
</body>
</html>
