<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMissingPatientFields extends Migration
{
    public function up()
    {
        $fields = [
            'middle_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'first_name'
            ],
            'age' => [
                'type' => 'INT',
                'constraint' => 3,
                'null' => true,
                'after' => 'dob'
            ],
            'civil_status' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'gender'
            ],
            'nationality' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'civil_status'
            ],
            'religion' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'nationality'
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'address'
            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'city'
            ],
            'zip_code' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'province'
            ],
            'emergency_relationship' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'emergency_name'
            ],
            'current_medications' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'allergies'
            ],
            'insurance_provider' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'current_medications'
            ],
            'insurance_policy_number' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'insurance_provider'
            ],
            'policy_holder_name' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => true,
                'after' => 'insurance_policy_number'
            ]
        ];

        foreach ($fields as $fieldName => $fieldConfig) {
            if (!$this->db->fieldExists($fieldName, 'patients')) {
                $this->forge->addColumn('patients', [$fieldName => $fieldConfig]);
            }
        }
    }

    public function down()
    {
        $fields = [
            'middle_name', 'age', 'civil_status', 'nationality', 'religion',
            'city', 'province', 'zip_code', 'emergency_relationship',
            'current_medications', 'insurance_provider', 'insurance_policy_number',
            'policy_holder_name'
        ];

        foreach ($fields as $fieldName) {
            if ($this->db->fieldExists($fieldName, 'patients')) {
                $this->forge->dropColumn('patients', $fieldName);
            }
        }
    }
}
