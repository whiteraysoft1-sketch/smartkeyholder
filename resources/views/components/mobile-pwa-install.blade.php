{{-- Mobile-Optimized PWA Install Component --}}
<div id="pwa-install-container" class="fixed bottom-4 left-4 right-4 z-50">
    <!-- Main Install Button -->
    <button id="pwa-install-btn" 
            class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-2xl shadow-2xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center space-x-3 text-lg border-2 border-white/20">
        <span id="pwa-install-icon" class="text-2xl">📱</span>
        <span id="pwa-install-text">Install App</span>
        <span class="animate-pulse">✨</span>
    </button>
    
    <!-- Installation Status -->
    <div id="pwa-install-status" class="hidden mt-3 p-4 bg-green-500 text-white rounded-xl shadow-lg text-center font-semibold">
        <div class="flex items-center justify-center space-x-2">
            <span class="animate-spin">⚙️</span>
            <span>Installing app...</span>
        </div>
    </div>
    
    <!-- Success Message -->
    <div id="pwa-install-success" class="hidden mt-3 p-4 bg-green-600 text-white rounded-xl shadow-lg text-center font-semibold">
        <div class="flex items-center justify-center space-x-2">
            <span>🎉</span>
            <span>App installed successfully!</span>
        </div>
    </div>
</div>

<script>
// Enhanced Mobile PWA Install Manager
class MobilePWAInstaller {
    constructor() {
        this.deferredPrompt = null;
        this.isInstalled = false;
        this.installAttempted = false;
        this.init();
    }

    init() {
        this.checkInstallStatus();
        this.setupEventListeners();
        this.setupUI();
    }

    checkInstallStatus() {
        // Check if PWA is already installed
        this.isInstalled = window.matchMedia('(display-mode: standalone)').matches ||
                          window.navigator.standalone === true ||
                          document.referrer.includes('android-app://');
        
        if (this.isInstalled) {
            this.hideInstallButton();
            return;
        }
    }

    setupEventListeners() {
        // Listen for beforeinstallprompt event
        window.addEventListener('beforeinstallprompt', (e) => {
            console.log('[PWA] Install prompt available');
            e.preventDefault();
            this.deferredPrompt = e;
            this.updateButtonForNativeInstall();
        });

        // Listen for app installed event
        window.addEventListener('appinstalled', () => {
            console.log('[PWA] App installed successfully');
            this.showInstallSuccess();
            setTimeout(() => this.hideInstallButton(), 3000);
        });

        // Install button click handler
        const installBtn = document.getElementById('pwa-install-btn');
        if (installBtn) {
            installBtn.addEventListener('click', () => this.handleInstallClick());
        }
    }

    setupUI() {
        const device = this.getDeviceInfo();
        const installBtn = document.getElementById('pwa-install-btn');
        const installIcon = document.getElementById('pwa-install-icon');
        const installText = document.getElementById('pwa-install-text');
        
        if (!installBtn) return;

        // Set appropriate icon and text based on device
        let icon = '📱';
        let text = 'Install App';
        
        if (device.isIOS) {
            icon = '🍎';
            text = 'Add to Home Screen';
        } else if (device.isAndroid) {
            icon = '🤖';
            text = 'Install App';
        } else {
            icon = '💻';
            text = 'Install App';
        }

        if (installIcon) installIcon.textContent = icon;
        if (installText) installText.textContent = text;

        // Show install button
        this.showInstallButton();
    }

    async handleInstallClick() {
        if (this.installAttempted) return;
        
        const device = this.getDeviceInfo();
        
        if (this.deferredPrompt) {
            // Native install prompt available
            await this.performNativeInstall();
        } else {
            // Fallback for browsers without native prompt
            this.performFallbackInstall(device);
        }
    }

    async performNativeInstall() {
        try {
            this.installAttempted = true;
            this.showInstallStatus();
            
            this.deferredPrompt.prompt();
            const { outcome } = await this.deferredPrompt.userChoice;
            
            console.log(`[PWA] Install outcome: ${outcome}`);
            
            if (outcome === 'accepted') {
                this.showInstallSuccess();
            } else {
                this.hideInstallStatus();
                this.installAttempted = false;
            }
            
            this.deferredPrompt = null;
        } catch (error) {
            console.error('[PWA] Install failed:', error);
            this.hideInstallStatus();
            this.installAttempted = false;
        }
    }

    performFallbackInstall(device) {
        this.installAttempted = true;
        this.showInstallStatus();
        
        // Device-specific instructions
        let message = '';
        
        if (device.isIOS && device.isSafari) {
            message = 'Tap the Share button (□↗) at the bottom, then select "Add to Home Screen"';
        } else if (device.isAndroid) {
            message = 'Tap the menu button (⋮) and select "Install app" or "Add to Home Screen"';
        } else {
            message = 'Look for an install icon in your browser\'s address bar or check the menu for install options';
        }
        
        // Show alert with instructions
        setTimeout(() => {
            alert(message);
            this.hideInstallStatus();
            this.installAttempted = false;
        }, 500);
    }

    updateButtonForNativeInstall() {
        const installBtn = document.getElementById('pwa-install-btn');
        const installText = document.getElementById('pwa-install-text');
        
        if (installBtn && installText) {
            installBtn.className = installBtn.className.replace('from-blue-600 to-purple-600', 'from-green-500 to-blue-500');
            installText.textContent = '⚡ One-Click Install';
        }
    }

    showInstallButton() {
        const container = document.getElementById('pwa-install-container');
        if (container) {
            container.classList.remove('hidden');
            container.style.display = 'block';
        }
    }

    hideInstallButton() {
        const container = document.getElementById('pwa-install-container');
        if (container) {
            container.style.display = 'none';
        }
    }

    showInstallStatus() {
        const status = document.getElementById('pwa-install-status');
        if (status) {
            status.classList.remove('hidden');
        }
    }

    hideInstallStatus() {
        const status = document.getElementById('pwa-install-status');
        if (status) {
            status.classList.add('hidden');
        }
    }

    showInstallSuccess() {
        const success = document.getElementById('pwa-install-success');
        const status = document.getElementById('pwa-install-status');
        
        if (status) status.classList.add('hidden');
        if (success) success.classList.remove('hidden');
    }

    getDeviceInfo() {
        const ua = navigator.userAgent;
        return {
            isIOS: /iPad|iPhone|iPod/.test(ua),
            isAndroid: /Android/.test(ua),
            isSafari: /Safari/.test(ua) && !/Chrome/.test(ua),
            isChrome: /Chrome/.test(ua) && !/Edg/.test(ua),
            isMobile: /iPad|iPhone|iPod|Android/.test(ua)
        };
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new MobilePWAInstaller();
});

// Also initialize if DOM is already loaded
if (document.readyState !== 'loading') {
    new MobilePWAInstaller();
}
</script>