<?= $this->extend('App\Modules\Frontend\Views\Layouts\default') ?>

<?= $this->section('title') ?>Company Registration Experts in Zimbabwe | Alpha Empire<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
  .hero-section {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
  }
  .feature-card {
    transition: all 0.3s ease;
  }
  .feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
  }
</style>

<style>
  :root {
    --primary: #2563eb;
    --primary-light: #dbeafe;
    --primary-dark: #1d4ed8;
    --secondary: #7c3aed;
    --accent: #f59e0b;
    --dark: #1e293b;
    --dark-2: #334155;
    --light: #f8fafc;
    --gray: #94a3b8;
    --gray-light: #e2e8f0;
    --success: #10b981;
    --danger: #ef4444;
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    --shadow-lg: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --radius: 0.75rem;
    --radius-lg: 1rem;
  }
  
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  
  body {
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    color: var(--dark);
    line-height: 1.6;
    background-color: #ffffff;
    overflow-x: hidden;
  }
  
  h1, h2, h3, h4, h5, h6 {
    font-weight: 700;
    line-height: 1.2;
    color: var(--dark);
  }
  
  .container {
    width: 100%;
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 1.5rem;
  }
  
  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.5rem;
    border-radius: var(--radius);
    font-weight: 600;
    text-align: center;
    transition: var(--transition);
    border: none;
    cursor: pointer;
    font-size: 1rem;
    line-height: 1.5;
  }
  
  .btn-primary {
    background: var(--primary);
    color: white;
    box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.3), 0 2px 4px -1px rgba(37, 99, 235, 0.2);
  }
  
  .btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3), 0 4px 6px -2px rgba(37, 99, 235, 0.2);
  }
  
  .btn-secondary {
    background: white;
    color: var(--primary);
    border: 1px solid var(--gray-light);
  }
  
  .btn-secondary:hover {
    background: var(--gray-light);
    transform: translateY(-2px);
    box-shadow: var(--shadow);
  }
  
  .section {
    padding: 6rem 0;
    position: relative;
  }
  
  .section-title {
    text-align: center;
    max-width: 800px;
    margin: 0 auto 4rem;
  }
  
  .section-title h2 {
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
    position: relative;
    display: inline-block;
  }
  
  .section-title h2:after {
    content: '';
    position: absolute;
    bottom: -0.75rem;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--secondary));
    border-radius: 2px;
  }
  
  .section-title p {
    font-size: 1.125rem;
    color: var(--gray);
    margin-bottom: 0;
  }
  
  .card {
    background: white;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
    transition: var(--transition);
    height: 100%;
    border: 1px solid rgba(226, 232, 240, 0.5);
  }
  
  .card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
  }
  
  .card-body {
    padding: 2rem;
  }
  
  .card-icon {
    width: 56px;
    height: 56px;
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
    font-size: 1.5rem;
    color: white;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.3), 0 2px 4px -1px rgba(37, 99, 235, 0.2);
  }
  
  .bg-gradient {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
  }
  
  /* Animations */
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  @keyframes float {
    0% {
      transform: translateY(0px);
    }
    50% {
      transform: translateY(-10px);
    }
    100% {
      transform: translateY(0px);
    }
  }
  
  .animate-float {
    animation: float 6s ease-in-out infinite;
  }
  
  .animation-delay-2000 {
    animation-delay: 2s;
  }
  
  .fade-in-up {
    animation: fadeInUp 0.6s ease-out forwards;
  }
  
  /* Custom Utility Classes */
  .text-shadow {
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  
  .backdrop-blur {
    backdrop-filter: blur(8px);
  }
  
  /* Custom Scrollbar */
  ::-webkit-scrollbar {
    width: 8px;
    height: 8px;
  }
  
  ::-webkit-scrollbar-track {
    background: #f1f5f9;
  }
  
  ::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
  }
  
  ::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
  }
  /* Modern About Section */
  :root {
    --primary: #4e73df;
    --primary-light: #eaedff;
    --secondary: #2e59d9;
    --dark: #2c3e50;
    --light: #f8f9fe;
    --accent: #f6c23e;
    --success: #1cc88a;
    --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    --transition: all 0.3s ease;
  }
  
  .about {
    background: linear-gradient(135deg, #f8f9fe 0%, #f1f4ff 100%);
    position: relative;
    overflow: hidden;
  }
  
  .about::before {
    content: '';
    position: absolute;
    width: 600px;
    height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(78, 115, 223, 0.1) 0%, rgba(78, 115, 223, 0) 70%);
    top: -300px;
    right: -200px;
    z-index: 0;
  }
  
  .section-title {
    position: relative;
    z-index: 1;
  }
  
  .section-title h2 {
    font-weight: 800;
    color: var(--dark);
    position: relative;
    display: inline-block;
    margin-bottom: 1.5rem;
  }
  
  .section-title h2::after {
    content: '';
    position: absolute;
    width: 50%;
    height: 4px;
    background: var(--primary);
    bottom: -10px;
    left: 0;
    border-radius: 2px;
  }
  
  .vision-mission {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow);
    transition: var(--transition);
    height: 100%;
    border-top: 4px solid var(--primary);
    position: relative;
    overflow: hidden;
    z-index: 1;
  }
  
  .vision-mission::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--secondary));
  }
  
  .vision-mission:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(78, 115, 223, 0.2);
  }
  
  .vision-mission h4 {
    color: var(--dark);
    font-weight: 700;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
  }
  
  .vision-mission h4 i {
    margin-right: 10px;
    color: var(--primary);
    background: var(--primary-light);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
  }
  
  .vision-mission p, .vision-mission li {
    color: #6c757d;
    line-height: 1.7;
  }
  
  .vision-mission ul {
    padding-left: 1.5rem;
  }
  
  .vision-mission li {
    position: relative;
    padding-left: 1.5rem;
    margin-bottom: 0.75rem;
  }
  
  .vision-mission li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: var(--success);
    font-weight: bold;
  }
  
  /* Modern Timeline */
  .timeline {
    position: relative;
    padding-left: 3rem;
  }
  
  .timeline::before {
    content: '';
    position: absolute;
    left: 1.5rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: linear-gradient(to bottom, var(--primary), var(--secondary));
    border-radius: 2px;
  }
  
  .timeline-item {
    position: relative;
    padding-bottom: 2.5rem;
    padding-left: 1rem;
  }
  
  .timeline-item:last-child {
    padding-bottom: 0;
  }
  
  .timeline-icon {
    position: absolute;
    left: -2.5rem;
    width: 3rem;
    height: 3rem;
    border-radius: 12px;
    background: white;
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    box-shadow: 0 4px 15px rgba(78, 115, 223, 0.2);
    border: 2px solid white;
    transition: var(--transition);
    z-index: 2;
  }
  
  .timeline-item:hover .timeline-icon {
    transform: scale(1.1) rotate(5deg);
    background: var(--primary);
    color: white;
  }
  
  .timeline-content {
    padding: 1.5rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
    transition: var(--transition);
    position: relative;
    border: 1px solid rgba(0, 0, 0, 0.03);
  }
  
  .timeline-item:hover .timeline-content {
    transform: translateX(10px);
    box-shadow: 0 8px 30px rgba(78, 115, 223, 0.15);
  }
  
  .timeline-content h4 {
    color: var(--dark);
    margin-top: 0;
    margin-bottom: 0.75rem;
    font-weight: 700;
    position: relative;
    padding-bottom: 0.75rem;
  }
  
  .timeline-content h4::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 3px;
    background: var(--primary);
    border-radius: 3px;
  }
  
  .timeline-content p {
    color: #6c757d;
    margin-bottom: 0;
    line-height: 1.7;
  }
  
  /* Stats Card */
  .analysis {
    height: 100%;
    position: relative;
    z-index: 1;
    overflow: hidden;
    border-radius: 16px;
    background: white;
    box-shadow: var(--shadow);
    transition: var(--transition);
    border: 1px solid rgba(0, 0, 0, 0.03);
  }
  
  .analysis::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), var(--secondary));
  }
  
  .analysis:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(78, 115, 223, 0.15);
  }
  
  .analysis .stats {
    padding: 2rem;
    background: transparent;
    box-shadow: none;
  }
  
  .stats .display-4 {
    font-weight: 800;
    background: linear-gradient(90deg, var(--primary), var(--secondary));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 0.5rem;
  }
  
  .stats .text-muted {
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 600;
    color: #6c757d !important;
  }
  
  /* Responsive Adjustments */
  @media (max-width: 991.98px) {
    .order-lg-1 {
      order: 2;
    }
    .order-lg-2 {
      order: 1;
      margin-bottom: 3rem;
    }
    
    .timeline {
      padding-left: 2.5rem;
    }
    
    .timeline-icon {
      left: -2rem;
      width: 2.5rem;
      height: 2.5rem;
      font-size: 1rem;
    }
  }
  
  /* Animation */
  @keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
  }
  
  .floating {
    animation: float 6s ease-in-out infinite;
  }
