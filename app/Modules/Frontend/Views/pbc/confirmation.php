<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted - PBC Registration</title>
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
            display: flex;
            align-items: center;
            min-height: 100vh;
        }
        
        .confirmation-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .success-icon {
            width: 100px;
            height: 100px;
            background: #28a745;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 3rem;
        }
        
        h1 {
            color: #28a745;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }
        
        .application-id {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 5px;
            font-family: monospace;
            font-size: 1.2rem;
            margin: 1.5rem 0;
            display: inline-block;
        }
        
        .next-steps {
            text-align: left;
            max-width: 600px;
            margin: 2rem auto 0;
        }
        
        .next-steps h3 {
            color: #6a11cb;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .next-steps ul {
            padding-left: 1.5rem;
        }
        
        .next-steps li {
            margin-bottom: 0.75rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 500;
            margin-top: 1.5rem;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(106, 17, 203, 0.3);
        }
        
        .contact-info {
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid #eee;
        }
        
        .contact-info p {
            margin-bottom: 0.5rem;
        }
        
        .whatsapp-link {
            color: #25D366;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="confirmation-container">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            
            <h1>Application Submitted Successfully!</h1>
            
            <p class="lead">Thank you for choosing our services. We've received your application and will process it shortly.</p>
            
            <div class="application-id">
    <i class="fas fa-file-alt me-2"></i> Reference: <?= esc($referenceNumber ?? 'N/A') ?>
</div>

                        
            <div class="next-steps">
                <h3>What Happens Next?</h3>
                <ul>
                    <li>You'll receive a confirmation email with your application details</li>
                    <li>Our team will review your application within 1-2 business days</li>
                    <li>We may contact you if we need any additional information</li>
                    <li>Once approved, you'll receive your company registration documents via email</li>
                </ul>
            </div>
            
            <div class="contact-info">
                <p class="mb-2">Need help or have questions?</p>
                <p class="mb-1">
                    <i class="fas fa-envelope me-2"></i> 
                    <a href="mailto:support@companyreg.co.za">support@companyreg.co.zw</a>
                </p>
                <p class="mb-0">
                    <i class="fab fa-whatsapp me-2"></i> 
                    <a href="https://wa.me/27612345678" class="whatsapp-link">+27 61 234 5678</a>
                </p>
            </div>
            
            <a href="<?= site_url('frontend/dashboard') ?>" class="btn btn-primary">
                <i class="fas fa-home me-2"></i> Back to Home
            </a>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
