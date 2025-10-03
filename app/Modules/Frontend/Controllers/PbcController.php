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
            'national_id'=> 'required|min_length[2]',
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
            'national_id'      => $this->request->getPost('national_id'),
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

    // Ensure the application and personal records exist to satisfy FKs
    $app = $this->applicationsModel->find($applicationId);
    if (!$app) {
        return redirect()->to(site_url('frontend/pbc/start-application'))
                         ->with('error', 'Invalid application reference. Please start your application again.');
    }
    $personal = $this->personalModel->find($personalId);
    if (!$personal) {
        return redirect()->to(site_url('frontend/pbc/personal-details'))
                         ->with('error', 'Personal details not found. Please complete Step 1.');
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

    // Handle inserts with extra fields
    foreach ($shareholders as $index => $shareholder) {

        // Handle file uploads (if any)
        $uploadFields = [
            'id_document', 'proof_of_residence', 'passport_photo',
            'proof_of_address', 'share_certificate', 'company_registration_doc'
        ];
        $uploads = [];

        foreach ($uploadFields as $field) {
            $file = $this->request->getFile("shareholders.$index.$field");
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/shareholders', $newName);
                $uploads[$field] = $newName;
            } else {
                $uploads[$field] = null;
            }
        }

        // Helper to convert empty strings to NULL for nullable columns
        $n = function ($v) { $v = is_string($v) ? trim($v) : $v; return ($v === '' ? null : $v); };

        // Insert into DB
        $this->shareholderModel->insert([
            'application_id'         => $applicationId,
            'personal_details_id'    => $personalId ?: null,
            'full_name'              => trim($shareholder['full_name'] ?? ''),
            'national_id'            => trim($shareholder['national_id'] ?? ''),
            'nationality'            => trim($shareholder['nationality'] ?? ''),
            'shareholding'           => (float) ($shareholder['shareholding'] ?? 0),
            'email'                  => $n($shareholder['email'] ?? null),
            'phone_number'           => $n($shareholder['phone_number'] ?? null),
            'is_director'            => !empty($shareholder['is_director']) ? 1 : 0,
            'gender'                 => $n($shareholder['gender'] ?? null),
            'date_of_birth'          => $n($shareholder['date_of_birth'] ?? null),
            'residential_address'    => $n($shareholder['residential_address'] ?? null),
            'marital_status'         => $n($shareholder['marital_status'] ?? null),
            'city'                   => $n($shareholder['city'] ?? null),
            'is_beneficial_owner'    => !empty($shareholder['is_beneficial_owner']) ? 1 : 0,
            'id_document'            => $uploads['id_document'] ?? null,
            'proof_of_residence'     => $uploads['proof_of_residence'] ?? null,
            'passport_photo'         => $uploads['passport_photo'] ?? null,
            'proof_of_address'       => $uploads['proof_of_address'] ?? null,
            'share_certificate'      => $uploads['share_certificate'] ?? null,
            'company_registration_doc'=> $uploads['company_registration_doc'] ?? null,
        ]);
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

public function updatePersonal()
{
    if (!$this->request->isAJAX()) {
        return redirect()->back();
    }

    $post = $this->request->getPost();
    $applicationId = session()->get('application_id');
    $personalId    = session()->get('personal_id');

    if (!$applicationId || !$personalId) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'No application found. Please start again.'
        ]);
    }

    // ✅ Update personal details in DB
    $updateData = [
        'first_name'   => $post['first_name'] ?? '',
        'last_name'    => $post['last_name'] ?? '',
        'national_id'  => $post['national_id'] ?? '',
        'email'        => $post['email'] ?? '',
        'phone_number' => $post['phone_number'] ?? '',
    ];

    $this->personalModel->update($personalId, $updateData);

    // ✅ Build updated HTML for review page
    $updatedHtml = '';
    $fields = [
        'First Name'  => $updateData['first_name'],
        'Last Name'   => $updateData['last_name'],
        'National ID' => $updateData['national_id'],
        'Email'       => $updateData['email'],
        'Phone'       => $updateData['phone_number'],
    ];

    foreach ($fields as $label => $value) {
        $updatedHtml .= '<div class="detail-item"><span class="detail-label">'
                      . $label . '</span><span class="detail-value">'
                      . esc($value) . '</span></div>';
    }

    return $this->response->setJSON([
        'success' => true,
        'updatedHtml' => $updatedHtml
    ]);
}

