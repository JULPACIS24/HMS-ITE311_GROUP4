<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixAppointmentsTable extends Migration
{
    public function up()
    {
        // Add missing columns
        $this->forge->addColumn('appointments', [
            'patient_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'after' => 'id'
            ],
            'doctor_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'after' => 'patient_id'
            ]
        ]);

        // Add indexes for better performance
        $this->forge->addKey('patient_id');
        $this->forge->addKey('doctor_id');
    }

    public function down()
    {
        // Remove the added columns
        $this->forge->dropColumn('appointments', ['patient_id', 'doctor_id']);
    }
}
