<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Status - Whiteray Smart Tag</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-4xl mx-auto p-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">🎉 Dashboard Fixed!</h1>
                    <p class="text-xl text-gray-600">Your Whiteray Smart Tag dashboard is now working with Tailwind CSS</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-green-800 mb-3">✅ What's Fixed</h3>
                        <ul class="text-green-700 space-y-2">
                            <li>• Tailwind CSS from CDN (no build required)</li>
                            <li>• Alpine.js for interactive components</li>
                            <li>• Font Awesome icons</li>
                            <li>• All dashboard functionality</li>
                            <li>• Profile management</li>
                            <li>• Social links & gallery</li>
                        </ul>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-800 mb-3">🚀 Available Routes</h3>
                        <ul class="text-blue-700 space-y-2">
                            <li>• <code>/dashboard</code> - Main dashboard</li>
                            <li>• <code>/dashboard-simple</code> - Simple version</li>
                            <li>• <code>/dashboard-debug</code> - Debug info</li>
                            <li>• <code>/dashboard-test-access</code> - No middleware</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-yellow-800 mb-3">👤 Available Test Users</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-yellow-700">
                        <div>
                            <p><strong>Admin User:</strong></p>
                            <p>Email: admin@example.com</p>
                            <p>Trial until: July 12, 2025</p>
                        </div>
                        <div>
                            <p><strong>Regular User:</strong></p>
                            <p>Email: whiteraysoft@gmail.com</p>
                            <p>Trial until: July 12, 2025</p>
                        </div>
                    </div>
                </div>

                <div class="text-center space-y-4">
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                            Login to Dashboard
                        </a>
                        <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                            Register New User
                        </a>
                    </div>
                    
                    @auth
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-700 mb-4">You're logged in as: <strong>{{ auth()->user()->name }}</strong></p>
                        <div class="space-x-2">
                            <a href="{{ route('dashboard') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                                Go to Dashboard
                            </a>
                            <a href="{{ route('dashboard.simple') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                                Simple Dashboard
                            </a>
                            <a href="{{ route('dashboard.debug') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                                Debug Info
                            </a>
                        </div>
                    </div>
                    @endauth
                </div>

                <div class="mt-8 text-center text-sm text-gray-500">
                    <p>If you still see a blank page, try the <strong>/dashboard-simple</strong> or <strong>/dashboard-test-access</strong> routes</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>