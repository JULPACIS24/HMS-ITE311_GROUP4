<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConsultations extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'appointment_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'patient_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'patient_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'patient_id_formatted' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'doctor_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'doctor_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'consultation_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'Initial Consultation',
            ],
            'date_time' => [
                'type' => 'DATETIME',
            ],
            'duration' => [
                'type'       => 'INT',
                'constraint' => 11,
                'comment'    => 'Duration in minutes',
                'default'    => 60,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Scheduled', 'In Progress', 'Completed', 'Cancelled'],
                'default'    => 'Scheduled',
            ],
            'chief_complaint' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'history_of_present_illness' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'physical_examination' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'diagnosis' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'treatment_plan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'prescriptions' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'follow_up_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'follow_up_notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'blood_pressure' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'heart_rate' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'temperature' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'weight' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'height' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('appointment_id', 'appointments', 'id', 'CASCADE', 'SET NULL');
        $this->forge->addForeignKey('patient_id', 'patients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('doctor_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('consultations');
    }

    public function down()
    {
        $this->forge->dropTable('consultations');
    }
}
