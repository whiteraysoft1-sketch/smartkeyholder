<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <meta name="msapplication-TileColor" content="#16a34a">
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
    @endif
    
    <style>
        /* Custom Agriculture Theme Styles */
        .agriculture-gradient {
            background: 
                linear-gradient(135deg, rgba(22, 163, 74, 0.95) 0%, rgba(34, 197, 94, 0.95) 25%, rgba(132, 204, 22, 0.95) 50%, rgba(234, 179, 8, 0.95) 75%, rgba(245, 158, 11, 0.95) 100%),
                url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .nature-pattern {
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 119, 198, 0.05) 0%, transparent 50%);
        }
        
        .leaf-shadow {
            box-shadow: 
                0 10px 25px -5px rgba(34, 197, 94, 0.3),
                0 4px 6px -2px rgba(34, 197, 94, 0.1);
        }
        
        .organic-border {
            border-radius: 2rem 1rem 2rem 1rem;
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .grow-hover {
            transition: all 0.3s ease;
        }
        
        .grow-hover:hover {
            transform: scale(1.05);
        }
        
        .agriculture-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .contact-item {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(132, 204, 22, 0.1) 100%);
            border: 1px solid rgba(34, 197, 94, 0.2);
        }
        
        .social-icon {
            background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: linear-gradient(135deg, #15803d 0%, #16a34a 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.4);
        }
        
        .service-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(240, 253, 244, 0.9) 100%);
            border: 1px solid rgba(34, 197, 94, 0.2);
            transition: all 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(34, 197, 94, 0.2);
        }
    </style>
