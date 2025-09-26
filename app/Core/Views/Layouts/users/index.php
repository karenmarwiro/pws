<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">User Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= site_url('rbac') ?>">RBAC</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="<?= site_url('rbac/users/add') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New User
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <div><?= session()->getFlashdata('success') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <div><?= session()->getFlashdata('error') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-users text-primary me-2"></i>Users
                </h5>
                <div class="d-flex
                ">
                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Search users...">
                        <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="usersTable">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">User</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Roles</th>
                            <th>Last Active</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary text-white d-flex align-items-center justify-content-center me-3">
                                                <?= strtoupper(substr($user->username ?? 'U', 0, 1)) ?>
                                            </div>
                                            <div>
                                                <div class="fw-semibold"><?= esc($user->username ?? 'N/A') ?></div>
                                                <small class="text-muted">ID: <?= $user->id ?? '' ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;" title="<?= esc($user->email ?? ''); ?>">
                                            <?= esc($user->email ?? 'N/A') ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($user->active): ?>
                                            <span class="badge bg-success bg-opacity-10 text-success">
                                                <i class="fas fa-circle me-1" style="font-size: 0.6em;"></i> Active
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                <i class="fas fa-circle me-1" style="font-size: 0.6em;"></i> Inactive
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($user->roles)): ?>
                                            <?php foreach (array_slice($user->roles, 0, 2) as $role): ?>
                                                <span class="badge bg-primary bg-opacity-10 text-primary mb-1">
                                                    <?= esc(ucfirst($role)) ?>
                                                </span>
                                            <?php endforeach; ?>
                                            <?php if (count($user->roles) > 2): ?>
                                                <span class="badge bg-light text-muted" data-bs-toggle="tooltip" 
                                                      title="<?= esc(implode(', ', array_slice($user->roles, 2))) ?>">
                                                    +<?= count($user->roles) - 2 ?> more
                                                </span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted">No roles</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($user->last_active)): 
                                            $date = \CodeIgniter\I18n\Time::parse($user->last_active);
                                        ?>
                                            <?= $date->format('M j, Y') ?>
                                            <div class="text-muted small">
                                                <?= $date->humanize() ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">Never</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group" role="group">
                                            <a href="<?= site_url('rbac/users/view/' . $user->id) ?>" 
                                               class="btn btn-sm btn-outline-primary" 
                                               data-bs-toggle="tooltip" 
                                               title="View User">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= site_url('rbac/users/edit/' . $user->id) ?>" 
                                               class="btn btn-sm btn-outline-secondary" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= site_url('rbac/users/assign-role/' . $user->id) ?>" 
                                               class="btn btn-sm btn-outline-info" 
                                               data-bs-toggle="tooltip" 
                                               title="Manage Roles">
                                                <i class="fas fa-user-shield"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteUserModal" 
                                                    data-user-id="<?= $user->id ?>"
                                                    data-user-name="<?= esc($user->username) ?>"
                                                    data-bs-toggle="tooltip"
                                                    title="Delete User">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-user-slash fa-2x mb-3"></i>
                                        <p class="mb-0">No users found</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if (isset($pager) && $pager->getPageCount() > 1): ?>
                <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                    <div class="text-muted small">
                        Showing <?= $pager->getCurrentPageFirstItem() ?> to <?= $pager->getCurrentPageLastItem() ?> 
                        of <?= $pager->getTotal() ?> users
                    </div>
                    <div>
                        <?= $pager->links('default', 'custom_pager') ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong id="userNameToDelete"></strong>?</p>
                <p class="text-danger small mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteUserForm" method="post" action="">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 1.1rem;
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
    white-space: nowrap;
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
    padding: 0.35em 0.65em;
    border-radius: 0.35rem;
    font-size: 0.8em;
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

.btn-group .btn {
    margin-right: 0.25rem;
    border-radius: 0.35rem !important;
}

.btn-group .btn:last-child {
    margin-right: 0;
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

/* Pagination styles */
.pagination {
    margin-bottom: 0;
}

.page-item.active .page-link {
    background-color: #4e73df;
    border-color: #4e73df;
}

.page-link {
    color: #4e73df;
    border: 1px solid #e3e6f0;
    padding: 0.5rem 0.75rem;
    margin: 0 0.2rem;
    border-radius: 0.35rem;
}

.page-link:hover {
    color: #224abe;
    background-color: #eaecf4;
    border-color: #e3e6f0;
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
    
    .card-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start !important;
    }
    
    .input-group {
        max-width: 100% !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const usersTable = document.getElementById('usersTable');
    
    if (searchInput && usersTable) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = usersTable.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header
                const row = rows[i];
                const text = row.textContent.toLowerCase();
                
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
        
        clearSearch.addEventListener('click', function() {
            searchInput.value = '';
            const rows = usersTable.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) {
                rows[i].style.display = '';
            }
            
            searchInput.focus();
        });
    }
    
    // Delete user modal
    const deleteUserModal = document.getElementById('deleteUserModal');
    if (deleteUserModal) {
        deleteUserModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');
            const userName = button.getAttribute('data-user-name');
            
            const modal = this;
            modal.querySelector('#userNameToDelete').textContent = userName;
            modal.querySelector('#deleteUserForm').action = `<?= site_url('rbac/users/delete/') ?>${userId}`;
        });
    }
    
    // Add animation to table rows
    const tableRows = document.querySelectorAll('#usersTable tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(10px)';
        row.style.transition = `opacity 0.3s ease, transform 0.3s ease ${index * 0.05}s`;
        
        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, 50);
    });
});
</script>

<?php include $coreViewPath . 'Partials/footer.php'; ?>
