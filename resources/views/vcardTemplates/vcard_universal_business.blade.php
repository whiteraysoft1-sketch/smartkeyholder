<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universal Business vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <meta name="msapplication-TileColor" content="#1f2937">
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
    @endif
    
    <style>
        /* Universal Business Theme Styles */
        .universal-gradient {
            background: 
                linear-gradient(135deg, rgba(31, 41, 55, 0.95) 0%, rgba(55, 65, 81, 0.95) 25%, rgba(75, 85, 99, 0.95) 50%, rgba(107, 114, 128, 0.95) 75%, rgba(156, 163, 175, 0.95) 100%),
                url('https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .universal-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(99, 102, 241, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(139, 92, 246, 0.05) 0%, transparent 50%);
        }
        
        .universal-shadow {
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.25),
                0 10px 20px -5px rgba(0, 0, 0, 0.1);
        }
        
        .universal-border {
            border-radius: 1.5rem;
        }
        
        .universal-pulse {
            animation: universal-pulse 3s ease-in-out infinite;
        }
        
        @keyframes universal-pulse {
            0%, 100% { 
                transform: scale(1);
                opacity: 1;
            }
            50% { 
                transform: scale(1.02);
                opacity: 0.9;
            }
        }
        
        .universal-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .contact-item {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(99, 102, 241, 0.05) 100%);
            border: 1px solid rgba(59, 130, 246, 0.15);
            transition: all 0.3s ease;
        }
        
        .contact-item:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(99, 102, 241, 0.1) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.3);
        }
        
        .social-icon {
            background: linear-gradient(135deg, #374151 0%, #4b5563 100%);
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 12px 35px rgba(31, 41, 55, 0.4);
        }
        
        .gallery-item {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(249, 250, 251, 0.95) 100%);
            border: 1px solid rgba(209, 213, 219, 0.3);
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .action-button {
            background: linear-gradient(135deg, #374151 0%, #4b5563 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .action-button:hover {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(31, 41, 55, 0.3);
        }
        
        .action-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .action-button:hover::before {
            left: 100%;
        }
        
        .profile-image {
            border: 4px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }
        
        .profile-image:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        }
        
        .universal-text-primary {
            color: #1f2937;
        }
        
        .universal-text-secondary {
            color: #374151;
        }
        
        .universal-bg-primary {
            background-color: #374151;
        }
        
        .universal-bg-secondary {
            background-color: #4b5563;
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .slide-up {
            animation: slideUp 0.6s ease-out;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .background-overlay {
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.9) 0%, rgba(55, 65, 81, 0.7) 100%);
        }
        
        .background-header {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        .profile-badge {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }
        
        .product-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(249, 250, 251, 0.98) 100%);
            border: 1px solid rgba(209, 213, 219, 0.3);
            transition: all 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
            border-color: rgba(59, 130, 246, 0.3);
        }
        
        .whatsapp-btn {
            background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
            transition: all 0.2s ease;
        }
        
        .whatsapp-btn:hover {
            background: linear-gradient(135deg, #128c7e 0%, #075e54 100%);
            transform: scale(1.05);
        }
        
        .product-modal-overlay {
            backdrop-filter: blur(8px);
        }
        
        .service-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
            border: 1px solid rgba(203, 213, 225, 0.4);
            transition: all 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border-color: rgba(59, 130, 246, 0.3);
        }
        
        .feature-highlight {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(99, 102, 241, 0.1) 100%);
            border-left: 4px solid #3b82f6;
        }
        
        .stats-card {
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.05) 0%, rgba(55, 65, 81, 0.05) 100%);
            border: 1px solid rgba(31, 41, 55, 0.1);
        }
        
        .cta-section {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(99, 102, 241, 0.05) 100%);
            border: 2px dashed rgba(59, 130, 246, 0.2);
        }
    </style>
