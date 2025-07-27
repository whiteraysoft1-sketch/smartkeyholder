<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food & Hospitality vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <meta name="msapplication-TileColor" content="#dc2626">
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
    @endif
    
    <style>
        /* Apple-inspired Food & Hospitality Design */
        @import url('https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', Roboto, sans-serif;
        }
        
        .food-gradient {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 50%, #f59e0b 100%);
            position: relative;
            min-height: 100vh;
        }
        .food-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 20%, rgba(239, 68, 68, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(245, 158, 11, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 40% 40%, rgba(34, 197, 94, 0.1) 0%, transparent 50%);
            animation: food-gradient-shift 10s ease-in-out infinite;
        }
        @keyframes food-gradient-shift {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }
        .food-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12), 
                        0 2px 8px rgba(0, 0, 0, 0.08),
                        inset 0 1px 0 rgba(255, 255, 255, 0.9);
            overflow: hidden;
            position: relative;
            backdrop-filter: blur(40px) saturate(180%);
            border: 0.5px solid rgba(255, 255, 255, 0.8);
        }
        .chef-badge {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: #fff;
            animation: chef-pulse 4s ease-in-out infinite;
            box-shadow: 0 4px 20px rgba(220, 38, 38, 0.3);
            font-weight: 600;
            letter-spacing: -0.02em;
        }
        @keyframes chef-pulse {
            0%, 100% { 
                transform: scale(1);
                box-shadow: 0 4px 20px rgba(220, 38, 38, 0.3);
            }
            50% { 
                transform: scale(1.02);
                box-shadow: 0 8px 32px rgba(220, 38, 38, 0.4);
            }
        }
        .chef-glow {
            animation: chef-glow 6s ease-in-out infinite;
        }
        @keyframes chef-glow {
            0%, 100% { 
                box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.2),
                           0 8px 32px rgba(0, 0, 0, 0.12);
            }
            50% { 
                box-shadow: 0 0 0 8px rgba(220, 38, 38, 0),
                           0 12px 40px rgba(0, 0, 0, 0.16);
            }
        }
        .contact-item {
            background: rgba(255, 255, 255, 0.8);
            border: 0.5px solid rgba(0, 0, 0, 0.04);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            backdrop-filter: blur(20px) saturate(180%);
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06),
                        inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }
        .contact-item:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12),
                        inset 0 1px 0 rgba(255, 255, 255, 0.9);
            border-color: rgba(220, 38, 38, 0.2);
        }
        .service-card {
            background: rgba(255, 255, 255, 0.7);
            border: 0.5px solid rgba(0, 0, 0, 0.04);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06),
                        inset 0 1px 0 rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px) saturate(180%);
        }
        .service-card:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15),
                        inset 0 1px 0 rgba(255, 255, 255, 0.9);
            background: rgba(255, 255, 255, 0.85);
            border-color: rgba(220, 38, 38, 0.15);
        }
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .social-icon {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            box-shadow: 0 4px 20px rgba(220, 38, 38, 0.25),
                        inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }
        .social-icon:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            transform: translateY(-3px) scale(1.08);
            box-shadow: 0 8px 32px rgba(220, 38, 38, 0.35),
                        inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        .food-banner {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, #dc2626 0%, #f59e0b 25%, #22c55e 50%, #3b82f6 75%, #8b5cf6 100%);
            z-index: 1;
            animation: food-banner-flow 8s ease-in-out infinite;
        }
        @keyframes food-banner-flow {
            0% { opacity: 0.8; background-position: 0% 50%; }
            50% { opacity: 1; background-position: 100% 50%; }
            100% { opacity: 0.8; background-position: 200% 50%; }
        }
        .profile-img-shadow {
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.15), 
                        0 0 0 3px rgba(255, 255, 255, 0.9),
                        0 0 0 4px rgba(220, 38, 38, 0.2);
        }
        .divider {
            border: none;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, rgba(0, 0, 0, 0.08) 50%, transparent 100%);
            margin: 2rem 0 1.5rem 0;
        }
        .gallery-thumb {
            border: 2px solid rgba(220, 38, 38, 0.2);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        .gallery-thumb:hover {
            transform: scale(1.05);
            z-index: 2;
            border-color: rgba(220, 38, 38, 0.4);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }
        .profile-overlap {
            position: absolute;
            left: 50%;
            transform: translateX(-50%) translateY(15px);
            top: 0;
            z-index: 10;
        }
        .header-spacer {
            height: 4rem;
        }
        .menu-items {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        .menu-item {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 16px;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08),
                        inset 0 1px 0 rgba(255, 255, 255, 0.8);
            border: 0.5px solid rgba(0, 0, 0, 0.04);
            backdrop-filter: blur(20px) saturate(180%);
        }
        .menu-item:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12),
                        inset 0 1px 0 rgba(255, 255, 255, 0.9);
            background: rgba(255, 255, 255, 0.9);
        }
        .stats-card {
            background: rgba(255, 255, 255, 0.7);
            border: 0.5px solid rgba(0, 0, 0, 0.04);
            backdrop-filter: blur(20px) saturate(180%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08),
                        inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }
        .action-btn-primary {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            box-shadow: 0 4px 20px rgba(220, 38, 38, 0.3),
                        inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            font-weight: 600;
            letter-spacing: -0.02em;
        }
        .action-btn-primary:hover {
            background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 32px rgba(220, 38, 38, 0.4),
                        inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        .action-btn-secondary {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            box-shadow: 0 4px 20px rgba(245, 158, 11, 0.3),
                        inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            font-weight: 600;
            letter-spacing: -0.02em;
        }
        .action-btn-secondary:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 32px rgba(245, 158, 11, 0.4),
                        inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        .action-btn-gradient {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            box-shadow: 0 4px 20px rgba(34, 197, 94, 0.3),
                        inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            font-weight: 600;
            letter-spacing: -0.02em;
        }
        .action-btn-gradient:hover {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 32px rgba(34, 197, 94, 0.4),
                        inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        
        /* Enhanced Animations */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-slide-in-left {
            animation: slideInLeft 0.6s ease-out;
        }
        
        .animate-slide-in-right {
            animation: slideInRight 0.6s ease-out;
        }
        
        .animate-slide-up {
            animation: slideInUp 0.6s ease-out;
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Loading state */
        body:not(.loaded) * {
            animation-play-state: paused;
        }
        
        body.loaded * {
            animation-play-state: running;
        }
        
        /* Enhanced hover effects */
        .contact-item:hover .fas {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }
        
        .service-card:hover .fas {
            transform: scale(1.1) rotate(5deg);
            transition: transform 0.3s ease;
        }
        
        .menu-item:hover .fas {
            transform: scale(1.2);
            transition: transform 0.3s ease;
        }
        
        /* Pulse effect for important buttons */
        .action-btn-primary {
            position: relative;
            overflow: hidden;
        }
        
        .action-btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .action-btn-primary:hover::before {
            left: 100%;
        }
    </style>
</head>
<body class="food-gradient min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="food-card overflow-hidden relative">
            <div class="food-banner"></div>
            <!-- Background Photo -->
            @if($profile->background_image)
            <div class="w-full h-32 md:h-40 bg-cover bg-center relative" style="background-image: url('{{ $profile->background_image_url }}');">
                <div class="absolute inset-0 bg-gradient-to-t from-red-800/80 to-transparent"></div>
                <!-- Profile Image Overlapping -->
                <div class="profile-overlap">
                    <div class="w-36 h-36 rounded-full bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 p-1 chef-glow profile-img-shadow">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'Chef') . '&background=dc2626&color=fff&size=144' }}" 
                             class="w-full h-full rounded-full object-cover border-4 border-white" 
                             alt="Profile Photo">
                        <!-- Chef Badge -->
                        <div class="absolute -bottom-2 -right-2 chef-badge rounded-full w-12 h-12 flex items-center justify-center text-xl border-4 border-white">
                            <i class="fas fa-utensils"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-spacer"></div>
            @else
            <!-- If no background, show profile image in normal flow -->
            <div class="relative flex justify-center mt-8 mb-2">
                <div class="w-36 h-36 rounded-full bg-gradient-to-br from-red-500 via-orange-500 to-yellow-500 p-1 chef-glow profile-img-shadow relative">
                    <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'Chef') . '&background=dc2626&color=fff&size=144' }}" 
                         class="w-full h-full rounded-full object-cover border-4 border-white" 
                         alt="Profile Photo">
                    <div class="absolute -bottom-2 -right-2 chef-badge rounded-full w-12 h-12 flex items-center justify-center text-xl border-4 border-white">
                        <i class="fas fa-utensils"></i>
                    </div>
                </div>
            </div>
            @endif
            <!-- Header Section -->
            <div class="relative px-6 pt-4 pb-6 text-center z-10">
                <!-- Name & Title -->
                <h1 class="text-3xl font-bold text-gray-900 mb-2 tracking-tight" style="font-weight: 700; letter-spacing: -0.025em;">
                    {{ $profile->display_name ?? $user->name ?? 'Chef' }}
                </h1>
                <p class="text-gray-600 font-medium text-lg mb-4 tracking-tight" style="font-weight: 500; letter-spacing: -0.01em;">
                    {{ $profile->profession ?? 'Food & Hospitality' }}
                </p>
                <!-- Call and Email Action Buttons -->
                <div class="flex items-center justify-center space-x-4 mb-4">
                    @if($profile->phone)
                    <a href="tel:{{ $profile->phone }}" 
                       class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-full font-semibold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fas fa-phone mr-2"></i>
                        Call
                    </a>
                    @endif
                    
                    @if($profile->email ?? $user->email)
                    <a href="mailto:{{ $profile->email ?? $user->email }}" 
                       class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-full font-semibold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fas fa-envelope mr-2"></i>
                        Email
                    </a>
                    @endif
                </div>
                
                @if($profile->location ?? null)
                <div class="flex items-center justify-center text-gray-500 text-sm mb-6">
                    <i class="fas fa-location-dot text-gray-400 mr-2"></i>
                    <span class="font-medium">{{ $profile->location }}</span>
                </div>
                @endif
                <div class="flex justify-center gap-2 mb-6">
                    <div class="chef-badge px-3 py-1.5 rounded-full text-xs font-semibold">
                        <i class="fas fa-award mr-1.5"></i>
                        Certified Chef
                    </div>
                    <div class="bg-gradient-to-r from-orange-500 to-yellow-600 text-white px-3 py-1.5 rounded-full text-xs font-semibold shadow-lg">
                        <i class="fas fa-star mr-1.5"></i>
                        Premium
                    </div>
                </div>
            </div>
            <div class="divider"></div>
            <!-- Services Section (Bio + Food Services) -->
            <div class="px-6 py-4">
                @if($profile->bio)
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 mb-3 flex items-center text-lg tracking-tight" style="font-weight: 600; letter-spacing: -0.015em;">
                        <i class="fas fa-info-circle text-gray-600 mr-3 text-lg"></i>
                        About Us
                    </h3>
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $profile->bio }}</p>
                </div>
                @endif
                
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center text-lg tracking-tight" style="font-weight: 600; letter-spacing: -0.015em;">
                    <i class="fas fa-concierge-bell text-gray-600 mr-3 text-lg"></i>
                    Our Services
                </h3>
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <div class="service-card p-4 rounded-2xl text-center">
                        <i class="fas fa-utensils text-2xl text-red-600 mb-2"></i>
                        <h4 class="font-semibold text-gray-800 text-sm mb-1">Fine Dining</h4>
                        <p class="text-xs text-gray-600">Exquisite Cuisine</p>
                    </div>
                    <div class="service-card p-4 rounded-2xl text-center">
                        <i class="fas fa-birthday-cake text-2xl text-orange-600 mb-2"></i>
                        <h4 class="font-semibold text-gray-800 text-sm mb-1">Catering</h4>
                        <p class="text-xs text-gray-600">Event Services</p>
                    </div>
                    <div class="service-card p-4 rounded-2xl text-center">
                        <i class="fas fa-coffee text-2xl text-yellow-600 mb-2"></i>
                        <h4 class="font-semibold text-gray-800 text-sm mb-1">Café</h4>
                        <p class="text-xs text-gray-600">Coffee & Pastries</p>
                    </div>
                    <div class="service-card p-4 rounded-2xl text-center">
                        <i class="fas fa-wine-glass text-2xl text-purple-600 mb-2"></i>
                        <h4 class="font-semibold text-gray-800 text-sm mb-1">Bar</h4>
                        <p class="text-xs text-gray-600">Craft Cocktails</p>
                    </div>
                </div>
            </div>
            
            <!-- Menu Highlights -->
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center text-lg tracking-tight" style="font-weight: 600; letter-spacing: -0.015em;">
                    <i class="fas fa-clipboard-list text-gray-600 mr-3 text-lg"></i>
                    Menu Highlights
                </h3>
                <div class="menu-items">
                    <div class="menu-item fade-in">
                        <i class="fas fa-hamburger text-2xl text-red-600 mb-2"></i>
                        <h4 class="font-semibold text-gray-800 text-xs">Signature Burger</h4>
                        <p class="text-xs text-gray-600 mt-1">Premium Quality</p>
                    </div>
                    <div class="menu-item fade-in">
                        <i class="fas fa-pizza-slice text-2xl text-orange-600 mb-2"></i>
                        <h4 class="font-semibold text-gray-800 text-xs">Wood Fired Pizza</h4>
                        <p class="text-xs text-gray-600 mt-1">Artisan Made</p>
                    </div>
                    <div class="menu-item fade-in">
                        <i class="fas fa-fish text-2xl text-blue-600 mb-2"></i>
                        <h4 class="font-semibold text-gray-800 text-xs">Fresh Seafood</h4>
                        <p class="text-xs text-gray-600 mt-1">Daily Catch</p>
                    </div>
                    <div class="menu-item fade-in">
                        <i class="fas fa-ice-cream text-2xl text-pink-600 mb-2"></i>
                        <h4 class="font-semibold text-gray-800 text-xs">Dessert Special</h4>
                        <p class="text-xs text-gray-600 mt-1">House Made</p>
                    </div>
                </div>
            </div>
            
            <!-- Statistics -->
            @if($profile->stats ?? false)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center text-lg tracking-tight" style="font-weight: 600; letter-spacing: -0.015em;">
                    <i class="fas fa-chart-bar text-gray-600 mr-3 text-lg"></i>
                    Our Achievements
                </h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="stats-card p-4 rounded-2xl text-center">
                        <div class="text-2xl font-bold text-red-600 mb-1">500+</div>
                        <div class="text-xs text-gray-600">Happy Customers</div>
                    </div>
                    <div class="stats-card p-4 rounded-2xl text-center">
                        <div class="text-2xl font-bold text-orange-600 mb-1">50+</div>
                        <div class="text-xs text-gray-600">Menu Items</div>
                    </div>
                    <div class="stats-card p-4 rounded-2xl text-center">
                        <div class="text-2xl font-bold text-green-600 mb-1">5★</div>
                        <div class="text-xs text-gray-600">Rating</div>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Contact Information -->
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center text-lg tracking-tight" style="font-weight: 600; letter-spacing: -0.015em;">
                    <i class="fas fa-address-book text-gray-600 mr-3 text-lg"></i>
                    Contact Information
                </h3>
                <div class="space-y-3">
                    @if($profile->phone)
                    <div class="contact-item p-4 rounded-2xl flex items-center">
                        <i class="fas fa-phone text-green-600 text-lg mr-4"></i>
                        <div>
                            <div class="font-semibold text-gray-800 text-sm">Phone</div>
                            <div class="text-gray-600 text-xs">{{ $profile->phone }}</div>
                        </div>
                    </div>
                    @endif
                    @if($profile->email)
                    <div class="contact-item p-4 rounded-2xl flex items-center">
                        <i class="fas fa-envelope text-blue-600 text-lg mr-4"></i>
                        <div>
                            <div class="font-semibold text-gray-800 text-sm">Email</div>
                            <div class="text-gray-600 text-xs">{{ $profile->email }}</div>
                        </div>
                    </div>
                    @endif
                    @if($profile->website)
                    <div class="contact-item p-4 rounded-2xl flex items-center">
                        <i class="fas fa-globe text-purple-600 text-lg mr-4"></i>
                        <div>
                            <div class="font-semibold text-gray-800 text-sm">Website</div>
                            <div class="text-gray-600 text-xs">{{ $profile->website }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Store/Menu Section -->
            @if($profile->store_enabled && isset($user->storeProducts) && $user->storeProducts->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center text-lg tracking-tight" style="font-weight: 600; letter-spacing: -0.015em;">
                    <i class="fas fa-store text-gray-600 mr-3 text-lg"></i>
                    Our Menu & Products
                </h3>
                <div class="space-y-3 mb-4">
                    @foreach($user->storeProducts->take(4) as $product)
                    <div class="service-card p-4 rounded-2xl hover:scale-105 transition-all duration-300">
                        <div class="flex items-center">
                            @if($product->image)
                            <img src="{{ Storage::disk('public')->url($product->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-16 h-16 object-cover rounded-xl mr-4">
                            @else
                            <div class="w-16 h-16 bg-red-500 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-utensils text-white text-xl"></i>
                            </div>
                            @endif
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800 text-sm mb-1">{{ $product->name }}</h4>
                                @if($product->description)
                                <p class="text-gray-600 text-xs mb-2">{{ Str::limit($product->description, 50) }}</p>
                                @endif
                                <div class="flex items-center justify-between">
                                    <span class="text-red-600 font-bold text-sm">{{ $profile->currency_symbol ?? '$' }}{{ number_format($product->price, 2) }}</span>
                                    @if($product->is_available)
                                    <span class="text-green-600 text-xs font-medium">Available</span>
                                    @else
                                    <span class="text-gray-400 text-xs">Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('store.show', $qrCode->uuid ?? '#') }}" 
                   class="action-btn-primary w-full py-3 px-4 rounded-2xl text-white text-center font-semibold text-sm flex items-center justify-center">
                    <i class="fas fa-shopping-bag mr-2"></i>
                    View Full Menu
                </a>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="px-6 py-4">
                <!-- Save Contact Button -->
                <button onclick="downloadVCard()" 
                        class="action-btn-primary w-full py-4 px-6 rounded-2xl text-white font-bold text-lg flex items-center justify-center mb-4">
                    <i class="fas fa-download mr-3"></i>
                    Save Contact
                </button>
                
                <!-- Quick Action Buttons -->
                <div class="grid grid-cols-2 gap-3 mb-4">
                    @if($profile->phone)
                    <a href="tel:{{ $profile->phone }}" class="action-btn-secondary py-3 px-4 rounded-2xl text-white text-center font-semibold text-sm flex items-center justify-center">
                        <i class="fas fa-phone mr-2"></i>
                        Call Now
                    </a>
                    @endif
                    @if($profile->email)
                    <a href="mailto:{{ $profile->email }}" class="action-btn-gradient py-3 px-4 rounded-2xl text-white text-center font-semibold text-sm flex items-center justify-center">
                        <i class="fas fa-envelope mr-2"></i>
                        Email Us
                    </a>
                    @endif
                </div>
                
                <!-- Reservation Button -->
                <a href="#" class="action-btn-secondary w-full py-3 px-4 rounded-2xl text-white text-center font-semibold text-sm flex items-center justify-center">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Make Reservation
                </a>
            </div>
            
            <!-- Gallery / Food Portfolio -->
            @if(isset($galleryItems) && $galleryItems->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center text-lg tracking-tight" style="font-weight: 600; letter-spacing: -0.015em;">
                    <i class="fas fa-images text-gray-600 mr-3 text-lg"></i>
                    Food Gallery
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($galleryItems->take(6) as $item)
                    <div class="relative group overflow-hidden rounded-2xl fade-in" style="animation-delay: {{ $loop->index * 0.1 }}s">
                        <img src="{{ Storage::disk('public')->url($item->image_path) }}" 
                             alt="{{ $item->title ?? 'Food Image' }}" 
                             class="w-full h-32 object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        @if($item->title)
                        <div class="absolute bottom-0 left-0 right-0 p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                            <p class="text-white text-sm font-semibold">{{ $item->title }}</p>
                            @if($item->description)
                            <p class="text-white/80 text-xs mt-1">{{ Str::limit($item->description, 40) }}</p>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @elseif(isset($gallery) && $gallery->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center text-lg tracking-tight" style="font-weight: 600; letter-spacing: -0.015em;">
                    <i class="fas fa-images text-gray-600 mr-3 text-lg"></i>
                    Food Gallery
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($gallery->take(6) as $image)
                    <div class="gallery-thumb aspect-square relative group overflow-hidden">
                        <img src="{{ $image->url }}" alt="Food Image" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Social Links -->
            @if(isset($socialLinks) && $socialLinks->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center text-lg tracking-tight" style="font-weight: 600; letter-spacing: -0.015em;">
                    <i class="fas fa-share-alt text-gray-600 mr-3 text-lg"></i>
                    Connect with Us
                </h3>
                <div class="flex gap-3 justify-center">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="social-icon w-12 h-12 flex items-center justify-center rounded-full text-white text-lg" title="{{ ucfirst($link->platform) }}">
                            @switch($link->platform)
                                @case('linkedin')<i class="fab fa-linkedin-in"></i>@break
                                @case('twitter')<i class="fab fa-twitter"></i>@break
                                @case('github')<i class="fab fa-github"></i>@break
                                @case('instagram')<i class="fab fa-instagram"></i>@break
                                @case('facebook')<i class="fab fa-facebook-f"></i>@break
                                @case('youtube')<i class="fab fa-youtube"></i>@break
                                @case('tiktok')<i class="fab fa-tiktok"></i>@break
                                @case('whatsapp')<i class="fab fa-whatsapp"></i>@break
                                @default<i class="fas fa-link"></i>
                            @endswitch
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Footer -->
            <div class="text-center py-6 animate-fade-in" style="animation-delay: 0.8s">
                <div class="flex items-center justify-center mb-3">
                    <div class="w-8 h-8 bg-gradient-to-r from-red-500 to-orange-500 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-utensils text-white text-sm"></i>
                    </div>
                    <p class="text-gray-600 text-sm font-medium">
                        {{ $profile->display_name ?? $user->name ?? 'Food & Hospitality' }}
                    </p>
                </div>
                <p class="text-gray-400 text-xs mb-2">
                    Serving excellence since {{ date('Y') }}
                </p>
                <p class="text-gray-400 text-xs">
                    Powered by Whiteray Smart Tag
                </p>
            </div>
        </div>
    </div>
    
    <script>
        // vCard Download Function
        function downloadVCard() {
            const vcard = `BEGIN:VCARD
VERSION:3.0
FN:{{ $profile->display_name ?? $user->name ?? 'Chef' }}
N:{{ $user->name ?? 'Chef' }};;;;
@if($profile->profession)ORG:{{ $profile->profession }}@endif
@if($profile->email ?? $user->email)EMAIL:{{ $profile->email ?? $user->email }}@endif
@if($profile->phone)TEL:{{ $profile->phone }}@endif
@if($profile->website)URL:{{ $profile->website }}@endif
@if($profile->location)ADR:;;{{ $profile->location }};;;;@endif
@if($profile->bio)NOTE:{{ $profile->bio }}@endif
END:VCARD`;

            const blob = new Blob([vcard], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($profile->display_name ?? $user->name ?? 'chef') }}-contact.vcf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
            
            // Show success message
            showNotification('Contact saved successfully!', 'success');
        }

        // Show notification function
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-2xl text-white font-semibold text-sm transform translate-x-full transition-transform duration-300 ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 
                'bg-blue-500'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Slide in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            // Slide out and remove
            setTimeout(() => {
                notification.style.transform = 'translateX(full)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Enhanced fade in animation with stagger
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.fade-in');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });
            
            fadeElements.forEach(el => observer.observe(el));
            
            // Add loading animation
            document.body.classList.add('loaded');
        });

        // Add scroll animations for better UX
        window.addEventListener('scroll', () => {
            const elements = document.querySelectorAll('.animate-on-scroll');
            elements.forEach(el => {
                const elementTop = el.getBoundingClientRect().top;
                const elementVisible = 150;

                if (elementTop < window.innerHeight - elementVisible) {
                    el.classList.add('visible');
                }
            });
        });

        // Add click tracking for analytics (optional)
        document.addEventListener('click', function(e) {
            const target = e.target.closest('a[href^="tel:"], a[href^="mailto:"], a[href^="http"]');
            if (target) {
                const action = target.href.startsWith('tel:') ? 'phone_call' : 
                             target.href.startsWith('mailto:') ? 'email_click' : 
                             'website_visit';
                
                // You can send this data to your analytics service
                console.log('User action:', action, target.href);
            }
        });

        // Add smooth scrolling for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
