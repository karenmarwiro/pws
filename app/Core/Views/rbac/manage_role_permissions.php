<?= $this->extend('App\\Core\\Views\\_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h2><?= $title ?></h2>
    
    <div class="card">
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label>Available Permissions</label>
                    <?php 
                    // This would typically come from a permissions config or database
                    $allPermissions = [
                        'users.create', 'users.read', 'users.update', 'users.delete',
                        'roles.create', 'roles.read', 'roles.update', 'roles.delete',
                        'settings.manage', 'logs.view'
                    ];
                    
                    foreach ($allPermissions as $permission): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" 
                                   value="<?= $permission ?>" 
                                   <?= in_array($permission, $rolePermissions) ? 'checked' : '' ?>>
                            <label class="form-check-label">
                                <?= $permission ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                <a href="<?= site_url('rbac') ?>" class="btn btn-secondary mt-3">Back</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
