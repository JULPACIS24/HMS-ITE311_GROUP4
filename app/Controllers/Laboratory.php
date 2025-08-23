<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Laboratory extends Controller
{
    public function index()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_dashboard'); // Renders Laboratory Management dashboard
    }

    public function requests()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_requests'); // Renders Laboratory Requests page
    }

    public function results()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_results'); // Renders Laboratory Results page
    }

    public function equipment()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_equipment'); // Renders Equipment Status page
    }
}


