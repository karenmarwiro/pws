<?= $this->include('admin/layouts/header') ?>

<div class="container-fluid d-flex flex-column min-vh-100">
    <div class="row flex-grow-1">
        <?= $this->include('admin/layouts/sidebar') ?>
        
        <!-- Main Content -->
        <div class="col-md-10 d-flex flex-column main-content">
            <?= $this->renderSection('content') ?>

            <!-- Footer inside main-content -->
            <?= $this->include('admin/layouts/footer') ?>
        </div>
    </div>
</div>
