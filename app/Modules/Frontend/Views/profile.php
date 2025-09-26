<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Complete Your Profile | Alpha & Empire</title>
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

    /* Form Styles */
    .profile-form {
      margin-top: 20px;
    }

    .form-section {
      margin-bottom: 30px;
      padding-bottom: 20px;
      border-bottom: 1px solid #eee;
    }

    .form-section-title {
      font-size: 1.3rem;
      margin-bottom: 20px;
      color: var(--primary);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .form-row {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
    }

    .form-group {
      flex: 1;
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
    }

    .form-group input, .form-group select, .form-group textarea {
      width: 100%;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-family: 'Poppins', sans-serif;
      font-size: 1rem;
    }

    .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .required::after {
      content: '*';
      color: var(--danger);
      margin-left: 4px;
    }

    .form-hint {
      font-size: 0.85rem;
      color: var(--gray);
      margin-top: 5px;
    }

    /* Buttons */
    .btn-dashboard {
      display: inline-block;
      background: var(--primary);
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 4px;
      font-weight: 600;
      transition: background 0.3s;
      border: none;
      cursor: pointer;
      font-size: 1rem;
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

    .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 15px;
      margin-top: 30px;
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
      
      .form-row {
        flex-direction: column;
        gap: 0;
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
      
      .form-actions {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="container header-container">
      <div class="logo">
        <div class="logo-text">Alpha <span>Empire</span></div>
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
          <li><a href="dashboard"><i class="fas fa-home"></i> Dashboard</a></li>
          <li><a href="apply"><i class="fas fa-file-alt"></i> Apply</a></li>
          <li><a href="profile" class="active"><i class="fas fa-user"></i> Profile</a></li>
          <li><a href=""><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
      </div>
      
      <!-- Dashboard Content -->
      <div class="dashboard-content">
        <div class="dashboard-header">
          <h2>Complete Your Profile</h2>
          <p>Please provide all required information for company registration</p>
        </div>
        
        <!-- Profile Form -->
        <form class="profile-form" id="profileForm">
          <!-- Personal Information Section -->
          <div class="form-section">
            <h3 class="form-section-title">
              <i class="fas fa-user-circle"></i> Personal Information
            </h3>
            
            <div class="form-row">
              <div class="form-group">
                <label for="firstName" class="required">First Name</label>
                <input type="text" id="firstName" name="firstName" required>
              </div>
              
              <div class="form-group">
                <label for="lastName" class="required">Last Name</label>
                <input type="text" id="lastName" name="lastName" required>
              </div>
            </div>
            
            <div class="form-row">
              <div class="form-group">
                <label for="idNumber" class="required">National ID Number</label>
                <input type="text" id="idNumber" name="idNumber" required>
                <p class="form-hint">As it appears on your national identification document</p>
              </div>
              
              <div class="form-group">
                <label for="dob" class="required">Date of Birth</label>
                <input type="date" id="dob" name="dob" required>
              </div>
            </div>
            
            <div class="form-row">
              <div class="form-group">
                <label for="gender" class="required">Gender</label>
                <select id="gender" name="gender" required>
                  <option value="">Select Gender</option>
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                  <option value="other">Other</option>
                </select>
              </div>
              
              <div class="form-group">
                <label for="maritalStatus" class="required">Marital Status</label>
                <select id="maritalStatus" name="maritalStatus" required>
                  <option value="">Select Status</option>
                  <option value="single">Single</option>
                  <option value="married">Married</option>
                  <option value="divorced">Divorced</option>
                  <option value="widowed">Widowed</option>
                </select>
              </div>
            </div>
          </div>
          
          <!-- Contact Information Section -->
          <div class="form-section">
            <h3 class="form-section-title">
              <i class="fas fa-address-book"></i> Contact Information
            </h3>
            
            <div class="form-row">
              <div class="form-group">
                <label for="email" class="required">Email Address</label>
                <input type="email" id="email" name="email" required>
              </div>
              
              <div class="form-group">
                <label for="phone" class="required">Phone Number</label>
                <input type="tel" id="phone" name="phone" required>
              </div>
            </div>
            
            <div class="form-group">
              <label for="address" class="required">Physical Address</label>
              <textarea id="address" name="address" rows="3" required></textarea>
            </div>
            
            <div class="form-row">
              <div class="form-group">
                <label for="city" class="required">City</label>
                <input type="text" id="city" name="city" required>
              </div>
              
              <div class="form-group">
                <label for="postalCode" class="required">Postal Code</label>
                <input type="text" id="postalCode" name="postalCode" required>
              </div>
            </div>
          </div>
          
          <!-- Identification Documents Section -->
          <div class="form-section">
            <h3 class="form-section-title">
              <i class="fas fa-id-card"></i> Identification Documents
            </h3>
            
            <div class="form-group">
              <label for="idDocument" class="required">National ID Document</label>
              <input type="file" id="idDocument" name="idDocument" accept=".pdf,.jpg,.jpeg,.png" required>
              <p class="form-hint">Upload a clear scan of your national ID (PDF, JPG, or PNG)</p>
            </div>
            
            <div class="form-group">
              <label for="proofOfAddress" class="required">Proof of Address</label>
              <input type="file" id="proofOfAddress" name="proofOfAddress" accept=".pdf,.jpg,.jpeg,.png" required>
              <p class="form-hint">Utility bill, bank statement or official letter (not older than 3 months)</p>
            </div>
            
            <div class="form-group">
              <label for="passportPhoto" class="required">Passport Photo</label>
              <input type="file" id="passportPhoto" name="passportPhoto" accept=".jpg,.jpeg,.png" required>
              <p class="form-hint">Recent passport-sized photograph with white background</p>
            </div>
          </div>
          
  
          
          <!-- Terms and Conditions -->
          <div class="form-group">
            <div style="display: flex; align-items: start; gap: 10px;">
              <input type="checkbox" id="terms" name="terms" required style="margin-top: 3px;">
              <label for="terms" class="required">I certify that the information provided is true and accurate to the best of my knowledge. I understand that providing false information may result in rejection of my application.</label>
            </div>
          </div>
          <?php if(session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach(session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

          
          <!-- Form Actions -->
          <form class="profile-form" id="profileForm"
            action="<?= site_url('frontend/profile/submit') ?>"
            method="post"
            enctype="multipart/form-data">
          <?= csrf_field() ?>

    <!-- your form fields here -->

    <div class="form-actions">
        <button type="submit" class="btn-dashboard btn-success">Submit Profile</button>
    </div>
</form>



        </form>
      </div>
    </div>
  </section>

  <footer>
    <div class="container">
      <p>&copy; <script>document.write(new Date().getFullYear())</script> Alpha Empire | Harare, Zimbabwe</p>
    </div>
  </footer>

</body>
</html>