<?php echo view('auth/partials/header', ['title' => 'Role Management']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header"><h1>Role Management</h1><?php echo view('auth/partials/userbadge'); ?></header>
        <div class="page-content">
            <style>
                .add-role-btn {
                    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                    color: white;
                    border: none;
                    padding: 12px 24px;
                    border-radius: 8px;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    font-size: 14px;
                    margin-bottom: 24px;
                }

                .add-role-btn:hover {
                    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
                    transform: translateY(-1px);
                }

                .roles-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
                    gap: 20px;
                    margin-bottom: 24px;
                }

                .role-card {
                    background: white;
                    border-radius: 12px;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                    overflow: hidden;
                    transition: transform 0.2s ease, box-shadow 0.2s ease;
                }

                .role-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                }

                .role-header {
                    padding: 20px;
                    border-bottom: 1px solid #e5e7eb;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .role-info {
                    flex: 1;
                }

                .role-name {
                    font-size: 18px;
                    font-weight: 600;
                    color: #1e293b;
                    margin-bottom: 4px;
                }

                .role-description {
                    color: #64748b;
                    font-size: 14px;
                }

                .role-badge {
                    padding: 4px 12px;
                    border-radius: 20px;
                    font-size: 12px;
                    font-weight: 500;
                    text-transform: uppercase;
                }

                .badge-admin {
                    background: #fef3c7;
                    color: #92400e;
                }

                .badge-doctor {
                    background: #dbeafe;
                    color: #1e40af;
                }

                .badge-nurse {
                    background: #d1fae5;
                    color: #065f46;
                }

                .badge-it {
                    background: #e0e7ff;
                    color: #3730a3;
                }

                .badge-pharmacist {
                    background: #fce7f3;
                    color: #be185d;
                }

                .badge-laboratory {
                    background: #ecfdf5;
                    color: #059669;
                }

                .badge-accountant {
                    background: #fef3c7;
                    color: #d97706;
                }

                .badge-receptionist {
                    background: #f3e8ff;
                    color: #7c3aed;
                }

                .role-body {
                    padding: 20px;
                }

                .permissions-section {
                    margin-bottom: 20px;
                }

                .section-title {
                    font-size: 14px;
                    font-weight: 600;
                    color: #374151;
                    margin-bottom: 12px;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }

                .permissions-list {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                    gap: 8px;
                }

                .permission-item {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    font-size: 13px;
                    color: #6b7280;
                }

                .permission-check {
                    width: 16px;
                    height: 16px;
                    border-radius: 3px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    font-size: 10px;
                }

                .permission-check.granted {
                    background: #10b981;
                }

                .permission-check.denied {
                    background: #ef4444;
                }

                .role-stats {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 16px;
                    margin-bottom: 20px;
                }

                .stat-item {
                    text-align: center;
                    padding: 12px;
                    background: #f8fafc;
                    border-radius: 8px;
                }

                .stat-number {
                    font-size: 20px;
                    font-weight: 700;
                    color: #1e293b;
                    margin-bottom: 4px;
                }

                .stat-label {
                    font-size: 12px;
                    color: #64748b;
                    font-weight: 500;
                }

                .role-actions {
                    display: flex;
                    gap: 8px;
                }

                .action-btn {
                    flex: 1;
                    padding: 8px 12px;
                    border: none;
                    border-radius: 6px;
                    font-size: 12px;
                    font-weight: 500;
                    cursor: pointer;
                    transition: all 0.2s ease;
                }

                .edit-btn {
                    background: #dbeafe;
                    color: #1e40af;
                }

                .edit-btn:hover {
                    background: #bfdbfe;
                }

                .delete-btn {
                    background: #fee2e2;
                    color: #dc2626;
                }

                .delete-btn:hover {
                    background: #fecaca;
                }

                .modal {
                    display: none;
                    position: fixed;
                    z-index: 1000;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, 0.5);
                }

                .modal-content {
                    background-color: white;
                    margin: 5% auto;
                    padding: 0;
                    border-radius: 12px;
                    width: 90%;
                    max-width: 600px;
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                }

                .modal-header {
                    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                    color: white;
                    padding: 20px;
                    border-radius: 12px 12px 0 0;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .modal-header h2 {
                    margin: 0;
                    font-size: 20px;
                    font-weight: 600;
                }

                .modal-body {
                    padding: 24px;
                }

                .form-group {
                    margin-bottom: 20px;
                }

                .form-group label {
                    display: block;
                    margin-bottom: 8px;
                    font-weight: 500;
                    color: #374151;
                }

                .form-group input,
                .form-group textarea,
                .form-group select {
                    width: 100%;
                    padding: 12px;
                    border: 1px solid #d1d5db;
                    border-radius: 8px;
                    font-size: 14px;
                    transition: border-color 0.2s ease;
                }

                .form-group input:focus,
                .form-group textarea:focus,
                .form-group select:focus {
                    outline: none;
                    border-color: #3b82f6;
                    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
                }

                .form-group textarea {
                    resize: vertical;
                    min-height: 80px;
                }

                .permissions-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 12px;
                    margin-top: 12px;
                }

                .permission-checkbox {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    padding: 8px;
                    border: 1px solid #e5e7eb;
                    border-radius: 6px;
                    cursor: pointer;
                    transition: background 0.2s ease;
                }

                .permission-checkbox:hover {
                    background: #f9fafb;
                }

                .permission-checkbox input[type="checkbox"] {
                    width: 16px;
                    height: 16px;
                    accent-color: #3b82f6;
                }

                .modal-footer {
                    padding: 20px 24px;
                    border-top: 1px solid #e5e7eb;
                    display: flex;
                    gap: 12px;
                    justify-content: flex-end;
                }

                .btn {
                    padding: 10px 20px;
                    border: none;
                    border-radius: 6px;
                    font-weight: 500;
                    cursor: pointer;
                    transition: all 0.2s ease;
                }

                .btn-secondary {
                    background: #f3f4f6;
                    color: #374151;
                }

                .btn-primary {
                    background: #3b82f6;
                    color: white;
                }

                .btn-primary:hover {
                    background: #2563eb;
                }

                .close {
                    color: white;
                    font-size: 28px;
                    font-weight: bold;
                    cursor: pointer;
                }

                .close:hover {
                    opacity: 0.7;
                }
            </style>

            <button class="add-role-btn" onclick="openAddModal()">
                <span>➕</span>
                Add New Role
            </button>

            <section class="roles-grid" id="rolesGrid">
                <!-- Role cards will be populated here -->
            </section>

            <!-- Add Role Modal -->
            <div id="addRoleModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Add New Role</h2>
                        <span class="close" onclick="closeModal('addRoleModal')">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form id="addRoleForm">
                            <div class="form-group">
                                <label for="roleName">Role Name</label>
                                <input type="text" id="roleName" name="roleName" required>
                            </div>
                            <div class="form-group">
                                <label for="roleDescription">Description</label>
                                <textarea id="roleDescription" name="roleDescription" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Permissions</label>
                                <div class="permissions-grid">
                                    <label class="permission-checkbox">
                                        <input type="checkbox" name="permissions[]" value="user_management">
                                        <span>User Management</span>
                                    </label>
                                    <label class="permission-checkbox">
                                        <input type="checkbox" name="permissions[]" value="role_management">
                                        <span>Role Management</span>
                                    </label>
                                    <label class="permission-checkbox">
                                        <input type="checkbox" name="permissions[]" value="patient_records">
                                        <span>Patient Records</span>
                                    </label>
                                    <label class="permission-checkbox">
                                        <input type="checkbox" name="permissions[]" value="appointments">
                                        <span>Appointments</span>
                                    </label>
                                    <label class="permission-checkbox">
                                        <input type="checkbox" name="permissions[]" value="medical_reports">
                                        <span>Medical Reports</span>
                                    </label>
                                    <label class="permission-checkbox">
                                        <input type="checkbox" name="permissions[]" value="system_settings">
                                        <span>System Settings</span>
                                    </label>
                                    <label class="permission-checkbox">
                                        <input type="checkbox" name="permissions[]" value="security_logs">
                                        <span>Security Logs</span>
                                    </label>
                                    <label class="permission-checkbox">
                                        <input type="checkbox" name="permissions[]" value="data_export">
                                        <span>Data Export</span>
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="closeModal('addRoleModal')">Cancel</button>
                        <button class="btn btn-primary" onclick="saveRole()">Save Role</button>
                    </div>
                </div>
            </div>

            <!-- Edit Role Modal -->
            <div id="editRoleModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Edit Role</h2>
                        <span class="close" onclick="closeModal('editRoleModal')">&times;</span>
                    </div>
                    <div class="modal-body">
                        <form id="editRoleForm">
                            <div class="form-group">
                                <label for="editRoleName">Role Name</label>
                                <input type="text" id="editRoleName" name="roleName" required>
                            </div>
                            <div class="form-group">
                                <label for="editRoleDescription">Description</label>
                                <textarea id="editRoleDescription" name="roleDescription" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Permissions</label>
                                <div class="permissions-grid" id="editPermissionsGrid">
                                    <!-- Permissions will be populated here -->
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="closeModal('editRoleModal')">Cancel</button>
                        <button class="btn btn-primary" onclick="updateRole()">Update Role</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<?php echo view('auth/partials/logout_confirm'); ?>

