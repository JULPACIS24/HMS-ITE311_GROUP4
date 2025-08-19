<?php

namespace App\Controllers;

class Laboratory extends BaseController
{
	public function index()
	{
		if (! session('isLoggedIn')) {
			return redirect()->to('/login');
		}
		return view('auth/laboratory');
	}
}


