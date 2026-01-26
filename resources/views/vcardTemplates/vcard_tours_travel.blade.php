<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->display_name ?? $user->name ?? 'Tours & Travel' }} - Digital Business Card</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <meta name="msapplication-TileColor" content="#10b981">
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
    @endif
    
    <style>
        /* Tours & Travel Premium Gradient - Wildlife & Nature Theme */
        .travel-gradient {
            background: 
                linear-gradient(135deg, 
                    rgba(5, 150, 105, 0.95) 0%,
                    rgba(16, 185, 129, 0.95) 20%,
                    rgba(6, 182, 212, 0.95) 40%,
                    rgba(34, 197, 94, 0.95) 60%,
                    rgba(20, 184, 166, 0.95) 80%,
                    rgba(14, 165, 233, 0.95) 100%
                ),
                url('https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            animation: gradient-shift 15s ease infinite;
        }
        
        @keyframes gradient-shift {
            0%, 100% { filter: hue-rotate(0deg); }
            50% { filter: hue-rotate(10deg); }
        }
        
        /* Premium Glass Effect */
        .premium-glass {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(30px) saturate(180%);
            border: 2px solid rgba(255, 255, 255, 0.4);
            box-shadow: 
                0 30px 60px -15px rgba(5, 150, 105, 0.25),
                0 15px 30px -10px rgba(16, 185, 129, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }
        
        /* Hero Section with Parallax */
        .travel-hero {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #14b8a6 100%);
            position: relative;
            overflow: hidden;
        }
        
        .travel-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.1) 0%, transparent 40%);
            animation: hero-pulse 8s ease-in-out infinite;
        }
        
        @keyframes hero-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        /* Floating Animation */
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-15px) rotate(2deg); }
            75% { transform: translateY(-10px) rotate(-2deg); }
        }
        
        /* Profile Glow */
        .profile-ring {
            animation: profile-ring 3s ease-in-out infinite;
        }
        
        @keyframes profile-ring {
            0%, 100% { 
                box-shadow: 
                    0 0 0 0 rgba(16, 185, 129, 0.4),
                    0 0 30px rgba(5, 150, 105, 0.3);
            }
            50% { 
                box-shadow: 
                    0 0 0 20px rgba(16, 185, 129, 0),
                    0 0 50px rgba(5, 150, 105, 0.5);
            }
        }
        
        /* Contact Cards */
        .contact-item {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(249, 250, 251, 0.95) 100%);
            border: 1px solid rgba(16, 185, 129, 0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .contact-item:hover {
            background: linear-gradient(135deg, rgba(255, 255, 255, 1) 0%, rgba(236, 253, 245, 1) 100%);
            transform: translateY(-5px) scale(1.02);
            box-shadow: 
                0 20px 40px rgba(16, 185, 129, 0.2),
                0 10px 20px rgba(5, 150, 105, 0.1);
            border-color: rgba(16, 185, 129, 0.3);
        }
        
        /* Destination Cards */
        .destination-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(16, 185, 129, 0.2);
            transition: all 0.4s ease;
            overflow: hidden;
            position: relative;
        }
        
        .destination-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }
        
        .destination-card:hover::before {
            left: 100%;
        }
        
        .destination-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 25px 50px rgba(16, 185, 129, 0.3);
        }
        
        /* Action Buttons */
        .travel-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
            transition: all 0.3s ease;
        }
        
        .travel-btn:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.4);
        }
        
        .travel-btn-secondary {
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
            box-shadow: 0 8px 20px rgba(20, 184, 166, 0.3);
        }
        
        .travel-btn-secondary:hover {
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(20, 184, 166, 0.4);
        }
        
        /* Social Icons */
        .social-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .social-card:hover {
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .social-icon-box {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        /* Gallery */
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
            transition: all 0.4s ease;
        }
        
        .gallery-item img {
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .gallery-item:hover img {
            transform: scale(1.15) rotate(2deg);
        }
        
        .gallery-overlay {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.9) 0%, rgba(5, 150, 105, 0.9) 100%);
        }
        
        /* Travel Icons */
        .travel-icon {
            animation: travel-bounce 2s ease-in-out infinite;
        }
        
        @keyframes travel-bounce {
            0%, 100% { transform: translateX(0) translateY(0); }
            25% { transform: translateX(5px) translateY(-5px); }
            75% { transform: translateX(-5px) translateY(-5px); }
        }
        
        /* Waves Animation */
        .wave {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"><path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="rgba(255,255,255,0.1)"/></svg>');
            background-size: cover;
            animation: wave 10s linear infinite;
        }
        
        @keyframes wave {
            0% { background-position: 0 0; }
            100% { background-position: 1200px 0; }
        }
        
        /* Fade In Animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Badge Styles */
        .verified-badge {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            animation: badge-pulse 2s ease-in-out infinite;
        }
        
        @keyframes badge-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
    </style>
