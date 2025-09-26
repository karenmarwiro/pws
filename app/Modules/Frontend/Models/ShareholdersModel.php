<?php

namespace App\Modules\Frontend\Models;

use CodeIgniter\Model;

class ShareholdersModel extends Model
{
    protected $table            = 'shareholders';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'application_id',
        'personal_details_id',
        'full_name',
        'national_id',
        'nationality',
        'shareholding',
        'email',
        'phone_number',
        'is_director'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
