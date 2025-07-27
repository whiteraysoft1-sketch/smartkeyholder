<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PWA Test Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-2xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">PWA Test Page</h1>
            
            <div class="space-y-4">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h2 class="text-lg font-semibold text-blue-900 mb-2">PWA Features Test</h2>
                    <p class="text-blue-700">This page tests basic PWA functionality.</p>
                </div>
                
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h3 class="font-semibold text-green-900 mb-2">Service Worker Status</h3>
                    <p id="sw-status" class="text-green-700">Checking...</p>
                </div>
                
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <h3 class="font-semibold text-purple-900 mb-2">Install Status</h3>
                    <p id="install-status" class="text-purple-700">Checking...</p>
                </div>
                
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h3 class="font-semibold text-yellow-900 mb-2">Browser Info</h3>
                    <p id="browser-info" class="text-yellow-700">Loading...</p>
                </div>
                
                <div class="flex space-x-4">
                    <a href="{{ route('dashboard.simple') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Back to Dashboard
                    </a>
                    <a href="{{ route('test.pwa.public') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Test Public PWA
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Check Service Worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.getRegistrations().then(function(registrations) {
                const swStatus = document.getElementById('sw-status');
                if (registrations.length > 0) {
                    swStatus.textContent = `Service Worker registered: ${registrations[0].scope}`;
                    swStatus.className = 'text-green-700';
                } else {
                    swStatus.textContent = 'No Service Worker registered';
                    swStatus.className = 'text-yellow-700';
                }
            });
        } else {
            document.getElementById('sw-status').textContent = 'Service Worker not supported';
            document.getElementById('sw-status').className = 'text-red-700';
        }
        
        // Check Install Status
        const installStatus = document.getElementById('install-status');
        if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
            installStatus.textContent = 'Running as installed PWA';
            installStatus.className = 'text-green-700';
        } else {
            installStatus.textContent = 'Running in browser';
            installStatus.className = 'text-blue-700';
        }
        
        // Browser Info
        const browserInfo = document.getElementById('browser-info');
        const ua = navigator.userAgent;
        const isIOS = /iPad|iPhone|iPod/.test(ua);
        const isAndroid = /Android/.test(ua);
        const isChrome = /Chrome/.test(ua) && !/Edg/.test(ua);
        const isSafari = /Safari/.test(ua) && !/Chrome/.test(ua);
        
        let browserText = 'Unknown browser';
        if (isIOS) browserText = isSafari ? 'iOS Safari' : 'iOS Other';
        else if (isAndroid) browserText = isChrome ? 'Android Chrome' : 'Android Other';
        else if (isChrome) browserText = 'Desktop Chrome';
        else if (isSafari) browserText = 'Desktop Safari';
        
        browserInfo.textContent = `${browserText} - PWA Support: ${isChrome || (isIOS && isSafari) ? 'Yes' : 'Limited'}`;
    </script>
</body>
</html>