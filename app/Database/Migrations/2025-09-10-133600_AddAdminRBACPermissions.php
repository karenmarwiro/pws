<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAdminRBACPermissions extends Migration
{
    public function up()
    {
        // Add RBAC permissions to admin group
        $this->db->table('auth_groups_permissions')->insert([
            ['group_id' => 2, 'permission_id' => 1], // rbac.view
            ['group_id' => 2, 'permission_id' => 2], // rbac.manage
            ['group_id' => 2, 'permission_id' => 3], // rbac.assign
        ]);
    }

    public function down()
    {
        // Remove the permissions if needed
        $this->db->table('auth_groups_permissions')
            ->where('group_id', 2)
            ->whereIn('permission_id', [1, 2, 3])
            ->delete();
    }
}
