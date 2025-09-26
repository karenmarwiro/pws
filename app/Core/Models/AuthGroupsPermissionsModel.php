<?php

namespace App\Core\Models;

use CodeIgniter\Model;

class AuthGroupsPermissionsModel extends Model
{
    protected $table      = 'auth_groups_permissions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['group', 'permission'];
    protected $returnType    = 'array';
}