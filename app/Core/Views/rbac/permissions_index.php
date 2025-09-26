<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle me-3" style="width: 48px; height: 48px;">
                    <i class="fas fa-key text-primary fs-4"></i>
                </div>
                <div>
                    <h1 class="h4 mb-0 fw-bold"><?= esc($title) ?></h1>
                    <p class="text-muted mb-0 small">Manage and organize system permissions</p>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
            <div class="input-group input-group-merge w-100 w-sm-auto">
                <span class="input-group-text bg-transparent border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" id="searchPermissions" class="form-control border-start-0" placeholder="Search permissions...">
            </div>
            <a href="<?= site_url('rbac/permissions/add') ?>" class="btn btn-primary px-4">
                <i class="fas fa-plus me-2"></i>New Permission
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <div class="flex-grow-1"><?= session()->getFlashdata('success') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm mb-4" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <div class="flex-grow-1"><?= session()->getFlashdata('error') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-3 px-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <h5 class="mb-2 mb-md-0 fw-semibold">
                            <i class="fas fa-key text-primary me-2"></i>Available Permissions
                        </h5>
                        <div class="d-flex align-items-center gap-2">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item active" href="#" data-filter="all">All Permissions</a></li>
                                    <li><a class="dropdown-item" href="#" data-filter="assigned">Assigned to Role</a></li>
                                    <li><a class="dropdown-item" href="#" data-filter="unassigned">Unassigned</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <?php foreach (array_keys($groupedPerms) as $group): ?>
                                        <li><a class="dropdown-item" href="#" data-filter="group-<?= $group ?>"><?= ucfirst($group) ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if (!empty($groupedPerms)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Permission</th>
                                        <th>Description</th>
                                        <th>Group</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($groupedPerms as $group => $permissions): ?>
                                        <tr class="bg-light">
                                            <td colspan="4" class="fw-semibold ps-4 py-2">
                                                <i class="fas fa-folder me-2 text-primary"></i>
                                                <?= ucfirst($group) ?>
                                                <span class="badge bg-primary bg-opacity-10 text-primary ms-2"><?= count($permissions) ?></span>
                                            </td>
                                        </tr>
                                        <?php foreach ($permissions as $perm): ?>
                                            <tr class="permission-row" data-group="group-<?= $group ?>">
                                                <td class="ps-5">
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle me-3" style="width: 36px; height: 36px;">
                                                            <i class="fas fa-key text-primary"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-medium"><?= esc($perm['permission']) ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php if (!empty($perm['description'])): ?>
                                                        <div class="text-muted small"><?= esc($perm['description']) ?></div>
                                                    <?php else: ?>
                                                        <span class="text-muted fst-italic small">No description</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark border">
                                                        <?= esc(ucfirst($perm['group'] ?? 'general')) ?>
                                                    </span>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-outline-secondary rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 32px; height: 32px;">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                            <li>
                                                                <a class="dropdown-item" href="<?= site_url('rbac/permissions/edit/' . $perm['id']) ?>">
                                                                    <i class="fas fa-edit me-2 text-primary"></i>Edit
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item text-danger" href="<?= site_url('rbac/permissions/delete/' . $perm['id']) ?>" 
                                                                   onclick="return confirm('Are you sure you want to delete this permission?')">
                                                                    <i class="fas fa-trash-alt me-2"></i>Delete
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-circle mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-key fa-2x text-muted opacity-25"></i>
                            </div>
                            <h5 class="text-muted mb-3">No permissions found</h5>
                            <p class="text-muted mb-4">Get started by adding your first permission to the system</p>
                            <a href="<?= site_url('rbac/permissions/add') ?>" class="btn btn-primary px-4">
                                <i class="fas fa-plus me-2"></i>Add Permission
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-white border-top py-3 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            <span id="totalPermissions"><?= count($permissions ?? []) ?></span> total permissions
                        </div>
                        <a href="<?= site_url('rbac') ?>" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Back to RBAC
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-shield-alt text-primary me-2"></i>Available Roles
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="alert alert-light border-0 mb-0">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-1">Role-Based Access Control</h6>
                                <p class="small text-muted mb-0">
                                    Assign roles to users to control their access to different parts of the system. 
                                    Each role has specific permissions that determine what actions a user can perform.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="list-group list-group-flush">
                        <?php foreach ($roles as $role): 
                            // Handle both object and array access
                            $roleName = is_object($role) ? ($role->name ?? '') : ($role['name'] ?? '');
                            $roleId = is_object($role) ? ($role->id ?? 0) : ($role['id'] ?? 0);
                            $roleDesc = is_object($role) 
                                ? ($role->description ?? ($role->description ?? '')) 
                                : ($role['description'] ?? '');
                            
                            // Skip if we don't have a valid role name
                            if (empty($roleName)) continue;
                            
                            $rolePermissions = $this->rbac->getRolePermissionsByName($roleName);
                            $permissionCount = !empty($rolePermissions) ? count($rolePermissions) : 0;
                        ?>
                            <div class="list-group-item border-0 py-3 px-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px;">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold"><?= esc(ucfirst($roleName)) ?></h6>
                                            <?php if (!empty($roleDesc)): ?>
                                                <p class="small text-muted mb-0"><?= esc($roleDesc) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 32px; height: 32px;">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li>
                                                <a class="dropdown-item" href="<?= site_url('rbac/roles/permissions/' . $roleId) ?>">
                                                    <i class="fas fa-key me-2 text-primary"></i>Manage Permissions
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="<?= site_url('rbac/roles/edit/' . $roleId) ?>">
                                                    <i class="fas fa-edit me-2 text-info"></i>Edit Role
                                                </a>
                                            </li>
                                            <?php if (strtolower($roleName) !== 'superadmin'): ?>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="<?= site_url('rbac/roles/delete/' . $roleId) ?>" 
                                                   onclick="return confirm('Are you sure you want to delete this role?')">
                                                    <i class="fas fa-trash-alt me-2"></i>Delete
                                                </a>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div>
                                        <span class="badge bg-light text-dark border">
                                            <i class="fas fa-users me-1"></i> <?= $this->rbac->countUsersInRole($roleId) ?> users
                                        </span>
                                        <span class="badge bg-light text-dark border ms-2">
                                            <i class="fas fa-key me-1"></i> <?= $permissionCount ?> permissions
                                        </span>
                                    </div>
                                    <a href="<?= site_url('rbac/roles/permissions/' . $roleId) ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-cog me-1"></i> Manage
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0">
                        <i class="fas fa-shield-alt text-primary me-2"></i>Available Roles
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php foreach ($roles as $role): ?>
                            <div class="list-group-item border-0 py-2 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold"><?= esc(ucfirst($role['group'])) ?></div>
                                    <small class="text-muted">
                                        <?= $role['description'] ?? 'No description available' ?>
                                    </small>
                                </div>
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    <?= $role['user_count'] ?? 0 ?> users
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for search and filter functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchPermissions');
    const permissionRows = document.querySelectorAll('.permission-row');
    const totalPermissions = document.getElementById('totalPermissions');
    const filterLinks = document.querySelectorAll('[data-filter]');
    let activeFilter = 'all';
    let activeSearch = '';

    // Function to filter and search permissions
    function updatePermissions() {
        let visibleCount = 0;
        
        permissionRows.forEach(row => {
            const permissionText = row.textContent.toLowerCase();
            const matchesSearch = permissionText.includes(activeSearch);
            const matchesFilter = activeFilter === 'all' || 
                                (activeFilter === 'assigned' && row.dataset.assigned === 'true') ||
                                (activeFilter === 'unassigned' && !row.dataset.assigned) ||
                                row.dataset.group === activeFilter;
            
            if (matchesSearch && matchesFilter) {
                row.style.display = '';
                visibleCount++;
                
                // Show the group header if it's hidden
                const groupHeader = row.previousElementSibling;
                if (groupHeader && groupHeader.classList.contains('bg-light')) {
                    groupHeader.style.display = '';
                }
            } else {
                row.style.display = 'none';
                
                // Hide group header if no visible permissions in group
                const groupHeader = row.previousElementSibling;
                if (groupHeader && groupHeader.classList.contains('bg-light')) {
                    const nextRow = row.nextElementSibling;
                    if (!nextRow || !nextRow.classList.contains('permission-row') || nextRow.style.display === 'none') {
                        groupHeader.style.display = 'none';
                    }
                }
            }
        });
        
        // Update the total count
        totalPermissions.textContent = visibleCount;
    }
    
    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            activeSearch = e.target.value.toLowerCase().trim();
            updatePermissions();
        });
    }
    
    // Filter functionality
    filterLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const filter = this.dataset.filter;
            
            // Update active filter
            activeFilter = filter;
            
            // Update active state
            filterLinks.forEach(l => {
                const item = l.closest('li');
                if (item) {
                    if (l === this) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                }
            });
            
            // Update the display
            updatePermissions();
        });
    });
    
    // Initialize with all permissions visible
    updatePermissions();
});
</script>

