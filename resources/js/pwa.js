// Smart Tag PWA Manager
class PWAManager {
    constructor() {
        this.deferredPrompt = null;
        this.isInstalled = false;
        this.swRegistration = null;
        this.pushSubscription = null;
        
        this.init();
    }
    
    async init() {
        console.log('[PWA] Initializing PWA Manager');
        
        // Check if already installed
        this.isInstalled = this.checkIfInstalled();
        
        // Register service worker
        await this.registerServiceWorker();
        
        // Setup install prompt handling
        this.setupInstallPrompt();
        
        // Setup push notifications
        this.setupPushNotifications();
        
        // Setup connection monitoring
        this.setupConnectionMonitoring();
        
        // Setup app shortcuts
        this.setupAppShortcuts();
        
        console.log('[PWA] PWA Manager initialized');
    }
    
    checkIfInstalled() {
        // Check if running in standalone mode
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || 
                           window.navigator.standalone === true;
        
        // Check for PWA display mode
        const isPWA = window.matchMedia('(display-mode: standalone)').matches ||
                     window.matchMedia('(display-mode: fullscreen)').matches ||
                     window.matchMedia('(display-mode: minimal-ui)').matches;
        
        return isStandalone || isPWA;
    }
    
    async registerServiceWorker() {
        if ('serviceWorker' in navigator) {
            try {
                this.swRegistration = await navigator.serviceWorker.register('/sw.js', {
                    scope: '/'
                });
                
                console.log('[PWA] Service Worker registered:', this.swRegistration.scope);
                
                // Handle service worker updates
                this.swRegistration.addEventListener('updatefound', () => {
                    const newWorker = this.swRegistration.installing;
                    newWorker.addEventListener('statechange', () => {
                        if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                            this.showUpdateAvailable();
                        }
                    });
                });
                
                // Listen for messages from service worker
                navigator.serviceWorker.addEventListener('message', this.handleSWMessage.bind(this));
                
            } catch (error) {
                console.error('[PWA] Service Worker registration failed:', error);
            }
        }
    }
    
    setupInstallPrompt() {
        // Listen for install prompt
        window.addEventListener('beforeinstallprompt', (e) => {
            console.log('[PWA] Install prompt triggered');
            e.preventDefault();
            this.deferredPrompt = e;
            this.showInstallButton();
        });
        
        // Listen for app installed
        window.addEventListener('appinstalled', () => {
            console.log('[PWA] App installed');
            this.isInstalled = true;
            this.hideInstallButton();
            this.deferredPrompt = null;
        });
    }
    
    async showInstallPrompt() {
        if (this.deferredPrompt) {
            try {
                this.deferredPrompt.prompt();
                const { outcome } = await this.deferredPrompt.userChoice;
                console.log(`[PWA] Install outcome: ${outcome}`);
                
                if (outcome === 'accepted') {
                    this.hideInstallButton();
                }
                
                this.deferredPrompt = null;
            } catch (error) {
                console.error('[PWA] Install prompt error:', error);
            }
        } else {
            // Show manual install instructions
            this.showManualInstallInstructions();
        }
    }
    
    showInstallButton() {
        // Dispatch custom event for install button
        window.dispatchEvent(new CustomEvent('pwa-install-available', {
            detail: { canInstall: true }
        }));
    }
    
    hideInstallButton() {
        // Dispatch custom event to hide install button
        window.dispatchEvent(new CustomEvent('pwa-install-available', {
            detail: { canInstall: false }
        }));
    }
    
    showManualInstallInstructions() {
        const device = this.getDeviceInfo();
        let instructions = '';
        
        if (device.isIOS && device.isSafari) {
            instructions = 'Tap the Share button and select "Add to Home Screen"';
        } else if (device.isAndroid) {
            instructions = 'Tap the menu button and select "Add to Home Screen" or "Install App"';
        } else if (device.isDesktop) {
            instructions = 'Look for the install icon in your browser\'s address bar';
        } else {
            instructions = 'Check your browser menu for install options';
        }
        
        // Dispatch custom event with instructions
        window.dispatchEvent(new CustomEvent('pwa-manual-install', {
            detail: { instructions, device }
        }));
    }
    
    getDeviceInfo() {
        const ua = navigator.userAgent;
        return {
            isIOS: /iPad|iPhone|iPod/.test(ua),
            isAndroid: /Android/.test(ua),
            isDesktop: !/Mobi|Android/i.test(ua),
            isSafari: /Safari/.test(ua) && !/Chrome/.test(ua),
            isChrome: /Chrome/.test(ua) && !/Edg/.test(ua),
            isEdge: /Edg/.test(ua),
            isFirefox: /Firefox/.test(ua)
        };
    }
    
    async setupPushNotifications() {
        if ('Notification' in window && 'serviceWorker' in navigator && 'PushManager' in window) {
            try {
                // Check current permission
                const permission = await Notification.requestPermission();
                console.log('[PWA] Notification permission:', permission);
                
                if (permission === 'granted' && this.swRegistration) {
                    await this.subscribeToPush();
                }
            } catch (error) {
                console.error('[PWA] Push notification setup failed:', error);
            }
        }
    }
    
    async subscribeToPush() {
        try {
            const subscription = await this.swRegistration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: this.urlBase64ToUint8Array(this.getVapidPublicKey())
            });
            
            this.pushSubscription = subscription;
            console.log('[PWA] Push subscription created');
            
            // Send subscription to server
            await this.sendSubscriptionToServer(subscription);
            
        } catch (error) {
            console.error('[PWA] Push subscription failed:', error);
        }
    }
    
    getVapidPublicKey() {
        // Replace with your actual VAPID public key
        return 'BEl62iUYgUivxIkv69yViEuiBIa40HI0DLLuxazjqAKVXTJtkKGlXCB3z3UlQpuLqMwLBNiQHzQVHSQqMG5Ck2I';
    }
    
    urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/-/g, '+')
            .replace(/_/g, '/');
        
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }
    
    async sendSubscriptionToServer(subscription) {
        try {
            const response = await fetch('/api/push-subscription', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                },
                body: JSON.stringify({
                    subscription: subscription.toJSON()
                })
            });
            
            if (response.ok) {
                console.log('[PWA] Subscription sent to server');
            }
        } catch (error) {
            console.error('[PWA] Failed to send subscription to server:', error);
        }
    }
    
    setupConnectionMonitoring() {
        window.addEventListener('online', () => {
            console.log('[PWA] Connection restored');
            this.handleConnectionChange(true);
        });
        
        window.addEventListener('offline', () => {
            console.log('[PWA] Connection lost');
            this.handleConnectionChange(false);
        });
    }
    
    handleConnectionChange(isOnline) {
        // Dispatch custom event for connection changes
        window.dispatchEvent(new CustomEvent('pwa-connection-change', {
            detail: { isOnline }
        }));
        
        // Show/hide offline indicator
        if (!isOnline) {
            this.showOfflineIndicator();
        } else {
            this.hideOfflineIndicator();
        }
    }
    
    showOfflineIndicator() {
        // Create or show offline indicator
        let indicator = document.getElementById('pwa-offline-indicator');
        if (!indicator) {
            indicator = document.createElement('div');
            indicator.id = 'pwa-offline-indicator';
            indicator.innerHTML = `
                <div style="
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    background: #EF4444;
                    color: white;
                    text-align: center;
                    padding: 0.5rem;
                    font-size: 0.9rem;
                    z-index: 9999;
                    transform: translateY(-100%);
                    transition: transform 0.3s ease;
                ">
                    📡 You're offline - Some features may be limited
                </div>
            `;
            document.body.appendChild(indicator);
        }
        
        // Animate in
        setTimeout(() => {
            indicator.firstElementChild.style.transform = 'translateY(0)';
        }, 100);
    }
    
    hideOfflineIndicator() {
        const indicator = document.getElementById('pwa-offline-indicator');
        if (indicator) {
            indicator.firstElementChild.style.transform = 'translateY(-100%)';
            setTimeout(() => {
                indicator.remove();
            }, 300);
        }
    }
    
    setupAppShortcuts() {
        // Handle app shortcuts if supported
        if ('navigator' in window && 'shortcuts' in navigator) {
            console.log('[PWA] App shortcuts supported');
        }
    }
    
    handleSWMessage(event) {
        const { data } = event;
        
        if (data.type === 'BACKGROUND_SYNC') {
            console.log('[PWA] Background sync completed');
        }
        
        if (data.type === 'PUSH_RECEIVED') {
            console.log('[PWA] Push notification received');
        }
    }
    
    showUpdateAvailable() {
        // Show update notification
        const updateBanner = document.createElement('div');
        updateBanner.innerHTML = `
            <div style="
                position: fixed;
                bottom: 1rem;
                left: 1rem;
                right: 1rem;
                background: #4F46E5;
                color: white;
                padding: 1rem;
                border-radius: 0.5rem;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: space-between;
            ">
                <span>🔄 App update available</span>
                <button onclick="this.parentElement.parentElement.remove(); window.location.reload();" 
                        style="background: rgba(255,255,255,0.2); border: none; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem; cursor: pointer;">
                    Update
                </button>
            </div>
        `;
        document.body.appendChild(updateBanner);
        
        // Auto-remove after 10 seconds
        setTimeout(() => {
            if (updateBanner.parentElement) {
                updateBanner.remove();
            }
        }, 10000);
    }
    
    // Public methods for external use
    async requestNotificationPermission() {
        if ('Notification' in window) {
            const permission = await Notification.requestPermission();
            if (permission === 'granted' && this.swRegistration) {
                await this.subscribeToPush();
            }
            return permission;
        }
        return 'denied';
    }
    
    async unsubscribeFromPush() {
        if (this.pushSubscription) {
            try {
                await this.pushSubscription.unsubscribe();
                this.pushSubscription = null;
                console.log('[PWA] Unsubscribed from push notifications');
            } catch (error) {
                console.error('[PWA] Failed to unsubscribe:', error);
            }
        }
    }
    
    getInstallationStatus() {
        return {
            isInstalled: this.isInstalled,
            canInstall: !!this.deferredPrompt,
            hasServiceWorker: !!this.swRegistration,
            hasPushSubscription: !!this.pushSubscription
        };
    }
}

// Initialize PWA Manager
const pwaManager = new PWAManager();

// Make it globally available
window.pwaManager = pwaManager;

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = PWAManager;
}

console.log('[PWA] PWA module loaded');