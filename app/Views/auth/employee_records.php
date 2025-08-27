<?php echo view('auth/partials/header', ['title' => 'Employee Records']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header"><h1>Employee Records</h1><?php echo view('auth/partials/userbadge'); ?></header>
        <div class="page-content">
            <style>
                .search-section {
                    background: white;
                    padding: 20px;
                    border-radius: 12px;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                    margin-bottom: 24px;
                }

                .search-form {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 16px;
                    align-items: end;
                }

                .form-group {
                    display: flex;
                    flex-direction: column;
                }

                .form-group label {
                    margin-bottom: 8px;
                    font-weight: 500;
                    color: #374151;
                    font-size: 14px;
                }

                .form-group input,
                .form-group select {
                    padding: 10px 12px;
                    border: 1px solid #d1d5db;
                    border-radius: 6px;
                    font-size: 14px;
                    transition: border-color 0.2s ease;
                }

                .form-group input:focus,
                .form-group select:focus {
                    outline: none;
                    border-color: #3b82f6;
                    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
                }

                .search-btn {
                    background: #3b82f6;
                    color: white;
                    border: none;
                    padding: 10px 20px;
                    border-radius: 6px;
                    font-weight: 500;
                    cursor: pointer;
                    transition: background 0.2s ease;
                }

                .search-btn:hover {
                    background: #2563eb;
                }

                .records-table {
                    background: white;
                    border-radius: 12px;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                    overflow: hidden;
                }

                .table-header {
                    background: #f8fafc;
                    padding: 16px 24px;
                    border-bottom: 1px solid #e2e8f0;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .table-title {
                    font-size: 18px;
                    font-weight: 600;
                    color: #1e293b;
                }

                .export-btn {
                    background: #10b981;
                    color: white;
                    border: none;
                    padding: 8px 16px;
                    border-radius: 6px;
                    font-size: 14px;
                    font-weight: 500;
                    cursor: pointer;
                    transition: background 0.2s ease;
                    display: flex;
                    align-items: center;
                    gap: 6px;
                }

                .export-btn:hover {
                    background: #059669;
                }

                .table-container {
                    overflow-x: auto;
                }

                .records-table table {
                    width: 100%;
                    border-collapse: collapse;
                }

                .records-table th {
                    background: #f1f5f9;
                    padding: 12px 16px;
                    text-align: left;
                    font-weight: 600;
                    color: #374151;
                    font-size: 14px;
                    border-bottom: 1px solid #e2e8f0;
                }

                .records-table td {
                    padding: 12px 16px;
                    border-bottom: 1px solid #f1f5f9;
                    font-size: 14px;
                    color: #374151;
                }

                .records-table tr:hover {
                    background: #f8fafc;
                }

                .status-badge {
                    padding: 4px 8px;
                    border-radius: 12px;
                    font-size: 12px;
                    font-weight: 500;
                    text-transform: uppercase;
                }

                .status-active {
                    background: #d1fae5;
                    color: #065f46;
                }

                .status-inactive {
                    background: #fee2e2;
                    color: #dc2626;
                }

                .action-buttons {
                    display: flex;
                    gap: 8px;
                }

                .action-btn {
                    padding: 6px 12px;
                    border: none;
                    border-radius: 4px;
                    font-size: 12px;
                    font-weight: 500;
                    cursor: pointer;
                    transition: all 0.2s ease;
                    text-decoration: none;
                    display: inline-block;
                }

                .view-btn {
                    background: #dbeafe;
                    color: #1e40af;
                }

                .view-btn:hover {
                    background: #bfdbfe;
                }

                .edit-btn {
                    background: #fef3c7;
                    color: #92400e;
                }

                .edit-btn:hover {
                    background: #fde68a;
                }

                .employee-avatar {
                    width: 32px;
                    height: 32px;
                    border-radius: 50%;
                    background: #3b82f6;
                    color: white;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: 600;
                    font-size: 12px;
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
                    padding: 20px;
                    border-radius: 12px;
                    width: 90%;
                    max-width: 600px;
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
                }

                .modal-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 20px;
                    padding-bottom: 10px;
                    border-bottom: 1px solid #e5e7eb;
                }

                .close {
                    font-size: 24px;
                    font-weight: bold;
                    cursor: pointer;
                    color: #6b7280;
                }

                .close:hover {
                    color: #dc2626;
                }

                .notification {
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    padding: 12px 20px;
                    border-radius: 6px;
                    color: white;
                    font-weight: 500;
                    z-index: 1001;
                    display: none;
                }

                .notification.success {
                    background: #10b981;
                }

                .notification.error {
                    background: #ef4444;
                }
            </style>

            <section class="search-section">
                <form class="search-form">
                    <div class="form-group">
                        <label for="searchName">Employee Name</label>
                        <input type="text" id="searchName" placeholder="Search by name...">
                    </div>
                    <div class="form-group">
                        <label for="searchDepartment">Department</label>
                        <select id="searchDepartment">
                            <option value="">All Departments</option>
                            <option value="Medical">Medical</option>
                            <option value="Nursing">Nursing</option>
                            <option value="Pharmacy">Pharmacy</option>
                            <option value="Laboratory">Laboratory</option>
                            <option value="Finance">Finance</option>
                            <option value="Front Desk">Front Desk</option>
                            <option value="IT">IT</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="searchStatus">Status</label>
                        <select id="searchStatus">
                            <option value="">All Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" class="search-btn" onclick="searchRecords()">Search</button>
                    </div>
                </form>
            </section>

            <section class="records-table">
                <div class="table-header">
                    <h3 class="table-title">Employee Records</h3>
                    <button class="export-btn" onclick="exportRecords()">
                        <span>📥</span>
                        Export
                    </button>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Employee ID</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="employeeTableBody">
                            <?php if (!empty($employees)): ?>
                                <?php foreach ($employees as $employee): ?>
                                    <?php 
                                    $initials = '';
                                    $nameParts = explode(' ', $employee['name']);
                                    foreach ($nameParts as $part) {
                                        if (!empty($part)) {
                                            $initials .= strtoupper(substr($part, 0, 1));
                                        }
                                    }
                                    $statusClass = $employee['status'] === 'Active' ? 'status-active' : 'status-inactive';
                                    $roleDisplay = ucwords(str_replace('_', ' ', $employee['role']));
                                    ?>
                                    <tr>
                                        <td>
                                            <div style="display: flex; align-items: center; gap: 12px;">
                                                <div class="employee-avatar"><?= $initials ?></div>
                                                <div>
                                                    <div style="font-weight: 600;"><?= esc($employee['name']) ?></div>
                                                    <div style="font-size: 12px; color: #64748b;">
                                                        <?= $roleDisplay ?>
                                                        <?php if (!empty($employee['specialty'])): ?>
                                                            • <?= esc($employee['specialty']) ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>EMP<?= str_pad($employee['id'], 3, '0', STR_PAD_LEFT) ?></td>
                                        <td><?= esc($employee['department']) ?></td>
                                        <td><?= $roleDisplay ?></td>
                                        <td><?= esc($employee['email']) ?></td>
                                        <td><span class="status-badge <?= $statusClass ?>"><?= esc($employee['status']) ?></span></td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="action-btn view-btn" onclick="viewEmployee(<?= $employee['id'] ?>)">View</button>
                                                <button class="action-btn edit-btn" onclick="editEmployee(<?= $employee['id'] ?>)">Edit</button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 20px; color: #64748b;">
                                        No employees found.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- View Employee Modal -->
            <div id="viewEmployeeModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 id="viewEmployeeTitle">Employee Details</h2>
                        <span class="close" onclick="closeModal('viewEmployeeModal')">&times;</span>
                    </div>
                    <div id="viewEmployeeContent">
                        <!-- Employee details will be populated here -->
                    </div>
                </div>
            </div>

            <!-- Edit Employee Modal -->
            <div id="editEmployeeModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Edit Employee</h2>
                        <span class="close" onclick="closeModal('editEmployeeModal')">&times;</span>
                    </div>
                    <form id="editEmployeeForm">
                        <input type="hidden" id="editId" name="id">
                        <div class="form-group">
                            <label for="editName">Name</label>
                            <input type="text" id="editName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" id="editEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="editRole">Role</label>
                            <select id="editRole" name="role" required>
                                <option value="doctor">Doctor</option>
                                <option value="nurse">Nurse</option>
                                <option value="pharmacist">Pharmacist</option>
                                <option value="laboratory">Laboratory</option>
                                <option value="accountant">Accountant</option>
                                <option value="receptionist">Receptionist</option>
                                <option value="it_staff">IT Staff</option>
                            </select>
                        </div>
                        <div class="form-group" id="specialtyGroup" style="display: none;">
                            <label for="editSpecialty">Specialty</label>
                            <select id="editSpecialty" name="specialty">
                                <option value="Cardiologist">Cardiologist</option>
                                <option value="Pediatrician">Pediatrician</option>
                                <option value="Surgeon">Surgeon</option>
                                <option value="General Physician">General Physician</option>
                            </select>
                        </div>
                        <div class="form-group" id="nurseDepartmentGroup" style="display: none;">
                            <label for="editNurseDepartment">Department</label>
                            <select id="editNurseDepartment" name="nurse_department">
                                <option value="Emergency">Emergency</option>
                                <option value="ICU">ICU</option>
                                <option value="Medical">Medical</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editStatus">Status</label>
                            <select id="editStatus" name="status" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                            <button type="button" class="btn" onclick="closeModal('editEmployeeModal')" style="background: #f3f4f6; color: #374151; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer;">Cancel</button>
                            <button type="submit" class="btn" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer;">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Notification -->
            <div id="notification" class="notification"></div>
        </div>
    </main>
