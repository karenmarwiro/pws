<!-- Sidebar -->
<div class="col-md-2 px-0 sidebar">
    <div class="text-center py-4">
        <h4>Admin Panel</h4>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?= url_is('admin/dashboard*') ? 'active' : '' ?>" href="/">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= url_is('admin/users*') ? 'active' : '' ?>" href="#">
                <i class="bi bi-people"></i> Users
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= url_is('admin/settings*') ? 'active' : '' ?>" href="#">
                <i class="bi bi-gear"></i> Settings
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link dropdown-toggle <?= url_is('admin/modules*') ? 'active' : '' ?>" href="#" data-bs-toggle="collapse" data-bs-target="#modulesCollapse" aria-expanded="false">
                <i class="bi bi-grid"></i> Modules
            </a>
            <div class="collapse <?= url_is('admin/modules*') ? 'show' : '' ?>" id="modulesCollapse">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link <?= url_is('admin/modules') ? 'active' : '' ?>" href="#">
                            <i class="bi bi-grid"></i> All Modules
                        </a>
                    </li>
                    
                    
                </ul>
            </div>
        </li>
        <li class="nav-item mt-4">
            <a class="nav-link text-danger" href="<?= base_url('logout') ?>">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </li>
    </ul>
</div>