<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
		if (! session('isLoggedIn')) {
			return redirect()->to('/login');
		}

		// Check user role and redirect accordingly
		$userRole = session('role');
		
		if ($userRole === 'admin') {
			return redirect()->to('/admin/dashboard');
		} elseif ($userRole === 'doctor') {
			return redirect()->to('/doctor');
		} elseif ($userRole === 'laboratory') {
			return redirect()->to('/laboratory');
		} elseif ($userRole === 'receptionist') {
			return redirect()->to('/receptionist');
		} elseif ($userRole === 'nurse') {
			return redirect()->to('/nurse');
		} elseif ($userRole === 'pharmacist') {
			return redirect()->to('/pharmacy');
		} elseif ($userRole === 'accountant') {
			return redirect()->to('/accountant');
		} elseif ($userRole === 'it_staff') {
			return redirect()->to('/it');
		} else {
			// Unknown role, redirect to login
			session()->destroy();
			return redirect()->to('/login')->with('error', 'Invalid user role.');
		}
	}
}


