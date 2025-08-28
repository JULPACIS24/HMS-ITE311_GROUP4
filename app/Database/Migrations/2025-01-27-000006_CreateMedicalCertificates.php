<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMedicalCertificates extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'certificate_id' => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'patient_id' => ['type' => 'VARCHAR', 'constraint' => 20],
            'patient_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'patient_age' => ['type' => 'INT', 'constraint' => 3],
            'patient_gender' => ['type' => 'VARCHAR', 'constraint' => 10],
            'patient_address' => ['type' => 'TEXT'],
            'doctor_id' => ['type' => 'INT', 'constraint' => 11],
            'doctor_name' => ['type' => 'VARCHAR', 'constraint' => 255],
            'doctor_license' => ['type' => 'VARCHAR', 'constraint' => 50],
            'issue_date' => ['type' => 'DATE'],
            'diagnosis' => ['type' => 'TEXT'],
            'medications' => ['type' => 'TEXT'],
            'pregnancy_details' => ['type' => 'TEXT', 'null' => true],
            'lmp' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'edd' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'notes' => ['type' => 'TEXT', 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['Active', 'Inactive'], 'default' => 'Active'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('patient_id');
        $this->forge->addKey('doctor_id');
        $this->forge->createTable('medical_certificates');
    }

    public function down()
    {
        $this->forge->dropTable('medical_certificates');
    }
}
