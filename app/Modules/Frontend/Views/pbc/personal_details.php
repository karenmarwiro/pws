<?= $this->extend('App\Modules\Frontend\Views\Layouts\default') ?>

<?= $this->section('title') ?>Personal Details (Step 1 of 4) | Alpha Empire<?= $this->endSection() ?>

<?= $this->section('styles') ?>
    <style>
        :root {
            --primary: #6a11cb;
            --primary-light: #8b46e5;
            --primary-gradient: linear-gradient(135deg, #6a11cb 0%, #4f46e5 100%);
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gray-500);
            color: var(--gray-800);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }
        
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .card-header {
            background: var(--primary-gradient);
            color: white;
            padding: 2rem;
            border-bottom: none;
            position: relative;
            overflow: hidden;
        }
        
        .card-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23ffffff" opacity="0.1"><polygon points="1000,100 1000,0 0,100"/></svg>');
            background-size: cover;
        }
        
        .card-body {
            padding: 2.5rem;
        }
        
        .form-control, .form-select {
            border-radius: 12px;
            padding: 0.875rem 1rem;
            border: 2px solid var(--gray-200);
            transition: all 0.3s ease;
            font-size: 0.95rem;
            background: var(--gray-50);
        }
        
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 4px rgba(106, 17, 203, 0.1);
            border-color: var(--primary);
            background: white;
            transform: translateY(-2px);
        }
        
        .form-control.is-valid {
            border-color: var(--success);
        }
        
        .form-control.is-invalid {
            border-color: var(--danger);
        }
        
        .btn {
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(106, 17, 203, 0.3);
        }
        
        .btn-outline-secondary {
            border: 2px solid var(--gray-300);
            color: var(--gray-600);
            background: white;
        }
        
        .btn-outline-secondary:hover {
            background: var(--gray-100);
            border-color: var(--gray-400);
            transform: translateY(-2px);
        }
        
        .progress {
            height: 8px;
            border-radius: 10px;
            background-color: var(--gray-200);
            margin: 2rem 0 1rem;
        }
        
        .progress-bar {
            background: var(--primary-gradient);
            border-radius: 10px;
            transition: width 0.6s ease;
        }
        
        .step-indicator {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            position: relative;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            position: relative;
            z-index: 2;
        }
        
        .step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 20px;
            left: 60%;
            width: 80%;
            height: 3px;
            background: var(--gray-300);
            z-index: 1;
        }
        
        .step.active:not(:last-child)::after {
            background: var(--primary);
        }
        
        .step.completed:not(:last-child)::after {
            background: var(--primary);
        }
        
        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gray-300);
            color: var(--gray-600);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-bottom: 0.75rem;
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
            border: 3px solid white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .step.active .step-circle {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }
        
        .step.completed .step-circle {
            background: var(--success);
            color: white;
        }
        
        .step.completed .step-circle::after {
            content: '✓';
            font-weight: bold;
        }
        
        .step-label {
            font-size: 0.8rem;
            color: var(--gray-500);
            text-align: center;
            font-weight: 500;
        }
        
        .step.active .step-label {
            color: var(--primary);
            font-weight: 600;
        }
        
        .floating-label {
            position: relative;
            margin-bottom: 1.75rem;
        }
        
        .floating-label .form-control {
            padding-top: 1.5rem;
            padding-bottom: 0.75rem;
        }
        
        .floating-label label {
            position: absolute;
            top: 0.875rem;
            left: 1rem;
            font-size: 0.9rem;
            color: var(--gray-500);
            transition: all 0.3s ease;
            pointer-events: none;
            background: linear-gradient(to bottom, transparent 0%, var(--gray-50) 50%);
            padding: 0 0.5rem;
            margin-left: -0.5rem;
            border-radius: 4px;
        }
        
        .floating-label .form-control:focus + label,
        .floating-label .form-control:not(:placeholder-shown) + label {
            top: -0.5rem;
            font-size: 0.75rem;
            color: var(--primary);
            font-weight: 600;
            background: white;
        }
        
        .form-section {
            margin-bottom: 2.5rem;
        }
        
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--gray-100);
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 0.75rem;
            color: var(--primary);
            background: rgba(106, 17, 203, 0.1);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .error-message {
            font-size: 0.8rem;
            color: var(--danger);
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .error-message i {
            font-size: 0.7rem;
        }
        
        .input-hint {
            font-size: 0.8rem;
            color: var(--gray-500);
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 1rem;
                background: var(--gray-100);
            }
            
            .card-body {
                padding: 2rem 1.5rem;
            }
            
            .card-header {
                padding: 1.5rem;
            }
            
            .step:not(:last-child)::after {
                left: 55%;
                width: 70%;
            }
            
            .step-label {
                font-size: 0.7rem;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 1rem;
            }
            
            .d-flex.justify-content-between {
                flex-direction: column;
            }
        }
        
        .welcome-text {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--gray-600);
            font-size: 1.1rem;
        }
        
        .form-note {
            background: rgba(106, 17, 203, 0.05);
            border-left: 4px solid var(--primary);
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }
        
        .form-note p {
            margin: 0;
            color: var(--gray-700);
            font-size: 0.9rem;
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="personal-details-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="card">
                    <div class="card-header position-relative">
                        <div class="text-center text-white position-relative">
                            <div class="bg-white bg-opacity-20 rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3">
                                <img src="<?= base_url('Assets/img/Picture1.jpg') ?>" alt="Alpha Empire Logo" class="img-fluid rounded-circle" style="width:64px;height:64px;object-fit:cover;" />
                            </div>
                            <h3 class="mb-2">Applicant Details</h3>
                            <p class="mb-0 opacity-90">Step 1 of 4 - Let's get to know you</p>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Step Indicator -->
                        <div class="step-indicator">
                            <div class="step active">
                                <div class="step-circle">1</div>
                                <div class="step-label">Personal Details</div>
                            </div>
                            <div class="step">
                                <div class="step-circle">2</div>
                                <div class="step-label">Company Details</div>
                            </div>
                            <div class="step">
                                <div class="step-circle">3</div>
                                <div class="step-label">Directors & Shareholders</div>
                            </div>
                            <div class="step">
                                <div class="step-circle">4</div>
                                <div class="step-label">Review & Submit</div>
                            </div>
                        </div>

                        <div class="welcome-text">
                            Welcome to Alpha Empire! Let's start with your basic information.
                        </div>

                        <div class="form-note">
                            <p><i class="fas fa-info-circle me-2 text-primary"></i>All fields marked with <span class="text-danger">*</span> are required.</p>
                        </div>

                        <form action="<?= site_url('frontend/pbc/process-personal-details') ?>" method="post" class="needs-validation" novalidate>
                            <?= csrf_field() ?>

                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-user"></i>
                                    Personal Information
                                </div>

                                <div class="row g-3">
                                    <!-- First Name -->
                                    <div class="col-md-6">
                                        <div class="floating-label">
                                            <input type="text" class="form-control <?= (session()->getFlashdata('errors')['first_name'] ?? false) ? 'is-invalid' : '' ?>" 
                                                   id="first_name" name="first_name"
                                                   value="<?= old('first_name') ?>" 
                                                   placeholder=" "
                                                   required>
                                            <label for="first_name">First Name <span class="text-danger">*</span></label>
                                            <?php if (session()->getFlashdata('errors')['first_name'] ?? false): ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    <?= session()->getFlashdata('errors')['first_name'] ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Surname -->
                                    <div class="col-md-6">
                                        <div class="floating-label">
                                            <input type="text" class="form-control <?= (session()->getFlashdata('errors')['surname'] ?? false) ? 'is-invalid' : '' ?>" 
                                                   id="surname" name="surname"
                                                   value="<?= old('surname') ?>" 
                                                   placeholder=" "
                                                   required>
                                            <label for="surname">Surname <span class="text-danger">*</span></label>
                                            <?php if (session()->getFlashdata('errors')['surname'] ?? false): ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    <?= session()->getFlashdata('errors')['surname'] ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- National ID -->
                                    <div class="col-md-6">
                                        <div class="floating-label">
                                            <input type="text" class="form-control <?= (session()->getFlashdata('errors')['national_id'] ?? false) ? 'is-invalid' : '' ?>" 
                                                   id="national_id" name="national_id"
                                                   value="<?= old('national_id') ?>" 
                                                   placeholder=" "
                                                   required>
                                            <label for="national_id">National ID <span class="text-danger">*</span></label>
                                            <div class="input-hint">
                                                <i class="fas fa-info-circle"></i>
                                                Your government-issued identification number
                                            </div>
                                            <?php if (session()->getFlashdata('errors')['national_id'] ?? false): ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    <?= session()->getFlashdata('errors')['national_id'] ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-md-6">
                                        <div class="floating-label">
                                            <input type="tel" class="form-control <?= (session()->getFlashdata('errors')['phone'] ?? false) ? 'is-invalid' : '' ?>" 
                                                   id="phone" name="phone"
                                                   value="<?= old('phone') ?>" 
                                                   placeholder=" "
                                                   required>
                                            <label for="phone">Phone Number <span class="text-danger">*</span></label>
                                            <?php if (session()->getFlashdata('errors')['phone'] ?? false): ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    <?= session()->getFlashdata('errors')['phone'] ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- WhatsApp (optional) -->
                                    <div class="col-md-6">
                                        <div class="floating-label">
                                            <input type="tel" class="form-control" 
                                                   id="whatsapp" name="whatsapp"
                                                   value="<?= old('whatsapp') ?>" 
                                                   placeholder=" ">
                                            <label for="whatsapp">WhatsApp Number</label>
                                            <div class="input-hint">
                                                <i class="fas fa-info-circle"></i>
                                                Optional - for faster communication
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-12">
                                        <div class="floating-label">
                                            <input type="email" class="form-control <?= (session()->getFlashdata('errors')['email'] ?? false) ? 'is-invalid' : '' ?>" 
                                                   id="email" name="email"
                                                   value="<?= old('email') ?>" 
                                                   placeholder=" "
                                                   required>
                                            <label for="email">Email Address <span class="text-danger">*</span></label>
                                            <div class="input-hint">
                                                <i class="fas fa-info-circle"></i>
                                                We'll send important updates to this email
                                            </div>
                                            <?php if (session()->getFlashdata('errors')['email'] ?? false): ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    <?= session()->getFlashdata('errors')['email'] ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Referral -->
                                    <div class="col-12">
                                        <div class="floating-label">
                                            <input type="text" class="form-control" 
                                                   id="referral" name="referral"
                                                   value="<?= old('referral') ?>" 
                                                   placeholder=" ">
                                            <label for="referral">How did you hear about us?</label>
                                            <div class="input-hint">
                                                <i class="fas fa-info-circle"></i>
                                                Friend, social media, search engine, etc.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                                <button type="reset" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-eraser me-2"></i>Clear Form
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    Continue to Company Details <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </form>

                        <!-- Progress Bar -->
                        <div class="text-center mt-4">
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 25%;" 
                                     aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted mt-2 d-block">Step 1 of 4 - Personal Details</small>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <p class="text-muted">Already have an account? <a href="#" class="text-primary text-decoration-none fw-medium">Sign in</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('form.needs-validation');
    
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            
            // Scroll to first invalid field
            const firstInvalid = form.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
        
        form.classList.add('was-validated');
    });

    // Real-time validation
    const inputs = form.querySelectorAll('input[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            this.classList.add('validated');
            if (this.value.trim() === '') {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
        
        // Validate on input for better UX
        input.addEventListener('input', function() {
            if (this.classList.contains('validated')) {
                if (this.value.trim() === '') {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            }
        });
    });

    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    const whatsappInput = document.getElementById('whatsapp');
    
    function formatPhoneNumber(input) {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.length <= 3) {
                    value = value;
                } else if (value.length <= 6) {
                    value = value.slice(0, 3) + ' ' + value.slice(3);
                } else if (value.length <= 10) {
                    value = value.slice(0, 3) + ' ' + value.slice(3, 6) + ' ' + value.slice(6);
                } else {
                    value = value.slice(0, 3) + ' ' + value.slice(3, 6) + ' ' + value.slice(6, 10);
                }
            }
            e.target.value = value;
        });
    }
    
    if (phoneInput) formatPhoneNumber(phoneInput);
    if (whatsappInput) formatPhoneNumber(whatsappInput);

    // Enhanced clear form functionality
    const clearBtn = document.querySelector('button[type="reset"]');
    clearBtn.addEventListener('click', function() {
        // Remove validation states
        form.classList.remove('was-validated');
        inputs.forEach(input => {
            input.classList.remove('is-valid', 'is-invalid', 'validated');
        });
        
        // Show confirmation
        if (confirm('Are you sure you want to clear all fields?')) {
            form.reset();
        }
    });
});
</script>
