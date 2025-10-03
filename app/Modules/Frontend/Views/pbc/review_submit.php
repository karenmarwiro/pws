<?= $this->extend('App\Modules\Frontend\Views\Layouts\default') ?>

<?= $this->section('title') ?>Confirmation | Alpha Empire<?= $this->endSection() ?>

<?= $this->section('styles') ?>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6a11cb;
            --secondary: #2575fc;
            --success: #28a745;
            --light-bg: #f8f9fa;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            color: #333;
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .review-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }
        
        .card-header {
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: none;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .section-title {
            position: relative;
            padding-bottom: 12px;
            margin-bottom: 1.5rem;
            font-weight: 600;
            color: var(--primary);
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 3px;
        }
        
        .detail-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid #f0f0f0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .detail-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f5f5f5;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 500;
            color: #666;
            flex: 1;
        }
        
        .detail-value {
            font-weight: 500;
            color: #333;
            flex: 2;
            text-align: right;
        }
        
        .shareholders-table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }
        
        .shareholders-table thead {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }
        
        .shareholders-table th {
            font-weight: 500;
            padding: 1rem;
        }
        
        .shareholders-table td {
            padding: 1rem;
            vertical-align: middle;
        }
        
        .shareholders-table tbody tr {
            transition: background-color 0.2s;
        }
        
        .shareholders-table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }
        
        .shareholders-table tbody tr:hover {
            background-color: #f0f4ff;
        }
        
        .badge-dir {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 0.35em 0.65em;
            border-radius: 50px;
            font-size: 0.75em;
            font-weight: 500;
        }
        
        .btn {
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-secondary {
            border: 2px solid #6c757d;
            color: #6c757d;
        }
        
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
        }
        
        .progress-container {
            max-width: 800px;
            margin: 0 auto 2rem auto;
        }
        
        .progress {
            height: 10px;
            border-radius: 10px;
            background-color: #e9ecef;
            overflow: hidden;
        }
        
        .progress-bar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }
        
        .step-text {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }
        
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
            
            .detail-item {
                flex-direction: column;
            }
            
            .detail-value {
                text-align: left;
                margin-top: 5px;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="review-container">

        <div class="card">
            <div class="card-header text-center">
                <h4><i class="fas fa-check-circle me-2"></i> Review Your Application</h4>
                <p class="mb-0">Verify your details before final submission</p>
            </div>
            <div class="card-body">
                <!-- Personal Details -->
 <h5 class="section-title d-flex justify-content-between align-items-center">
    <span><i class="fas fa-user me-2"></i> Personal Details</span>
    <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editPersonalModal">
    <i class="fas fa-edit"></i> Edit
</a>

</h5>
<div class="detail-card">
    <?php
    $personalDetails = [
        ['First Name', esc($personal['first_name'])],
        ['Last Name', esc($personal['last_name'])],
        ['National ID', esc($personal['national_id'])],
        ['Email', esc($personal['email'])],
        ['Phone', esc($personal['phone_number'])]
    ];
    foreach ($personalDetails as $detail): ?>
        <div class="detail-item">
            <span class="detail-label"><?= $detail[0] ?></span>
            <span class="detail-value"><?= $detail[1] ?></span>
        </div>
    <?php endforeach; ?>
</div>

<!-- Company Details -->
<h5 class="section-title d-flex justify-content-between align-items-center">
    <span><i class="fas fa-user me-2"></i> Company Details</span>
    <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCompanyModal">
    <i class="fas fa-edit"></i> Edit
</a>

</h5>
<div class="detail-card">
    <?php
    $companyDetails = [
        ['Proposed Name 1', esc($company['proposed_name_one'])],
        ['Proposed Name 2', esc($company['proposed_name_two'])],
        ['Proposed Name 3', esc($company['proposed_name_three'])],
        ['Proposed Name 4', esc($company['proposed_name_four'])],
        ['Postal Code', esc($company['postal_code'])],
        ['City', esc($company['suburb_city'])],
        ['Country', esc($company['country'])],
        ['Business Type', esc($company['business_type'])],
        ['Year End', esc($company['financial_year_end'])]
    ];
    foreach ($companyDetails as $detail): ?>
        <div class="detail-item">
            <span class="detail-label"><?= $detail[0] ?></span>
            <span class="detail-value"><?= $detail[1] ?></span>
        </div>
    <?php endforeach; ?>
</div>

<!-- Shareholders -->
<h5 class="section-title d-flex justify-content-between align-items-center">
    <span><i class="fas fa-user me-2"></i> Shareholders</span>
    <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editShareholderModal">
    <i class="fas fa-edit"></i> Edit
</a>
</h5>

<div class="table-responsive">
    <table class="table shareholders-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>ID/Passport</th>
                <th>Nationality</th>
                <th>Gender</th>
                <th>DOB</th>
                <th>Residential Address</th>
                <th>Marital Status</th>
                <th>City</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Shareholding</th>
                <th>Director</th>
                <th>Beneficial Owner</th>
                <th>ID Document</th>
                <th>Proof of Residence</th>
                <th>Passport Photo</th>
                <th>Share Certificate</th>
                <th>Company Reg. Doc</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shareholders as $i => $s): ?>
                <tr>
                    <td><strong><?= $i + 1 ?></strong></td>
                    <td><?= esc($s['full_name']) ?></td>
                    <td><?= esc($s['national_id']) ?></td>
                    <td><?= esc($s['nationality']) ?></td>
                    <td><?= esc($s['gender'] ?? '') ?></td>
                    <td><?= esc($s['date_of_birth'] ?? '') ?></td>
                    <td><?= esc($s['residential_address'] ?? '') ?></td>
                    <td><?= esc($s['marital_status'] ?? '') ?></td>
                    <td><?= esc($s['city'] ?? '') ?></td>
                    <td><?= esc($s['email']) ?></td>
                    <td><?= esc($s['phone_number'] ?? '') ?></td>
                    <td><strong><?= esc($s['shareholding']) ?>%</strong></td>
                    <td>
                        <?php if (!empty($s['is_director'])): ?>
                            <span class="badge badge-dir">Yes</span>
                        <?php else: ?>
                            <span class="text-muted">No</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($s['is_beneficial_owner'])): ?>
                            <span class="badge bg-success">Yes</span>
                        <?php else: ?>
                            <span class="text-muted">No</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($s['id_document'])): ?>
                            <a href="<?= base_url('uploads/shareholders/' . $s['id_document']) ?>" target="_blank">View</a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($s['proof_of_residence'])): ?>
                            <a href="<?= base_url('uploads/shareholders/' . $s['proof_of_residence']) ?>" target="_blank">View</a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($s['passport_photo'])): ?>
                            <a href="<?= base_url('uploads/shareholders/' . $s['passport_photo']) ?>" target="_blank">View</a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($s['share_certificate'])): ?>
                            <a href="<?= base_url('uploads/shareholders/' . $s['share_certificate']) ?>" target="_blank">View</a>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (!empty($s['company_registration_doc'])): ?>
                            <a href="<?= base_url('uploads/shareholders/' . $s['company_registration_doc']) ?>" target="_blank">View</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>



                <!-- Action buttons -->
                <div class="d-flex justify-content-between action-buttons mt-5">
                    <a href="<?= site_url('frontend/pbc/directors-shareholders') ?>" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-arrow-left me-2"></i> Back
                    </a>
                    <form action="<?= site_url('frontend/pbc/submit-final') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <!-- You can optionally show a checkbox: "I confirm all details are correct" -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="confirm" id="confirm" required>
                            <label class="form-check-label" for="confirm">
                                I confirm that all information provided is correct.
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Submit Application
                        </button>
                    </form>

                     
                </div>
            </div>
        </div>

                <div class="text-center mt-4">
                    <div class="progress mt-4" style="height: 8px;">
                        <div class="progress-bar" role="progressbar" style="width: 100%;" 
                             aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted">Step 4 of 4 - Review and Submit</small>
                </div>
    </div>


