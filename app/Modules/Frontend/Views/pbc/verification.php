<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification - PBC Registration</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        
        .verification-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .verification-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .verification-header i {
            font-size: 3rem;
            color: #28a745;
            margin-bottom: 1rem;
        }
        
        .terms-box {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            background: #f8f9fa;
        }
        
        .terms-box h4 {
            color: #2c3e50;
            margin-bottom: 1rem;
        }
        
        .terms-box p, .terms-box ul {
            margin-bottom: 1rem;
            line-height: 1.6;
        }
        
        .terms-box ul {
            padding-left: 1.5rem;
        }
        
        .form-check {
            margin: 1.5rem 0;
        }
        
        .btn-primary {
            padding: 0.75rem 2rem;
            font-weight: 500;
        }
        
        .progress {
            height: 8px;
            margin: 2rem 0 1rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="verification-container">
                    <!-- Progress Bar -->
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 90%;" 
                             aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p class="text-muted text-center mb-4">Step 4 of 4 - Verification</p>
                    
                    <div class="verification-header">
                        <i class="fas fa-file-signature"></i>
                        <h2>Terms & Conditions</h2>
                        <p class="text-muted">Please review and accept the terms and conditions to proceed</p>
                    </div>
                    
                    <div class="terms-box">
                        <h4>Company Registration Terms and Conditions</h4>
                        
                        <p>By proceeding with your company registration, you agree to the following terms and conditions:</p>
                        
                        <h5>1. Accuracy of Information</h5>
                        <p>You confirm that all information provided during the registration process is accurate and complete to the best of your knowledge.</p>
                        
                        <h5>2. Legal Requirements</h5>
                        <p>You understand and agree to comply with all applicable laws and regulations regarding company registration in South Africa, including but not limited to:</p>
                        <ul>
                            <li>Companies Act 71 of 2008</li>
                            <li>Companies Regulations, 2011</li>
                            <li>All relevant tax registration requirements</li>
                        </ul>
                        
                        <h5>3. Fees and Payments</h5>
                        <p>All registration fees are non-refundable once the registration process has been initiated.</p>
                        
                        <h5>4. Privacy Policy</h5>
                        <p>We collect and process your personal information in accordance with the Protection of Personal Information Act (POPIA). Your information will be used solely for the purpose of company registration and related services.</p>
                        
                        <h5>5. Service Limitations</h5>
                        <p>While we strive for accuracy and efficiency, we cannot guarantee the approval of your company registration as this is subject to CIPC's discretion and verification processes.</p>
                    </div>
                    
                    <form id="verificationForm" action="<?= site_url('pbc/process-verification') ?>" method="post">
                        <?= csrf_field() ?>
                        
                       
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="termsAgreement" required>
                            <label class="form-check-label" for="termsAgreement">
                                I have read and agree to the terms and conditions stated above
                            </label>
                            <div class="invalid-feedback">
                                You must agree to the terms and conditions to proceed
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?= site_url('pbc/directors-shareholders') ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                Confirm & Submit Application <i class="fas fa-check-circle ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- reCAPTCHA API -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <script>
    // Enable terms checkbox after CAPTCHA is verified
    function enableTermsCheckbox() {
        const termsCheckbox = document.getElementById('termsAgreement');
        const recaptchaError = document.getElementById('recaptcha-error');
        
        termsCheckbox.disabled = false;
        recaptchaError.classList.add('d-none');
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('verificationForm');
        const submitBtn = document.getElementById('submitBtn');
        const termsCheckbox = document.getElementById('termsAgreement');
        
        if (form) {
            form.addEventListener('submit', function(e) {
                // Validate CAPTCHA
                const recaptchaResponse = grecaptcha.getResponse();
                if (recaptchaResponse.length === 0) {
                    e.preventDefault();
                    document.getElementById('recaptcha-error').classList.remove('d-none');
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    return false;
                }
                e.preventDefault();
                
                // Validate form
                if (!termsCheckbox.checked) {
                    termsCheckbox.classList.add('is-invalid');
                    return false;
                }
                
                // Show loading state
                const originalBtnText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Processing...';
                
                // Submit the form via fetch API to handle the response
                const formData = new FormData(this);
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                    } else {
                        return response.json().then(data => {
                            if (data.redirect) {
                                window.location.href = data.redirect;
                            } else if (data.error) {
                                throw new Error(data.error);
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred: ' + error.message);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                });
            });
            
            // Remove invalid state when user checks the box
            termsCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    this.classList.remove('is-invalid');
                }
            });
        }
    });
    </script>
</body>
</html>
