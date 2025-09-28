<?php 

namespace App\Modules\Frontend\Controllers;

use App\Modules\Frontend\Models\ApplicationsModel;
use App\Modules\Frontend\Models\PersonalDetailsModel;
use App\Modules\Frontend\Models\CompanyDetailsModel;
use App\Modules\Frontend\Models\ShareholdersModel;
use App\Modules\Frontend\Models\PbcApplicationModel;
use CodeIgniter\Controller;

class PbcController extends Controller
{
    protected $applicationsModel;
    protected $personalModel;
    protected $companyModel;
    protected $shareholderModel;
    protected $PbcApplicationModel;

    public function __construct()
    {
        helper(['form', 'url', 'session']);
        $this->applicationsModel = new ApplicationsModel();
        $this->personalModel     = new PersonalDetailsModel();
        $this->companyModel      = new CompanyDetailsModel();
        $this->shareholderModel  = new ShareholdersModel();
        $this->PbcApplicationModel  = new PbcApplicationModel();
    }

    /** Step 0: Start Application */
  public function startApplication()
{
    $userId = auth()->id();

    if (!$userId) {
        return redirect()->to(site_url('login'))
                         ->with('error', 'Please login before starting an application.');
    }

    // Generate structured reference number
    $datePart = date('ymd'); // YYMMDD, e.g., 250927
    $countToday = $this->applicationsModel
                       ->where('DATE(created_at)', date('Y-m-d'))
                       ->countAllResults();
    $sequence = str_pad($countToday + 1, 4, '0', STR_PAD_LEFT);
    $referenceNumber = 'PBC-' . $datePart . '-' . $sequence;

    // Insert new application
    $this->applicationsModel->insert([
        'user_id'             => $userId,
        'application_type_id' => 1,
        'status'              => 'pending',
        'reference_number'    => $referenceNumber,
        'created_at'          => date('Y-m-d H:i:s'),
    ]);

    $applicationId = $this->applicationsModel->getInsertID();
    session()->set('application_id', $applicationId);

    return redirect()->to(site_url('frontend/pbc/personal-details'));
}



    /** Step 1: Personal Details Form */
    public function personalDetails()
    {
        return view('App\Modules\Frontend\Views\pbc\personal_details');
    }

