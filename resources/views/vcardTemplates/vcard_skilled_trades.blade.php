<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skilled Trades & Services vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <meta name="msapplication-TileColor" content="#f59e0b">
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
    @endif
    
    <style>
        /* Enhanced Skilled Trades Theme Styles */
        .trades-gradient {
            background: 
                linear-gradient(135deg, rgba(245, 158, 11, 0.95) 0%, rgba(251, 191, 36, 0.95) 25%, rgba(59, 130, 246, 0.95) 50%, rgba(30, 64, 175, 0.95) 75%, rgba(15, 23, 42, 0.95) 100%),
                url('https://images.unsplash.com/photo-1504307651254-35680f356dfd?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(245, 158, 11, 0.2);
            box-shadow: 
                0 25px 45px -10px rgba(245, 158, 11, 0.15),
                0 10px 20px -5px rgba(59, 130, 246, 0.1);
        }
        
        .service-badge {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            color: #fff;
            border-radius: 1.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .service-badge:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        }
        
        .contact-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(245, 158, 11, 0.2);
            transition: all 0.3s ease;
        }
        
        .contact-card:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(245, 158, 11, 0.15);
        }
        
        .social-btn {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(245, 158, 11, 0.3);
            transition: all 0.3s ease;
        }
        
        .social-btn:hover {
            background: rgba(245, 158, 11, 0.1);
            transform: translateY(-2px) scale(1.1);
            box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
        }
        
        .profile-glow {
            animation: profile-glow 3s ease-in-out infinite;
        }
        
        @keyframes profile-glow {
            0%, 100% { 
                box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4);
            }
            50% { 
                box-shadow: 0 0 0 15px rgba(245, 158, 11, 0);
            }
        }
        
        .tools-animation {
            animation: tools-rotate 4s ease-in-out infinite;
        }
        
        @keyframes tools-rotate {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-5deg); }
            75% { transform: rotate(5deg); }
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
        
        .expertise-card {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
            border: 1px solid rgba(245, 158, 11, 0.2);
            transition: all 0.3s ease;
        }
        
        .expertise-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(245, 158, 11, 0.2);
        }
        
        .action-btn {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
            transition: all 0.3s ease;
        }
        
        .action-btn:hover {
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(245, 158, 11, 0.4);
        }
        
        .gallery-item {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(245, 158, 11, 0.2);
            transition: all 0.3s ease;
        }
        
        .gallery-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(245, 158, 11, 0.2);
        }
        
        .section-divider {
            background: linear-gradient(90deg, transparent 0%, rgba(245, 158, 11, 0.3) 50%, transparent 100%);
            height: 1px;
            margin: 1.5rem 0;
        }
        
        .status-badge {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            animation: status-pulse 2s ease-in-out infinite;
        }
        
        @keyframes status-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
    </style>
