<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Billing extends Controller
{
    public function index()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // Load the BillModel to fetch real data
        $billModel = new \App\Models\BillModel();
        
        // Get bill statistics
        $stats = $billModel->getBillStatistics();
        
        // Get recent bills
        $recentBills = $billModel->getBillsWithPatients(10);
        
        // Get recent payments (paid bills)
        $recentPayments = $billModel->getBillsWithPatients(5, 'Paid');
        
        // Get pending bills for the Recent Payments section
        $pendingBills = $billModel->getBillsWithPatients(5, 'Pending');
        
        // Combine recent payments and pending bills for the Recent Payments section
        $allRecentActivity = array_merge($recentPayments, $pendingBills);
        // Sort by creation date (newest first)
        usort($allRecentActivity, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        // Take only the first 5
        $allRecentActivity = array_slice($allRecentActivity, 0, 5);
        
        // Pass data to the view
        return view('auth/billing_payments', [
            'stats' => $stats,
            'recentBills' => $recentBills,
            'recentPayments' => $allRecentActivity
        ]);
    }

    public function payments()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // Load the BillModel to fetch real payment data
        $billModel = new \App\Models\BillModel();
        
        // Get all bills with patient information for payment tracking
        $allBills = $billModel->getBillsWithPatients();
        
        // Get payment statistics
        $paymentStats = [
            'total_bills' => count($allBills),
            'paid_bills' => count(array_filter($allBills, fn($bill) => $bill['status'] === 'Paid')),
            'pending_bills' => count(array_filter($allBills, fn($bill) => $bill['status'] === 'Pending')),
            'overdue_bills' => count(array_filter($allBills, fn($bill) => $bill['status'] === 'Pending' && strtotime($bill['due_date']) < time())),
            'total_revenue' => array_sum(array_column(array_filter($allBills, fn($bill) => $bill['status'] === 'Paid'), 'total_amount')),
            'pending_amount' => array_sum(array_column(array_filter($allBills, fn($bill) => $bill['status'] === 'Pending'), 'total_amount'))
        ];
        
        // Pass data to the view
        return view('auth/payment_tracking', [
            'bills' => $allBills,
            'stats' => $paymentStats
        ]);
    }
    
    public function insuranceClaims()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // Load the BillModel to fetch real insurance data
        $billModel = new \App\Models\BillModel();
        
        // Get bills with insurance information
        $insuranceBills = $billModel->select('bills.*, patients.first_name, patients.last_name, patients.phone, patients.email')
                                   ->join('patients', 'patients.id = bills.patient_id', 'left')
                                   ->where('bills.insurance_provider IS NOT NULL')
                                   ->where('bills.insurance_provider !=', '')
                                   ->orderBy('bills.created_at', 'DESC')
                                   ->findAll();
        
        // Get insurance statistics
        $insuranceStats = [
            'total_claims' => count($insuranceBills),
            'philhealth_claims' => count(array_filter($insuranceBills, fn($bill) => $bill['insurance_provider'] === 'PhilHealth')),
            'maxicare_claims' => count(array_filter($insuranceBills, fn($bill) => $bill['insurance_provider'] === 'Maxicare')),
            'intellicare_claims' => count(array_filter($insuranceBills, fn($bill) => $bill['insurance_provider'] === 'Intellicare')),
            'total_insured_amount' => array_sum(array_column($insuranceBills, 'total_amount')),
            'pending_claims' => count(array_filter($insuranceBills, fn($bill) => $bill['status'] === 'Pending'))
        ];
        
        // Pass data to the view
        return view('auth/insurance_claims', [
            'insuranceBills' => $insuranceBills,
            'stats' => $insuranceStats
        ]);
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
        
        // Debug: Log the formatted patients data
        log_message('info', 'Formatted patients data: ' . json_encode($patients));
        
        // Pass patients data to the view
        return view('auth/generate_bill', ['patients' => $patients]);
    }
    
    public function createBill()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // Get JSON input
        $jsonInput = $this->request->getJSON(true);
        
        if (!$jsonInput) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid JSON data received'
            ]);
        }
        
        // Validate request
        $rules = [
            'patient_id' => 'required|integer',
            'patient_name' => 'required|string',
            'bill_date' => 'required|valid_date',
            'due_date' => 'required|valid_date',
            'services' => 'required|string',
            'subtotal' => 'required|numeric',
            'tax' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'notes' => 'permit_empty|string',
            'insurance_provider' => 'permit_empty|string',
            'insurance_details' => 'permit_empty|string',
            'payment_method' => 'required|string',
            'status' => 'required|string'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ]);
        }
        
        try {
            // Debug: Log the received data
            log_message('info', 'Received bill data: ' . json_encode($jsonInput));
            
            // Load the BillModel
            $billModel = new \App\Models\BillModel();
            
            // Generate unique bill ID
            $billId = $billModel->generateBillId();
            
            // Get payment method and status
            $paymentMethod = $jsonInput['payment_method'];
            $status = $jsonInput['status'];
            
            // If cash payment, set payment date to now
            $paymentDate = null;
            if ($paymentMethod === 'Cash' && $status === 'Paid') {
                $paymentDate = date('Y-m-d H:i:s');
            }
            
            // Prepare bill data
            $billData = [
                'bill_id' => $billId,
                'patient_id' => $jsonInput['patient_id'],
                'patient_name' => $jsonInput['patient_name'],
                'bill_date' => $jsonInput['bill_date'],
                'due_date' => $jsonInput['due_date'],
                'services' => $jsonInput['services'],
                'subtotal' => $jsonInput['subtotal'],
                'tax' => $jsonInput['tax'],
                'discount' => $jsonInput['discount'] ?? 0,
                'total_amount' => $jsonInput['total_amount'],
                'status' => $status,
                'payment_method' => $paymentMethod,
                'payment_date' => $paymentDate,
                'notes' => $jsonInput['notes'],
                'insurance_provider' => $jsonInput['insurance_provider'],
                'insurance_details' => $jsonInput['insurance_details']
            ];
            
            // Save bill to database
            $billModel->insert($billData);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Bill created successfully',
                'bill_id' => $billId
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Error creating bill: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error creating bill. Please try again.'
            ]);
        }
    }

    public function recordPayment()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // This will render the Record Payment page
        return view('auth/record_payment');
    }
}


