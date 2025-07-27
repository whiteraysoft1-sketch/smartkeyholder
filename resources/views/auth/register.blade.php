<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Smart KeyHolder - Whiteray Smart Tag</title>
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

    <div class="container mx-auto px-4 py-8 relative z-10">
        <!-- Header -->
        <div class="text-center mb-8 slide-in">
            <div class="glass-card rounded-3xl p-6 max-w-md mx-auto">
                <h1 class="text-2xl md:text-3xl font-bold text-white mb-2">🔑 Join Smart KeyHolder</h1>
                <p class="text-white/80">Create Your Digital Identity</p>
            </div>
        </div>

        <!-- Registration Form -->
        <div class="max-w-md mx-auto slide-in" style="animation-delay: 0.2s;">
            <div class="glass-card rounded-3xl p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="glass-card rounded-2xl p-4 border-red-300 bg-red-500/20">
                            <div class="flex items-center text-red-100 mb-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-semibold">Please fix the following:</span>
                            </div>
                            <ul class="list-disc list-inside text-red-100 text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Welcome Message -->
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-white mb-2">Welcome! 👋</h2>
                        <p class="text-white/80 text-sm">Let's create your account in just a few steps</p>
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-white font-medium mb-2">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                            class="glass-input w-full px-4 py-3 rounded-xl text-white placeholder-white/60 focus:outline-none"
                            placeholder="Enter your full name">
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-white font-medium mb-2">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="glass-input w-full px-4 py-3 rounded-xl text-white placeholder-white/60 focus:outline-none"
                            placeholder="your.email@example.com">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-white font-medium mb-2">Password</label>
                        <input type="password" id="password" name="password" required
                            class="glass-input w-full px-4 py-3 rounded-xl text-white placeholder-white/60 focus:outline-none"
                            placeholder="Create a strong password">
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-white font-medium mb-2">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="glass-input w-full px-4 py-3 rounded-xl text-white placeholder-white/60 focus:outline-none"
                            placeholder="Confirm your password">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold py-3 px-6 rounded-xl transition duration-300 transform hover:scale-105 hover:shadow-lg">
                        🎉 Create My Account
                    </button>

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-white/80 text-sm">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="text-white underline hover:text-white/80 font-medium">
                                Sign In
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Features Preview -->
        <div class="max-w-4xl mx-auto mt-12 slide-in" style="animation-delay: 0.4s;">
            <div class="glass-card rounded-3xl p-8">
                <h3 class="text-2xl font-bold text-center text-white mb-8">What You'll Get</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-white mb-2">Professional Profile</h4>
                        <p class="text-white/70 text-sm">Beautiful vCard-style page with your photo, bio, and contact info</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-white mb-2">Social Links</h4>
                        <p class="text-white/70 text-sm">Connect all your social media and professional profiles in one place</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-white mb-2">Photo Gallery</h4>
                        <p class="text-white/70 text-sm">Showcase your work, products, or memorable moments</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Terms -->
        <div class="text-center mt-8">
            <p class="text-white/60 text-sm">
                By creating an account, you agree to our 
                <a href="#" class="text-white underline hover:text-white/80">Terms of Service</a> and 
                <a href="#" class="text-white underline hover:text-white/80">Privacy Policy</a>
            </p>
        </div>
    </div>

    <script>
        // Auto-focus on first input
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('name').focus();
        });

        // Form validation feedback
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match. Please try again.');
                document.getElementById('password_confirmation').focus();
                return false;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long.');
                document.getElementById('password').focus();
                return false;
            }
        });

        // Real-time password confirmation
        document.getElementById('password_confirmation').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.style.borderColor = 'rgba(239, 68, 68, 0.5)';
            } else {
                this.style.borderColor = 'rgba(255, 255, 255, 0.2)';
            }
        });
    </script>
</body>
</html>