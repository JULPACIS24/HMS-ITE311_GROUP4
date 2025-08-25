<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Pharmacy extends Controller
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Get real data from all three submenu sources
        $medicationsModel = new \App\Models\MedicationsInventoryModel();
        $prescriptionModel = new \App\Models\PrescriptionModel();
        $stockAlertsModel = new \App\Models\StockAlertsModel();

        // Get medications inventory data (limit to 5 for dashboard)
        $recentMedications = $medicationsModel->orderBy('medication_name', 'ASC')->limit(5)->findAll();

        // Get recent prescriptions data (limit to 5 for dashboard)
        $recentPrescriptions = $prescriptionModel->orderBy('created_date', 'DESC')->limit(5)->findAll();

        // Get stock alerts data for statistics
        $activeAlerts = $stockAlertsModel->where('status', 'Active')->findAll();

        // Calculate dashboard statistics
        $stats = [
            'total_medications' => $medicationsModel->countAllResults(),
            'low_stock_items' => 0,
            'expiring_soon' => 0,
            'total_value' => 0
        ];

        // Count low stock and expiring items from alerts
        foreach ($activeAlerts as $alert) {
            if ($alert['alert_type'] === 'Low Stock') {
                $stats['low_stock_items']++;
            } elseif ($alert['alert_type'] === 'Expiring Soon') {
                $stats['expiring_soon']++;
            }
        }

        // Calculate total inventory value
        $allMedications = $medicationsModel->findAll();
        foreach ($allMedications as $medication) {
            $stats['total_value'] += ($medication['current_stock'] * $medication['unit_price']);
        }

        // Calculate prescription statistics
        $prescriptionStats = [
            'pending_orders' => count(array_filter($recentPrescriptions, function($p) { return $p['status'] === 'Pending'; })),
            'ready_pickup' => count(array_filter($recentPrescriptions, function($p) { return $p['status'] === 'Ready for Pickup'; })),
            'dispensed_today' => count(array_filter($recentPrescriptions, function($p) { 
                return $p['status'] === 'Dispensed' && date('Y-m-d', strtotime($p['created_date'])) === date('Y-m-d'); 
            }))
        ];

        return view('auth/pharmacy_dashboard', [
            'recentMedications' => $recentMedications,
            'recentPrescriptions' => $recentPrescriptions,
            'stats' => $stats,
            'prescriptionStats' => $prescriptionStats
        ]);
    }

    public function inventory()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $medicationsModel = new \App\Models\MedicationsInventoryModel();
        $allMedications = $medicationsModel->orderBy('medication_name', 'ASC')->findAll();

        // Get stock alerts data to calculate correct statistics
        $stockAlertsModel = new \App\Models\StockAlertsModel();
        $activeAlerts = $stockAlertsModel->where('status', 'Active')->findAll();

        // Calculate statistics based on stock alerts
        $stats = [
            'total_medications' => count($allMedications),
            'low_stock' => 0,
            'out_of_stock' => 0,
            'total_value' => 0
        ];

        // Count low stock and out of stock from alerts
        foreach ($activeAlerts as $alert) {
            if ($alert['alert_type'] === 'Low Stock') {
                $stats['low_stock']++;
            } elseif ($alert['alert_type'] === 'Out of Stock') {
                $stats['out_of_stock']++;
            }
        }

        // Calculate total value from medications inventory
        foreach ($allMedications as $medication) {
            $stats['total_value'] += ($medication['current_stock'] * $medication['unit_price']);
        }

        return view('auth/pharmacy_inventory', [
            'medications' => $allMedications,
            'stats' => $stats
        ]);
    }

    public function prescriptions()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        // Get real prescription data
        $prescriptionModel = new \App\Models\PrescriptionModel();
        $allPrescriptions = $prescriptionModel->orderBy('created_date', 'DESC')->findAll();
        
        // Get real pharmacist data - only show pharmacists that actually exist
        $userModel = new \App\Models\UserModel();
        $pharmacists = $userModel->where('role', 'pharmacist')
                                 ->where('status', 'Active')
                                 ->findAll();
        
        // If no pharmacists found, create a default one or show empty
        if (empty($pharmacists)) {
            $pharmacists = [
                [
                    'id' => 0,
                    'name' => 'No Pharmacists Available',
                    'email' => '',
                    'role' => 'pharmacist'
                ]
            ];
        }
        
        // Calculate statistics
        $stats = [
            'pending_orders' => count(array_filter($allPrescriptions, function($p) { return $p['status'] === 'Pending'; })),
            'ready_pickup' => count(array_filter($allPrescriptions, function($p) { return $p['status'] === 'Ready for Pickup'; })),
            'dispensed_today' => count(array_filter($allPrescriptions, function($p) { 
                return $p['status'] === 'Dispensed' && date('Y-m-d', strtotime($p['created_date'])) === date('Y-m-d'); 
            })),
            'partial_orders' => count(array_filter($allPrescriptions, function($p) { return $p['status'] === 'Partial'; }))
        ];
        
        return view('auth/pharmacy_prescriptions', [
            'prescriptions' => $allPrescriptions,
            'stats' => $stats,
            'pharmacists' => $pharmacists
        ]);
    }

    public function processOrder()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if ($this->request->getMethod() === 'post') {
            $prescriptionId = $this->request->getPost('prescription_id');
            $status = $this->request->getPost('status');
            $notes = $this->request->getPost('notes');
            $processedBy = $this->request->getPost('processed_by');

            $prescriptionModel = new \App\Models\PrescriptionModel();
            $prescription = $prescriptionModel->where('prescription_id', $prescriptionId)->first();

            if ($prescription) {
                $updateData = [
                    'status' => $status,
                    'notes' => $notes,
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $prescriptionModel->update($prescription['id'], $updateData);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Order processed successfully'
                ]);
            }

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Prescription not found'
            ]);
        }
    }

    public function getPrescriptionDetails($prescriptionId)
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        $prescriptionModel = new \App\Models\PrescriptionModel();
        $prescription = $prescriptionModel->where('prescription_id', $prescriptionId)->first();
        
        if (!$prescription) {
            return $this->response->setJSON(['success' => false, 'message' => 'Prescription not found']);
        }
        
        return $this->response->setJSON(['success' => true, 'data' => $prescription]);
    }

    public function alerts()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/pharmacy_alerts'); // Renders Stock Alerts page
    }

    public function stockAlerts()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Get real stock alerts data
        $stockAlertsModel = new \App\Models\StockAlertsModel();
        $allAlerts = $stockAlertsModel->orderBy('priority', 'ASC')
                                     ->orderBy('created_at', 'DESC')
                                     ->findAll();

        // Calculate statistics
        $stats = [
            'critical_alerts' => 0,
            'high_priority' => 0,
            'medium_priority' => 0,
            'low_priority' => 0
        ];

        foreach ($allAlerts as $alert) {
            switch ($alert['priority']) {
                case 'Critical':
                    $stats['critical_alerts']++;
                    break;
                case 'High':
                    $stats['high_priority']++;
                    break;
                case 'Medium':
                    $stats['medium_priority']++;
                    break;
                case 'Low':
                    $stats['low_priority']++;
                    break;
            }
        }

        return view('auth/stock_alerts', [
            'alerts' => $allAlerts,
            'stats' => $stats
        ]);
    }

    public function updateAlertStatus()
    {
        // Debug: Log the request
        log_message('info', 'updateAlertStatus called - Method: ' . $this->request->getMethod());
        log_message('info', 'Session isLoggedIn: ' . (session()->get('isLoggedIn') ? 'true' : 'false'));
        
        if (!session()->get('isLoggedIn')) {
            log_message('error', 'User not logged in');
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Not logged in'
            ]);
        }

        if ($this->request->getMethod() === 'post') {
            $alertId = $this->request->getPost('alert_id');
            $action = $this->request->getPost('action');
            
            // Debug: Log the received data
            log_message('info', 'Received alert_id: ' . $alertId . ', action: ' . $action);

            // Validate inputs
            if (!$alertId || !$action) {
                log_message('error', 'Missing parameters - alert_id: ' . $alertId . ', action: ' . $action);
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Missing required parameters'
                ]);
            }

            try {
                $stockAlertsModel = new \App\Models\StockAlertsModel();
                $alert = $stockAlertsModel->find($alertId);
                
                log_message('info', 'Found alert: ' . ($alert ? 'yes' : 'no'));

                if (!$alert) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Alert not found'
                    ]);
                }

                $updateData = [
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                switch ($action) {
                    case 'dismiss':
                        $updateData['status'] = 'Dismissed';
                        break;
                    case 'reorder':
                        $updateData['status'] = 'Reorder Requested';
                        break;
                    case 'remove':
                        $updateData['status'] = 'Removed from Stock';
                        break;
                    case 'reactivate':
                        $updateData['status'] = 'Active';
                        break;
                    default:
                        log_message('error', 'Invalid action: ' . $action);
                        return $this->response->setJSON([
                            'success' => false,
                            'message' => 'Invalid action'
                        ]);
                }
                
                log_message('info', 'Updating alert with data: ' . json_encode($updateData));

                $result = $stockAlertsModel->update($alertId, $updateData);
                
                log_message('info', 'Update result: ' . ($result ? 'success' : 'failed'));

                if ($result) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Alert updated successfully'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update alert'
                    ]);
                }

            } catch (\Exception $e) {
                log_message('error', 'Exception in updateAlertStatus: ' . $e->getMessage());
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Database error: ' . $e->getMessage()
                ]);
            }
        }

        log_message('error', 'Invalid request method: ' . $this->request->getMethod());
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request method'
        ]);
    }

    public function getAlertDetails($alertId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $stockAlertsModel = new \App\Models\StockAlertsModel();
        $alert = $stockAlertsModel->find($alertId);

        if ($alert) {
            return $this->response->setJSON([
                'success' => true,
                'data' => $alert
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Alert not found'
        ]);
    }
}



