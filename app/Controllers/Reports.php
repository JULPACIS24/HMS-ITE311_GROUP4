<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Reports extends Controller
{
    public function index()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/reports_dashboard'); // Renders Reports & Analytics dashboard
    }

    public function performance()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/reports_performance'); // Renders Performance Report page
    }

    public function financial()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/reports_financial'); // Renders Financial Reports page
    }

    public function patientAnalytics()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/reports_patient_analytics'); // Renders Patient Analytics page
    }
}


