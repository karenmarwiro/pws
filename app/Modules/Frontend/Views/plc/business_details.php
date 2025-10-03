<?= $this->extend('App\Modules\Frontend\Views\Layouts\default') ?>

<?= $this->section('title') ?>Company Details (Step 2 of 4) | Alpha Empire<?= $this->endSection() ?>

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
            background-color: var(--gray-50);
            color: var(--gray-800);
            line-height: 1.6;
        }
        
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }
        
        .card-header {
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: none;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-300);
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }
        
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(106, 17, 203, 0.1);
            border-color: var(--primary);
        }
        
        .input-group-text {
            background-color: var(--gray-100);
            border: 1px solid var(--gray-300);
            color: var(--gray-600);
        }
        
        .btn {
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background: var(--primary-gradient);
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(106, 17, 203, 0.3);
        }
        
        .btn-outline-secondary {
            border: 1px solid var(--gray-300);
            color: var(--gray-700);
        }
        
        .btn-outline-secondary:hover {
            background: var(--gray-100);
            border-color: var(--gray-400);
        }
        
        .progress {
            height: 10px;
            border-radius: 10px;
            background-color: var(--gray-200);
        }
        
        .progress-bar {
            background: var(--primary-gradient);
            border-radius: 10px;
        }
        
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
        }
        
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }
        
        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border-left: 4px solid var(--success);
        }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 0.75rem;
            color: var(--primary);
        }
        
        .form-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid var(--gray-200);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
        
        .company-name-input {
            position: relative;
        }
        
        .company-name-input .input-group-text {
            min-width: 45px;
            justify-content: center;
            font-weight: 600;
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .floating-label {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .floating-label .form-control {
            padding-top: 1.5rem;
            padding-bottom: 0.75rem;
        }
        
        .floating-label label {
            position: absolute;
            top: 0.75rem;
            left: 1rem;
            font-size: 0.8rem;
            color: var(--gray-500);
            transition: all 0.2s ease;
            pointer-events: none;
            background: white;
            padding: 0 0.25rem;
            margin-left: -0.25rem;
        }
        
        .floating-label .form-control:focus + label,
        .floating-label .form-control:not(:placeholder-shown) + label {
            top: -0.5rem;
            font-size: 0.7rem;
            color: var(--primary);
            font-weight: 500;
        }
        
        .form-hint {
            font-size: 0.8rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
        }
        
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
            
            .form-section {
                padding: 1.25rem;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 0.75rem;
            }
            
            .d-flex.justify-content-between {
                flex-direction: column;
            }
            
        }
    </style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="personal-details-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-white bg-opacity-20 rounded-circle p-3 d-inline-flex align-items-center justify-content-center">
                                    <i class="fas fa-building fa-lg text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mb-1">Company Details</h4>
                                <p class="mb-0 opacity-90">Step 2 of 4 - Tell us about your company</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="badge bg-white bg-opacity-20 text-white fs-6">2/4</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php if(session()->has('error')): ?>
                            <div class="alert alert-danger mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <div><?= session('error') ?></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if(session()->has('message')): ?>
                            <div class="alert alert-success mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <div><?= session('message') ?></div>
                                </div>
                            </div>
                        <?php endif; ?>

                        

                        <form action="<?= site_url('frontend/plc/process-company-details') ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                            <?= csrf_field() ?>
                            
                            <!-- Company Names Section -->
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-file-signature"></i>
                                    Proposed Company Names
                                </div>
                                <p class="text-muted mb-4">Please provide 4 proposed names in order of preference. We'll check their availability.</p>

                                <div class="row g-3">
                                    <?php for ($i = 1; $i <= 4; $i++): ?>
                                    <div class="col-12">
                                        <div class="company-name-input">
                                            <div class="input-group">
                                                <span class="input-group-text"><?= $i ?></span>
                                                <div class="floating-label flex-grow-1">
                                                    <input type="text" class="form-control" id="name<?= $i ?>" 
                                                           name="name<?= $i ?>" required 
                                                           placeholder=" ">
                                                    <label for="name<?= $i ?>">Proposed Company Name <?= $i ?> <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">Company name <?= $i ?> is required.</div>
                                        </div>
                                    </div>
                                    <?php endfor; ?>
                                </div>
                            </div>

                            <!-- Company Details Section -->
                            <div class="form-section">
                                <div class="section-title">
                                    <i class="fas fa-info-circle"></i>
                                    Company Information
                                </div>

                                <div class="row g-3">
                                    <!-- Physical Address -->
                                    <div class="col-12">
                                        <div class="floating-label">
                                            <input type="text" class="form-control" id="physical_address" 
                                                   name="physical_address" required
                                                   placeholder=" ">
                                            <label for="physical_address">Physical Address <span class="text-danger">*</span></label>
                                            <div class="invalid-feedback">Physical address is required.</div>
                                        </div>
                                    </div>

                                    <!-- Suburb & City -->
                                    <div class="col-md-6">
                                        <div class="floating-label">
                                            <input type="text" class="form-control" id="suburb_city" 
                                                   name="suburb_city" required
                                                   placeholder=" ">
                                            <label for="suburb_city">Suburb & City <span class="text-danger">*</span></label>
                                            <div class="invalid-feedback">Suburb and city are required.</div>
                                        </div>
                                    </div>

                                    <!-- Postal Code -->
                                    <div class="col-md-6">
                                        <div class="floating-label">
                                            <input type="text" class="form-control" id="postal_code" 
                                                   name="postal_code" required
                                                   placeholder=" ">
                                            <label for="postal_code">Postal Code <span class="text-danger">*</span></label>
                                            <div class="invalid-feedback">Postal code is required.</div>
                                        </div>
                                    </div>

                                    <!-- Country -->
                                    <div class="col-md-6">
                                        <div class="floating-label">
                                            <input type="text" class="form-control" id="country" 
                                                   name="country" required
                                                   placeholder=" ">
                                            <label for="country">Country <span class="text-danger">*</span></label>
                                            <div class="invalid-feedback">Country is required.</div>
                                        </div>
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="col-md-6">
                                        <div class="floating-label">
                                            <input type="tel" class="form-control" id="phone_number" 
                                                   name="phone_number" required
                                                   placeholder=" ">
                                            <label for="phone_number">Phone Number <span class="text-danger">*</span></label>
                                            <div class="invalid-feedback">Phone number is required.</div>
                                        </div>
                                    </div>

                                    <!-- Email Address -->
                                    <div class="col-md-6">
                                        <div class="floating-label">
                                            <input type="email" class="form-control" id="email" 
                                                   name="email" required
                                                   placeholder=" ">
                                            <label for="email">Email Address <span class="text-danger">*</span></label>
                                            <div class="invalid-feedback">Valid email address is required.</div>
                                        </div>
                                    </div>

                                    <!-- Website -->
                                    <div class="col-md-6">
                                        <div class="floating-label">
                                            <input type="url" class="form-control" id="website" 
                                                   name="website"
                                                   placeholder=" ">
                                            <label for="website">Website (Optional)</label>
                                        </div>
                                    </div>

                                    <!-- Business Type -->
                                    <div class="col-md-8">
                                        <div class="floating-label">
                                            <input type="text" class="form-control" id="business_type" 
                                                   name="business_type" required
                                                   placeholder=" ">
                                            <label for="business_type">Main Type of Business <span class="text-danger">*</span></label>
                                            <div class="form-hint">e.g., IT Services, Retail, Consulting</div>
                                            <div class="invalid-feedback">Business type is required.</div>
                                        </div>
                                    </div>

                                    <!-- Financial Year End -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="year_end" class="form-label">Financial Year End <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="year_end" 
                                                   name="year_end" required>
                                            <div class="invalid-feedback">Financial year end is required.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <a href="<?= site_url('frontend/plc/personal-details') ?>" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    Save & Continue <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </form>

                        <!-- Progress Bar -->
                        <div class="text-center mt-4">
                            <div class="progress mt-4">
                                <div class="progress-bar" role="progressbar" style="width: 50%;" 
                                     aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted mt-2 d-block">Step 2 of 4 - Company Details</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
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

    // Add real-time validation
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
    });

    // Enhance date input
    const yearEndInput = document.getElementById('year_end');
    if (yearEndInput) {
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        yearEndInput.min = today;
    }

    // Add input formatting for phone number
    const phoneInput = document.getElementById('phone_number');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                value = '(' + value;
                if (value.length > 4) {
                    value = value.slice(0, 4) + ') ' + value.slice(4);
                }
                if (value.length > 9) {
                    value = value.slice(0, 9) + '-' + value.slice(9, 13);
                }
            }
            e.target.value = value;
        });
    }
});
</script>
<?= $this->endSection() ?>