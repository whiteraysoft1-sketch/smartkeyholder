<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \App\Models\Setting::get('site_name', 'Smart KeyHolder') }} - {{ \App\Models\Setting::get('site_description', 'Your Digital Identity Platform') }}</title>
    <meta name="keywords" content="Uganda news, Jobs in Uganda, URA, Uganda Revenue Authority, NSSF Uganda, Scholarships in Uganda, MTN Uganda, Airtel Uganda, Uganda cranes, UNRA, Uganda National Roads Authority, Uganda passport application, Uganda weather, Mobile money Uganda, Jiji Uganda, Marketplace Uganda, Buy and Sell Uganda, Classifieds Uganda, Online Shopping Uganda">
    @if(\App\Models\Setting::get('favicon'))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . \App\Models\Setting::get('favicon')) }}">
    @endif
    @vite(['resources/css/app.css', 'resources/css/liquid-glass.css', 'resources/js/app.js'])
    <style>
        /* Apple Liquid Glass UI Styles */
        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        }
        
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }
        
        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(180deg); }
        }
        
        .slide-in {
            animation: slideInUp 1s ease-out;
        }
        
        .slide-in-delay {
            animation: slideInUp 1s ease-out 0.3s both;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .pulse-glow {
            animation: pulseGlow 2s ease-in-out infinite alternate;
        }
        
        @keyframes pulseGlow {
            from {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
            }
            to {
                box-shadow: 0 0 30px rgba(59, 130, 246, 0.8);
            }
        }
    </style>
</head>
<body class="bg-white text-gray-900 font-sans overflow-x-hidden">
    <!-- Navigation -->
    <nav class="glass-nav fixed w-full top-0 z-50 py-4">
        <div class="max-w-6xl mx-auto px-4 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                @if(\App\Models\Setting::get('main_logo'))
                    <img src="{{ asset('storage/' . \App\Models\Setting::get('main_logo')) }}" alt="{{ \App\Models\Setting::get('site_name', 'Whiteray Smart Tag') }}" class="h-8 w-auto">
                @endif
                <span class="text-xl font-bold text-gray-800">{{ \App\Models\Setting::get('site_name', 'Smart KeyHolder') }}</span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium transition">Sign In</a>
                <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-full font-semibold hover:shadow-lg transition transform hover:scale-105">
                    Get Started
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-hero relative min-h-screen flex items-center pt-20">
        <!-- Floating Background Elements -->
        <div class="floating-elements">
            <div class="floating-element w-32 h-32 top-20 left-10" style="animation-delay: 0s;"></div>
            <div class="floating-element w-48 h-48 top-40 right-20" style="animation-delay: 2s;"></div>
            <div class="floating-element w-24 h-24 bottom-40 left-20" style="animation-delay: 4s;"></div>
            <div class="floating-element w-36 h-36 bottom-20 right-10" style="animation-delay: 1s;"></div>
            <div class="floating-element w-20 h-20 top-60 left-1/2" style="animation-delay: 3s;"></div>
        </div>

        <div class="max-w-6xl mx-auto px-4 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="flex-1 text-center lg:text-left slide-in">
                    <h1 class="text-5xl lg:text-7xl font-bold mb-6 text-white leading-tight">
                        Your Digital
                        <span class="bg-gradient-to-r from-yellow-300 to-pink-300 bg-clip-text text-transparent">
                            Identity
                        </span>
                        <br>
                        Awaits
                    </h1>
                    <p class="text-xl lg:text-2xl mb-8 text-white/90 leading-relaxed">
                        {{ \App\Models\Setting::get('site_description', 'Smart digital identity powered by permanent QR codes. Claim your profile, share your vCard, and manage your digital presence—anywhere, anytime.') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="bg-white text-gray-800 px-8 py-4 rounded-2xl font-bold text-lg hover:shadow-xl transition transform hover:scale-105 pulse-glow">
                            🚀 Start Free Trial
                        </a>
                        <a href="{{ route('qr-purchase') }}" class="glass-card text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/30 transition">
                            💎 Buy QR Codes
                        </a>
                    </div>
                    <div class="mt-8 flex items-center justify-center lg:justify-start space-x-6 text-white/80">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>30-day free trial</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>No credit card required</span>
                        </div>
                    </div>
                </div>
                <div class="flex-1 flex justify-center slide-in-delay">
                    <div class="glass-card rounded-3xl p-8 hover-lift">
                        @if(\App\Models\Setting::get('landing_hero'))
                            <img src="{{ asset('storage/' . \App\Models\Setting::get('landing_hero')) }}" alt="Hero Image" class="w-80 h-80 object-contain rounded-2xl">
                        @else
                            <div class="w-80 h-80 bg-gradient-to-br from-blue-400 to-purple-500 rounded-2xl flex items-center justify-center">
                                <div class="text-center text-white">
                                    <svg class="w-24 h-24 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                    <h3 class="text-2xl font-bold">Smart KeyHolder</h3>
                                    <p class="text-white/80">Your Digital Identity</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20 bg-white relative">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16 slide-in">
                <h2 class="text-4xl lg:text-5xl font-bold mb-6 text-gray-800">How It Works</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Simple, powerful, and designed for the modern digital world</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
                @php
                    $steps = [
                        ['icon' => '⚙️', 'title' => 'Admin Panel', 'desc' => 'Admin generates and manages permanent QR codes for physical items.', 'color' => 'blue'],
                        ['icon' => '📱', 'title' => 'User Scans QR', 'desc' => 'User scans the QR code on the item to access the claim page.', 'color' => 'green'],
                        ['icon' => '🎯', 'title' => 'Claim Profile', 'desc' => 'User claims and activates their digital profile with a 1-month free trial.', 'color' => 'yellow'],
                        ['icon' => '🎨', 'title' => 'Customize Profile', 'desc' => 'User adds photo, bio, social links, and gallery images to their profile.', 'color' => 'purple'],
                        ['icon' => '🚀', 'title' => 'Share & Use', 'desc' => 'User shares their vCard profile; admin and user manage content anytime.', 'color' => 'pink']
                    ];
                @endphp
                @foreach($steps as $index => $step)
                    <div class="text-center slide-in hover-lift" style="animation-delay: {{ $index * 0.1 }}s;">
                        <div class="w-20 h-20 bg-gradient-to-r from-{{ $step['color'] }}-400 to-{{ $step['color'] }}-600 rounded-full flex items-center justify-center text-3xl mb-4 mx-auto shadow-lg">
                            {{ $step['icon'] }}
                        </div>
                        <h3 class="font-bold text-lg mb-2 text-gray-800">{{ $step['title'] }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-blue-50 relative">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16 slide-in">
                <h2 class="text-4xl lg:text-5xl font-bold mb-6 text-gray-800">Powerful Features</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Everything you need to create and manage your digital identity</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $features = [
                        ['icon' => '🔗', 'title' => 'Permanent QR Codes', 'desc' => 'Unique, non-editable QR codes printed on physical items. Claim and activate your digital profile instantly.', 'gradient' => 'from-blue-500 to-cyan-500'],
                        ['icon' => '👤', 'title' => 'Digital vCard Profiles', 'desc' => 'Share a public vCard-style page with your photo, bio, social links, and service gallery. Mobile-optimized for sharing.', 'gradient' => 'from-green-500 to-teal-500'],
                        ['icon' => '⚡', 'title' => 'Admin & SaaS Features', 'desc' => 'Admin panel for managing QR codes, users, and subscriptions. SaaS billing with 1-month free trial and secure payments.', 'gradient' => 'from-purple-500 to-pink-500']
                    ];
                @endphp
                @foreach($features as $index => $feature)
                    <div class="glass-card rounded-3xl p-8 text-center hover-lift slide-in" style="animation-delay: {{ $index * 0.2 }}s;">
                        <div class="w-16 h-16 bg-gradient-to-r {{ $feature['gradient'] }} rounded-2xl flex items-center justify-center text-2xl mb-6 mx-auto shadow-lg">
                            {{ $feature['icon'] }}
                        </div>
                        <h3 class="font-bold text-xl mb-4 text-gray-800">{{ $feature['title'] }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16 slide-in">
                <h2 class="text-4xl lg:text-5xl font-bold mb-6 text-gray-800">Simple Pricing</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Start with our free trial, then choose the plan that works for you</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-{{ min(4, \App\Models\PricingPlan::active()->count()) }} gap-8">
                @foreach(\App\Models\PricingPlan::active() as $index => $plan)
                    <div class="glass-card rounded-3xl p-8 text-center hover-lift slide-in relative" style="animation-delay: {{ $index * 0.1 }}s;">
                        @if($plan->badge_text)
                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-yellow-400 to-orange-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                {{ $plan->badge_text }}
                            </div>
                        @endif
                        <h3 class="font-bold text-2xl mb-4 text-gray-800">{{ $plan->name }}</h3>
                        <div class="text-4xl font-bold text-gray-800 mb-6">
                            {{ $plan->formatted_price }} 
                            <span class="text-lg font-normal text-gray-600">{{ $plan->billing_cycle_text }}</span>
                        </div>
                        @if($plan->description)
                            <p class="text-gray-600 mb-6">{{ $plan->description }}</p>
                        @endif
                        @if($plan->features && count($plan->features) > 0)
                            <ul class="text-gray-600 mb-8 space-y-2">
                                @foreach($plan->features as $feature)
                                    <li class="flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-8 py-3 rounded-2xl font-bold hover:shadow-lg transition transform hover:scale-105 block">
                            {{ $plan->button_text }}
                        </a>
                        @if($plan->has_whatsapp_store)
                            <div class="mt-4">
                                <span class="px-3 py-1 bg-gradient-to-r from-green-400 to-blue-500 text-white text-xs rounded-full font-semibold">WhatsApp Store Included</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 gradient-bg relative">
        <div class="floating-elements">
            <div class="floating-element w-24 h-24 top-10 left-10" style="animation-delay: 0s;"></div>
            <div class="floating-element w-32 h-32 top-20 right-20" style="animation-delay: 2s;"></div>
            <div class="floating-element w-20 h-20 bottom-20 left-20" style="animation-delay: 4s;"></div>
        </div>
        <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
            <div class="slide-in">
                <h2 class="text-4xl lg:text-5xl font-bold mb-6 text-white">Ready to Get Started?</h2>
                <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">Join thousands of users who have already claimed their digital identity with Smart KeyHolder</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="bg-white text-gray-800 px-8 py-4 rounded-2xl font-bold text-lg hover:shadow-xl transition transform hover:scale-105">
                        🎉 Start Your Free Trial
                    </a>
                    <a href="{{ route('qr-purchase') }}" class="glass-card text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/30 transition">
                        💎 Purchase QR Codes
                    </a>
                </div>
            </div>
        </div>
    </section>

    
    <!-- Footer -->
    <footer class="py-12 bg-gray-900 text-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-2 mb-4">
                    @if(\App\Models\Setting::get('main_logo'))
                        <img src="{{ asset('storage/' . \App\Models\Setting::get('main_logo')) }}" alt="{{ \App\Models\Setting::get('site_name', 'Whiteray Smart Tag') }}" class="h-8 w-auto">
                    @endif
                    <span class="text-2xl font-bold">{{ \App\Models\Setting::get('site_name', 'Smart KeyHolder') }}</span>
                </div>
                <p class="text-gray-400 mb-6">Your Digital Identity, Simplified</p>
                @if(\App\Models\Setting::get('contact_email'))
                    <div class="mb-4">
                        <a href="mailto:{{ \App\Models\Setting::get('contact_email') }}" class="text-blue-400 hover:text-blue-300 transition">{{ \App\Models\Setting::get('contact_email') }}</a>
                        @if(\App\Models\Setting::get('contact_phone'))
                            <span class="text-gray-500 mx-2">|</span>
                            <a href="tel:{{ \App\Models\Setting::get('contact_phone') }}" class="text-blue-400 hover:text-blue-300 transition">{{ \App\Models\Setting::get('contact_phone') }}</a>
                        @endif
                    </div>
                @endif
                <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name', 'Whiteray Smart Tag') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- SEO Uganda Keywords (hidden for crawlers) -->
    <div style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;">
        Uganda news, Jobs in Uganda, URA, Uganda Revenue Authority, NSSF Uganda, Scholarships in Uganda, MTN Uganda, Airtel Uganda, Uganda cranes, UNRA, Uganda National Roads Authority, Uganda passport application, Uganda weather, Mobile money Uganda. Find the latest updates, job opportunities, government services, scholarships, telecom offers, sports news, weather, and mobile money solutions in Uganda. Your trusted source for all things Uganda.
    </div>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add scroll effect to navigation
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 100) {
                nav.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                nav.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });
    </script>
</body>
</html>