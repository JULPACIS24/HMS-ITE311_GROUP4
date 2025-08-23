<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Pharmacy extends Controller
{
    public function index()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/pharmacy_dashboard'); // Renders Pharmacy Management dashboard
    }

    public function inventory()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/pharmacy_inventory'); // Renders Inventory Management page
    }

    public function prescriptions()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/pharmacy_prescriptions'); // Renders Prescription Orders page
    }

    public function alerts()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/pharmacy_alerts'); // Renders Stock Alerts page
    }
}


