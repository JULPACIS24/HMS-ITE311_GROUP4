<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColorLabelAndDurationToAppointments extends Migration
{
    public function up()
    {
        // Check if appointments table exists first
        if (!$this->db->tableExists('appointments')) {
            return;
        }

        // Check if color_label column already exists
        if (!$this->db->fieldExists('color_label', 'appointments')) {
            $this->forge->addColumn('appointments', [
                'color_label' => [
                    'type' => 'VARCHAR',
                    'constraint' => 7,
                    'default' => '#3b82f6',
                    'null' => false,
                    'comment' => 'Color label for appointment display'
                ]
            ]);
        }

        // Check if duration column already exists
        if (!$this->db->fieldExists('duration', 'appointments')) {
            $this->forge->addColumn('appointments', [
                'duration' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'null' => true,
                    'comment' => 'Duration in minutes'
                ]
            ]);
        }
    }

    public function down()
    {
        // Check if appointments table exists first
        if (!$this->db->tableExists('appointments')) {
            return;
        }

        // Check if color_label column exists before dropping
        if ($this->db->fieldExists('color_label', 'appointments')) {
            $this->forge->dropColumn('appointments', ['color_label']);
        }

        // Check if duration column exists before dropping
        if ($this->db->fieldExists('duration', 'appointments')) {
            $this->forge->dropColumn('appointments', ['duration']);
        }
    }
}
