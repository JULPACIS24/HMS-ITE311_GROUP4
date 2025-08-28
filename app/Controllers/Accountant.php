<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Accountant extends Controller
{
    public function index()
    {
        if (! session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Only allow accountant role
        if (session('role') && session('role') !== 'accountant') {
            return redirect()->to('/dashboard');
        }

        // Load the BillModel to fetch real data for accountant dashboard
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

        return view('auth/accountant_dashboard', [
            'stats' => $stats,
            'recentBills' => $recentBills,
            'recentPayments' => $allRecentActivity
        ]);
    }

    public function billing()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        if (session('role') && session('role') !== 'accountant') return redirect()->to('/dashboard');
        
        // Redirect to billing functionality
        return redirect()->to('/billing');
    }

    public function invoices()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        if (session('role') && session('role') !== 'accountant') return redirect()->to('/dashboard');
        
        // Load invoice data
        $billModel = new \App\Models\BillModel();
        $invoices = $billModel->getBillsWithPatients();
        
        return view('auth/accountant_invoices', [
            'invoices' => $invoices
        ]);
    }

    public function insurance()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        if (session('role') && session('role') !== 'accountant') return redirect()->to('/dashboard');
        
        // Redirect to insurance functionality
        return redirect()->to('/billing/insurance-claims');
    }

    public function reports()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        if (session('role') && session('role') !== 'accountant') return redirect()->to('/dashboard');
        
        // Redirect to financial reports
        return redirect()->to('/reports/financial');
    }

    public function accounts()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        if (session('role') && session('role') !== 'accountant') return redirect()->to('/dashboard');
        
        return view('auth/accountant_accounts');
    }

    public function transactions()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        if (session('role') && session('role') !== 'accountant') return redirect()->to('/dashboard');
        
        return view('auth/accountant_transactions');
    }

    public function settings()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        if (session('role') && session('role') !== 'accountant') return redirect()->to('/dashboard');
        
        return view('auth/accountant_settings');
    }
}
