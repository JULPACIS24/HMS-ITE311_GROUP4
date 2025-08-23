<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratory Results - San Miguel HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        .lab-results {
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
        .card-number.red { color: #dc2626; }
        .card-number.orange { color: #ea580c; }
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
        
        .card-subtitle.green { color: #059669; }
        .card-subtitle.red { color: #dc2626; }
        
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
        
        .enter-results-btn {
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
        
        .enter-results-btn:hover {
            background: #1d4ed8;
        }
        
        .results-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .result-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        
        .result-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .result-info h3 {
            color: #1e293b;
            margin: 0 0 8px 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .result-info p {
            color: #64748b;
            margin: 0 0 4px 0;
            font-size: 14px;
        }
        
        .result-status {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .status-tag {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
        }
        
        .status-critical { background: #fecaca; color: #dc2626; }
        .status-verified { background: #dcfce7; color: #16a34a; }
        
        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .results-table th {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
            background: #f8fafc;
        }
        
        .results-table td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #374151;
        }
        
        .results-table tr:last-child td {
            border-bottom: none;
        }
        
        .test-name {
            font-weight: 600;
            color: #1e293b;
        }
        
        .test-result {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .result-value {
            font-weight: 500;
        }
        
        .result-value.abnormal {
            color: #dc2626;
        }
        
        .abnormal-tag {
            background: #fecaca;
            color: #dc2626;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 500;
        }
        
        .test-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
        }
        
        .status-completed { background: #dcfce7; color: #16a34a; }
        
        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .action-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-view { background: #3b82f6; color: white; }
        .btn-view:hover { background: #2563eb; }
        
        .btn-print { background: #10b981; color: white; }
        .btn-print:hover { background: #059669; }
        
        .btn-email { background: #8b5cf6; color: white; }
        .btn-email:hover { background: #7c3aed; }
        
        @media (max-width: 1200px) {
            .summary-cards {
                grid-template-columns: repeat(2, 1fr);
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
            
            .action-buttons {
                justify-content: center;
            }
            
            .results-table {
                font-size: 12px;
            }
            
            .results-table th,
            .results-table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <?= $this->include('auth/partials/sidebar') ?>
    
    <div class="main-content">
        <?= $this->include('auth/partials/header') ?>
        
        <div class="lab-results">
            <div class="page-header">
                <h1 class="page-title">Laboratory Results</h1>
                <p class="page-subtitle">View and manage laboratory test results</p>
            </div>
            
            <div class="summary-cards">
                <div class="summary-card">
                    <h2 class="card-number green">18</h2>
                    <p class="card-label">Completed Results</p>
                    <p class="card-subtitle green">+5 today</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number red">3</h2>
                    <p class="card-label">Critical Results</p>
                    <p class="card-subtitle red">Requires attention</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number orange">6</h2>
                    <p class="card-label">Pending Verification</p>
                    <p class="card-subtitle">Awaiting review</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number blue">95%</h2>
                    <p class="card-label">Accuracy Rate</p>
                    <p class="card-subtitle">This month</p>
                </div>
            </div>
            
            <div class="action-bar">
                <div class="search-section">
                    <input type="text" class="search-input" placeholder="Search results...">
                    <select class="filter-dropdown">
                        <option>All Results</option>
                        <option>Completed</option>
                        <option>Critical</option>
                        <option>Pending Verification</option>
                        <option>Normal</option>
                        <option>Abnormal</option>
                    </select>
                </div>
                <button class="enter-results-btn" onclick="openEnterResultsModal()">
                    Enter Results
                </button>
            </div>
            
            <div class="results-list">
                <div class="result-card">
                    <div class="result-header">
                        <div class="result-info">
                            <h3>LAB-2024-001</h3>
                            <p>Patient: John Dela Cruz</p>
                            <p>Completed: 2024-01-15 | Technician: Lab Tech Maria Cruz</p>
                        </div>
                        <div class="result-status">
                            <span class="status-tag status-critical">Critical</span>
                            <span class="status-tag status-verified">Verified</span>
                        </div>
                    </div>
                    
                    <table class="results-table">
                        <thead>
                            <tr>
                                <th>TEST</th>
                                <th>RESULT</th>
                                <th>REFERENCE RANGE</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="test-name">Complete Blood Count</td>
                                <td class="test-result">
                                    <span class="result-value">Normal</span>
                                </td>
                                <td>Normal range</td>
                                <td><span class="test-status status-completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td class="test-name">Lipid Profile</td>
                                <td class="test-result">
                                    <span class="result-value abnormal">Elevated cholesterol</span>
                                    <span class="abnormal-tag">Abnormal</span>
                                </td>
                                <td>&lt;200 mg/dL</td>
                                <td><span class="test-status status-completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td class="test-name">HbA1c</td>
                                <td class="test-result">
                                    <span class="result-value abnormal">6.2%</span>
                                    <span class="abnormal-tag">Abnormal</span>
                                </td>
                                <td>&lt;5.7%</td>
                                <td><span class="test-status status-completed">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="action-buttons">
                        <button class="action-btn btn-view" onclick="viewFullReport('LAB-2024-001')">View Full Report</button>
                        <button class="action-btn btn-print" onclick="printResults('LAB-2024-001')">Print Results</button>
                        <button class="action-btn btn-email" onclick="emailToDoctor('LAB-2024-001')">Email to Doctor</button>
                    </div>
                </div>
                
                <div class="result-card">
                    <div class="result-header">
                        <div class="result-info">
                            <h3>LAB-2024-002</h3>
                            <p>Patient: Ana Rodriguez</p>
                            <p>Completed: 2024-01-15 | Technician: Lab Tech Jose Santos</p>
                        </div>
                        <div class="result-status">
                            <span class="status-tag status-verified">Verified</span>
                        </div>
                    </div>
                    
                    <table class="results-table">
                        <thead>
                            <tr>
                                <th>TEST</th>
                                <th>RESULT</th>
                                <th>REFERENCE RANGE</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="test-name">Routine Urinalysis</td>
                                <td class="test-result">
                                    <span class="result-value">Normal</span>
                                </td>
                                <td>Normal range</td>
                                <td><span class="test-status status-completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td class="test-name">Complete Blood Count</td>
                                <td class="test-result">
                                    <span class="result-value">Normal</span>
                                </td>
                                <td>Normal range</td>
                                <td><span class="test-status status-completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td class="test-name">Blood Glucose</td>
                                <td class="test-result">
                                    <span class="result-value">95 mg/dL</span>
                                </td>
                                <td>70-100 mg/dL</td>
                                <td><span class="test-status status-completed">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="action-buttons">
                        <button class="action-btn btn-view" onclick="viewFullReport('LAB-2024-002')">View Full Report</button>
                        <button class="action-btn btn-print" onclick="printResults('LAB-2024-002')">Print Results</button>
                        <button class="action-btn btn-email" onclick="emailToDoctor('LAB-2024-002')">Email to Doctor</button>
                    </div>
                </div>
                
                <div class="result-card">
                    <div class="result-header">
                        <div class="result-info">
                            <h3>LAB-2024-003</h3>
                            <p>Patient: Carlos Mendoza</p>
                            <p>Completed: 2024-01-14 | Technician: Lab Tech Elena Garcia</p>
                        </div>
                        <div class="result-status">
                            <span class="status-tag status-verified">Verified</span>
                        </div>
                    </div>
                    
                    <table class="results-table">
                        <thead>
                            <tr>
                                <th>TEST</th>
                                <th>RESULT</th>
                                <th>REFERENCE RANGE</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="test-name">Comprehensive Metabolic Panel</td>
                                <td class="test-result">
                                    <span class="result-value">Normal</span>
                                </td>
                                <td>Normal range</td>
                                <td><span class="test-status status-completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td class="test-name">Thyroid Function Tests</td>
                                <td class="test-result">
                                    <span class="result-value">Normal</span>
                                </td>
                                <td>Normal range</td>
                                <td><span class="test-status status-completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td class="test-name">Vitamin D Level</td>
                                <td class="test-result">
                                    <span class="result-value">32 ng/mL</span>
                                </td>
                                <td>30-100 ng/mL</td>
                                <td><span class="test-status status-completed">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="action-buttons">
                        <button class="action-btn btn-view" onclick="viewFullReport('LAB-2024-003')">View Full Report</button>
                        <button class="action-btn btn-print" onclick="printResults('LAB-2024-003')">Print Results</button>
                        <button class="action-btn btn-email" onclick="emailToDoctor('LAB-2024-003')">Email to Doctor</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function openEnterResultsModal() {
            alert('Enter Results modal would open here');
        }
        
        function viewFullReport(resultId) {
            alert(`Viewing full report for ${resultId}`);
        }
        
        function printResults(resultId) {
            alert(`Printing results for ${resultId}`);
        }
        
        function emailToDoctor(resultId) {
            alert(`Emailing results to doctor for ${resultId}`);
        }
        
        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.result-card');
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Filter functionality
        document.querySelector('.filter-dropdown').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const cards = document.querySelectorAll('.result-card');
            
            cards.forEach(card => {
                if (filterValue === 'All Results') {
                    card.style.display = '';
                } else if (filterValue === 'Critical') {
                    const hasCritical = card.querySelector('.status-critical');
                    card.style.display = hasCritical ? '' : 'none';
                } else if (filterValue === 'Abnormal') {
                    const hasAbnormal = card.querySelector('.abnormal-tag');
                    card.style.display = hasAbnormal ? '' : 'none';
                } else {
                    // For other filters, show all for now
                    card.style.display = '';
                }
            });
        });
    </script>
</body>
</html>
