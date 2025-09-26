<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><?= esc($title) ?></h1>
            <p class="text-muted mb-0">Update role details and permissions</p>
        </div>
        <div>
            <a href="<?= site_url('rbac') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Roles
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i><?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i><?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-user-shield text-primary me-2"></i>Role Details
                    </h5>
                </div>
                <div class="card-body">
                   <form action="<?= site_url('rbac/roles/update/'.$role['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-4">

                            <label for="group" class="form-label fw-semibold">Role Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                <input type="text" 
                                       name="group" 
                                       id="group" 
                                       class="form-control form-control-lg" 
                                       value="<?= esc($role['group']) ?>" 
                                       required
                                       placeholder="Enter role name">
                            </div>
                            <div class="form-text">A unique identifier for this role (e.g., admin, editor, viewer)</div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                <textarea name="description" 
                                          id="description" 
                                          class="form-control" 
                                          rows="3"
                                          placeholder="Enter a brief description of this role"><?= esc($role['description']) ?></textarea>
                            </div>
                            <div class="form-text">Describe the purpose and permissions of this role</div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-5">
                            <a href="<?= site_url('rbac') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>Role Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Role ID</h6>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-light text-dark font-monospace"><?= $role['id'] ?></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Created</h6>
                        <div class="d-flex align-items-center">
                            <i class="far fa-calendar-alt me-2 text-muted"></i>
                            <span><?= date('M j, Y', strtotime($role['created_at'] ?? 'now')) ?></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Last Updated</h6>
                        <div class="d-flex align-items-center">
                            <i class="far fa-clock me-2 text-muted"></i>
                            <span><?= date('M j, Y', strtotime($role['updated_at'] ?? 'now')) ?></span>
                        </div>
                    </div>
                    <hr>
                    <div class="d-grid">
                        <a href="<?= site_url('rbac/roles/permissions/'.$role['id']) ?>" class="btn btn-outline-primary">
                            <i class="fas fa-shield-alt me-2"></i>Manage Permissions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $coreViewPath . 'Partials/footer.php'; ?>

<style>
.role-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background-color: rgba(13, 110, 253, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
}
.input-group-text {
    min-width: 45px;
    justify-content: center;
}
</style>