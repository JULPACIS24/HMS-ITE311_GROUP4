<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColorAndDurationToAppointments extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('appointments')) {
            return;
        }

        $columnsToAdd = [];

        if (! $this->db->fieldExists('color_label', 'appointments')) {
            $columnsToAdd['color_label'] = [
                'type' => 'VARCHAR',
                'constraint' => 7,
                'default' => '#3b82f6',
                'null' => false,
                'comment' => 'Color label for appointment display',
                'after' => 'notes',
            ];
        }

        if (! $this->db->fieldExists('duration', 'appointments')) {
            $columnsToAdd['duration'] = [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'comment' => 'Duration in minutes',
                'after' => 'color_label',
            ];
        }

        if (! empty($columnsToAdd)) {
            $this->forge->addColumn('appointments', $columnsToAdd);
        }
    }

    public function down()
    {
        if (! $this->db->tableExists('appointments')) {
            return;
        }

        if ($this->db->fieldExists('duration', 'appointments')) {
            $this->forge->dropColumn('appointments', ['duration']);
        }

        if ($this->db->fieldExists('color_label', 'appointments')) {
            $this->forge->dropColumn('appointments', ['color_label']);
        }
    }
}