</head>
<body class="agriculture-gradient min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="agriculture-card organic-border leaf-shadow overflow-hidden">
            
            <!-- Header Section -->
            @if($profile->background_image)
            <!-- Header with Background Image -->
            <div class="relative w-full h-48 bg-cover bg-center" style="background-image: url('{{ $profile->background_image_url }}');">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/20"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-green-400/40 via-green-600/30 to-yellow-500/40"></div>
                
                <!-- Profile Image Overlapping -->
                <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                    <div class="relative inline-block">
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-green-400 to-green-600 p-1">
                            <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'AG') . '&background=16a34a&color=fff&size=128' }}" 
                                 class="w-full h-full rounded-full object-cover border-4 border-white" 
                                 alt="Profile Photo">
                        </div>
                        <!-- Badge -->
                        <div class="absolute -bottom-2 -right-2 bg-yellow-500 text-white rounded-full w-10 h-10 flex items-center justify-center text-lg">
                            <i class="fas fa-tractor"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Decorative Elements -->
                <div class="absolute top-4 left-4 text-white/50 text-2xl floating-animation">
                    <i class="fas fa-leaf"></i>
                </div>
                <div class="absolute top-4 right-4 text-white/50 text-2xl floating-animation" style="animation-delay: -2s;">
                    <i class="fas fa-seedling"></i>
                </div>
            </div>
            <!-- Spacer and Profile Info -->
            <div class="pt-20 pb-6 px-6 text-center">
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Agricultural Expert' }}
                </h1>
                <p class="text-green-700 font-semibold text-lg mb-2">
                    {{ $profile->profession ?? 'Agricultural Specialist' }}
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
                    <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
            </div>
            @else
            <!-- Header without Background Image -->
            <div class="relative px-6 pt-8 pb-6 text-center">
                <!-- Decorative Elements -->
                <div class="absolute top-4 left-4 text-green-500/30 text-2xl floating-animation">
                    <i class="fas fa-leaf"></i>
                </div>
                <div class="absolute top-4 right-4 text-yellow-500/30 text-2xl floating-animation" style="animation-delay: -2s;">
                    <i class="fas fa-seedling"></i>
                </div>
                
                <!-- Profile Image -->
                <div class="relative inline-block mb-4">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-green-400 to-green-600 p-1">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'AG') . '&background=16a34a&color=fff&size=128' }}" 
                             class="w-full h-full rounded-full object-cover border-4 border-white" 
                             alt="Profile Photo">
                    </div>
                    <!-- Badge -->
                    <div class="absolute -bottom-2 -right-2 bg-yellow-500 text-white rounded-full w-10 h-10 flex items-center justify-center text-lg">
                        <i class="fas fa-tractor"></i>
                    </div>
                </div>
                
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Agricultural Expert' }}
                </h1>
                <p class="text-green-700 font-semibold text-lg mb-2">
                    {{ $profile->profession ?? 'Agricultural Specialist' }}
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
                    <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
            </div>
            @endif
            
            <!-- Bio Section -->
            <div class="px-6 py-4">
                <div class="bg-green-50 rounded-xl p-4 mb-6 border border-green-200">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-quote-left text-green-600 text-lg mr-2"></i>
                        <h3 class="font-semibold text-green-800">About Me</h3>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        {{ $profile->bio ?? 'Passionate about sustainable agriculture and helping farmers grow better crops through innovative farming techniques and modern agricultural solutions.' }}
                    </p>
                </div>
            </div>
            
            <!-- Contact Information -->
            @if($profile->phone || $profile->email || $profile->website)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-address-book text-green-600 mr-2"></i>
                    Contact Information
                </h3>
                <div class="space-y-3">
                    @if($profile->phone)
                    <a href="tel:{{ $profile->phone }}" class="contact-item rounded-lg p-3 flex items-center grow-hover">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800">Phone</div>
                            <div class="text-sm text-gray-600">{{ $profile->phone }}</div>
                        </div>
                    </a>
                    @endif
                    
                    @if($profile->email)
                    <a href="mailto:{{ $profile->email }}" class="contact-item rounded-lg p-3 flex items-center grow-hover">
                        <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800">Email</div>
                            <div class="text-sm text-gray-600">{{ $profile->email }}</div>
                        </div>
                    </a>
                    @endif
                    
                    @if($profile->website)
                    <a href="{{ $profile->website }}" target="_blank" class="contact-item rounded-lg p-3 flex items-center grow-hover">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-800">Website</div>
                            <div class="text-sm text-gray-600">Visit our farm</div>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Services Section -->
            @if($profile->services ?? false)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-seedling text-green-600 mr-2"></i>
                    Our Services
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <div class="service-card rounded-lg p-3 text-center">
                        <i class="fas fa-tractor text-green-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Farm Equipment</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center">
                        <i class="fas fa-leaf text-green-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Organic Farming</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center">
                        <i class="fas fa-apple-alt text-green-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Crop Consulting</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center">
                        <i class="fas fa-water text-blue-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Irrigation</div>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Social Links -->
            @if($socialLinks->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-share-alt text-green-600 mr-2"></i>
                    Connect With Us
                </h3>
                <div class="flex gap-3 justify-center">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="social-icon w-12 h-12 flex items-center justify-center rounded-full text-white text-lg" title="{{ ucfirst($link->platform) }}">
                            @switch($link->platform)
                                @case('facebook')<i class="fab fa-facebook-f"></i>@break
                                @case('instagram')<i class="fab fa-instagram"></i>@break
                                @case('twitter')<i class="fab fa-twitter"></i>@break
                                @case('linkedin')<i class="fab fa-linkedin-in"></i>@break
                                @case('youtube')<i class="fab fa-youtube"></i>@break
                                @case('whatsapp')<i class="fab fa-whatsapp"></i>@break
                                @case('telegram')<i class="fab fa-telegram-plane"></i>@break
                                @default<i class="fas fa-link"></i>@break
                            @endswitch
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Gallery Section -->
            @if($galleryItems->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-images text-green-600 mr-2"></i>
                    Farm Gallery
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($galleryItems->take(4) as $item)
                        <div class="relative group overflow-hidden rounded-lg">
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
                <a href="tel:{{ $profile->phone }}" class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center grow-hover">
                    <i class="fas fa-phone mr-2"></i>
                    Call Now
                </a>
                @endif
                
                @if($profile->email)
                <a href="mailto:{{ $profile->email }}" class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center grow-hover">
                    <i class="fas fa-envelope mr-2"></i>
                    Send Email
                </a>
                @endif
                
                <!-- Save Contact Button -->
                <button onclick="downloadVCard()" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center grow-hover">
                    <i class="fas fa-download mr-2"></i>
                    Save Contact
                </button>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 bg-green-50 text-center border-t border-green-200">
                <div class="flex items-center justify-center text-green-700 text-sm">
                    <i class="fas fa-leaf mr-2"></i>
                    <span>Growing Together, Harvesting Success</span>
                    <i class="fas fa-seedling ml-2"></i>
                </div>
                <div class="text-xs text-gray-500 mt-2">
                    Powered by Smart Tag Agriculture
                </div>
            </div>
        </div>
    </div>
    
    <!-- vCard Download Script -->
    <script>
        function downloadVCard() {
            const vCardData = `BEGIN:VCARD
VERSION:3.0
FN:{{ $profile->display_name ?? $user->name ?? 'Agricultural Expert' }}
ORG:{{ $profile->profession ?? 'Agricultural Specialist' }}
TITLE:{{ $profile->profession ?? 'Agricultural Specialist' }}
TEL:{{ $profile->phone ?? '' }}
EMAIL:{{ $profile->email ?? '' }}
URL:{{ $profile->website ?? '' }}
NOTE:{{ $profile->bio ?? 'Passionate about sustainable agriculture and helping farmers grow better crops.' }}
END:VCARD`;
            
            const blob = new Blob([vCardData], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($profile->display_name ?? $user->name ?? 'agricultural-expert') }}.vcf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        
        // Add some interactive animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate elements on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            // Observe all service cards and contact items
            document.querySelectorAll('.service-card, .contact-item').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        });
    </script>
</body>
</html>
