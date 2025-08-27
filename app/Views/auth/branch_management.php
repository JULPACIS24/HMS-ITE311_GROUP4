<?php echo view('auth/partials/header', ['title' => 'Branch Management']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header">
            <div>
                <h1>Branch Management</h1>
                <p style="color: #666; margin: 0;">Manage hospital branches and clinic locations.</p>
            </div>
            <div>
                <button class="btn primary" id="addBranchBtn">+ Add Branch</button>
            </div>
        </header>
        
        <div class="page-content">
            <?php if (!empty($message)): ?>
                <div class="alert success"><?php echo esc($message); ?></div>
            <?php endif; ?>
            
            <?php if (!empty($errors)): ?>
                <div class="alert danger">
                    <?php if (is_array($errors)): ?>
                        <?php foreach ($errors as $err): ?>
                            <div><?php echo esc($err); ?></div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div><?php echo esc($errors); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Summary Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Total Branches</span>
                        <div class="stat-icon">🏢</div>
                    </div>
                    <div class="stat-value"><?= $statistics['total_branches'] ?? 0 ?></div>
                    <div class="stat-details"><?= ($statistics['operational'] ?? 0) ?> operational, <?= ($statistics['under_construction'] ?? 0) ?> upcoming</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Total Beds</span>
                        <div class="stat-icon">🛏️</div>
                    </div>
                    <div class="stat-value"><?= number_format($statistics['total_beds'] ?? 0) ?></div>
                    <div class="stat-details"><?= number_format($statistics['occupancy_rate'] ?? 0, 1) ?>% occupancy rate</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Combined Revenue</span>
                        <div class="stat-icon">💰</div>
                    </div>
                    <div class="stat-value">₱<?= number_format(($statistics['total_revenue'] ?? 0) / 1000000, 2) ?>M</div>
                    <div class="stat-details">Monthly total</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Total Staff</span>
                        <div class="stat-icon">👥</div>
                    </div>
                    <div class="stat-value"><?= number_format($statistics['total_staff'] ?? 0) ?></div>
                    <div class="stat-details">Across all branches</div>
                </div>
            </div>

            <!-- Branch Overview Table -->
            <div class="patients-table-container">
                <div class="table-header">
                    <h2 class="table-title">Branch Overview</h2>
                    <div class="table-actions">
                        <input type="text" id="searchBranch" placeholder="Search branches..." style="margin-right: 10px; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                        <select id="statusFilter" style="margin-right: 10px; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                            <option value="">All Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Under Construction">Under Construction</option>
                            <option value="Maintenance">Maintenance</option>
                        </select>
                        <button onclick="refreshBranchData()" class="btn secondary">🔄 Refresh</button>
                    </div>
                </div>
                
                <table class="patients-table">
                    <thead>
                        <tr>
                            <th>BRANCH</th>
                            <th>TYPE</th>
                            <th>CAPACITY</th>
                            <th>STAFF</th>
                            <th>PATIENTS</th>
                            <th>REVENUE</th>
                            <th>STATUS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($branches)): ?>
                            <?php foreach ($branches as $branch): ?>
                                <tr>
                                    <td>
                                        <div>
                                            <strong><?php echo esc($branch['name']); ?></strong>
                                            <div style="color: #666; font-size: 0.9em;"><?php echo esc($branch['location']); ?></div>
                                            <div style="color: #666; font-size: 0.9em;">Manager: <?php echo esc($branch['manager_name'] ?? 'TBA'); ?></div>
                                        </div>
                                    </td>
                                    <td><?php echo esc($branch['type']); ?></td>
                                    <td><?php echo number_format($branch['bed_capacity']); ?> beds</td>
                                    <td><?php echo number_format($branch['total_staff']); ?> staff</td>
                                    <td><?php echo number_format($branch['total_patients']); ?></td>
                                    <td>₱<?php echo number_format($branch['monthly_revenue'] / 1000, 0); ?>K</td>
                                    <td>
                                        <span class="badge <?php echo strtolower(str_replace(' ', '-', $branch['status'])); ?>">
                                            <?php echo esc($branch['status']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button onclick="viewBranch(<?php echo $branch['id']; ?>)" class="btn-icon" title="View">
                                                👁️
                                            </button>
                                            <button onclick="editBranch(<?php echo $branch['id']; ?>)" class="btn-icon" title="Edit">
                                                ✏️
                                            </button>
                                            <button onclick="deleteBranch(<?php echo $branch['id']; ?>)" class="btn-icon" title="Delete">
                                                🗑️
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px;">
                                    <div style="color: #666;">
                                        <div style="font-size: 3em; margin-bottom: 10px;">🏢</div>
                                        <div>No branches found</div>
                                        <div style="margin-top: 10px;">
                                            <button onclick="showAddBranchModal()" class="btn primary">Add Your First Branch</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Department Coverage Section -->
            <div class="patients-table-container" style="margin-top: 30px;">
                <div class="table-header">
                    <h2 class="table-title">Department Coverage Across Branches</h2>
                </div>
                
                <div class="department-grid">
                    <?php foreach ($departmentCoverage as $deptName => $deptData): ?>
                        <div class="department-card">
                            <div class="department-header">
                                <h3><?php echo esc($deptName); ?></h3>
                            </div>
                            <div class="department-locations">
                                <?php foreach ($deptData['branches'] as $branch): ?>
                                    <div class="location-item">
                                        <span class="location-icon">📍</span>
                                        <span><?php echo esc($branch); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="department-hours">
                                <span class="hours-badge"><?php echo esc($deptData['hours']); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Add Branch Modal -->
<div class="modal" id="addBranchModal" style="display:none">
    <div class="modal-content" style="max-width:600px">
        <div class="modal-header">
            <h3>Add New Branch</h3>
            <button class="close" id="closeAddBranch">×</button>
        </div>
        <form method="post" action="<?php echo site_url('branch-management/create'); ?>" class="form-grid">
            <div class="form-group">
                <label>Branch Name</label>
                <input type="text" name="name" required placeholder="San Miguel Hospital - Branch Name" value="<?php echo old('name'); ?>">
            </div>
            
            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" required placeholder="City, Province" value="<?php echo old('location'); ?>">
            </div>
            
            <div class="form-group">
                <label>Branch Type</label>
                <select name="type" required>
                    <option value="">Select Type</option>
                    <option value="Main Hospital" <?php echo old('type') == 'Main Hospital' ? 'selected' : ''; ?>>Main Hospital</option>
                    <option value="Branch Hospital" <?php echo old('type') == 'Branch Hospital' ? 'selected' : ''; ?>>Branch Hospital</option>
                    <option value="Emergency Center" <?php echo old('type') == 'Emergency Center' ? 'selected' : ''; ?>>Emergency Center</option>
                    <option value="Outpatient Clinic" <?php echo old('type') == 'Outpatient Clinic' ? 'selected' : ''; ?>>Outpatient Clinic</option>
                    <option value="Specialty Center" <?php echo old('type') == 'Specialty Center' ? 'selected' : ''; ?>>Specialty Center</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Bed Capacity</label>
                <input type="number" name="bed_capacity" required min="0" placeholder="0" value="<?php echo old('bed_capacity'); ?>">
            </div>
            
            <div class="form-group">
                <label>Branch Manager</label>
                <input type="text" name="manager_name" placeholder="Dr. Name" value="<?php echo old('manager_name'); ?>">
            </div>
            
            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="contact_number" placeholder="Phone number" value="<?php echo old('contact_number'); ?>">
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="branch@hospital.com" value="<?php echo old('email'); ?>">
            </div>
            
            <div class="form-group">
                <label>Address</label>
                <textarea name="address" placeholder="Complete address" rows="3"><?php echo old('address'); ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="Active" <?php echo old('status') == 'Active' ? 'selected' : ''; ?>>Active</option>
                    <option value="Inactive" <?php echo old('status') == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                    <option value="Under Construction" <?php echo old('status') == 'Under Construction' ? 'selected' : ''; ?>>Under Construction</option>
                    <option value="Maintenance" <?php echo old('status') == 'Maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Opening Hours</label>
                <input type="text" name="opening_hours" placeholder="24/7" value="<?php echo old('opening_hours', '24/7'); ?>">
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn secondary" onclick="closeAddBranchModal()">Cancel</button>
                <button type="submit" class="btn primary">Add Branch</button>
            </div>
        </form>
    </div>
</div>

<style>
.department-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.department-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.department-header h3 {
    margin: 0 0 15px 0;
    color: #374151;
    font-size: 1.1em;
}

.department-locations {
    margin-bottom: 15px;
}

.location-item {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    color: #6b7280;
}

.location-icon {
    margin-right: 8px;
    font-size: 0.9em;
}

.department-hours {
    text-align: right;
}

.hours-badge {
    background: #dbeafe;
    color: #1e40af;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8em;
    font-weight: 500;
}

.action-buttons {
    display: flex;
    gap: 5px;
}

.btn-icon {
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
    border-radius: 4px;
    font-size: 1.1em;
    transition: background-color 0.2s;
}

.btn-icon:hover {
    background-color: #f3f4f6;
}

.table-actions {
    display: flex;
    align-items: center;
}

.stat-details {
    font-size: 0.8em;
    color: #6b7280;
    margin-top: 5px;
}

.badge.active {
    background: #dcfce7;
    color: #166534;
}

.badge.inactive {
    background: #fef2f2;
    color: #dc2626;
}

.badge.under-construction {
    background: #fef3c7;
    color: #d97706;
}

.badge.maintenance {
    background: #f3e8ff;
    color: #7c3aed;
}
</style>

<script>
// Modal functionality
document.getElementById('addBranchBtn').addEventListener('click', showAddBranchModal);
document.getElementById('closeAddBranch').addEventListener('click', closeAddBranchModal);

function showAddBranchModal() {
    document.getElementById('addBranchModal').style.display = 'flex';
}

function closeAddBranchModal() {
    document.getElementById('addBranchModal').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('addBranchModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddBranchModal();
    }
});

// Branch actions
function viewBranch(id) {
    window.location.href = '<?php echo site_url('branch-management/view/'); ?>' + id;
}

function editBranch(id) {
    window.location.href = '<?php echo site_url('branch-management/edit/'); ?>' + id;
}

function deleteBranch(id) {
    if (confirm('Are you sure you want to delete this branch? This action cannot be undone.')) {
        window.location.href = '<?php echo site_url('branch-management/delete/'); ?>' + id;
    }
}

// Search and filter functionality
document.getElementById('searchBranch').addEventListener('input', function() {
    filterBranches();
});

document.getElementById('statusFilter').addEventListener('change', function() {
    filterBranches();
});

function filterBranches() {
    const searchTerm = document.getElementById('searchBranch').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('.patients-table tbody tr');
    
    rows.forEach(row => {
        const branchName = row.cells[0].textContent.toLowerCase();
        const status = row.cells[6].textContent.trim();
        
        const matchesSearch = branchName.includes(searchTerm);
        const matchesStatus = !statusFilter || status === statusFilter;
        
        row.style.display = matchesSearch && matchesStatus ? '' : 'none';
    });
}

function refreshBranchData() {
    location.reload();
}
</script>

<?php echo view('auth/partials/footer'); ?>
