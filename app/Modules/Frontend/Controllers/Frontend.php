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


    /**
     * Calculate the profile completion percentage
     *
     * @param object $user
     * @param array $fields
     * @return int
     */
    protected function calculateProfileCompletion($user, array $fields): int
    {
        if (empty($fields)) {
            return 0;
        }
        
        $completed = 0;
        foreach ($fields as $field) {
            if (!empty($user->$field)) {
                $completed++;
            }
        }
        
        return (int) round(($completed / count($fields)) * 100);
    }
    
    /**
     * Display the dashboard with user statistics
     */
    public function dashboard(): string
    {
        // Get the authenticated user
        $auth = service('auth');
        $user = $auth->user();
        
        if (!$user) {
            return redirect()->to('login')->with('error', 'Please login to access the dashboard.');
        }
        
        // Load the applications model
        $applicationsModel = new \App\Modules\Frontend\Models\ApplicationsModel();
        
        // Get application statistics for the current user
        $stats = $applicationsModel->getApplicationStats($user->id);
        
        // Get recent activities (applications)
        $recentActivities = [];
        foreach ($stats['recent_applications'] as $app) {
            $status = $app['status'] ?? 'pending';
            $type = strpos(($app['reference_number'] ?? ''), 'PLC-') === 0 ? 'PLC' : 'PBC';
            $date = !empty($app['updated_at']) ? $app['updated_at'] : ($app['created_at'] ?? date('Y-m-d H:i:s'));
            
            $recentActivities[] = [
                'type' => $status === 'approved' ? 'approved' : ($status === 'pending' ? 'pending' : 'submitted'),
                'title' => $status === 'approved' ? 'Application Approved' : 
                          ($status === 'pending' ? 'Application Under Review' : 'New Application Submitted'),
                'description' => "{$type} registration - " . ($app['reference_number'] ?? 'New Application'),
                'date' => $date,
                'status' => ucfirst($status),
                'reference' => $app['reference_number'] ?? 'N/A',
                'icon' => 'file-alt',
                'color' => $this->getStatusColor($status)
            ];
        }
        
        // Add some system notifications (example)
        $systemActivities = [
            [
                'type' => 'info',
                'title' => 'System Update',
                'description' => 'New features have been added to the portal.',
                'date' => '2023-10-01 10:30:00',
                'status' => 'Info',
                'reference' => 'SYSTEM',
                'icon' => 'info-circle',
                'color' => 'info'
            ]
        ];
        
        // Merge activities
        $activities = array_merge($recentActivities, $systemActivities);
        
        // Sort activities by date (newest first)
        usort($activities, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });
        
        // Get only the latest 5 activities
        $recentActivities = array_slice($activities, 0, 5);
        
        // Calculate profile completion percentage
        $profileFields = [
            'first_name', 'last_name', 'email', 'phone', 'id_number',
            'date_of_birth', 'gender', 'country', 'city', 'address_line1',
            'postal_code', 'profile_photo', 'id_document'
        ];
        
        // Calculate profile completion percentage
        $profileFields = [
            'first_name', 'last_name', 'email', 'phone', 'id_number',
            'date_of_birth', 'gender', 'country', 'city', 'address_line1',
            'postal_code', 'profile_photo', 'id_document'
        ];
        $profileCompletion = $this->calculateProfileCompletion($user, $profileFields);
        
        // Add welcome message if no recent activities
        if (empty($recentActivities)) {
            $recentActivities[] = [
                'type' => 'info',
                'title' => 'Welcome to Your Dashboard',
                'description' => 'Get started by submitting your first application',
                'date' => date('Y-m-d H:i:s'),
                'status' => 'Info',
                'reference' => 'Welcome',
                'icon' => 'info-circle',
                'color' => 'info'
            ];
        }
        
        // Prepare data for the view
        $data = [
            'title' => 'Dashboard - ' . env('APP_NAME'),
            'user' => (array)$user,
            'stats' => [
                'total_applications' => $stats['total_applications'],
                'active_applications' => $stats['active_applications'],
                'approved_applications' => $stats['approved_applications'],
                'pending_review' => $stats['pending_review']
            ],
            'recent_activities' => $recentActivities,
            'profile_completion' => $profileCompletion
        ];
        
        return view('App\\Modules\\Frontend\\Views\\dashboard', $data);
    }

    public function profile(): string
    {
        // Get the authenticated user
        $auth = service('auth');
        $user = $auth->user();
        
        if (!$user) {
            return redirect()->to('login')->with('error', 'Please login to view your profile.');
        }
        
        // Load the personal details from the database
        $db = \Config\Database::connect();
        $personalDetails = $db->table('personal_details')
                             ->where('user_id', $user->id)
                             ->get()
                             ->getRowArray();
        
        // Merge personal details with user data
        if ($personalDetails) {
            // Convert to array if it's an object
            $userArray = is_object($user) ? (array)$user : $user;
            $user = (object)array_merge($userArray, $personalDetails);
        }
        
        $data = [
            'title' => 'My Profile',
            'user' => $user,
            'validation' => \Config\Services::validation()
        ];
        
        return view('App\Modules\Frontend\Views\profile', $data);
    }

    public function updateProfile(): RedirectResponse
    {
        // Get the authenticated user
        $auth = service('auth');
        $user = $auth->user();
        
        if (!$user) {
            return redirect()->to('login')->with('error', 'Please login to update your profile.');
        }

        // Validate the form data
        $rules = [
            'first_name'    => 'required|min_length[2]|max_length[50]',
            'last_name'     => 'required|min_length[2]|max_length[50]',
            'email'         => 'required|valid_email',
            'phone'         => 'required',
            'national_id'     => 'required',
            'date_of_birth' => 'required|valid_date',
            'physical_address' => 'required',
            'city'          => 'required',
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
            'national_id' => [
                'required' => 'ID/Passport number is required'
            ],
            'date_of_birth' => [
                'required' => 'Date of birth is required',
                'valid_date' => 'Please provide a valid date of birth'
            ],
            'physical_address' => [
                'required' => 'Address line 1 is required'
            ],
            'city' => [
                'required' => 'City is required'
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Process file uploads
        $filePaths = [];
        $uploadPath = WRITEPATH . 'uploads/users/' . $user->id . '/';
        
        // Create user directory if it doesn't exist
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Handle profile photo upload
        $profilePhoto = $this->request->getFile('profile_photo');
        if ($profilePhoto && $profilePhoto->isValid() && !$profilePhoto->hasMoved()) {
            $newName = $profilePhoto->getRandomName();
            $profilePhoto->move($uploadPath . 'profile', $newName);
            $filePaths['profile_photo'] = 'profile/' . $newName;
        }

        // Handle ID document upload
        $idDocument = $this->request->getFile('id_document');
        if ($idDocument && $idDocument->isValid() && !$idDocument->hasMoved()) {
            $newName = $idDocument->getRandomName();
            $idDocument->move($uploadPath . 'documents', $newName);
            $filePaths['id_document'] = 'documents/' . $newName;
        }
        
        // Prepare personal details data
        $personalDetailsData = [
            'user_id'         => $user->id,
            'first_name'      => $this->request->getPost('first_name'),
            'last_name'       => $this->request->getPost('last_name'),
            'email'           => $this->request->getPost('email'),
            'phone_number'    => $this->request->getPost('phone'),
            'national_id'     => $this->request->getPost('national_id'),
            'date_of_birth'   => $this->request->getPost('date_of_birth'),
            'gender'          => $this->request->getPost('gender'),
            'marital_status'  => $this->request->getPost('marital_status'),
            'physical_address'=> $this->request->getPost('physical_address'),
            'city'            => $this->request->getPost('city'),
            'updated_at'      => date('Y-m-d H:i:s')
        ];

       
        // Update or create personal details
        $db = \Config\Database::connect();
        $builder = $db->table('personal_details');
        $existingDetails = $builder->where('user_id', $user->id)->get()->getRowArray();

        if ($existingDetails) {
            $builder->where('id', $existingDetails['id'])->update($personalDetailsData);
        } else {
            $personalDetailsData['created_at'] = date('Y-m-d H:i:s');
            $builder->insert($personalDetailsData);
        }

        // Update user's basic info in users table
        $userData = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $userModel = new \App\Core\Models\UserModel();
        $userModel->update($user->id, $userData);

        // Update user session data
        $updatedUser = $userModel->find($user->id);
        $auth->setUser($updatedUser);

        // Check if this is an AJAX request
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'redirect' => site_url('frontend/profile')
            ]);
        }

        return redirect()->to(site_url('frontend/profile'))
            ->with('success', 'Profile updated successfully!');
    }

    public function __construct()
    {
        helper(['form', 'url', 'text', 'common']);
    }
    
    /**
     * Get color class based on application status
     *
     * @param string $status
     * @return string
     */
    protected function getStatusColor($status)
    {
        $status = strtolower($status);
        
        switch ($status) {
            case 'approved':
                return 'success';
            case 'pending':
                return 'warning';
            case 'in_review':
            case 'in_progress':
                return 'info';
            case 'rejected':
            case 'cancelled':
                return 'danger';
            default:
                return 'secondary';
        }
    }
    
    /**
     * Display user's company registrations
     */
    public function registrations(): string
    {
        // Get the authenticated user
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('login')->with('error', 'Please login to view your registrations');
        }
        
        $data = [
            'title' => 'My Registrations',
            'user' => $user
        ];
        
        return view('App\Modules\Frontend\Views\registrations', $data);
    }
    
    /**
     * Display the application form
     */
    public function apply(): string
    {
        $data = [
            'title' => 'Apply',
            'user' => session()->get('user')
        ];
        
        return view('App\Modules\Frontend\Views\apply', $data);
    }
    
    /**
     * Display user's applications
     */
    public function applications()
    {
        // Get the authenticated user
        $auth = service('auth');
        $user = $auth->user();
        
        if (!$user) {
            return redirect()->to('login')->with('error', 'Please login to view your applications.');
        }
        
        try {
            // Load the applications model
            $applicationsModel = new \App\Modules\Frontend\Models\ApplicationsModel();
            
            // Get all applications for the current user
            $applications = $applicationsModel->getUserApplications($user->id);
            
            // Format the applications data for the view
            $formattedApplications = [];
            foreach ($applications as $app) {
                $formattedApplications[] = [
                    'id' => $app['id'],
                    'reference_number' => $app['reference_number'] ?? 'N/A',
                    'status' => !empty($app['status']) ? ucfirst($app['status']) : 'Draft',
                    'type' => strpos(($app['reference_number'] ?? ''), 'PLC-') === 0 ? 'plc' : 'pbc',
                    'created_at' => $app['created_at'] ?? null,
                    'updated_at' => $app['updated_at'] ?? null,
                    'company_name' => 'Application ' . ($app['reference_number'] ?? $app['id'])
                ];
            }
            
            $data = [
                'title' => 'My Applications - ' . env('APP_NAME'),
                'applications' => $formattedApplications,
                'pager' => null // Not using pagination for now
            ];
            
            return view('App\\Modules\\Frontend\\Views\\applications', $data);
            
        } catch (\Exception $e) {
            // Log the error for debugging
            log_message('error', 'Error loading applications: ' . $e->getMessage() . '\n' . $e->getTraceAsString());
            
            // Show a user-friendly error message
            return redirect()->back()->with('error', 'Unable to load applications. Please try again later.');
        }
    }
}