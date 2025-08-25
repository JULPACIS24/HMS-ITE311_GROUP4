<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStockAlerts extends Migration
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
            'alert_id' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'medication_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'alert_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'priority' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'Medium',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'Active',
            ],
            'current_stock' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'minimum_required' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'expiry_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'days_remaining' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'batch_number' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'supplier' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addKey('alert_id');
        $this->forge->addKey('priority');
        $this->forge->addKey('status');
        $this->forge->createTable('stock_alerts');
    }

    public function down()
    {
        $this->forge->dropTable('stock_alerts');
    }
}
