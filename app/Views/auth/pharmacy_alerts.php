<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Alerts - San Miguel HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        .stock-alerts {
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
            position: relative;
            overflow: hidden;
        }
        
        .summary-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 6px;
        }
        
        .summary-card.critical::before { background: #dc2626; }
        .summary-card.high::before { background: #ea580c; }
        .summary-card.medium::before { background: #d97706; }
        .summary-card.low::before { background: #2563eb; }
        
        .card-number {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
            margin-bottom: 8px;
        }
        
        .card-number.critical { color: #dc2626; }
        .card-number.high { color: #ea580c; }
        .card-number.medium { color: #d97706; }
        .card-number.low { color: #2563eb; }
        
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
        
        .alert-settings-btn {
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
        
        .alert-settings-btn:hover {
            background: #1d4ed8;
        }
        
        .alerts-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .alert-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }
        
        .alert-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 6px;
        }
        
        .alert-card.high::before { background: #ea580c; }
        .alert-card.medium::before { background: #d97706; }
        
        .alert-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .alert-info h3 {
            color: #1e293b;
            margin: 0 0 8px 0;
            font-size: 18px;
            font-weight: 600;
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
        
        .status-high { background: #fed7aa; color: #ea580c; }
        .status-medium { background: #fef3c7; color: #d97706; }
        .status-low-stock { background: #fecaca; color: #dc2626; }
        .status-expiring-soon { background: #fef3c7; color: #d97706; }
        
        .alert-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 500;
            color: #6b7280;
        }
        
        .detail-value {
            color: #374151;
            font-weight: 500;
        }
        
        .last-updated {
            text-align: right;
            font-size: 12px;
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
        
        .btn-reorder { background: #10b981; color: white; }
        .btn-reorder:hover { background: #059669; }
        
        .btn-view { background: #3b82f6; color: white; }
        .btn-view:hover { background: #2563eb; }
        
        .btn-dismiss { background: #6b7280; color: white; }
        .btn-dismiss:hover { background: #4b5563; }
        
        .btn-remove { background: #ea580c; color: white; }
        .btn-remove:hover { background: #c2410c; }
        
        @media (max-width: 1200px) {
            .summary-cards {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .alert-details {
                grid-template-columns: 1fr;
                gap: 16px;
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
            
            .alert-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            
            .last-updated {
                text-align: left;
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
        
        <div class="stock-alerts">
            <div class="page-header">
                <h1 class="page-title">Stock Alerts</h1>
                <p class="page-subtitle">Monitor inventory alerts and notifications</p>
            </div>
            
            <div class="summary-cards">
                <div class="summary-card critical">
                    <h2 class="card-number critical">5</h2>
                    <p class="card-label">Critical Alerts</p>
                    <p class="card-subtitle">Immediate attention</p>
                </div>
                
                <div class="summary-card high">
                    <h2 class="card-number high">8</h2>
                    <p class="card-label">High Priority</p>
                    <p class="card-subtitle">Action needed</p>
                </div>
                
                <div class="summary-card medium">
                    <h2 class="card-number medium">12</h2>
                    <p class="card-label">Medium Priority</p>
                    <p class="card-subtitle">Monitor closely</p>
                </div>
                
                <div class="summary-card low">
                    <h2 class="card-number low">3</h2>
                    <p class="card-label">Low Priority</p>
                    <p class="card-subtitle">General awareness</p>
                </div>
            </div>
            
            <div class="action-bar">
                <div class="search-section">
                    <input type="text" class="search-input" placeholder="Search alerts...">
                    <select class="filter-dropdown">
                        <option>All Alerts</option>
                        <option>Critical</option>
                        <option>High Priority</option>
                        <option>Medium Priority</option>
                        <option>Low Priority</option>
                    </select>
                </div>
                <button class="alert-settings-btn" onclick="openAlertSettings()">
                    Alert Settings
                </button>
            </div>
            
            <div class="alerts-list">
                <div class="alert-card high">
                    <div class="alert-header">
                        <div class="alert-info">
                            <h3>Amoxicillin 250mg</h3>
                            <div class="status-tags">
                                <span class="status-tag status-high">High</span>
                                <span class="status-tag status-low-stock">Low Stock</span>
                            </div>
                        </div>
                        <div class="last-updated">Last Updated: 2024-01-15 10:30 AM</div>
                    </div>
                    
                    <div class="alert-details">
                        <div class="detail-item">
                            <span class="detail-label">Current Stock:</span>
                            <span class="detail-value">15 units</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Minimum Required:</span>
                            <span class="detail-value">30 units</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Location:</span>
                            <span class="detail-value">Shelf B2</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Supplier:</span>
                            <span class="detail-value">Pfizer Philippines</span>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button class="action-btn btn-reorder" onclick="reorderStock('MED002')">Reorder Stock</button>
                        <button class="action-btn btn-view" onclick="viewAlertDetails('MED002')">View Details</button>
                        <button class="action-btn btn-dismiss" onclick="dismissAlert('MED002')">Dismiss Alert</button>
                    </div>
                </div>
                
                <div class="alert-card medium">
                    <div class="alert-header">
                        <div class="alert-info">
                            <h3>Insulin Glargine 100U/ml</h3>
                            <div class="status-tags">
                                <span class="status-tag status-medium">Medium</span>
                                <span class="status-tag status-expiring-soon">Expiring Soon</span>
                            </div>
                        </div>
                        <div class="last-updated">Last Updated: 2024-01-15 09:15 AM</div>
                    </div>
                    
                    <div class="alert-details">
                        <div class="detail-item">
                            <span class="detail-label">Expiry Date:</span>
                            <span class="detail-value">2024-02-20</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Days Remaining:</span>
                            <span class="detail-value">36 days</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Batch Number:</span>
                            <span class="detail-value">INS240201</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Stock Affected:</span>
                            <span class="detail-value">8 units</span>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button class="action-btn btn-remove" onclick="removeFromStock('MED004')">Remove from Stock</button>
                        <button class="action-btn btn-view" onclick="viewAlertDetails('MED004')">View Details</button>
                        <button class="action-btn btn-dismiss" onclick="dismissAlert('MED004')">Dismiss Alert</button>
                    </div>
                </div>
                
                <div class="alert-card high">
                    <div class="alert-header">
                        <div class="alert-info">
                            <h3>Metformin 500mg</h3>
                            <div class="status-tags">
                                <span class="status-tag status-high">High</span>
                                <span class="status-tag status-low-stock">Low Stock</span>
                            </div>
                        </div>
                        <div class="last-updated">Last Updated: 2024-01-15 08:45 AM</div>
                    </div>
                    
                    <div class="alert-details">
                        <div class="detail-item">
                            <span class="detail-label">Current Stock:</span>
                            <span class="detail-value">5 units</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Minimum Required:</span>
                            <span class="detail-value">25 units</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Location:</span>
                            <span class="detail-value">Shelf C1</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Supplier:</span>
                            <span class="detail-value">Merck Philippines</span>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button class="action-btn btn-reorder" onclick="reorderStock('MED005')">Reorder Stock</button>
                        <button class="action-btn btn-view" onclick="viewAlertDetails('MED005')">View Details</button>
                        <button class="action-btn btn-dismiss" onclick="dismissAlert('MED005')">Dismiss Alert</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function openAlertSettings() {
            alert('Alert Settings modal would open here');
        }
        
        function reorderStock(medicineId) {
            alert(`Reordering stock for ${medicineId}`);
        }
        
        function viewAlertDetails(medicineId) {
            alert(`Viewing alert details for ${medicineId}`);
        }
        
        function dismissAlert(medicineId) {
            alert(`Dismissing alert for ${medicineId}`);
        }
        
        function removeFromStock(medicineId) {
            alert(`Removing ${medicineId} from stock`);
        }
        
        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.alert-card');
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Filter functionality
        document.querySelector('.filter-dropdown').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const cards = document.querySelectorAll('.alert-card');
            
            cards.forEach(card => {
                if (filterValue === 'All Alerts') {
                    card.style.display = '';
                } else {
                    const priorityTags = card.querySelectorAll('.status-tag');
                    let hasMatchingPriority = false;
                    
                    priorityTags.forEach(tag => {
                        if (tag.textContent.includes(filterValue)) {
                            hasMatchingPriority = true;
                        }
                    });
                    
                    card.style.display = hasMatchingPriority ? '' : 'none';
                }
            });
        });
    </script>
</body>
</html>
