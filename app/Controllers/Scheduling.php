<?php

namespace App\Controllers;

class Scheduling extends BaseController
{
    public function doctor()
    {
        // Debug: Check session status
        log_message('info', 'Scheduling::doctor() - Session isLoggedIn: ' . (session('isLoggedIn') ? 'true' : 'false'));
        
        if (!session('isLoggedIn')) return redirect()->to('/login');
        
        try {
            // Get real doctors from staff management
            log_message('info', 'Scheduling::doctor() - Getting doctors');
            $userModel = new \App\Models\UserModel();
            $doctors = $userModel->where('role', 'doctor')
                                ->where('status', 'Active')
                                ->orderBy('name', 'ASC')
                                ->findAll();
            
            log_message('info', 'Doctors found: ' . count($doctors));
            
            // Get existing patients from Patient Management (without status filter)
            log_message('info', 'Scheduling::doctor() - Getting patients');
            $patientModel = new \App\Models\PatientModel();
            $patients = $patientModel->orderBy('first_name', 'ASC')
                                    ->findAll();
            
            log_message('info', 'Patients found: ' . count($patients));
            
            // Get all appointments from the database
            $appointmentModel = new \App\Models\AppointmentModel();
            $appointments = $appointmentModel->orderBy('date_time', 'ASC')->findAll();
            
            log_message('info', 'Appointments found: ' . count($appointments));
            
            return view('auth/scheduling_doctor', [
                'doctors' => $doctors,
                'patients' => $patients,
                'appointments' => $appointments
            ]);
            
        } catch (\Exception $e) {
            // Log the error for debugging
            log_message('error', 'Scheduling::doctor() error: ' . $e->getMessage());
            log_message('error', 'Scheduling::doctor() stack trace: ' . $e->getTraceAsString());
            
            // Return view with empty data instead of crashing
            return view('auth/scheduling_doctor', [
                'doctors' => [],
                'patients' => [],
                'appointments' => []
            ]);
        }
    }

