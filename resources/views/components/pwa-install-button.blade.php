<!-- PWA Install Button Component for VCards -->
<div x-data="pwaInstallButton()" x-show="shouldShow" x-transition class="pwa-install-container">
    <!-- Floating Install Button -->
    <button @click="handleInstall()" 
            class="pwa-install-btn"
            :class="buttonClass"
            :title="buttonTitle">
        <span class="pwa-install-icon" x-html="buttonIcon"></span>
        <span class="pwa-install-text" x-text="buttonText"></span>
    </button>

    <!-- Install Modal -->
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         @click.away="showModal = false">
        
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <span class="text-2xl" x-text="deviceIcon"></span>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" x-text="modalTitle"></h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" x-text="modalDescription"></p>
                        </div>
                        
                        <!-- Manual Instructions -->
                        <div x-show="showInstructions" class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-md">
                            <div class="text-sm text-blue-700" x-html="installInstructions"></div>
                        </div>
                        
                        <!-- App Features -->
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Why install this app?</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li class="flex items-center">
                                    <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Quick access to profile
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Works offline
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Native app experience
                                </li>
                                <li class="flex items-center">
                                    <svg class="h-4 w-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Fast loading
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button @click="performInstall()" 
                            x-show="canInstallNatively"
                            type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Install Now
                    </button>
                    <button @click="showModal = false" 
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        <span x-text="canInstallNatively ? 'Cancel' : 'Close'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.pwa-install-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
}

