<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipment Status - San Miguel HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }
        
        .equipment-status {
            padding: 24px;
            background: #f5f5f5;
            min-height: 100vh;
        }
        
        .page-header {
            margin-bottom: 24px;
        }
        
        .page-title {
            color: #2d3748;
            margin: 0;
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .page-subtitle {
            color: #718096;
            margin: 8px 0 0 0;
            font-size: 16px;
            font-weight: 400;
        }
        
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }
        
        .summary-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            position: relative;
        }
        
        .card-number {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            margin-bottom: 4px;
            color: #2d3748;
        }
        
        .card-label {
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            margin: 0;
            margin-bottom: 2px;
        }
        
        .card-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            border: 2px solid;
        }
        
        .icon-green { 
            background: #f0fff4; 
            color: #38a169; 
            border-color: #c6f6d5;
        }
        .icon-yellow { 
            background: #fffbeb; 
            color: #d69e2e; 
            border-color: #faf089;
        }
        .icon-orange { 
            background: #fffaf0; 
            color: #dd6b20; 
            border-color: #fbd38d;
        }
        .icon-blue { 
            background: #ebf8ff; 
            color: #3182ce; 
            border-color: #bee3f8;
        }
        
        .action-bar {
            background: white;
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }
        
        .search-section {
            display: flex;
            gap: 12px;
            align-items: center;
            flex: 1;
        }
        
        .search-input {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            min-width: 200px;
            background: white;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #3182ce;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        }
        
        .filter-dropdown {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            background: white;
            min-width: 140px;
        }
        
        .schedule-maintenance-btn {
            background: #3182ce;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.2s ease;
        }
        
        .schedule-maintenance-btn:hover {
            background: #2c5aa0;
        }
        
        .equipment-table {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        
        .equipment-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .equipment-table th {
            text-align: left;
            padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #4a5568;
            font-size: 12px;
            background: #f7fafc;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .equipment-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #2d3748;
            vertical-align: top;
        }
        
        .equipment-table tr:last-child td {
            border-bottom: none;
        }
        
        .equipment-info h4 {
            color: #2d3748;
            margin: 0 0 2px 0;
            font-size: 14px;
            font-weight: 600;
        }
        
        .equipment-info p {
            color: #718096;
            margin: 0 0 1px 0;
            font-size: 12px;
        }
        
        .equipment-id {
            color: #a0aec0;
            font-size: 11px;
        }
        
        .department-info h5 {
            color: #2d3748;
            margin: 0 0 2px 0;
            font-size: 13px;
            font-weight: 600;
        }
        
        .department-info p {
            color: #718096;
            margin: 0 0 1px 0;
            font-size: 11px;
        }
        
        .equipment-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
            text-align: center;
            display: inline-block;
        }
        
        .status-operational { 
            background: #c6f6d5; 
            color: #22543d; 
        }
        .status-maintenance { 
            background: #faf089; 
            color: #744210; 
        }
        .status-calibration { 
            background: #fbd38d; 
            color: #7b341e; 
        }
        
        .usage-container {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .usage-bar {
            flex: 1;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
        }
        
        .usage-fill {
            height: 100%;
            border-radius: 3px;
            transition: width 0.3s ease;
        }
        
        .usage-fill.high { background: #e53e3e; }
        .usage-fill.medium { background: #dd6b20; }
        .usage-fill.low { background: #38a169; }
        .usage-fill.zero { background: #a0aec0; }
        
        .usage-text {
            font-size: 12px;
            color: #4a5568;
            font-weight: 500;
            min-width: 35px;
        }
        
        .maintenance-info {
            font-size: 11px;
            color: #4a5568;
            line-height: 1.3;
        }
        
        .maintenance-info strong {
            color: #2d3748;
        }
        
        .action-links {
            display: flex;
            gap: 8px;
        }
        
        .action-link {
            color: #3182ce;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        
        .action-link:hover {
            color: #2c5aa0;
            text-decoration: underline;
        }
        
        .action-link.view { color: #3182ce; }
        .action-link.maintain { color: #38a169; }
        .action-link.calibrate { color: #dd6b20; }
        
        @media (max-width: 1200px) {
            .summary-cards {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .equipment-table {
                overflow-x: auto;
            }
        }
        
        @media (max-width: 768px) {
            .equipment-status {
                padding: 16px;
            }
            
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
                padding: 8px 12px;
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
                    <h2 class="card-number">12</h2>
                    <p class="card-label">Operational</p>
                    <div class="card-icon icon-green">✓</div>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number">3</h2>
                    <p class="card-label">Under Maintenance</p>
                    <div class="card-icon icon-yellow">✕</div>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number">2</h2>
                    <p class="card-label">Needs Attention</p>
                    <div class="card-icon icon-orange">!</div>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number">87%</h2>
                    <p class="card-label">Overall Uptime</p>
                    <div class="card-icon icon-blue">⏰</div>
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
                                <div class="usage-container">
                                    <div class="usage-bar">
                                        <div class="usage-fill high" style="width: 95%"></div>
                                    </div>
                                    <div class="usage-text">95%</div>
                                </div>
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
                                <div class="usage-container">
                                    <div class="usage-bar">
                                        <div class="usage-fill zero" style="width: 0%"></div>
                                    </div>
                                    <div class="usage-text">0%</div>
                                </div>
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
                                <div class="usage-container">
                                    <div class="usage-bar">
                                        <div class="usage-fill medium" style="width: 78%"></div>
                                    </div>
                                    <div class="usage-text">78%</div>
                                </div>
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
                                <div class="usage-container">
                                    <div class="usage-bar">
                                        <div class="usage-fill low" style="width: 60%"></div>
                                    </div>
                                    <div class="usage-text">60%</div>
                                </div>
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
                                <div class="usage-container">
                                    <div class="usage-bar">
                                        <div class="usage-fill medium" style="width: 85%"></div>
                                    </div>
                                    <div class="usage-text">85%</div>
                                </div>
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