<script>
// Role data with permissions
const roles = [
    {
        id: 'admin',
        name: 'Administrator',
        description: 'Full system access and control',
        badge: 'badge-admin',
        userCount: 5,
        permissions: ['user_management', 'role_management', 'system_settings', 'security_logs', 'data_export', 'patient_records']
    },
    {
        id: 'doctor',
        name: 'Doctor',
        description: 'Medical staff with patient access',
        badge: 'badge-doctor',
        userCount: 45,
        permissions: ['patient_records', 'appointments', 'medical_reports']
    },
    {
        id: 'nurse',
        name: 'Nurse',
        description: 'Nursing staff with limited access',
        badge: 'badge-nurse',
        userCount: 89,
        permissions: ['patient_records', 'appointments']
    },
    {
        id: 'it_staff',
        name: 'IT Staff',
        description: 'Technical support and maintenance',
        badge: 'badge-it',
        userCount: 12,
        permissions: ['user_management', 'role_management', 'security_logs', 'system_settings']
    },
    {
        id: 'pharmacist',
        name: 'Pharmacist',
        description: 'Pharmacy staff with medication access',
        badge: 'badge-pharmacist',
        userCount: 15,
        permissions: ['patient_records', 'medical_reports']
    },
    {
        id: 'laboratory',
        name: 'Laboratory',
        description: 'Lab technicians with test access',
        badge: 'badge-laboratory',
        userCount: 20,
        permissions: ['patient_records', 'medical_reports']
    },
    {
        id: 'accountant',
        name: 'Accountant',
        description: 'Financial staff with billing access',
        badge: 'badge-accountant',
        userCount: 8,
        permissions: ['data_export']
    },
    {
        id: 'receptionist',
        name: 'Receptionist',
        description: 'Front desk staff with appointment access',
        badge: 'badge-receptionist',
        userCount: 25,
        permissions: ['appointments', 'patient_records']
    }
];

