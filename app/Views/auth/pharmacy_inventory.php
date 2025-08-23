<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management - San Miguel HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        .inventory-management {
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
        .card-number.red { color: #dc2626; }
        .card-number.orange { color: #ea580c; }
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
        
        .add-medicine-btn {
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
        
        .add-medicine-btn:hover {
            background: #1d4ed8;
        }
        
        .inventory-table {
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
        
        .inventory-table table {
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
            margin: 0 0 2px 0;
            font-size: 12px;
        }
        
        .medicine-id {
            color: #9ca3af;
            font-size: 12px;
        }
        
        .stock-level {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .stock-quantity {
            font-weight: 600;
            color: #1e293b;
        }
        
        .stock-status {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 500;
            text-align: center;
            display: inline-block;
        }
        
        .status-in-stock { background: #dcfce7; color: #16a34a; }
        .status-low-stock { background: #fecaca; color: #dc2626; }
        
        .pricing-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .price-per-unit {
            font-weight: 600;
            color: #1e293b;
        }
        
        .total-value {
            font-size: 12px;
            color: #6b7280;
        }
        
        .expiry-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .expiry-date {
            font-weight: 500;
            color: #1e293b;
        }
        
        .expiring-soon {
            background: #fecaca;
            color: #dc2626;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 500;
            text-align: center;
            display: inline-block;
        }
        
        .location-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .location-name {
            font-weight: 500;
            color: #1e293b;
        }
        
        .batch-number {
            font-size: 12px;
            color: #6b7280;
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
        
        .action-link.edit { color: #2563eb; }
        .action-link.restock { color: #16a34a; }
        
        @media (max-width: 1200px) {
            .summary-cards {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .inventory-table {
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
            
            .inventory-table th,
            .inventory-table td {
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
        
        <div class="inventory-management">
            <div class="page-header">
                <h1 class="page-title">Inventory Management</h1>
                <p class="page-subtitle">Monitor and manage pharmacy inventory</p>
            </div>
            
            <div class="summary-cards">
                <div class="summary-card">
                    <h2 class="card-number blue">1,248</h2>
                    <p class="card-label">Total Items</p>
                    <p class="card-subtitle green">+24 this week</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number red">12</h2>
                    <p class="card-label">Low Stock Items</p>
                    <p class="card-subtitle">Needs restocking</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number orange">8</h2>
                    <p class="card-label">Expiring Soon</p>
                    <p class="card-subtitle">Within 30 days</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number green">₱245k</h2>
                    <p class="card-label">Total Value</p>
                    <p class="card-subtitle">Current inventory</p>
                </div>
            </div>
            
            <div class="action-bar">
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
                <button class="add-medicine-btn" onclick="openAddMedicineModal()">
                    Add Medicine
                </button>
            </div>
            
            <div class="inventory-table">
                <div class="table-header">
                    <h3 class="table-title">Medicine Inventory</h3>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>MEDICINE DETAILS</th>
                            <th>STOCK LEVEL</th>
                            <th>PRICING</th>
                            <th>EXPIRY STATUS</th>
                            <th>LOCATION</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="medicine-info">
                                    <h4>Paracetamol</h4>
                                    <p>Acetaminophen, Analgesic | Unilab</p>
                                    <span class="medicine-id">ID: MED001</span>
                                </div>
                            </td>
                            <td>
                                <div class="stock-level">
                                    <span class="stock-quantity">250 units</span>
                                    <span class="stock-status status-in-stock">In Stock</span>
                                </div>
                            </td>
                            <td>
                                <div class="pricing-info">
                                    <span class="price-per-unit">₱2.50/unit</span>
                                    <span class="total-value">Total: ₱625</span>
                                </div>
                            </td>
                            <td>
                                <div class="expiry-info">
                                    <span class="expiry-date">2025-06-15</span>
                                    <span class="expiring-soon">Expiring Soon</span>
                                </div>
                            </td>
                            <td>
                                <div class="location-info">
                                    <span class="location-name">Shelf A1</span>
                                    <span class="batch-number">Batch: PAR240101</span>
                                </div>
                            </td>
                            <td>
                                <div class="action-links">
                                    <a href="#" class="action-link edit" onclick="editMedicine('MED001')">Edit</a>
                                    <a href="#" class="action-link restock" onclick="restockMedicine('MED001')">Restock</a>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <div class="medicine-info">
                                    <h4>Amoxicillin</h4>
                                    <p>Amoxicillin, Antibiotic | Pfizer</p>
                                    <span class="medicine-id">ID: MED002</span>
                                </div>
                            </td>
                            <td>
                                <div class="stock-level">
                                    <span class="stock-quantity">15 units</span>
                                    <span class="stock-status status-low-stock">Low Stock</span>
                                </div>
                            </td>
                            <td>
                                <div class="pricing-info">
                                    <span class="price-per-unit">₱8.75/unit</span>
                                    <span class="total-value">Total: ₱131.25</span>
                                </div>
                            </td>
                            <td>
                                <div class="expiry-info">
                                    <span class="expiry-date">2024-12-20</span>
                                    <span class="expiring-soon">Expiring Soon</span>
                                </div>
                            </td>
                            <td>
                                <div class="location-info">
                                    <span class="location-name">Shelf B2</span>
                                    <span class="batch-number">Batch: AMX231205</span>
                                </div>
                            </td>
                            <td>
                                <div class="action-links">
                                    <a href="#" class="action-link edit" onclick="editMedicine('MED002')">Edit</a>
                                    <a href="#" class="action-link restock" onclick="restockMedicine('MED002')">Restock</a>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <div class="medicine-info">
                                    <h4>Biogesic</h4>
                                    <p>Paracetamol, Analgesic | Unilab</p>
                                    <span class="medicine-id">ID: MED003</span>
                                </div>
                            </td>
                            <td>
                                <div class="stock-level">
                                    <span class="stock-quantity">180 units</span>
                                    <span class="stock-status status-in-stock">In Stock</span>
                                </div>
                            </td>
                            <td>
                                <div class="pricing-info">
                                    <span class="price-per-unit">₱3.20/unit</span>
                                    <span class="total-value">Total: ₱576</span>
                                </div>
                            </td>
                            <td>
                                <div class="expiry-info">
                                    <span class="expiry-date">2025-03-10</span>
                                    <span class="expiring-soon">Expiring Soon</span>
                                </div>
                            </td>
                            <td>
                                <div class="location-info">
                                    <span class="location-name">Shelf A2</span>
                                    <span class="batch-number">Batch: BIO240115</span>
                                </div>
                            </td>
                            <td>
                                <div class="action-links">
                                    <a href="#" class="action-link edit" onclick="editMedicine('MED003')">Edit</a>
                                    <a href="#" class="action-link restock" onclick="restockMedicine('MED003')">Restock</a>
                                </div>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <div class="medicine-info">
                                    <h4>Insulin Glargine</h4>
                                    <p>Insulin Glargine, Antidiabetic | Sanofi</p>
                                    <span class="medicine-id">ID: MED004</span>
                                </div>
                            </td>
                            <td>
                                <div class="stock-level">
                                    <span class="stock-quantity">8 units</span>
                                    <span class="stock-status status-low-stock">Low Stock</span>
                                </div>
                            </td>
                            <td>
                                <div class="pricing-info">
                                    <span class="price-per-unit">₱450.00/unit</span>
                                    <span class="total-value">Total: ₱3,600</span>
                                </div>
                            </td>
                            <td>
                                <div class="expiry-info">
                                    <span class="expiry-date">2024-08-30</span>
                                    <span class="expiring-soon">Expiring Soon</span>
                                </div>
                            </td>
                            <td>
                                <div class="location-info">
                                    <span class="location-name">Refrigerator A</span>
                                    <span class="batch-number">Batch: INS240201</span>
                                </div>
                            </td>
                            <td>
                                <div class="action-links">
                                    <a href="#" class="action-link edit" onclick="editMedicine('MED004')">Edit</a>
                                    <a href="#" class="action-link restock" onclick="restockMedicine('MED004')">Restock</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        function openAddMedicineModal() {
            alert('Add Medicine modal would open here');
        }
        
        function editMedicine(medicineId) {
            alert(`Editing ${medicineId}`);
        }
        
        function restockMedicine(medicineId) {
            alert(`Restocking ${medicineId}`);
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
                    const categoryCell = row.querySelector('td:nth-child(1)');
                    const category = categoryCell.textContent.toLowerCase();
                    row.style.display = category.includes(filterValue.toLowerCase()) ? '' : 'none';
                }
            });
        });
    </script>
</body>
</html>