</style>
<?php $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<section class="relative overflow-hidden py-20 md:py-32 hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('<?= base_url('assets/img/Picture2.jpg') ?>') no-repeat center center; background-size: cover; color: white; background-attachment: fixed;">
  <div class="container mx-auto px-4 text-center relative z-10">
    <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
      Welcome to <span class="text-blue-400">Alpha Empire</span>
    </h1>
    <p class="text-xl text-gray-200 max-w-3xl mx-auto mb-10">
      Your trusted partner for company registration and business services in Zimbabwe.
    </p>
    <div class="flex flex-col sm:flex-row justify-center gap-4">
      <a href="<?= site_url('register') ?>" class="inline-flex items-center justify-center px-8 py-3 bg-blue-600 hover:bg-blue-500 text-white font-medium rounded-lg transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
        Get Started
        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
        </svg>
      </a>
    </div>
  </div>
  <!-- Bottom Gradient Fade -->
  <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-white to-transparent"></div>
</section>

<!-- Services Section -->
<section id="services" class="py-20 bg-gray-50">
  <div class="container mx-auto px-4">
    <div class="text-center mb-16" data-aos="fade-up">
      <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-4">Our Services</h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">
        Comprehensive business solutions tailored to your needs
      </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Service 1 -->
      <div class="group bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" 
           data-aos="fade-up" data-aos-delay="100">
        <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mb-6 mx-auto transition-all duration-300 group-hover:bg-blue-600 group-hover:text-white">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-3 text-center group-hover:text-blue-600 transition-colors duration-300">Company Registration</h3>
        <p class="text-gray-600 text-center">
          Fast and reliable company registration services to get your business up and running quickly with expert guidance.
        </p>
      </div>

      <!-- Service 2 -->
      <div class="group bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
           data-aos="fade-up" data-aos-delay="200">
        <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center text-green-600 mb-6 mx-auto transition-all duration-300 group-hover:bg-green-600 group-hover:text-white">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-3 text-center group-hover:text-green-600 transition-colors duration-300">Business Compliance</h3>
        <p class="text-gray-600 text-center">
          Stay compliant with all regulatory requirements through our comprehensive compliance services and expert guidance.
        </p>
      </div>

      <!-- Service 3 -->
      <div class="group bg-white p-8 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
           data-aos="fade-up" data-aos-delay="300">
        <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 mb-6 mx-auto transition-all duration-300 group-hover:bg-purple-600 group-hover:text-white">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-3 text-center group-hover:text-purple-600 transition-colors duration-300">Tax Advisory</h3>
        <p class="text-gray-600 text-center">
          Expert tax planning and advisory services to optimize your tax position and ensure full compliance with regulations.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- About Section -->
