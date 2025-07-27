{{-- Enhanced Universal PWA Meta Tags Component --}}
{{-- Following universal-pwa-support.md guidelines --}}

{{-- Enhanced PWA Meta Tags for Universal Support --}}
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="{{ $title ?? 'Smart Tag' }}">
<meta name="application-name" content="{{ $title ?? 'Smart Tag' }}">

{{-- Theme Colors for Light/Dark Mode --}}
<meta name="theme-color" content="{{ $themeColor ?? '#4F46E5' }}" media="(prefers-color-scheme: light)">
<meta name="theme-color" content="{{ $themeColorDark ?? '#3730A3' }}" media="(prefers-color-scheme: dark)">
<meta name="msapplication-navbutton-color" content="{{ $themeColor ?? '#4F46E5' }}">
<meta name="apple-mobile-web-app-status-bar-style" content="default">

{{-- PWA Manifest --}}
<link rel="manifest" href="{{ $manifestUrl ?? '/manifest.json' }}">

{{-- Comprehensive Apple Touch Icons --}}
<link rel="apple-touch-icon" href="{{ $iconPath ?? '/images/pwa-icon-180.png' }}">
<link rel="apple-touch-icon" sizes="57x57" href="{{ $iconPath ?? '/images/pwa-icon-57.png' }}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ $iconPath ?? '/images/pwa-icon-60.png' }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ $iconPath ?? '/images/pwa-icon-72.png' }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ $iconPath ?? '/images/pwa-icon-76.png' }}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ $iconPath ?? '/images/pwa-icon-114.png' }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ $iconPath ?? '/images/pwa-icon-120.png' }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ $iconPath ?? '/images/pwa-icon-144.png' }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ $iconPath ?? '/images/pwa-icon-152.png' }}">
<link rel="apple-touch-icon" sizes="167x167" href="{{ $iconPath ?? '/images/pwa-icon-167.png' }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ $iconPath ?? '/images/pwa-icon-180.png' }}">

{{-- Microsoft Tiles --}}
<meta name="msapplication-TileImage" content="{{ $iconPath ?? '/images/pwa-icon-144.png' }}">
<meta name="msapplication-TileColor" content="{{ $themeColor ?? '#4F46E5' }}">
<meta name="msapplication-square70x70logo" content="{{ $iconPath ?? '/images/pwa-icon-70.png' }}">
<meta name="msapplication-square150x150logo" content="{{ $iconPath ?? '/images/pwa-icon-150.png' }}">
<meta name="msapplication-wide310x150logo" content="{{ $iconPath ?? '/images/pwa-icon-310x150.png' }}">
<meta name="msapplication-square310x310logo" content="{{ $iconPath ?? '/images/pwa-icon-310.png' }}">

{{-- Samsung Internet --}}
<meta name="mobile-web-app-capable" content="yes">
<meta name="mobile-web-app-status-bar-style" content="black-translucent">

{{-- Standard Favicon --}}
<link rel="icon" type="image/png" sizes="32x32" href="{{ $iconPath ?? '/images/pwa-icon-32.png' }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ $iconPath ?? '/images/pwa-icon-16.png' }}">
<link rel="shortcut icon" href="{{ $iconPath ?? '/images/pwa-icon-32.png' }}">

{{-- Enhanced Universal PWA Service Worker & Install Logic --}}
<style>
@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

@keyframes glow {
    0%, 100% {
        box-shadow: 0 0 5px rgba(16, 185, 129, 0.5);
    }
    50% {
        box-shadow: 0 0 20px rgba(16, 185, 129, 0.8), 0 0 30px rgba(16, 185, 129, 0.6);
    }
}

.pwa-install-ready {
    animation: glow 2s infinite;
}
</style>

<script>
// Enhanced Mobile PWA Support with One-Click Install
console.log('Enhanced Mobile PWA support initialized');

// Service Worker Registration with Enhanced Error Handling
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('{{ $serviceWorkerUrl ?? '/sw.js' }}', {
            scope: '{{ $scope ?? '/' }}'
        }).then(function(registration) {
            console.log('[PWA] Service Worker registered successfully:', registration.scope);
            
            // Check for updates
            registration.addEventListener('updatefound', function() {
                const newWorker = registration.installing;
                newWorker.addEventListener('statechange', function() {
                    if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                        // New content is available, show update notification
                        showUpdateNotification(newWorker);
                    }
                });
            });
        }).catch(function(error) {
            console.error('[PWA] Service Worker registration failed:', error);
        });
        
        // Listen for service worker messages
        navigator.serviceWorker.addEventListener('message', function(event) {
            if (event.data && event.data.type === 'SW_UPDATED') {
                window.location.reload();
            }
        });
    });
}

