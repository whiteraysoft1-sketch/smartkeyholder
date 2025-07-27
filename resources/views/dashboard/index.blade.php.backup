@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <style>
        /* ... (CSS unchanged) ... */
    </style>
    <div class="min-h-screen bg-gradient-to-br from-blue-100 via-white to-purple-100 flex flex-col items-center px-2 py-2 sm:px-0">
        <!-- App Bar -->
        <div class="w-full max-w-md mx-auto flex items-center justify-between py-3 px-4 sticky top-0 z-20 liquid-glass shadow-lg mb-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                    <i class="fas fa-user text-white text-lg"></i>
                </div>
                <div>
                    <div class="text-base font-bold text-gray-900">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-gray-500">Smart Tag</div>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button class="liquid-btn !w-10 !h-10 !p-0 flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600"><i class="fas fa-bell"></i></button>
            </div>
        </div>

        <div class="w-full max-w-md mx-auto space-y-6 pb-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="liquid-glass px-4 py-3 text-green-800 text-center text-sm font-semibold">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="liquid-glass px-4 py-3 text-red-800 text-center text-sm font-semibold">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="liquid-glass px-4 py-3 text-red-800 text-center text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if($profile && $profile->latest_inapp_message)
                <div id="inapp-message-banner" class="liquid-glass px-4 py-3 text-blue-900 text-center text-base font-semibold flex items-center justify-between mb-4">
                    <span>{{ $profile->latest_inapp_message }}</span>
                    <button onclick="dismissInAppMessage()" class="ml-4 text-blue-600 hover:text-blue-800 text-lg font-bold">&times;</button>
                </div>
                <script>
                function dismissInAppMessage() {
                    fetch('/dashboard/pwa-settings/send-notification', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({ message: '' })
                    }).then(() => {
                        document.getElementById('inapp-message-banner').style.display = 'none';
                    });
                }
                </script>
            @endif

            <!-- Trial/Subscription Status -->
            <div class="liquid-glass px-4 py-3 text-blue-900 text-center text-sm">
                @if(auth()->user()->isOnTrial())
                    <span class="font-bold">Trial:</span> Expires {{ auth()->user()->trial_ends_at->format('M d, Y') }}
                    <a href="{{ route('plans') }}" class="underline text-blue-700 ml-2">Upgrade</a>
                @elseif(auth()->user()->hasActiveSubscription())
                    <span class="font-bold">Active:</span> {{ $subscription->plan_name ?? 'Premium' }} until {{ auth()->user()->subscription_ends_at->format('M d, Y') }}
                @endif
            </div>

            <!-- QR Code Card -->
            @if($qrCode)
            <div class="liquid-glass p-5 flex flex-col items-center">
                <div class="mb-3">
                    <img src="{{ route('qr.generate', $qrCode->uuid) }}" alt="QR Code" class="w-32 h-32 rounded-xl shadow-lg border-2 border-white/40">
                </div>
                <div class="w-full flex flex-col items-center space-y-2">
                    <div class="w-full flex justify-center">
                        <a href="{{ route('qr.view', $qrCode->uuid) }}" target="_blank" class="liquid-btn liquid-glass text-center">View Profile</a>
                    </div>
                    <div class="flex w-full space-x-2">
                        <a href="{{ route('qr.download', $qrCode->uuid) }}" class="liquid-btn bg-gradient-to-br from-gray-700 to-gray-900 flex items-center justify-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 mr-2">
                                <i class="fas fa-file-image fa-lg text-white"></i>
                            </span>
                            PNG
                        </a>
                        <a href="{{ route('qr.download.svg', $qrCode->uuid) }}" class="liquid-btn bg-gradient-to-br from-gray-700 to-gray-900 flex items-center justify-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-purple-600 mr-2">
                                <i class="fas fa-code fa-lg text-white"></i>
                            </span>
                            SVG
                        </a>
                    </div>
                    @if($profile && $profile->store_enabled)
                        <a href="{{ route('store.show', $qrCode->uuid) }}" target="_blank" class="liquid-btn bg-gradient-to-br from-green-500 to-green-700">🛍️ View Store</a>
                    @endif
                </div>
                <div class="w-full mt-4 text-xs text-gray-700">
                    <div class="flex justify-between"><span>Code:</span> <span class="font-mono">{{ $qrCode->code }}</span></div>
                    <div class="flex justify-between"><span>Claimed:</span> <span>{{ $qrCode->claimed_at->format('M d, Y H:i') }}</span></div>
                    <div class="flex justify-between"><span>Scans:</span> <span>{{ $qrCode->scan_count }}</span></div>
                    <div class="flex justify-between"><span>Last Scan:</span> <span>@if($qrCode->last_scanned_at){{ $qrCode->last_scanned_at->diffForHumans() }}@else Never @endif</span></div>
                </div>
                <div class="w-full mt-2 text-xs text-blue-700 break-all">Share: <a href="{{ $qrCode->url }}" target="_blank" class="underline">{{ $qrCode->url }}</a></div>
            </div>
            @endif

            <!-- vCard Templates Card -->
            <div class="liquid-glass p-5">
                <div class="w-full flex justify-center">
                    <a href="{{ route('dashboard.vcard-templates') }}" class="liquid-btn liquid-glass text-center">
                        <i class="fas fa-id-card mr-2"></i>
                        vCard Templates
                    </a>
                </div>
            </div>

            <!-- Profile Card -->
            <div class="liquid-glass p-5">
                <!-- Remove Image Forms (outside main form) -->
                @if($profile && $profile->profile_image)
                    <form id="remove-profile-form" action="{{ route('dashboard.profile.remove-image') }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif
                @if($profile && $profile->background_image)
                    <form id="remove-background-form" action="{{ route('dashboard.profile.remove-background') }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                @endif

                <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="flex flex-col items-center space-y-3 mb-4">
                        <!-- Profile Image -->
                        <div class="flex flex-col items-center space-y-2">
                            <label class="liquid-label text-center">Profile Photo</label>
                            @if($profile && $profile->profile_image)
                                <div class="relative">
                                    <img src="{{ $profile->profile_image_url }}" alt="Profile" class="w-20 h-20 rounded-full object-cover border-2 border-white/40 shadow">
                                    <button type="button" onclick="removeProfileImage()" class="absolute -top-1 -right-1 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @else
                                <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-user text-2xl text-gray-400"></i>
                                </div>
                            @endif
                            <input type="file" name="profile_image" accept="image/jpeg,image/png,image/jpg,image/gif" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <!-- Background Image -->
                        <div class="flex flex-col items-center space-y-2 w-full">
                            <label class="liquid-label text-center">Background Photo</label>
                            @if($profile && $profile->background_image)
                                <div class="relative">
                                    <img src="{{ $profile->background_image_url }}" alt="Background" class="w-full h-24 rounded-xl object-cover border-2 border-white/40 shadow">
                                    <button type="button" onclick="removeBackgroundImage()" class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @else
                                <div class="w-full h-24 rounded-xl bg-gray-200 flex items-center justify-center border-2 border-dashed border-gray-300">
                                    <i class="fas fa-image text-2xl text-gray-400"></i>
                                </div>
                            @endif
                            <input type="file" name="background_image" accept="image/jpeg,image/png,image/jpg,image/gif" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                            <p class="text-xs text-gray-500 text-center">Recommended: 1200x400px or similar landscape ratio</p>
                        </div>
                    </div>
                    <div>
                        <label class="liquid-label">Name</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" class="liquid-input" required>
                    </div>
                    <div>
                        <label class="liquid-label">Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="liquid-input" required>
                    </div>
                    <div>
                        <label class="liquid-label">Display Name</label>
                        <input type="text" name="display_name" value="{{ $profile->display_name ?? '' }}" class="liquid-input">
                    </div>
                    <div>
                        <label class="liquid-label">Phone</label>
                        <input type="text" name="phone" value="{{ $profile->phone ?? '' }}" class="liquid-input">
                    </div>
                    <div>
                        <label class="liquid-label">Website</label>
                        <input type="url" name="website" value="{{ $profile->website ?? '' }}" class="liquid-input">
                    </div>
                    <div>
                        <label class="liquid-label">Location</label>
                        <input type="text" name="location" value="{{ $profile->location ?? '' }}" class="liquid-input">
                    </div>
                    <div>
                        <label class="liquid-label">Profession</label>
                        <input type="text" name="profession" value="{{ $profile->profession ?? '' }}" class="liquid-input">
                    </div>
                    <div>
                        <label class="liquid-label">Bio</label>
                        <textarea name="bio" rows="2" class="liquid-input">{{ $profile->bio ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="liquid-label">Contact</label>
                        <input type="text" name="contact" value="{{ $profile->contact ?? '' }}" class="liquid-input">
                    </div>
                    <button type="submit" class="w-full py-4 px-6 rounded-full font-bold text-white text-lg bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200" onclick="console.log('Update Profile button clicked')">
                        Update Profile
                    </button>
                </form>

                <script>
                function removeProfileImage() {
                    if (confirm('Remove profile image?')) {
                        document.getElementById('remove-profile-form').submit();
                    }
                }

                function removeBackgroundImage() {
                    if (confirm('Remove background image?')) {
                        document.getElementById('remove-background-form').submit();
                    }
                }

                // Debug: Add form submission listener
                document.addEventListener('DOMContentLoaded', function() {
                    const profileForm = document.querySelector('form[action="{{ route('dashboard.profile.update') }}"]');
                    console.log('Profile form found:', profileForm);
                    console.log('Form action URL:', '{{ route('dashboard.profile.update') }}');
                    
                    if (profileForm) {
                        profileForm.addEventListener('submit', function(e) {
                            console.log('Profile form is being submitted');
                            console.log('Form action:', this.action);
                            console.log('Form method:', this.method);
                            
                            // Check if all required fields are filled
                            const nameField = this.querySelector('input[name="name"]');
                            const emailField = this.querySelector('input[name="email"]');
                            console.log('Name field value:', nameField ? nameField.value : 'not found');
                            console.log('Email field value:', emailField ? emailField.value : 'not found');
                        });
                    } else {
                        console.error('Profile form not found!');
                    }
                });
                </script>
            </div>

            <!-- Social Links Card -->
            <div class="liquid-glass p-5">
                <h3 class="text-base font-bold mb-2">Social Links</h3>
                <form action="{{ route('dashboard.social-links.add') }}" method="POST" class="flex space-x-2 mb-4">
                    @csrf
                    <select name="platform" class="liquid-input" required>
                        <option value="">Platform</option>
                        <option value="facebook">Facebook</option>
                        <option value="twitter">Twitter</option>
                        <option value="instagram">Instagram</option>
                        <option value="linkedin">LinkedIn</option>
                        <option value="youtube">YouTube</option>
                        <option value="tiktok">TikTok</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="website">Website</option>
                    </select>
                    <input type="url" name="url" placeholder="URL" class="liquid-input" required>
                    <button type="submit" class="liquid-btn !w-auto !px-4">Add</button>
                </form>
                <div class="space-y-2">
                    @foreach($socialLinks as $link)
                        <div class="flex items-center justify-between bg-white/60 rounded-xl px-3 py-2 shadow">
                            <div class="flex items-center space-x-2">
                                <i class="{{ $link->platform_icon }} text-blue-500"></i>
                                <span class="font-medium">{{ ucfirst($link->platform) }}</span>
                                <a href="{{ $link->url }}" target="_blank" class="text-blue-600 underline">{{ $link->display_name ?: $link->url }}</a>
                            </div>
                            <form action="{{ route('dashboard.social-links.delete', $link) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 px-2 py-1 rounded-full hover:bg-red-100"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Rebuilt Photo Gallery Card -->
            <div class="liquid-glass p-5">
                <h3 class="text-lg font-bold mb-4 flex items-center">
                    <i class="fas fa-images mr-3 text-purple-500"></i>
                    Photo Gallery
                </h3>

                <!-- Add Photo Form -->
                <form action="{{ route('dashboard.gallery.add') }}" method="POST" enctype="multipart/form-data" class="mb-6 p-4 bg-white/20 rounded-xl border border-white/30">
                    @csrf
                    <div class="mb-3">
                        <label for="image" class="liquid-label">Upload New Photo</label>
                        <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/jpg,image/gif" class="liquid-input" required>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="liquid-label">Photo Title (Optional)</label>
                        <input type="text" name="title" id="title" placeholder="e.g., My Best Work" class="liquid-input">
                    </div>
                    <button type="submit" class="liquid-btn bg-gradient-to-br from-purple-500 to-indigo-600 text-white w-full">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Add Photo
                    </button>
                </form>

                <!-- Image Grid -->
                @if($galleryItems->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($galleryItems as $item)
                            <div class="relative group aspect-square">
                                <img src="{{ $item->full_image_url }}" 
                                     alt="{{ $item->title }}" 
                                     class="w-full h-full object-cover rounded-xl shadow-lg border-2 border-white/50 transition-transform duration-300 group-hover:scale-105"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-full h-full bg-gray-200 rounded-xl flex items-center justify-center" style="display: none;">
                                    <div class="text-center">
                                        <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                        <p class="text-xs text-gray-500">Image not found</p>
                                        <p class="text-xs text-gray-400">{{ $item->image_path }}</p>
                                    </div>
                                </div>
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl flex items-center justify-center">
                                    <form action="{{ route('dashboard.gallery.delete', $item) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this photo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white rounded-full w-10 h-10 flex items-center justify-center text-lg shadow-lg hover:bg-red-700 transform hover:scale-110 transition-transform">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                @if($item->title)
                                    <div class="absolute bottom-0 left-0 right-0 p-2 bg-black/40 text-white text-xs rounded-b-xl">
                                        <p class="truncate">{{ $item->title }}</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-8 px-4 border-2 border-dashed border-gray-300/50 rounded-xl">
                        <i class="fas fa-camera-retro text-4xl text-gray-400/80 mb-3"></i>
                        <h4 class="text-lg font-semibold text-gray-600">Your Gallery is Empty</h4>
                        <p class="text-sm text-gray-500">Upload your first photo using the form above.</p>
                    </div>
                @endif
            </div>

            
            
            <!-- PWA Install Card -->
            
            <!-- Store Settings Card -->
            <div class="liquid-glass p-5">
                <h3 class="text-base font-bold mb-2">WhatsApp Store Settings</h3>
                <form action="{{ route('dashboard.store-settings.update') }}" method="POST" class="space-y-2">
                    @csrf
                    <input type="hidden" name="store_enabled" value="0">
                    <label class="flex items-center">
                        <input type="checkbox" name="store_enabled" value="1" {{ $profile->store_enabled ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Enable WhatsApp Store</span>
                    </label>
                    <input type="text" name="store_name" value="{{ $profile->store_name ?? '' }}" placeholder="Store Name" class="liquid-input">
                    <input type="text" name="store_whatsapp" value="{{ $profile->store_whatsapp ?? $profile->phone }}" placeholder="WhatsApp Number" class="liquid-input">
                    <textarea name="store_description" rows="2" placeholder="Store Description" class="liquid-input">{{ $profile->store_description ?? '' }}</textarea>
                    <input type="text" name="store_address" value="{{ $profile->store_address ?? '' }}" placeholder="Store Address" class="liquid-input">
                    <input type="number" name="minimum_order" value="{{ $profile->minimum_order ?? 0 }}" min="0" step="0.01" placeholder="Minimum Order" class="liquid-input">
                    <select name="currency" class="liquid-input">
                        @foreach($currencies as $code => $currency)
                            <option value="{{ $code }}" {{ ($profile->currency ?? 'USD') === $code ? 'selected' : '' }}>
                                {{ $currency['symbol'] }} - {{ $currency['name'] }} ({{ $code }})
                            </option>
                        @endforeach
                    </select>
                    <div class="flex space-x-2">
                        <input type="hidden" name="delivery_available" value="0">
                        <label class="flex items-center">
                            <input type="checkbox" name="delivery_available" value="1" {{ $profile->delivery_available ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm">
                            <span class="ml-2 text-sm text-gray-700">Delivery</span>
                        </label>
                        <input type="hidden" name="pickup_available" value="0">
                        <label class="flex items-center">
                            <input type="checkbox" name="pickup_available" value="1" {{ $profile->pickup_available ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm">
                            <span class="ml-2 text-sm text-gray-700">Pickup</span>
                        </label>
                    </div>
                    <input type="number" name="delivery_fee" value="{{ $profile->delivery_fee ?? 0 }}" min="0" step="0.01" placeholder="Delivery Fee" class="liquid-input">
                    <button type="submit" class="w-full py-4 px-6 rounded-full font-bold text-white text-lg tracking-wide shadow-xl bg-gradient-to-br from-green-500 via-green-600 to-green-700 backdrop-blur-md border border-white/30 transition-all duration-200 hover:scale-105 hover:from-green-600 hover:to-green-800 focus:outline-none focus:ring-4 focus:ring-green-300/40 mb-4">
                        <span class="drop-shadow">Update Store Settings</span>
                    </button>
                    @if($profile->store_enabled)
                        <div class="flex flex-col gap-4 mt-2">
                            <a href="{{ route('dashboard.store') }}" class="w-full py-4 px-6 rounded-full font-bold text-white text-base tracking-wide shadow-lg bg-gradient-to-br from-green-400 via-green-500 to-green-600 backdrop-blur-md border border-white/30 flex items-center justify-center transition-all duration-200 hover:scale-105 hover:from-green-500 hover:to-green-700 focus:outline-none focus:ring-4 focus:ring-green-300/40">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-green-700 mr-3">
                                    <i class="fas fa-cogs fa-lg text-white"></i>
                                </span>
                                <span class="drop-shadow">Manage Store</span>
                            </a>
                            <a href="{{ route('store.show', $qrCode->uuid) }}" target="_blank" class="w-full py-4 px-6 rounded-full font-bold text-white text-base tracking-wide shadow-lg bg-gradient-to-br from-purple-400 via-purple-500 to-purple-700 backdrop-blur-md border border-white/30 flex items-center justify-center transition-all duration-200 hover:scale-105 hover:from-purple-500 hover:to-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300/40">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-purple-700 mr-3">
                                    <i class="fas fa-store fa-lg text-white"></i>
                                </span>
                                <span class="drop-shadow">View Store</span>
                            </a>
                        </div>
                    @endif
                </form>
            </div>

                    </div>
    </div>
</x-app-layout>
