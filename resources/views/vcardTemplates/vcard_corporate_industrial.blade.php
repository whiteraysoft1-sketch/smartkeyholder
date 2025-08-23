<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->display_name ?: $user->name }} - Corporate Profile</title>
    <meta name="description" content="{{ $profile->bio ?: 'Professional Corporate Profile' }}">
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
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Apple Liquid Glass Corporate UI */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
                0 8px 32px 0 rgba(31, 38, 135, 0.37),
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
            background: rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(20px) saturate(1.8);
            -webkit-backdrop-filter: blur(20px) saturate(1.8);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow:
                0 8px 32px 0 rgba(0, 0, 0, 0.3),
                inset 0 1px 0 0 rgba(255, 255, 255, 0.2);
        }

        .corporate-gradient {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #06b6d4 100%);
        }

        .industrial-pattern {
            background-image:
                radial-gradient(circle at 2px 2px, rgba(255,255,255,0.15) 1px, transparent 0);
            background-size: 20px 20px;
        }

        .glow-effect {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
        }

        .corporate-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .corporate-btn:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.4);
        }

        .corporate-btn:active {
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
        .corporate-bg {
            background:
                radial-gradient(ellipse at top, rgba(59, 130, 246, 0.3) 0%, transparent 50%),
                radial-gradient(ellipse at bottom, rgba(147, 51, 234, 0.3) 0%, transparent 50%),
                linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
        }

        /* Responsive text sizes */
        @media (max-width: 640px) {
            .liquid-glass {
                border-radius: 16px;
            }
        }
    </style>
</head>
<body class="corporate-bg min-h-screen">
    <!-- Background Pattern -->
    <div class="fixed inset-0 industrial-pattern opacity-20"></div>

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
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    </div>
                @endif

                <div class="relative z-10">
                    <!-- Profile Image -->
                    <div class="mb-4 animate-float">
                        @if($profile->profile_image)
                            <img src="{{ $profile->profile_image_url }}"
                                 alt="{{ $profile->display_name ?: $user->name }}"
                                 class="w-24 h-24 rounded-full mx-auto object-cover border-4 border-white/50 shadow-2xl glow-effect">
                        @else
                            <div class="w-24 h-24 rounded-full mx-auto corporate-gradient flex items-center justify-center border-4 border-white/50 shadow-2xl glow-effect">
                                <i class="fas fa-building text-2xl text-white"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Name and Title -->
                    <h1 class="text-2xl font-bold text-white mb-2 drop-shadow-lg animate-slide-up">
                        {{ $profile->display_name ?: $user->name }}
                    </h1>

                    @if($profile->profession)
                        <p class="text-blue-100 font-medium mb-2 animate-slide-up" style="animation-delay: 0.1s">
                            {{ $profile->profession }}
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
                
                    @endif

                    @if($profile->location)
                        <div class="flex items-center justify-center text-blue-200 text-sm mb-4 animate-slide-up" style="animation-delay: 0.2s">
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

            <!-- Contact Information -->
            <div class="liquid-glass p-5 animate-slide-in-left">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 corporate-gradient rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-address-card text-white"></i>
                    </div>
                    <h2 class="text-lg font-bold text-white">Contact Information</h2>
                </div>

                <div class="space-y-3">
                    @if($user->email)
                        <a href="mailto:{{ $user->email }}"
                           class="flex items-center p-3 liquid-glass-dark rounded-xl hover:scale-105 transition-all duration-300 group">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-400">
                                <i class="fas fa-envelope text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Email</p>
                                <p class="text-blue-200 text-sm">{{ $user->email }}</p>
                            </div>
                        </a>
                    @endif

                    @if($profile->phone)
                        <a href="tel:{{ $profile->phone }}"
                           class="flex items-center p-3 liquid-glass-dark rounded-xl hover:scale-105 transition-all duration-300 group">
                            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-400">
                                <i class="fas fa-phone text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Phone</p>
                                <p class="text-blue-200 text-sm">{{ $profile->phone }}</p>
                            </div>
                        </a>
                    @endif

                    @if($profile->website)
                        <a href="{{ $profile->website }}" target="_blank"
                           class="flex items-center p-3 liquid-glass-dark rounded-xl hover:scale-105 transition-all duration-300 group">
                            <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-400">
                                <i class="fas fa-globe text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-white font-medium">Website</p>
                                <p class="text-blue-200 text-sm">{{ parse_url($profile->website, PHP_URL_HOST) }}</p>
                            </div>
                        </a>
                    @endif

                    @if($profile->contact)
                    @endif
                </div>
            </div>

            <!-- Social Media Links -->
            @if($socialLinks->count() > 0)
                <div class="liquid-glass p-5 animate-slide-in-right">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 corporate-gradient rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-share-alt text-white"></i>
                        </div>
                        <h2 class="text-lg font-bold text-white">Connect With Us</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach($socialLinks as $link)
                            <a href="{{ $link->url }}" target="_blank"
                               class="flex items-center p-3 liquid-glass-dark rounded-xl hover:scale-105 transition-all duration-300 group">
                                <div class="w-8 h-8 {{ $link->platform_color }} rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                                    <i class="{{ $link->platform_icon }} text-white text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-white font-medium text-sm">{{ ucfirst($link->platform) }}</p>
                                    <p class="text-blue-200 text-xs truncate">{{ $link->display_name ?: 'Visit Profile' }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Gallery / Portfolio -->
            @if($galleryItems->count() > 0)
                <div class="liquid-glass p-5 animate-fade-in" style="animation-delay: 0.4s">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 corporate-gradient rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-images text-white"></i>
                        </div>
                        <h2 class="text-lg font-bold text-white">Our Work</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach($galleryItems->take(6) as $item)
                            <div class="relative group overflow-hidden rounded-xl animate-slide-up cursor-pointer"
                                 style="animation-delay: {{ $loop->index * 0.1 }}s"
                                 onclick="openImageViewer('{{ Storage::disk('public')->url($item->image_path) }}', {{ $loop->index }})">
                                <img src="{{ Storage::disk('public')->url($item->image_path) }}"
                                     alt="{{ $item->title }}"
                                     class="w-full h-32 object-cover transition-transform duration-500 group-hover:scale-110 gallery-image">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                        <i class="fas fa-search-plus text-white text-xl"></i>
                                    </div>
                                </div>
                                @if($item->title)
                                    <div class="absolute bottom-0 left-0 right-0 p-2 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                        <p class="text-white text-xs font-medium">{{ $item->title }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Store Section -->
            @if($profile->store_enabled && $user->storeProducts && $user->storeProducts->count() > 0)
                <div class="liquid-glass p-5 animate-slide-in-left" style="animation-delay: 0.5s">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 corporate-gradient rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-store text-white"></i>
                        </div>
                        <h2 class="text-lg font-bold text-white">Our Products & Services</h2>
                    </div>

                    <div class="space-y-3 mb-4">
                        @foreach($user->storeProducts->take(3) as $product)
                            <div class="liquid-glass-dark p-3 rounded-xl hover:scale-105 transition-all duration-300">
                                <div class="flex items-center">
                                    @if($product->image)
                                        <img src="{{ Storage::disk('public')->url($product->image) }}"
                                             alt="{{ $product->name }}"
                                             class="w-12 h-12 object-cover rounded-lg mr-3">
                                    @else
                                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-box text-white"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="text-white font-medium text-sm">{{ $product->name }}</h4>
                                        <p class="text-blue-200 text-xs">{{ $profile->currency_symbol ?? '$' }}{{ number_format($product->price, 2) }}</p>
                                    </div>
                                    @if($product->is_available)
                                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('store.show', $qrCode->uuid) }}"
                       class="corporate-btn w-full py-3 px-4 rounded-xl text-white font-semibold text-center block">
                        <i class="fas fa-shopping-bag mr-2"></i>
                        View Full Catalog
                    </a>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="space-y-3 animate-fade-in" style="animation-delay: 0.6s">
                <!-- Save Contact Button -->
                <button onclick="downloadVCard()"
                        class="corporate-btn w-full py-4 px-6 rounded-xl text-white font-bold text-lg flex items-center justify-center">
                    <i class="fas fa-download mr-3"></i>
                    Save Contact
                </button>

                <!-- Quick Action Buttons -->
                <div class="grid grid-cols-2 gap-3">
                    @if($profile->phone)
                        <a href="tel:{{ $profile->phone }}"
                           class="liquid-glass-dark py-3 px-4 rounded-xl text-white font-semibold text-center hover:scale-105 transition-all duration-300">
                            <i class="fas fa-phone mr-2"></i>
                            Call Now
                        </a>
                    @endif

                    @if($user->email)
                        <a href="mailto:{{ $user->email }}"
                           class="liquid-glass-dark py-3 px-4 rounded-xl text-white font-semibold text-center hover:scale-105 transition-all duration-300">
                            <i class="fas fa-envelope mr-2"></i>
                            Email Us
                        </a>
                    @endif
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center py-4 animate-fade-in" style="animation-delay: 0.7s">
                <p class="text-white/60 text-xs">
                    Powered by Whiteray Smart Tag
                </p>
            </div>
        </div>
    </div>

    <!-- Image Viewer Modal -->
    <div id="imageViewer" class="fixed inset-0 bg-black/90 z-50 hidden">
        <button onclick="closeImageViewer()" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 z-10">
            <i class="fas fa-times"></i>
        </button>
        <button id="prevImage" class="absolute left-4 top-1/2 -translate-y-1/2 text-white text-3xl hover:text-gray-300 z-10">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button id="nextImage" class="absolute right-4 top-1/2 -translate-y-1/2 text-white text-3xl hover:text-gray-300 z-10">
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="w-full h-full flex items-center justify-center p-4">
            <img id="fullImage" src="" alt="Full size image" class="max-h-full max-w-full object-contain">
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Image Viewer
        let currentImageIndex = 0;
        let galleryImages = [];

        function openImageViewer(imageUrl, index) {
            const viewer = document.getElementById('imageViewer');
            const fullImage = document.getElementById('fullImage');
            
            // Get all gallery images if not already loaded
            if (galleryImages.length === 0) {
                galleryImages = Array.from(document.querySelectorAll('.gallery-image')).map(img => img.src);
            }
            
            currentImageIndex = index;
            fullImage.src = imageUrl;
            viewer.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageViewer() {
            const viewer = document.getElementById('imageViewer');
            viewer.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function showNextImage() {
            currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
            document.getElementById('fullImage').src = galleryImages[currentImageIndex];
        }

        function showPrevImage() {
            currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
            document.getElementById('fullImage').src = galleryImages[currentImageIndex];
        }

        document.getElementById('prevImage').addEventListener('click', showPrevImage);
        document.getElementById('nextImage').addEventListener('click', showNextImage);

        // Handle keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (document.getElementById('imageViewer').classList.contains('hidden')) return;
            
            if (e.key === 'Escape') closeImageViewer();
            if (e.key === 'ArrowLeft') showPrevImage();
            if (e.key === 'ArrowRight') showNextImage();
        });

        // vCard Download Function
        function downloadVCard() {
            const vcard = `BEGIN:VCARD
VERSION:3.0
FN:{{ $profile->display_name ?: $user->name }}
N:{{ $user->name }};;;;
@if($profile->profession)ORG:{{ $profile->profession }}@endif
@if($user->email)EMAIL:{{ $user->email }}@endif
@if($profile->phone)TEL:{{ $profile->phone }}@endif
@if($profile->website)URL:{{ $profile->website }}@endif
@if($profile->location)ADR:;;{{ $profile->location }};;;;@endif
@if($profile->bio)NOTE:{{ $profile->bio }}@endif
END:VCARD`;

            const blob = new Blob([vcard], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($profile->display_name ?: $user->name) }}-contact.vcf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }

        // Add scroll animations
        window.addEventListener('scroll', () => {
            const elements = document.querySelectorAll('.animate-on-scroll');
            elements.forEach(el => {
                const elementTop = el.getBoundingClientRect().top;
                const elementVisible = 150;

                if (elementTop < window.innerHeight - elementVisible) {
                    el.classList.add('animate-fade-in');
                }
            });
        });

        // Add loading animation
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('loaded');
        });
    </script>
</body>
</html>