<section class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div data-aos="fade-up">
      <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-700 mb-6 transform transition-all duration-300 hover:scale-105 hover:shadow-sm">
        <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
        WHO WE ARE
      </div>
      <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6" data-aos="fade-up" data-aos-delay="100">
        Redefining Business Support in <span class="text-blue-600">Zimbabwe</span>
      </h2>
      <p class="text-xl text-gray-600 mb-8 leading-relaxed max-w-4xl" data-aos="fade-up" data-aos-delay="150">
        At Alpha Empire, we're not just service providers—we're your strategic partners in growth. Our team of highly qualified professionals is dedicated to helping businesses thrive through flexible, cost-effective solutions.
      </p>
    </div>
    
    <div class="grid md:grid-cols-2 gap-8 text-left">
      <!-- Agile Support -->
      <div class="group flex items-start space-x-4 p-6 rounded-xl hover:bg-gray-50 transition-all duration-300" 
           data-aos="fade-up" data-aos-delay="200">
        <div class="flex-shrink-0">
          <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
          </div>
        </div>
        <div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors duration-300">Agile Support</h3>
          <p class="text-gray-600">Get expert assistance precisely when you need it—no unnecessary overhead, just results.</p>
        </div>
      </div>
      
      <!-- Cost Efficiency -->
      <div class="group flex items-start space-x-4 p-6 rounded-xl hover:bg-gray-50 transition-all duration-300" 
           data-aos="fade-up" data-aos-delay="250">
        <div class="flex-shrink-0">
          <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-green-100 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1"></path>
            </svg>
          </div>
        </div>
      <div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Cost Efficiency</h3>
        <p class="text-gray-600">Maximize savings without the commitment of full-time hires.</p>
      </div>
    </div>
  </div>
