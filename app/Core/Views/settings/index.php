<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0"><?= lang('App.site_settings') ?></h1>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-globe me-1"></i> <?= $languages[$language] ?? 'English' ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php foreach ($languages as $code => $name): ?>
                            <li>
                                <a class="dropdown-item d-flex justify-content-between align-items-center <?= $language === $code ? 'active' : '' ?>" 
                                   href="#" 
                                   onclick="changeLanguage('<?= $code ?>')">
                                    <?= $name ?>
                                    <?php if ($language === $code): ?>
                                        <i class="bx bx-check text-primary"></i>
                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="settings-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">
                                <i class="fas fa-cog me-1"></i> <?= lang('App.general_settings') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="appearance-tab" data-bs-toggle="tab" href="#appearance" role="tab" aria-controls="appearance" aria-selected="false">
                                <i class="fas fa-paint-brush me-1"></i> <?= lang('App.appearance') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="notifications-tab" data-bs-toggle="tab" href="#notifications" role="tab" aria-controls="notifications" aria-selected="false">
                                <i class="fas fa-bell me-1"></i> <?= lang('App.notifications') ?>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body">
                    <form id="settings-form" action="<?= site_url('settings/save') ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="tab-content" id="settings-tab-content">
                            <!-- General Settings -->
                            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="site_name"><?= lang('App.site_name_label') ?></label>
                                            <input type="text" class="form-control" id="site_name" name="site_name" value="<?= esc($settings['site_name'] ?? 'PWS Prototype') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="site_url"><?= lang('App.site_url_label') ?></label>
                                            <input type="url" class="form-control" id="site_url" name="site_url" value="<?= esc($settings['site_url'] ?? 'https://example.com') ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="admin_email"><?= lang('App.admin_email_label') ?></label>
                                            <input type="email" class="form-control" id="admin_email" name="admin_email" value="<?= esc($settings['admin_email'] ?? 'admin@example.com') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="timezone"><?= lang('App.timezone_label') ?></label>
                                            <select class="form-control" id="timezone" name="timezone">
                                                <option value="UTC" <?= ($settings['timezone'] ?? 'UTC') === 'UTC' ? 'selected' : '' ?>>UTC</option>
                                                <option value="America/New_York" <?= ($settings['timezone'] ?? '') === 'America/New_York' ? 'selected' : '' ?>>Eastern Time (ET)</option>
                                                <option value="America/Chicago" <?= ($settings['timezone'] ?? '') === 'America/Chicago' ? 'selected' : '' ?>>Central Time (CT)</option>
                                                <option value="America/Denver" <?= ($settings['timezone'] ?? '') === 'America/Denver' ? 'selected' : '' ?>>Mountain Time (MT)</option>
                                                <option value="America/Los_Angeles" <?= ($settings['timezone'] ?? '') === 'America/Los_Angeles' ? 'selected' : '' ?>>Pacific Time (PT)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="language"><?= lang('App.language_label') ?></label>
                                    <select class="form-control" id="language" name="language" onchange="this.form.submit()">
                                        <?php foreach ($languages as $code => $name): ?>
                                            <option value="<?= $code ?>" <?= ($language ?? 'en') === $code ? 'selected' : '' ?>><?= $name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Appearance Tab -->
                            <div class="tab-pane fade" id="appearance" role="tabpanel" aria-labelledby="appearance-tab">
                                <div class="form-group">
                                    <label for="theme"><?= lang('App.theme') ?></label>
                                    <select class="form-control" id="theme" name="theme">
                                        <option value="default" <?= ($settings['theme'] ?? 'default') === 'default' ? 'selected' : '' ?>>Default</option>
                                        <option value="dark" <?= ($settings['theme'] ?? '') === 'dark' ? 'selected' : '' ?>>Dark</option>
                                        <option value="light" <?= ($settings['theme'] ?? '') === 'light' ? 'selected' : '' ?>>Light</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mt-3">
                                    <label><?= lang('App.color_scheme') ?></label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="color_scheme" id="colorSchemeLight" value="light" <?= ($settings['color_scheme'] ?? 'light') === 'light' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="colorSchemeLight">
                                            <i class="fas fa-sun me-1"></i> <?= lang('App.light') ?>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="color_scheme" id="colorSchemeDark" value="dark" <?= ($settings['color_scheme'] ?? '') === 'dark' ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="colorSchemeDark">
                                            <i class="fas fa-moon me-1"></i> <?= lang('App.dark') ?>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="form-group mt-3">
                                    <label for="logo" class="form-label"><?= lang('App.logo') ?></label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                        <button class="btn btn-outline-secondary" type="button" id="upload-logo">
                                            <i class="fas fa-upload me-1"></i> <?= lang('App.upload') ?>
                                        </button>
                                    </div>
                                    <small class="form-text text-muted"><?= lang('App.logo_help') ?></small>
                                    <?php if (!empty($settings['logo'])): ?>
                                        <div class="mt-2">
                                            <img src="<?= base_url('uploads/' . $settings['logo']) ?>" alt="Logo" style="max-height: 50px;">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="remove_logo" name="remove_logo" value="1">
                                                <label class="form-check-label" for="remove_logo">
                                                    <?= lang('App.remove_logo') ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="form-group mt-3">
                                    <label for="favicon" class="form-label"><?= lang('App.favicon') ?></label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="favicon" name="favicon" accept=".ico,image/x-icon">
                                        <button class="btn btn-outline-secondary" type="button" id="upload-favicon">
                                            <i class="fas fa-upload me-1"></i> <?= lang('App.upload') ?>
                                        </button>
                                    </div>
                                    <small class="form-text text-muted"><?= lang('App.favicon_help') ?></small>
                                    <?php if (!empty($settings['favicon'])): ?>
                                        <div class="mt-2">
                                            <img src="<?= base_url('uploads/' . $settings['favicon']) ?>" alt="Favicon" style="height: 32px; width: 32px;">
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" id="remove_favicon" name="remove_favicon" value="1">
                                                <label class="form-check-label" for="remove_favicon">
                                                    <?= lang('App.remove_favicon') ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <!-- Notifications Tab -->
                            <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications" value="1" <?= ($settings['email_notifications'] ?? '1') === '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="email_notifications">
                                        <?= lang('App.enable_email_notifications') ?>
                                    </label>
                                </div>
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="browser_notifications" name="browser_notifications" value="1" <?= ($settings['browser_notifications'] ?? '1') === '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="browser_notifications">
                                        <?= lang('App.enable_browser_notifications') ?>
                                    </label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="desktop_notifications" name="desktop_notifications" value="1" <?= ($settings['desktop_notifications'] ?? '0') === '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="desktop_notifications">
                                        <?= lang('App.enable_desktop_notifications') ?>
                                    </label>
                                </div>
                                
                                <div class="mt-4">
                                    <h5><?= lang('App.notification_sound') ?></h5>
                                    <div class="form-group">
                                        <label for="notification_sound"><?= lang('App.select_sound') ?></label>
                                        <select class="form-control" id="notification_sound" name="notification_sound">
                                            <option value="default" <?= ($settings['notification_sound'] ?? 'default') === 'default' ? 'selected' : '' ?>><?= lang('App.default_sound') ?></option>
                                            <option value="chime" <?= ($settings['notification_sound'] ?? '') === 'chime' ? 'selected' : '' ?>><?= lang('App.chime_sound') ?></option>
                                            <option value="bell" <?= ($settings['notification_sound'] ?? '') === 'bell' ? 'selected' : '' ?>><?= lang('App.bell_sound') ?></option>
                                            <option value="ding" <?= ($settings['notification_sound'] ?? '') === 'ding' ? 'selected' : '' ?>><?= lang('App.ding_sound') ?></option>
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="test-sound">
                                        <i class="fas fa-volume-up me-1"></i> <?= lang('App.test_sound') ?>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Form Footer -->
                            <div class="card-footer text-end mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> <?= lang('App.save_changes') ?>
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="fas fa-undo me-1"></i> <?= lang('App.reset') ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Footer -->
<?php include $coreViewPath . 'Partials/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle form validation
    const form = document.getElementById('settings-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    }

    // Handle theme changes
    const themeSelect = document.getElementById('theme');
    if (themeSelect) {
        themeSelect.addEventListener('change', function() {
            // You can add theme preview logic here
            console.log('Theme changed to:', this.value);
        });
    }

    // Handle color scheme changes
    const colorSchemeRadios = document.querySelectorAll('input[name="color_scheme"]');
    colorSchemeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            // You can add color scheme preview logic here
            console.log('Color scheme changed to:', this.value);
        });
    });

    // Handle file upload buttons
    document.getElementById('upload-logo')?.addEventListener('click', function() {
        document.getElementById('logo').click();
    });

    document.getElementById('upload-favicon')?.addEventListener('click', function() {
        document.getElementById('favicon').click();
    });

    // Test notification sound
    document.getElementById('test-sound')?.addEventListener('click', function() {
        const sound = document.getElementById('notification_sound').value;
        const audio = new Audio(`/assets/sounds/${sound}.mp3`);
        audio.play().catch(e => console.error('Error playing sound:', e));
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Function to change language
function changeLanguage(lang) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '<?= site_url("settings/set_language") ?>';
    
    const csrfField = document.createElement('input');
    csrfField.type = 'hidden';
    csrfField.name = '<?= csrf_token() ?>';
    csrfField.value = '<?= csrf_hash() ?>';
    
    const langField = document.createElement('input');
    langField.type = 'hidden';
    langField.name = 'language';
    langField.value = lang;
    
    form.appendChild(csrfField);
    form.appendChild(langField);
    document.body.appendChild(form);
    form.submit();
}
</script>


