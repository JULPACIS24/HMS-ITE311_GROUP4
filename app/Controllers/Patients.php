<?php
namespace App\Controllers;

class Patients extends BaseController
{
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        $model = new \App\Models\PatientModel();
        $data['patients'] = $model->orderBy('id', 'ASC')->findAll();
        // Default landing: Patient Records page (list + details)
        return view('auth/patient_records', $data);
    }
    
    public function add()
    {
        // Registration multi-step UI
        return view('auth/patient_registration');
    }
    
    public function view($id)
    {
        $model = new \App\Models\PatientModel();
        $data['patient'] = $model->find($id);
        return view('auth/patient_view', $data);
    }

    public function history()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        $model = new \App\Models\PatientModel();
        $data['patients'] = $model->orderBy('id', 'ASC')->findAll();
        return view('auth/medical_history', $data);
    }

    public function management()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        // Get real patient data from database
        $model = new \App\Models\PatientModel();
        $data['patients'] = $model->orderBy('id', 'ASC')->findAll();
        // This will render the new Patient Management dashboard
        return view('auth/patient_management', $data);
    }

    public function store()
    {
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
        $model->insert([
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
        $newId = $model->getInsertID();
        // After successful registration, go to Patient Records and highlight the new patient
        return redirect()->to('/patients/records')->with('message', 'Patient added.')->with('new_patient_id', $newId);
    }

    public function storeRegistration()
    {
        // Handle AJAX request from the multi-step registration form
        if ($this->request->isAJAX()) {
            try {
                $rules = [
                    'firstName' => 'required|min_length[2]',
                    'lastName'  => 'required|min_length[2]',
                    'dateOfBirth' => 'required',
                    'gender'     => 'required',
                    'phoneNumber' => 'required',
                    'address'    => 'required',
                    'city'       => 'required',
                    'emergencyName' => 'required',
                    'emergencyPhone' => 'required',
                ];

                if (!$this->validate($rules)) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Please fill in all required fields.',
                        'errors' => $this->validator->getErrors()
                    ]);
                }

                $model = new \App\Models\PatientModel();
                
                // Calculate age from date of birth
                $dob = new \DateTime($this->request->getPost('dateOfBirth'));
                $today = new \DateTime();
                $age = $today->diff($dob)->y;
                
                $patientData = [
                    'first_name' => $this->request->getPost('firstName'),
                    'middle_name' => $this->request->getPost('middleName'),
                    'last_name' => $this->request->getPost('lastName'),
                    'dob' => $this->request->getPost('dateOfBirth'),
                    'age' => $age,
                    'gender' => $this->request->getPost('gender'),
                    'civil_status' => $this->request->getPost('civilStatus'),
                    'nationality' => $this->request->getPost('nationality'),
                    'religion' => $this->request->getPost('religion'),
                    'phone' => $this->request->getPost('phoneNumber'),
                    'email' => $this->request->getPost('emailAddress'),
                    'address' => $this->request->getPost('address'),
                    'city' => $this->request->getPost('city'),
                    'province' => $this->request->getPost('province'),
                    'zip_code' => $this->request->getPost('zipCode'),
                    'blood_type' => $this->request->getPost('bloodType'),
                    'allergies' => $this->request->getPost('allergies'),
                    'current_medications' => $this->request->getPost('currentMedications'),
                    'medical_history' => $this->request->getPost('medicalHistory'),
                    'emergency_name' => $this->request->getPost('emergencyName'),
                    'emergency_relationship' => $this->request->getPost('emergencyRelationship'),
                    'emergency_phone' => $this->request->getPost('emergencyPhone'),
                    'insurance_provider' => $this->request->getPost('insuranceProvider'),
                    'insurance_policy_number' => $this->request->getPost('insuranceNumber'),
                    'policy_holder_name' => $this->request->getPost('policyHolder'),
                ];

                $newId = $model->insert($patientData);
                
                if ($newId) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Patient registered successfully!',
                        'patient_id' => $newId,
                        'redirect_url' => site_url('patient-management')
                    ]);
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to register patient. Please try again.'
                    ]);
                }
                
            } catch (\Exception $e) {
                log_message('error', 'Patient registration error: ' . $e->getMessage());
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'An error occurred during registration. Please try again.'
                ]);
            }
        }
        
        // If not AJAX, redirect to registration form
        return redirect()->to('/patients/add');
    }

    public function edit($id)
    {
        $model = new \App\Models\PatientModel();
        $data['patient'] = $model->find($id);
        if (! $data['patient']) {
            // Fallback to blank form if record doesn't exist yet (demo data in table is static)
            $data['patient'] = [
                'id' => (int) $id,
                'first_name' => '',
                'last_name' => '',
                'dob' => '',
                'gender' => 'Male',
                'phone' => '',
                'email' => '',
                'address' => '',
                'blood_type' => '',
                'emergency_name' => '',
                'emergency_phone' => '',
                'medical_history' => '',
                'allergies' => '',
            ];
        }
        return view('auth/edit_patient', $data);
    }

    public function update($id)
    {
        $model = new \App\Models\PatientModel();
        $payload = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'dob'        => $this->request->getPost('dob'),
            'gender'     => $this->request->getPost('gender'),
            'phone'      => $this->request->getPost('phone'),
            'email'      => $this->request->getPost('email'),
            'address'    => $this->request->getPost('address'),
            'blood_type' => $this->request->getPost('blood_type'),
            'emergency_name'  => $this->request->getPost('emergency_name'),
            'emergency_phone' => $this->request->getPost('emergency_phone'),
            'medical_history' => $this->request->getPost('medical_history'),
            'allergies'       => $this->request->getPost('allergies'),
        ];
        // Remove null/empty keys so partial updates (email/phone only) won't wipe other fields
        $data = array_filter($payload, static fn($v) => $v !== null && $v !== '');
        if (! empty($data)) {
            $model->update($id, $data);
        }
        return redirect()->to('/patients');
    }

    public function delete($id)
    {
        $model = new \App\Models\PatientModel();
        $model->delete($id);
        return redirect()->to('/patients');
    }

    public function json($id)
    {
        $this->response->setContentType('application/json');
        $model = new \App\Models\PatientModel();
        $patient = $model->find($id);
        return $this->response->setJSON($patient ?? []);
    }
}