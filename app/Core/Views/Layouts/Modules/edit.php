<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <!-- Main Content -->
        <div class="col-12">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="<?= site_url('modules') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Modules
                </a>
            </div>
            <!-- Notifications -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= site_url('modules') ?>">Modules</a></li>
                    <li class="breadcrumb-item active">Edit Module</li>
                </ol>
            </nav>

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-edit me-2"></i>
                    Edit Module: <?= $module['name'] ?>
                </h1>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <!-- Edit Form -->
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0">Module Details</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?= site_url('modules/update/' . $module['id']) ?>" method="POST">
                                <?= csrf_field() ?>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Module Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>" 
                                                   id="name" name="name" value="<?= old('name', $module['name']) ?>" required>
                                            <?php if (session('errors.name')): ?>
                                                <div class="invalid-feedback"><?= session('errors.name') ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="version" class="form-label">Version <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?= session('errors.version') ? 'is-invalid' : '' ?>" 
                                                   id="version" name="version" value="<?= old('version', $module['version']) ?>" required>
                                            <?php if (session('errors.version')): ?>
                                                <div class="invalid-feedback"><?= session('errors.version') ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control <?= session('errors.description') ? 'is-invalid' : '' ?>" 
                                              id="description" name="description" rows="3" required><?= old('description', $module['description']) ?></textarea>
                                    <?php if (session('errors.description')): ?>
                                        <div class="invalid-feedback"><?= session('errors.description') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="author" class="form-label">Author</label>
                                            <input type="text" class="form-control" id="author" name="author" 
                                                   value="<?= old('author', $module['author'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="icon" class="form-label">Icon</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="<?= old('icon', $module['icon'] ?? 'fas fa-cube') ?>"></i></span>
                                                <input type="text" class="form-control" id="icon" name="icon" 
                                                       value="<?= old('icon', $module['icon'] ?? 'fas fa-cube') ?>" 
                                                       placeholder="fas fa-cube">
                                            </div>
                                            <small class="form-text text-muted">Font Awesome icon class</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="namespace" class="form-label">Namespace</label>
                                            <input type="text" class="form-control" id="namespace" name="namespace" 
                                                   value="<?= old('namespace', $module['namespace'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="order" class="form-label">Display Order</label>
                                            <input type="number" class="form-control" id="order" name="order" 
                                                   value="<?= old('order', $module['order'] ?? 0) ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Module Type</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_core" id="core-module" 
                                               value="1" <?= ($module['is_core']) ? 'checked' : '' ?> <?= $module['is_core'] ? 'disabled' : '' ?>>
                                        <label class="form-check-label" for="core-module">
                                            Core Module <span class="badge bg-primary ms-2">System Essential</span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_core" id="addin-module" 
                                               value="0" <?= (!$module['is_core']) ? 'checked' : '' ?> <?= $module['is_core'] ? 'disabled' : '' ?>>
                                        <label class="form-check-label" for="addin-module">
                                            Add-in Module <span class="badge bg-success ms-2">Removable</span>
                                        </label>
                                    </div>
                                    <?php if ($module['is_core']): ?>
                                        <small class="form-text text-muted">Core modules cannot be changed to add-ins for system stability.</small>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               value="1" <?= ($module['is_active']) ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="is_active">
                                            Module Enabled
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Disable to temporarily turn off this module without uninstalling.</small>
                                </div>

                                <div class="mb-3">
                                    <label for="settings" class="form-label">Module Settings (JSON)</label>
                                    <textarea class="form-control font-monospace" id="settings" name="settings" 
                                              rows="5" style="font-size: 0.9rem;"><?= old('settings', isset($module['settings']) ? json_encode($module['settings'], JSON_PRETTY_PRINT) : '{}') ?></textarea>
                                    <small class="form-text text-muted">Advanced configuration in JSON format.</small>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="<?= site_url('modules/update/' . $module['id']) ?>" class="btn btn-outline-primary me-2">
                                            <i class="fas fa-sync-alt me-1"></i> Update Module Files
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Save Changes
                                        </button>
                                        <a href="<?= site_url('modules') ?>" class="btn btn-outline-secondary ms-2">
                                            Cancel
                                        </a>
                                    </div>
                                    <?php if (!$module['is_core']): ?>
                                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                                            <i class="fas fa-trash me-1"></i> Delete Module
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Module Info Card -->
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="card-title mb-0">Module Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <div class="module-icon-large bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                     style="width: 80px; height: 80px;">
                                    <i class="<?= $module['icon'] ?? 'fas fa-cube' ?> fa-2x"></i>
                                </div>
                                <h5><?= $module['name'] ?></h5>
                                <span class="badge bg-<?= $module['is_core'] ? 'primary' : 'success' ?>">
                                    <?= $module['is_core'] ? 'Core Module' : 'Add-in Module' ?>
                                </span>
                                <span class="badge bg-<?= $module['is_active'] ? 'success' : 'danger' ?> ms-1">
                                    <?= $module['is_active'] ? 'Enabled' : 'Disabled' ?>
                                </span>
                            </div>

                            <div class="module-info">
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <strong>Version:</strong>
                                    <span>v<?= $module['version'] ?></span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <strong>Last Updated:</strong>
                                    <span><?= isset($module['updated_at']) ? date('M j, Y H:i', strtotime($module['updated_at'])) : 'Never' ?></span>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <strong>Created:</strong>
                                    <span><?= isset($module['created_at']) ? date('M j, Y', strtotime($module['created_at'])) : 'Unknown' ?></span>
                                </div>
                                <?php if (isset($module['author'])): ?>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <strong>Author:</strong>
                                    <span><?= $module['author'] ?></span>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Quick Actions -->
                            <div class="mt-4">
                                <h6 class="text-muted mb-3">Quick Actions</h6>
                                <div class="d-grid gap-2">
                                    <?php if ($module['is_active']): ?>
                                        <button class="btn btn-outline-warning" onclick="toggleModule(<?= $module['id'] ?>, false)">
                                            <i class="fas fa-toggle-off me-1"></i> Disable Module
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-outline-success" onclick="toggleModule(<?= $module['id'] ?>, true)">
                                            <i class="fas fa-toggle-on me-1"></i> Enable Module
                                        </button>
                                    <?php endif; ?>
                                    
                                    <a href="<?= site_url('modules') ?>" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-1"></i> Back to Modules
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Danger Zone -->
                    <?php if (!$module['is_core']): ?>
                    <div class="card border-danger mt-4">
                        <div class="card-header bg-danger text-white">
                            <h5 class="card-title mb-0">Danger Zone</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">These actions are irreversible. Please be cautious.</p>
                            <button class="btn btn-outline-danger w-100" onclick="confirmDelete()">
                                <i class="fas fa-trash me-1"></i> Delete This Module
                            </button>
                            <small class="form-text text-muted">This will completely remove the module and all its data.</small>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the module <strong>"<?= $module['name'] ?>"</strong>?</p>
                <p class="text-danger">This action cannot be undone. All module data will be permanently removed.</p>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="confirmDelete">
                    <label class="form-check-label" for="confirmDelete">
                        I understand this action is irreversible
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn" disabled>
                    <i class="fas fa-trash me-1"></i> Delete Module
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
    
    document.getElementById('confirmDelete').addEventListener('change', function() {
        document.getElementById('confirmDeleteBtn').disabled = !this.checked;
    });
    
    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        window.location.href = '<?= site_url('modules/delete/') ?>' + '<?= $module['id'] ?>';
    });
}

