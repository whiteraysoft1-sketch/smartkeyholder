<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taxi Driver vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <meta name="msapplication-TileColor" content="#fbbf24">
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
    @endif
    <style>
        .taxi-gradient {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e42 100%), url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .taxi-card {
            background: rgba(255,255,255,0.98);
            border-radius: 2rem;
            box-shadow: 0 8px 32px 0 rgba(0,0,0,0.18);
            overflow: hidden;
            position: relative;
        }
        .taxi-badge {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e42 100%);
            color: #fff;
            animation: taxi-shine 4s ease-in-out infinite;
        }
        @keyframes taxi-shine {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.9; }
        }
        .taxi-glow {
            animation: taxi-glow 4s ease-in-out infinite;
        }
        @keyframes taxi-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(251,191,36,0.4); }
            50% { box-shadow: 0 0 0 15px rgba(251,191,36,0); }
        }
        .contact-item {
            background: linear-gradient(135deg, rgba(251,191,36,0.08) 0%, rgba(245,158,66,0.08) 100%);
            border: 1px solid rgba(251,191,36,0.15);
            transition: all 0.3s ease;
        }
        .contact-item:hover {
            background: linear-gradient(135deg, rgba(251,191,36,0.15) 0%, rgba(245,158,66,0.15) 100%);
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 10px 30px rgba(251,191,36,0.15);
        }
        .service-card {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(248,250,252,0.95) 100%);
            border: 1px solid rgba(251,191,36,0.18);
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px 0 rgba(251,191,36,0.08);
        }
        .service-card:hover {
            transform: translateY(-8px) scale(1.04);
            box-shadow: 0 20px 40px rgba(251,191,36,0.18);
            border-color: rgba(251,191,36,0.28);
        }
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s cubic-bezier(.4,0,.2,1);
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .social-icon {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e42 100%);
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px 0 rgba(251,191,36,0.12);
        }
        .social-icon:hover {
            background: linear-gradient(135deg, #f59e42 0%, #fbbf24 100%);
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 12px 35px rgba(251,191,36,0.22);
        }
        .taxi-banner {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 60px;
            background: repeating-linear-gradient(135deg, #222 0 20px, #fbbf24 20px 40px);
            z-index: 1;
        }
        .profile-img-shadow {
            box-shadow: 0 8px 24px 0 rgba(251,191,36,0.25), 0 1.5px 4px 0 rgba(0,0,0,0.08);
        }
        .divider {
            border-top: 2px dashed #fbbf24;
            margin: 2rem 0 1.5rem 0;
        }
        .gallery-thumb {
            border: 2px solid #fbbf24;
            transition: transform 0.3s;
        }
        .gallery-thumb:hover {
            transform: scale(1.07);
            z-index: 2;
        }
        /* Overlap profile image above background */
        .profile-overlap {
            position: absolute;
            left: 50%;
            /* Move further down: increase translateY from -50% to 10px lower */
            transform: translateX(-50%) translateY(85px);
            top: 0;
            z-index: 10;
        }
        .header-spacer {
            height: 3.5rem;
        }
    </style>
</head>
<body class="taxi-gradient min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="taxi-card overflow-hidden relative">
            <div class="taxi-banner"></div>
            <!-- Background Photo -->
            @if($profile->background_image)
            <div class="w-full h-32 md:h-40 bg-cover bg-center relative" style="background-image: url('{{ $profile->background_image_url }}');">
                <div class="absolute inset-0 bg-gradient-to-t from-yellow-400/80 to-transparent"></div>
                <!-- Profile Image Overlapping -->
                <div class="profile-overlap">
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-500 p-1 taxi-glow profile-img-shadow">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'Taxi Driver') . '&background=fbbf24&color=fff&size=128' }}" 
                             class="w-full h-full rounded-full object-cover border-4 border-white" 
                             alt="Profile Photo">
                        <!-- Taxi Badge -->
                        <div class="absolute -bottom-2 -right-2 taxi-badge rounded-full w-10 h-10 flex items-center justify-center text-lg border-4 border-white">
                            <i class="fas fa-taxi"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-spacer"></div>
            @else
            <!-- If no background, show profile image in normal flow -->
            <div class="relative flex justify-center mt-8 mb-2">
                <div class="w-32 h-32 rounded-full bg-gradient-to-br from-yellow-400 to-yellow-500 p-1 taxi-glow profile-img-shadow relative">
                    <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'Taxi Driver') . '&background=fbbf24&color=fff&size=128' }}" 
                         class="w-full h-full rounded-full object-cover border-4 border-white" 
                         alt="Profile Photo">
                    <div class="absolute -bottom-2 -right-2 taxi-badge rounded-full w-10 h-10 flex items-center justify-center text-lg border-4 border-white">
                        <i class="fas fa-taxi"></i>
                    </div>
                </div>
            </div>
            @endif
            <!-- Header Section -->
            <div class="relative px-6 pt-4 pb-6 text-center z-10">
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1 tracking-wide">
                    {{ $profile->display_name ?? $user->name ?? 'Taxi Driver' }}
                </h1>
                <p class="text-yellow-700 font-semibold text-lg mb-2">
                    {{ $profile->profession ?? 'Professional Taxi Driver' }}
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
                    <i class="fas fa-map-marker-alt text-yellow-600 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
                <div class="flex justify-center gap-2 mb-4">
                    <div class="taxi-badge px-3 py-1 rounded-full text-xs font-medium shadow">
                        <i class="fas fa-id-badge mr-1"></i>
                        Licensed Taxi
                    </div>
                </div>
            </div>
            <div class="divider"></div>
            <!-- Services Section (Bio + Taxi Services) -->
            <div class="px-6 py-4">
                <div class="rounded-xl p-4 mb-6 bg-yellow-50 border-l-4 border-yellow-400 shadow-sm">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-quote-left text-yellow-600 text-lg mr-2"></i>
                        <h3 class="font-semibold text-gray-800">Services</h3>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed mb-4">
                        {{ $profile->bio ?? 'Reliable, safe, and friendly taxi service. Your destination, our responsibility!' }}
                    </p>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="service-card rounded-lg p-3 text-center fade-in">
                            <i class="fas fa-map-marked-alt text-yellow-600 text-2xl mb-2"></i>
                            <div class="text-sm font-medium text-gray-800">City Rides</div>
                        </div>
                        <div class="service-card rounded-lg p-3 text-center fade-in">
                            <i class="fas fa-plane-departure text-yellow-500 text-2xl mb-2"></i>
                            <div class="text-sm font-medium text-gray-800">Airport Transfers</div>
                        </div>
                        <div class="service-card rounded-lg p-3 text-center fade-in">
                            <i class="fas fa-clock text-yellow-700 text-2xl mb-2"></i>
                            <div class="text-sm font-medium text-gray-800">24/7 Service</div>
                        </div>
                        <div class="service-card rounded-lg p-3 text-center fade-in">
                            <i class="fas fa-user-friends text-yellow-400 text-2xl mb-2"></i>
                            <div class="text-sm font-medium text-gray-800">Group Rides</div>
                        </div>
                                                                    </div>
                </div>
            </div>
            <!-- Social Links (moved below Services) -->
            @if(isset($socialLinks) && $socialLinks->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-share-alt text-yellow-600 mr-2"></i>
                    Connect with Me
                </h3>
                <div class="space-y-3">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="social-link-card contact-item rounded-xl p-4 flex items-center fade-in hover:scale-105 transition-all duration-300">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white mr-4 shadow-lg
                                @switch($link->platform)
                                    @case('linkedin') bg-gradient-to-r from-blue-600 to-blue-700 @break
                                    @case('twitter') bg-gradient-to-r from-sky-400 to-sky-500 @break
                                    @case('github') bg-gradient-to-r from-gray-700 to-gray-800 @break
                                    @case('instagram') bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 @break
                                    @case('facebook') bg-gradient-to-r from-blue-600 to-blue-700 @break
                                    @case('youtube') bg-gradient-to-r from-red-600 to-red-700 @break
                                    @case('whatsapp') bg-gradient-to-r from-green-500 to-green-600 @break
                                    @case('telegram') bg-gradient-to-r from-blue-500 to-blue-600 @break
                                    @default bg-gradient-to-r from-yellow-500 to-yellow-600 @break
                                @endswitch">
                                @switch($link->platform)
                                    @case('linkedin')<i class="fab fa-linkedin-in text-lg"></i>@break
                                    @case('twitter')<i class="fab fa-twitter text-lg"></i>@break
                                    @case('github')<i class="fab fa-github text-lg"></i>@break
                                    @case('instagram')<i class="fab fa-instagram text-lg"></i>@break
                                    @case('facebook')<i class="fab fa-facebook-f text-lg"></i>@break
                                    @case('youtube')<i class="fab fa-youtube text-lg"></i>@break
                                    @case('whatsapp')<i class="fab fa-whatsapp text-lg"></i>@break
                                    @case('telegram')<i class="fab fa-telegram-plane text-lg"></i>@break
                                    @default<i class="fas fa-link text-lg"></i>@break
                                @endswitch
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-gray-800 capitalize">{{ $link->platform }}</div>
                                <div class="text-sm text-gray-600">Follow me on {{ ucfirst($link->platform) }}</div>
                            </div>
                            <div class="text-yellow-500">
                                <i class="fas fa-external-link-alt text-sm"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
            <!-- Taxi Stats -->
            <div class="px-6 py-4">
                <div class="rounded-lg p-4 mb-6 bg-yellow-100 border border-yellow-300 shadow-sm">
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-tachometer-alt text-yellow-600 mr-2"></i>
                        Service Stats
                    </h3>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold text-yellow-600">500+</div>
                            <div class="text-xs text-gray-600">Rides</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-yellow-700">4.9</div>
                            <div class="text-xs text-gray-600">Rating</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-yellow-500">24/7</div>
                            <div class="text-xs text-gray-600">Availability</div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Photo Gallery -->
            @if(isset($galleryItems) && $galleryItems->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-images text-yellow-600 mr-2"></i>
                    Photo Gallery
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($galleryItems->take(4) as $item)
                        <div class="relative group overflow-hidden rounded-lg fade-in cursor-pointer gallery-thumb" onclick="openGalleryModal('{{ $item->full_image_url }}', '{{ $item->title }}', '{{ $item->description }}')">
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
            <!-- Contact Information -->
            @if($profile->phone || $profile->email || $profile->website)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-address-book text-yellow-600 mr-2"></i>
                    Contact Information
                </h3>
                <div class="space-y-3">
                    @if($profile->phone)
                    <div class="contact-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-yellow-600 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Phone</div>
                            <div class="text-sm text-gray-600">{{ $profile->phone }}</div>
                        </div>
                        <a href="tel:{{ $profile->phone }}" class="bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-yellow-700 transition-colors">
                            Call
                        </a>
                    </div>
                    @endif
                    @if($profile->email ?? $user->email)
                    <div class="contact-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-yellow-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Email</div>
                            <div class="text-sm text-gray-600">{{ $profile->email ?? $user->email }}</div>
                        </div>
                        <a href="mailto:{{ $profile->email ?? $user->email }}" class="bg-yellow-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-yellow-600 transition-colors">
                            Email
                        </a>
                    </div>
                    @endif
                    @if($profile->website)
                    <div class="contact-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Website</div>
                            <div class="text-sm text-gray-600">Visit my site</div>
                        </div>
                        <a href="{{ $profile->website }}" target="_blank" class="bg-yellow-400 text-white px-3 py-1 rounded-lg text-sm hover:bg-yellow-500 transition-colors">
                            Visit
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
                        <!-- Action Buttons -->
            <div class="px-6 py-6 space-y-3">
                @if($profile->phone)
                <a href="tel:{{ $profile->phone }}" class="w-full bg-yellow-600 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center hover:bg-yellow-700 transition-all shadow-lg">
                    <i class="fas fa-phone mr-2"></i>
                    Call Now
                </a>
                @endif
                @if($profile->email ?? $user->email)
                <a href="mailto:{{ $profile->email ?? $user->email }}?subject=Taxi Booking Request" class="w-full bg-yellow-500 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center hover:bg-yellow-600 transition-all shadow-lg">
                    <i class="fas fa-envelope mr-2"></i>
                    Book by Email
                </a>
                @endif
                <!-- Save Contact Button -->
                <button onclick="saveContact()" class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center hover:from-yellow-600 hover:to-yellow-700 transition-all shadow-lg">
                    <i class="fas fa-download mr-2"></i>
                    Save Contact
                </button>
            </div>
            <!-- Footer -->
            <div class="px-6 py-4 bg-yellow-50 text-center border-t border-yellow-200">
                <div class="flex items-center justify-center text-yellow-700 text-sm mb-2">
                    <i class="fas fa-taxi mr-2"></i>
                    <span>Safe & Reliable Taxi Service</span>
                    <i class="fas fa-tachometer-alt ml-2"></i>
                </div>
                <div class="text-xs text-gray-400 mt-1">
                    Powered by Smart Tag Taxi
                </div>
            </div>
        </div>
    </div>
    <!-- Gallery Modal -->
    <div id="galleryModal" class="hidden fixed top-0 left-0 w-full h-full bg-black/90 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full max-h-full overflow-auto relative">
            <div class="flex justify-between items-center p-4 border-b border-yellow-200">
                <h3 id="galleryModalTitle" class="text-lg font-bold text-yellow-900"></h3>
                <button onclick="closeGalleryModal()" class="text-2xl text-yellow-700 hover:text-yellow-900 transition-colors">&times;</button>
            </div>
            <img id="galleryModalImage" src="" alt="" class="w-full object-contain" style="max-height:60vh;">
            <div class="p-4 text-yellow-800 text-sm" id="galleryModalDescription"></div>
        </div>
    </div>
    <script>
        // vCard Download Function
        function saveContact() {
            const vCardData = `BEGIN:VCARD\nVERSION:3.0\nFN:{{ $profile->display_name ?? $user->name ?? 'Taxi Driver' }}\nORG:{{ $profile->profession ?? 'Professional Taxi Driver' }}\nTITLE:{{ $profile->profession ?? 'Professional Taxi Driver' }}\nTEL:{{ $profile->phone ?? '' }}\nEMAIL:{{ $profile->email ?? $user->email ?? '' }}\nURL:{{ $profile->website ?? '' }}\nNOTE:{{ $profile->bio ?? 'Reliable, safe, and friendly taxi service.' }}\nEND:VCARD`;
            const blob = new Blob([vCardData], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($profile->display_name ?? $user->name ?? 'taxi-driver') }}.vcf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        // Gallery Modal Functions
        function openGalleryModal(imageUrl, title, description) {
            document.getElementById('galleryModalImage').src = imageUrl;
            document.getElementById('galleryModalTitle').textContent = title || 'Gallery Image';
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
        // Fade-in animation
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('visible'); } });
            }, observerOptions);
            document.querySelectorAll('.fade-in').forEach(el => { observer.observe(el); });
        });
    </script>
</body>
</html>

