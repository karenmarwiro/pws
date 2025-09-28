<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directors & Shareholders - PBC Registration</title>
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
        
        .shareholder-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e9ecef;
            position: relative;
        }
        
        .shareholder-number {
            position: absolute;
            top: -10px;
            left: 20px;
            background: #6a11cb;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
        }
        
        .remove-shareholder {
            position: absolute;
            top: 10px;
            right: 15px;
            color: #dc3545;
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s;
        }
        
        .remove-shareholder:hover {
            opacity: 1;
        }
        
        .add-shareholder-btn {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            color: #6c757d;
            padding: 1.5rem;
            text-align: center;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 1.5rem;
        }
        
        .add-shareholder-btn:hover {
            border-color: #6a11cb;
            color: #6a11cb;
            background: #f0e6ff;
        }
        
        .total-shares {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 1.5rem 0;
            padding: 1rem;
            background: #e9ecef;
            border-radius: 8px;
            text-align: center;
        }
        
        .total-valid {
            background: #d4edda;
            color: #155724;
        }
        
        .total-invalid {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>


<body>
<div class="personal-details-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header text-center">
                        <h4><i class="fas fa-users me-2"></i> Directors & Shareholders</h4>
                        <p class="mb-0">Step 3 of 4 - Add company directors and shareholders</p>
                    </div>
                    <?php if(session()->has('error')): ?>
                        <div class="alert alert-danger">
                            <?= session('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if(session()->has('message')): ?>
                        <div class="alert alert-success">
                            <?= session('message') ?>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <form id="shareholdersForm" 
                              action="<?= site_url('frontend/pbc/process-shareholders') ?>" 
                              method="post" novalidate>
                            <?= csrf_field() ?>

                            <div id="shareholdersContainer">
                                <!-- Shareholder cards will be added here dynamically -->
                            </div>

                            <div class="add-shareholder-btn" id="addShareholderBtn">
                                <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                <p class="mb-0">Add Shareholder/Director</p>
                            </div>

                            <div class="total-shares" id="totalShares">
                                Total Shareholding: <span id="sharesSum">0</span>%
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="<?= site_url('frontend/pbc/business-details') ?>" 
                                   class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Company Details
                                </a>
                                <button type="submit" class="btn btn-primary px-4" id="nextBtn">
                                    Next <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <div class="progress mt-4" style="height: 8px;">
                        <div class="progress-bar" role="progressbar" style="width: 75%;" 
                             aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted">Step 3 of 4 - Directors & Shareholders</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template for new shareholder -->
<template id="shareholderTemplate">
    <div class="shareholder-card" data-shareholder-index="0">
        <div class="shareholder-number">1</div>
        <button type="button" class="remove-shareholder" title="Remove shareholder">
            <i class="fas fa-times"></i>
        </button>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control shareholder-name"
                               name="shareholders[0][full_name]" required 
                               placeholder="Enter full name">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">National ID/Passport No <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        <input type="text" class="form-control shareholder-id"
                               name="shareholders[0][national_id]" required 
                               placeholder="Enter ID/Passport number">
                    </div>
                </div>
            </div>

            <!-- Nationality -->
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Nationality <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-flag"></i></span>
                        <input type="text" class="form-control shareholder-nationality"
                               name="shareholders[0][nationality]" required 
                               placeholder="Enter nationality">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Shareholding (%) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                        <input type="number" class="form-control shareholder-percent"
                               name="shareholders[0][shareholding]" min="1" max="100" step="0.01" 
                               required placeholder="e.g. 50">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control shareholder-email"
                               name="shareholders[0][email]" required 
                               placeholder="email@example.com">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="tel" class="form-control shareholder-phone"
                               name="shareholders[0][phone_number]" 
                               placeholder="(123) 456-7890">
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="isDirector0" 
                           name="shareholders[0][is_director]" value="1" checked>
                    <label class="form-check-label" for="isDirector0">
                        This person is also a director
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('shareholdersContainer');
    const addBtn = document.getElementById('addShareholderBtn');
    const sharesSumSpan = document.getElementById('sharesSum');
    const template = document.getElementById('shareholderTemplate');

    let shareholderCount = 0;

    // Add first shareholder by default
    addShareholder();

    function addShareholder() {
        const newShareholder = template.content.cloneNode(true);
        const newIndex = shareholderCount;

        const card = newShareholder.querySelector('.shareholder-card');
        card.dataset.shareholderIndex = newIndex;
        card.querySelector('.shareholder-number').textContent = newIndex + 1;

        const inputs = newShareholder.querySelectorAll('input, label[for]');
        inputs.forEach(input => {
            if (input.id) input.id = input.id.replace('0', newIndex);
            if (input.name) input.name = input.name.replace('[0]', `[${newIndex}]`);
            if (input.htmlFor) input.htmlFor = input.htmlFor.replace('0', newIndex);
        });

        // Remove shareholder button
        card.querySelector('.remove-shareholder').addEventListener('click', function() {
            if (shareholderCount > 1) {
                card.remove();
                shareholderCount--;
                updateShareholderNumbers();
                updateTotalShares();
            } else {
                alert('At least one shareholder is required');
            }
        });

        container.appendChild(card);
        shareholderCount++;
        updateShareholderNumbers();
        updateTotalShares();
    }

    function updateShareholderNumbers() {
        container.querySelectorAll('.shareholder-card').forEach((card, index) => {
            card.querySelector('.shareholder-number').textContent = index + 1;
        });
    }

    function updateTotalShares() {
        let total = 0;
        container.querySelectorAll('.shareholder-percent').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        sharesSumSpan.textContent = total.toFixed(2);
    }

    addBtn.addEventListener('click', addShareholder);
});
</script>
</body>

</html>