function showUpdateNotification(newWorker) {
    // Create a more user-friendly update notification
    const updateDiv = document.createElement('div');
    updateDiv.className = 'fixed top-4 left-4 right-4 bg-blue-500 text-white p-4 rounded-lg shadow-lg z-50 flex items-center justify-between';
    updateDiv.innerHTML = `
        <div class="flex items-center">
            <span class="mr-2">🔄</span>
            <span>New version available!</span>
        </div>
        <div class="space-x-2">
            <button onclick="updateApp()" class="bg-white text-blue-500 px-3 py-1 rounded font-semibold">Update</button>
            <button onclick="this.parentElement.parentElement.remove()" class="border border-white px-3 py-1 rounded">Later</button>
        </div>
    `;
    document.body.appendChild(updateDiv);
    
    window.updateApp = function() {
        newWorker.postMessage({ type: 'SKIP_WAITING' });
        window.location.reload();
    };
}

// Universal PWA Install Logic
let deferredPrompt;

// Device and Browser Detection
function getDeviceInfo() {
    const ua = navigator.userAgent;
    const isIOS = /iPad|iPhone|iPod/.test(ua);
    const isAndroid = /Android/.test(ua);
    const isWindows = /Windows/.test(ua);
    const isMac = /Mac/.test(ua);
    
    const isChrome = /Chrome/.test(ua) && !/Edg/.test(ua);
    const isEdge = /Edg/.test(ua);
    const isSafari = /Safari/.test(ua) && !/Chrome/.test(ua);
    const isFirefox = /Firefox/.test(ua);
    const isSamsung = /SamsungBrowser/.test(ua);
    const isOpera = /OPR/.test(ua);
    
    return {
        isIOS, isAndroid, isWindows, isMac,
        isChrome, isEdge, isSafari, isFirefox, isSamsung, isOpera,
        isMobile: isIOS || isAndroid,
        isDesktop: isWindows || isMac
    };
}

function isStandalone() {
    return window.matchMedia('(display-mode: standalone)').matches || 
           window.navigator.standalone === true;
}

// Simplified Mobile-First Install Button Setup
function setupUniversalInstallButton() {
    const installBtn = document.getElementById('pwa-install-btn');
    const installIcon = document.getElementById('pwa-install-icon');
    const installText = document.getElementById('pwa-install-text');
    
    if (!installBtn) return;
    
    const device = getDeviceInfo();
    let icon = '📱';
    let buttonText = 'Install App';

    // Set appropriate icon and text for mobile-first approach
    if (device.isMobile) {
        icon = device.isIOS ? '🍎' : '🤖';
        buttonText = device.isIOS ? 'Add to Home Screen' : 'Install App';
    } else {
        icon = '💻';
        buttonText = 'Install App';
    }

    if (installIcon) installIcon.textContent = icon;
    if (installText) installText.textContent = buttonText;

    console.log(`Mobile PWA install ready for: ${device.isIOS ? 'iOS' : device.isAndroid ? 'Android' : 'Desktop'}`);

    // Don't show anything if already installed
    if (isStandalone()) {
        installBtn.style.display = 'none';
        console.log('[PWA] App already installed');
        return;
    }

    // Show install button
    installBtn.style.display = 'inline-flex';
    return { installBtn, device };
}

