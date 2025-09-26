<?php

namespace App\Modules\Frontend\Models;

use CodeIgniter\Model;

class ApplicationTypeModel extends Model
{
    protected $table            = 'application_type';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['name', 'description'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
