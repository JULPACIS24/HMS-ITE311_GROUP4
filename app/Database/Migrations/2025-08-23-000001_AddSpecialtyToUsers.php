<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSpecialtyToUsers extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        if (!$db->fieldExists('specialty', 'users')) {
            $this->forge->addColumn('users', [
                'specialty' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                    'default'    => null,
                ],
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['specialty']);
    }
}
