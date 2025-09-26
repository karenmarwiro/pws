<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container">
    <h2><?= $title ?></h2>

    <form>
        <label>Client Name</label>
        <input type="text" name="name" required>

        <label>Primary Contact</label>
        <input type="text" name="primary_contact" required>

        <label>Phone</label>
        <input type="text" name="phone" required>

        <label>Labels</label>
        <input type="text" name="labels">

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="/pws/clients" class="btn">Back</a>
        </div>
    </form>
</div>

<?php include $coreViewPath . 'Partials/footer.php'; ?>
