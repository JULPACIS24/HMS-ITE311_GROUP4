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
		return view('auth/doctor_patients');
	}

	public function appointments()
	{
		if (! session('isLoggedIn')) return redirect()->to('/login');
		if (session('role') && session('role') !== 'doctor') return redirect()->to('/dashboard');
		return view('auth/doctor_appointments');
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
		return view('auth/doctor_lab_requests');
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
}

?>


