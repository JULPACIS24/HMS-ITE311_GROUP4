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