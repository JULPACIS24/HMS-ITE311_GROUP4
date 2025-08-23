<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Management - San Miguel HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/appointments.css') ?>">
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

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-icon {
            width: 32px;
            height: 32px;
            background: #2563eb;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            color: #fff;
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }

        .sidebar-subtitle {
            font-size: 12px;
            color: #64748b;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            display: block;
            padding: 12px 20px;
            color: #334155;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-item:hover {
            background-color: #f1f5f9;
            color: #0f172a;
            border-left-color: #2563eb;
        }

        .menu-item.active {
            background-color: #eef2ff;
            color: #1d4ed8;
            border-left-color: #2563eb;
        }

        .menu-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
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

        .add-patient-btn {
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

        .add-patient-btn:hover {
            background: #1d4ed8;
        }

        /* Page Content */
        .page-content {
            padding: 30px;
        }

        /* Summary Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }

        .stat-icon.total { background: #2563eb; }
        .stat-icon.active { background: #22c55e; }
        .stat-icon.new { background: #3b82f6; }
        .stat-icon.emergency { background: #ef4444; }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
        }

        /* Search and Filter Section */
        .search-filter-section {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-box {
            flex: 1;
            max-width: 400px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .search-input:focus {
            border-color: #2563eb;
        }

        .filter-select {
            padding: 12px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            background: white;
            min-width: 150px;
        }

        .more-filters-btn {
            background: #f8fafc;
            color: #475569;
            border: 1px solid #e5e7eb;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .more-filters-btn:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        /* Patients Table */
        .patients-table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .table-header {
            padding: 20px;
            border-bottom: 1px solid #ecf0f1;
        }

        .table-title {
            font-size: 18px;
            font-weight: 600;
            color: #0f172a;
        }

        .patients-table {
            width: 100%;
            border-collapse: collapse;
        }

        .patients-table th,
        .patients-table td {
            padding: 16px 20px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }

        .patients-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #0f172a;
            font-size: 14px;
        }

        .patients-table td {
            color: #0f172a;
            font-size: 14px;
        }

        .patients-table tr:hover {
            background-color: #f8f9fa;
        }

        .patient-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .patient-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #eef2ff;
            display: grid;
            place-items: center;
            color: #2563eb;
            font-weight: 800;
            font-size: 16px;
        }

        .patient-details {
            display: flex;
            flex-direction: column;
        }

        .patient-name {
            font-weight: 600;
            color: #0f172a;
        }

        .patient-meta {
            color: #64748b;
            font-size: 12px;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background: #ecfdf5;
            color: #16a34a;
        }

        .status-discharged {
            background: #f1f5f9;
            color: #64748b;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s ease;
        }

        .btn-view {
            background: #2563eb;
            color: white;
        }

        .btn-edit {
            background: #f59e0b;
            color: white;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-action:hover {
            opacity: 0.8;
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

            .search-filter-section {
                flex-direction: column;
                gap: 16px;
                align-items: stretch;
            }

            .patients-table-container {
                overflow-x: auto;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
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
                    <h1>Patient Management</h1>
                    <div class="header-subtitle">Manage patient records and information</div>
                </div>
                <a href="<?= site_url('patients/add') ?>" class="add-patient-btn">
                    <span>➕</span> Add Patient
                </a>
            </header>

            <!-- Page Content -->
            <div class="page-content">
                <!-- Summary Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Total Patients</span>
                            <div class="stat-icon total">👥</div>
                        </div>
                        <div class="stat-value"><?= count($patients ?? []) ?></div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Active Patients</span>
                            <div class="stat-icon active">❤️</div>
                        </div>
                        <div class="stat-value"><?= count(array_filter($patients ?? [], function($p) { 
                            return !empty($p['last_visit']) && (new DateTime())->diff(new DateTime($p['last_visit']))->days <= 30; 
                        })) ?></div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">New This Month</span>
                            <div class="stat-icon new">👤</div>
                        </div>
                        <div class="stat-value"><?= count(array_filter($patients ?? [], function($p) { 
                            return !empty($p['created_at']) && (new DateTime())->diff(new DateTime($p['created_at']))->days <= 30; 
                        })) ?></div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">With Medical History</span>
                            <div class="stat-icon emergency">📋</div>
                        </div>
                        <div class="stat-value"><?= count(array_filter($patients ?? [], function($p) { 
                            return !empty($p['medical_history']); 
                        })) ?></div>
                    </div>
                </div>

                <!-- Search and Filter Section -->
                <div class="search-filter-section">
                    <div class="search-box">
                        <input type="text" class="search-input" id="patientSearch" placeholder="Search patients by name or ID...">
                    </div>
                    <select class="filter-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="discharged">Discharged</option>
                        <option value="pending">Pending</option>
                    </select>
                    <button class="more-filters-btn" id="moreFiltersBtn">
                        <span>🔍</span> More Filters
                    </button>
                </div>

                <!-- Patients Table -->
                <div class="patients-table-container">
                    <div class="table-header">
                        <h2 class="table-title">Patient Records</h2>
                    </div>

                    <table class="patients-table">
                        <thead>
                            <tr>
                                <th>PATIENT</th>
                                <th>CONTACT</th>
                                <th>STATUS</th>
                                <th>LAST VISIT</th>
                                <th>CONDITION</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody id="patientsTableBody">
                            <!-- Sample data - will be populated dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Patient data from backend
        const patients = <?= json_encode(array_map(function($p) {
            // Calculate age from DOB
            $age = '';
            if (!empty($p['dob'])) {
                $dob = new DateTime($p['dob']);
                $now = new DateTime();
                $age = $dob->diff($now)->y . 'y';
            }
            
            // Determine status based on last visit (you can customize this logic)
            $status = 'Active';
            if (!empty($p['last_visit'])) {
                $lastVisit = new DateTime($p['last_visit']);
                $now = new DateTime();
                $diff = $now->diff($lastVisit);
                if ($diff->days > 30) {
                    $status = 'Inactive';
                }
            }
            
            return [
                'id' => 'P' . str_pad($p['id'], 3, '0', STR_PAD_LEFT),
                'name' => ($p['first_name'] ?? '') . ' ' . ($p['last_name'] ?? ''),
                'age' => $age,
                'gender' => $p['gender'] ?? '',
                'contact' => $p['phone'] ?? '',
                'status' => $status,
                'lastVisit' => $p['last_visit'] ?? date('Y-m-d'),
                'condition' => $p['medical_history'] ? 'Has Medical History' : 'No Conditions'
            ];
        }, $patients ?? [])) ?>;

        // Render patients table
        function renderPatientsTable(filteredPatients = patients) {
            const tbody = document.getElementById('patientsTableBody');
            tbody.innerHTML = filteredPatients.map(patient => `
                <tr>
                    <td>
                        <div class="patient-info">
                            <div class="patient-avatar">👤</div>
                            <div class="patient-details">
                                <div class="patient-name">${patient.name}</div>
                                <div class="patient-meta">${patient.id} • ${patient.age} • ${patient.gender}</div>
                            </div>
                        </div>
                    </td>
                    <td>${patient.contact}</td>
                    <td><span class="status-badge status-${patient.status.toLowerCase()}">${patient.status}</span></td>
                    <td>${patient.lastVisit}</td>
                    <td>${patient.condition}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= site_url('patients/view') ?>/${patient.id}" class="btn-action btn-view">👁️</a>
                            <a href="<?= site_url('patients/edit') ?>/${patient.id}" class="btn-action btn-edit">✏️</a>
                            <a href="<?= site_url('patients/delete') ?>/${patient.id}" class="btn-action btn-delete" onclick="return confirm('Delete patient ${patient.id}?')">🗑️</a>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        // Search functionality
        document.getElementById('patientSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const filteredPatients = patients.filter(patient => 
                patient.name.toLowerCase().includes(searchTerm) ||
                patient.id.toLowerCase().includes(searchTerm) ||
                patient.contact.includes(searchTerm)
            );
            renderPatientsTable(filteredPatients);
        });

        // Status filter
        document.getElementById('statusFilter').addEventListener('change', function(e) {
            const status = e.target.value;
            let filteredPatients = patients;
            
            if (status) {
                filteredPatients = patients.filter(patient => 
                    patient.status.toLowerCase() === status.toLowerCase()
                );
            }
            
            renderPatientsTable(filteredPatients);
        });

        // More filters button (placeholder for future functionality)
        document.getElementById('moreFiltersBtn').addEventListener('click', function() {
            alert('More filters functionality coming soon!');
        });

        // Initialize table
        if (patients && patients.length > 0) {
            renderPatientsTable();
        } else {
            // Show message if no patients
            document.getElementById('patientsTableBody').innerHTML = `
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">
                        <div style="font-size: 48px; margin-bottom: 16px;">👥</div>
                        <div style="font-weight: 700; color: #0f172a; margin-bottom: 8px;">No Patients Found</div>
                        <div style="font-size: 14px;">Start by adding your first patient using the "Add Patient" button above.</div>
                    </td>
                </tr>
            `;
        }

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
    </script>
</body>
</html>
