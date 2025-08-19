<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
		if (! session('isLoggedIn')) {
			return redirect()->to('/login')->with('errors', ['Please log in first.']);
		}

		return view('auth/dashboard');
	}
}


