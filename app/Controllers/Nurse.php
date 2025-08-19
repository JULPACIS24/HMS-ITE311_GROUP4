<?php

namespace App\Controllers;

class Nurse extends BaseController
{
	public function index()
	{
		if (! session('isLoggedIn')) {
			return redirect()->to('/login');
		}

		if ((session('role') ?? '') !== 'nurse') {
			return redirect()->to('/dashboard');
		}

		return view('auth/nurse_dashboard');
	}
}

?>

