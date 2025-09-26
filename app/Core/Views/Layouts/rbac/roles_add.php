<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 mb-1"><?= esc($title) ?></h1>
            <p class="text-muted mb-0">Create a new role with specific permissions and access levels</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= site_url('rbac') ?>" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-2"></i>Back to Roles
            </a>
        </div>
    </div>

    <!-- Alerts -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle me-2"></i><?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-error-circle me-2"></i><?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Main Form -->
        <div class="col-12 col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="bx bx-shield-quarter text-primary me-2"></i>Role Information
                    </h5>
                    <small class="text-muted">Step 1 of 2</small>
                </div>
                <div class="card-body">
                    <?php if (isset($validation) && $validation->getErrors()): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-error-circle me-2"></i>
                                <div>
                                    <h6 class="alert-heading mb-1">Please fix the following issues:</h6>
                                    <ul class="mb-0">
                                        <?php foreach ($validation->getErrors() as $error): ?>
                                            <li class="small"><?= esc($error) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form id="roleForm" action="<?= site_url('rbac/roles/add') ?>" method="POST" class="needs-validation" novalidate>
                        <?= csrf_field() ?>
                        
                        <div class="mb-4">
                            <div class="form-floating mb-3">
                                <input type="text" 
                                    class="form-control <?= (isset($validation) && $validation->hasError('group')) ? 'is-invalid' : '' ?>" 
                                    id="group" 
                                    name="group" 
                                    placeholder="e.g., content_editor"
                                    value="<?= old('group', '') ?>"
                                    required
                                    autofocus>
                                <label for="group">Role Name <span class="text-danger">*</span></label>
                                <div class="invalid-feedback">
                                    <i class="bx bx-info-circle me-1"></i> Please provide a valid role name
                                </div>
                                <div class="form-text">Use lowercase with underscores (e.g., content_editor, site_admin)</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-floating">
                                <textarea class="form-control" 
                                    id="description" 
                                    name="description" 
                                    placeholder="Enter role description"
                                    style="height: 100px"><?= old('description', '') ?></textarea>
                                <label for="description">Description</label>
                                <div class="form-text">Describe the purpose and permissions of this role</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-3 mt-4 border-top">
                            <a href="<?= site_url('rbac') ?>" class="btn btn-label-secondary">
                                <i class="bx bx-x me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-plus-circle me-2"></i>Create Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-12 col-lg-4">
            <!-- Role Guidelines -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-info-circle text-primary me-2"></i>Role Guidelines
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3 mb-4">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-sm">
                                <span class="avatar-initial rounded-circle bg-label-warning">
                                    <i class="bx bx-bulb"></i>
                                </span>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-2">Best Practices</h6>
                            <ul class="list-unstyled small">
                                <li class="mb-2">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    Use clear, descriptive names
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    Follow naming conventions
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    Document role purposes
                                </li>
                                <li>
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    Assign minimal permissions
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert alert-primary alert-dismissible mb-0" role="alert">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-2">
                                <i class="bx bx-info-circle"></i>
                            </div>
                            <div>
                                <h6 class="alert-heading">Did you know?</h6>
                                <p class="small mb-0">After creating this role, you can assign specific permissions to it from the role management page.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $coreViewPath . 'Partials/footer.php'; ?>

<style>
/* Custom styles */
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(165, 163, 174, 0.3);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(165, 163, 174, 0.3);
}

.form-floating > label {
    padding: 1rem 1.25rem;
}

.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label,
.form-floating > .form-control-plaintext ~ label,
.form-floating > .form-select ~ label {
    opacity: 0.8;
    transform: scale(0.85) translateY(-0.5rem) translateX(0.25rem);
}

.avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.avatar-initial {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 600;
    font-size: 1.25rem;
}

/* Animation for form elements */
.form-control, .form-select, .form-check-input {
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #b4b4b4;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #9a9a9a;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-format role name as user types
    const roleNameInput = document.getElementById('group');
    if (roleNameInput) {
        roleNameInput.addEventListener('input', function(e) {
            // Convert to lowercase and replace spaces with underscores
            let value = e.target.value.toLowerCase()
                .replace(/\s+/g, '_')  // Replace spaces with underscores
                .replace(/[^a-z0-9_]/g, '');  // Remove special characters
            
            // Update the input value if it changed
            if (value !== e.target.value) {
                e.target.value = value;
            }
        });
    }
    
    // Form validation
    const form = document.getElementById('roleForm');
    if (form) {
        // Bootstrap 5 form validation
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
        
        // Real-time validation
        const roleInput = document.getElementById('group');
        if (roleInput) {
            roleInput.addEventListener('input', function() {
                if (roleInput.validity.patternMismatch) {
                    roleInput.setCustomValidity('Please use only lowercase letters, numbers, and underscores');
                } else {
                    roleInput.setCustomValidity('');
                }
            });
        }
    }
    
    // Add animation to form elements
    const formControls = document.querySelectorAll('.form-control, .form-select, .form-check-input');
    formControls.forEach(control => {
        control.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        control.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
        
        // Check if the field has content on page load
        if (control.value) {
            control.parentElement.classList.add('focused');
        }
    });
});
</script>
            }
            
            // You can add more validation as needed
            return true;
        });
    }
});
</script>