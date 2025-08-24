<?php echo view('auth/partials/header', ['title' => 'Insurance Claims']); ?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        background-color: #f5f7fa;
        overflow-x: hidden;
    }

    .container {
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar Styles */
    .sidebar {
        width: 250px;
        background: #fff;
        color: #0f172a;
        position: fixed;
        height: 100vh;
        overflow-y: auto;
        z-index: 1000;
        border-right: 1px solid #e5e7eb;
    }

    /* Main Content */
    .main-content {
        flex: 1;
        margin-left: 250px;
        padding: 0;
    }

    /* Header */
    .header {
        background: white;
        padding: 20px 30px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header h1 {
        font-size: 24px;
        color: #0f172a;
        font-weight: 600;
    }

    .header-subtitle {
        color: #64748b;
        font-size: 14px;
        margin-top: 4px;
    }

    .back-btn {
        background: #6b7280;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.3s ease;
    }

    .back-btn:hover {
        background: #4b5563;
    }

    /* Page Content */
    .page-content {
        padding: 30px;
    }

    /* Summary Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: #2563eb;
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .stat-title {
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
    }

    .stat-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
    }

    .stat-icon.total { background: #2563eb; }
    .stat-icon.philhealth { background: #0ea5e9; }
    .stat-icon.maxicare { background: #8b5cf6; }
    .stat-icon.intellicare { background: #f59e0b; }
    .stat-icon.amount { background: #10b981; }
    .stat-icon.pending { background: #ef4444; }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .stat-detail {
        font-size: 12px;
        color: #64748b;
    }

    /* Search and Filter */
    .search-filter {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        display: flex;
        gap: 16px;
        align-items: center;
        flex-wrap: wrap;
    }

    .search-bar {
        flex: 1;
        min-width: 250px;
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
    }

    .search-bar:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .filter-dropdown {
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        min-width: 150px;
    }

    .filter-dropdown:focus {
        border-color: #2563eb;
    }

    .date-filter {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .date-input {
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
    }

    .date-input:focus {
        border-color: #2563eb;
    }

    /* Table Styles */
    .table-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .table-header {
        padding: 20px;
        border-bottom: 1px solid #ecf0f1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-title {
        font-size: 18px;
        font-weight: 600;
        color: #0f172a;
    }

    .table-count {
        color: #64748b;
        font-size: 14px;
    }

    .claims-table {
        width: 100%;
        border-collapse: collapse;
    }

    .claims-table th {
        background: #f8fafc;
        padding: 16px;
        text-align: left;
        font-weight: 600;
        color: #374151;
        font-size: 14px;
        border-bottom: 1px solid #e5e7eb;
    }

    .claims-table td {
        padding: 16px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
    }

    .bill-id {
        font-weight: 600;
        color: #1f2937;
    }

    .patient-info {
        display: flex;
        flex-direction: column;
    }

    .patient-name {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 2px;
    }

    .patient-contact {
        font-size: 12px;
        color: #6b7280;
    }

    .amount {
        font-weight: 600;
        color: #1f2937;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        display: inline-block;
    }

    .status-paid { background: #dcfce7; color: #166534; }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-overdue { background: #fee2e2; color: #991b1b; }

    .insurance-provider {
        padding: 6px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        display: inline-block;
    }

    .provider-philhealth { background: #dbeafe; color: #1e40af; }
    .provider-maxicare { background: #f3e8ff; color: #7c3aed; }
    .provider-intellicare { background: #fef3c7; color: #92400e; }

    .due-date {
        color: #6b7280;
        font-size: 14px;
    }

    .actions {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        padding: 8px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: opacity 0.3s ease;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-view { background: #3b82f6; color: white; }
    .btn-edit { background: #f59e0b; color: white; }
    .btn-process { background: #10b981; color: white; }

    .btn-action:hover {
        opacity: 0.8;
    }

    /* Insurance Details */
    .insurance-details {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .empty-state-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #374151;
    }

    .empty-state-subtitle {
        font-size: 14px;
        margin-bottom: 20px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }

        .main-content {
            margin-left: 0;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }

        .search-filter {
            flex-direction: column;
            align-items: stretch;
        }

        .date-filter {
            flex-direction: column;
            align-items: stretch;
        }

        .table-container {
            overflow-x: auto;
        }
    }
</style>

<div class="container">
    <!-- Sidebar -->
    <?php echo view('auth/partials/sidebar'); ?>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div>
                <h1>Insurance Claims</h1>
                <div class="header-subtitle">Manage and track all insurance claims and coverage</div>
            </div>
            <a href="<?= site_url('billing') ?>" class="back-btn">
                <span>←</span> Back to Billing
            </a>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            <!-- Summary Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Total Claims</span>
                        <div class="stat-icon total">📋</div>
                    </div>
                    <div class="stat-value"><?= $stats['total_claims'] ?? 0 ?></div>
                    <div class="stat-detail">All insurance claims</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">PhilHealth</span>
                        <div class="stat-icon philhealth">🏥</div>
                    </div>
                    <div class="stat-value"><?= $stats['philhealth_claims'] ?? 0 ?></div>
                    <div class="stat-detail">PhilHealth claims</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Maxicare</span>
                        <div class="stat-icon maxicare">💊</div>
                    </div>
                    <div class="stat-value"><?= $stats['maxicare_claims'] ?? 0 ?></div>
                    <div class="stat-detail">Maxicare claims</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Intellicare</span>
                        <div class="stat-icon intellicare">🩺</div>
                    </div>
                    <div class="stat-value"><?= $stats['intellicare_claims'] ?? 0 ?></div>
                    <div class="stat-detail">Intellicare claims</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Total Insured Amount</span>
                        <div class="stat-icon amount">💰</div>
                    </div>
                    <div class="stat-value">₱<?= number_format($stats['total_insured_amount'] ?? 0, 2) ?></div>
                    <div class="stat-detail">Covered by insurance</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Pending Claims</span>
                        <div class="stat-icon pending">⏳</div>
                    </div>
                    <div class="stat-value"><?= $stats['pending_claims'] ?? 0 ?></div>
                    <div class="stat-detail">Awaiting processing</div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="search-filter">
                <input type="text" class="search-bar" id="searchBar" placeholder="Search by patient name, bill ID, or insurance provider...">
                <select class="filter-dropdown" id="insuranceFilter">
                    <option value="">All Insurance</option>
                    <option value="PhilHealth">PhilHealth</option>
                    <option value="Maxicare">Maxicare</option>
                    <option value="Intellicare">Intellicare</option>
                </select>
                <select class="filter-dropdown" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="Paid">Paid</option>
                    <option value="Pending">Pending</option>
                </select>
                <div class="date-filter">
                    <input type="date" class="date-input" id="startDate" placeholder="Start Date">
                    <span>to</span>
                    <input type="date" class="date-input" id="endDate" placeholder="End Date">
                </div>
            </div>

            <!-- Claims Table -->
            <div class="table-container">
                <div class="table-header">
                    <div>
                        <h2 class="table-title">Insurance Claims</h2>
                        <div class="table-count"><?= count($insuranceBills) ?> claims found</div>
                    </div>
                </div>
                
                <div style="overflow-x: auto;">
                    <table class="claims-table">
                        <thead>
                            <tr>
                                <th>BILL ID</th>
                                <th>PATIENT</th>
                                <th>AMOUNT</th>
                                <th>INSURANCE</th>
                                <th>STATUS</th>
                                <th>DUE DATE</th>
                                <th>CREATED</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody id="claimsTableBody">
                            <?php if (!empty($insuranceBills)): ?>
                                <?php foreach ($insuranceBills as $claim): ?>
                                    <tr data-insurance="<?= strtolower($claim['insurance_provider']) ?>" 
                                        data-status="<?= strtolower($claim['status']) ?>"
                                        data-amount="<?= $claim['total_amount'] ?>"
                                        data-patient="<?= strtolower($claim['patient_name']) ?>"
                                        data-bill-id="<?= strtolower($claim['bill_id']) ?>"
                                        data-created="<?= $claim['created_at'] ?>"
                                        data-due="<?= $claim['due_date'] ?>">
                                        <td class="bill-id"><?= esc($claim['bill_id']) ?></td>
                                        <td>
                                            <div class="patient-info">
                                                <div class="patient-name"><?= esc($claim['patient_name']) ?></div>
                                                <div class="patient-contact">
                                                    <?= esc($claim['phone'] ?? 'N/A') ?> • <?= esc($claim['email'] ?? 'N/A') ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="amount">₱<?= number_format($claim['total_amount'], 2) ?></td>
                                        <td>
                                            <span class="insurance-provider provider-<?= strtolower($claim['insurance_provider']) ?>">
                                                <?= esc($claim['insurance_provider']) ?>
                                            </span>
                                            <?php if (!empty($claim['insurance_details'])): ?>
                                                <?php 
                                                    $insuranceDetails = json_decode($claim['insurance_details'], true);
                                                    if ($insuranceDetails): 
                                                ?>
                                                    <div class="insurance-details">
                                                        <?php if (isset($insuranceDetails['philhealth_number'])): ?>
                                                            #<?= esc($insuranceDetails['philhealth_number']) ?>
                                                            <?php if (isset($insuranceDetails['philhealth_category'])): ?>
                                                                (<?= esc($insuranceDetails['philhealth_category']) ?>)
                                                            <?php endif; ?>
                                                        <?php elseif (isset($insuranceDetails['policy_number'])): ?>
                                                            Policy: <?= esc($insuranceDetails['policy_number']) ?>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?= strtolower($claim['status']) ?>">
                                                <?= esc($claim['status']) ?>
                                                <?php if ($claim['status'] === 'Pending' && strtotime($claim['due_date']) < time()): ?>
                                                    (Overdue)
                                                <?php endif; ?>
                                            </span>
                                        </td>
                                        <td class="due-date"><?= date('Y-m-d', strtotime($claim['due_date'])) ?></td>
                                        <td><?= date('Y-m-d', strtotime($claim['created_at'])) ?></td>
                                        <td class="actions">
                                            <button class="btn-action btn-view" title="View Details" onclick="viewClaim('<?= $claim['bill_id'] ?>')">👁️</button>
                                            <button class="btn-action btn-edit" title="Edit Claim" onclick="editClaim('<?= $claim['bill_id'] ?>')">✏️</button>
                                            <?php if ($claim['status'] === 'Pending'): ?>
                                                <button class="btn-action btn-process" title="Process Claim" onclick="processClaim('<?= $claim['bill_id'] ?>')">⚡</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">🏥</div>
                                            <div class="empty-state-title">No insurance claims found</div>
                                            <div class="empty-state-subtitle">Generate bills with insurance to see claims here</div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    // Search and filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchBar = document.getElementById('searchBar');
        const insuranceFilter = document.getElementById('insuranceFilter');
        const statusFilter = document.getElementById('statusFilter');
        const startDate = document.getElementById('startDate');
        const endDate = document.getElementById('endDate');
        
        // Set default dates (last 30 days)
        const today = new Date();
        const thirtyDaysAgo = new Date();
        thirtyDaysAgo.setDate(today.getDate() - 30);
        
        startDate.value = thirtyDaysAgo.toISOString().split('T')[0];
        endDate.value = today.toISOString().split('T')[0];
        
        // Add event listeners
        [searchBar, insuranceFilter, statusFilter, startDate, endDate].forEach(element => {
            element.addEventListener('input', filterClaims);
            element.addEventListener('change', filterClaims);
        });
    });
    
    function filterClaims() {
        const searchTerm = document.getElementById('searchBar').value.toLowerCase();
        const insuranceFilter = document.getElementById('insuranceFilter').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        const rows = document.querySelectorAll('#claimsTableBody tr');
        let visibleCount = 0;
        
        rows.forEach(row => {
            if (row.cells.length === 1) return; // Skip empty state row
            
            const insurance = row.dataset.insurance;
            const status = row.dataset.status;
            const amount = parseFloat(row.dataset.amount);
            const patient = row.dataset.patient;
            const billId = row.dataset.billId;
            const created = row.dataset.created;
            const due = row.dataset.due;
            
            // Text search
            const matchesSearch = !searchTerm || 
                patient.includes(searchTerm) || 
                billId.includes(searchTerm) || 
                insurance.includes(searchTerm) ||
                amount.toString().includes(searchTerm);
            
            // Insurance filter
            const matchesInsurance = !insuranceFilter || insurance === insuranceFilter;
            
            // Status filter
            const matchesStatus = !statusFilter || status === statusFilter;
            
            // Date filter
            let matchesDate = true;
            if (startDate && endDate) {
                const createdDate = new Date(created);
                const start = new Date(startDate);
                const end = new Date(endDate);
                matchesDate = createdDate >= start && createdDate <= end;
            }
            
            // Show/hide row
            if (matchesSearch && matchesInsurance && matchesStatus && matchesDate) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update count
        const countElement = document.querySelector('.table-count');
        if (countElement) {
            countElement.textContent = `${visibleCount} claims found`;
        }
    }
    
    // Claim action functions
    function viewClaim(billId) {
        alert(`View claim ${billId} - This will open claim details`);
        // TODO: Implement claim viewing functionality
    }
    
    function editClaim(billId) {
        alert(`Edit claim ${billId} - This will open claim editor`);
        // TODO: Implement claim editing functionality
    }
    
    function processClaim(billId) {
        if (confirm(`Process claim ${billId}?`)) {
            alert(`Claim ${billId} is being processed!`);
            // TODO: Implement claim processing functionality
            // This should update the claim status and send to insurance provider
        }
    }
</script>

<?php echo view('auth/partials/footer'); ?>
