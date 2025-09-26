<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1"><?= esc($title) ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= site_url('rbac') ?>">RBAC</a></li>
                    <li class="breadcrumb-item"><a href="<?= site_url('rbac/roles') ?>">Roles</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?= esc(ucfirst($role['group'])) ?> Permissions</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= site_url('rbac/roles/edit/'.$role['id']) ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Role
            </a>
            <a href="<?= site_url('rbac') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-list me-2"></i>All Roles
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <div><?= esc(session()->getFlashdata('success')) ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
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
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-shield-alt text-primary me-2"></i>Role Permissions
                        </h5>
                        <div class="d-flex align-items-center">
                            <div class="form-check form-switch me-3">
                                <input class="form-check-input" type="checkbox" id="selectAllPermissions" style="transform: scale(1.2);">
                                <label class="form-check-label small fw-semibold" for="selectAllPermissions">Select All</label>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-filter me-1"></i> Filter
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                    <li><a class="dropdown-item filter-option active" href="#" data-filter="all">All Permissions</a></li>
                                    <li><a class="dropdown-item filter-option" href="#" data-filter="assigned">Assigned Only</a></li>
                                    <li><a class="dropdown-item filter-option" href="#" data-filter="unassigned">Unassigned Only</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <?php foreach (array_keys($groupedPerms) as $group): ?>
                                        <li><a class="dropdown-item filter-option" href="#" data-filter="group-<?= $group ?>"><?= ucfirst($group) ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <div class="p-3 border-bottom">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" id="permissionSearch" class="form-control border-start-0" placeholder="Search permissions..." autocomplete="off">
                            <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <form action="<?= site_url('rbac/roles/permissions/'.$role['id']) ?>" method="post" id="permissionsForm">
                        <?= csrf_field() ?>
                        
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="text-muted small">
                                    <span id="visibleCount"><?= count($allPerms) ?></span> of <?= count($allPerms) ?> permissions
                                </div>
                                <div class="text-end small">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        <i class="fas fa-check-circle me-1"></i> 
                                        <span id="selectedCount"><?= count($ownedPerms) ?></span> selected
                                    </span>
                                </div>
                            </div>
                            
                            <div class="accordion" id="permissionsAccordion">
                                <?php foreach ($groupedPerms as $group => $permissions): 
                                    $groupId = 'group-' . preg_replace('/[^a-z0-9]/', '-', strtolower($group));
                                    $assignedCount = count(array_filter($permissions, fn($p) => in_array($p['permission'], $ownedPerms)));
                                ?>
                                    <div class="accordion-item border-0 mb-2 permission-group" data-group="<?= $groupId ?>">
                                        <div class="accordion-header">
                                            <button class="accordion-button collapsed bg-light shadow-none" type="button" data-bs-toggle="collapse" 
                                                    data-bs-target="#<?= $groupId ?>" aria-expanded="false" aria-controls="<?= $groupId ?>">
                                                <div class="d-flex justify-content-between align-items-center w-100">
                                                    <div>
                                                        <i class="fas fa-folder-open text-primary me-2"></i>
                                                        <span class="fw-semibold"><?= esc(ucfirst($group)) ?></span>
                                                    </div>
                                                    <div>
                                                        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary me-2">
                                                            <?= $assignedCount ?>/<?= count($permissions) ?> assigned
                                                        </span>
                                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                            <?= count($permissions) ?> total
                                                        </span>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                        <div id="<?= $groupId ?>" class="accordion-collapse collapse" data-bs-parent="#permissionsAccordion">
                                            <div class="accordion-body pt-3 pb-0">
                                                <div class="row g-3" id="permissionsContainer">
                                                    <?php foreach ($permissions as $perm): 
                                                        $isAssigned = in_array($perm['permission'], $ownedPerms, true);
                                                    ?>
                                                        <div class="col-12 permission-item" data-assigned="<?= $isAssigned ? 'true' : 'false' ?>">
                                                            <div class="card border-0 shadow-sm h-100 transition-all">
                                                                <div class="card-body p-3">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input permission-checkbox" 
                                                                               type="checkbox"
                                                                               name="permissions[]"
                                                                               value="<?= esc($perm['permission']) ?>"
                                                                               id="p_<?= esc($perm['id']) ?>"
                                                                               <?= $isAssigned ? 'checked' : '' ?>>
                                                                        <label class="form-check-label d-block ms-2" for="p_<?= esc($perm['id']) ?>">
                                                                            <div class="fw-semibold d-flex align-items-center">
                                                                                <span class="permission-name"><?= esc($perm['permission']) ?></span>
                                                                                <?php if ($isAssigned): ?>
                                                                                    <span class="badge bg-success bg-opacity-10 text-success ms-2">Assigned</span>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                            <?php if (!empty($perm['description'])): ?>
                                                                                <div class="text-muted small mt-1"><?= esc($perm['description']) ?></div>
                                                                            <?php endif; ?>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-white border-top p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="<?= site_url('rbac/roles/edit/'.$role['id']) ?>" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </a>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>Role Summary
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="role-icon me-3">
                            <i class="fas fa-user-shield text-primary"></i>
                        </div>
                        <div>
                            <h4 class="mb-0"><?= esc(ucfirst($role['group'])) ?></h4>
                            <span class="text-muted">Role ID: <?= $role['id'] ?></span>
                        </div>
                    </div>
                    
                    <div class="mb-4
                    ">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Permission Assignment</span>
                            <span class="fw-semibold"><?= count($ownedPerms) ?>/<?= count($allPerms) ?></span>
                        </div>
                        <div class="progress mb-3" style="height: 8px;">
                            <?php 
                            $percent = count($allPerms) > 0 ? (count($ownedPerms) / count($allPerms)) * 100 : 0;
                            $percent = min(100, max(0, $percent));
                            $color = $percent < 30 ? 'bg-danger' : ($percent < 70 ? 'bg-warning' : 'bg-success');
                            ?>
                            <div class="progress-bar progress-bar-striped progress-bar-animated <?= $color ?>" 
                                 role="progressbar" 
                                 style="width: <?= $percent ?>%" 
                                 aria-valuenow="<?= $percent ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between small text-muted mb-3">
                            <span><?= round($percent) ?>% of permissions assigned</span>
                            <span><?= count($ownedPerms) ?> of <?= count($allPerms) ?></span>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-sm btn-outline-primary" id="expandAll">
                                <i class="fas fa-expand-alt me-1"></i> Expand All
                            </button>
                        </div>
                    </div>
                    
                    <div class="alert alert-light border small">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-2">
                                <i class="fas fa-lightbulb text-warning"></i>
                            </div>
                            <div>
                                <strong>Tip:</strong> Select the permissions you want to assign to this role. 
                                Changes are saved when you click "Save Changes".
                            </div>
                        </div>
                    </div>
                    
                    <div class="card bg-light border-0 mt-3">
                        <div class="card-body p-3">
                            <h6 class="mb-3">Quick Actions</h6>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="selectAllInGroup">
                                    <i class="fas fa-check-double me-1"></i> Select All in Visible Groups
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAll">
                                    <i class="fas fa-times-circle me-1"></i> Deselect All
                                </button>
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
:root {
    --primary-color: #4e73df;
    --primary-light: rgba(78, 115, 223, 0.1);
    --success-light: rgba(28, 200, 138, 0.1);
    --warning-light: rgba(246, 194, 62, 0.1);
    --danger-light: rgba(231, 74, 59, 0.1);
}

