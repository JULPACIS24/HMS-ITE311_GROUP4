<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UpdateAdminRoleSeeder extends Seeder
{
    public function run()
    {
        // Update existing admin users to have the correct role
        $this->db->table('users')
            ->whereIn('id', [8, 9])  // Update the existing admin users
            ->update([
                'role' => 'admin',
                'department' => 'Administration',
                'status' => 'Active'
            ]);

        echo "UpdateAdminRoleSeeder completed successfully!\n";
        echo "Updated existing admin users (IDs 8 & 9) to have 'admin' role\n";
        echo "Admin users now have proper role in database\n";
    }
}
