<?php

namespace App\Core\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [];

    /**
     * Get total users count
     */
    public function getTotalUsers()
    {
        $db = \Config\Database::connect();
        return $db->table('users')->countAllResults();
    }

    /**
     * Get active users count
     */
    public function getActiveUsers()
    {
        $db = \Config\Database::connect();
        return $db->table('users')
                 ->where('active', 1)
                 ->countAllResults();
    }

    /**
     * Get user registration data for the last 6 months
     */
    public function getUserGrowthData()
    {
        $db = \Config\Database::connect();
        
        // Get the last 6 months
        $months = [];
        $data = [];
        $labels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = new \DateTime();
            $date->modify("-$i month");
            $month = $date->format('Y-m');
            $months[] = $month;
            $labels[] = $date->format('M Y');
        }
        
        foreach ($months as $month) {
            $startDate = "$month-01";
            $endDate = date('Y-m-t', strtotime($startDate));
            
            $count = $db->table('users')
                       ->where('created_at >=', $startDate . ' 00:00:00')
                       ->where('created_at <=', $endDate . ' 23:59:59')
                       ->countAllResults();
            
            $data[] = $count;
        }
        
        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
    
    /**
     * Get user roles distribution
     */
    public function getUserRolesDistribution()
    {
        $db = \Config\Database::connect();
        
        $query = $db->table('auth_groups_users')
                   ->select('auth_groups.group as role, COUNT(auth_groups_users.user_id) as count')
                   ->join('auth_groups', 'auth_groups.id = auth_groups_users.group')
                   ->groupBy('auth_groups.group')
                   ->get();
        
        $labels = [];
        $data = [];
        $colors = [];
        
        $colorPalette = [
            '#4e73df', // Blue
            '#1cc88a', // Green
            '#36b9cc', // Cyan
            '#f6c23e', // Yellow
            '#e74a3b', // Red
            '#6f42c1', // Purple
            '#fd7e14', // Orange
        ];
        
        $i = 0;
        foreach ($query->getResult() as $row) {
            $labels[] = ucfirst($row->role);
            $data[] = (int)$row->count;
            $colors[] = $colorPalette[$i % count($colorPalette)];
            $i++;
        }
        
        return [
            'labels' => $labels,
            'data' => $data,
            'colors' => $colors
        ];
    }
}
