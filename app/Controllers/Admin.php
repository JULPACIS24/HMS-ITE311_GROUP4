<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function index()
    {
        if (! session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return view('auth/admin_dashboard');
    }

    public function dashboard()
    {
        if (! session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return view('auth/admin_dashboard');
    }
}
