<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends BaseController
{
    protected $auth;

    public function __construct()
    {
        $this->auth = service('auth');
    }

    public function index(): string
    {
        return view('admin/dashboard');
    }

    /**
     * Admin dashboard
     */
    public function adminDashboard()
    {
        if (!$this->auth->loggedIn()) {
            return redirect()->to('login')->with('error', 'Please login first');
        }

        $user = $this->auth->user();
        
        if (!$user->inGroup('admin', 'superadmin')) {
            $this->auth->logout();
            return redirect()->to('login')->with('error', 'Unauthorized access');
        }

        $data = [
            'title' => 'Admin Dashboard',
            'user' => $user
        ];

        return view('admin/dashboard', $data);
    }
}