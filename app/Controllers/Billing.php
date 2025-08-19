<?php

namespace App\Controllers;

class Billing extends BaseController
{
	public function index()
	{
		if (! session('isLoggedIn')) {
			return redirect()->to('/login');
		}
		return view('auth/billing');
	}
}


