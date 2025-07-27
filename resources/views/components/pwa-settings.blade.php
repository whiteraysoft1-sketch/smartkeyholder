<!-- PWA Settings Component -->
<div x-data="pwaSettings()" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Progressive Web App (PWA)</h3>
                <p class="mt-1 text-sm text-gray-600">Install Smart Tag as an app on your device for the best experience</p>
            </div>
            <div class="flex items-center">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                      :class="isInstalled ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                    <span class="w-2 h-2 rounded-full mr-1.5"
                          :class="isInstalled ? 'bg-green-400' : 'bg-gray-400'"></span>
                    <span x-text="isInstalled ? 'Installed' : 'Not Installed'"></span>
                </span>
            </div>
        </div>

        <!-- Installation Section -->
        <div class="space-y-6">
            <!-- Install Button -->
            <div x-show="!isInstalled" class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="text-2xl" x-text="deviceIcon"></span>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-medium text-gray-900" x-text="installTitle"></h4>
                            <p class="text-sm text-gray-500" x-text="installDescription"></p>
                        </div>
                    </div>
                    <button @click="installApp()" 
                            :disabled="!canInstall && !showManualInstructions"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-text="installButtonText"></span>
                    </button>
                </div>
                
                <!-- Manual Installation Instructions -->
                <div x-show="showManualInstructions" x-transition class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h5 class="text-sm font-medium text-blue-800">Installation Instructions</h5>
                            <div class="mt-2 text-sm text-blue-700" x-html="manualInstructions"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- App Features -->
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-3">App Features</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700">Works offline</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700">Fast loading</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700">Push notifications</span>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-sm text-gray-700">Native app feel</span>
                    </div>
                </div>
            </div>

            <!-- Notifications Settings -->
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-medium text-gray-900">Push Notifications</h4>
                    <button @click="toggleNotifications()" 
                            :class="notificationsEnabled ? 'bg-indigo-600' : 'bg-gray-200'"
                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span :class="notificationsEnabled ? 'translate-x-5' : 'translate-x-0'"
                              class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                    </button>
                </div>
                <p class="text-sm text-gray-500 mb-3">Get notified about important updates and activities</p>
                <div x-show="notificationsEnabled" class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" x-model="notificationSettings.profile_updates" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Profile updates</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" x-model="notificationSettings.qr_scans" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">QR code scans</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" x-model="notificationSettings.system_updates" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">System updates</span>
                    </label>
                </div>
            </div>

            <!-- App Info -->
            <div class="border border-gray-200 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-3">App Information</h4>
                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Version:</span>
                        <span x-text="appVersion"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Cache Status:</span>
                        <span :class="cacheStatus === 'active' ? 'text-green-600' : 'text-gray-600'" x-text="cacheStatus"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Service Worker:</span>
                        <span :class="serviceWorkerStatus === 'active' ? 'text-green-600' : 'text-gray-600'" x-text="serviceWorkerStatus"></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Connection:</span>
                        <span :class="isOnline ? 'text-green-600' : 'text-red-600'" x-text="isOnline ? 'Online' : 'Offline'"></span>
                    </div>
                </div>
                
                <div class="mt-4 flex space-x-2">
                    <button @click="clearCache()" 
                            class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Clear Cache
                    </button>
                    <button @click="checkForUpdates()" 
                            class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Check Updates
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function pwaSettings() {
    return {
        isInstalled: false,
        canInstall: false,
        showManualInstructions: false,
        notificationsEnabled: false,
        deviceIcon: '📱',
        installTitle: 'Install Smart Tag App',
        installDescription: 'Get the best experience with our native app',
        installButtonText: 'Install App',
        manualInstructions: '',
        appVersion: '1.0.0',
        cacheStatus: 'checking...',
        serviceWorkerStatus: 'checking...',
        isOnline: navigator.onLine,
        notificationSettings: {
            profile_updates: true,
            qr_scans: true,
            system_updates: false
        },

        init() {
            this.checkPWAStatus();
            this.setupEventListeners();
            this.loadSettings();
        },

        checkPWAStatus() {
            if (window.pwaManager) {
                const status = window.pwaManager.getInstallationStatus();
                this.isInstalled = status.isInstalled;
                this.canInstall = status.canInstall;
                this.serviceWorkerStatus = status.hasServiceWorker ? 'active' : 'inactive';
                this.cacheStatus = status.hasServiceWorker ? 'active' : 'inactive';
            }

            this.updateDeviceInfo();
            this.checkNotificationPermission();
        },

        updateDeviceInfo() {
            const ua = navigator.userAgent;
            const isIOS = /iPad|iPhone|iPod/.test(ua);
            const isAndroid = /Android/.test(ua);
            const isDesktop = !/Mobi|Android/i.test(ua);
            const isSafari = /Safari/.test(ua) && !/Chrome/.test(ua);

            if (isIOS) {
                this.deviceIcon = '🍎';
                this.installTitle = 'Add to Home Screen';
                this.installDescription = 'Install Smart Tag on your iPhone/iPad';
                this.installButtonText = isSafari ? 'Show Instructions' : 'Install App';
                this.showManualInstructions = isSafari;
                this.manualInstructions = `
                    <ol class="list-decimal list-inside space-y-1">
                        <li>Tap the <strong>Share</strong> button (square with arrow) at the bottom</li>
                        <li>Scroll down and tap <strong>"Add to Home Screen"</strong></li>
                        <li>Tap <strong>"Add"</strong> to confirm</li>
                        <li>Find the Smart Tag app on your home screen</li>
                    </ol>
                `;
            } else if (isAndroid) {
                this.deviceIcon = '🤖';
                this.installTitle = 'Install Android App';
                this.installDescription = 'Install Smart Tag on your Android device';
                this.installButtonText = 'Install App';
            } else if (isDesktop) {
                this.deviceIcon = '💻';
                this.installTitle = 'Install Desktop App';
                this.installDescription = 'Install Smart Tag on your computer';
                this.installButtonText = 'Install App';
                this.manualInstructions = `
                    <ol class="list-decimal list-inside space-y-1">
                        <li>Look for the <strong>install icon</strong> in your browser's address bar</li>
                        <li>Or check the browser menu for <strong>"Install Smart Tag"</strong></li>
                        <li>Click <strong>"Install"</strong> to add to your desktop</li>
                        <li>Launch from your desktop or start menu</li>
                    </ol>
                `;
            }
        },

        setupEventListeners() {
            // Listen for PWA events
            window.addEventListener('pwa-install-available', (event) => {
                this.canInstall = event.detail.canInstall;
            });

            window.addEventListener('pwa-manual-install', (event) => {
                this.showManualInstructions = true;
                this.manualInstructions = event.detail.instructions;
            });

            window.addEventListener('pwa-connection-change', (event) => {
                this.isOnline = event.detail.isOnline;
            });

            // Listen for online/offline events
            window.addEventListener('online', () => {
                this.isOnline = true;
            });

            window.addEventListener('offline', () => {
                this.isOnline = false;
            });
        },

        async installApp() {
            if (window.pwaManager) {
                await window.pwaManager.showInstallPrompt();
            } else {
                this.showManualInstructions = true;
            }
        },

        async toggleNotifications() {
            if (!this.notificationsEnabled) {
                if (window.pwaManager) {
                    const permission = await window.pwaManager.requestNotificationPermission();
                    this.notificationsEnabled = permission === 'granted';
                } else {
                    const permission = await Notification.requestPermission();
                    this.notificationsEnabled = permission === 'granted';
                }
            } else {
                if (window.pwaManager) {
                    await window.pwaManager.unsubscribeFromPush();
                }
                this.notificationsEnabled = false;
            }
            
            this.saveSettings();
        },

        async checkNotificationPermission() {
            if ('Notification' in window) {
                this.notificationsEnabled = Notification.permission === 'granted';
            }
        },

        async clearCache() {
            if ('caches' in window) {
                const cacheNames = await caches.keys();
                await Promise.all(cacheNames.map(name => caches.delete(name)));
                this.cacheStatus = 'cleared';
                
                // Show success message
                this.$dispatch('show-notification', {
                    type: 'success',
                    message: 'Cache cleared successfully'
                });
                
                setTimeout(() => {
                    this.cacheStatus = 'active';
                }, 2000);
            }
        },

        async checkForUpdates() {
            if ('serviceWorker' in navigator && navigator.serviceWorker.controller) {
                navigator.serviceWorker.controller.postMessage({ type: 'CHECK_FOR_UPDATES' });
                
                this.$dispatch('show-notification', {
                    type: 'info',
                    message: 'Checking for updates...'
                });
            }
        },

        loadSettings() {
            const saved = localStorage.getItem('pwa-settings');
            if (saved) {
                const settings = JSON.parse(saved);
                this.notificationSettings = { ...this.notificationSettings, ...settings.notifications };
            }
        },

        saveSettings() {
            const settings = {
                notifications: this.notificationSettings,
                notificationsEnabled: this.notificationsEnabled
            };
            localStorage.setItem('pwa-settings', JSON.stringify(settings));
        }
    }
}
</script>