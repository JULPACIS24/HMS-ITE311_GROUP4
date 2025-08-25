<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMedicationsInventory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'medication_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'medication_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'generic_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'strength' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'dosage_form' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'current_stock' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'minimum_stock' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 10,
            ],
            'maximum_stock' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 100,
            ],
            'unit_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'supplier' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'storage_conditions' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => 'Room Temperature',
            ],
            'requires_prescription' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Active', 'Inactive', 'Discontinued'],
                'default' => 'Active',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('medication_id');
        $this->forge->addKey('medication_name');
        $this->forge->addKey('category');
        $this->forge->addKey('status');
        $this->forge->createTable('medications_inventory');
    }

    public function down()
    {
        $this->forge->dropTable('medications_inventory');
    }
}
