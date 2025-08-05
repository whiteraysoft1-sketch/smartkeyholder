<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->display_name ?: $user->name }} - Real Estate Professional</title>
    <meta name="description" content="{{ $profile->bio ?: 'Professional Real Estate & Property Management Services' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $profile->pwa_icon ? Storage::disk('public')->url($profile->pwa_icon) : '/favicon.ico' }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                        'playfair': ['Playfair Display', 'serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'rotate-slow': 'rotate 20s linear infinite',
                        'bounce-gentle': 'bounceGentle 2s ease-in-out infinite',
                        'property-slide': 'propertySlide 15s linear infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(40px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        bounceGentle: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-5px)' },
                        },
                        propertySlide: {
                            '0%': { transform: 'translateX(0)' },
                            '100%': { transform: 'translateX(-100%)' },
                        },
                    }
                }
            }
        }
    </script>

    <style>
        /* Real Estate Professional Theme */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #334155 50%, #475569 75%, #64748b 100%);
            background-size: 400% 400%;
            animation: realEstateGradient 20s ease infinite;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        @keyframes realEstateGradient {
            0% { background-position: 0% 50%; }
            25% { background-position: 100% 50%; }
            50% { background-position: 0% 100%; }
            75% { background-position: 100% 0%; }
            100% { background-position: 0% 50%; }
        }

        .property-glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(25px) saturate(2);
            -webkit-backdrop-filter: blur(25px) saturate(2);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow:
                0 8px 32px 0 rgba(15, 23, 42, 0.4),
                0 4px 16px 0 rgba(30, 41, 59, 0.3),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.5);
            position: relative;
            overflow: hidden;
        }

        .property-glass::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #d4af37, #ffd700, #ffed4e, #d4af37);
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .property-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px) saturate(1.8);
            -webkit-backdrop-filter: blur(20px) saturate(1.8);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow:
                0 4px 20px 0 rgba(15, 23, 42, 0.3),
                0 2px 8px 0 rgba(30, 41, 59, 0.2),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .property-card:hover {
            background: rgba(255, 255, 255, 0.18);
            transform: translateY(-3px) scale(1.02);
            box-shadow:
                0 8px 30px 0 rgba(15, 23, 42, 0.4),
                0 4px 15px 0 rgba(30, 41, 59, 0.3),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.4);
        }

        .real-estate-primary {
            background: linear-gradient(135deg, #d4af37 0%, #ffd700 50%, #ffed4e 100%);
        }

        .real-estate-secondary {
            background: linear-gradient(135deg, #1f2937 0%, #374151 50%, #4b5563 100%);
        }

        .real-estate-accent {
            background: linear-gradient(135deg, #7c2d12 0%, #dc2626 50%, #ef4444 100%);
        }

        .real-estate-luxury {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
        }

        .professional-ring {
            background: conic-gradient(from 0deg, #d4af37, #ffd700, #ffed4e, #1f2937, #374151, #d4af37);
            animation: professional-rotate 12s linear infinite;
            padding: 4px;
            border-radius: 50%;
            position: relative;
        }

        .professional-ring::before {
            content: '';
            position: absolute;
            inset: 2px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            backdrop-filter: blur(10px);
        }

        @keyframes professional-rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .floating-property-icon {
            position: absolute;
            opacity: 0.3;
            animation: float 8s ease-in-out infinite;
            pointer-events: none;
            color: rgba(212, 175, 55, 0.8);
            text-shadow: 0 0 20px rgba(212, 175, 55, 0.6);
            transition: all 0.3s ease;
        }

        .floating-property-icon:hover {
            opacity: 0.8;
            transform: scale(1.2);
            text-shadow: 0 0 30px rgba(255, 215, 0, 0.9);
        }

        .floating-property-icon:nth-child(2) { animation-delay: -2s; }
        .floating-property-icon:nth-child(3) { animation-delay: -4s; }
        .floating-property-icon:nth-child(4) { animation-delay: -6s; }

        .property-stats-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.3);
            animation: bounce-gentle 2s ease-in-out infinite;
        }

        .property-stats-dot:nth-child(1) { background: #d4af37; animation-delay: 0s; }
        .property-stats-dot:nth-child(2) { background: #ffd700; animation-delay: 0.2s; }
        .property-stats-dot:nth-child(3) { background: #ffed4e; animation-delay: 0.4s; }
        .property-stats-dot:nth-child(4) { background: #1f2937; animation-delay: 0.6s; }
        .property-stats-dot:nth-child(5) { background: #374151; animation-delay: 0.8s; }

        .real-estate-save-btn {
            background: linear-gradient(135deg, #d4af37 0%, #ffd700 50%, #ffed4e 100%);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.4);
            color: #1f2937 !important;
        }

        .real-estate-save-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.8s ease;
        }

        .real-estate-save-btn:hover::before {
            left: 100%;
        }

        .real-estate-save-btn:hover {
            box-shadow: 0 12px 35px rgba(212, 175, 55, 0.6);
            transform: translateY(-2px) scale(1.05);
        }

        .property-glass-dark {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px) saturate(1.5);
            -webkit-backdrop-filter: blur(15px) saturate(1.5);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        @keyframes property-pulse {
            0%, 100% { 
                box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.7);
            }
            50% { 
                box-shadow: 0 0 0 20px rgba(212, 175, 55, 0);
            }
        }

        .property-pulse {
            animation: property-pulse 2s infinite;
        }

        .property-hover-lift:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 15px 40px rgba(212, 175, 55, 0.4);
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }

        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .service-icon {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .service-icon:hover {
            transform: translateY(-3px) scale(1.1) rotate(5deg);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto relative">
        
        <!-- Floating Property Icons -->
        <div class="floating-property-icon top-10 left-8 text-white text-3xl">
            <i class="fas fa-home"></i>
        </div>
        <div class="floating-property-icon top-20 right-12 text-white text-2xl">
            <i class="fas fa-building"></i>
        </div>
        <div class="floating-property-icon bottom-32 left-6 text-white text-xl">
            <i class="fas fa-key"></i>
        </div>
        <div class="floating-property-icon bottom-20 right-8 text-white text-2xl">
            <i class="fas fa-chart-line"></i>
        </div>

        <div class="property-glass overflow-hidden shadow-2xl relative property-hover-lift">
            
            <!-- Header with Background -->
            <div class="relative h-40 overflow-hidden
                @if($profile->background_image_url)
                    bg-cover bg-center
                @else
                    real-estate-primary
                @endif"
                @if($profile->background_image_url)
                    style="background-image: url('{{ $profile->background_image_url }}');"
                @endif>
                
                <!-- Overlay -->
                <div class="absolute inset-0 bg-gradient-to-br from-blue-900/60 via-blue-800/40 to-transparent"></div>
                
                <!-- Property Stats Dots -->
                <div class="absolute top-4 right-4 flex space-x-2">
                    <div class="property-stats-dot"></div>
                    <div class="property-stats-dot"></div>
                    <div class="property-stats-dot"></div>
                    <div class="property-stats-dot"></div>
                    <div class="property-stats-dot"></div>
                </div>
                
                <!-- Professional Badge -->
                <div class="absolute top-4 left-4 real-estate-secondary text-white px-3 py-1 rounded-full text-xs font-semibold">
                    <i class="fas fa-certificate mr-1"></i>
                    Licensed Professional
                </div>
            </div>
            
            <!-- Profile Section -->
            <div class="relative px-6 pt-2 pb-6 text-center">
                <!-- Profile Image with Professional Ring -->
                <div class="relative inline-block -mt-20 mb-4">
                    <div class="professional-ring w-36 h-36 rounded-full flex items-center justify-center property-pulse">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'Agent') . '&background=d4af37&color=1f2937&size=144' }}" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-white/30 relative z-10 hover:scale-105 transition-transform duration-300" 
                             alt="Profile Photo">
                    </div>
                    <!-- Professional Badge -->
                    <div class="absolute -bottom-2 -right-2 real-estate-accent text-white rounded-full w-12 h-12 flex items-center justify-center text-lg shadow-lg">
                        <i class="fas fa-home"></i>
                    </div>
                </div>
                
                <!-- Name and Title -->
                <h1 class="font-playfair text-2xl font-bold text-white mb-2 animate-on-scroll">
                    {{ $profile->display_name ?: $user->name }}
                </h1>
                <p class="text-white/90 font-semibold text-lg mb-2 animate-on-scroll">
                    {{ $profile->profession ?? 'Real Estate Professional' }}
                </p>
                
                <!-- Action Buttons -->
                <div class="flex items-center justify-center space-x-3 mb-4 animate-on-scroll">
                    @if($profile->phone)
                    <a href="tel:{{ $profile->phone }}" 
                       class="flex items-center justify-center real-estate-primary text-white px-5 py-2.5 rounded-full font-semibold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fas fa-phone mr-2"></i>
                        Call
                    </a>
                    @endif
                    
                    @if($profile->email ?? $user->email)
                    <a href="mailto:{{ $profile->email ?? $user->email }}" 
                       class="flex items-center justify-center real-estate-secondary text-white px-5 py-2.5 rounded-full font-semibold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fas fa-envelope mr-2"></i>
                        Email
                    </a>
                    @endif
                </div>
                
                @if($profile->location)
                <div class="flex items-center justify-center text-white/90 text-sm mb-4 animate-on-scroll">
                    <i class="fas fa-map-marker-alt text-white/70 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
                
                <!-- Bio -->
                @if($profile->bio)
                <div class="property-card rounded-xl p-4 mb-6 text-left animate-on-scroll">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-quote-left text-white/70 mr-2"></i>
                        <h3 class="font-semibold text-white">About My Services</h3>
                    </div>
                    <p class="text-white/90 text-sm leading-relaxed">{{ $profile->bio }}</p>
                </div>
                @endif
            </div>
            
            <!-- Services Section -->
            <div class="px-6 py-4">
                <h3 class="font-semibold text-white mb-4 flex items-center animate-on-scroll">
                    <i class="fas fa-briefcase text-white/70 mr-2"></i>
                    My Expertise
                </h3>
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <div class="property-card rounded-lg p-3 text-center animate-on-scroll">
                        <div class="real-estate-primary w-12 h-12 rounded-full flex items-center justify-center text-white mx-auto mb-2">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="text-white text-xs font-medium">Residential</div>
                    </div>
                    <div class="property-card rounded-lg p-3 text-center animate-on-scroll">
                        <div class="real-estate-secondary w-12 h-12 rounded-full flex items-center justify-center text-white mx-auto mb-2">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="text-white text-xs font-medium">Commercial</div>
                    </div>
                    <div class="property-card rounded-lg p-3 text-center animate-on-scroll">
                        <div class="real-estate-accent w-12 h-12 rounded-full flex items-center justify-center text-white mx-auto mb-2">
                            <i class="fas fa-key"></i>
                        </div>
                        <div class="text-white text-xs font-medium">Property Mgmt</div>
                    </div>
                    <div class="property-card rounded-lg p-3 text-center animate-on-scroll">
                        <div class="real-estate-luxury w-12 h-12 rounded-full flex items-center justify-center text-white mx-auto mb-2">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="text-white text-xs font-medium">Investment</div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="px-6 py-4">
                <h3 class="font-semibold text-white mb-4 flex items-center animate-on-scroll">
                    <i class="fas fa-address-book text-white/70 mr-2"></i>
                    Contact Information
                </h3>
                <div class="space-y-3">
                    @if($profile->phone)
                    <div class="property-card rounded-lg p-3 flex items-center animate-on-scroll">
                        <div class="w-10 h-10 real-estate-primary rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-white">Phone</div>
                            <div class="text-sm text-white/80">{{ $profile->phone }}</div>
                        </div>
                        <a href="tel:{{ $profile->phone }}" class="real-estate-primary text-white px-3 py-1 rounded-lg text-sm hover:opacity-90 transition-all">
                            Call
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->email ?? $user->email)
                    <div class="property-card rounded-lg p-3 flex items-center animate-on-scroll">
                        <div class="w-10 h-10 real-estate-secondary rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-white">Email</div>
                            <div class="text-sm text-white/80">{{ $profile->email ?? $user->email }}</div>
                        </div>
                        <a href="mailto:{{ $profile->email ?? $user->email }}" class="real-estate-secondary text-white px-3 py-1 rounded-lg text-sm hover:opacity-90 transition-all">
                            Email
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->website)
                    <div class="property-card rounded-lg p-3 flex items-center animate-on-scroll">
                        <div class="w-10 h-10 real-estate-accent rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-white">Website</div>
                            <div class="text-sm text-white/80">{{ $profile->website }}</div>
                        </div>
                        <a href="{{ $profile->website }}" target="_blank" class="real-estate-accent text-white px-3 py-1 rounded-lg text-sm hover:opacity-90 transition-all">
                            Visit
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Social Links -->
            @if($socialLinks && $socialLinks->count() > 0)
            <div class="px-6 py-4">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 real-estate-luxury rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-share-alt text-white"></i>
                    </div>
                    <h2 class="text-lg font-bold text-white">Connect With Me</h2>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank"
                           class="flex items-center p-3 property-glass-dark rounded-xl hover:scale-105 transition-all duration-300 group">
                            <div class="w-8 h-8 {{ $link->platform_color }} rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                <i class="{{ $link->platform_icon }} text-white text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white font-medium text-sm">{{ ucfirst($link->platform) }}</p>
                                <p class="text-white/70 text-xs truncate">{{ $link->display_name ?: 'Visit Profile' }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @else
            <!-- Default Social Message when no links -->
            <div class="px-6 py-4">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 real-estate-luxury rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-share-alt text-white"></i>
                    </div>
                    <h2 class="text-lg font-bold text-white">Connect With Me</h2>
                </div>
                <div class="property-card rounded-xl p-4 text-center animate-on-scroll">
                    <i class="fas fa-handshake text-white/70 text-3xl mb-2"></i>
                    <p class="text-white/90 text-sm">
                        Ready to find your dream property?<br>
                        <span class="text-white/70">Contact me for professional real estate services</span>
                    </p>
                </div>
            </div>
            @endif
            
            <!-- Gallery Preview -->
            @if($galleryItems && $galleryItems->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-white mb-4 flex items-center animate-on-scroll">
                    <i class="fas fa-images text-white/70 mr-2"></i>
                    Featured Properties
                </h3>
                <div class="grid grid-cols-3 gap-2">
                    @foreach($galleryItems->take(6) as $item)
                    <div class="property-card rounded-lg overflow-hidden aspect-square animate-on-scroll">
                        <img src="{{ $item->image_url }}" 
                             class="w-full h-full object-cover hover:scale-110 transition-transform duration-300" 
                             alt="Property Image">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Save Contact Section -->
            <div class="px-6 py-6 text-center">
                <h3 class="font-semibold text-white mb-4 flex items-center justify-center animate-on-scroll">
                    <i class="fas fa-address-book text-white/70 mr-2"></i>
                    Save My Contact
                </h3>
                <div class="animate-on-scroll">
                    <button onclick="saveContact()" 
                            class="real-estate-save-btn flex items-center justify-center px-10 py-4 rounded-full font-semibold text-base transition-all duration-300 transform border-2 border-white/20 relative z-10 mx-auto">
                        <i class="fas fa-download mr-3 text-lg"></i>
                        Save Contact
                    </button>
                    <p class="text-white/70 text-xs mt-3 animate-on-scroll">
                        Add to your phone's contacts with one click
                    </p>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 text-center border-t border-white/10">
                <p class="text-white/60 text-xs animate-on-scroll">
                    Professional Real Estate & Property Management Services
                </p>
            </div>
        </div>
    </div>

    <script>
        // Save Contact Function
        function saveContact() {
            // Create vCard data
            const vCardData = `BEGIN:VCARD
VERSION:3.0
FN:{{ Str::replace(["\r", "\n"], '', $profile->display_name ?? $user->name ?? 'Real Estate Professional') }}
ORG:{{ Str::replace(["\r", "\n"], '', $profile->company ?? 'Real Estate & Property Management Services') }}
TITLE:{{ Str::replace(["\r", "\n"], '', $profile->profession ?? 'Real Estate Professional') }}
@if($profile->phone)TEL:{{ $profile->phone }}
@endif
@if($profile->email ?? $user->email)EMAIL:{{ $profile->email ?? $user->email }}
@endif
@if($profile->website)URL:{{ $profile->website }}
@endif
@if($profile->location)ADR:;;{{ Str::replace(["\r", "\n"], '', $profile->location) }};;;;
@endif
@if($profile->bio)NOTE:{{ Str::replace(["\r", "\n"], ' ', $profile->bio) }}
@endif
END:VCARD`;

            // Create blob and download
            const blob = new Blob([vCardData], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = '{{ Str::slug($profile->display_name ?? $user->name ?? 'contact') }}.vcf';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.URL.revokeObjectURL(url);

            // Show success message
            showNotification('Contact saved successfully!', 'success');
        }

        // Notification function
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white font-semibold text-sm transform transition-all duration-300 translate-x-full opacity-0 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-2"></i>
                    ${message}
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full', 'opacity-0');
            }, 100);
            
            // Animate out and remove
            setTimeout(() => {
                notification.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });

        // Add some interactive effects
        document.querySelectorAll('.service-icon').forEach(icon => {
            icon.addEventListener('mouseenter', () => {
                icon.style.transform = 'translateY(-3px) scale(1.05) rotate(5deg)';
            });
            
            icon.addEventListener('mouseleave', () => {
                icon.style.transform = 'translateY(0) scale(1) rotate(0deg)';
            });
        });

        // Enhanced hover effects for property cards
        document.querySelectorAll('.property-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-3px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Add property stats animation
        document.querySelectorAll('.property-stats-dot').forEach((dot, index) => {
            dot.addEventListener('mouseenter', () => {
                dot.style.transform = 'scale(1.5)';
                dot.style.boxShadow = '0 0 20px rgba(255, 255, 255, 0.8)';
            });
            
            dot.addEventListener('mouseleave', () => {
                dot.style.transform = 'scale(1)';
                dot.style.boxShadow = 'none';
            });
        });
    </script>
</body>
</html>