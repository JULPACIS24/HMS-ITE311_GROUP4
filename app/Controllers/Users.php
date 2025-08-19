<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
	public function index()
	{
		if (! session('isLoggedIn')) {
			return redirect()->to('/login');
		}
		$userModel = new UserModel();
		$isItStaff = (session('role') === 'it_staff');

		if ($isItStaff) {
			// IT staff see only operational roles (not IT nor Admin)
			$users = $userModel
				->whereNotIn('role', ['it_staff', 'admin'])
				->orderBy('id', 'DESC')
				->findAll();
			$roleOptions = ['doctor','nurse','accountant','receptionist','laboratory','pharmacist'];
		} else {
			// Admin sees only IT staff accounts here
			$users = $userModel
				->where('role', 'it_staff')
				->orderBy('id', 'DESC')
				->findAll();
			$roleOptions = ['it_staff'];
		}

		return view('auth/users', [
			'users'       => $users,
			'message'     => session()->getFlashdata('message'),
			'errors'      => session()->getFlashdata('errors'),
			'roleOptions' => $roleOptions,
			'isItStaff'   => $isItStaff,
		]);
	}

	public function store()
	{
		if (! session('isLoggedIn')) {
			return redirect()->to('/login');
		}

		$isItStaff = (session('role') === 'it_staff');
		$allowedRoles = $isItStaff
			? ['doctor','nurse','accountant','receptionist','laboratory','pharmacist']
			: ['it_staff'];

		$rules = [
			'name'             => 'required|min_length[3]',
			'email'            => 'required|valid_email|is_unique[users.email]',
			'password'         => 'required|min_length[6]',
			'password_confirm' => 'required|matches[password]',
			'role'             => 'required|in_list[' . implode(',', $allowedRoles) . ']',
		];

		if (! $this->validate($rules)) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$userModel = new UserModel();
		$role = strtolower($this->request->getPost('role'));
		if (! in_array($role, $allowedRoles, true)) {
			$role = 'it_staff';
		}

		$userModel->insert([
			'name'          => $this->request->getPost('name'),
			'email'         => $this->request->getPost('email'),
			'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
			'role'          => $role,
			'department'    => $this->mapDepartment($role),
			'status'        => 'Active',
		]);

		return redirect()->to('/users')->with('message', 'User account created successfully.');
	}

	private function mapDepartment(?string $role): string
	{
		$role = strtolower($role ?? '');
		switch ($role) {
			case 'doctor': return 'Medical';
			case 'nurse': return 'Nursing';
			case 'accountant': return 'Finance';
			case 'receptionist': return 'Front Desk';
			case 'laboratory': return 'Laboratory';
			case 'pharmacist': return 'Pharmacy';
			case 'it_staff':
			default: return 'IT';
		}
	}
}


