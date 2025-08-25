<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PharmacistSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Maria Santos',
                'email' => 'maria.santos@hms.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'pharmacist',
                'department' => 'Pharmacy',
                'status' => 'active',
                'specialty' => 'Clinical Pharmacy'
            ],
            [
                'name' => 'Juan Dela Cruz',
                'email' => 'juan.delacruz@hms.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'pharmacist',
                'department' => 'Pharmacy',
                'status' => 'active',
                'specialty' => 'Hospital Pharmacy'
            ],
            [
                'name' => 'Ana Rodriguez',
                'email' => 'ana.rodriguez@hms.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'pharmacist',
                'department' => 'Pharmacy',
                'status' => 'active',
                'specialty' => 'Compounding Pharmacy'
            ]
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
