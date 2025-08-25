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

    // View bill details
    public function view($billId)
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        $billModel = new \App\Models\BillModel();
        $bill = $billModel->select('bills.*, patients.first_name, patients.last_name, patients.phone, patients.email, patients.address')
                         ->join('patients', 'patients.id = bills.patient_id', 'left')
                         ->where('bills.bill_id', $billId)
                         ->first();
        
        if (!$bill) {
            return redirect()->to('/billing')->with('error', 'Bill not found');
        }
        
        return view('auth/view_bill', ['bill' => $bill]);
    }
    
    // Edit bill
    public function edit($billId)
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        $billModel = new \App\Models\BillModel();
        $bill = $billModel->select('bills.*, patients.first_name, patients.last_name, patients.phone, patients.email')
                         ->join('patients', 'patients.id = bills.patient_id', 'left')
                         ->where('bills.bill_id', $billId)
                         ->first();
        
        if (!$bill) {
            return redirect()->to('/billing')->with('error', 'Bill not found');
        }
        
        // Get all patients for the dropdown
        $patientModel = new \App\Models\PatientModel();
        $patients = $patientModel->findAll();
        
        return view('auth/edit_bill', [
            'bill' => $bill,
            'patients' => $patients
        ]);
    }
    
    // Update bill
    public function update($billId)
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        $billModel = new \App\Models\BillModel();
        
        $data = [
            'patient_id' => $this->request->getPost('patient_id'),
            'services' => $this->request->getPost('services'),
            'subtotal' => $this->request->getPost('subtotal'),
            'tax' => $this->request->getPost('tax'),
            'discount' => $this->request->getPost('discount'),
            'total_amount' => $this->request->getPost('total_amount'),
            'due_date' => $this->request->getPost('due_date'),
            'notes' => $this->request->getPost('notes'),
            'insurance_provider' => $this->request->getPost('insurance_provider'),
            'insurance_details' => $this->request->getPost('insurance_details')
        ];
        
        // Calculate total if not provided
        if (empty($data['total_amount'])) {
            $data['total_amount'] = $data['subtotal'] + $data['tax'] - $data['discount'];
        }
        
        $result = $billModel->where('bill_id', $billId)->set($data)->update();
        
        if ($result) {
            return redirect()->to('/billing')->with('success', 'Bill updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update bill');
        }
    }
    
    // Download bill as PDF
    public function download($billId)
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        $billModel = new \App\Models\BillModel();
        $bill = $billModel->select('bills.*, patients.first_name, patients.last_name, patients.phone, patients.email, patients.address')
                         ->join('patients', 'patients.id = bills.patient_id', 'left')
                         ->where('bills.bill_id', $billId)
                         ->first();
        
        if (!$bill) {
            return redirect()->to('/billing')->with('error', 'Bill not found');
        }
        
        // Generate HTML content for the bill
        $html = $this->generateBillHTML($bill);
        
        // Set headers for file download
        $filename = 'Bill_' . $bill['bill_id'] . '_' . date('Y-m-d') . '.html';
        
        // Return the HTML as a downloadable file
        return $this->response
            ->setHeader('Content-Type', 'text/html')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Content-Length', strlen($html))
            ->setBody($html);
    }
    
    // Generate HTML content for the bill
    private function generateBillHTML($bill)
    {
        $patientName = $bill['patient_name'] ?: ($bill['first_name'] . ' ' . $bill['last_name']);
        
        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill - ' . $bill['bill_id'] . '</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; background: #fff; }
        .bill-container { max-width: 800px; margin: 20px auto; padding: 40px; border: 2px solid #333; }
        .bill-header { text-align: center; border-bottom: 3px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
        .hospital-name { font-size: 28px; font-weight: bold; margin-bottom: 10px; }
        .bill-title { font-size: 20px; margin-bottom: 5px; }
        .bill-id { font-size: 18px; font-weight: bold; }
        .bill-info { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 30px; }
        .info-section h3 { font-size: 16px; border-bottom: 1px solid #333; padding-bottom: 8px; margin-bottom: 15px; }
        .info-item { margin-bottom: 10px; }
        .info-label { font-weight: bold; display: inline-block; width: 120px; }
        .services-section { margin-bottom: 30px; }
        .services-section h3 { font-size: 16px; border-bottom: 1px solid #333; padding-bottom: 8px; margin-bottom: 15px; }
        .services-content { background: #f9f9f9; padding: 20px; border-left: 4px solid #333; }
        .bill-summary { background: #f9f9f9; padding: 20px; border: 1px solid #333; }
        .summary-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #ddd; }
        .summary-row:last-child { border-bottom: none; font-weight: bold; font-size: 18px; border-top: 2px solid #333; padding-top: 15px; margin-top: 8px; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #666; }
        .status-badge { display: inline-block; padding: 4px 8px; border: 1px solid #333; font-size: 12px; font-weight: bold; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="bill-container">
        <div class="bill-header">
            <div class="hospital-name">San Miguel Hospital</div>
            <div class="bill-title">Medical Bill</div>
            <div class="bill-id">' . $bill['bill_id'] . '</div>
        </div>

        <div class="bill-info">
            <div class="info-section">
                <h3>Patient Information</h3>
                <div class="info-item">
                    <span class="info-label">Name:</span>
                    <span>' . htmlspecialchars($patientName) . '</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone:</span>
                    <span>' . htmlspecialchars($bill['phone'] ?? 'N/A') . '</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span>' . htmlspecialchars($bill['email'] ?? 'N/A') . '</span>
                </div>';
        
        if (!empty($bill['address'])) {
            $html .= '<div class="info-item">
                    <span class="info-label">Address:</span>
                    <span>' . htmlspecialchars($bill['address']) . '</span>
                </div>';
        }
        
        $html .= '</div>

            <div class="info-section">
                <h3>Bill Information</h3>
                <div class="info-item">
                    <span class="info-label">Bill Date:</span>
                    <span>' . date('F j, Y', strtotime($bill['bill_date'])) . '</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Due Date:</span>
                    <span>' . date('F j, Y', strtotime($bill['due_date'])) . '</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="status-badge">' . htmlspecialchars($bill['status']) . '</span>
                </div>';
        
        if (!empty($bill['payment_method'])) {
            $html .= '<div class="info-item">
                    <span class="info-label">Payment:</span>
                    <span>' . htmlspecialchars($bill['payment_method']) . '</span>
                </div>';
        }
        
        if (!empty($bill['insurance_provider'])) {
            $html .= '<div class="info-item">
                    <span class="info-label">Insurance:</span>
                    <span>' . htmlspecialchars($bill['insurance_provider']) . '</span>
                </div>';
        }
        
        $html .= '</div>
        </div>

        <div class="services-section">
            <h3>Services Provided</h3>
            <div class="services-content">
                <p>' . htmlspecialchars($bill['services'] ?: 'Medical Services') . '</p>
            </div>
        </div>

        <div class="bill-summary">
            <h3>Bill Summary</h3>
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>₱' . number_format($bill['subtotal'], 2) . '</span>
            </div>
            <div class="summary-row">
                <span>Tax:</span>
                <span>₱' . number_format($bill['tax'], 2) . '</span>
            </div>';
        
        if ($bill['discount'] > 0) {
            $html .= '<div class="summary-row">
                <span>Discount:</span>
                <span>-₱' . number_format($bill['discount'], 2) . '</span>
            </div>';
        }
        
        $html .= '<div class="summary-row">
                <span>Total Amount:</span>
                <span>₱' . number_format($bill['total_amount'], 2) . '</span>
            </div>
        </div>';

        if (!empty($bill['notes'])) {
            $html .= '<div class="services-section">
            <h3>Notes</h3>
            <div class="services-content">
                <p>' . htmlspecialchars($bill['notes']) . '</p>
            </div>
        </div>';
        }

        $html .= '<div class="footer">
            <p>Thank you for choosing San Miguel Hospital</p>
            <p>For inquiries, please contact us at (123) 456-7890</p>
            <p>Generated on: ' . date('F j, Y \a\t g:i A') . '</p>
        </div>
    </div>
</body>
</html>';
        
        return $html;
    }
    
    // Generate new bill
    public function generate()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // Get all patients for the dropdown
        $patientModel = new \App\Models\PatientModel();
        $patients = $patientModel->findAll();
        
        return view('auth/generate_bill', ['patients' => $patients]);
    }
    
    // Create new bill
    public function create()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        $billModel = new \App\Models\BillModel();
        
        $data = [
            'bill_id' => $billModel->generateBillId(),
            'patient_id' => $this->request->getPost('patient_id'),
            'services' => $this->request->getPost('services'),
            'bill_date' => date('Y-m-d'),
            'due_date' => $this->request->getPost('due_date'),
            'subtotal' => $this->request->getPost('subtotal'),
            'tax' => $this->request->getPost('tax'),
            'discount' => $this->request->getPost('discount'),
            'total_amount' => $this->request->getPost('total_amount'),
            'status' => 'Pending',
            'notes' => $this->request->getPost('notes'),
            'insurance_provider' => $this->request->getPost('insurance_provider'),
            'insurance_details' => $this->request->getPost('insurance_details')
        ];
        
        // Calculate total if not provided
        if (empty($data['total_amount'])) {
            $data['total_amount'] = $data['subtotal'] + $data['tax'] - $data['discount'];
        }
        
        $result = $billModel->insert($data);
        
        if ($result) {
            return redirect()->to('/billing')->with('success', 'Bill generated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to generate bill');
        }
    }
    
    // Delete bill
    public function delete($billId)
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        $billModel = new \App\Models\BillModel();
        $result = $billModel->where('bill_id', $billId)->delete();
        
        if ($result) {
            return redirect()->to('/billing')->with('success', 'Bill deleted successfully');
        } else {
            return redirect()->to('/billing')->with('error', 'Failed to delete bill');
        }
    }
    
    // Update bill status
    public function updateStatus($billId)
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        $billModel = new \App\Models\BillModel();
        
        $data = [
            'status' => $this->request->getPost('status'),
            'payment_method' => $this->request->getPost('payment_method'),
            'payment_date' => $this->request->getPost('payment_date')
        ];
        
        $result = $billModel->updateBillStatus($billId, $data['status'], $data['payment_method'], $data['payment_date']);
        
        if ($result) {
            return redirect()->to('/billing')->with('success', 'Bill status updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update bill status');
        }
    }

    public function recordPayment()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // This will render the Record Payment page
        return view('auth/record_payment');
    }
}


