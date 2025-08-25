<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Management - San Miguel HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        .pharmacy-dashboard {
            padding: 20px;
            background: #f8fafc;
            min-height: 100vh;
        }
        
        .pharmacy-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .pharmacy-title h1 {
            color: #1e293b;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        
        .pharmacy-title p {
            color: #64748b;
            margin: 5px 0 0 0;
            font-size: 16px;
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
        .card-icon.red { background: #fecaca; color: #dc2626; }
        .card-icon.green { background: #bbf7d0; color: #16a34a; }
        
        .card-subtitle {
            font-size: 14px;
            color: #64748b;
            margin: 0;
        }
        
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }
        
        .inventory-section {
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
        
        .medicine-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .medicine-table th {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }
        
        .medicine-table td {
            padding: 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: #374151;
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
        
        .stock-quantity {
            font-weight: 600;
            color: #1e293b;
        }
        
        .stock-min {
            font-size: 12px;
            color: #6b7280;
        }
        
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
            display: inline-block;
        }
        
        .status-in-stock { background: #dcfce7; color: #16a34a; }
        .status-low-stock { background: #fed7aa; color: #ea580c; }
        .status-critical { background: #fecaca; color: #dc2626; }
        
        .action-btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-right: 8px;
        }
        
        .action-btn:hover {
            background: #2563eb;
        }
        
        .action-btn.edit {
            background: #10b981;
        }
        
        .action-btn.edit:hover {
            background: #059669;
        }
        
        .prescriptions-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        
        .prescription-card {
            padding: 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 16px;
            background: #f8fafc;
        }
        
        .prescription-card:last-child {
            margin-bottom: 0;
        }
        
        .prescription-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
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
        }
        
        .status-dispensed { background: #dcfce7; color: #16a34a; }
        .status-pending { background: #fef3c7; color: #d97706; }
        .status-ready { background: #dbeafe; color: #1e40af; }
        .status-out-of-stock { background: #fecaca; color: #dc2626; }
        
        .prescription-details {
            font-size: 12px;
            color: #64748b;
            line-height: 1.4;
        }
        
        .prescription-details p {
            margin: 2px 0;
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
            
            .pharmacy-header {
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
        
        <div class="pharmacy-dashboard">
            <div class="pharmacy-header">
                <div class="pharmacy-title">
                    <h1>Pharmacy Management</h1>
                    <p>Manage inventory, prescriptions and medicine dispensing</p>
                </div>
                <button class="add-medicine-btn" onclick="openAddMedicineModal()">
                    <span>+</span>
                    Add Medicine
                </button>
            </div>
            
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-number"><?= $stats['total_medications'] ?? 0 ?></h2>
                            <p class="card-subtitle">16 categories</p>
                        </div>
                        <div class="card-icon blue">💊</div>
                    </div>
                    <p class="card-subtitle">Total Medicines</p>
                </div>
                
                <div class="summary-card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-number"><?= $stats['low_stock_items'] ?? 0 ?></h2>
                            <p class="card-subtitle">Requires attention</p>
                        </div>
                        <div class="card-icon orange">⚠️</div>
                    </div>
                    <p class="card-subtitle">Low Stock Items</p>
                </div>
                
                <div class="summary-card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-number"><?= $stats['expiring_soon'] ?? 0 ?></h2>
                            <p class="card-subtitle">Within 60 days</p>
                        </div>
                        <div class="card-icon red">⏰</div>
                    </div>
                    <p class="card-subtitle">Expiring Soon</p>
                </div>
                
                <div class="summary-card">
                    <div class="card-header">
                        <div>
                            <h2 class="card-number">₱<?= number_format($stats['total_value'] ?? 0, 2) ?></h2>
                            <p class="card-subtitle"><?= $prescriptionStats['dispensed_today'] ?? 0 ?> transactions today</p>
                        </div>
                        <div class="card-icon green">💰</div>
                    </div>
                    <p class="card-subtitle">Inventory Value</p>
                </div>
            </div>
            
            <div class="content-grid">
                <div class="inventory-section">
                    <div class="section-header">
                        <h3 class="section-title">Medical Inventory</h3>
                        <div class="search-filter">
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
                    
                    <div style="overflow-x: auto;">
                        <table class="medicine-table">
                            <thead>
                                <tr>
                                    <th>MEDICINE</th>
                                    <th>STOCK</th>
                                    <th>PRICE</th>
                                    <th>CATEGORY</th>
                                    <th>STATUS</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($recentMedications)): ?>
                                    <?php foreach ($recentMedications as $medication): ?>
                                        <?php 
                                        $stockLevel = 'in-stock';
                                        if ($medication['current_stock'] == 0) {
                                            $stockLevel = 'critical';
                                        } elseif ($medication['current_stock'] <= $medication['minimum_stock']) {
                                            $stockLevel = 'low-stock';
                                        }
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="medicine-info">
                                                    <h4><?= esc($medication['medication_name']) ?></h4>
                                                    <p><?= esc($medication['medication_id']) ?> • <?= esc($medication['generic_name']) ?></p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="stock-info">
                                                    <span class="stock-quantity"><?= esc($medication['current_stock']) ?> units</span>
                                                    <span class="stock-min">Min: <?= esc($medication['minimum_stock']) ?></span>
                                                </div>
                                            </td>
                                            <td>₱<?= number_format($medication['unit_price'], 2) ?></td>
                                            <td><?= esc($medication['category']) ?></td>
                                            <td><span class="status-badge status-<?= $stockLevel ?>"><?= ucfirst(str_replace('-', ' ', $stockLevel)) ?></span></td>
                                            <td>
                                                <button class="action-btn" onclick="viewMedicine('<?= $medication['medication_id'] ?>')">👁️</button>
                                                <button class="action-btn edit" onclick="editMedicine('<?= $medication['medication_id'] ?>')">✏️</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 20px; color: #64748b;">
                                            No medications found in inventory.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="prescriptions-section">
                    <h3 class="section-title">Recent Prescriptions</h3>
                    
                    <?php if (!empty($recentPrescriptions)): ?>
                        <?php foreach ($recentPrescriptions as $prescription): ?>
                            <div class="prescription-card">
                                <div class="prescription-header">
                                    <span class="prescription-id"><?= esc($prescription['prescription_id']) ?></span>
                                    <span class="prescription-status status-<?= strtolower(str_replace(' ', '-', $prescription['status'])) ?>"><?= esc($prescription['status']) ?></span>
                                </div>
                                <div class="prescription-details">
                                    <p><strong><?= esc($prescription['patient_name']) ?></strong></p>
                                    <p><?= esc($prescription['diagnosis']) ?></p>
                                    <p>Dr. <?= esc($prescription['doctor_name']) ?></p>
                                    <p>₱<?= number_format($prescription['total_amount'], 2) ?></p>
                                    <p><?= date('M d, Y', strtotime($prescription['created_date'])) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="prescription-card">
                            <div class="prescription-details">
                                <p style="text-align: center; color: #64748b;">No recent prescriptions found.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="view-all-link">
                        <a href="<?= site_url('pharmacy/prescriptions') ?>">View All Prescriptions</a>
                    </div>
                </div>
            </div>
            
            <div class="view-all-link" style="margin-top: 20px; text-align: center;">
                <a href="<?= site_url('pharmacy/inventory') ?>" style="color: #2563eb; text-decoration: none; font-weight: 500; font-size: 14px; margin-right: 20px;">View Full Inventory</a>
                <a href="<?= site_url('pharmacy/stock-alerts') ?>" style="color: #2563eb; text-decoration: none; font-weight: 500; font-size: 14px;">View Stock Alerts</a>
            </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function openAddMedicineModal() {
            window.location.href = '<?= site_url('pharmacy/inventory') ?>';
        }
        
        function viewMedicine(medicineId) {
            window.location.href = '<?= site_url('pharmacy/inventory') ?>';
        }
        
        function editMedicine(medicineId) {
            window.location.href = '<?= site_url('pharmacy/inventory') ?>';
        }
        
        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.medicine-table tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Filter functionality
        document.querySelector('.filter-dropdown').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const rows = document.querySelectorAll('.medicine-table tbody tr');
            
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
