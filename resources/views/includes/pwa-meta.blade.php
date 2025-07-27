{{-- PWA Meta Tags --}}
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="{{ $profile->pwa_app_name ?? $profile->display_name ?? 'Digital Profile' }}">
<meta name="application-name" content="{{ $profile->pwa_app_name ?? $profile->display_name ?? 'Digital Profile' }}">

{{-- Theme Colors --}}
<meta name="theme-color" content="{{ $profile->pwa_theme_color ?? '#4F46E5' }}" media="(prefers-color-scheme: light)">
<meta name="theme-color" content="#3730A3" media="(prefers-color-scheme: dark)">
<meta name="msapplication-navbutton-color" content="{{ $profile->pwa_theme_color ?? '#4F46E5' }}">

{{-- PWA Manifest --}}
@if(isset($qrCode) && $qrCode)
    <link rel="manifest" href="{{ route('pwa.manifest', $qrCode->uuid) }}">
@else
    <link rel="manifest" href="{{ route('pwa.manifest', 'demo') }}">
@endif

{{-- Apple Touch Icons --}}
@if($profile->pwa_icon && Storage::disk('public')->exists($profile->pwa_icon))
    <link rel="apple-touch-icon" href="{{ Storage::disk('public')->url($profile->pwa_icon) }}">
@else
    <link rel="apple-touch-icon" href="/images/pwa-icon-180.png">
@endif
<link rel="apple-touch-icon" sizes="152x152" href="/images/pwa-icon-152.png">
<link rel="apple-touch-icon" sizes="144x144" href="/images/pwa-icon-144.png">
<link rel="apple-touch-icon" sizes="120x120" href="/images/pwa-icon-120.png">

{{-- Standard Favicon --}}
<link rel="icon" type="image/png" sizes="32x32" href="/images/pwa-icon-32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/images/pwa-icon-16.png">