<!-- Edit Personal Details Modal -->
<div class="modal fade" id="editPersonalModal" tabindex="-1" aria-labelledby="editPersonalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="editPersonalForm">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h5 class="modal-title" id="editPersonalModalLabel"><i class="fas fa-user me-2"></i> Edit Personal Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label>First Name</label>
              <input type="text" name="first_name" value="<?= esc($personal['first_name'] ?? '') ?>" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Last Name</label>
              <input type="text" name="last_name" value="<?= esc($personal['last_name'] ?? '') ?>" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>National ID</label>
              <input type="text" name="national_id" value="<?= esc($personal['national_id'] ?? '') ?>" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label>Email</label>
              <input type="email" name="email" value="<?= esc($personal['email'] ?? '') ?>" class="form-control" required>
            </div>

             <div class="col-md-6">
              <label>Phone</label>
              <input type="text" name="phone_number" value="<?= esc($personal['phone_number'] ?? '') ?>" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end of personal detetails modal -->

<!-- Edit Company Details Modal -->
<div class="modal fade" id="editCompanyModal" tabindex="-1" aria-labelledby="editCompanyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="editCompanyForm" method="post">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h5 class="modal-title" id="editCompanyModalLabel">
            <i class="fas fa-building me-2"></i> Edit Company Details
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label>Proposed Name 1</label>
              <input type="text" name="proposed_name_one" class="form-control" value="<?= esc($company['proposed_name_one'] ?? '') ?>" required>
            </div>
            <div class="col-md-6">
              <label>Proposed Name 2</label>
              <input type="text" name="proposed_name_two" class="form-control" value="<?= esc($company['proposed_name_two'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label>Proposed Name 3</label>
              <input type="text" name="proposed_name_three" class="form-control" value="<?= esc($company['proposed_name_three'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label>Proposed Name 4</label>
              <input type="text" name="proposed_name_four" class="form-control" value="<?= esc($company['proposed_name_four'] ?? '') ?>">
            </div>
            <div class="col-md-4">
              <label>Postal Code</label>
              <input type="text" name="postal_code" class="form-control" value="<?= esc($company['postal_code'] ?? '') ?>">
            </div>
            <div class="col-md-4">
              <label>City/Suburb</label>
              <input type="text" name="suburb_city" class="form-control" value="<?= esc($company['suburb_city'] ?? '') ?>">
            </div>
            <div class="col-md-4">
              <label>Country</label>
              <input type="text" name="country" class="form-control" value="<?= esc($company['country'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label>Business Type</label>
              <input type="text" name="business_type" class="form-control" value="<?= esc($company['business_type'] ?? '') ?>">
            </div>
            <div class="col-md-6">
              <label>Financial Year End</label>
              <input type="text" name="financial_year_end" class="form-control" value="<?= esc($company['financial_year_end'] ?? '') ?>">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- end of company details modal -->

