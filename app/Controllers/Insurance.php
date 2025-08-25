<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Insurance extends Controller
{
    public function claims()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // Load the BillModel to fetch real insurance data
        $billModel = new \App\Models\BillModel();
        
        // Get insurance claims with detailed information
        $insuranceClaims = $billModel->getInsuranceClaims();
        
        // Get insurance statistics for the dashboard
        $stats = $billModel->getInsuranceStatistics();
        
        // Pass data to the view
        return view('auth/insurance_claims', [
            'insuranceClaims' => $insuranceClaims,
            'stats' => $stats
        ]);
    }

    public function submitClaim()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // This will render the Submit New Claim page
        return view('auth/submit_claim');
    }
}
