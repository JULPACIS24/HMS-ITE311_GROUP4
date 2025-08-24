<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddInsuranceFieldsToPatients extends Migration
{
    public function up()
    {
        // Add insurance fields to patients table
        // Insurance providers: PhilHealth, Maxicare, Intellicare
        $this->forge->addColumn('patients', [
            'philhealth_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'emergency_phone'
            ],
            'philhealth_category' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'philhealth_number'
            ],
            'insurance_provider' => [
                'type' => 'ENUM',
                'constraint' => "'PhilHealth','Maxicare','Intellicare'",
                'null' => true,
                'after' => 'philhealth_category'
            ],
            'insurance_policy_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'insurance_provider'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('patients', [
            'philhealth_number',
            'philhealth_category',
            'insurance_provider',
            'insurance_policy_number'
        ]);
    }
}
