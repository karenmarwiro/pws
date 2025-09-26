<?= $this->extend('App\\Core\\Views\\_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h2>RBAC Management</h2>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Roles</div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php if (!empty($roles)): ?>
                            <?php foreach ($roles as $role): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><?= esc(ucfirst($role->name)) ?></span>
                                <div>
                                    <a href="<?= site_url("rbac/manage-permissions/{$role->name}") ?>" 
                                       class="btn btn-sm btn-info">Permissions</a>
                                    <a href="<?= site_url("rbac/users-by-role/{$role->name}") ?>" 
                                       class="btn btn-sm btn-secondary">Users</a>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item">No roles found</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Quick Actions</div>
                <div class="card-body">
                    <a href="<?= site_url('rbac/manage-roles') ?>" 
                       class="btn btn-primary btn-block mb-2">Manage User Roles</a>
                    <a href="<?= site_url('users') ?>" 
                       class="btn btn-secondary btn-block">View All Users</a>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">System Users</div>
                <div class="card-body">
                    <?php if (!empty($users)): ?>
                        <ul class="list-group">
                            <?php foreach ($users as $user): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><?= esc($user->username) ?></span>
                                    <a href="<?= site_url("rbac/manage-roles/{$user->id}") ?>" 
                                       class="btn btn-sm btn-outline-primary">Manage Roles</a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No users found</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Add any additional JavaScript here
</script>
<?= $this->endSection() ?>
