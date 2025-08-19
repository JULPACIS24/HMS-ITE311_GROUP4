<?php

namespace App\Controllers;

class Reports extends BaseController
{
	public function index()
	{
		if (! session('isLoggedIn')) {
			return redirect()->to('/login');
		}
		return view('auth/reports');
	}
}


