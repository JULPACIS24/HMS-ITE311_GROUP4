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
}


