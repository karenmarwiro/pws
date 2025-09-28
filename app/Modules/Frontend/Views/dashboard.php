<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Alpha Empire | User Dashboard</title>
  <meta name="description" content="Professional company registration services in Zimbabwe. Register your PBC or PLC with trusted, verified consultants. Fast, reliable, and affordable.">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #2563eb;
      --secondary: #f59e0b;
      --dark: #1e293b;
      --gray: #64748b;
      --light: #f1f5f9;
      --success: #10b981;
      --danger: #ef4444;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      color: var(--dark);
      line-height: 1.6;
      background-color: #f9fafb;
    }

    .container {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    /* Header Styles */
    header {
      background: white;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .header-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 0;
    }

    .logo-text {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--dark);
    }

    .logo-text span {
      color: var(--primary);
    }

    nav {
      display: flex;
      align-items: center;
      gap: 25px;
    }

    nav a {
      text-decoration: none;
      color: var(--dark);
      font-weight: 500;
      transition: color 0.3s;
    }

    nav a:hover {
      color: var(--primary);
    }

    .auth-buttons {
      display: flex;
      gap: 15px;
    }

    .btn-login, .btn-register {
      padding: 8px 20px;
      border-radius: 4px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s;
    }

    .btn-login {
      color: var(--primary);
      border: 1px solid var(--primary);
    }

    .btn-login:hover {
      background: var(--primary);
      color: white;
    }

    .btn-register {
      background: var(--primary);
      color: white;
    }

    .btn-register:hover {
      background: #1d4ed8;
    }

    /* Hero Section */
    .hero {
      background: linear-gradient(rgba(37, 99, 235, 0.9), rgba(37, 99, 235, 0.8)), url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
      background-size: cover;
      background-position: center;
      color: white;
      padding: 80px 0;
      text-align: center;
    }

    .hero-content h1 {
      font-size: 2.5rem;
      margin-bottom: 20px;
    }

    .hero-content p {
      font-size: 1.2rem;
      max-width: 700px;
      margin: 0 auto 30px;
    }

    .btn-primary {
      display: inline-block;
      background: var(--secondary);
      color: white;
      padding: 12px 30px;
      border-radius: 4px;
      text-decoration: none;
      font-weight: 600;
      transition: background 0.3s;
    }

    .btn-primary:hover {
      background: #e69008;
    }

    /* Dashboard Styles */
    .dashboard {
      padding: 40px 0;
    }

    .dashboard-container {
      display: flex;
      gap: 30px;
    }

    /* Sidebar */
    .dashboard-sidebar {
      width: 280px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      padding: 20px;
      height: fit-content;
    }

    .user-profile {
      text-align: center;
      padding-bottom: 20px;
      border-bottom: 1px solid #eee;
      margin-bottom: 20px;
    }

    .user-avatar {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: var(--primary);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      font-weight: 600;
      margin: 0 auto 15px;
    }

    .user-profile h3 {
      margin-bottom: 5px;
    }

    .user-profile p {
      color: var(--gray);
      font-size: 0.9rem;
    }

    .dashboard-menu {
      list-style: none;
    }

    .dashboard-menu li {
      margin-bottom: 10px;
    }

    .dashboard-menu a {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 15px;
      color: var(--dark);
      text-decoration: none;
      border-radius: 4px;
      transition: all 0.3s;
    }

    .dashboard-menu a:hover, .dashboard-menu a.active {
      background: var(--light);
      color: var(--primary);
    }

    .dashboard-menu a i {
      width: 20px;
      text-align: center;
    }

    /* Dashboard Content */
    .dashboard-content {
      flex: 1;
      background: white;
      border-radius: 8px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      padding: 30px;
    }

    .dashboard-header {
      margin-bottom: 30px;
    }

    .dashboard-header h2 {
      font-size: 1.8rem;
      margin-bottom: 10px;
    }

    /* Profile Completion */
    .profile-completion {
      background: var(--light);
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 30px;
    }

    .progress-container {
      margin: 20px 0;
    }

    .progress-info {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
    }

    .progress-bar {
      height: 10px;
      background: #e5e7eb;
      border-radius: 5px;
      overflow: hidden;
    }

    .progress {
      height: 100%;
      border-radius: 5px;
      background: linear-gradient(90deg, var(--primary) 0%, #3b82f6 100%);
      width: 35%;
      transition: width 0.5s ease;
    }

    /* Dashboard Cards */
    .dashboard-cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }

    .dashboard-card {
      background: var(--light);
      border-radius: 8px;
      padding: 20px;
      text-align: center;
    }

    .dashboard-card i {
      font-size: 2.5rem;
      color: var(--primary);
      margin-bottom: 15px;
    }

    .dashboard-card h3 {
      margin-bottom: 10px;
    }

    .dashboard-card p {
      color: var(--gray);
      margin-bottom: 15px;
    }

    /* Application Steps */
    .steps {
      display: flex;
      justify-content: space-between;
      margin: 40px 0;
      position: relative;
    }

    .steps::before {
      content: '';
      position: absolute;
      top: 30px;
      left: 0;
      right: 0;
      height: 4px;
      background: #e5e7eb;
      z-index: 1;
    }

    .step {
      text-align: center;
      position: relative;
      z-index: 2;
    }

    .step-number {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: white;
      border: 4px solid #e5e7eb;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 1.2rem;
      color: #9ca3af;
      margin: 0 auto 15px;
      transition: all 0.3s ease;
    }

    .step.active .step-number {
      border-color: var(--primary);
      background: var(--primary);
      color: white;
    }

    .step.completed .step-number {
      border-color: var(--success);
      background: var(--success);
      color: white;
    }

    .step-title {
      font-weight: 600;
      color: #9ca3af;
    }

    .step.active .step-title,
    .step.completed .step-title {
      color: var(--dark);
    }

    /* Buttons */
    .btn-dashboard {
      display: inline-block;
      background: var(--primary);
      color: white;
      text-decoration: none;
      padding: 10px 20px;
      border-radius: 4px;
      font-weight: 600;
      transition: background 0.3s;
      border: none;
      cursor: pointer;
    }

    .btn-dashboard:hover {
      background: #1d4ed8;
    }

    .btn-success {
      background: var(--success);
    }

    .btn-success:hover {
      background: #059669;
    }

    .action-buttons {
      display: flex;
      gap: 15px;
      margin-top: 20px;
    }

    /* Footer */
    footer {
      background: var(--dark);
      color: white;
      text-align: center;
      padding: 30px 0;
      margin-top: 60px;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
      .dashboard-container {
        flex-direction: column;
      }
      
      .dashboard-sidebar {
        width: 100%;
      }
      
      .dashboard-cards {
        grid-template-columns: 1fr;
      }
      
      .steps {
        flex-direction: column;
        gap: 30px;
      }
      
      .steps::before {
        display: none;
      }
    }

    @media (max-width: 768px) {
      .header-container {
        flex-direction: column;
        gap: 15px;
      }
      
      nav {
        flex-wrap: wrap;
        justify-content: center;
      }
      
      .hero-content h1 {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="container header-container">
      <div class="logo">
        <div class="logo-text">Angel & <span>Walt</span></div>
      </div>
      <nav>
        <a href="#services">Services</a>
        <a href="#why-us">Why Us</a>
        <a href="#about">About Us</a>
        <a href="#contact">Contact</a>
        <div class="auth-buttons">
          <a href="<?= site_url('/login') ?>" class="btn-login"> Login </a>
          <a href="<?= site_url('/register') ?>" class="btn-register"> Register </a>
        </div>
      </nav>
    </div>
  </header>

  <section class="hero">
    <div class="container">
      <div class="hero-content">
        <h1>Fast & Reliable Company Registration in Zimbabwe</h1>
        <p>Register your PBC or PLC with trusted professionals. 100% legal, verified, and affordable. Start your business journey with confidence.</p>
        <a href="#contact" class="btn-primary">Start Registration Today</a>
      </div>
    </div>
  </section>

  <!-- User Dashboard Section -->
  <section class="dashboard">
    <div class="container dashboard-container">
      <!-- Dashboard Sidebar -->
      <div class="dashboard-sidebar">
        <div class="user-profile">
          <div class="user-avatar">AJ</div>
          <h3>Alex Johnson</h3>
          <p>Registered: Jan 15, 2024</p>
        </div>
        
        <ul class="dashboard-menu">
          <li><a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
          <li>
            <a href="#"><i class="fas fa-caret-down"></i> My Account</a>
            <ul class="submenu">
              <li><a href="#"><i class="fas fa-file-alt"></i> Apply</a></li>
              <li><a href="#"><i class="fas fa-user"></i> Profile</a></li>
              <li><a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
      
      <!-- Dashboard Content -->
      <div class="dashboard-content">
        <div class="dashboard-header">
          <h2>Welcome back, Alex Johnson</h2>
          <p>Your account overview and next steps</p>
        </div>
        
        <!-- Profile Completion -->
        <div class="profile-completion">
          <h3>Complete Your Profile</h3>
          <p>Finish your profile to unlock all features and start your application process.</p>
          
          <div class="progress-container">
            <div class="progress-info">
              <span>35% Complete</span>
              <span>5/14 fields</span>
            </div>
            <div class="progress-bar">
              <div class="progress" id="profileProgress"></div>
            </div>
          </div>
          
          <div class="action-buttons">
            <button class="btn-dashboard" id="finishProfileBtn">
              <i class="fas fa-user-edit"></i> Finish Profile
            </button>
          </div>
        </div>
        
        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
          <div class="dashboard-card">
            <i class="fas fa-user"></i>
            <h3>Profile Information</h3>
            <p>View and update your personal details</p>
            <a href="#profile" class="btn-dashboard">Edit Profile</a>
          </div>
          
          <div class="dashboard-card">
            <i class="fas fa-check-circle"></i>
            <h3>Your Registrations</h3>
            <p>Track the progress of your company registrations</p>
            <a href="#registrations" class="btn-dashboard">View Registrations</a>
          </div>
        </div>
        
        <!-- Application Process -->
        <h3>Application Process</h3>
        <p>Follow these steps to complete your application:</p>
        
        <div class="steps">
          <div class="step completed">
            <div class="step-number">1</div>
            <div class="step-title">Create Account</div>
          </div>
          
          <div class="step active">
            <div class="step-number">2</div>
            <div class="step-title">Complete Profile</div>
          </div>
          
          <div class="step">
            <div class="step-number">3</div>
            <div class="step-title">Select Program</div>
          </div>
          
          <div class="step">
            <div class="step-number">4</div>
            <div class="step-title">Submit Application</div>
          </div>
        </div>
        
        <!-- Start Application Button (initially hidden) -->
        <div id="applicationSection" style="display: none;">
          <div class="action-buttons">
            <button class="btn-dashboard btn-success" id="startApplicationBtn">
              <i class="fas fa-play-circle"></i> Start Application
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Other Sections (Services, Why Us, etc.) -->
  <section id="services" class="features">
    <div class="container">
      <div class="section-title">
        <h2>What We Offer</h2>
        <p>Comprehensive business registration services tailored to your needs</p>
      </div>
      <!-- Your existing service cards here -->
    </div>
  </section>

  <!-- Other Sections (Why Us, About, Contact) -->

  <footer>
    <div class="container">
      <p>&copy; <script>document.write(new Date().getFullYear())</script> Angel & Walt | Harare, Zimbabwe</p>
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const finishProfileBtn = document.getElementById('finishProfileBtn');
      const startApplicationBtn = document.getElementById('startApplicationBtn');
      const applicationSection = document.getElementById('applicationSection');
      const profileProgress = document.getElementById('profileProgress');
      const step2 = document.querySelector('.step:nth-child(2)');
      
      finishProfileBtn.addEventListener('click', function() {
        // Simulate profile completion
        profileProgress.style.width = '100%';
        document.querySelector('.progress-info span:first-child').textContent = '100% Complete';
        document.querySelector('.progress-info span:last-child').textContent = '14/14 fields';
        
        // Update step status
        step2.classList.remove('active');
        step2.classList.add('completed');
        
        document.querySelector('.step:nth-child(3)').classList.add('active');
        
        // Show application section
        applicationSection.style.display = 'block';
        
        // Update button text
        finishProfileBtn.innerHTML = '<i class="fas fa-check-circle"></i> Profile Complete';
        finishProfileBtn.style.background = '#10b981';
        
        // Show success message
        alert('Profile completed successfully! You can now start your application.');
      });
      
      startApplicationBtn.addEventListener('click', function() {
        alert('Redirecting to application page...');
        // In a real application, this would redirect to the application page
      });
    });
  </script>
</body>
</html>