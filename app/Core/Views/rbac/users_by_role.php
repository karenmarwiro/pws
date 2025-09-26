<?= $this->extend('App\\Core\\Views\\_layout') ?>

<?= $this->section('content') ?>
<div class="container">
    <h2><?= $title ?></h2>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $user->id ?></td>
                                <td><?= esc($user->username) ?></td>
                                <td><?= esc($user->email) ?></td>
                                <td>
                                    <a href="<?= site_url('rbac/manage-user-roles/' . $user->id) ?>" 
                                       class="btn btn-sm btn-info">Manage Roles</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <a href="<?= site_url('rbac') ?>" class="btn btn-secondary mt-3">Back to RBAC</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
