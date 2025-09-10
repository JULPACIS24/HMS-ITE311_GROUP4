<?php

namespace App\Controllers;

use App\Models\LabRequestModel;
use App\Models\UserModel;

class LabRequests extends BaseController
{
    protected $labRequestModel;
    protected $userModel;

    public function __construct()
    {
        $this->labRequestModel = new LabRequestModel();
        $this->userModel = new UserModel();
    }

    /**
     * Display lab requests (for admin and laboratory)
     */
    public function index()
    {
        $userRole = session('role');
        $status = $this->request->getGet('status');
        $priority = $this->request->getGet('priority');
        
        $data = [
            'title' => 'Lab Requests',
            'requests' => $this->labRequestModel->getAllRequests($status, $priority),
            'stats' => $this->labRequestModel->getRequestStats(),
            'currentStatus' => $status,
            'currentPriority' => $priority,
            'userRole' => $userRole
        ];

        // Determine which view to load based on user role
        if ($userRole === 'admin') {
            return view('auth/admin_lab_requests', $data);
        } elseif ($userRole === 'laboratory') {
            return view('auth/lab_test_requests', $data);
        } else {
            return redirect()->to('/auth/login');
        }
    }

    /**
     * Update request status (for laboratory staff)
     */
    public function updateStatus()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        if (!$id || !$status) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Missing required parameters'
            ]);
        }

        try {
            $this->labRequestModel->updateStatus($id, $status);
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Cancel request (for admin)
     */
    public function cancel($id)
    {
        try {
            $this->labRequestModel->updateStatus($id, 'Cancelled');
            return redirect()->to('/lab-requests')
                           ->with('success', 'Request cancelled successfully!');
        } catch (\Exception $e) {
            return redirect()->to('/lab-requests')
                           ->with('error', 'Failed to cancel request: ' . $e->getMessage());
        }
    }
}
