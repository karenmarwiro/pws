<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Edit Permission</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= site_url('rbac') ?>">RBAC</a></li>
                    <li class="breadcrumb-item"><a href="<?= site_url('rbac/permissions') ?>">Permissions</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="<?= site_url('rbac/permissions') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Permissions
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <div><?= esc(session()->getFlashdata('error')) ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-edit text-primary me-2"></i>Edit Permission
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('rbac/permissions/edit/' . $perm['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label for="permission" class="form-label">Permission Key</label>
                            <input type="text" class="form-control <?= session('errors.permission') ? 'is-invalid' : '' ?>" 
                                   id="permission" name="permission" 
                                   value="<?= old('permission', $perm['permission'] ?? '') ?>" 
                                   required>
                            <?php if (session('errors.permission')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.permission') ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-text text-muted">
                                Use lowercase with dots as separators (e.g., 'users.create', 'posts.delete')
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control <?= session('errors.description') ? 'is-invalid' : '' ?>" 
                                      id="description" name="description" 
                                      rows="3"><?= old('description', $perm['description'] ?? '') ?></textarea>
                            <?php if (session('errors.description')): ?>
                                <div class="invalid-feedback">
                                    <?= session('errors.description') ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="<?= site_url('rbac/permissions') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Permissions
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $coreViewPath . 'Partials/footer.php'; ?>
