
<?php include $coreViewPath . 'Partials/header.php'; ?>
<?php include $coreViewPath . 'Partials/menu.php'; ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 mb-1">Add New Module</h1>
            <p class="text-muted">Upload and install a new module package</p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= site_url('modules') ?>" class="btn btn-label-secondary">
                <i class="bx bx-arrow-back me-2"></i>Back to Modules
            </a>
        </div>
    </div>

    <!-- Alerts -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bx bx-check-circle me-2"></i><?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bx bx-error-circle me-2"></i><?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Main Form -->
        <div class="col-12 col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <i class="bx bx-upload text-primary me-2"></i>Upload Module Package
                    </h5>
                    <span class="badge bg-label-primary">Step 1 of 2</span>
                </div>
                <div class="card-body">
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bx bx-info-circle me-2"></i>
                            <div>
                                <h6 class="alert-heading mb-1">Module Package Requirements</h6>
                                <ul class="mb-0">
                                    <li>Only <strong>.zip</strong> files are accepted</li>
                                    <li>Maximum file size: <strong>50MB</strong></li>
                                    <li>Must contain a valid <code>module.json</code> file</li>
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    
                    <form id="moduleUploadForm" action="<?= site_url('modules/upload') ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <?= csrf_field() ?>
                        
                        <!-- Dropzone -->
                        <div class="dropzone text-center py-5 mb-4" id="moduleDropzone">
                            <div class="dropzone-inner">
                                <i class="bx bx-cloud-upload display-4 text-muted mb-3"></i>
                                <h5 class="mb-2">Drag & drop your module package here</h5>
                                <p class="text-muted mb-3">or</p>
                                <button type="button" class="btn btn-primary" id="browseBtn">
                                    <i class="bx bx-folder-open me-2"></i>Browse Files
                                </button>
                                <input type="file" name="module_zip" id="fileInput" class="d-none" accept=".zip" required>
                                <p class="small text-muted mt-3 mb-0">Supported format: .zip (max 50MB)</p>
                            </div>
                        </div>

                        <!-- File Preview -->
                        <div id="filePreview" class="mb-4 d-none">
                            <div class="card border-0 bg-light">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar">
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class="bx bx-package fs-4"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1" id="fileName"></h6>
                                            <p class="small text-muted mb-0" id="fileSize"></p>
                                        </div>
                                        <button type="button" class="btn-close" id="removeFileBtn" aria-label="Remove file"></button>
                                    </div>
                                    <div class="progress mt-3 d-none" id="uploadProgressContainer">
                                        <div id="uploadProgress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module Details (will be shown after upload) -->
                        <div id="moduleDetails" class="d-none">
                            <h5 class="mb-3"><i class="bx bx-info-circle text-primary me-2"></i>Module Information</h5>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Module Name</label>
                                    <input type="text" class="form-control" id="moduleName" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Version</label>
                                    <input type="text" class="form-control" id="moduleVersion" readonly>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" id="moduleDescription" rows="2" readonly></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center pt-3 mt-4 border-top">
                            <a href="<?= site_url('modules') ?>" class="btn btn-label-secondary">
                                <i class="bx bx-x me-2"></i>Cancel
                            </a>
                            <div>
                                <button type="button" class="btn btn-outline-secondary me-2 d-none" id="backToUploadBtn">
                                    <i class="bx bx-arrow-back me-2"></i>Back
                                </button>
                                <button type="submit" class="btn btn-primary" id="uploadBtn" disabled>
                                    <i class="bx bx-upload me-2"></i>Upload Module
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-12 col-lg-4">
            <!-- Help Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-help-circle text-primary me-2"></i>Need Help?
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-3 mb-4">
                        <div class="flex-shrink-0">
                            <div class="avatar">
                                <span class="avatar-initial rounded-circle bg-label-primary">
                                    <i class="bx bx-question-mark"></i>
                                </span>
                            </div>
                        </div>
                        <div>
                            <h6 class="mb-2">Creating a Module Package</h6>
                            <p class="small">Your module package should be a .zip file containing:</p>
                            <ul class="list-unstyled small">
                                <li class="mb-2">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    A valid <code>module.json</code> file
                                </li>
                                <li class="mb-2">
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    All necessary PHP files in proper directory structure
                                </li>
                                <li>
                                    <i class="bx bx-check-circle text-success me-2"></i>
                                    Any assets (CSS, JS, images) in an <code>assets</code> directory
                                </li>
                            </ul>
                            <a href="#" class="btn btn-sm btn-outline-primary mt-2">
                                <i class="bx bx-book-open me-2"></i>View Documentation
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Requirements -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bx bx-cog text-primary me-2"></i>System Requirements
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex mb-3">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx-check"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-0">PHP 7.4 or higher</h6>
                                <small class="text-muted">Current: <?= phpversion() ?></small>
                            </div>
                        </li>
                        <li class="d-flex mb-3">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx-check"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-0">Write Permissions</h6>
                                <small class="text-muted">/app/Modules directory must be writable</small>
                            </div>
                        </li>
                        <li class="d-flex">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class="bx bx-check"></i>
                                </span>
                            </div>
                            <div>
                                <h6 class="mb-0">Composer</h6>
                                <small class="text-muted">Required for dependency management</small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $coreViewPath . 'Partials/footer.php'; ?>