</head>
<body class="universal-gradient min-h-screen flex items-center justify-center universal-pattern">
    <div class="w-full max-w-md mx-auto p-4">
        <div class="relative universal-border universal-shadow universal-card overflow-hidden fade-in">
            <!-- Header -->
            @if($profile->background_image)
            <!-- Header with Background Image -->
            <div class="relative w-full h-48 background-header" style="background-image: url('{{ $profile->background_image_url }}');">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/20"></div>
                <div class="absolute inset-0 background-overlay"></div>
                
                <!-- Profile Image Overlapping -->
                <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                    <div class="universal-pulse">
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-gray-700 to-gray-800 p-1 universal-shadow">
                            <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'UB') . '&background=374151&color=fff&size=128' }}" 
                                 class="w-full h-full rounded-full object-cover border-4 border-white profile-image" 
                                 alt="Profile Photo">
                        </div>
                        <!-- Business Badge -->
                        <div class="absolute -bottom-2 -right-2 w-10 h-10 profile-badge rounded-full flex items-center justify-center text-white border-4 border-white">
                            <i class="fas fa-building text-sm"></i>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- Spacer and Profile Info -->
            <div class="pt-20 pb-6 px-6 text-center">
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Universal Business' }}
                </h1>
                <p class="text-blue-700 font-semibold text-lg mb-2">
                    {{ $profile->profession ?? 'Professional Services' }}
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
                    <i class="fas fa-map-marker-alt text-blue-600 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
            </div>
            @else
            <!-- Header without Background Image -->
            <div class="relative bg-gradient-to-br from-gray-700 via-gray-800 to-gray-900 p-8">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="universal-pulse mb-4">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'UB') . '&background=374151&color=fff&size=128' }}" class="w-28 h-28 rounded-full profile-image object-cover" alt="Profile Photo">
                    </div>
                    <div class="text-white">
                        <h1 class="text-2xl font-bold tracking-tight drop-shadow-lg mb-1">{{ $profile->display_name ?? $user->name ?? 'Universal Business' }}</h1>
                        <p class="text-blue-200 text-lg font-medium mb-2">{{ $profile->profession ?? 'Professional Services' }}</p>
                        @if($profile->location ?? null)
                        <div class="text-blue-300 text-sm flex items-center justify-center gap-2">
                            <i class="fas fa-map-marker-alt"></i> 
                            <span>{{ $profile->location }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="absolute top-4 right-4 text-white/30">
                    <i class="fas fa-building text-3xl"></i>
                </div>
            </div>
            @endif
            
            <!-- Bio -->
            <div class="p-6 slide-up {{ $profile->background_image ? 'pt-4' : '' }}">
                <div class="text-center mb-6">
                    <h2 class="text-xl font-bold universal-text-primary mb-3 flex items-center justify-center gap-2">
                        <i class="fas fa-info-circle text-blue-600"></i>
                        About Us
                    </h2>
                    <p class="universal-text-secondary text-sm leading-relaxed">{{ $profile->bio ?? 'We are committed to delivering exceptional services and solutions tailored to meet your unique needs. Our professional team combines expertise with innovation to help you achieve your goals.' }}</p>
                </div>
                
                <!-- Contact Information -->
                <div class="space-y-3 mb-6">
                    @if($profile->phone)
                    <div class="contact-item p-4 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white mr-4">
                                <i class="fas fa-phone text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Phone</p>
                                <a href="tel:{{ $profile->phone }}" class="text-gray-800 font-semibold hover:text-blue-600 transition-colors">{{ $profile->phone }}</a>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($profile->email ?? $user->email)
                    <div class="contact-item p-4 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white mr-4">
                                <i class="fas fa-envelope text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Email</p>
                                <a href="mailto:{{ $profile->email ?? $user->email }}" class="text-gray-800 font-semibold hover:text-blue-600 transition-colors break-all">{{ $profile->email ?? $user->email }}</a>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($profile->website)
                    <div class="contact-item p-4 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white mr-4">
                                <i class="fas fa-globe text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Website</p>
                                <a href="{{ $profile->website }}" target="_blank" class="text-gray-800 font-semibold hover:text-blue-600 transition-colors break-all">{{ $profile->website }}</a>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($profile->location)
                    <div class="contact-item p-4 rounded-xl">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white mr-4">
                                <i class="fas fa-map-marker-alt text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-xs text-gray-500 uppercase tracking-wide">Location</p>
                                <p class="text-gray-800 font-semibold">{{ $profile->location }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Services/Products -->
                @if($storeProducts && $storeProducts->count() > 0)
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold universal-text-primary flex items-center gap-2">
                            <i class="fas fa-star text-blue-600"></i>
                            Our Offerings
                        </h3>
                        @if($qrCode && $qrCode->uuid)
                        <a href="/qr/{{ $qrCode->uuid }}/store" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-1">
                            <span>View All</span>
                            <i class="fas fa-external-link-alt text-xs"></i>
                        </a>
                        @endif
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($storeProducts->take(4) as $product)
                        <div class="product-card p-3 rounded-xl cursor-pointer relative group" onclick="handleProductClick(event, {{ $product->id }})" title="Click to view details, Ctrl+Click to go to store">
                            @if($qrCode && $qrCode->uuid)
                            <div class="absolute top-2 right-2 bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                <i class="fas fa-external-link-alt text-xs"></i>
                            </div>
                            @endif
                            @if($product->image_url)
                            <div class="aspect-square bg-gray-100 rounded-lg mb-2 overflow-hidden">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </div>
                            @else
                            <div class="aspect-square bg-gradient-to-br from-blue-100 to-gray-100 rounded-lg mb-2 flex items-center justify-center">
                                <i class="fas fa-cube text-2xl text-blue-400"></i>
                            </div>
                            @endif
                            <h4 class="font-semibold text-sm text-gray-800 mb-1 line-clamp-2">{{ $product->name }}</h4>
                            @if($product->price)
                            <p class="text-blue-600 font-bold text-sm">{{ $profile->currency_symbol ?? '$' }}{{ number_format($product->price, 2) }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @if($storeProducts->count() > 4)
                    <div class="text-center mt-4">
                        @if($qrCode && $qrCode->uuid)
                        <a href="/qr/{{ $qrCode->uuid }}/store" target="_blank" class="inline-flex items-center gap-2 bg-blue-100 hover:bg-blue-200 text-blue-700 px-4 py-2 rounded-lg font-semibold text-sm transition-colors">
                            <i class="fas fa-plus"></i>
                            <span>View All {{ $storeProducts->count() }} Items</span>
                        </a>
                        @endif
                    </div>
                    @endif
                </div>
                @endif
                
                <!-- Gallery -->
                @if($galleryItems && $galleryItems->count() > 0)
                <div class="mb-6">
                    <h3 class="text-lg font-bold universal-text-primary mb-4 flex items-center gap-2">
                        <i class="fas fa-images text-blue-600"></i>
                        Gallery
                    </h3>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($galleryItems->take(6) as $item)
                        <div class="gallery-item aspect-square rounded-lg overflow-hidden cursor-pointer" onclick="openGalleryModal('{{ $item->image_url }}', '{{ $item->title }}')">
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Social Links -->
                @if($socialLinks && $socialLinks->count() > 0)
                <div class="mb-6">
                    <h3 class="text-lg font-bold universal-text-primary mb-4 flex items-center gap-2">
                        <i class="fas fa-share-alt text-blue-600"></i>
                        Connect With Us
                    </h3>
                    <div class="flex flex-wrap gap-3 justify-center">
                        @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="social-icon w-12 h-12 rounded-full flex items-center justify-center text-white shadow-lg" title="{{ ucfirst($link->platform) }}">
                            @switch($link->platform)
                                @case('facebook')
                                    <i class="fab fa-facebook-f text-lg"></i>
                                    @break
                                @case('instagram')
                                    <i class="fab fa-instagram text-lg"></i>
                                    @break
                                @case('twitter')
                                    <i class="fab fa-twitter text-lg"></i>
                                    @break
                                @case('linkedin')
                                    <i class="fab fa-linkedin-in text-lg"></i>
                                    @break
                                @case('youtube')
                                    <i class="fab fa-youtube text-lg"></i>
                                    @break
                                @case('whatsapp')
                                    <i class="fab fa-whatsapp text-lg"></i>
                                    @break
                                @case('telegram')
                                    <i class="fab fa-telegram-plane text-lg"></i>
                                    @break
                                @case('tiktok')
                                    <i class="fab fa-tiktok text-lg"></i>
                                    @break
                                @case('github')
                                    <i class="fab fa-github text-lg"></i>
                                    @break
                                @case('snapchat')
                                    <i class="fab fa-snapchat-ghost text-lg"></i>
                                    @break
                                @case('pinterest')
                                    <i class="fab fa-pinterest text-lg"></i>
                                    @break
                                @case('discord')
                                    <i class="fab fa-discord text-lg"></i>
                                    @break
                                @default
                                    <i class="fas fa-link text-lg"></i>
                                    @break
                            @endswitch
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Call to Action Section -->
                <div class="cta-section p-4 rounded-xl mb-6">
                    <div class="text-center">
                        <h3 class="text-lg font-bold universal-text-primary mb-2">Ready to Get Started?</h3>
                        <p class="text-sm text-gray-600 mb-4">Contact us today to discuss how we can help you achieve your goals.</p>
                        <div class="flex gap-2 justify-center">
                            @if($profile->phone)
                            <a href="tel:{{ $profile->phone }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-colors flex items-center gap-2">
                                <i class="fas fa-phone text-xs"></i>
                                <span>Call Now</span>
                            </a>
                            @endif
                            @if($profile->email ?? $user->email)
                            <a href="mailto:{{ $profile->email ?? $user->email }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold text-sm transition-colors flex items-center gap-2">
                                <i class="fas fa-envelope text-xs"></i>
                                <span>Email Us</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="space-y-3">
                    @if($profile->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->phone) }}" target="_blank" class="whatsapp-btn w-full py-4 rounded-xl text-white font-semibold text-center flex items-center justify-center gap-3 shadow-lg">
                        <i class="fab fa-whatsapp text-xl"></i>
                        <span>Chat on WhatsApp</span>
                    </a>
                    @endif
                    
                    <button onclick="saveContact()" class="action-button w-full py-4 rounded-xl text-white font-semibold flex items-center justify-center gap-3 shadow-lg">
                        <i class="fas fa-address-book text-lg"></i>
                        <span>Save Contact</span>
                    </button>
                    
                    <button onclick="shareProfile()" class="bg-gray-600 hover:bg-gray-700 w-full py-4 rounded-xl text-white font-semibold flex items-center justify-center gap-3 shadow-lg transition-all duration-300">
                        <i class="fas fa-share text-lg"></i>
                        <span>Share Profile</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Product Modal -->
    <div id="productModal" class="fixed inset-0 bg-black/50 product-modal-overlay hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl max-w-sm w-full max-h-[90vh] overflow-y-auto">
            <div id="productModalContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
    
    <!-- Gallery Modal -->
    <div id="galleryModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50 p-4">
        <div class="relative max-w-4xl w-full">
            <button onclick="closeGalleryModal()" class="absolute top-4 right-4 text-white bg-black/50 rounded-full w-10 h-10 flex items-center justify-center z-10">
                <i class="fas fa-times"></i>
            </button>
            <img id="galleryModalImage" src="" alt="" class="w-full h-auto rounded-lg">
            <div id="galleryModalTitle" class="text-white text-center mt-4 text-lg font-semibold"></div>
        </div>
    </div>
    
    <script>
        // Currency symbol from profile
        const currencySymbol = "{{ $profile->currency_symbol ?? '$' }}";
        
        // Product Click Handler
        function handleProductClick(event, productId) {
            const storeUuid = "{{ $qrCode && $qrCode->uuid ? $qrCode->uuid : '' }}";
            
            // If Ctrl key is pressed, go directly to store/product page
            if (event.ctrlKey || event.metaKey) {
                if (storeUuid) {
                    window.open(`/qr/${storeUuid}/store/product/${productId}`, '_blank');
                    return;
                }
            }
            
            // Otherwise, open modal
            openProductModal(productId);
        }
        
        // Product Modal Functions
        function openProductModal(productId) {
            const products = @json($storeProducts ?? collect());
            const product = products.find(p => p.id === productId);
            
            if (!product) return;
            
            const modal = document.getElementById('productModal');
            const content = document.getElementById('productModalContent');
            
            const storeUrl = "{{ $qrCode && $qrCode->uuid ? '/qr/' . $qrCode->uuid . '/store' : '#' }}";
            const productUrl = "{{ $qrCode && $qrCode->uuid ? '/qr/' . $qrCode->uuid . '/store/product/' : '#' }}" + product.id;
            
            content.innerHTML = `
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-bold text-gray-800">${product.name}</h3>
                        <button onclick="closeProductModal()" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-100 rounded-full transition-colors">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>
                    ${product.image_url ? `
                    <div class="mb-4">
                        <img src="${product.image_url}" alt="${product.name}" class="w-full h-48 object-cover rounded-lg shadow-sm">
                    </div>
                    ` : `
                    <div class="mb-4">
                        <div class="w-full h-48 bg-gradient-to-br from-blue-100 to-gray-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cube text-4xl text-blue-400"></i>
                        </div>
                    </div>
                    `}
                    ${product.description ? `
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-800 mb-2">Description</h4>
                        <p class="text-gray-600 text-sm leading-relaxed">${product.description}</p>
                    </div>
                    ` : ''}
                    ${product.price ? `
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Price</span>
                            <span class="text-2xl font-bold text-blue-600">${currencySymbol}${parseFloat(product.price).toFixed(2)}</span>
                        </div>
                    </div>
                    ` : ''}
                    <div class="space-y-3">
                        ${storeUrl !== '#' ? `
                        <a href="${productUrl}" target="_blank" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-semibold text-center transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-external-link-alt"></i>
                            <span>View in Store</span>
                        </a>
                        ` : ''}
                        <div class="flex gap-3">
                            ${product.whatsapp_link ? `
                            <a href="${product.whatsapp_link}" target="_blank" class="flex-1 bg-green-500 hover:bg-green-600 text-white py-3 px-4 rounded-lg font-semibold text-center transition-colors flex items-center justify-center gap-2">
                                <i class="fab fa-whatsapp"></i>
                                <span>Order via WhatsApp</span>
                            </a>
                            ` : ''}
                            <button onclick="shareProduct('${product.name}', '${productUrl !== '#' ? window.location.origin + productUrl : window.location.href}')" class="bg-gray-500 hover:bg-gray-600 text-white py-3 px-4 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-share"></i>
                                <span>Share</span>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        
        function closeProductModal() {
            const modal = document.getElementById('productModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        
        // Gallery Modal Functions
        function openGalleryModal(imageUrl, title) {
            const modal = document.getElementById('galleryModal');
            const image = document.getElementById('galleryModalImage');
            const titleElement = document.getElementById('galleryModalTitle');
            
            image.src = imageUrl;
            titleElement.textContent = title || '';
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        
        function closeGalleryModal() {
            const modal = document.getElementById('galleryModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        
        // Utility Functions
        function saveContact() {
            const contact = {
                name: "{{ $profile->display_name ?? $user->name ?? 'Universal Business' }}",
                phone: "{{ $profile->phone ?? '' }}",
                email: "{{ $profile->email ?? $user->email ?? '' }}",
                organization: "{{ $profile->profession ?? 'Professional Services' }}",
                url: "{{ $profile->website ?? '' }}"
            };
            
            const vcard = `BEGIN:VCARD
VERSION:3.0
FN:${contact.name}
ORG:${contact.organization}
TEL:${contact.phone}
EMAIL:${contact.email}
URL:${contact.url}
END:VCARD`;
            
            const blob = new Blob([vcard], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `${contact.name.replace(/[^a-z0-9]/gi, '_').toLowerCase()}.vcf`;
            a.click();
            window.URL.revokeObjectURL(url);
        }
        
        function shareProfile() {
            if (navigator.share) {
                navigator.share({
                    title: "{{ $profile->display_name ?? $user->name ?? 'Universal Business' }}",
                    text: "Check out this business profile",
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Profile link copied to clipboard!');
                });
            }
        }
        
        function shareProduct(productName, url) {
            if (navigator.share) {
                navigator.share({
                    title: productName,
                    text: `Check out this product/service: ${productName}`,
                    url: url
                });
            } else {
                navigator.clipboard.writeText(url).then(() => {
                    alert('Product link copied to clipboard!');
                });
            }
        }
        
        // Close modals when clicking outside
        document.getElementById('productModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeProductModal();
            }
        });
        
        document.getElementById('galleryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGalleryModal();
            }
        });
        
        // Fade in animation on scroll
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
        
        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>