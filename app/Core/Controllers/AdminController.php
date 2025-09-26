<?php

namespace App\Core\Controllers;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    public function index()
    {
        return $this->dashboard();
    }
    
    public function dashboard()
    {
        // Load the dashboard model
        $dashboardModel = new \App\Core\Models\DashboardModel();
        
        // Get user statistics
        $totalUsers = $dashboardModel->getTotalUsers();
        $activeUsers = $dashboardModel->getActiveUsers();
        
        // Get growth data
        $growthData = $dashboardModel->getUserGrowthData();
        $rolesData = $dashboardModel->getUserRolesDistribution();
        
        $data = [
            'title'          => 'Admin Dashboard',
            'username'       => auth()->user()->username ?? 'Admin',
            'totalUsers'     => $totalUsers,
            'activeUsers'    => $activeUsers,
            'growthData'     => $growthData,
            'rolesData'      => $rolesData,
            'inactiveUsers'  => $totalUsers - $activeUsers,
            'userGrowth'     => $this->calculateGrowthRate($growthData['data'])
        ];

        // Load the dashboard view using coreView
        return $this->coreView('dashboard', $data);
    }
    
    /**
     * Calculate growth rate percentage
     */
    private function calculateGrowthRate($data)
    {
        if (count($data) < 2) {
            return 0;
        }
        
        $current = end($data);
        $previous = prev($data);
        
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        
        return round((($current - $previous) / $previous) * 100);
    }
}
