<?php echo view('auth/partials/header', ['title' => 'Staff Management']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header"><h1>Staff Management</h1><?php echo view('auth/partials/userbadge'); ?></header>
        <div class="page-content">
            <?php if (!$isItStaff): ?>
                <div class="alert info" style="margin-bottom: 20px; padding: 12px; background: #dbeafe; color: #1e40af; border-radius: 6px; border-left: 4px solid #2563eb;">
                    <strong>Admin Access:</strong> You can create and manage accounts for all staff roles including IT Staff.
                </div>
            <?php endif; ?>
            <div class="stats-grid">
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Total Users</span><div class="stat-icon">👥</div></div><div class="stat-value" id="totalUsers"><?= $totalUsers ?? 0 ?></div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Active Today</span><div class="stat-icon">✅</div></div><div class="stat-value" id="activeToday"><?= $activeToday ?? 0 ?></div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">New This Month</span><div class="stat-icon">🆕</div></div><div class="stat-value" id="newThisMonth"><?= $newThisMonth ?? 0 ?></div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Pending Approval</span><div class="stat-icon">⏳</div></div><div class="stat-value" id="pendingApproval"><?= $pendingApproval ?? 0 ?></div></div>
            </div>
            <div style="text-align: center; margin: 20px 0;">
                <button onclick="refreshStatistics()" style="background: #3b82f6; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                    <span>🔄</span>
                    Refresh Statistics
                </button>
            </div>
            <div class="patients-table-container">
                <div class="table-header"><h2 class="table-title">Staff Management</h2><div><button class="btn primary" id="addUserBtn">Add New User</button></div></div>
                <?php if (!empty($message)): ?>
                    <div class="alert success"><?php echo esc($message); ?></div>
                <?php endif; ?>
                <?php if (!empty($errors)): ?>
                    <div class="alert danger">
                        <?php foreach ($errors as $err): ?>
                            <div><?php echo esc($err); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <table class="patients-table">
                    <thead><tr><th>User</th><th>Email</th><th>Role</th><th>Specialty</th><th>Department</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><?php echo esc($u['name']); ?></td>
                                    <td><?php echo esc($u['email']); ?></td>
                                    <td><?php echo esc(ucwords(str_replace('_',' ',$u['role']))); ?></td>
                                    <td><?php echo esc($u['specialty'] ?? '-'); ?></td>
                                    <td><?php echo esc($u['department'] ?? 'IT'); ?></td>
                                    <td><span class="badge confirmed"><?php echo esc($u['status'] ?? 'Active'); ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" style="text-align:center">No users yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<?php echo view('auth/partials/logout_confirm'); ?>
<div class="modal" id="addUserModal" style="display:none">
    <div class="modal-content" style="max-width:520px">
        <div class="modal-header"><h3>Add New Staff Member</h3><button class="close" id="closeAddUser">×</button></div>
        <form method="post" action="<?php echo site_url('staff-management/store'); ?>" class="form-grid">
            <div class="form-group"><label>Name</label><input type="text" name="name" required value="<?php echo old('name'); ?>"></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" required value="<?php echo old('email'); ?>"></div>
            <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
            <div class="form-group"><label>Confirm Password</label><input type="password" name="password_confirm" required></div>
            <div class="form-group"><label>Role</label>
                <select name="role" id="roleSelect" required>
                    <?php if (!$isItStaff): ?>
                        <!-- Admin can create all roles including IT Staff -->
                        <option value="it_staff">IT Staff</option>
                    <?php endif; ?>
                    <option value="nurse">Nurse</option>
                    <option value="pharmacist">Pharmacist</option>
                    <option value="doctor">Doctor</option>
                    <option value="laboratory">Laboratory</option>
                    <option value="accountant">Accountant</option>
                    <option value="receptionist">Receptionist</option>
                </select>
            </div>
            <div class="form-group" id="specialtyGroup" style="display: none;">
                <label>Specialty</label>
                <select name="specialty" id="specialtySelect">
                    <option value="">Select Specialty</option>
                    <option value="Cardiologist">Cardiologist</option>
                    <option value="Pediatrician">Pediatrician</option>
                    <option value="Surgeon">Surgeon</option>
                    <option value="General Physician">General Physician</option>
                </select>
            </div>
            <div class="modal-actions"><button type="submit" class="btn primary">Create User</button><button type="button" class="btn" id="cancelAddUser">Cancel</button></div>
        </form>
    </div>
    <div class="modal-backdrop"></div>
    <style>
    .modal{position:fixed;inset:0;align-items:center;justify-content:center}
    .modal .modal-backdrop{position:absolute;inset:0;background:#0006}
    .modal .modal-content{position:relative;background:#fff;border-radius:8px;padding:16px;z-index:1}
    .modal .modal-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
    .modal .form-grid .form-group{margin-bottom:10px}
    .modal .modal-actions{display:flex;gap:8px;justify-content:flex-end;margin-top:8px}
    .modal .close{background:none;border:none;font-size:20px;cursor:pointer}
    </style>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addUserBtn = document.getElementById('addUserBtn');
    const addUserModal = document.getElementById('addUserModal');
    const closeAddUser = document.getElementById('closeAddUser');
    const cancelAddUser = document.getElementById('cancelAddUser');

    addUserBtn.addEventListener('click', function() {
        addUserModal.style.display = 'flex';
    });

    closeAddUser.addEventListener('click', function() {
        addUserModal.style.display = 'none';
    });

    cancelAddUser.addEventListener('click', function() {
        addUserModal.style.display = 'none';
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === addUserModal) {
            addUserModal.style.display = 'none';
        }
    });

    // Show/hide specialty field based on role selection
    const roleSelect = document.getElementById('roleSelect');
    const specialtyGroup = document.getElementById('specialtyGroup');
    const specialtySelect = document.getElementById('specialtySelect');

    roleSelect.addEventListener('change', function() {
        if (this.value === 'doctor') {
            specialtyGroup.style.display = 'block';
            specialtySelect.required = true;
        } else {
            specialtyGroup.style.display = 'none';
            specialtySelect.required = false;
            specialtySelect.value = '';
        }
    });
});

    // Function to refresh statistics
    function refreshStatistics() {
        fetch('<?= site_url('staff-management/statistics') ?>')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('totalUsers').textContent = data.statistics.totalUsers;
                    document.getElementById('activeToday').textContent = data.statistics.activeToday;
                    document.getElementById('newThisMonth').textContent = data.statistics.newThisMonth;
                    document.getElementById('pendingApproval').textContent = data.statistics.pendingApproval;
                    
                    // Show success message
                    const refreshBtn = event.target;
                    const originalText = refreshBtn.innerHTML;
                    refreshBtn.innerHTML = '<span>✅</span> Updated!';
                    refreshBtn.style.background = '#10b981';
                    
                    setTimeout(() => {
                        refreshBtn.innerHTML = originalText;
                        refreshBtn.style.background = '#3b82f6';
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error refreshing statistics:', error);
                alert('Failed to refresh statistics. Please try again.');
            });
    }
</script>
