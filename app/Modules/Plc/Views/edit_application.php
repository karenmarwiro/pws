
<?php include APPPATH . 'Core/Views/Partials/header.php'; ?>
<?php include APPPATH . 'Core/Views/Partials/menu.php'; ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-edit me-2"></i> Edit Application #<?= esc($application['id']) ?>
    </h1>

    <form action="<?= site_url('plc/update/' . $application['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- Personal Details -->
        <h5 class="mt-4">Personal Details</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label>Full Name</label>
                <input type="text" name="personal_details[first_name]" 
                       value="<?= esc($submitted['personal_details']['first_name'] ?? '') ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Last Name</label>
                <input type="text" name="personal_details[last_name]" 
                       value="<?= esc($submitted['personal_details']['last_name'] ?? '') ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Email</label>
                <input type="email" name="personal_details[email]" 
                       value="<?= esc($submitted['personal_details']['email'] ?? '') ?>" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Phone</label>
                <input type="text" name="personal_details[phone_number]" 
                       value="<?= esc($submitted['personal_details']['phone_number'] ?? '') ?>" class="form-control">
            </div>
        </div>

        <!-- Company Details -->
        <h5 class="mt-4">Company Details</h5>
        <div class="row g-3">
            <?php 
                $companyFields = [
                    'proposed_name_one' => 'Proposed Name 1',
                    'proposed_name_two' => 'Proposed Name 2',
                    'proposed_name_three' => 'Proposed Name 3',
                    'proposed_name_four' => 'Proposed Name 4',
                    'business_type' => 'Business Type',
                    'registration_number' => 'Registration Number',
                    'email' => 'Email',
                    'phone_number' => 'Phone Number',
                    'address' => 'Street Address',
                    'suburb_city' => 'City/Suburb',
                    'country' => 'Country'
                ];
            ?>
            <?php foreach ($companyFields as $key => $label): ?>
                <div class="col-md-4 mb-3">
                    <label><?= $label ?></label>
                    <input type="text" name="company_details[<?= $key ?>]" 
                           value="<?= esc($submitted['company_details'][$key] ?? '') ?>" class="form-control">
                </div>
            <?php endforeach; ?>
        </div>

      <h5 class="mt-4">Shareholders</h5>

<?php if (!empty($shareholders)): ?>
    <?php foreach ($shareholders as $i => $s): ?>
        <div class="card mb-4 <?= $i === 0 ? 'border-primary shadow-sm' : '' ?>">
            <div class="card-header <?= $i === 0 ? 'bg-primary text-white' : 'bg-light' ?>">
                <b>Shareholder <?= $i + 1 ?></b>
            </div>
            <div class="card-body">
                <div class="row g-3">

                    <!-- Full Name -->
                    <div class="col-md-6">
                        <label>Full Name</label>
                        <input type="text" name="shareholders[<?= $i ?>][full_name]" 
                               value="<?= esc($s['full_name'] ?? '') ?>" class="form-control">
                    </div>

                    <!-- National ID -->
                    <div class="col-md-6">
                        <label>ID/Passport</label>
                        <input type="text" name="shareholders[<?= $i ?>][national_id]" 
                               value="<?= esc($s['national_id'] ?? '') ?>" class="form-control">
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="shareholders[<?= $i ?>][email]" 
                               value="<?= esc($s['email'] ?? '') ?>" class="form-control">
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <label>Phone</label>
                        <input type="text" name="shareholders[<?= $i ?>][phone_number]" 
                               value="<?= esc($s['phone_number'] ?? '') ?>" class="form-control">
                    </div>

                    <!-- Shareholding -->
                    <div class="col-md-4">
                        <label>Shareholding %</label>
                        <input type="number" name="shareholders[<?= $i ?>][shareholding]" 
                               value="<?= esc($s['shareholding'] ?? 0) ?>" class="form-control">
                    </div>

                    <!-- Director -->
                    <div class="col-md-4 d-flex align-items-center mt-3">
                        <div class="form-check">
                            <input type="hidden" name="shareholders[<?= $i ?>][is_director]" value="0">
                            <input type="checkbox" name="shareholders[<?= $i ?>][is_director]" value="1" 
                                   <?= !empty($s['is_director']) ? 'checked' : '' ?> class="form-check-input">
                            <label class="form-check-label">Director</label>
                        </div>
                    </div>

                    <!-- Beneficial Owner -->
                    <div class="col-md-4 d-flex align-items-center mt-3">
                        <div class="form-check">
                            <input type="hidden" name="shareholders[<?= $i ?>][is_beneficial_owner]" value="0">
                            <input type="checkbox" name="shareholders[<?= $i ?>][is_beneficial_owner]" value="1" 
                                   <?= !empty($s['is_beneficial_owner']) ? 'checked' : '' ?> class="form-check-input">
                            <label class="form-check-label">Beneficial Owner</label>
                        </div>
                    </div>

                    <!-- Documents -->
                    <div class="col-12">
                        <label>Documents</label>
                        
                        <?php 
                            // Determine all possible document fields
                            $docFields = ['id_document', 'passport_photo', 'proof_of_residence', 'share_certificate', 'proof_of_address', 'company_registration_doc'];
                        ?>

                        <?php foreach ($docFields as $docField): ?>
                            <?php if (!empty($s[$docField])): ?>
                                <div class="mb-2">
                                    <span class="me-2"><?= ucwords(str_replace('_', ' ', $docField)) ?>:</span>
                                    <a href="<?= base_url('uploads/shareholders/' . $s[$docField]) ?>" target="_blank" 
                                       class="badge bg-info text-dark me-1 mb-1">
                                        <i class="fas fa-file-alt"></i> <?= esc($s[$docField]) ?>
                                    </a>
                                    <div class="mt-1">
                                        <label class="form-label">Replace</label>
                                        <input type="file" name="shareholders[<?= $i ?>][<?= $docField ?>]" class="form-control">
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <?php if (empty(array_filter(array_map(fn($f) => $s[$f] ?? null, $docFields)))): ?>
                            <p class="text-muted">No documents uploaded</p>
                        <?php endif; ?>
                    </div>

                    <!-- Actions -->
                    <div class="col-12 mt-3">
                        <a href="<?= site_url('plc/shareholder/' . $s['id']) ?>" class="btn btn-sm btn-info mb-1">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <button type="button" class="btn btn-sm btn-secondary mb-1 cancel-row">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No shareholders added yet.</p>
<?php endif; ?>


        <div class="mt-3">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Application</button>
            <a href="<?= site_url('plc/view/' . $application['id']) ?>" class="btn btn-danger"><i class="fas fa-times"></i> Cancel</a>
        </div>
    </form>
</div>

<script>
document.querySelectorAll('.cancel-row').forEach(btn => {
    btn.addEventListener('click', function() {
        const row = this.closest('tr');
        row.querySelectorAll('input').forEach(input => input.value = '');
        row.querySelector('input[type="checkbox"]').checked = false;
    });
});
</script>

<?php include APPPATH . 'Core/Views/Partials/footer.php'; ?>