    public function processPersonalDetails()
    {
        $rules = [
            'first_name' => 'required|min_length[2]',
            'surname'    => 'required|min_length[2]',
            'phone'      => 'required',
            'email'      => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId        = auth()->id();
        $applicationId = session()->get('application_id');
        if (!$applicationId) {
            return redirect()->to(site_url('frontend/pbc/start-application'))
                             ->with('error', 'No application found. Please start your application.');
        }

        // Insert personal details
        $this->personalModel->insert([
            'user_id'          => $userId,
            'application_id'   => $applicationId,
            'first_name'       => $this->request->getPost('first_name'),
            'last_name'        => $this->request->getPost('surname'),
            'phone_number'     => $this->request->getPost('phone'),
            'email'            => $this->request->getPost('email'),
            'physical_address' => $this->request->getPost('referral') ?? null
        ]);

        $personalId = $this->personalModel->getInsertID();

        // ✅ Save in session
        session()->set('personal_id', $personalId);

        return redirect()->to(site_url('frontend/pbc/business-details'))
                         ->with('message', 'Personal details saved successfully!');
    }

    /** Step 2: Company Details Form */
    public function businessDetails()
    {
        return view('App\Modules\Frontend\Views\pbc\business_details');
    }

    public function processCompanyDetails()
    {
        $applicationId = session()->get('application_id');
        $personalId    = session()->get('personal_id'); // ✅ now defined

        if (!$applicationId || !$personalId) {
            return redirect()->to(site_url('frontend/pbc/start-application'))
                             ->with('error', 'No personal details found. Please start your application.');
        }

        $rules = [
            'name1'            => 'required|min_length[2]',
            'name2'            => 'required|min_length[2]',
            'name3'            => 'permit_empty|min_length[2]',
            'name4'            => 'permit_empty|min_length[2]',
            'physical_address' => 'required',
            'suburb_city'      => 'required',
            'postal_code'      => 'required',
            'business_type'    => 'required',
            'year_end'         => 'required|valid_date[Y-m-d]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $companyData = [
            'application_id'      => $applicationId,
            'personal_details_id' => $personalId,
            'proposed_name_one'   => $this->request->getPost('name1'),
            'proposed_name_two'   => $this->request->getPost('name2'),
            'proposed_name_three' => $this->request->getPost('name3'),
            'proposed_name_four'  => $this->request->getPost('name4'),
            'registration_number' => $this->request->getPost('registration_number'),
            'postal_code'         => $this->request->getPost('postal_code'),
            'suburb_city'         => $this->request->getPost('suburb_city'),
            'country'             => $this->request->getPost('country'),
            'phone_number'        => $this->request->getPost('phone_number'),
            'email'               => $this->request->getPost('email'),
            'website'             => $this->request->getPost('website'),
            'address'             => $this->request->getPost('physical_address'),
            'business_type'       => $this->request->getPost('business_type'),
            'financial_year_end'  => $this->request->getPost('year_end')
        ];
       

        $this->companyModel->insert($companyData);

        return redirect()->to(site_url('frontend/pbc/directors-shareholders'))
                         ->with('message', 'Company details submitted successfully!');
    }

    /** Step 3: Directors & Shareholders Form */
    public function directorsShareholders()
    {
        return view('App\Modules\Frontend\Views\pbc\directors_shareholders');
    }
   public function processShareholders()
{
    $applicationId = session()->get('application_id');
    $personalId    = session()->get('personal_id');

    if (!$applicationId || !$personalId) {
        return redirect()->to(site_url('frontend/pbc/start-application'))
                         ->with('error', 'No application or personal details found. Please start your application.');
    }

    $shareholders = $this->request->getPost('shareholders');
    if (!$shareholders || !is_array($shareholders)) {
        return redirect()->back()->with('error', 'No shareholders submitted.');
    }

    $ids = [];
    $totalShares = 0;

    foreach ($shareholders as $i => $shareholder) {
        $nid = trim($shareholder['national_id'] ?? '');
        $share = floatval($shareholder['shareholding'] ?? 0);

        // Check National ID uniqueness
        if (empty($nid)) {
            return redirect()->back()->withInput()
                             ->with('error', 'National ID is required for all shareholders.');
        }
        if (in_array($nid, $ids)) {
            return redirect()->back()->withInput()
                             ->with('error', 'Each shareholder must have a unique National ID. Duplicate found: ' . $nid);
        }
        $ids[] = $nid;

        // Sum shares
        $totalShares += $share;
    }

    if ($totalShares > 100) {
        return redirect()->back()->withInput()
                         ->with('error', 'Total shareholding cannot exceed 100%. Currently: ' . $totalShares . '%');
    }

    // Insert shareholders
    foreach ($shareholders as $i => $shareholder) {
        $data = [
            'application_id'      => $applicationId,
            'personal_details_id' => $personalId,
            'full_name'           => $shareholder['full_name'] ?? '',
            'national_id'         => $shareholder['national_id'] ?? '',
            'nationality'         => $shareholder['nationality'] ?? '',
            'shareholding'        => $shareholder['shareholding'] ?? 0,
            'email'               => $shareholder['email'] ?? '',
            'phone_number'        => $shareholder['phone_number'] ?? '',
            'is_director'         => !empty($shareholder['is_director']) ? 1 : 0,
            'gender'              => $shareholder['gender'] ?? '',
            'date_of_birth'       => $shareholder['date_of_birth'] ?? null,
            'residential_address' => $shareholder['residential_address'] ?? '',
            'marital_status'      => $shareholder['marital_status'] ?? '',
            'city'                => $shareholder['city'] ?? '',
            'is_beneficial_owner' => !empty($shareholder['is_beneficial_owner']) ? 1 : 0,
        ];

        // Ensure upload directory exists and is writable
        $uploadPath = WRITEPATH . 'uploads/shareholders';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        if (!is_writable($uploadPath)) {
            log_message('error', 'Upload directory is not writable: ' . $uploadPath);
            return redirect()->back()->with('error', 'Server error: Upload directory is not writable');
        }

        // Handle file uploads
        $fileFields = [
            'id_document',
            'proof_of_residence',
            'passport_photo',
            'proof_of_address',
            'share_certificate',
            'company_registration_doc'
        ];

        foreach ($fileFields as $field) {
            $file = $this->request->getFile("shareholders[$i][$field]");
            log_message('debug', "Processing file field: {$field}");
            log_message('debug', 'File info: ' . print_r($file, true));
            
            if ($file === null) {
                log_message('debug', 'No file was uploaded for field: ' . $field);
                continue;
            }
            
            if (!$file->isValid()) {
                $error = $file->getErrorString() ?? 'Unknown error';
                log_message('error', "File validation failed for {$field}: {$error}");
                log_message('debug', 'File error code: ' . $file->getError());
                continue;
            }
            
            if ($file->hasMoved()) {
                log_message('warning', 'File has already been moved: ' . $file->getName());
                continue;
            }
            
            $newName = $file->getRandomName();
            log_message('debug', 'Attempting to move file to: ' . $uploadPath . '/' . $newName);
            
            try {
                $file->move($uploadPath, $newName);
                
                if ($file->hasMoved()) {
                    $data[$field] = $newName;
                    log_message('info', 'File uploaded successfully: ' . $newName . ' (Original: ' . $file->getName() . ')');
                    log_message('debug', 'File size: ' . $file->getSize() . ' bytes');
                    log_message('debug', 'File MIME type: ' . $file->getMimeType());
                } else {
                    $error = $file->getErrorString() ?? 'Unknown error';
                    log_message('error', 'Failed to move uploaded file: ' . $error);
                    log_message('debug', 'Upload path: ' . $uploadPath);
                    log_message('debug', 'Is writable: ' . (is_writable($uploadPath) ? 'Yes' : 'No'));
                }
            } catch (\Exception $e) {
                log_message('error', 'File upload exception: ' . $e->getMessage());
                log_message('debug', 'Exception trace: ' . $e->getTraceAsString());
            }
        }

        $this->shareholderModel->insert($data);
    }

    return redirect()->to(site_url('frontend/pbc/review-submit'))
                     ->with('message', 'Shareholders saved successfully!');
}




    public function reviewSubmit()
{
    $applicationId = session()->get('application_id');
    $personalId    = session()->get('personal_id');

    if (!$applicationId || !$personalId) {
        return redirect()->to(site_url('frontend/pbc/start-application'))
                         ->with('error', 'No application found. Please start your application.');
    }

    // Load models
    $applicationsModel = $this->applicationsModel;
    $personalModel     = $this->personalModel;
    $companyModel      = $this->companyModel;
    $shareholderModel  = $this->shareholderModel;

    // Fetch data
    $application  = $applicationsModel->find($applicationId);
    $personal     = $personalModel->find($personalId);
    $company      = $companyModel->where('application_id', $applicationId)->first();
    $shareholders = $shareholderModel->where('application_id', $applicationId)->findAll();

    return view('App\Modules\Frontend\Views\pbc\review_submit', [
        'application'  => $application,
        'personal'     => $personal,
        'company'      => $company,
        'shareholders' => $shareholders,
    ]);
}

public function submitFinalApplication()
{
    $applicationId = session()->get('application_id');
    $personalId    = session()->get('personal_id');

    if (!$applicationId || !$personalId) {
        return redirect()->to(site_url('frontend/pbc/start-application'))
                         ->with('error', 'No application or personal details found. Please start your application.');
    }

    $userId = auth()->id();

    // Get company details
    $company = $this->companyModel->where('application_id', $applicationId)->first();
    if (!$company) {
        return redirect()->back()->with('error', 'Company details not found.');
    }

    // Get all shareholders
    $shareholders = $this->shareholderModel->where('application_id', $applicationId)
                                           ->findAll();

    // Prepare JSON data
    $submittedData = [
        'personal_details' => $this->personalModel->find($personalId),
        'company_details'  => $company,
        'shareholders'     => $shareholders
    ];

    // Insert into final PBC table
    $this->PbcApplicationModel->insert([
        'user_id'             => $userId,
        'application_id'      => $applicationId,
        'personal_details_id' => $personalId,
        'company_details_id'  => $company['id'],
        'submitted_data'      => json_encode($submittedData),
        'status'              => 'submitted'
    ]);

    // Fetch the reference number from applications table
    $applicationsModel = new \App\Modules\Frontend\Models\ApplicationsModel();
    $application       = $applicationsModel->find($applicationId);
    $referenceNumber   = $application['reference_number'] ?? 'N/A';

    // Pass reference number to confirmation view
    return view('App\Modules\Frontend\Views\pbc\confirmation', [
        'referenceNumber' => $referenceNumber
    ]);
}


 
    public function confirmation()
{
    $applicationId = session()->get('application_id');

    if (!$applicationId) {
        return redirect()->to(site_url('frontend/pbc/start-application'))
                         ->with('error', 'No application found.');
    }

    $applicationsModel = new \App\Modules\Frontend\Models\ApplicationsModel();
    $application = $applicationsModel->find($applicationId);

    $referenceNumber = $application['reference_number'] ?? 'N/A';

    return view('App\Modules\Frontend\Views\pbc\confirmation', [
        'referenceNumber' => $referenceNumber
    ]);
}


};