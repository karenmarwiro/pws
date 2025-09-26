<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0"><?= esc($title) ?></h1>
            <p class="text-muted mb-0">Manage role assignments for user</p>
        </div>
        <div>
            <a href="<?= site_url('rbac') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Roles
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-user-shield text-primary me-2"></i>User Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="avatar avatar-xl bg-light rounded-circle me-4">
                            <i class="fas fa-user text-primary" style="font-size: 2rem; line-height: 3.5rem; width: 3.5rem; text-align: center;"></i>
                        </div>
                        <div>
                            <h4 class="mb-1"><?= esc($user->username) ?></h4>
                            <p class="text-muted mb-0">User ID: <?= (int)$user->id ?></p>
                            <p class="text-muted mb-0">Email: <?= esc($user->email ?? 'Not provided') ?></p>
                        </div>
                    </div>

                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            
                    <form action="<?= site_url('rbac/roles/assign/'.$user->id) ?>" method="post">
    <?= csrf_field() ?>
                                    <div class="mb-3">
                                    <label class="form-label fw-semibold">Assign New Role</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        <select name="role" class="form-select form-select-lg" required>
                                            <option value="">-- Select a role --</option>
                                            <?php foreach ($roles as $r): 
                                                $roleName = $r->group ?? $r['group'] ?? '';
                                            ?>
                                                <option value="<?= esc($roleName) ?>">
                                                    <?= ucwords(str_replace('_', ' ', esc($roleName))) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-text">Select a role to assign to this user</div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-plus-circle me-2"></i>Assign Role
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!empty($current)): ?>
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-list-check text-primary me-2"></i>Current Role Assignments
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <?php foreach ($current as $cr): 
                                $roleName = $cr->group ?? $cr['group'] ?? '';
                                $roleId = $cr->id ?? $cr['id'] ?? '';
                            ?>
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1"><?= ucwords(str_replace('_', ' ', esc($roleName))) ?></h6>
                                            <small class="text-muted">Assigned on: <?= date('M d, Y', strtotime($cr->created_at ?? 'now')) ?></small>
                                        </div>
                                        <form action="<?= site_url('rbac/roles/remove/'.$user->id) ?>" method="post" class="m-0" onsubmit="return confirm('Are you sure you want to remove this role from the user?')">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="role" value="<?= esc($roleName) ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash-alt me-1"></i>Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>This user doesn't have any roles assigned yet.
                </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>Role Management
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start mb-4">
                        <div class="role-icon me-3">
                            <i class="fas fa-shield-alt text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-2">About Role Assignment</h6>
                            <p class="small text-muted mb-0">
                                Assigning roles to users controls their access to different parts of the system. 
                                Make sure to assign only the necessary roles to maintain security.
                            </p>
                        </div>
                    </div>

                    <div class="alert alert-light border small">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-2">
                                <i class="fas fa-lightbulb text-warning"></i>
                            </div>
                            <div>
                                <strong>Tip:</strong> You can manage available roles in the 
                                <a href="<?= site_url('rbac/roles') ?>">Roles Management</a> section.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 3.5rem;
    height: 3.5rem;
    border-radius: 50%;
    background-color: #f8f9fa;
}

.role-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: rgba(13, 110, 253, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: #0d6efd;
}

.list-group-item {
    padding: 1rem 1.25rem;
    transition: background-color 0.2s;
}

.list-group-item:hover {
    background-color: #f8f9fa;
}

.input-group-text {
    min-width: 45px;
    justify-content: center;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('assignRoleForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const roleSelect = form.querySelector('select[name="role"]');
            if (!roleSelect.value) {
                e.preventDefault();
                roleSelect.focus();
                // Add Bootstrap's is-invalid class
                roleSelect.classList.add('is-invalid');
                // Add error message if not exists
                if (!roleSelect.nextElementSibling || !roleSelect.nextElementSibling.classList.contains('invalid-feedback')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = 'Please select a role to assign';
                    roleSelect.parentNode.insertBefore(errorDiv, roleSelect.nextSibling);
                }
            }
        });
    }
});
</script>

<?php include $coreViewPath . 'Partials/footer.php'; ?>