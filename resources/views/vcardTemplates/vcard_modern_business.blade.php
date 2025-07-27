<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Business vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <meta name="msapplication-TileColor" content="#1e40af">
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
    @endif
    
    <style>
        /* Modern Business Theme Styles */
        .business-gradient {
            background: 
                linear-gradient(135deg, rgba(30, 64, 175, 0.95) 0%, rgba(59, 130, 246, 0.95) 25%, rgba(147, 197, 253, 0.95) 50%, rgba(219, 234, 254, 0.95) 75%, rgba(239, 246, 255, 0.95) 100%),
                url('https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(59, 130, 246, 0.2);
            box-shadow: 
                0 25px 45px -10px rgba(30, 64, 175, 0.15),
                0 10px 20px -5px rgba(59, 130, 246, 0.1);
        }
        
        .contact-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(59, 130, 246, 0.2);
            transition: all 0.3s ease;
        }
        
        .contact-card:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
        }
        
        .social-btn {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
        }
        
        .social-btn:hover {
            background: rgba(59, 130, 246, 0.1);
            transform: translateY(-2px) scale(1.05);
        }
        
        .gallery-item {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(59, 130, 246, 0.2);
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.2);
        }
        
        .profile-glow {
            animation: profile-glow 3s ease-in-out infinite;
        }
        
        @keyframes profile-glow {
            0%, 100% { 
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
            }
            50% { 
                box-shadow: 0 0 0 15px rgba(59, 130, 246, 0);
            }
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
        
        .floating-icon {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body class="business-gradient min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="glass-card rounded-3xl overflow-hidden shadow-2xl">
            
            <!-- Header with Background Image -->
            <div class="relative h-32 overflow-hidden
                @if($profile->background_image_url)
                    bg-cover bg-center
                @else
                    bg-gradient-to-r from-blue-600 to-blue-800
                @endif"
                @if($profile->background_image_url)
                    style="background-image: url('{{ $profile->background_image_url }}');"
                @endif>
                <div class="absolute inset-0 bg-blue-900/30"></div>
                <div class="absolute top-4 right-4">
                    <i class="fas fa-briefcase text-white/70 text-2xl floating-icon"></i>
                </div>
            </div>
            
            <!-- Profile Section -->
            <div class="relative px-6 pt-2 pb-6 text-center">
                <!-- Profile Image -->
                <div class="relative inline-block -mt-16 mb-4">
                    <div class="w-32 h-32 rounded-full bg-white p-2 profile-glow">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&background=3b82f6&color=fff&size=128' }}" 
                             class="w-full h-full rounded-full object-cover border-4 border-blue-100" 
                             alt="Profile Photo">
                    </div>
                    <!-- Status Badge -->
                    <div class="absolute -bottom-2 -right-2 bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
                
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Business Professional' }}
                </h1>
                <p class="text-blue-600 font-semibold text-lg mb-4">
                    {{ $profile->profession ?? 'Business Professional' }}
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
                <div class="flex items-center justify-center text-gray-600 text-sm mb-4">
                    <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
                
                <!-- Bio -->
                @if($profile->bio)
                <div class="contact-card rounded-xl p-4 mb-6 text-left">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-quote-left text-blue-500 mr-2"></i>
                        <h3 class="font-semibold text-gray-800">About</h3>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">{{ $profile->bio }}</p>
                </div>
                @endif
            </div>
            
            <!-- Contact Information -->
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-address-book text-blue-500 mr-2"></i>
                    Contact Information
                </h3>
                <div class="space-y-3">
                    @if($profile->phone)
                    <div class="contact-card rounded-lg p-3 flex items-center fade-in">
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
                    
                    @if($profile->email ?? $user->email)
                    <div class="contact-card rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Email</div>
                            <div class="text-sm text-gray-600">{{ $profile->email ?? $user->email }}</div>
                        </div>
                        <a href="mailto:{{ $profile->email ?? $user->email }}" class="bg-indigo-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-indigo-600 transition-colors">
                            Email
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->website)
                    <div class="contact-card rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Website</div>
                            <div class="text-sm text-gray-600">Visit my website</div>
                        </div>
                        <a href="{{ $profile->website }}" target="_blank" class="bg-purple-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-purple-600 transition-colors">
                            Visit
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Social Media Links -->
            @if($socialLinks->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-share-alt text-blue-500 mr-2"></i>
                    Connect With Me
                </h3>
                <div class="grid grid-cols-4 gap-3">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="social-btn aspect-square flex items-center justify-center rounded-xl text-gray-700 text-xl hover:text-blue-600" title="{{ ucfirst($link->platform) }}">
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
                                @default<i class="fas fa-link"></i>@break
                            @endswitch
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Products & Services Section -->
            @if($storeProducts->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-box text-blue-500 mr-2"></i>
                    Our Products & Services
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($storeProducts as $product)
                        <div class="contact-card rounded-lg overflow-hidden fade-in">
                            <div class="aspect-square relative">
                                <img src="{{ $product->image_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover">
                                @if($product->is_on_sale)
                                    <div class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                        -{{ $product->discount_percentage }}%
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h4 class="font-medium text-gray-800 text-sm truncate">{{ $product->name }}</h4>
                                <div class="flex items-center justify-between mt-1">
                                    <div class="flex items-center space-x-1">
                                        <span class="text-blue-600 font-semibold text-sm">{{ $product->formatted_price }}</span>
                                        @if($product->is_on_sale)
                                            <span class="text-gray-400 line-through text-xs">{{ $product->formatted_original_price }}</span>
                                        @endif
                                    </div>
                                    @if($product->stock_status === 'low_stock')
                                        <span class="text-orange-500 text-xs">Low Stock</span>
                                    @elseif($product->stock_status === 'out_of_stock')
                                        <span class="text-red-500 text-xs">Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($user->storeProducts()->available()->count() > 6)
                    <div class="text-center mt-4">
                        <a href="{{ route('store.show', $user->uuid) }}" class="text-blue-500 text-sm hover:text-blue-600">
                            View All Products ({{ $user->storeProducts()->available()->count() }} items)
                        </a>
                    </div>
                @endif
            </div>
            @endif
            
            <!-- Gallery Section -->
            @if($galleryItems->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-images text-blue-500 mr-2"></i>
                    Gallery
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($galleryItems->take(6) as $item)
                        <div class="gallery-item rounded-lg overflow-hidden cursor-pointer" onclick="openGalleryModal('{{ $item->full_image_url }}', '{{ $item->title }}', '{{ $item->description }}')">
                            <img src="{{ $item->full_image_url }}" 
                                 alt="{{ $item->title }}" 
                                 class="w-full h-24 object-cover">
                            @if($item->title)
                                <div class="p-2">
                                    <p class="text-xs font-medium text-gray-800 truncate">{{ $item->title }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @if($galleryItems->count() > 6)
                    <div class="text-center mt-3">
                        <button onclick="showAllGallery()" class="text-blue-500 text-sm hover:text-blue-600">
                            View All ({{ $galleryItems->count() }} items)
                        </button>
                    </div>
                @endif
            </div>
            @endif
            
            <!-- WhatsApp Store Section -->
            @if($profile->store_enabled && $user->currentPlan && $user->currentPlan->hasWhatsAppStore())
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fab fa-whatsapp text-green-500 mr-2"></i>
                    WhatsApp Store
                </h3>
                <div class="contact-card rounded-xl p-4 text-center">
                    @if($profile->store_name)
                        <h4 class="font-semibold text-gray-800 mb-2">{{ $profile->store_name }}</h4>
                    @endif
                    @if($profile->store_description)
                        <p class="text-gray-600 text-sm mb-4">{{ $profile->store_description }}</p>
                    @endif
                    <div class="flex gap-3">
                        <a href="{{ route('store.show', $user->uuid) }}" target="_blank" class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white py-3 px-4 rounded-lg font-semibold text-center flex items-center justify-center hover:from-green-600 hover:to-green-700 transition-all">
                            <i class="fas fa-store mr-2"></i>
                            View Store
                        </a>
                        @if($profile->store_whatsapp || $profile->phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->store_whatsapp ?? $profile->phone) }}" target="_blank" class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white py-3 px-4 rounded-lg font-semibold text-center flex items-center justify-center hover:from-green-700 hover:to-green-800 transition-all">
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
                <button onclick="downloadVCard()" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center hover:from-blue-700 hover:to-indigo-700 transition-all">
                    <i class="fas fa-download mr-2"></i>
                    Save Contact
                </button>
                
                <!-- Share Button -->
                <button onclick="shareProfile()" class="w-full bg-gradient-to-r from-gray-600 to-gray-700 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center hover:from-gray-700 hover:to-gray-800 transition-all">
                    <i class="fas fa-share mr-2"></i>
                    Share Profile
                </button>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 bg-blue-50 text-center border-t border-blue-100">
                <div class="text-xs text-gray-600">
                    Professional Digital Business Card
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    Powered by Smart vCard
                </div>
            </div>
        </div>
    </div>
    
    <!-- Gallery Modal -->
    <div id="galleryModal" class="hidden fixed top-0 left-0 w-full h-full bg-black/90 z-50 flex items-center justify-center p-4">
        <div class="glass-card rounded-2xl max-w-lg w-full max-h-full overflow-auto relative">
            <button onclick="closeGalleryModal()" class="absolute top-4 right-4 text-gray-600 hover:text-gray-800 z-10">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div id="galleryModalContent" class="p-6">
                <!-- Modal content will be inserted here -->
            </div>
        </div>
    </div>
    
    <script>
        // Fade in animation
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach((element, index) => {
                setTimeout(() => {
                    element.classList.add('visible');
                }, index * 100);
            });
        });
        
        // Gallery Modal Functions
        function openGalleryModal(imageUrl, title, description) {
            const modal = document.getElementById('galleryModal');
            const content = document.getElementById('galleryModalContent');
            
            content.innerHTML = `
                <img src="${imageUrl}" alt="${title}" class="w-full rounded-lg mb-4">
                ${title ? `<h3 class="text-lg font-semibold text-gray-800 mb-2">${title}</h3>` : ''}
                ${description ? `<p class="text-gray-600 text-sm">${description}</p>` : ''}
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
FN:{{ $profile->display_name ?? $user->name ?? 'Business Professional' }}
ORG:{{ $profile->profession ?? 'Business Professional' }}
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
            a.download = '{{ Str::slug($profile->display_name ?? $user->name ?? 'contact') }}.vcf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        
        // Share Profile
        function shareProfile() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $profile->display_name ?? $user->name ?? "Business Professional" }}',
                    text: 'Check out my digital business card',
                    url: window.location.href
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Profile link copied to clipboard!');
                });
            }
        }
        
        // Show all gallery items
        function showAllGallery() {
            // This would typically open a full gallery view
            alert('Full gallery view would open here');
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