<?php echo view('auth/partials/header', ['title' => 'IT Dashboard', 'extraCss' => ['assets/css/it-dashboard.css']]); ?>
<div class="container itd">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header"><h1>IT Dashboard</h1><?php echo view('auth/partials/userbadge'); ?></header>
        <div class="page-content">
            <div class="stats-grid">
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Server Uptime</span><div class="stat-icon">🖥️</div></div><div class="stat-value">99.9%</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Active Users</span><div class="stat-icon">👥</div></div><div class="stat-value">147</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">System Alerts</span><div class="stat-icon">⚠️</div></div><div class="stat-value">3</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Database Size</span><div class="stat-icon">🗄️</div></div><div class="stat-value">2.4TB</div></div>
            </div>

            <div class="dashboard-grid">
            <div class="card activities">
                <div class="card-header">Recent System Activities</div>
                <div class="card-content">
                    <div class="task-item"><div class="task-info"><h4>System backup completed</h4><div class="task-meta">Assigned to: System Scheduler</div><div class="task-status">2 minutes ago</div></div><div class="task-actions"><span class="priority-badge priority-low">low</span><button class="review-btn">View</button></div></div>
                    <div class="task-item"><div class="task-info"><h4>User password reset request</h4><div class="task-meta">Assigned to: Dr. Maria Santos</div><div class="task-status">15 minutes ago</div></div><div class="task-actions"><span class="priority-badge priority-medium">medium</span><button class="review-btn">Review</button></div></div>
                    <div class="task-item"><div class="task-info"><h4>Security scan initiated</h4><div class="task-meta">Assigned to: IT Administrator</div><div class="task-status">1 hour ago</div></div><div class="task-actions"><span class="priority-badge priority-high">high</span><button class="review-btn">View</button></div></div>
                    <div class="task-item"><div class="task-info"><h4>Database optimization completed</h4><div class="task-meta">Assigned to: System Maintenance</div><div class="task-status">2 hours ago</div></div><div class="task-actions"><span class="priority-badge priority-medium">medium</span><button class="review-btn">View</button></div></div>
                    <div class="task-item"><div class="task-info"><h4>New user account created</h4><div class="task-meta">Assigned to: HR Department</div><div class="task-status">3 hours ago</div></div><div class="task-actions"><span class="priority-badge priority-low">low</span><button class="review-btn">View</button></div></div>
                </div>
            </div>

                <div class="card">
                    <div class="card-header">System Health</div>
                    <div class="card-content">
                        <div style="margin-bottom:16px">
                            <div style="display:flex;justify-content:space-between;margin-bottom:8px"><span>CPU Usage</span><span>23%</span></div>
                            <div style="background:#e1e6ec;height:8px;border-radius:4px"><div style="background:#27ae60;height:8px;width:23%;border-radius:4px"></div></div>
                        </div>
                        <div style="margin-bottom:16px">
                            <div style="display:flex;justify-content:space-between;margin-bottom:8px"><span>Memory Usage</span><span>67%</span></div>
                            <div style="background:#e1e6ec;height:8px;border-radius:4px"><div style="background:#f39c12;height:8px;width:67%;border-radius:4px"></div></div>
                        </div>
                        <div>
                            <div style="display:flex;justify-content:space-between;margin-bottom:8px"><span>Disk Usage</span><span>45%</span></div>
                            <div style="background:#e1e6ec;height:8px;border-radius:4px"><div style="background:#3498db;height:8px;width:45%;border-radius:4px"></div></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Network Status</div>
                    <div class="card-content">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                            <div><div style="font-weight:600">Main Server</div><div style="font-size:12px;color:#7f8c8d">192.168.1.100</div></div>
                            <span style="background:#e8f5e9;color:#27ae60;padding:4px 8px;border-radius:12px;font-size:11px;font-weight:600">Online</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                            <div><div style="font-weight:600">Database Server</div><div style="font-size:12px;color:#7f8c8d">192.168.1.101</div></div>
                            <span style="background:#e8f5e9;color:#27ae60;padding:4px 8px;border-radius:12px;font-size:11px;font-weight:600">Online</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
                            <div><div style="font-weight:600">Backup Server</div><div style="font-size:12px;color:#7f8c8d">192.168.1.102</div></div>
                            <span style="background:#fff8e1;color:#f39c12;padding:4px 8px;border-radius:12px;font-size:11px;font-weight:600">Maintenance</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;align-items:center">
                            <div><div style="font-weight:600">Clinic Network</div><div style="font-size:12px;color:#7f8c8d">VPN Connection</div></div>
                            <span style="background:#e8f5e9;color:#27ae60;padding:4px 8px;border-radius:12px;font-size:11px;font-weight:600">Connected</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Security Alerts</div>
                    <div class="card-content">
                        <?php if (!empty($securityLogs)): ?>
                            <?php foreach ($securityLogs as $log): ?>
                                <?php 
                                    $role = ucwords(str_replace('_', ' ', (string)($log['role'] ?? 'unknown')));
                                    $userName = esc($log['user_name'] ?? 'Unknown');
                                    $when = esc(date('M j, g:i a', strtotime((string)($log['created_at'] ?? 'now'))));
                                    $isLogout = ($log['event'] ?? '') === 'logout';
                                    $action = $isLogout ? 'Logout' : 'Login';
                                    $barColor = $isLogout ? '#e74c3c' : '#3498db';
                                ?>
                                <div style="border-left:3px solid <?php echo $barColor; ?>;padding-left:12px;margin-bottom:12px">
                                    <div style="font-weight:600;color:#2c3e50"><?php echo $action; ?> by <?php echo $userName; ?> (<?php echo $role; ?>)</div>
                                    <div style="font-size:12px;color:#7f8c8d">
                                        <?php echo esc($log['ip_address'] ?? ''); ?> • <?php echo $when; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="sub">No recent security events.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<?php echo view('auth/partials/logout_confirm'); ?>
<?php echo view('auth/partials/footer'); ?>


