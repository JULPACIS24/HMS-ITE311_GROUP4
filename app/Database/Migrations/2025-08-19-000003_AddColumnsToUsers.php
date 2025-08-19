<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnsToUsers extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();

        if (! $db->fieldExists('role', 'users')) {
            $this->forge->addColumn('users', [
                'role' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => false,
                    'default'    => 'it_staff',
                ],
            ]);
        }

        if (! $db->fieldExists('department', 'users')) {
            $this->forge->addColumn('users', [
                'department' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                    'default'    => 'IT',
                ],
            ]);
        }

        if (! $db->fieldExists('status', 'users')) {
            $this->forge->addColumn('users', [
                'status' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'null'       => false,
                    'default'    => 'Active',
                ],
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['role', 'department', 'status']);
    }
}

?>

