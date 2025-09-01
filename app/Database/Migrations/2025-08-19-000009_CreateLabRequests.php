<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLabRequests extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'lab_id' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'patient_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'patient_id' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'doctor_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'tests' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'priority' => [
                'type' => 'ENUM',
                'constraint' => ['Routine', 'Urgent', 'STAT'],
                'default' => 'Routine',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Pending', 'In Progress', 'Completed', 'Cancelled'],
                'default' => 'Pending',
            ],
            'expected_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'clinical_notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('lab_id', false, true); // Unique key
        $this->forge->addKey('patient_id', false);
        $this->forge->addKey('doctor_name', false);
        $this->forge->addKey('status', false);
        $this->forge->addKey('priority', false);
        $this->forge->addKey('expected_date', false);

        $this->forge->createTable('lab_requests');
    }

    public function down()
    {
        $this->forge->dropTable('lab_requests');
    }
}
