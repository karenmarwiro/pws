<?php

namespace App\Core\Models;

use CodeIgniter\Model;

class AuthPermissionsModel extends Model
{
    protected $table      = 'auth_permissions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['permission', 'description'];
    protected $returnType    = 'array';
}