<?php

namespace App\Modules\Frontend\Models;

use CodeIgniter\Model;

class ShareholdersModel extends Model
{
    protected $table         = 'shareholders';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';

    protected $allowedFields = [
        'application_id',
        'personal_details_id',
        'full_name',
        'national_id',
        'nationality',
        'shareholding',              
        'email',
        'phone_number',
        'is_director',
        'gender',
        'date_of_birth',
        'residential_address',
        'marital_status',
        'city',
        'is_beneficial_owner',
        'id_document',
        'proof_of_residence',
        'passport_photo',
        'proof_of_address',
        'share_certificate',
        'company_registration_doc'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
