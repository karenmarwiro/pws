<?php 
$user = $user ?? session()->get('user');
// Ensure $user is an array for consistent access
if (is_object($user)) {
    $user = (array) $user;
}
?>

<?= $this->extend('App\Modules\Frontend\Views\Layouts\default') ?>

<?= $this->section('title') ?>User Dashboard | Alpha Empire<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<!-- Add Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<style>
    /* Ensure the main content takes full height and pushes footer down */
    .main-content {
        flex: 1 0 auto;
        width: 100%;
    }
    
    /* Fix for the sticky footer */
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    
    /* Ensure the toast appears above other content */
    .toast-container {
        z-index: 9999;
    }
    
    /* Custom styles that can't be easily done with Tailwind */
    .user-profile::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml;utf8,<svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h100v100H0z" fill="none"/><path d="M30 10L10 30M90 10L70 30M10 70l20 20M90 70l-20 20" stroke="rgba(255,255,255,0.1)" stroke-width="2" stroke-linecap="round"/></svg>');
        opacity: 0.5;
        pointer-events: none;
    }
    
    .progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, 
            rgba(255,255,255,0.8) 0%, 
            rgba(255,255,255,0.4) 50%, 
            rgba(255,255,255,0.8) 100%);
        background-size: 200px 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 0.25rem;
    }
    
    @keyframes shimmer {
        0% { background-position: -200px 0; }
        100% { background-position: calc(200px + 100%) 0; }
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
<script>
    tailwind.config = {
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

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="main-content">
    <div class="container mx-auto px-4 py-8 flex-grow">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar -->
        <div class="w-full lg:w-72 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-custom overflow-hidden sticky top-24 transition-all duration-300">
                <!-- User Profile -->
                <div class="user-profile relative">
                    <div class="relative z-10">
                        <img src="<?= $user['profile_photo'] ?? 'https://ui-avatars.com/api/?name=' . urlencode(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')) . '&background=1b12cd&color=fff&size=200' ?>" 
                             alt="Profile Photo" 
                             class="w-24 h-24 rounded-full border-4 border-white/30 shadow-md mx-auto mb-4 transition-transform duration-300 hover:scale-105" 
                             id="profilePreview">
                        <h3 class="text-xl font-semibold text-white text-center"><?= esc($user['first_name'] ?? 'User') ?> <?= esc($user['last_name'] ?? '') ?></h3>
                        <p class="text-white/80 text-sm text-center"><?= esc($user['email'] ?? '') ?></p>
                        
                        <!-- Profile Completion -->
                        <?php
                        $profileFields = ['first_name', 'last_name', 'email', 'phone', 'id_number', 'date_of_birth', 'gender', 'country', 'city', 'address_line1', 'postal_code', 'profile_photo'];
                        $completedFields = 0;
                        
                        foreach ($profileFields as $field) {
                            if (!empty($user[$field])) {
                                $completedFields++;
                            }
                        }
                        
                        $completionPercentage = round(($completedFields / count($profileFields)) * 100);
                        ?>
                        <div class="mt-4 px-4">
                            <div class="flex justify-between text-xs text-white/80 mb-1">
                                <span>Profile Complete</span>
                                <span><?= $completionPercentage ?>%</span>
                            </div>
                            <div class="w-full bg-white/20 rounded-full h-2">
                                <div class="bg-white h-2 rounded-full progress-bar" style="width: <?= $completionPercentage ?>%; position: relative;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation -->
                <nav class="p-4">
                    <ul class="space-y-1">
                        <li>
                            <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-primary/10 text-primary">
                                <i class="fas fa-tachometer-alt w-5 mr-3 text-center"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('frontend/profile') ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-100 hover:text-primary">
                                <i class="fas fa-user w-5 mr-3 text-center"></i>
                                My Profile
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('frontend/applications') ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-100 hover:text-primary">
                                <i class="fas fa-file-alt w-5 mr-3 text-center"></i>
                                My Applications
                            </a>
                        </li>
                        <li class="mt-4 pt-4 border-t border-gray-100">
                            <a href="<?= site_url('logout') ?>" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt w-5 mr-3 text-center"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Overview</h2>
            
            <!-- Welcome Card -->
            <div class="bg-white rounded-xl shadow-custom overflow-hidden mb-6 transition-all duration-300 hover:shadow-custom-hover">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div class="mb-4 md:mb-0">
                            <div class="flex items-center">
                                <h3 class="text-lg font-semibold text-gray-800">Welcome back, <?= esc($user['first_name'] ?? 'User') ?>!</h3>
                                <label for="profile_photo" class="ml-3 cursor-pointer p-2 bg-primary/10 text-primary rounded-full hover:bg-primary/20 transition-colors">
                                    <i class="fas fa-camera"></i>
                                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="hidden">
                                </label>
                            </div>
                            <p class="text-gray-500">Here's what's happening with your account today.</p>
                        </div>
                        <a href="<?= site_url('frontend/apply') ?>" class="inline-flex items-center px-4 py-2.5 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primary-dark transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            New Application
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Applications -->
                <div class="bg-white rounded-xl shadow-custom p-6 transition-all duration-300 hover:shadow-custom-hover border-l-4 border-primary">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Applications</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= $stats['total_applications'] ?? 0 ?></h3>
                        </div>
                        <div class="p-3 bg-primary/10 rounded-lg text-primary">
                            <i class="fas fa-file-alt text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Active Applications -->
                <div class="bg-white rounded-xl shadow-custom p-6 transition-all duration-300 hover:shadow-custom-hover border-l-4 border-secondary">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Active Applications</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= $stats['active_applications'] ?? 0 ?></h3>
                        </div>
                        <div class="p-3 bg-secondary/10 rounded-lg text-secondary">
                            <i class="fas fa-spinner text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Approved Applications -->
                <div class="bg-white rounded-xl shadow-custom p-6 transition-all duration-300 hover:shadow-custom-hover border-l-4 border-success">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Approved</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= $stats['approved_applications'] ?? 0 ?></h3>
                        </div>
                        <div class="p-3 bg-success/10 rounded-lg text-success">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Pending Review -->
                <div class="bg-white rounded-xl shadow-custom p-6 transition-all duration-300 hover:shadow-custom-hover border-l-4 border-yellow-400">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pending Review</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= $stats['pending_review'] ?? 0 ?></h3>
                        </div>
                        <div class="p-3 bg-yellow-400/10 rounded-lg text-yellow-400">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Completed -->
                <div class="bg-white rounded-xl shadow-custom p-6 transition-all duration-300 hover:shadow-custom-hover border-l-4 border-green-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Completed</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">5</h3>
                        </div>
                        <div class="p-3 bg-green-500/10 rounded-lg text-green-500">
                            <i class="fas fa-check-double text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <!-- In Progress -->
                <div class="bg-white rounded-xl shadow-custom p-6 transition-all duration-300 hover:shadow-custom-hover border-l-4 border-blue-500">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">In Progress</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">2</h3>
                        </div>
                        <div class="p-3 bg-blue-500/10 rounded-lg text-blue-500">
                            <i class="fas fa-sync-alt text-xl animate-spin"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-custom overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
                </div>
                <div class="p-6">
                    <?php if (empty($recent_activities)): ?>
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No recent activity to display</p>
                        </div>
                    <?php else: ?>
                        <div class="space-y-6">
                            <?php foreach ($recent_activities as $activity): 
                                // Determine icon and color based on activity type
                                $icon = 'fa-file-alt';
                                $color = 'blue-500';
                                
                                switch ($activity['type']) {
                                    case 'approved':
                                        $icon = 'fa-check-circle';
                                        $color = 'green-500';
                                        break;
                                    case 'pending':
                                        $icon = 'fa-clock';
                                        $color = 'yellow-500';
                                        break;
                                    case 'submitted':
                                        $icon = 'fa-paper-plane';
                                        $color = 'blue-500';
                                        break;
                                    case 'info':
                                    default:
                                        $icon = 'fa-info-circle';
                                        $color = 'blue-500';
                                }
                                
                                // Format the date
                                $date = new DateTime($activity['date']);
                                $now = new DateTime();
                                $interval = $now->diff($date);
                                
                                if ($interval->y > 0) {
                                    $timeAgo = $interval->y . ' year' . ($interval->y > 1 ? 's' : '') . ' ago';
                                } elseif ($interval->m > 0) {
                                    $timeAgo = $interval->m . ' month' . ($interval->m > 1 ? 's' : '') . ' ago';
                                } elseif ($interval->d > 0) {
                                    $timeAgo = $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
                                } elseif ($interval->h > 0) {
                                    $timeAgo = $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
                                } elseif ($interval->i > 0) {
                                    $timeAgo = $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
                                } else {
                                    $timeAgo = 'Just now';
                                }
                            ?>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="h-2.5 w-2.5 rounded-full bg-<?= $color ?> relative">
                                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 h-3 w-3 rounded-full bg-<?= $color ?> opacity-20"></div>
                                    </div>
                                    <div class="h-full w-0.5 bg-gray-200 ml-1 my-1"></div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between items-start">
                                        <h4 class="text-sm font-medium text-gray-900"><?= esc($activity['title']) ?></h4>
                                        <span class="text-xs text-gray-500"><?= $timeAgo ?></span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1"><?= esc($activity['description']) ?></p>
                                    <?php if (!empty($activity['reference']) && $activity['reference'] !== 'Welcome'): ?>
                                        <div class="mt-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <i class="fas fa-hashtag text-gray-400 mr-1"></i>
                                                <?= esc($activity['reference']) ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>



<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-tooltip]'));
        tooltipTriggerList.forEach(tooltipTriggerEl => {
            const tooltipText = tooltipTriggerEl.getAttribute('data-tooltip');
            const tooltip = document.createElement('div');
            tooltip.className = 'hidden bg-gray-900 text-white text-xs rounded py-1 px-2 absolute z-50 whitespace-nowrap';
            tooltip.textContent = tooltipText;
            document.body.appendChild(tooltip);
            
            tooltipTriggerEl.addEventListener('mouseenter', () => {
                const rect = tooltipTriggerEl.getBoundingClientRect();
                tooltip.style.top = `${rect.top - tooltip.offsetHeight - 5}px`;
                tooltip.style.left = `${rect.left + (rect.width - tooltip.offsetWidth) / 2}px`;
                tooltip.classList.remove('hidden');
            });
            
            tooltipTriggerEl.addEventListener('mouseleave', () => {
                tooltip.classList.add('hidden');
            });
        });

        // Profile photo upload preview
        const profilePhotoInput = document.getElementById('profile_photo');
        if (profilePhotoInput) {
            profilePhotoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const preview = document.getElementById('profilePreview');
                        if (preview) {
                            preview.src = event.target.result;
                            // Show success message
                            const toast = document.getElementById('photoUploadToast');
                            toast.classList.remove('hidden');
                            setTimeout(() => {
                                toast.classList.add('hidden');
                            }, 3000);
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>

<?= $this->endSection() ?>