import './bootstrap';
import './pwa';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// PWA specific Alpine.js data
document.addEventListener('alpine:init', () => {
    Alpine.data('pwaInstaller', () => ({
        canInstall: false,
        isInstalled: false,
        isOffline: !navigator.onLine,
        
        init() {
            this.checkInstallStatus();
            this.setupEventListeners();
        },
        
        checkInstallStatus() {
            this.isInstalled = window.matchMedia('(display-mode: standalone)').matches ||
                              window.navigator.standalone === true ||
                              document.referrer.includes('android-app://');
        },
        
        setupEventListeners() {
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                this.canInstall = true;
                window.deferredPrompt = e;
            });
            
            window.addEventListener('appinstalled', () => {
                this.isInstalled = true;
                this.canInstall = false;
            });
            
            window.addEventListener('online', () => {
                this.isOffline = false;
            });
            
            window.addEventListener('offline', () => {
                this.isOffline = true;
            });
        },
        
        async install() {
            if (window.deferredPrompt) {
                window.deferredPrompt.prompt();
                const { outcome } = await window.deferredPrompt.userChoice;
                
                if (outcome === 'accepted') {
                    this.canInstall = false;
                }
                
                window.deferredPrompt = null;
            }
        }
    }));
    
    Alpine.data('notificationManager', () => ({
        permission: 'default',
        
        init() {
            if ('Notification' in window) {
                this.permission = Notification.permission;
            }
        },
        
        async requestPermission() {
            if ('Notification' in window) {
                const permission = await Notification.requestPermission();
                this.permission = permission;
                
                if (permission === 'granted' && window.pwaManager) {
                    await window.pwaManager.subscribeToPush();
                }
                
                return permission === 'granted';
            }
            return false;
        }
    }));
});
