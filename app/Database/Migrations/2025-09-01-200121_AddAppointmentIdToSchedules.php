<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAppointmentIdToSchedules extends Migration
{
    public function up()
    {
        $this->forge->addColumn('schedules', [
            'appointment_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'after' => 'patient_id'
            ]
        ]);
        
        // Add foreign key constraint
        $this->forge->addForeignKey('appointment_id', 'appointments', 'id', 'CASCADE', 'SET NULL');
    }

    public function down()
    {
        // Check if foreign key exists before dropping
        $foreignKeys = $this->db->getForeignKeyData('schedules');
        $foreignKeyExists = false;
        
        foreach ($foreignKeys as $fk) {
            if ($fk->column_name === 'appointment_id') {
                $foreignKeyExists = true;
                break;
            }
        }
        
        // Remove foreign key first if it exists
        if ($foreignKeyExists) {
            $this->forge->dropForeignKey('schedules', 'appointment_id');
        }
        
        // Remove the column
        $this->forge->dropColumn('schedules', 'appointment_id');
    }
}