</head>
<body class="trades-gradient min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="glass-card rounded-3xl overflow-hidden shadow-2xl">
            
            <!-- Header with Background Image -->
            <div class="relative h-40 overflow-hidden
                @if($profile->background_image_url)
                    bg-cover bg-center
                @else
                    bg-gradient-to-r from-amber-500 via-orange-500 to-blue-600
                @endif"
                @if($profile->background_image_url)
                    style="background-image: url('{{ $profile->background_image_url }}');"
                @endif>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-amber-500/40 via-orange-500/30 to-blue-600/40"></div>
                
                <!-- Floating Tools Icons -->
                <div class="absolute top-4 left-4">
                    <i class="fas fa-tools text-white/70 text-2xl tools-animation"></i>
                </div>
                <div class="absolute top-4 right-4">
                    <i class="fas fa-hard-hat text-white/70 text-2xl floating-icon"></i>
                </div>
                <div class="absolute bottom-4 left-4">
                    <i class="fas fa-wrench text-white/50 text-lg floating-icon" style="animation-delay: -2s;"></i>
                </div>
                <div class="absolute bottom-4 right-4">
                    <i class="fas fa-hammer text-white/50 text-lg tools-animation" style="animation-delay: -1s;"></i>
                </div>
            </div>
            
            <!-- Profile Section -->
            <div class="relative px-6 pt-2 pb-6 text-center">
                <!-- Profile Image -->
                <div class="relative inline-block -mt-16 mb-4">
                    <div class="w-32 h-32 rounded-full bg-white p-2 profile-glow">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&background=f59e0b&color=fff&size=128' }}" 
                             class="w-full h-full rounded-full object-cover border-4 border-amber-100" 
                             alt="Profile Photo">
                    </div>
                    <!-- Status Badge -->
                    <div class="absolute -bottom-2 -right-2 status-badge text-white rounded-full w-8 h-8 flex items-center justify-center text-sm">
                        <i class="fas fa-check"></i>
                    </div>
                </div>
                
                <!-- Name & Title -->
                <h1 class="text-2xl font-bold text-gray-800 mb-1">
                    {{ $profile->display_name ?? $user->name ?? 'Skilled Professional' }}
                </h1>
                <p class="text-amber-600 font-semibold text-lg mb-4">
                    {{ $profile->profession ?? 'Skilled Trades & Services' }}
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
                    <i class="fas fa-map-marker-alt text-amber-500 mr-2"></i>
                    {{ $profile->location }}
                </div>
                @endif
                
                <!-- Professional Badge -->
                <div class="flex justify-center mb-4">
                    <div class="bg-gradient-to-r from-amber-500 to-orange-500 text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                        <i class="fas fa-award mr-2"></i>
                        Certified Professional
                    </div>
                </div>
            </div>
            
            <!-- About Section -->
            @if($profile->bio)
            <div class="px-6 py-4">
                <div class="expertise-card rounded-xl p-4 mb-6 fade-in">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-user-cog text-amber-500 text-lg mr-2"></i>
                        <h3 class="font-semibold text-gray-800">About Me</h3>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed">{{ $profile->bio }}</p>
                </div>
            </div>
            @endif
            
            <!-- Services Section -->
            <div class="px-6 py-4">
                <div class="expertise-card rounded-xl p-4 mb-6 fade-in">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-tools text-amber-500 text-lg mr-2"></i>
                        <h3 class="font-semibold text-gray-800">Services Offered</h3>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @if($profile->services ?? null)
                            @foreach(explode(',', $profile->services) as $service)
                                <span class="service-badge">
                                    <i class="fas fa-check-circle"></i> 
                                    {{ trim($service) }}
                                </span>
                            @endforeach
                        @else
                            <span class="service-badge">
                                <i class="fas fa-wrench"></i> 
                                General Repairs
                            </span>
                            <span class="service-badge">
                                <i class="fas fa-bolt"></i> 
                                Electrical Work
                            </span>
                            <span class="service-badge">
                                <i class="fas fa-water"></i> 
                                Plumbing Services
                            </span>
                            <span class="service-badge">
                                <i class="fas fa-paint-roller"></i> 
                                Painting & Finishing
                            </span>
                            <span class="service-badge">
                                <i class="fas fa-hammer"></i> 
                                Carpentry
                            </span>
                            <span class="service-badge">
                                <i class="fas fa-home"></i> 
                                Home Maintenance
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-address-book text-amber-500 mr-2"></i>
                    Contact Information
                </h3>
                <div class="space-y-3">
                    @if($profile->phone)
                    <div class="contact-card rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Phone</div>
                            <div class="text-sm text-gray-600">{{ $profile->phone }}</div>
                        </div>
                        <a href="tel:{{ $profile->phone }}" class="bg-green-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-green-600 transition-colors">
                            Call
                        </a>
                    </div>
                    @endif
                    
                    @if($profile->email ?? $user->email)
                    <div class="contact-card rounded-lg p-3 flex items-center fade-in">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white mr-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-gray-800">Email</div>
                            <div class="text-sm text-gray-600">{{ $profile->email ?? $user->email }}</div>
                        </div>
                        <a href="mailto:{{ $profile->email ?? $user->email }}" class="bg-blue-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-600 transition-colors">
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
                            <div class="text-sm text-gray-600">{{ str_replace(['http://', 'https://'], '', $profile->website) }}</div>
                        </div>
                        <a href="{{ $profile->website }}" target="_blank" class="bg-purple-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-purple-600 transition-colors">
                            Visit
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Gallery Section -->
            @if($galleryItems->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-images text-amber-500 mr-2"></i>
                    Work Gallery
                </h3>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($galleryItems as $item)
                    <div class="gallery-item rounded-xl overflow-hidden shadow cursor-pointer group relative" onclick="openGalleryModal('{{ $item->full_image_url }}', '{{ $item->title }}', '{{ $item->description }}')">
                        <img src="{{ $item->full_image_url }}" alt="{{ $item->title }}" class="w-full h-24 object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        @if($item->title)
                        <div class="absolute bottom-0 left-0 right-0 text-white text-xs px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            {{ $item->title }}
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Social Links -->
            @if($socialLinks->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-share-alt text-amber-500 mr-2"></i>
                    Connect With Me
                </h3>
                <div class="flex gap-3 justify-center flex-wrap">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" class="social-btn w-12 h-12 flex items-center justify-center rounded-full text-amber-600 text-lg shadow-lg" title="{{ ucfirst($link->platform) }}">
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
            </div>
            @endif
            
            <!-- Action Button -->
            <div class="px-6 py-6">
                <button class="action-btn w-full py-4 rounded-xl text-white font-semibold shadow-lg text-base flex items-center justify-center gap-2" onclick="saveContact()">
                    <i class="fas fa-address-card"></i> 
                    Save Contact
                </button>
            </div>
        </div>
    </div>
    
    <!-- Gallery Modal -->
    <div id="galleryModal" class="hidden fixed top-0 left-0 w-full h-full bg-black/90 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full max-h-full overflow-auto relative shadow-2xl">
            <div class="flex justify-between items-center p-4 border-b border-gray-200">
                <h3 id="galleryModalTitle" class="text-lg font-bold text-gray-800"></h3>
                <button onclick="closeGalleryModal()" class="text-2xl text-gray-500 hover:text-gray-700 transition-colors">&times;</button>
            </div>
            <img id="galleryModalImage" src="" alt="" class="w-full object-contain" style="max-height:60vh;">
            <div class="p-4 text-gray-700 text-sm" id="galleryModalDescription"></div>
        </div>
    </div>
    
    <script>
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
        
        function saveContact() {
            const name = "{{ $profile->display_name ?? $user->name ?? 'Skilled Professional' }}";
            const title = "{{ $profile->profession ?? 'Skilled Trades & Services' }}";
            const email = "{{ $profile->email ?? $user->email ?? '' }}";
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
        
        // Add smooth scrolling and enhanced interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Trigger fade-in animations immediately for visible elements
            setTimeout(() => {
                document.querySelectorAll('.fade-in').forEach(el => {
                    const rect = el.getBoundingClientRect();
                    if (rect.top < window.innerHeight && rect.bottom > 0) {
                        el.classList.add('visible');
                    }
                });
            }, 100);
        });
    </script>
</body>
</html>