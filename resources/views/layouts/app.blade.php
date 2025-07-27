<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ setting('site_name', config('app.name', 'Laravel')) }}</title>
        
        @if(setting('favicon'))
            <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . setting('favicon')) }}">
        @endif

        {{-- PWA Meta Tags --}}
        <x-pwa-meta />



        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/liquid-glass.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
        

        
        @stack('scripts')
        <script>
        // Auto-attach CSRF token to all fetch requests
        (function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if (!csrfToken) return;
            const origFetch = window.fetch;
            window.fetch = function(input, init = {}) {
                init.headers = init.headers || {};
                if (typeof init.headers.append === 'function') {
                    init.headers.append('X-CSRF-TOKEN', csrfToken);
                } else {
                    init.headers['X-CSRF-TOKEN'] = csrfToken;
                }
                return origFetch(input, init);
            };
        })();
        </script>
    </body>
</html>