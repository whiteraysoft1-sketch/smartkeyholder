p{{-- Simple PWA Install Button Component --}}
<div id="pwa-install-container" class="hidden">
    <button id="pwa-install-btn" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        Install App
    </button>
</div>

<div id="pwa-manual-instructions" class="hidden mt-4 p-4 bg-blue-50 rounded-lg">
    <p class="text-sm text-blue-800">
        <strong>Install this app:</strong>
        <span id="pwa-instructions-text"></span>
    </p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const installContainer = document.getElementById('pwa-install-container');
    const installBtn = document.getElementById('pwa-install-btn');
    const manualInstructions = document.getElementById('pwa-manual-instructions');
    const instructionsText = document.getElementById('pwa-instructions-text');
    
    let deferredPrompt;

    // Helper functions
    function isIOS() {
        return /iPad|iPhone|iPod/.test(navigator.userAgent);
    }

    function isAndroid() {
        return /Android/.test(navigator.userAgent);
    }

    function isStandalone() {
        return window.matchMedia('(display-mode: standalone)').matches || 
               window.navigator.standalone === true;
    }

    function isSafari() {
        return /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
    }

    // Don't show install options if already installed
    if (isStandalone()) {
        console.log('[PWA] App is already installed');
        return;
    }

    // Handle different platforms
    if (isIOS() && isSafari()) {
        // iOS Safari - show manual instructions
        manualInstructions.classList.remove('hidden');
        instructionsText.innerHTML = 'Tap the <strong>Share</strong> button <svg class="inline w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path></svg> then <strong>"Add to Home Screen"</strong>';
    } else if (isAndroid()) {
        // Android - show fallback instructions
        manualInstructions.classList.remove('hidden');
        instructionsText.textContent = 'If no install prompt appears, tap the browser menu and select "Install app" or "Add to Home screen"';
    } else {
        // Desktop - show fallback instructions
        manualInstructions.classList.remove('hidden');
        instructionsText.textContent = 'Look for an install icon in your browser\'s address bar, or check the browser menu for "Install" options';
    }

    // Listen for the beforeinstallprompt event
    window.addEventListener('beforeinstallprompt', function(e) {
        console.log('[PWA] Install prompt available');
        e.preventDefault();
        deferredPrompt = e;
        
        // Show the install button
        installContainer.classList.remove('hidden');
        manualInstructions.classList.add('hidden');
    });

    // Handle install button click
    installBtn.addEventListener('click', async function() {
        if (deferredPrompt) {
            deferredPrompt.prompt();
            const { outcome } = await deferredPrompt.userChoice;
            
            console.log('[PWA] Install prompt outcome:', outcome);
            
            if (outcome === 'accepted') {
                installContainer.classList.add('hidden');
            }
            
            deferredPrompt = null;
        }
    });

    // Listen for successful installation
    window.addEventListener('appinstalled', function() {
        console.log('[PWA] App installed successfully');
        installContainer.classList.add('hidden');
        manualInstructions.classList.add('hidden');
    });
});
</script>