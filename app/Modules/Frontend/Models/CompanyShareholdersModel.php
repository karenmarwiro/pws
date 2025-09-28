<?php

namespace App\Modules\Frontend\Models;

use CodeIgniter\Model;

class CompanyShareholdersModel extends Model
{
    protected $table      = 'company_shareholders';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'company_id',
        'shareholder_id',
        'shareholding',
        'is_director',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
