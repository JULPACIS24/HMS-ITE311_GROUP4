<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSecurityLogs extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
			'user_id'     => ['type' => 'INT', 'unsigned' => true, 'null' => true],
			'role'        => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
			'event'       => ['type' => 'VARCHAR', 'constraint' => 50],
			'details'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
			'ip_address'  => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => true],
			'user_agent'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
			'created_at'  => ['type' => 'DATETIME', 'null' => true],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('security_logs');
	}

	public function down()
	{
		$this->forge->dropTable('security_logs');
	}
}

?>