<!-- Edit Shareholders Modal -->
<div class="modal fade" id="editShareholderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="editShareholderForm" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-user-friends me-2"></i> Add / Edit Shareholders</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div id="shareholdersContainer">
            <?php foreach ($shareholders as $i => $s): ?>
            <div class="shareholder-row mb-3 border p-2" data-index="<?= $i ?>">
              <div class="row g-2">
                <div class="col-md-3"><label>Full Name</label><input type="text" name="full_name[]" class="form-control" value="<?= esc($s['full_name']) ?>" required></div>
                <div class="col-md-3"><label>ID/Passport</label><input type="text" name="national_id[]" class="form-control" value="<?= esc($s['national_id']) ?>"></div>
                <div class="col-md-3"><label>Nationality</label><input type="text" name="nationality[]" class="form-control" value="<?= esc($s['nationality']) ?>"></div>
                <div class="col-md-3"><label>Gender</label><input type="text" name="gender[]" class="form-control" value="<?= esc($s['gender']) ?>"></div>
                <div class="col-md-3"><label>DOB</label><input type="date" name="date_of_birth[]" class="form-control" value="<?= esc($s['date_of_birth']) ?>"></div>
                <div class="col-md-3"><label>Residential Address</label><input type="text" name="residential_address[]" class="form-control" value="<?= esc($s['residential_address']) ?>"></div>
                <div class="col-md-3"><label>Marital Status</label><input type="text" name="marital_status[]" class="form-control" value="<?= esc($s['marital_status']) ?>"></div>
                <div class="col-md-3"><label>City</label><input type="text" name="city[]" class="form-control" value="<?= esc($s['city']) ?>"></div>
                <div class="col-md-3"><label>Email</label><input type="email" name="email[]" class="form-control" value="<?= esc($s['email']) ?>"></div>
                <div class="col-md-3"><label>Phone</label><input type="text" name="phone_number[]" class="form-control" value="<?= esc($s['phone_number']) ?>"></div>
                <div class="col-md-3"><label>Shareholding %</label><input type="number" name="shareholding[]" class="form-control" min="0" max="100" value="<?= esc($s['shareholding']) ?>"></div>

                <div class="col-md-3">
                  <label>Director</label>
                  <input type="hidden" name="is_director[<?= $i ?>]" value="0">
                  <input type="checkbox" name="is_director[<?= $i ?>]" value="1" <?= !empty($s['is_director']) ? 'checked' : '' ?>>
                </div>
                <div class="col-md-3">
                  <label>Beneficial Owner</label>
                  <input type="hidden" name="is_beneficial_owner[<?= $i ?>]" value="0">
                  <input type="checkbox" name="is_beneficial_owner[<?= $i ?>]" value="1" <?= !empty($s['is_beneficial_owner']) ? 'checked' : '' ?>>
                </div>

                <div class="col-md-3"><label>ID Document</label><input type="file" name="id_document[]" class="form-control"></div>
                <div class="col-md-3"><label>Proof of Residence</label><input type="file" name="proof_of_residence[]" class="form-control"></div>
                <div class="col-md-3"><label>Passport Photo</label><input type="file" name="passport_photo[]" class="form-control"></div>
                <div class="col-md-3"><label>Share Certificate</label><input type="file" name="share_certificate[]" class="form-control"></div>
                <div class="col-md-3"><label>Company Reg. Doc</label><input type="file" name="company_registration_doc[]" class="form-control"></div>
              </div>
              <button type="button" class="btn btn-sm btn-danger mt-2 remove-shareholder">Remove</button>
            </div>
            <?php endforeach; ?>

            <?php if (empty($shareholders)): ?>
              <!-- empty row -->
              <div class="shareholder-row mb-3 border p-2" data-index="0">
                <div class="row g-2">
                  <?php for($f=0;$f<18;$f++): ?>
                    <div class="col-md-3"><input type="text" class="form-control"></div>
                  <?php endfor; ?>
                </div>
              </div>
            <?php endif; ?>
          </div>

          <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addShareholderRow">
            <i class="fas fa-plus"></i> Add Shareholder
          </button>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Shareholders</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
