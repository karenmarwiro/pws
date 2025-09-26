     
<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container">
    <h2><?= $title ?></h2>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="toolbar-left">
            <button class="btn btn-primary" 
                onclick="openModal('<?= site_url('clients/add') ?>')">
            + Add Client
        </button>
        </div>
        <div class="toolbar-right">
            <input type="text" placeholder="Search clients..." class="search-bar">
        </div>
    </div>

    <!-- Clients Table -->
    <table class="table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Primary Contact</th>
                <th>Phone</th>
                <th>Labels</th>
                <th>Projects</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= $client['id'] ?></td>
                <td><?= $client['name'] ?></td>
                <td><?= $client['primary_contact'] ?></td>
                <td><?= $client['phone'] ?></td>
                <td>
                    <?php foreach ($client['labels'] as $label): ?>
                        <span class="label"><?= $label ?></span>
                    <?php endforeach; ?>
                </td>
                <td><?= $client['projects'] ?></td>
                <td>
    <a href="javascript:void(0)" 
       onclick="openModal('<?= site_url('clients/view/' . $client['id']) ?>')">View</a> | 

    <a href="javascript:void(0)" 
       onclick="openModal('<?= site_url('clients/edit/' . $client['id']) ?>')">Edit</a> | 

    <a href="javascript:void(0)" 
       onclick="confirmDelete('<?= site_url('clients/delete/' . $client['id']) ?>')">Delete</a>
</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <a href="#" class="page">&lt;</a>
        <a href="#" class="page active">1</a>
        <a href="#" class="page">2</a>
        <a href="#" class="page">3</a>
        <span>...</span>
        <a href="#" class="page">6</a>
        <a href="#" class="page">&gt;</a>
    </div>
</div>

<!-- Universal Modal (for Add/Edit/View loading via AJAX) -->
<div id="mainModal" class="modal">
    <div class="modal-content" id="modalBody">
        <!-- Content loads here -->
    </div>
</div>

<?php include $coreViewPath . 'Partials/footer.php'; ?>
