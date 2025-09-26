<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container">
    <h2><?= $title ?></h2>

    <form>
        <label>Client Name</label>
        <input type="text" name="name" value="<?= $client['name'] ?>" required>

        <label>Primary Contact</label>
        <input type="text" name="primary_contact" value="<?= $client['primary_contact'] ?>" required>

        <label>Phone</label>
        <input type="text" name="phone" value="<?= $client['phone'] ?>" required>

        <label>Labels</label>
        <input type="text" name="labels" value="<?= $client['labels'] ?>">

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="/pws/clients" class="btn">Back</a>
        </div>
    </form>
</div>

<?php include $coreViewPath . 'Partials/footer.php'; ?>
