<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PatientSeeder extends Seeder
{
	public function run()
	{
		$data = [
			[
				'first_name' => 'Yad',
				'last_name'  => 'Mohamd',
				'dob'        => '1990-05-15',
				'gender'     => 'Male',
				'phone'      => '09123456789',
				'email'      => 'yad.mohamd@email.com',
				'address'    => '123 Main Street, City',
				'blood_type' => 'O+',
				'emergency_name'  => 'Ahmed Mohamd',
				'emergency_phone' => '09187654321',
				'medical_history' => 'None',
				'allergies'       => 'None',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'first_name' => 'Maria',
				'last_name'  => 'Santos',
				'dob'        => '1985-08-22',
				'gender'     => 'Female',
				'phone'      => '09234567890',
				'email'      => 'maria.santos@email.com',
				'address'    => '456 Oak Avenue, Town',
				'blood_type' => 'A+',
				'emergency_name'  => 'Juan Santos',
				'emergency_phone' => '09234567891',
				'medical_history' => 'Hypertension',
				'allergies'       => 'Penicillin',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'first_name' => 'John',
				'last_name'  => 'Doe',
				'dob'        => '1992-03-10',
				'gender'     => 'Male',
				'phone'      => '09345678901',
				'email'      => 'john.doe@email.com',
				'address'    => '789 Pine Street, Village',
				'blood_type' => 'B+',
				'emergency_name'  => 'Jane Doe',
				'emergency_phone' => '09345678902',
				'medical_history' => 'Diabetes Type 2',
				'allergies'       => 'None',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
			[
				'first_name' => 'Sarah',
				'last_name'  => 'Wilson',
				'dob'        => '1988-12-05',
				'gender'     => 'Female',
				'phone'      => '09456789012',
				'email'      => 'sarah.wilson@email.com',
				'address'    => '321 Elm Road, Borough',
				'blood_type' => 'AB+',
				'emergency_name'  => 'Robert Wilson',
				'emergency_phone' => '09456789013',
				'medical_history' => 'Asthma',
				'allergies'       => 'Dust, Pollen',
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			],
		];

		$this->db->table('patients')->insertBatch($data);
	}
}
