<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateNurseDepartments extends Migration
{
    public function up()
    {
        // Update existing nurses with "Nursing" department to have proper departments
        $this->db->query("
            UPDATE users 
            SET department = CASE 
                WHEN id = 5 THEN 'Emergency'  -- karma nagisa
                WHEN id = 6 THEN 'ICU'        -- yadd
                ELSE department 
            END 
            WHERE role = 'nurse' AND department = 'Nursing'
        ");
    }

    public function down()
    {
        // Revert nurse departments back to "Nursing"
        $this->db->query("
            UPDATE users 
            SET department = 'Nursing'
            WHERE role = 'nurse' AND department IN ('Emergency', 'ICU', 'Medical')
        ");
    }
}
