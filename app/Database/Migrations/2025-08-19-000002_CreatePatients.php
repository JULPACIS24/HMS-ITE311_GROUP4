<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatients extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
			'first_name' => [ 'type' => 'VARCHAR', 'constraint' => 100 ],
			'last_name'  => [ 'type' => 'VARCHAR', 'constraint' => 100 ],
			'dob'        => [ 'type' => 'DATE' ],
			'gender'     => [ 'type' => 'VARCHAR', 'constraint' => 10 ],
			'phone'      => [ 'type' => 'VARCHAR', 'constraint' => 30 ],
			'email'      => [ 'type' => 'VARCHAR', 'constraint' => 150, 'null' => true ],
			'address'    => [ 'type' => 'TEXT', 'null' => true ],
			'blood_type' => [ 'type' => 'VARCHAR', 'constraint' => 5, 'null' => true ],
			'emergency_name'  => [ 'type' => 'VARCHAR', 'constraint' => 150, 'null' => true ],
			'emergency_phone' => [ 'type' => 'VARCHAR', 'constraint' => 30, 'null' => true ],
			'medical_history' => [ 'type' => 'TEXT', 'null' => true ],
			'allergies'       => [ 'type' => 'TEXT', 'null' => true ],
			'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
			'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('patients');
	}

	public function down()
	{
		$this->forge->dropTable('patients');
	}
}


