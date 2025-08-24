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
        
        // Load the PatientModel to fetch real patients
        $patientModel = new \App\Models\PatientModel();
        
        // Fetch all active patients with their information
        $patients = $patientModel->select('id, first_name, last_name, phone, email, emergency_name, emergency_phone, blood_type, address')
                                ->findAll();
        
        // Format the data for the view
        foreach ($patients as &$patient) {
            $patient['name'] = $patient['first_name'] . ' ' . $patient['last_name'];
            $patient['patient_id'] = 'P' . str_pad($patient['id'], 3, '0', STR_PAD_LEFT);
            $patient['contact'] = $patient['phone'];
            $patient['emergency_contact'] = $patient['emergency_name'];
            $patient['emergency_contact_number'] = $patient['emergency_phone'];
            
            // Set default values for fields that don't exist yet
            $patient['philhealth_number'] = '';
            $patient['philhealth_category'] = '';
            $patient['insurance_provider'] = '';
            $patient['insurance_policy_number'] = '';
        }
        
        // Pass patients data to the view
        return view('auth/generate_bill', ['patients' => $patients]);
    }

    public function recordPayment()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // This will render the Record Payment page
        return view('auth/record_payment');
    }
}


