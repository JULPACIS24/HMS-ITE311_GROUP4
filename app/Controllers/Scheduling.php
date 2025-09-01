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
        
        try {
            // Get real nurses from staff management
            log_message('info', 'Scheduling::nurse() - Getting nurses');
            $userModel = new \App\Models\UserModel();
            $nurses = $userModel->where('role', 'nurse')
                                ->where('status', 'Active')
                                ->orderBy('name', 'ASC')
                                ->findAll();
            
            log_message('info', 'Nurses found: ' . count($nurses));
            
            // Get all nurse schedules from the database (if you have a nurse_schedules table)
            // For now, we'll create mock schedules based on the nurses
            $nurseSchedules = [];
            foreach ($nurses as $nurse) {
                // Create a default schedule for each nurse
                $nurseSchedules[] = [
                    'id' => 'schedule_' . $nurse['id'], // Unique ID for each schedule
                    'nurse_id' => $nurse['id'],
                    'nurse_name' => $nurse['name'],
                    'department' => $nurse['department'] ?? 'General',
                    'shift' => 'Morning Shift',
                    'shift_time' => '6:00 AM - 2:00 PM',
                    'status' => 'Active',
                    'patients_assigned' => rand(0, 10), // Mock data for now
                    'experience' => '5 years experience' // Mock data for now
                ];
            }
            
            return view('auth/scheduling_nurse', [
                'nurses' => $nurses,
                'nurseSchedules' => $nurseSchedules
            ]);
            
        } catch (\Exception $e) {
            // Log the error for debugging
            log_message('error', 'Scheduling::nurse() error: ' . $e->getMessage());
            log_message('error', 'Scheduling::nurse() stack trace: ' . $e->getTraceAsString());
            
            // Return view with empty data instead of crashing
            return view('auth/scheduling_nurse', [
                'nurses' => [],
                'nurseSchedules' => []
            ]);
        }
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
            'patient_id'   => 'required|integer',
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
            
            // Get patient and doctor details
            $patientModel = new \App\Models\PatientModel();
            $userModel = new \App\Models\UserModel();
            
            $patientId = $this->request->getPost('patient_id');
            $doctorName = $this->request->getPost('doctor_name');
            $appointmentDate = $this->request->getPost('date');
            
            // Log the received data
            log_message('info', 'Creating appointment - Patient ID: ' . $patientId . ', Doctor: ' . $doctorName . ', Date: ' . $appointmentDate);
            
            // Get patient details
            $patient = $patientModel->find($patientId);
            if (!$patient) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Patient not found in the system. Please register the patient first.'
                ]);
            }
            
            // Get doctor details
            $doctor = $userModel->where('name', $doctorName)->where('role', 'doctor')->first();
            if (!$doctor) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Doctor not found in the system. Please check the doctor name.'
                ]);
            }
            
            // Check for duplicate appointment (same patient, same date)
            $nextDay = date('Y-m-d', strtotime($appointmentDate . ' +1 day'));
            $existingAppointment = $model->where('patient_id', $patientId)
                                       ->where('date_time >=', $appointmentDate . ' 00:00:00')
                                       ->where('date_time <', $nextDay . ' 00:00:00')
                                       ->first();
            
            if ($existingAppointment) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Patient already has an appointment on this date. Please select a different date or patient.'
                ]);
            }
            
            $payload = [
                'appointment_code' => 'APT' . date('YmdHis'),
                'patient_id'       => $patientId,
                'doctor_id'        => $doctor['id'],
                'patient_name'     => $patient['first_name'] . ' ' . $patient['last_name'],
                'patient_phone'    => $patient['phone'],
                'doctor_name'      => $doctorName,
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
            'patient_id'   => 'required|integer',
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
            
            // Get patient and doctor details
            $patientModel = new \App\Models\PatientModel();
            $userModel = new \App\Models\UserModel();
            
            $patientId = $this->request->getPost('patient_id');
            $doctorName = $this->request->getPost('doctor_name');
            
            // Get patient details
            $patient = $patientModel->find($patientId);
            if (!$patient) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Patient not found in the system.'
                ]);
            }
            
            // Get doctor details
            $doctor = $userModel->where('name', $doctorName)->where('role', 'doctor')->first();
            if (!$doctor) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Doctor not found in the system.'
                ]);
            }
            
            $update = [
                'patient_id'       => $patientId,
                'doctor_id'        => $doctor['id'],
                'patient_name'     => $patient['first_name'] . ' ' . $patient['last_name'],
                'patient_phone'    => $patient['phone'],
                'doctor_name'      => $doctorName,
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
            
            // Search by doctor_id only (temporarily remove date filter)
            $query = $model->where('doctor_id', $doctorId);
            
            log_message('info', 'getDoctorAppointments called with doctorId: ' . $doctorId . ' and date: ' . ($date ?? 'null'));
            log_message('info', 'Temporarily getting ALL appointments for doctor (no date filter)');
            
            // Temporarily comment out date filtering to debug
            /*
            if ($date) {
                $nextDay = date('Y-m-d', strtotime($date . ' +1 day'));
                $query->where('date_time >=', $date . ' 00:00:00')
                      ->where('date_time <', $nextDay . ' 00:00:00');
                log_message('info', 'Filtering by date range: ' . $date . ' 00:00:00 to ' . $nextDay . ' 00:00:00');
            } else {
                log_message('info', 'No date filter applied, getting all appointments for doctor');
            }
            */
            
            $appointments = $query->orderBy('date_time', 'ASC')->findAll();
            
            log_message('info', 'Found ' . count($appointments) . ' appointments for doctor ID: ' . $doctorId . ' (all dates)');
            foreach ($appointments as $apt) {
                log_message('info', 'Appointment: ID=' . $apt['id'] . ', Patient=' . $apt['patient_name'] . ', Date=' . $apt['date_time'] . ', Doctor ID=' . $apt['doctor_id']);
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



	// Get appointments for a specific patient
	public function getPatientAppointments($patientId) {
		try {
			log_message('info', 'getPatientAppointments called for patient ID: ' . $patientId);
			
			$appointmentModel = new \App\Models\AppointmentModel();
			
			// First, let's check if the patient exists
			$patientModel = new \App\Models\PatientModel();
			$patient = $patientModel->find($patientId);
			
			if (!$patient) {
				log_message('error', 'Patient not found with ID: ' . $patientId);
				return $this->response->setJSON([
					'success' => false,
					'message' => 'Patient not found'
				]);
			}
			
			log_message('info', 'Found patient: ' . $patient['first_name'] . ' ' . $patient['last_name']);
			
			// Get appointments using the model
			$appointments = $appointmentModel->select('appointments.*, users.name as doctor_name')
				->join('users', 'users.id = appointments.doctor_id', 'left')
				->where('appointments.patient_id', $patientId)
				->orderBy('appointments.date_time', 'DESC')
				->findAll();
			
			log_message('info', 'Found ' . count($appointments) . ' appointments for patient ID: ' . $patientId);
			
			// Process appointments to extract date and time from date_time
			foreach ($appointments as &$appointment) {
				if (isset($appointment['date_time'])) {
					$dateTime = new \DateTime($appointment['date_time']);
					$appointment['date'] = $dateTime->format('Y-m-d');
					$appointment['time'] = $dateTime->format('H:i');
				} else {
					$appointment['date'] = 'N/A';
					$appointment['time'] = 'N/A';
				}
				
				log_message('info', 'Appointment: ID=' . $appointment['id'] . ', Date=' . $appointment['date'] . ', Time=' . $appointment['time'] . ', Type=' . $appointment['type']);
			}
			
			return $this->response->setJSON([
				'success' => true,
				'appointments' => $appointments
			]);
		} catch (\Exception $e) {
			log_message('error', 'Error getting patient appointments: ' . $e->getMessage());
			log_message('error', 'Stack trace: ' . $e->getTraceAsString());
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Error getting patient appointments: ' . $e->getMessage()
			]);
		}
    }

    // Add nurse schedule
    public function addNurseSchedule()
    {
        if (! session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $rules = [
            'nurse_id' => 'required|numeric',
            'department' => 'required|in_list[Emergency,ICU,Medical]',
            'shift' => 'required|in_list[Morning Shift,Evening Shift,Night Shift]'
        ];

        // Get data from either POST or JSON
        $nurseId = $this->request->getPost('nurse_id') ?? $this->request->getJSON()->nurse_id ?? null;
        $department = $this->request->getPost('department') ?? $this->request->getJSON()->department ?? null;
        $shift = $this->request->getPost('shift') ?? $this->request->getJSON()->shift ?? null;

        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ]);
        }

        try {
            // For now, we'll store in session since we don't have a nurse_schedules table
            // In a real app, you'd insert into a database table
            $scheduleData = [
                'id' => uniqid(),
                'nurse_id' => $nurseId,
                'department' => $department,
                'shift' => $shift,
                'shift_time' => $this->getShiftTime($shift),
                'status' => 'Active',
                'patients_assigned' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Store in session for now (you can create a proper table later)
            $schedules = session('nurse_schedules') ?? [];
            $schedules[] = $scheduleData;
            session()->set('nurse_schedules', $schedules);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Nurse schedule added successfully',
                'schedule' => $scheduleData
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error adding nurse schedule: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to add nurse schedule'
            ]);
        }
    }

    // Update nurse schedule
    public function updateNurseSchedule($id)
    {
        if (! session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $rules = [
            'department' => 'required|in_list[Emergency,ICU,Medical]',
            'shift' => 'required|in_list[Morning Shift,Evening Shift,Night Shift]',
            'status' => 'required|in_list[Active,On Leave]'
        ];

        // Get data from either POST or JSON
        $department = $this->request->getPost('department') ?? $this->request->getJSON()->department ?? null;
        $shift = $this->request->getPost('shift') ?? $this->request->getJSON()->shift ?? null;
        $status = $this->request->getPost('status') ?? $this->request->getJSON()->status ?? null;

        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ]);
        }

        try {
            $schedules = session('nurse_schedules') ?? [];
            $scheduleIndex = -1;

            // Find the schedule to update
            foreach ($schedules as $index => $schedule) {
                if ($schedule['id'] === $id) {
                    $scheduleIndex = $index;
                    break;
                }
            }

            if ($scheduleIndex === -1) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Schedule not found'
                ]);
            }

            // Update the schedule
            $schedules[$scheduleIndex]['department'] = $department;
            $schedules[$scheduleIndex]['shift'] = $shift;
            $schedules[$scheduleIndex]['shift_time'] = $this->getShiftTime($shift);
            $schedules[$scheduleIndex]['status'] = $status;
            $schedules[$scheduleIndex]['updated_at'] = date('Y-m-d H:i:s');

            session()->set('nurse_schedules', $schedules);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Nurse schedule updated successfully',
                'schedule' => $schedules[$scheduleIndex]
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error updating nurse schedule: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update nurse schedule'
            ]);
        }
    }

    // Delete nurse schedule
    public function deleteNurseSchedule($id)
    {
        if (! session('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        try {
            $schedules = session('nurse_schedules') ?? [];
            $scheduleIndex = -1;

            // Find the schedule to delete
            foreach ($schedules as $index => $schedule) {
                if ($schedule['id'] === $id) {
                    $scheduleIndex = $index;
                    break;
                }
            }

            if ($scheduleIndex === -1) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Schedule not found'
                ]);
            }

            // Remove the schedule
            array_splice($schedules, $scheduleIndex, 1);
            session()->set('nurse_schedules', $schedules);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Nurse schedule removed successfully'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error deleting nurse schedule: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to remove nurse schedule'
            ]);
        }
    }

    // Helper method to get shift time based on shift
    private function getShiftTime($shift)
    {
        switch ($shift) {
            case 'Morning Shift':
                return '6:00 AM - 2:00 PM';
            case 'Evening Shift':
                return '2:00 PM - 10:00 PM';
            case 'Night Shift':
                return '10:00 PM - 6:00 AM';
            default:
                return '6:00 AM - 2:00 PM';
        }
    }
}
