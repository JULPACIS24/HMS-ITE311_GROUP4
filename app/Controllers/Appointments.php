<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AppointmentModel;

class Appointments extends BaseController
{
	public function index()
	{
		if (! session('isLoggedIn')) {
			return redirect()->to('/login');
		}

		$model = new AppointmentModel();
		$data['appointments'] = $model->orderBy('date_time', 'ASC')->findAll();

		return view('auth/appointments', $data);
	}

	public function create()
	{
		if (! session('isLoggedIn')) {
			return redirect()->to('/login');
		}

		return view('auth/appointments_form');
	}

	public function store()
	{
		if (! session('isLoggedIn')) {
			return redirect()->to('/login');
		}

		$rules = [
			'patient_name' => 'required|min_length[3]',
			'doctor_name'  => 'required|min_length[3]',
			'date'         => 'required',
			'time'         => 'required',
			'type'         => 'required',
			'status'       => 'required|in_list[Confirmed,Pending,Completed]'
		];

		if (! $this->validate($rules)) {
			return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
		}

		$model = new AppointmentModel();
		$model->insert([
			'appointment_code' => $this->request->getPost('appointment_code') ?: null,
			'patient_name'     => $this->request->getPost('patient_name'),
			'patient_phone'    => $this->request->getPost('patient_phone'),
			'doctor_name'      => $this->request->getPost('doctor_name'),
			'date_time'        => $this->request->getPost('date') . ' ' . $this->request->getPost('time'),
			'type'             => $this->request->getPost('type'),
			'status'           => $this->request->getPost('status'),
			'notes'            => $this->request->getPost('notes'),
		]);

		return redirect()->to('/appointments')->with('message', 'Appointment scheduled.');
	}

	public function updateStatus($id)
	{
		$model = new AppointmentModel();
		$status = $this->request->getPost('status');
		if (in_array($status, ['Confirmed', 'Pending', 'Completed'], true)) {
			$model->update($id, ['status' => $status]);
		}
		return redirect()->to('/appointments');
	}

	public function delete($id)
	{
		$model = new AppointmentModel();
		$model->delete($id);
		return redirect()->to('/appointments');
	}

	public function view($id)
	{
		$model = new AppointmentModel();
		$data['appointment'] = $model->find($id);
		return view('auth/appointment_view', $data);
	}

	public function edit($id)
	{
		$model = new AppointmentModel();
		$data['appointment'] = $model->find($id);
		return view('auth/appointment_edit', $data);
	}

	public function update($id)
	{
		$model = new AppointmentModel();
		$model->update($id, [
			'patient_name'  => $this->request->getPost('patient_name'),
			'patient_phone' => $this->request->getPost('patient_phone'),
			'doctor_name'   => $this->request->getPost('doctor_name'),
			'date_time'     => $this->request->getPost('date') . ' ' . $this->request->getPost('time'),
			'type'          => $this->request->getPost('type'),
			'status'        => $this->request->getPost('status'),
			'notes'         => $this->request->getPost('notes'),
		]);
		return redirect()->to('/appointments');
	}

	public function json($id)
	{
		$this->response->setContentType('application/json');
		$model = new AppointmentModel();
		$a = $model->find($id);
		return $this->response->setJSON($a ?? []);
	}
}


