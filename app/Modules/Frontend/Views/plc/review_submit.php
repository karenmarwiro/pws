<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Application - PLC Registration</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6a11cb;
            --secondary: #2575fc;
            --success: #28a745;
            --light-bg: #f8f9fa;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            color: #333;
            min-height: 100vh;
            padding: 20px 0;
        }
        
        .review-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: none;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .section-title {
            position: relative;
            padding-bottom: 12px;
            margin-bottom: 1.5rem;
            font-weight: 600;
            color: var(--primary);
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 3px;
        }
        
        .detail-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid #f0f0f0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .detail-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f5f5f5;
        }
        
        .detail-item:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 500;
            color: #666;
            flex: 1;
        }
        
        .detail-value {
            font-weight: 500;
            color: #333;
            flex: 2;
            text-align: right;
        }
        
        .shareholders-table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }
        
        .shareholders-table thead {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }
        
        .shareholders-table th {
            font-weight: 500;
            padding: 1rem;
        }
        
        .shareholders-table td {
            padding: 1rem;
            vertical-align: middle;
        }
        
        .shareholders-table tbody tr {
            transition: background-color 0.2s;
        }
        
        .shareholders-table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }
        
        .shareholders-table tbody tr:hover {
            background-color: #f0f4ff;
        }
        
        .badge-dir {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 0.35em 0.65em;
            border-radius: 50px;
            font-size: 0.75em;
            font-weight: 500;
        }
        
        .btn {
            border-radius: 10px;
            padding: 12px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-outline-secondary {
            border: 2px solid #6c757d;
            color: #6c757d;
        }
        
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.4);
        }
        
        .progress-container {
            max-width: 800px;
            margin: 0 auto 2rem auto;
        }
        
        .progress {
            height: 10px;
            border-radius: 10px;
            background-color: #e9ecef;
            overflow: hidden;
        }
        
        .progress-bar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }
        
        .step-text {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }
        
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
            
            .detail-item {
                flex-direction: column;
            }
            
            .detail-value {
                text-align: left;
                margin-top: 5px;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="review-container">

        <div class="card">
            <div class="card-header text-center">
                <h4><i class="fas fa-check-circle me-2"></i> Review Your Application</h4>
                <p class="mb-0">Verify your details before final submission</p>
            </div>
            <div class="card-body">
                <!-- Personal Details -->
                <!-- Personal Details -->
<h5 class="section-title d-flex justify-content-between align-items-center">
    <span><i class="fas fa-user me-2"></i> Personal Details</span>
    <a href="<?= site_url('frontend/plc/personal-details?edit=1') ?>" class="btn btn-sm btn-outline-primary">
        <i class="fas fa-edit"></i> Edit
    </a>
</h5>
<div class="detail-card">
    <?php
    $personalDetails = [
        ['First Name', esc($personal['first_name'])],
        ['Last Name', esc($personal['last_name'])],
        ['Email', esc($personal['email'])],
        ['Phone', esc($personal['phone_number'])]
    ];
    foreach ($personalDetails as $detail): ?>
        <div class="detail-item">
            <span class="detail-label"><?= $detail[0] ?></span>
            <span class="detail-value"><?= $detail[1] ?></span>
        </div>
    <?php endforeach; ?>
</div>

<!-- Company Details -->
<h5 class="section-title d-flex justify-content-between align-items-center">
    <span><i class="fas fa-building me-2"></i> Company Details</span>
    <a href="<?= site_url('frontend/plc/company-details?edit=1') ?>" class="btn btn-sm btn-outline-primary">
        <i class="fas fa-edit"></i> Edit
    </a>
</h5>
<div class="detail-card">
    <?php
    $companyDetails = [
        ['Proposed Name 1', esc($company['proposed_name_one'])],
        ['Proposed Name 2', esc($company['proposed_name_two'])],
        ['Proposed Name 3', esc($company['proposed_name_three'])],
        ['Proposed Name 4', esc($company['proposed_name_four'])],
        ['Postal Code', esc($company['postal_code'])],
        ['City', esc($company['suburb_city'])],
        ['Country', esc($company['country'])],
        ['Business Type', esc($company['business_type'])],
        ['Year End', esc($company['financial_year_end'])]
    ];
    foreach ($companyDetails as $detail): ?>
        <div class="detail-item">
            <span class="detail-label"><?= $detail[0] ?></span>
            <span class="detail-value"><?= $detail[1] ?></span>
        </div>
    <?php endforeach; ?>
</div>

<!-- Shareholders -->
<h5 class="section-title d-flex justify-content-between align-items-center">
    <span><i class="fas fa-users me-2"></i> Directors & Shareholders</span>
    <a href="<?= site_url('frontend/plc/directors-shareholders?edit=1') ?>" class="btn btn-sm btn-outline-primary">
        <i class="fas fa-edit"></i> Edit
    </a>
</h5>
<div class="table-responsive">
    <table class="table shareholders-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>ID/Passport</th>
                <th>Nationality</th>
                <th>Email</th>
                <th>Shareholding</th>
                <th>Director</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($shareholders as $i => $s): ?>
                <tr>
                    <td><strong><?= $i + 1 ?></strong></td>
                    <td><?= esc($s['full_name']) ?></td>
                    <td><?= esc($s['national_id']) ?></td>
                    <td><?= esc($s['nationality']) ?></td>
                    <td><?= esc($s['email']) ?></td>
                    <td><strong><?= esc($s['shareholding']) ?>%</strong></td>
                    <td>
                        <?php if ($s['is_director']): ?>
                            <span class="badge badge-dir">Yes</span>
                        <?php else: ?>
                            <span class="text-muted">No</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>


                <!-- Action buttons -->
                <div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="confirm" id="confirm" required>
            <label class="form-check-label" for="confirm">
                I confirm all details are correct.
            </label>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">
            Submit Application
        </button>
    </div>
</div>
            </div>
        </div>

                <div class="text-center mt-4">
                    <div class="progress mt-4" style="height: 8px;">
                        <div class="progress-bar" role="progressbar" style="width: 100%;" 
                             aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted">Step 4 of 4 - Directors & Shareholders</small>
                </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>