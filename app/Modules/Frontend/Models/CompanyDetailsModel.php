<?php

namespace App\Modules\Frontend\Models;

use CodeIgniter\Model;

class CompanyDetailsModel extends Model
{
    protected $table            = 'company_details';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'application_id',
        'personal_details_id',
        'proposed_name_one',
        'proposed_name_two',
        'proposed_name_three',
        'proposed_name_four',
        'registration_number',
        'postal_code',
        'suburb_city',
        'country',
        'phone_number',
        'email',
        'website',
        'address',
        'business_type',
        'financial_year_end'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
