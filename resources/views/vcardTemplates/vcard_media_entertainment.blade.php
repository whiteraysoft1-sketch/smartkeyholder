<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media & Entertainment vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <meta name="msapplication-TileColor" content="#7c3aed">
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
    @endif
    <style>
        .media-gradient {
            background:
                linear-gradient(135deg, rgba(124,58,237,0.95) 0%, rgba(236,72,153,0.9) 50%, rgba(251,191,36,0.9) 100%),
                url('https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .media-card {
            background: rgba(30, 27, 75, 0.7);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 20px 40px -10px rgba(124,58,237,0.2);
            border-radius: 2rem;
        }
        .media-glow {
            animation: media-glow 3s ease-in-out infinite;
        }
        @keyframes media-glow {
            0%,100% { box-shadow: 0 0 0 0 rgba(236,72,153,0.4); }
            50% { box-shadow: 0 0 0 18px rgba(236,72,153,0); }
        }
        .media-item {
            background: rgba(55, 48, 163, 0.5);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.18);
            transition: all 0.3s ease;
        }
        .media-item:hover {
            background: rgba(236,72,153,0.5);
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 10px 30px rgba(236,72,153,0.15);
        }
        .social-glass {
            background: rgba(251,191,36,0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
            transition: all 0.3s ease;
        }
        .social-glass:hover {
            background: rgba(251,191,36,0.5);
            transform: scale(1.1);
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
        .spotlight {
            animation: spotlight 4s ease-in-out infinite;
        }
        @keyframes spotlight {
            0%,100% { filter: brightness(1); }
            50% { filter: brightness(1.2) drop-shadow(0 0 20px #fbbf24); }
        }
        .text-white {
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        }
        h1, h2, h3 {
            text-shadow: 3px 3px 6px rgba(0,0,0,0.9);
        }
    </style>
</head>
<body class="media-gradient min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="media-card overflow-hidden">
            <!-- Header Section -->
            @if($profile->background_image)
            <!-- Header with Background Image -->
            <div class="relative w-full h-48 bg-cover bg-center" style="background-image: url('{{ $profile->background_image_url }}');">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/20"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-fuchsia-500/40 via-yellow-400/30 to-purple-600/40"></div>
                
                <!-- Profile Image Overlapping -->
                <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                    <div class="relative inline-block">
                        <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-gradient-to-br from-fuchsia-500 to-yellow-400 p-1 media-glow">
                            <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'Media Star') . '&background=7c3aed&color=fff&size=128' }}"
                                 class="w-full h-full rounded-full object-cover border-4 border-white/30"
                                 alt="Profile Photo">
                        </div>
                        <!-- Spotlight Badge -->
                        <div class="absolute -bottom-2 -right-2 bg-yellow-400 text-white rounded-full w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center text-base sm:text-lg spotlight">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- Spacer and Profile Info -->
            <div class="pt-20 pb-6 px-6 text-center">
                <!-- Name & Profession -->
                <h1 class="text-xl sm:text-2xl font-bold text-white mb-1">{{ $profile->display_name ?? $user->name ?? 'Media Star' }}</h1>
                <p class="text-yellow-200 font-semibold text-base sm:text-lg mb-2">{{ $profile->profession ?? 'Performer / Creator' }}</p>
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
                <div class="flex items-center justify-center text-white/90 text-xs sm:text-sm mb-4">
                    <i class="fas fa-map-marker-alt text-yellow-300 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
                <!-- Tagline -->
                <div class="flex justify-center gap-2 mb-4">
                    <div class="bg-gradient-to-r from-fuchsia-500 to-yellow-400 px-2 sm:px-3 py-1 rounded-full text-xs font-medium text-white shadow-lg">
                        <i class="fas fa-microphone-alt mr-1"></i>
                        In the Spotlight
                    </div>
                </div>
            </div>
            @else
            <!-- Header without Background Image -->
            <div class="relative px-3 sm:px-6 pt-6 sm:pt-8 pb-4 sm:pb-6 text-center">
                <!-- Profile Image with Spotlight Badge -->
                <div class="relative inline-block mb-4">
                    <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-gradient-to-br from-fuchsia-500 to-yellow-400 p-1 media-glow">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'Media Star') . '&background=7c3aed&color=fff&size=128' }}"
                             class="w-full h-full rounded-full object-cover border-4 border-white/30"
                             alt="Profile Photo">
                    </div>
                    <!-- Spotlight Badge -->
                    <div class="absolute -bottom-2 -right-2 bg-yellow-400 text-white rounded-full w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center text-base sm:text-lg spotlight">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <!-- Name & Profession -->
                <h1 class="text-xl sm:text-2xl font-bold text-white mb-1">{{ $profile->display_name ?? $user->name ?? 'Media Star' }}</h1>
                <p class="text-yellow-200 font-semibold text-base sm:text-lg mb-2">{{ $profile->profession ?? 'Performer / Creator' }}</p>
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
                <div class="flex items-center justify-center text-white/90 text-xs sm:text-sm mb-4">
                    <i class="fas fa-map-marker-alt text-yellow-300 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
                <!-- Tagline -->
                <div class="flex justify-center gap-2 mb-4">
                    <div class="bg-gradient-to-r from-fuchsia-500 to-yellow-400 px-2 sm:px-3 py-1 rounded-full text-xs font-medium text-white shadow-lg">
                        <i class="fas fa-microphone-alt mr-1"></i>
                        In the Spotlight
                    </div>
                </div>
            </div>
            @endif
            <!-- Bio/Description -->
            <div class="px-6 py-4">
                <div class="media-item rounded-xl p-4 mb-6">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-quote-left text-yellow-300 text-lg mr-2"></i>
                        <h3 class="font-semibold text-white">About Me</h3>
                    </div>
                    <p class="text-white/90 text-sm leading-relaxed">
                        {{ $profile->bio ?? 'Passionate about creating unforgettable moments in music, film, and entertainment. Always ready for the next big show!' }}
                    </p>
                </div>
            </div>
            <!-- Portfolio / Featured Works -->
            @if($galleryItems->count() > 0)
            <div class="px-3 sm:px-6 py-3 sm:py-4">
                <h3 class="font-semibold text-white mb-4 flex items-center text-base sm:text-lg">
                    <i class="fas fa-film text-yellow-300 mr-2"></i>
                    Featured Works
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($galleryItems->take(4) as $item)
                        <div class="relative group overflow-hidden rounded-lg fade-in cursor-pointer media-item" onclick="openGalleryModal('{{ $item->full_image_url }}', '{{ $item->title }}', '{{ $item->description }}')">
                            <img src="{{ $item->full_image_url }}"
                                 alt="{{ $item->title }}"
                                 class="w-full h-20 sm:h-24 object-cover transition-transform duration-300 group-hover:scale-110">
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
            <!-- Contact & Booking -->
            @if($profile->phone || $profile->email || $profile->website)
            <div class="px-3 sm:px-6 py-3 sm:py-4">
                <h3 class="font-semibold text-white mb-4 flex items-center text-base sm:text-lg">
                    <i class="fas fa-address-book text-yellow-300 mr-2"></i>
                    Bookings & Contact
                </h3>
                <div class="space-y-3">
                    @if($profile->phone)
                    <div class="media-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 bg-fuchsia-600/80 rounded-full flex items-center justify-center text-white mr-3 border border-white/30">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-white text-sm sm:text-base">Phone</div>
                            <div class="text-xs sm:text-sm text-white/80">{{ $profile->phone }}</div>
                        </div>
                        <a href="tel:{{ $profile->phone }}" class="bg-fuchsia-600/80 text-white px-2 sm:px-3 py-1 rounded-lg text-xs sm:text-sm hover:bg-fuchsia-700/90 transition-colors border border-white/30">
                            Call
                        </a>
                    </div>
                    @endif
                    @if($profile->email ?? $user->email)
                    <div class="media-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 bg-yellow-500/80 rounded-full flex items-center justify-center text-white mr-3 border border-white/30">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-white text-sm sm:text-base">Email</div>
                            <div class="text-xs sm:text-sm text-white/80">{{ $profile->email ?? $user->email }}</div>
                        </div>
                        <a href="mailto:{{ $profile->email ?? $user->email }}" class="bg-yellow-500/80 text-white px-2 sm:px-3 py-1 rounded-lg text-xs sm:text-sm hover:bg-yellow-600/90 transition-colors border border-white/30">
                            Email
                        </a>
                    </div>
                    @endif
                    @if($profile->website)
                    <div class="media-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 bg-indigo-600/80 rounded-full flex items-center justify-center text-white mr-3 border border-white/30">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-white text-sm sm:text-base">Website</div>
                            <div class="text-xs sm:text-sm text-white/80">Official Site</div>
                        </div>
                        <a href="{{ $profile->website }}" target="_blank" class="bg-indigo-600/80 text-white px-2 sm:px-3 py-1 rounded-lg text-xs sm:text-sm hover:bg-indigo-700/90 transition-colors border border-white/30">
                            Visit
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            <!-- Social Links -->
            @if($socialLinks->count() > 0)
            <div class="px-3 sm:px-6 py-3 sm:py-4">
                <h3 class="font-semibold text-white mb-4 flex items-center text-base sm:text-lg">
                    <i class="fas fa-share-alt text-yellow-300 mr-2"></i>
                    Socials
                </h3>
                <div class="flex gap-2 sm:gap-3 justify-center flex-wrap">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="social-glass w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-full text-white text-base sm:text-lg" title="{{ ucfirst($link->platform) }}">
                            @switch($link->platform)
                                @case('facebook')<i class="fab fa-facebook-f"></i>@break
                                @case('instagram')<i class="fab fa-instagram"></i>@break
                                @case('twitter')<i class="fab fa-twitter"></i>@break
                                @case('linkedin')<i class="fab fa-linkedin-in"></i>@break
                                @case('youtube')<i class="fab fa-youtube"></i>@break
                                @case('whatsapp')<i class="fab fa-whatsapp"></i>@break
                                @case('telegram')<i class="fab fa-telegram-plane"></i>@break
                                @case('tiktok')<i class="fab fa-tiktok"></i>@break
                                @default<i class="fas fa-link"></i>@break
                            @endswitch
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
            <!-- Action Buttons -->
            <div class="px-3 sm:px-6 py-4 sm:py-6 space-y-2 sm:space-y-3">
                @if($profile->email ?? $user->email)
                <a href="mailto:{{ $profile->email ?? $user->email }}?subject=Booking Inquiry" class="w-full bg-gradient-to-r from-fuchsia-500 to-yellow-400 text-white py-2 sm:py-3 px-3 sm:px-4 rounded-xl font-semibold text-center flex items-center justify-center text-base sm:text-lg">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Book Now
                </a>
                @endif
                @if($profile->phone)
                <a href="tel:{{ $profile->phone }}" class="w-full bg-gradient-to-r from-yellow-400 to-fuchsia-500 text-white py-2 sm:py-3 px-3 sm:px-4 rounded-xl font-semibold text-center flex items-center justify-center text-base sm:text-lg">
                    <i class="fas fa-microphone-alt mr-2"></i>
                    Call for Gigs
                </a>
                @endif
                
                <button onclick="downloadVCard()" class="w-full bg-gradient-to-r from-gray-700/80 to-gray-800/80 backdrop-blur-10 text-white py-2 sm:py-3 px-3 sm:px-4 rounded-xl font-semibold text-center flex items-center justify-center hover:from-gray-800/90 hover:to-gray-900/90 transition-all media-item border border-white/30 text-base sm:text-lg">
                    <i class="fas fa-download mr-2"></i>
                    Save Contact
                </button>
            </div>
            <!-- Footer -->
            <div class="px-3 sm:px-6 py-3 sm:py-4 bg-indigo-900/20 text-center border-t border-white/20">
                <div class="flex items-center justify-center text-yellow-200 text-xs sm:text-sm mb-2">
                    <i class="fas fa-film mr-2"></i>
                    <span>Lights. Camera. Connect!</span>
                    <i class="fas fa-music ml-2"></i>
                </div>
                <div class="text-xs text-white/70">
                    Media & Entertainment Professional
                </div>
                <div class="text-xs text-white/50 mt-1">
                    Powered by Smart Tag
                </div>
            </div>
        </div>
    </div>
    <!-- Gallery Modal -->
    <div id="galleryModal" class="hidden fixed top-0 left-0 w-full h-full bg-black/90 z-50 flex items-center justify-center p-4">
        <div class="media-card rounded-2xl max-w-lg w-full max-h-full overflow-auto relative">
            <div class="flex justify-between items-center p-4 border-b border-white/20">
                <h3 id="galleryModalTitle" class="text-lg font-bold text-white"></h3>
                <button onclick="closeGalleryModal()" class="text-2xl text-white/80 hover:text-white transition-colors">&times;</button>
            </div>
            <img id="galleryModalImage" src="" alt="" class="w-full object-contain" style="max-height:60vh;">
            <div class="p-4 text-white/90 text-sm" id="galleryModalDescription"></div>
        </div>
    </div>
    <script>
        // vCard Download Function
        function downloadVCard() {
            const vCardData = `BEGIN:VCARD\nVERSION:3.0\nFN:{{ $profile->display_name ?? $user->name ?? 'Media Star' }}\nORG:{{ $profile->profession ?? 'Performer / Creator' }}\nTITLE:{{ $profile->profession ?? 'Performer / Creator' }}\nTEL:{{ $profile->phone ?? '' }}\nEMAIL:{{ $profile->email ?? $user->email ?? '' }}\nURL:{{ $profile->website ?? '' }}\nNOTE:{{ $profile->bio ?? 'Passionate about creating unforgettable moments in music, film, and entertainment.' }}\nEND:VCARD`;
            const blob = new Blob([vCardData], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($profile->display_name ?? $user->name ?? 'media-star') }}.vcf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        // Gallery Modal Functions
        function openGalleryModal(imageUrl, title, description) {
            document.getElementById('galleryModalImage').src = imageUrl;
            document.getElementById('galleryModalTitle').textContent = title || 'Featured Work';
            document.getElementById('galleryModalDescription').textContent = description || '';
            document.getElementById('galleryModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeGalleryModal() {
            document.getElementById('galleryModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        document.getElementById('galleryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGalleryModal();
            }
        });
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
            document.querySelectorAll('.fade-in').forEach(el => {
                observer.observe(el);
            });
        });
        
    </script>
</body>
</html>

