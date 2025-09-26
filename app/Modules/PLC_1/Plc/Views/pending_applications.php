<table class="table table-bordered table-hover" id="pendingApplicationsTable" width="100%" cellspacing="0">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Reference No.</th>
            <th>Applicant Name</th>
            <th>Business Name</th>
            <th>Date Submitted</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($applications as $i => $app): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($app['reference_number']) ?></td>
                <td><?= esc($app['applicant_name']) ?></td>
                <td><?= esc($app['business_name']) ?></td>
                <td><?= date('Y-m-d', strtotime($app['created_at'])) ?></td>
                <td>
                    <?php if ($app['status'] === 'approved'): ?>
                        <span class="badge bg-success">Approved</span>
                    <?php elseif ($app['status'] === 'pending' || $app['status'] === 'processing'): ?>
                        <span class="badge bg-warning"><?= ucfirst($app['status']) ?></span>
                    <?php else: ?>
                        <span class="badge bg-secondary"><?= esc($app['status']) ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= site_url('admin/pbc/view/' . $app['id']) ?>" 
                       class="btn btn-sm btn-primary">
                       <i class="fas fa-eye"></i> View
                    </a>

                    <form action="<?= site_url('admin/pbc/delete/' . $app['id']) ?>" 
                          method="post" 
                          style="display:inline-block;" 
                          onsubmit="return confirm('Are you sure you want to delete this application?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
