<?php include APPPATH . 'Core/Views/Partials/header.php'; ?>
<?php include APPPATH . 'Core/Views/Partials/menu.php'; ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-eye me-2"></i> View Application #<?= esc($application['id']) ?>
    </h1>

    <!-- Status Update -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form id="statusForm" class="d-flex align-items-center gap-2">
                <?= csrf_field() ?>
                <label for="status" class="fw-bold me-2">Application Status:</label>
                <select class="form-select w-auto" name="status" id="status">
                    <option value="pending"   <?= $application['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="submitted" <?= $application['status'] === 'submitted' ? 'selected' : '' ?>>Submitted</option>
                    <option value="processing"<?= $application['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                    <option value="approved"  <?= $application['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                    <option value="rejected"  <?= $application['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                </select>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-sync-alt"></i> Update
                </button>
            </form>
            <div id="statusMessage" class="mt-2"></div>
        </div>
    </div>

    <!-- Submitted Information -->
    <div class="card shadow-sm">
        <div class="card-header fw-bold bg-primary text-white">
            <i class="fas fa-info-circle me-2"></i> Submitted Information
        </div>
        <div class="card-body">

            <!-- Personal Details -->
            <div class="mb-4">
                <h5 class="fw-bold text-secondary"><i class="fas fa-user me-2"></i> Personal Details</h5>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Full Name:</b> <?= esc(($submitted['personal_details']['first_name'] ?? '') . ' ' . ($submitted['personal_details']['last_name'] ?? '')) ?></li>
                            <li class="list-group-item"><b>National ID:</b> <?= esc($submitted['personal_details']['national_id'] ?? 'N/A') ?></li>
                            <li class="list-group-item"><b>Email:</b> <?= esc($submitted['personal_details']['email'] ?? 'N/A') ?></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Phone:</b> <?= esc($submitted['personal_details']['phone_number'] ?? 'N/A') ?></li>
                            <li class="list-group-item"><b>Address:</b> <?= esc($submitted['personal_details']['physical_address'] ?? 'N/A') ?>, <?= esc($submitted['personal_details']['city'] ?? '') ?></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Company Details -->
            <div class="mb-4">
                <h5 class="fw-bold text-secondary"><i class="fas fa-building me-2"></i> Company Details</h5>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Proposed Name 1:</b> <?= esc($submitted['company_details']['proposed_name_one'] ?? 'N/A') ?></li>
                            <li class="list-group-item"><b>Proposed Name 2:</b> <?= esc($submitted['company_details']['proposed_name_two'] ?? 'N/A') ?></li>
                            <li class="list-group-item"><b>Proposed Name 3:</b> <?= esc($submitted['company_details']['proposed_name_three'] ?? 'N/A') ?></li>
                            <li class="list-group-item"><b>Proposed Name 4:</b> <?= esc($submitted['company_details']['proposed_name_four'] ?? 'N/A') ?></li>
                            <li class="list-group-item"><b>Business Type:</b> <?= esc($submitted['company_details']['business_type'] ?? 'N/A') ?></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Registration No:</b> <?= esc($submitted['company_details']['registration_number'] ?? 'N/A') ?></li>
                            <li class="list-group-item"><b>Email:</b> <?= esc($submitted['company_details']['email'] ?? 'N/A') ?></li>
                            <li class="list-group-item"><b>Phone:</b> <?= esc($submitted['company_details']['phone_number'] ?? 'N/A') ?></li>
                            <li class="list-group-item"><b>Address:</b> <?= esc($submitted['company_details']['address'] ?? 'N/A') ?>, <?= esc($submitted['company_details']['suburb_city'] ?? '') ?>, <?= esc($submitted['company_details']['country'] ?? '') ?></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Shareholders -->
<div class="mb-4">
    <h5 class="fw-bold text-secondary"><i class="fas fa-users me-2"></i> Shareholders</h5>
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>ID/Passport</th>
                    <th>Shareholding</th>
                    <th>Director</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($submitted['shareholders'] as $i => $s): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($s['full_name']) ?></td>
                        <td><?= esc($s['national_id']) ?></td>
                        <td><span class="badge bg-info"><?= esc($s['shareholding']) ?>%</span></td>
                        <td><?= $s['is_director'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>' ?></td>
                        <td>
                            <a href="<?= site_url('plc/shareholder/' . $s['id']) ?>" 
                               class="btn btn-sm btn-info">
                               <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>


        </div>
    </div>

    <a href="<?= site_url('plc') ?>" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<script>
document.getElementById("statusForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("<?= site_url('plc/update-status/' . $application['id']) ?>", {
        method: "POST",
        body: formData,
        headers: {
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": "<?= csrf_hash() ?>"
        }
    })
    .then(res => res.json())
    .then(data => {
        let msg = document.getElementById("statusMessage");
        if (data.success) {
            msg.innerHTML = '<div class="alert alert-success">'+data.message+'</div>';
            setTimeout(() => { window.location.href = "<?= site_url('plc') ?>"; }, 1500);
        } else {
            msg.innerHTML = '<div class="alert alert-danger">'+data.message+'</div>';
        }
    })
    .catch(err => console.error(err));
});
</script>

<?php include APPPATH . 'Core/Views/Partials/footer.php'; ?>
