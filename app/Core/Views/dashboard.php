<!-- Header -->
<?php include $coreViewPath . 'Partials/header.php'; ?>

<!-- Sidebar/Menu -->
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4"><?= esc($title) ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Welcome back, <?= auth()->user()->username ?? 'Admin' ?>!</li>
    </ol>

    <!-- Stat Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Total Users</h6>
                            <h3 class="mb-0"><?= number_format($totalUsers) ?></h3>
                        </div>
                        <div class="icon-circle bg-primary-light">
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3 small">
                        <span class="text-white-50">
                            <i class="fas fa-arrow-up"></i> <?= abs($userGrowth) ?>% from last month
                        </span>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= site_url('rbac/users') ?>">View Details</a>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Active Users</h6>
                            <h3 class="mb-0"><?= number_format($activeUsers) ?></h3>
                        </div>
                        <div class="icon-circle bg-success-light">
                            <i class="fas fa-user-check text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3 small">
                        <span class="text-white-50">
                            <?= $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0 ?>% of total users
                        </span>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= site_url('rbac/users') ?>?status=active">View Active</a>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Inactive Users</h6>
                            <h3 class="mb-0"><?= number_format($inactiveUsers) ?></h3>
                        </div>
                        <div class="icon-circle bg-warning-light">
                            <i class="fas fa-user-clock text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3 small">
                        <span class="text-white-50">
                            <?= $totalUsers > 0 ? round(($inactiveUsers / $totalUsers) * 100) : 0 ?>% of total users
                        </span>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= site_url('rbac/users') ?>?status=inactive">View Inactive</a>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">User Roles</h6>
                            <h3 class="mb-0"><?= count($rolesData['labels']) ?></h3>
                        </div>
                        <div class="icon-circle bg-info-light">
                            <i class="fas fa-user-tag text-white"></i>
                        </div>
                    </div>
                    <div class="mt-3 small">
                        <span class="text-white-50">
                            <?= implode(', ', array_map('ucfirst', $rolesData['labels'])) ?>
                        </span>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= site_url('rbac/roles') ?>">Manage Roles</a>
                    <i class="fas fa-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-xl-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-line me-2"></i>User Growth
                    </h6>
                    <div class="dropdown no-arrow
                    ">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v text-gray-400"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="#">Last 6 Months</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                            <li><a class="dropdown-item" href="#">All Time</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-pie me-2"></i>User Roles Distribution
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie">
                        <canvas id="userRolesChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <?php foreach ($rolesData['labels'] as $index => $label): ?>
                            <span class="me-3">
                                <i class="fas fa-circle" style="color: <?= $rolesData['colors'][$index] ?>"></i> 
                                <?= $label ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include $coreViewPath . 'Partials/footer.php'; ?>

<!-- Charts Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // User Growth Chart
    var ctx = document.getElementById('userGrowthChart').getContext('2d');
    var growthChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($growthData['labels']) ?>,
            datasets: [{
                label: 'New Users',
                data: <?= json_encode($growthData['data']) ?>,
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderColor: 'rgba(78, 115, 223, 1)',
                pointRadius: 3,
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointBorderColor: 'rgba(78, 115, 223, 1)',
                pointHoverRadius: 3,
                pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                pointHitRadius: 10,
                pointBorderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                },
                y: {
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    },
                    grid: {
                        color: 'rgb(234, 236, 244)',
                        borderDash: [2],
                        borderColor: 'transparent',
                        borderDashOffset: [2],
                        drawBorder: false,
                        drawTicks: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgb(255,255,255)',
                    bodyColor: '#858796',
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function(context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y.toLocaleString();
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });

    // User Roles Pie Chart
    var ctx2 = document.getElementById('userRolesChart');
    var rolesChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($rolesData['labels']) ?>,
            datasets: [{
                data: <?= json_encode($rolesData['data']) ?>,
                backgroundColor: <?= json_encode($rolesData['colors']) ?>,
                hoverBackgroundColor: <?= json_encode(array_map(function($color) {
                    return adjustColor(color, -20);
                }, $rolesData['colors'])) ?>,
                hoverBorderColor: 'rgba(234, 236, 244, 1)',
            }],
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    backgroundColor: 'rgb(255,255,255)',
                    bodyColor: '#858796',
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed !== null) {
                                label += context.parsed + ' users';
                            }
                            return label;
                        }
                    }
                },
                legend: {
                    display: false
                }
            },
            cutout: '70%',
        },
    });

    // Helper function to adjust color brightness
    function adjustColor(color, amount) {
        return '#' + color.replace(/^#/, '').replace(/../g, color => 
            ('0' + Math.min(255, Math.max(0, parseInt(color, 16) + amount)).toString(16)).substr(-2)
        );
    }
                borderColor: "rgba(13, 110, 253, 0.8)",
                backgroundColor: "rgba(13, 110, 253, 0.2)",
                fill: true,
                tension: 0.3
            }]
        }
    });

    // Dummy Product Distribution
    new Chart(document.getElementById("productChart"), {
        type: "doughnut",
        data: {
            labels: ["Electronics", "Clothing", "Books", "Others"],
            datasets: [{
                data: [120, 90, 60, 50],
                backgroundColor: ["#0d6efd", "#198754", "#ffc107", "#dc3545"]
            }]
        }
    });
</script>
