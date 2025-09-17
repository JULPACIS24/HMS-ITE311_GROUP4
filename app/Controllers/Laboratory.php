<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Laboratory extends BaseController
{
    private function checkAuth()
    {
        if (!session('isLoggedIn')) {
            return redirect()->to('/login')->with('errors', ['Please log in to access Laboratory.']);
        }
        return null;
    }

    public function index()
    {
        if (! session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return view('auth/laboratory_dashboard');
    }

    public function requests()
    {
        
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
        return view('auth/laboratory_test_results'); // Renders Laboratory Results page
    }

    public function equipment()
    {
        return view('auth/laboratory_equipment_status'); // Renders Equipment Status page
    }

    public function tracking()
    {
        return view('auth/laboratory_tracking'); // Renders Sample Tracking page
    }

    public function reports()
    {
        return view('auth/laboratory_reports'); // Renders Lab Reports page
    }

    public function quality()
    {
        return view('auth/laboratory_quality'); // Renders Quality Control page
    }

    public function inventory()
    {
        return view('auth/laboratory_inventory'); // Renders Lab Inventory page
    }

    public function settings()
    {
        return view('auth/laboratory_settings'); // Renders Settings page
    }

    public function testRequest()
    {
        if (!session('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        // Get real lab requests from database
        $labRequestModel = new \App\Models\LabRequestModel();
        $labRequests = $labRequestModel->orderBy('created_at', 'DESC')->findAll();
        
        // Debug: Log the lab requests found
        log_message('info', 'Laboratory testRequest - Found ' . count($labRequests) . ' lab requests');
        foreach ($labRequests as $request) {
            log_message('info', 'Lab Request: ' . ($request['lab_id'] ?? 'No ID') . ' - ' . ($request['patient_name'] ?? 'No Name') . ' by ' . ($request['doctor_name'] ?? 'No Doctor'));
        }
        
        // Calculate statistics from real data
        $stats = [
            'total' => count($labRequests),
            'new' => 0,
            'in_progress' => 0,
            'urgent' => 0
        ];
        
        foreach ($labRequests as $request) {
            switch ($request['status']) {
                case 'New Request':
                case 'Pending':
                    $stats['new']++;
                    break;
                case 'In Progress':
                case 'Processing':
                    $stats['in_progress']++;
                    break;
            }
            
            if ($request['priority'] === 'Urgent' || $request['priority'] === 'High') {
                $stats['urgent']++;
            }
        }
        
        $data = [
            'requests' => $labRequests,
            'stats' => $stats
        ];
        
        return view('auth/laboratory_test_request', $data); // Renders Test Request page
    }

    public function testResults()
    {
        return view('auth/laboratory_test_results'); // Renders Test Results page
    }

    public function equipmentStatus()
    {
        return view('auth/laboratory_equipment_status'); // Renders Equipment Status page
    }

    public function clearOldData()
    {
        if (!session('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        // Clear old test request data (for testing purposes)
        $labRequestModel = new \App\Models\LabRequestModel();
        $result = $labRequestModel->deleteByPatientName('gene yoy');
        
        return redirect()->to('/laboratory/test/request')->with('message', 'Old test data cleared. Deleted ' . $result . ' records.');
    }
}


