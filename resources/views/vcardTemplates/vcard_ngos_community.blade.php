<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NGOs & Community Groups vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
        <meta name="msapplication-TileColor" content="#059669">
        @if($profile->pwa_icon)
            <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
        @endif
    
    <style>
        /* Custom NGO & Community Theme Styles - Light & Natural */
        .eco-gradient {
            background: 
                linear-gradient(135deg, rgba(240, 253, 244, 0.95) 0%, rgba(220, 252, 231, 0.95) 25%, rgba(187, 247, 208, 0.95) 50%, rgba(134, 239, 172, 0.95) 75%, rgba(74, 222, 128, 0.95) 100%),
                url('https://images.unsplash.com/photo-1441974231531-c6227db76b6e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .eco-gradient.has-custom-bg {
            background-attachment: fixed;
        }
        
        .nature-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(74, 222, 128, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(134, 239, 172, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(187, 247, 208, 0.1) 0%, transparent 50%);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(74, 222, 128, 0.3);
            box-shadow: 
                0 25px 45px -10px rgba(74, 222, 128, 0.2),
                0 10px 20px -5px rgba(134, 239, 172, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }
        
        .glass-border {
            border-radius: 2rem;
        }
        
        .earth-pulse {
            animation: earth-pulse 4s ease-in-out infinite;
        }
        
        @keyframes earth-pulse {
            0%, 100% { 
                transform: scale(1) rotate(0deg);
                filter: hue-rotate(0deg);
            }
            25% { 
                transform: scale(1.05) rotate(2deg);
                filter: hue-rotate(10deg);
            }
            75% { 
                transform: scale(1.02) rotate(-2deg);
                filter: hue-rotate(-10deg);
            }
        }
        
        .tree-sway {
            animation: tree-sway 6s ease-in-out infinite;
        }
        
        @keyframes tree-sway {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(2deg); }
            75% { transform: rotate(-2deg); }
        }
        
        .leaf-float {
            animation: leaf-float 8s ease-in-out infinite;
        }
        
        @keyframes leaf-float {
            0%, 100% { 
                transform: translateY(0px) rotate(0deg);
                opacity: 0.7;
            }
            25% { 
                transform: translateY(-10px) rotate(5deg);
                opacity: 1;
            }
            75% { 
                transform: translateY(-5px) rotate(-5deg);
                opacity: 0.8;
            }
        }
        
        .eco-glow {
            animation: eco-glow 3s ease-in-out infinite;
        }
        
        @keyframes eco-glow {
            0%, 100% { 
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4);
            }
            50% { 
                transform: scale(1.03);
                box-shadow: 0 0 0 15px rgba(34, 197, 94, 0);
            }
        }
        
        .glass-item {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(74, 222, 128, 0.25);
            transition: all 0.3s ease;
        }
        
        .glass-item:hover {
            background: rgba(255, 255, 255, 0.85);
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(74, 222, 128, 0.2);
        }
        
        .social-glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(74, 222, 128, 0.4);
            transition: all 0.3s ease;
        }
        
        .social-glass:hover {
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 15px 40px rgba(74, 222, 128, 0.25);
        }
        
        .cause-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(74, 222, 128, 0.3);
            transition: all 0.3s ease;
        }
        
        .cause-card:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(74, 222, 128, 0.2);
        }
        
        .impact-badge {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            animation: impact-shine 4s ease-in-out infinite;
        }
        
        @keyframes impact-shine {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.9; }
        }
        
        .mission-quote {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(74, 222, 128, 0.3);
            border-left: 4px solid #10b981;
        }
        
        .donate-btn {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.3);
        }
        
        .donate-btn:hover {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(5, 150, 105, 0.4);
        }
        
        .volunteer-btn {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        }
        
        .volunteer-btn:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.4);
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
        
        .impact-stats {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(74, 222, 128, 0.3);
        }
        
        .achievement-badge {
            background: linear-gradient(135deg, #84cc16 0%, #65a30d 100%);
            color: white;
            animation: achievement-glow 3s ease-in-out infinite;
        }
        
        @keyframes achievement-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(132, 204, 22, 0.4); }
            50% { box-shadow: 0 0 0 10px rgba(132, 204, 22, 0); }
        }
        
        .floating-elements {
            position: absolute;
            opacity: 0.3;
            animation: float-gentle 8s ease-in-out infinite;
        }
        
        @keyframes float-gentle {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-15px) rotate(2deg); }
            66% { transform: translateY(-8px) rotate(-2deg); }
        }
        
        .globe-spin {
            animation: globe-spin 20s linear infinite;
        }
        
        @keyframes globe-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .heart-beat {
            animation: heart-beat 2s ease-in-out infinite;
        }
        
        @keyframes heart-beat {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.1); }
            50% { transform: scale(1); }
            75% { transform: scale(1.05); }
        }
        
        /* Enhanced Text Visibility */
        .text-white {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }
        
        .text-green-100 {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }
        
        .text-white\/90 {
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
        }
        
        .text-white\/80 {
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
        }
        
        .text-green-200 {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }
        
        .text-white\/70 {
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
        }
        
        .text-white\/50 {
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
        }
        
        h1, h2, h3 {
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.1);
        }
        
        .font-bold {
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.2);
        }
        
        .font-semibold {
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.3);
        }
        
        .font-medium {
            text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="eco-gradient nature-pattern min-h-screen flex items-center justify-center p-4 @if($profile && $profile->hasBackgroundImage()) has-custom-bg @endif"
      @if($profile && $profile->hasBackgroundImage())
      style="background-image: 
          linear-gradient(135deg, rgba(240, 253, 244, 0.95) 0%, rgba(220, 252, 231, 0.95) 25%, rgba(187, 247, 208, 0.95) 50%, rgba(134, 239, 172, 0.95) 75%, rgba(74, 222, 128, 0.95) 100%),
          url('{{ $profile->full_background_image_url }}');"
      @endif>
    <div class="w-full max-w-md mx-auto">
        <div class="glass-card glass-border overflow-hidden">
            
            <!-- Floating Background Elements -->
            <div class="floating-elements top-4 left-4 text-green-600/30 text-3xl tree-sway">
                <i class="fas fa-tree"></i>
            </div>
            <div class="floating-elements top-6 right-6 text-emerald-600/30 text-2xl leaf-float" style="animation-delay: -2s;">
                <i class="fas fa-leaf"></i>
            </div>
            <div class="floating-elements top-12 left-1/2 text-lime-600/30 text-xl leaf-float" style="animation-delay: -4s;">
                <i class="fas fa-seedling"></i>
            </div>
            
            <!-- Header Section -->
            <div class="relative px-6 pt-8 pb-6 text-center">
                <!-- Profile Image with Earth Badge -->
                <div class="relative inline-block mb-4">
                    <div class="w-32 h-32 rounded-full p-1 eco-glow relative overflow-hidden
                        @if($profile && $profile->hasBackgroundImage())
                            bg-cover bg-center bg-no-repeat
                        @else
                            bg-gradient-to-br from-green-400 to-emerald-600
                        @endif"
                        @if($profile && $profile->hasBackgroundImage())
                            style="background-image: url('{{ $profile->full_background_image_url }}');"
                        @endif>
                        <!-- Overlay for better contrast if background image exists -->
                        @if($profile && $profile->hasBackgroundImage())
                            <div class="absolute inset-0 bg-green-600/30 rounded-full"></div>
                        @endif
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'NGO') . '&background=059669&color=fff&size=128' }}" 
                             class="w-full h-full rounded-full object-cover border-4 border-white/30 relative z-10" 
                             alt="Profile Photo">
                    </div>
                    <!-- Earth/Globe Badge -->
                    <div class="absolute -bottom-2 -right-2 impact-badge text-white rounded-full w-12 h-12 flex items-center justify-center text-lg earth-pulse">
                        <i class="fas fa-globe-americas globe-spin"></i>
                    </div>
                </div>
                
                <!-- Organization Name & Mission -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1 drop-shadow-sm">
                    {{ $profile->display_name ?? $user->name ?? 'Green Earth NGO' }}
                </h1>
                <p class="text-green-700 font-semibold text-lg mb-2">
                    {{ $profile->profession ?? 'Environmental Conservation' }}
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
                <div class="flex items-center justify-center text-gray-700 text-sm mb-4">
                    <i class="fas fa-map-marker-alt text-green-600 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
                
                <!-- Mission Badge -->
                <div class="flex justify-center gap-2 mb-4">
                    <div class="achievement-badge px-3 py-1 rounded-full text-xs font-medium">
                        <i class="fas fa-heart heart-beat mr-1"></i>
                        Save Our Planet
                    </div>
                </div>
            </div>
            
            <!-- Mission Statement -->
            <div class="px-6 py-4">
                <div class="mission-quote rounded-xl p-4 mb-6">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-quote-left text-green-600 text-lg mr-2"></i>
                        <h3 class="font-semibold text-gray-800">Our Mission</h3>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">
                        {{ $profile->bio ?? 'Dedicated to protecting our planet and building sustainable communities for future generations. Together, we can make a difference through environmental conservation, community empowerment, and global awareness.' }}
                    </p>
                </div>
            </div>
            
            <!-- Impact Statistics -->
            <div class="px-6 py-4">
                <div class="impact-stats rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-chart-line text-green-600 mr-2"></i>
                        Our Impact
                    </h3>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold text-green-600">5K+</div>
                            <div class="text-xs text-gray-600">Trees Planted</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-emerald-600">50+</div>
                            <div class="text-xs text-gray-600">Communities</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-lime-600">100K+</div>
                            <div class="text-xs text-gray-600">Lives Touched</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            @if($profile->phone || $profile->email || $profile->website)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-address-book text-green-600 mr-2"></i>
                    Get In Touch
                </h3>
                <div class="space-y-3">
                    @if($profile->phone)
                    <div class="glass-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-green-600/80 rounded-full flex items-center justify-center text-white mr-3 border border-white/30">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Phone</div>
                            <div class="text-sm text-gray-600">{{ $profile->phone }}</div>
                        </div>
                        <a href="tel:{{ $profile->phone }}" class="bg-green-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-700 transition-colors">
                            Call
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->email ?? $user->email)
                    <div class="glass-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-emerald-600/80 rounded-full flex items-center justify-center text-white mr-3 border border-white/30">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Email</div>
                            <div class="text-sm text-gray-600">{{ $profile->email ?? $user->email }}</div>
                        </div>
                        <a href="mailto:{{ $profile->email ?? $user->email }}" class="bg-emerald-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-emerald-700 transition-colors">
                            Email
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->website)
                    <div class="glass-item rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-lime-600/80 rounded-full flex items-center justify-center text-white mr-3 border border-white/30">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Website</div>
                            <div class="text-sm text-gray-600">Visit our cause</div>
                        </div>
                        <a href="{{ $profile->website }}" target="_blank" class="bg-lime-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-lime-700 transition-colors">
                            Visit
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Causes & Programs Section -->
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-hands-helping text-green-600 mr-2"></i>
                    Our Causes
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    <div class="cause-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-tree text-green-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Reforestation</div>
                    </div>
                    <div class="cause-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-recycle text-emerald-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Recycling</div>
                    </div>
                    <div class="cause-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-water text-cyan-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Clean Water</div>
                    </div>
                    <div class="cause-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-solar-panel text-yellow-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Clean Energy</div>
                    </div>
                    <div class="cause-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-graduation-cap text-purple-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Education</div>
                    </div>
                    <div class="cause-card rounded-lg p-3 text-center fade-in">
                        <i class="fas fa-heart text-pink-600 text-2xl mb-2"></i>
                        <div class="text-sm font-medium text-gray-800">Community</div>
                    </div>
                </div>
            </div>
            
            <!-- Volunteer Opportunities -->
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-calendar-alt text-green-600 mr-2"></i>
                    Get Involved
                </h3>
                <div class="glass-item rounded-lg p-4 space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tree Planting Drive</span>
                        <span class="font-medium text-green-600">This Saturday</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Beach Cleanup</span>
                        <span class="font-medium text-emerald-600">Next Sunday</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Community Workshop</span>
                        <span class="font-medium text-lime-600">Monthly</span>
                    </div>
                    <div class="mt-3 pt-2 border-t border-gray-300">
                        <div class="flex items-center text-green-600">
                            <i class="fas fa-hands-helping mr-2"></i>
                            <span class="text-xs">Join our volunteer community today!</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Social Links -->
            @if($socialLinks->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-share-alt text-green-600 mr-2"></i>
                    Spread Awareness
                </h3>
                <div class="flex gap-3 justify-center">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="social-glass w-12 h-12 flex items-center justify-center rounded-full text-green-600 text-lg" title="{{ ucfirst($link->platform) }}">
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
            
            <!-- Community Products & Services -->
            @if($storeProducts->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-leaf text-green-600 mr-2"></i>
                    Our Products & Services
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($storeProducts as $product)
                        <div class="glass-item rounded-lg overflow-hidden fade-in">
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
                                        <span class="text-green-600 font-semibold text-sm">{{ $product->formatted_price }}</span>
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
                        <a href="{{ route('store.show', $user->uuid) }}" class="text-green-600 text-sm hover:text-green-700">
                            <i class="fas fa-store mr-1"></i>
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
                    <i class="fas fa-images text-green-600 mr-2"></i>
                    Our Work in Action
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($galleryItems->take(4) as $item)
                        <div class="relative group overflow-hidden rounded-lg fade-in cursor-pointer glass-item" onclick="openGalleryModal('{{ $item->full_image_url }}', '{{ $item->title }}', '{{ $item->description }}')">
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
            
            <!-- WhatsApp Store Section -->
            @if($profile->store_enabled && $user->currentPlan && $user->currentPlan->hasWhatsAppStore())
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fab fa-whatsapp text-green-600 mr-2"></i>
                    Community Store
                </h3>
                <div class="glass-item rounded-xl p-4 text-center">
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
                @if($profile->email ?? $user->email)
                <a href="mailto:{{ $profile->email ?? $user->email }}?subject=Donation Inquiry" class="donate-btn w-full text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center">
                    <i class="fas fa-heart mr-2 heart-beat"></i>
                    Donate Now
                </a>
                @endif
                
                @if($profile->phone)
                <a href="tel:{{ $profile->phone }}" class="volunteer-btn w-full text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center">
                    <i class="fas fa-hands-helping mr-2"></i>
                    Volunteer With Us
                </a>
                @endif
                
                <!-- PWA Install Button -->

                <!-- Save Contact Button -->
                <button onclick="downloadVCard()" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white py-3 px-4 rounded-xl font-semibold text-center flex items-center justify-center hover:from-green-700 hover:to-emerald-700 transition-all">
                    <i class="fas fa-download mr-2"></i>
                    Save Contact
                </button>
            </div>
            
            <!-- Footer -->
            <div class="px-6 py-4 bg-green-50 text-center border-t border-green-200">
                <div class="flex items-center justify-center text-green-700 text-sm mb-2">
                    <i class="fas fa-globe-americas mr-2 globe-spin"></i>
                    <span>Together for a Greener Tomorrow</span>
                    <i class="fas fa-leaf ml-2 leaf-float"></i>
                </div>
                <div class="text-xs text-gray-600">
                    Certified Environmental Organization
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    Powered by Smart Tag Green Initiative
                </div>
            </div>
        </div>
    </div>
    
    <!-- Gallery Modal -->
    <div id="galleryModal" class="hidden fixed top-0 left-0 w-full h-full bg-black/90 z-50 flex items-center justify-center p-4">
        <div class="glass-card rounded-2xl max-w-lg w-full max-h-full overflow-auto relative">
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
            const vCardData = `BEGIN:VCARD
VERSION:3.0
FN:{{ $profile->display_name ?? $user->name ?? 'Green Earth NGO' }}
ORG:{{ $profile->profession ?? 'Environmental Conservation' }}
TITLE:{{ $profile->profession ?? 'Environmental Conservation' }}
TEL:{{ $profile->phone ?? '' }}
EMAIL:{{ $profile->email ?? $user->email ?? '' }}
URL:{{ $profile->website ?? '' }}
NOTE:{{ $profile->bio ?? 'Dedicated to protecting our planet and building sustainable communities for future generations.' }}
END:VCARD`;
            
            const blob = new Blob([vCardData], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($profile->display_name ?? $user->name ?? 'green-earth-ngo') }}.vcf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        
        // Gallery Modal Functions
        function openGalleryModal(imageUrl, title, description) {
            document.getElementById('galleryModalImage').src = imageUrl;
            document.getElementById('galleryModalTitle').textContent = title || 'Our Work';
            document.getElementById('galleryModalDescription').textContent = description || '';
            document.getElementById('galleryModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeGalleryModal() {
            document.getElementById('galleryModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Close modal when clicking outside
        document.getElementById('galleryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeGalleryModal();
            }
        });
        
        // Environmental animations and interactions
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
            
            // Observe all fade-in elements
            document.querySelectorAll('.fade-in').forEach(el => {
                observer.observe(el);
            });
            
            // Add staggered animation delays for cause cards
            document.querySelectorAll('.cause-card').forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Environmental impact counter animation
            const counters = document.querySelectorAll('.impact-stats .text-2xl');
            counters.forEach(counter => {
                const target = parseInt(counter.textContent.replace(/[^\d]/g, ''));
                let current = 0;
                const increment = target / 80;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        const suffix = counter.textContent.includes('K') ? 'K+' : counter.textContent.includes('+') ? '+' : '';
                        counter.textContent = target + suffix;
                        clearInterval(timer);
                    } else {
                        const suffix = counter.textContent.includes('K') ? 'K+' : counter.textContent.includes('+') ? '+' : '';
                        counter.textContent = Math.floor(current) + suffix;
                    }
                }, 50);
            });
            
            // Environmental tip system
            const ecoTips = [
                "🌱 Every small action creates a ripple of change!",
                "🌍 Together we can heal our planet!",
                "♻️ Reduce, Reuse, Recycle - Make it a lifestyle!",
                "🌳 Plant a tree today, breathe easier tomorrow!",
                "💚 Your support makes a world of difference!"
            ];
            
            // Show random eco tip
            const tipElement = document.createElement('div');
            tipElement.className = 'fixed bottom-4 right-4 glass-card text-white p-3 rounded-lg shadow-lg text-sm max-w-xs opacity-0 transition-opacity duration-300';
            tipElement.innerHTML = ecoTips[Math.floor(Math.random() * ecoTips.length)];
            document.body.appendChild(tipElement);
            
            // Show tip after 8 seconds
            setTimeout(() => {
                tipElement.style.opacity = '1';
                setTimeout(() => {
                    tipElement.style.opacity = '0';
                    setTimeout(() => {
                        document.body.removeChild(tipElement);
                    }, 300);
                }, 6000);
            }, 8000);
        });

    </script>
</body>
</html>
