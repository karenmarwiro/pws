<?php 

namespace App\Modules\Frontend\Models;

use CodeIgniter\Model;

class PlcApplicationModel extends Model
{
    protected $table      = 'plc_applications';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'user_id',
        'application_id',
        'personal_details_id',
        'company_details_id',
        'submitted_data',
        'status'
    ];
}
