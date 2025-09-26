<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><?= esc($title) ?></h1>
            <p class="text-muted mb-0">Manage user roles and their permissions</p>
        </div>
        <div>
            <a href="<?= site_url('rbac/roles/add') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add Role
            </a>
            <a href="<?= site_url('rbac/users') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-shield-alt me-2"></i>Manage Users
            </a>
            <a href="<?= site_url('rbac/permissions') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-shield-alt me-2"></i>Permissions
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
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

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 60px;">#</th>
                            <th>Role</th>
                            <th>Description</th>
                            <th class="text-center" style="width: 120px;">Users</th>
                            <th class="text-end pe-4" style="width: 220px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($roles)): $i=1; foreach ($roles as $role): ?>
                        <tr>
                            <td class="ps-4 text-muted"><?= $i++ ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="role-icon me-3">
                                        <i class="fas fa-user-shield text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0"><?= esc(ucfirst($role['group'])) ?></h6>
                                        <small class="text-muted">ID: <?= $role['id'] ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 text-muted"><?= esc($role['description'] ?: 'No description provided') ?></p>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill"><?= (int)($role['users_count'] ?? 0) ?> users</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group" role="group">
                                    <a href="<?= site_url('rbac/roles/edit/'.$role['id']) ?>" 
                                       class="btn btn-sm btn-outline-primary" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit Role">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= site_url('rbac/roles/permissions/'.$role['id']) ?>" 
                                       class="btn btn-sm btn-outline-info" 
                                       data-bs-toggle="tooltip" 
                                       title="Manage Permissions">
                                        <i class="fas fa-shield-alt"></i>
                                    </a>
                                    <a href="<?= site_url('rbac/roles/assign/1') ?>" 
                                       class="btn btn-sm btn-outline-success" 
                                       data-bs-toggle="tooltip" 
                                       title="Assign to User">
                                        <i class="fas fa-user-plus"></i>
                                    </a>
                                    <form action="<?= site_url('rbac/roles/delete/'.$role['id']) ?>" 
                                          method="post" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this role? This action cannot be undone.');">
                                        <?= csrf_field() ?>
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger" 
                                                data-bs-toggle="tooltip" 
                                                title="Delete Role"
                                                <?= ($role['users_count'] ?? 0) > 0 ? 'disabled' : '' ?>>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted mb-3">
                                    <i class="fas fa-user-shield fa-3x opacity-25"></i>
                                </div>
                                <h5 class="text-muted">No roles found</h5>
                                <p class="text-muted">Get started by creating your first role</p>
                                <a href="<?= site_url('rbac/roles/add') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Add Role
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if (!empty($roles) && count($roles) > 5): ?>
        <div class="card-footer bg-transparent">
            <nav aria-label="Roles pagination">
                <ul class="pagination justify-content-end mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRoleModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this role? This action cannot be undone.</p>
                <p class="text-danger"><strong>Warning:</strong> Deleting this role will remove all associated permissions.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete Role</button>
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
.table > :not(caption) > * > * {
    padding: 1rem 0.5rem;
}
</style>

<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Handle delete confirmation
    var deleteModal = document.getElementById('deleteRoleModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var form = button.closest('form');
            var confirmBtn = document.getElementById('confirmDelete');
            
            confirmBtn.onclick = function() {
                form.submit();
            };
        });
    }
});
</script>