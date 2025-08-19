<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAppointments extends Migration
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
			'appointment_code' => [
				'type'       => 'VARCHAR',
				'constraint' => 20,
				'null'       => true,
			],
			'patient_name' => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
			],
			'patient_phone' => [
				'type'       => 'VARCHAR',
				'constraint' => 30,
				'null'       => true,
			],
			'doctor_name' => [
				'type'       => 'VARCHAR',
				'constraint' => 100,
			],
			'date_time' => [
				'type' => 'DATETIME',
			],
			'type' => [
				'type'       => 'VARCHAR',
				'constraint' => 50,
			],
			'status' => [
				'type'       => 'ENUM',
				'constraint' => ['Confirmed', 'Pending', 'Completed'],
				'default'    => 'Pending',
			],
			'notes' => [
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
		$this->forge->createTable('appointments');
	}

	public function down()
	{
		$this->forge->dropTable('appointments');
	}
}