</div>
      </div>
    </div>
  </div>
</section>

<!-- Vision & Mission Section -->
<section class="py-20 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16" data-aos="fade-up">
      <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">Our Vision & Mission</h2>
      <p class="mt-4 text-xl text-gray-600 max-w-3xl mx-auto">
        Guiding principles that drive our commitment to excellence and client success
      </p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
      <!-- Vision Card -->
      <div class="group bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
           data-aos="fade-right">
        <div class="p-8 h-full">
          <div class="flex flex-col h-full">
            <div class="flex items-center mb-6">
              <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                  <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                  </svg>
                </div>
              </div>
              <h3 class="ml-5 text-2xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300">Our Vision</h3>
            </div>
            <div class="flex-grow flex items-center">
              <p class="text-gray-600 leading-relaxed text-lg">
                To be the leading partner for businesses seeking smart, cost-efficient solutions by
                redefining professional support—delivering expertise on demand, driving sustainable
                growth, and empowering organizations to thrive without limits.
              </p>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Mission Card -->
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
           data-aos="fade-left" data-aos-delay="100">
        <div class="p-8">
          <div class="flex items-center mb-6">
            <div class="flex-shrink-0">
              <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-purple-50 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
              </div>
            </div>
            <h3 class="ml-5 text-2xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors duration-300">Our Mission</h3>
          </div>
          
          <div class="space-y-6">
            <!-- Mission Item 1 -->
            <div class="group flex items-start p-4 rounded-lg hover:bg-gray-50 transition-colors duration-300"
                 data-aos="fade-up" data-aos-delay="150">
              <div class="flex-shrink-0">
                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-green-100 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-4">
                <h4 class="text-lg font-semibold text-gray-900 group-hover:text-green-600 transition-colors duration-300">Deliver Expertise on Demand</h4>
                <p class="mt-1 text-gray-600">Provide businesses with professional, high-quality support precisely when needed, eliminating unnecessary overhead costs.</p>
              </div>
            </div>
            
            <!-- Mission Item 2 -->
            <div class="group flex items-start p-4 rounded-lg hover:bg-gray-50 transition-colors duration-300"
                 data-aos="fade-up" data-aos-delay="200">
              <div class="flex-shrink-0">
                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-4">
                <h4 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-300">Drive Sustainable Growth</h4>
                <p class="mt-1 text-gray-600">Empower clients to maximize efficiency, reduce costs, and achieve long-term success through innovative solutions.</p>
              </div>
            </div>
            
            <!-- Mission Item 3 -->
            <div class="group flex items-start p-4 rounded-lg hover:bg-gray-50 transition-colors duration-300"
                 data-aos="fade-up" data-aos-delay="250">
              <div class="flex-shrink-0">
                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-purple-100 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                  </svg>
                </div>
              </div>
              <div class="ml-4">
                <h4 class="text-lg font-semibold text-gray-900 group-hover:text-purple-600 transition-colors duration-300">Build Lasting Partnerships</h4>
                <p class="mt-1 text-gray-600">Foster trust and loyalty by offering reliable, flexible, and personalized services for every stage of business growth.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
      </div>
    </div>

