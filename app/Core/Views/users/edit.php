<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Edit User</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= site_url('rbac') ?>">RBAC</a></li>
                    <li class="breadcrumb-item"><a href="<?= site_url('rbac/users') ?>">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="<?= site_url('rbac/users/view/'.$user->id) ?>" class="btn btn-light">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0"><i class="fas fa-user-edit text-primary me-2"></i> Update User Information</h5>
        </div>
        <div class="card-body">
            <form action="<?= site_url('rbac/users/update/'.$user->id) ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" 
                           id="username" 
                           name="username" 
                           value="<?= old('username', $user->username) ?>" 
                           required>
                    <div class="invalid-feedback"><?= session('errors.username') ?></div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" 
                       class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>" 
                       id="email" 
                       name="email" 
                       value="<?= old('email', $user->email ?? '') ?>" 
                       required>
                                    <div class="invalid-feedback"><?= session('errors.email') ?></div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password <small class="text-muted">(leave blank to keep current)</small></label>
                    <input type="password" 
                           class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                           id="password" 
                           name="password">
                    <div class="invalid-feedback"><?= session('errors.password') ?></div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                        <?php foreach ($allRoles as $role): ?>
                            <option value="<?= esc($role) ?>" <?= in_array($role, $user->roles) ? 'selected' : '' ?>>
                                <?= esc(ucfirst($role)) ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="active" <?= $user->active ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= !$user->active ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include $coreViewPath . 'Partials/footer.php'; ?>
