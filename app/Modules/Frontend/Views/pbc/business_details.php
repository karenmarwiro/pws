<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Details - PBC Registration</title>
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
        
        .company-name-input {
            position: relative;
        }
        
        .company-name-input .input-group-text {
            min-width: 40px;
            justify-content: center;
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
                            <h4><i class="fas fa-building me-2"></i> Company Details</h4>
                            <p class="mb-0">Step 2 of 4 - Tell us about your company</p>
                        </div>
                        <div class="card-body">
                            <form action="<?= site_url('frontend/pbc/process-company-details') ?>" method="post" enctype="multipart/form-data">
                          <?= csrf_field() ?>
                                
                               <fieldset class="mb-4">
                                    <legend class="h5"><i class="fas fa-file-signature me-2"></i>Proposed Company Names</legend>
                                    <p class="text-muted small mb-4">Please provide 4 proposed names in order of preference. We'll check their availability.</p>

                                    <div class="row g-3 mb-4">
                                        <?php for ($i = 1; $i <= 4; $i++): ?>
                                        <div class="col-12">
                                            <div class="form-group company-name-input">
                                                <label for="name<?= $i ?>" class="form-label">Proposed Company Name <?= $i ?> <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><?= $i ?>.</span>
                                                    <input type="text" class="form-control" id="name<?= $i ?>" 
                                                           name="name<?= $i ?>" required 
                                                           placeholder="Enter company name <?= $i ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <?php endfor; ?>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="physical_address" class="form-label">Physical Address <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                    <input type="text" class="form-control" id="physical_address" 
                                                           name="physical_address" required
                                                           placeholder="Enter physical address">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="suburb_city" class="form-label">Suburb & City <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-city"></i></span>
                                                    <input type="text" class="form-control" id="suburb_city" 
                                                           name="suburb_city" required
                                                           placeholder="Enter suburb and city">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="postal_code" class="form-label">Postal Code <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                    <input type="text" class="form-control" id="postal_code" 
                                                           name="postal_code" required
                                                           placeholder="Enter postal code">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-flag"></i></span>
                                                    <input type="text" class="form-control" id="country" 
                                                           name="country" required
                                                           placeholder="Enter country">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                    <input type="tel" class="form-control" id="phone_number" 
                                                           name="phone_number" required
                                                           placeholder="Enter phone number">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                    <input type="email" class="form-control" id="email" 
                                                           name="email" required
                                                           placeholder="Enter email">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="website" class="form-label">Website</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                                    <input type="url" class="form-control" id="website" 
                                                           name="website"
                                                           placeholder="Enter website (optional)">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="business_type" class="form-label">Main Type of Business <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                                    <input type="text" class="form-control" id="business_type" 
                                                           name="business_type" required
                                                           placeholder="e.g., IT Services, Retail, Consulting">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="year_end" class="form-label">Financial Year End <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                    <input type="date" class="form-control" id="year_end" 
                                                           name="year_end" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </fieldset>
                                
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="<?= site_url('frontend/pbc/personal-details') ?>" class="btn btn-outline-secondary px-4">
                                        <i class="fas fa-arrow-left me-2"></i>Back to Personal Details
                                    </a>
                                    <div>
                                        <button type="submit" class="btn btn-primary px-4">
                                            Save & Continue <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="text-center mt-4">
                                <div class="progress mt-4" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" 
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="text-muted">Step 2 of 4 - Company Details</small>
                            </div>

                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
  </body>
</html>
