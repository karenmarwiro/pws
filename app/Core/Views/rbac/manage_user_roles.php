<?= $this->extend('App\Core\Views\_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h2><?= $title ?></h2>
    
    <div class="card">
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label>Available Roles</label>
                    <?php foreach ($allRoles as $role): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="roles[]" 
                                   value="<?= $role->name ?>" 
                                   <?= in_array($role->name, $userRoles) ? 'checked' : '' ?>>
                            <label class="form-check-label">
                                <?= ucfirst($role->name) ?>
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
