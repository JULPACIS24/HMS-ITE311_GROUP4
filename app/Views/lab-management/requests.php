<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Requests - San Miguel HMS</title>
    
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
            overflow-x: hidden;
            z-index: 1000;
            border-right: 1px solid #e5e7eb;
        }
        
        /* Sidebar Header Styling - Match other sidebars */
        .sidebar .sidebar-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .sidebar .admin-icon {
            width: 32px;
            height: 32px;
            background: #2563eb;
            color: #fff;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            flex-shrink: 0;
        }
        
        .sidebar .sidebar-title {
            font-weight: 800;
            font-size: 16px;
            color: #0f172a;
            line-height: 1.1;
        }
        
        .sidebar .sidebar-subtitle {
            font-size: 12px;
            color: #64748b;
            line-height: 1.1;
        }
        
        .sidebar .hamburger-menu {
            margin-left: auto;
            opacity: 0.8;
            cursor: pointer;
            font-size: 18px;
            color: #64748b;
        }
        
        /* Add spacing between Admin Header and first menu item in Lab Request sidebar */
        .sidebar .sidebar-menu {
            margin-top: 20px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 0;
            overflow-x: hidden;
            max-width: calc(100vw - 250px);
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

        .new-request-btn {
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

        .new-request-btn:hover {
            background: #1d4ed8;
        }

        /* Page Content */
        .page-content {
            padding: 30px;
            overflow-x: hidden;
            max-width: 100%;
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

        .stat-icon.total { background: #22c55e; }
        .stat-icon.pending { background: #f59e0b; }
        .stat-icon.progress { background: #3b82f6; }
        .stat-icon.completed { background: #10b981; }

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

        /* Main Panel */
        .panel {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .panel-header {
            padding: 24px;
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
            max-width: 100%;
        }

        .requests-table {
            width: 100%;
            border-collapse: collapse;
        }

        .requests-table th {
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

        .requests-table td {
            padding: 16px 12px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
            vertical-align: middle;
        }

        .request-id {
            font-weight: 600;
            color: #1f2937;
            font-family: 'Courier New', monospace;
        }

        .patient-info {
            display: flex;
            flex-direction: column;
        }

        .patient-name {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .doctor-name {
            font-size: 12px;
            color: #6b7280;
            font-style: italic;
        }

        .test-type {
            font-weight: 600;
            color: #1f2937;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-align: center;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending { background: #fef3c7; color: #92400e; }
        .status-in-progress { background: #dbeafe; color: #1d4ed8; }
        .status-completed { background: #dcfce7; color: #166534; }
        .status-ready { background: #fef3c7; color: #92400e; }

        .request-date {
            color: #6b7280;
            font-size: 13px;
            font-family: 'Courier New', monospace;
        }

        .actions {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .btn-action {
            padding: 6px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.2s;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .action-link {
            text-decoration: underline;
            font-size: 14px;
            margin-right: 15px;
            font-weight: 500;
        }

        .process-link { color: #10b981; }
        .view-link { color: #3b82f6; }
        .edit-link { color: #374151; }

        .btn-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
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
                max-width: 100vw;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .search-filter {
                flex-direction: column;
            }
        }

        /* Prevent horizontal scrollbars globally */
        html, body {
            overflow-x: hidden;
        }

        .container {
            overflow-x: hidden;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php echo view('auth/partials/sidebar'); ?>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <div>
                    <h1>Lab Requests</h1>
                    <div class="header-subtitle">Manage and track laboratory test requests</div>
                </div>
                <a href="<?= site_url('lab-management/new-test') ?>" class="new-request-btn">
                    <span>🧪</span> New Test Request
                </a>
            </header>

            <!-- Page Content -->
            <div class="page-content">
                <!-- Summary Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Total Requests</span>
                            <div class="stat-icon total">📋</div>
                        </div>
                        <div class="stat-value"><?= $stats['total_requests'] ?? 0 ?></div>
                        <div class="stat-detail">All lab requests</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Pending</span>
                            <div class="stat-icon pending">⏰</div>
                        </div>
                        <div class="stat-value"><?= $stats['pending'] ?? 0 ?></div>
                        <div class="stat-detail">Awaiting processing</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">In Progress</span>
                            <div class="stat-icon progress">🔄</div>
                        </div>
                        <div class="stat-value"><?= $stats['in_progress'] ?? 0 ?></div>
                        <div class="stat-detail">Currently being processed</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Completed</span>
                            <div class="stat-icon completed">✅</div>
                        </div>
                        <div class="stat-value"><?= $stats['completed'] ?? 0 ?></div>
                        <div class="stat-detail">Results ready</div>
                    </div>
                </div>

                <!-- Lab Requests Panel -->
                <div class="panel">
                    <div class="panel-header">
                        <h2 class="panel-title">Laboratory Test Requests</h2>
                        <div class="search-filter">
                            <div class="search-container">
                                <input type="text" class="search-bar" placeholder="Search requests...">
                                <span class="search-icon">🔍</span>
                            </div>
                            <select class="filter-dropdown">
                                <option>All Status</option>
                                <option>Pending</option>
                                <option>In Progress</option>
                                <option>Completed</option>
                                <option>Ready</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="table-container">
                        <table class="requests-table">
                            <thead>
                                <tr>
                                    <th>REQUEST ID</th>
                                    <th>PATIENT</th>
                                    <th>DOCTOR</th>
                                    <th>TEST TYPE</th>
                                    <th>STATUS</th>
                                    <th>REQUEST DATE</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($labRequests)): ?>
                                    <?php foreach ($labRequests as $request): ?>
                                        <tr>
                                            <td class="request-id"><?= esc($request['lab_id']) ?></td>
                                            <td>
                                                <div class="patient-info">
                                                    <div class="patient-name"><?= esc($request['patient_name']) ?></div>
                                                </div>
                                            </td>
                                            <td class="doctor-name"><?= esc($request['doctor_name']) ?></td>
                                            <td class="test-type"><?= esc($request['tests']) ?></td>
                                            <td>
                                                <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $request['status'])) ?>">
                                                    <?= esc($request['status']) ?>
                                                </span>
                                            </td>
                                            <td class="request-date"><?= date('Y-m-d H:i', strtotime($request['created_at'])) ?></td>
                                            <td class="actions">
                                                <a href="<?= site_url('lab-management/process/' . $request['lab_id']) ?>" class="action-link process-link">Process</a>
                                                <a href="<?= site_url('lab-management/view/' . $request['lab_id']) ?>" class="action-link view-link">View</a>
                                                <a href="<?= site_url('lab-management/edit/' . $request['lab_id']) ?>" class="action-link edit-link">Edit</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" style="text-align: center; padding: 40px; color: #64748b;">
                                            <div style="font-size: 16px; margin-bottom: 8px;">🧪</div>
                                            <div>No lab requests found</div>
                                            <div style="font-size: 12px; margin-top: 4px;">Create your first test request to get started</div>
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
        // Highlight active menu item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                const href = item.getAttribute('href') || '';
                if (href && currentPath.includes(href)) {
                    item.classList.add('active');
                }
            });
        });

        // Search functionality
        document.querySelector('.search-bar').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.requests-table tbody tr');
            
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
            const filterValue = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.requests-table tbody tr');
            
            rows.forEach(row => {
                const status = row.querySelector('.status-badge').textContent.toLowerCase();
                if (filterValue === 'all status' || status === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Request action functions
        function deleteRequest(requestId) {
            if (confirm(`Are you sure you want to delete request ${requestId}? This action cannot be undone.`)) {
                window.location.href = `<?= site_url('lab-management/delete/') ?>${requestId}`;
            }
        }
    </script>
</body>
</html>
