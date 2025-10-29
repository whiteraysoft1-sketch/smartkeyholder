<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->display_name ?: $user->name }} - Fashion Store</title>
    <meta name="description" content="{{ $profile->bio ?: 'Fashion & Clothing Store' }}">
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
                        'sparkle': 'sparkle 1.5s cubic-bezier(0.4, 0, 0.6, 1) infinite',
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
                        sparkle: {
                            '0%, 100%': { opacity: '1', transform: 'scale(1)' },
                            '50%': { opacity: '0.7', transform: 'scale(1.1)' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Cloth Store Liquid Glass UI - Navy & Gold Theme */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #1e3a4a 100%);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .liquid-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px) saturate(1.8);
            -webkit-backdrop-filter: blur(20px) saturate(1.8);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow:
                0 8px 32px 0 rgba(217, 119, 6, 0.15),
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
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(20px) saturate(1.8);
            -webkit-backdrop-filter: blur(20px) saturate(1.8);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow:
                0 8px 32px 0 rgba(0, 0, 0, 0.2),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.2);
        }

        .gold-gradient {
            background: linear-gradient(135deg, #d97706 0%, #b45309 50%, #92400e 100%);
        }

        .gold-light-gradient {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
        }

        .fashion-pattern {
            background-image:
                radial-gradient(circle at 2px 2px, rgba(255,255,255,0.1) 1px, transparent 0);
            background-size: 20px 20px;
        }

        .glow-effect-gold {
            box-shadow: 0 0 20px rgba(217, 119, 6, 0.5);
        }

        .cloth-store-btn {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .cloth-store-btn:hover {
            background: linear-gradient(135deg, #92400e 0%, #78350f 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(217, 119, 6, 0.5);
        }

        .cloth-store-btn:active {
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

        .text-shadow {
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="min-h-screen p-4 py-8">
        <div class="max-w-md mx-auto space-y-4">

            <!-- Header Card with Profile -->
            <div class="liquid-glass p-6 rounded-3xl text-center animate-fade-in overflow-hidden relative">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-5 fashion-pattern"></div>
                
                <div class="relative z-10">
                    <!-- Profile Image -->
                    @if($profile->profile_image)
                        <div class="w-24 h-24 mx-auto mb-4 rounded-full border-4 border-yellow-400 overflow-hidden shadow-2xl transform hover:scale-105 transition-transform duration-300">
                            <img src="{{ Storage::disk('public')->url($profile->profile_image) }}" 
                                 alt="{{ $profile->display_name }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-24 h-24 mx-auto mb-4 rounded-full border-4 border-yellow-400 overflow-hidden shadow-2xl flex items-center justify-center gold-gradient">
                            <i class="fas fa-shirt text-white text-3xl"></i>
                        </div>
                    @endif

                    <!-- Store Name and Title -->
                    @if($profile->display_name)
                        <h1 class="text-2xl font-bold text-white mb-1 text-shadow">
                            {{ $profile->display_name }}
                        </h1>
                        <p class="text-yellow-300 font-medium mb-3 animate-slide-up text-sm" style="animation-delay: 0.1s">
                            <i class="fas fa-shop mr-1"></i>Fashion & Clothing Store
                        </p>
                    @else
                        <p class="text-yellow-300 font-medium mb-3 animate-slide-up text-lg" style="animation-delay: 0.1s">
                            <i class="fas fa-tag mr-2"></i>Cloth Store
                        </p>
                    @endif

                    <!-- Call and Email Action Buttons -->
                    <div class="flex items-center justify-center space-x-3 mb-4 flex-wrap gap-2">
                        @if($profile->phone)
                        <a href="tel:{{ $profile->phone }}" 
                           class="flex items-center justify-center bg-white hover:bg-yellow-50 text-yellow-700 px-5 py-2 rounded-full font-semibold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <i class="fas fa-phone mr-2"></i>
                            Call
                        </a>
                        @endif
                        
                        @if($profile->email ?? $user->email)
                        <a href="mailto:{{ $profile->email ?? $user->email }}" 
                           class="flex items-center justify-center bg-white hover:bg-yellow-50 text-yellow-700 px-5 py-2 rounded-full font-semibold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <i class="fas fa-envelope mr-2"></i>
                            Email
                        </a>
                        @endif

                        <button onclick="downloadVCard()" 
                           class="flex items-center justify-center bg-white hover:bg-yellow-50 text-yellow-700 px-5 py-2 rounded-full font-semibold text-sm transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <i class="fas fa-address-card mr-2"></i>
                            Save Contact
                        </button>
                    </div>

                    @if($profile->location)
                        <div class="flex items-center justify-center text-yellow-200 text-sm mb-3 animate-slide-up" style="animation-delay: 0.2s">
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

            <!-- Store Information -->
            <div class="liquid-glass p-5 animate-slide-in-left">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 gold-gradient rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-info-circle text-white"></i>
                    </div>
                    <h2 class="text-lg font-bold text-white">Store Details</h2>
                </div>

                <div class="space-y-3">
                    @if($user->email)
                        <div class="flex items-center p-3 liquid-glass-dark rounded-xl hover:scale-105 transition-all duration-300 group">
                            <div class="w-8 h-8 bg-yellow-400 rounded-lg flex items-center justify-center mr-3 group-hover:bg-yellow-300">
                                <i class="fas fa-envelope text-slate-900 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Email</p>
                                <p class="text-yellow-200 text-sm break-all">{{ $user->email }}</p>
                            </div>
                        </div>
                    @endif

                    @if($profile->phone)
                        <a href="tel:{{ $profile->phone }}"
                           class="flex items-center p-3 liquid-glass-dark rounded-xl hover:scale-105 transition-all duration-300 group">
                            <div class="w-8 h-8 bg-yellow-400 rounded-lg flex items-center justify-center mr-3 group-hover:bg-yellow-300">
                                <i class="fas fa-phone text-slate-900 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Phone</p>
                                <p class="text-yellow-200 text-sm">{{ $profile->phone }}</p>
                            </div>
                        </a>
                    @endif

                    @if($profile->website)
                        <a href="{{ $profile->website }}" target="_blank"
                           class="flex items-center p-3 liquid-glass-dark rounded-xl hover:scale-105 transition-all duration-300 group">
                            <div class="w-8 h-8 bg-yellow-400 rounded-lg flex items-center justify-center mr-3 group-hover:bg-yellow-300">
                                <i class="fas fa-globe text-slate-900 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Website</p>
                                <p class="text-yellow-200 text-sm">{{ parse_url($profile->website, PHP_URL_HOST) }}</p>
                            </div>
                        </a>
                    @endif

                    <div class="flex items-center p-3 liquid-glass-dark rounded-xl bg-yellow-400/10">
                        <div class="w-8 h-8 flex items-center justify-center mr-3">
                            <i class="fas fa-star text-2xl text-yellow-400 animate-sparkle"></i>
                        </div>
                        <div>
                            <p class="text-white font-medium">Premium Fashion</p>
                            <p class="text-yellow-200 text-sm">Trending Collections!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            @if($socialLinks->count() > 0)
                <div class="liquid-glass p-5 animate-slide-in-right">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 gold-gradient rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-share-alt text-white"></i>
                        </div>
                        <h2 class="text-lg font-bold text-white">Follow Us</h2>
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
                        <div class="w-10 h-10 gold-gradient rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-images text-white"></i>
                        </div>
                        <h2 class="text-lg font-bold text-white">Collection</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach($galleryItems->take(4) as $item)
                            <div class="group relative rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105 border-2 border-yellow-400/30">
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
                        <p class="text-yellow-200 text-center text-xs mt-3">+{{ $galleryItems->count() - 4 }} more items</p>
                    @endif
                </div>
            @endif

            <!-- Store Section -->
            @if($profile->store_enabled && $storeProducts->count() > 0)
                <div class="liquid-glass p-5 animate-slide-in-right">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 gold-gradient rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-shopping-bag text-white"></i>
                        </div>
                        <h2 class="text-lg font-bold text-white">{{ $profile->store_name ?: 'Shop Now' }}</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-4">
                        @foreach($storeProducts->take(4) as $product)
                            <div class="liquid-glass-dark rounded-lg overflow-hidden hover:scale-105 transition-transform duration-300 cursor-pointer border border-yellow-400/20">
                                @if($product->image)
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                         class="w-full h-20 object-cover">
                                @else
                                    <div class="w-full h-20 bg-gradient-to-br from-yellow-600 to-yellow-800 flex items-center justify-center">
                                        <i class="fas fa-tshirt text-white text-xl"></i>
                                    </div>
                                @endif
                                <div class="p-2">
                                    <p class="text-white text-xs font-semibold truncate">{{ $product->name }}</p>
                                    <p class="text-yellow-300 text-xs font-bold">{{ $profile->currency_symbol }}{{ number_format($product->price, 2) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($profile->store_whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->store_whatsapp) }}?text=Hi%20I%20am%20interested%20in%20your%20collection" 
                           target="_blank"
                           class="w-full cloth-store-btn text-white py-3 rounded-xl font-semibold flex items-center justify-center hover:shadow-xl transition-all duration-300">
                            <i class="fab fa-whatsapp mr-2"></i>
                            Order on WhatsApp
                        </a>
                    @endif
                </div>
            @endif

            <!-- Footer CTA -->
            <div class="liquid-glass p-5 text-center animate-fade-in" style="animation-delay: 0.4s">
                <div class="flex items-center justify-center mb-3">
                    <i class="fas fa-star text-2xl text-yellow-400 mr-2 animate-sparkle"></i>
                    <i class="fas fa-star text-2xl text-yellow-400 animate-sparkle" style="animation-delay: 0.2s"></i>
                </div>
                <p class="text-white font-semibold">Fashion Forward Collection</p>
                <p class="text-yellow-200 text-xs mt-1">Premium Quality Clothing</p>
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
            
            vcard += "NOTE:Cloth Store - Fashion & Clothing\n";
            vcard += "ORG:Clothing Store\n";
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
        <meta name="theme-color" content="#d97706">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="{{ $profile->pwa_app_name ?: 'Fashion Store' }}">
        <link rel="apple-touch-icon" href="{{ $profile->pwa_icon_url }}">
    @endif
</body>
</html>