const allPermissions = [
    { id: 'user_management', name: 'User Management' },
    { id: 'role_management', name: 'Role Management' },
    { id: 'patient_records', name: 'Patient Records' },
    { id: 'appointments', name: 'Appointments' },
    { id: 'medical_reports', name: 'Medical Reports' },
    { id: 'system_settings', name: 'System Settings' },
    { id: 'security_logs', name: 'Security Logs' },
    { id: 'data_export', name: 'Data Export' }
];

function loadRoles() {
    const rolesGrid = document.getElementById('rolesGrid');
    rolesGrid.innerHTML = '';
    
    roles.forEach(role => {
        const permissionItems = allPermissions.map(perm => {
            const hasPermission = role.permissions.includes(perm.id);
            return `
                <div class="permission-item">
                    <div class="permission-check ${hasPermission ? 'granted' : 'denied'}">
                        ${hasPermission ? '✓' : '✗'}
                    </div>
                    <span>${perm.name}</span>
                </div>
            `;
        }).join('');

        rolesGrid.innerHTML += `
            <div class="role-card">
                <div class="role-header">
                    <div class="role-info">
                        <div class="role-name">${role.name}</div>
                        <div class="role-description">${role.description}</div>
                    </div>
                    <span class="role-badge ${role.badge}">${role.name.toUpperCase()}</span>
                </div>
                <div class="role-body">
                    <div class="permissions-section">
                        <div class="section-title">Permissions</div>
                        <div class="permissions-list">
                            ${permissionItems}
                        </div>
                    </div>
                    <div class="role-stats">
                        <div class="stat-item">
                            <div class="stat-number">${role.userCount}</div>
                            <div class="stat-label">Users</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">${role.permissions.length}</div>
                            <div class="stat-label">Permissions</div>
                        </div>
                    </div>
                    <div class="role-actions">
                        <button class="action-btn edit-btn" onclick="editRole('${role.id}')">Edit</button>
                        <button class="action-btn delete-btn" onclick="deleteRole('${role.id}')">Delete</button>
                    </div>
                </div>
            </div>
        `;
    });
}

