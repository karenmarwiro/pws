<?php include APPPATH . 'Core/Views/Partials/header.php'; ?>
<?php include APPPATH . 'Core/Views/Partials/menu.php'; ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        <i class="fas fa-user"></i> Shareholder: <?= esc($shareholder['full_name']) ?>
    </h1>

    <!-- Shareholder Info -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header">Details</div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item"><b>Full Name:</b> <?= esc($shareholder['full_name']) ?></li>
                <li class="list-group-item"><b>National ID:</b> <?= esc($shareholder['national_id']) ?></li>
                <li class="list-group-item"><b>Nationality:</b> <?= esc($shareholder['nationality']) ?></li>
                <li class="list-group-item"><b>Email:</b> <?= esc($shareholder['email']) ?></li>
                <li class="list-group-item"><b>Phone:</b> <?= esc($shareholder['phone_number']) ?></li>
                <li class="list-group-item"><b>Gender:</b> <?= esc($shareholder['gender']) ?></li>
                <li class="list-group-item"><b>Date of Birth:</b> <?= esc($shareholder['date_of_birth']) ?></li>
                <li class="list-group-item"><b>Address:</b> <?= esc($shareholder['residential_address']) ?>, <?= esc($shareholder['city']) ?></li>
                <li class="list-group-item"><b>Marital Status:</b> <?= esc($shareholder['marital_status']) ?></li>
                <li class="list-group-item"><b>Shareholding:</b> <?= esc($shareholder['shareholding']) ?>%</li>
                <li class="list-group-item"><b>Director:</b> <?= $shareholder['is_director'] ? 'Yes' : 'No' ?></li>
                <li class="list-group-item"><b>Beneficial Owner:</b> <?= $shareholder['is_beneficial_owner'] ? 'Yes' : 'No' ?></li>
            </ul>
        </div>
    </div>

    <!-- Documents -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header">Documents</div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item"><b>ID Document:</b> <?= esc($shareholder['id_document']) ?></li>
                <li class="list-group-item"><b>Proof of Residence:</b> <?= esc($shareholder['proof_of_residence']) ?></li>
                <li class="list-group-item"><b>Passport Photo:</b> <?= esc($shareholder['passport_photo']) ?></li>
                <li class="list-group-item"><b>Proof of Address:</b> <?= esc($shareholder['proof_of_address']) ?></li>
                <li class="list-group-item"><b>Share Certificate:</b> <?= esc($shareholder['share_certificate']) ?></li>
                <li class="list-group-item"><b>Company Registration Doc:</b> <?= esc($shareholder['company_registration_doc']) ?></li>
            </ul>
        </div>
    </div>

    <!-- Linked Companies -->
    <div class="card shadow-sm">
        <div class="card-header">Companies</div>
        <div class="card-body">
            <?php if (!empty($companies)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Business Type</th>
                            <th>Registration No</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($companies as $company): ?>
                            <tr>
                                <td><?= esc($company['proposed_name_one']) ?></td>
                                <td><?= esc($company['business_type']) ?></td>
                                <td><?= esc($company['registration_number']) ?></td>
                                <td><?= esc($company['email']) ?></td>
                                <td><?= esc($company['phone_number']) ?></td>
                                <td>
                                    <a href="<?= site_url('pbc/company/'.$company['id']) ?>" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No companies linked to this shareholder.</p>
            <?php endif; ?>
        </div>
    </div>

    <a href="<?= site_url('pbc') ?>" class="btn btn-secondary mt-3">Back</a>
</div>

<?php include APPPATH . 'Core/Views/Partials/footer.php'; ?>
