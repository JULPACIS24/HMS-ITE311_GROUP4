<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'San Miguel Hospital - Main Campus',
                'location' => 'General Santos City, South Cotabato',
                'type' => 'Main Hospital',
                'bed_capacity' => 200,
                'manager_name' => 'Dr. Maria Santos',
                'contact_number' => '+63 912 345 6789',
                'email' => 'main@sanmiguelhms.com',
                'address' => '123 Hospital Drive, General Santos City, South Cotabato',
                'status' => 'Active',
                'opening_hours' => '24/7',
                'departments' => json_encode(['emergency', 'cardiology', 'pediatrics', 'laboratory', 'pharmacy', 'radiology', 'surgery']),
                'monthly_revenue' => 2850000.00,
                'total_staff' => 131,
                'total_patients' => 1847,
                'occupancy_rate' => 87.50,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'San Miguel Clinic - Downtown',
                'location' => 'Pioneer Avenue, General Santos City',
                'type' => 'Outpatient Clinic',
                'bed_capacity' => 25,
                'manager_name' => 'Dr. Juan Martinez',
                'contact_number' => '+63 912 345 6790',
                'email' => 'downtown@sanmiguelhms.com',
                'address' => '456 Pioneer Avenue, General Santos City',
                'status' => 'Active',
                'opening_hours' => 'Mon-Sat 8AM-8PM',
                'departments' => json_encode(['pediatrics', 'laboratory', 'pharmacy']),
                'monthly_revenue' => 485000.00,
                'total_staff' => 28,
                'total_patients' => 456,
                'occupancy_rate' => 75.20,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'San Miguel Emergency Center',
                'location' => 'Dadiangas Heights, General Santos City',
                'type' => 'Emergency Center',
                'bed_capacity' => 45,
                'manager_name' => 'Dr. Ana Rodriguez',
                'contact_number' => '+63 912 345 6791',
                'email' => 'emergency@sanmiguelhms.com',
                'address' => '789 Dadiangas Heights, General Santos City',
                'status' => 'Active',
                'opening_hours' => '24/7',
                'departments' => json_encode(['emergency', 'laboratory']),
                'monthly_revenue' => 725000.00,
                'total_staff' => 42,
                'total_patients' => 678,
                'occupancy_rate' => 92.30,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'San Miguel Hospital - Davao Branch',
                'location' => 'Davao City, Davao del Sur',
                'type' => 'Branch Hospital',
                'bed_capacity' => 150,
                'manager_name' => 'TBA',
                'contact_number' => '+63 912 345 6792',
                'email' => 'davao@sanmiguelhms.com',
                'address' => '321 Davao Street, Davao City, Davao del Sur',
                'status' => 'Under Construction',
                'opening_hours' => 'TBA',
                'departments' => json_encode([]),
                'monthly_revenue' => 0.00,
                'total_staff' => 0,
                'total_patients' => 0,
                'occupancy_rate' => 0.00,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('branches')->insertBatch($data);
    }
}
