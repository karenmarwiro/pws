<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1"><?= esc($title) ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= site_url('rbac') ?>">RBAC</a></li>
                    <li class="breadcrumb-item"><a href="<?= site_url('rbac/permissions') ?>">Permissions</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New</li>
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
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle text-primary me-2"></i>Add New Permission
                    </h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('rbac/permissions/add') ?>" method="POST" id="permissionForm">
                        <?= csrf_field() ?>
                        
                        <div class="mb-4">
                            <label for="permission" class="form-label fw-semibold">Permission Slug</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input type="text" 
                                       name="permission" 
                                       id="permission" 
                                       class="form-control form-control-lg" 
                                       placeholder="e.g., users.manage" 
                                       value="<?= old('permission') ?>" 
                                       required
                                       pattern="[a-z0-9._-]+"
                                       title="Use only lowercase letters, numbers, dots, hyphens, and underscores">
                            </div>
                            <div class="form-text">
                                Use dot notation for grouping (e.g., users.create, users.edit, posts.delete)
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-align-left"></i>
                                </span>
                                <input type="text" 
                                       name="description" 
                                       id="description" 
                                       class="form-control" 
                                       placeholder="What does this permission allow?" 
                                       value="<?= old('description') ?>">
                            </div>
                            <div class="form-text">
                                Optional but recommended for better understanding
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="<?= site_url('rbac/permissions') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Permission
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>Permission Guidelines
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-light border small">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-2">
                                <i class="fas fa-lightbulb text-warning"></i>
                            </div>
                            <div>
                                <strong>Best Practices</strong>
                                <ul class="mt-2 mb-0">
                                    <li>Use dot notation for grouping related permissions</li>
                                    <li>Be specific but concise in your naming</li>
                                    <li>Use lowercase letters and dots only</li>
                                    <li>Keep permission names consistent</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="fw-semibold">Common Permission Patterns</h6>
                        <div class="list-group list-group-flush small">
                            <div class="list-group-item px-0 py-2 border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <code>module.resource.action</code>
                                    <span class="badge bg-primary bg-opacity-10 text-primary">Recommended</span>
                                </div>
                                <small class="text-muted">e.g., users.profiles.view</small>
                            </div>
                            <div class="list-group-item px-0 py-2 border-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <code>resource.action</code>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">Simple</span>
                                </div>
                                <small class="text-muted">e.g., posts.create</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="<?= site_url('rbac/permissions') ?>" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-list me-1"></i> View All Permissions
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0">
                        <i class="fas fa-shield-alt text-primary me-2"></i>Permission Structure
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 py-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle me-3">
                                    <i class="fas fa-sitemap"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Hierarchical Structure</h6>
                                    <small class="text-muted">Organize permissions logically</small>
                                </div>
                            </div>
                            <div class="ms-5 ps-3 border-start">
                                <div class="d-flex align-items-center text-muted small mb-1">
                                    <i class="fas fa-folder me-2"></i>
                                    users
                                    <span class="badge bg-light text-dark ms-2">Module</span>
                                </div>
                                <div class="ms-4">
                                    <div class="d-flex align-items-center text-muted small mb-1">
                                        <i class="fas fa-file me-2"></i>
                                        users.create
                                        <span class="badge bg-light text-dark ms-2">Permission</span>
                                    </div>
                                    <div class="d-flex align-items-center text-muted small">
                                        <i class="fas fa-file me-2"></i>
                                        users.edit
                                        <span class="badge bg-light text-dark ms-2">Permission</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control, .form-select {
    border-radius: 0.5rem;
    padding: 0.6rem 1rem;
    border-color: #d1d3e2;
    transition: all 0.2s ease-in-out;
}

.form-control:focus, .form-select:focus {
    border-color: #bac8f3;
    box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
}

.input-group-text {
    background-color: #f8f9fc;
    border-color: #d1d3e2;
    color: #6e707e;
    transition: all 0.2s ease-in-out;
}

.btn {
    font-weight: 500;
    padding: 0.5rem 1.25rem;
    border-radius: 0.5rem;
    transition: all 0.2s ease-in-out;
}

.btn-primary {
    background-color: #4e73df;
    border-color: #4e73df;
}

.btn-outline-secondary {
    color: #6e707e;
    border-color: #d1d3e2;
}

.btn-outline-secondary:hover {
    background-color: #f8f9fc;
    border-color: #bac8f3;
    color: #4e73df;
}

.card {
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
    border: none;
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
    padding: 1rem 1.25rem;
}

.alert {
    border: none;
    border-radius: 0.5rem;
    padding: 1rem 1.25rem;
}

.breadcrumb {
    background: none;
    padding: 0;
    margin: 0;
    font-size: 0.85rem;
}

.breadcrumb-item a {
    color: #4e73df;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #6c757d;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: '›';
    padding: 0 0.5rem;
}

.badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
    border-radius: 0.35rem;
}

code {
    background-color: #f8f9fc;
    padding: 0.2em 0.4em;
    border-radius: 0.25rem;
    font-size: 0.85em;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format permission input to lowercase and replace spaces with dots
    const permissionInput = document.getElementById('permission');
    if (permissionInput) {
        permissionInput.addEventListener('input', function(e) {
            this.value = this.value.toLowerCase().replace(/\s+/g, '.');
        });
    }
    
    // Form validation
    const form = document.getElementById('permissionForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    }
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Add animation to form elements
    const formGroups = document.querySelectorAll('.form-group');
    formGroups.forEach((group, index) => {
        setTimeout(() => {
            group.style.opacity = '0';
            group.style.transform = 'translateY(10px)';
            group.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            
            setTimeout(() => {
                group.style.opacity = '1';
                group.style.transform = 'translateY(0)';
            }, 50);
        }, index * 100);
    });
});
</script>

<?php include $coreViewPath . 'Partials/footer.php'; ?>