<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Trial/Subscription Status -->
            <div class="mb-6 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                @if(auth()->user()->isOnTrial())
                    <p><strong>Trial Account:</strong> Your trial expires on {{ auth()->user()->trial_ends_at->format('M d, Y') }}</p>
                    <a href="{{ route('plans') }}" class="text-blue-600 underline">Upgrade to continue using the service</a>
                @elseif(auth()->user()->hasActiveSubscription())
                    <p><strong>Active Subscription:</strong> {{ $subscription->plan_name ?? 'Premium' }} plan expires on {{ auth()->user()->subscription_ends_at->format('M d, Y') }}</p>
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
                                <a href="{{ route('qr.view', $qrCode->uuid) }}" target="_blank" class="block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">View Profile</a>
                                <div class="flex space-x-2">
                                    <a href="{{ route('qr.download', $qrCode->uuid) }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded text-sm">PNG</a>
                                    <a href="{{ route('qr.download.svg', $qrCode->uuid) }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded text-sm">SVG</a>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm text-gray-600">QR Code: <strong>{{ $qrCode->code }}</strong></p>
                                <p class="text-sm text-gray-600">Claimed: {{ $qrCode->claimed_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-900 mb-2">Scan Statistics</h4>
                                <div class="grid grid-cols-2 gap-4 text-center">
                                    <div>
                                        <p class="text-2xl font-bold text-blue-600">{{ $qrCode->scan_count }}</p>
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
                                <p>Share URL: <a href="{{ $qrCode->url }}" target="_blank" class="text-blue-600 underline break-all">{{ $qrCode->url }}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <input type="text" name="display_name" value="{{ $profile->display_name ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text" name="phone" value="{{ $profile->phone ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Website</label>
                                <input type="url" name="website" value="{{ $profile->website ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" name="location" value="{{ $profile->location ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Profession</label>
                                <input type="text" name="profession" value="{{ $profile->profession ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Profile Image</label>
                                <div class="flex items-center space-x-4">
                                    @if($profile && $profile->profile_image)
                                        <img src="{{ $profile->profile_image_url }}" alt="Profile" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300">
                                        <div class="flex-1">
                                            <input type="file" name="profile_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF up to 5MB</p>
                                        </div>
                                        <button type="button" onclick="removeProfileImage()" class="bg-red-500 hover:bg-red-700 text-white text-xs py-1 px-2 rounded">
                                            Remove
                                        </button>
                                    @else
                                        <div class="w-20 h-20 rounded-full bg-gray-300 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <input type="file" name="profile_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF up to 5MB</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Bio</label>
                                <textarea name="bio" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $profile->bio ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
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
                                <select name="platform" class="block w-full rounded-md border-gray-300 shadow-sm" required>
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
                                <input type="url" name="url" placeholder="URL" class="block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            <div>
                                <input type="text" name="display_name" placeholder="Display Name (optional)" class="block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full">
                                    Add Link
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Existing Social Links -->
                    @if($socialLinks->count() > 0)
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
                                        <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No social links added yet.</p>
                    @endif
                </div>
            </div>

            <!-- PWA Settings Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">PWA & Currency Settings</h3>
                    <form  method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- PWA Enable Toggle -->
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="pwa_enabled" value="1" {{ $profile->pwa_enabled ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Enable Progressive Web App (PWA)</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-1">Allow users to install your profile as an app on their devices</p>
                            </div>

                            <!-- PWA App Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">App Name</label>
                                <input type="text" name="pwa_app_name" value="{{ $profile->pwa_app_name ?? '' }}" placeholder="{{ $profile->display_name ?: $user->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <p class="text-xs text-gray-500 mt-1">Full name displayed when app is installed</p>
                            </div>

                            <!-- PWA Short Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Short Name</label>
                                <input type="text" name="pwa_short_name" value="{{ $profile->pwa_short_name ?? '' }}" maxlength="12" placeholder="{{ substr($profile->display_name ?: $user->name, 0, 12) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <p class="text-xs text-gray-500 mt-1">Short name for home screen (max 12 chars)</p>
                            </div>

                            <!-- Theme Color -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Theme Color</label>
                                <input type="color" name="pwa_theme_color" value="{{ $profile->pwa_theme_color ?: '#000000' }}" class="mt-1 block w-full h-10 rounded-md border-gray-300 shadow-sm">
                                <p class="text-xs text-gray-500 mt-1">Color for browser UI elements</p>
                            </div>

                            <!-- Background Color -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Background Color</label>
                                <input type="color" name="pwa_background_color" value="{{ $profile->pwa_background_color ?: '#ffffff' }}" class="mt-1 block w-full h-10 rounded-md border-gray-300 shadow-sm">
                                <p class="text-xs text-gray-500 mt-1">Background color while app loads</p>
                            </div>

                            <!-- Currency Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Currency</label>
                                <select name="currency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @foreach($currencies as $code => $currency)
                                        <option value="{{ $code }}" {{ ($profile->currency ?? 'USD') === $code ? 'selected' : '' }}>
                                            {{ $currency['symbol'] }} - {{ $currency['name'] }} ({{ $code }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Currency for pricing and payments</p>
                            </div>

                            <!-- PWA Icon Upload -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">PWA Icon</label>
                                <div class="flex items-center space-x-4">
                                    @if($profile && $profile->pwa_icon)
                                        <img src="{{ $profile->pwa_icon_url }}" alt="PWA Icon" class="w-20 h-20 rounded-lg object-cover border-2 border-gray-300">
                                        <div class="flex-1">
                                            <input type="file" name="pwa_icon" accept="image/png,image/jpg,image/jpeg" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            <p class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB. Recommended: 512x512px</p>
                                        </div>
                                        <button type="button" onclick="removePwaIcon()" class="bg-red-500 hover:bg-red-700 text-white text-xs py-1 px-2 rounded">
                                            Remove
                                        </button>
                                    @else
                                        <div class="w-20 h-20 rounded-lg bg-gray-300 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <input type="file" name="pwa_icon" accept="image/png,image/jpg,image/jpeg" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            <p class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB. Recommended: 512x512px</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update PWA Settings
                            </button>
                        </div>
                    </form>
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
                                <input type="text" name="title" placeholder="Title (optional)" class="block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <input type="text" name="description" placeholder="Description (optional)" class="block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <input type="file" name="image" accept="image/*" class="block w-full" required>
                            </div>
                            <div>
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full">
                                    Add Image
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Existing Gallery Items -->
                    @if($galleryItems->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($galleryItems as $item)
                                <div class="relative">
                                    <img src="{{ $item->full_image_url }}" alt="{{ $item->title }}" class="w-full h-32 object-cover rounded">
                                    <div class="absolute top-2 right-2">
                                        <form action="{{ route('dashboard.gallery.delete', $item) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white rounded-full w-6 h-6 text-xs" onclick="return confirm('Are you sure?')">×</button>
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
        </div>
    </div>

    <!-- Hidden form for removing profile image -->
    <form id="remove-profile-image-form" action="{{ route('dashboard.profile.remove-image') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Hidden form for removing PWA icon -->
    <form id="remove-pwa-icon-form" action="{{ route('dashboard.pwa-settings.remove-icon') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function removeProfileImage() {
            if (confirm('Are you sure you want to remove your profile image?')) {
                document.getElementById('remove-profile-image-form').submit();
            }
        }

        function removePwaIcon() {
            if (confirm('Are you sure you want to remove your PWA icon?')) {
                document.getElementById('remove-pwa-icon-form').submit();
            }
        }
    </script>
</x-app-layout>

