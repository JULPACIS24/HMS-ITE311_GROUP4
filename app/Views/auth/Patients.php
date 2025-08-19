<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients - Healthcare Admin</title>
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
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #34495e;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-icon {
            width: 32px;
            height: 32px;
            background: #3498db;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 600;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            display: block;
            padding: 12px 20px;
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: #3498db;
        }

        .menu-item.active {
            background-color: rgba(52, 152, 219, 0.2);
            color: white;
            border-left-color: #3498db;
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
            color: #2c3e50;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: #3498db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        /* Page Content */
        .page-content {
            padding: 30px;
        }

        /* Action Bar */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .search-box {
            flex: 1;
            max-width: 400px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .search-input:focus {
            border-color: #3498db;
        }

        

        .add-patient-btn {
            background: #3498db;
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
            background: #2980b9;
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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
        }

        .table-filters {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .filter-select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
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
            color: #2c3e50;
            font-size: 14px;
        }

        .patients-table td {
            color: #2c3e50;
            font-size: 14px;
        }

        .patients-table tr:hover {
            background-color: #f8f9fa;
        }

        .patient-name {
            font-weight: 600;
            color: #2c3e50;
        }

        .patient-id {
            color: #7f8c8d;
            font-size: 12px;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-active {
            background: #e8f5e8;
            color: #27ae60;
        }

        .status-inactive {
            background: #fee;
            color: #e74c3c;
        }

        .status-pending {
            background: #fff9e6;
            color: #f39c12;
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
            background: #3498db;
            color: white;
        }

        .btn-edit {
            background: #f39c12;
            color: white;
        }

        .btn-delete {
            background: #e74c3c;
            color: white;
        }

        .btn-action:hover {
            opacity: 0.8;
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: white;
            border-top: 1px solid #ecf0f1;
        }

        .pagination-info {
            color: #7f8c8d;
            font-size: 14px;
        }

        .pagination-controls {
            display: flex;
            gap: 8px;
        }

        .page-btn {
            padding: 8px 12px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            color: #2c3e50;
        }

        .page-btn:hover,
        .page-btn.active {
            background: #3498db;
            color: white;
            border-color: #3498db;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
            background: #3498db;
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .stat-title {
            color: #7f8c8d;
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
            background: #3498db;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
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

            .action-bar {
                flex-direction: column;
                gap: 16px;
                align-items: stretch;
            }

            .patients-table-container {
                overflow-x: auto;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <div class="admin-icon">A</div>
                <span class="sidebar-title">Administrator</span>
            </div>
            
            <div class="sidebar-menu">
                <a href="<?= site_url('dashboard') ?>" class="menu-item"><span class="menu-icon">📊</span>Dashboard</a>
                <a href="<?= site_url('patients') ?>" class="menu-item active"><span class="menu-icon">👥</span>Patients</a>
                <a href="<?= site_url('appointments') ?>" class="menu-item"><span class="menu-icon">📅</span>Appointments</a>
                <a href="<?= site_url('billing') ?>" class="menu-item"><span class="menu-icon">💳</span>Billing & Payments</a>
                <a href="<?= site_url('laboratory') ?>" class="menu-item"><span class="menu-icon">🧪</span>Laboratory</a>
                <a href="<?= site_url('pharmacy') ?>" class="menu-item"><span class="menu-icon">💊</span>Pharmacy & Inventory</a>
                <a href="<?= site_url('reports') ?>" class="menu-item"><span class="menu-icon">📈</span>Reports</a>
                <a href="<?= site_url('users') ?>" class="menu-item"><span class="menu-icon">👤</span>User Management</a>
                <a href="<?= site_url('settings') ?>" class="menu-item"><span class="menu-icon">⚙️</span>Settings</a>
                <a href="<?= site_url('logout') ?>" class="menu-item"><span class="menu-icon">🚪</span>Logout</a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <h1>Patients</h1>
                <div class="user-info">
                    <div class="user-avatar">A</div>
                    <span>Admin</span>
                </div>
            </header>

            <!-- Page Content -->
            <div class="page-content">
                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Total Patients</span>
                            <div class="stat-icon">👥</div>
                        </div>
                        <div class="stat-value">1,247</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">New This Month</span>
                            <div class="stat-icon">📈</div>
                        </div>
                        <div class="stat-value">89</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Active Patients</span>
                            <div class="stat-icon">✅</div>
                        </div>
                        <div class="stat-value">1,156</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Pending Reviews</span>
                            <div class="stat-icon">⏳</div>
                        </div>
                        <div class="stat-value">24</div>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="action-bar">
                    <div class="search-box">
                        <input type="text" class="search-input" placeholder="Search patients by name, ID, or phone...">
                    </div>
                    <button id="openPatientModal" class="add-patient-btn" type="button"><span>➕</span> Add New Patient</button>
                </div>

                <!-- Patients Table -->
                <div class="patients-table-container">
                    <div class="table-header">
                        <h2 class="table-title">All Patients</h2>
                        <div class="table-filters">
                            <select class="filter-select">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="pending">Pending</option>
                            </select>
                            <select class="filter-select">
                                <option value="">Sort By</option>
                                <option value="name">Name</option>
                                <option value="date">Date Added</option>
                                <option value="status">Status</option>
                            </select>
                        </div>
                    </div>

                    <table class="patients-table">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Patient ID</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($patients)): ?>
                                <?php foreach ($patients as $p): ?>
                                    <tr>
                                        <td>
                                            <div class="patient-name"><?= esc(($p['first_name'] ?? '') . ' ' . ($p['last_name'] ?? '')) ?></div>
                                            <div class="patient-id">#PAT-<?= esc(str_pad((string)$p['id'], 3, '0', STR_PAD_LEFT)) ?></div>
                                        </td>
                                        <td>PAT-<?= esc(str_pad((string)$p['id'], 3, '0', STR_PAD_LEFT)) ?></td>
                                        <td><?= esc($p['phone'] ?? '') ?></td>
                                        <td><?= esc($p['email'] ?? '') ?></td>
                                        <td>-</td>
                                        <td><?= esc($p['gender'] ?? '') ?></td>
                                        <td><span class="status-badge status-active">Active</span></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="#" data-id="<?= $p['id'] ?>" class="btn-action btn-view js-view">View</a>
                                                <a href="#" data-id="<?= $p['id'] ?>" class="btn-action btn-edit">Edit</a>
                                                <a href="<?= site_url('patients/delete/' . $p['id']) ?>" class="btn-action btn-delete" onclick="return confirm('Delete patient PAT-<?= esc(str_pad((string)$p['id'], 3, '0', STR_PAD_LEFT)) ?>?')">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No patients found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    
                </div>
            </div>
            <!-- Patient Modal -->
            <div class="modal" id="patientModal" aria-hidden="true">
                <div class="modal-backdrop" id="closePatientBackdrop"></div>
                <div class="modal-dialog">
                    <div class="modal-header">
                        <h3>Add New Patient</h3>
                        <button class="modal-close" id="closePatientModal" aria-label="Close">×</button>
                    </div>
                    <form method="post" action="<?= site_url('patients/store') ?>">
                        <div class="modal-body">
                            <div class="grid-2 modal-grid">
                                <label>
                                    <span>First Name *</span>
                                    <input type="text" name="first_name" required>
                                </label>
                                <label>
                                    <span>Last Name *</span>
                                    <input type="text" name="last_name" required>
                                </label>
                            </div>
                            <div class="grid-2 modal-grid">
                                <label>
                                    <span>Date of Birth *</span>
                                    <input type="date" name="dob" required>
                                </label>
                                <label>
                                    <span>Gender *</span>
                                    <select name="gender" required>
                                        <option>Male</option>
                                        <option>Female</option>
                                        <option>Other</option>
                                    </select>
                                </label>
                            </div>
                            <div class="grid-2 modal-grid">
                                <label>
                                    <span>Blood Type</span>
                                    <select name="blood_type">
                                        <option value="">Select Blood Type</option>
                                        <option>A+</option><option>A-</option><option>B+</option><option>B-</option>
                                        <option>AB+</option><option>AB-</option><option>O+</option><option>O-</option>
                                    </select>
                                </label>
                                <label>
                                    <span>Phone Number *</span>
                                    <input type="text" name="phone" required>
                                </label>
                            </div>
                            <div class="grid-2 modal-grid">
                                <label>
                                    <span>Email Address</span>
                                    <input type="text" name="email">
                                </label>
                                <label>
                                    <span>Emergency Contact Name</span>
                                    <input type="text" name="emergency_name">
                                </label>
                            </div>
                            <div class="grid-2 modal-grid">
                                <label>
                                    <span>Emergency Contact Phone</span>
                                    <input type="text" name="emergency_phone">
                                </label>
                                <label>
                                    <span>Address</span>
                                    <input type="text" name="address">
                                </label>
                            </div>
                            <label>
                                <span>Medical History</span>
                                <textarea name="medical_history"></textarea>
                            </label>
                            <label>
                                <span>Known Allergies</span>
                                <textarea name="allergies"></textarea>
                            </label>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" type="button" id="cancelPatientModal">Cancel</button>
                            <button class="btn primary" type="submit">Add Patient</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Patient Modal (Phone & Email only) -->
            <div class="modal" id="editPatientModal" aria-hidden="true">
                <div class="modal-backdrop" id="closeEditBackdrop"></div>
                <div class="modal-dialog">
                    <div class="modal-header">
                        <h3>Edit Patient</h3>
                        <button class="modal-close" id="closeEditModal" aria-label="Close">×</button>
                    </div>
                    <form method="post" id="editPatientForm">
                        <div class="modal-body">
                            <div class="grid-2 modal-grid">
                                <label>
                                    <span>Phone *</span>
                                    <input type="text" name="phone" id="editPhone" required>
                                </label>
                                <label>
                                    <span>Email</span>
                                    <input type="text" name="email" id="editEmail">
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" type="button" id="cancelEditModal">Cancel</button>
                            <button class="btn primary" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- View Patient Modal -->
            <div class="modal" id="viewPatientModal" aria-hidden="true">
                <div class="modal-backdrop" id="closeViewBackdrop"></div>
                <div class="modal-dialog">
                    <div class="modal-header">
                        <h3>Patient Details</h3>
                        <button class="modal-close" id="closeViewModal" aria-label="Close">×</button>
                    </div>
                    <div class="modal-body">
                        <div id="viewContent">
                            <p><strong>Name:</strong> <span id="vName"></span></p>
                            <p><strong>Phone:</strong> <span id="vPhone"></span></p>
                            <p><strong>Email:</strong> <span id="vEmail"></span></p>
                            <p><strong>Gender:</strong> <span id="vGender"></span></p>
                            <p><strong>DOB:</strong> <span id="vDob"></span></p>
                            <p><strong>Address:</strong> <span id="vAddress"></span></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" type="button" id="closeViewFooter">Close</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const tableRows = document.querySelectorAll('.patients-table tbody tr');
            
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Delete patient function
        function deletePatient(patientId) {
            if (confirm(`Are you sure you want to delete patient ${patientId}?`)) {
                // Add your delete logic here
                alert(`Patient ${patientId} would be deleted`);
            }
        }

        // Filter functionality
        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', function() {
                // Add filter logic here
                console.log('Filter changed:', this.value);
            });
        });

        // Modal wiring
        const pModal = document.getElementById('patientModal');
        const openPM = document.getElementById('openPatientModal');
        const closePM = document.getElementById('closePatientModal');
        const cancelPM = document.getElementById('cancelPatientModal');
        const closePB = document.getElementById('closePatientBackdrop');
        function openPatient(){ pModal.classList.add('open'); }
        function closePatient(){ pModal.classList.remove('open'); }
        openPM?.addEventListener('click', openPatient);
        closePM?.addEventListener('click', closePatient);
        cancelPM?.addEventListener('click', closePatient);
        closePB?.addEventListener('click', closePatient);

        // Edit modal wiring (phone & email only)
        const eModal = document.getElementById('editPatientModal');
        const closeEB = document.getElementById('closeEditBackdrop');
        const closeEM = document.getElementById('closeEditModal');
        const cancelEM = document.getElementById('cancelEditModal');
        const editPhone = document.getElementById('editPhone');
        const editEmail = document.getElementById('editEmail');
        const editForm = document.getElementById('editPatientForm');
        let editingId = null;
        function openEdit(id){
            editingId = id;
            // Try to hydrate from the table row text if present (simple demo logic)
            const row = [...document.querySelectorAll('.patients-table tbody tr')][id-1];
            if (row){
                const cells = row.querySelectorAll('td');
                const phoneText = cells[2]?.textContent?.trim() || '';
                const emailText = cells[3]?.textContent?.trim() || '';
                editPhone.value = phoneText;
                editEmail.value = emailText;
            } else {
                editPhone.value = '';
                editEmail.value = '';
            }
            eModal.classList.add('open');
        }
        function closeEdit(){ eModal.classList.remove('open'); }
        document.querySelectorAll('.btn-action.btn-edit').forEach(btn => {
            btn.addEventListener('click', (ev) => {
                ev.preventDefault();
                const id = btn.getAttribute('data-id');
                openEdit(id);
            });
        });
        closeEB?.addEventListener('click', closeEdit);
        closeEM?.addEventListener('click', closeEdit);
        cancelEM?.addEventListener('click', closeEdit);
        editForm?.addEventListener('submit', () => {
            if (!editingId) return;
            editForm.setAttribute('action', `<?= site_url('patients/update') ?>/${editingId}`);
        });

        // View modal
        const vModal = document.getElementById('viewPatientModal');
        const closeVB = document.getElementById('closeViewBackdrop');
        const closeVM = document.getElementById('closeViewModal');
        const closeVF = document.getElementById('closeViewFooter');
        function openView(id){
            fetch(`<?= site_url('patients/json') ?>/${id}`)
                .then(r => r.json())
                .then(p => {
                    document.getElementById('vName').textContent = `${p.first_name ?? ''} ${p.last_name ?? ''}`.trim();
                    document.getElementById('vPhone').textContent = p.phone ?? '';
                    document.getElementById('vEmail').textContent = p.email ?? '';
                    document.getElementById('vGender').textContent = p.gender ?? '';
                    document.getElementById('vDob').textContent = p.dob ?? '';
                    document.getElementById('vAddress').textContent = p.address ?? '';
                    vModal.classList.add('open');
                })
                .catch(() => vModal.classList.add('open'));
        }
        function closeView(){ vModal.classList.remove('open'); }
        document.querySelectorAll('.js-view').forEach(btn => {
            btn.addEventListener('click', (ev) => {
                ev.preventDefault();
                openView(btn.getAttribute('data-id'));
            });
        });
        closeVB?.addEventListener('click', closeView);
        closeVM?.addEventListener('click', closeView);
        closeVF?.addEventListener('click', closeView);

        // Highlight active menu item (exact match by last path segment)
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const currentSegment = currentPath.split('/').filter(Boolean).pop();
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                const href = item.getAttribute('href') || '';
                const segment = href.split('/').filter(Boolean).pop();
                if (segment === currentSegment) {
                    menuItems.forEach(mi => mi.classList.remove('active'));
                    item.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>