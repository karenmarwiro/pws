
<?php include APPPATH . 'Core/Views/Partials/header.php'; ?>
<?php include APPPATH . 'Core/Views/Partials/menu.php'; ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-edit me-2"></i> Edit Application #<?= esc($application['id']) ?>
    </h1>

    <form action="<?= site_url('pbc/update/' . $application['id']) ?>" method="post" enctype="multipart/form-data">
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

        <!-- Shareholders Table -->
<h5 class="mt-4">Shareholders</h5>
<?php if (!empty($shareholders)): ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>ID/Passport</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Shareholding %</th>
                    <th>Director</th>
                    <th>Documents</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shareholders as $i => $s): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <input type="text" name="shareholders[<?= $i ?>][full_name]" 
                                   value="<?= esc($s['full_name'] ?? '') ?>" class="form-control">
                        </td>
                        <td>
                            <input type="text" name="shareholders[<?= $i ?>][national_id]" 
                                   value="<?= esc($s['national_id'] ?? '') ?>" class="form-control">
                        </td>
                        <td>
                            <input type="email" name="shareholders[<?= $i ?>][email]" 
                                   value="<?= esc($s['email'] ?? '') ?>" class="form-control">
                        </td>
                        <td>
                            <input type="text" name="shareholders[<?= $i ?>][phone_number]" 
                                   value="<?= esc($s['phone_number'] ?? '') ?>" class="form-control">
                        </td>
                        <td>
                            <input type="number" name="shareholders[<?= $i ?>][shareholding]" 
                                   value="<?= esc($s['shareholding'] ?? 0) ?>" class="form-control">
                        </td>
                        <td class="text-center">
                            <input type="checkbox" name="shareholders[<?= $i ?>][is_director]" 
                                   value="1" <?= !empty($s['is_director']) ? 'checked' : '' ?>>
                        </td>
                        <td>
                            <!-- Existing documents -->
                            <?php if (!empty($s['documents'])): ?>
                                <div class="mb-2">
                                    <?php foreach ($s['documents'] as $doc): ?>
                                        <a href="<?= base_url('uploads/shareholders/' . $doc) ?>" 
                                           target="_blank" class="badge bg-info text-dark me-1">
                                           <i class="fas fa-file-alt"></i> <?= esc($doc) ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No documents</p>
                            <?php endif; ?>

                            <!-- Upload new -->
                            <input type="file" name="shareholders[<?= $i ?>][documents][]" 
                                   class="form-control" multiple>
                        </td>
                        <td>
                            <a href="<?= site_url('pbc/shareholder/' . $s['id']) ?>" 
                               class="btn btn-sm btn-info mb-1">
                               <i class="fas fa-eye"></i> View
                            </a>
                            <button type="button" class="btn btn-sm btn-secondary mb-1 cancel-row">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p>No shareholders added yet.</p>
<?php endif; ?>


        <div class="mt-3">
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Application</button>
            <a href="<?= site_url('pbc/view/' . $application['id']) ?>" class="btn btn-danger"><i class="fas fa-times"></i> Cancel</a>
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