<!-- Our Journey Section -->
<section class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16" data-aos="fade-up">
      <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-4">Our Journey</h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">
        Milestones that define our path to excellence and growth
      </p>
    </div>

    <div class="relative">
      <!-- Timeline Line -->
      <div class="hidden lg:block absolute left-1/2 h-full w-0.5 bg-gradient-to-b from-blue-500 to-purple-600 transform -translate-x-1/2"></div>
      
      <!-- Timeline Items -->
      <div class="space-y-12 lg:space-y-20">
        <!-- Growth & Expansion -->
        <div class="relative flex flex-col lg:flex-row items-center group" data-aos="fade-right">
          <div class="lg:w-1/2 lg:pr-12 lg:text-right mb-6 lg:mb-0" data-aos="fade-right">
            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-700 mb-3">
              <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
              2023 - PRESENT
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Growth & Expansion</h3>
            <p class="text-gray-600">
              Broadening our service portfolio by introducing Assurance Services and Legal Consultancy, 
              providing SMEs with a full spectrum of professional support.
            </p>
          </div>
          <div class="lg:w-1/2 lg:pl-12 flex justify-center lg:justify-start" data-aos="fade-left" data-aos-delay="200">
            <div class="w-20 h-20 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
              <i class="fas fa-chart-line text-3xl"></i>
            </div>
          </div>
        </div>

        <!-- Future Goals -->
        <div class="relative flex flex-col lg:flex-row-reverse items-center group" data-aos="fade-left">
          <div class="lg:w-1/2 lg:pl-12 mb-6 lg:mb-0" data-aos="fade-left">
            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-purple-100 text-purple-700 mb-3">
              <span class="w-2 h-2 rounded-full bg-purple-500 mr-2"></span>
              NEXT STEPS
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Future Goals</h3>
            <p class="text-gray-600">
              Expanding our impact to 900 SMEs and launching a tailored ERP software designed 
              to meet the unique needs of small and medium enterprises.
            </p>
          </div>
          <div class="lg:w-1/2 lg:pr-12 flex justify-center lg:justify-end" data-aos="fade-right" data-aos-delay="200">
            <div class="w-20 h-20 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
              <i class="fas fa-bullseye text-3xl"></i>
            </div>
          </div>
        </div>
      </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</section>

<!-- How It Works Section -->
<section class="py-20 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16" data-aos="fade-up">
      <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-4">How It Works</h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">
        Simple, transparent steps to register your company with confidence
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Step 1 -->
      <div class="group relative bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
           data-aos="fade-up" data-aos-delay="100">
        <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl font-bold group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
          1
        </div>
        <div class="text-center pt-6">
          <div class="w-20 h-20 mx-auto mb-6 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:bg-blue-100 transition-colors duration-300">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors duration-300">Submit Details</h3>
          <p class="text-gray-600">Fill out our simple online form with your company details. Our secure platform ensures your information is protected.</p>
          <div class="mt-6">
              <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