function toggleModule(moduleId, enable) {
    if (confirm(enable ? 'Enable this module?' : 'Disable this module?')) {
        fetch(`<?= site_url('api/modules/') ?>${moduleId}/toggle`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ enable: enable })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error toggling module: ' + error);
        });
    }
}

// JSON validation for settings field
document.getElementById('settings').addEventListener('blur', function() {
    try {
        JSON.parse(this.value);
        this.classList.remove('is-invalid');
    } catch (e) {
        this.classList.add('is-invalid');
    }
});
</script>

<style>
.sidebar {
    background-color: #f8f9fa;
    border-right: 1px solid #dee2e6;
    min-height: calc(100vh - 56px);
    padding-top: 1rem;
}

.sidebar .nav-link {
    color: #495057;
    border-radius: 0.25rem;
    margin: 0.1rem 0.5rem;
    padding: 0.5rem 1rem;
}

.sidebar .nav-link:hover {
    background-color: #e9ecef;
    color: #007bff;
}

.sidebar .nav-link.active {
    background-color: #007bff;
    color: white;
}

.module-icon-large {
    font-size: 2rem;
}

.module-info {
    background-color: #f8f9fa;
    border-radius: 0.5rem;
    padding: 1rem;
}

.form-check-input:disabled {
    background-color: #e9ecef;
}

.font-monospace {
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
}

.card {
    border: 1px solid rgba(0,0,0,.125);
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
</style>
<?= $this->endSection() ?>