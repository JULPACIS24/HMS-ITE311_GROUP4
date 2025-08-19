<?php

namespace App\Controllers;

class Settings extends BaseController
{
	public function index()
	{
		if (! session('isLoggedIn')) {
			return redirect()->to('/login');
		}
		return view('auth/settings');
	}
}