<style>
.avatar-circle {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    font-size: 1.75rem;
    font-weight: 600;
}

.user-avatar {
    position: relative;
}

.user-status {
    position: absolute;
    bottom: 0;
    right: 5px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 2px solid #fff;
}

.bg-online {
    background-color: #1cc88a;
}

.bg-offline {
    background-color: #e74a3b;
}

.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    color: #6c757d;
    border-top: none;
    border-bottom: 1px solid #e3e6f0;
    padding: 0.75rem 1rem;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
    border-color: #e3e6f0;
}

.table-hover > tbody > tr:hover {
    background-color: #f8f9fc;
}

.badge {
    font-weight: 500;
    padding: 0.4em 0.75em;
    border-radius: 0.35rem;
}

.card {
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
    padding: 1rem 1.25rem;
}

.btn {
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 0.35rem;
    transition: all 0.2s ease-in-out;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.form-select {
    padding: 0.5rem 1rem;
    border-radius: 0.35rem;
    border-color: #d1d3e2;
}

.form-select:focus {
    border-color: #bac8f3;
    box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
}

.alert {
    border: none;
    border-radius: 0.35rem;
    padding: 1rem 1.25rem;
}

.alert-light {
    background-color: #f8f9fc;
    border: 1px solid #e3e6f0 !important;
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
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize select2 if available
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('select[name="role"]').select2({
            placeholder: 'Select a role to assign...',
            allowClear: true,
            width: '100%',
            dropdownParent: $('select[name="role"]').parent()
        });
    }

    // Add smooth scrolling to all links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add fade in animation to alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease-in-out';
                alert.style.opacity = '1';
            }, 50);
        }, 50);
    });
});
</script>

<?php include $coreViewPath . 'Partials/footer.php'; ?>