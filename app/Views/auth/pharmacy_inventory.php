<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Inventory - San Miguel HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        .pharmacy-inventory {
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
        .card-number.red { color: #dc2626; }
        .card-number.green { color: #10b981; }
        
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
        
        .add-medication-btn {
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
        
        .add-medication-btn:hover {
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
            padding: 16px 24px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table-title {
            color: #1e293b;
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        .inventory-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .inventory-table th {
            background: #f1f5f9;
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }
        
        .inventory-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
            color: #374151;
        }
        
        .inventory-table tr:hover {
            background: #f9fafb;
        }
        
        .stock-status {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-adequate { background: #dcfce7; color: #166534; }
        .status-low { background: #fef3c7; color: #d97706; }
        .status-out { background: #fee2e2; color: #dc2626; }
        
        .prescription-required {
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .prescription-yes { background: #fee2e2; color: #dc2626; }
        .prescription-no { background: #dcfce7; color: #166534; }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-edit { background: #3b82f6; color: white; }
        .btn-edit:hover { background: #2563eb; }
        
        .btn-stock { background: #10b981; color: white; }
        .btn-stock:hover { background: #059669; }
        
        .btn-delete { background: #ef4444; color: white; }
        .btn-delete:hover { background: #dc2626; }
        
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
            
            .inventory-table {
                font-size: 12px;
            }
            
            .inventory-table th,
            .inventory-table td {
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>
    <?= $this->include('auth/partials/sidebar') ?>
    
    <div class="main-content">
        <?= $this->include('auth/partials/header') ?>
        
        <div class="pharmacy-inventory">
            <div class="page-header">
                <h1 class="page-title">Pharmacy Inventory</h1>
                <p class="page-subtitle">Manage and monitor all medications in stock</p>
            </div>
            
            <div class="summary-cards">
                <div class="summary-card">
                    <h2 class="card-number blue"><?= $stats['total_medications'] ?? 0 ?></h2>
                    <p class="card-label">Total Medications</p>
                    <p class="card-subtitle">In inventory</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number orange"><?= $stats['low_stock'] ?? 0 ?></h2>
                    <p class="card-label">Low Stock</p>
                    <p class="card-subtitle">Below minimum</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number red"><?= $stats['out_of_stock'] ?? 0 ?></h2>
                    <p class="card-label">Out of Stock</p>
                    <p class="card-subtitle">Zero inventory</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number green">₱<?= number_format($stats['total_value'] ?? 0, 2) ?></h2>
                    <p class="card-label">Total Value</p>
                    <p class="card-subtitle">Inventory worth</p>
                </div>
            </div>
            
            <div class="action-bar">
                <div class="search-section">
                    <input type="text" class="search-input" placeholder="Search medications...">
                    <select class="filter-dropdown" id="categoryFilter">
                        <option value="">All Categories</option>
                        <option value="Analgesic">Analgesic</option>
                        <option value="NSAID">NSAID</option>
                        <option value="Antibiotic">Antibiotic</option>
                        <option value="ACE Inhibitor">ACE Inhibitor</option>
                        <option value="Antidiabetic">Antidiabetic</option>
                        <option value="Statin">Statin</option>
                        <option value="Proton Pump Inhibitor">Proton Pump Inhibitor</option>
                        <option value="Calcium Channel Blocker">Calcium Channel Blocker</option>
                        <option value="Antiplatelet">Antiplatelet</option>
                        <option value="ARB">ARB</option>
                        <option value="Beta Blocker">Beta Blocker</option>
                        <option value="Diuretic">Diuretic</option>
                        <option value="Anticoagulant">Anticoagulant</option>
                        <option value="Insulin">Insulin</option>
                    </select>
                    <select class="filter-dropdown" id="stockFilter">
                        <option value="">All Stock Levels</option>
                        <option value="adequate">Adequate Stock</option>
                        <option value="low">Low Stock</option>
                        <option value="out">Out of Stock</option>
                    </select>
                </div>
                <button class="add-medication-btn" onclick="showAddMedicationModal()">Add Medication</button>
            </div>
            
            <div class="inventory-table">
                <div class="table-header">
                    <h3 class="table-title">Medications Inventory</h3>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Medication ID</th>
                                <th>Medication Name</th>
                                <th>Generic Name</th>
                                <th>Strength</th>
                                <th>Current Stock</th>
                                <th>Stock Status</th>
                                <th>Unit Price</th>
                                <th>Category</th>
                                <th>Prescription</th>
                                <th>Location</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($medications)): ?>
                                <?php foreach ($medications as $medication): ?>
                                    <?php 
                                    $stockLevel = 'adequate';
                                    if ($medication['current_stock'] == 0) {
                                        $stockLevel = 'out';
                                    } elseif ($medication['current_stock'] <= $medication['minimum_stock']) {
                                        $stockLevel = 'low';
                                    }
                                    ?>
                                    <tr>
                                        <td><?= esc($medication['medication_id']) ?></td>
                                        <td><strong><?= esc($medication['medication_name']) ?></strong></td>
                                        <td><?= esc($medication['generic_name']) ?></td>
                                        <td><?= esc($medication['strength']) ?></td>
                                        <td><?= esc($medication['current_stock']) ?> units</td>
                                        <td>
                                            <span class="stock-status status-<?= $stockLevel ?>">
                                                <?= ucfirst($stockLevel) ?> Stock
                                            </span>
                                        </td>
                                        <td>₱<?= number_format($medication['unit_price'], 2) ?></td>
                                        <td><?= esc($medication['category']) ?></td>
                                        <td>
                                            <span class="prescription-required prescription-<?= $medication['requires_prescription'] ? 'yes' : 'no' ?>">
                                                <?= $medication['requires_prescription'] ? 'Required' : 'OTC' ?>
                                            </span>
                                        </td>
                                        <td><?= esc($medication['location']) ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="action-btn btn-edit" onclick="editMedication(<?= $medication['id'] ?>)">Edit</button>
                                                <button class="action-btn btn-stock" onclick="updateStock(<?= $medication['id'] ?>)">Stock</button>
                                                <button class="action-btn btn-delete" onclick="deleteMedication(<?= $medication['id'] ?>)">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" style="text-align: center; padding: 40px; color: #64748b;">
                                        No medications found in inventory.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Category filter
        document.getElementById('categoryFilter').addEventListener('change', function(e) {
            applyFilters();
        });
        
        // Stock filter
        document.getElementById('stockFilter').addEventListener('change', function(e) {
            applyFilters();
        });
        
        function applyFilters() {
            const categoryFilter = document.getElementById('categoryFilter').value;
            const stockFilter = document.getElementById('stockFilter').value;
            const searchTerm = document.querySelector('.search-input').value.toLowerCase();
            
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length === 0) return; // Skip empty rows
                
                const category = cells[7].textContent.trim();
                const stockStatus = cells[5].textContent.trim().toLowerCase();
                const text = row.textContent.toLowerCase();
                
                const matchesCategory = !categoryFilter || category === categoryFilter;
                const matchesStock = !stockFilter || stockStatus.includes(stockFilter);
                const matchesSearch = !searchTerm || text.includes(searchTerm);
                
                row.style.display = (matchesCategory && matchesStock && matchesSearch) ? '' : 'none';
            });
        }
        
        // Modal functions (to be implemented)
        function showAddMedicationModal() {
            alert('Add Medication functionality will be implemented here.');
        }
        
        function editMedication(id) {
            alert('Edit Medication functionality will be implemented here. ID: ' + id);
        }
        
        function updateStock(id) {
            alert('Update Stock functionality will be implemented here. ID: ' + id);
        }
        
        function deleteMedication(id) {
            if (confirm('Are you sure you want to delete this medication?')) {
                alert('Delete Medication functionality will be implemented here. ID: ' + id);
            }
        }
    </script>
</body>
</html>
