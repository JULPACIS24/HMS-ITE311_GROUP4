<?php

namespace App\Controllers;

class Pharmacy extends BaseController
{
	public function index()
	{
		if (! session('isLoggedIn')) {
			return redirect()->to('/login');
		}
		return view('auth/pharmacy');
	}
}


