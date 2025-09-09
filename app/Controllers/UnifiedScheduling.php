<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\PatientModel;
use App\Models\UserModel;
use App\Models\RoomModel;

class UnifiedScheduling extends BaseController
{
    protected $appointmentModel;
    protected $patientModel;
    protected $userModel;
    protected $roomModel;

    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->patientModel = new PatientModel();
        $this->userModel = new UserModel();
        $this->roomModel = new RoomModel();
    }

    /**
     * Display unified scheduling dashboard for Admin
     */
    public function admin()
    {
        if (!session('isLoggedIn')) return redirect()->to('/login');
        
        try {
            // Get all doctors
            $doctors = $this->userModel->where('role', 'doctor')
                                     ->where('status', 'Active')
                                     ->orderBy('name', 'ASC')
                                     ->findAll();

            // Get all patients
            $patients = $this->patientModel->orderBy('first_name', 'ASC')->findAll();

            // Get all rooms
            $rooms = $this->roomModel->getAvailableRooms();

            // Get today's appointments
            $today = date('Y-m-d');
            $todayAppointments = $this->appointmentModel->getAppointmentsByDate($today);

            // Get statistics
            $stats = $this->appointmentModel->getStatistics(['date' => $today]);

            return view('auth/unified_scheduling_admin', [
                'doctors' => $doctors,
                'patients' => $patients,
                'rooms' => $rooms,
                'today_appointments' => $todayAppointments,
                'stats' => $stats,
                'selected_date' => $today
            ]);

        } catch (\Exception $e) {
            log_message('error', 'UnifiedScheduling::admin() error: ' . $e->getMessage());
            
            return view('auth/unified_scheduling_admin', [
                'doctors' => [],
                'patients' => [],
                'rooms' => [],
                'today_appointments' => [],
                'stats' => ['total' => 0, 'confirmed' => 0, 'pending' => 0, 'completed' => 0, 'cancelled' => 0],
                'selected_date' => date('Y-m-d')
            ]);
        }
    }

    /**
     * Display unified scheduling dashboard for Doctor
     */
    public function doctor()
    {
        if (!session('isLoggedIn')) return redirect()->to('/login');
        
        try {
            // Get current doctor ID from session
            $doctorId = session('user_id');
            
            // Get all patients
            $patients = $this->patientModel->orderBy('first_name', 'ASC')->findAll();

            // Get all rooms
            $rooms = $this->roomModel->getAvailableRooms();

            // Get doctor's appointments for current week
            $today = date('Y-m-d');
            $weekStart = date('Y-m-d', strtotime('monday this week'));
            $weekEnd = date('Y-m-d', strtotime('sunday this week'));
            
            $appointments = $this->appointmentModel->getAppointmentsByDoctorAndDate($doctorId, $weekStart, $weekEnd);

            // Get statistics
            $stats = $this->appointmentModel->getStatistics(['doctor_id' => $doctorId, 'date' => $today]);

            return view('auth/unified_scheduling_doctor', [
                'patients' => $patients,
                'rooms' => $rooms,
                'appointments' => $appointments,
                'stats' => $stats,
                'selected_date' => $today,
                'week_start' => $weekStart,
                'week_end' => $weekEnd
            ]);

        } catch (\Exception $e) {
            log_message('error', 'UnifiedScheduling::doctor() error: ' . $e->getMessage());
            
            return view('auth/unified_scheduling_doctor', [
                'patients' => [],
                'rooms' => [],
                'appointments' => [],
                'stats' => ['total' => 0, 'confirmed' => 0, 'pending' => 0, 'completed' => 0, 'cancelled' => 0],
                'selected_date' => date('Y-m-d'),
                'week_start' => date('Y-m-d', strtotime('monday this week')),
                'week_end' => date('Y-m-d', strtotime('sunday this week'))
            ]);
        }
    }

    /**
     * AJAX: Create new appointment
     */
    public function createAppointment()
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
        }

        $rules = [
            'patient_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'date' => 'required',
            'start_time' => 'required',
            'duration' => 'required|integer',
            'type' => 'required',
            'room' => 'required',
            'notes' => 'permit_empty',
            'color_label' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Validation failed', 
                'errors' => $this->validator->getErrors()
            ]);
        }

        try {
            // Get patient and doctor details
            $patient = $this->patientModel->find($this->request->getPost('patient_id'));
            $doctor = $this->userModel->find($this->request->getPost('doctor_id'));

            if (!$patient) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Patient not found'
                ]);
            }

            if (!$doctor) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Doctor not found'
                ]);
            }

            // Check for conflicts
            $date = $this->request->getPost('date');
            $time = $this->request->getPost('start_time');
            $dateTime = $date . ' ' . $time . ':00'; // Add seconds
            $duration = $this->request->getPost('duration');

            if ($this->appointmentModel->checkConflict($this->request->getPost('doctor_id'), $dateTime, $duration)) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Time conflict detected. Please choose a different time slot.'
                ]);
            }

            // Create appointment
            $appointmentData = [
                'appointment_code' => 'APT' . date('YmdHis'),
                'patient_id' => $this->request->getPost('patient_id'),
                'patient_name' => $patient['first_name'] . ' ' . $patient['last_name'],
                'patient_phone' => $patient['phone'],
                'doctor_id' => $this->request->getPost('doctor_id'),
                'doctor_name' => $doctor['name'],
                'date_time' => $dateTime,
                'type' => $this->request->getPost('type'),
                'status' => 'Confirmed',
                'room' => $this->request->getPost('room'),
                'notes' => $this->request->getPost('notes') ?: '',
                'color_label' => $this->request->getPost('color_label') ?: '#3b82f6',
                'duration' => $duration
            ];

            // Log the appointment data for debugging
            log_message('debug', 'Creating appointment with data: ' . json_encode($appointmentData));

            $appointmentId = $this->appointmentModel->insert($appointmentData);

            if ($appointmentId) {
                // Log successful creation
                log_message('debug', 'Appointment created successfully with ID: ' . $appointmentId);
                
                // Get the created appointment to verify
                $createdAppointment = $this->appointmentModel->find($appointmentId);
                log_message('debug', 'Created appointment details: ' . json_encode($createdAppointment));

                return $this->response->setJSON([
                    'success' => true, 
                    'message' => 'Appointment created successfully',
                    'appointment_id' => $appointmentId,
                    'appointment' => $createdAppointment
                ]);
            } else {
                log_message('error', 'Failed to create appointment');
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Failed to create appointment'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error creating appointment: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Error creating appointment: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * AJAX: Update appointment
     */
    public function updateAppointment($id)
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
        }

        $rules = [
            'patient_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'date' => 'required',
            'start_time' => 'required',
            'duration' => 'required|integer',
            'type' => 'required',
            'room' => 'required',
            'status' => 'required|in_list[Confirmed,Pending,Completed,Cancelled]',
            'notes' => 'permit_empty',
            'color_label' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Validation failed', 
                'errors' => $this->validator->getErrors()
            ]);
        }

        try {
            // Get patient and doctor details
            $patient = $this->patientModel->find($this->request->getPost('patient_id'));
            $doctor = $this->userModel->find($this->request->getPost('doctor_id'));

            if (!$patient || !$doctor) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Patient or doctor not found'
                ]);
            }

            // Check for conflicts (excluding current appointment)
            $date = $this->request->getPost('date');
            $time = $this->request->getPost('start_time');
            $dateTime = $date . ' ' . $time . ':00'; // Add seconds
            $duration = $this->request->getPost('duration');

            if ($this->appointmentModel->checkConflict($this->request->getPost('doctor_id'), $dateTime, $duration, $id)) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Time conflict detected. Please choose a different time slot.'
                ]);
            }

            // Update appointment
            $appointmentData = [
                'patient_id' => $this->request->getPost('patient_id'),
                'patient_name' => $patient['first_name'] . ' ' . $patient['last_name'],
                'patient_phone' => $patient['phone'],
                'doctor_id' => $this->request->getPost('doctor_id'),
                'doctor_name' => $doctor['name'],
                'date_time' => $dateTime,
                'type' => $this->request->getPost('type'),
                'status' => $this->request->getPost('status'),
                'room' => $this->request->getPost('room'),
                'notes' => $this->request->getPost('notes') ?: '',
                'color_label' => $this->request->getPost('color_label') ?: '#3b82f6',
                'duration' => $duration
            ];

            $result = $this->appointmentModel->update($id, $appointmentData);

            if ($result) {
                return $this->response->setJSON([
                    'success' => true, 
                    'message' => 'Appointment updated successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Failed to update appointment'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error updating appointment: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Error updating appointment: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * AJAX: Delete appointment
     */
    public function deleteAppointment($id)
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $result = $this->appointmentModel->delete($id);

            if ($result) {
                return $this->response->setJSON([
                    'success' => true, 
                    'message' => 'Appointment deleted successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Failed to delete appointment'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error deleting appointment: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Error deleting appointment: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * AJAX: Get appointments for calendar
     */
    public function getAppointments()
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $filters = [];
            
            // Get filters from request
            if ($this->request->getGet('doctor_id')) {
                $filters['doctor_id'] = $this->request->getGet('doctor_id');
            }
            
            if ($this->request->getGet('date')) {
                $filters['date'] = $this->request->getGet('date');
            }

            if ($this->request->getGet('start_date')) {
                $filters['start_date'] = $this->request->getGet('start_date');
            }

            if ($this->request->getGet('end_date')) {
                $filters['end_date'] = $this->request->getGet('end_date');
            }

            // Log the filters for debugging
            log_message('debug', 'getAppointments filters: ' . json_encode($filters));

            $appointments = $this->appointmentModel->getAppointmentsWithDetails($filters);

            // Log the results for debugging
            log_message('debug', 'getAppointments found: ' . count($appointments) . ' appointments');

            return $this->response->setJSON([
                'success' => true,
                'appointments' => $appointments,
                'filters' => $filters, // Include filters in response for debugging
                'count' => count($appointments)
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error getting appointments: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Error getting appointments: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * AJAX: Get patients for dropdown
     */
    public function getPatients()
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $patients = $this->patientModel->select('id, first_name, last_name, phone')
                                         ->orderBy('first_name', 'ASC')
                                         ->findAll();

            return $this->response->setJSON([
                'success' => true,
                'patients' => $patients
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error getting patients: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Error getting patients: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * AJAX: Get rooms for dropdown
     */
    public function getRooms()
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $rooms = $this->roomModel->getAvailableRooms();

            return $this->response->setJSON([
                'success' => true,
                'rooms' => $rooms
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error getting rooms: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Error getting rooms: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * AJAX: Get doctors for dropdown
     */
    public function getDoctors()
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $doctors = $this->userModel->select('id, name, specialty')
                                     ->where('role', 'doctor')
                                     ->where('status', 'Active')
                                     ->orderBy('name', 'ASC')
                                     ->findAll();

            return $this->response->setJSON([
                'success' => true,
                'doctors' => $doctors
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error getting doctors: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Error getting doctors: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * AJAX: Get appointment details for editing
     */
    public function getAppointment($id)
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $appointment = $this->appointmentModel->find($id);
            
            if (!$appointment) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Appointment not found'
                ]);
            }

            // Parse date and time for form
            $dateTime = new \DateTime($appointment['date_time']);
            $appointment['date'] = $dateTime->format('Y-m-d');
            $appointment['start_time'] = $dateTime->format('H:i');

            return $this->response->setJSON([
                'success' => true,
                'appointment' => $appointment
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error getting appointment: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Error getting appointment: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * AJAX: Get statistics
     */
    public function getStatistics()
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $filters = [];
            
            if ($this->request->getGet('doctor_id')) {
                $filters['doctor_id'] = $this->request->getGet('doctor_id');
            }
            
            if ($this->request->getGet('date')) {
                $filters['date'] = $this->request->getGet('date');
            }

            $stats = $this->appointmentModel->getStatistics($filters);

            return $this->response->setJSON([
                'success' => true,
                'statistics' => $stats
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error getting statistics: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Error getting statistics: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Debug endpoint to check appointments
     */
    public function debugAppointments()
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            // Get all appointments
            $allAppointments = $this->appointmentModel->findAll();
            
            // Get today's appointments
            $today = date('Y-m-d');
            $todayAppointments = $this->appointmentModel->getAppointmentsByDate($today);
            
            // Get appointments with details
            $appointmentsWithDetails = $this->appointmentModel->getAppointmentsWithDetails(['date' => $today]);

            return $this->response->setJSON([
                'success' => true,
                'all_appointments' => $allAppointments,
                'today_appointments' => $todayAppointments,
                'appointments_with_details' => $appointmentsWithDetails,
                'today_date' => $today,
                'counts' => [
                    'all' => count($allAppointments),
                    'today' => count($todayAppointments),
                    'with_details' => count($appointmentsWithDetails)
                ]
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error in debug: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Error in debug: ' . $e->getMessage()
            ]);
        }
    }
}
