<?php

namespace App\Core\Models;

use CodeIgniter\Model;

class AuthPermissionsUsersModel extends Model
{
    protected $table      = 'auth_permissions_users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'permission', 'created_at'];
    protected $returnType    = 'array';
}