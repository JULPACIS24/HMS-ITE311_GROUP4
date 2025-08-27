<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BranchModel;

class Settings extends BaseController
{
    protected $userModel;
    protected $branchModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->branchModel = new BranchModel();
    }

    public function index()
    {
        $data = [
            'title' => 'System Settings',
            'activeTab' => 'general',
            'hospitalInfo' => $this->getHospitalInfo(),
            'systemPreferences' => $this->getSystemPreferences()
        ];

        return view('auth/settings', $data);
    }

    public function security()
    {
        $data = [
            'title' => 'System Settings',
            'activeTab' => 'security',
            'passwordPolicy' => $this->getPasswordPolicy(),
            'sessionManagement' => $this->getSessionManagement(),
            'twoFactorAuth' => $this->getTwoFactorAuth()
        ];

        return view('auth/settings', $data);
    }

    public function notifications()
    {
        $data = [
            'title' => 'System Settings',
            'activeTab' => 'notifications',
            'notificationSettings' => $this->getNotificationSettings()
        ];

        return view('auth/settings', $data);
    }

    public function backup()
    {
        $data = [
            'title' => 'System Settings',
            'activeTab' => 'backup',
            'backupSettings' => $this->getBackupSettings(),
            'recentBackups' => $this->getRecentBackups()
        ];

        return view('auth/settings', $data);
    }

    public function auditLogs()
    {
        $data = [
            'title' => 'System Settings',
            'activeTab' => 'audit',
            'auditLogs' => $this->getAuditLogs(),
            'filterDate' => $this->request->getGet('date') ?? date('Y-m-d')
        ];

        return view('auth/settings', $data);
    }

    public function saveGeneral()
    {
        // Handle saving general settings
        $hospitalInfo = [
            'name' => $this->request->getPost('hospital_name'),
            'license' => $this->request->getPost('license_number'),
            'contact' => $this->request->getPost('contact_number'),
            'email' => $this->request->getPost('email_address'),
            'address' => $this->request->getPost('address')
        ];

        $systemPrefs = [
            'auto_save' => $this->request->getPost('auto_save') ? 1 : 0,
            'time_format' => $this->request->getPost('time_format') ? 1 : 0,
            'email_notifications' => $this->request->getPost('email_notifications') ? 1 : 0
        ];

        // Save to session for now (in real app, save to database)
        session()->set('hospital_info', $hospitalInfo);
        session()->set('system_preferences', $systemPrefs);

        return redirect()->to('settings')->with('success', 'General settings updated successfully!');
    }

    public function saveSecurity()
    {
        // Handle saving security settings
        $passwordPolicy = [
            'min_length' => $this->request->getPost('min_length'),
            'require_uppercase' => $this->request->getPost('require_uppercase') ? 1 : 0,
            'require_numbers' => $this->request->getPost('require_numbers') ? 1 : 0,
            'require_special' => $this->request->getPost('require_special') ? 1 : 0
        ];

        $sessionManagement = [
            'timeout' => $this->request->getPost('session_timeout'),
            'max_attempts' => $this->request->getPost('max_attempts')
        ];

        $twoFactorAuth = [
            'enabled' => $this->request->getPost('require_2fa') ? 1 : 0
        ];

        // Save to session for now
        session()->set('password_policy', $passwordPolicy);
        session()->set('session_management', $sessionManagement);
        session()->set('two_factor_auth', $twoFactorAuth);

        return redirect()->to('settings/security')->with('success', 'Security settings updated successfully!');
    }

    public function saveNotifications()
    {
        // Handle saving notification settings
        $notificationSettings = [
            'email_alerts' => $this->request->getPost('email_alerts') ? 1 : 0,
            'sms_notifications' => $this->request->getPost('sms_notifications') ? 1 : 0,
            'app_notifications' => $this->request->getPost('app_notifications') ? 1 : 0,
            'patient_reminders' => $this->request->getPost('patient_reminders') ? 1 : 0,
            'staff_alerts' => $this->request->getPost('staff_alerts') ? 1 : 0,
            'system_alerts' => $this->request->getPost('system_alerts') ? 1 : 0
        ];

        session()->set('notification_settings', $notificationSettings);

        return redirect()->to('settings/notifications')->with('success', 'Notification settings updated successfully!');
    }

    public function saveBackup()
    {
        // Handle saving backup settings
        $backupSettings = [
            'auto_backup' => $this->request->getPost('auto_backup') ? 1 : 0,
            'backup_frequency' => $this->request->getPost('backup_frequency'),
            'retention_days' => $this->request->getPost('retention_days'),
            'backup_location' => $this->request->getPost('backup_location')
        ];

        session()->set('backup_settings', $backupSettings);

        return redirect()->to('settings/backup')->with('success', 'Backup settings updated successfully!');
    }

    public function exportLogs()
    {
        $date = $this->request->getGet('date') ?? date('Y-m-d');
        $logs = $this->getAuditLogs($date);

        // Create CSV content
        $csv = "Timestamp,Action,User,IP Address,Status\n";
        foreach ($logs as $log) {
            $csv .= "{$log['timestamp']},{$log['action']},{$log['user']},{$log['ip_address']},{$log['status']}\n";
        }

        // Set headers for download
        $this->response->setHeader('Content-Type', 'text/csv');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="audit_logs_' . $date . '.csv"');

        return $this->response->setBody($csv);
    }

    private function getHospitalInfo()
    {
        return session()->get('hospital_info') ?? [
            'name' => 'San Miguel Hospital Inc.',
            'license' => 'HL-2024-GSC-001',
            'contact' => '+63 83 552-3456',
            'email' => 'info@sanmiguelhospital.com',
            'address' => 'Pioneer Avenue, General Santos City, South Cotabato, Philippines'
        ];
    }

    private function getSystemPreferences()
    {
        return session()->get('system_preferences') ?? [
            'auto_save' => 1,
            'time_format' => 0,
            'email_notifications' => 1
        ];
    }

    private function getPasswordPolicy()
    {
        return session()->get('password_policy') ?? [
            'min_length' => 8,
            'require_uppercase' => 1,
            'require_numbers' => 1,
            'require_special' => 0
        ];
    }

    private function getSessionManagement()
    {
        return session()->get('session_management') ?? [
            'timeout' => 30,
            'max_attempts' => 3
        ];
    }

    private function getTwoFactorAuth()
    {
        return session()->get('two_factor_auth') ?? [
            'enabled' => 1
        ];
    }

    private function getNotificationSettings()
    {
        return session()->get('notification_settings') ?? [
            'email_alerts' => 1,
            'sms_notifications' => 0,
            'app_notifications' => 1,
            'patient_reminders' => 1,
            'staff_alerts' => 1,
            'system_alerts' => 1
        ];
    }

    private function getBackupSettings()
    {
        return session()->get('backup_settings') ?? [
            'auto_backup' => 1,
            'backup_frequency' => 'daily',
            'retention_days' => 30,
            'backup_location' => '/backups/hms/'
        ];
    }

    private function getRecentBackups()
    {
        return [
            [
                'date' => '2024-01-15 02:00:00',
                'size' => '2.5 GB',
                'status' => 'Completed',
                'type' => 'Full Backup'
            ],
            [
                'date' => '2024-01-14 02:00:00',
                'size' => '2.3 GB',
                'status' => 'Completed',
                'type' => 'Full Backup'
            ],
            [
                'date' => '2024-01-13 02:00:00',
                'size' => '2.4 GB',
                'status' => 'Completed',
                'type' => 'Full Backup'
            ]
        ];
    }

    private function getAuditLogs($date = null)
    {
        // Get real user data for audit logs
        $users = $this->userModel->findAll();
        $userNames = array_column($users, 'name');
        
        // Generate realistic audit logs with real staff names
        $logs = [];
        $actions = [
            'User Login' => ['success' => 0.9, 'failed' => 0.1],
            'Patient Record Updated' => ['success' => 0.95, 'failed' => 0.05],
            'Failed Login Attempt' => ['success' => 0, 'failed' => 1],
            'System Backup' => ['success' => 0.98, 'failed' => 0.02],
            'Medicine Stock Updated' => ['success' => 0.92, 'failed' => 0.08],
            'Appointment Created' => ['success' => 0.94, 'failed' => 0.06],
            'Lab Result Added' => ['success' => 0.96, 'failed' => 0.04],
            'Payment Processed' => ['success' => 0.93, 'failed' => 0.07],
            'Staff Record Modified' => ['success' => 0.91, 'failed' => 0.09],
            'Branch Information Updated' => ['success' => 0.97, 'failed' => 0.03]
        ];

        $ipAddresses = [
            '192.168.1.100', '192.168.1.101', '192.168.1.102', '192.168.1.103',
            '192.168.1.104', '192.168.1.105', '192.168.1.106', '192.168.1.107',
            '192.168.1.108', '192.168.1.109', '192.168.1.110'
        ];

        $currentDate = $date ? date('Y-m-d', strtotime($date)) : date('Y-m-d');
        
        // Generate logs for the specified date
        for ($i = 0; $i < 50; $i++) {
            $action = array_rand($actions);
            $actionData = $actions[$action];
            
            // Determine if this should be a success or failed action
            $isSuccess = (mt_rand(1, 100) / 100) < $actionData['success'];
            
            $timestamp = $currentDate . ' ' . sprintf('%02d:%02d:%02d', 
                mt_rand(0, 23), mt_rand(0, 59), mt_rand(0, 59));
            
            $user = $action === 'System Backup' ? 'System' : 
                   ($action === 'Failed Login Attempt' ? 'Unknown' : 
                   $userNames[array_rand($userNames)]);
            
            $ip = $action === 'System Backup' ? 'Internal' : $ipAddresses[array_rand($ipAddresses)];
            
            $logs[] = [
                'timestamp' => $timestamp,
                'action' => $action,
                'user' => $user,
                'ip_address' => $ip,
                'status' => $isSuccess ? 'Success' : 'Failed'
            ];
        }

        // Sort by timestamp (newest first)
        usort($logs, function($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });

        return array_slice($logs, 0, 25); // Return top 25 logs
    }
}


