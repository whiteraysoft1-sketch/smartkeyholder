<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error - Smart KeyHolder</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            min-height: 100vh;
        }
        
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }
        
        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(180deg); }
        }
        
        .slide-in {
            animation: slideInUp 1s ease-out;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
    </style>
</head>
<body class="gradient-bg relative">
    <!-- Floating Background Elements -->
    <div class="floating-elements">
        <div class="floating-element w-32 h-32 top-20 left-10" style="animation-delay: 0s;"></div>
        <div class="floating-element w-48 h-48 top-40 right-20" style="animation-delay: 2s;"></div>
        <div class="floating-element w-24 h-24 bottom-40 left-20" style="animation-delay: 4s;"></div>
        <div class="floating-element w-36 h-36 bottom-20 right-10" style="animation-delay: 1s;"></div>
    </div>

    <div class="container mx-auto px-4 py-8 relative z-10 flex items-center justify-center min-h-screen">
        <div class="max-w-2xl w-full text-center slide-in">
            <!-- Error Icon -->
            <div class="mb-8">
                <div class="w-32 h-32 bg-gradient-to-r from-red-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 pulse">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Error Message -->
            <div class="glass-card rounded-3xl p-8 mb-8">
                <h1 class="text-6xl font-bold text-white mb-4">500</h1>
                <h2 class="text-3xl font-bold text-white mb-4">Server Error</h2>
                <p class="text-xl text-white/80 mb-6 leading-relaxed">
                    Oops! Something went wrong on our end. Our team has been notified and is working to fix this issue.
                    Please try again in a few moments.
                </p>
                
                <!-- Action Buttons -->
                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button onclick="window.location.reload()" class="bg-white text-gray-800 px-8 py-3 rounded-2xl font-bold hover:shadow-xl transition transform hover:scale-105">
                            🔄 Try Again
                        </button>
                        <a href="{{ route('home') }}" class="glass-card text-white px-8 py-3 rounded-2xl font-bold hover:bg-white/30 transition">
                            🏠 Go Home
                        </a>
                    </div>
                    
                    @auth
                        <div>
                            <a href="{{ route('dashboard') }}" class="text-white/80 hover:text-white underline">
                                Return to Dashboard
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Status Updates -->
            <div class="glass-card rounded-3xl p-6 mb-6">
                <h3 class="text-xl font-bold text-white mb-4">🔧 What We're Doing</h3>
                <div class="space-y-3 text-white/80 text-left">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-green-400 rounded-full mr-3"></div>
                        <span>Error has been automatically logged</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3"></div>
                        <span>Development team has been notified</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-blue-400 rounded-full mr-3"></div>
                        <span>Working on a fix right now</span>
                    </div>
                </div>
            </div>

            <!-- Helpful Tips -->
            <div class="glass-card rounded-3xl p-6">
                <h3 class="text-xl font-bold text-white mb-4">💡 In the Meantime</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-white/80">
                    <div class="text-center">
                        <div class="text-2xl mb-2">⏰</div>
                        <p class="text-sm">Wait a few minutes and try again</p>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl mb-2">🔄</div>
                        <p class="text-sm">Refresh the page or clear your browser cache</p>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="mt-8 text-white/60 text-sm">
                <p>
                    If the problem persists, please 
                    <a href="mailto:support@smartkeyholder.com" class="text-white underline hover:text-white/80">contact our support team</a>
                    with the error details.
                </p>
                <p class="mt-2 text-xs">Error ID: {{ uniqid() }} | Time: {{ now()->format('Y-m-d H:i:s T') }}</p>
            </div>
        </div>
    </div>

    <script>
        // Auto-retry functionality
        let retryCount = 0;
        const maxRetries = 3;
        
        function autoRetry() {
            if (retryCount < maxRetries) {
                retryCount++;
                setTimeout(() => {
                    console.log(`Auto-retry attempt ${retryCount}/${maxRetries}`);
                    window.location.reload();
                }, 30000); // Retry after 30 seconds
            }
        }
        
        // Start auto-retry
        autoRetry();
        
        // Add visual feedback for retry button
        document.addEventListener('DOMContentLoaded', function() {
            const retryButton = document.querySelector('button[onclick*="reload"]');
            if (retryButton) {
                retryButton.addEventListener('click', function() {
                    this.innerHTML = '⏳ Retrying...';
                    this.disabled = true;
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                });
            }
        });
    </script>
</body>
</html>