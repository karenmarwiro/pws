<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
  <!--begin::App Wrapper-->
  <div class="app-wrapper">
    <!--begin::Header-->
    <nav class="app-header navbar navbar-expand bg-body">
      <div class="container-fluid">
        <!--begin::Start Navbar-->
        <ul class="navbar-nav">
          <li class="nav-item">

            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
              <i class="bi bi-list"></i>
            </a>
          </li>
        </ul>
        <!--end::Start Navbar-->

        <!--begin::End Navbar (Empty but keeps layout right-aligned)-->
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
           
          </li>
          

          <li class="nav-item ">
    <a class="nav-link text-danger" href="<?= site_url('logout') ?>">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</li>


        </ul>


        <!--end::End Navbar-->
      </div>
    </nav>
    <!--end::Header-->
    

    
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="<?= base_url(); ?>" class="brand-link">
            <!--begin::Brand Image-->
          <img
            
           
            class="brand-image opacity-75 shadow" />

            <!--end::Brand Image-->

            <!--begin::Brand Text-->
            <span class="brand-text fw-light site-name"><?= esc(session('siteName') ?? ($settings['site_name'] ?? 'PWS')) ?></span>
            <!--end::Brand Text-->
          </a>
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="menu"
              data-accordion="false"
            >
            <li class="nav-item">
                <a href="<?= base_url('dashboard'); ?>" class="nav-link">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              
              <?php 
              // Load the module helper
              helper('module');
              
              // Get active modules
              $activeModules = get_active_modules();
              
              
              
              // Add active modules to the menu
              foreach ($activeModules as $module) {
                  // Skip core modules that are already in the menu
                  if (in_array($module['name'], ['Dashboard', 'Settings', 'RBAC', 'Modules'])) {
                      continue;
                  }
                  
                  $moduleName = $module['name'];
                  $moduleSlug = strtolower(str_replace(' ', '-', $moduleName));
                  $moduleIcon = get_module_icon($moduleName);
                  
                  echo '<li class="nav-item">
                    <a href="' . base_url($moduleSlug) . '" class="nav-link">
                      <i class="nav-icon bi ' . $moduleIcon . '"></i>
                      <p>' . $moduleName . '</p>
                    </a>
                  </li>';
              }
              ?>
              <li class="nav-item">
                <a href="<?= base_url('modules'); ?>" class="nav-link <?= uri_string() == 'modules' ? 'active' : '' ?>">
                  <i class="nav-icon bi bi-puzzle"></i>
                  <p>
                    Modules
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('rbac'); ?>" class="nav-link">
                  <i class="nav-icon bi bi-shield-lock"></i>
                  <p>
                    RBAC
                  </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?= base_url('settings') ?>" class="nav-link">
                  <i class="nav-icon bi bi-gear"></i>
                  <p>Settings</p>
                </a>
              </li>
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>


