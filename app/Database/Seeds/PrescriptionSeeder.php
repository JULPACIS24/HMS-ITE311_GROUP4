<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PrescriptionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'prescription_id' => 'RX-2024-001',
                'patient_name' => 'John Dela Cruz',
                'patient_id' => 'P-000001',
                'doctor_name' => 'Dr. Maria Santos',
                'doctor_id' => 1,
                'diagnosis' => 'Hypertension and Diabetes',
                'medications' => json_encode([
                    [
                        'name' => 'Paracetamol',
                        'dosage' => '500mg',
                        'frequency' => 'Every 6 hours',
                        'duration' => '7 days'
                    ],
                    [
                        'name' => 'Amoxicillin',
                        'dosage' => '250mg',
                        'frequency' => 'Three times daily',
                        'duration' => '7 days'
                    ]
                ]),
                'notes' => 'Take with food. Monitor blood pressure regularly.',
                'status' => 'Pending',
                'total_amount' => 425.50,
                'insurance_covered' => 'Yes',
                'created_date' => '2024-01-15 10:30:00',
                'updated_at' => '2024-01-15 10:30:00'
            ],
            [
                'prescription_id' => 'RX-2024-002',
                'patient_name' => 'Maria Garcia',
                'patient_id' => 'P-000002',
                'doctor_name' => 'Dr. Carlos Martinez',
                'doctor_id' => 2,
                'diagnosis' => 'Upper Respiratory Infection',
                'medications' => json_encode([
                    [
                        'name' => 'Ibuprofen',
                        'dosage' => '400mg',
                        'frequency' => 'Every 8 hours',
                        'duration' => '5 days'
                    ]
                ]),
                'notes' => 'Rest well and stay hydrated.',
                'status' => 'Ready for Pickup',
                'total_amount' => 150.00,
                'insurance_covered' => 'Yes',
                'created_date' => '2024-01-16 14:20:00',
                'updated_at' => '2024-01-16 15:30:00'
            ],
            [
                'prescription_id' => 'RX-2024-003',
                'patient_name' => 'Roberto Santos',
                'patient_id' => 'P-000003',
                'doctor_name' => 'Dr. Ana Lopez',
                'doctor_id' => 3,
                'diagnosis' => 'Chronic Back Pain',
                'medications' => json_encode([
                    [
                        'name' => 'Metformin',
                        'dosage' => '500mg',
                        'frequency' => 'Twice daily',
                        'duration' => '30 days'
                    ],
                    [
                        'name' => 'Atorvastatin',
                        'dosage' => '20mg',
                        'frequency' => 'Once daily',
                        'duration' => '30 days'
                    ]
                ]),
                'notes' => 'Take Metformin with meals. Monitor blood sugar levels.',
                'status' => 'Pending',
                'total_amount' => 750.25,
                'insurance_covered' => 'Partial',
                'created_date' => '2024-01-17 09:15:00',
                'updated_at' => '2024-01-17 09:15:00'
            ]
        ];

        $this->db->table('prescriptions')->insertBatch($data);
    }
}
