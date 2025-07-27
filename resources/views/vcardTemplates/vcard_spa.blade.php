<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spa & Wellness vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <meta name="msapplication-TileColor" content="#06b6d4">
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
    @endif
    
    <style>
        /* Custom Spa & Wellness Theme Styles */
        .spa-gradient {
            background: 
                linear-gradient(135deg, rgba(6, 182, 212, 0.95) 0%, rgba(14, 165, 233, 0.95) 25%, rgba(59, 130, 246, 0.95) 50%, rgba(99, 102, 241, 0.95) 75%, rgba(139, 92, 246, 0.95) 100%),
                url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .tranquil-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(6, 182, 212, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.05) 0%, transparent 50%);
        }
        
        .serenity-shadow {
            box-shadow: 
                0 10px 25px -5px rgba(6, 182, 212, 0.3),
                0 4px 6px -2px rgba(6, 182, 212, 0.1);
        }
        
        .spa-border {
            border-radius: 1.5rem;
        }
        
        .water-ripple {
            animation: water-ripple 5s ease-in-out infinite;
        }
        
        @keyframes water-ripple {
            0%, 100% { 
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(6, 182, 212, 0.4);
            }
            25% { 
                transform: scale(1.02);
                box-shadow: 0 0 0 5px rgba(6, 182, 212, 0.2);
            }
            50% { 
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(6, 182, 212, 0);
            }
            75% { 
                transform: scale(1.02);
                box-shadow: 0 0 0 5px rgba(6, 182, 212, 0.1);
            }
        }
        
        .zen-flow {
            animation: zen-flow 4s ease-in-out infinite;
        }
        
        @keyframes zen-flow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-5px) rotate(2deg); }
            50% { transform: translateY(0px) rotate(0deg); }
            75% { transform: translateY(-3px) rotate(-2deg); }
        }
        
        .spa-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .contact-item {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
            border: 1px solid rgba(6, 182, 212, 0.2);
            transition: all 0.3s ease;
        }
        
        .contact-item:hover {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(139, 92, 246, 0.15) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(6, 182, 212, 0.2);
        }
        
        .social-icon {
            background: linear-gradient(135deg, #06b6d4 0%, #0ea5e9 100%);
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: linear-gradient(135deg, #0891b2 0%, #0284c7 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(6, 182, 212, 0.4);
        }
        
        .service-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(240, 249, 255, 0.9) 100%);
            border: 1px solid rgba(6, 182, 212, 0.2);
            transition: all 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(6, 182, 212, 0.2);
            border-color: rgba(6, 182, 212, 0.3);
        }
        
        .wellness-badge {
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            animation: gentle-pulse 4s ease-in-out infinite;
        }
        
        @keyframes gentle-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        .spa-quote {
            background: linear-gradient(135deg, rgba(6, 182, 212, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
            border-left: 4px solid #06b6d4;
        }
        
        .treatment-btn {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            transition: all 0.3s ease;
        }
        
        .treatment-btn:hover {
            background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(6, 182, 212, 0.4);
        }
        
        .serenity-btn {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            animation: serenity-glow 4s ease-in-out infinite;
        }
        
        @keyframes serenity-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.4); }
            50% { box-shadow: 0 0 0 8px rgba(139, 92, 246, 0); }
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
    </style>
