<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AppointmentsSeeder extends Seeder
{
	public function run()
	{
		$data = [
			[
				'appointment_code' => 'APT001',
				'patient_name'     => 'Sarah Johnson',
				'patient_phone'    => '+1 (555) 123-4567',
				'doctor_name'      => 'Dr. Smith',
				'date_time'        => date('Y-m-d 09:00:00'),
				'type'             => 'Consultation',
				'status'           => 'Confirmed',
			],
			[
				'appointment_code' => 'APT002',
				'patient_name'     => 'Michael Brown',
				'patient_phone'    => '+1 (555) 234-5678',
				'doctor_name'      => 'Dr. Wilson',
				'date_time'        => date('Y-m-d 10:30:00'),
				'type'             => 'Follow-up',
				'status'           => 'Pending',
			],
			[
				'appointment_code' => 'APT003',
				'patient_name'     => 'Emily Davis',
				'patient_phone'    => '+1 (555) 345-6789',
				'doctor_name'      => 'Dr. Johnson',
				'date_time'        => date('Y-m-d 14:00:00'),
				'type'             => 'Checkup',
				'status'           => 'Completed',
			],
			[
				'appointment_code' => 'APT004',
				'patient_name'     => 'James Wilson',
				'patient_phone'    => '+1 (555) 456-7890',
				'doctor_name'      => 'Dr. Anderson',
				'date_time'        => date('Y-m-d 11:00:00', strtotime('+1 day')),
				'type'             => 'Emergency',
				'status'           => 'Confirmed',
			],
		];

		$this->db->table('appointments')->insertBatch($data);
	}
}


