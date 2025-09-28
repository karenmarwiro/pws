<?php 

namespace App\Modules\Frontend\Controllers;

use App\Modules\Frontend\Models\ApplicationsModel;
use App\Modules\Frontend\Models\PersonalDetailsModel;
use App\Modules\Frontend\Models\CompanyDetailsModel;
use App\Modules\Frontend\Models\ShareholdersModel;
use App\Modules\Frontend\Models\PlcApplicationModel;
use CodeIgniter\Controller;

class PlcController extends Controller
{
    protected $applicationsModel;
    protected $personalModel;
    protected $companyModel;
    protected $shareholderModel;
    protected $PlcApplicationModel;

    public function __construct()
    {
        helper(['form', 'url', 'session']);
        $this->applicationsModel = new ApplicationsModel();
        $this->personalModel     = new PersonalDetailsModel();
        $this->companyModel      = new CompanyDetailsModel();
        $this->shareholderModel  = new ShareholdersModel();
        $this->PlcApplicationModel  = new PlcApplicationModel();
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
    $referenceNumber = 'PLC-' . $datePart . '-' . $sequence;

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

    return redirect()->to(site_url('frontend/plc/personal-details'));
}


    /** Step 1: Personal Details Form */
    public function personalDetails()
    {
        return view('App\Modules\Frontend\Views\plc\personal_details');
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
            return redirect()->to(site_url('frontend/plc/start-application'))
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

        return redirect()->to(site_url('frontend/plc/business-details'))
                         ->with('message', 'Personal details saved successfully!');
    }

    /** Step 2: Company Details Form */
    public function businessDetails()
    {
        return view('App\Modules\Frontend\Views\plc\business_details');
    }

    public function processCompanyDetails()
    {
        $applicationId = session()->get('application_id');
        $personalId    = session()->get('personal_id'); // ✅ now defined

        if (!$applicationId || !$personalId) {
            return redirect()->to(site_url('frontend/plc/start-application'))
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

        return redirect()->to(site_url('frontend/plc/directors-shareholders'))
                         ->with('message', 'Company details submitted successfully!');
    }

    /** Step 3: Directors & Shareholders Form */
    public function directorsShareholders()
    {
        return view('App\Modules\Frontend\Views\plc\directors_shareholders');
    }
    public function processShareholders()
{
    $applicationId = session()->get('application_id');
    $personalId    = session()->get('personal_id');

    if (!$applicationId || !$personalId) {
        return redirect()->to(site_url('frontend/plc/start-application'))
                         ->with('error', 'No application or personal details found. Please start your application.');
    }

    $shareholders = $this->request->getPost('shareholders');
    if (!$shareholders || !is_array($shareholders)) {
        return redirect()->back()->with('error', 'No shareholders submitted.');
    }

    // Check for duplicate National IDs
    $ids = [];
    foreach ($shareholders as $shareholder) {
        $nid = trim($shareholder['national_id'] ?? '');
        if (empty($nid)) {
            return redirect()->back()->withInput()
                             ->with('error', 'National ID is required for all shareholders.');
        }
        if (in_array($nid, $ids)) {
            return redirect()->back()->withInput()
                             ->with('error', 'Each shareholder must have a unique National ID. Duplicate found: ' . $nid);
        }
        $ids[] = $nid;
    }

    // Insert shareholders
    foreach ($shareholders as $shareholder) {
        $this->shareholderModel->insert([
            'application_id'      => $applicationId,
            'personal_details_id' => $personalId,
            'full_name'           => $shareholder['full_name'] ?? '',
            'national_id'         => $shareholder['national_id'] ?? '',
            'nationality'         => $shareholder['nationality'] ?? '',
            'shareholding'        => $shareholder['shareholding'] ?? 0,
            'email'               => $shareholder['email'] ?? '',
            'phone_number'        => $shareholder['phone_number'] ?? '',
            'is_director'         => !empty($shareholder['is_director']) ? 1 : 0,
        ]);
    }

    return redirect()->to(site_url('frontend/plc/review-submit'))
                     ->with('message', 'Shareholders saved successfully!');
}


    public function reviewSubmit()
{
    $applicationId = session()->get('application_id');
    $personalId    = session()->get('personal_id');

    if (!$applicationId || !$personalId) {
        return redirect()->to(site_url('frontend/plc/start-application'))
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

    return view('App\Modules\Frontend\Views\plc\review_submit', [
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
        return redirect()->to(site_url('frontend/plc/start-application'))
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

    // Insert into final PLC table
    $this->PlcApplicationModel->insert([
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
    return view('App\Modules\Frontend\Views\plc\confirmation', [
        'referenceNumber' => $referenceNumber
    ]);
}


 
    public function confirmation()
{
    $applicationId = session()->get('application_id');

    if (!$applicationId) {
        return redirect()->to(site_url('frontend/plc/start-application'))
                         ->with('error', 'No application found.');
    }

    $applicationsModel = new \App\Modules\Frontend\Models\ApplicationsModel();
    $application = $applicationsModel->find($applicationId);

    $referenceNumber = $application['reference_number'] ?? 'N/A';

    return view('App\Modules\Frontend\Views\plc\confirmation', [
        'referenceNumber' => $referenceNumber
    ]);
}


};