</head>
<body class="spa-gradient tranquil-pattern min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="spa-card spa-border serenity-shadow overflow-hidden">
            
            <!-- Header Section -->
            @if($profile->background_image)
            <!-- Header with Background Image -->
            <div class="relative w-full h-48 bg-cover bg-center" style="background-image: url('{{ $profile->background_image_url }}');">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/20"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-400/40 via-blue-500/30 to-cyan-600/40"></div>
                
                <!-- Profile Image Overlapping -->
                <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                    <div class="relative inline-block">
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-cyan-400 to-blue-500 p-1 water-ripple">
                            <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'SW') . '&background=06b6d4&color=fff&size=128' }}" 
                                 class="w-full h-full rounded-full object-cover border-4 border-white" 
                                 alt="Profile Photo">
                        </div>
                        <!-- Spa Lotus Badge -->
                        <div class="absolute -bottom-2 -right-2 wellness-badge text-white rounded-full w-10 h-10 flex items-center justify-center text-lg">
                            <i class="fas fa-spa"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Decorative Spa Elements -->
                <div class="absolute top-4 left-4 text-white/50 text-2xl zen-flow">
                    <i class="fas fa-leaf"></i>
                </div>
                <div class="absolute top-4 right-4 text-white/50 text-2xl water-ripple">
                    <i class="fas fa-water"></i>
                </div>
            </div>
            <!-- Spacer and Profile Info -->
            <div class="pt-20 pb-6 px-6 text-center">
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Spa Wellness Expert' }}
                </h1>
                <p class="text-cyan-700 font-semibold text-lg mb-2">
                    {{ $profile->profession ?? 'Spa & Wellness Specialist' }}
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
                    <i class="fas fa-map-marker-alt text-cyan-600 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
                
                <!-- Credentials/Specialization -->
                <div class="inline-flex items-center bg-cyan-100 text-cyan-800 px-3 py-1 rounded-full text-sm font-medium">
                    <i class="fas fa-certificate mr-2"></i>
                    Certified Wellness Professional
                </div>
            </div>
            @else
            <!-- Header without Background Image -->
            <div class="relative px-6 pt-8 pb-6 text-center">
                <!-- Decorative Spa Elements -->
                <div class="absolute top-4 left-4 text-cyan-500/30 text-2xl zen-flow">
                    <i class="fas fa-leaf"></i>
                </div>
                <div class="absolute top-4 right-4 text-blue-500/30 text-2xl water-ripple">
                    <i class="fas fa-water"></i>
                </div>
                
                <!-- Profile Image with Wellness Badge -->
                <div class="relative inline-block mb-4">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-cyan-400 to-blue-500 p-1 water-ripple">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'SW') . '&background=06b6d4&color=fff&size=128' }}" 
                             class="w-full h-full rounded-full object-cover border-4 border-white" 
                             alt="Profile Photo">
                    </div>
                    <!-- Spa Lotus Badge -->
                    <div class="absolute -bottom-2 -right-2 wellness-badge text-white rounded-full w-10 h-10 flex items-center justify-center text-lg">
                        <i class="fas fa-spa"></i>
                    </div>
                </div>
                
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Spa Wellness Expert' }}
                </h1>
                <p class="text-cyan-700 font-semibold text-lg mb-2">
                    {{ $profile->profession ?? 'Spa & Wellness Specialist' }}
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
                    <i class="fas fa-map-marker-alt text-cyan-600 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
                
                <!-- Credentials/Specialization -->
                <div class="inline-flex items-center bg-cyan-100 text-cyan-800 px-3 py-1 rounded-full text-sm font-medium">
                    <i class="fas fa-certificate mr-2"></i>
                    Certified Wellness Professional
                </div>
            </div>
            @endif
            
            <!-- Bio Section -->
            <div class="px-6 py-4">
                <div class="spa-quote rounded-xl p-4 mb-6">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-quote-left text-cyan-600 text-lg mr-2"></i>
                        <h3 class="font-semibold text-gray-800">About Our Spa</h3>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        {{ $profile->bio ?? 'Experience ultimate relaxation and rejuvenation at our luxury spa. We offer a complete range of wellness treatments designed to restore balance, beauty, and inner peace.' }}
                    </p>
                </div>
            </div>
            
            <!-- Quick Booking (if available) -->
            @if($profile->phone)
            <div class="px-6 py-2">
                <a href="tel:{{ $profile->phone }}" class="serenity-btn w-full text-white py-3 px-4 rounded-xl font-bold text-center flex items-center justify-center">
                    <i class="fas fa-phone-alt mr-2"></i>
                    Book Spa Treatment
                </a>
            </div>
            @endif
            
            <!-- Contact Information -->
            @if($profile->phone || $profile->email || $profile->website)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-address-book text-cyan-600 mr-2"></i>
                    Contact Information
                </h3>
                <div class="space-y-3">
                    @if($profile->phone)
                    <div class="contact-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-cyan-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Phone</div>
                            <div class="text-sm text-gray-600">{{ $profile->phone }}</div>
                        </div>
                        <a href="tel:{{ $profile->phone }}" class="bg-cyan-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-cyan-600 transition-colors">
                            Call
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->email)
                    <div class="contact-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Email</div>
                            <div class="text-sm text-gray-600">{{ $profile->email }}</div>
                        </div>
                        <a href="mailto:{{ $profile->email }}" class="bg-blue-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-600 transition-colors">
                            Email
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->website)
                    <div class="contact-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Website</div>
                            <div class="text-sm text-gray-600">Visit our spa</div>
                        </div>
                        <a href="{{ $profile->website }}" target="_blank" class="bg-purple-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-purple-600 transition-colors">
                            Visit
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Services Section -->
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-spa text-cyan-600 mr-2"></i>
                    Spa Treatments
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-spa text-cyan-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Facial Treatments</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-hands text-purple-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Body Massage</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-tint text-blue-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Hydrotherapy</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-leaf text-green-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Aromatherapy</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-fire text-orange-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Sauna & Steam</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-fire text-red-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Hot Stone Massage</div>
                    </div>
                </div>
            </div>
            
            <!-- Social Links -->
            @if($socialLinks->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-share-alt text-cyan-600 mr-2"></i>
                    Connect With Us
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
                                    @default bg-gradient-to-r from-cyan-500 to-blue-500 @break
                                @endswitch">
                                @switch($link->platform)
                                    @case('facebook')<i class="fab fa-facebook-f text-lg"></i>@break
                                    @case('instagram')<i class="fab fa-instagram text-lg"></i>@break
                                    @case('twitter')<i class="fab fa-twitter text-lg"></i>@break
                                    @case('linkedin')<i class="fab fa-linkedin-in text-lg"></i>@break
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
                            <div class="text-cyan-500">
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
                    <i class="fas fa-images text-cyan-600 mr-2"></i>
                    Spa Gallery
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($galleryItems->take(4) as $item)
                        <div class="relative group overflow-hidden rounded-lg fade-in">
                            <img src="{{ $item->full_image_url }}" 
                                 alt="{{ $item->title }}" 
                                 class="w-full h-24 object-cover transition-transform duration-300 group-hover:scale-110">
                            @if($item->title)
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2">
                                    <p class="text-white text-xs font-medium">{{ $item->title }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Action Buttons -->
            <div class="px-6 py-6 space-y-3">
                @if($profile->phone)
                <a href="tel:{{ $profile->phone }}" class="treatment-btn w-full text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Book Spa Treatment
                </a>
                @endif
                
                @if($profile->email)
                <a href="mailto:{{ $profile->email }}" class="w-full bg-gradient-to-r from-cyan-500 to-blue-500 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center hover:from-cyan-600 hover:to-blue-600 transition-all">
                    <i class="fas fa-envelope mr-2"></i>
                    Send Message
                </a>
                @endif
                
                <!-- Save Contact Button -->
                <button onclick="downloadVCard()" class="w-full bg-gradient-to-r from-purple-500 to-indigo-500 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center hover:from-purple-600 hover:to-indigo-600 transition-all">
                    <i class="fas fa-download mr-2"></i>
                    Save Contact
                </button>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 bg-cyan-50 text-center border-t border-cyan-200">
                <div class="flex items-center justify-center text-cyan-700 text-sm mb-2">
                    <i class="fas fa-spa mr-2"></i>
                    <span>Relax, Rejuvenate, Restore</span>
                    <i class="fas fa-heart ml-2 text-blue-500 zen-flow"></i>
                </div>
                <div class="text-xs text-gray-500">
                    Premium Spa & Wellness Center
                </div>
                <div class="text-xs text-gray-400 mt-1">
                    Powered by Smart Tag Spa
                </div>
            </div>
        </div>
    </div>
    
    <!-- vCard Download Script -->
    <script>
        function downloadVCard() {
            const vCardData = `BEGIN:VCARD
VERSION:3.0
FN:{{ $profile->display_name ?? $user->name ?? 'Spa Wellness Expert' }}
ORG:{{ $profile->profession ?? 'Spa & Wellness Specialist' }}
TITLE:{{ $profile->profession ?? 'Spa & Wellness Specialist' }}
TEL:{{ $profile->phone ?? '' }}
EMAIL:{{ $profile->email ?? '' }}
URL:{{ $profile->website ?? '' }}
NOTE:{{ $profile->bio ?? 'Experience ultimate relaxation and rejuvenation at our luxury spa and wellness center.' }}
END:VCARD`;
            
            const blob = new Blob([vCardData], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($profile->display_name ?? $user->name ?? 'spa-wellness-expert') }}.vcf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        
        // Interactive animations and effects
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
            
            // Add staggered animation delays
            document.querySelectorAll('.service-card').forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Serenity button pulse effect
            const serenityBtn = document.querySelector('.serenity-btn');
            if (serenityBtn) {
                setInterval(() => {
                    serenityBtn.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        serenityBtn.style.transform = 'scale(1)';
                    }, 200);
                }, 5000);
            }
            
            // Spa tip tooltip
            const spaTip = document.createElement('div');
            spaTip.className = 'fixed bottom-4 right-4 bg-cyan-500 text-white p-3 rounded-lg shadow-lg text-sm max-w-xs opacity-0 transition-opacity duration-300';
            spaTip.innerHTML = '<i class="fas fa-leaf mr-2"></i>Take time for yourself - regular spa treatments promote overall wellness!';
            document.body.appendChild(spaTip);
            
            // Show spa tip after 5 seconds
            setTimeout(() => {
                spaTip.style.opacity = '1';
                setTimeout(() => {
                    spaTip.style.opacity = '0';
                }, 4000);
            }, 5000);
        });
    </script>
</body>
</html>
