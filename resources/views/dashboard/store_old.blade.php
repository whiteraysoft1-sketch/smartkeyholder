<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-bold text-2xl bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                🛍️ {{ __('Store Management') }}
            </h2>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('store.show', $user->qrCode->uuid) }}" target="_blank" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white text-sm font-semibold rounded-lg shadow-md transition-all duration-200 hover:shadow-lg hover:scale-105">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    View Store
                </a>
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <style>
        .stat-card {
            background: linear-gradient(135deg, var(--tw-gradient-stops));
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.15);
        }
        .modern-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.07);
            transition: all 0.3s ease;
        }
        .modern-card:hover {
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        }
        .modern-input {
            @apply mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all;
        }
        .modern-button {
            @apply w-full font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105;
        }
        .tab-button {
            @apply px-6 py-3 font-medium text-gray-600 hover:text-blue-600 border-b-2 border-transparent hover:border-blue-600 transition-all;
        }
        .tab-button.active {
            @apply text-blue-600 border-blue-600;
        }
    </style>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-400 text-green-700 px-6 py-4 rounded-lg shadow-sm animate-fade-in">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3 text-xl"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 px-6 py-4 rounded-lg shadow-sm animate-fade-in">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3 text-xl"></i>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Store Overview Stats -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-4 flex items-center">
                    <i class="fas fa-chart-line mr-2 text-blue-500"></i>
                    {{ $profile->store_name ?: 'Your Store' }}
                </h3>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="stat-card from-blue-500 to-blue-600 p-6 rounded-2xl text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm font-medium">Total Products</p>
                                <p class="text-3xl font-bold mt-2">{{ $products->count() }}</p>
                            </div>
                            <div class="bg-white/20 p-4 rounded-xl">
                                <i class="fas fa-box text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card from-green-500 to-green-600 p-6 rounded-2xl text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Categories</p>
                                <p class="text-3xl font-bold mt-2">{{ $categories->count() }}</p>
                            </div>
                            <div class="bg-white/20 p-4 rounded-xl">
                                <i class="fas fa-tags text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card from-yellow-500 to-orange-500 p-6 rounded-2xl text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-sm font-medium">Pending Orders</p>
                                <p class="text-3xl font-bold mt-2">{{ $orders->where('status', 'pending')->count() }}</p>
                            </div>
                            <div class="bg-white/20 p-4 rounded-xl">
                                <i class="fas fa-clock text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card from-purple-500 to-purple-600 p-6 rounded-2xl text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Total Orders</p>
                                <p class="text-3xl font-bold mt-2">{{ $orders->count() }}</p>
                            </div>
                            <div class="bg-white/20 p-4 rounded-xl">
                                <i class="fas fa-shopping-cart text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Store Settings -->
            <div class="modern-card mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-cog mr-3 text-blue-600"></i>
                        ⚙️ Store Settings
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Configure your store's appearance and settings</p>
                </div>
                <div class="p-6">
                    <form action="{{ route('dashboard.store-settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Store Logo -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Store Logo</label>
                                @if($profile->store_logo)
                                    <div class="mb-3">
                                        <img src="{{ Storage::disk('public')->url($profile->store_logo) }}" alt="Store Logo" class="h-24 w-auto rounded-lg border border-gray-300">
                                    </div>
                                @endif
                                <input type="file" name="store_logo" accept="image/*" class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100">
                                <p class="text-xs text-gray-500 mt-1">Recommended size: 200x200px. Max 2MB</p>
                            </div>

                            <!-- Store Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Store Name</label>
                                <input type="text" name="store_name" value="{{ $profile->store_name ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- WhatsApp Number -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">WhatsApp Number</label>
                                <input type="text" name="store_whatsapp" value="{{ $profile->store_whatsapp ?? $profile->phone }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- Store Description -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Store Description</label>
                                <textarea name="store_description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $profile->store_description ?? '' }}</textarea>
                            </div>

                            <!-- Store Address -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Store Address</label>
                                <input type="text" name="store_address" value="{{ $profile->store_address ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- Store Theme -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Store Theme</label>
                                <select name="store_theme" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="default" {{ ($profile->store_theme ?? 'default') === 'default' ? 'selected' : '' }}>Default (Blue)</option>
                                    <option value="modern" {{ ($profile->store_theme ?? '') === 'modern' ? 'selected' : '' }}>Modern (Purple)</option>
                                    <option value="minimal" {{ ($profile->store_theme ?? '') === 'minimal' ? 'selected' : '' }}>Minimal (Gray)</option>
                                    <option value="vibrant" {{ ($profile->store_theme ?? '') === 'vibrant' ? 'selected' : '' }}>Vibrant (Orange)</option>
                                    <option value="dark" {{ ($profile->store_theme ?? '') === 'dark' ? 'selected' : '' }}>Dark (Black)</option>
                                </select>
                            </div>

                            <!-- Currency -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Currency</label>
                                <select name="currency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="USD" {{ ($profile->currency ?? 'USD') === 'USD' ? 'selected' : '' }}>USD ($) - US Dollar</option>
                                    <option value="EUR" {{ ($profile->currency ?? '') === 'EUR' ? 'selected' : '' }}>EUR (€) - Euro</option>
                                    <option value="GBP" {{ ($profile->currency ?? '') === 'GBP' ? 'selected' : '' }}>GBP (£) - British Pound</option>
                                    <option value="JPY" {{ ($profile->currency ?? '') === 'JPY' ? 'selected' : '' }}>JPY (¥) - Japanese Yen</option>
                                    <option value="CAD" {{ ($profile->currency ?? '') === 'CAD' ? 'selected' : '' }}>CAD (C$) - Canadian Dollar</option>
                                    <option value="AUD" {{ ($profile->currency ?? '') === 'AUD' ? 'selected' : '' }}>AUD (A$) - Australian Dollar</option>
                                    <option value="CHF" {{ ($profile->currency ?? '') === 'CHF' ? 'selected' : '' }}>CHF - Swiss Franc</option>
                                    <option value="CNY" {{ ($profile->currency ?? '') === 'CNY' ? 'selected' : '' }}>CNY (¥) - Chinese Yuan</option>
                                    <option value="INR" {{ ($profile->currency ?? '') === 'INR' ? 'selected' : '' }}>INR (₹) - Indian Rupee</option>
                                    <option value="NGN" {{ ($profile->currency ?? '') === 'NGN' ? 'selected' : '' }}>NGN (₦) - Nigerian Naira</option>
                                    <option value="ZAR" {{ ($profile->currency ?? '') === 'ZAR' ? 'selected' : '' }}>ZAR (R) - South African Rand</option>
                                    <option value="KES" {{ ($profile->currency ?? '') === 'KES' ? 'selected' : '' }}>KES (KSh) - Kenyan Shilling</option>
                                    <option value="GHS" {{ ($profile->currency ?? '') === 'GHS' ? 'selected' : '' }}>GHS (₵) - Ghanaian Cedi</option>
                                    <option value="UGX" {{ ($profile->currency ?? '') === 'UGX' ? 'selected' : '' }}>UGX (USh) - Ugandan Shilling</option>
                                </select>
                            </div>

                            <!-- Color Customization -->
                            <div class="md:col-span-2 border-t pt-4 mt-2">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">🎨 Color Customization</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Primary Color</label>
                                        <div class="flex items-center space-x-2">
                                            <input type="color" name="store_primary_color" value="{{ $profile->store_primary_color ?? '#3B82F6' }}" class="h-10 w-16 rounded border border-gray-300">
                                            <input type="text" value="{{ $profile->store_primary_color ?? '#3B82F6' }}" readonly class="flex-1 text-xs rounded border-gray-300">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Secondary Color</label>
                                        <div class="flex items-center space-x-2">
                                            <input type="color" name="store_secondary_color" value="{{ $profile->store_secondary_color ?? '#10B981' }}" class="h-10 w-16 rounded border border-gray-300">
                                            <input type="text" value="{{ $profile->store_secondary_color ?? '#10B981' }}" readonly class="flex-1 text-xs rounded border-gray-300">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Text Color</label>
                                        <div class="flex items-center space-x-2">
                                            <input type="color" name="store_text_color" value="{{ $profile->store_text_color ?? '#1F2937' }}" class="h-10 w-16 rounded border border-gray-300">
                                            <input type="text" value="{{ $profile->store_text_color ?? '#1F2937' }}" readonly class="flex-1 text-xs rounded border-gray-300">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Background Color</label>
                                        <div class="flex items-center space-x-2">
                                            <input type="color" name="store_background_color" value="{{ $profile->store_background_color ?? '#FFFFFF' }}" class="h-10 w-16 rounded border border-gray-300">
                                            <input type="text" value="{{ $profile->store_background_color ?? '#FFFFFF' }}" readonly class="flex-1 text-xs rounded border-gray-300">
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">💡 Tip: Choose colors that match your brand identity</p>
                                
                                <!-- Live Preview -->
                                <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-xs font-semibold text-gray-700 mb-3">Preview:</p>
                                    <div id="theme-preview" class="space-y-2">
                                        <div class="flex items-center space-x-2">
                                            <button type="button" id="preview-primary-btn" class="px-4 py-2 rounded-lg text-white font-semibold text-sm" style="background-color: {{ $profile->store_primary_color ?? '#3B82F6' }}">Primary Button</button>
                                            <button type="button" id="preview-secondary-btn" class="px-4 py-2 rounded-lg text-white font-semibold text-sm" style="background-color: {{ $profile->store_secondary_color ?? '#10B981' }}">Secondary Button</button>
                                        </div>
                                        <div id="preview-text" class="text-sm" style="color: {{ $profile->store_text_color ?? '#1F2937' }}">Sample text with your selected color</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delivery Settings -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Minimum Order ({{ $profile->currency_symbol ?? '$' }})</label>
                                <input type="number" name="minimum_order" value="{{ $profile->minimum_order ?? 0 }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Delivery Fee ({{ $profile->currency_symbol ?? '$' }})</label>
                                <input type="number" name="delivery_fee" value="{{ $profile->delivery_fee ?? 0 }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- Options -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Options</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="store_enabled" value="1" {{ $profile->store_enabled ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        <span class="ml-2 text-sm text-gray-700">Enable Store</span>
                                    </label>
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
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition-colors">
                                💾 Save Store Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Add Category -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Add Category</h3>
                        <form action="{{ route('dashboard.store.categories.add') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Category Name</label>
                                    <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <input type="text" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Icon (emoji or text)</label>
                                    <input type="text" name="icon" placeholder="🍕" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Add Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Add Product -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Add Product</h3>
                        <form action="{{ route('dashboard.store.products.add') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Product Name</label>
                                    <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Enter product description..."></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Category</label>
                                    <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">No Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Price ({{ $profile->currency_symbol ?? '$' }})</label>
                                        <input type="number" name="price" step="0.01" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Original Price ({{ $profile->currency_symbol ?? '$' }})</label>
                                        <input type="number" name="original_price" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Product Image</label>
                                    <input type="file" name="image" accept="image/*" class="mt-1 block w-full">
                                </div>
                                <div class="flex space-x-4">
                                    <input type="hidden" name="is_available" value="0">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_available" value="1" checked class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        <span class="ml-2 text-sm text-gray-700">Available</span>
                                    </label>
                                    <input type="hidden" name="is_featured" value="0">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        <span class="ml-2 text-sm text-gray-700">Featured</span>
                                    </label>
                                </div>
                                <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Add Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Categories</h3>
                    @if($categories->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($categories as $category)
                                <div class="border rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold">{{ $category->icon }} {{ $category->name }}</h4>
                                            @if($category->description)
                                                <p class="text-sm text-gray-600">{{ $category->description }}</p>
                                            @endif
                                            <p class="text-xs text-gray-500">{{ $category->products->count() }} products</p>
                                        </div>
                                        <div class="text-right space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                            <a href="{{ route('dashboard.store.categories.edit', $category) }}" class="text-blue-500 hover:text-blue-700 text-xs font-bold">Edit</a>
                                            <form action="{{ route('dashboard.store.categories.delete', $category) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold ml-2">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No categories created yet.</p>
                    @endif
                </div>
            </div>

            <!-- Products -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Products</h3>
                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($products as $product)
                                <div class="border rounded-lg overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-32 object-cover">
                                    @else
                                        <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500">No Image</span>
                                        </div>
                                    @endif
                                    <div class="p-4">
                                        <h4 class="font-semibold">{{ $product->name }}</h4>
                                        @if($product->category)
                                            <p class="text-xs text-gray-500">{{ $product->category->name }}</p>
                                        @endif
                                        <div class="flex items-center justify-between mt-2">
                                            <div>
                                                <span class="font-bold text-green-600">{{ $product->formatted_price }}</span>
                                                @if($product->is_on_sale)
                                                    <span class="text-sm text-gray-500 line-through ml-2">{{ $product->formatted_original_price }}</span>
                                                @endif
                                            </div>
                                            <div class="flex space-x-1">
                                                @if($product->is_featured)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Featured</span>
                                                @endif
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $product->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $product->is_available ? 'Available' : 'Unavailable' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex justify-end space-x-2 mt-3">
                                            <a href="{{ route('dashboard.store.products.edit', $product) }}" class="text-blue-500 hover:text-blue-700 text-xs font-bold">Edit</a>
                                            <form action="{{ route('dashboard.store.products.delete', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold ml-2">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No products added yet.</p>
                    @endif
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Recent Orders</h3>
                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="border rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold">Order #{{ $order->order_number }}</h4>
                                            <p class="text-sm text-gray-600">{{ $order->customer_name }} - {{ $order->customer_phone }}</p>
                                            <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold">{{ $order->formatted_total }}</p>
                                            <div class="flex items-center space-x-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800">
                                                    {{ $order->status_label }}
                                                </span>
                                                <form action="{{ route('dashboard.store.orders.status', $order) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" onchange="this.form.submit()" class="text-xs border-gray-300 rounded">
                                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                        <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                                                        <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Ready</option>
                                                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-600">Items: {{ $order->total_items }}</p>
                                        @if($order->notes)
                                            <p class="text-sm text-gray-600">Notes: {{ $order->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No orders yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Color picker synchronization and live preview
        document.addEventListener('DOMContentLoaded', function() {
            const colorInputs = document.querySelectorAll('input[type="color"]');
            
            colorInputs.forEach(colorInput => {
                const textInput = colorInput.parentElement.querySelector('input[type="text"]');
                
                if (textInput) {
                    // Update text input when color picker changes
                    colorInput.addEventListener('input', function() {
                        textInput.value = this.value.toUpperCase();
                        updatePreview();
                    });
                }
            });
            
            // Update live preview
            function updatePreview() {
                const primaryColor = document.querySelector('input[name="store_primary_color"]').value;
                const secondaryColor = document.querySelector('input[name="store_secondary_color"]').value;
                const textColor = document.querySelector('input[name="store_text_color"]').value;
                
                document.getElementById('preview-primary-btn').style.backgroundColor = primaryColor;
                document.getElementById('preview-secondary-btn').style.backgroundColor = secondaryColor;
                document.getElementById('preview-text').style.color = textColor;
            }
        });
    </script>
</x-app-layout>
