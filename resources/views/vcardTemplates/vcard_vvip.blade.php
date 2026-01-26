<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VVIP Luxury vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    
    <meta name="msapplication-TileColor" content="#D4AF37">
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
    @endif
    
    <style>
        /* VVIP Luxury Gold & Black Theme */
        :root {
            --gold-primary: #D4AF37;
            --gold-light: #FFD700;
            --gold-dark: #B8941D;
            --black-primary: #0A0A0A;
            --black-light: #1A1A1A;
        }
        
        body {
            background: linear-gradient(135deg, #0A0A0A 0%, #1A1A1A 50%, #0A0A0A 100%);
            min-height: 100vh;
        }
        
        /* Realistic Gold Gradient */
        .gold-gradient {
            background: linear-gradient(135deg, 
                #B8941D 0%, 
                #D4AF37 15%, 
                #FFD700 30%, 
                #F5E6B3 50%, 
                #FFD700 70%, 
                #D4AF37 85%, 
                #B8941D 100%
            );
        }
        
        /* Metallic Gold Effect */
        .metallic-gold {
            background: linear-gradient(145deg, 
                #B8941D 0%, 
                #D4AF37 25%, 
                #FFD700 50%, 
                #D4AF37 75%, 
                #B8941D 100%
            );
            background-size: 200% 200%;
            animation: gold-shimmer 3s ease-in-out infinite;
        }
        
        @keyframes gold-shimmer {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        /* Luxury Card with Gold Border */
        .vvip-card {
            background: #0A0A0A;
            border: 3px solid;
            border-image: linear-gradient(135deg, 
                #B8941D, #D4AF37, #FFD700, #F5E6B3, #FFD700, #D4AF37, #B8941D
            ) 1;
            box-shadow: 
                0 0 40px rgba(212, 175, 55, 0.3),
                0 20px 60px rgba(0, 0, 0, 0.8),
                inset 0 0 30px rgba(212, 175, 55, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .vvip-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, 
                transparent 30%, 
                rgba(212, 175, 55, 0.1) 50%, 
                transparent 70%
            );
            transform: rotate(45deg);
            animation: luxury-shine 6s linear infinite;
        }
        
        @keyframes luxury-shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        
        /* Gold Text Effect */
        .gold-text {
            background: linear-gradient(135deg, #B8941D, #D4AF37, #FFD700, #D4AF37, #B8941D);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gold-text-shimmer 4s ease-in-out infinite;
            font-weight: 700;
            text-shadow: 0 0 20px rgba(212, 175, 55, 0.5);
        }
        
        @keyframes gold-text-shimmer {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        /* VIP Badge */
        .vip-badge {
            background: linear-gradient(135deg, #B8941D, #D4AF37, #FFD700);
            box-shadow: 
                0 4px 15px rgba(212, 175, 55, 0.4),
                inset 0 1px 3px rgba(255, 255, 255, 0.3);
            animation: badge-glow 2s ease-in-out infinite;
        }
        
        @keyframes badge-glow {
            0%, 100% { box-shadow: 0 4px 15px rgba(212, 175, 55, 0.4), inset 0 1px 3px rgba(255, 255, 255, 0.3); }
            50% { box-shadow: 0 4px 25px rgba(212, 175, 55, 0.7), inset 0 1px 3px rgba(255, 255, 255, 0.3); }
        }
        
        /* Profile Image Gold Ring */
        .gold-ring {
            border: 4px solid;
            border-image: linear-gradient(135deg, 
                #B8941D, #D4AF37, #FFD700, #F5E6B3, #FFD700, #D4AF37, #B8941D
            ) 1;
            box-shadow: 
                0 0 30px rgba(212, 175, 55, 0.6),
                inset 0 0 20px rgba(212, 175, 55, 0.2);
            animation: ring-pulse 3s ease-in-out infinite;
        }
        
        @keyframes ring-pulse {
            0%, 100% { 
                box-shadow: 0 0 30px rgba(212, 175, 55, 0.6), inset 0 0 20px rgba(212, 175, 55, 0.2);
            }
            50% { 
                box-shadow: 0 0 50px rgba(212, 175, 55, 0.9), inset 0 0 30px rgba(212, 175, 55, 0.3);
            }
        }
        
        /* Luxury Buttons */
        .luxury-btn {
            background: linear-gradient(135deg, #B8941D, #D4AF37, #FFD700);
            color: #0A0A0A;
            font-weight: 700;
            border: 2px solid rgba(212, 175, 55, 0.3);
            box-shadow: 
                0 4px 15px rgba(212, 175, 55, 0.3),
                inset 0 1px 2px rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }
        
        .luxury-btn:hover {
            background: linear-gradient(135deg, #FFD700, #F5E6B3, #FFD700);
            box-shadow: 
                0 6px 25px rgba(212, 175, 55, 0.5),
                inset 0 1px 2px rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
        }
        
        /* Contact Cards */
        .contact-card-vip {
            background: linear-gradient(135deg, #1A1A1A 0%, #0A0A0A 100%);
            border: 1px solid rgba(212, 175, 55, 0.3);
            box-shadow: 
                0 4px 20px rgba(0, 0, 0, 0.6),
                inset 0 1px 1px rgba(212, 175, 55, 0.1);
            transition: all 0.3s ease;
        }
        
        .contact-card-vip:hover {
            border-color: rgba(212, 175, 55, 0.6);
            box-shadow: 
                0 6px 30px rgba(212, 175, 55, 0.2),
                inset 0 1px 1px rgba(212, 175, 55, 0.2);
            transform: translateY(-3px);
        }
        
        /* Social Icons */
        .social-icon-vip {
            background: linear-gradient(135deg, #1A1A1A, #0A0A0A);
            border: 2px solid rgba(212, 175, 55, 0.4);
            color: #D4AF37;
            transition: all 0.3s ease;
        }
        
        .social-icon-vip:hover {
            background: linear-gradient(135deg, #D4AF37, #FFD700);
            color: #0A0A0A;
            border-color: #FFD700;
            box-shadow: 0 0 25px rgba(212, 175, 55, 0.5);
            transform: translateY(-3px) scale(1.05);
        }
        
        /* Gallery Items */
        .gallery-vip {
            background: #1A1A1A;
            border: 2px solid rgba(212, 175, 55, 0.2);
            transition: all 0.3s ease;
        }
        
        .gallery-vip:hover {
            border-color: rgba(212, 175, 55, 0.6);
            box-shadow: 0 8px 30px rgba(212, 175, 55, 0.3);
            transform: translateY(-5px);
        }
        
        /* Decorative Elements */
        .corner-accent {
            position: absolute;
            width: 60px;
            height: 60px;
        }
        
        .corner-accent-tl {
            top: 0;
            left: 0;
            border-top: 3px solid #D4AF37;
            border-left: 3px solid #D4AF37;
        }
        
        .corner-accent-tr {
            top: 0;
            right: 0;
            border-top: 3px solid #D4AF37;
            border-right: 3px solid #D4AF37;
        }
        
        .corner-accent-bl {
            bottom: 0;
            left: 0;
            border-bottom: 3px solid #D4AF37;
            border-left: 3px solid #D4AF37;
        }
        
        .corner-accent-br {
            bottom: 0;
            right: 0;
            border-bottom: 3px solid #D4AF37;
            border-right: 3px solid #D4AF37;
        }
        
        /* Fade In Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }
        
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Crown Icon */
        .crown-icon {
            color: #D4AF37;
            filter: drop-shadow(0 0 10px rgba(212, 175, 55, 0.6));
            animation: crown-float 4s ease-in-out infinite;
        }
        
        @keyframes crown-float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(5deg); }
        }
    </style>
</head>
<body class="flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="vvip-card rounded-3xl overflow-hidden relative">
            
            <!-- Corner Accents -->
            <div class="corner-accent corner-accent-tl"></div>
            <div class="corner-accent corner-accent-tr"></div>
            <div class="corner-accent corner-accent-bl"></div>
            <div class="corner-accent corner-accent-br"></div>
            
            <!-- Header with Background -->
            <div class="relative h-40 overflow-hidden metallic-gold">
                @if($profile->background_image_url)
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $profile->background_image_url }}');"></div>
                    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-transparent"></div>
                @endif
                <div class="absolute top-4 right-4">
                    <i class="fas fa-crown text-4xl crown-icon"></i>
                </div>
                <div class="absolute top-4 left-4">
                    <div class="vip-badge px-4 py-1 rounded-full text-black text-xs font-bold uppercase tracking-wider">
                        VVIP Member
                    </div>
                </div>
            </div>
            
            <!-- Profile Section -->
            <div class="relative px-8 pt-4 pb-8 text-center">
                <!-- Profile Image -->
                <div class="relative inline-block -mt-20 mb-6">
                    <div class="w-36 h-36 rounded-full bg-black p-1 gold-ring">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'VIP') . '&background=D4AF37&color=0A0A0A&size=144&bold=true' }}" 
                             class="w-full h-full rounded-full object-cover" 
                             alt="Profile Photo">
                    </div>
                    <!-- VIP Status Badge -->
                    <div class="absolute -bottom-2 -right-2 vip-badge text-black rounded-full w-10 h-10 flex items-center justify-center text-lg shadow-lg">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                
                <!-- Name & Title -->
                <h1 class="text-3xl font-bold gold-text mb-2 tracking-wide">
                    {{ $profile->display_name ?? $user->name ?? 'Distinguished Member' }}
                </h1>
                <p class="text-xl text-gray-300 font-semibold mb-2">
                    {{ $profile->profession ?? 'Executive Professional' }}
                </p>
                
                @if($profile->business_name)
                <p class="text-sm gold-text mb-6">
                    <i class="fas fa-building mr-2"></i>{{ $profile->business_name }}
                </p>
                @endif
                
                <!-- Bio -->
                @if($profile->bio)
                <p class="text-gray-400 text-sm leading-relaxed mb-6 max-w-xs mx-auto italic border-l-2 border-gold-primary pl-4">
                    "{{ $profile->bio }}"
                </p>
                @endif
                
                <!-- Action Buttons -->
                <div class="flex items-center justify-center space-x-3 mb-8">
                    @if($profile->phone)
                    <a href="tel:{{ $profile->phone }}" class="luxury-btn px-6 py-3 rounded-xl flex items-center space-x-2">
                        <i class="fas fa-phone-alt"></i>
                        <span class="hidden sm:inline">Call</span>
                    </a>
                    @endif
                    
                    @if($user->email)
                    <a href="mailto:{{ $user->email }}" class="luxury-btn px-6 py-3 rounded-xl flex items-center space-x-2">
                        <i class="fas fa-envelope"></i>
                        <span class="hidden sm:inline">Email</span>
                    </a>
                    @endif
                    
                    <button onclick="downloadVCard()" class="luxury-btn px-6 py-3 rounded-xl flex items-center space-x-2">
                        <i class="fas fa-address-card"></i>
                        <span class="hidden sm:inline">Save Contact</span>
                    </button>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="px-8 pb-6 space-y-3">
                <h2 class="text-lg font-bold gold-text mb-4 uppercase tracking-wider">
                    <i class="fas fa-address-book mr-2"></i>Contact Details
                </h2>
                
                @if($profile->phone)
                <div class="contact-card-vip rounded-xl p-4">
                    <a href="tel:{{ $profile->phone }}" class="flex items-center space-x-4 group">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-gold-primary to-gold-light flex items-center justify-center text-black">
                            <i class="fas fa-mobile-alt text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-xs text-gray-500 uppercase tracking-wide">Personal Phone</div>
                            <div class="text-gray-200 font-semibold group-hover:text-gold-light transition-colors">{{ $profile->phone }}</div>
                        </div>
                        <i class="fas fa-chevron-right text-gold-primary group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                @endif
                
                @if($profile->business_phone)
                <div class="contact-card-vip rounded-xl p-4">
                    <a href="tel:{{ $profile->business_phone }}" class="flex items-center space-x-4 group">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-gold-primary to-gold-light flex items-center justify-center text-black">
                            <i class="fas fa-phone text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-xs text-gray-500 uppercase tracking-wide">Business Phone</div>
                            <div class="text-gray-200 font-semibold group-hover:text-gold-light transition-colors">{{ $profile->business_phone }}</div>
                        </div>
                        <i class="fas fa-chevron-right text-gold-primary group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                @endif
                
                @if($user->email)
                <div class="contact-card-vip rounded-xl p-4">
                    <a href="mailto:{{ $user->email }}" class="flex items-center space-x-4 group">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-gold-primary to-gold-light flex items-center justify-center text-black">
                            <i class="fas fa-envelope text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-xs text-gray-500 uppercase tracking-wide">Email</div>
                            <div class="text-gray-200 font-semibold group-hover:text-gold-light transition-colors break-all">{{ $user->email }}</div>
                        </div>
                        <i class="fas fa-chevron-right text-gold-primary group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                @endif
                
                @if($profile->business_email)
                <div class="contact-card-vip rounded-xl p-4">
                    <a href="mailto:{{ $profile->business_email }}" class="flex items-center space-x-4 group">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-gold-primary to-gold-light flex items-center justify-center text-black">
                            <i class="fas fa-briefcase text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-xs text-gray-500 uppercase tracking-wide">Business Email</div>
                            <div class="text-gray-200 font-semibold group-hover:text-gold-light transition-colors break-all">{{ $profile->business_email }}</div>
                        </div>
                        <i class="fas fa-chevron-right text-gold-primary group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                @endif
                
                @if($profile->website)
                <div class="contact-card-vip rounded-xl p-4">
                    <a href="{{ $profile->website }}" target="_blank" class="flex items-center space-x-4 group">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-gold-primary to-gold-light flex items-center justify-center text-black">
                            <i class="fas fa-globe text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-xs text-gray-500 uppercase tracking-wide">Website</div>
                            <div class="text-gray-200 font-semibold group-hover:text-gold-light transition-colors break-all">{{ $profile->website }}</div>
                        </div>
                        <i class="fas fa-external-link-alt text-gold-primary group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                @endif
                
                @if($profile->location)
                <div class="contact-card-vip rounded-xl p-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-gold-primary to-gold-light flex items-center justify-center text-black">
                            <i class="fas fa-map-marker-alt text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-xs text-gray-500 uppercase tracking-wide">Location</div>
                            <div class="text-gray-200 font-semibold">{{ $profile->location }}</div>
                        </div>
                    </div>
                </div>
                @endif
                
                @if($profile->business_address)
                <div class="contact-card-vip rounded-xl p-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-gold-primary to-gold-light flex items-center justify-center text-black">
                            <i class="fas fa-building text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-xs text-gray-500 uppercase tracking-wide">Business Address</div>
                            <div class="text-gray-200 font-semibold">{{ $profile->business_address }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Business Information (if available) -->
            @if($profile->business_name || $profile->business_phone || $profile->business_email || $profile->business_address)
            <div class="px-8 pb-6">
                <h2 class="text-lg font-bold gold-text mb-4 uppercase tracking-wider">
                    <i class="fas fa-briefcase mr-2"></i>Business Information
                </h2>
                <div class="contact-card-vip rounded-xl p-5 space-y-3">
                    @if($profile->business_name)
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-building text-gold-primary mt-1"></i>
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wide">Company</div>
                            <div class="text-gray-200 font-semibold">{{ $profile->business_name }}</div>
                        </div>
                    </div>
                    @endif
                    
                    @if($profile->business_phone)
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-phone text-gold-primary mt-1"></i>
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wide">Business Phone</div>
                            <a href="tel:{{ $profile->business_phone }}" class="text-gray-200 font-semibold hover:text-gold-light">{{ $profile->business_phone }}</a>
                        </div>
                    </div>
                    @endif
                    
                    @if($profile->business_email)
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-envelope text-gold-primary mt-1"></i>
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wide">Business Email</div>
                            <a href="mailto:{{ $profile->business_email }}" class="text-gray-200 font-semibold hover:text-gold-light break-all">{{ $profile->business_email }}</a>
                        </div>
                    </div>
                    @endif
                    
                    @if($profile->business_address)
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-map-marker-alt text-gold-primary mt-1"></i>
                        <div>
                            <div class="text-xs text-gray-500 uppercase tracking-wide">Address</div>
                            <div class="text-gray-200 font-semibold">{{ $profile->business_address }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Social Links -->
            @if($socialLinks->count() > 0)
            <div class="px-8 pb-6">
                <h2 class="text-lg font-bold gold-text mb-4 uppercase tracking-wider">
                    <i class="fas fa-share-alt mr-2"></i>Connect With Me
                </h2>
                <div class="grid grid-cols-4 gap-3">
                    @foreach($socialLinks as $link)
                    <a href="{{ $link->url }}" target="_blank" class="social-icon-vip w-14 h-14 rounded-xl flex items-center justify-center text-xl">
                        <i class="fab fa-{{ $link->platform }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Gallery -->
            @if($galleryItems->count() > 0)
            <div class="px-8 pb-6">
                <h2 class="text-lg font-bold gold-text mb-4 uppercase tracking-wider">
                    <i class="fas fa-images mr-2"></i>Gallery
                </h2>
                <div class="grid grid-cols-3 gap-3">
                    @foreach($galleryItems as $item)
                    <div class="gallery-vip aspect-square rounded-xl overflow-hidden">
                        <img src="{{ $item->full_image_url }}" alt="Gallery" class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            <!-- Footer -->
            <div class="px-8 pb-8 text-center">
                <div class="border-t border-gold-primary/30 pt-6">
                    <p class="text-gray-500 text-xs uppercase tracking-widest mb-2">Exclusively For Distinguished Members</p>
                    <div class="flex items-center justify-center space-x-2 text-gold-primary">
                        <i class="fas fa-crown"></i>
                        <span class="text-sm font-bold">VVIP EXPERIENCE</span>
                        <i class="fas fa-crown"></i>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <script>
        // Fade in animation on scroll
        const fadeElements = document.querySelectorAll('.fade-in');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });

        fadeElements.forEach(el => observer.observe(el));

        // Download vCard function
        function downloadVCard() {
            const vcard = `BEGIN:VCARD
VERSION:3.0
FN:{{ $profile->display_name ?: $user->name }}
N:{{ implode(';', array_pad(explode(' ', $user->name), 5, '')) }}
@if($profile->business_name)
ORG:{{ $profile->business_name }}
@endif
@if($profile->profession)
TITLE:{{ $profile->profession }}
@endif
@if($profile->phone)
TEL;TYPE=CELL:{{ $profile->phone }}
@endif
@if($profile->business_phone)
TEL;TYPE=WORK:{{ $profile->business_phone }}
@endif
@if($user->email)
EMAIL;TYPE=INTERNET,PREF:{{ $user->email }}
@endif
@if($profile->business_email)
EMAIL;TYPE=INTERNET,WORK:{{ $profile->business_email }}
@endif
@if($profile->website)
URL:{{ $profile->website }}
@endif
@if($profile->business_address)
ADR;TYPE=WORK:;;{{ str_replace(["\r\n", "\n", "\r"], ' ', $profile->business_address) }}
@endif
@if($profile->location)
ADR;TYPE=HOME:;;{{ $profile->location }}
@endif
@if($profile->bio)
NOTE:{{ str_replace(["\r\n", "\n", "\r"], ' ', $profile->bio) }}
@endif
@if($profile->full_profile_image_url)
PHOTO;ENCODING=URI;TYPE=JPEG:{{ $profile->full_profile_image_url }}
@endif
REV:{{ now()->format('Y-m-d\TH:i:s\Z') }}
END:VCARD`;

            const blob = new Blob([vcard], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($user->name ?? "contact") }}.vcf';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        }
    </script>
</body>
</html>
