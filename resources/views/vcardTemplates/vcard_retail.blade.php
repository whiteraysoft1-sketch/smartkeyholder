<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail & Wholesale vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <meta name="msapplication-TileColor" content="#f59e42">
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
    @endif
    
    <style>
        /* Custom Retail & Wholesale Theme Styles */
        .retail-gradient {
            background: 
                linear-gradient(135deg, rgba(245, 158, 66, 0.95) 0%, rgba(251, 191, 36, 0.95) 25%, rgba(252, 211, 77, 0.95) 50%, rgba(245, 158, 66, 0.95) 75%, rgba(217, 119, 6, 0.95) 100%),
                url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .retail-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(245, 158, 66, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(251, 191, 36, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(252, 211, 77, 0.05) 0%, transparent 50%);
        }
        
        .retail-shadow {
            box-shadow: 
                0 20px 40px -10px rgba(245, 158, 66, 0.3),
                0 8px 16px -4px rgba(245, 158, 66, 0.1);
        }
        
        .retail-border {
            border-radius: 1.5rem;
        }
        
        .shopping-pulse {
            animation: shopping-pulse 3s ease-in-out infinite;
        }
        
        @keyframes shopping-pulse {
            0%, 100% { 
                transform: scale(1);
                opacity: 1;
            }
            50% { 
                transform: scale(1.05);
                opacity: 0.8;
            }
        }
        
        .retail-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .contact-item {
            background: linear-gradient(135deg, rgba(245, 158, 66, 0.1) 0%, rgba(251, 191, 36, 0.1) 100%);
            border: 1px solid rgba(245, 158, 66, 0.2);
            transition: all 0.3s ease;
        }
        
        .contact-item:hover {
            background: linear-gradient(135deg, rgba(245, 158, 66, 0.15) 0%, rgba(251, 191, 36, 0.15) 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(245, 158, 66, 0.2);
        }
        
        .social-icon {
            background: linear-gradient(135deg, #f59e42 0%, #fbbf24 100%);
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: linear-gradient(135deg, #d97706 0%, #f59e42 100%);
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 12px 35px rgba(245, 158, 66, 0.4);
        }
        
        .gallery-item {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(254, 243, 199, 0.9) 100%);
            border: 1px solid rgba(245, 158, 66, 0.2);
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(245, 158, 66, 0.2);
        }
        
        .action-button {
            background: linear-gradient(135deg, #f59e42 0%, #fbbf24 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .action-button:hover {
            background: linear-gradient(135deg, #d97706 0%, #f59e42 100%);
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(245, 158, 66, 0.4);
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
            border: 4px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 8px 32px rgba(245, 158, 66, 0.3);
            transition: all 0.3s ease;
        }
        
        .profile-image:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 40px rgba(245, 158, 66, 0.4);
        }
        
        .retail-text-primary {
            color: #92400e;
        }
        
        .retail-text-secondary {
            color: #a16207;
        }
        
        .retail-bg-primary {
            background-color: #f59e42;
        }
        
        .retail-bg-secondary {
            background-color: #fbbf24;
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
        
        .profile-overlap {
            position: absolute;
            bottom: -64px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
        }
        
        .header-spacer {
            height: 64px;
        }
        
        .background-overlay {
            background: linear-gradient(135deg, rgba(245, 158, 66, 0.8) 0%, rgba(251, 191, 36, 0.6) 100%);
        }
        
        .background-header {
            background: linear-gradient(135deg, #f59e42 0%, #fbbf24 100%);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        .profile-badge {
            background: linear-gradient(135deg, #f59e42 0%, #fbbf24 100%);
            box-shadow: 0 4px 12px rgba(245, 158, 66, 0.4);
        }
        
        .product-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(254, 243, 199, 0.95) 100%);
            border: 1px solid rgba(245, 158, 66, 0.2);
            transition: all 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(245, 158, 66, 0.2);
            border-color: rgba(245, 158, 66, 0.4);
        }
        
        .whatsapp-btn {
            background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
            transition: all 0.2s ease;
        }
        
        .whatsapp-btn:hover {
            background: linear-gradient(135deg, #128c7e 0%, #075e54 100%);
            transform: scale(1.1);
        }
        
        .product-modal-overlay {
            backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="retail-gradient min-h-screen flex items-center justify-center retail-pattern">
    <div class="w-full max-w-md mx-auto p-4">
        <div class="relative retail-border retail-shadow retail-card overflow-hidden fade-in">
            <!-- Header -->
            @if($profile->background_image)
            <!-- Header with Background Image -->
            <div class="relative w-full h-48 background-header" style="background-image: url('{{ $profile->background_image_url }}');">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/20"></div>
                <div class="absolute inset-0 background-overlay"></div>
                
                <!-- Profile Image Overlapping -->
                <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                    <div class="shopping-pulse">
                        <div class="w-32 h-32 rounded-full bg-gradient-to-br from-orange-400 to-yellow-500 p-1 retail-shadow">
                            <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'RW') . '&background=f59e42&color=fff&size=128' }}" 
                                 class="w-full h-full rounded-full object-cover border-4 border-white profile-image" 
                                 alt="Profile Photo">
                        </div>
                        <!-- Shopping Cart Badge -->
                        <div class="absolute -bottom-2 -right-2 w-10 h-10 profile-badge rounded-full flex items-center justify-center text-white border-4 border-white">
                            <i class="fas fa-shopping-cart text-sm"></i>
                        </div>
                    </div>
                </div>
                
            </div>
            <!-- Spacer and Profile Info -->
            <div class="pt-20 pb-6 px-6 text-center">
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Retailer' }}
                </h1>
                <p class="text-orange-700 font-semibold text-lg mb-2">
                    {{ $profile->profession ?? 'Retail & Wholesale' }}
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
                    <i class="fas fa-map-marker-alt text-orange-600 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
            </div>
            @else
            <!-- Header without Background Image -->
            <div class="relative bg-gradient-to-br from-orange-400 via-yellow-400 to-orange-500 p-8">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="shopping-pulse mb-4">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'RW') . '&background=f59e42&color=fff&size=128' }}" class="w-28 h-28 rounded-full profile-image object-cover" alt="Profile Photo">
                    </div>
                    <div class="text-white">
                        <h1 class="text-2xl font-bold tracking-tight drop-shadow-lg mb-1">{{ $profile->display_name ?? $user->name ?? 'Retailer' }}</h1>
                        <p class="text-yellow-100 text-lg font-medium mb-2">{{ $profile->profession ?? 'Retail & Wholesale' }}</p>
                        @if($profile->location ?? null)
                        <div class="text-yellow-200 text-sm flex items-center justify-center gap-2">
                            <i class="fas fa-map-marker-alt"></i> 
                            <span>{{ $profile->location }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="absolute top-4 right-4 text-white/30">
                    <i class="fas fa-shopping-cart text-3xl"></i>
                </div>
            </div>
            @endif
            <!-- Bio -->
            <div class="p-6 slide-up {{ $profile->background_image ? 'pt-4' : '' }}">
                <div class="text-center mb-6">
                    <h2 class="text-xl font-bold retail-text-primary mb-3 flex items-center justify-center gap-2">
                        <i class="fas fa-store text-orange-500"></i>
                        About Our Business
                    </h2>
                    <p class="retail-text-secondary text-sm leading-relaxed">{{ $profile->bio ?? 'Your trusted partner for quality products at competitive wholesale and retail prices. We pride ourselves on excellent customer service and reliable supply chains.' }}</p>
                </div>
                
                <!-- Social Links -->
                @if($socialLinks->count() > 0)
                <div class="flex flex-wrap gap-3 justify-center mb-6">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="w-12 h-12 flex items-center justify-center rounded-full social-icon text-white text-lg shadow-lg" title="{{ ucfirst($link->platform) }}">
                            @switch($link->platform)
                                @case('linkedin')<i class="fab fa-linkedin-in"></i>@break
                                @case('twitter')<i class="fab fa-twitter"></i>@break
                                @case('github')<i class="fab fa-github"></i>@break
                                @case('instagram')<i class="fab fa-instagram"></i>@break
                                @case('facebook')<i class="fab fa-facebook-f"></i>@break
                                @case('youtube')<i class="fab fa-youtube"></i>@break
                                @case('tiktok')<i class="fab fa-tiktok"></i>@break
                                @case('whatsapp')<i class="fab fa-whatsapp"></i>@break
                                @default<i class="fas fa-link"></i>
                            @endswitch
                        </a>
                    @endforeach
                </div>
                @endif
                <!-- Contact Info -->
                <div class="space-y-3 mb-6">
                    <h3 class="text-lg font-semibold retail-text-primary mb-4 flex items-center gap-2">
                        <i class="fas fa-address-book text-orange-500"></i>
                        Contact Information
                    </h3>
                    @if($profile->phone ?? null)
                    <a href="tel:{{ $profile->phone }}" class="contact-item flex items-center gap-4 p-4 rounded-xl">
                        <div class="w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <div class="font-medium retail-text-primary">Phone</div>
                            <div class="text-sm retail-text-secondary">{{ $profile->phone }}</div>
                        </div>
                    </a>
                    @endif
                    @if($user->email)
                    <a href="mailto:{{ $user->email }}" class="contact-item flex items-center gap-4 p-4 rounded-xl">
                        <div class="w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <div class="font-medium retail-text-primary">Email</div>
                            <div class="text-sm retail-text-secondary">{{ $user->email }}</div>
                        </div>
                    </a>
                    @endif
                    @if($profile->website ?? null)
                    <a href="{{ $profile->website }}" target="_blank" class="contact-item flex items-center gap-4 p-4 rounded-xl">
                        <div class="w-10 h-10 bg-orange-500 text-white rounded-full flex items-center justify-center">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div>
                            <div class="font-medium retail-text-primary">Website</div>
                            <div class="text-sm retail-text-secondary">{{ str_replace(['http://', 'https://'], '', $profile->website) }}</div>
                        </div>
                    </a>
                    @endif
                </div>
                <!-- Gallery -->
                @if($galleryItems->count() > 0)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold retail-text-primary mb-4 flex items-center gap-2">
                        <i class="fas fa-images text-orange-500"></i>
                        Product Gallery
                    </h3>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($galleryItems as $item)
                        <div class="gallery-item rounded-xl overflow-hidden shadow-lg cursor-pointer group relative" onclick="openGalleryModal('{{ $item->full_image_url }}', '{{ $item->title }}', '{{ $item->description }}')">
                            <img src="{{ $item->full_image_url }}" alt="{{ $item->title }}" class="w-full h-32 object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            @if($item->title)
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-orange-900/90 to-transparent text-white text-xs px-3 py-2">
                                <div class="font-medium">{{ $item->title }}</div>
                            </div>
                            @endif
                            <div class="absolute top-2 right-2 w-8 h-8 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <i class="fas fa-expand text-white text-sm"></i>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Store Products Section -->
                @if($profile->store_enabled && $storeProducts->count() > 0)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold retail-text-primary mb-4 flex items-center gap-2">
                        <i class="fas fa-shopping-bag text-orange-500"></i>
                        Our Products
                    </h3>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($storeProducts as $product)
                        <div class="product-card rounded-xl overflow-hidden shadow-lg cursor-pointer group relative" onclick="openProductModal('{{ $product->id }}', '{{ $product->name }}', '{{ $product->description }}', '{{ $product->image_url }}', '{{ $product->formatted_price }}', '{{ $product->formatted_original_price }}', {{ $product->is_on_sale ? 'true' : 'false' }}, {{ $product->discount_percentage }})">
                            <div class="aspect-square relative">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @if($product->is_on_sale)
                                    <div class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold">
                                        -{{ $product->discount_percentage }}%
                                    </div>
                                @endif
                                @if($product->stock_status === 'out_of_stock')
                                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">Out of Stock</span>
                                    </div>
                                @elseif($product->stock_status === 'low_stock')
                                    <div class="absolute top-2 left-2 bg-orange-500 text-white text-xs px-2 py-1 rounded-full font-bold">
                                        Low Stock
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h4 class="font-medium retail-text-primary text-sm truncate mb-1">{{ $product->name }}</h4>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-1">
                                        <span class="text-orange-600 font-bold text-sm">{{ $product->formatted_price }}</span>
                                        @if($product->is_on_sale)
                                            <span class="text-gray-400 line-through text-xs">{{ $product->formatted_original_price }}</span>
                                        @endif
                                    </div>
                                    <button class="w-6 h-6 whatsapp-btn text-white rounded-full flex items-center justify-center" onclick="event.stopPropagation(); orderProductWhatsApp('{{ $product->name }}', '{{ $product->formatted_price }}')">
                                        <i class="fab fa-whatsapp text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if(method_exists($user, 'storeProducts') && $user->storeProducts()->available()->count() > 6)
                        <div class="text-center mt-4">
                            <a href="{{ route('store.show', $qrCode->uuid) }}" target="_blank" class="text-orange-500 text-sm hover:text-orange-600 font-medium">
                                View All Products ({{ $user->storeProducts()->available()->count() }} items)
                            </a>
                        </div>
                    @endif
                </div>
                @endif
                
                <!-- Actions -->
                <div class="space-y-3 pt-4 border-t border-orange-200">
                    <button class="action-button w-full py-4 rounded-xl text-white font-bold shadow-lg flex items-center justify-center gap-3" onclick="saveContact()">
                        <i class="fas fa-address-card text-lg"></i>
                        <span>Save Contact</span>
                    </button>
                    @if($profile->store_enabled && method_exists($user, 'storeProducts') && $user->storeProducts()->available()->count() > 0)
                    <a href="{{ route('store.show', $qrCode->uuid) }}" target="_blank" class="block w-full py-4 rounded-xl bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold shadow-lg text-center transition-all duration-200 transform hover:scale-105">
                        <i class="fas fa-store text-lg mr-2"></i>
                        <span>Visit Our Store</span>
                    </a>
                    @endif
                    <div class="text-center">
                        <p class="text-xs retail-text-secondary">
                            <i class="fas fa-shield-alt"></i>
                            Your trusted retail partner
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Gallery Modal -->
    <div id="galleryModal" class="hidden fixed top-0 left-0 w-full h-full bg-black/90 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full max-h-full overflow-auto relative retail-shadow">
            <div class="flex justify-between items-center p-6 border-b border-orange-200 bg-gradient-to-r from-orange-50 to-yellow-50">
                <h3 id="galleryModalTitle" class="text-xl font-bold retail-text-primary"></h3>
                <button onclick="closeGalleryModal()" class="w-10 h-10 flex items-center justify-center rounded-full bg-orange-100 hover:bg-orange-200 text-orange-600 hover:text-orange-800 transition-all duration-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <img id="galleryModalImage" src="" alt="" class="w-full object-contain" style="max-height:60vh;">
            <div class="p-6 bg-gradient-to-r from-orange-50 to-yellow-50" id="galleryModalDescription">
                <p class="retail-text-secondary text-sm"></p>
            </div>
        </div>
    </div>
    
    <!-- Product Modal -->
    <div id="productModal" class="hidden fixed top-0 left-0 w-full h-full bg-black/90 product-modal-overlay z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full max-h-full overflow-auto relative retail-shadow">
            <div class="flex justify-between items-center p-6 border-b border-orange-200 bg-gradient-to-r from-orange-50 to-yellow-50">
                <h3 id="productModalTitle" class="text-xl font-bold retail-text-primary"></h3>
                <button onclick="closeProductModal()" class="w-10 h-10 flex items-center justify-center rounded-full bg-orange-100 hover:bg-orange-200 text-orange-600 hover:text-orange-800 transition-all duration-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="relative">
                <img id="productModalImage" src="" alt="" class="w-full h-64 object-cover">
                <div id="productModalSaleBadge" class="hidden absolute top-4 right-4 bg-red-500 text-white text-sm px-3 py-1 rounded-full font-bold">
                    -<span id="productModalDiscount"></span>%
                </div>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <span id="productModalPrice" class="text-2xl font-bold text-orange-600"></span>
                            <span id="productModalOriginalPrice" class="hidden text-lg text-gray-400 line-through"></span>
                        </div>
                    </div>
                    <p id="productModalDescription" class="retail-text-secondary text-sm leading-relaxed mb-4"></p>
                </div>
                <div class="flex gap-3">
                    <button onclick="orderCurrentProductWhatsApp()" class="flex-1 action-button py-3 rounded-xl text-white font-bold flex items-center justify-center gap-2">
                        <i class="fab fa-whatsapp text-lg"></i>
                        <span>Order via WhatsApp</span>
                    </button>
                    <button onclick="closeProductModal()" class="px-6 py-3 rounded-xl border-2 border-orange-200 retail-text-primary font-medium hover:bg-orange-50 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function saveContact() {
            const name = "{{ $profile->display_name ?? $user->name ?? 'Retailer' }}";
            const title = "{{ $profile->profession ?? 'Retail & Wholesale' }}";
            const email = "{{ $user->email ?? '' }}";
            const phone = "{{ $profile->phone ?? '' }}";
            const website = "{{ $profile->website ?? '' }}";
            const location = "{{ $profile->location ?? '' }}";
            const bio = `{{ $profile->bio ?? '' }}`;
            const vcard = `BEGIN:VCARD\nVERSION:3.0\nFN:${name}\nTITLE:${title}\nEMAIL:${email}\nTEL:${phone}\nURL:${website}\nADR:;;${location};;;;\nNOTE:${bio}\nEND:VCARD`;
            const blob = new Blob([vcard], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `${name.replace(/\s+/g, '_')}_contact.vcf`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        function openGalleryModal(imageUrl, title, description) {
            document.getElementById('galleryModalImage').src = imageUrl;
            document.getElementById('galleryModalTitle').textContent = title || 'Product Image';
            const descElement = document.getElementById('galleryModalDescription').querySelector('p');
            if (descElement) {
                descElement.textContent = description || 'View our quality products and services.';
            }
            document.getElementById('galleryModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeGalleryModal() {
            document.getElementById('galleryModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Product Modal Functions
        let currentProduct = {};
        
        function openProductModal(id, name, description, imageUrl, price, originalPrice, isOnSale, discountPercentage) {
            currentProduct = {
                id: id,
                name: name,
                description: description,
                imageUrl: imageUrl,
                price: price,
                originalPrice: originalPrice,
                isOnSale: isOnSale,
                discountPercentage: discountPercentage
            };
            
            document.getElementById('productModalTitle').textContent = name;
            document.getElementById('productModalImage').src = imageUrl;
            document.getElementById('productModalPrice').textContent = price;
            document.getElementById('productModalDescription').textContent = description || 'High-quality product available for purchase.';
            
            if (isOnSale && originalPrice) {
                document.getElementById('productModalOriginalPrice').textContent = originalPrice;
                document.getElementById('productModalOriginalPrice').classList.remove('hidden');
                document.getElementById('productModalSaleBadge').classList.remove('hidden');
                document.getElementById('productModalDiscount').textContent = discountPercentage;
            } else {
                document.getElementById('productModalOriginalPrice').classList.add('hidden');
                document.getElementById('productModalSaleBadge').classList.add('hidden');
            }
            
            document.getElementById('productModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeProductModal() {
            document.getElementById('productModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // WhatsApp Ordering Functions
        const whatsappNumber = "{{ preg_replace('/[^0-9]/', '', $profile->store_whatsapp ?? $profile->phone ?? '') }}";
        const storeName = "{{ $profile->store_name ?? $profile->display_name ?? $user->name ?? 'Store' }}";
        
        function orderProductWhatsApp(productName, productPrice) {
            if (!whatsappNumber) {
                showNotification('WhatsApp number not available. Please contact us directly.', 'error');
                return;
            }
            
            const message = `🛒 *Product Inquiry from ${storeName}*\n\n` +
                          `Product: *${productName}*\n` +
                          `Price: ${productPrice}\n\n` +
                          `Hi! I'm interested in this product. Please provide more details and availability.\n\n` +
                          `Thank you! 😊`;
            
            const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
            window.open(whatsappUrl, '_blank');
            showNotification('Opening WhatsApp...', 'success');
        }
        
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg text-white font-medium shadow-lg transform translate-x-full transition-transform duration-300 ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 
                'bg-blue-500'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Show notification
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Hide notification after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
        
        function orderCurrentProductWhatsApp() {
            if (!currentProduct.name) return;
            orderProductWhatsApp(currentProduct.name, currentProduct.price);
            closeProductModal();
        }
        document.getElementById('galleryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGalleryModal();
            }
        });
        
    </script>
</body>
</html>