</head>
<body class="travel-gradient min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="premium-glass rounded-3xl overflow-hidden shadow-2xl">
            
            <!-- Hero Section with Background -->
            <div class="relative">
                <div class="h-56 overflow-hidden relative">
                    @if($profile->background_image_url)
                        <img src="{{ $profile->background_image_url }}" 
                             class="w-full h-full object-cover" 
                             alt="Background">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-emerald-500 via-teal-500 to-green-600"></div>
                    @endif
                    
                    <!-- Overlay gradient -->
                    <div class="absolute inset-0 bg-gradient-to-b from-black/20 to-transparent"></div>
                    
                    <!-- Floating Travel Icons -->
                    <div class="absolute top-6 right-6">
                        <i class="fas fa-plane text-white/40 text-3xl float-animation" style="animation-delay: 0s;"></i>
                    </div>
                    <div class="absolute top-12 left-8">
                        <i class="fas fa-globe-americas text-white/30 text-2xl float-animation" style="animation-delay: 1s;"></i>
                    </div>
                </div>
                
                <!-- Profile Image Overlapping -->
                <div class="flex justify-center -mt-16">
                    <div class="relative">
                        <div class="w-32 h-32 rounded-full bg-white p-1.5 shadow-2xl profile-ring">
                            <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&background=10b981&color=fff&size=128' }}" 
                                 class="w-full h-full rounded-full object-cover" 
                                 alt="Profile Photo">
                        </div>
                        <!-- Verified Badge -->
                        <div class="verified-badge absolute bottom-0 right-0 text-white rounded-full w-10 h-10 flex items-center justify-center text-sm shadow-lg">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                </div>
            </div>
                
            <!-- Profile Section -->
            <div class="px-6 pt-4 pb-6 text-center">
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Travel Expert' }}
                </h1>
                <p class="text-emerald-600 font-medium text-base mb-4">
                    {{ $profile->profession ?? 'Travel & Tour Specialist' }}
                </p>
                    
                    @if($profile->location)
                    <div class="flex items-center justify-center text-gray-600 text-sm mb-5 gap-2">
                        <i class="fas fa-map-marker-alt text-emerald-500"></i>
                        <span>{{ $profile->location }}</span>
                    </div>
                    @endif
                    
                    <!-- Quick Action Buttons -->
                    <div class="flex items-center justify-center gap-3 mb-6">
                        @if($profile->phone)
                        <a href="tel:{{ $profile->phone }}" 
                           class="travel-btn flex-1 text-white px-6 py-3.5 rounded-full font-semibold text-sm transition-all duration-300">
                            <i class="fas fa-phone-alt mr-2"></i>
                            Call Now
                        </a>
                        @endif
                        
                        @if($profile->email ?? $user->email)
                        <a href="mailto:{{ $profile->email ?? $user->email }}" 
                           class="travel-btn-secondary flex-1 text-white px-6 py-3.5 rounded-full font-semibold text-sm transition-all duration-300">
                            <i class="fas fa-envelope mr-2"></i>
                            Email
                        </a>
                        @endif
                    </div>
                    
                    <!-- Bio/About Section -->
                    @if($profile->bio)
                    <div class="destination-card rounded-2xl p-5 mb-6 text-left">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center mr-3">
                                <i class="fas fa-compass text-white"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 text-lg">About Our Services</h3>
                        </div>
                        <p class="text-gray-700 leading-relaxed">{{ $profile->bio }}</p>
                    </div>
                    @endif
                </div>
                
                <!-- Contact Information -->
                <div class="px-6 py-6 bg-gradient-to-b from-transparent to-gray-50/50">
                    <h3 class="font-bold text-gray-800 mb-5 flex items-center text-lg">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center mr-3">
                            <i class="fas fa-address-book text-white"></i>
                        </div>
                        Contact Details
                    </h3>
                    
                    <div class="space-y-3">
                        @if($profile->phone)
                        <div class="contact-item rounded-xl p-4 flex items-center fade-in">
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center text-white mr-4 shadow-lg">
                                <i class="fas fa-mobile-alt text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800 text-sm">Phone</div>
                                <a href="tel:{{ $profile->phone }}" class="text-emerald-600 font-medium">{{ $profile->phone }}</a>
                            </div>
                            <a href="tel:{{ $profile->phone }}" class="text-emerald-500 hover:text-emerald-700">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                        @endif
                        
                        @if($profile->email ?? $user->email)
                        <div class="contact-item rounded-xl p-4 flex items-center fade-in">
                            <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center text-white mr-4 shadow-lg">
                                <i class="fas fa-envelope text-xl"></i>
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <div class="font-semibold text-gray-800 text-sm">Email</div>
                                <a href="mailto:{{ $profile->email ?? $user->email }}" class="text-teal-600 font-medium truncate block">{{ $profile->email ?? $user->email }}</a>
                            </div>
                            <a href="mailto:{{ $profile->email ?? $user->email }}" class="text-teal-500 hover:text-teal-700">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                        @endif
                        
                        @if($profile->website)
                        <div class="contact-item rounded-xl p-4 flex items-center fade-in">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center text-white mr-4 shadow-lg">
                                <i class="fas fa-globe text-xl"></i>
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <div class="font-semibold text-gray-800 text-sm">Website</div>
                                <a href="{{ $profile->website }}" target="_blank" class="text-green-600 font-medium truncate block">{{ $profile->website }}</a>
                            </div>
                            <a href="{{ $profile->website }}" target="_blank" class="text-green-500 hover:text-green-700">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                        @endif
                        
                        @if($profile->location)
                        <div class="contact-item rounded-xl p-4 flex items-center fade-in">
                            <div class="w-12 h-12 bg-gradient-to-br from-lime-500 to-lime-600 rounded-xl flex items-center justify-center text-white mr-4 shadow-lg">
                                <i class="fas fa-map-marker-alt text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800 text-sm">Location</div>
                                <p class="text-lime-600 font-medium">{{ $profile->location }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Business Information -->
                @if($profile->business_name || $profile->business_phone || $profile->business_email || $profile->business_address)
                <div class="px-6 py-6 bg-gradient-to-b from-gray-50/50 to-transparent">
                    <h3 class="font-bold text-gray-800 mb-5 flex items-center text-lg">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center mr-3">
                            <i class="fas fa-building text-white"></i>
                        </div>
                        Business Information
                    </h3>
                    
                    <div class="space-y-3">
                        @if($profile->business_name)
                        <div class="contact-item rounded-xl p-4 flex items-center fade-in">
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center text-white mr-4 shadow-lg">
                                <i class="fas fa-briefcase text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800 text-sm">Business Name</div>
                                <p class="text-emerald-600 font-medium">{{ $profile->business_name }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($profile->business_phone)
                        <div class="contact-item rounded-xl p-4 flex items-center fade-in">
                            <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center text-white mr-4 shadow-lg">
                                <i class="fas fa-phone text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800 text-sm">Business Phone</div>
                                <a href="tel:{{ $profile->business_phone }}" class="text-teal-600 font-medium">{{ $profile->business_phone }}</a>
                            </div>
                            <a href="tel:{{ $profile->business_phone }}" class="text-teal-500 hover:text-teal-700">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                        @endif
                        
                        @if($profile->business_email)
                        <div class="contact-item rounded-xl p-4 flex items-center fade-in">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center text-white mr-4 shadow-lg">
                                <i class="fas fa-envelope text-xl"></i>
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <div class="font-semibold text-gray-800 text-sm">Business Email</div>
                                <a href="mailto:{{ $profile->business_email }}" class="text-green-600 font-medium truncate block">{{ $profile->business_email }}</a>
                            </div>
                            <a href="mailto:{{ $profile->business_email }}" class="text-green-500 hover:text-green-700">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                        @endif
                        
                        @if($profile->business_address)
                        <div class="contact-item rounded-xl p-4 flex items-center fade-in">
                            <div class="w-12 h-12 bg-gradient-to-br from-lime-500 to-lime-600 rounded-xl flex items-center justify-center text-white mr-4 shadow-lg">
                                <i class="fas fa-map-marker-alt text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-800 text-sm">Business Address</div>
                                <p class="text-lime-600 font-medium">{{ $profile->business_address }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                
                <!-- Social Links -->
                @if($socialLinks && $socialLinks->count() > 0)
                <div class="px-6 py-6 bg-gradient-to-b from-gray-50/50 to-transparent">
                    <h3 class="font-bold text-gray-800 mb-5 flex items-center text-lg">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-green-500 flex items-center justify-center mr-3">
                            <i class="fas fa-share-alt text-white"></i>
                        </div>
                        Connect With Us
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" 
                           class="social-card flex items-center gap-3 p-4 rounded-2xl transform transition-all duration-300 hover:scale-105">
                            <div class="social-icon-box w-12 h-12 rounded-xl flex items-center justify-center text-white text-xl flex-shrink-0
                                @if(str_contains(strtolower($link->platform ?? ''), 'facebook')) bg-blue-600
                                @elseif(str_contains(strtolower($link->platform ?? ''), 'instagram')) bg-gradient-to-br from-purple-600 via-pink-600 to-orange-500
                                @elseif(str_contains(strtolower($link->platform ?? ''), 'whatsapp')) bg-green-500
                                @elseif(str_contains(strtolower($link->platform ?? ''), 'twitter') || str_contains(strtolower($link->platform ?? ''), 'x')) bg-sky-500
                                @elseif(str_contains(strtolower($link->platform ?? ''), 'youtube')) bg-red-600
                                @elseif(str_contains(strtolower($link->platform ?? ''), 'linkedin')) bg-blue-700
                                @elseif(str_contains(strtolower($link->platform ?? ''), 'tiktok')) bg-black
                                @else bg-emerald-600
                                @endif">
                                @switch(strtolower($link->platform ?? ''))
                                    @case('linkedin') <i class="fab fa-linkedin-in"></i> @break
                                    @case('twitter') <i class="fab fa-twitter"></i> @break
                                    @case('x') <i class="fab fa-x-twitter"></i> @break
                                    @case('github') <i class="fab fa-github"></i> @break
                                    @case('instagram') <i class="fab fa-instagram"></i> @break
                                    @case('facebook') <i class="fab fa-facebook-f"></i> @break
                                    @case('youtube') <i class="fab fa-youtube"></i> @break
                                    @case('tiktok') <i class="fab fa-tiktok"></i> @break
                                    @case('whatsapp') <i class="fab fa-whatsapp"></i> @break
                                    @case('telegram') <i class="fab fa-telegram-plane"></i> @break
                                    @case('pinterest') <i class="fab fa-pinterest-p"></i> @break
                                    @default <i class="fas fa-link"></i>
                                @endswitch
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-gray-800 text-sm truncate">{{ ucfirst($link->platform ?? 'Link') }}</div>
                                <div class="text-gray-600 text-xs">{{ $link->display_name ?: 'Visit Profile' }}</div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Photo Gallery -->
                @if($galleryItems && $galleryItems->count() > 0)
                <div class="px-6 py-6">
                    <h3 class="font-bold text-gray-800 mb-5 flex items-center text-lg">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center mr-3">
                            <i class="fas fa-images text-white"></i>
                        </div>
                        Travel Gallery
                    </h3>
                    
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($galleryItems->take(4) as $item)
                        <div class="gallery-item group cursor-pointer relative" onclick="openGalleryModal({{ $loop->index }})">
                            <div class="aspect-square overflow-hidden rounded-xl">
                                <img src="{{ $item->full_image_url }}" 
                                     alt="{{ $item->title }}" 
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="gallery-overlay absolute inset-0 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <i class="fas fa-search-plus text-white text-3xl"></i>
                            </div>
                            @if($item->title)
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3 rounded-b-xl opacity-0 group-hover:opacity-100 transition-opacity">
                                <p class="text-white text-sm font-medium">{{ $item->title }}</p>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    
                    @if($galleryItems->count() > 4)
                    <button onclick="showAllGallery()" class="w-full mt-4 travel-btn text-white py-3 rounded-xl font-semibold">
                        View All {{ $galleryItems->count() }} Photos
                    </button>
                    @endif
                </div>
                @endif
                
                <!-- Save Contact Card -->
                <div class="px-6 py-6">
                    <button onclick="saveContact()" class="w-full bg-gradient-to-r from-emerald-500 via-green-500 to-teal-500 text-white py-4 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-3">
                        <i class="fas fa-download text-2xl"></i>
                        Save Travel Contact
                    </button>
                </div>
                
                <!-- Share Button -->
                <div class="px-6 pb-6">
                    <button onclick="shareProfile()" class="w-full border-2 border-emerald-500 text-emerald-600 py-3.5 rounded-2xl font-semibold hover:bg-emerald-50 transition-all duration-300 flex items-center justify-center gap-2">
                        <i class="fas fa-share-nodes"></i>
                        Share Profile
                    </button>
                </div>
                
            </div>
        </div>
    </div>
    
    <!-- Gallery Modal -->
    <div id="galleryModal" class="fixed inset-0 bg-black/95 hidden items-center justify-center z-50 p-4" onclick="closeGalleryModal()">
        <button class="absolute top-4 right-4 text-white text-3xl hover:text-emerald-400 transition-colors z-10" onclick="closeGalleryModal()">
            <i class="fas fa-times"></i>
        </button>
        <div class="max-w-4xl w-full" onclick="event.stopPropagation()">
            <img id="modalImage" src="" alt="" class="w-full h-auto rounded-2xl shadow-2xl">
            <div id="modalTitle" class="text-white text-center mt-4 text-xl font-semibold"></div>
        </div>
    </div>

    <script>
        // Fade in animations on scroll
        const fadeElements = document.querySelectorAll('.fade-in');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });
        
        fadeElements.forEach(el => observer.observe(el));
        
        // Save Contact vCard
        function saveContact() {
            const vCardData = `BEGIN:VCARD
VERSION:3.0
FN:{{ $profile->display_name ?? $user->name ?? 'Contact' }}
N:{{ $user->name ?? 'Contact' }};;;
{{ $profile->profession ? 'TITLE:' . $profile->profession : '' }}
{{ $profile->phone ? 'TEL;TYPE=WORK,VOICE:' . $profile->phone : '' }}
{{ ($profile->email ?? $user->email) ? 'EMAIL;TYPE=WORK:' . ($profile->email ?? $user->email) : '' }}
URL:{{ url('/qr/' . $qrCode->uuid) }}
{{ $profile->location ? 'ADR;TYPE=WORK:;;' . $profile->location : '' }}
{{ $profile->bio ? 'NOTE:' . $profile->bio : '' }}
END:VCARD`;
            
            const blob = new Blob([vCardData], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($profile->display_name ?? $user->name ?? 'contact') }}.vcf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        
        // Share Profile
        function shareProfile() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $profile->display_name ?? $user->name ?? "Tours & Travel" }}',
                    text: 'Check out our travel services!',
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Profile link copied to clipboard!');
                });
            }
        }
        
        // Gallery Modal Functions
        const galleryImages = @json($galleryItems->map(fn($item) => ['url' => $item->full_image_url, 'title' => $item->title]));
        
        function openGalleryModal(index) {
            const modal = document.getElementById('galleryModal');
            const modalImage = document.getElementById('modalImage');
            const modalTitle = document.getElementById('modalTitle');
            
            modalImage.src = galleryImages[index].url;
            modalTitle.textContent = galleryImages[index].title || '';
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        
        function closeGalleryModal() {
            const modal = document.getElementById('galleryModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        
        function showAllGallery() {
            alert('Full gallery view would open here');
        }
    </script>
</body>
</html>
