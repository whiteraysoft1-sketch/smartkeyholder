{{-- PWA Service Worker Registration --}}
<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        @if(isset($qrCode) && $qrCode)
            navigator.serviceWorker.register('/pwa/sw/{{ $qrCode->uuid }}')
        @else
            navigator.serviceWorker.register('/pwa/sw/demo')
        @endif
            .then(function(registration) {
                console.log('[PWA] Service Worker registered successfully:', registration.scope);
            })
            .catch(function(error) {
                console.error('[PWA] Service Worker registration failed:', error);
            });
    });
}
</script>

{{-- PWA Install Prompt Handling --}}
<script>
// PWA Install functionality
window.addEventListener('load', function() {
    // Check if already running as PWA
    if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
        console.log('[PWA] Already running in standalone mode');
        return;
    }
    
    // Handle install prompt
    let deferredPrompt;
    
    window.addEventListener('beforeinstallprompt', (e) => {
        console.log('[PWA] Install prompt available');
        e.preventDefault();
        deferredPrompt = e;
        
        // Show install button if it exists
        const installSection = document.getElementById('pwa-install-section');
        if (installSection) {
            installSection.classList.remove('hidden');
        }
    });
    
    // Handle successful installation
    window.addEventListener('appinstalled', () => {
        console.log('[PWA] App installed successfully');
        const installSection = document.getElementById('pwa-install-section');
        if (installSection) {
            installSection.classList.add('hidden');
        }
    });
    
    // Global install function
    window.installPWA = function() {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('[PWA] User accepted the install prompt');
                } else {
                    console.log('[PWA] User dismissed the install prompt');
                }
                deferredPrompt = null;
            });
        } else {
            // Show manual install instructions
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
            const isAndroid = /Android/.test(navigator.userAgent);
            
            let instructions = '';
            if (isIOS) {
                instructions = 'To install this app on your iOS device:\n\n1. Tap the Share button (square with arrow)\n2. Scroll down and tap "Add to Home Screen"\n3. Tap "Add" to confirm';
            } else if (isAndroid) {
                instructions = 'To install this app:\n\n1. Tap the menu button (⋮) in your browser\n2. Select "Add to Home screen" or "Install app"\n3. Follow the prompts to install';
            } else {
                instructions = 'To install this app:\n\n1. Look for the install icon in your browser\'s address bar\n2. Or check your browser menu for "Install" option\n3. Follow the prompts to install';
            }
            
            alert(instructions);
        }
    };
});
</script>