.role-icon {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    background-color: var(--primary-light);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--primary-color);
    flex-shrink: 0;
}

.accordion-button {
    font-weight: 600;
    padding: 0.75rem 1.25rem;
    border-radius: 0.5rem !important;
    margin-bottom: 0.5rem;
}

.accordion-button:not(.collapsed) {
    background-color: var(--primary-light);
    color: var(--primary-color);
    box-shadow: none;
}

.accordion-button:focus {
    box-shadow: none;
    border-color: var(--primary-light);
}

.accordion-button::after {
    background-size: 1rem;
    width: 1.5rem;
    height: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: var(--primary-light);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%234e73df'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    transition: transform 0.2s ease-in-out;
}

.accordion-button:not(.collapsed)::after {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%234e73df'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    transform: rotate(180deg);
}

.permission-item .card {
    transition: all 0.2s ease-in-out;
    border: 1px solid rgba(0,0,0,0.05);
    border-left: 3px solid var(--primary-color);
    border-radius: 0.5rem;
    overflow: hidden;
}

.permission-item .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    border-color: var(--primary-color);
}

.permission-item[data-assigned="true"] .card {
    border-left-color: #1cc88a;
    background-color: rgba(28, 200, 138, 0.03);
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.form-check-input:focus {
    box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
}

.badge {
    font-weight: 500;
    padding: 0.35em 0.65em;
}

.progress {
    border-radius: 1rem;
    overflow: hidden;
}

.progress-bar {
    border-radius: 1rem;
}

.transition-all {
    transition: all 0.2s ease-in-out;
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
    // Elements
    const searchInput = document.getElementById('permissionSearch');
    const clearSearchBtn = document.getElementById('clearSearch');
    const permissionItems = document.querySelectorAll('.permission-item');
    const permissionGroups = document.querySelectorAll('.permission-group');
    const selectAllCheckbox = document.getElementById('selectAllPermissions');
    const checkboxes = document.querySelectorAll('.permission-checkbox');
    const expandAllBtn = document.getElementById('expandAll');
    const selectAllInGroupBtn = document.getElementById('selectAllInGroup');
    const deselectAllBtn = document.getElementById('deselectAll');
    const visibleCountEl = document.getElementById('visibleCount');
    const selectedCountEl = document.getElementById('selectedCount');
    
    // Initialize accordion
    const accordion = new bootstrap.Collapse(document.getElementById('permissionsAccordion'), {
        toggle: false
    });
    
    // Toggle all accordion items
    let isExpanded = false;
    expandAllBtn.addEventListener('click', function() {
        const accordionItems = document.querySelectorAll('.accordion-button');
        isExpanded = !isExpanded;
        
        accordionItems.forEach(item => {
            const target = document.querySelector(item.getAttribute('data-bs-target'));
            const bsCollapse = new bootstrap.Collapse(target, {toggle: false});
            
            if (isExpanded) {
                bsCollapse.show();
                expandAllBtn.innerHTML = '<i class="fas fa-compress-alt me-1"></i> Collapse All';
            } else {
                bsCollapse.hide();
                expandAllBtn.innerHTML = '<i class="fas fa-expand-alt me-1"></i> Expand All';
            }
        });
    });
    
    // Search functionality
    function filterPermissions(searchTerm) {
        let visibleCount = 0;
        
        permissionItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            const isVisible = text.includes(searchTerm);
            item.style.display = isVisible ? 'block' : 'none';
            if (isVisible) visibleCount++;
        });
        
        // Show/hide groups based on visible items
        permissionGroups.forEach(group => {
            const groupId = group.getAttribute('data-group');
            const hasVisibleItems = Array.from(group.querySelectorAll('.permission-item'))
                .some(item => item.style.display !== 'none');
                
            group.style.display = hasVisibleItems ? 'block' : 'none';
            
            // Auto-expand groups with matching items
            if (hasVisibleItems && searchTerm.length > 0) {
                const collapseEl = group.querySelector('.accordion-collapse');
                if (collapseEl) {
                    const bsCollapse = bootstrap.Collapse.getInstance(collapseEl) || 
                                      new bootstrap.Collapse(collapseEl, {toggle: false});
                    bsCollapse.show();
                }
            }
        });
        
        // Update visible count
        visibleCountEl.textContent = visibleCount;
    }
    
    searchInput.addEventListener('input', (e) => {
        filterPermissions(e.target.value.toLowerCase());
    });
    
    clearSearchBtn.addEventListener('click', () => {
        searchInput.value = '';
        filterPermissions('');
        searchInput.focus();
    });
    
    // Filter by dropdown
    document.querySelectorAll('.filter-option').forEach(option => {
        option.addEventListener('click', (e) => {
            e.preventDefault();
            const filter = option.getAttribute('data-filter');
            
            // Update active state
            document.querySelectorAll('.filter-option').forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');
            
            // Apply filter
            if (filter === 'all') {
                permissionItems.forEach(item => item.style.display = 'block');
            } else if (filter === 'assigned') {
                permissionItems.forEach(item => {
                    item.style.display = item.getAttribute('data-assigned') === 'true' ? 'block' : 'none';
                });
            } else if (filter === 'unassigned') {
                permissionItems.forEach(item => {
                    item.style.display = item.getAttribute('data-assigned') === 'false' ? 'block' : 'none';
                });
            } else if (filter.startsWith('group-')) {
                const groupName = filter.replace('group-', '');
                permissionGroups.forEach(group => {
                    const isTargetGroup = group.getAttribute('data-group') === filter;
                    group.style.display = isTargetGroup ? 'block' : 'none';
                    
                    if (isTargetGroup) {
                        const collapseEl = group.querySelector('.accordion-collapse');
                        if (collapseEl) {
                            const bsCollapse = bootstrap.Collapse.getInstance(collapseEl) || 
                                            new bootstrap.Collapse(collapseEl, {toggle: false});
                            bsCollapse.show();
                        }
                    }
                });
            }
            
            // Update visible count
            const visibleItems = document.querySelectorAll('.permission-item[style="display: block"]');
            visibleCountEl.textContent = visibleItems.length;
        });
    });
    
    // Select all functionality
    function updateSelectAllState() {
        const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
        const someChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        
        selectAllCheckbox.checked = allChecked;
        selectAllCheckbox.indeterminate = someChecked && !allChecked;
        
        // Update selected count
        const selectedCount = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;
        selectedCountEl.textContent = selectedCount;
    }
    
    selectAllCheckbox.addEventListener('change', function() {
        const isChecked = this.checked;
        checkboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
            // Trigger change event to update UI
            checkbox.dispatchEvent(new Event('change'));
        });
        updateSelectAllState();
    });
    
    // Update select all when individual checkboxes change
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const card = this.closest('.card');
            if (this.checked) {
                card.classList.add('border-primary');
            } else {
                card.classList.remove('border-primary');
            }
            updateSelectAllState();
        });
    });
    
    // Select all in visible groups
    selectAllInGroupBtn.addEventListener('click', function() {
        const visibleCheckboxes = Array.from(document.querySelectorAll('.permission-item[style="display: block"] .permission-checkbox'));
        visibleCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
            checkbox.dispatchEvent(new Event('change'));
        });
        updateSelectAllState();
    });
    
    // Deselect all
    deselectAllBtn.addEventListener('click', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
            checkbox.dispatchEvent(new Event('change'));
        });
        updateSelectAllState();
    });
    
    // Initialize counts
    updateSelectAllState();
    
    // Add keyboard navigation for accessibility
    document.addEventListener('keydown', function(e) {
        // Focus search on Ctrl+F
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            searchInput.focus();
        }
        
        // Clear search on Escape
        if (e.key === 'Escape' && document.activeElement === searchInput && searchInput.value) {
            searchInput.value = '';
            filterPermissions('');
        }
    });
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>