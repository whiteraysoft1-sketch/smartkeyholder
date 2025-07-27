<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Smart KeyHolder</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Apple Liquid Glass UI Styles */
        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        .glass-input {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .glass-input:focus {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(59, 130, 246, 0.5);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
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
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .slide-in {
            animation: slideInUp 0.8s ease-out;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="gradient-bg relative">
    <!-- Floating Background Elements -->
    <div class="floating-elements">
        <div class="floating-element w-20 h-20 top-10 left-10" style="animation-delay: 0s;"></div>
        <div class="floating-element w-32 h-32 top-20 right-20" style="animation-delay: 2s;"></div>
        <div class="floating-element w-16 h-16 bottom-20 left-20" style="animation-delay: 4s;"></div>
        <div class="floating-element w-24 h-24 bottom-10 right-10" style="animation-delay: 1s;"></div>
    </div>

    <div class="container mx-auto px-4 py-8 relative z-10 flex items-center justify-center min-h-screen">
        <!-- Login Form -->
        <div class="max-w-md w-full slide-in">
            <div class="glass-card rounded-3xl p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-white mb-2">Welcome Back! 👋</h1>
                    <p class="text-white/80 text-sm">Sign in to your Smart KeyHolder</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="glass-card rounded-2xl p-4 border-green-300 bg-green-500/20 mb-6">
                        <p class="text-green-100 text-sm">{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="glass-card rounded-2xl p-4 border-red-300 bg-red-500/20">
                            <div class="flex items-center text-red-100 mb-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold">Sign in failed</span>
                            </div>
                            <ul class="list-disc list-inside text-red-100 text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-white font-medium mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="glass-input w-full px-4 py-3 rounded-xl text-white placeholder-white/60 focus:outline-none"
                            placeholder="your.email@example.com">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-white font-medium mb-2">Password</label>
                        <input type="password" id="password" name="password" required
                            class="glass-input w-full px-4 py-3 rounded-xl text-white placeholder-white/60 focus:outline-none"
                            placeholder="Enter your password">
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input type="checkbox" id="remember_me" name="remember" 
                            class="w-4 h-4 text-blue-600 bg-white/20 border-white/30 rounded focus:ring-blue-500 focus:ring-2">
                        <label for="remember_me" class="ml-2 text-white/80 text-sm">Remember me</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold py-3 px-6 rounded-xl transition duration-300 transform hover:scale-105 hover:shadow-lg">
                        🔓 Sign In
                    </button>

                    <!-- Links -->
                    <div class="space-y-3 text-center">
                        @if (Route::has('password.request'))
                            <div>
                                <a href="{{ route('password.request') }}" class="text-white/80 hover:text-white text-sm underline">
                                    Forgot your password?
                                </a>
                            </div>
                        @endif
                        
                        <div>
                            <p class="text-white/80 text-sm">
                                Don't have an account? 
                                <a href="{{ route('register') }}" class="text-white underline hover:text-white/80 font-medium">
                                    Create one
                                </a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Quick Features -->
            <div class="glass-card rounded-3xl p-6 mt-6 slide-in" style="animation-delay: 0.2s;">
                <h3 class="text-lg font-bold text-white mb-4 text-center">Why Smart KeyHolder?</h3>
                <div class="space-y-3">
                    <div class="flex items-center text-white/80">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-sm">Instant digital profile sharing</span>
                    </div>
                    <div class="flex items-center text-white/80">
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-400 to-pink-500 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-sm">Professional vCard templates</span>
                    </div>
                    <div class="flex items-center text-white/80">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-cyan-500 rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-sm">Analytics & insights</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-focus on email input
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('email').focus();
        });

        // Enter key navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                const activeElement = document.activeElement;
                if (activeElement.id === 'email') {
                    document.getElementById('password').focus();
                    e.preventDefault();
                } else if (activeElement.id === 'password') {
                    document.querySelector('form').submit();
                }
            }
        });

        // Form validation feedback
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                e.preventDefault();
                alert('Please fill in all fields.');
                return false;
            }
        });
    </script>
</body>
</html>