    public function nurse()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/scheduling_nurse');
    }

    public function management()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        
        try {
            // Get real-time statistics for the dashboard
            $appointmentModel = new \App\Models\AppointmentModel();
            $userModel = new \App\Models\UserModel();
            
            // Test database connection
            log_message('info', 'Testing database connection in Scheduling::management()');
            try {
                $appointmentModel->db->connect();
                log_message('info', 'Database connection successful');
            } catch (\Exception $e) {
                log_message('error', 'Database connection failed: ' . $e->getMessage());
                throw $e;
            }
            
            // Get today's appointments count
            log_message('info', 'Getting today\'s appointments count');
            $todayAppointments = $appointmentModel->where('date_time >=', date('Y-m-d') . ' 00:00:00')
                                                ->where('date_time <', date('Y-m-d', strtotime('+1 day')) . ' 00:00:00')
                                                ->countAllResults();
            log_message('info', 'Today\'s appointments count: ' . $todayAppointments);
            
            // Get available doctors count
            $availableDoctors = $userModel->where('role', 'doctor')
                                        ->where('status', 'Active')
                                        ->countAllResults();
            
            // Get pending appointments count
            $pendingAppointments = $appointmentModel->where('status', 'Pending')->countAllResults();
            
            // Get emergency cases count (appointments with Emergency type)
            $emergencyCases = $appointmentModel->where('type', 'Emergency')->countAllResults();
            
            // Get selected date or today's schedule data
            $selectedDate = $this->request->getGet('date') ?: date('Y-m-d');
            $nextDay = date('Y-m-d', strtotime($selectedDate . ' +1 day'));
            $todaySchedule = $appointmentModel->where('date_time >=', $selectedDate . ' 00:00:00')
                                             ->where('date_time <', $nextDay . ' 00:00:00')
                                             ->orderBy('date_time', 'ASC')
                                             ->findAll();
            
            // Get doctor availability data
            $doctors = $userModel->where('role', 'doctor')
                                ->where('status', 'Active')
                                ->orderBy('name', 'ASC')
                                ->findAll();
            
            // Add appointment counts for each doctor
            foreach ($doctors as &$doctor) {
                $doctor['appointment_count'] = $appointmentModel->where('doctor_id', $doctor['id'])->countAllResults();
                $nextDay = date('Y-m-d', strtotime('+1 day'));
                $doctor['today_appointments'] = $appointmentModel->where('doctor_id', $doctor['id'])
                                                               ->where('date_time >=', date('Y-m-d') . ' 00:00:00')
                                                               ->where('date_time <', $nextDay . ' 00:00:00')
                                                               ->countAllResults();
            }
            
            return view('auth/scheduling_management', [
                'stats' => [
                    'today_appointments' => $todayAppointments,
                    'available_doctors' => $availableDoctors,
                    'pending_approval' => $pendingAppointments,
                    'emergency_cases' => $emergencyCases
                ],
                'today_schedule' => $todaySchedule,
                'doctors' => $doctors,
                'selected_date' => $selectedDate
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Scheduling::management() error: ' . $e->getMessage());
            
            // Return view with empty data instead of crashing
            return view('auth/scheduling_management', [
                'stats' => [
                    'today_appointments' => 0,
                    'available_doctors' => 0,
                    'pending_approval' => 0,
                    'emergency_cases' => 0
                ],
                'today_schedule' => [],
                'doctors' => [],
                'selected_date' => date('Y-m-d')
            ]);
        }
    }

    // AJAX endpoint to create new appointment
    public function createAppointment()
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
        }

        $rules = [
            'patient_name' => 'required|min_length[3]',
            'doctor_name'  => 'required|min_length[3]',
            'date'         => 'required',
            'time'         => 'required',
            'type'         => 'required',
            'status'       => 'required|in_list[Confirmed,Pending,Completed]',
            'room'         => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Validation failed', 'errors' => $this->validator->getErrors()]);
        }

        try {
            $model = new \App\Models\AppointmentModel();
            
            // Find patient and doctor IDs
            $patientModel = new \App\Models\PatientModel();
            $userModel = new \App\Models\UserModel();
            
            $patientName = $this->request->getPost('patient_name');
            $doctorName = $this->request->getPost('doctor_name');
            $appointmentDate = $this->request->getPost('date');
            
            // Log the received data
            log_message('info', 'Creating appointment - Patient: ' . $patientName . ', Doctor: ' . $doctorName . ', Date: ' . $appointmentDate);
            
            // Check for duplicate appointment (same patient, same date)
            $nextDay = date('Y-m-d', strtotime($appointmentDate . ' +1 day'));
            $existingAppointment = $model->where('patient_name', $patientName)
                                       ->where('date_time >=', $appointmentDate . ' 00:00:00')
                                       ->where('date_time <', $nextDay . ' 00:00:00')
                                       ->first();
            
            if ($existingAppointment) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Patient already has an appointment on this date. Please select a different date or patient.'
                ]);
            }
            
            // Find patient by name
            $patient = $patientModel->where("CONCAT(first_name, ' ', last_name)", $patientName)->first();
            $doctor = $userModel->where('name', $doctorName)->where('role', 'doctor')->first();
            
            log_message('info', 'Found patient: ' . ($patient ? 'Yes' : 'No') . ', Found doctor: ' . ($doctor ? 'Yes' : 'No'));
            
            $payload = [
                'appointment_code' => 'APT' . date('YmdHis'),
                'patient_id'       => $patient ? $patient['id'] : null,
                'doctor_id'        => $doctor ? $doctor['id'] : null,
                'patient_name'     => $this->request->getPost('patient_name'),
                'patient_phone'    => $patient ? $patient['phone'] : '',
                'doctor_name'      => $this->request->getPost('doctor_name'),
                'date_time'        => $this->request->getPost('date') . ' ' . $this->request->getPost('time'),
                'type'             => $this->request->getPost('type'),
                'status'           => $this->request->getPost('status'),
                'room'             => $this->request->getPost('room'),
                'notes'            => $this->request->getPost('notes') ?: '',
            ];

            log_message('info', 'Payload: ' . json_encode($payload));
            
            $result = $model->insert($payload);
            log_message('info', 'Insert result: ' . $result);
            
            return $this->response->setJSON(['success' => true, 'message' => 'Appointment created successfully']);
            
        } catch (\Exception $e) {
            log_message('error', 'Error creating appointment: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            return $this->response->setJSON(['success' => false, 'message' => 'Error creating appointment: ' . $e->getMessage()]);
        }
    }

    // AJAX endpoint to update appointment
    public function updateAppointment($id)
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
        }

        $rules = [
            'patient_name' => 'required|min_length[3]',
            'doctor_name'  => 'required|min_length[3]',
            'date'         => 'required',
            'time'         => 'required',
            'type'         => 'required',
            'status'       => 'required|in_list[Confirmed,Pending,Completed]',
            'room'         => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Validation failed', 'errors' => $this->validator->getErrors()]);
        }

        try {
            $model = new \App\Models\AppointmentModel();
            
            // Find patient and doctor IDs
            $patientModel = new \App\Models\PatientModel();
            $userModel = new \App\Models\UserModel();
            
            $patientName = $this->request->getPost('patient_name');
            $doctorName = $this->request->getPost('doctor_name');
            
            // Find patient by name
            $patient = $patientModel->where("CONCAT(first_name, ' ', last_name)", $patientName)->first();
            $doctor = $userModel->where('name', $doctorName)->where('role', 'doctor')->first();
            
            $update = [
                'patient_id'       => $patient ? $patient['id'] : null,
                'doctor_id'        => $doctor ? $doctor['id'] : null,
                'patient_name'     => $this->request->getPost('patient_name'),
                'patient_phone'    => $patient ? $patient['phone'] : '',
                'doctor_name'      => $this->request->getPost('doctor_name'),
                'date_time'        => $this->request->getPost('date') . ' ' . $this->request->getPost('time'),
                'type'             => $this->request->getPost('type'),
                'status'           => $this->request->getPost('status'),
                'room'             => $this->request->getPost('room'),
                'notes'            => $this->request->getPost('notes') ?: '',
            ];

            $model->update($id, $update);
            
            return $this->response->setJSON(['success' => true, 'message' => 'Appointment updated successfully']);
            
        } catch (\Exception $e) {
            log_message('error', 'Error updating appointment: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Error updating appointment: ' . $e->getMessage()]);
        }
    }

    // AJAX endpoint to delete appointment
    public function deleteAppointment($id)
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $model = new \App\Models\AppointmentModel();
            $model->delete($id);
            
            return $this->response->setJSON(['success' => true, 'message' => 'Appointment deleted successfully']);
            
        } catch (\Exception $e) {
            log_message('error', 'Error deleting appointment: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Error deleting appointment: ' . $e->getMessage()]);
        }
    }

    // AJAX endpoint to get appointments for a specific doctor and date
    public function getDoctorAppointments($doctorId, $date = null)
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $model = new \App\Models\AppointmentModel();
            
            // First try to get doctor name from the ID
            $userModel = new \App\Models\UserModel();
            $doctor = $userModel->find($doctorId);
            
            if ($doctor) {
                // Search by doctor_id first, then by doctor_name as fallback
                $query = $model->groupStart()
                    ->where('doctor_id', $doctorId)
                    ->orWhere('doctor_name', $doctor['name'])
                    ->groupEnd();
            } else {
                // If doctor not found, just search by doctor_id
                $query = $model->where('doctor_id', $doctorId);
            }
            
            if ($date) {
                $nextDay = date('Y-m-d', strtotime($date . ' +1 day'));
                $query->where('date_time >=', $date . ' 00:00:00')
                      ->where('date_time <', $nextDay . ' 00:00:00');
                log_message('info', 'Filtering by date: ' . $date);
            }
            
            $appointments = $query->orderBy('date_time', 'ASC')->findAll();
            
            log_message('info', 'Found ' . count($appointments) . ' appointments for doctor ID: ' . $doctorId . ' and date: ' . ($date ?? 'all'));
            foreach ($appointments as $apt) {
                log_message('info', 'Appointment: ID=' . $apt['id'] . ', Patient=' . $apt['patient_name'] . ', Time=' . $apt['date_time']);
            }
            
            return $this->response->setJSON(['success' => true, 'appointments' => $appointments]);
            
        } catch (\Exception $e) {
            log_message('error', 'Error getting doctor appointments: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Error getting appointments: ' . $e->getMessage()]);
        }
    }

    // AJAX endpoint to get available patients (those without appointments for the selected doctor and date)
    public function getAvailablePatients($doctorId, $date = null)
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
        }

        try {
            $patientModel = new \App\Models\PatientModel();
            $appointmentModel = new \App\Models\AppointmentModel();
            
            // Get the selected date or use current date
            $selectedDate = $date ?: date('Y-m-d');
            
            // Get all patients
            $allPatients = $patientModel->select('id, first_name, last_name, phone')
                                       ->orderBy('first_name', 'ASC')
                                       ->findAll();
            
                        // Get patients who already have appointments on this date (any doctor)
            $nextDay = date('Y-m-d', strtotime($selectedDate . ' +1 day'));
            $busyPatients = $appointmentModel->select('patient_name')
                                             ->where('date_time >=', $selectedDate . ' 00:00:00')
                                             ->where('date_time <', $nextDay . ' 00:00:00')
                                             ->findAll();
            
            // Extract patient names from busy patients
            $busyPatientNames = array_column($busyPatients, 'patient_name');
            
            // Filter out patients who are already busy
            $availablePatients = array_filter($allPatients, function($patient) use ($busyPatientNames) {
                $fullName = trim($patient['first_name'] . ' ' . $patient['last_name']);
                return !in_array($fullName, $busyPatientNames);
            });
            
            log_message('info', 'Available patients for date ' . $selectedDate . ': ' . count($availablePatients) . ' out of ' . count($allPatients));
            
            return $this->response->setJSON([
                'success' => true,
                'patients' => array_values($availablePatients),
                'date' => $selectedDate
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Error in getAvailablePatients: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error fetching available patients: ' . $e->getMessage()
            ]);
        }
    }
}
