<?php 
$validation = \Config\Services::validation();
$user = $user ?? session()->get('user');
// Ensure $user is an array for consistent access
if (is_object($user)) {
    $user = (array) $user;
}
?>

<?= $this->extend('App\Modules\Frontend\Views\Layouts\default') ?>

<?= $this->section('styles') ?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --primary: #4f46e5;
        --primary-light: #818cf8;
        --secondary: #f59e0b;
        --dark: #1e293b;
        --dark-2: #334155;
        --gray: #64748b;
        --light: #f8fafc;
        --light-gray: #e2e8f0;
        --success: #10b981;
        --danger: #ef4444;
        --border-radius: 0.75rem;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        background-color: #f1f5f9;
        color: #334155;
        line-height: 1.6;
    }

    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .card:hover {
        box-shadow: var(--shadow-lg);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border: none;
        padding: 1.5rem 2rem;
    }
    
    .profile-avatar-container {
        position: relative;
        width: 150px;
        height: 150px;
        margin: -75px auto 1.5rem;
        z-index: 2;
    }

    .profile-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 4px solid white;
        border-radius: 50%;
        box-shadow: var(--shadow-md);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .profile-avatar:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-lg);
    }

    .profile-upload-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .profile-upload-btn:hover {
        background: var(--primary-light);
        transform: scale(1.1);
    }

    .section-title {
        color: var(--dark);
        font-weight: 600;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #495057;
    }
    
    .form-control, .form-select {
        padding: 0.5rem 1rem;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(27, 18, 205, 0.25);
    }
    
    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
    }
    
    .btn-primary:hover {
        background-color: #160d9e;
        border-color: #150c90;
    }
    
    .card {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
    }
    
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 1.25rem 1.5rem;
    }
    }
    
    .form-section {
        margin-bottom: 2.5rem;
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e9ecef;
    }
    
    .required-field::after {
        content: ' *';
        color: var(--danger);
    }
    
    .invalid-feedback {
        font-size: 0.85rem;
        color: var(--danger);
        margin-top: 0.25rem;
    }
    
    .file-upload {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }
    
    .file-upload-input {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .file-upload-label {
        display: block;
        padding: 1.5rem;
        background-color: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 0.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .file-upload-label:hover {
        background-color: #e9ecef;
        border-color: #adb5bd;
    }
    
    .file-preview {
        margin-top: 1rem;
        text-align: center;
    }
    
    .file-preview img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 0.5rem;
        border: 1px solid #dee2e6;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .profile-avatar {
            width: 100px;
            height: 100px;
        }
        
        .form-actions {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .btn {
            width: 100%;
        }
    }

    .dashboard-menu a:hover, .dashboard-menu a.active {
      background: var(--light);
      color: var(--primary);
    }

    .dashboard-menu a i {
      width: 20px;
      text-align: center;
    }

    /* Dashboard Content */
    .dashboard-content {
      flex: 1;
      background: white;
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      padding: 30px;
    }

    .dashboard-header {
      margin-bottom: 30px;
    }

    .dashboard-header h2 {
      font-size: 1.8rem;
      margin-bottom: 10px;
    }

    /* Form Styles */
    .profile-form {
      margin-top: 20px;
    }

    .form-section {
      margin-bottom: 30px;
      padding-bottom: 20px;
      border-bottom: 1px solid #eee;
    }

    .form-section-title {
      font-size: 1.3rem;
      margin-bottom: 20px;
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .form-row {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }

    .form-group {
      flex: 1;
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
    }

    .form-group input, .form-group select, .form-group textarea {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-family: 'Poppins', sans-serif;
      font-size: 1rem;
    }

    .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .required::after {
      content: '*';
      color: var(--danger);
      margin-left: 4px;
    }

    .form-hint {
      font-size: 0.85rem;
      color: var(--gray);
      margin-top: 5px;
    }

    /* Buttons */
    .btn-dashboard {
      display: inline-block;
      background: var(--primary);
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 4px;
      font-weight: 600;
      transition: background 0.3s;
      border: none;
      cursor: pointer;
      font-size: 1rem;
    }

    .btn-dashboard:hover {
      background: #1d4ed8;
    }

    .btn-success {
      background: var(--success);
    }

    .btn-success:hover {
      background: #059669;
    }

    .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 15px;
      margin-top: 30px;
    }

    /* Footer */
    footer {
      background: var(--dark);
      color: white;
      text-align: center;
      padding: 30px 0;
      margin-top: 60px;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
      .dashboard-container {
        flex-direction: column;
      }
      
      .dashboard-sidebar {
        width: 100%;
      }
      
      .form-row {
        flex-direction: column;
        gap: 0;
      }
    }

    @media (max-width: 768px) {
      .header-container {
        flex-direction: column;
        gap: 15px;
      }
      
      nav {
        flex-wrap: wrap;
        justify-content: center;
      .form-actions {
        flex-direction: column;
      }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="h5 mb-0 text-white fw-semibold">
                                <i class="fas fa-user-edit me-2"></i>
                                My Profile
                            </h2>
                            <p class="mb-0 text-white-50 small">Manage your personal information and preferences</p>
                        </div>
                        <a href="<?= site_url(route_to('dashboard')) ?>" class="btn btn-light btn-sm rounded-pill px-3">
                            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
                
                <div class="card-body position-relative">
                    <!-- Profile Picture Upload -->
                    <div class="profile-avatar-container">
                        <img src="<?= $user['profile_photo'] ?? 'https://ui-avatars.com/api/?name=' . urlencode(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) . '&background=4f46e5&color=fff&size=150' ?>" 
                             alt="Profile Photo" 
                             class="profile-avatar"
                             id="profilePreview">
                        <label for="profile_photo" class="profile-upload-btn" data-bs-toggle="tooltip" title="Update photo">
                            <i class="fas fa-camera"></i>
                            <input type="file" id="profile_photo" name="profile_photo" class="d-none" accept="image/*">
                        </label>
                    </div>

                    <!-- Profile Form -->
                  <!-- Form Actions -->
         <form class="profile-form" id="profileForm"
      action="<?= site_url('frontend/profile') ?>"
      method="post"
      enctype="multipart/form-data">
    <?= csrf_field() ?>

                        <!-- Personal Information Section -->
                        <div class="mb-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                    <i class="fas fa-user-circle text-primary"></i>
                                </div>
                                <h5 class="mb-0 fw-semibold">Personal Information</h5>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="first_name" name="first_name" 
                                               placeholder="First Name"
                                               value="<?= old('first_name', $user['first_name'] ?? '') ?>" 
                                               required>
                                        <label for="first_name">First Name <span class="text-danger">*</span></label>
                                        <?php if ($validation->hasError('first_name')) : ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $validation->getError('first_name') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="last_name" name="last_name" 
                                               placeholder="Last Name"
                                               value="<?= old('last_name', $user['last_name'] ?? '') ?>" 
                                               required>
                                        <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                        <?php if ($validation->hasError('last_name')) : ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $validation->getError('last_name') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-envelope text-muted"></i>
                                            </span>
                                            <div class="form-floating flex-grow-1">
                                                <input type="email" class="form-control border-start-0 ps-2" id="email" name="email" 
                                                       placeholder="Email Address"
                                                       value="<?= old('email', $user['email'] ?? '') ?>" 
                                                       required>
                                                <label for="email" class="ps-4">Email Address <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <?php if ($validation->hasError('email')) : ?>
                                            <div class="invalid-feedback d-block mt-1">
                                                <?= $validation->getError('email') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-phone text-muted"></i>
                                            </span>
                                            <div class="form-floating flex-grow-1">
                                                <input type="tel" class="form-control border-start-0 ps-2" id="phone_number" name="phone_number" 
                                                       placeholder="Phone Number"
                                                       value="<?= old('phone_number', $user['phone_number'] ?? '') ?>" 
                                                       required>
                                                <label for="phone_number" class="ps-4">Phone Number <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <?php if ($validation->hasError('phone_number')) : ?>
                                            <div class="invalid-feedback d-block mt-1">
                                                <?= $validation->getError('phone_number') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="national_id" name="national_id" 
                                               placeholder="National ID Number"
                                               value="<?= old('national_id', $user['national_id'] ?? '') ?>" 
                                               required>
                                        <label for="national_id">National ID Number <span class="text-danger">*</span></label>
                                        <?php if ($validation->hasError('national_id')) : ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $validation->getError('national_id') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" 
                                               placeholder="Date of Birth"
                                               value="<?= old('date_of_birth', $user['date_of_birth'] ?? '') ?>" 
                                               required>
                                        <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                                        <?php if ($validation->hasError('date_of_birth')) : ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $validation->getError('date_of_birth') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="gender" name="gender" required>
                                            <option value="">Select Gender</option>
                                            <option value="male" <?= (old('gender', $user['gender'] ?? '') == 'male') ? 'selected' : '' ?>>Male</option>
                                            <option value="female" <?= (old('gender', $user['gender'] ?? '') == 'female') ? 'selected' : '' ?>>Female</option>
                                            <option value="other" <?= (old('gender', $user['gender'] ?? '') == 'other') ? 'selected' : '' ?>>Other</option>
                                        </select>
                                        <label for="gender">Gender <span class="text-danger">*</span></label>
                                        <?php if ($validation->hasError('gender')) : ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $validation->getError('gender') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="marital_status" name="marital_status" required>
                                            <option value="">Select Marital Status</option>
                                            <option value="single" <?= (old('marital_status', $user['marital_status'] ?? '') == 'single') ? 'selected' : '' ?>>Single</option>
                                            <option value="married" <?= (old('marital_status', $user['marital_status'] ?? '') == 'married') ? 'selected' : '' ?>>Married</option>
                                            <option value="divorced" <?= (old('marital_status', $user['marital_status'] ?? '') == 'divorced') ? 'selected' : '' ?>>Divorced</option>
                                            <option value="widowed" <?= (old('marital_status', $user['marital_status'] ?? '') == 'widowed') ? 'selected' : '' ?>>Widowed</option>
                                        </select>
                                        <label for="marital_status">Marital Status <span class="text-danger">*</span></label>
                                        <?php if ($validation->hasError('marital_status')) : ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $validation->getError('marital_status') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Address Information Section -->
                        <div class="mb-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary bg-opacity-10 p-2 rounded me-3">
                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                </div>
                                <h5 class="mb-0 fw-semibold">Address Information</h5>
                            </div>
                            
                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="physical_address" name="physical_address" 
                                               placeholder="Physical Address"
                                               value="<?= old('physical_address', $user['physical_address'] ?? '') ?>" 
                                               required>
                                        <label for="physical_address">Street Address <span class="text-danger">*</span></label>
                                        <?php if ($validation->hasError('physical_address"')) : ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $validation->getError('physical_address"') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="city" name="city" 
                                               placeholder="City"
                                               value="<?= old('city', $user['city'] ?? '') ?>" 
                                               required>
                                        <label for="city">City <span class="text-danger">*</span></label>
                                        <?php if ($validation->hasError('city')) : ?>
                                            <div class="invalid-feedback d-block">
                                                <?= $validation->getError('city') ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
          
              
                <!-- Terms and Conditions -->
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            I certify that the information provided is true and accurate to the best of my knowledge. 
                            I understand that providing false information may result in rejection of my application.
                            <span class="text-danger">*</span>
                        </label>
                        <div class="invalid-feedback">
                            You must agree to the terms before submitting.
                        </div>
                    </div>
                </div>
                
                       

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-3 pt-4 mt-4 border-top">
                            <a href="<?= site_url('frontend/dashboard') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Save Changes
                            </button>
                        </div>
                
                        <!-- Profile Preview Script -->
                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Profile picture preview
                            const profilePhoto = document.getElementById('profile_photo');
                            const profilePreview = document.getElementById('profilePreview');
                            
                            if (profilePhoto && profilePreview) {
                                profilePhoto.addEventListener('change', function(e) {
                                    const file = e.target.files[0];
                                    if (file) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            profilePreview.src = e.target.result;
                                        }
                                        reader.readAsDataURL(file);
                                    }
                                });
                            }
                            
                            // Form validation
                            const form = document.getElementById('profileForm');
                            if (form) {
                                form.addEventListener('submit', function(e) {
                                    if (!form.checkValidity()) {
                                        e.preventDefault();
                                        e.stopPropagation();
                                    }
                                    form.classList.add('was-validated');
                                }, false);
                            }
                            
                            // Initialize Bootstrap tooltips
                            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                                return new bootstrap.Tooltip(tooltipTriggerEl);
                            });
                        });
                        </script>
                
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom Scripts -->
<script>
    // Enable tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Initialize form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Profile photo preview
    document.addEventListener('DOMContentLoaded', function() {
        const profilePhoto = document.getElementById('profile_photo');
        const profilePreview = document.getElementById('profilePreview');
        
        if (profilePhoto && profilePreview) {
            profilePhoto.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profilePreview.src = e.target.result;
                        // You can add a success message here if needed
                        const toast = new bootstrap.Toast(document.getElementById('photoUploadToast'));
                        toast.show();
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
<script>
    // Enable Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Form validation
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();

    // Profile picture preview
    document.addEventListener('DOMContentLoaded', function() {
        const profilePhoto = document.getElementById('profile_photo');
        const profilePreview = document.getElementById('profilePreview');
        
        if (profilePhoto && profilePreview) {
            profilePhoto.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profilePreview.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>