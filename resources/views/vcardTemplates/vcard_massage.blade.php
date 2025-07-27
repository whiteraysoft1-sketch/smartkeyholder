<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Massage & Therapy vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <meta name="msapplication-TileColor" content="#8b5cf6">
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
    @endif
    
    <style>
        /* Custom Massage & Therapy Theme Styles */
        .massage-gradient {
            background: 
                linear-gradient(135deg, rgba(139, 92, 246, 0.95) 0%, rgba(168, 85, 247, 0.95) 25%, rgba(217, 70, 239, 0.95) 50%, rgba(236, 72, 153, 0.95) 75%, rgba(251, 113, 133, 0.95) 100%),
                url('https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .zen-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(236, 72, 153, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(168, 85, 247, 0.05) 0%, transparent 50%);
        }
        
        .relaxation-shadow {
            box-shadow: 
                0 10px 25px -5px rgba(139, 92, 246, 0.3),
                0 4px 6px -2px rgba(139, 92, 246, 0.1);
        }
        
        .massage-border {
            border-radius: 1.5rem;
        }
        
        .zen-animation {
            animation: zen-float 4s ease-in-out infinite;
        }
        
        @keyframes zen-float {
            0%, 100% { 
                transform: translateY(0px) scale(1);
                box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.4);
            }
            50% { 
                transform: translateY(-10px) scale(1.02);
                box-shadow: 0 0 0 10px rgba(139, 92, 246, 0);
            }
        }
        
        .lotus-bloom {
            animation: lotus-bloom 3s ease-in-out infinite;
        }
        
        @keyframes lotus-bloom {
            0%, 100% { transform: scale(1) rotate(0deg); }
            25% { transform: scale(1.1) rotate(5deg); }
            50% { transform: scale(1) rotate(0deg); }
            75% { transform: scale(1.05) rotate(-5deg); }
        }
        
        .massage-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .contact-item {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.1) 0%, rgba(236, 72, 153, 0.1) 100%);
            border: 1px solid rgba(139, 92, 246, 0.2);
            transition: all 0.3s ease;
        }
        
        .contact-item:hover {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.15) 0%, rgba(236, 72, 153, 0.15) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.2);
        }
        
        .social-icon {
            background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: linear-gradient(135deg, #7c3aed 0%, #9333ea 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4);
        }
        
        .service-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.9) 100%);
            border: 1px solid rgba(139, 92, 246, 0.2);
            transition: all 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(139, 92, 246, 0.2);
            border-color: rgba(139, 92, 246, 0.3);
        }
        
        .therapy-badge {
            background: linear-gradient(135deg, #ec4899 0%, #f97316 100%);
            animation: gentle-pulse 4s ease-in-out infinite;
        }
        
        @keyframes gentle-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        .zen-quote {
            background: linear-gradient(135deg, rgba(236, 72, 153, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
            border-left: 4px solid #ec4899;
        }
        
        .booking-btn {
            background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
            transition: all 0.3s ease;
        }
        
        .booking-btn:hover {
            background: linear-gradient(135deg, #be185d 0%, #9d174d 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(236, 72, 153, 0.4);
        }
        
        .relaxation-btn {
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            animation: relaxation-glow 3s ease-in-out infinite;
        }
        
        @keyframes relaxation-glow {
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
<body class="massage-gradient zen-pattern min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="massage-card massage-border relaxation-shadow overflow-hidden">
            
            <!-- Header Section -->
            @if($profile->background_image)
            <!-- Header with Background Image -->
            <div class="relative w-full h-48 bg-cover bg-center" style="background-image: url('{{ $profile->background_image_url }}');">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/20"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-purple-400/40 via-pink-500/30 to-purple-600/40"></div>
                
                <!-- Profile Image Overlapping -->
                <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                    <div class="relative inline-block">
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 p-1 zen-animation">
                            <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'MT') . '&background=8b5cf6&color=fff&size=128' }}" 
                                 class="w-full h-full rounded-full object-cover border-4 border-white" 
                                 alt="Profile Photo">
                        </div>
                        <!-- Massage Hands Badge -->
                        <div class="absolute -bottom-2 -right-2 therapy-badge text-white rounded-full w-10 h-10 flex items-center justify-center text-lg">
                            <i class="fas fa-hands"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Decorative Massage Elements -->
                <div class="absolute top-4 left-4 text-white/50 text-2xl lotus-bloom">
                    <i class="fas fa-spa"></i>
                </div>
                <div class="absolute top-4 right-4 text-white/50 text-2xl zen-animation">
                    <i class="fas fa-hands"></i>
                </div>
            </div>
            <!-- Spacer and Profile Info -->
            <div class="pt-20 pb-6 px-6 text-center">
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Massage Therapist' }}
                </h1>
                <p class="text-purple-700 font-semibold text-lg mb-2">
                    {{ $profile->profession ?? 'Licensed Massage Therapist' }}
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
                    <i class="fas fa-map-marker-alt text-purple-600 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
            </div>
            @else
            <!-- Header without Background Image -->
            <div class="relative px-6 pt-8 pb-6 text-center">
                <!-- Decorative Massage Elements -->
                <div class="absolute top-4 left-4 text-purple-500/30 text-2xl lotus-bloom">
                    <i class="fas fa-spa"></i>
                </div>
                <div class="absolute top-4 right-4 text-pink-500/30 text-2xl zen-animation">
                    <i class="fas fa-hands"></i>
                </div>
                
                <!-- Profile Image with Therapy Badge -->
                <div class="relative inline-block mb-4">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 p-1 zen-animation">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'MT') . '&background=8b5cf6&color=fff&size=128' }}" 
                             class="w-full h-full rounded-full object-cover border-4 border-white" 
                             alt="Profile Photo">
                    </div>
                    <!-- Massage Hands Badge -->
                    <div class="absolute -bottom-2 -right-2 therapy-badge text-white rounded-full w-10 h-10 flex items-center justify-center text-lg">
                        <i class="fas fa-hands"></i>
                    </div>
                </div>
                
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Massage Therapist' }}
                </h1>
                <p class="text-purple-700 font-semibold text-lg mb-2">
                    {{ $profile->profession ?? 'Licensed Massage Therapist' }}
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
                    <i class="fas fa-map-marker-alt text-purple-600 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
            @endif
                
                <!-- Credentials/Specialization -->
                <div class="inline-flex items-center bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                    <i class="fas fa-certificate mr-2"></i>
                    Certified Massage Therapist
                </div>
            </div>
            
            <!-- Bio Section -->
            <div class="px-6 py-4">
                <div class="zen-quote rounded-xl p-4 mb-6">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-quote-left text-pink-600 text-lg mr-2"></i>
                        <h3 class="font-semibold text-gray-800">About My Practice</h3>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        {{ $profile->bio ?? 'Dedicated to healing through therapeutic touch. Specializing in relaxation, deep tissue, and therapeutic massage techniques to restore balance and wellness to your body and mind.' }}
                    </p>
                </div>
            </div>
            
            <!-- Quick Booking (if available) -->
            @if($profile->phone)
            <div class="px-6 py-2">
                <a href="tel:{{ $profile->phone }}" class="relaxation-btn w-full text-white py-3 px-4 rounded-xl font-bold text-center flex items-center justify-center">
                    <i class="fas fa-phone-alt mr-2"></i>
                    Book Your Session
                </a>
            </div>
            @endif
            
            <!-- Contact Information -->
            @if($profile->phone || $profile->email || $profile->website)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-address-book text-purple-600 mr-2"></i>
                    Contact Information
                </h3>
                <div class="space-y-3">
                    @if($profile->phone)
                    <div class="contact-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Phone</div>
                            <div class="text-sm text-gray-600">{{ $profile->phone }}</div>
                        </div>
                        <a href="tel:{{ $profile->phone }}" class="bg-purple-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-purple-600 transition-colors">
                            Call
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->email)
                    <div class="contact-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-pink-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Email</div>
                            <div class="text-sm text-gray-600">{{ $profile->email }}</div>
                        </div>
                        <a href="mailto:{{ $profile->email }}" class="bg-pink-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-pink-600 transition-colors">
                            Email
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->website)
                    <div class="contact-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Website</div>
                            <div class="text-sm text-gray-600">Visit our studio</div>
                        </div>
                        <a href="{{ $profile->website }}" target="_blank" class="bg-indigo-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-indigo-600 transition-colors">
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
                    <i class="fas fa-spa text-purple-600 mr-2"></i>
                    Massage Services
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-hands text-purple-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Swedish Massage</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-fist-raised text-red-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Deep Tissue</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-fire text-orange-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Hot Stone</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-leaf text-green-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Aromatherapy</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-running text-blue-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Sports Massage</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-baby text-pink-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Prenatal</div>
                    </div>
                </div>
            </div>
            
            <!-- Social Links -->
            @if($socialLinks->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-share-alt text-purple-600 mr-2"></i>
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
                    <i class="fas fa-images text-purple-600 mr-2"></i>
                    Studio Gallery
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
                <a href="tel:{{ $profile->phone }}" class="booking-btn w-full text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Book Massage Session
                </a>
                @endif
                
                @if($profile->email)
                <a href="mailto:{{ $profile->email }}" class="w-full bg-gradient-to-r from-purple-500 to-pink-500 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center hover:from-purple-600 hover:to-pink-600 transition-all">
                    <i class="fas fa-envelope mr-2"></i>
                    Send Message
                </a>
                @endif
                
                <!-- Save Contact Button -->
                <button onclick="downloadVCard()" class="w-full bg-gradient-to-r from-indigo-500 to-purple-500 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center hover:from-indigo-600 hover:to-purple-600 transition-all">
                    <i class="fas fa-download mr-2"></i>
                    Save Contact
                </button>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 bg-purple-50 text-center border-t border-purple-200">
                <div class="flex items-center justify-center text-purple-700 text-sm mb-2">
                    <i class="fas fa-spa mr-2"></i>
                    <span>Healing Through Touch</span>
                    <i class="fas fa-heart ml-2 text-pink-500 lotus-bloom"></i>
                </div>
                <div class="text-xs text-gray-500">
                    Licensed Massage Therapist
                </div>
                <div class="text-xs text-gray-400 mt-1">
                    Powered by Smart Tag Wellness
                </div>
            </div>
        </div>
    </div>
    
    <!-- vCard Download Script -->
    <script>
        function downloadVCard() {
            const vCardData = `BEGIN:VCARD
VERSION:3.0
FN:{{ $profile->display_name ?? $user->name ?? 'Massage Therapist' }}
ORG:{{ $profile->profession ?? 'Licensed Massage Therapist' }}
TITLE:{{ $profile->profession ?? 'Licensed Massage Therapist' }}
TEL:{{ $profile->phone ?? '' }}
EMAIL:{{ $profile->email ?? '' }}
URL:{{ $profile->website ?? '' }}
NOTE:{{ $profile->bio ?? 'Dedicated to healing through therapeutic touch and massage therapy.' }}
END:VCARD`;
            
            const blob = new Blob([vCardData], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($profile->display_name ?? $user->name ?? 'massage-therapist') }}.vcf';
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
            
            // Relaxation button pulse effect
            const relaxationBtn = document.querySelector('.relaxation-btn');
            if (relaxationBtn) {
                setInterval(() => {
                    relaxationBtn.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        relaxationBtn.style.transform = 'scale(1)';
                    }, 200);
                }, 4000);
            }
            
            // Wellness tip tooltip
            const wellnessTip = document.createElement('div');
            wellnessTip.className = 'fixed bottom-4 right-4 bg-purple-500 text-white p-3 rounded-lg shadow-lg text-sm max-w-xs opacity-0 transition-opacity duration-300';
            wellnessTip.innerHTML = '<i class="fas fa-spa mr-2"></i>Regular massage therapy can reduce stress and improve circulation!';
            document.body.appendChild(wellnessTip);
            
            // Show wellness tip after 5 seconds
            setTimeout(() => {
                wellnessTip.style.opacity = '1';
                setTimeout(() => {
                    wellnessTip.style.opacity = '0';
                }, 4000);
            }, 5000);
        });
    </script>
</body>
</html>
