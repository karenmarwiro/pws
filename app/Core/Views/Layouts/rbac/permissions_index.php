<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1"><?= esc($title) ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?= site_url('rbac') ?>">RBAC</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Roles</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="<?= site_url('rbac') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to RBAC
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

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-user-shield text-primary me-2"></i>User Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="user-avatar me-3">
                            <div class="avatar-circle bg-primary text-white d-flex align-items-center justify-content-center">
                                <?= strtoupper(substr($user['username'] ?? 'U', 0, 1)) ?>
                            </div>
                        </div>
                        <div>
                            <h4 class="mb-1"><?= esc($user['username'] ?? 'N/A') ?></h4>
                            <span class="text-muted">User ID: <?= (int)($user['id'] ?? 0) ?></span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="mb-3">Assign New Role</h5>
                        <form action="<?= site_url('rbac/roles/assign/'.$user['id']) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="input-group mb-3">
                                <select name="role" class="form-select" required>
                                    <option value="" selected disabled>Select a role to assign...</option>
                                    <?php foreach ($roles as $r): ?>
                                        <option value="<?= esc($r['group']) ?>"><?= esc(ucfirst($r['group'])) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-plus me-1"></i> Assign Role
                                </button>
                            </div>
                        </form>
                    </div>

                    <?php if (!empty($current)): ?>
                        <div class="mt-4">
                            <h5 class="mb-3">Current Roles</h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Role</th>
                                            <th>Assigned</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($current as $cr): ?>
                                            <tr>
                                                <td>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                                                        <i class="fas fa-shield-alt me-1"></i>
                                                        <?= esc(ucfirst($cr['group'])) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php 
                                                        $date = new DateTime($cr['created_at'] ?? 'now');
                                                        echo 'Assigned ' . $date->format('M j, Y');
                                                        ?>
                                                    </small>
                                                </td>
                                                <td class="text-end">
                                                    <form action="<?= site_url('rbac/roles/remove/'.$user['id']) ?>" 
                                                          method="post" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to remove this role from the user?')">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="role" value="<?= esc($cr['group']) ?>">
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                data-bs-toggle="tooltip" data-bs-placement="top" 
                                                                title="Remove Role">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-light border d-flex align-items-center" role="alert">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            <div>
                                <strong>No roles assigned yet.</strong> Use the form above to assign roles to this user.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer bg-white border-top py-3">
                    <a href="<?= site_url('rbac') ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to RBAC
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>Role Management
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-light border small">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-2">
                                <i class="fas fa-lightbulb text-warning"></i>
                            </div>
                            <div>
                                <strong>Role-Based Access Control</strong>
                                <p class="mb-0 mt-1">
                                    Assign roles to users to control their access to different parts of the system. 
                                    Each role has specific permissions that determine what actions a user can perform.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="<?= site_url('rbac/roles') ?>" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-cog me-1"></i> Manage All Roles
                        </a>
                        <a href="<?= site_url('rbac/users') ?>" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-users me-1"></i> View All Users
                        </a>
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