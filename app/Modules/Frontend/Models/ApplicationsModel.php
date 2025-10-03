<?php

namespace App\Modules\Frontend\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class ApplicationsModel extends Model
{
    protected $table            = 'applications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'user_id', 'application_type_id', 'status', 'reference_number', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    /**
     * Get applications by user ID with optional status filter and limit
     *
     * @param int $userId
     * @param string|null $status
     * @param int|null $limit
     * @return array
     */
    public function getUserApplications($userId, $status = null, $limit = null)
    {
        $builder = $this->where('user_id', $userId);
        
        if ($status !== null) {
            $builder->where('status', $status);
        }
        
        $builder->orderBy('created_at', 'DESC');
        
        if ($limit !== null) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }
    
    /**
     * Get application by reference number
     *
     * @param string $referenceNumber
     * @return array|null
     */
    public function getByReferenceNumber($referenceNumber)
    {
        return $this->where('reference_number', $referenceNumber)
                   ->first();
    }
    
    /**
     * Generate a new reference number
     *
     * @param string $prefix
     * @return string
     */
    public function generateReferenceNumber($prefix = 'PBC')
    {
        $date = new Time('now');
        $datePart = $date->format('ymd');
        $randomPart = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 10));
        
        return "{$prefix}-{$datePart}-{$randomPart}";
    }
    
    /**
     * Get application statistics for dashboard
     *
     * @param int $userId
     * @return array
     */
    public function getApplicationStats($userId)
    {
        $db = $this->db;
        
        // Total applications
        $total = $db->table($this->table)
                   ->where('user_id', $userId)
                   ->countAllResults();
        
        // Active applications (not completed or rejected)
        $active = $db->table($this->table)
                    ->where('user_id', $userId)
                    ->whereIn('status', ['pending', 'in_review', 'in_progress'])
                    ->countAllResults();
        
        // Approved applications
        $approved = $db->table($this->table)
                      ->where('user_id', $userId)
                      ->where('status', 'approved')
                      ->countAllResults();
        
        // Pending review applications
        $pendingReview = $db->table($this->table)
                           ->where('user_id', $userId)
                           ->where('status', 'pending')
                           ->countAllResults();
        
        return [
            'total_applications' => $total,
            'active_applications' => $active,
            'approved_applications' => $approved,
            'pending_review' => $pendingReview,
            'recent_applications' => $this->getUserApplications($userId, null, 5) // Get 5 most recent applications
        ];
    }
}
