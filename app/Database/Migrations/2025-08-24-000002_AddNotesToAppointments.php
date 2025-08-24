<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNotesToAppointments extends Migration
{
	public function up()
	{
		// Check if table exists first
		if (!$this->db->tableExists('appointments')) {
			return;
		}

		// Add notes column if it doesn't exist
		if (!$this->db->fieldExists('notes', 'appointments')) {
			$this->forge->addColumn('appointments', [
				'notes' => [
					'type' => 'TEXT',
					'null' => true,
					'after' => 'status',
				],
			]);
		}
	}

	public function down()
	{
		// Check if table exists first
		if (!$this->db->tableExists('appointments')) {
			return;
		}

		// Remove notes column if it exists
		if ($this->db->fieldExists('notes', 'appointments')) {
			$this->forge->dropColumn('appointments', 'notes');
		}
	}
}
