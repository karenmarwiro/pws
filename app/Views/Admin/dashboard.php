<?= $this->extend('Admin/layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Welcome Back, <?= esc($user->username ?? 'Admin') ?></h2>
    <div class="text-muted">
        <?= date('l, F j, Y') ?>
    </div>
</div>

<div class="row mb-4">
    <!-- Quick Stats -->
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Users</h5>
                <h2>1,234</h2>
                <p class="mb-0"><i class="bi bi-people-fill"></i> Active this month</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Sales</h5>
                <h2>$9,876</h2>
                <p class="mb-0"><i class="bi bi-cart-fill"></i> Total revenue</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Tickets</h5>
                <h2>45</h2>
                <p class="mb-0"><i class="bi bi-envelope-fill"></i> Pending</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">Alerts</h5>
                <h2>3</h2>
                <p class="mb-0"><i class="bi bi-exclamation-triangle-fill"></i> Critical issues</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Charts and Notifications -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <i class="bi bi-graph-up"></i> Monthly Traffic
            </div>
            <div class="card-body">
                <canvas id="trafficChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <i class="bi bi-bell-fill"></i> Recent Notifications
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">New user registered</li>
                <li class="list-group-item">Server backup completed</li>
                <li class="list-group-item">New order placed</li>
                <li class="list-group-item">Password changed successfully</li>
            </ul>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('trafficChart').getContext('2d');
    const trafficChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Week 1','Week 2','Week 3','Week 4'],
            datasets: [{
                label: 'Visits',
                data: [1200, 1500, 1100, 1800],
                backgroundColor: 'rgba(67, 97, 238, 0.2)',
                borderColor: 'rgba(67, 97, 238, 1)',
                borderWidth: 2,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
</script>

<?= $this->endSection() ?>
