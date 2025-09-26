<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Authentication\Passwords;

class AdminController extends Controller
{
    protected $helpers = ['form', 'url'];

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function login()
    {
        // If user is already logged in, redirect to admin dashboard
        if (auth()->loggedIn()) {
            return redirect()->to('/admin/dashboard');
        }

        $data = [
            'title' => 'Admin Login',
            'config' => config('Auth')
        ];

        if ($this->request->getMethod() === 'post') {
            $credentials = [
                'email'    => $this->request->getPost('email'),
                'password' => $this->request->getPost('password')
            ];

            $loginAttempt = auth()->attempt($credentials);
            
            if ($loginAttempt->isOK()) {
                $user = $loginAttempt->extraInfo();
                
                // Check if user has admin role
                if ($user->inGroup('admin', 'superadmin')) {
                    return redirect()->to('/admin/dashboard')->with('message', 'Login successful!');
                }
                
                // If not admin, log them out
                auth()->logout();
                return redirect()->back()->with('error', 'You do not have permission to access the admin area.');
            }
            
            return redirect()->back()->with('error', 'Invalid login credentials');
        }

        return view('admin/auth/login', $data);
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->to('/auth/login')->with('message', 'You have been logged out.');
    }

    public function dashboard()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/admin/login')->with('error', 'Please login first');
        }

        $user = auth()->user();
        
        if (!$user->inGroup('admin', 'superadmin')) {
            auth()->logout();
            return redirect()->to('/admin/login')->with('error', 'Unauthorized access');
        }

        $data = [
            'title' => 'Admin Dashboard',
            'user' => $user
        ];

        return view('admin/dashboard', $data);
    }
}