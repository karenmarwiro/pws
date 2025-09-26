<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container-fluid px-4">
    <h1 class="h3 mb-4">Assign Role to User: <?= esc($user->username) ?></h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= site_url('rbac/users/assign-role/'.$user->id) ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label for="role" class="form-label">Select Role</label>
            <select id="role" name="role" class="form-select" required>
                <option value="" disabled selected>Choose a role</option>
                <?php foreach ($allRoles as $r): ?>
                    <option value="<?= esc($r) ?>" <?= in_array($r, $user->roles) ? 'selected' : '' ?>>
                        <?= esc(ucfirst($r)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Assign Role</button>
        <a href="<?= site_url('rbac/users') ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include $coreViewPath . 'Partials/footer.php'; ?>
