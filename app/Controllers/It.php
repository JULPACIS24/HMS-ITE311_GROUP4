<?php

namespace App\Controllers;

class It extends BaseController
{
	public function index()
	{
		if (! session('isLoggedIn')) {
			return redirect()->to('/login');
		}

		// Optional role gate: only allow IT staff
		if (session('role') && session('role') !== 'it_staff') {
			return redirect()->to('/dashboard');
		}

		// Fetch latest security logs with user names for dashboard alerts
		$logs = [];
		try {
			$logModel = new \App\Models\SecurityLogModel();
			$userModel = new \App\Models\UserModel();
			
			$rawLogs = $logModel->where('role !=', 'it_staff')->orderBy('created_at', 'DESC')->limit(10)->find();
			
			// Enrich with user names
			foreach ($rawLogs as $log) {
				$log['user_name'] = 'Unknown';
				if (!empty($log['user_id'])) {
					$user = $userModel->find($log['user_id']);
					if ($user) {
						$log['user_name'] = $user['name'];
					}
				}
				$logs[] = $log;
			}
		} catch (\Throwable $e) {
			$logs = [];
		}

		return view('auth/it_dashboard', ['securityLogs' => $logs]);
	}

	public function monitoring()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		return view('auth/it_monitoring');
	}

	public function security()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		return view('auth/it_security');
	}

	public function backup()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		return view('auth/it_backup');
	}

	public function maintenance()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		return view('auth/it_maintenance');
	}

	public function logs()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		return view('auth/it_logs');
	}
}

?>

