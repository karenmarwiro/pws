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

    $post  = $this->request->getPost();
    $files = $this->request->getFiles();

    if (!$post) {
        return redirect()->back()->with('error', 'No data submitted.');
    }

    // ---------- 1. Personal Details ----------
    $personalId = null;
    if (!empty($post['personal_details']['id'])) {
        $personalId = $post['personal_details']['id'];
        $personalData = $post['personal_details'];
        unset($personalData['id']);
        $this->personalModel->update($personalId, $personalData);
    } else {
        $personalId = $this->personalModel->insert($post['personal_details']);
    }

    // ---------- 2. Company Details ----------
    $companyId = null;
    if (!empty($post['company_details']['id'])) {
        $companyId = $post['company_details']['id'];
        $companyData = $post['company_details'];
        unset($companyData['id']);
        $this->companyModel->update($companyId, $companyData);
    } else {
        $companyId = $this->companyModel->insert($post['company_details']);
    }

    // ---------- 3. Shareholders ----------
    if (!empty($post['shareholders'])) {
        foreach ($post['shareholders'] as $i => $s) {
            $shareholderId = $s['id'] ?? null;
            $updateData = $s;
            unset($updateData['id']);

            // Required foreign keys
            $updateData['personal_details_id'] = $personalId;
            $updateData['application_id'] = $application['application_id'] ?? $id;

            // Checkboxes
            $updateData['is_director'] = !empty($updateData['is_director']) ? 1 : 0;
            $updateData['is_beneficial_owner'] = !empty($updateData['is_beneficial_owner']) ? 1 : 0;

            // ---------- Handle file uploads ----------
            if (!empty($files['shareholders'][$i])) {
                foreach ($files['shareholders'][$i] as $field => $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move(WRITEPATH . 'uploads/shareholders/', $newName);
                        $updateData[$field] = $newName;
                    }
                }
            }

            if ($shareholderId) {
                $this->shareholderModel->update($shareholderId, $updateData);
            } else {
                $this->shareholderModel->insert($updateData);
            }
        }
    }

    // ---------- 4. Update main application record ----------
    $this->plcApplicationModel->update($id, [
        'personal_details_id' => $personalId,
        'company_details_id'  => $companyId,
        'updated_at'          => date('Y-m-d H:i:s'),
    ]);

    return redirect()->to(site_url('plc/view/' . $id))
                     ->with('message', 'Application updated successfully!');
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
