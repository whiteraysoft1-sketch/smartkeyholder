<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->display_name ?: $user->name }} - Blood Donation</title>
    <meta name="description" content="{{ $profile->bio ?: 'Blood Donation Profile' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $profile->pwa_icon ? Storage::disk('public')->url($profile->pwa_icon) : '/favicon.ico' }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'heartbeat': 'heartbeat 1.2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
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
                        heartbeat: {
                            '0%, 100%': { transform: 'scale(1)' },
                            '14%': { transform: 'scale(1.1)' },
                            '28%': { transform: 'scale(1)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Blood Donation Liquid Glass UI - Red & White Theme */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 50%, #7f1d1d 100%);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .liquid-glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px) saturate(1.8);
            -webkit-backdrop-filter: blur(20px) saturate(1.8);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow:
                0 8px 32px 0 rgba(220, 38, 38, 0.3),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.5),
                0 1px 0 0 rgba(255, 255, 255, 0.25);
            position: relative;
            overflow: hidden;
        }

        .liquid-glass::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
        }

        .liquid-glass-dark {
            background: rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(20px) saturate(1.8);
            -webkit-backdrop-filter: blur(20px) saturate(1.8);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow:
                0 8px 32px 0 rgba(0, 0, 0, 0.2),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.2);
        }

        .blood-gradient {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%);
        }

        .blood-light-gradient {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #b91c1c 100%);
        }

        .blood-pattern {
            background-image:
                radial-gradient(circle at 2px 2px, rgba(255,255,255,0.1) 1px, transparent 0);
            background-size: 20px 20px;
        }

        .glow-effect-red {
            box-shadow: 0 0 20px rgba(220, 38, 38, 0.5);
        }

        .blood-donation-btn {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .blood-donation-btn:hover {
            background: linear-gradient(135deg, #991b1b 0%, #7f1d1d 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.5);
        }

        .blood-donation-btn:active {
            transform: translateY(0);
        }

        /* Professional animations */
        .animate-slide-in-left {
            animation: slideInLeft 0.6s ease-out;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.6s ease-out;
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        /* Background effects */
        .blood-bg {
            background:
                radial-gradient(ellipse at top, rgba(220, 38, 38, 0.3) 0%, transparent 50%),
                radial-gradient(ellipse at bottom, rgba(153, 27, 27, 0.3) 0%, transparent 50%),
                linear-gradient(135deg, #7f1d1d 0%, #991b1b 50%, #b91c1c 100%);
        }

        /* Responsive text sizes */
        @media (max-width: 640px) {
            .liquid-glass {
                border-radius: 16px;
            }
        }

        /* Blood drop animation */
        .blood-drop {
            display: inline-block;
        }

        .blood-drop::before {
            content: '🩸';
            animation: heartbeat 1.2s ease-in-out infinite;
        }
    </style>
</head>
<body class="blood-bg min-h-screen">
    <!-- Background Pattern -->
    <div class="fixed inset-0 blood-pattern opacity-20"></div>

    <!-- Main Container -->
    <div class="relative min-h-screen py-4 px-4 sm:py-8">
        <div class="max-w-md mx-auto space-y-6">

            <!-- Header Profile Card -->
            <div class="liquid-glass p-6 text-center animate-fade-in">
                <!-- Background Image -->
                @if($profile->background_image)
                    <div class="absolute inset-0 rounded-2xl overflow-hidden">
                        <img src="{{ $profile->background_image_url }}"
                             alt="Background"
                             class="w-full h-full object-cover opacity-20">
                        <div class="absolute inset-0 bg-gradient-to-t from-red-900/80 to-transparent"></div>
                    </div>
                @endif

                <div class="relative z-10">
                    <!-- Blood Donation Badge -->
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                        <div class="bg-white text-red-600 rounded-full p-3 shadow-lg">
                            <i class="fas fa-droplet text-2xl"></i>
                        </div>
                    </div>

                    <!-- Profile Image -->
                    <div class="mb-6 animate-float mt-4">
                        @if($profile->profile_image)
                            <img src="{{ $profile->profile_image_url }}"
                                 alt="{{ $profile->display_name ?: $user->name }}"
                                 class="w-28 h-28 rounded-full mx-auto object-cover border-4 border-white shadow-2xl glow-effect-red">
                        @else
                            <div class="w-28 h-28 rounded-full mx-auto blood-gradient flex items-center justify-center border-4 border-white shadow-2xl glow-effect-red">
                                <i class="fas fa-heart text-4xl text-white animate-pulse"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Name and Title -->
                    <h1 class="text-2xl font-bold text-white mb-2 drop-shadow-lg animate-slide-up">
                        {{ $profile->display_name ?: $user->name }}
                    </h1>

                    @if($profile->profession)
                        <p class="text-red-100 font-medium mb-3 animate-slide-up text-lg" style="animation-delay: 0.1s">
                            <i class="fas fa-heartbeat mr-2"></i>{{ $profile->profession }}
                        </p>
                    @else
                        <p class="text-red-100 font-medium mb-3 animate-slide-up text-lg" style="animation-delay: 0.1s">
                            <i class="fas fa-heartbeat mr-2"></i>Blood Donation Center
                        </p>
                    @endif

                    <!-- Call and Email Action Buttons -->
                    <div class="flex items-center justify-center space-x-3 mb-4 flex-wrap gap-2">
                        @if($profile->phone)
                        <a href="tel:{{ $profile->phone }}" 
                           class="flex items-center justify-center bg-white hover:bg-red-50 text-red-600 px-5 py-2 rounded-full font-semibold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <i class="fas fa-phone mr-2"></i>
                            Call
                        </a>
                        @endif
                        
                        @if($profile->email ?? $user->email)
                        <a href="mailto:{{ $profile->email ?? $user->email }}" 
                           class="flex items-center justify-center bg-white hover:bg-red-50 text-red-600 px-5 py-2 rounded-full font-semibold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <i class="fas fa-envelope mr-2"></i>
                            Email
                        </a>
                        @endif

                        <button onclick="downloadVCard()" 
                           class="flex items-center justify-center bg-white hover:bg-red-50 text-red-600 px-5 py-2 rounded-full font-semibold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <i class="fas fa-address-card mr-2"></i>
                            Save Contact
                        </button>
                    </div>

                    @if($profile->location)
                        <div class="flex items-center justify-center text-red-100 text-sm mb-3 animate-slide-up" style="animation-delay: 0.2s">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $profile->location }}
                        </div>
                    @endif

                    @if($profile->bio)
                        <p class="text-white/90 text-sm leading-relaxed animate-slide-up" style="animation-delay: 0.3s">
                            {{ $profile->bio }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Donation Information -->
            <div class="liquid-glass p-5 animate-slide-in-left">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 blood-gradient rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-info-circle text-white"></i>
                    </div>
                    <h2 class="text-lg font-bold text-white">Donation Information</h2>
                </div>

                <div class="space-y-3">
                    @if($user->email)
                        <div class="flex items-center p-3 liquid-glass-dark rounded-xl hover:scale-105 transition-all duration-300 group">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-50">
                                <i class="fas fa-envelope text-red-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Email</p>
                                <p class="text-red-100 text-sm break-all">{{ $user->email }}</p>
                            </div>
                        </div>
                    @endif

                    @if($profile->phone)
                        <a href="tel:{{ $profile->phone }}"
                           class="flex items-center p-3 liquid-glass-dark rounded-xl hover:scale-105 transition-all duration-300 group">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-50">
                                <i class="fas fa-phone text-red-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Phone</p>
                                <p class="text-red-100 text-sm">{{ $profile->phone }}</p>
                            </div>
                        </a>
                    @endif

                    @if($profile->website)
                        <a href="{{ $profile->website }}" target="_blank"
                           class="flex items-center p-3 liquid-glass-dark rounded-xl hover:scale-105 transition-all duration-300 group">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-50">
                                <i class="fas fa-globe text-red-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Website</p>
                                <p class="text-red-100 text-sm">{{ parse_url($profile->website, PHP_URL_HOST) }}</p>
                            </div>
                        </a>
                    @endif

                    <div class="flex items-center p-3 liquid-glass-dark rounded-xl bg-white/10">
                        <div class="w-8 h-8 flex items-center justify-center mr-3">
                            <i class="fas fa-droplet text-2xl text-white animate-bounce"></i>
                        </div>
                        <div>
                            <p class="text-white font-medium">Save Lives Today</p>
                            <p class="text-red-100 text-sm">Every donation counts!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            @if($socialLinks->count() > 0)
                <div class="liquid-glass p-5 animate-slide-in-right">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 blood-gradient rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-share-alt text-white"></i>
                        </div>
                        <h2 class="text-lg font-bold text-white">Connect With Us</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach($socialLinks as $index => $link)
                            @php
                                $platformColors = [
                                    'facebook' => 'bg-blue-500 hover:bg-blue-600',
                                    'twitter' => 'bg-blue-400 hover:bg-blue-500',
                                    'instagram' => 'bg-pink-500 hover:bg-pink-600',
                                    'linkedin' => 'bg-blue-700 hover:bg-blue-800',
                                    'whatsapp' => 'bg-green-500 hover:bg-green-600',
                                    'youtube' => 'bg-red-600 hover:bg-red-700',
                                    'tiktok' => 'bg-black hover:bg-gray-800',
                                    'telegram' => 'bg-blue-400 hover:bg-blue-500',
                                ];
                                $color = $platformColors[strtolower($link->platform)] ?? 'bg-gray-500 hover:bg-gray-600';
                                $icon = match(strtolower($link->platform)) {
                                    'facebook' => 'fab fa-facebook-f',
                                    'twitter' => 'fab fa-twitter',
                                    'instagram' => 'fab fa-instagram',
                                    'linkedin' => 'fab fa-linkedin-in',
                                    'whatsapp' => 'fab fa-whatsapp',
                                    'youtube' => 'fab fa-youtube',
                                    'tiktok' => 'fab fa-tiktok',
                                    'telegram' => 'fab fa-telegram',
                                    default => 'fas fa-link'
                                };
                            @endphp
                            <a href="{{ $link->url }}" target="_blank" rel="noopener"
                               class="group flex flex-col items-center justify-center {{ $color }} text-white py-4 rounded-xl transition-all duration-300 transform hover:scale-110 shadow-lg hover:shadow-xl"
                               title="{{ $link->platform }}">
                                <i class="{{ $icon }} text-xl mb-2"></i>
                                <span class="text-xs font-semibold capitalize">{{ $link->platform }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Gallery Section -->
            @if($galleryItems->count() > 0)
                <div class="liquid-glass p-5 animate-slide-in-left">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 blood-gradient rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-images text-white"></i>
                        </div>
                        <h2 class="text-lg font-bold text-white">Gallery</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach($galleryItems->take(4) as $item)
                            <div class="group relative rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                                     class="w-full h-32 object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-3">
                                    @if($item->title)
                                        <p class="text-white text-xs font-semibold">{{ $item->title }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($galleryItems->count() > 4)
                        <p class="text-red-100 text-center text-xs mt-3">+{{ $galleryItems->count() - 4 }} more photos</p>
                    @endif
                </div>
            @endif

            <!-- Store Section -->
            @if($profile->store_enabled && $storeProducts->count() > 0)
                <div class="liquid-glass p-5 animate-slide-in-right">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 blood-gradient rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-shopping-bag text-white"></i>
                        </div>
                        <h2 class="text-lg font-bold text-white">{{ $profile->store_name ?: 'Store' }}</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-4">
                        @foreach($storeProducts->take(4) as $product)
                            <div class="liquid-glass-dark rounded-lg overflow-hidden hover:scale-105 transition-transform duration-300 cursor-pointer">
                                @if($product->image)
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                         class="w-full h-20 object-cover">
                                @else
                                    <div class="w-full h-20 bg-red-600 flex items-center justify-center">
                                        <i class="fas fa-cube text-white text-xl"></i>
                                    </div>
                                @endif
                                <div class="p-2">
                                    <p class="text-white text-xs font-semibold truncate">{{ $product->name }}</p>
                                    <p class="text-red-200 text-xs">{{ $profile->currency_symbol }}{{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($profile->store_whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->store_whatsapp) }}?text=Hi%20I%20am%20interested%20in%20your%20products" 
                           target="_blank"
                           class="w-full blood-donation-btn text-white py-3 rounded-xl font-semibold flex items-center justify-center hover:shadow-xl transition-all duration-300">
                            <i class="fab fa-whatsapp mr-2"></i>
                            Order on WhatsApp
                        </a>
                    @endif
                </div>
            @endif

            <!-- Footer CTA -->
            <div class="liquid-glass p-5 text-center animate-fade-in" style="animation-delay: 0.4s">
                <div class="flex items-center justify-center mb-3">
                    <i class="fas fa-heart text-2xl text-red-300 mr-2 animate-heartbeat"></i>
                    <i class="fas fa-heart text-2xl text-red-300 animate-heartbeat" style="animation-delay: 0.2s"></i>
                </div>
                <p class="text-white font-semibold">Help Save Lives</p>
                <p class="text-red-100 text-xs mt-1">Every donation makes a difference</p>
            </div>

        </div>
    </div>

    <!-- vCard Download Script -->
    <script>
        function downloadVCard() {
            const contactName = "{{ $profile->display_name ?: $user->name }}";
            const email = "{{ $profile->email ?? $user->email }}";
            const phone = "{{ $profile->phone ?? '' }}";
            const location = "{{ $profile->location ?? '' }}";
            const bio = "{{ $profile->bio ?? '' }}";
            const website = "{{ $profile->website ?? '' }}";
            
            let vcard = "BEGIN:VCARD\n";
            vcard += "VERSION:3.0\n";
            vcard += "FN:" + contactName + "\n";
            vcard += "N:" + contactName.split(' ').reverse().join(';') + ";;;\n";
            
            if (email) {
                vcard += "EMAIL:" + email + "\n";
            }
            
            if (phone) {
                vcard += "TEL;TYPE=VOICE:" + phone + "\n";
            }
            
            if (location) {
                vcard += "ADR:;;;" + location + ";;;;\n";
            }
            
            if (website) {
                vcard += "URL:" + website + "\n";
            }
            
            vcard += "NOTE:Blood Donation Center - Help Save Lives\n";
            vcard += "ORG:Blood Donation Center\n";
            vcard += "END:VCARD";
            
            const element = document.createElement("a");
            element.setAttribute("href", "data:text/plain;charset=utf-8," + encodeURIComponent(vcard));
            element.setAttribute("download", contactName.replace(/\s+/g, '_') + ".vcf");
            element.style.display = "none";
            document.body.appendChild(element);
            element.click();
            document.body.removeChild(element);
        }
    </script>

    <!-- PWA Meta Tags -->
    @if($profile->pwa_enabled)
        <link rel="manifest" href="{{ route('pwa.manifest', ['uuid' => $qrCode->uuid]) }}">
        <meta name="theme-color" content="#dc2626">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="{{ $profile->pwa_app_name ?: 'Blood Donation' }}">
        <link rel="apple-touch-icon" href="{{ $profile->pwa_icon_url }}">
    @endif
</body>
</html>