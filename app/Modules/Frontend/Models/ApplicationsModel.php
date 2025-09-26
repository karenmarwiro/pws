<?php

namespace App\Modules\Frontend\Models;

use CodeIgniter\Model;

class ApplicationsModel extends Model
{
    protected $table            = 'applications';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'user_id', 'application_type_id', 'status', 'reference_number'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
