<!-- Header -->
<?php include $coreViewPath . 'Partials/header.php'; ?>

<!-- Sidebar/Menu -->
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="h4 mb-1 fw-bold">Modules Management</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                            <li class="breadcrumb-item active">Modules</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= site_url('modules/add') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus-circle me-1"></i> Add New Module
                    </a>
                    
                </div>
            </div>

            <!-- Modules Grid -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">All Modules</h5>
                        <div class="d-flex gap-2">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                    <li><a class="dropdown-item" href="#">All Modules</a></li>
                                    <li><a class="dropdown-item" href="#">Active</a></li>
                                    <li><a class="dropdown-item" href="#">Inactive</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Core</a></li>
                                    <li><a class="dropdown-item" href="#">Add-ins</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($modules)): ?>
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-cube fa-4x text-light" style="font-size: 5rem; opacity: 0.2;"></i>
                            </div>
                            <h5 class="text-muted mb-3">No modules found</h5>
                            <p class="text-muted mb-4">Get started by adding your first module to the system</p>
                            <a href="<?= site_url('modules/add') ?>" class="btn btn-primary px-4">
                                <i class="fas fa-plus me-2"></i> Add Module
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Module</th>
                                        <th>Version</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    <?php foreach ($modules as $module): 
                                        $moduleIcon = $module['icon'] ?? 'fas fa-cube';
                                        $isCore = $module['is_core'] ?? false;
                                        $isActive = $module['is_active'] ?? false;
                                    ?>
                                        <tr class="border-bottom">
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="bg-primary bg-opacity-10 text-primary rounded-2 p-2">
                                                            <i class="<?= $moduleIcon ?> fa-lg"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-0 fw-medium module-name"><?= esc($module['name']) ?></h6>
                                                        <small class="text-muted"><?= esc($module['description'] ?? 'No description') ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border">v<?= esc($module['version'] ?? '1.0.0') ?></span>
                                            </td>
                                            <td>
                                                <?php if ($isCore): ?>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                                        <i class="fas fa-shield-alt me-1"></i> Core
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-success bg-opacity-10 text-success">
                                                        <i class="fas fa-puzzle-piece me-1"></i> Add-in
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($isActive): ?>
                                                    <span class="badge bg-success bg-opacity-10 text-success">
                                                        <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> Active
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger bg-opacity-10 text-danger">
                                                        <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> Inactive
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="d-flex align-items-center justify-content-end">
                                                    
                                                    <div class="btn-group btn-group-sm" role="group">
    <?php if ($isCore): ?>
        <button type="button" 
                class="btn btn-action btn-core-toggle position-relative" 
                data-bs-toggle="tooltip" 
                title="Core modules cannot be deactivated">
            <i class="fas fa-toggle-on"></i>
            <i class="fas fa-lock"></i>
        </button>
    <?php else: ?>
        <?php if ($isActive): ?>
            <button type="button" 
                    class="btn btn-action text-danger toggle-btn" 
                    data-module-id="<?= $module['id'] ?>"
                    data-module-name="<?= htmlspecialchars($module['name']) ?>"
                    data-action="disable"
                    data-bs-toggle="tooltip" 
                    title="Deactivate">
                <i class="fas fa-toggle-on"></i>
            </button>
        <?php else: ?>
            <button type="button" 
                    class="btn btn-action text-success toggle-btn" 
                    data-module-id="<?= $module['id'] ?>"
                    data-module-name="<?= htmlspecialchars($module['name']) ?>"
                    data-action="enable"
                    data-bs-toggle="tooltip" 
                    title="Activate">
                <i class="fas fa-toggle-off"></i>
            </button>
        <?php endif; ?>
    <?php endif; ?>
    
    <?php if (!$isCore): ?>
        <button type="button" 
                class="btn btn-action text-danger" 
                onclick="confirmDelete(<?= $module['id'] ?>, '<?= addslashes($module['name']) ?>')" 
                data-bs-toggle="tooltip" 
                title="Delete">
            <i class="fas fa-trash"></i>
        </button>
    <?php else: ?>
        <button type="button" 
                class="btn btn-action text-muted" 
                disabled 
                data-bs-toggle="tooltip" 
                title="Core modules cannot be deleted">
            <i class="fas fa-trash"></i>
        </button>
    <?php endif; ?>
</div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include $coreViewPath . 'Partials/footer.php'; ?>


