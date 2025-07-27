<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creative Portfolio vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <meta name="msapplication-TileColor" content="#7c3aed">
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
    @endif
    
    <style>
        /* Creative Portfolio Theme Styles */
        .creative-gradient {
            background: 
                linear-gradient(135deg, rgba(124, 58, 237, 0.9) 0%, rgba(168, 85, 247, 0.9) 25%, rgba(236, 72, 153, 0.9) 50%, rgba(251, 113, 133, 0.9) 75%, rgba(252, 165, 165, 0.9) 100%),
                url('https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .glass-morphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 
                0 25px 45px -10px rgba(124, 58, 237, 0.3),
                0 10px 20px -5px rgba(168, 85, 247, 0.2);
        }
        
        .creative-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            transition: all 0.3s ease;
        }
        
        .creative-card:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-5px) rotate(1deg);
            box-shadow: 0 20px 40px rgba(124, 58, 237, 0.3);
        }
        
        .social-orb {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .social-orb::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.6s ease;
            opacity: 0;
        }
        
        .social-orb:hover::before {
            opacity: 1;
            transform: rotate(45deg) translate(50%, 50%);
        }
        
        .social-orb:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 15px 30px rgba(124, 58, 237, 0.4);
        }
        
        .portfolio-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .portfolio-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s ease;
        }
        
        .portfolio-item:hover::before {
            left: 100%;
        }
        
        .portfolio-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(124, 58, 237, 0.4);
        }
        
        .floating-shapes {
            position: absolute;
            opacity: 0.1;
            animation: float-shapes 8s ease-in-out infinite;
        }
        
        @keyframes float-shapes {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg);
                opacity: 0.1;
            }
            25% { 
                transform: translateY(-20px) rotate(90deg);
                opacity: 0.2;
            }
            75% { 
                transform: translateY(-10px) rotate(270deg);
                opacity: 0.15;
            }
        }
        
        .profile-ring {
            animation: profile-ring 4s linear infinite;
        }
        
        @keyframes profile-ring {
            0% { 
                transform: rotate(0deg);
                box-shadow: 0 0 0 0 rgba(168, 85, 247, 0.6);
            }
            25% { 
                box-shadow: 0 0 0 10px rgba(168, 85, 247, 0.2);
            }
            50% { 
                transform: rotate(180deg);
                box-shadow: 0 0 0 20px rgba(168, 85, 247, 0);
            }
            100% { 
                transform: rotate(360deg);
                box-shadow: 0 0 0 0 rgba(168, 85, 247, 0.6);
            }
        }
        
        .text-glow {
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
        
        .slide-in {
            opacity: 0;
            transform: translateX(-30px);
            transition: all 0.6s ease;
        }
        
        .slide-in.visible {
            opacity: 1;
            transform: translateX(0);
        }
        
        .bounce-in {
            opacity: 0;
            transform: scale(0.3);
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }
        
        .bounce-in.visible {
            opacity: 1;
            transform: scale(1);
        }
    </style>
</head>
<body class="creative-gradient min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="glass-morphism rounded-3xl overflow-hidden shadow-2xl relative">
            
            <!-- Floating Background Shapes -->
            <div class="floating-shapes top-4 left-4 text-white text-3xl">
                <i class="fas fa-palette"></i>
            </div>
            <div class="floating-shapes top-8 right-6 text-white text-2xl" style="animation-delay: -2s;">
                <i class="fas fa-brush"></i>
            </div>
            <div class="floating-shapes bottom-20 left-8 text-white text-xl" style="animation-delay: -4s;">
                <i class="fas fa-pen-nib"></i>
            </div>
            
            <!-- Header with Background -->
            <div class="relative h-40 overflow-hidden
                @if($profile->background_image_url)
                    bg-cover bg-center
                @else
                    bg-gradient-to-br from-purple-600 via-pink-500 to-red-400
                @endif"
                @if($profile->background_image_url)
                    style="background-image: url('{{ $profile->background_image_url }}');"
                @endif>
                <div class="absolute inset-0 bg-gradient-to-br from-purple-900/40 via-pink-900/40 to-red-900/40"></div>
                <div class="absolute top-4 right-4">
                    <i class="fas fa-star text-white/70 text-2xl floating-shapes"></i>
                </div>
                <div class="absolute bottom-4 left-4">
                    <i class="fas fa-magic text-white/70 text-xl floating-shapes" style="animation-delay: -3s;"></i>
                </div>
            </div>
            
            <!-- Profile Section -->
            <div class="relative px-6 pt-2 pb-6 text-center">
                <!-- Profile Image -->
                <div class="relative inline-block -mt-20 mb-4">
                    <div class="w-36 h-36 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 p-1 profile-ring">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'Creative') . '&background=7c3aed&color=fff&size=144' }}" 
                             class="w-full h-full rounded-full object-cover border-4 border-white/30" 
                             alt="Profile Photo">
                    </div>
                    <!-- Creative Badge -->
                    <div class="absolute -bottom-2 -right-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full w-10 h-10 flex items-center justify-center text-lg">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                </div>
                
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-white mb-1 text-glow bounce-in">
                    {{ $profile->display_name ?? $user->name ?? 'Creative Professional' }}
                </h1>
                <p class="text-purple-200 font-semibold text-lg mb-2 slide-in">
                    {{ $profile->profession ?? 'Creative Professional' }}
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
                
                
                @if($profile->location)
                <div class="flex items-center justify-center text-white/90 text-sm mb-4 slide-in">
                    <i class="fas fa-map-marker-alt text-purple-300 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
                
                <!-- Bio -->
                @if($profile->bio)
                <div class="creative-card rounded-xl p-4 mb-6 text-left slide-in">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-quote-left text-purple-300 mr-2"></i>
                        <h3 class="font-semibold text-white">Creative Vision</h3>
                    </div>
                    <p class="text-white/90 text-sm leading-relaxed">{{ $profile->bio }}</p>
                </div>
                @endif
            </div>
            
            <!-- Contact Information -->
            <div class="px-6 py-4">
                <h3 class="font-semibold text-white mb-4 flex items-center slide-in">
                    <i class="fas fa-address-book text-purple-300 mr-2"></i>
                    Let's Connect
                </h3>
                <div class="space-y-3">
                    @if($profile->phone)
                    <div class="creative-card rounded-lg p-3 flex items-center slide-in">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-white">Phone</div>
                            <div class="text-sm text-white/80">{{ $profile->phone }}</div>
                        </div>
                        <a href="tel:{{ $profile->phone }}" class="bg-gradient-to-r from-purple-500 to-purple-600 text-white px-3 py-1 rounded-lg text-sm hover:from-purple-600 hover:to-purple-700 transition-all">
                            Call
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->email ?? $user->email)
                    <div class="creative-card rounded-lg p-3 flex items-center slide-in">
                        <div class="w-10 h-10 bg-gradient-to-r from-pink-500 to-pink-600 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-white">Email</div>
                            <div class="text-sm text-white/80">{{ $profile->email ?? $user->email }}</div>
                        </div>
                        <a href="mailto:{{ $profile->email ?? $user->email }}" class="bg-gradient-to-r from-pink-500 to-pink-600 text-white px-3 py-1 rounded-lg text-sm hover:from-pink-600 hover:to-pink-700 transition-all">
                            Email
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->website)
                    <div class="creative-card rounded-lg p-3 flex items-center slide-in">
                        <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-white">Portfolio</div>
                            <div class="text-sm text-white/80">View my work</div>
                        </div>
                        <a href="{{ $profile->website }}" target="_blank" class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white px-3 py-1 rounded-lg text-sm hover:from-indigo-600 hover:to-indigo-700 transition-all">
                            Visit
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Social Media Orbs -->
            @if($socialLinks->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-white mb-4 flex items-center slide-in">
                    <i class="fas fa-share-alt text-purple-300 mr-2"></i>
                    Social Universe
                </h3>
                <div class="flex flex-wrap gap-3 justify-center">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="social-orb w-12 h-12 flex items-center justify-center rounded-full text-white text-lg bounce-in" title="{{ ucfirst($link->platform) }}">
                            @switch($link->platform)
                                @case('facebook')<i class="fab fa-facebook-f"></i>@break
                                @case('instagram')<i class="fab fa-instagram"></i>@break
                                @case('twitter')<i class="fab fa-twitter"></i>@break
                                @case('linkedin')<i class="fab fa-linkedin-in"></i>@break
                                @case('youtube')<i class="fab fa-youtube"></i>@break
                                @case('whatsapp')<i class="fab fa-whatsapp"></i>@break
                                @case('telegram')<i class="fab fa-telegram-plane"></i>@break
                                @case('tiktok')<i class="fab fa-tiktok"></i>@break
                                @case('snapchat')<i class="fab fa-snapchat-ghost"></i>@break
                                @case('pinterest')<i class="fab fa-pinterest"></i>@break
                                @case('discord')<i class="fab fa-discord"></i>@break
                                @case('github')<i class="fab fa-github"></i>@break
                                @case('behance')<i class="fab fa-behance"></i>@break
                                @case('dribbble')<i class="fab fa-dribbble"></i>@break
                                @default<i class="fas fa-link"></i>@break
                            @endswitch
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Creative Products & Services -->
            @if($storeProducts->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-white mb-4 flex items-center slide-in">
                    <i class="fas fa-palette text-purple-300 mr-2"></i>
                    Creative Products & Services
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($storeProducts as $product)
                        <div class="creative-card rounded-xl overflow-hidden slide-in">
                            <div class="aspect-square relative">
                                <img src="{{ $product->image_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover">
                                @if($product->is_on_sale)
                                    <div class="absolute top-2 right-2 bg-gradient-to-r from-pink-500 to-red-500 text-white text-xs px-2 py-1 rounded-full">
                                        -{{ $product->discount_percentage }}%
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-end">
                                    <div class="p-3 w-full">
                                        <h4 class="text-white font-medium text-sm">{{ $product->name }}</h4>
                                        <div class="flex items-center justify-between mt-1">
                                            <div class="flex items-center space-x-1">
                                                <span class="text-purple-300 font-semibold text-sm">{{ $product->formatted_price }}</span>
                                                @if($product->is_on_sale)
                                                    <span class="text-white/60 line-through text-xs">{{ $product->formatted_original_price }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($user->storeProducts()->available()->count() > 6)
                    <div class="text-center mt-4">
                        <a href="{{ route('store.show', $user->uuid) }}" class="text-purple-300 text-sm hover:text-purple-200 transition-colors">
                            <i class="fas fa-plus-circle mr-1"></i>
                            View All Creative Works ({{ $user->storeProducts()->available()->count() }} items)
                        </a>
                    </div>
                @endif
            </div>
            @endif
            
            <!-- Portfolio Gallery -->
            @if($galleryItems->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-white mb-4 flex items-center slide-in">
                    <i class="fas fa-images text-purple-300 mr-2"></i>
                    Creative Showcase
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($galleryItems->take(4) as $item)
                        <div class="portfolio-item rounded-xl overflow-hidden cursor-pointer bounce-in" onclick="openGalleryModal('{{ $item->full_image_url }}', '{{ $item->title }}', '{{ $item->description }}')">
                            <div class="aspect-square relative">
                                <img src="{{ $item->full_image_url }}" 
                                     alt="{{ $item->title }}" 
                                     class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-end">
                                    @if($item->title)
                                        <p class="text-white text-sm font-medium p-3">{{ $item->title }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($galleryItems->count() > 4)
                    <div class="text-center mt-4">
                        <button onclick="showAllGallery()" class="text-purple-300 text-sm hover:text-purple-200 transition-colors">
                            <i class="fas fa-plus-circle mr-1"></i>
                            View All {{ $galleryItems->count() }} Works
                        </button>
                    </div>
                @endif
            </div>
            @endif
            
            <!-- WhatsApp Store Section -->
            @if($profile->store_enabled && $user->currentPlan && $user->currentPlan->hasWhatsAppStore())
            <div class="px-6 py-4">
                <h3 class="font-semibold text-white mb-4 flex items-center slide-in">
                    <i class="fab fa-whatsapp text-green-400 mr-2"></i>
                    Creative Store
                </h3>
                <div class="creative-card rounded-xl p-4 text-center slide-in">
                    @if($profile->store_name)
                        <h4 class="font-semibold text-white mb-2">{{ $profile->store_name }}</h4>
                    @endif
                    @if($profile->store_description)
                        <p class="text-white/80 text-sm mb-4">{{ $profile->store_description }}</p>
                    @endif
                    <div class="flex gap-3">
                        <a href="{{ route('store.show', $user->uuid) }}" target="_blank" class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white py-3 px-4 rounded-lg font-semibold text-center flex items-center justify-center hover:from-green-600 hover:to-green-700 transition-all transform hover:scale-105">
                            <i class="fas fa-store mr-2"></i>
                            View Store
                        </a>
                        @if($profile->store_whatsapp || $profile->phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->store_whatsapp ?? $profile->phone) }}" target="_blank" class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white py-3 px-4 rounded-lg font-semibold text-center flex items-center justify-center hover:from-green-700 hover:to-green-800 transition-all transform hover:scale-105">
                            <i class="fab fa-whatsapp mr-2"></i>
                            Chat Now
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Action Buttons -->
            <div class="px-6 py-6 space-y-3">
                <!-- Save Contact Button -->
                <button onclick="downloadVCard()" class="w-full bg-gradient-to-r from-purple-600 via-pink-500 to-red-500 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center hover:from-purple-700 hover:via-pink-600 hover:to-red-600 transition-all transform hover:scale-105">
                    <i class="fas fa-download mr-2"></i>
                    Save My Contact
                </button>
                
                <!-- Share Button -->
                <button onclick="shareProfile()" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center hover:from-indigo-700 hover:to-purple-700 transition-all transform hover:scale-105">
                    <i class="fas fa-share mr-2"></i>
                    Share My Art
                </button>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 bg-black/20 text-center border-t border-white/20">
                <div class="flex items-center justify-center text-purple-200 text-sm mb-2">
                    <i class="fas fa-palette mr-2 floating-shapes"></i>
                    <span>Creative Digital Identity</span>
                    <i class="fas fa-sparkles ml-2 floating-shapes" style="animation-delay: -1s;"></i>
                </div>
                <div class="text-xs text-white/70">
                    Crafted with Creativity & Code
                </div>
            </div>
        </div>
    </div>
    
    <!-- Gallery Modal -->
    <div id="galleryModal" class="hidden fixed top-0 left-0 w-full h-full bg-black/95 z-50 flex items-center justify-center p-4">
        <div class="glass-morphism rounded-2xl max-w-lg w-full max-h-full overflow-auto relative">
            <button onclick="closeGalleryModal()" class="absolute top-4 right-4 text-white hover:text-purple-300 z-10">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div id="galleryModalContent" class="p-6">
                <!-- Modal content will be inserted here -->
            </div>
        </div>
    </div>
    
    <script>
        // Animation triggers
        document.addEventListener('DOMContentLoaded', function() {
            const slideElements = document.querySelectorAll('.slide-in');
            const bounceElements = document.querySelectorAll('.bounce-in');
            
            slideElements.forEach((element, index) => {
                setTimeout(() => {
                    element.classList.add('visible');
                }, index * 150);
            });
            
            bounceElements.forEach((element, index) => {
                setTimeout(() => {
                    element.classList.add('visible');
                }, index * 100 + 300);
            });
        });
        
        // Gallery Modal Functions
        function openGalleryModal(imageUrl, title, description) {
            const modal = document.getElementById('galleryModal');
            const content = document.getElementById('galleryModalContent');
            
            content.innerHTML = `
                <img src="${imageUrl}" alt="${title}" class="w-full rounded-lg mb-4">
                ${title ? `<h3 class="text-lg font-semibold text-white mb-2">${title}</h3>` : ''}
                ${description ? `<p class="text-white/80 text-sm">${description}</p>` : ''}
            `;
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeGalleryModal() {
            const modal = document.getElementById('galleryModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Download vCard
        function downloadVCard() {
            const vCardData = `BEGIN:VCARD
VERSION:3.0
FN:{{ $profile->display_name ?? $user->name ?? 'Creative Professional' }}
ORG:{{ $profile->profession ?? 'Creative Professional' }}
TEL:{{ $profile->phone ?? '' }}
EMAIL:{{ $profile->email ?? $user->email ?? '' }}
URL:{{ $profile->website ?? '' }}
ADR:{{ $profile->location ?? '' }}
NOTE:{{ $profile->bio ?? '' }}
END:VCARD`;
            
            const blob = new Blob([vCardData], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($profile->display_name ?? $user->name ?? 'creative-contact') }}.vcf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        
        // Share Profile
        function shareProfile() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $profile->display_name ?? $user->name ?? "Creative Professional" }}',
                    text: 'Check out my creative portfolio',
                    url: window.location.href
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    // Create a temporary notification
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 bg-purple-600 text-white px-4 py-2 rounded-lg z-50';
                    notification.textContent = 'Profile link copied!';
                    document.body.appendChild(notification);
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 3000);
                });
            }
        }
        
        // Show all gallery items
        function showAllGallery() {
            // This would typically open a full gallery view
            alert('Full creative showcase would open here');
        }
        
        // Close modal when clicking outside
        document.getElementById('galleryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGalleryModal();
            }
        });
    </script>
</body>
</html>
