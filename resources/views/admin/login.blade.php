<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Whiteray Smart Tag</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @php
        use App\Models\Setting;
        $mainLogo = Setting::get('main_logo');
        $landingHero = Setting::get('landing_hero');
    @endphp
<style>
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
    </style>
</head>
<body class="gradient-bg">
    <div class="min-h-screen flex items-center justify-center">
        <div class="glass-card liquid-glass w-full max-w-4xl flex flex-col md:flex-row rounded-xl overflow-hidden shadow-lg">
            <div class="hidden md:flex w-full md:w-1/2 items-center justify-center p-6 liquid-glass bg-white/20 backdrop-blur-lg border border-white/30">
                <!-- Side Image -->
                @if($landingHero)
                    <img src="{{ asset('storage/' . $landingHero) }}" alt="Admin Side Image" class="h-64 object-contain">
                @else
                    <img src="https://images.unsplash.com/photo-1585487002244-6e6c74c3fbc6?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=60" alt="Key Holder" class="h-64 object-contain">
                @endif
            </div>
            <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
                <div class="flex justify-center mb-6">
                    <div class="bg-white bg-opacity-90 rounded-full shadow-lg flex items-center justify-center p-3">
                        @if($mainLogo)
                            <img src="{{ asset('storage/' . $mainLogo) }}" alt="Logo" class="h-12 w-auto">
                        @else
                            <img src="https://whiteray.com/wp-content/uploads/2023/01/logo-1.png" alt="Logo" class="h-12 w-auto">
                        @endif
                    </div>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-2">Admin Login</h2>
                <p class="text-gray-600 text-center mb-6">Welcome back! Please sign in to continue.</p>
                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="glass-input w-full px-4 py-3 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none">
                    </div>
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                        <input id="password" type="password" name="password" required class="glass-input w-full px-4 py-3 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none">
                    </div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input id="remember" type="checkbox" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-900">Remember me</label>
                        </div>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800">Forgot Password?</a>
                    </div>
                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                    <div class="flex items-center justify-center">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl focus:outline-none focus:shadow-outline w-full transition duration-200">
                            Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
