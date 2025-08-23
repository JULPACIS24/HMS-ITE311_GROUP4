<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Billing extends Controller
{
    public function index()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // This will render the Billing & Payments dashboard
        return view('auth/billing_payments');
    }

    public function payments()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // This will render the Payment Tracking page
        return view('auth/payment_tracking');
    }

    public function generate()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // This will render the Generate Bill page
        return view('auth/generate_bill');
    }

    public function recordPayment()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // This will render the Record Payment page
        return view('auth/record_payment');
    }
}


