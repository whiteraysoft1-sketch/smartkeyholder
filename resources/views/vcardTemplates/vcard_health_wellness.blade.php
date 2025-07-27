<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health & Wellness vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <meta name="msapplication-TileColor" content="#0ea5e9">
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
    @endif
    
    <style>
        /* Custom Health & Wellness Theme Styles */
        .health-gradient {
            background: 
                linear-gradient(135deg, rgba(14, 165, 233, 0.95) 0%, rgba(6, 182, 212, 0.95) 25%, rgba(16, 185, 129, 0.95) 50%, rgba(59, 130, 246, 0.95) 75%, rgba(99, 102, 241, 0.95) 100%),
                url('https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .medical-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(16, 185, 129, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(6, 182, 212, 0.05) 0%, transparent 50%);
        }
        
        .wellness-shadow {
            box-shadow: 
                0 10px 25px -5px rgba(14, 165, 233, 0.3),
                0 4px 6px -2px rgba(14, 165, 233, 0.1);
        }
        
        .medical-border {
            border-radius: 1.5rem;
        }
        
        .pulse-animation {
            animation: pulse-glow 3s ease-in-out infinite;
        }
        
        @keyframes pulse-glow {
            0%, 100% { 
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(14, 165, 233, 0.4);
            }
            50% { 
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(14, 165, 233, 0);
            }
        }
        
        .heartbeat {
            animation: heartbeat 2s ease-in-out infinite;
        }
        
        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.1); }
            50% { transform: scale(1); }
            75% { transform: scale(1.05); }
        }
        
        .wellness-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .contact-item {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
            border: 1px solid rgba(14, 165, 233, 0.2);
            transition: all 0.3s ease;
        }
        
        .contact-item:hover {
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.15) 0%, rgba(16, 185, 129, 0.15) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.2);
        }
        
        .social-icon {
            background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: linear-gradient(135deg, #0284c7 0%, #0891b2 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(14, 165, 233, 0.4);
        }
        
        .service-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(240, 249, 255, 0.9) 100%);
            border: 1px solid rgba(14, 165, 233, 0.2);
            transition: all 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(14, 165, 233, 0.2);
            border-color: rgba(14, 165, 233, 0.3);
        }
        
        .health-badge {
            background: linear-gradient(135deg, #ef4444 0%, #f97316 100%);
            animation: gentle-pulse 4s ease-in-out infinite;
        }
        
        @keyframes gentle-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        .wellness-quote {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
            border-left: 4px solid #10b981;
        }
        
        .appointment-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            transition: all 0.3s ease;
        }
        
        .appointment-btn:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        }
        
        .emergency-btn {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            animation: emergency-glow 2s ease-in-out infinite;
        }
        
        @keyframes emergency-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            50% { box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
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
<body class="health-gradient medical-pattern min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="wellness-card medical-border wellness-shadow overflow-hidden">
            
            <!-- Header Section -->
            @if($profile->background_image)
            <!-- Header with Background Image -->
            <div class="relative w-full h-48 bg-cover bg-center" style="background-image: url('{{ $profile->background_image_url }}');">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/20"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-blue-400/40 via-cyan-500/30 to-green-500/40"></div>
                
                <!-- Profile Image Overlapping -->
                <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                    <div class="relative inline-block">
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-400 to-cyan-500 p-1 pulse-animation">
                            <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'HW') . '&background=0ea5e9&color=fff&size=128' }}" 
                                 class="w-full h-full rounded-full object-cover border-4 border-white" 
                                 alt="Profile Photo">
                        </div>
                        <!-- Medical Cross Badge -->
                        <div class="absolute -bottom-2 -right-2 health-badge text-white rounded-full w-10 h-10 flex items-center justify-center text-lg">
                            <i class="fas fa-plus"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Decorative Medical Elements -->
                <div class="absolute top-4 left-4 text-white/50 text-2xl heartbeat">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <div class="absolute top-4 right-4 text-white/50 text-2xl pulse-animation">
                    <i class="fas fa-user-md"></i>
                </div>
            </div>
            <!-- Spacer and Profile Info -->
            <div class="pt-20 pb-6 px-6 text-center">
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Dr. Health Expert' }}
                </h1>
                <p class="text-blue-700 font-semibold text-lg mb-2">
                    {{ $profile->profession ?? 'Healthcare Professional' }}
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
                    <i class="fas fa-hospital text-blue-600 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
            </div>
            @else
            <!-- Header without Background Image -->
            <div class="relative px-6 pt-8 pb-6 text-center">
                <!-- Decorative Medical Elements -->
                <div class="absolute top-4 left-4 text-blue-500/30 text-2xl heartbeat">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <div class="absolute top-4 right-4 text-green-500/30 text-2xl pulse-animation">
                    <i class="fas fa-user-md"></i>
                </div>
                
                <!-- Profile Image with Medical Badge -->
                <div class="relative inline-block mb-4">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-400 to-cyan-500 p-1 pulse-animation">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'HW') . '&background=0ea5e9&color=fff&size=128' }}" 
                             class="w-full h-full rounded-full object-cover border-4 border-white" 
                             alt="Profile Photo">
                    </div>
                    <!-- Medical Cross Badge -->
                    <div class="absolute -bottom-2 -right-2 health-badge text-white rounded-full w-10 h-10 flex items-center justify-center text-lg">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
                
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Dr. Health Expert' }}
                </h1>
                <p class="text-blue-700 font-semibold text-lg mb-2">
                    {{ $profile->profession ?? 'Healthcare Professional' }}
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
                    <i class="fas fa-hospital text-blue-600 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
            @endif
                
                <!-- Credentials/Specialization -->
                <div class="inline-flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                    <i class="fas fa-certificate mr-2"></i>
                    Licensed Healthcare Provider
                </div>
            </div>
            
            <!-- Bio Section -->
            <div class="px-6 py-4">
                <div class="wellness-quote rounded-xl p-4 mb-6">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-quote-left text-green-600 text-lg mr-2"></i>
                        <h3 class="font-semibold text-gray-800">About My Practice</h3>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        {{ $profile->bio ?? 'Dedicated to providing compassionate, comprehensive healthcare services. Committed to your wellness journey with personalized treatment plans and preventive care.' }}
                    </p>
                </div>
            </div>
            
            <!-- Emergency Contact (if available) -->
            @if($profile->phone)
            <div class="px-6 py-2">
                <a href="tel:{{ $profile->phone }}" class="emergency-btn w-full text-white py-3 px-4 rounded-xl font-bold text-center flex items-center justify-center">
                    <i class="fas fa-phone-alt mr-2"></i>
                    Emergency Contact
                </a>
            </div>
            @endif
            
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
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Phone</div>
                            <div class="text-sm text-gray-600">{{ $profile->phone }}</div>
                        </div>
                        <a href="tel:{{ $profile->phone }}" class="bg-blue-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-600 transition-colors">
                            Call
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->email)
                    <div class="contact-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Email</div>
                            <div class="text-sm text-gray-600">{{ $profile->email }}</div>
                        </div>
                        <a href="mailto:{{ $profile->email }}" class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-600 transition-colors">
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
                            <div class="text-sm text-gray-600">Visit our clinic</div>
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
                    <i class="fas fa-stethoscope text-blue-600 mr-2"></i>
                    Healthcare Services
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-user-md text-blue-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Consultation</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-heartbeat text-red-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Health Checkup</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-pills text-green-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Treatment</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-dumbbell text-purple-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Wellness</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-calendar-check text-orange-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Appointments</div>
                    </div>
                    <div class="service-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-ambulance text-red-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Emergency</div>
                    </div>
                </div>
            </div>
            
            <!-- Social Links -->
            @if($socialLinks->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-share-alt text-blue-600 mr-2"></i>
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
                    <i class="fas fa-images text-blue-600 mr-2"></i>
                    Clinic Gallery
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
                <a href="tel:{{ $profile->phone }}" class="appointment-btn w-full text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center">
                    <i class="fas fa-calendar-plus mr-2"></i>
                    Book Appointment
                </a>
                @endif
                
                @if($profile->email)
                <a href="mailto:{{ $profile->email }}" class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center hover:from-blue-600 hover:to-cyan-600 transition-all">
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
            <div class="px-6 py-4 bg-blue-50 text-center border-t border-blue-200">
                <div class="flex items-center justify-center text-blue-700 text-sm mb-2">
                    <i class="fas fa-shield-alt mr-2"></i>
                    <span>Your Health, Our Priority</span>
                    <i class="fas fa-heart ml-2 text-red-500 heartbeat"></i>
                </div>
                <div class="text-xs text-gray-500">
                    Licensed Healthcare Professional
                </div>
                <div class="text-xs text-gray-400 mt-1">
                    Powered by Smart Tag Health
                </div>
            </div>
        </div>
    </div>
    
    <!-- vCard Download Script -->
    <script>
        function downloadVCard() {
            const vCardData = `BEGIN:VCARD
VERSION:3.0
FN:{{ $profile->display_name ?? $user->name ?? 'Dr. Health Expert' }}
ORG:{{ $profile->profession ?? 'Healthcare Professional' }}
TITLE:{{ $profile->profession ?? 'Healthcare Professional' }}
TEL:{{ $profile->phone ?? '' }}
EMAIL:{{ $profile->email ?? '' }}
URL:{{ $profile->website ?? '' }}
NOTE:{{ $profile->bio ?? 'Dedicated healthcare professional committed to your wellness journey.' }}
END:VCARD`;
            
            const blob = new Blob([vCardData], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($profile->display_name ?? $user->name ?? 'dr-health-expert') }}.vcf';
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
            
            // Emergency button pulse effect
            const emergencyBtn = document.querySelector('.emergency-btn');
            if (emergencyBtn) {
                setInterval(() => {
                    emergencyBtn.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        emergencyBtn.style.transform = 'scale(1)';
                    }, 200);
                }, 3000);
            }
            
            // Health tip tooltip (optional enhancement)
            const healthTip = document.createElement('div');
            healthTip.className = 'fixed bottom-4 right-4 bg-green-500 text-white p-3 rounded-lg shadow-lg text-sm max-w-xs opacity-0 transition-opacity duration-300';
            healthTip.innerHTML = '<i class="fas fa-lightbulb mr-2"></i>Remember to stay hydrated and maintain regular checkups!';
            document.body.appendChild(healthTip);
            
            // Show health tip after 5 seconds
            setTimeout(() => {
                healthTip.style.opacity = '1';
                setTimeout(() => {
                    healthTip.style.opacity = '0';
                }, 4000);
            }, 5000);
        });
    </script>
</body>
</html>