</div>
<?php echo view('auth/partials/logout_confirm'); ?>

<script>
// Store employees data from PHP
const employees = <?= json_encode($employees ?? []) ?>;

function searchRecords() {
    const name = document.getElementById('searchName').value.toLowerCase();
    const department = document.getElementById('searchDepartment').value.toLowerCase();
    const status = document.getElementById('searchStatus').value.toLowerCase();
    
    const rows = document.querySelectorAll('#employeeTableBody tr');
    
    rows.forEach(row => {
        const nameCell = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
        const deptCell = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        const statusCell = row.querySelector('td:nth-child(6)').textContent.toLowerCase();
        
        const nameMatch = !name || nameCell.includes(name);
        const deptMatch = !department || deptCell.includes(department);
        const statusMatch = !status || statusCell.includes(status);
        
        row.style.display = nameMatch && deptMatch && statusMatch ? '' : 'none';
    });
}

function exportRecords() {
    const csvContent = "data:text/csv;charset=utf-8," 
        + "Employee ID,Name,Email,Role,Department,Status,Specialty\n"
        + employees.map(emp => 
            `EMP${String(emp.id).padStart(3, '0')},${emp.name},${emp.email},${emp.role},${emp.department},${emp.status},${emp.specialty || ''}`
        ).join("\n");
    
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "employee_records.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showNotification('Employee records exported successfully!', 'success');
}

