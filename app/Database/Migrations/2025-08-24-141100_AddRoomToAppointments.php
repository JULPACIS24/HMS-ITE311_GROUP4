<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoomToAppointments extends Migration
{
    public function up()
    {
        $this->forge->addColumn('appointments', [
            'room' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'status'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('appointments', 'room');
    }
}
