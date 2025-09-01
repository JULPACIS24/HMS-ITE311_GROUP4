<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Management - San Miguel HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        .pharmacy-management {
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
        
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .add-medicine-btn {
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
        
        .add-medicine-btn:hover {
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
            position: relative;
        }
        
        .card-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        
        .card-info h3 {
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
            margin: 0 0 8px 0;
        }
        
        .card-number {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 4px 0;
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
            font-size: 20px;
        }
        
        .icon-blue { background: #dbeafe; color: #1e40af; }
        .icon-orange { background: #fed7aa; color: #ea580c; }
        .icon-red { background: #fecaca; color: #dc2626; }
        .icon-green { background: #dcfce7; color: #059669; }
        
        .main-content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }
        
        .medicine-inventory {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        
        .inventory-header {
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .inventory-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }
        
        .inventory-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 16px;
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
            background: white;
        }
        
        .filter-dropdown {
            padding: 10px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            min-width: 150px;
        }
        
        .inventory-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .inventory-table th {
            text-align: left;
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
            background: #f8fafc;
        }
        
        .inventory-table td {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #374151;
            vertical-align: top;
        }
        
        .inventory-table tr:last-child td {
            border-bottom: none;
        }
        
        .medicine-info h4 {
            color: #1e293b;
            margin: 0 0 4px 0;
            font-size: 16px;
            font-weight: 600;
        }
        
        .medicine-info p {
            color: #6b7280;
            margin: 0;
            font-size: 12px;
        }
        
        .stock-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .stock-current {
            font-weight: 600;
            color: #1e293b;
        }
        
        .stock-min {
            font-size: 12px;
            color: #6b7280;
        }
        
        .price {
            font-weight: 600;
            color: #1e293b;
        }
        
        .expiry {
            font-size: 14px;
            color: #374151;
        }
        
        .status-tag {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
            display: inline-block;
        }
        
        .status-instock { background: #dcfce7; color: #16a34a; }
        .status-lowstock { background: #fed7aa; color: #ea580c; }
        .status-critical { background: #fecaca; color: #dc2626; }
        
        .action-icons {
            display: flex;
            gap: 8px;
        }
        
        .action-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .action-icon.view { background: #dbeafe; color: #1e40af; }
        .action-icon.edit { background: #dcfce7; color: #16a34a; }
        
        .action-icon:hover {
            transform: scale(1.1);
        }
        
        .recent-prescriptions {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        
        .prescriptions-header {
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .prescriptions-title {
            font-size: 20px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }
        
        .prescription-item {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .prescription-item:last-child {
            border-bottom: none;
        }
        
        .prescription-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }
        
        .prescription-id {
            font-weight: 600;
            color: #1e293b;
            font-size: 14px;
        }
        
        .prescription-status {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 500;
            text-align: center;
        }
        
        .status-dispensed { background: #dcfce7; color: #16a34a; }
        .status-pending { background: #fef3c7; color: #d97706; }
        .status-ready { background: #dbeafe; color: #1e40af; }
        
        .patient-name {
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 4px 0;
            font-size: 14px;
        }
        
        .medicine-name {
            color: #6b7280;
            margin: 0 0 4px 0;
            font-size: 13px;
        }
        
        .prescription-details {
            color: #6b7280;
            margin: 0 0 4px 0;
            font-size: 12px;
        }
        
        .prescription-date {
            color: #9ca3af;
            font-size: 12px;
        }
        
        @media (max-width: 1200px) {
            .summary-cards {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .main-content-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .summary-cards {
                grid-template-columns: 1fr;
            }
            
            .header-actions {
                flex-direction: column;
                align-items: stretch;
                gap: 16px;
            }
            
            .inventory-controls {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }
            
            .search-section {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-input,
            .filter-dropdown {
                min-width: auto;
            }
            
            .inventory-table {
                font-size: 12px;
            }
            
            .inventory-table th,
            .inventory-table td {
                padding: 12px 16px;
            }
        }
    </style>
</head>
<body>
    <?= $this->include('auth/partials/sidebar') ?>
    
    <div class="main-content">
        <?= $this->include('auth/partials/header') ?>
        
        <div class="pharmacy-management">
            <div class="page-header">
                <h1 class="page-title">Pharmacy Management</h1>
                <p class="page-subtitle">Manage inventory, prescriptions and medicine dispensing</p>
            </div>
            
            <div class="header-actions">
                <div></div>
                <button class="add-medicine-btn" onclick="openAddMedicineModal()">
                    <span>+</span> Add Medicine
                </button>
            </div>
            
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="card-content">
                        <div class="card-info">
                            <h3>Total Medicines</h3>
                            <div class="card-number">1,247</div>
                            <p class="card-subtitle">42 categories</p>
                        </div>
                        <div class="card-icon icon-blue">💊</div>
                    </div>
                </div>
                
                <div class="summary-card">
                    <div class="card-content">
                        <div class="card-info">
                            <h3>Low Stock Items</h3>
                            <div class="card-number">15</div>
                            <p class="card-subtitle">Requires attention</p>
                        </div>
                        <div class="card-icon icon-orange">⚠️</div>
                    </div>
                </div>
                
                <div class="summary-card">
                    <div class="card-content">
                        <div class="card-info">
                            <h3>Expiring Soon</h3>
                            <div class="card-number">8</div>
                            <p class="card-subtitle">Within 30 days</p>
                        </div>
                        <div class="card-icon icon-red">⏰</div>
                    </div>
                </div>
                
                <div class="summary-card">
                    <div class="card-content">
                        <div class="card-info">
                            <h3>Today's Sales</h3>
                            <div class="card-number">₱48,500</div>
                            <p class="card-subtitle">125 transactions</p>
                        </div>
                        <div class="card-icon icon-green">💰</div>
                    </div>
                </div>
            </div>
            
            <div class="main-content-grid">
                <div class="medicine-inventory">
                    <div class="inventory-header">
                        <h3 class="inventory-title">Medicine Inventory</h3>
                        <div class="inventory-controls">
                            <div class="search-section">
                                <input type="text" class="search-input" placeholder="Search medicines...">
                                <select class="filter-dropdown">
                                    <option>All Categories</option>
                                    <option>Analgesic</option>
                                    <option>Antibiotic</option>
                                    <option>Antidiabetic</option>
                                    <option>Antihypertensive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>MEDICINE</th>
                                <th>STOCK</th>
                                <th>PRICE</th>
                                <th>EXPIRY</th>
                                <th>STATUS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="medicine-info">
                                        <h4>Paracetamol 500mg</h4>
                                        <p>MED001 • Analgesic</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="stock-info">
                                        <span class="stock-current">150 units</span>
                                        <span class="stock-min">Min: 50</span>
                                    </div>
                                </td>
                                <td class="price">₱5.5</td>
                                <td class="expiry">2025-06-15</td>
                                <td><span class="status-tag status-instock">In Stock</span></td>
                                <td>
                                    <div class="action-icons">
                                        <div class="action-icon view" onclick="viewMedicine('MED001')">👁️</div>
                                        <div class="action-icon edit" onclick="editMedicine('MED001')">✏️</div>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    <div class="medicine-info">
                                        <h4>Amoxicillin 250mg</h4>
                                        <p>MED002 • Antibiotic</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="stock-info">
                                        <span class="stock-current">25 units</span>
                                        <span class="stock-min">Min: 30</span>
                                    </div>
                                </td>
                                <td class="price">₱15.25</td>
                                <td class="expiry">2024-12-20</td>
                                <td><span class="status-tag status-lowstock">Low Stock</span></td>
                                <td>
                                    <div class="action-icons">
                                        <div class="action-icon view" onclick="viewMedicine('MED002')">👁️</div>
                                        <div class="action-icon edit" onclick="editMedicine('MED002')">✏️</div>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    <div class="medicine-info">
                                        <h4>Ibuprofen 400mg</h4>
                                        <p>MED003 • Analgesic</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="stock-info">
                                        <span class="stock-current">200 units</span>
                                        <span class="stock-min">Min: 40</span>
                                    </div>
                                </td>
                                <td class="price">₱8.75</td>
                                <td class="expiry">2025-03-10</td>
                                <td><span class="status-tag status-instock">In Stock</span></td>
                                <td>
                                    <div class="action-icons">
                                        <div class="action-icon view" onclick="viewMedicine('MED003')">👁️</div>
                                        <div class="action-icon edit" onclick="editMedicine('MED003')">✏️</div>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    <div class="medicine-info">
                                        <h4>Metformin 500mg</h4>
                                        <p>MED004 • Antidiabetic</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="stock-info">
                                        <span class="stock-current">5 units</span>
                                        <span class="stock-min">Min: 25</span>
                                    </div>
                                </td>
                                <td class="price">₱12</td>
                                <td class="expiry">2024-08-30</td>
                                <td><span class="status-tag status-critical">Critical</span></td>
                                <td>
                                    <div class="action-icons">
                                        <div class="action-icon view" onclick="viewMedicine('MED004')">👁️</div>
                                        <div class="action-icon edit" onclick="editMedicine('MED004')">✏️</div>
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    <div class="medicine-info">
                                        <h4>Lisinopril 10mg</h4>
                                        <p>MED005 • Antihypertensive</p>
                                    </div>
                                </td>
                                <td>
                                    <div class="stock-info">
                                        <span class="stock-current">80 units</span>
                                        <span class="stock-min">Min: 30</span>
                                    </div>
                                </td>
                                <td class="price">₱18.5</td>
                                <td class="expiry">2025-01-25</td>
                                <td><span class="status-tag status-instock">In Stock</span></td>
                                <td>
                                    <div class="action-icons">
                                        <div class="action-icon view" onclick="viewMedicine('MED005')">👁️</div>
                                        <div class="action-icon edit" onclick="editMedicine('MED005')">✏️</div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="recent-prescriptions">
                    <div class="prescriptions-header">
                        <h3 class="prescriptions-title">Recent Prescriptions</h3>
                    </div>
                    
                    <div class="prescription-item">
                        <div class="prescription-header">
                            <span class="prescription-id">RX001</span>
                            <span class="prescription-status status-dispensed">Dispensed</span>
                        </div>
                        <h4 class="patient-name">Juan Dela Cruz</h4>
                        <p class="medicine-name">Paracetamol 500mg</p>
                        <p class="prescription-details">Qty: 20 • Dr. Martinez</p>
                        <p class="prescription-date">2024-01-15</p>
                    </div>
                    
                    <div class="prescription-item">
                        <div class="prescription-header">
                            <span class="prescription-id">RX002</span>
                            <span class="prescription-status status-pending">Pending</span>
                        </div>
                        <h4 class="patient-name">Maria Santos</h4>
                        <p class="medicine-name">Amoxicillin 250mg</p>
                        <p class="prescription-details">Qty: 15 • Dr. Rodriguez</p>
                        <p class="prescription-date">2024-01-15</p>
                    </div>
                    
                    <div class="prescription-item">
                        <div class="prescription-header">
                            <span class="prescription-id">RX003</span>
                            <span class="prescription-status status-ready">Ready</span>
                        </div>
                        <h4 class="patient-name">Pedro Garcia</h4>
                        <p class="medicine-name">Ibuprofen 400mg</p>
                        <p class="prescription-details">Qty: 30 • Dr. Chen</p>
                        <p class="prescription-date">2024-01-15</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function openAddMedicineModal() {
            alert('Add Medicine modal would open here');
        }
        
        function viewMedicine(medicineId) {
            alert(`Viewing medicine ${medicineId}`);
        }
        
        function editMedicine(medicineId) {
            alert(`Editing medicine ${medicineId}`);
        }
        
        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.inventory-table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Filter functionality
        document.querySelector('.filter-dropdown').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const rows = document.querySelectorAll('.inventory-table tbody tr');
            
            rows.forEach(row => {
                if (filterValue === 'All Categories') {
                    row.style.display = '';
                } else {
                    const categoryCell = row.querySelector('td:first-child p');
                    const category = categoryCell.textContent.toLowerCase();
                    row.style.display = category.includes(filterValue.toLowerCase()) ? '' : 'none';
                }
            });
        });
    </script>
</body>
</html>
