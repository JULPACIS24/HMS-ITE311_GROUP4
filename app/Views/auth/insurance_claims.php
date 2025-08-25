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

    .submit-claim-btn {
        background: #2563eb;
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

    .submit-claim-btn:hover {
        background: #1d4ed8;
    }

    /* Page Content */
    .page-content {
        padding: 30px;
    }

    /* Summary Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
        border: 1px solid #e5e7eb;
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
        margin-bottom: 16px;
    }

    .stat-title {
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
    }

    .stat-icon.approved { background: #22c55e; }
    .stat-icon.pending { background: #f59e0b; }
    .stat-icon.rejected { background: #ef4444; }
    .stat-icon.rate { background: #2563eb; }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .stat-detail {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }

    /* Main Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .panel {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    .panel-header {
        padding: 20px 24px;
        border-bottom: 1px solid #ecf0f1;
        background: #f8fafc;
    }

    .panel-title {
        font-size: 18px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 16px;
    }

    .search-filter {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .search-container {
        position: relative;
        flex: 1;
    }

    .search-bar {
        width: 100%;
        padding: 10px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        padding-right: 40px;
        transition: border-color 0.2s;
    }

    .search-bar:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .search-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-size: 16px;
    }

    .filter-dropdown {
        padding: 10px 16px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        min-width: 120px;
        background: white;
        cursor: pointer;
    }

    .filter-dropdown:focus {
        border-color: #2563eb;
    }

    /* Table Styles */
    .table-container {
        overflow-x: auto;
    }

    .claims-table {
        width: 100%;
        border-collapse: collapse;
    }

    .claims-table th {
        background: #f8fafc;
        padding: 16px 12px;
        text-align: left;
        font-weight: 600;
        color: #374151;
        font-size: 13px;
        border-bottom: 1px solid #e5e7eb;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .claims-table td {
        padding: 16px 12px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
        vertical-align: middle;
    }

    .claims-table tr:hover {
        background: #f8fafc;
    }

    /* Claim Details */
    .claim-id {
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 4px;
        font-family: 'Courier New', monospace;
    }

    .patient-name {
        font-weight: 500;
        color: #374151;
        margin-bottom: 4px;
    }

    .services {
        font-size: 12px;
        color: #6b7280;
        line-height: 1.4;
        font-style: italic;
    }

    /* Insurance Info */
    .insurance-provider {
        font-weight: 500;
        color: #374151;
        margin-bottom: 4px;
    }

    .insurance-id {
        font-size: 12px;
        color: #6b7280;
        background: #f3f4f6;
        padding: 2px 8px;
        border-radius: 4px;
        display: inline-block;
        font-family: 'Courier New', monospace;
    }

    /* Amount */
    .claimed-amount {
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 4px;
        font-family: 'Courier New', monospace;
    }

    .approved-amount {
        font-size: 12px;
        color: #059669;
        font-family: 'Courier New', monospace;
    }

    /* Status Badges */
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: center;
        display: inline-block;
    }

    .status-approved { background: #dcfce7; color: #166534; }
    .status-pending { background: #fef3c7; color: #92400e; }
    .status-partial { background: #dbeafe; color: #1d4ed8; }
    .status-rejected { background: #fee2e2; color: #991b1b; }

    /* Dates */
    .submitted-date {
        font-weight: 500;
        color: #374151;
        margin-bottom: 4px;
        font-size: 13px;
    }

    .processed-date {
        font-size: 12px;
        color: #6b7280;
        font-family: 'Courier New', monospace;
    }

    /* Actions */
    .action-links {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .action-link {
        color: #3b82f6;
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.2s;
        padding: 4px 8px;
        border-radius: 4px;
    }

    .action-link:hover {
        color: #2563eb;
        background: #eff6ff;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 24px;
        color: #6b7280;
    }

    .empty-state-icon {
        font-size: 32px;
        margin-bottom: 16px;
    }

    .empty-state-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #374151;
    }

    .empty-state-subtitle {
        font-size: 14px;
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

        .content-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }

        .search-filter {
            flex-direction: column;
        }
    }
</style>

<div class="container">
    <!-- Sidebar -->
    <?php echo view('auth/partials/sidebar'); ?>
    
    <div class="main-content">
        <!-- Header -->
        <header class="header">
            <div>
                <h1>Insurance Claims</h1>
                <div class="header-subtitle">Manage and track insurance claim submissions</div>
            </div>
            <a href="/insurance/submit-claim" class="submit-claim-btn">
                <span>📋</span> Submit New Claim
            </a>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            <!-- Summary Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Total Approved</span>
                        <div class="stat-icon approved">✅</div>
                    </div>
                    <div class="stat-value">₱<?= number_format($stats['total_approved'] ?? 0, 2) ?></div>
                    <div class="stat-detail">Approved claims amount</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Pending Claims</span>
                        <div class="stat-icon pending">⏳</div>
                    </div>
                    <div class="stat-value">₱<?= number_format($stats['pending_claims'] ?? 0, 2) ?></div>
                    <div class="stat-detail"><?= $stats['pending_claims'] ?? 0 ?> pending claims</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Rejected Claims</span>
                        <div class="stat-icon rejected">❌</div>
                    </div>
                    <div class="stat-value">₱<?= number_format($stats['rejected_claims'] ?? 0, 2) ?></div>
                    <div class="stat-detail">Rejected claims amount</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Approval Rate</span>
                        <div class="stat-icon rate">📊</div>
                    </div>
                    <div class="stat-value"><?= $stats['approval_rate'] ?? 0 ?>%</div>
                    <div class="stat-detail">Overall approval percentage</div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="content-grid">
                <!-- Claims Table Panel -->
                <div class="panel">
                    <div class="panel-header">
                        <h2 class="panel-title">Insurance Claims</h2>
                        <div class="search-filter">
                            <div class="search-container">
                                <input type="text" class="search-bar" placeholder="Search claims...">
                                <span class="search-icon">🔍</span>
                            </div>
                            <select class="filter-dropdown">
                                <option>All Claims</option>
                                <option>Approved</option>
                                <option>Pending</option>
                                <option>Rejected</option>
                                <option>Partial</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="table-container">
                        <table class="claims-table">
                            <thead>
                                <tr>
                                    <th>CLAIM DETAILS</th>
                                    <th>INSURANCE INFO</th>
                                    <th>AMOUNT</th>
                                    <th>STATUS</th>
                                    <th>DATES</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($insuranceClaims)): ?>
                                    <?php foreach ($insuranceClaims as $claim): ?>
                                        <tr>
                                            <td>
                                                <div class="claim-id"><?= $claim['claim_id'] ?></div>
                                                <div class="patient-name"><?= $claim['patient_name'] ?></div>
                                                <div class="services"><?= $claim['services'] ?></div>
                                            </td>
                                            <td>
                                                <div class="insurance-provider"><?= $claim['insurance_provider'] ?></div>
                                                <div class="insurance-id"><?= $claim['insurance_id'] ?></div>
                                            </td>
                                            <td>
                                                <div class="claimed-amount">Claimed: ₱<?= number_format($claim['claimed_amount'], 2) ?></div>
                                                <?php if ($claim['approved_amount'] > 0): ?>
                                                    <div class="approved-amount">Approved: ₱<?= number_format($claim['approved_amount'], 2) ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="status-badge status-<?= strtolower($claim['status']) ?>">
                                                    <?= $claim['status'] ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="submitted-date">Submitted: <?= date('Y-m-d', strtotime($claim['submitted_date'])) ?></div>
                                                <?php if ($claim['processed_date']): ?>
                                                    <div class="processed-date">Processed: <?= date('Y-m-d', strtotime($claim['processed_date'])) ?></div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="action-links">
                                                    <a href="#" class="action-link">View</a>
                                                    <a href="#" class="action-link">Download</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <div class="empty-state-icon">🏥</div>
                                                <div class="empty-state-title">No insurance claims found</div>
                                                <div class="empty-state-subtitle">Create bills with insurance providers to see claims here</div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Search functionality
    document.querySelector('.search-bar').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('.claims-table tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Filter functionality
    document.querySelector('.filter-dropdown').addEventListener('change', function(e) {
        const filterValue = e.target.value;
        const rows = document.querySelectorAll('.claims-table tbody tr');
        
        rows.forEach(row => {
            if (filterValue === 'All Claims') {
                row.style.display = '';
                return;
            }
            
            const statusCell = row.querySelector('.status-badge');
            if (statusCell && statusCell.textContent.trim() === filterValue) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<?php echo view('auth/partials/footer'); ?>