<style>
/* Dropzone Styles */
.dropzone {
    min-height: 240px;
    border: 2px dashed #dee2e6;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background-color: #f8f9fa;
    position: relative;
    overflow: hidden;
}

.dropzone:hover, .dropzone.dragover {
    border-color: #0d6efd;
    background-color: rgba(13, 110, 253, 0.05);
}

.dropzone.dragover::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(13, 110, 253, 0.1);
    z-index: 1;
}

.dz-message {
    padding: 2rem 1rem;
    position: relative;
    z-index: 2;
}

/* File Preview Styles */
.file-preview {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
    padding: 1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    transition: all 0.2s;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
}

.file-preview:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
}

.file-icon {
    font-size: 1.75rem;
    margin-right: 1rem;
    color: #6c757d;
    min-width: 2.5rem;
    text-align: center;
}

.file-info {
    flex: 1;
    min-width: 0;
    overflow: hidden;
}

.file-name {
    font-weight: 500;
    margin-bottom: 0.25rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.file-size {
    font-size: 0.8125rem;
    color: #6c757d;
}

.file-actions {
    display: flex;
    align-items: center;
    margin-left: 1rem;
}

.file-remove {
    color: #dc3545;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 0.25rem;
    transition: background-color 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
}

.file-remove:hover {
    background-color: rgba(220, 53, 69, 0.1);
}

/* Progress Bar */
.progress {
    height: 0.5rem;
    margin-top: 0.5rem;
    border-radius: 0.25rem;
    overflow: hidden;
    background-color: #e9ecef;
}

.progress-bar {
    background-color: #0d6efd;
    transition: width 0.6s ease;
}

/* Alert Styling */
.alert {
    border: none;
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
}

.alert-info {
    background-color: #f0f7ff;
    color: #084298;
}

/* Button Styles */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
    transition: all 0.2s;
}

.btn i {
    font-size: 0.875em;
}

