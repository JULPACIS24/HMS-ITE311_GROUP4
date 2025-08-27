<?php echo view('auth/partials/header', ['title' => $title]); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header">
            <h1><?= $title ?></h1>
            <?php echo view('auth/partials/userbadge'); ?>
        </header>
        <div class="page-content">
            <!-- Settings Header -->
            <div class="settings-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2 style="margin: 0 0 5px 0;"><?= $title ?></h2>
                        <p style="margin: 0; opacity: 0.8;">Configure system preferences and security settings</p>
                    </div>
                    <button class="btn primary" onclick="saveAllChanges()" style="background: white; color: #667eea; border: none;">
                        💾 Save All Changes
                    </button>
                </div>
            </div>

            <!-- Settings Tabs -->
            <div class="settings-tabs" style="background: white; border-radius: 10px; margin-bottom: 20px; overflow: hidden;">
                <div style="display: flex; border-bottom: 1px solid #e9ecef;">
                    <a href="<?= site_url('settings') ?>" 
                       style="padding: 15px 25px; text-decoration: none; color: <?= $activeTab === 'general' ? '#667eea' : '#6c757d' ?>; border-bottom: <?= $activeTab === 'general' ? '3px solid #667eea' : 'none' ?>; font-weight: 500;">
                        ⚙️ General Settings
                    </a>
                    <a href="<?= site_url('settings/security') ?>" 
                       style="padding: 15px 25px; text-decoration: none; color: <?= $activeTab === 'security' ? '#667eea' : '#6c757d' ?>; border-bottom: <?= $activeTab === 'security' ? '3px solid #667eea' : 'none' ?>; font-weight: 500;">
                        🛡️ Security
                    </a>
                    <a href="<?= site_url('settings/notifications') ?>" 
                       style="padding: 15px 25px; text-decoration: none; color: <?= $activeTab === 'notifications' ? '#667eea' : '#6c757d' ?>; border-bottom: <?= $activeTab === 'notifications' ? '3px solid #667eea' : 'none' ?>; font-weight: 500;">
                        🔔 Notifications
                    </a>
                    <a href="<?= site_url('settings/backup') ?>" 
                       style="padding: 15px 25px; text-decoration: none; color: <?= $activeTab === 'backup' ? '#667eea' : '#6c757d' ?>; border-bottom: <?= $activeTab === 'backup' ? '3px solid #667eea' : 'none' ?>; font-weight: 500;">
                        💾 Backup & Recovery
                    </a>
                    <a href="<?= site_url('settings/audit-logs') ?>" 
                       style="padding: 15px 25px; text-decoration: none; color: <?= $activeTab === 'audit' ? '#667eea' : '#6c757d' ?>; border-bottom: <?= $activeTab === 'audit' ? '3px solid #667eea' : 'none' ?>; font-weight: 500;">
                        📄 Audit Logs
                    </a>
                </div>
            </div>

            <!-- Settings Content -->
            <div class="settings-content" style="background: white; border-radius: 10px; padding: 30px;">
                            <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('success') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= session()->getFlashdata('error') ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <!-- General Settings Tab -->
                            <?php if ($activeTab === 'general'): ?>
                                <form action="<?= site_url('settings/save-general') ?>" method="post">
                                    <!-- Hospital Information -->
                                    <div class="form-section" style="margin-bottom: 30px;">
                                        <h5 style="color: #495057; margin-bottom: 20px; font-weight: 600;">🏥 Hospital Information</h5>
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                            <div>
                                                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Hospital Name</label>
                                                <input type="text" name="hospital_name" value="<?= $hospitalInfo['name'] ?>" required 
                                                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                                            </div>
                                            <div>
                                                <label style="display: block; margin-bottom: 5px; font-weight: 500;">License Number</label>
                                                <input type="text" name="license_number" value="<?= $hospitalInfo['license'] ?>" required 
                                                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                                            </div>
                                            <div>
                                                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Contact Number</label>
                                                <input type="text" name="contact_number" value="<?= $hospitalInfo['contact'] ?>" required 
                                                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                                            </div>
                                            <div>
                                                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Email Address</label>
                                                <input type="email" name="email_address" value="<?= $hospitalInfo['email'] ?>" required 
                                                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                                            </div>
                                            <div style="grid-column: 1 / -1;">
                                                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Address</label>
                                                <textarea name="address" rows="3" required 
                                                          style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"><?= $hospitalInfo['address'] ?></textarea>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn primary" style="margin-top: 20px;">
                                            💾 Update Information
                                        </button>
                                    </div>

                                    <!-- System Preferences -->
                                    <div class="form-section" style="margin-bottom: 30px;">
                                        <h5 style="color: #495057; margin-bottom: 20px; font-weight: 600;">⚙️ System Preferences</h5>
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; border: 1px solid #e9ecef; border-radius: 8px;">
                                                <div>
                                                    <h6 style="margin: 0 0 5px 0; font-weight: 600;">Auto-save Patient Records</h6>
                                                    <small style="color: #6c757d;">Automatically save changes to patient records</small>
                                                </div>
                                                <label style="position: relative; display: inline-block; width: 60px; height: 34px;">
                                                    <input type="checkbox" name="auto_save" <?= $systemPreferences['auto_save'] ? 'checked' : '' ?> style="opacity: 0; width: 0; height: 0;">
                                                    <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: <?= $systemPreferences['auto_save'] ? '#667eea' : '#ccc' ?>; transition: .4s; border-radius: 34px;">
                                                        <span style="position: absolute; content: ''; height: 26px; width: 26px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; transform: translateX(<?= $systemPreferences['auto_save'] ? '26px' : '0' ?>);"></span>
                                                    </span>
                                                </label>
                                            </div>
                                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; border: 1px solid #e9ecef; border-radius: 8px;">
                                                <div>
                                                    <h6 style="margin: 0 0 5px 0; font-weight: 600;">24-Hour Time Format</h6>
                                                    <small style="color: #6c757d;">Display time in 24-hour format</small>
                                                </div>
                                                <label style="position: relative; display: inline-block; width: 60px; height: 34px;">
                                                    <input type="checkbox" name="time_format" <?= $systemPreferences['time_format'] ? 'checked' : '' ?> style="opacity: 0; width: 0; height: 0;">
                                                    <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: <?= $systemPreferences['time_format'] ? '#667eea' : '#ccc' ?>; transition: .4s; border-radius: 34px;">
                                                        <span style="position: absolute; content: ''; height: 26px; width: 26px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; transform: translateX(<?= $systemPreferences['time_format'] ? '26px' : '0' ?>);"></span>
                                                    </span>
                                                </label>
                                            </div>
                                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; border: 1px solid #e9ecef; border-radius: 8px;">
                                                <div>
                                                    <h6 style="margin: 0 0 5px 0; font-weight: 600;">Email Notifications</h6>
                                                    <small style="color: #6c757d;">Send email notifications for important events</small>
                                                </div>
                                                <label style="position: relative; display: inline-block; width: 60px; height: 34px;">
                                                    <input type="checkbox" name="email_notifications" <?= $systemPreferences['email_notifications'] ? 'checked' : '' ?> style="opacity: 0; width: 0; height: 0;">
                                                    <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: <?= $systemPreferences['email_notifications'] ? '#667eea' : '#ccc' ?>; transition: .4s; border-radius: 34px;">
                                                        <span style="position: absolute; content: ''; height: 26px; width: 26px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; transform: translateX(<?= $systemPreferences['email_notifications'] ? '26px' : '0' ?>);"></span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>

                            <!-- Security Tab -->
                            <?php if ($activeTab === 'security'): ?>
                                <form action="<?= site_url('settings/save-security') ?>" method="post">
                                    <!-- Password Policy -->
                                    <div class="form-section">
                                        <h5><i class="fas fa-key me-2"></i>Password Policy</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Minimum Password Length</label>
                                                <select class="form-select" name="min_length">
                                                    <option value="6" <?= $passwordPolicy['min_length'] == 6 ? 'selected' : '' ?>>6 characters</option>
                                                    <option value="8" <?= $passwordPolicy['min_length'] == 8 ? 'selected' : '' ?>>8 characters</option>
                                                    <option value="10" <?= $passwordPolicy['min_length'] == 10 ? 'selected' : '' ?>>10 characters</option>
                                                    <option value="12" <?= $passwordPolicy['min_length'] == 12 ? 'selected' : '' ?>>12 characters</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="require_uppercase" 
                                                           <?= $passwordPolicy['require_uppercase'] ? 'checked' : '' ?>>
                                                    <label class="form-check-label">Require uppercase letters</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="require_numbers" 
                                                           <?= $passwordPolicy['require_numbers'] ? 'checked' : '' ?>>
                                                    <label class="form-check-label">Require numbers</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="require_special" 
                                                           <?= $passwordPolicy['require_special'] ? 'checked' : '' ?>>
                                                    <label class="form-check-label">Require special characters</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Session Management -->
                                    <div class="form-section">
                                        <h5><i class="fas fa-clock me-2"></i>Session Management</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Session Timeout (minutes)</label>
                                                <input type="number" class="form-control" name="session_timeout" 
                                                       value="<?= $sessionManagement['timeout'] ?>" min="5" max="480">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Max Failed Login Attempts</label>
                                                <input type="number" class="form-control" name="max_attempts" 
                                                       value="<?= $sessionManagement['max_attempts'] ?>" min="1" max="10">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Two-Factor Authentication -->
                                    <div class="form-section">
                                        <h5><i class="fas fa-mobile-alt me-2"></i>Two-Factor Authentication</h5>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">Require 2FA for all users</h6>
                                                <small class="text-muted">Enhanced security with two-factor authentication</small>
                                            </div>
                                            <label class="toggle-switch">
                                                <input type="checkbox" name="require_2fa" <?= $twoFactorAuth['enabled'] ? 'checked' : '' ?>>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Save Security Settings
                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- Notifications Tab -->
                            <?php if ($activeTab === 'notifications'): ?>
                                <form action="<?= site_url('settings/save-notifications') ?>" method="post">
                                    <div class="form-section">
                                        <h5><i class="fas fa-bell me-2"></i>Notification Settings</h5>
                                        <p class="text-muted mb-4">Configure notification preferences and alert settings.</p>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1">Email Alerts</h6>
                                                        <small class="text-muted">Receive notifications via email</small>
                                                    </div>
                                                    <label class="toggle-switch">
                                                        <input type="checkbox" name="email_alerts" <?= $notificationSettings['email_alerts'] ? 'checked' : '' ?>>
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1">SMS Notifications</h6>
                                                        <small class="text-muted">Receive notifications via SMS</small>
                                                    </div>
                                                    <label class="toggle-switch">
                                                        <input type="checkbox" name="sms_notifications" <?= $notificationSettings['sms_notifications'] ? 'checked' : '' ?>>
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1">App Notifications</h6>
                                                        <small class="text-muted">Receive in-app notifications</small>
                                                    </div>
                                                    <label class="toggle-switch">
                                                        <input type="checkbox" name="app_notifications" <?= $notificationSettings['app_notifications'] ? 'checked' : '' ?>>
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1">Patient Reminders</h6>
                                                        <small class="text-muted">Send appointment reminders to patients</small>
                                                    </div>
                                                    <label class="toggle-switch">
                                                        <input type="checkbox" name="patient_reminders" <?= $notificationSettings['patient_reminders'] ? 'checked' : '' ?>>
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1">Staff Alerts</h6>
                                                        <small class="text-muted">Notify staff of important events</small>
                                                    </div>
                                                    <label class="toggle-switch">
                                                        <input type="checkbox" name="staff_alerts" <?= $notificationSettings['staff_alerts'] ? 'checked' : '' ?>>
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1">System Alerts</h6>
                                                        <small class="text-muted">Receive system maintenance alerts</small>
                                                    </div>
                                                    <label class="toggle-switch">
                                                        <input type="checkbox" name="system_alerts" <?= $notificationSettings['system_alerts'] ? 'checked' : '' ?>>
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Save Notification Settings
                                        </button>
                                    </div>
                                </form>
                            <?php endif; ?>

                            <!-- Backup & Recovery Tab -->
                            <?php if ($activeTab === 'backup'): ?>
                                <form action="<?= site_url('settings/save-backup') ?>" method="post">
                                    <div class="form-section">
                                        <h5><i class="fas fa-database me-2"></i>Backup & Recovery</h5>
                                        <p class="text-muted mb-4">Manage system backups and recovery procedures.</p>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1">Automatic Backups</h6>
                                                        <small class="text-muted">Enable automatic system backups</small>
                                                    </div>
                                                    <label class="toggle-switch">
                                                        <input type="checkbox" name="auto_backup" <?= $backupSettings['auto_backup'] ? 'checked' : '' ?>>
                                                        <span class="slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Backup Frequency</label>
                                                <select class="form-select" name="backup_frequency">
                                                    <option value="daily" <?= $backupSettings['backup_frequency'] === 'daily' ? 'selected' : '' ?>>Daily</option>
                                                    <option value="weekly" <?= $backupSettings['backup_frequency'] === 'weekly' ? 'selected' : '' ?>>Weekly</option>
                                                    <option value="monthly" <?= $backupSettings['backup_frequency'] === 'monthly' ? 'selected' : '' ?>>Monthly</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Retention Period (days)</label>
                                                <input type="number" class="form-control" name="retention_days" 
                                                       value="<?= $backupSettings['retention_days'] ?>" min="7" max="365">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Backup Location</label>
                                                <input type="text" class="form-control" name="backup_location" 
                                                       value="<?= $backupSettings['backup_location'] ?>">
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Save Backup Settings
                                        </button>
                                    </div>

                                    <!-- Recent Backups -->
                                    <div class="form-section">
                                        <h5><i class="fas fa-history me-2"></i>Recent Backups</h5>
                                        <?php foreach ($recentBackups as $backup): ?>
                                            <div class="backup-item completed">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1"><?= $backup['type'] ?></h6>
                                                        <small class="text-muted"><?= $backup['date'] ?> • <?= $backup['size'] ?></small>
                                                    </div>
                                                    <span class="status-badge status-success"><?= $backup['status'] ?></span>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </form>
                            <?php endif; ?>

                            <!-- Audit Logs Tab -->
                            <?php if ($activeTab === 'audit'): ?>
                                <div class="form-section" style="margin-bottom: 30px;">
                                    <h5 style="color: #495057; margin-bottom: 20px; font-weight: 600;">📄 System Activity Logs</h5>
                                    
                                    <!-- Filter Section -->
                                    <div style="background: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; border: 1px solid #e9ecef;">
                                        <div style="display: flex; justify-content: space-between; align-items: center;">
                                            <div style="flex: 1; margin-right: 20px;">
                                                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Filter by Date</label>
                                                <input type="date" id="filterDate" value="<?= $filterDate ?>" onchange="filterLogs()" 
                                                       style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                                            </div>
                                            <div>
                                                <a href="<?= site_url('settings/export-logs') ?>?date=<?= $filterDate ?>" 
                                                   class="btn primary" style="background: #667eea; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px;">
                                                    📥 Export Logs
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Audit Logs Table -->
                                    <div style="background: white; border-radius: 8px; overflow: hidden; border: 1px solid #e9ecef;">
                                        <table class="patients-table" style="width: 100%; border-collapse: collapse;">
                                            <thead>
                                                <tr style="background: #f8f9fa;">
                                                    <th style="padding: 15px; text-align: left; font-weight: 600; color: #495057; border-bottom: 1px solid #e9ecef;">TIMESTAMP</th>
                                                    <th style="padding: 15px; text-align: left; font-weight: 600; color: #495057; border-bottom: 1px solid #e9ecef;">ACTION</th>
                                                    <th style="padding: 15px; text-align: left; font-weight: 600; color: #495057; border-bottom: 1px solid #e9ecef;">USER</th>
                                                    <th style="padding: 15px; text-align: left; font-weight: 600; color: #495057; border-bottom: 1px solid #e9ecef;">IP ADDRESS</th>
                                                    <th style="padding: 15px; text-align: left; font-weight: 600; color: #495057; border-bottom: 1px solid #e9ecef;">STATUS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($auditLogs as $log): ?>
                                                    <tr style="border-bottom: 1px solid #e9ecef;">
                                                        <td style="padding: 12px 15px;"><?= $log['timestamp'] ?></td>
                                                        <td style="padding: 12px 15px;"><?= $log['action'] ?></td>
                                                        <td style="padding: 12px 15px;"><?= $log['user'] ?></td>
                                                        <td style="padding: 12px 15px;"><?= $log['ip_address'] ?></td>
                                                        <td style="padding: 12px 15px;">
                                                            <span style="padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; background: <?= $log['status'] === 'Success' ? '#d4edda' : '#f8d7da' ?>; color: <?= $log['status'] === 'Success' ? '#155724' : '#721c24' ?>;">
                                                                <?= $log['status'] ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<script>
    function saveAllChanges() {
        // Get all forms and submit them
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            if (form.style.display !== 'none') {
                form.submit();
            }
        });
    }

    function filterLogs() {
        const date = document.getElementById('filterDate').value;
        window.location.href = '<?= site_url('settings/audit-logs') ?>?date=' + date;
    }
</script>

