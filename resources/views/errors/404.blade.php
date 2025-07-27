<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found - Smart KeyHolder</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        
        .bounce {
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-30px);
            }
            60% {
                transform: translateY(-15px);
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
                <div class="w-32 h-32 bg-gradient-to-r from-red-400 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-6 bounce">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
            </div>

            <!-- Error Message -->
            <div class="glass-card rounded-3xl p-8 mb-8">
                <h1 class="text-6xl font-bold text-white mb-4">404</h1>
                <h2 class="text-3xl font-bold text-white mb-4">Oops! Page Not Found</h2>
                <p class="text-xl text-white/80 mb-6 leading-relaxed">
                    The page you're looking for seems to have vanished into the digital void. 
                    Don't worry, even the best explorers sometimes take a wrong turn!
                </p>
                
                <!-- Helpful Links -->
                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('home') }}" class="bg-white text-gray-800 px-8 py-3 rounded-2xl font-bold hover:shadow-xl transition transform hover:scale-105">
                            🏠 Go Home
                        </a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="glass-card text-white px-8 py-3 rounded-2xl font-bold hover:bg-white/30 transition">
                                📊 Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="glass-card text-white px-8 py-3 rounded-2xl font-bold hover:bg-white/30 transition">
                                🔐 Sign In
                            </a>
                        @endauth
                    </div>
                    
                    <div class="text-white/60 text-sm">
                        <p>Or try one of these popular pages:</p>
                        <div class="flex flex-wrap justify-center gap-4 mt-2">
                            <a href="{{ route('register') }}" class="text-white/80 hover:text-white underline">Get Started</a>
                            <a href="{{ route('qr-purchase') }}" class="text-white/80 hover:text-white underline">Buy QR Codes</a>
                            @auth
                                @if(auth()->user()->qrCode)
                                    <a href="{{ route('qr.view', auth()->user()->qrCode->uuid) }}" class="text-white/80 hover:text-white underline">My Profile</a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <!-- Fun Facts -->
            <div class="glass-card rounded-3xl p-6">
                <h3 class="text-xl font-bold text-white mb-4">💡 Did You Know?</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-white/80">
                    <div class="text-center">
                        <div class="text-2xl mb-2">🔗</div>
                        <p class="text-sm">Smart KeyHolder creates permanent QR codes that never expire</p>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl mb-2">📱</div>
                        <p class="text-sm">Your digital profile works on any device, anywhere</p>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl mb-2">🎨</div>
                        <p class="text-sm">Choose from multiple beautiful vCard templates</p>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="mt-8 text-white/60 text-sm">
                <p>Still having trouble? <a href="mailto:support@smartkeyholder.com" class="text-white underline hover:text-white/80">Contact Support</a></p>
            </div>
        </div>
    </div>

    <script>
        // Add some interactive elements
        document.addEventListener('DOMContentLoaded', function() {
            // Add click effect to buttons
            document.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Create ripple effect
                    const ripple = document.createElement('div');
                    ripple.style.position = 'absolute';
                    ripple.style.borderRadius = '50%';
                    ripple.style.background = 'rgba(255, 255, 255, 0.6)';
                    ripple.style.transform = 'scale(0)';
                    ripple.style.animation = 'ripple 0.6s linear';
                    ripple.style.left = (e.clientX - this.offsetLeft) + 'px';
                    ripple.style.top = (e.clientY - this.offsetTop) + 'px';
                    ripple.style.width = ripple.style.height = '20px';
                    
                    this.style.position = 'relative';
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });

        // Add ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>