<!-- end of shareholder details modal -->

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('editPersonalForm');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch("<?= site_url('frontend/pbc/update-personal') ?>", {
            method: "POST",
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Close modal
                var modalEl = document.getElementById('editPersonalModal');
                var modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();

                // Update the review section immediately
                document.querySelector('.detail-card').innerHTML = data.updatedHtml;

                // Optionally show a success toast
                alert('Personal details updated!');
            } else {
                alert(data.message || 'Failed to update.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('An error occurred.');
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const companyForm = document.getElementById('editCompanyForm');

    if (companyForm) {
        companyForm.addEventListener('submit', function(e) {
            e.preventDefault(); // prevent traditional form submission

            const formData = new FormData(companyForm);

            fetch("<?= site_url('frontend/pbc/update-company') ?>", {
                method: "POST",
                body: formData,
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Hide modal
                    const modalEl = document.getElementById('editCompanyModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    modalInstance.hide();

                    // Update company card content
                    const companyCard = document.querySelector('.company-card');
                    if (companyCard) {
                        companyCard.innerHTML = data.updatedHtml;
                    }

                    // Show success toast/alert
                    const toast = document.createElement('div');
                    toast.className = 'alert alert-success mt-3';
                    toast.innerText = 'Company details updated successfully!';
                    document.body.prepend(toast);

                    setTimeout(() => toast.remove(), 3000); // remove after 3 sec
                } else {
                    alert(data.message || 'Failed to update company details.');
                }
            })
            .catch(err => console.error(err));
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('editShareholderForm');
  const container = document.getElementById('shareholdersContainer');
  const addBtn = document.getElementById('addShareholderRow');

  // Add new shareholder row
  addBtn.addEventListener('click', () => {
    const clone = container.querySelector('.shareholder-row').cloneNode(true);
    clone.querySelectorAll('input').forEach(input => input.value = '');
    container.appendChild(clone);
  });

  // Remove shareholder row
  container.addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-shareholder')) {
      const rows = container.querySelectorAll('.shareholder-row');
      if (rows.length > 1) e.target.closest('.shareholder-row').remove();
    }
  });

  // Submit via AJAX
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(form);

    fetch("<?= site_url('frontend/pbc/update-shareholders') ?>", {
      method: "POST",
      body: formData,
      headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        const modal = bootstrap.Modal.getInstance(document.getElementById('editShareholderModal'));
        modal.hide();
        document.querySelector('.shareholders-table tbody').innerHTML = data.updatedHtml;
        alert('Shareholders updated successfully!');
      } else {
        alert(data.message || 'Failed to update shareholders.');
      }
    })
    .catch(err => {
      console.error(err);
      alert('An error occurred.');
    });
  });
});


</script>
<?= $this->endSection() ?>