</svg>
          </div>
        </div>
      </div>

      <!-- Step 2 -->
      <div class="group relative bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
           data-aos="fade-up" data-aos-delay="200">
        <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-xl font-bold group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
          2
        </div>
        <div class="text-center pt-6">
          <div class="w-20 h-20 mx-auto mb-6 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 group-hover:bg-green-100 transition-colors duration-300">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors duration-300">Document Review</h3>
          <p class="text-gray-600">Our experienced team carefully reviews your application and prepares all necessary documents with precision.</p>
          <div class="mt-6">
            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </div>
        </div>
      </div>

      <!-- Step 3 -->
      <div class="group relative bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2"
           data-aos="fade-up" data-aos-delay="300">
        <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-xl font-bold group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
          3
        </div>
        <div class="text-center pt-6">
          <div class="w-20 h-20 mx-auto mb-6 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 group-hover:bg-purple-100 transition-colors duration-300">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-purple-600 transition-colors duration-300">Company Registered</h3>
          <p class="text-gray-600">Receive your official registration documents and get ready to launch your business with our ongoing support.</p>
          <div class="mt-6">
            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-16 text-center" data-aos="fade-up" data-aos-delay="400">
      <a href="<?= site_url('frontend/apply') ?>" class="inline-flex items-center px-8 py-4 border-2 border-white text-base font-bold rounded-full text-white relative overflow-hidden group">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-90 group-hover:opacity-100 transition-opacity duration-300" style="background-image: url('<?= base_url('assets/img/Picture1.jpg') ?>');"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 opacity-80 group-hover:opacity-90 transition-opacity duration-300"></div>
        <span class="relative z-10">Start Your Registration Now</span>
        <svg class="ml-2 -mr-1 w-5 h-5 relative z-10" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
      </a>
    </div>
  </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-20 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16" data-aos="fade-up">
      <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl mb-4">Get In Touch</h2>
      <p class="text-xl text-gray-600 max-w-3xl mx-auto">
        We're here to help and answer any questions you might have. Reach out to us through any of these channels.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
      <!-- Email -->
      <a href="mailto:admin@alphaempire.co.zw" class="group bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100" data-aos="fade-up" data-aos-delay="100">
        <div class="w-16 h-16 mb-6 mx-auto bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:bg-blue-100 transition-colors duration-300">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 text-center mb-2 group-hover:text-blue-600 transition-colors duration-300">Email Us</h3>
        <p class="text-gray-600 text-center">admin@alphaempire.co.zw</p>
      </a>

      <!-- Phone -->
      <a href="tel:+263776136070" class="group bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100" data-aos="fade-up" data-aos-delay="150">
        <div class="w-16 h-16 mb-6 mx-auto bg-green-50 rounded-2xl flex items-center justify-center text-green-600 group-hover:bg-green-100 transition-colors duration-300">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 text-center mb-2 group-hover:text-green-600 transition-colors duration-300">Call Us</h3>
        <p class="text-gray-600 text-center">+263 776 136 070</p>
      </a>

      <!-- Website -->
      <a href="https://www.alphaempire.co.zw" target="_blank" class="group bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100" data-aos="fade-up" data-aos-delay="200">
        <div class="w-16 h-16 mb-6 mx-auto bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 group-hover:bg-purple-100 transition-colors duration-300">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 text-center mb-2 group-hover:text-purple-600 transition-colors duration-300">Visit Website</h3>
        <p class="text-gray-600 text-center">www.alphaempire.co.zw</p>
      </a>

      <!-- Location -->
      <div class="group bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border border-gray-100" data-aos="fade-up" data-aos-delay="250">
        <div class="w-16 h-16 mb-6 mx-auto bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 group-hover:bg-amber-100 transition-colors duration-300">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 text-center mb-2 group-hover:text-amber-600 transition-colors duration-300">Our Location</h3>
        <p class="text-gray-600 text-center">ST 248 SOUTHERTON, HARARE</p>
      </div>
    </div>

    <div class="mt-16 text-center" data-aos="fade-up" data-aos-delay="300">
      <h3 class="text-2xl font-bold text-gray-900 mb-6">Business Hours</h3>
      <p class="text-gray-600 text-lg">Monday - Friday: 8:00 AM - 5:00 PM</p>
      <p class="text-gray-600 text-lg">Saturday: 9:00 AM - 1:00 PM</p>
      <p class="text-gray-600 text-lg">Sunday: Closed</p>
    </div>
  </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Initialize contact form submission
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      // Add form submission logic here
      alert('Thank you for your message. We will get back to you soon!');
      contactForm.reset();
    });
  }
});
</script>
<?= $this->endSection() ?>