function openAddModal() {
    document.getElementById('addRoleModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function saveRole() {
    const form = document.getElementById('addRoleForm');
    const formData = new FormData(form);
    
    const roleName = formData.get('roleName');
    const roleDescription = formData.get('roleDescription');
    const permissions = formData.getAll('permissions[]');
    
    // Create new role
    const newRole = {
        id: roleName.toLowerCase().replace(/\s+/g, '_'),
        name: roleName,
        description: roleDescription,
        badge: 'badge-it', // Default badge
        userCount: 0,
        permissions: permissions
    };
    
    roles.push(newRole);
    loadRoles();
    closeModal('addRoleModal');
    form.reset();
    alert('Role added successfully!');
}

function editRole(roleId) {
    const role = roles.find(r => r.id === roleId);
    if (!role) return;
    
    document.getElementById('editRoleName').value = role.name;
    document.getElementById('editRoleDescription').value = role.description;
    
    // Populate permissions
    const editPermissionsGrid = document.getElementById('editPermissionsGrid');
    editPermissionsGrid.innerHTML = '';
    
    allPermissions.forEach(perm => {
        const checked = role.permissions.includes(perm.id) ? 'checked' : '';
        editPermissionsGrid.innerHTML += `
            <label class="permission-checkbox">
                <input type="checkbox" name="permissions[]" value="${perm.id}" ${checked}>
                <span>${perm.name}</span>
            </label>
        `;
    });
    
    document.getElementById('editRoleForm').setAttribute('data-role-id', roleId);
    document.getElementById('editRoleModal').style.display = 'block';
}

function updateRole() {
    const form = document.getElementById('editRoleForm');
    const roleId = form.getAttribute('data-role-id');
    const role = roles.find(r => r.id === roleId);
    
    if (!role) return;
    
    const formData = new FormData(form);
    role.name = formData.get('roleName');
    role.description = formData.get('roleDescription');
    role.permissions = formData.getAll('permissions[]');
    
    loadRoles();
    closeModal('editRoleModal');
    alert('Role updated successfully!');
}

function deleteRole(roleId) {
    if (confirm('Are you sure you want to delete this role? This action cannot be undone.')) {
        const roleIndex = roles.findIndex(r => r.id === roleId);
        if (roleIndex > -1) {
            roles.splice(roleIndex, 1);
            loadRoles();
            alert('Role deleted successfully!');
        }
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
}

// Load roles on page load
document.addEventListener('DOMContentLoaded', function() {
    loadRoles();
});
</script>