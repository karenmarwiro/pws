<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Authorization\Groups;
use CodeIgniter\Shield\Authorization\Permissions;
use CodeIgniter\Shield\Models\GroupModel;
use CodeIgniter\Shield\Models\PermissionModel;

class RBACSeeder extends Seeder
{
    public function run()
    {
        // Get the database connection
        $db = \Config\Database::connect();
        
        // Truncate existing data to avoid duplicates
        $db->table('auth_groups_permissions')->truncate();
        $db->table('auth_groups_users')->truncate();
        $db->table('auth_permissions_users')->truncate();
        $db->table('auth_identities')->delete(['user_id >' => 0]);
        $db->table('auth_logins')->truncate();
        $db->table('auth_token_logins')->truncate();
        $db->table('auth_remember_tokens')->truncate();
        $db->table('users')->delete(['id >' => 0]);
        
        // Reset auto-increment counters
        $db->query('ALTER TABLE users AUTO_INCREMENT = 1');
        $db->query('ALTER TABLE auth_identities AUTO_INCREMENT = 1');
        
        // Create a default admin user
        $users = new \CodeIgniter\Shield\Models\UserModel();
        $user = new \CodeIgniter\Shield\Entities\User([
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'password' => 'admin123',
            'active'   => 1
        ]);
        $users->save($user);
        
        // Get the saved user with ID
        $user = $users->findById($users->getInsertID());
        
        // Add user to superadmin group
        $authorization = service('authorization');
        $authorization->addUserToGroup($user->id, 'superadmin');
        
        // Output success message
        echo "Successfully created default admin user: admin@example.com / admin123\n";
        echo "Please change the password after first login!\n";
    }
}
