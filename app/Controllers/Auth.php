<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\SecurityLogModel;

class Auth extends BaseController
{
	public function register()
	{
		return view('auth/register');
	}

	public function attemptRegister()
	{
		$rules = [
			'name'              => 'required|min_length[3]',
			'email'             => 'required|valid_email|is_unique[users.email]',
			'password'          => 'required|min_length[6]',
			'password_confirm'  => 'required|matches[password]',
		];

		if (! $this->validate($rules)) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$userModel = new UserModel();
		$userModel->insert([
			'name'          => $this->request->getPost('name'),
			'email'         => $this->request->getPost('email'),
			'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
		]);

		return redirect()->to('/login')->with('message', 'Registration successful. Please log in.');
	}

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

		session()->set([
			'user_id'    => $user['id'],
			'user_name'  => $user['name'],
			'role'       => $user['role'] ?? null,
			'specialty'  => $user['specialty'] ?? null,
			'department' => $user['department'] ?? null,
			'isLoggedIn' => true,
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

		session()->destroy();
		return redirect()->to('/login')->with('message', 'You have been logged out.');
	}
}


