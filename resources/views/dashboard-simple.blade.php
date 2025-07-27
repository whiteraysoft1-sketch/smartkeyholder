<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Simple</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Simple Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold">Whiteray Smart Tag</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span>{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Trial/Subscription Status -->
            <div class="mb-6 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                @if(auth()->user()->isOnTrial())
                    <p><strong>Trial Account:</strong> Your trial expires on {{ auth()->user()->trial_ends_at->format('M d, Y') }}</p>
                    <a href="{{ route('plans') }}" class="text-blue-600 underline">Upgrade to continue using the service</a>
                @elseif(auth()->user()->hasActiveSubscription())
                    <p><strong>Active Subscription:</strong> {{ $subscription->plan_name ?? 'Premium' }} plan expires on {{ auth()->user()->subscription_ends_at->format('M d, Y') }}</p>
                @else
                    <p><strong>Account Status:</strong> Please activate your trial or subscription to access all features.</p>
                    <a href="{{ route('plans') }}" class="text-blue-600 underline">View Plans</a>
                @endif
            </div>

            <!-- QR Code Section -->
            @if($qrCode)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Your QR Code & Analytics</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="text-center">
                            <img src="{{ route('qr.generate', $qrCode->uuid) }}" alt="QR Code" class="w-32 h-32 border mx-auto mb-3">
                            <div class="space-y-2">
                                <a href="{{ route('qr.view', $qrCode->uuid) }}" target="_blank" class="block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm transition duration-200">View Profile</a>
                                <div class="flex space-x-2">
                                    <a href="{{ route('qr.download', $qrCode->uuid) }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded text-sm transition duration-200">PNG</a>
                                    <a href="{{ route('qr.download.svg', $qrCode->uuid) }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded text-sm transition duration-200">SVG</a>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-600">QR Code: <strong>{{ $qrCode->code }}</strong></p>
                                <p class="text-sm text-gray-600">Claimed: {{ $qrCode->claimed_at ? $qrCode->claimed_at->format('M d, Y H:i') : 'Not claimed' }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-900 mb-2">Scan Statistics</h4>
                                <div class="grid grid-cols-2 gap-4 text-center">
                                    <div>
                                        <p class="text-2xl font-bold text-blue-600">{{ $qrCode->scan_count ?? 0 }}</p>
                                        <p class="text-xs text-gray-600">Total Scans</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">
                                            @if($qrCode->last_scanned_at)
                                                {{ $qrCode->last_scanned_at->diffForHumans() }}
                                            @else
                                                Never
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-600">Last Scan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-xs text-gray-500">
                                <p>Share URL: <a href="{{ $qrCode->url ?? '#' }}" target="_blank" class="text-blue-600 underline break-all">{{ $qrCode->url ?? 'Not available' }}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
                <p><strong>No QR Code:</strong> You don't have a QR code yet. Please claim one to get started.</p>
            </div>
            @endif

            <!-- Profile Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Profile Information</h3>
                    <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Display Name</label>
                                <input type="text" name="display_name" value="{{ optional($profile)->display_name ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text" name="phone" value="{{ optional($profile)->phone ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Website</label>
                                <input type="url" name="website" value="{{ optional($profile)->website ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" name="location" value="{{ optional($profile)->location ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Profession</label>
                                <input type="text" name="profession" value="{{ optional($profile)->profession ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Bio</label>
                                <textarea name="bio" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ optional($profile)->bio ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Social Links Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Social Links</h3>
                    
                    <!-- Add New Social Link -->
                    <form action="{{ route('dashboard.social-links.add') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <select name="platform" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    <option value="">Select Platform</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="twitter">Twitter</option>
                                    <option value="instagram">Instagram</option>
                                    <option value="linkedin">LinkedIn</option>
                                    <option value="youtube">YouTube</option>
                                    <option value="tiktok">TikTok</option>
                                    <option value="whatsapp">WhatsApp</option>
                                    <option value="website">Website</option>
                                </select>
                            </div>
                            <div>
                                <input type="url" name="url" placeholder="URL" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <input type="text" name="display_name" placeholder="Display Name (optional)" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full transition duration-200">
                                    Add Link
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Existing Social Links -->
                    @if($socialLinks && $socialLinks->count() > 0)
                        <div class="space-y-2">
                            @foreach($socialLinks as $link)
                                <div class="flex items-center justify-between bg-gray-50 p-3 rounded">
                                    <div class="flex items-center space-x-3">
                                        <i class="{{ $link->platform_icon }}"></i>
                                        <span class="font-medium">{{ ucfirst($link->platform) }}</span>
                                        <a href="{{ $link->url }}" target="_blank" class="text-blue-600 underline">{{ $link->display_name ?: $link->url }}</a>
                                    </div>
                                    <form action="{{ route('dashboard.social-links.delete', $link) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition duration-200" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No social links added yet.</p>
                    @endif
                </div>
            </div>

            <!-- Gallery Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Photo Gallery</h3>
                    
                    <!-- Add New Gallery Item -->
                    <form action="{{ route('dashboard.gallery.add') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <input type="text" name="title" placeholder="Title (optional)" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <input type="text" name="description" placeholder="Description (optional)" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                            </div>
                            <div>
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full transition duration-200">
                                    Add Image
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Existing Gallery Items -->
                    @if($galleryItems && $galleryItems->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($galleryItems as $item)
                                <div class="relative">
                                    <img src="{{ $item->full_image_url }}" alt="{{ $item->title }}" class="w-full h-32 object-cover rounded">
                                    <div class="absolute top-2 right-2">
                                        <form action="{{ route('dashboard.gallery.delete', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white rounded-full w-6 h-6 text-xs transition duration-200" onclick="return confirm('Are you sure?')">×</button>
                                        </form>
                                    </div>
                                    @if($item->title)
                                        <p class="text-sm font-medium mt-1">{{ $item->title }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No gallery images added yet.</p>
                    @endif
                </div>
            </div>

            <!-- Debug Links -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Debug & Testing</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <a href="{{ route('dashboard.debug') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded text-center">
                            Debug Info
                        </a>
                        <a href="{{ route('billing') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-center">
                            Billing
                        </a>
                        <a href="{{ route('plans') }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-center">
                            Plans
                        </a>
                        <a href="{{ route('test.pwa') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                            PWA Test
                        </a>
                        <a href="{{ route('test.pwa.public') }}" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded text-center">
                            PWA Public Test
                        </a>
                        <a href="{{ route('debug.pwa.settings') }}" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded text-center">
                            PWA Debug
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>