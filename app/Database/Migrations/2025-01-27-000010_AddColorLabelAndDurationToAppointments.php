<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColorLabelAndDurationToAppointments extends Migration
{
    public function up()
    {
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

    public function down()
    {
        $this->forge->dropColumn('appointments', ['color_label']);
    }
}
