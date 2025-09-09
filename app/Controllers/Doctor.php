<?php

namespace App\Controllers;

class Doctor extends BaseController
{
	public function index()
	{
		if (! session('isLoggedIn')) {
			return redirect()->to('/login');
		}

		// Optional role gate
		if (session('role') && session('role') !== 'doctor') {
			return redirect()->to('/dashboard');
		}

		return view('auth/doctor_dashboard');
	}

	public function patients()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		// Get real patient data from database - same as admin
		$model = new \App\Models\PatientModel();
		$data['patients'] = $model->orderBy('id', 'ASC')->findAll();
		
		// Calculate patient statistics
		$data['stats'] = [
			'total_patients' => count($data['patients']),
			'active_cases' => count($data['patients']), // For now, consider all as active
			'critical_patients' => 0, // Can be enhanced later with medical condition data
			'discharged_today' => 0 // Can be enhanced later with discharge data
		];
		
		return view('auth/doctor_patients', $data);
	}

	public function viewPatient($id)
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$model = new \App\Models\PatientModel();
		$data['patient'] = $model->find($id);
		
		if (!$data['patient']) {
			return redirect()->to('/doctor/patients')->with('error', 'Patient not found.');
		}
		
		return view('auth/doctor_view_patient', $data);
	}

	public function editPatient($id)
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$model = new \App\Models\PatientModel();
		$data['patient'] = $model->find($id);
		
		if (!$data['patient']) {
			return redirect()->to('/doctor/patients')->with('error', 'Patient not found.');
		}
		
		return view('auth/doctor_edit_patient', $data);
	}

	public function updatePatient($id)
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$rules = [
			'first_name' => 'required|min_length[2]',
			'last_name'  => 'required|min_length[2]',
			'dob'        => 'required',
			'gender'     => 'required',
			'phone'      => 'required',
		];

		if (! $this->validate($rules)) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$model = new \App\Models\PatientModel();
		$model->update($id, [
			'first_name' => $this->request->getPost('first_name'),
			'last_name'  => $this->request->getPost('last_name'),
			'dob'        => $this->request->getPost('dob'),
			'age'        => $this->request->getPost('age'),
			'gender'     => $this->request->getPost('gender'),
			'phone'      => $this->request->getPost('phone'),
			'email'      => $this->request->getPost('email'),
			'address'    => $this->request->getPost('address'),
			'blood_type' => $this->request->getPost('blood_type'),
			'emergency_name'  => $this->request->getPost('emergency_name'),
			'emergency_phone' => $this->request->getPost('emergency_phone'),
			'medical_history' => $this->request->getPost('medical_history'),
			'allergies'       => $this->request->getPost('allergies'),
		]);
		
		return redirect()->to('/doctor/patients')->with('message', 'Patient updated successfully.');
	}

	public function appointments()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		// Get real appointment data for the logged-in doctor
		$appointmentModel = new \App\Models\AppointmentModel();
		$userModel = new \App\Models\UserModel();
		
		// Get the logged-in doctor's name
		$doctorName = session('user_name');
		
		// Debug: Log the doctor name
		log_message('info', 'Doctor appointments - Doctor name: ' . $doctorName);
		
		// Get today's date
		$today = date('Y-m-d');
		$nextDay = date('Y-m-d', strtotime('+1 day'));
		
		// Debug: Log the date range
		log_message('info', 'Doctor appointments - Date range: ' . $today . ' to ' . $nextDay);
		
		// Get ALL appointments for this doctor (not just today's) to show all appointments
		$allAppointments = $appointmentModel->where('doctor_name', $doctorName)
										   ->orderBy('date_time', 'ASC')
										   ->findAll();
		
		// Debug: Log the appointments found
		log_message('info', 'Doctor appointments - Found ' . count($allAppointments) . ' appointments for doctor');
		foreach ($allAppointments as $apt) {
			log_message('info', 'Appointment: ' . $apt['patient_name'] . ' at ' . $apt['date_time'] . ' (status: ' . $apt['status'] . ', room: ' . ($apt['room'] ?? 'N/A') . ')');
		}
		
		// Get today's appointments for statistics
		$todayAppointments = $appointmentModel->where('doctor_name', $doctorName)
											 ->where('date_time >=', $today . ' 00:00:00')
											 ->where('date_time <', $nextDay . ' 00:00:00')
											 ->findAll();
		
		// Calculate statistics
		$stats = [
			'today_appointments' => count($todayAppointments),
			'completed_today' => 0,
			'urgent_cases' => 0,
			'available_slots' => 8 // Assuming 8 slots per day (9 AM to 5 PM)
		];
		
		// Count completed and urgent appointments
		foreach ($todayAppointments as $appointment) {
			if ($appointment['status'] === 'Completed') {
				$stats['completed_today']++;
			}
			if ($appointment['type'] === 'Emergency' || $appointment['status'] === 'Urgent') {
				$stats['urgent_cases']++;
			}
		}
		
		// Calculate available slots (subtract scheduled appointments)
		$stats['available_slots'] = max(0, $stats['available_slots'] - $stats['today_appointments']);
		
		// Process appointments for display
		foreach ($allAppointments as &$appointment) {
			// Use patient_name directly since there's no patient_id
			$appointment['patient_full_name'] = $appointment['patient_name'] ?? 'Unknown Patient';
			$appointment['patient_id_formatted'] = 'N/A'; // No patient ID in appointments table
			
			// Format time
			$dateTime = new \DateTime($appointment['date_time']);
			$appointment['formatted_time'] = $dateTime->format('g:i A');
			$appointment['formatted_date'] = $dateTime->format('Y-m-d');
			
			// Include room information
			$appointment['room_info'] = $appointment['room'] ?? 'No Room Assigned';
		}
		
		return view('auth/doctor_appointments', [
			'appointments' => $allAppointments, // Show all appointments, not just today's
			'stats' => $stats
		]);
	}

	public function prescriptions()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		// Get real patients from database
		$patientModel = new \App\Models\PatientModel();
		$patients = $patientModel->orderBy('first_name', 'ASC')->findAll();
		
		// Get real prescriptions for this doctor
		$prescriptionModel = new \App\Models\PrescriptionModel();
		$prescriptions = $prescriptionModel->getByDoctor(session('user_name'));
		
		// Calculate real prescription statistics
		$stats = [
			'total_prescriptions' => count($prescriptions),
			'active_prescriptions' => count(array_filter($prescriptions, function($p) { return $p['status'] === 'Active'; })),
			'pending_approvals' => count(array_filter($prescriptions, function($p) { return $p['status'] === 'Pending'; })),
			'refills_needed' => count(array_filter($prescriptions, function($p) { return $p['status'] === 'Refill'; }))
		];
		
		return view('auth/doctor_prescriptions', [
			'patients' => $patients,
			'prescriptions' => $prescriptions,
			'stats' => $stats
		]);
	}

	public function labRequests()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		// Get lab requests for this doctor
		$labRequestModel = new \App\Models\LabRequestModel();
		$doctorName = session('user_name');
		
		$labRequests = $labRequestModel->where('doctor_name', $doctorName)
									  ->orderBy('created_at', 'DESC')
									  ->findAll();
		
		// Calculate statistics
		$stats = [
			'total_requests' => count($labRequests ?? []),
			'pending_results' => 0,
			'stat_orders' => 0,
			'completed_today' => 0
		];
		
		$today = date('Y-m-d');
		if (!empty($labRequests)) {
			foreach ($labRequests as $request) {
				if ($request['status'] === 'Pending' || $request['status'] === 'In Progress') {
					$stats['pending_results']++;
				}
				if ($request['priority'] === 'STAT') {
					$stats['stat_orders']++;
				}
				if ($request['status'] === 'Completed' && date('Y-m-d', strtotime($request['created_at'])) === $today) {
					$stats['completed_today']++;
				}
			}
		}
		
		return view('auth/doctor_lab_requests', [
			'labRequests' => $labRequests,
			'stats' => $stats
		]);
	}
	
	public function createLabRequest()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		// Get available patients
		$patientModel = new \App\Models\PatientModel();
		$patients = $patientModel->orderBy('first_name', 'ASC')->findAll();
		
		return view('auth/doctor_create_lab_request', [
			'patients' => $patients
		]);
	}
	
	public function storeLabRequest()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$labRequestModel = new \App\Models\LabRequestModel();
		$patientModel = new \App\Models\PatientModel();
		
		// Get patient details
		$patientId = $this->request->getPost('patient_id');
		$patient = $patientModel->find($patientId);
		
		if (!$patient) {
			return redirect()->back()->with('error', 'Patient not found.');
		}
		
		// Get selected tests
		$selectedTests = $this->request->getPost('tests') ?? [];
		$testsString = implode(', ', $selectedTests);
		
		$labRequestData = [
			'lab_id' => 'LAB-' . date('YmdHis'),
			'patient_name' => $patient['first_name'] . ' ' . $patient['last_name'],
			'patient_id' => 'P-' . str_pad($patient['id'], 6, '0', STR_PAD_LEFT),
			'doctor_name' => session('user_name'),
			'tests' => $testsString,
			'priority' => $this->request->getPost('priority'),
			'status' => 'Pending',
			'expected_date' => $this->request->getPost('expected_date'),
			'clinical_notes' => $this->request->getPost('clinical_notes'),
			'created_at' => date('Y-m-d H:i:s')
		];
		
		$labRequestModel->insert($labRequestData);
		
		return redirect()->to('/doctor/lab-requests')->with('message', 'Lab request created successfully.');
	}
	
	public function viewLabRequest($id)
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$labRequestModel = new \App\Models\LabRequestModel();
		$labRequest = $labRequestModel->find($id);
		
		if (!$labRequest) {
			return redirect()->to('/doctor/lab-requests')->with('error', 'Lab request not found.');
		}
		
		// Check if this lab request belongs to the logged-in doctor
		if ($labRequest['doctor_name'] !== session('user_name')) {
			return redirect()->to('/doctor/lab-requests')->with('error', 'You can only view your own lab requests.');
		}
		
		return view('auth/doctor_view_lab_request', ['labRequest' => $labRequest]);
	}
	
	public function editLabRequest($id)
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$labRequestModel = new \App\Models\LabRequestModel();
		$labRequest = $labRequestModel->find($id);
		
		if (!$labRequest) {
			return redirect()->to('/doctor/lab-requests')->with('error', 'Lab request not found.');
		}
		
		// Check if this lab request belongs to the logged-in doctor
		if ($labRequest['doctor_name'] !== session('user_name')) {
			return redirect()->to('/doctor/lab-requests')->with('error', 'You can only edit your own lab requests.');
		}
		
		// Get available patients
		$patientModel = new \App\Models\PatientModel();
		$patients = $patientModel->orderBy('first_name', 'ASC')->findAll();
		
		return view('auth/doctor_edit_lab_request', [
			'labRequest' => $labRequest,
			'patients' => $patients
		]);
	}
	
	public function updateLabRequest($id)
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$labRequestModel = new \App\Models\LabRequestModel();
		$labRequest = $labRequestModel->find($id);
		
		if (!$labRequest) {
			return redirect()->to('/doctor/lab-requests')->with('error', 'Lab request not found.');
		}
		
		// Check if this lab request belongs to the logged-in doctor
		if ($labRequest['doctor_name'] !== session('user_name')) {
			return redirect()->to('/doctor/lab-requests')->with('error', 'You can only update your own lab requests.');
		}
		
		// Get selected tests
		$selectedTests = $this->request->getPost('tests') ?? [];
		$testsString = implode(', ', $selectedTests);
		
		$updateData = [
			'tests' => $testsString,
			'priority' => $this->request->getPost('priority'),
			'expected_date' => $this->request->getPost('expected_date'),
			'clinical_notes' => $this->request->getPost('clinical_notes'),
		];
		
		$labRequestModel->update($id, $updateData);
		
		return redirect()->to('/doctor/lab-requests')->with('message', 'Lab request updated successfully.');
	}
	
	public function deleteLabRequest($id)
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$labRequestModel = new \App\Models\LabRequestModel();
		$labRequest = $labRequestModel->find($id);
		
		if (!$labRequest) {
			return $this->response->setJSON(['success' => false, 'message' => 'Lab request not found.']);
		}
		
		// Check if this lab request belongs to the logged-in doctor
		if ($labRequest['doctor_name'] !== session('user_name')) {
			return $this->response->setJSON(['success' => false, 'message' => 'You can only delete your own lab requests.']);
		}
		
		$labRequestModel->delete($id);
		
		return $this->response->setJSON(['success' => true, 'message' => 'Lab request deleted successfully.']);
	}

	public function consultations()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		// Debug session data
		log_message('info', 'Doctor consultations - Session data: user_id=' . session('user_id') . ', user_name=' . session('user_name') . ', role=' . session('role'));
		
		try {
			// Test database connection first
			$db = \Config\Database::connect();
			log_message('info', 'Doctor consultations - Database connection successful');
			
			$consultationModel = new \App\Models\ConsultationModel();
			$appointmentModel = new \App\Models\AppointmentModel();
			
			// Test if tables exist
			$tables = $db->listTables();
			log_message('info', 'Doctor consultations - Available tables: ' . implode(', ', $tables));
			
			// Get consultation statistics for the current doctor
			$stats = $consultationModel->getDoctorConsultationStats(session('user_id'));
			log_message('info', 'Doctor consultations - Stats retrieved: ' . json_encode($stats));
			
			// Get consultations for the current doctor
			$consultations = $consultationModel->getConsultationsWithDetails(session('user_id'));
			log_message('info', 'Doctor consultations - Consultations retrieved: ' . count($consultations));
			
			// Get upcoming appointments that can be converted to consultations
			// Use the new doctor_id field instead of doctor_name
			$upcomingAppointments = $appointmentModel->select('appointments.*, patients.first_name, patients.last_name')
													->join('patients', 'patients.id = appointments.patient_id', 'left')
													->where('appointments.doctor_id', session('user_id'))
													->where('appointments.status', 'Confirmed')
													->orderBy('appointments.date_time', 'ASC')
													->findAll();
			
			log_message('info', 'Doctor consultations - Found appointments for doctor ID: ' . session('user_id') . ', count: ' . count($upcomingAppointments));
			
			return view('auth/doctor_consultations', [
				'stats' => $stats,
				'consultations' => $consultations,
				'upcomingAppointments' => $upcomingAppointments
			]);
			
		} catch (\Exception $e) {
			log_message('error', 'Error in doctor consultations: ' . $e->getMessage());
			log_message('error', 'Error trace: ' . $e->getTraceAsString());
			return view('auth/doctor_consultations', [
				'stats' => ['total' => 0, 'active' => 0, 'completed' => 0, 'emergency' => 0],
				'consultations' => [],
				'upcomingAppointments' => [],
				'error' => 'Unable to load consultations at this time. Please try again. Error: ' . $e->getMessage()
			]);
		}
	}


	public function reports()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		return view('auth/doctor_reports');
	}

	public function editAppointment($id)
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$appointmentModel = new \App\Models\AppointmentModel();
		$appointment = $appointmentModel->find($id);
		
		if (!$appointment) {
			return redirect()->to('/doctor/appointments')->with('error', 'Appointment not found.');
		}
		
		// Check if this appointment belongs to the logged-in doctor
		if ($appointment['doctor_name'] !== session('user_name')) {
			return redirect()->to('/doctor/appointments')->with('error', 'You can only edit your own appointments.');
		}
		
		return view('auth/doctor_edit_appointment', ['appointment' => $appointment]);
	}
	
	public function updateAppointment($id)
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$appointmentModel = new \App\Models\AppointmentModel();
		$appointment = $appointmentModel->find($id);
		
		if (!$appointment) {
			return redirect()->to('/doctor/appointments')->with('error', 'Appointment not found.');
		}
		
		// Check if this appointment belongs to the logged-in doctor
		if ($appointment['doctor_name'] !== session('user_name')) {
			return redirect()->to('/doctor/appointments')->with('error', 'You can only update your own appointments.');
		}
		
		$updateData = [
			'status' => $this->request->getPost('status'),
			'notes' => $this->request->getPost('notes'),
			'room' => $this->request->getPost('room'),
		];
		
		$appointmentModel->update($id, $updateData);
		
		return redirect()->to('/doctor/appointments')->with('message', 'Appointment updated successfully.');
	}
	
	public function markCompleted($id)
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$appointmentModel = new \App\Models\AppointmentModel();
		$appointment = $appointmentModel->find($id);
		
		if (!$appointment) {
			return $this->response->setJSON(['success' => false, 'message' => 'Appointment not found.']);
		}
		
		// Check if this appointment belongs to the logged-in doctor
		if ($appointment['doctor_name'] !== session('user_name')) {
			return $this->response->setJSON(['success' => false, 'message' => 'You can only update your own appointments.']);
		}
		
		$appointmentModel->update($id, ['status' => 'Completed']);
		
		return $this->response->setJSON(['success' => true, 'message' => 'Appointment marked as completed.']);
	}
	
	public function scheduleAppointment()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		// Get available patients
		$patientModel = new \App\Models\PatientModel();
		$patients = $patientModel->orderBy('first_name', 'ASC')->findAll();
		
		// Get doctor's existing appointments to show availability
		$appointmentModel = new \App\Models\AppointmentModel();
		$doctorName = session('user_name');
		$existingAppointments = $appointmentModel->where('doctor_name', $doctorName)
												->where('date_time >=', date('Y-m-d') . ' 00:00:00')
												->orderBy('date_time', 'ASC')
												->findAll();
		
		return view('auth/doctor_schedule_appointment', [
			'patients' => $patients,
			'existingAppointments' => $existingAppointments
		]);
	}
	
	public function createAppointment()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$appointmentModel = new \App\Models\AppointmentModel();
		$patientModel = new \App\Models\PatientModel();
		
		// Get patient details
		$patientId = $this->request->getPost('patient_id');
		$patient = $patientModel->find($patientId);
		
		if (!$patient) {
			return redirect()->back()->with('error', 'Patient not found.');
		}
		
		$appointmentData = [
			'appointment_code' => 'APT' . date('YmdHis'),
			'patient_name' => $patient['first_name'] . ' ' . $patient['last_name'],
			'patient_phone' => $patient['phone'],
			'doctor_name' => session('user_name'),
			'date_time' => $this->request->getPost('date') . ' ' . $this->request->getPost('time'),
			'type' => $this->request->getPost('type'),
			'status' => 'Confirmed',
			'room' => $this->request->getPost('room'),
			'notes' => $this->request->getPost('notes'),
		];
		
		$appointmentModel->insert($appointmentData);
		
		return redirect()->to('/doctor/appointments')->with('message', 'Appointment scheduled successfully.');
	}

	public function createPrescription()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$prescriptionModel = new \App\Models\PrescriptionModel();
		
		// Get form data
		$patientName = $this->request->getPost('patient_name');
		$patientId = $this->request->getPost('patient_id');
		$diagnosis = $this->request->getPost('diagnosis');
		$notes = $this->request->getPost('notes');
		$medications = $this->request->getPost('medications');
		
		// Process medications array
		$medicationsData = [];
		if (is_array($medications)) {
			foreach ($medications as $med) {
				if (!empty($med['name']) && !empty($med['dosage'])) {
					$medicationsData[] = [
						'name' => $med['name'],
						'dosage' => $med['dosage'],
						'frequency' => $med['frequency'],
						'duration' => $med['duration']
					];
				}
			}
		}
		
		// Calculate total amount (mock calculation)
		$totalAmount = count($medicationsData) * 150.00; // Mock price per medication
		
		$prescriptionData = [
			'prescription_id' => $prescriptionModel->generatePrescriptionId(),
			'patient_name' => $patientName,
			'patient_id' => $patientId,
			'doctor_name' => session('user_name'),
			'doctor_id' => session('user_id'),
			'diagnosis' => $diagnosis,
			'medications' => json_encode($medicationsData),
			'notes' => $notes,
			'status' => 'Pending',
			'total_amount' => $totalAmount,
			'insurance_covered' => 'Yes',
			'created_date' => date('Y-m-d H:i:s')
		];
		
		$result = $prescriptionModel->insert($prescriptionData);
		
		if ($result) {
			return $this->response->setJSON([
				'success' => true,
				'message' => 'Prescription created successfully!',
				'prescription_id' => $prescriptionData['prescription_id']
			]);
		} else {
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Failed to create prescription. Please try again.'
			]);
		}
	}

	public function startConsultation()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$appointmentId = $this->request->getPost('appointment_id');
		$patientId = $this->request->getPost('patient_id');
		
		$appointmentModel = new \App\Models\AppointmentModel();
		$patientModel = new \App\Models\PatientModel();
		$consultationModel = new \App\Models\ConsultationModel();
		
		// Get appointment and patient details
		$appointment = $appointmentModel->find($appointmentId);
		$patient = $patientModel->find($patientId);
		
		if (!$appointment || !$patient) {
			return $this->response->setJSON(['success' => false, 'message' => 'Appointment or patient not found.']);
		}
		
		// Check if consultation already exists
		$existingConsultation = $consultationModel->where('appointment_id', $appointmentId)->first();
		if ($existingConsultation) {
			return $this->response->setJSON(['success' => false, 'message' => 'Consultation already exists for this appointment.']);
		}
		
		// Create new consultation
		$consultationData = [
			'appointment_id' => $appointmentId,
			'patient_id' => $patientId,
			'patient_name' => $patient['first_name'] . ' ' . $patient['last_name'],
			'patient_id_formatted' => $patient['patient_id'] ?? 'P-' . date('Y') . '-' . str_pad($patient['id'], 3, '0', STR_PAD_LEFT),
			'doctor_id' => session('user_id'),
			'doctor_name' => session('user_name'),
			'consultation_type' => $appointment['type'] ?? 'Initial Consultation',
			'date_time' => $appointment['date_time'],
			'duration' => 60, // Default duration
			'status' => 'In Progress',
			'blood_pressure' => '120/80',
			'heart_rate' => '72 bpm',
			'temperature' => '36.5°C',
			'weight' => '70 kg',
		];
		
		$consultationId = $consultationModel->insert($consultationData);
		
		if ($consultationId) {
			// Update appointment status
			$appointmentModel->update($appointmentId, ['status' => 'In Progress']);
			
			return $this->response->setJSON([
				'success' => true,
				'message' => 'Consultation started successfully!',
				'consultation_id' => $consultationId
			]);
		} else {
			return $this->response->setJSON([
				'success' => false,
				'message' => 'Failed to start consultation. Please try again.'
			]);
		}
	}

	public function saveConsultation()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$consultationModel = new \App\Models\ConsultationModel();
		$patientModel = new \App\Models\PatientModel();
		
		// Get form data from the modal
		$patientId = $this->request->getPost('patient_id');
		$consultationType = $this->request->getPost('consultation_type');
		$chiefComplaint = $this->request->getPost('chief_complaint');
		$dateTime = $this->request->getPost('date_time');
		$duration = $this->request->getPost('duration');
		$notes = $this->request->getPost('notes');
		
		// Log the received data for debugging
		log_message('info', 'Save consultation - Received data: ' . json_encode([
			'patient_id' => $patientId,
			'consultation_type' => $consultationType,
			'chief_complaint' => $chiefComplaint,
			'date_time' => $dateTime,
			'duration' => $duration,
			'notes' => $notes
		]));
		
		// Validate required fields
		if (!$patientId || !$consultationType || !$dateTime) {
			log_message('error', 'Save consultation - Missing required fields: patient_id=' . $patientId . ', consultation_type=' . $consultationType . ', date_time=' . $dateTime);
			return $this->response->setJSON(['success' => false, 'message' => 'Missing required fields.']);
		}
		
		// Get patient details
		$patient = $patientModel->find($patientId);
		if (!$patient) {
			log_message('error', 'Save consultation - Patient not found: ' . $patientId);
			return $this->response->setJSON(['success' => false, 'message' => 'Patient not found.']);
		}
		
		// Find existing appointment for this patient and doctor
		$appointmentModel = new \App\Models\AppointmentModel();
		$existingAppointment = null;
		
		// Only try to find appointment if the appointments table has the patient_id column
		try {
			$existingAppointment = $appointmentModel->where('patient_id', $patientId)
				->where('doctor_id', session('user_id'))
				->where('status', 'Confirmed')
				->orderBy('date_time', 'DESC')
				->first();
		} catch (\Exception $e) {
			log_message('info', 'Save consultation - No existing appointment found or appointments table not properly configured: ' . $e->getMessage());
			// Continue without appointment - this is fine for direct consultations
		}
		
		// Create new consultation
		$consultationData = [
			'patient_id' => $patientId,
			'patient_name' => $patient['first_name'] . ' ' . $patient['last_name'],
			'patient_id_formatted' => $patient['patient_id'] ?? 'P-' . date('Y') . '-' . str_pad($patient['id'], 3, '0', STR_PAD_LEFT),
			'doctor_id' => session('user_id'),
			'doctor_name' => session('user_name'),
			'consultation_type' => $consultationType,
			'date_time' => $dateTime,
			'duration' => $duration ?: 30,
			'status' => 'Active',
			'chief_complaint' => $chiefComplaint,
			'notes' => $notes,
			// Link to appointment if found
			'appointment_id' => $existingAppointment ? $existingAppointment['id'] : null,
			// Set default values for medical fields
			'blood_pressure' => '120/80',
			'heart_rate' => '72 bpm',
			'temperature' => '36.5°C',
			'weight' => '70 kg',
		];
		
		log_message('info', 'Save consultation - Attempting to insert: ' . json_encode($consultationData));
		
		try {
			$consultationId = $consultationModel->insert($consultationData);
			
			if ($consultationId) {
				log_message('info', 'Save consultation - Successfully created consultation with ID: ' . $consultationId);
				
				return $this->response->setJSON([
					'success' => true, 
					'message' => 'Consultation created successfully!',
					'consultation_id' => $consultationId
				]);
			} else {
				log_message('error', 'Save consultation - Failed to insert consultation data');
				return $this->response->setJSON(['success' => false, 'message' => 'Failed to create consultation.']);
			}
		} catch (\Exception $e) {
			log_message('error', 'Save consultation - Exception: ' . $e->getMessage());
			return $this->response->setJSON(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
		}
	}

	public function completeConsultation()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$consultationId = $this->request->getPost('consultation_id');
		
		$consultationModel = new \App\Models\ConsultationModel();
		$appointmentModel = new \App\Models\AppointmentModel();
		
		// Get consultation
		$consultation = $consultationModel->find($consultationId);
		if (!$consultation) {
			return $this->response->setJSON(['success' => false, 'message' => 'Consultation not found.']);
		}
		
		// Check if this consultation belongs to the logged-in doctor
		if ($consultation['doctor_id'] != session('user_id')) {
			return $this->response->setJSON(['success' => false, 'message' => 'You can only update your own consultations.']);
		}
		
		// Update consultation status
		$consultationModel->update($consultationId, ['status' => 'Completed']);
		
		// Update appointment status if it exists
		if ($consultation['appointment_id']) {
			$appointmentModel->update($consultation['appointment_id'], ['status' => 'Completed']);
		}
		
		return $this->response->setJSON(['success' => true, 'message' => 'Consultation completed successfully!']);
	}

	public function getConsultationDetails($id)
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$consultationModel = new \App\Models\ConsultationModel();
		$consultation = $consultationModel->find($id);
		
		if (!$consultation) {
			return $this->response->setJSON(['success' => false, 'message' => 'Consultation not found.']);
		}
		
		// Check if this consultation belongs to the logged-in doctor
		if ($consultation['doctor_id'] != session('user_id')) {
			return $this->response->setJSON(['success' => false, 'message' => 'You can only view your own consultations.']);
		}
		
		return $this->response->setJSON(['success' => true, 'consultation' => $consultation]);
	}

	public function getAppointmentDetails($appointmentId)
	{
		if (! session('isLoggedIn')) return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
		if (session('role') && session('role') !== 'doctor') return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
		
		$appointmentModel = new \App\Models\AppointmentModel();
		$appointment = $appointmentModel->find($appointmentId);
		
		if (!$appointment) {
			return $this->response->setJSON(['success' => false, 'message' => 'Appointment not found']);
		}
		
		return $this->response->setJSON(['success' => true, 'appointment' => $appointment]);
	}

	public function getPatientConsultations($patientId)
	{
		if (! session('isLoggedIn')) return $this->response->setJSON(['success' => false, 'message' => 'Not authenticated']);
		
		// Allow both doctors and admins to access this method
		if (session('role') && !in_array(session('role'), ['doctor', 'admin'])) {
			return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized access']);
		}
		
		$consultationModel = new \App\Models\ConsultationModel();
		$userModel = new \App\Models\UserModel();
		
		// Get all consultations for the patient with appointment details (including room)
		$consultations = $consultationModel->select('consultations.*, patients.first_name, patients.last_name, patients.phone, appointments.appointment_code, appointments.room')
			->join('patients', 'patients.id = consultations.patient_id', 'left')
			->join('appointments', 'appointments.id = consultations.appointment_id', 'left')
			->where('consultations.patient_id', $patientId)
			->orderBy('consultations.date_time', 'DESC')
			->findAll();
		
		// Get doctor names for each consultation
		foreach ($consultations as &$consultation) {
			if ($consultation['doctor_id']) {
				$doctor = $userModel->find($consultation['doctor_id']);
				$consultation['doctor_name'] = $doctor ? $doctor['name'] : 'Unknown';
			} else {
				$consultation['doctor_name'] = 'Unknown';
			}
		}
		
		return $this->response->setJSON([
			'success' => true, 
			'consultations' => $consultations
		]);
	}

	// Medical Certificates Methods
	public function medicalCertificates()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$medicalCertificateModel = new \App\Models\MedicalCertificateModel();
		$doctorName = session('user_name');
		
		$certificates = $medicalCertificateModel->getByDoctor($doctorName);
		$stats = $medicalCertificateModel->getDoctorCertificateStats($doctorName);
		
		return view('auth/doctor_medical_certificates', [
			'certificates' => $certificates,
			'stats' => $stats
		]);
	}

	public function createMedicalCertificate()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$patientModel = new \App\Models\PatientModel();
		$patients = $patientModel->orderBy('first_name', 'ASC')->findAll();
		
		return view('auth/doctor_create_medical_certificate', ['patients' => $patients]);
	}

	public function storeMedicalCertificate()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$medicalCertificateModel = new \App\Models\MedicalCertificateModel();
		$patientModel = new \App\Models\PatientModel();
		
		$patientId = $this->request->getPost('patient_id');
		$patient = $patientModel->find($patientId);
		
		if (!$patient) {
			return redirect()->back()->with('error', 'Patient not found.');
		}
		
		$certificateData = [
			'certificate_id' => $medicalCertificateModel->generateCertificateId(),
			'patient_id' => $patientId,
			'patient_name' => $patient['first_name'] . ' ' . $patient['last_name'],
			'patient_age' => $patient['dob'] ? date_diff(date_create($patient['dob']), date_create('today'))->y : 0,
			'patient_gender' => $patient['gender'],
			'patient_address' => $patient['address'],
			'doctor_id' => session('user_id'),
			'doctor_name' => session('user_name'),
			'doctor_license' => '114072', // Default license number
			'issue_date' => $this->request->getPost('issue_date'),
			'diagnosis' => $this->request->getPost('diagnosis'),
			'medications' => $this->request->getPost('medications'),
			'pregnancy_details' => $this->request->getPost('pregnancy_details'),
			'lmp' => $this->request->getPost('lmp'),
			'edd' => $this->request->getPost('edd'),
			'notes' => $this->request->getPost('notes'),
			'status' => 'Active'
		];
		
		$result = $medicalCertificateModel->insert($certificateData);
		
		if ($result) {
			return redirect()->to('/doctor/medical-certificates')->with('message', 'Medical certificate created successfully!');
		} else {
			return redirect()->back()->with('error', 'Failed to create medical certificate.');
		}
	}

	public function viewMedicalCertificate($id)
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$medicalCertificateModel = new \App\Models\MedicalCertificateModel();
		$certificate = $medicalCertificateModel->find($id);
		
		if (!$certificate) {
			return redirect()->to('/doctor/medical-certificates')->with('error', 'Medical certificate not found.');
		}
		
		return view('auth/doctor_view_medical_certificate', ['certificate' => $certificate]);
	}

	public function printMedicalCertificate($id)
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		
		$medicalCertificateModel = new \App\Models\MedicalCertificateModel();
		$certificate = $medicalCertificateModel->find($id);
		
		if (!$certificate) {
			return redirect()->to('/doctor/medical-certificates')->with('error', 'Medical certificate not found.');
		}
		
		return view('auth/doctor_print_medical_certificate', ['certificate' => $certificate]);
	}
}


