<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratory Requests - San Miguel HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        .lab-requests {
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
        
        .card-number.blue { color: #2563eb; }
        .card-number.orange { color: #ea580c; }
        .card-number.purple { color: #7c3aed; }
        .card-number.green { color: #16a34a; }
        
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
        
        .new-request-btn {
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
        
        .new-request-btn:hover {
            background: #1d4ed8;
        }
        
        .requests-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .request-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        
        .request-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .request-info h3 {
            color: #1e293b;
            margin: 0 0 8px 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .request-info p {
            color: #64748b;
            margin: 0 0 4px 0;
            font-size: 14px;
        }
        
        .status-tags {
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
        
        .status-in-progress { background: #dbeafe; color: #1e40af; }
        .status-pending { background: #fef3c7; color: #d97706; }
        .status-urgent { background: #fecaca; color: #dc2626; }
        .status-normal { background: #dbeafe; color: #1e40af; }
        
        .request-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 20px;
        }
        
        .tests-requested h4,
        .request-details h4 {
            color: #374151;
            margin: 0 0 12px 0;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .test-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .test-list li {
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
            color: #374151;
            font-size: 14px;
        }
        
        .test-list li:last-child {
            border-bottom: none;
        }
        
        .detail-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .detail-list li {
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
            color: #374151;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
        }
        
        .detail-list li:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 500;
            color: #6b7280;
        }
        
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
        
        .btn-update { background: #10b981; color: white; }
        .btn-update:hover { background: #059669; }
        
        .btn-print { background: #8b5cf6; color: white; }
        .btn-print:hover { background: #7c3aed; }
        
        @media (max-width: 1200px) {
            .summary-cards {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .request-content {
                grid-template-columns: 1fr;
                gap: 20px;
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
        }
    </style>
</head>
<body>
    <?= $this->include('auth/partials/sidebar') ?>
    
    <div class="main-content">
        <?= $this->include('auth/partials/header') ?>
        
        <div class="lab-requests">
            <div class="page-header">
                <h1 class="page-title">Laboratory Requests</h1>
                <p class="page-subtitle">Manage and track laboratory test requests</p>
            </div>
            
            <div class="summary-cards">
                <div class="summary-card">
                    <h2 class="card-number blue">24</h2>
                    <p class="card-label">Total Requests</p>
                    <p class="card-subtitle green">+3 today</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number orange">8</h2>
                    <p class="card-label">Pending</p>
                    <p class="card-subtitle">Awaiting processing</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number purple">6</h2>
                    <p class="card-label">In Progress</p>
                    <p class="card-subtitle">Being processed</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number green">10</h2>
                    <p class="card-label">Completed</p>
                    <p class="card-subtitle">Results ready</p>
                </div>
            </div>
            
            <div class="action-bar">
                <div class="search-section">
                    <input type="text" class="search-input" placeholder="Search requests...">
                    <select class="filter-dropdown">
                        <option>All Requests</option>
                        <option>Pending</option>
                        <option>In Progress</option>
                        <option>Completed</option>
                        <option>Urgent</option>
                    </select>
                </div>
                <button class="new-request-btn" onclick="openNewRequestModal()">
                    New Lab Request
                </button>
            </div>
            
            <div class="requests-list">
                <div class="request-card">
                    <div class="request-header">
                        <div class="request-info">
                            <h3>LAB-2024-001</h3>
                            <p>Patient: John Dela Cruz</p>
                            <p>Requested by: Dr. Maria Santos | Cardiology</p>
                        </div>
                        <div class="status-tags">
                            <span class="status-tag status-in-progress">In Progress</span>
                            <span class="status-tag status-urgent">Urgent</span>
                        </div>
                    </div>
                    
                    <div class="request-content">
                        <div class="tests-requested">
                            <h4>Tests Requested</h4>
                            <ul class="test-list">
                                <li>Complete Blood Count</li>
                                <li>Lipid Profile</li>
                                <li>HbA1c</li>
                            </ul>
                        </div>
                        
                        <div class="request-details">
                            <h4>Request Details</h4>
                            <ul class="detail-list">
                                <li>
                                    <span class="detail-label">Request Date:</span>
                                    <span>2024-01-15</span>
                                </li>
                                <li>
                                    <span class="detail-label">Expected Date:</span>
                                    <span>2024-01-15</span>
                                </li>
                                <li>
                                    <span class="detail-label">Notes:</span>
                                    <span>Pre-operative clearance required</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button class="action-btn btn-view" onclick="viewRequestDetails('LAB-2024-001')">View Details</button>
                        <button class="action-btn btn-update" onclick="updateRequestStatus('LAB-2024-001')">Update Status</button>
                        <button class="action-btn btn-print" onclick="printRequest('LAB-2024-001')">Print Request</button>
                    </div>
                </div>
                
                <div class="request-card">
                    <div class="request-header">
                        <div class="request-info">
                            <h3>LAB-2024-002</h3>
                            <p>Patient: Ana Rodriguez</p>
                            <p>Requested by: Dr. Roberto Garcia | Pediatrics</p>
                        </div>
                        <div class="status-tags">
                            <span class="status-tag status-pending">Pending</span>
                            <span class="status-tag status-normal">Normal</span>
                        </div>
                    </div>
                    
                    <div class="request-content">
                        <div class="tests-requested">
                            <h4>Tests Requested</h4>
                            <ul class="test-list">
                                <li>Routine Urinalysis</li>
                                <li>Complete Blood Count</li>
                                <li>Blood Glucose</li>
                            </ul>
                        </div>
                        
                        <div class="request-details">
                            <h4>Request Details</h4>
                            <ul class="detail-list">
                                <li>
                                    <span class="detail-label">Request Date:</span>
                                    <span>2024-01-15</span>
                                </li>
                                <li>
                                    <span class="detail-label">Expected Date:</span>
                                    <span>2024-01-16</span>
                                </li>
                                <li>
                                    <span class="detail-label">Notes:</span>
                                    <span>Routine checkup</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button class="action-btn btn-view" onclick="viewRequestDetails('LAB-2024-002')">View Details</button>
                        <button class="action-btn btn-update" onclick="updateRequestStatus('LAB-2024-002')">Update Status</button>
                        <button class="action-btn btn-print" onclick="printRequest('LAB-2024-002')">Print Request</button>
                    </div>
                </div>
                
                <div class="request-card">
                    <div class="request-header">
                        <div class="request-info">
                            <h3>LAB-2024-003</h3>
                            <p>Patient: Carlos Mendoza</p>
                            <p>Requested by: Dr. Elena Santos | Internal Medicine</p>
                        </div>
                        <div class="status-tags">
                            <span class="status-tag status-in-progress">In Progress</span>
                            <span class="status-tag status-normal">Normal</span>
                        </div>
                    </div>
                    
                    <div class="request-content">
                        <div class="tests-requested">
                            <h4>Tests Requested</h4>
                            <ul class="test-list">
                                <li>Comprehensive Metabolic Panel</li>
                                <li>Thyroid Function Tests</li>
                                <li>Vitamin D Level</li>
                            </ul>
                        </div>
                        
                        <div class="request-details">
                            <h4>Request Details</h4>
                            <ul class="detail-list">
                                <li>
                                    <span class="detail-label">Request Date:</span>
                                    <span>2024-01-14</span>
                                </li>
                                <li>
                                    <span class="detail-label">Expected Date:</span>
                                    <span>2024-01-17</span>
                                </li>
                                <li>
                                    <span class="detail-label">Notes:</span>
                                    <span>Annual physical examination</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button class="action-btn btn-view" onclick="viewRequestDetails('LAB-2024-003')">View Details</button>
                        <button class="action-btn btn-update" onclick="updateRequestStatus('LAB-2024-003')">Update Status</button>
                        <button class="action-btn btn-print" onclick="printRequest('LAB-2024-003')">Print Request</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function openNewRequestModal() {
            alert('New Lab Request modal would open here');
        }
        
        function viewRequestDetails(requestId) {
            alert(`Viewing details for ${requestId}`);
        }
        
        function updateRequestStatus(requestId) {
            alert(`Updating status for ${requestId}`);
        }
        
        function printRequest(requestId) {
            alert(`Printing request for ${requestId}`);
        }
        
        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.request-card');
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Filter functionality
        document.querySelector('.filter-dropdown').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const cards = document.querySelectorAll('.request-card');
            
            cards.forEach(card => {
                if (filterValue === 'All Requests') {
                    card.style.display = '';
                } else {
                    const statusTags = card.querySelectorAll('.status-tag');
                    let hasMatchingStatus = false;
                    
                    statusTags.forEach(tag => {
                        if (tag.textContent.includes(filterValue)) {
                            hasMatchingStatus = true;
                        }
                    });
                    
                    card.style.display = hasMatchingStatus ? '' : 'none';
                }
            });
        });
    </script>
</body>
</html>
