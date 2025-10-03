<?= $this->extend('App\Modules\Frontend\Views\Layouts\default') ?>

<?= $this->section('title') ?>Directors & Shareholders (Step 3 of 4) | Alpha Empire<?= $this->endSection() ?>

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
        
        .shareholder-card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            padding: 1.75rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--gray-200);
            position: relative;
            transition: all 0.3s ease;
        }
        
        .shareholder-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .shareholder-number {
            position: absolute;
            top: -12px;
            left: 20px;
            background: var(--primary);
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 6px -1px rgba(106, 17, 203, 0.3);
        }
        
        .remove-shareholder {
            position: absolute;
            top: 16px;
            right: 20px;
            color: var(--danger);
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .remove-shareholder:hover {
            opacity: 1;
            background-color: rgba(239, 68, 68, 0.1);
        }
        
        .add-shareholder-btn {
            background: var(--gray-50);
            border: 2px dashed var(--gray-300);
            color: var(--gray-500);
            padding: 2rem 1.5rem;
            text-align: center;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 1.5rem;
        }
        
        .add-shareholder-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: rgba(106, 17, 203, 0.05);
            transform: translateY(-2px);
        }
        
        .total-shares {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 2rem 0;
            padding: 1.25rem;
            background: var(--gray-100);
            border-radius: 12px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .total-valid {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }
        
        .total-invalid {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
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
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(106, 17, 203, 0.25);
        }
        
        .form-switch .form-check-input {
            width: 2.5em;
            height: 1.25em;
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--gray-700);
        }
        
        .progress {
            height: 8px;
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
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--gray-500);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--gray-200);
        }
        
        .file-upload-hint {
            font-size: 0.8rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
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
        }
        
        .floating-label .form-control:focus + label,
        .floating-label .form-control:not(:placeholder-shown) + label {
            top: 0.25rem;
            font-size: 0.7rem;
            color: var(--primary);
        }
        
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
            
            .shareholder-card {
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
                                    <i class="fas fa-users fa-lg text-white"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h4 class="mb-1">Directors & Shareholders</h4>
                                <p class="mb-0 opacity-90">Step 3 of 4 - Add company directors and shareholders</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="badge bg-white bg-opacity-20 text-white fs-6">3/4</span>
                            </div>
                        </div>
                    </div>

                    <?php if(session()->has('error')): ?>
                        <div class="alert alert-danger mx-3 mt-3 mb-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <div><?= session('error') ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(session()->has('message')): ?>
                        <div class="alert alert-success mx-3 mt-3 mb-0">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                <div><?= session('message') ?></div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <form id="shareholdersForm" class="needs-validation" 
                              action="<?= site_url('frontend/plc/process-shareholders') ?>" 
                              method="post" 
                              enctype="multipart/form-data" 
                              novalidate>
                            <?= csrf_field() ?>

                            <div id="shareholdersContainer">
                                <!-- Shareholder cards will be added here dynamically -->
                            </div>

                            <div class="add-shareholder-btn" id="addShareholderBtn">
                                <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                <p class="mb-0 fw-medium">Add Shareholder/Director</p>
                                <small class="text-muted">Click to add another person</small>
                            </div>

                            <div class="total-shares" id="totalShares">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="fas fa-chart-pie me-2"></i>
                                    <span>Total Shareholding: <span id="sharesSum" class="fs-5">0</span>%</span>
                                </div>
                                <div id="totalHint" class="mt-1 small">Total must equal 100% to proceed.</div>
                            </div>

                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <a href="<?= site_url('frontend/plc/business-details') ?>" 
                                   class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </a>
                                <button type="submit" class="btn btn-primary px-4" id="nextBtn">
                                    Continue <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <div class="progress mt-4" style="height: 10px;">
                        <div class="progress-bar" role="progressbar" style="width: 75%;" 
                             aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted mt-2 d-block">Step 3 of 4 - Directors & Shareholders</small>
                </div>
            </div>
        </div>
    </div>
</div>

<template id="shareholderTemplate">
    <div class="shareholder-card" data-shareholder-index="0">
        <div class="shareholder-number">1</div>
        <button type="button" class="remove-shareholder" title="Remove shareholder">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="section-title">Personal Information</div>
        <div class="row g-3 mb-4">

            <!-- Full Name -->
            <div class="col-md-6">
                <div class="floating-label">
                    <input type="text" class="form-control shareholder-name"
                           name="shareholders[0][full_name]" required 
                           placeholder=" ">
                    <label>Full Name <span class="text-danger">*</span></label>
                    <div class="invalid-feedback">Full name is required.</div>
                </div>
            </div>

            <!-- National ID -->
            <div class="col-md-6">
                <div class="floating-label">
                    <input type="text" class="form-control shareholder-id"
                           name="shareholders[0][national_id]" required 
                           placeholder=" ">
                    <label>National ID/Passport No <span class="text-danger">*</span></label>
                    <div class="invalid-feedback">National ID/Passport is required.</div>
                </div>
            </div>

            <!-- Nationality -->
            <div class="col-md-6">
                <div class="floating-label">
                    <input type="text" class="form-control shareholder-nationality"
                           name="shareholders[0][nationality]" required 
                           placeholder=" ">
                    <label>Nationality <span class="text-danger">*</span></label>
                    <div class="invalid-feedback">Nationality is required.</div>
                </div>
            </div>

            <!-- Shareholding -->
            <div class="col-md-6">
                <div class="floating-label">
                    <input type="number" class="form-control shareholder-percent"
                           name="shareholders[0][shareholding]" min="1" max="100" step="0.01" 
                           required placeholder=" ">
                    <label>Shareholding (%) <span class="text-danger">*</span></label>
                    <div class="invalid-feedback">Enter a valid percentage between 1 and 100.</div>
                </div>
            </div>

            <!-- Email -->
            <div class="col-md-6">
                <div class="floating-label">
                    <input type="email" class="form-control shareholder-email"
                           name="shareholders[0][email]" required 
                           placeholder=" ">
                    <label>Email Address <span class="text-danger">*</span></label>
                    <div class="invalid-feedback">A valid email is required.</div>
                </div>
            </div>

            <!-- Phone -->
            <div class="col-md-6">
                <div class="floating-label">
                    <input type="tel" class="form-control shareholder-phone"
                           name="shareholders[0][phone_number]" 
                           placeholder=" ">
                    <label>Phone Number</label>
                </div>
            </div>

            <!-- Gender -->
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                    <select class="form-select" name="shareholders[0][gender]" required>
                        <option value="">Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    <div class="invalid-feedback">Please select a gender.</div>
                </div>
            </div>

            <!-- Date of Birth -->
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="shareholders[0][date_of_birth]" required>
                    <div class="invalid-feedback">Date of birth is required.</div>
                </div>
            </div>

            <!-- Residential Address -->
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label">Residential Address <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="shareholders[0][residential_address]" required
                              placeholder="Enter residential address" rows="2"></textarea>
                    <div class="invalid-feedback">Residential address is required.</div>
                </div>
            </div>

            <!-- Marital Status -->
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Marital Status</label>
                    <select class="form-select" name="shareholders[0][marital_status]">
                        <option value="">Select status</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <!-- City -->
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">City</label>
                    <input type="text" class="form-control" name="shareholders[0][city]" placeholder="Enter city">
                </div>
            </div>
        </div>

        <div class="section-title">Roles & Documents</div>
        <div class="row g-3">
            <!-- Roles -->
            <div class="col-md-6">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="isBeneficialOwner0" name="shareholders[0][is_beneficial_owner]" value="1">
                    <label class="form-check-label fw-medium" for="isBeneficialOwner0">Is Beneficial Owner</label>
                </div>
                
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="isDirector0" 
                           name="shareholders[0][is_director]" value="1" checked>
                    <label class="form-check-label fw-medium" for="isDirector0">
                        This person is also a director
                    </label>
                </div>
            </div>

            <!-- Documents -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label class="form-label">ID Document</label>
                    <input type="file" class="form-control" name="shareholders[0][id_document]" accept=".pdf,.jpg,.jpeg,.png">
                    <div class="file-upload-hint">Accepted: PDF, JPG, PNG</div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Proof of Residence</label>
                    <input type="file" class="form-control" name="shareholders[0][proof_of_residence]" accept=".pdf,.jpg,.jpeg,.png">
                    <div class="file-upload-hint">Recent utility bill or bank statement</div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label">Passport Photo</label>
                    <input type="file" class="form-control" name="shareholders[0][passport_photo]" accept=".jpg,.jpeg,.png">
                    <div class="file-upload-hint">Clear headshot on plain background</div>
                </div>
            </div>
        </div>
    </div>
</template>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('shareholdersContainer');
    const addBtn = document.getElementById('addShareholderBtn');
    const sharesSumSpan = document.getElementById('sharesSum');
    const template = document.getElementById('shareholderTemplate');
    const totalBox = document.getElementById('totalShares');
    const totalHint = document.getElementById('totalHint');
    const nextBtn = document.getElementById('nextBtn');

    let shareholderCount = 0;

    // Add first shareholder by default
    addShareholder();

    function addShareholder() {
        const newShareholder = template.content.cloneNode(true);
        const newIndex = shareholderCount;

        const card = newShareholder.querySelector('.shareholder-card');
        card.dataset.shareholderIndex = newIndex;
        card.querySelector('.shareholder-number').textContent = newIndex + 1;

        const inputs = newShareholder.querySelectorAll('input, select, label[for]');
        inputs.forEach(input => {
            if (input.id) input.id = input.id.replace('0', newIndex);
            if (input.name) input.name = input.name.replace('[0]', `[${newIndex}]`);
            if (input.htmlFor) input.htmlFor = input.htmlFor.replace('0', newIndex);
        });

        // Recalculate when percentage changes
        const percentInput = newShareholder.querySelector('.shareholder-percent');
        if (percentInput) {
            percentInput.addEventListener('input', updateTotalShares);
        }

        // Remove shareholder button
        card.querySelector('.remove-shareholder').addEventListener('click', function() {
            if (shareholderCount > 1) {
                card.remove();
                shareholderCount--;
                updateShareholderNumbers();
                updateTotalShares();
            } else {
                showToast('At least one shareholder is required', 'warning');
            }
        });

        container.appendChild(card);
        shareholderCount++;
        updateShareholderNumbers();
        updateTotalShares();
        
        // Animate the new card
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.3s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 10);
    }

    function updateShareholderNumbers() {
        container.querySelectorAll('.shareholder-card').forEach((card, index) => {
            card.querySelector('.shareholder-number').textContent = index + 1;
        });
    }

    function updateTotalShares() {
        let total = 0;
        let validPercents = true;
        container.querySelectorAll('.shareholder-percent').forEach(input => {
            const val = parseFloat(input.value);
            if (!isNaN(val)) {
                if (val < 0 || val > 100) validPercents = false;
                total += val;
            }
        });

        // Normalize floating error to 2 decimals
        const totalRounded = Math.round(total * 100) / 100;
        sharesSumSpan.textContent = totalRounded.toFixed(2);

        const equals100 = Math.abs(totalRounded - 100) < 0.01;
        if (equals100 && validPercents && shareholderCount > 0) {
            totalBox.classList.remove('total-invalid');
            totalBox.classList.add('total-valid');
            totalHint.innerHTML = '<i class="fas fa-check-circle me-1"></i> Looks good. Total equals 100%.';
            nextBtn.removeAttribute('disabled');
        } else {
            totalBox.classList.remove('total-valid');
            totalBox.classList.add('total-invalid');
            totalHint.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i> Total must equal 100% to proceed.';
            nextBtn.setAttribute('disabled', 'disabled');
        }
    }

    // Delegate input handling for dynamically added cards
    container.addEventListener('input', function(e) {
        if (e.target && e.target.classList.contains('shareholder-percent')) {
            updateTotalShares();
        }
    });

    // Bootstrap validation + prevent submit if invalid
    const form = document.getElementById('shareholdersForm');
    form.addEventListener('submit', function(e) {
        const total = parseFloat(sharesSumSpan.textContent) || 0;
        if (!form.checkValidity() || Math.abs(total - 100) >= 0.01) {
            e.preventDefault();
            e.stopPropagation();
            updateTotalShares();
            
            // Scroll to the first invalid field
            const firstInvalid = form.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else if (Math.abs(total - 100) >= 0.01) {
                totalBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            
            showToast('Please fix the errors before submitting', 'error');
        }
        form.classList.add('was-validated');
    });

    addBtn.addEventListener('click', addShareholder);
    
    // Toast notification function
    function showToast(message, type = 'info') {
        // Create toast element if it doesn't exist
        let toastContainer = document.getElementById('toastContainer');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toastContainer';
            toastContainer.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 1055;';
            document.body.appendChild(toastContainer);
        }
        
        const toast = document.createElement('div');
        const bgColor = type === 'error' ? 'var(--danger)' : 
                       type === 'success' ? 'var(--success)' : 
                       type === 'warning' ? 'var(--warning)' : 'var(--primary)';
        
        toast.innerHTML = `
            <div class="toast show" role="alert" style="background: white; border-left: 4px solid ${bgColor}; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                <div class="toast-body d-flex align-items-center">
                    <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 
                                     type === 'success' ? 'check-circle' : 
                                     type === 'warning' ? 'exclamation-circle' : 'info-circle'} me-2" 
                       style="color: ${bgColor};"></i>
                    <div>${message}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        toastContainer.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.remove();
        }, 5000);
        
        // Add close button functionality
        toast.querySelector('.btn-close').addEventListener('click', () => {
            toast.remove();
        });
    }
});
</script>
<?= $this->endSection() ?>