<?php

namespace App\Modules\Pbc\Controllers;

use App\Core\Controllers\AdminController;
use App\Modules\Pbc\Models\PbcApplicationModel;
use App\Modules\Frontend\Models\ApplicationsModel;
use App\Modules\Frontend\Models\PersonalDetailsModel;
use App\Modules\Frontend\Models\CompanyDetailsModel;
use App\Modules\Frontend\Models\ShareholdersModel;

class Pbc extends AdminController
{
    protected $pbcApplicationModel;
    protected $applicationsModel;
    protected $personalModel;
    protected $companyModel;
    protected $shareholderModel;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);

        helper(['form', 'url']);

        // Load models once
        $this->pbcApplicationModel = new PbcApplicationModel();
        $this->applicationsModel   = new ApplicationsModel();
        $this->personalModel       = new PersonalDetailsModel();
        $this->companyModel        = new CompanyDetailsModel();
        $this->shareholderModel    = new ShareholdersModel();
    }

    public function index()
    {
        return view('App\Modules\Pbc\Views\index', [
            'title' => 'PBC Applications Management'
        ]);
    }

    public function getApplications()
    {
        $status = $this->request->getGet('status') ?? 'all';

        if ($status !== 'all') {
            $applications = $this->pbcApplicationModel->where('status', $status)
                                ->orderBy('created_at', 'DESC')
                                ->findAll();
        } else {
            $applications = $this->pbcApplicationModel->orderBy('created_at', 'DESC')
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

        return view('App\Modules\Pbc\Views\application_list', [
            'applications' => $applications,
            'status'       => $status
        ]);
    }

    public function view($id = null)
    {
        $application = $this->pbcApplicationModel->find($id);

        if (empty($application)) {
            return redirect()->back()->with('error', 'Application not found.');
        }

        $submittedData = json_decode($application['submitted_data'], true);

        return view('App\Modules\Pbc\Views\view_application', [
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

    $this->pbcApplicationModel->update($id, [
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


    public function delete($id = null)
    {
        if (!$this->request->is('post')) {
            return redirect()->back()->with('error', 'Invalid request method.');
        }

        $application = $this->pbcApplicationModel->find($id);
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
        $this->pbcApplicationModel->delete($id);

        return redirect()->to(site_url('pbc'))
                         ->with('message', 'Application and related records deleted successfully.');
    }

    
}
