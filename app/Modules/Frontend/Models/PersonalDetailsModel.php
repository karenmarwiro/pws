<?php

namespace App\Modules\Frontend\Models;

use CodeIgniter\Model;

class PersonalDetailsModel extends Model
{
    protected $table            = 'personal_details';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'user_id', 'first_name', 'last_name', 'national_id', 'date_of_birth',
        'gender', 'marital_status', 'email', 'phone_number',
        'physical_address', 'city', 'id_document', 'proof_of_address',
        'passport_photo'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
};
