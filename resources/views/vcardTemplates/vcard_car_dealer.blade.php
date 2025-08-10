<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Dealer vCard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    {{-- PWA Meta Tags --}}
    <meta name="theme-color" content="{{ $profile->pwa_theme_color ?? '#1e293b' }}">
    <meta name="msapplication-TileColor" content="{{ $profile->pwa_theme_color ?? '#1e293b' }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ $profile->pwa_app_name ?? $profile->display_name ?? 'Car Dealer vCard' }}">
    <meta name="mobile-web-app-capable" content="yes">
    
    {{-- PWA Manifest --}}
    @if($profile->pwa_enabled && isset($qrCode))
        <link rel="manifest" href="{{ route('pwa.manifest', $qrCode->uuid) }}">
    @else
        <link rel="manifest" href="/manifest.json">
    @endif
    
    {{-- PWA Icons --}}
    @if($profile->pwa_icon)
        <meta name="msapplication-TileImage" content="{{ $profile->pwa_icon_url }}">
        <link rel="apple-touch-icon" href="{{ $profile->pwa_icon_url }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ $profile->pwa_icon_url }}">
    @else
        <meta name="msapplication-TileImage" content="/images/pwa-icon-144.png">
        <link rel="apple-touch-icon" href="/images/pwa-icon-180.png">
        <link rel="icon" type="image/png" sizes="192x192" href="/images/pwa-icon-192.png">
    @endif
    <style>
        /* Apple-inspired Design System */
        @import url('https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: -apple-system, BlinkMacSystemFont, 'SF Pro Display', 'Segoe UI', Roboto, sans-serif;
        }
        
        .dealer-gradient {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            position: relative;
            min-height: 100vh;
        }
        .dealer-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 20%, rgba(120, 119, 198, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(255, 119, 198, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.1) 0%, transparent 50%);
            animation: apple-gradient-shift 12s ease-in-out infinite;
        }
        @keyframes apple-gradient-shift {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }
        .dealer-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12), 
                        0 2px 8px rgba(0, 0, 0, 0.08),
                        inset 0 1px 0 rgba(255, 255, 255, 0.9);
            overflow: hidden;
            position: relative;
            backdrop-filter: blur(40px) saturate(180%);
            border: 0.5px solid rgba(255, 255, 255, 0.8);
        }
        .dealer-badge {
            background: linear-gradient(135deg, #007AFF 0%, #0051D5 100%);
            color: #fff;
            animation: apple-pulse 4s ease-in-out infinite;
            box-shadow: 0 4px 20px rgba(0, 122, 255, 0.3);
            font-weight: 600;
            letter-spacing: -0.02em;
        }
        @keyframes apple-pulse {
            0%, 100% { 
                transform: scale(1);
                box-shadow: 0 4px 20px rgba(0, 122, 255, 0.3);
            }
            50% { 
                transform: scale(1.02);
                box-shadow: 0 8px 32px rgba(0, 122, 255, 0.4);
            }
        }
        .dealer-glow {
            animation: apple-glow 6s ease-in-out infinite;
        }
        @keyframes apple-glow {
            0%, 100% { 
                box-shadow: 0 0 0 0 rgba(0, 122, 255, 0.2),
                           0 8px 32px rgba(0, 0, 0, 0.12);
            }
            50% { 
                box-shadow: 0 0 0 8px rgba(0, 122, 255, 0),
                           0 12px 40px rgba(0, 0, 0, 0.16);
            }
        }
        .contact-item {
            background: rgba(255, 255, 255, 0.8);
            border: 0.5px solid rgba(0, 0, 0, 0.04);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            backdrop-filter: blur(20px) saturate(180%);
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06),
                        inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }
        .contact-item:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12),
                        inset 0 1px 0 rgba(255, 255, 255, 0.9);
            border-color: rgba(0, 122, 255, 0.2);
        }
        .service-card {
            background: rgba(255, 255, 255, 0.7);
            border: 0.5px solid rgba(0, 0, 0, 0.04);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06),
                        inset 0 1px 0 rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px) saturate(180%);
        }
        .service-card:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15),
                        inset 0 1px 0 rgba(255, 255, 255, 0.9);
            background: rgba(255, 255, 255, 0.85);
            border-color: rgba(0, 122, 255, 0.15);
        }
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .social-icon {
            background: linear-gradient(135deg, #007AFF 0%, #0051D5 100%);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            box-shadow: 0 4px 20px rgba(0, 122, 255, 0.25),
                        inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }
        .social-icon:hover {
            background: linear-gradient(135deg, #0051D5 0%, #003D9F 100%);
            transform: translateY(-3px) scale(1.08);
            box-shadow: 0 8px 32px rgba(0, 122, 255, 0.35),
                        inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        .dealer-banner {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, #007AFF 0%, #5856D6 25%, #AF52DE 50%, #FF2D92 75%, #FF3B30 100%);
            z-index: 1;
            animation: apple-banner-flow 8s ease-in-out infinite;
        }
        @keyframes apple-banner-flow {
            0% { opacity: 0.8; background-position: 0% 50%; }
            50% { opacity: 1; background-position: 100% 50%; }
            100% { opacity: 0.8; background-position: 200% 50%; }
        }
        .profile-img-shadow {
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.15), 
                        0 0 0 3px rgba(255, 255, 255, 0.9),
                        0 0 0 4px rgba(0, 122, 255, 0.2);
        }
        .divider {
            border: none;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, rgba(0, 0, 0, 0.08) 50%, transparent 100%);
            margin: 2rem 0 1.5rem 0;
        }
        .gallery-thumb {
            border: 2px solid rgba(0, 122, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        .gallery-thumb:hover {
            transform: scale(1.05);
            z-index: 2;
            border-color: rgba(0, 122, 255, 0.4);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }
        .profile-overlap {
            position: absolute;
            left: 50%;
            transform: translateX(-50%) translateY(75px);
            top: 0;
            z-index: 10;
        }
        .header-spacer {
            height: 8rem;
        }
        .brand-logos {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(72px, 1fr));
            gap: 1.2rem;
            justify-items: center;
            align-items: center;
            margin-top: 1rem;
            max-width: 100%;
        }
        .brand-logo {
            width: 72px;
            height: 72px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08),
                        inset 0 1px 0 rgba(255, 255, 255, 0.8);
            border: 0.5px solid rgba(0, 0, 0, 0.04);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(20px) saturate(180%);
        }
        .brand-logo:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12),
                        inset 0 1px 0 rgba(255, 255, 255, 0.9);
            border-color: rgba(0, 122, 255, 0.15);
            background: rgba(255, 255, 255, 0.9);
        }
        .brand-logo img {
            max-width: 45px;
            max-height: 45px;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        .brand-logo-img {
            max-width: 50px;
            max-height: 50px;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .brand-logo div {
            text-align: center;
            line-height: 1.2;
        }
        .brand-logo:nth-child(1) { animation-delay: 0.1s; }
        .brand-logo:nth-child(2) { animation-delay: 0.2s; }
        .brand-logo:nth-child(3) { animation-delay: 0.3s; }
        .brand-logo:nth-child(4) { animation-delay: 0.4s; }
        .brand-logo:nth-child(5) { animation-delay: 0.5s; }
        .brand-logo:nth-child(6) { animation-delay: 0.6s; }
        .brand-logo:nth-child(7) { animation-delay: 0.7s; }
        .brand-logo:nth-child(8) { animation-delay: 0.8s; }
        .brand-logo:nth-child(9) { animation-delay: 0.9s; }
        .brand-logo:nth-child(10) { animation-delay: 1.0s; }
        .brand-logo:nth-child(11) { animation-delay: 1.1s; }
        .brand-logo:nth-child(12) { animation-delay: 1.2s; }
        .brand-logo:nth-child(13) { animation-delay: 1.3s; }
        .brand-logo:nth-child(14) { animation-delay: 1.4s; }
        .brand-logo:nth-child(15) { animation-delay: 1.5s; }
        .stats-card {
            background: rgba(255, 255, 255, 0.7);
            border: 0.5px solid rgba(0, 0, 0, 0.04);
            backdrop-filter: blur(20px) saturate(180%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08),
                        inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }
        .action-btn-primary {
            background: linear-gradient(135deg, #007AFF 0%, #0051D5 100%);
            box-shadow: 0 4px 20px rgba(0, 122, 255, 0.3),
                        inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            font-weight: 600;
            letter-spacing: -0.02em;
        }
        .action-btn-primary:hover {
            background: linear-gradient(135deg, #0051D5 0%, #003D9F 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 32px rgba(0, 122, 255, 0.4),
                        inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        .action-btn-secondary {
            background: linear-gradient(135deg, #34C759 0%, #248A3D 100%);
            box-shadow: 0 4px 20px rgba(52, 199, 89, 0.3),
                        inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            font-weight: 600;
            letter-spacing: -0.02em;
        }
        .action-btn-secondary:hover {
            background: linear-gradient(135deg, #248A3D 0%, #1E6F32 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 32px rgba(52, 199, 89, 0.4),
                        inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        .action-btn-gradient {
            background: linear-gradient(135deg, #5856D6 0%, #3634A3 100%);
            box-shadow: 0 4px 20px rgba(88, 86, 214, 0.3),
                        inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            font-weight: 600;
            letter-spacing: -0.02em;
        }
        .action-btn-gradient:hover {
            background: linear-gradient(135deg, #3634A3 0%, #2D2A87 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 32px rgba(88, 86, 214, 0.4),
                        inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        .header-action-btn {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(20px) saturate(180%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08),
                        inset 0 1px 0 rgba(255, 255, 255, 0.9);
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
        }
        .header-action-btn:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12),
                        inset 0 1px 0 rgba(255, 255, 255, 0.9);
            border-color: rgba(0, 122, 255, 0.2);
        }
        .header-action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }
        .header-action-btn:hover::before {
            left: 100%;
        }
        
        /* Glass UI Styles for About Section */
        .glass-about-section {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1),
                        0 2px 8px rgba(0, 0, 0, 0.05),
                        inset 0 1px 0 rgba(255, 255, 255, 0.4);
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .glass-about-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.1) 0%, 
                rgba(255, 255, 255, 0.05) 50%, 
                rgba(255, 255, 255, 0.1) 100%);
            pointer-events: none;
            z-index: 0;
        }
        .glass-about-section:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15),
                        0 4px 16px rgba(0, 0, 0, 0.08),
                        inset 0 1px 0 rgba(255, 255, 255, 0.5);
            border-color: rgba(255, 255, 255, 0.4);
        }
        .glass-content {
            position: relative;
            z-index: 1;
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05),
                        inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        .glass-service-card {
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(15px) saturate(180%);
            -webkit-backdrop-filter: blur(15px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 20px;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08),
                        inset 0 1px 0 rgba(255, 255, 255, 0.4);
            position: relative;
            overflow: hidden;
        }
        .glass-service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.1) 0%, 
                transparent 50%, 
                rgba(255, 255, 255, 0.1) 100%);
            pointer-events: none;
            z-index: 0;
        }
        .glass-service-card:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12),
                        inset 0 1px 0 rgba(255, 255, 255, 0.5);
            border-color: rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.4);
        }
        .glass-service-content {
            position: relative;
            z-index: 1;
        }
        .glass-icon-glow {
            filter: drop-shadow(0 4px 8px rgba(0, 122, 255, 0.3));
            transition: all 0.3s ease;
        }
        .glass-service-card:hover .glass-icon-glow {
            filter: drop-shadow(0 6px 12px rgba(0, 122, 255, 0.4));
            transform: scale(1.1);
        }
        
        /* Car Shop Section Styles */
        .car-shop-section {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px) saturate(180%);
            -webkit-backdrop-filter: blur(15px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 20px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08),
                        inset 0 1px 0 rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .car-shop-section:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12),
                        inset 0 1px 0 rgba(255, 255, 255, 0.4);
        }
        .car-item {
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06),
                        inset 0 1px 0 rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
        }
        .car-item:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1),
                        inset 0 1px 0 rgba(255, 255, 255, 0.4);
            border-color: rgba(255, 255, 255, 0.3);
        }
        .car-image {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .car-item:hover .car-image {
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }
        .price-tag {
            background: linear-gradient(135deg, #34C759 0%, #248A3D 100%);
            color: white;
            font-weight: 700;
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            box-shadow: 0 2px 8px rgba(52, 199, 89, 0.3);
            letter-spacing: -0.01em;
        }
        .shop-header-icon {
            background: linear-gradient(135deg, #FF6B6B 0%, #FF8E53 100%);
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(255, 107, 107, 0.3);
            margin-right: 1rem;
        }
    </style>
</head>
<body class="dealer-gradient min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="dealer-card overflow-hidden relative">
            <div class="dealer-banner"></div>
            <!-- Background Photo -->
            @if($profile->background_image)
            <div class="w-full h-32 md:h-40 bg-cover bg-center relative" style="background-image: url('{{ $profile->background_image_url }}');">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-800/80 to-transparent"></div>
                <!-- Profile Image Overlapping -->
                <div class="profile-overlap">
                    <div class="w-36 h-36 rounded-full bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 p-1 dealer-glow profile-img-shadow">
                        <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'Car Dealer') . '&background=007AFF&color=fff&size=144' }}" 
                             class="w-full h-full rounded-full object-cover border-4 border-white" 
                             alt="Profile Photo">
                        <!-- Dealer Badge -->
                        <div class="absolute -bottom-2 -right-2 dealer-badge rounded-full w-12 h-12 flex items-center justify-center text-xl border-4 border-white">
                            <i class="fas fa-car"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-spacer"></div>
            @else
            <!-- If no background, show profile image in normal flow -->
            <div class="relative flex justify-center mt-8 mb-2">
                <div class="w-36 h-36 rounded-full bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 p-1 dealer-glow profile-img-shadow relative">
                    <img src="{{ $profile->full_profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'Car Dealer') . '&background=007AFF&color=fff&size=144' }}" 
                         class="w-full h-full rounded-full object-cover border-4 border-white" 
                         alt="Profile Photo">
                    <div class="absolute -bottom-2 -right-2 dealer-badge rounded-full w-12 h-12 flex items-center justify-center text-xl border-4 border-white">
                        <i class="fas fa-car"></i>
                    </div>
                </div>
            </div>
            @endif
            <!-- Header Section -->
            <div class="relative px-6 pb-6 text-center z-10" style="margin-top: -30px;">
                <!-- Name & Title -->
                <h1 class="text-3xl font-bold text-gray-900 mb-2 tracking-tight" style="font-weight: 700; letter-spacing: -0.025em;">
                    {{ $profile->display_name ?? $user->name ?? 'Car Dealer' }}
                </h1>
                <p class="text-gray-600 font-medium text-lg mb-4 tracking-tight" style="font-weight: 500; letter-spacing: -0.01em;">
                    {{ $profile->profession ?? 'Vehicle Sales & Dealership' }}
                </p>

                
                @if($profile->location ?? null)
                <div class="flex items-center justify-center text-gray-500 text-sm mb-6">
                    <i class="fas fa-location-dot text-gray-400 mr-2"></i>
                    <span class="font-medium">{{ $profile->location }}</span>
                </div>
                @endif
                <div class="flex justify-center gap-2 mb-6">
                    <div class="dealer-badge px-3 py-1.5 rounded-full text-xs font-semibold">
                        <i class="fas fa-shield-check mr-1.5"></i>
                        Certified Dealer
                    </div>
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-3 py-1.5 rounded-full text-xs font-semibold shadow-lg">
                        <i class="fas fa-star mr-1.5"></i>
                        Premium
                    </div>
                </div>
                
                <!-- Call and Email Buttons under Certified Dealer Premium -->
                <div class="flex items-center justify-center space-x-4 mb-6">
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
            </div>
            

            
            <div class="divider"></div>
            <!-- Services Section (Bio + Dealer Services) with Glass UI -->
            <div class="px-6 py-4">
                <div class="glass-about-section p-6 mb-6">
                    <div class="glass-content">
                        <!-- Glass Header -->
                        <div class="glass-header">
                            <div class="flex items-center justify-center">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center mr-4 shadow-lg">
                                    <i class="fas fa-info-circle text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg mb-1">About Our Dealership</h3>
                                    <p class="text-xs text-gray-600 font-medium">Premium Vehicle Solutions</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Bio Text with Glass Background -->
                        <div class="bg-white/20 backdrop-blur-sm rounded-xl p-4 mb-6 border border-white/30">
                            <p class="text-gray-800 text-sm leading-relaxed font-medium">
                                {{ $profile->bio ?? 'Your trusted partner for new and used vehicles. We offer a wide range of cars, financing, and after-sales support with exceptional customer service.' }}
                            </p>
                        </div>
                        
                        <!-- Glass Service Cards -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="glass-service-card p-5 text-center fade-in">
                                <div class="glass-service-content">
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mx-auto mb-3 shadow-lg">
                                        <i class="fas fa-car-side text-white text-2xl glass-icon-glow"></i>
                                    </div>
                                    <div class="text-sm font-bold text-gray-800 mb-1">New Cars</div>
                                    <div class="text-xs text-gray-600 font-medium">Latest Models</div>
                                    <div class="mt-2 px-2 py-1 bg-blue-100/50 rounded-full text-xs text-blue-700 font-semibold">
                                        Premium Selection
                                    </div>
                                </div>
                            </div>
                            <div class="glass-service-card p-5 text-center fade-in">
                                <div class="glass-service-content">
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center mx-auto mb-3 shadow-lg">
                                        <i class="fas fa-car text-white text-2xl glass-icon-glow"></i>
                                    </div>
                                    <div class="text-sm font-bold text-gray-800 mb-1">Used Cars</div>
                                    <div class="text-xs text-gray-600 font-medium">Quality Assured</div>
                                    <div class="mt-2 px-2 py-1 bg-green-100/50 rounded-full text-xs text-green-700 font-semibold">
                                        Certified Pre-Owned
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <!-- Brands Section -->
            <div class="px-6 py-4">
                <h3 class="font-semibold text-gray-900 mb-6 flex items-center text-lg tracking-tight" style="font-weight: 600; letter-spacing: -0.015em;">
                    <i class="fas fa-car-alt text-gray-600 mr-3 text-lg"></i>
                    Featured Brands
                </h3>
                <div class="brand-logos">
                    <div class="brand-logo fade-in" title="Toyota">
                        <img src="{{ asset('images/car-logos/toyota.png') }}" alt="Toyota" class="brand-logo-img">
                    </div>
                    <div class="brand-logo fade-in" title="Mercedes-Benz">
                        <img src="{{ asset('images/car-logos/mercedes-benz.png') }}" alt="Mercedes-Benz" class="brand-logo-img">
                    </div>
                    <div class="brand-logo fade-in" title="BMW">
                        <img src="{{ asset('images/car-logos/bmw.jpg') }}" alt="BMW" class="brand-logo-img">
                    </div>
                    <div class="brand-logo fade-in" title="Audi">
                        <img src="{{ asset('images/car-logos/audi.png') }}" alt="Audi" class="brand-logo-img">
                    </div>
                    <div class="brand-logo fade-in" title="Honda">
                        <img src="{{ asset('images/car-logos/honda (2).png') }}" alt="Honda" class="brand-logo-img">
                    </div>
                    <div class="brand-logo fade-in" title="Ford">
                        <img src="{{ asset('images/car-logos/ford.png') }}" alt="Ford" class="brand-logo-img">
                    </div>
                    <div class="brand-logo fade-in" title="Nissan">
                        <img src="{{ asset('images/car-logos/nissan.png') }}" alt="Nissan" class="brand-logo-img">
                    </div>
                    <div class="brand-logo fade-in" title="Hyundai">
                        <img src="{{ asset('images/car-logos/hyunda.png') }}" alt="Hyundai" class="brand-logo-img">
                    </div>
                    <div class="brand-logo fade-in" title="Subaru">
                        <img src="{{ asset('images/car-logos/Subaru.png') }}" alt="Subaru" class="brand-logo-img">
                    </div>
                    <div class="brand-logo fade-in" title="Mitsubishi">
                        <img src="{{ asset('images/car-logos/mitsubish.jpg') }}" alt="Mitsubishi" class="brand-logo-img">
                    </div>
                    <div class="brand-logo fade-in" title="Mazda">
                        <img src="{{ asset('images/car-logos/Mazda.jpg') }}" alt="Mazda" class="brand-logo-img">
                    </div>
                    <div class="brand-logo fade-in" title="Lexus">
                        <img src="{{ asset('images/car-logos/Lexus.jpg') }}" alt="Lexus" class="brand-logo-img">
                    </div>
                    <div class="brand-logo fade-in" title="Land Rover">
                        <img src="{{ asset('images/car-logos/land-rover-.jpg') }}" alt="Land Rover" class="brand-logo-img">
                    </div>
                    <div class="brand-logo fade-in" title="Jeep">
                        <img src="{{ asset('images/car-logos/Jeep.jpg') }}" alt="Jeep" class="brand-logo-img">
                    </div>
                    <div class="brand-logo fade-in" title="Jaguar">
                        <img src="{{ asset('images/car-logos/jaguar.jpg') }}" alt="Jaguar" class="brand-logo-img">
                    </div>
                </div>
            </div>
            <!-- Social Links -->
            @if(isset($socialLinks) && $socialLinks->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-bold text-gray-800 mb-6 flex items-center text-lg">
                    <i class="fas fa-share-alt text-pink-600 mr-3 text-xl"></i>
                    Connect with Us
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
                                    @default bg-gradient-to-r from-gray-500 to-gray-600 @break
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
                                <div class="text-sm text-gray-600">Follow us on {{ ucfirst($link->platform) }}</div>
                            </div>
                            <div class="text-gray-400">
                                <i class="fas fa-external-link-alt text-sm"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Photo Gallery -->
            @if(isset($galleryItems) && $galleryItems->count() > 0)
            <div class="px-6 py-4">
                <h3 class="font-bold text-gray-800 mb-6 flex items-center text-lg">
                    <i class="fas fa-images text-purple-600 mr-3 text-xl"></i>
                    Showroom Gallery
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
            @if($profile->website)
            <div class="px-6 py-4">
                <h3 class="font-bold text-gray-800 mb-6 flex items-center text-lg">
                    <i class="fas fa-address-book text-indigo-600 mr-3 text-xl"></i>
                    Get In Touch
                </h3>
                <div class="space-y-3">
                    <div class="contact-item rounded-xl p-4 flex items-center fade-in">
                        <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white mr-4 shadow-lg">
                            <i class="fas fa-globe text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-gray-800">Website</div>
                            <div class="text-sm text-gray-600 font-medium">Visit our site</div>
                        </div>
                        <a href="{{ $profile->website }}" target="_blank" class="bg-gradient-to-r from-purple-500 to-purple-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:from-purple-600 hover:to-purple-700 transition-all shadow-lg">
                            Visit
                        </a>
                    </div>
                </div>
            </div>
            @endif
            <!-- Action Buttons -->
            <div class="px-6 py-6 space-y-4">
                @if($profile->phone)
                <a href="tel:{{ $profile->phone }}" class="w-full action-btn-primary text-white py-4 px-6 rounded-xl font-bold text-center flex items-center justify-center text-lg">
                    <i class="fas fa-phone mr-3"></i>
                    Call Now
                </a>
                @endif
                @if($profile->email ?? $user->email)
                <a href="mailto:{{ $profile->email ?? $user->email }}?subject=Car Inquiry" class="w-full action-btn-secondary text-white py-4 px-6 rounded-xl font-bold text-center flex items-center justify-center text-lg">
                    <i class="fas fa-envelope mr-3"></i>
                    Email Us
                </a>
                @endif
                <!-- Save Contact Button -->
                <button onclick="saveContact()" class="w-full action-btn-gradient text-white py-4 px-6 rounded-xl font-bold text-center flex items-center justify-center text-lg">
                    <i class="fas fa-download mr-3"></i>
                    Save Contact
                </button>
            </div>
            <!-- Footer -->
            <div class="px-6 py-6 bg-gradient-to-r from-gray-50 to-blue-50 text-center border-t border-blue-200">
                <div class="flex items-center justify-center text-gray-700 text-sm mb-3">
                    <i class="fas fa-shield-alt text-blue-600 mr-2"></i>
                    <span class="font-bold">Trusted Vehicle Dealer</span>
                    <i class="fas fa-award text-green-600 ml-2"></i>
                </div>
                <div class="text-xs text-gray-500 font-medium">
                    Powered by Whiteraysoft Technologies
                </div>
            </div>
        </div>
    </div>
    <!-- Gallery Modal -->
    <div id="galleryModal" class="hidden fixed top-0 left-0 w-full h-full bg-black/90 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full max-h-full overflow-auto relative">
            <div class="flex justify-between items-center p-4 border-b border-slate-200">
                <h3 id="galleryModalTitle" class="text-lg font-bold text-slate-900"></h3>
                <button onclick="closeGalleryModal()" class="text-2xl text-slate-700 hover:text-slate-900 transition-colors">&times;</button>
            </div>
            <img id="galleryModalImage" src="" alt="" class="w-full object-contain" style="max-height:60vh;">
            <div class="p-4 text-slate-800 text-sm" id="galleryModalDescription"></div>
        </div>
    </div>
    <script>
        // vCard Download Function
        function saveContact() {
            const vCardData = `BEGIN:VCARD\nVERSION:3.0\nFN:{{ $profile->display_name ?? $user->name ?? 'Car Dealer' }}\nORG:{{ $profile->profession ?? 'Vehicle Sales & Dealership' }}\nTITLE:{{ $profile->profession ?? 'Vehicle Sales & Dealership' }}\nTEL:{{ $profile->phone ?? '' }}\nEMAIL:{{ $profile->email ?? $user->email ?? '' }}\nURL:{{ $profile->website ?? '' }}\nNOTE:{{ $profile->bio ?? 'Your trusted partner for new and used vehicles.' }}\nEND:VCARD`;
            const blob = new Blob([vCardData], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($profile->display_name ?? $user->name ?? 'car-dealer') }}.vcf';
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

        // PWA Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                @if($profile->pwa_enabled && isset($qrCode))
                    navigator.serviceWorker.register('{{ route('pwa.service-worker', $qrCode->uuid) }}')
                @else
                    navigator.serviceWorker.register('/sw.js')
                @endif
                .then(function(registration) {
                    console.log('[PWA] Service Worker registered successfully:', registration.scope);
                    
                    // Check for updates
                    registration.addEventListener('updatefound', function() {
                        const newWorker = registration.installing;
                        newWorker.addEventListener('statechange', function() {
                            if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                // New content is available
                                console.log('[PWA] New content available');
                            }
                        });
                    });
                }).catch(function(error) {
                    console.error('[PWA] Service Worker registration failed:', error);
                });
            });
        }

        // PWA Install Prompt
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', function(e) {
            e.preventDefault();
            deferredPrompt = e;
            
            // Show install button if available
            const installBtn = document.getElementById('pwa-install-btn');
            if (installBtn) {
                installBtn.style.display = 'block';
                installBtn.addEventListener('click', function() {
                    if (deferredPrompt) {
                        deferredPrompt.prompt();
                        deferredPrompt.userChoice.then(function(choiceResult) {
                            if (choiceResult.outcome === 'accepted') {
                                console.log('[PWA] User accepted the install prompt');
                            }
                            deferredPrompt = null;
                        });
                    }
                });
            }
        });

        // Handle successful installation
        window.addEventListener('appinstalled', function() {
            console.log('[PWA] App installed successfully');
            const installBtn = document.getElementById('pwa-install-btn');
            if (installBtn) {
                installBtn.style.display = 'none';
            }
        });
    </script>
</body>
</html>

