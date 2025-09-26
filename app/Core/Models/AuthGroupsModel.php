<?php

namespace App\Core\Models;

use CodeIgniter\Model;

class AuthGroupsModel extends Model
{
    protected $table      = 'auth_groups';
    protected $primaryKey = 'id';
    protected $allowedFields = ['group', 'description'];
}
