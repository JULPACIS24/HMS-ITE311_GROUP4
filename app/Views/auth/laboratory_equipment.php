<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Status - San Miguel HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        .equipment-status {
            padding: 20px;
            background: #f8fafc;
            min-height: 100vh;
        }
        
        .page-header {
            margin-bottom: 30px;
        }
        
        .page-title {
            color: #1e293b;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        
        .page-subtitle {
            color: #64748b;
            margin: 5px 0 0 0;
            font-size: 16px;
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
            text-align: center;
        }
        
        .card-number {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
            margin-bottom: 8px;
        }
        
        .card-number.green { color: #16a34a; }
        .card-number.orange { color: #ea580c; }
        .card-number.red { color: #dc2626; }
        .card-number.blue { color: #2563eb; }
        
        .card-label {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
            margin-bottom: 4px;
        }
        
        .card-subtitle {
            font-size: 14px;
            color: #64748b;
            margin: 0;
        }
        
        .card-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px auto;
            font-size: 20px;
        }
        
        .icon-green { background: #dcfce7; color: #16a34a; }
        .icon-yellow { background: #fef3c7; color: #d97706; }
        .icon-orange { background: #fed7aa; color: #ea580c; }
        .icon-blue { background: #dbeafe; color: #1e40af; }
        
        .action-bar {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }
        
        .search-section {
            display: flex;
            gap: 12px;
            align-items: center;
            flex: 1;
        }
        
        .search-input {
            padding: 10px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            min-width: 250px;
        }
        
        .filter-dropdown {
            padding: 10px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            min-width: 150px;
        }
        
        .schedule-maintenance-btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.3s ease;
        }
        
        .schedule-maintenance-btn:hover {
            background: #1d4ed8;
        }
        
        .equipment-table {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        
        .table-header {
            background: #f8fafc;
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }
        
        .equipment-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .equipment-table th {
            text-align: left;
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
            background: #f8fafc;
        }
        
        .equipment-table td {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #374151;
            vertical-align: top;
        }
        
        .equipment-table tr:last-child td {
            border-bottom: none;
        }
        
        .equipment-info h4 {
            color: #1e293b;
            margin: 0 0 4px 0;
            font-size: 16px;
            font-weight: 600;
        }
        
        .equipment-info p {
            color: #6b7280;
            margin: 0 0 2px 0;
            font-size: 12px;
        }
        
        .equipment-id {
            color: #9ca3af;
            font-size: 12px;
        }
        
        .department-info h5 {
            color: #1e293b;
            margin: 0 0 4px 0;
            font-size: 14px;
            font-weight: 600;
        }
        
        .department-info p {
            color: #6b7280;
            margin: 0 0 2px 0;
            font-size: 12px;
        }
        
        .equipment-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
            display: inline-block;
        }
        
        .status-operational { background: #dcfce7; color: #16a34a; }
        .status-maintenance { background: #fef3c7; color: #d97706; }
        .status-calibration { background: #fed7aa; color: #ea580c; }
        
        .usage-bar {
            width: 100%;
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 8px;
        }
        
        .usage-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
        }
        
        .usage-fill.high { background: #dc2626; }
        .usage-fill.medium { background: #ea580c; }
        .usage-fill.low { background: #16a34a; }
        .usage-fill.zero { background: #9ca3af; }
        
        .usage-text {
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }
        
        .maintenance-info {
            font-size: 12px;
            color: #6b7280;
            line-height: 1.4;
        }
        
        .maintenance-info strong {
            color: #374151;
        }
        
        .action-links {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .action-link {
            color: #2563eb;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .action-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }
        
        .action-link.view { color: #2563eb; }
        .action-link.maintain { color: #16a34a; }
        .action-link.calibrate { color: #ea580c; }
        
        @media (max-width: 1200px) {
            .summary-cards {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .equipment-table {
                overflow-x: auto;
            }
        }
        
        @media (max-width: 768px) {
            .summary-cards {
                grid-template-columns: 1fr;
            }
            
            .action-bar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-section {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-input,
            .filter-dropdown {
                min-width: auto;
            }
            
            .equipment-table th,
            .equipment-table td {
                padding: 12px 16px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <?= $this->include('auth/partials/sidebar') ?>
    
    <div class="main-content">
        <?= $this->include('auth/partials/header') ?>
        
        <div class="equipment-status">
            <div class="page-header">
                <h1 class="page-title">Equipment Status</h1>
                <p class="page-subtitle">Monitor and manage laboratory equipment</p>
            </div>
            
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="card-icon icon-green">✅</div>
                    <h2 class="card-number green">12</h2>
                    <p class="card-label">Operational</p>
                    <p class="card-subtitle">Fully functional</p>
                </div>
                
                <div class="summary-card">
                    <div class="card-icon icon-yellow">🔧</div>
                    <h2 class="card-number orange">3</h2>
                    <p class="card-label">Under Maintenance</p>
                    <p class="card-subtitle">Being serviced</p>
                </div>
                
                <div class="summary-card">
                    <div class="card-icon icon-orange">⚠️</div>
                    <h2 class="card-number red">2</h2>
                    <p class="card-label">Needs Attention</p>
                    <p class="card-subtitle">Requires service</p>
                </div>
                
                <div class="summary-card">
                    <div class="card-icon icon-blue">🔄</div>
                    <h2 class="card-number blue">87%</h2>
                    <p class="card-label">Overall Uptime</p>
                    <p class="card-subtitle">This month</p>
                </div>
            </div>
            
            <div class="action-bar">
                <div class="search-section">
                    <input type="text" class="search-input" placeholder="Search equipment...">
                    <select class="filter-dropdown">
                        <option>All Departments</option>
                        <option>Hematology</option>
                        <option>Chemistry</option>
                        <option>Radiology</option>
                        <option>Pathology</option>
                        <option>General Lab</option>
                    </select>
                </div>
                <button class="schedule-maintenance-btn" onclick="openMaintenanceModal()">
                    Schedule Maintenance
                </button>
            </div>
            
            <div class="equipment-table">
                <div class="table-header">
                    <h3 class="table-title">Equipment Inventory</h3>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>EQUIPMENT</th>
                            <th>DEPARTMENT & LOCATION</th>
                            <th>STATUS</th>
                            <th>USAGE</th>
                            <th>MAINTENANCE</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="equipment-info">
                                    <h4>Hematology Analyzer</h4>
                                    <p>Sysmex XN-1000</p>
                                    <span class="equipment-id">ID: EQ-001</span>
                                </div>
                            </td>
                            <td>
                                <div class="department-info">
                                    <h5>Hematology</h5>
                                    <p>Lab Room A</p>
                                    <p>Tech: Maria Cruz</p>
                                </div>
                            </td>
                            <td>
                                <span class="equipment-status status-operational">Operational</span>
                            </td>
                            <td>
                                <div class="usage-bar">
                                    <div class="usage-fill high" style="width: 95%"></div>
                                </div>
                                <div class="usage-text">95%</div>
                            </td>
                            <td>
                                <div class="maintenance-info">
                                    <strong>Last:</strong> 2024-01-01<br>
                                    <strong>Next:</strong> 2024-04-01
                                </div>
                            </td>
                            <td>
                                <div class="action-links">
                                    <a href="#" class="action-link view" onclick="viewEquipment('EQ-001')">View</a>
                                    <a href="#" class="action-link maintain" onclick="maintainEquipment('EQ-001')">Maintain</a>
                                    <a href="#" class="action-link calibrate" onclick="calibrateEquipment('EQ-001')">Calibrate</a>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <div class="equipment-info">
                                    <h4>Chemistry Analyzer</h4>
                                    <p>Beckman Coulter AU5800</p>
                                    <span class="equipment-id">ID: EQ-002</span>
                                </div>
                            </td>
                            <td>
                                <div class="department-info">
                                    <h5>Chemistry</h5>
                                    <p>Lab Room B</p>
                                    <p>Tech: Jose Santos</p>
                                </div>
                            </td>
                            <td>
                                <span class="equipment-status status-maintenance">Under Maintenance</span>
                            </td>
                            <td>
                                <div class="usage-bar">
                                    <div class="usage-fill zero" style="width: 0%"></div>
                                </div>
                                <div class="usage-text">0%</div>
                            </td>
                            <td>
                                <div class="maintenance-info">
                                    <strong>Last:</strong> 2024-01-14<br>
                                    <strong>Next:</strong> 2024-04-14
                                </div>
                            </td>
                            <td>
                                <div class="action-links">
                                    <a href="#" class="action-link view" onclick="viewEquipment('EQ-002')">View</a>
                                    <a href="#" class="action-link maintain" onclick="maintainEquipment('EQ-002')">Maintain</a>
                                    <a href="#" class="action-link calibrate" onclick="calibrateEquipment('EQ-002')">Calibrate</a>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <div class="equipment-info">
                                    <h4>X-Ray Machine</h4>
                                    <p>GE Brivo XR575</p>
                                    <span class="equipment-id">ID: EQ-003</span>
                                </div>
                            </td>
                            <td>
                                <div class="department-info">
                                    <h5>Radiology</h5>
                                    <p>Radiology Room 1</p>
                                    <p>Tech: Ana Lopez</p>
                                </div>
                            </td>
                            <td>
                                <span class="equipment-status status-operational">Operational</span>
                            </td>
                            <td>
                                <div class="usage-bar">
                                    <div class="usage-fill medium" style="width: 78%"></div>
                                </div>
                                <div class="usage-text">78%</div>
                            </td>
                            <td>
                                <div class="maintenance-info">
                                    <strong>Last:</strong> 2023-12-15<br>
                                    <strong>Next:</strong> 2024-03-15
                                </div>
                            </td>
                            <td>
                                <div class="action-links">
                                    <a href="#" class="action-link view" onclick="viewEquipment('EQ-003')">View</a>
                                    <a href="#" class="action-link maintain" onclick="maintainEquipment('EQ-003')">Maintain</a>
                                    <a href="#" class="action-link calibrate" onclick="calibrateEquipment('EQ-003')">Calibrate</a>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <div class="equipment-info">
                                    <h4>Microscope</h4>
                                    <p>Olympus BX53</p>
                                    <span class="equipment-id">ID: EQ-004</span>
                                </div>
                            </td>
                            <td>
                                <div class="department-info">
                                    <h5>Pathology</h5>
                                    <p>Pathology Lab</p>
                                    <p>Tech: Carlos Rivera</p>
                                </div>
                            </td>
                            <td>
                                <span class="equipment-status status-calibration">Needs Calibration</span>
                            </td>
                            <td>
                                <div class="usage-bar">
                                    <div class="usage-fill low" style="width: 60%"></div>
                                </div>
                                <div class="usage-text">60%</div>
                            </td>
                            <td>
                                <div class="maintenance-info">
                                    <strong>Last:</strong> 2023-11-20<br>
                                    <strong>Next:</strong> 2024-02-20
                                </div>
                            </td>
                            <td>
                                <div class="action-links">
                                    <a href="#" class="action-link view" onclick="viewEquipment('EQ-004')">View</a>
                                    <a href="#" class="action-link maintain" onclick="maintainEquipment('EQ-004')">Maintain</a>
                                    <a href="#" class="action-link calibrate" onclick="calibrateEquipment('EQ-004')">Calibrate</a>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <div class="equipment-info">
                                    <h4>Centrifuge</h4>
                                    <p>Eppendorf 5810R</p>
                                    <span class="equipment-id">ID: EQ-005</span>
                                </div>
                            </td>
                            <td>
                                <div class="department-info">
                                    <h5>General Lab</h5>
                                    <p>Central Lab</p>
                                    <p>Tech: Elena Garcia</p>
                                </div>
                            </td>
                            <td>
                                <span class="equipment-status status-operational">Operational</span>
                            </td>
                            <td>
                                <div class="usage-bar">
                                    <div class="usage-fill medium" style="width: 85%"></div>
                                </div>
                                <div class="usage-text">85%</div>
                            </td>
                            <td>
                                <div class="maintenance-info">
                                    <strong>Last:</strong> 2024-01-10<br>
                                    <strong>Next:</strong> 2024-07-10
                                </div>
                            </td>
                            <td>
                                <div class="action-links">
                                    <a href="#" class="action-link view" onclick="viewEquipment('EQ-005')">View</a>
                                    <a href="#" class="action-link maintain" onclick="maintainEquipment('EQ-005')">Maintain</a>
                                    <a href="#" class="action-link calibrate" onclick="calibrateEquipment('EQ-005')">Calibrate</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        function openMaintenanceModal() {
            alert('Schedule Maintenance modal would open here');
        }
        
        function viewEquipment(equipmentId) {
            alert(`Viewing equipment ${equipmentId}`);
        }
        
        function maintainEquipment(equipmentId) {
            alert(`Opening maintenance for ${equipmentId}`);
        }
        
        function calibrateEquipment(equipmentId) {
            alert(`Starting calibration for ${equipmentId}`);
        }
        
        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.equipment-table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Filter functionality
        document.querySelector('.filter-dropdown').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const rows = document.querySelectorAll('.equipment-table tbody tr');
            
            rows.forEach(row => {
                if (filterValue === 'All Departments') {
                    row.style.display = '';
                } else {
                    const departmentCell = row.querySelector('td:nth-child(2)');
                    const department = departmentCell.textContent.toLowerCase();
                    row.style.display = department.includes(filterValue.toLowerCase()) ? '' : 'none';
                }
            });
        });
    </script>
</body>
</html>