function showManualInstructions(device, titleEl, textEl, containerEl) {
    let title = 'Install Smart Tag App';
    let instructions = '';

    if (device.isIOS && device.isSafari) {
        title = '📱 Add to Home Screen';
        instructions = `
            1. Tap the <strong>Share</strong> button (square with arrow) at the bottom<br>
            2. Scroll down and tap <strong>"Add to Home Screen"</strong><br>
            3. Tap <strong>"Add"</strong> to confirm<br>
            4. Find the Smart Tag app on your home screen
        `;
    } else if (device.isIOS && device.isChrome) {
        title = '📱 Install from Chrome';
        instructions = `
            1. Tap the <strong>three dots menu</strong> (⋮) in the top right<br>
            2. Tap <strong>"Add to Home Screen"</strong><br>
            3. Tap <strong>"Add"</strong> to confirm<br>
            4. Find the Smart Tag app on your home screen
        `;
    } else if (device.isAndroid && device.isFirefox) {
        title = '🤖 Install from Firefox';
        instructions = `
            1. Tap the <strong>three dots menu</strong> (⋮) in the top right<br>
            2. Tap <strong>"Install"</strong> or <strong>"Add to Home Screen"</strong><br>
            3. Tap <strong>"Add"</strong> to confirm<br>
            4. Find the Smart Tag app on your home screen
        `;
    } else if (device.isDesktop && device.isFirefox) {
        title = '💻 Install from Firefox';
        instructions = `
            1. Click the <strong>three lines menu</strong> (☰) in the top right<br>
            2. Look for <strong>"Install Smart Tag"</strong> option<br>
            3. Or bookmark this page for quick access<br>
            4. You can also create a desktop shortcut
        `;
    } else if (device.isDesktop) {
        title = '💻 Install Desktop App';
        instructions = `
            1. Look for the <strong>install icon</strong> in your browser's address bar<br>
            2. Or check the browser menu for <strong>"Install Smart Tag"</strong><br>
            3. Click <strong>"Install"</strong> to add to your desktop<br>
            4. Launch from your desktop or start menu
        `;
    } else {
        title = '📱 Install App';
        instructions = `
            1. Look for an <strong>install option</strong> in your browser menu<br>
            2. Or check for an <strong>install icon</strong> in the address bar<br>
            3. Follow your browser's installation prompts<br>
            4. Add Smart Tag to your home screen or desktop
        `;
    }

    titleEl.textContent = title;
    textEl.innerHTML = instructions;
    containerEl.classList.remove('hidden');
}

// Handle native install prompt (Chrome, Edge, Samsung Internet)
window.addEventListener('beforeinstallprompt', function(e) {
    console.log('[PWA] One-click install available!');
    e.preventDefault();
    deferredPrompt = e;
    
    // Update button to show one-click install is ready
    const installBtn = document.getElementById('pwa-install-btn');
    const installText = document.getElementById('pwa-install-text');
    
    if (installBtn) {
        installBtn.style.background = 'linear-gradient(135deg, #10B981, #059669)';
        installBtn.classList.add('pwa-install-ready');
    }
    
    if (installText) {
        installText.textContent = '⚡ One-Click Install';
    }
    
    console.log('[PWA] One-click install ready!');
});

// Simplified Install Button Click Handler
function handleInstallClick() {
    const installBtn = document.getElementById('pwa-install-btn');
    
    if (!installBtn) return;
    
    installBtn.addEventListener('click', async function() {
        const device = getDeviceInfo();
        
        if (deferredPrompt) {
            // Native install prompt available - ONE CLICK INSTALL
            console.log('[PWA] One-click install triggered');
            try {
                // Update button state
                installBtn.style.background = 'linear-gradient(135deg, #F59E0B, #D97706)';
                installBtn.textContent = 'Installing...';
                installBtn.disabled = true;
                
                deferredPrompt.prompt();
                const { outcome } = await deferredPrompt.userChoice;
                console.log(`[PWA] Install outcome: ${outcome}`);
                
                if (outcome === 'accepted') {
                    installBtn.textContent = '✅ Installing...';
                    setTimeout(() => {
                        installBtn.style.display = 'none';
                    }, 2000);
                } else {
                    // Reset button
                    installBtn.style.background = '';
                    installBtn.textContent = installBtn.querySelector('#pwa-install-text')?.textContent || 'Install App';
                    installBtn.disabled = false;
                }
            } catch (error) {
                console.error('[PWA] Install error:', error);
                // Reset button
                installBtn.style.background = '';
                installBtn.textContent = installBtn.querySelector('#pwa-install-text')?.textContent || 'Install App';
                installBtn.disabled = false;
            }
            deferredPrompt = null;
        } else {
            // Fallback - show device-specific instructions
            console.log('[PWA] Showing fallback instructions');
            let message = '';
            
            if (device.isIOS && device.isSafari) {
                message = 'Tap the Share button (□↗) at the bottom, then select "Add to Home Screen"';
            } else if (device.isAndroid) {
                message = 'Tap the menu button (⋮) and select "Install app" or "Add to Home Screen"';
            } else {
                message = 'Look for an install icon in your browser\'s address bar or check the menu for install options';
            }
            
            alert(message);
        }
    });
}

// Handle successful installation
window.addEventListener('appinstalled', function() {
    console.log('[PWA] App installed successfully');
    const installBtn = document.getElementById('pwa-install-btn');
    const manualInstructions = document.getElementById('pwa-manual-instructions');
    
    if (installBtn) installBtn.style.display = 'none';
    if (manualInstructions) manualInstructions.classList.add('hidden');
});

// Initialize Universal PWA Install when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    setupUniversalInstallButton();
    handleInstallClick();
});

// Also initialize if DOM is already loaded
if (document.readyState !== 'loading') {
    setupUniversalInstallButton();
    handleInstallClick();
}
</script>