<?php echo view('auth/partials/header', ['title' => 'Reports']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header"><h1>Reports</h1></header>
        <div class="page-content">
            <div class="stats-grid">
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Total Reports</span><div class="stat-icon">📊</div></div><div class="stat-value">156</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">This Month</span><div class="stat-icon">📅</div></div><div class="stat-value">24</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Scheduled</span><div class="stat-icon">⏱️</div></div><div class="stat-value">8</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Processing</span><div class="stat-icon">⚙️</div></div><div class="stat-value">3</div></div>
            </div>
            <div class="patients-table-container">
                <div class="table-header"><h2 class="table-title">Report Categories</h2></div>
                <div class="quick-actions" style="grid-template-columns:repeat(2,1fr)">
                    <a href="#" class="action-btn add-patient">Patient Reports</a>
                    <a href="#" class="action-btn schedule">Financial Reports</a>
                    <a href="#" class="action-btn reports">Appointment Reports</a>
                    <a href="#" class="action-btn settings">Inventory Reports</a>
                </div>
            </div>
        </div>
    </main>
</div>
<?php echo view('auth/partials/logout_confirm'); ?>
<?php echo view('auth/partials/footer'); ?>

