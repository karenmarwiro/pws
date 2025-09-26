<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CleanupNonEssentialModules extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        
        // Define essential core module names
        $essentialModules = ['Settings', 'Modules', 'RBAC'];
        
        // First, update any non-essential modules that were marked as core
        $db->table('modules')
           ->whereNotIn('name', $essentialModules)
           ->update(['is_core' => 0]);
        
        // Then delete any non-core modules that are not in the essential list
        $db->table('modules')
           ->where('is_core', 0)
           ->whereNotIn('name', $essentialModules)
           ->delete();
    }

    public function down()
    {
        // No rollback needed as this is a cleanup migration
    }
}
