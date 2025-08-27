<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'doctor_id' => 1,
                'patient_id' => 1,
                'title' => 'Regular Checkup',
                'type' => 'appointment',
                'date' => date('Y-m-d'),
                'start_time' => '09:00:00',
                'end_time' => '09:30:00',
                'room' => 'Room 101',
                'description' => 'Annual physical examination',
                'status' => 'scheduled',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'doctor_id' => 1,
                'patient_id' => 2,
                'title' => 'Surgery - Appendectomy',
                'type' => 'surgery',
                'date' => date('Y-m-d'),
                'start_time' => '14:00:00',
                'end_time' => '16:00:00',
                'room' => 'OR 1',
                'description' => 'Emergency appendectomy procedure',
                'status' => 'scheduled',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'doctor_id' => 1,
                'patient_id' => null,
                'title' => 'Ward Rounds',
                'type' => 'ward_rounds',
                'date' => date('Y-m-d'),
                'start_time' => '10:00:00',
                'end_time' => '11:00:00',
                'room' => 'Ward A',
                'description' => 'Daily ward rounds for patient monitoring',
                'status' => 'scheduled',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'doctor_id' => 1,
                'patient_id' => null,
                'title' => 'Lunch Break',
                'type' => 'blocked',
                'date' => date('Y-m-d'),
                'start_time' => '12:00:00',
                'end_time' => '13:00:00',
                'room' => null,
                'description' => 'Lunch break',
                'status' => 'scheduled',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'doctor_id' => 1,
                'patient_id' => 3,
                'title' => 'Follow-up Consultation',
                'type' => 'appointment',
                'date' => date('Y-m-d', strtotime('+1 day')),
                'start_time' => '08:30:00',
                'end_time' => '09:00:00',
                'room' => 'Room 102',
                'description' => 'Post-surgery follow-up',
                'status' => 'scheduled',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('schedules')->insertBatch($data);
    }
}