<!-- JavaScript for module actions -->
<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Handle module toggle buttons
    document.querySelectorAll('.toggle-btn').forEach(button => {
        button.addEventListener('click', function() {
            const moduleId = this.dataset.moduleId;
            const moduleName = this.dataset.moduleName;
            const action = this.dataset.action;
            const isEnabling = action === 'enable';
            const actionText = isEnabling ? 'activate' : 'deactivate';

            Swal.fire({
                title: `${isEnabling ? 'Activate' : 'Deactivate'} Module`,
                text: `Are you sure you want to ${actionText} the "${moduleName}" module?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: isEnabling ? '#198754' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Yes, ${actionText} it!`,
                cancelButtonText: 'Cancel',
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        // Get CSRF token from meta tag
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        if (!csrfToken) {
                            console.error('CSRF token not found');
                            throw new Error('Security token is missing. Please refresh the page and try again.');
                        }

                        const baseUrl = window.location.origin;
                        const response = await fetch(`${baseUrl}/pws/api/modules/${moduleId}/toggle`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            credentials: 'same-origin',
                            body: JSON.stringify({ enable: action === 'enable' })
                        });

                        console.log('Response status:', response.status);
                        
                        if (!response.ok) {
                            let errorText = 'Network response was not ok';
                            try {
                                const errorData = await response.json();
                                errorText = errorData.message || errorText;
                                console.error('API error:', errorData);
                            } catch (e) {
                                console.error('Failed to parse error response:', e);
                            }
                            throw new Error(errorText);
                        }

                        const data = await response.json();
                        console.log('API response:', data);
                        
                        if (data && data.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: `Module has been ${actionText}d successfully.`,
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            throw new Error(data.message || `Failed to ${actionText} module`);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        Swal.showValidationMessage(
                            `Request failed: ${error.message || 'Unknown error occurred'}`
                        );
                        return Promise.reject(error);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        });
    });
});

function confirmDelete(moduleId, moduleName) {
    Swal.fire({
        title: 'Delete Module',
        text: `Are you sure you want to delete the "${moduleName}" module? This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            return fetch(`/modules/delete/${moduleId}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'The module has been deleted.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Failed to delete module');
                }
            })
            .catch(error => {
                Swal.fire(
                    'Error!',
                    error.message || 'Failed to delete module',
                    'error'
                );
            });
        }
    });
}
</script>

<style>
/* Module List Styles */
.table {
    --bs-table-hover-bg: rgba(13, 110, 253, 0.03);
}

.table > :not(caption) > * > * {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
}

/* Module Status Badges */
.badge {
    font-weight: 500;
    letter-spacing: 0.3px;
    padding: 0.5em 0.75em;
    font-size: 0.75em;
    border-radius: 0.375rem;
}

.badge.bg-primary {
    background-color: rgba(13, 110, 253, 0.1) !important;
    color: #0d6efd !important;
}

/* Action Buttons */
.btn-action {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.375rem;
    transition: all 0.2s ease-in-out;
    position: relative;
    color: #6c757d;
    background-color: transparent;
    border: none;
}

.btn-action:hover {
    background-color: rgba(108, 117, 125, 0.1);
    transform: translateY(-1px);
}

.btn-action:active {
    transform: translateY(0);
}

.btn-action i {
    font-size: 1.1em;
}

/* Core Module Toggle */
.btn-core-toggle {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    color: #6c757d;
    cursor: not-allowed;
}

.btn-core-toggle .fa-lock {
    position: absolute;
    font-size: 0.6em;
    bottom: 0;
    right: 0;
    color: #ffc107;
    background: #fff;
    border-radius: 50%;
    width: 14px;
    height: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 0 2px #fff;
}

/* Hover Effects */
.btn-action.text-primary:hover {
    color: #0a58ca !important;
}

.btn-action.text-success:hover {
    color: #146c43 !important;
}

.btn-action.text-danger:hover {
    color: #b02a37 !important;
}

/* Module Icon */
.module-icon-wrapper {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(13, 110, 253, 0.1);
    border-radius: 0.5rem;
    color: #0d6efd;
    font-size: 1.25rem;
}

/* Responsive Adjustments */
@media (max-width: 767.98px) {
    .table > :not(caption) > * > * {
        padding: 0.75rem 0.5rem;
    }
    
    .module-icon-wrapper {
        width: 36px;
        height: 36px;
        font-size: 1.1rem;
    }
}
</style>
