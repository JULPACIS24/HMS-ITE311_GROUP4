<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\SecurityLogModel;

class Auth extends BaseController
{

	public function login()
	{
		return view('auth/login');
	}

	public function attemptLogin()
	{
		$rules = [
			'email'    => 'required|valid_email',
			'password' => 'required',
		];

		if (! $this->validate($rules)) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$userModel = new UserModel();
		$user = $userModel->findByEmail($this->request->getPost('email'));

		if (! $user || ! password_verify($this->request->getPost('password'), $user['password_hash'])) {
			return redirect()->back()->withInput()->with('errors', ['Invalid email or password']);
		}

		// Generate unique session token with user ID
		$sessionToken = bin2hex(random_bytes(32)) . '_' . $user['id'];
		
		session()->set([
			'user_id'    => $user['id'],
			'user_name'  => $user['name'],
			'role'       => $user['role'] ?? null,
			'specialty'  => $user['specialty'] ?? null,
			'department' => $user['department'] ?? null,
			'isLoggedIn' => true,
			'session_token' => $sessionToken,
			'session_start_time' => time(),
		]);

		// Record security log for successful login
		try {
			$sec = new SecurityLogModel();
			$sec->insert([
				'user_id'    => $user['id'] ?? null,
				'role'       => $user['role'] ?? null,
				'event'      => 'login_success',
				'details'    => 'User logged in',
				'ip_address' => $this->request->getIPAddress(),
				'user_agent' => (string) ($this->request->getUserAgent() ?? ''),
			]);
		} catch (\Throwable $e) {
			// Ignore logging failures
		}

		// Redirect based on role
		if (($user['role'] ?? '') === 'it_staff') {
			return redirect()->to('/it');
		}
		if (($user['role'] ?? '') === 'receptionist') {
			return redirect()->to('/receptionist');
		}
		if (($user['role'] ?? '') === 'doctor') {
			return redirect()->to('/doctor');
		}
		if (($user['role'] ?? '') === 'nurse') {
			return redirect()->to('/nurse');
		}
		if (($user['role'] ?? '') === 'pharmacist') {
			return redirect()->to('/pharmacy');
		}
		if (($user['role'] ?? '') === 'laboratory') {
			return redirect()->to('/laboratory');
		}
		if (($user['role'] ?? '') === 'accountant') {
			return redirect()->to('/accountant');
		}

		return redirect()->to('/dashboard');
	}

	public function logout()
	{
		// Log logout event before clearing session
		try {
			$sec = new SecurityLogModel();
			$sec->insert([
				'user_id'    => session('user_id'),
				'role'       => session('role'),
				'event'      => 'logout',
				'details'    => 'User logged out',
				'ip_address' => $this->request->getIPAddress(),
				'user_agent' => (string) ($this->request->getUserAgent() ?? ''),
			]);
		} catch (\Throwable $e) {
			// do nothing
		}

		// Clear session token and destroy session
		session()->remove('session_token');
		session()->destroy();
		return redirect()->to('/login')->with('message', 'You have been logged out.');
	}

    public function forceLogout()
    {
        // Force logout for testing purposes
        session()->remove('session_token');
        session()->destroy();
        return redirect()->to('/login')->with('message', 'You have been force logged out for testing.');
    }

	public function testAuth()
	{
		$isLoggedIn = session('isLoggedIn');
		$userRole = session('role');
		$userId = session('user_id');
		$userName = session('user_name');
		
		return "Auth Test - isLoggedIn: " . ($isLoggedIn ? 'true' : 'false') . 
		       ", role: " . $userRole . 
		       ", user_id: " . $userId . 
		       ", user_name: " . $userName;
	}

	public function clearSession()
	{
		// Clear all session data
		session()->destroy();
		session()->regenerate(true);
		
		// Also clear session files from disk
		$sessionPath = WRITEPATH . 'session';
		if (is_dir($sessionPath)) {
			$files = glob($sessionPath . '/*');
			foreach ($files as $file) {
				if (is_file($file)) {
					unlink($file);
				}
			}
		}
		
		return redirect()->to('/login')->with('message', 'Session cleared completely.');
	}
}


