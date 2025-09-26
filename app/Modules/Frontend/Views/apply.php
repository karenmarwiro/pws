<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Select Registration Type</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #2c3e50;
      --secondary-color: #3498db;
      --accent-color: #e74c3c;
      --light-bg: #f8f9fa;
      --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
      --transition: all 0.3s ease;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    
    .selection-container {
      background: white;
      border-radius: 20px;
      padding: 40px;
      box-shadow: var(--card-shadow);
      max-width: 1000px;
      width: 100%;
      margin: 20px;
    }
    
    .selection-container h1 {
      color: var(--primary-color);
      font-weight: 700;
      margin-bottom: 15px;
      text-align: center;
    }
    
    .selection-container > p {
      color: #6c757d;
      text-align: center;
      margin-bottom: 40px;
      font-size: 1.1rem;
    }
    
    .options {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      margin-top: 30px;
    }
    
    .card {
      display: block;
      text-decoration: none;
      color: inherit;
      background: white;
      border-radius: 15px;
      padding: 30px;
      border: 2px solid #e9ecef;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }
    
    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: var(--secondary-color);
      transition: var(--transition);
    }
    
    .card:hover {
      transform: translateY(-5px);
      border-color: var(--secondary-color);
      box-shadow: var(--card-shadow);
    }
    
    .card:hover::before {
      height: 6px;
      background: var(--accent-color);
    }
    
    .card h2 {
      color: var(--primary-color);
      font-weight: 600;
      margin-bottom: 15px;
      font-size: 1.4rem;
    }
    
    .card p {
      color: #6c757d;
      margin-bottom: 25px;
      line-height: 1.6;
    }
    
    .btn {
      background: var(--secondary-color);
      color: white;
      padding: 12px 25px;
      border-radius: 50px;
      font-weight: 500;
      transition: var(--transition);
      display: inline-block;
    }
    
    .card:hover .btn {
      background: var(--accent-color);
      transform: translateX(5px);
    }
    
    .icon {
      font-size: 2.5rem;
      margin-bottom: 20px;
      display: block;
    }
    
    .features {
      list-style: none;
      padding: 0;
      margin: 20px 0;
    }
    
    .features li {
      padding: 5px 0;
      color: #6c757d;
    }
    
    .features li i {
      color: #28a745;
      margin-right: 10px;
    }
    
    .badge {
      position: absolute;
      top: 20px;
      right: 20px;
      background: #ffc107;
      color: #000;
      padding: 5px 15px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
      .selection-container {
        padding: 25px;
        margin: 10px;
      }
      
      .options {
        grid-template-columns: 1fr;
      }
      
      .card {
        padding: 25px;
      }
    }
    
    /* Animation */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .selection-container {
      animation: fadeInUp 0.6s ease-out;
    }
    
    .card {
      animation: fadeInUp 0.8s ease-out;
    }
    
    .card:nth-child(2) {
      animation-delay: 0.2s;
    }
  </style>
</head>
<body>
  <div class="selection-container">
    <div class="text-center mb-5">
      <h1 class="display-4 fw-bold text-primary">
        <i class="fas fa-building me-3"></i>Choose Your Company Registration Type
      </h1>
      <p class="lead text-muted">Select the option that best suits your business needs and requirements</p>
    </div>

    <div class="options">
  <!-- PBC Option -->
  <a href="<?= site_url('frontend/pbc/start-application') ?>" class="card position-relative">
    <span class="badge">Most Popular</span>
    <i class="icon fas fa-store"></i>
    <h2>Private Business Corporation (PBC)</h2>
    <p>Perfect for small businesses, startups, and entrepreneurs looking for a simple and cost-effective business structure.</p>
    
    <ul class="features">
      <li><i class="fas fa-check-circle"></i> Simple registration process</li>
      <li><i class="fas fa-check-circle"></i> Lower compliance requirements</li>
      <li><i class="fas fa-check-circle"></i> Ideal for 1-20 shareholders</li>
      <li><i class="fas fa-check-circle"></i> Faster setup time</li>
    </ul>
    
    <span class="btn">
      Apply Now <i class="fas fa-arrow-right ms-2"></i>
    </span>
  </a>

  <!-- PLC Option -->
  <a href="<?= site_url('frontend/plc/start-application') ?>" class="card">
    <i class="icon fas fa-city"></i>
    <h2>Private Limited Company (PLC)</h2>
    <p>Designed for growing businesses that require a formal structure with shareholders, directors, and corporate governance.</p>
    
    <ul class="features">
      <li><i class="fas fa-check-circle"></i> Separate legal entity</li>
      <li><i class="fas fa-check-circle"></i> Limited liability protection</li>
      <li><i class="fas fa-check-circle"></i> Better access to funding</li>
      <li><i class="fas fa-check-circle"></i> Professional corporate structure</li>
    </ul>
    
    <span class="btn">
      Apply Now <i class="fas fa-arrow-right ms-2"></i>
    </span>
  </a>
</div>

    <div class="text-center mt-5">
      <p class="text-muted">
        <i class="fas fa-question-circle me-2"></i>
        Not sure which one to choose? 
        <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#helpModal">
          Compare features
        </a>
      </p>
    </div>
  </div>

  <!-- Help Modal -->
  <div class="modal fade" id="helpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Comparison: PBC vs PLC</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Feature</th>
                  <th>PBC</th>
                  <th>PLC</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Legal Entity</td>
                  <td>Separate</td>
                  <td>Separate</td>
                </tr>
                <tr>
                  <td>Liability</td>
                  <td>Limited</td>
                  <td>Limited</td>
                </tr>
                <tr>
                  <td>Minimum Shareholders</td>
                  <td>1</td>
                  <td>1</td>
                </tr>
                <tr>
                  <td>Maximum Shareholders</td>
                  <td>20</td>
                  <td>50</td>
                </tr>
                <tr>
                  <td>Compliance Level</td>
                  <td>Low</td>
                  <td>High</td>
                </tr>
                <tr>
                  <td>Setup Time</td>
                  <td>3-5 days</td>
                  <td>7-10 days</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap & JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Add smooth scrolling to links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
          e.preventDefault();
          document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
          });
        });
      });

      // Add animation to cards on hover
      const cards = document.querySelectorAll('.card');
      cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
          this.style.transform = 'translateY(-8px)';
        });
        
        card.addEventListener('mouseleave', function() {
          this.style.transform = 'translateY(0)';
        });
      });

      // Show tooltips
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
  </script>
</body>
</html>