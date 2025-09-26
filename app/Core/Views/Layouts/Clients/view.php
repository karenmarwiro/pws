<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container">
    <h2><?= $title ?></h2>

    <p><strong>ID:</strong> <?= $client['id'] ?></p>
    <p><strong>Name:</strong> <?= $client['name'] ?></p>
    <p><strong>Primary Contact:</strong> <?= $client['primary_contact'] ?></p>
    <p><strong>Phone:</strong> <?= $client['phone'] ?></p>
    <p><strong>Labels:</strong> <?= $client['labels'] ?></p>
    <p><strong>Projects:</strong> <?= $client['projects'] ?></p>

    <div class="form-actions">
        <a href="/pws/clients" class="btn">Back</a>
    </div>
</div>

<?php include $coreViewPath . 'Partials/footer.php'; ?>