.pwa-install-btn {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    background: linear-gradient(135deg, #4F46E5, #7C3AED);
    color: white;
    border: none;
    border-radius: 50px;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
    font-weight: 500;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.pwa-install-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
    background: linear-gradient(135deg, #4338CA, #6D28D9);
}

.pwa-install-btn:active {
    transform: translateY(0);
}

.pwa-install-icon {
    margin-right: 8px;
    font-size: 16px;
}

.pwa-install-text {
    white-space: nowrap;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .pwa-install-container {
        bottom: 15px;
        right: 15px;
    }
    
    .pwa-install-btn {
        padding: 10px 16px;
        font-size: 13px;
    }
    
    .pwa-install-text {
        display: none;
    }
    
    .pwa-install-icon {
        margin-right: 0;
        font-size: 18px;
    }
}

/* Hide on very small screens or when keyboard is open */
@media (max-height: 500px) {
    .pwa-install-container {
        display: none;
    }
}

/* Animation for entrance */
@keyframes slideInUp {
    from {
        transform: translateY(100px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.pwa-install-btn {
    animation: slideInUp 0.5s ease-out;
}
</style>

<script>
function pwaInstallButton() {
    return {
        shouldShow: false,
        showModal: false,
        showInstructions: false,
        canInstallNatively: false,
        isInstalled: false,
        deferredPrompt: null,
        
        // UI State
        deviceIcon: '📱',
        buttonIcon: '📱',
        buttonText: 'Install App',
        buttonTitle: 'Install Smart Tag App',
        buttonClass: '',
        modalTitle: 'Install Smart Tag App',
        modalDescription: 'Get the best experience by installing our app on your device.',
        installInstructions: '',

        init() {
            this.checkInstallStatus();
            this.setupEventListeners();
            this.updateDeviceInfo();
            
            // Show button after a delay if not installed
            setTimeout(() => {
                if (!this.isInstalled) {
                    this.shouldShow = true;
                }
            }, 3000);
        },

        checkInstallStatus() {
            // Check if already installed
            this.isInstalled = window.matchMedia('(display-mode: standalone)').matches || 
                             window.navigator.standalone === true;
            
            if (this.isInstalled) {
                this.shouldShow = false;
                return;
            }

            // Check if PWA manager is available
            if (window.pwaManager) {
                const status = window.pwaManager.getInstallationStatus();
                this.canInstallNatively = status.canInstall;
                this.isInstalled = status.isInstalled;
            }
        },

        setupEventListeners() {
            // Listen for install prompt
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                this.deferredPrompt = e;
                this.canInstallNatively = true;
                this.shouldShow = !this.isInstalled;
            });

            // Listen for app installed
            window.addEventListener('appinstalled', () => {
                this.isInstalled = true;
                this.shouldShow = false;
                this.showModal = false;
                this.deferredPrompt = null;
            });

            // Listen for PWA events
            window.addEventListener('pwa-install-available', (event) => {
                this.canInstallNatively = event.detail.canInstall;
                this.shouldShow = !this.isInstalled && event.detail.canInstall;
            });

            // Hide button when scrolling (mobile UX)
            let scrollTimeout;
            window.addEventListener('scroll', () => {
                if (window.innerWidth <= 640) {
                    this.shouldShow = false;
                    clearTimeout(scrollTimeout);
                    scrollTimeout = setTimeout(() => {
                        if (!this.isInstalled) {
                            this.shouldShow = true;
                        }
                    }, 1000);
                }
            });
        },

        updateDeviceInfo() {
            const ua = navigator.userAgent;
            const isIOS = /iPad|iPhone|iPod/.test(ua);
            const isAndroid = /Android/.test(ua);
            const isDesktop = !/Mobi|Android/i.test(ua);
            const isSafari = /Safari/.test(ua) && !/Chrome/.test(ua);
            const isChrome = /Chrome/.test(ua) && !/Edg/.test(ua);

            if (isIOS) {
                this.deviceIcon = '🍎';
                this.buttonIcon = '🍎';
                this.modalTitle = 'Add to Home Screen';
                this.modalDescription = 'Install Smart Tag on your iPhone or iPad for quick access.';
                
                if (isSafari) {
                    this.buttonText = 'Add to Home';
                    this.showInstructions = true;
                    this.installInstructions = `
                        <ol class="list-decimal list-inside space-y-2">
                            <li>Tap the <strong>Share</strong> button <svg class="inline w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"></path></svg> at the bottom</li>
                            <li>Scroll down and tap <strong>"Add to Home Screen"</strong></li>
                            <li>Tap <strong>"Add"</strong> to confirm</li>
                            <li>Find Smart Tag on your home screen</li>
                        </ol>
                    `;
                } else {
                    this.buttonText = 'Install App';
                    this.showInstructions = true;
                    this.installInstructions = `
                        <ol class="list-decimal list-inside space-y-2">
                            <li>Tap the <strong>three dots menu</strong> (⋮) in Chrome</li>
                            <li>Tap <strong>"Add to Home Screen"</strong></li>
                            <li>Tap <strong>"Add"</strong> to confirm</li>
                            <li>Find Smart Tag on your home screen</li>
                        </ol>
                    `;
                }
            } else if (isAndroid) {
                this.deviceIcon = '🤖';
                this.buttonIcon = '🤖';
                this.modalTitle = 'Install Android App';
                this.modalDescription = 'Install Smart Tag on your Android device for the best experience.';
                this.buttonText = 'Install App';
                
                if (!isChrome) {
                    this.showInstructions = true;
                    this.installInstructions = `
                        <ol class="list-decimal list-inside space-y-2">
                            <li>Tap the <strong>menu button</strong> in your browser</li>
                            <li>Look for <strong>"Add to Home Screen"</strong> or <strong>"Install"</strong></li>
                            <li>Tap <strong>"Add"</strong> or <strong>"Install"</strong> to confirm</li>
                            <li>Find Smart Tag on your home screen</li>
                        </ol>
                    `;
                }
            } else if (isDesktop) {
                this.deviceIcon = '💻';
                this.buttonIcon = '💻';
                this.modalTitle = 'Install Desktop App';
                this.modalDescription = 'Install Smart Tag on your computer for quick access and offline use.';
                this.buttonText = 'Install App';
                
                if (!isChrome) {
                    this.showInstructions = true;
                    this.installInstructions = `
                        <ol class="list-decimal list-inside space-y-2">
                            <li>Look for the <strong>install icon</strong> in your browser's address bar</li>
                            <li>Or check the browser menu for <strong>"Install Smart Tag"</strong></li>
                            <li>Click <strong>"Install"</strong> to add to your desktop</li>
                            <li>Launch from your desktop or start menu</li>
                        </ol>
                    `;
                }
            }

            // Update button title
            this.buttonTitle = `${this.modalTitle} - ${this.modalDescription}`;
        },

        handleInstall() {
            if (this.canInstallNatively && this.deferredPrompt) {
                this.performInstall();
            } else {
                this.showModal = true;
            }
        },

        async performInstall() {
            if (this.deferredPrompt) {
                try {
                    this.deferredPrompt.prompt();
                    const { outcome } = await this.deferredPrompt.userChoice;
                    
                    if (outcome === 'accepted') {
                        this.shouldShow = false;
                        this.showModal = false;
                    }
                    
                    this.deferredPrompt = null;
                } catch (error) {
                    console.error('Install prompt error:', error);
                }
            } else if (window.pwaManager) {
                await window.pwaManager.showInstallPrompt();
            }
        }
    }
}
</script>