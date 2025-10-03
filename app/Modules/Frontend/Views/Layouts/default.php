<?php 
$validation = $validation ?? \Config\Services::validation();
$user = $user ?? session()->get('user');
// Ensure $user is an array for consistent access
if (is_object($user)) {
    $user = (array) $user;
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Alpha Empire') ?></title>
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: { preflight: false },
            theme: {
                extend: {
                    colors: {
                        primary: '#1b12cd',
                        'primary-light': '#e0e7ff',
                        'primary-dark': '#1b12cd',
                        secondary: '#f59e0b',
                        dark: '#1e293b',
                        gray: '#64748b',
                        light: '#f8fafc',
                        'light-gray': '#f1f5f9',
                        success: '#10b981',
                        danger: '#ef4444',
                    },
                    borderRadius: {
                        'custom': '0.5rem',
                    },
                    boxShadow: {
                        'custom': '0 1px 3px rgba(0, 0, 0, 0.1)',
                        'custom-hover': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
            color: #111827;
        }
        
        /* Ensure navbar items are visible */
        .navbar-nav .nav-link {
            color: var(--dark) !important;
            opacity: 1 !important;
            visibility: visible !important;
            display: block !important;
        }
        
        .navbar .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        
        .navbar-collapse {
            z-index: 10000 !important;
        }
        .navbar.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .navbar-brand img {
            transition: all 0.3s ease;
            height: 36px;
        }
        .navbar.scrolled .navbar-brand {
            font-size: 1.3rem;
        }
        .navbar.scrolled .navbar-brand img {
            height: 32px;
        }
        .nav-link {
            color: var(--dark) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: var(--primary);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 60%;
        }
        .nav-link:hover,
        .nav-link.active {
            color: var(--primary) !important;
        }
        .btn-register {
            background: linear-gradient(135deg, var(--primary), #1d4ed8);
            border: none;
            padding: 0.5rem 1.25rem !important;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
        }
        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
        }
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        .dropdown-item {
            padding: 0.5rem 1.25rem;
            font-weight: 400;
            color: var(--dark);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }
        .dropdown-item i {
            width: 20px;
            margin-right: 0.75rem;
            color: var(--gray);
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: var(--primary);
        }
        .dropdown-item:hover i {
            color: var(--primary);
        }
        .dropdown-divider {
            margin: 0.25rem 0;
            border-color: #f1f5f9;
        }
        .navbar-toggler {
            border: none !important;
            padding: 0.5rem !important;
            font-size: 1.25rem !important;
            z-index: 10001 !important;
        }
        .navbar-toggler:focus {
            box-shadow: none !important;
            outline: none !important;
        }
        
        /* Ensure navbar items are visible */
        .navbar-nav {
            z-index: 10000 !important;
            position: relative;
        }
        
        /* Let Bootstrap control collapse visibility via its own breakpoints */
        
        .navbar-collapse.collapse.show {
            display: flex !important;
            flex-basis: 100% !important;
            flex-grow: 1 !important;
            align-items: center !important;
            background: white !important;
            padding: 1rem !important;
            margin-top: 0.5rem !important;
            border-radius: 0.5rem !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
            opacity: 1 !important;
            visibility: visible !important;
            height: auto !important;
            overflow: visible !important;
        }
        
        @media (max-width: 991.98px) {
            .navbar-collapse {
                position: absolute !important;
                top: 100% !important;
                left: 0 !important;
                right: 0 !important;
                padding: 1rem !important;
                background: white !important;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
                display: block !important;
                opacity: 1 !important;
                visibility: visible !important;
                height: auto !important;
                overflow: visible !important;
            }
        }
        footer {
            background-color: var(--dark);
            color: white;
            padding: 40px 0;
            margin-top: 60px;
        }
        .footer-links a {
            color: #e2e8f0;
            text-decoration: none;
            display: block;
            margin-bottom: 8px;
        }
        .footer-links a:hover {
            color: white;
            text-decoration: underline;
        }
        .social-icons a {
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
        }
    </style>
    <?= $this->renderSection('styles') ?>
    <style>
        :root {
            --primary: rgb(27, 18, 205);
            --primary-light: #e0e7ff;
            --primary-dark: rgb(27, 18, 205);
            --secondary: #f59e0b;
            --dark: #1e293b;
            --gray: #64748b;
            --light: #f8f9fa;
            --light-gray: #e9ecef;
            --success: #10b981;
            --danger: #ef4444;
            --border-radius: 0.5rem;
        }
        
        body {
            background-color: #f9fafb;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            line-height: 1.6;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a href="<?= base_url('/frontend') ?>" class="navbar-brand">
                    <img src="<?= base_url('assets/img/Picture1.jpg') ?>" alt="Alpha Empire Logo">
                    <span>Alpha Empire</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="z-index: 10001;">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() === base_url('/frontend') ? 'active' : '' ?>" href="<?= base_url('/frontend') ?>">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() === base_url('frontend/apply') ? 'active' : '' ?>" href="<?= base_url('frontend/apply') ?>">
                                Apply
                            </a>
                        </li>
                        <?php if (session()->has('user')): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= current_url() === site_url('frontend/dashboard') ? 'active' : '' ?>" href="<?= site_url('frontend/dashboard') ?>">
                                Dashboard
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                    <ul class="navbar-nav align-items-lg-center">
                        <?php if (session()->has('user')): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center px-3" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    
                                    <span class="d-none d-lg-inline"><?= esc($user['first_name'] ?? 'User') ?></span>
                                    <i class="fas fa-chevron-down ms-1 d-none d-lg-inline" style="font-size: 0.8rem; opacity: 0.7;"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('frontend/profile') ?>">
                                            <i class="fas fa-user"></i> Profile
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item me-2">
                                <a class="nav-link px-3" href="<?= base_url('login') ?>">
                                    Sign In
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary btn-register" href="<?= base_url('register') ?>">
                                    Get Started <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
    <script>
        // Add scroll effect to navbar
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('scrolled');
            } else {
                document.querySelector('.navbar').classList.remove('scrolled');
            }
        });
        
        // Initialize navbar state on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('scrolled');
            }
        });
    </script>

    <!-- Main Content -->
    <main class="flex-grow-1 py-4" style="margin-top: 76px; position: relative; z-index: 1;">
        <div class="container">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8 mt-auto w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <!-- Branding -->
                <div class="flex items-center space-x-3 mb-6 md:mb-0">
                    <img src="<?= base_url('assets/img/Picture1.jpg') ?>" alt="Alpha Empire Logo" class="h-8">
                    <span class="text-xl font-bold text-white">Alpha <span class="text-blue-500">Empire</span></span>
                </div>

                <!-- Contact Info -->
                <div class="grid grid-cols-2 gap-6 text-sm">
                    <a href="mailto:admin@alphaempire.co.zw" class="flex items-center text-gray-400 hover:text-white transition-colors">
                        <svg class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Email Us
                    </a>
                    <a href="tel:+263776136070" class="flex items-center text-gray-400 hover:text-white transition-colors">
                        <svg class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        +263 776 136 070
                    </a>
                </div>

                <!-- Social Links -->
                <div class="flex space-x-4 mt-6 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors" aria-label="Facebook">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors" aria-label="Twitter">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors" aria-label="LinkedIn">
                        <span class="sr-only">LinkedIn</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="mt-8 pt-6 border-t border-gray-800 text-center text-gray-500 text-xs">
                <p>&copy; <?= date('Y') ?> Alpha Empire. All rights reserved.</p>
                <div class="mt-2 space-x-4">
                    <a href="#" class="hover:text-white transition-colors">Privacy</a>
                    <span>•</span>
                    <a href="#" class="hover:text-white transition-colors">Terms</a>
                    <span>•</span>
                    <a href="#" class="hover:text-white transition-colors">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <?= $this->renderSection('scripts') ?>
    
    <!-- Bootstrap 5 JS Bundle (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS with custom settings
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                mirror: false
            });
            
            // Initialize Bootstrap tooltips and popovers
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            // Bootstrap handles navbar toggling via data attributes; no custom JS needed
        });
    </script>
</body>
</html>
