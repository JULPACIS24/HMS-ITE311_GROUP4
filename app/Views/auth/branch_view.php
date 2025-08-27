<?php echo view('auth/partials/header', ['title' => 'Branch Details']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header">
            <div>
                <h1><?php echo esc($branch['name']); ?></h1>
                <p style="color: #666; margin: 0;">Branch Details & Information</p>
            </div>
            <div>
                <a href="<?php echo site_url('branch-management'); ?>" class="btn secondary">← Back to Branches</a>
                <a href="<?php echo site_url('branch-management/edit/' . $branch['id']); ?>" class="btn primary">✏️ Edit Branch</a>
            </div>
        </header>
        
        <div class="page-content">
            <!-- Branch Overview Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Bed Capacity</span>
                        <div class="stat-icon">🛏️</div>
                    </div>
                    <div class="stat-value"><?php echo number_format($branch['bed_capacity']); ?></div>
                    <div class="stat-details">Total beds available</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Staff Count</span>
                        <div class="stat-icon">👥</div>
                    </div>
                    <div class="stat-value"><?php echo number_format($branch['total_staff']); ?></div>
                    <div class="stat-details">Total staff members</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Monthly Revenue</span>
                        <div class="stat-icon">💰</div>
                    </div>
                    <div class="stat-value">₱<?php echo number_format($branch['monthly_revenue'] / 1000, 0); ?>K</div>
                    <div class="stat-details">Current month</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Occupancy Rate</span>
                        <div class="stat-icon">📊</div>
                    </div>
                    <div class="stat-value"><?php echo number_format($branch['occupancy_rate'], 1); ?>%</div>
                    <div class="stat-details">Bed utilization</div>
                </div>
            </div>

            <!-- Branch Details -->
            <div class="details-container">
                <div class="detail-section">
                    <h3>Basic Information</h3>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>Branch Name</label>
                            <span><?php echo esc($branch['name']); ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Location</label>
                            <span><?php echo esc($branch['location']); ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Branch Type</label>
                            <span><?php echo esc($branch['type']); ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Status</label>
                            <span class="badge <?php echo strtolower(str_replace(' ', '-', $branch['status'])); ?>">
                                <?php echo esc($branch['status']); ?>
                            </span>
                        </div>
                        <div class="detail-item">
                            <label>Opening Hours</label>
                            <span><?php echo esc($branch['opening_hours']); ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Total Patients</label>
                            <span><?php echo number_format($branch['total_patients']); ?></span>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <h3>Management & Contact</h3>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>Branch Manager</label>
                            <span><?php echo esc($branch['manager_name'] ?? 'TBA'); ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Contact Number</label>
                            <span><?php echo esc($branch['contact_number'] ?? 'Not provided'); ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Email Address</label>
                            <span><?php echo esc($branch['email'] ?? 'Not provided'); ?></span>
                        </div>
                        <div class="detail-item full-width">
                            <label>Complete Address</label>
                            <span><?php echo esc($branch['address'] ?? 'Not provided'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="detail-section">
                    <h3>Departments</h3>
                    <div class="departments-list">
                        <?php 
                        $departments = json_decode($branch['departments'] ?? '[]', true);
                        if (!empty($departments)): 
                        ?>
                            <div class="department-tags">
                                <?php foreach ($departments as $dept): ?>
                                    <span class="department-tag"><?php echo esc(ucfirst($dept)); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p style="color: #666; font-style: italic;">No departments assigned yet.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="detail-section">
                    <h3>Timestamps</h3>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <label>Created</label>
                            <span><?php echo date('F j, Y g:i A', strtotime($branch['created_at'])); ?></span>
                        </div>
                        <div class="detail-item">
                            <label>Last Updated</label>
                            <span><?php echo date('F j, Y g:i A', strtotime($branch['updated_at'])); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-section">
                <div class="action-buttons">
                    <a href="<?php echo site_url('branch-management/edit/' . $branch['id']); ?>" class="btn primary">
                        ✏️ Edit Branch
                    </a>
                    <button onclick="deleteBranch(<?php echo $branch['id']; ?>)" class="btn danger">
                        🗑️ Delete Branch
                    </button>
                    <a href="<?php echo site_url('branch-management/update-statistics/' . $branch['id']); ?>" class="btn secondary">
                        🔄 Update Statistics
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
.details-container {
    max-width: 1000px;
    margin: 0 auto;
}

.detail-section {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.detail-section h3 {
    margin: 0 0 20px 0;
    color: #374151;
    font-size: 1.1em;
    border-bottom: 2px solid #f3f4f6;
    padding-bottom: 10px;
}

.detail-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.detail-item.full-width {
    grid-column: 1 / -1;
}

.detail-item label {
    font-weight: 600;
    color: #374151;
    font-size: 0.9em;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.detail-item span {
    color: #1f2937;
    font-size: 1em;
}

.departments-list {
    margin-top: 10px;
}

.department-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.department-tag {
    background: #dbeafe;
    color: #1e40af;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.9em;
    font-weight: 500;
}

.action-section {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}

.action-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
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

.btn.danger {
    background: #dc2626;
    color: white;
    border: 1px solid #dc2626;
}

.btn.danger:hover {
    background: #b91c1c;
}
</style>

<script>
function deleteBranch(id) {
    if (confirm('Are you sure you want to delete this branch? This action cannot be undone.')) {
        window.location.href = '<?php echo site_url('branch-management/delete/'); ?>' + id;
    }
}
</script>

<?php echo view('auth/partials/footer'); ?>
