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
        
        // For now, use sample data to avoid database issues
        $labRequests = [
            [
                'lab_id' => 'LR-001',
                'patient_name' => 'Juan Dela Cruz',
                'doctor_name' => 'Dr. Santos',
                'test_type' => 'Blood Test',
                'status' => 'Pending',
                'created_at' => '2024-01-15 10:00:00'
            ],
            [
                'lab_id' => 'LR-002',
                'patient_name' => 'Maria Santos',
                'doctor_name' => 'Dr. Reyes',
                'test_type' => 'Urine Analysis',
                'status' => 'In Progress',
                'created_at' => '2024-01-15 09:30:00'
            ]
        ];
        
        // Calculate statistics
        $stats = [
            'total_requests' => count($labRequests),
            'pending' => 0,
            'in_progress' => 0,
            'completed' => 0
        ];
        
        foreach ($labRequests as $request) {
            switch ($request['status']) {
                case 'Pending':
                    $stats['pending']++;
                    break;
                case 'In Progress':
                    $stats['in_progress']++;
                    break;
                case 'Completed':
                    $stats['completed']++;
                    break;
            }
        }
        
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
