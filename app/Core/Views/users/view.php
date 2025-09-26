<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">User Details</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= site_url('rbac') ?>">RBAC</a></li>
                    <li class="breadcrumb-item"><a href="<?= site_url('rbac/users') ?>">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= esc($user->username ?? 'User') ?></li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="<?= site_url('rbac/users/edit/'.$user->id) ?>" class="btn btn-secondary me-2">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="<?= site_url('rbac/users/assign-role/'.$user->id) ?>" class="btn btn-info me-2">
                <i class="fas fa-user-shield me-1"></i> Manage Roles
            </a>
            <a href="<?= site_url('rbac/users') ?>" class="btn btn-light">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Profile card -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body text-center">
                    <div class="avatar-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3">
                        <?= strtoupper(substr($user->username ?? 'U', 0, 1)) ?>
                    </div>
                    <h5 class="mb-1"><?= esc($user->username ?? 'N/A') ?></h5>
                    <p class="text-muted mb-3"><?= esc($user->email ?? 'N/A') ?></p>

                    <?php if ($user->active): ?>
                        <span class="badge bg-success">Active</span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Inactive</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Details card -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0"><i class="fas fa-user me-2 text-primary"></i> User Information</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">ID</dt>
                        <dd class="col-sm-9"><?= esc($user->id) ?></dd>

                        <dt class="col-sm-3">Username</dt>
                        <dd class="col-sm-9"><?= esc($user->username) ?></dd>

                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9"><?= esc($user->email ?? 'N/A') ?></dd>

                        <dt class="col-sm-3">Status</dt>
                        <dd class="col-sm-9"><?= esc($user->status ?? 'N/A') ?></dd>

                        <dt class="col-sm-3">Last Active</dt>
                        <dd class="col-sm-9">
                            <?php if (!empty($user->last_active)): 
                                $date = \CodeIgniter\I18n\Time::parse($user->last_active);
                            ?>
                                <?= $date->format('M j, Y H:i') ?>
                                <div class="text-muted small"><?= $date->humanize() ?></div>
                            <?php else: ?>
                                <span class="text-muted">Never</span>
                            <?php endif; ?>
                        </dd>

                        <dt class="col-sm-3">Created At</dt>
                        <dd class="col-sm-9"><?= esc($user->created_at ?? '-') ?></dd>

                        <dt class="col-sm-3">Updated At</dt>
                        <dd class="col-sm-9"><?= esc($user->updated_at ?? '-') ?></dd>
                    </dl>
                </div>
            </div>

            <!-- Roles card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0"><i class="fas fa-user-shield me-2 text-primary"></i> Assigned Roles</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($roles)): ?>
                        <?php foreach ($roles as $role): ?>
                            <span class="badge bg-primary bg-opacity-10 text-primary me-1 mb-1">
                                <?= esc(ucfirst($role)) ?>
                            </span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="text-muted">No roles assigned</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 2rem;
}
</style>

<?php include $coreViewPath . 'Partials/footer.php'; ?>
