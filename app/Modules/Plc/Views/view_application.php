<?php include APPPATH . 'Core/Views/Partials/header.php'; ?>
<?php include APPPATH . 'Core/Views/Partials/menu.php'; ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-eye me-2"></i> View Application #<?= esc($application['id']) ?>
    </h1>

    <!-- Status Update -->
    <div class="card mb-4">
        <div class="card-body">
            <form id="statusForm">
            <?= csrf_field() ?>
            <select class="form-select w-25 d-inline" name="status" id="status">
                <option value="pending" <?= $application['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="submitted" <?= $application['status'] === 'submitted' ? 'selected' : '' ?>>Submitted</option>
                <option value="processing" <?= $application['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                <option value="approved" <?= $application['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                <option value="rejected" <?= $application['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
        </form>

        <div id="statusMessage"></div>


                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-sync-alt"></i> Update
                </button>
            </form>
            <div id="statusMessage" class="mt-2"></div>
        </div>
    </div>

    <!-- Submitted Data -->
    <div class="card">
        <div class="card-header fw-bold">
            Submitted Information
        </div>
        <div class="card-body">

            <!-- Personal Details -->
            <h5 class="mt-4">Personal Details</h5>
                <ul class="list-group mb-3">
                    <li class="list-group-item">
                        <b>Full Name:</b>
                        <?= esc(($submitted['personal_details']['first_name'] ?? '') . ' ' . ($submitted['personal_details']['last_name'] ?? '')) ?>
                    </li>
                    <li class="list-group-item">
                        <b>National ID:</b> <?= esc($submitted['personal_details']['national_id'] ?? 'N/A') ?>
                    </li>
                    <li class="list-group-item">
                        <b>Email:</b> <?= esc($submitted['personal_details']['email'] ?? 'N/A') ?>
                    </li>
                    <li class="list-group-item">
                        <b>Phone:</b> <?= esc($submitted['personal_details']['phone_number'] ?? 'N/A') ?>
                    </li>
                    <li class="list-group-item">
                        <b>Address:</b> <?= esc($submitted['personal_details']['physical_address'] ?? 'N/A') ?>,
                        <?= esc($submitted['personal_details']['city'] ?? '') ?>
                    </li>
                </ul>


            <!-- Company Details -->
           <h5 class="mt-4">Company Details</h5>
            <ul class="list-group mb-3">
                <li class="list-group-item">
                    <b>Proposed Name 1:</b> <?= esc($submitted['company_details']['proposed_name_one'] ?? 'N/A') ?>
                </li>
                <li class="list-group-item">
                    <b>Proposed Name 2:</b> <?= esc($submitted['company_details']['proposed_name_two'] ?? 'N/A') ?>
                </li>
                <li class="list-group-item">
                    <b>Proposed Name 3:</b> <?= esc($submitted['company_details']['proposed_name_three'] ?? 'N/A') ?>
                </li>
                <li class="list-group-item">
                    <b>Proposed Name 4:</b> <?= esc($submitted['company_details']['proposed_name_four'] ?? 'N/A') ?>
                </li>
                <li class="list-group-item">
                    <b>Business Type:</b> <?= esc($submitted['company_details']['business_type'] ?? 'N/A') ?>
                </li>
                <li class="list-group-item">
                    <b>Registration No:</b> <?= esc($submitted['company_details']['registration_number'] ?? 'N/A') ?>
                </li>
                <li class="list-group-item">
                    <b>Email:</b> <?= esc($submitted['company_details']['email'] ?? 'N/A') ?>
                </li>
                <li class="list-group-item">
                    <b>Phone:</b> <?= esc($submitted['company_details']['phone_number'] ?? 'N/A') ?>
                </li>
                <li class="list-group-item">
                    <b>Address:</b> <?= esc($submitted['company_details']['address'] ?? 'N/A') ?>,
                    <?= esc($submitted['company_details']['suburb_city'] ?? '') ?>,
                    <?= esc($submitted['company_details']['country'] ?? '') ?>
                </li>
            </ul>


            <!-- Shareholders -->
           <h5 class="mt-4">Shareholders</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>ID/Passport</th>
                            <th>Nationality</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Shareholding</th>
                            <th>Director</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($submitted['shareholders'] as $i => $s): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($s['full_name']) ?></td>
                                <td><?= esc($s['national_id']) ?></td>
                                <td><?= esc($s['nationality']) ?></td>
                                <td><?= esc($s['email']) ?></td>
                                <td><?= esc($s['phone_number']) ?></td>
                                <td><?= esc($s['shareholding']) ?>%</td>
                                <td><?= $s['is_director'] ? 'Yes' : 'No' ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
     <a href="<?= site_url('plc') ?>" class="btn btn-secondary mt-3">Back</a>
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
