<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminPermissionsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['group_id' => 2, 'permission_id' => 1], // admin - rbac.view
            ['group_id' => 2, 'permission_id' => 2], // admin - rbac.manage
            ['group_id' => 2, 'permission_id' => 3], // admin - rbac.assign
            ['group_id' => 2, 'permission_id' => 4], // admin - users.view
            ['group_id' => 2, 'permission_id' => 5], // admin - users.manage
        ];

        // Only insert if the permission doesn't already exist
        $db = \Config\Database::connect();
        foreach ($data as $row) {
            $exists = $db->table('auth_groups_permissions')
                ->where('group_id', $row['group_id'])
                ->where('permission_id', $row['permission_id'])
                ->countAllResults();

            if ($exists === 0) {
                $db->table('auth_groups_permissions')->insert($row);
            }
        }
    }
}
