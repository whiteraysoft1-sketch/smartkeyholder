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
                                @if($profile && $profile->store_enabled)
                                    <a href="{{ route('store.show', $qrCode->uuid) }}" target="_blank" class="block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">🛍️ View Store</a>
                                @endif
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

            <!-- Store Settings Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">🛍️ WhatsApp Store Settings</h3>
                    <form action="{{ route('dashboard.store-settings.update') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Store Enable Toggle -->
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="store_enabled" value="1" {{ $profile->store_enabled ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Enable WhatsApp Store</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-1">Allow customers to browse and order products via WhatsApp</p>
                            </div>

                            <!-- Store Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Store Name</label>
                                <input type="text" name="store_name" value="{{ $profile->store_name ?? '' }}" placeholder="{{ $profile->display_name ?: $user->name }}'s Store" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- WhatsApp Number -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">WhatsApp Number</label>
                                <input type="text" name="store_whatsapp" value="{{ $profile->store_whatsapp ?? $profile->phone }}" placeholder="+1234567890" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- Store Description -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Store Description</label>
                                <textarea name="store_description" rows="2" placeholder="Describe your store..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $profile->store_description ?? '' }}</textarea>
                            </div>

                            <!-- Delivery Options -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Options</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="delivery_available" value="1" {{ $profile->delivery_available ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        <span class="ml-2 text-sm text-gray-700">Delivery Available</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="pickup_available" value="1" {{ $profile->pickup_available ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        <span class="ml-2 text-sm text-gray-700">Pickup Available</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Delivery Fee ({{ $profile->currency_symbol ?? '$' }})</label>
                                <input type="number" name="delivery_fee" value="{{ $profile->delivery_fee ?? 0 }}" min="0" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-3">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Store Settings
                            </button>
                            @if($profile->store_enabled)
                                <a href="{{ route('dashboard.store') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Manage Store
                                </a>
                                <a href="{{ route('store.show', $qrCode->uuid) }}" target="_blank" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                    View Store
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

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

            <!-- PWA & Currency Settings Section -->
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

                            <!-- PWA App Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">App Name</label>
                                <input type="text" name="pwa_app_name" value="{{ $profile->pwa_app_name ?? '' }}" placeholder="{{ $profile->display_name ?: $user->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden form for removing profile image -->
    <form id="remove-profile-image-form" action="{{ route('dashboard.profile.remove-image') }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function removeProfileImage() {
            if (confirm('Are you sure you want to remove your profile image?')) {
                document.getElementById('remove-profile-image-form').submit();
            }
        }
    </script>
</x-app-layout>