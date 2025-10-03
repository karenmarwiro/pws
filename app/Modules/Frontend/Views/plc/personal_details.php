
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Details - Company Registration</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= base_url('assets/css/personal-details.css') ?>" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        
        .form-control, .btn {
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(106, 17, 203, 0.1);
            border-color: #6a11cb;
        }
    </style>
</head>
<body>
    <div class="personal-details-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4><i class="fas fa-user-circle me-2"></i> Applicant Details</h4>
                            <p class="mb-0">Step 1 of 4 - Let's get to know you</p>
                        </div>
                        <div class="card-body">
                           <form action="<?= site_url('frontend/plc/process-personal-details') ?>" method="post">
    <?= csrf_field() ?>

    <fieldset class="mb-4">
        <legend class="h5">Your  Details</legend>

        <div class="row g-3">
            <!-- First Name -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="first_name" name="first_name"
                           value="<?= old('first_name') ?>" required>
                    <?php if (session()->getFlashdata('errors')['first_name'] ?? false): ?>
                        <div class="text-danger small"><?= session()->getFlashdata('errors')['first_name'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Surname -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="surname" class="form-label">Surname <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="surname" name="surname"
                           value="<?= old('surname') ?>" required>
                    <?php if (session()->getFlashdata('errors')['surname'] ?? false): ?>
                        <div class="text-danger small"><?= session()->getFlashdata('errors')['surname'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- National ID -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="national_id" class="form-label">National ID <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="national_id" name="national_id"
                           value="<?= old('national_id') ?>" required>
                    <?php if (session()->getFlashdata('errors')['national_id'] ?? false): ?>
                        <div class="text-danger small"><?= session()->getFlashdata('errors')['national_id'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Phone -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" id="phone" name="phone"
                           value="<?= old('phone') ?>" required>
                    <?php if (session()->getFlashdata('errors')['phone'] ?? false): ?>
                        <div class="text-danger small"><?= session()->getFlashdata('errors')['phone'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- WhatsApp (optional) -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="whatsapp" class="form-label">WhatsApp Number</label>
                    <input type="tel" class="form-control" id="whatsapp" name="whatsapp"
                           value="<?= old('whatsapp') ?>">
                </div>
            </div>

            <!-- Email -->
            <div class="col-12">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="<?= old('email') ?>" required>
                    <?php if (session()->getFlashdata('errors')['email'] ?? false): ?>
                        <div class="text-danger small"><?= session()->getFlashdata('errors')['email'] ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Referral -->
            <div class="col-12">
                <div class="form-group">
                    <label for="referral" class="form-label">How did you hear about us?</label>
                    <input type="text" class="form-control" id="referral" name="referral"
                           value="<?= old('referral') ?>">
                </div>
            </div>
        </div>
    </fieldset>

    <!-- Actions -->
    <div class="d-flex justify-content-between mt-4">
        <button type="reset" class="btn btn-secondary px-4">Clear Form</button>
        <button type="submit" class="btn btn-primary px-4">
            Next
        </button>
    </div>
</form>

                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted">Already have an account? <a href="#">Sign in</a></p>
                        <div class="progress mt-4" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" 
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">Step 1 of 4</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="<?= base_url('assets/js/personal-details.js') ?>"></script>
</body>
</html>



