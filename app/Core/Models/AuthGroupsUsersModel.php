<?php

namespace App\Core\Models;

use CodeIgniter\Model;

class AuthGroupsUsersModel extends Model
{
    protected $table      = 'auth_groups_users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'group', 'created_at'];
    protected $returnType    = 'array';
}