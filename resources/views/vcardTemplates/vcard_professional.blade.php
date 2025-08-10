<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Services vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <meta name="msapplication-TileColor" content="#1e40af">
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
    @endif
    
    <style>
        /* Custom Professional Services Theme Styles */
        .professional-gradient {
            background: 
                linear-gradient(135deg, rgba(30, 64, 175, 0.95) 0%, rgba(59, 130, 246, 0.95) 25%, rgba(6, 182, 212, 0.95) 50%, rgba(8, 145, 178, 0.95) 75%, rgba(15, 118, 110, 0.95) 100%),
                url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .corporate-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(30, 64, 175, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(6, 182, 212, 0.05) 0%, transparent 50%);
        }
        
        .executive-shadow {
            box-shadow: 
                0 20px 40px -10px rgba(30, 64, 175, 0.3),
                0 8px 16px -4px rgba(30, 64, 175, 0.1);
        }
        
        .professional-border {
            border-radius: 1.5rem;
        }
        
        .briefcase-pulse {
            animation: briefcase-pulse 3s ease-in-out infinite;
        }
        
        @keyframes briefcase-pulse {
            0%, 100% { 
                transform: scale(1);
                opacity: 1;
            }
            50% { 
                transform: scale(1.1);
                opacity: 0.8;
            }
        }
        
        .professional-glow {
            animation: professional-glow 4s ease-in-out infinite;
        }
        
        @keyframes professional-glow {
            0%, 100% { 
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(30, 64, 175, 0.4);
            }
            50% { 
                transform: scale(1.02);
                box-shadow: 0 0 0 15px rgba(30, 64, 175, 0);
            }
        }
        
        .handshake-animation {
            animation: handshake 2.5s ease-in-out infinite;
        }
        
        @keyframes handshake {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-5deg); }
            75% { transform: rotate(5deg); }
        }
        
        .professional-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .contact-item {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
            border: 1px solid rgba(30, 64, 175, 0.2);
            transition: all 0.3s ease;
        }
        
        .contact-item:hover {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.15) 0%, rgba(6, 182, 212, 0.15) 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(30, 64, 175, 0.2);
        }
        
        .social-icon {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 12px 35px rgba(30, 64, 175, 0.4);
        }
        
        .service-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.9) 100%);
            border: 1px solid rgba(30, 64, 175, 0.2);
            transition: all 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(30, 64, 175, 0.2);
            border-color: rgba(30, 64, 175, 0.3);
        }
        
        .professional-badge {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            animation: badge-shine 4s ease-in-out infinite;
        }
        
        @keyframes badge-shine {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.9; }
        }
        
        .expertise-quote {
            background: linear-gradient(135deg, rgba(30, 64, 175, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
            border-left: 4px solid #1e40af;
        }
        
        .consultation-btn {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            transition: all 0.3s ease;
        }
        
        .consultation-btn:hover {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(30, 64, 175, 0.4);
        }
        
        .contact-btn {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            transition: all 0.3s ease;
        }
        
        .contact-btn:hover {
            background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(6, 182, 212, 0.4);
        }
        
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .professional-stats {
            background: linear-gradient(135deg, rgba(15, 118, 110, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
            border: 1px solid rgba(15, 118, 110, 0.2);
        }
        
        .excellence-badge {
            background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%);
            color: white;
            animation: excellence-glow 3s ease-in-out infinite;
        }
        
        @keyframes excellence-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(15, 118, 110, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(15, 118, 110, 0); }
        }
        
        .floating-elements {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
    </style>
</head>
<body class="professional-gradient corporate-pattern min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="professional-card professional-border executive-shadow overflow-hidden">
            
            <!-- Floating Background Elements -->
            <div class="floating-elements top-4 left-4 text-blue-500/20 text-3xl">
                <i class="fas fa-briefcase briefcase-pulse"></i>
            </div>
            <div class="floating-elements top-4 right-4 text-cyan-500/20 text-3xl" style="animation-delay: -2s;">
                <i class="fas fa-handshake handshake-animation"></i>
            </div>
            
            <!-- Header Section -->
            @if($profile->background_image)
            <!-- Header with Background Image -->
            <div class="relative w-full h-48 bg-cover bg-center" style="background-image: url('{{ $profile->background_image_url }}');">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/20"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/40 via-cyan-500/30 to-blue-700/40"></div>
                
                <!-- Profile Image Overlapping -->
                <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                    <div class="relative inline-block">
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-600 to-cyan-500 p-1 professional-glow">
                            <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'PS') . '&background=1e40af&color=fff&size=128' }}" 
                                 class="w-full h-full rounded-full object-cover border-4 border-white" 
                                 alt="Profile Photo">
                        </div>
                        <!-- Professional Excellence Badge -->
                        <div class="absolute -bottom-2 -right-2 professional-badge text-white rounded-full w-10 h-10 flex items-center justify-center text-lg">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- Spacer and Profile Info -->
            <div class="pt-20 pb-6 px-6 text-center">
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Professional Expert' }}
                </h1>
                <p class="text-cyan-700 font-semibold text-lg mb-4">
                    {{ $profile->profession ?? 'Professional Consultant' }}
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
                <div class="flex items-center justify-center text-gray-600 text-sm mb-4">
                    <i class="fas fa-building text-cyan-600 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
            </div>
            @else
            <!-- Header without Background Image -->
            <div class="relative px-6 pt-8 pb-6 text-center">
                <!-- Profile Image with Professional Badge -->
                <div class="relative inline-block mb-4">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-600 to-cyan-500 p-1 professional-glow">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'PS') . '&background=1e40af&color=fff&size=128' }}" 
                             class="w-full h-full rounded-full object-cover border-4 border-white" 
                             alt="Profile Photo">
                    </div>
                    <!-- Professional Excellence Badge -->
                    <div class="absolute -bottom-2 -right-2 professional-badge text-white rounded-full w-10 h-10 flex items-center justify-center text-lg">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Professional Expert' }}
                </h1>
                <p class="text-blue-700 font-semibold text-lg mb-4">
                    {{ $profile->profession ?? 'Professional Consultant' }}
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
                <div class="flex items-center justify-center text-gray-600 text-sm mb-4">
                    <i class="fas fa-building text-blue-600 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
                
                <!-- Professional Credentials -->
                <div class="flex justify-center gap-2 mb-4">
                    <div class="excellence-badge px-3 py-1 rounded-full text-xs font-medium">
                        <i class="fas fa-award mr-1"></i>
                        Certified Professional
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Bio Section -->
            <div class="px-6 py-4 {{ $profile->background_image ? 'pt-2' : '' }}">
                <div class="expertise-quote rounded-xl p-4 mb-6">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-quote-left text-blue-600 text-lg mr-2"></i>
                        <h3 class="font-semibold text-gray-800">Professional Expertise</h3>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        {{ $profile->bio ?? 'Delivering exceptional professional services with integrity, expertise, and commitment to excellence. Trusted advisor helping clients achieve their business objectives through strategic solutions.' }}
                    </p>
                </div>
            </div>
            

            
            <!-- Contact Information -->
            @if($profile->phone || $profile->email || $profile->website)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-address-book text-blue-600 mr-2"></i>
                    Contact Information
                </h3>
                <div class="space-y-3">
                    @if($profile->phone)
                    <div class="contact-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Phone</div>
                            <div class="text-sm text-gray-600">{{ $profile->phone }}</div>
                        </div>
                        <a href="tel:{{ $profile->phone }}" class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-700 transition-colors">
                            Call
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->email ?? $user->email)
                    <div class="contact-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-cyan-600 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Email</div>
                            <div class="text-sm text-gray-600">{{ $profile->email ?? $user->email }}</div>
                        </div>
                        <a href="mailto:{{ $profile->email ?? $user->email }}" class="bg-cyan-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-cyan-700 transition-colors">
                            Email
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->website)
                    <div class="contact-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-teal-600 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Website</div>
                            <div class="text-sm text-gray-600">Visit our office</div>
                        </div>
                        <a href="{{ $profile->website }}" target="_blank" class="bg-teal-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-teal-700 transition-colors">
                            Visit
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Professional Services Section -->
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-cogs text-blue-600 mr-2"></i>
                    Professional Services
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-handshake text-blue-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Consulting</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-chart-line text-cyan-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Strategy</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-users text-teal-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Advisory</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-lightbulb text-indigo-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Solutions</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-project-diagram text-purple-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Management</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-rocket text-orange-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Growth</div>
                    </div>
                </div>
            </div>
            
            <!-- Social Links -->
            @if($socialLinks->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-share-alt text-blue-600 mr-2"></i>
                    Professional Network
                </h3>
                <div class="space-y-3">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="social-link-card contact-item rounded-xl p-4 flex items-center fade-in hover:scale-105 transition-all duration-300">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white mr-4 shadow-lg
                                @switch($link->platform)
                                    @case('linkedin') bg-gradient-to-r from-blue-600 to-blue-700 @break
                                    @case('twitter') bg-gradient-to-r from-sky-400 to-sky-500 @break
                                    @case('github') bg-gradient-to-r from-gray-700 to-gray-800 @break
                                    @case('instagram') bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 @break
                                    @case('facebook') bg-gradient-to-r from-blue-600 to-blue-700 @break
                                    @case('youtube') bg-gradient-to-r from-red-600 to-red-700 @break
                                    @case('whatsapp') bg-gradient-to-r from-green-500 to-green-600 @break
                                    @case('telegram') bg-gradient-to-r from-blue-500 to-blue-600 @break
                                    @default bg-gradient-to-r from-gray-500 to-gray-600 @break
                                @endswitch">
                                @switch($link->platform)
                                    @case('linkedin')<i class="fab fa-linkedin-in text-lg"></i>@break
                                    @case('twitter')<i class="fab fa-twitter text-lg"></i>@break
                                    @case('github')<i class="fab fa-github text-lg"></i>@break
                                    @case('instagram')<i class="fab fa-instagram text-lg"></i>@break
                                    @case('facebook')<i class="fab fa-facebook-f text-lg"></i>@break
                                    @case('youtube')<i class="fab fa-youtube text-lg"></i>@break
                                    @case('whatsapp')<i class="fab fa-whatsapp text-lg"></i>@break
                                    @case('telegram')<i class="fab fa-telegram-plane text-lg"></i>@break
                                    @default<i class="fas fa-link text-lg"></i>@break
                                @endswitch
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-gray-800 capitalize">{{ $link->platform }}</div>
                                <div class="text-sm text-gray-600">Follow us on {{ ucfirst($link->platform) }}</div>
                            </div>
                            <div class="text-gray-400">
                                <i class="fas fa-external-link-alt text-sm"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Gallery Section -->
            @if($galleryItems->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-images text-blue-600 mr-2"></i>
                    Our Work
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($galleryItems->take(4) as $item)
                        <div class="relative group overflow-hidden rounded-lg fade-in cursor-pointer transform transition-all duration-300 hover:scale-105 hover:shadow-lg" onclick="openFullImageModal('{{ $item->full_image_url }}', '{{ $item->title }}', '{{ $item->description }}')">
                            <img src="{{ $item->full_image_url }}" 
                                 alt="{{ $item->title }}" 
                                 class="w-full h-24 object-cover transition-transform duration-300 group-hover:scale-110">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                <i class="fas fa-expand text-white text-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                            </div>
                            @if($item->title)
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2">
                                    <p class="text-white text-xs font-medium">{{ $item->title }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @if($galleryItems->count() > 4)
                    <div class="mt-4 text-center">
                        <button onclick="showAllImages()" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors">
                            <i class="fas fa-plus-circle mr-1"></i>
                            View All {{ $galleryItems->count() }} Images
                        </button>
                    </div>
                @endif
            </div>
            @endif
            
            <!-- Action Buttons -->
            <div class="px-6 py-6 space-y-3">
                @if($profile->email ?? $user->email)
                <a href="mailto:{{ $profile->email ?? $user->email }}?subject=Professional Consultation Request" class="consultation-btn w-full text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Schedule Consultation
                </a>
                @endif
                
                @if($profile->phone)
                <a href="tel:{{ $profile->phone }}" class="contact-btn w-full text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center">
                    <i class="fas fa-phone mr-2"></i>
                    Call Now
                </a>
                @endif
                
                <!-- PWA Install Button -->

                <!-- Save Contact Button -->
                <button onclick="saveContact()" class="w-full bg-gradient-to-r from-gray-600 to-gray-700 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center hover:from-gray-700 hover:to-gray-800 transition-all">
                    <i class="fas fa-download mr-2"></i>
                    Save Contact
                </button>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 bg-blue-50 text-center border-t border-blue-200">
                <div class="flex items-center justify-center text-blue-700 text-sm mb-2">
                    <i class="fas fa-award mr-2"></i>
                    <span>Excellence in Professional Services</span>
                    <i class="fas fa-briefcase ml-2 briefcase-pulse"></i>
                </div>
                <div class="text-xs text-gray-500">
                    Certified Professional Consultant
                </div>
                <div class="text-xs text-gray-400 mt-1">
                    Powered by Smart Tag Professional
                </div>
            </div>
        </div>
    </div>
    <!-- Gallery Modal -->
    <div id="galleryModal" class="hidden fixed top-0 left-0 w-full h-full bg-black/90 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full max-h-full overflow-auto relative executive-shadow">
            <div class="flex justify-between items-center p-4 border-b border-blue-200">
                <h3 id="galleryModalTitle" class="text-lg font-bold text-blue-900"></h3>
                <button onclick="closeGalleryModal()" class="text-2xl text-blue-700 hover:text-blue-900 transition-colors">&times;</button>
            </div>
            <img id="galleryModalImage" src="" alt="" class="w-full object-contain" style="max-height:60vh;">
            <div class="p-4 text-blue-800 text-sm" id="galleryModalDescription"></div>
        </div>
    </div>
    
    <!-- Enhanced Full-Screen Image Modal -->
    <div id="fullImageModal" class="hidden fixed top-0 left-0 w-full h-full bg-black/95 z-50 flex items-center justify-center p-4">
        <div class="relative w-full h-full flex items-center justify-center">
            <!-- Close Button -->
            <button onclick="closeFullImageModal()" class="absolute top-4 right-4 z-10 bg-white/20 hover:bg-white/30 text-white rounded-full w-12 h-12 flex items-center justify-center text-xl transition-all duration-300 backdrop-blur-sm">
                <i class="fas fa-times"></i>
            </button>
            
            <!-- Navigation Buttons -->
            <button id="prevImageBtn" onclick="showPreviousImage()" class="absolute left-4 top-1/2 transform -translate-y-1/2 z-10 bg-white/20 hover:bg-white/30 text-white rounded-full w-12 h-12 flex items-center justify-center text-xl transition-all duration-300 backdrop-blur-sm">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <button id="nextImageBtn" onclick="showNextImage()" class="absolute right-4 top-1/2 transform -translate-y-1/2 z-10 bg-white/20 hover:bg-white/30 text-white rounded-full w-12 h-12 flex items-center justify-center text-xl transition-all duration-300 backdrop-blur-sm">
                <i class="fas fa-chevron-right"></i>
            </button>
            
            <!-- Image Container -->
            <div class="w-full h-full flex items-center justify-center">
                <img id="fullModalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
            </div>
            
            <!-- Image Info -->
            <div class="absolute bottom-4 left-4 right-4 bg-white/10 backdrop-blur-md rounded-xl p-4 text-white">
                <h3 id="fullModalTitle" class="text-lg font-bold mb-2"></h3>
                <p id="fullModalDescription" class="text-sm opacity-90"></p>
                <div class="flex items-center justify-between mt-3">
                    <span id="imageCounter" class="text-xs opacity-75"></span>
                    <div class="flex space-x-2">
                        <button onclick="downloadImage()" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-xs transition-colors">
                            <i class="fas fa-download mr-1"></i>
                            Download
                        </button>
                        <button onclick="shareImage()" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg text-xs transition-colors">
                            <i class="fas fa-share mr-1"></i>
                            Share
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- All Images Modal -->
    <div id="allImagesModal" class="hidden fixed top-0 left-0 w-full h-full bg-black/90 z-50 overflow-y-auto">
        <div class="min-h-full flex items-start justify-center p-4">
            <div class="bg-white rounded-2xl max-w-4xl w-full my-8 relative executive-shadow">
                <div class="flex justify-between items-center p-6 border-b border-blue-200">
                    <h3 class="text-xl font-bold text-blue-900">
                        <i class="fas fa-images text-blue-600 mr-2"></i>
                        Our Complete Portfolio
                    </h3>
                    <button onclick="closeAllImagesModal()" class="text-2xl text-blue-700 hover:text-blue-900 transition-colors">&times;</button>
                </div>
                <div class="p-6">
                    <div id="allImagesGrid" class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <!-- Images will be populated here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Gallery data for navigation
        let galleryImages = [];
        let currentImageIndex = 0;
        
        // Initialize gallery data
        @if($galleryItems->count() > 0)
        galleryImages = [
            @foreach($galleryItems as $index => $item)
            {
                url: '{{ $item->full_image_url }}',
                title: '{{ $item->title ?? "Portfolio Image" }}',
                description: '{{ $item->description ?? "" }}'
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
        ];
        @endif
        
        // vCard Download Function
        function saveContact() {
            const vCardData = `BEGIN:VCARD
VERSION:3.0
FN:{{ $profile->display_name ?? $user->name ?? 'Professional Expert' }}
ORG:{{ $profile->profession ?? 'Professional Consultant' }}
TITLE:{{ $profile->profession ?? 'Professional Consultant' }}
TEL:{{ $profile->phone ?? '' }}
EMAIL:{{ $profile->email ?? $user->email ?? '' }}
URL:{{ $profile->website ?? '' }}
NOTE:{{ $profile->bio ?? 'Delivering exceptional professional services with integrity and expertise.' }}
END:VCARD`;
            
            const blob = new Blob([vCardData], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($profile->display_name ?? $user->name ?? 'professional-expert') }}.vcf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        
        // Enhanced Full-Screen Image Modal Functions
        function openFullImageModal(imageUrl, title, description) {
            // Find the index of the clicked image
            currentImageIndex = galleryImages.findIndex(img => img.url === imageUrl);
            if (currentImageIndex === -1) currentImageIndex = 0;
            
            showImageInModal(currentImageIndex);
            document.getElementById('fullImageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function showImageInModal(index) {
            if (index < 0 || index >= galleryImages.length) return;
            
            const image = galleryImages[index];
            document.getElementById('fullModalImage').src = image.url;
            document.getElementById('fullModalTitle').textContent = image.title;
            document.getElementById('fullModalDescription').textContent = image.description;
            document.getElementById('imageCounter').textContent = `${index + 1} of ${galleryImages.length}`;
            
            // Show/hide navigation buttons
            document.getElementById('prevImageBtn').style.display = galleryImages.length > 1 ? 'flex' : 'none';
            document.getElementById('nextImageBtn').style.display = galleryImages.length > 1 ? 'flex' : 'none';
        }
        
        function closeFullImageModal() {
            document.getElementById('fullImageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        function showPreviousImage() {
            currentImageIndex = currentImageIndex > 0 ? currentImageIndex - 1 : galleryImages.length - 1;
            showImageInModal(currentImageIndex);
        }
        
        function showNextImage() {
            currentImageIndex = currentImageIndex < galleryImages.length - 1 ? currentImageIndex + 1 : 0;
            showImageInModal(currentImageIndex);
        }
        
        function downloadImage() {
            const image = galleryImages[currentImageIndex];
            const link = document.createElement('a');
            link.href = image.url;
            link.download = `${image.title || 'portfolio-image'}.jpg`;
            link.target = '_blank';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        
        function shareImage() {
            const image = galleryImages[currentImageIndex];
            if (navigator.share) {
                navigator.share({
                    title: image.title || 'Portfolio Image',
                    text: image.description || 'Check out this image from our portfolio',
                    url: image.url
                }).catch(console.error);
            } else {
                // Fallback: copy URL to clipboard
                navigator.clipboard.writeText(image.url).then(() => {
                    alert('Image URL copied to clipboard!');
                }).catch(() => {
                    alert('Unable to share. Please copy the URL manually: ' + image.url);
                });
            }
        }
        
        // Show All Images Modal
        function showAllImages() {
            const grid = document.getElementById('allImagesGrid');
            grid.innerHTML = '';
            
            galleryImages.forEach((image, index) => {
                const imageDiv = document.createElement('div');
                imageDiv.className = 'relative group overflow-hidden rounded-lg cursor-pointer transform transition-all duration-300 hover:scale-105 hover:shadow-lg';
                imageDiv.onclick = () => {
                    closeAllImagesModal();
                    setTimeout(() => openFullImageModal(image.url, image.title, image.description), 100);
                };
                
                imageDiv.innerHTML = `
                    <img src="${image.url}" alt="${image.title}" class="w-full h-32 object-cover transition-transform duration-300 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                        <i class="fas fa-expand text-white text-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                    </div>
                    ${image.title ? `<div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2">
                        <p class="text-white text-xs font-medium">${image.title}</p>
                    </div>` : ''}
                `;
                
                grid.appendChild(imageDiv);
            });
            
            document.getElementById('allImagesModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeAllImagesModal() {
            document.getElementById('allImagesModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Legacy Gallery Modal Functions (keeping for compatibility)
        function openGalleryModal(imageUrl, title, description) {
            openFullImageModal(imageUrl, title, description);
        }
        
        function closeGalleryModal() {
            closeFullImageModal();
        }
        
        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (!document.getElementById('fullImageModal').classList.contains('hidden')) {
                switch(e.key) {
                    case 'Escape':
                        closeFullImageModal();
                        break;
                    case 'ArrowLeft':
                        showPreviousImage();
                        break;
                    case 'ArrowRight':
                        showNextImage();
                        break;
                }
            }
            
            if (!document.getElementById('allImagesModal').classList.contains('hidden')) {
                if (e.key === 'Escape') {
                    closeAllImagesModal();
                }
            }
        });
        
        // Close modals when clicking outside
        document.getElementById('fullImageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeFullImageModal();
            }
        });
        
        document.getElementById('allImagesModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAllImagesModal();
            }
        });
        
        // Professional animations and interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Fade in animation observer
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);
            
            // Observe all fade-in elements
            document.querySelectorAll('.fade-in').forEach(el => {
                observer.observe(el);
            });
            
            // Add staggered animation delays for service cards
            document.querySelectorAll('.service-card').forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Professional achievement counter animation
            const counters = document.querySelectorAll('.professional-stats .text-2xl');
            counters.forEach(counter => {
                const target = parseInt(counter.textContent);
                let current = 0;
                const increment = target / 60;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target + (counter.textContent.includes('+') ? '+' : '') + (counter.textContent.includes('%') ? '%' : '');
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current) + (counter.textContent.includes('+') ? '+' : '') + (counter.textContent.includes('%') ? '%' : '');
                    }
                }, 50);
            });
            
            // Professional tip system
            const professionalTips = [
                "💼 Excellence is not a skill, it's an attitude!",
                "🎯 Success is where preparation meets opportunity!",
                "🚀 Professional growth never stops!",
                "⭐ Quality service builds lasting relationships!",
                "🤝 Trust is the foundation of all business!"
            ];
            
            // Show random professional tip
            const tipElement = document.createElement('div');
            tipElement.className = 'fixed bottom-4 right-4 bg-blue-600 text-white p-3 rounded-lg shadow-lg text-sm max-w-xs opacity-0 transition-opacity duration-300';
            tipElement.innerHTML = professionalTips[Math.floor(Math.random() * professionalTips.length)];
            document.body.appendChild(tipElement);
            
            // Show tip after 7 seconds
            setTimeout(() => {
                tipElement.style.opacity = '1';
                setTimeout(() => {
                    tipElement.style.opacity = '0';
                    setTimeout(() => {
                        document.body.removeChild(tipElement);
                    }, 300);
                }, 5000);
            }, 7000);
        });

    </script>
</body>
</html>