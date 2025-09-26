<?php

namespace App\Modules\Frontend\Controllers;

use App\Modules\Frontend\Models\PersonalDetailsModel;
use CodeIgniter\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        // Load the profile view
        return view('App\Modules\Frontend\Views\profile');
    }

   public function submit()
{
    helper(['form', 'url']);

    $rules = [
        'firstName'       => 'required|min_length[2]',
        'lastName'        => 'required|min_length[2]',
        'idNumber'        => 'required',
        'dob'             => 'required|valid_date',
        'gender'          => 'required|in_list[male,female,other]',
        'maritalStatus'   => 'required|in_list[single,married,divorced,widowed]',
        'email'           => 'required|valid_email',
        'phone'           => 'required',
        'address'         => 'required',
        'city'            => 'required',
        // make file uploads optional for now
        'idDocument'      => 'if_exist|uploaded[idDocument]|ext_in[idDocument,pdf,jpg,jpeg,png]',
        'proofOfAddress'  => 'if_exist|uploaded[proofOfAddress]|ext_in[proofOfAddress,pdf,jpg,jpeg,png]',
        'passportPhoto'   => 'if_exist|uploaded[passportPhoto]|ext_in[passportPhoto,jpg,jpeg,png]',
    ];

    if (! $this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $personalModel = new PersonalDetailsModel();

    // File handling
    $idDoc = $this->request->getFile('idDocument');
    $proof = $this->request->getFile('proofOfAddress');
    $passport = $this->request->getFile('passportPhoto');

    $idDocPath = $idDoc && $idDoc->isValid() ? $idDoc->store('uploads/id_docs') : null;
    $proofPath = $proof && $proof->isValid() ? $proof->store('uploads/proofs') : null;
    $passportPath = $passport && $passport->isValid() ? $passport->store('uploads/passports') : null;

    $data = [
        'first_name'      => $this->request->getPost('firstName'),
        'last_name'       => $this->request->getPost('lastName'),
        'national_id'     => $this->request->getPost('idNumber'),
        'date_of_birth'   => $this->request->getPost('dob'),
        'gender'          => $this->request->getPost('gender'),
        'marital_status'  => $this->request->getPost('maritalStatus'),
        'email'           => $this->request->getPost('email'),
        'phone_number'    => $this->request->getPost('phone'),
        'physical_address'=> $this->request->getPost('address'),
        'city'            => $this->request->getPost('city'),
        'id_document'     => $idDocPath,
        'proof_of_address'=> $proofPath,
        'passport_photo'  => $passportPath,
    ];

    $personalModel->insert($data);

    return redirect()->to(site_url('frontend/dashboard'))->with('success', 'Profile saved successfully!');
}


}