public function updateCompany()
{
    if (!$this->request->isAJAX()) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid request.'
        ]);
    }

    $post = $this->request->getPost();
    $applicationId = session()->get('application_id');

    if (!$post || !$applicationId) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'No data submitted or application missing.'
        ]);
    }

    $company = $this->companyModel->where('application_id', $applicationId)->first();

    if ($company) {
        $this->companyModel->update($company['id'], [
            'proposed_name_one'   => $post['proposed_name_one'] ?? $company['proposed_name_one'],
            'proposed_name_two'   => $post['proposed_name_two'] ?? $company['proposed_name_two'],
            'proposed_name_three' => $post['proposed_name_three'] ?? $company['proposed_name_three'],
            'proposed_name_four'  => $post['proposed_name_four'] ?? $company['proposed_name_four'],
            'postal_code'         => $post['postal_code'] ?? $company['postal_code'],
            'suburb_city'         => $post['suburb_city'] ?? $company['suburb_city'],
            'country'             => $post['country'] ?? $company['country'],
            'business_type'       => $post['business_type'] ?? $company['business_type'],
            'financial_year_end'  => $post['financial_year_end'] ?? $company['financial_year_end']
        ]);
    } else {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Company record not found.'
        ]);
    }

    // Build updated HTML
    $updatedHtml = '';
    $fields = [
        'Proposed Name 1' => 'proposed_name_one',
        'Proposed Name 2' => 'proposed_name_two',
        'Proposed Name 3' => 'proposed_name_three',
        'Proposed Name 4' => 'proposed_name_four',
        'Postal Code'     => 'postal_code',
        'City'            => 'suburb_city',
        'Country'         => 'country',
        'Business Type'   => 'business_type',
        'Year End'        => 'financial_year_end'
    ];

    foreach ($fields as $label => $key) {
        $updatedHtml .= '<div class="detail-item"><span class="detail-label">'. $label .'</span><span class="detail-value">'. esc($post[$key] ?? $company[$key]) .'</span></div>';
    }

    return $this->response->setJSON([
        'success' => true,
        'updatedHtml' => $updatedHtml
    ]);
}



public function updateShareholders()
{
    if (!$this->request->isAJAX()) return redirect()->back();

    $applicationId = session()->get('application_id');
    $personalId    = session()->get('personal_id');

    if (!$applicationId || !$personalId) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Missing application or personal details. Please complete personal details first.'
        ]);
    }

    $post  = $this->request->getPost();
    $files = $this->request->getFiles();
    $shareholdersUpdated = [];

    $uploadPath = WRITEPATH . 'uploads/shareholders/';
    if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

    foreach ($post['full_name'] as $i => $fullName) {
        $data = [
            'application_id'      => $applicationId,
            'personal_details_id' => $personalId,
            'full_name'           => $fullName,
            'national_id'         => $post['national_id'][$i] ?? '',
            'nationality'         => $post['nationality'][$i] ?? '',
            'gender'              => $post['gender'][$i] ?? '',
            'date_of_birth'       => $post['date_of_birth'][$i] ?? '',
            'residential_address' => $post['residential_address'][$i] ?? '',
            'marital_status'      => $post['marital_status'][$i] ?? '',
            'city'                => $post['city'][$i] ?? '',
            'email'               => $post['email'][$i] ?? '',
            'phone_number'        => $post['phone_number'][$i] ?? '',
            'shareholding'        => $post['shareholding'][$i] ?? 0,
            'is_director'         => $post['is_director'][$i] ?? 0,
            'is_beneficial_owner' => $post['is_beneficial_owner'][$i] ?? 0,
        ];

        // Files
        foreach (['id_document','proof_of_residence','passport_photo','share_certificate','company_registration_doc'] as $field) {
            $file = $files[$field][$i] ?? null;
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $data[$field] = $file->getRandomName();
                $file->move($uploadPath, $data[$field]);
            }
        }

        // Insert or update
        $existing = $this->shareholderModel
            ->where('personal_details_id', $personalId)
            ->where('full_name', $fullName)
            ->first();

        if ($existing) {
            $this->shareholderModel->update($existing['id'], $data);
        } else {
            $this->shareholderModel->insert($data);
        }

        $shareholdersUpdated[] = $data;
    }

    // Build updated HTML for review table
    $updatedHtml = '';
    foreach ($shareholdersUpdated as $i => $s) {
        $updatedHtml .= '<tr>';
        $updatedHtml .= '<td>'.($i+1).'</td>';
        $updatedHtml .= '<td>'.esc($s['full_name']).'</td>';
        $updatedHtml .= '<td>'.esc($s['national_id']).'</td>';
        $updatedHtml .= '<td>'.esc($s['nationality']).'</td>';
        $updatedHtml .= '<td>'.esc($s['gender']).'</td>';
        $updatedHtml .= '<td>'.esc($s['date_of_birth']).'</td>';
        $updatedHtml .= '<td>'.esc($s['residential_address']).'</td>';
        $updatedHtml .= '<td>'.esc($s['marital_status']).'</td>';
        $updatedHtml .= '<td>'.esc($s['city']).'</td>';
        $updatedHtml .= '<td>'.esc($s['email']).'</td>';
        $updatedHtml .= '<td>'.esc($s['phone_number']).'</td>';
        $updatedHtml .= '<td>'.esc($s['shareholding']).'%</td>';
        $updatedHtml .= '<td>'.($s['is_director'] ? 'Yes' : 'No').'</td>';
        $updatedHtml .= '<td>'.($s['is_beneficial_owner'] ? 'Yes' : 'No').'</td>';

        foreach (['id_document','proof_of_residence','passport_photo','share_certificate','company_registration_doc'] as $fileField) {
            $updatedHtml .= '<td>';
            if (!empty($s[$fileField])) {
                $updatedHtml .= '<a href="'.base_url('uploads/shareholders/'.$s[$fileField]).'" target="_blank">View</a>';
            }
            $updatedHtml .= '</td>';
        }
        $updatedHtml .= '</tr>';
    }

    return $this->response->setJSON([
        'success' => true,
        'updatedHtml' => $updatedHtml
    ]);
}




};