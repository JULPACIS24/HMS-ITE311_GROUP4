<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Orders - San Miguel HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        .prescription-orders {
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
        
        .card-number.orange { color: #ea580c; }
        .card-number.green { color: #16a34a; }
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
        
        .process-orders-btn {
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
        
        .process-orders-btn:hover {
            background: #1d4ed8;
        }
        
        .prescription-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .prescription-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        
        .prescription-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .prescription-info h3 {
            color: #1e293b;
            margin: 0 0 8px 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .prescription-info p {
            color: #64748b;
            margin: 0 0 4px 0;
            font-size: 14px;
        }
        
        .prescription-status {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
        }
        
        .status-pending { background: #fef3c7; color: #d97706; }
        .status-ready { background: #dbeafe; color: #1e40af; }
        
        .total-amount {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        
        .insurance-info {
            font-size: 12px;
            color: #059669;
            margin: 0;
        }
        
        .prescribed-medicines {
            margin-bottom: 20px;
        }
        
        .medicines-title {
            color: #374151;
            margin: 0 0 12px 0;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .medicine-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .medicine-item:last-child {
            border-bottom: none;
        }
        
        .medicine-details {
            flex: 1;
        }
        
        .medicine-name {
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 4px 0;
            font-size: 14px;
        }
        
        .medicine-dosage {
            color: #6b7280;
            margin: 0;
            font-size: 12px;
        }
        
        .medicine-quantity {
            font-weight: 600;
            color: #1e293b;
            font-size: 14px;
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
        
        .btn-fulfill { background: #10b981; color: white; }
        .btn-fulfill:hover { background: #059669; }
        
        .btn-view { background: #3b82f6; color: white; }
        .btn-view:hover { background: #2563eb; }
        
        .btn-print { background: #8b5cf6; color: white; }
        .btn-print:hover { background: #7c3aed; }
        
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
            
            .prescription-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            
            .prescription-status {
                align-items: flex-start;
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
        
        <div class="prescription-orders">
            <div class="page-header">
                <h1 class="page-title">Prescription Orders</h1>
                <p class="page-subtitle">Manage and fulfill prescription orders</p>
            </div>
            
            <div class="summary-cards">
                <div class="summary-card">
                    <h2 class="card-number orange">8</h2>
                    <p class="card-label">Pending Orders</p>
                    <p class="card-subtitle">Awaiting fulfillment</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number green">15</h2>
                    <p class="card-label">Ready for Pickup</p>
                    <p class="card-subtitle">Fulfilled orders</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number blue">142</h2>
                    <p class="card-label">Dispensed Today</p>
                    <p class="card-subtitle green">+12 from yesterday</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number orange">3</h2>
                    <p class="card-label">Partial Orders</p>
                    <p class="card-subtitle">Stock issues</p>
                </div>
            </div>
            
            <div class="action-bar">
                <div class="search-section">
                    <input type="text" class="search-input" placeholder="Search prescriptions...">
                    <select class="filter-dropdown">
                        <option>All Orders</option>
                        <option>Pending</option>
                        <option>Ready for Pickup</option>
                        <option>Dispensed</option>
                        <option>Partial</option>
                    </select>
                </div>
                <button class="process-orders-btn" onclick="processOrders()">
                    Process Orders
                </button>
            </div>
            
            <div class="prescription-list">
                <div class="prescription-card">
                    <div class="prescription-header">
                        <div class="prescription-info">
                            <h3>RX-2024-001</h3>
                            <p>Patient: John Dela Cruz</p>
                            <p>Prescribed by: Dr. Maria Santos | Order Date: 2024-01-15</p>
                        </div>
                        <div class="prescription-status">
                            <span class="status-badge status-pending">Pending</span>
                            <div class="total-amount">₱425.50</div>
                            <p class="insurance-info">Insurance covered</p>
                        </div>
                    </div>
                    
                    <div class="prescribed-medicines">
                        <h4 class="medicines-title">Prescribed Medicines</h4>
                        
                        <div class="medicine-item">
                            <div class="medicine-details">
                                <div class="medicine-name">Paracetamol 500mg</div>
                                <div class="medicine-dosage">Take 1 tablet every 6 hours as needed for pain</div>
                            </div>
                            <div class="medicine-quantity">Qty: 30</div>
                        </div>
                        
                        <div class="medicine-item">
                            <div class="medicine-details">
                                <div class="medicine-name">Amoxicillin 250mg</div>
                                <div class="medicine-dosage">Take 1 capsule 3 times daily for 7 days</div>
                            </div>
                            <div class="medicine-quantity">Qty: 21</div>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button class="action-btn btn-fulfill" onclick="fulfillOrder('RX-2024-001')">Fulfill Order</button>
                        <button class="action-btn btn-view" onclick="viewOrderDetails('RX-2024-001')">View Details</button>
                        <button class="action-btn btn-print" onclick="printLabel('RX-2024-001')">Print Label</button>
                    </div>
                </div>
                
                <div class="prescription-card">
                    <div class="prescription-header">
                        <div class="prescription-info">
                            <h3>RX-2024-002</h3>
                            <p>Patient: Maria Santos</p>
                            <p>Prescribed by: Dr. Roberto Garcia | Order Date: 2024-01-15</p>
                        </div>
                        <div class="prescription-status">
                            <span class="status-badge status-ready">Ready for Pickup</span>
                            <div class="total-amount">₱187.25</div>
                            <p class="insurance-info">Insurance covered</p>
                        </div>
                    </div>
                    
                    <div class="prescribed-medicines">
                        <h4 class="medicines-title">Prescribed Medicines</h4>
                        
                        <div class="medicine-item">
                            <div class="medicine-details">
                                <div class="medicine-name">Ibuprofen 400mg</div>
                                <div class="medicine-dosage">Take 1 tablet every 8 hours as needed for inflammation</div>
                            </div>
                            <div class="medicine-quantity">Qty: 20</div>
                        </div>
                        
                        <div class="medicine-item">
                            <div class="medicine-details">
                                <div class="medicine-name">Omeprazole 20mg</div>
                                <div class="medicine-dosage">Take 1 capsule daily before breakfast</div>
                            </div>
                            <div class="medicine-quantity">Qty: 15</div>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button class="action-btn btn-view" onclick="viewOrderDetails('RX-2024-002')">View Details</button>
                        <button class="action-btn btn-print" onclick="printLabel('RX-2024-002')">Print Label</button>
                    </div>
                </div>
                
                <div class="prescription-card">
                    <div class="prescription-header">
                        <div class="prescription-info">
                            <h3>RX-2024-003</h3>
                            <p>Patient: Pedro Garcia</p>
                            <p>Prescribed by: Dr. Elena Chen | Order Date: 2024-01-14</p>
                        </div>
                        <div class="prescription-status">
                            <span class="status-badge status-pending">Pending</span>
                            <div class="total-amount">₱312.75</div>
                            <p class="insurance-info">Insurance covered</p>
                        </div>
                    </div>
                    
                    <div class="prescribed-medicines">
                        <h4 class="medicines-title">Prescribed Medicines</h4>
                        
                        <div class="medicine-item">
                            <div class="medicine-details">
                                <div class="medicine-name">Metformin 500mg</div>
                                <div class="medicine-dosage">Take 1 tablet twice daily with meals</div>
                            </div>
                            <div class="medicine-quantity">Qty: 60</div>
                        </div>
                        
                        <div class="medicine-item">
                            <div class="medicine-details">
                                <div class="medicine-name">Lisinopril 10mg</div>
                                <div class="medicine-dosage">Take 1 tablet daily in the morning</div>
                            </div>
                            <div class="medicine-quantity">Qty: 30</div>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button class="action-btn btn-fulfill" onclick="fulfillOrder('RX-2024-003')">Fulfill Order</button>
                        <button class="action-btn btn-view" onclick="viewOrderDetails('RX-2024-003')">View Details</button>
                        <button class="action-btn btn-print" onclick="printLabel('RX-2024-003')">Print Label</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function processOrders() {
            alert('Processing orders...');
        }
        
        function fulfillOrder(orderId) {
            alert(`Fulfilling order ${orderId}`);
        }
        
        function viewOrderDetails(orderId) {
            alert(`Viewing details for ${orderId}`);
        }
        
        function printLabel(orderId) {
            alert(`Printing label for ${orderId}`);
        }
        
        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.prescription-card');
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Filter functionality
        document.querySelector('.filter-dropdown').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const cards = document.querySelectorAll('.prescription-card');
            
            cards.forEach(card => {
                if (filterValue === 'All Orders') {
                    card.style.display = '';
                } else {
                    const statusBadge = card.querySelector('.status-badge');
                    const status = statusBadge.textContent.toLowerCase();
                    const shouldShow = status.includes(filterValue.toLowerCase()) || 
                                    (filterValue === 'Dispensed' && status === 'ready for pickup') ||
                                    (filterValue === 'Partial' && status === 'pending');
                    card.style.display = shouldShow ? '' : 'none';
                }
            });
        });
    </script>
</body>
</html>
