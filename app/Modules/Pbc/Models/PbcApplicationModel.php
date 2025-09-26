<?php

namespace App\Modules\Pbc\Models;

use CodeIgniter\Model;

class PbcApplicationModel extends Model
{
    protected $table            = 'pbc_applications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'user_id',
        'application_id',
        'personal_details_id',
        'company_details_id',
        'submitted_data',
        'status',
    ];

    // Enable automatic created_at & updated_at
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Optional validation rules
    protected $validationRules = [
        'user_id'             => 'required|integer',
        'application_id'      => 'required|integer',
        'personal_details_id' => 'required|integer',
        'company_details_id'  => 'required|integer',
        'submitted_data'      => 'required',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}