function viewEmployee(employeeId) {
    const employee = employees.find(emp => emp.id == employeeId);
    if (!employee) {
        showNotification('Employee not found!', 'error');
        return;
    }
    
    const roleDisplay = employee.role.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
    
    document.getElementById('viewEmployeeTitle').textContent = `${employee.name} - Details`;
    document.getElementById('viewEmployeeContent').innerHTML = `
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <h4 style="margin-bottom: 10px; color: #374151;">Basic Information</h4>
                <p><strong>Employee ID:</strong> EMP${String(employee.id).padStart(3, '0')}</p>
                <p><strong>Name:</strong> ${employee.name}</p>
                <p><strong>Email:</strong> ${employee.email}</p>
                <p><strong>Created:</strong> ${new Date(employee.created_at).toLocaleDateString()}</p>
            </div>
            <div>
                <h4 style="margin-bottom: 10px; color: #374151;">Employment Details</h4>
                <p><strong>Role:</strong> ${roleDisplay}</p>
                <p><strong>Department:</strong> ${employee.department}</p>
                ${employee.specialty ? `<p><strong>Specialty:</strong> ${employee.specialty}</p>` : ''}
                <p><strong>Status:</strong> <span class="status-badge ${employee.status === 'Active' ? 'status-active' : 'status-inactive'}">${employee.status}</span></p>
            </div>
        </div>
    `;
    
    document.getElementById('viewEmployeeModal').style.display = 'block';
}

function editEmployee(employeeId) {
    const employee = employees.find(emp => emp.id == employeeId);
    if (!employee) {
        showNotification('Employee not found!', 'error');
        return;
    }
    
    document.getElementById('editId').value = employee.id;
    document.getElementById('editName').value = employee.name;
    document.getElementById('editEmail').value = employee.email;
    document.getElementById('editRole').value = employee.role;
    document.getElementById('editStatus').value = employee.status;
    
    // Show/hide specialty field for doctors
    const specialtyGroup = document.getElementById('specialtyGroup');
    const nurseDepartmentGroup = document.getElementById('nurseDepartmentGroup');
    
    if (employee.role === 'doctor') {
        specialtyGroup.style.display = 'block';
        nurseDepartmentGroup.style.display = 'none';
        document.getElementById('editSpecialty').value = employee.specialty || 'General Physician';
    } else if (employee.role === 'nurse') {
        specialtyGroup.style.display = 'none';
        nurseDepartmentGroup.style.display = 'block';
        document.getElementById('editNurseDepartment').value = employee.department || 'Medical';
    } else {
        specialtyGroup.style.display = 'none';
        nurseDepartmentGroup.style.display = 'none';
    }
    
    document.getElementById('editEmployeeModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

function showNotification(message, type) {
    const notification = document.getElementById('notification');
    notification.textContent = message;
    notification.className = `notification ${type}`;
    notification.style.display = 'block';
    
    setTimeout(() => {
        notification.style.display = 'none';
    }, 3000);
}

// Handle role change in edit form
document.getElementById('editRole').addEventListener('change', function() {
    const specialtyGroup = document.getElementById('specialtyGroup');
    const nurseDepartmentGroup = document.getElementById('nurseDepartmentGroup');
    
    if (this.value === 'doctor') {
        specialtyGroup.style.display = 'block';
        nurseDepartmentGroup.style.display = 'none';
    } else if (this.value === 'nurse') {
        specialtyGroup.style.display = 'none';
        nurseDepartmentGroup.style.display = 'block';
    } else {
        specialtyGroup.style.display = 'none';
        nurseDepartmentGroup.style.display = 'none';
    }
});

// Handle edit form submission
document.getElementById('editEmployeeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('<?= site_url('staff-management/update-employee') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            closeModal('editEmployeeModal');
            // Reload the page to show updated data
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification(data.message || 'Failed to update employee', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while updating employee', 'error');
    });
});

// Close modals when clicking outside
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}

// Search functionality on input change
document.getElementById('searchName').addEventListener('input', searchRecords);
document.getElementById('searchDepartment').addEventListener('change', searchRecords);
document.getElementById('searchStatus').addEventListener('change', searchRecords);
</script>