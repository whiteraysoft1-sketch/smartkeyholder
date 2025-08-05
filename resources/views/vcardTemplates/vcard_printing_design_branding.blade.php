<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->display_name ?: $user->name }} - Printing & Design Professional</title>
    <meta name="description" content="{{ $profile->bio ?: 'Professional Printing, Design & Branding Services' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $profile->pwa_icon ? Storage::disk('public')->url($profile->pwa_icon) : '/favicon.ico' }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                        'playfair': ['Playfair Display', 'serif'],
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'rotate-slow': 'rotate 20s linear infinite',
                        'bounce-gentle': 'bounceGentle 2s ease-in-out infinite',
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
                        rotate: {
                            '0%': { transform: 'rotate(0deg)' },
                            '100%': { transform: 'rotate(360deg)' },
                        },
                        bounceGentle: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-5px)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Instagram-Style Printing & Design Professional Theme */
        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #833ab4 0%, #fd1d1d 25%, #fcb045 50%, #833ab4 75%, #fd1d1d 100%);
            background-size: 400% 400%;
            animation: instagramGradient 20s ease infinite;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        @keyframes instagramGradient {
            0% { background-position: 0% 50%; }
            25% { background-position: 100% 50%; }
            50% { background-position: 0% 100%; }
            75% { background-position: 100% 0%; }
            100% { background-position: 0% 50%; }
        }

        .instagram-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(25px) saturate(2);
            -webkit-backdrop-filter: blur(25px) saturate(2);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow:
                0 8px 32px 0 rgba(131, 58, 180, 0.3),
                0 4px 16px 0 rgba(253, 29, 29, 0.2),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.4);
            position: relative;
            overflow: hidden;
        }

        .instagram-glass::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #833ab4, #fd1d1d, #fcb045, #833ab4);
            background-size: 200% 100%;
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .instagram-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px) saturate(1.8);
            -webkit-backdrop-filter: blur(20px) saturate(1.8);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow:
                0 4px 20px 0 rgba(131, 58, 180, 0.2),
                0 2px 8px 0 rgba(253, 29, 29, 0.1),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.25);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .instagram-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-3px) scale(1.02);
            box-shadow:
                0 8px 30px 0 rgba(131, 58, 180, 0.3),
                0 4px 15px 0 rgba(253, 29, 29, 0.2),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.4);
        }

        .instagram-primary {
            background: linear-gradient(135deg, #833ab4 0%, #fd1d1d 50%, #fcb045 100%);
        }

        .instagram-secondary {
            background: linear-gradient(135deg, #405de6 0%, #5851db 25%, #833ab4 50%, #c13584 75%, #e1306c 100%);
        }

        .instagram-accent {
            background: linear-gradient(135deg, #f58529 0%, #dd2a7b 50%, #8134af 100%);
        }

        .instagram-story {
            background: linear-gradient(135deg, #feda75 0%, #fa7e1e 25%, #d62976 50%, #962fbf 75%, #4f5bd5 100%);
        }

        .instagram-glass-dark {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px) saturate(1.5);
            -webkit-backdrop-filter: blur(15px) saturate(1.5);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .floating-icon {
            position: absolute;
            opacity: 0.3;
            animation: float 8s ease-in-out infinite;
            pointer-events: none;
            color: rgba(255, 255, 255, 0.6);
            text-shadow: 0 0 20px rgba(131, 58, 180, 0.5);
            transition: all 0.3s ease;
        }

        .floating-icon:hover {
            opacity: 0.7;
            transform: scale(1.2);
            text-shadow: 0 0 30px rgba(253, 29, 29, 0.8);
        }

        .floating-icon:nth-child(2) { animation-delay: -2s; }
        .floating-icon:nth-child(3) { animation-delay: -4s; }
        .floating-icon:nth-child(4) { animation-delay: -6s; }

        .instagram-story-ring {
            background: conic-gradient(from 0deg, #feda75, #fa7e1e, #d62976, #962fbf, #4f5bd5, #feda75);
            animation: instagram-rotate 8s linear infinite;
            padding: 4px;
            border-radius: 50%;
            position: relative;
        }

        .instagram-story-ring::before {
            content: '';
            position: absolute;
            inset: 2px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            backdrop-filter: blur(10px);
        }

        @keyframes instagram-rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes instagram-pulse {
            0%, 100% { 
                box-shadow: 0 0 0 0 rgba(131, 58, 180, 0.7);
            }
            50% { 
                box-shadow: 0 0 0 20px rgba(131, 58, 180, 0);
            }
        }

        .instagram-pulse {
            animation: instagram-pulse 2s infinite;
        }

        .instagram-hover-lift:hover {
            transform: translateY(-5px) scale(1.03);
            box-shadow: 0 15px 40px rgba(131, 58, 180, 0.4);
        }

        .service-icon {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .service-icon:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .text-shadow-glow {
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
        }

        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .color-palette {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin: 16px 0;
        }

        .color-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.3);
            animation: bounce-gentle 2s ease-in-out infinite;
        }

        .color-dot:nth-child(1) { background: #833ab4; animation-delay: 0s; }
        .color-dot:nth-child(2) { background: #fd1d1d; animation-delay: 0.2s; }
        .color-dot:nth-child(3) { background: #fcb045; animation-delay: 0.4s; }
        .color-dot:nth-child(4) { background: #e1306c; animation-delay: 0.6s; }
        .color-dot:nth-child(5) { background: #405de6; animation-delay: 0.8s; }

        .instagram-save-btn {
            background: linear-gradient(135deg, #833ab4 0%, #fd1d1d 50%, #fcb045 100%);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(131, 58, 180, 0.4);
        }

        .instagram-save-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.8s ease;
        }

        .instagram-save-btn:hover::before {
            left: 100%;
        }

        .instagram-save-btn:hover {
            box-shadow: 0 12px 35px rgba(131, 58, 180, 0.6);
            transform: translateY(-2px) scale(1.05);
        }

        .social-link-enhanced {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .social-link-enhanced::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.3s ease;
        }

        .social-link-enhanced:hover::before {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto relative">
        
        <!-- Floating Design Icons -->
        <div class="floating-icon top-10 left-8 text-white text-3xl">
            <i class="fas fa-palette"></i>
        </div>
        <div class="floating-icon top-20 right-12 text-white text-2xl">
            <i class="fas fa-print"></i>
        </div>
        <div class="floating-icon bottom-32 left-6 text-white text-xl">
            <i class="fas fa-pen-nib"></i>
        </div>
        <div class="floating-icon bottom-20 right-8 text-white text-2xl">
            <i class="fas fa-brush"></i>
        </div>

        <div class="instagram-glass overflow-hidden shadow-2xl relative instagram-hover-lift">
            
            <!-- Header with Background -->
            <div class="relative h-40 overflow-hidden
                @if($profile->background_image_url)
                    bg-cover bg-center
                @else
                    instagram-primary
                @endif"
                @if($profile->background_image_url)
                    style="background-image: url('{{ $profile->background_image_url }}');"
                @endif>
                <div class="absolute inset-0 bg-gradient-to-br from-black/20 via-transparent to-black/20"></div>
                
                <!-- Creative Elements -->
                <div class="absolute top-4 right-4">
                    <div class="service-icon w-12 h-12 rounded-full flex items-center justify-center">
                        <i class="fas fa-magic text-white text-lg"></i>
                    </div>
                </div>
                <div class="absolute bottom-4 left-4">
                    <div class="service-icon w-10 h-10 rounded-full flex items-center justify-center">
                        <i class="fas fa-star text-white"></i>
                    </div>
                </div>
                
                <!-- Color Palette Display -->
                <div class="absolute bottom-2 left-1/2 transform -translate-x-1/2">
                    <div class="color-palette">
                        <div class="color-dot"></div>
                        <div class="color-dot"></div>
                        <div class="color-dot"></div>
                        <div class="color-dot"></div>
                        <div class="color-dot"></div>
                    </div>
                </div>
            </div>
            
            <!-- Profile Section -->
            <div class="relative px-6 pt-2 pb-6 text-center">
                <!-- Profile Image with Creative Ring -->
                <div class="relative inline-block -mt-20 mb-4">
                    <div class="instagram-story-ring w-36 h-36 rounded-full flex items-center justify-center instagram-pulse">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'Designer') . '&background=833ab4&color=fff&size=144' }}" 
                             class="w-32 h-32 rounded-full object-cover border-4 border-white/30 relative z-10 hover:scale-105 transition-transform duration-300" 
                             alt="Profile Photo">
                    </div>
                    <!-- Professional Badge -->
                    <div class="absolute -bottom-2 -right-2 instagram-secondary text-white rounded-full w-12 h-12 flex items-center justify-center text-lg shadow-lg">
                        <i class="fas fa-award"></i>
                    </div>
                </div>
                
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-white mb-1 text-shadow-glow font-playfair animate-on-scroll">
                    {{ $profile->display_name ?? $user->name ?? 'Design Professional' }}
                </h1>
                <p class="text-white/90 font-semibold text-lg mb-2 animate-on-scroll">
                    {{ $profile->profession ?? 'Printing, Design & Branding Expert' }}
                </p>
                
                <!-- Action Buttons -->
                <div class="flex items-center justify-center space-x-3 mb-4 animate-on-scroll">
                    @if($profile->phone)
                    <a href="tel:{{ $profile->phone }}" 
                       class="flex items-center justify-center instagram-primary text-white px-5 py-2.5 rounded-full font-semibold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fas fa-phone mr-2"></i>
                        Call
                    </a>
                    @endif
                    
                    @if($profile->email ?? $user->email)
                    <a href="mailto:{{ $profile->email ?? $user->email }}" 
                       class="flex items-center justify-center instagram-secondary text-white px-5 py-2.5 rounded-full font-semibold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
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
                <div class="instagram-card rounded-xl p-4 mb-6 text-left animate-on-scroll">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-quote-left text-white/70 mr-2"></i>
                        <h3 class="font-semibold text-white">About Our Services</h3>
                    </div>
                    <p class="text-white/90 text-sm leading-relaxed">{{ $profile->bio }}</p>
                </div>
                @endif
            </div>
            
            <!-- Services Section -->
            <div class="px-6 py-4">
                <h3 class="font-semibold text-white mb-4 flex items-center animate-on-scroll">
                    <i class="fas fa-tools text-white/70 mr-2"></i>
                    Our Expertise
                </h3>
                <div class="grid grid-cols-3 gap-3 mb-6">
                    <div class="instagram-card rounded-lg p-3 text-center animate-on-scroll">
                        <div class="instagram-primary w-12 h-12 rounded-full flex items-center justify-center text-white mx-auto mb-2">
                            <i class="fas fa-print"></i>
                        </div>
                        <div class="text-white text-xs font-medium">Printing</div>
                    </div>
                    <div class="instagram-card rounded-lg p-3 text-center animate-on-scroll">
                        <div class="instagram-secondary w-12 h-12 rounded-full flex items-center justify-center text-white mx-auto mb-2">
                            <i class="fas fa-palette"></i>
                        </div>
                        <div class="text-white text-xs font-medium">Design</div>
                    </div>
                    <div class="instagram-card rounded-lg p-3 text-center animate-on-scroll">
                        <div class="instagram-accent w-12 h-12 rounded-full flex items-center justify-center text-white mx-auto mb-2">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div class="text-white text-xs font-medium">Branding</div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="px-6 py-4">
                <h3 class="font-semibold text-white mb-4 flex items-center animate-on-scroll">
                    <i class="fas fa-address-book text-white/70 mr-2"></i>
                    Get In Touch
                </h3>
                <div class="space-y-3">
                    @if($profile->phone)
                    <div class="instagram-card rounded-lg p-3 flex items-center animate-on-scroll">
                        <div class="w-10 h-10 instagram-primary rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-white">Phone</div>
                            <div class="text-sm text-white/80">{{ $profile->phone }}</div>
                        </div>
                        <a href="tel:{{ $profile->phone }}" class="instagram-primary text-white px-3 py-1 rounded-lg text-sm hover:opacity-90 transition-all">
                            Call
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->email ?? $user->email)
                    <div class="instagram-card rounded-lg p-3 flex items-center animate-on-scroll">
                        <div class="w-10 h-10 instagram-secondary rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-white">Email</div>
                            <div class="text-sm text-white/80">{{ $profile->email ?? $user->email }}</div>
                        </div>
                        <a href="mailto:{{ $profile->email ?? $user->email }}" class="instagram-secondary text-white px-3 py-1 rounded-lg text-sm hover:opacity-90 transition-all">
                            Email
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->website)
                    <div class="instagram-card rounded-lg p-3 flex items-center animate-on-scroll">
                        <div class="w-10 h-10 instagram-accent rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-white">Portfolio</div>
                            <div class="text-sm text-white/80">{{ $profile->website }}</div>
                        </div>
                        <a href="{{ $profile->website }}" target="_blank" class="instagram-accent text-white px-3 py-1 rounded-lg text-sm hover:opacity-90 transition-all">
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
                    <div class="w-10 h-10 instagram-story rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-share-alt text-white"></i>
                    </div>
                    <h2 class="text-lg font-bold text-white">Connect With Us</h2>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank"
                           class="flex items-center p-3 instagram-glass-dark rounded-xl hover:scale-105 transition-all duration-300 group">
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
                    <div class="w-10 h-10 instagram-story rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-share-alt text-white"></i>
                    </div>
                    <h2 class="text-lg font-bold text-white">Connect With Us</h2>
                </div>
                <div class="instagram-card rounded-xl p-4 text-center animate-on-scroll">
                    <i class="fas fa-handshake text-white/70 text-3xl mb-2"></i>
                    <p class="text-white/90 text-sm">
                        Ready to bring your creative vision to life?<br>
                        <span class="text-white/70">Contact us for professional printing, design & branding services</span>
                    </p>
                </div>
            </div>
            @endif
            
            <!-- Gallery Preview -->
            @if($galleryItems && $galleryItems->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-white mb-4 flex items-center animate-on-scroll">
                    <i class="fas fa-images text-white/70 mr-2"></i>
                    Our Work
                </h3>
                <div class="grid grid-cols-3 gap-2">
                    @foreach($galleryItems->take(6) as $item)
                    <div class="instagram-card rounded-lg overflow-hidden aspect-square animate-on-scroll">
                        <img src="{{ $item->image_url }}" 
                             class="w-full h-full object-cover hover:scale-110 transition-transform duration-300" 
                             alt="Gallery Item">
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
                            class="instagram-save-btn flex items-center justify-center text-white px-10 py-4 rounded-full font-semibold text-base transition-all duration-300 transform border-2 border-white/20 relative z-10 mx-auto">
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
                    Professional Printing, Design & Branding Services
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
FN:{{ Str::replace(["\r", "\n"], '', $profile->display_name ?? $user->name ?? 'Design Professional') }}
ORG:{{ Str::replace(["\r", "\n"], '', $profile->company ?? 'Printing, Design & Branding Services') }}
TITLE:{{ Str::replace(["\r", "\n"], '', $profile->profession ?? 'Printing, Design & Branding Expert') }}
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

        // Enhanced hover effects for Instagram cards
        document.querySelectorAll('.instagram-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-3px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0) scale(1)';
            });
        });
    </script>
</body>
</html>