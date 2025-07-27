<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profile->display_name ?? $user->name }} - Digital Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Enhanced PWA Meta Tags (Only if PWA is enabled) -->
    @if($profile && $profile->pwa_enabled)
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="{{ $profile->pwa_app_name ?? $profile->display_name ?? $user->name }}">
    <meta name="application-name" content="{{ $profile->pwa_app_name ?? $profile->display_name ?? $user->name }}">
    
    <!-- Theme Colors -->
    <meta name="theme-color" content="{{ $profile->pwa_theme_color ?? '#4F46E5' }}" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#3730A3" media="(prefers-color-scheme: dark)">
    <meta name="msapplication-navbutton-color" content="{{ $profile->pwa_theme_color ?? '#4F46E5' }}">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ route('pwa.manifest', $qrCode->uuid ?? $profile->uuid ?? 'demo') }}">
    
    <!-- Apple Touch Icons -->
    @if($profile->pwa_icon)
        <link rel="apple-touch-icon" href="{{ Storage::disk('public')->url($profile->pwa_icon) }}">
    @else
        <link rel="apple-touch-icon" href="/images/pwa-icon-180.png">
    @endif
    <link rel="apple-touch-icon" sizes="152x152" href="/images/pwa-icon-152.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/images/pwa-icon-144.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/pwa-icon-120.png">
    
    <!-- Standard Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/images/pwa-icon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/pwa-icon-16.png">
    
    <!-- Service Worker Registration -->
    <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/pwa/sw/{{ $qrCode->uuid ?? $profile->uuid ?? 'demo' }}')
                .then(function(registration) {
                    console.log('[PWA] Service Worker registered successfully:', registration.scope);
                })
                .catch(function(error) {
                    console.error('[PWA] Service Worker registration failed:', error);
                });
        });
    }
    </script>
    @endif
    
    <!-- Meta tags for social sharing -->
    <meta property="og:title" content="{{ $profile->display_name ?? $user->name }}">
    <meta property="og:description" content="{{ $profile->bio ?? 'Digital Profile' }}">
    <meta property="og:type" content="profile">
    <meta name="twitter:card" content="summary_large_image">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>