/* Responsive Adjustments */
@media (max-width: 767.98px) {
    .dropzone {
        padding: 1.5rem;
    }
    
    .file-preview {
        flex-direction: column;
        text-align: center;
    }
    
    .file-icon {
        margin-right: 0;
        margin-bottom: 0.5rem;
    }
    
    .file-actions {
        margin-left: 0;
        margin-top: 0.75rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize elements
    const dropzone = document.getElementById('moduleDropzone');
    const fileInput = document.getElementById('fileInput');
    const browseBtn = document.getElementById('browseBtn');
    const removeFileBtn = document.getElementById('removeFileBtn');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const uploadBtn = document.getElementById('uploadBtn');
    const uploadForm = document.getElementById('moduleUploadForm');
    const uploadProgress = document.getElementById('uploadProgress');
    const uploadProgressContainer = document.getElementById('uploadProgressContainer');
    const backToUploadBtn = document.getElementById('backToUploadBtn');
    const moduleDetails = document.getElementById('moduleDetails');
    
    // Toggle drag over class on dropzone
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    // Highlight dropzone when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        dropzone.classList.add('dragover');
    }
    
    function unhighlight() {
        dropzone.classList.remove('dragover');
    }
    
    // Handle dropped files
    dropzone.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }
    
    // Handle file selection via button
    browseBtn.addEventListener('click', () => {
        fileInput.click();
    });
    
    // Handle file input change
    fileInput.addEventListener('change', function() {
        if (this.files.length) {
            handleFiles(this.files);
        }
    });
    
    // Handle file removal
    removeFileBtn.addEventListener('click', resetFileInput);
    
    // Handle back to upload button
    backToUploadBtn.addEventListener('click', function() {
        moduleDetails.classList.add('d-none');
        backToUploadBtn.classList.add('d-none');
        filePreview.classList.remove('d-none');
    });
    
    // Process selected files
    function handleFiles(files) {
        const file = files[0];
        
        // Check if file is a zip
        if (!file.name.endsWith('.zip')) {
            showError('Invalid File', 'Please select a valid .zip file.');
            return;
        }
        
        // Check file size (50MB max)
        const maxSize = 50 * 1024 * 1024; // 50MB in bytes
        if (file.size > maxSize) {
            showError('File Too Large', 'The selected file exceeds the maximum allowed size of 50MB.');
            return;
        }
        
        // Update UI
        updateFileInfo(file);
        
        // In a real implementation, you would extract and read the module.json here
        // For now, we'll simulate it with a timeout
        simulateModuleInfoExtraction(file);
    }
    
    // Simulate extracting module info from the zip file
    function simulateModuleInfoExtraction(file) {
        // Show loading state
        uploadBtn.disabled = true;
        uploadBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Analyzing...';
        
        // Simulate API call to extract module info
        setTimeout(() => {
            // This would normally come from the server after extracting the zip
            const moduleInfo = {
                name: file.name.replace('.zip', '').replace(/[-_]/g, ' ').replace(/\b\w/g, l => l.toUpperCase()),
                version: '1.0.0',
                description: 'A custom module for the application.'
            };
            
            // Update module details
            document.getElementById('moduleName').value = moduleInfo.name;
            document.getElementById('moduleVersion').value = moduleInfo.version;
            document.getElementById('moduleDescription').value = moduleInfo.description;
            
            // Show module details and hide file preview
            filePreview.classList.add('d-none');
            moduleDetails.classList.remove('d-none');
            backToUploadBtn.classList.remove('d-none');
            
            // Update button
            uploadBtn.disabled = false;
            uploadBtn.innerHTML = '<i class="bx bx-upload me-2"></i>Install Module';
            
            // Scroll to module details
            moduleDetails.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            
        }, 1500);
    }
    
    // Update file info in the UI
    function updateFileInfo(file) {
        // Show file preview
        filePreview.classList.remove('d-none');
        
        // Update file info
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        
        // Enable upload button
        uploadBtn.disabled = false;
        uploadBtn.innerHTML = '<i class="bx bx-upload me-2"></i>Analyze Module';
        
        // Hide module details if shown
        moduleDetails.classList.add('d-none');
        backToUploadBtn.classList.add('d-none');
        
        // Scroll to preview
        filePreview.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    
    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Reset file input
    function resetFileInput() {
        fileInput.value = '';
        filePreview.classList.add('d-none');
        moduleDetails.classList.add('d-none');
        backToUploadBtn.classList.add('d-none');
        uploadBtn.disabled = true;
        uploadBtn.innerHTML = '<i class="bx bx-upload me-2"></i>Upload Module';
    }
    
    // Handle form submission
    uploadForm.addEventListener('submit', handleFormSubmit);
    
    async function handleFormSubmit(e) {
        e.preventDefault();
        
        if (!fileInput.files || fileInput.files.length === 0) {
            showError('Error', 'Please select a module file to upload.');
            return;
        }
        
        const formData = new FormData(uploadForm);
        
        try {
            // Show upload progress
            uploadBtn.disabled = true;
            uploadBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Installing...';
            uploadProgressContainer.classList.remove('d-none');
            uploadProgress.style.width = '0%';
            
            const xhr = new XMLHttpRequest();
            
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = (e.loaded / e.total) * 100;
                    uploadProgress.style.width = percentComplete + '%';
                }
            }, false);
            
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    uploadBtn.disabled = false;
                    uploadBtn.innerHTML = '<i class="bx bx-upload me-2"></i>Install Module';
                    
                    try {
                        const response = JSON.parse(xhr.responseText);
                        
                        if (xhr.status === 200) {
                            // Show success message
                            showSuccess('Success', 'Module installed successfully!');
                            
                            // Reset form
                            uploadForm.reset();
                            resetFileInput();
                            uploadProgressContainer.classList.add('d-none');
                            
                            // Redirect to modules list after a short delay
                            setTimeout(() => {
                                window.location.href = '<?= site_url('modules') ?>';
                            }, 1500);
                        } else {
                            showError('Installation Failed', response.message || 'An error occurred while installing the module.');
                            uploadProgressContainer.classList.add('d-none');
                        }
                    } catch (e) {
                        showError('Error', 'An unexpected error occurred. Please try again.');
                        console.error('Error parsing response:', e);
                        uploadProgressContainer.classList.add('d-none');
                    }
                }
            };
            
            xhr.open('POST', uploadForm.action, true);
            xhr.send(formData);
            
        } catch (error) {
            console.error('Upload error:', error);
            showError('Installation Failed', 'An error occurred while installing the module. Please try again.');
            uploadBtn.disabled = false;
            uploadBtn.innerHTML = '<i class="bx bx-upload me-2"></i>Install Module';
            uploadProgressContainer.classList.add('d-none');
        }
    }
    
    // Show error message
    function showError(title, message) {
        // Remove any existing alerts
        const existingAlerts = document.querySelectorAll('.alert-dismissible');
        existingAlerts.forEach(alert => alert.remove());
        
        // Create and show new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            <i class="bx bx-error-circle me-2"></i>
            <strong>${title}:</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Insert after the page header
        const header = document.querySelector('h1');
        if (header) {
            header.parentNode.insertBefore(alertDiv, header.nextSibling);
        } else {
            document.querySelector('.container').prepend(alertDiv);
        }
        
        // Scroll to the top to show the alert
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    // Show success message
    function showSuccess(title, message) {
        // Remove any existing alerts
        const existingAlerts = document.querySelectorAll('.alert-dismissible');
        existingAlerts.forEach(alert => alert.remove());
        
        // Create and show new alert
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-success alert-dismissible fade show';
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            <i class="bx bx-check-circle me-2"></i>
            <strong>${title}:</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Insert after the page header
        const header = document.querySelector('h1');
        if (header) {
            header.parentNode.insertBefore(alertDiv, header.nextSibling);
        } else {
            document.querySelector('.container').prepend(alertDiv);
        }
        
        // Scroll to the top to show the alert
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    // Add form validation
    (function () {
        'use strict'
        
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')
        
        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                
                form.classList.add('was-validated')
            }, false)
        })
    })()
});
</script>