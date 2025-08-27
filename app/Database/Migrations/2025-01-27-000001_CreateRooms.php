<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRooms extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'room_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'room_type' => [
                'type'       => 'ENUM',
                'constraint' => ['Consultation', 'Operating', 'Recovery', 'ICU', 'General', 'Ward'],
                'default'    => 'General',
            ],
            'floor' => [
                'type'       => 'INT',
                'constraint' => 3,
            ],
            'capacity' => [
                'type'       => 'INT',
                'constraint' => 3,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Available', 'Occupied', 'Maintenance', 'Reserved'],
                'default'    => 'Available',
            ],
            'description' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('room_name');
        $this->forge->createTable('rooms');
        
        // Insert sample room data
        $this->db->table('rooms')->insertBatch([
            [
                'room_name' => 'Consultation Room 1',
                'room_type' => 'Consultation',
                'floor' => 1,
                'capacity' => 4,
                'status' => 'Available',
                'description' => 'General consultation room',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'room_name' => 'Consultation Room 2',
                'room_type' => 'Consultation',
                'floor' => 1,
                'capacity' => 4,
                'status' => 'Available',
                'description' => 'General consultation room',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'room_name' => 'Operating Room 1',
                'room_type' => 'Operating',
                'floor' => 2,
                'capacity' => 8,
                'status' => 'Available',
                'description' => 'Main operating room',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'room_name' => 'Recovery Room 1',
                'room_type' => 'Recovery',
                'floor' => 2,
                'capacity' => 6,
                'status' => 'Available',
                'description' => 'Post-operative recovery room',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'room_name' => 'ICU Room 1',
                'room_type' => 'ICU',
                'floor' => 3,
                'capacity' => 2,
                'status' => 'Available',
                'description' => 'Intensive care unit room',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'room_name' => 'Ward Room 101',
                'room_type' => 'Ward',
                'floor' => 1,
                'capacity' => 4,
                'status' => 'Available',
                'description' => 'General ward room',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'room_name' => 'Ward Room 102',
                'room_type' => 'Ward',
                'floor' => 1,
                'capacity' => 4,
                'status' => 'Available',
                'description' => 'General ward room',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('rooms');
    }
}
