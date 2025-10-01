<?php

namespace App\Modules\Plc\Controllers;

use App\Core\Controllers\AdminController;
use App\Modules\Plc\Models\PlcApplicationModel;
use App\Modules\Frontend\Models\ApplicationsModel;
use App\Modules\Frontend\Models\PersonalDetailsModel;
use App\Modules\Frontend\Models\CompanyDetailsModel;
use App\Modules\Frontend\Models\ShareholdersModel;

class Plc extends AdminController
{
    protected $PlcApplicationModel;
    protected $applicationsModel;
    protected $personalModel;
    protected $companyModel;
    protected $shareholderModel;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        helper(['form', 'url']);

        // Load models once
        $this->plcApplicationModel = new PlcApplicationModel();
        $this->applicationsModel   = new ApplicationsModel();
        $this->personalModel       = new PersonalDetailsModel();
        $this->companyModel        = new CompanyDetailsModel();
        $this->shareholderModel    = new ShareholdersModel();
    }

    public function index()
    {
        return view('App\Modules\Plc\Views\index', [
            'title' => 'PLC Applications Management'
        ]);
    }

   public function getApplications()
{
    $status = $this->request->getGet('status') ?? 'all';

    if ($status === 'pending') {
        // Include both 'pending' and 'processing'
        $applications = $this->plcApplicationModel
                             ->whereIn('status', ['pending', 'processing'])
                             ->orderBy('created_at', 'DESC')
                             ->findAll();
    } elseif ($status === 'approved') {
        $applications = $this->plcApplicationModel
                             ->where('status', 'approved')
                             ->orderBy('created_at', 'DESC')
                             ->findAll();
    } else {
        // All applications
        $applications = $this->plcApplicationModel
                             ->orderBy('created_at', 'DESC')
                             ->findAll();
    }

    // Decode submitted_data + fetch reference number
    $applications = array_map(function ($app) {
        $submitted = json_decode($app['submitted_data'], true);

        $personal = $submitted['personal_details'] ?? [];
        $company  = $submitted['company_details'] ?? [];

        // Fetch reference_number from applications table
        $applicationRow = $this->applicationsModel->find($app['application_id']);

        $app['reference_number'] = $applicationRow['reference_number'] ?? 'N/A';
        $app['applicant_name']   = trim(($personal['first_name'] ?? '') . ' ' . ($personal['last_name'] ?? ''));
        $app['business_name']    = $company['proposed_name_one'] ?? 'N/A';

        return $app;
    }, $applications);

    return view('App\Modules\Plc\Views\application_list', [
        'applications' => $applications,
        'status'       => $status
    ]);
}

   public function view($id = null)
    {
        $application = $this->plcApplicationModel->find($id);

        if (empty($application)) {
            return redirect()->back()->with('error', 'Application not found.');
        }

        $submittedData = json_decode($application['submitted_data'], true);

        return view('App\Modules\Plc\Views\view_application', [
            'title'       => 'View Application',
            'application' => $application,
            'submitted'   => $submittedData,
        ]);
    }

   public function updateStatus($id)
{
    $status = $this->request->getPost('status');

    if (!$status) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Status not provided.'
        ]);
    }

    $validStatuses = ['pending', 'submitted', 'processing', 'approved', 'rejected'];

    if (!in_array($status, $validStatuses)) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Invalid status: ' . $status
        ]);
    }

    $this->plcApplicationModel->update($id, [
        'status'     => $status,
        'updated_at' => date('Y-m-d H:i:s')
    ]);

    return $this->response->setJSON([
        'success'   => true,
        'message'   => 'Application status updated successfully.',
        'newStatus' => $status,
        'id'        => $id
    ]);
}

public function edit($id = null)
{
    $application = $this->plcApplicationModel->find($id);

    if (empty($application)) {
        return redirect()->back()->with('error', 'Application not found.');
    }

    // Decode submitted_data safely
    $submitted = !empty($application['submitted_data']) ? json_decode($application['submitted_data'], true) : [];

    // Make sure 'shareholders' key exists
    $shareholders = $submitted['shareholders'] ?? [];

    return view('App\Modules\Plc\Views\edit_application', [
        'title'        => 'Edit Application',
        'application'  => $application,
        'submitted'    => $submitted,
        'shareholders' => $shareholders
    ]);
}



public function update($id = null)
{
    if (!$id) {
        return redirect()->to(site_url('plc'))->with('error', 'Application ID not provided.');
    }

    $application = $this->applicationsModel->find($id);
    if (!$application) {
        return redirect()->to(site_url('plc'))->with('error', 'Application not found.');
    }

    $data = $this->request->getPost();

    if (!$data) {
        return redirect()->back()->with('error', 'No data submitted.');
    }

    // Decode existing submitted_data or initialize empty array
    $existing = json_decode($application['submitted_data'] ?? '{}', true);

    // Merge recursively while keeping nested arrays intact
    $updatedData = $this->array_merge_recursive_distinct($existing, $data);

    // Encode back to JSON and save
    $application['submitted_data'] = json_encode($updatedData);

    if ($this->applicationsModel->update($id, $application)) {
        return redirect()->to(site_url('plc/view/' . $id))
                         ->with('message', 'Application updated successfully!');
    } else {
        return redirect()->back()->with('error', 'Failed to update application.');
    }
}

// --- Add this helper function inside the controller ---
private function array_merge_recursive_distinct(array $array1, array $array2)
{
    $merged = $array1;

    foreach ($array2 as $key => $value) {
        if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
            $merged[$key] = $this->array_merge_recursive_distinct($merged[$key], $value);
        } else {
            $merged[$key] = $value;
        }
    }

    return $merged;
}

public function shareholder($id = null)
{
    if (!$id) {
        return redirect()->back()->with('error', 'Shareholder ID not provided.');
    }

    // 1. Get shareholder details
    $shareholder = $this->shareholderModel->find($id);

    if (!$shareholder) {
        return redirect()->back()->with('error', 'Shareholder not found.');
    }

    // 2. Get all companies linked to this shareholder via pivot table
    $db = \Config\Database::connect();

    $companies = $db->table('company_shareholders cs')
        ->select('cd.id, cd.proposed_name_one, cd.business_type, cd.registration_number, cd.email, cd.phone_number')
        ->join('company_details cd', 'cd.id = cs.company_id')
        ->where('cs.shareholder_id', $id)
        ->get()
        ->getResultArray();

    return view('App\Modules\Plc\Views\view_shareholder', [
        'title'       => 'View Shareholder',
        'shareholder' => $shareholder,
        'companies'   => $companies,
    ]);
}



    public function delete($id = null)
    {
        if (!$this->request->is('post')) {
            return redirect()->back()->with('error', 'Invalid request method.');
        }

        $application = $this->plcApplicationModel->find($id);
        if (!$application) {
            return redirect()->back()->with('error', 'Application not found.');
        }

        // Delete linked data
        if (!empty($application['personal_details_id'])) {
            $this->personalModel->delete($application['personal_details_id']);
        }

        if (!empty($application['company_details_id'])) {
            $this->companyModel->delete($application['company_details_id']);
        }

        if (!empty($application['application_id'])) {
            $this->shareholderModel->where('application_id', $application['application_id'])->delete();
        }

        // Finally delete the application
        $this->plcApplicationModel->delete($id);

        return redirect()->to(site_url('plc'))
                         ->with('message', 'Application and related records deleted successfully.');
    }

    
}
