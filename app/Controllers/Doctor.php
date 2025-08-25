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
		return view('auth/doctor_prescriptions');
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
		return view('auth/doctor_consultations');
	}

	public function schedule()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		return view('auth/doctor_schedule');
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
}

?>


