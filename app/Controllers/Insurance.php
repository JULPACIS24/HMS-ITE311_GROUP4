<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Insurance extends Controller
{
    public function claims()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // This will render the Insurance Claims dashboard
        return view('auth/insurance_claims');
    }

    public function submitClaim()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // This will render the Submit New Claim page
        return view('auth/submit_claim');
    }
}
