<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class LabManagement extends BaseController
{
    public function index()
    {
        // Check if user is logged in
        if (!session('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        // Get statistics for the dashboard
        $stats = [
            'total_tests_today' => 25,
            'pending_results' => 8,
            'completed_tests' => 17,
            'urgent_tests' => 3
        ];
        
        // Get sample lab requests data
        $lab_requests = [
            [
                'test_id' => 'T-001',
                'patient_name' => 'Juan Dela Cruz',
                'test_type' => 'Blood Test',
                'priority' => 'Normal',
                'status' => 'pending',
                'request_date' => '2024-01-15'
            ],
            [
                'test_id' => 'T-002',
                'patient_name' => 'Maria Santos',
                'test_type' => 'Urine Analysis',
                'priority' => 'Urgent',
                'status' => 'in_progress',
                'request_date' => '2024-01-15'
            ],
            [
                'test_id' => 'T-003',
                'patient_name' => 'Pedro Reyes',
                'test_type' => 'X-Ray',
                'priority' => 'Normal',
                'status' => 'completed',
                'request_date' => '2024-01-14'
            ]
        ];
        
        // Get sample equipment data
        $equipment = [
            [
                'name' => 'Blood Analyzer',
                'status' => 'operational',
                'utilization' => 85
            ],
            [
                'name' => 'X-Ray Machine',
                'status' => 'operational',
                'utilization' => 60
            ],
            [
                'name' => 'Microscope',
                'status' => 'maintenance',
                'utilization' => 0
            ],
            [
                'name' => 'Centrifuge',
                'status' => 'operational',
                'utilization' => 45
            ]
        ];
        
        return view('lab-management/dashboard', [
            'stats' => $stats,
            'lab_requests' => $lab_requests,
            'equipment' => $equipment
        ]);
    }

    public function requests()
    {
        if (!session('isLoggedIn')) return redirect()->to('/login');
        
        // Load lab requests from database
        $labRequestModel = new \App\Models\LabRequestModel();
        $labRequests = $labRequestModel->getAllRequests();
        $stats = $labRequestModel->getRequestStats();
        
        return view('lab-management/requests', [
            'labRequests' => $labRequests,
            'stats' => $stats
        ]);
    }

    public function results()
    {
        if (!session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_results');
    }

    public function equipment()
    {
        if (!session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_equipment');
    }

    public function newTest()
    {
        if (!session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_requests'); // Redirect to requests page for now
    }

    public function view($testId)
    {
        if (!session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_requests'); // Redirect to requests page for now
    }

    public function edit($testId)
    {
        if (!session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_requests'); // Redirect to requests page for now
    }

    public function delete($testId)
    {
        if (!session('isLoggedIn')) return redirect()->to('/login');
        
        // Add delete logic here
        // For now, just redirect back to requests
        return redirect()->to('/lab-management/requests');
    }

    // Test method to check if controller is working
    public function test()
    {
        return "LabManagement controller is working!";
    }
}
