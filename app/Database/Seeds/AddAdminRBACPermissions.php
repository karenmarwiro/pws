<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AddAdminRBACPermissions extends Seeder
{
    public function run()
    {
        $data = [
            ['group' => 'admin', 'permission' => 'rbac.view'],
            ['group' => 'admin', 'permission' => 'rbac.manage'],
            ['group' => 'admin', 'permission' => 'rbac.assign'],
        ];

        // Get database connection
        $db = \Config\Database::connect();
        
        foreach ($data as $row) {
            // Check if the permission already exists for the group
            $exists = $db->table('auth_groups_permissions')
                ->where('`group`', $row['group'])
                ->where('permission', $row['permission'])
                ->countAllResults();

            if ($exists === 0) {
                // Insert the permission
                $db->table('auth_groups_permissions')->insert([
                    '`group`' => $row['group'],
                    'permission' => $row['permission']
                ]);
                echo "Added permission {$row['permission']} to group {$row['group']}\n";
            } else {
                echo "Permission {$row['permission']} already exists for group {$row['group']}\n";
            }
        }
    }
}
