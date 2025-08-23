<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->display_name ?: $user->name }} - Church Profile</title>
    <meta name="description" content="{{ $profile->bio ?: 'Church Profile Card' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $profile->pwa_icon ? Storage::disk('public')->url($profile->pwa_icon) : '/favicon.ico' }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'cormorant': ['Cormorant Garamond', 'serif'],
                        'montserrat': ['Montserrat', 'sans-serif'],
                    },
                    colors: {
                        'church-gold': '#D4AF37',
                        'church-burgundy': '#800020',
                        'church-navy': '#14213D',
                        'church-cream': '#FFF8E7',
                    },
                    animation: {
                        'fade-in': 'fadeIn 1s ease-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'slide-down': 'slideDown 0.8s ease-out',
                        'slide-in-left': 'slideInLeft 0.8s ease-out',
                        'slide-in-right': 'slideInRight 0.8s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideDown: {
                            '0%': { transform: 'translateY(-20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        slideInLeft: {
                            '0%': { transform: 'translateX(-20px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                        slideInRight: {
                            '0%': { transform: 'translateX(20px)', opacity: '0' },
                            '100%': { transform: 'translateX(0)', opacity: '1' },
                        },
                    }
                }
            }
        }
    </script>
    <style>
        .church-gradient {
            background: linear-gradient(135deg, #D4AF37 0%, #800020 100%);
        }
        .church-card {
            background-color: rgba(255, 248, 231, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(212, 175, 55, 0.2);
        }
        .church-button {
            background: linear-gradient(135deg, #D4AF37 0%, #800020 100%);
            transition: all 0.3s ease;
        }
        .church-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
        }
        .profile-image-border {
            position: relative;
            padding: 4px;
            background: linear-gradient(135deg, #D4AF37 0%, #800020 100%);
            border-radius: 9999px;
        }
        .profile-image-border::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 9999px;
            background: linear-gradient(135deg, #D4AF37 0%, #800020 100%);
            -webkit-mask: 
                linear-gradient(#fff 0 0) content-box, 
                linear-gradient(#fff 0 0);
            mask: 
                linear-gradient(#fff 0 0) content-box, 
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }
    </style>
</head>
<body class="min-h-screen bg-church-cream font-montserrat">
    <!-- Hero Section with Background -->
    <div class="h-[420px] relative w-full overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            @if($profile->background_image)
                <img src="{{ Storage::disk('public')->url($profile->background_image) }}"
                     alt="Background"
                     class="w-full h-[420px] object-cover object-center">
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-black/70"></div>
        </div>
        
        <!-- Decorative Pattern -->
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M54.627 0l.83.828-1.415 1.415L51.8 0h2.827zM5.373 0l-.83.828L5.96 2.243 8.2 0H5.374zM48.97 0l3.657 3.657-1.414 1.414L46.143 0h2.828zM11.03 0L7.372 3.657 8.787 5.07 13.857 0H11.03zm32.284 0L49.8 6.485 48.384 7.9l-7.9-7.9h2.83zM16.686 0L10.2 6.485 11.616 7.9l7.9-7.9h-2.83zM22.343 0L13.8 8.544 15.214 9.96l9.9-9.9h-2.77zM32 0l-3.657 3.657 1.414 1.414L32 2.828l2.243 2.243 1.414-1.414L32 0zm2.828 0l8.544 8.544-1.414 1.414-9.9-9.9h2.77zm5.657 0l6.485 6.485-1.414 1.414-7.9-7.9h2.83zm5.657 0l3.657 3.657-1.414 1.414L45.143 0h2.828zM39.88 6.485l4.243 4.243-4.243-4.243zm-5.657 5.657l4.243 4.243-4.243-4.243zm-5.657 5.657l4.243 4.243-4.243-4.243zm-5.657 5.657l4.243 4.243-4.243-4.243zm-5.657 5.657l4.243 4.243-4.243-4.243zm-5.657 5.657l4.243 4.243-4.243-4.243zm-5.657 5.657l4.243 4.243-4.243-4.243z\' fill=\'%23D4AF37\' fill-opacity=\'1\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');"></div>

        <!-- Profile Image -->
        <div class="absolute left-1/2 bottom-0 -mb-24 transform -translate-x-1/2 z-20">
            <div class="profile-image-border inline-block shadow-2xl">
                <img src="{{ $profile->profile_image ? Storage::disk('public')->url($profile->profile_image) : '/images/default-profile.jpg' }}"
                     alt="{{ $profile->display_name ?: $user->name }}"
                     class="w-48 h-48 rounded-full object-cover">
            </div>
        </div>
    </div>

    <div class="relative min-h-screen flex flex-col items-center justify-start p-4 z-10 mt-32">
        <div class="w-full max-w-2xl space-y-6">
            <!-- Profile Header -->
            <div class="church-card rounded-3xl p-8 text-center relative overflow-hidden animate-fade-in">

                <!-- Name and Title -->
                <h1 class="font-cormorant text-3xl font-bold text-church-navy mb-2 animate-slide-up">
                    {{ $profile->display_name ?: $user->name }}
                </h1>

                @if($profile->profession)
                    <p class="text-church-burgundy font-medium mb-4 animate-slide-up" style="animation-delay: 0.1s">
                        {{ $profile->profession }}
                    </p>
                @endif

                @if($profile->bio)
                    <p class="text-gray-600 text-sm leading-relaxed mb-6 animate-slide-up" style="animation-delay: 0.2s">
                        {{ $profile->bio }}
                    </p>
                @endif

                <!-- Quick Action Buttons -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    @if($profile->phone)
                        <a href="tel:{{ $profile->phone }}"
                           class="church-button text-white px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-phone mr-2"></i>
                            Call
                        </a>
                    @endif

                    @if($user->email)
                        <a href="mailto:{{ $user->email }}"
                           class="church-button text-white px-6 py-3 rounded-xl font-semibold text-sm transition-all duration-300 flex items-center justify-center">
                            <i class="fas fa-envelope mr-2"></i>
                            Email
                        </a>
                    @endif
                </div>
            </div>

            <!-- Contact Information -->
            <div class="church-card rounded-3xl p-6 animate-slide-in-left">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 church-gradient rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-address-card text-white"></i>
                    </div>
                    <h2 class="font-cormorant text-xl font-bold text-church-navy">Contact Information</h2>
                </div>

                <div class="space-y-4">
                    @if($user->email)
                        <a href="mailto:{{ $user->email }}"
                           class="flex items-center p-4 bg-white/50 rounded-xl hover:bg-white/80 transition-all duration-300">
                            <div class="w-8 h-8 bg-church-burgundy rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-envelope text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-church-navy font-medium">Email</p>
                                <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                            </div>
                        </a>
                    @endif

                    @if($profile->phone)
                        <a href="tel:{{ $profile->phone }}"
                           class="flex items-center p-4 bg-white/50 rounded-xl hover:bg-white/80 transition-all duration-300">
                            <div class="w-8 h-8 bg-church-gold rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-phone text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-church-navy font-medium">Phone</p>
                                <p class="text-gray-600 text-sm">{{ $profile->phone }}</p>
                            </div>
                        </a>
                    @endif

                    @if($profile->location)
                        <a href="https://maps.google.com/?q={{ urlencode($profile->location) }}" target="_blank"
                           class="flex items-center p-4 bg-white/50 rounded-xl hover:bg-white/80 transition-all duration-300">
                            <div class="w-8 h-8 bg-church-navy rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-map-marker-alt text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="text-church-navy font-medium">Location</p>
                                <p class="text-gray-600 text-sm">{{ $profile->location }}</p>
                            </div>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Social Media Links -->
            @if($socialLinks->count() > 0)
                <div class="church-card rounded-3xl p-6 animate-slide-in-right">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 church-gradient rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-share-alt text-white"></i>
                        </div>
                        <h2 class="font-cormorant text-xl font-bold text-church-navy">Connect With Us</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach($socialLinks as $link)
                            <a href="{{ $link->url }}" target="_blank"
                               class="flex items-center p-3 bg-white/50 rounded-xl hover:bg-white/80 transition-all duration-300">
                                <div class="w-8 h-8 {{ $link->platform_color }} rounded-lg flex items-center justify-center mr-3">
                                    <i class="{{ $link->platform_icon }} text-white text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-church-navy font-medium text-sm">{{ ucfirst($link->platform) }}</p>
                                    <p class="text-gray-600 text-xs truncate">{{ $link->display_name ?: 'Visit Profile' }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Gallery / Portfolio -->
            @if($galleryItems->count() > 0)
                <div class="church-card rounded-3xl p-6 animate-fade-in" style="animation-delay: 0.4s">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 church-gradient rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-images text-white"></i>
                        </div>
                        <h2 class="font-cormorant text-xl font-bold text-church-navy">Our Gallery</h2>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        @foreach($galleryItems->take(6) as $item)
                            <div class="relative group overflow-hidden rounded-xl cursor-pointer animate-slide-up"
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

            <!-- Save Contact Button -->
            <button onclick="downloadVCard()"
                    class="church-button w-full py-4 px-6 rounded-xl text-white font-bold text-lg flex items-center justify-center">
                <i class="fas fa-download mr-3"></i>
                Save Contact
            </button>

            <!-- Footer -->
            <div class="text-center py-4 animate-fade-in" style="animation-delay: 0.7s">
                <p class="text-gray-500 text-xs">
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
            // Create a more detailed vCard format
            const vcard = `BEGIN:VCARD
VERSION:3.0
FN:{{ $profile->display_name ?: $user->name }}
N:{{ implode(';', array_pad(explode(' ', $user->name), 5, '')) }}
@if($profile->profession)TITLE:{{ $profile->profession }}
ORG:{{ $profile->profession }}@endif
@if($user->email)EMAIL;type=INTERNET;type=HOME:{{ $user->email }}@endif
@if($profile->phone)TEL;type=CELL:{{ $profile->phone }}@endif
@if($profile->website)URL:{{ $profile->website }}@endif
@if($profile->location)ADR;type=HOME:;;{{ $profile->location }};;;;
LABEL;type=HOME:{{ $profile->location }}@endif
@if($profile->bio)NOTE:{{ $profile->bio }}@endif
REV:{{ now()->format('Y-m-d\THis\Z') }}
END:VCARD`;

            // Create Blob with UTF-8 encoding and proper MIME type
            const blob = new Blob([vcard], { 
                type: 'text/vcard;charset=utf-8' 
            });

            // Check if it's a mobile device
            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

            if (isMobile) {
                // For mobile devices, use a direct download that triggers the native contact save
                const url = window.URL.createObjectURL(blob);
                window.location.href = url;
                setTimeout(() => {
                    window.URL.revokeObjectURL(url);
                }, 1000);
            } else {
                // For desktop devices, use the traditional download approach
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = '{{ Str::slug($profile->display_name ?: $user->name) }}-contact.vcf';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            }
        }
    </script>
</body>
</html>
