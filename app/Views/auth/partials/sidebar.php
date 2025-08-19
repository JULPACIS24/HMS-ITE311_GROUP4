<nav class="sidebar">
    <div class="sidebar-header">
        <?php $role = session('role') ?? 'admin'; ?>
        <div class="admin-icon"><?php echo $role === 'it_staff' ? 'IT' : 'A'; ?></div>
        <span class="sidebar-title"><?php echo $role === 'it_staff' ? 'IT Administrator' : 'Administrator'; ?></span>
    </div>
    <div class="sidebar-menu">
        <?php $role = session('role') ?? 'admin'; ?>
        <?php if ($role === 'it_staff'): ?>
            <a href="<?= site_url('it') ?>" class="menu-item"><span class="menu-icon">🖥️</span>IT Dashboard</a>
            <a href="<?= site_url('it/monitoring') ?>" class="menu-item"><span class="menu-icon">📡</span>System Monitoring</a>
            <a href="<?= site_url('it/security') ?>" class="menu-item"><span class="menu-icon">🔐</span>Security & Access</a>
            <a href="<?= site_url('it/backup') ?>" class="menu-item"><span class="menu-icon">💾</span>Backup & Recovery</a>
            <a href="<?= site_url('it/maintenance') ?>" class="menu-item"><span class="menu-icon">🛠️</span>Maintenance</a>
            <a href="<?= site_url('users') ?>" class="menu-item"><span class="menu-icon">👤</span>User Management</a>
            <a href="<?= site_url('it/logs') ?>" class="menu-item"><span class="menu-icon">📜</span>System Logs</a>
            <a href="<?= site_url('reports') ?>" class="menu-item"><span class="menu-icon">📈</span>IT Reports</a>
            <a href="<?= site_url('settings') ?>" class="menu-item"><span class="menu-icon">⚙️</span>Settings</a>
        <?php else: ?>
            <a href="<?= site_url('dashboard') ?>" class="menu-item"><span class="menu-icon">📊</span>Dashboard</a>
            <a href="<?= site_url('patients') ?>" class="menu-item"><span class="menu-icon">👥</span>Patients</a>
            <a href="<?= site_url('appointments') ?>" class="menu-item"><span class="menu-icon">📅</span>Appointments</a>
            <a href="<?= site_url('billing') ?>" class="menu-item"><span class="menu-icon">💳</span>Billing & Payments</a>
            <a href="<?= site_url('laboratory') ?>" class="menu-item"><span class="menu-icon">🧪</span>Laboratory</a>
            <a href="<?= site_url('pharmacy') ?>" class="menu-item"><span class="menu-icon">💊</span>Pharmacy & Inventory</a>
            <a href="<?= site_url('reports') ?>" class="menu-item"><span class="menu-icon">📈</span>Reports</a>
            <a href="<?= site_url('users') ?>" class="menu-item"><span class="menu-icon">👤</span>User Management</a>
            <a href="<?= site_url('settings') ?>" class="menu-item"><span class="menu-icon">⚙️</span>Settings</a>
        <?php endif; ?>
        <a href="#" class="menu-item" id="logoutLink"><span class="menu-icon">🚪</span>Logout</a>
    </div>
</nav>

