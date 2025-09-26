<!-- Header -->
<?php include $coreViewPath . 'Partials/header.php'; ?>

<!-- Sidebar/Menu -->
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1 class="mt-4"><?= esc($title) ?></h1>
        <a href="<?= site_url('users/add') ?>" class="btn btn-success mb-2">Add User</a>
    </section>

    <section class="content">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th><th>Name</th><th>Email</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= esc($user['name']) ?></td>
                        <td><?= esc($user['email']) ?></td>
                        <td>
                            <a href="<?= site_url('users/edit/'.$user['id']) ?>" class="btn btn-primary btn-sm">Edit</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>
</div>

<!-- Header -->
<?php include $coreViewPath . 'Partials/footer.php'; ?>


