<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Laboratory extends Controller
{
    public function index()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_dashboard'); // Renders Laboratory Management dashboard
    }

    public function requests()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // Get all lab requests from database
        $labRequestModel = new \App\Models\LabRequestModel();
        $labRequests = $labRequestModel->orderBy('created_at', 'DESC')->findAll();
        
        // Debug: Log the lab requests found
        log_message('info', 'Admin lab requests - Found ' . count($labRequests) . ' lab requests');
        foreach ($labRequests as $request) {
            log_message('info', 'Lab Request: ' . $request['lab_id'] . ' - ' . $request['patient_name'] . ' by ' . $request['doctor_name']);
        }
        
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
        
        return view('auth/laboratory_requests', [
            'labRequests' => $labRequests,
            'stats' => $stats
        ]);
    }

    public function results()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_results'); // Renders Laboratory Results page
    }

    public function equipment()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_equipment'); // Renders Equipment Status page
    }

    public function tracking()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_tracking'); // Renders Sample Tracking page
    }

    public function reports()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_reports'); // Renders Lab Reports page
    }

    public function quality()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_quality'); // Renders Quality Control page
    }

    public function inventory()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_inventory'); // Renders Lab Inventory page
    }

    public function settings()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_settings'); // Renders Settings page
    }

    public function testRequest()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // Load lab requests data
        $labRequestModel = new \App\Models\LabRequestModel();
        $requests = $labRequestModel->getAllRequests();
        $stats = $labRequestModel->getRequestStats();
        
        $data = [
            'requests' => $requests,
            'stats' => $stats
        ];
        
        return view('auth/laboratory_test_request', $data); // Renders Test Request page
    }

    public function testResults()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_test_results'); // Renders Test Results page
    }

    public function equipmentStatus()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/laboratory_equipment_status'); // Renders Equipment Status page
    }
}