<body class="bg-gradient-to-br from-gray-50 to-white min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-md">
        <!-- Profile Header -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
            <!-- Cover/Background -->
            <div class="h-32 relative overflow-hidden">
                @if($profile && $profile->hasBackgroundImage())
                    <img src="{{ $profile->full_background_image_url }}" 
                         alt="Background" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                @else
                    <div class="h-full bg-gradient-to-r from-blue-500 to-purple-600">
                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                    </div>
                @endif
            </div>
            
            <!-- Profile Info -->
            <div class="relative px-6 pb-6">
                <!-- Profile Picture -->
                <div class="flex justify-center -mt-16 mb-4">
                    @if($profile && $profile->profile_image)
                        <img src="{{ $profile->full_profile_image_url }}" 
                             alt="{{ $profile->display_name ?? $user->name }}"
                             class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
                    @else
                        <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg bg-gray-300 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                
                <!-- Name and Title -->
                <div class="text-center mb-4">
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">
                        {{ $profile->display_name ?? $user->name }}
                    </h1>
                    @if($profile && $profile->profession)
                        <p class="text-gray-600 font-medium">{{ $profile->profession }}</p>
                    @endif
                    @if($profile && $profile->location)
                        <p class="text-gray-500 text-sm flex items-center justify-center mt-1">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $profile->location }}
                        </p>
                    @endif
                </div>
                
                <!-- Bio -->
                @if($profile && $profile->bio)
                    <div class="text-center mb-6">
                        <p class="text-gray-700 leading-relaxed">{{ $profile->bio }}</p>
                    </div>
                @endif
                
                <!-- Contact Buttons -->
                <div class="grid grid-cols-2 gap-3 mb-6">
                    @if($profile && $profile->phone)
                        <a href="tel:{{ $profile->phone }}" 
                           class="flex items-center justify-center bg-green-500 hover:bg-green-600 text-white py-3 px-4 rounded-xl transition duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Call
                        </a>
                    @endif
                    
                    <a href="mailto:{{ $user->email }}" 
                       class="flex items-center justify-center bg-blue-500 hover:bg-blue-600 text-white py-3 px-4 rounded-xl transition duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Email
                    </a>
                </div>
                
                <!-- PWA Install Button -->
                <div id="pwa-install-section" class="mb-6 hidden">
                    <button id="pwa-install-btn" 
                            class="w-full flex items-center justify-center bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white py-3 px-4 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg">
                        <span id="pwa-install-icon" class="mr-2">📱</span>
                        <span id="pwa-install-text">Install App</span>
                    </button>
                    <p class="text-center text-xs text-gray-500 mt-2">Get quick access from your home screen</p>
                </div>
                
                <!-- Website Button -->
                @if($profile && $profile->website)
                    <a href="{{ $profile->website }}" target="_blank" rel="noopener noreferrer"
                       class="block w-full text-center bg-gray-800 hover:bg-gray-900 text-white py-3 px-4 rounded-xl transition duration-200 transform hover:scale-105 mb-6">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-5 0-9-4-9-9s4-9 9-9"></path>
                        </svg>
                        Visit Website
                    </a>
                @endif
            </div>
        </div>
        
        <!-- Social Links -->
        @if($socialLinks->count() > 0)
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 text-center">Connect With Me</h2>
                <div class="space-y-3">
                    @foreach($socialLinks as $link)
                        <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer"
                           class="flex items-center justify-between bg-gray-50 hover:bg-gray-100 p-4 rounded-xl transition duration-200 transform hover:scale-105">
                            <div class="flex items-center">
                                @php
                                    $platformColors = [
                                        'facebook' => 'text-blue-600',
                                        'twitter' => 'text-blue-400',
                                        'instagram' => 'text-pink-600',
                                        'linkedin' => 'text-blue-700',
                                        'youtube' => 'text-red-600',
                                        'tiktok' => 'text-black',
                                        'whatsapp' => 'text-green-600',
                                        'website' => 'text-gray-600'
                                    ];
                                    $colorClass = $platformColors[$link->platform] ?? 'text-gray-600';
                                @endphp
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center mr-3 {{ $colorClass }}">
                                    @switch($link->platform)
                                        @case('facebook')
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                            @break
                                        @case('twitter')
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                            @break
                                        @case('instagram')
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.297-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.807.875 1.297 2.026 1.297 3.323s-.49 2.448-1.297 3.323c-.875.807-2.026 1.297-3.323 1.297zm7.718-1.297c-.875.807-2.026 1.297-3.323 1.297s-2.448-.49-3.323-1.297c-.807-.875-1.297-2.026-1.297-3.323s.49-2.448 1.297-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.807.875 1.297 2.026 1.297 3.323s-.49 2.448-1.297 3.323z"/></svg>
                                            @break
                                        @case('linkedin')
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                            @break
                                        @case('youtube')
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                            @break
                                        @case('tiktok')
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>
                                            @break
                                        @case('whatsapp')
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.085"/></svg>
                                            @break
                                        @default
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                            </svg>
                                    @endswitch
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ ucfirst($link->platform) }}</p>
                                    @if($link->display_name)
                                        <p class="text-sm text-gray-600">{{ $link->display_name }}</p>
                                    @endif
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Gallery -->
        @if($galleryItems->count() > 0)
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 text-center">Gallery</h2>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($galleryItems as $item)
                        <div class="relative group cursor-pointer" onclick="openModal('{{ $item->full_image_url }}', '{{ $item->title }}', '{{ $item->description }}')">
                            <img src="{{ $item->full_image_url }}" 
                                 alt="{{ $item->title }}"
                                 class="w-full h-32 object-cover rounded-xl transition duration-200 group-hover:opacity-90">
                            @if($item->title)
                                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2 rounded-b-xl">
                                    <p class="text-sm font-medium truncate">{{ $item->title }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- PWA Install Section (Only show if PWA is enabled) -->
        @if($profile && $profile->pwa_enabled)
        <div class="bg-white rounded-2xl shadow-xl p-6 text-center space-y-3 mb-6">
            <!-- PWA Install Button -->
            <button id="pwa-install-btn" class="w-full bg-gradient-to-r from-green-500 to-blue-600 hover:from-green-600 hover:to-blue-700 text-white font-bold py-4 px-6 rounded-xl transition duration-200 transform hover:scale-105 flex items-center justify-center mb-3 shadow-lg text-lg">
                <span id="pwa-install-icon" class="mr-3 text-2xl">📱</span>
                <span id="pwa-install-text">Install {{ $profile->pwa_app_name ?? 'App' }}</span>
            </button>
            
            <!-- Installation Status -->
            <div id="pwa-install-status" class="hidden w-full mb-3 p-3 bg-blue-100 border border-blue-300 rounded-xl">
                <div class="text-blue-800 font-semibold text-sm flex items-center justify-center">
                    <span class="animate-spin mr-2">⚙️</span>
                    Installing app...
                </div>
            </div>
            
            <!-- Success Status -->
            <div id="pwa-install-success" class="hidden w-full mb-3 p-3 bg-green-100 border border-green-300 rounded-xl">
                <div class="text-green-800 font-semibold text-sm">
                    🎉 App installed! Check your home screen.
                </div>
            </div>
            
            <!-- Save Contact Button -->
            <button onclick="downloadVCard()" 
                    class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold py-4 px-6 rounded-xl transition duration-200 transform hover:scale-105">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Save Contact
            </button>
        </div>
        @else
        <!-- Save Contact Section (when PWA is disabled) -->
        <div class="bg-white rounded-2xl shadow-xl p-6 text-center mb-6">
            <button onclick="downloadVCard()" 
                    class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold py-4 px-6 rounded-xl transition duration-200 transform hover:scale-105">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Save Contact
            </button>
        </div>
        @endif
        
        <!-- PWA Status Badge -->
        <div class="bg-gradient-to-r from-purple-100 to-indigo-100 border border-purple-200 rounded-xl p-4 mb-6 text-center">
            <div class="flex items-center justify-center mb-2">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-full p-2 mr-3">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                    </svg>
                </div>
                <span class="text-purple-800 font-semibold">📱 Enhanced App Experience</span>
            </div>
            <p class="text-purple-700 text-sm">This profile is optimized as a Progressive Web App with offline support and native features!</p>
        </div>
        
        <!-- Footer -->
        <div class="text-center mt-8 text-gray-500 text-sm">
            <p>Powered by <span class="font-semibold">Whiteray Smart Tag</span></p>
        </div>
    </div>
    
    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full max-h-full overflow-auto">
            <div class="p-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 id="modalTitle" class="text-lg font-semibold"></h3>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <img id="modalImage" src="" alt="" class="w-full rounded-xl mb-4">
                <p id="modalDescription" class="text-gray-600"></p>
            </div>
        </div>
    </div>

    <script>
        function openModal(imageUrl, title, description) {
            document.getElementById('modalImage').src = imageUrl;
            document.getElementById('modalTitle').textContent = title || 'Image';
            document.getElementById('modalDescription').textContent = description || '';
            document.getElementById('imageModal').classList.remove('hidden');
        }
        
        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }
        
        function downloadVCard() {
            // Create vCard content
            const vcard = `BEGIN:VCARD
VERSION:3.0
FN:{{ $profile->display_name ?? $user->name }}
EMAIL:{{ $user->email }}
@if($profile && $profile->phone)TEL:{{ $profile->phone }}
@endif
@if($profile && $profile->profession)TITLE:{{ $profile->profession }}
@endif
@if($profile && $profile->website)URL:{{ $profile->website }}
@endif
@if($profile && $profile->bio)NOTE:{{ $profile->bio }}
@endif
END:VCARD`;
            
            // Create and download file
            const blob = new Blob([vcard], { type: 'text/vcard' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($profile->display_name ?? $user->name) }}.vcf';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
        }
        
        // Close modal when clicking outside
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        @if($profile && $profile->pwa_enabled)
        // Enhanced Mobile PWA Install Support for Public Profile
        console.log('PWA install initialized for {{ $profile->pwa_app_name ?? "Smart Tag" }}');

        // PWA Installation Manager
        let deferredPrompt;
        let installAttempted = false;
        const installBtn = document.getElementById('pwa-install-btn');
        const installSection = document.getElementById('pwa-install-section');
        const installIcon = document.getElementById('pwa-install-icon');
        const installText = document.getElementById('pwa-install-text');
        const installStatus = document.getElementById('pwa-install-status');
        const installSuccess = document.getElementById('pwa-install-success');

        // Device and Browser Detection
        function getDeviceInfo() {
            const ua = navigator.userAgent;
            const isIOS = /iPad|iPhone|iPod/.test(ua);
            const isAndroid = /Android/.test(ua);
            const isSafari = /Safari/.test(ua) && !/Chrome/.test(ua);
            const isChrome = /Chrome/.test(ua) && !/Edg/.test(ua);
            
            return { isIOS, isAndroid, isSafari, isChrome, isMobile: isIOS || isAndroid };
        }

        function isStandalone() {
            return window.matchMedia('(display-mode: standalone)').matches || 
                   window.navigator.standalone === true;
        }

        function setupInstallButton() {
            if (!installBtn) return;
            
            const device = getDeviceInfo();
            let icon = '📱';
            let buttonText = 'Install {{ $profile->pwa_app_name ?? "App" }}';

            // Set appropriate icon and text for mobile-first approach
            if (device.isMobile) {
                icon = device.isIOS ? '🍎' : '🤖';
                buttonText = device.isIOS ? 'Add to Home Screen' : 'Install {{ $profile->pwa_app_name ?? "App" }}';
            } else {
                icon = '💻';
                buttonText = 'Install {{ $profile->pwa_app_name ?? "App" }}';
            }

            if (installIcon) installIcon.textContent = icon;
            if (installText) installText.textContent = buttonText;

            console.log(`PWA install ready for: ${device.isIOS ? 'iOS' : device.isAndroid ? 'Android' : 'Desktop'}`);

            // Don't show anything if already installed
            if (isStandalone()) {
                if (installSection) installSection.classList.add('hidden');
                console.log('[PWA] App already installed');
                return;
            }

            // Show install button
            if (installSection) installSection.classList.remove('hidden');
            return device;
        }

        // Handle native install prompt (Chrome, Edge, Samsung Internet)
        window.addEventListener('beforeinstallprompt', function(e) {
            console.log('[PWA] One-click install available!');
            e.preventDefault();
            deferredPrompt = e;
            
            // Update button to show one-click install is ready
            if (installBtn) {
                installBtn.style.background = 'linear-gradient(135deg, #10B981, #059669)';
                installBtn.style.boxShadow = '0 0 20px rgba(16, 185, 129, 0.5)';
            }
            
            if (installText) {
                installText.textContent = '⚡ One-Click Install';
            }
            
            console.log('[PWA] One-click install ready!');
        });

        // Install button click handler
        if (installBtn) {
            installBtn.addEventListener('click', async function() {
                if (installAttempted) return;
                
                const device = getDeviceInfo();
                
                if (deferredPrompt) {
                    // Native install prompt available - ONE CLICK INSTALL
                    console.log('[PWA] One-click install triggered');
                    try {
                        installAttempted = true;
                        
                        // Show status
                        if (installStatus) installStatus.classList.remove('hidden');
                        
                        // Update button state
                        installBtn.style.background = 'linear-gradient(135deg, #F59E0B, #D97706)';
                        installText.textContent = 'Installing...';
                        installBtn.disabled = true;
                        
                        deferredPrompt.prompt();
                        const { outcome } = await deferredPrompt.userChoice;
                        console.log(`[PWA] Install outcome: ${outcome}`);
                        
                        if (outcome === 'accepted') {
                            if (installStatus) installStatus.classList.add('hidden');
                            if (installSuccess) installSuccess.classList.remove('hidden');
                            setTimeout(() => {
                                if (installSection) installSection.classList.add('hidden');
                            }, 3000);
                        } else {
                            // Reset button
                            installBtn.style.background = 'linear-gradient(135deg, #10B981, #059669)';
                            installText.textContent = '⚡ One-Click Install';
                            installBtn.disabled = false;
                            installAttempted = false;
                            if (installStatus) installStatus.classList.add('hidden');
                        }
                    } catch (error) {
                        console.error('[PWA] Install error:', error);
                        // Reset button
                        installBtn.style.background = 'linear-gradient(135deg, #10B981, #059669)';
                        installText.textContent = '⚡ One-Click Install';
                        installBtn.disabled = false;
                        installAttempted = false;
                        if (installStatus) installStatus.classList.add('hidden');
                    }
                    deferredPrompt = null;
                } else {
                    // Fallback - show device-specific instructions
                    console.log('[PWA] Showing fallback instructions');
                    let message = '';
                    
                    if (device.isIOS && device.isSafari) {
                        message = 'To install:\n1. Tap the Share button (□↗) at the bottom\n2. Select "Add to Home Screen"\n3. Tap "Add"';
                    } else if (device.isAndroid) {
                        message = 'To install:\n1. Tap the menu button (⋮) and select "Install app" or "Add to Home Screen"';
                    } else {
                        message = 'To install:\n1. Look for an install icon in your browser\'s address bar\n2. Or check your browser menu for install options';
                    }
                    
                    alert(message);
                }
            });
        }

        // Handle successful installation
        window.addEventListener('appinstalled', function() {
            console.log('[PWA] App installed successfully!');
            if (installSection) installSection.classList.add('hidden');
            if (installStatus) installStatus.classList.add('hidden');
            if (installSuccess) installSuccess.classList.remove('hidden');
        });

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            setupInstallButton();
        });

        // Also initialize if DOM is already loaded
        if (document.readyState !== 'loading') {
            setupInstallButton();
        }
        @endif
    </script>
</body>
</html>