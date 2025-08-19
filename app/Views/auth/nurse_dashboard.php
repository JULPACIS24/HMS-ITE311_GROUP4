<?php echo view('auth/partials/header', ['title' => 'Nurse Dashboard']); ?>
<div class="container">
    <?php echo view('auth/partials/nurse_sidebar'); ?>
    <main class="main-content">
        <header class="header"><h1>Dashboard</h1><div class="user-info"><div class="user-avatar">N</div><span>Nurse</span></div></header>
        <div class="page-content">
            <div class="stats-grid">
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Patients Under Care</span><div class="stat-icon">👥</div></div><div class="stat-value">12</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Medications Due</span><div class="stat-icon">💊</div></div><div class="stat-value">8</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Vitals Pending</span><div class="stat-icon">📈</div></div><div class="stat-value">5</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Critical Alerts</span><div class="stat-icon">⚠️</div></div><div class="stat-value">2</div></div>
            </div>

            <div class="content-grid" style="grid-template-columns:1.4fr 1fr;gap:24px">
                <div class="card">
                    <div class="card-header">Pending Tasks</div>
                    <div class="card-content">
                        <div class="task-item"><div><div class="patient">Administer morning medications</div><div class="sub">Assigned to: Ward A - Room 205</div></div><div class="priority-badge" style="background:#fee;color:#e74c3c">high</div></div>
                        <div class="task-item"><div><div class="patient">Check vital signs</div><div class="sub">Assigned to: Ward B - Room 312</div></div><div class="priority-badge" style="background:#fff9e6;color:#f39c12">medium</div></div>
                        <div class="task-item"><div><div class="patient">Patient discharge preparation</div><div class="sub">Assigned to: Ward A - Room 101</div></div><div class="priority-badge" style="background:#e8f5e8;color:#27ae60">low</div></div>
                        <div class="task-item"><div><div class="patient">Wound dressing change</div><div class="sub">Assigned to: Ward C - Room 407</div></div><div class="priority-badge" style="background:#fee;color:#e74c3c">high</div></div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Quick Actions</div>
                    <div class="card-content">
                        <div class="quick-actions">
                            <a href="#" class="action-btn add-patient"><span class="action-icon">➕</span>Add Patient</a>
                            <a href="#" class="action-btn schedule"><span class="action-icon">💓</span>Record Vitals</a>
                            <a href="#" class="action-btn reports"><span class="action-icon">📊</span>View Reports</a>
                            <a href="#" class="action-btn settings"><span class="action-icon">⚙️</span>Settings</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top:24px">
                <div class="card-header">Today's Schedule</div>
                <div class="card-content">
                    <div class="task-item"><div>Morning Rounds</div><div class="sub">6:00 AM - 8:00 AM</div></div>
                    <div class="task-item"><div>Medication Administration</div><div class="sub">8:00 AM - 10:00 AM</div></div>
                    <div class="task-item"><div>Patient Documentation</div><div class="sub">2:00 PM - 4:00 PM</div></div>
                </div>
            </div>
        </div>
    </main>
</div>
<?php echo view('auth/partials/logout_confirm'); ?>
<?php echo view('auth/partials/footer'); ?>


