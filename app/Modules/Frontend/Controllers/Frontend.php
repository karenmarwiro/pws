<?php

namespace App\Modules\Frontend\Controllers;

use App\Core\Controllers\FrontendController;
use CodeIgniter\HTTP\RedirectResponse;

class Frontend extends FrontendController
{
   public function index(): string
{
    if (session()->has('isLoggedIn')) {
        return redirect()->route('frontend.dashboard');
    }
    return view('App\Modules\Frontend\Views\index');
}


    public function dashboard(): string
    {
        $data = [
            'title' => 'Dashboard',
            'user' => session()->get('user') // Assuming user data is stored in session
        ];
        
        return view('App\Modules\Frontend\Views\dashboard', $data);
    }

    public function profile(): string
    {
        $data = [
            'title' => 'My Profile',
            'user' => session()->get('user') // Assuming user data is stored in session
        ];
        
        return view('App\Modules\Frontend\Views\profile', $data);
    }

    public function updateProfile(): RedirectResponse
    {
        // Validate the form data
        $rules = [
            'first_name'    => 'required|min_length[2]|max_length[50]',
            'last_name'     => 'required|min_length[2]|max_length[50]',
            'email'         => 'required|valid_email',
            'phone'         => 'required',
            'id_number'     => 'required',
            'date_of_birth' => 'required|valid_date',
            'address_line1' => 'required',
            'city'          => 'required',
            'state'         => 'required',
            'postal_code'   => 'required',
            'country'       => 'required',
        ];

        $messages = [
            'first_name' => [
                'required' => 'First name is required',
                'min_length' => 'First name must be at least 2 characters',
                'max_length' => 'First name cannot exceed 50 characters'
            ],
            'last_name' => [
                'required' => 'Last name is required',
                'min_length' => 'Last name must be at least 2 characters',
                'max_length' => 'Last name cannot exceed 50 characters'
            ],
            'email' => [
                'required' => 'Email is required',
                'valid_email' => 'Please provide a valid email address'
            ],
            'phone' => [
                'required' => 'Phone number is required'
            ],
            'id_number' => [
                'required' => 'ID/Passport number is required'
            ],
            'date_of_birth' => [
                'required' => 'Date of birth is required',
                'valid_date' => 'Please provide a valid date of birth'
            ],
            'address_line1' => [
                'required' => 'Address line 1 is required'
            ],
            'city' => [
                'required' => 'City is required'
            ],
            'state' => [
                'required' => 'Province is required'
            ],
            'postal_code' => [
                'required' => 'Postal code is required'
            ],
            'country' => [
                'required' => 'Country is required'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get the current user ID from session
        $userId = session()->get('user_id');
        
        // Prepare user data
        $userData = [
            'first_name'    => $this->request->getPost('first_name'),
            'last_name'     => $this->request->getPost('last_name'),
            'email'         => $this->request->getPost('email'),
            'phone'         => $this->request->getPost('phone'),
            'id_number'     => $this->request->getPost('id_number'),
            'date_of_birth' => $this->request->getPost('date_of_birth'),
            'address_line1' => $this->request->getPost('address_line1'),
            'address_line2' => $this->request->getPost('address_line2'),
            'city'          => $this->request->getPost('city'),
            'state'         => $this->request->getPost('state'),
            'postal_code'   => $this->request->getPost('postal_code'),
            'country'       => $this->request->getPost('country'),
            'occupation'    => $this->request->getPost('occupation'),
            'tax_number'    => $this->request->getPost('tax_number'),
            'bio'           => $this->request->getPost('bio'),
            'updated_at'    => date('Y-m-d H:i:s')
        ];

        // Load the User model
        $userModel = new \App\Models\UserModel();
        
        try {
            // Update the user's profile
            if ($userModel->update($userId, $userData)) {
                // Update session data
                $updatedUser = $userModel->find($userId);
                session()->set('user', $updatedUser);
                
                return redirect()->back()->with('success', 'Profile updated successfully!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update profile. Please try again.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Profile update error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'An error occurred while updating your profile.');
        }
    }

    public function apply(): string
    {
        $data = [
            'title' => 'Apply',
            'user' => session()->get('user')
        ];
        
        return view('App\Modules\Frontend\Views\apply', $data);
    }
}