@extends('layouts.app')

@section('content')
<div class="min-h-screen flex justify-center items-start py-12 px-2 sm:px-6 lg:px-8">
    <div class="max-w-3xl w-full mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">Admin Settings</h2>
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-col lg:grid lg:grid-cols-3 gap-6">
            <div class="order-1 lg:col-span-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Settings Categories</h3>
                        <nav class="flex overflow-x-auto pb-2 space-x-4 lg:flex-col lg:space-x-0 lg:space-y-2 settings-nav" aria-label="Settings Categories">
                            <a href="#general" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 settings-nav-link" data-target="general">
                                General Settings
                            </a>
                            <a href="#payment" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 settings-nav-link" data-target="payment">
                                Payment Gateways
                            </a>
                            <a href="#branding" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 settings-nav-link" data-target="branding">
                                Branding & Logo
                            </a>
                            <a href="#pricing" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 settings-nav-link" data-target="pricing">
                                Pricing Plans
                            </a>
                            <a href="#currency" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 settings-nav-link" data-target="currency">
                                Currency Settings
                            </a>
                            <a href="#qr-purchase" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 settings-nav-link" data-target="qr-purchase">
                                Purchase QR Codes
                            </a>
                            <a href="#smtp" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 settings-nav-link" data-target="smtp">
                                SMTP Configuration
                            </a>
                            <a href="#emails" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 settings-nav-link" data-target="emails">
                                Email Management
                            </a>
                            <a href="#system" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 settings-nav-link" data-target="system">
                                System Upgrade
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="order-2 lg:col-span-2">
                <!-- General Settings -->
                <form method="POST" action="{{ route('admin.settings.update') }}" id="general-form">
                    @csrf
                    <div id="general-section" class="settings-section bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">General Settings</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="site_name" class="block text-sm font-medium text-gray-700">Site Name</label>
                                    <input type="text" name="site_name" id="site_name" value="{{ $settings['general']['site_name'] ?? 'Whiteray Smart Tag' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="contact_email" class="block text-sm font-medium text-gray-700">Contact Email</label>
                                    <input type="email" name="contact_email" id="contact_email" value="{{ $settings['general']['contact_email'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="contact_phone" class="block text-sm font-medium text-gray-700">Contact Phone</label>
                                    <input type="text" name="contact_phone" id="contact_phone" value="{{ $settings['general']['contact_phone'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="trial_days" class="block text-sm font-medium text-gray-700">Trial Days</label>
                                    <input type="number" name="trial_days" id="trial_days" min="0" max="365" value="{{ $settings['general']['trial_days'] ?? '7' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="site_description" class="block text-sm font-medium text-gray-700">Site Description</label>
                                <textarea name="site_description" id="site_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $settings['general']['site_description'] ?? 'Smart QR Code Management System' }}</textarea>
                            </div>
                            <div class="mt-6 text-right">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded">Save General Settings</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Payment Gateway Settings -->
                <form method="POST" action="{{ route('admin.settings.update') }}" id="payment-form">
                    @csrf
                    <div id="payment-section" class="settings-section bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6" style="display: none;">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Payment Gateway Configuration</h3>
                            <p class="text-sm text-gray-600 mb-6">Configure payment gateways for processing transactions. Pricing is managed in the Pricing Plans section.</p>
                            
                            <!-- Flutterwave Settings -->
                            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-medium text-gray-900">Flutterwave Configuration</h4>
                                    <a href="{{ route('test.flutterwave.payment') }}" class="bg-blue-500 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">
                                        Test Flutterwave Payment
                                    </a>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="flutterwave_active" class="block text-sm font-medium text-gray-700">Active</label>
                                        <input type="checkbox" name="flutterwave_active" id="flutterwave_active" value="1"
                                            {{ !empty($settings['payment']['flutterwave_active']) && $settings['payment']['flutterwave_active'] ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-600">Enable Flutterwave as a payment gateway</span>
                                    </div>
                                    <div></div>
                                    <div>
                                        <label for="flutterwave_public_key" class="block text-sm font-medium text-gray-700">Public Key</label>
                                        <input type="text" name="flutterwave_public_key" id="flutterwave_public_key" 
                                               value="{{ $settings['payment']['flutterwave_public_key'] ?? '' }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label for="flutterwave_secret_key" class="block text-sm font-medium text-gray-700">Secret Key</label>
                                        <input type="password" name="flutterwave_secret_key" id="flutterwave_secret_key" 
                                               value="{{ $settings['payment']['flutterwave_secret_key'] ?? '' }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label for="flutterwave_encryption_key" class="block text-sm font-medium text-gray-700">Encryption Key</label>
                                        <input type="password" name="flutterwave_encryption_key" id="flutterwave_encryption_key" 
                                               value="{{ $settings['payment']['flutterwave_encryption_key'] ?? '' }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label for="flutterwave_environment" class="block text-sm font-medium text-gray-700">Environment</label>
                                        <select name="flutterwave_environment" id="flutterwave_environment" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="sandbox" {{ ($settings['payment']['flutterwave_environment'] ?? 'sandbox') === 'sandbox' ? 'selected' : '' }}>Sandbox</option>
                                            <option value="live" {{ ($settings['payment']['flutterwave_environment'] ?? 'sandbox') === 'live' ? 'selected' : '' }}>Live</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 text-right">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded">Save Payment Settings</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Branding & Logo Management -->
                <form method="POST" action="{{ route('admin.settings.update') }}" id="branding-form" enctype="multipart/form-data">
                    @csrf
                    <div id="branding-section" class="settings-section bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6" style="display: none;">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Branding & Logo Management</h3>
                            <p class="text-sm text-gray-600 mb-6">These settings control the Site Logo and Favicon displayed on your landing page and website.</p>
                            
                            <!-- Logo Management -->
                            <div class="mb-6 p-4 bg-purple-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">Logo Management</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Site Logo -->
                                    <div>
                                        <label for="site_logo" class="block text-sm font-medium text-gray-700 mb-2">Site Logo</label>
                                        <div class="flex flex-col">
                                            <div class="mb-3 flex justify-center">
                                                @if(isset($settings['branding']['main_logo']) && $settings['branding']['main_logo'])
                                                    <div class="relative">
                                                        <img src="{{ asset('storage/' . $settings['branding']['main_logo']) }}" alt="Current Logo" class="h-16 w-auto border border-gray-300 rounded">
                                                        <form action="{{ route('admin.settings.logo.delete') }}" method="POST" class="absolute -top-2 -right-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="type" value="main_logo">
                                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white rounded-full p-1" onclick="return confirm('Are you sure you want to delete this logo?')">
                                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="h-16 w-16 bg-gray-200 border border-gray-300 rounded flex items-center justify-center">
                                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <form action="{{ route('admin.settings.logo.upload') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="type" value="main_logo">
                                                <div class="file-input-container">
                                                    <input type="file" name="logo" id="site_logo" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                                    <p class="text-xs text-gray-500 mt-1">Recommended: PNG or SVG, max 2MB</p>
                                                </div>
                                                <button type="submit" class="mt-2 w-full bg-blue-500 hover:bg-blue-700 text-white text-xs px-3 py-2 rounded">
                                                    Upload Logo
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <!-- Favicon -->
                                    <div>
                                        <label for="favicon" class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                                        <div class="flex flex-col">
                                            <div class="mb-3 flex justify-center">
                                                @if(isset($settings['branding']['favicon']) && $settings['branding']['favicon'])
                                                    <div class="relative">
                                                        <img src="{{ asset('storage/' . $settings['branding']['favicon']) }}" alt="Current Favicon" class="h-12 w-12 border border-gray-300 rounded">
                                                        <form action="{{ route('admin.settings.logo.delete') }}" method="POST" class="absolute -top-2 -right-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="type" value="favicon">
                                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white rounded-full p-1" onclick="return confirm('Are you sure you want to delete this favicon?')">
                                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="h-12 w-12 bg-gray-200 border border-gray-300 rounded flex items-center justify-center">
                                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <form action="{{ route('admin.settings.logo.upload') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="type" value="favicon">
                                                <div class="file-input-container">
                                                    <input type="file" name="logo" id="favicon" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                                    <p class="text-xs text-gray-500 mt-1">Recommended: ICO or PNG, 32x32px</p>
                                                </div>
                                                <button type="submit" class="mt-2 w-full bg-blue-500 hover:bg-blue-700 text-white text-xs px-3 py-2 rounded">
                                                    Upload Favicon
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <!-- Admin UI Image -->
                                    <div>
                                        <label for="admin_ui_image" class="block text-sm font-medium text-gray-700 mb-2">Admin UI Image</label>
                                        <div class="flex flex-col">
                                            <div class="mb-3 flex justify-center">
                                                @if(isset($settings['branding']['landing_hero']) && $settings['branding']['landing_hero'])
                                                    <div class="relative">
                                                        <img src="{{ asset('storage/' . $settings['branding']['landing_hero']) }}" alt="Current Admin UI Image" class="h-16 w-auto border border-gray-300 rounded">
                                                        <form action="{{ route('admin.settings.logo.delete') }}" method="POST" class="absolute -top-2 -right-2">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="type" value="landing_hero">
                                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white rounded-full p-1" onclick="return confirm('Are you sure you want to delete this image?')">
                                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @else
                                                    <div class="h-16 w-24 bg-gray-200 border border-gray-300 rounded flex items-center justify-center">
                                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <form action="{{ route('admin.settings.logo.upload') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="type" value="landing_hero">
                                                <div class="file-input-container">
                                                    <input type="file" name="logo" id="admin_ui_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                                    <p class="text-xs text-gray-500 mt-1">Recommended: JPG or PNG, max 2MB</p>
                                                </div>
                                                <button type="submit" class="mt-2 w-full bg-blue-500 hover:bg-blue-700 text-white text-xs px-3 py-2 rounded">
                                                    Upload Admin UI Image
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- JavaScript for file input display -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Get all file inputs in the branding section
                                    const fileInputs = document.querySelectorAll('#branding-section input[type="file"]');
                                    
                                    // Add event listeners to each file input
                                    fileInputs.forEach(input => {
                                        const container = input.closest('.file-input-container');
                                        
                                        // Create a span to display the file name if it doesn't exist
                                        if (!container.querySelector('.file-name')) {
                                            const fileNameDisplay = document.createElement('span');
                                            fileNameDisplay.className = 'file-name text-xs text-gray-600 mt-1 block';
                                            container.appendChild(fileNameDisplay);
                                        }
                                        
                                        // Add change event listener
                                        input.addEventListener('change', function() {
                                            const fileNameDisplay = container.querySelector('.file-name');
                                            if (this.files.length > 0) {
                                                fileNameDisplay.textContent = 'Selected: ' + this.files[0].name;
                                            } else {
                                                fileNameDisplay.textContent = 'No file selected';
                                            }
                                        });
                                    });
                                });
                            </script>

                            <!-- Site Information -->
                            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">Site Information</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="branding_site_name" class="block text-sm font-medium text-gray-700">Site Name</label>
                                        <input type="text" name="site_name" id="branding_site_name" value="{{ $settings['general']['site_name'] ?? 'Whiteray Smart Tag' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <p class="text-xs text-gray-500 mt-1">Appears in navigation and footer</p>
                                    </div>
                                    <div>
                                        <label for="branding_tagline" class="block text-sm font-medium text-gray-700">Tagline</label>
                                        <input type="text" name="site_tagline" id="branding_tagline" value="{{ $settings['branding']['site_tagline'] ?? 'Smart QR Code Solutions' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <p class="text-xs text-gray-500 mt-1">Short catchy phrase for your brand</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label for="branding_site_description" class="block text-sm font-medium text-gray-700">Site Description</label>
                                    <textarea name="site_description" id="branding_site_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $settings['general']['site_description'] ?? 'Smart QR Code Management System' }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Appears in hero section and page title</p>
                                </div>
                            </div>

                            <!-- Color Scheme -->
                            <div class="mb-6 p-4 bg-green-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">Color Scheme</h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="primary_color" class="block text-sm font-medium text-gray-700">Primary Color</label>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <input type="color" name="primary_color" id="primary_color" value="{{ $settings['branding']['primary_color'] ?? '#3B82F6' }}" class="h-10 w-16 rounded border border-gray-300">
                                            <input type="text" name="primary_color_hex" id="primary_color_hex" value="{{ $settings['branding']['primary_color'] ?? '#3B82F6' }}" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Main brand color</p>
                                    </div>
                                    <div>
                                        <label for="secondary_color" class="block text-sm font-medium text-gray-700">Secondary Color</label>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <input type="color" name="secondary_color" id="secondary_color" value="{{ $settings['branding']['secondary_color'] ?? '#10B981' }}" class="h-10 w-16 rounded border border-gray-300">
                                            <input type="text" name="secondary_color_hex" id="secondary_color_hex" value="{{ $settings['branding']['secondary_color'] ?? '#10B981' }}" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Accent color</p>
                                    </div>
                                    <div>
                                        <label for="accent_color" class="block text-sm font-medium text-gray-700">Accent Color</label>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <input type="color" name="accent_color" id="accent_color" value="{{ $settings['branding']['accent_color'] ?? '#F59E0B' }}" class="h-10 w-16 rounded border border-gray-300">
                                            <input type="text" name="accent_color_hex" id="accent_color_hex" value="{{ $settings['branding']['accent_color'] ?? '#F59E0B' }}" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Highlight color</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Social Media Links -->
                            <div class="mb-6 p-4 bg-indigo-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">Social Media Links</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="facebook_url" class="block text-sm font-medium text-gray-700">Facebook URL</label>
                                        <input type="url" name="facebook_url" id="facebook_url" value="{{ $settings['branding']['facebook_url'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label for="twitter_url" class="block text-sm font-medium text-gray-700">Twitter URL</label>
                                        <input type="url" name="twitter_url" id="twitter_url" value="{{ $settings['branding']['twitter_url'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label for="linkedin_url" class="block text-sm font-medium text-gray-700">LinkedIn URL</label>
                                        <input type="url" name="linkedin_url" id="linkedin_url" value="{{ $settings['branding']['linkedin_url'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label for="instagram_url" class="block text-sm font-medium text-gray-700">Instagram URL</label>
                                        <input type="url" name="instagram_url" id="instagram_url" value="{{ $settings['branding']['instagram_url'] ?? '' }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Settings -->
                            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">Footer Settings</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label for="footer_text" class="block text-sm font-medium text-gray-700">Footer Text</label>
                                        <textarea name="footer_text" id="footer_text" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $settings['branding']['footer_text'] ?? '© 2024 Whiteray Smart Tag. All rights reserved.' }}</textarea>
                                        <p class="text-xs text-gray-500 mt-1">Copyright text in footer</p>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="show_powered_by" id="show_powered_by" value="1" {{ !empty($settings['branding']['show_powered_by']) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <label for="show_powered_by" class="ml-2 text-sm text-gray-700">Show "Powered by" link in footer</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 text-right">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded">Save Branding Settings</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Pricing Plans Section -->
                <div id="pricing-section" class="settings-section bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6" style="display: none;">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Pricing Plans Management</h3>
                            <button onclick="openPricingModal()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Add New Plan
                            </button>
                        </div>
                        
                        <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-sm text-yellow-800">
                                <strong>Note:</strong> For users to access the WhatsApp Store feature, they must have either a Free Trial plan or Premium plan with WhatsApp Store enabled.
                            </p>
                        </div>

                        <!-- Pricing Plans List -->
                        <div class="space-y-4" id="pricing-plans-list">
                            @if(isset($pricingPlans) && $pricingPlans->count() > 0)
                                @foreach($pricingPlans as $plan)
                                    <div class="border border-gray-200 rounded-lg p-4 {{ !$plan->is_active ? 'opacity-50' : '' }}" data-plan-id="{{ $plan->id }}">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2 mb-2">
                                                    <h4 class="font-semibold text-lg">{{ $plan->name }}</h4>
                                                    @if($plan->is_popular)
                                                        <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">Popular</span>
                                                    @endif
                                                    @if($plan->is_free_trial)
                                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Free Trial</span>
                                                    @endif
                                                    @if($plan->has_whatsapp_store)
                                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">WhatsApp Store</span>
                                                    @endif
                                                    @if(!$plan->is_active)
                                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Inactive</span>
                                                    @endif
                                                </div>
                                                <div class="text-2xl font-bold text-gray-900 mb-2">
                                                    {{ $plan->formatted_price }}<span class="text-base font-normal text-gray-600">{{ $plan->billing_cycle_text }}</span>
                                                </div>
                                                @if($plan->description)
                                                    <p class="text-gray-600 mb-2">{{ $plan->description }}</p>
                                                @endif
                                                @if($plan->features && count($plan->features) > 0)
                                                    <div class="mt-2">
                                                        <p class="text-sm font-medium text-gray-700 mb-1">Features:</p>
                                                        <ul class="text-sm text-gray-600 space-y-1">
                                                            @foreach(array_slice($plan->features, 0, 3) as $feature)
                                                                <li class="flex items-center">
                                                                    <svg class="w-3 h-3 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                    </svg>
                                                                    {{ $feature }}
                                                                </li>
                                                            @endforeach
                                                            @if(count($plan->features) > 3)
                                                                <li class="text-xs text-gray-500">+{{ count($plan->features) - 3 }} more features</li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex flex-col space-y-2 ml-4">
                                                <button onclick="editPricingPlan({{ $plan->id }})" class="bg-blue-500 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded">
                                                    Edit
                                                </button>
                                                <form method="POST" action="{{ route('admin.pricing-plans.toggle', $plan) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white text-xs px-3 py-1 rounded w-full">
                                                        {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.pricing-plans.delete', $plan) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this pricing plan?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-xs px-3 py-1 rounded w-full">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    No pricing plans created yet. Click "Add New Plan" to get started.
                                </div>
                            @endif
                        </div>

                        <!-- Drag and Drop Reordering -->
                        @if(isset($pricingPlans) && $pricingPlans->count() > 1)
                            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">Plan Ordering</h4>
                                <p class="text-sm text-gray-600 mb-3">Drag and drop to reorder pricing plans. The order will be reflected on your public pricing page.</p>
                                <button onclick="enableDragDrop()" class="bg-blue-500 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded">
                                    Enable Drag & Drop Reordering
                                </button>
                                <button onclick="savePlanOrder()" class="bg-green-500 hover:bg-green-700 text-white text-sm px-4 py-2 rounded ml-2" style="display: none;" id="save-order-btn">
                                    Save Order
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Currency Settings -->
                <form method="POST" action="{{ route('admin.settings.update') }}" id="currency-form">
                    @csrf
                    <div id="currency-section" class="settings-section bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6" style="display: none;">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Currency Settings</h3>
                            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">Select Currency</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="default_currency" class="block text-sm font-medium text-gray-700">Default Currency</label>
                                        <select name="default_currency" id="default_currency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select Currency</option>
                                            <option value="USD" {{ ($settings['currency']['default_currency'] ?? '') === 'USD' ? 'selected' : '' }}>USD - US Dollar ($)</option>
                                            <option value="EUR" {{ ($settings['currency']['default_currency'] ?? '') === 'EUR' ? 'selected' : '' }}>EUR - Euro (€)</option>
                                            <option value="GBP" {{ ($settings['currency']['default_currency'] ?? '') === 'GBP' ? 'selected' : '' }}>GBP - British Pound (£)</option>
                                            <option value="UGX" {{ ($settings['currency']['default_currency'] ?? '') === 'UGX' ? 'selected' : '' }}>UGX - Ugandan Shilling (UGX)</option>
                                            <option value="KES" {{ ($settings['currency']['default_currency'] ?? '') === 'KES' ? 'selected' : '' }}>KES - Kenyan Shilling (KSh)</option>
                                            <option value="TZS" {{ ($settings['currency']['default_currency'] ?? '') === 'TZS' ? 'selected' : '' }}>TZS - Tanzanian Shilling (TSh)</option>
                                            <option value="RWF" {{ ($settings['currency']['default_currency'] ?? '') === 'RWF' ? 'selected' : '' }}>RWF - Rwandan Franc (RWF)</option>
                                            <option value="NGN" {{ ($settings['currency']['default_currency'] ?? '') === 'NGN' ? 'selected' : '' }}>NGN - Nigerian Naira (₦)</option>
                                            <option value="GHS" {{ ($settings['currency']['default_currency'] ?? '') === 'GHS' ? 'selected' : '' }}>GHS - Ghanaian Cedi (GH₵)</option>
                                            <option value="ZAR" {{ ($settings['currency']['default_currency'] ?? '') === 'ZAR' ? 'selected' : '' }}>ZAR - South African Rand (R)</option>
                                            <option value="XAF" {{ ($settings['currency']['default_currency'] ?? '') === 'XAF' ? 'selected' : '' }}>XAF - Central African CFA Franc (FCFA)</option>
                                            <option value="XOF" {{ ($settings['currency']['default_currency'] ?? '') === 'XOF' ? 'selected' : '' }}>XOF - West African CFA Franc (CFA)</option>
                                            <option value="EGP" {{ ($settings['currency']['default_currency'] ?? '') === 'EGP' ? 'selected' : '' }}>EGP - Egyptian Pound (E£)</option>
                                            <option value="MAD" {{ ($settings['currency']['default_currency'] ?? '') === 'MAD' ? 'selected' : '' }}>MAD - Moroccan Dirham (MAD)</option>
                                            <option value="ETB" {{ ($settings['currency']['default_currency'] ?? '') === 'ETB' ? 'selected' : '' }}>ETB - Ethiopian Birr (Br)</option>
                                            <option value="CUSTOM" {{ ($settings['currency']['default_currency'] ?? '') === 'CUSTOM' ? 'selected' : '' }}>Custom Currency</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="currency_position" class="block text-sm font-medium text-gray-700">Symbol Position</label>
                                        <select name="currency_position" id="currency_position" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="before" {{ ($settings['currency']['currency_position'] ?? 'before') === 'before' ? 'selected' : '' }}>Before Amount ($100)</option>
                                            <option value="after" {{ ($settings['currency']['currency_position'] ?? 'before') === 'after' ? 'selected' : '' }}>After Amount (100$)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label for="currency_symbol" class="block text-sm font-medium text-gray-700">Currency Symbol</label>
                                    <input type="text" name="currency_symbol" id="currency_symbol" value="{{ $settings['currency']['currency_symbol'] ?? '$' }}" placeholder="$" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-sm text-gray-500">This symbol will be displayed with prices throughout the application</p>
                                </div>
                            </div>
                            <div class="mt-6 text-right">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded">Save Currency Settings</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Purchase QR Codes Settings -->
                <form method="POST" action="{{ route('admin.settings.update') }}" id="qr-purchase-form">
                    @csrf
                    <div id="qr-purchase-section" class="settings-section bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6" style="display: none;">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Purchase QR Codes Settings</h3>
                            <p class="text-sm text-gray-600 mb-6">Configure settings for the QR code purchasing page that appears on your landing page. These settings control pricing, packages, and features displayed to customers.</p>
                            
                            <!-- QR Code Packages -->
                            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">QR Code Packages & Pricing</h4>
                                <p class="text-sm text-gray-600 mb-4">Configure the three main packages displayed on your QR purchase page. Prices will use the currency selected in Currency Settings.</p>
                                
                                <!-- Single QR Package -->
                                <div class="mb-6 p-4 bg-white rounded-lg border">
                                    <h5 class="font-medium text-gray-800 mb-3">📱 Single QR Code Package</h5>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="single_qr_price" class="block text-sm font-medium text-gray-700">Price ({{ $settings['currency']['default_currency'] ?? 'USD' }})</label>
                                            <div class="mt-1 relative rounded-md shadow-sm">
                                                <div class="absolute inset-y-0 {{ ($settings['currency']['currency_position'] ?? 'before') === 'before' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm">{{ $settings['currency']['currency_symbol'] ?? '$' }}</span>
                                                </div>
                                                <input type="number" name="single_qr_price" id="single_qr_price"
                                                       value="{{ $settings['qr_purchase']['single_qr_price'] ?? '4.99' }}"
                                                       step="0.01" min="0"
                                                       class="{{ ($settings['currency']['currency_position'] ?? 'before') === 'before' ? 'pl-7' : 'pr-7' }} mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="single_qr_description" class="block text-sm font-medium text-gray-700">Package Description</label>
                                            <input type="text" name="single_qr_description" id="single_qr_description"
                                                   value="{{ $settings['qr_purchase']['single_qr_description'] ?? 'Perfect for individuals' }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                    <!-- Removed duplicate single_qr_description field -->
                                </div>

                                <!-- Business Pack -->
                                <div class="mb-6 p-4 bg-white rounded-lg border">
                                    <h5 class="font-medium text-gray-800 mb-3">🏢 Business Pack (10 QR Codes)</h5>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="business_pack_price" class="block text-sm font-medium text-gray-700">Price ({{ $settings['currency']['default_currency'] ?? 'USD' }})</label>
                                            <div class="mt-1 relative rounded-md shadow-sm">
                                                <div class="absolute inset-y-0 {{ ($settings['currency']['currency_position'] ?? 'before') === 'before' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm">{{ $settings['currency']['currency_symbol'] ?? '$' }}</span>
                                                </div>
                                                <input type="number" name="business_pack_price" id="business_pack_price"
                                                       value="{{ $settings['qr_purchase']['business_pack_price'] ?? '39.99' }}"
                                                       step="0.01" min="0"
                                                       class="{{ ($settings['currency']['currency_position'] ?? 'before') === 'before' ? 'pl-7' : 'pr-7' }} mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="business_pack_savings" class="block text-sm font-medium text-gray-700">Savings Badge</label>
                                            <input type="text" name="business_pack_savings" id="business_pack_savings"
                                                   value="{{ $settings['qr_purchase']['business_pack_savings'] ?? '20% off' }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div>
                                            <label for="business_pack_description" class="block text-sm font-medium text-gray-700">Package Description</label>
                                            <input type="text" name="business_pack_description" id="business_pack_description"
                                                   value="{{ $settings['qr_purchase']['business_pack_description'] ?? 'Great for small businesses' }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                </div>

                                <!-- Enterprise Pack -->
                                <div class="mb-6 p-4 bg-white rounded-lg border">
                                    <h5 class="font-medium text-gray-800 mb-3">🏭 Enterprise Pack (50 QR Codes)</h5>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="enterprise_pack_price" class="block text-sm font-medium text-gray-700">Price ({{ $settings['currency']['default_currency'] ?? 'USD' }})</label>
                                            <div class="mt-1 relative rounded-md shadow-sm">
                                                <div class="absolute inset-y-0 {{ ($settings['currency']['currency_position'] ?? 'before') === 'before' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                                                    <span class="text-gray-500 sm:text-sm">{{ $settings['currency']['currency_symbol'] ?? '$' }}</span>
                                                </div>
                                                <input type="number" name="enterprise_pack_price" id="enterprise_pack_price"
                                                       value="{{ $settings['qr_purchase']['enterprise_pack_price'] ?? '149.99' }}"
                                                       step="0.01" min="0"
                                                       class="{{ ($settings['currency']['currency_position'] ?? 'before') === 'before' ? 'pl-7' : 'pr-7' }} mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            </div>
                                        </div>
                                        <div>
                                            <label for="enterprise_pack_savings" class="block text-sm font-medium text-gray-700">Savings Badge</label>
                                            <input type="text" name="enterprise_pack_savings" id="enterprise_pack_savings"
                                                   value="{{ $settings['qr_purchase']['enterprise_pack_savings'] ?? '40% off' }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div>
                                            <label for="enterprise_pack_description" class="block text-sm font-medium text-gray-700">Package Description</label>
                                            <input type="text" name="enterprise_pack_description" id="enterprise_pack_description"
                                                   value="{{ $settings['qr_purchase']['enterprise_pack_description'] ?? 'Perfect for large organizations' }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="enterprise_pack_popular" id="enterprise_pack_popular" value="1" 
                                                   {{ !empty($settings['qr_purchase']['enterprise_pack_popular']) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <label for="enterprise_pack_popular" class="ml-2 text-sm text-gray-700">Mark as "Most Popular" (shows badge and highlight)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Page Content Settings -->
                            <div class="mb-6 p-4 bg-green-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">QR Purchase Page Content</h4>
                                <p class="text-sm text-gray-600 mb-4">Customize the content displayed on your QR code purchase page.</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="qr_purchase_page_title" class="block text-sm font-medium text-gray-700">Page Title</label>
                                        <input type="text" name="qr_purchase_page_title" id="qr_purchase_page_title"
                                               value="{{ $settings['qr_purchase']['qr_purchase_page_title'] ?? 'Purchase Additional QR Codes' }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <p class="text-xs text-gray-500 mt-1">Main heading on the purchase page</p>
                                    </div>
                                    <div>
                                        <label for="qr_purchase_page_subtitle" class="block text-sm font-medium text-gray-700">Page Subtitle</label>
                                        <input type="text" name="qr_purchase_page_subtitle" id="qr_purchase_page_subtitle"
                                               value="{{ $settings['qr_purchase']['qr_purchase_page_subtitle'] ?? 'Get more QR codes for your business or organization' }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <p class="text-xs text-gray-500 mt-1">Subtitle text below the main heading</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <label for="currency_info_text" class="block text-sm font-medium text-gray-700">Multi-Currency Information Text</label>
                                    <textarea name="currency_info_text" id="currency_info_text" rows="2" 
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $settings['qr_purchase']['currency_info_text'] ?? 'Prices are automatically adjusted based on your region and preferred currency settings.' }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Text displayed in the currency information section</p>
                                </div>
                            </div>

                            <!-- "What You Get" Features Section -->
                            <div class="mb-6 p-4 bg-purple-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">"What You Get" Features Section</h4>
                                <p class="text-sm text-gray-600 mb-4">Customize the three main features displayed in the "What You Get" section of the purchase page.</p>
                                
                                <!-- Feature 1: Permanent & Secure -->
                                <div class="mb-4 p-3 bg-white rounded border">
                                    <h5 class="font-medium text-gray-800 mb-2">🔒 Feature 1: Security</h5>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label for="feature1_title" class="block text-sm font-medium text-gray-700">Title</label>
                                            <input type="text" name="feature1_title" id="feature1_title" 
                                                   value="{{ $settings['qr_purchase']['feature1_title'] ?? 'Permanent & Secure' }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label for="feature1_description" class="block text-sm font-medium text-gray-700">Description</label>
                                            <input type="text" name="feature1_description" id="feature1_description" 
                                                   value="{{ $settings['qr_purchase']['feature1_description'] ?? 'Each QR code is unique and permanently yours once claimed' }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                </div>

                                <!-- Feature 2: Analytics -->
                                <div class="mb-4 p-3 bg-white rounded border">
                                    <h5 class="font-medium text-gray-800 mb-2">📊 Feature 2: Analytics</h5>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label for="feature2_title" class="block text-sm font-medium text-gray-700">Title</label>
                                            <input type="text" name="feature2_title" id="feature2_title" 
                                                   value="{{ $settings['qr_purchase']['feature2_title'] ?? 'Analytics Included' }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label for="feature2_description" class="block text-sm font-medium text-gray-700">Description</label>
                                            <input type="text" name="feature2_description" id="feature2_description" 
                                                   value="{{ $settings['qr_purchase']['feature2_description'] ?? 'Track scans, views, and engagement for each QR code' }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                </div>

                                <!-- Feature 3: Mobile Optimized -->
                                <div class="mb-4 p-3 bg-white rounded border">
                                    <h5 class="font-medium text-gray-800 mb-2">📱 Feature 3: Mobile Experience</h5>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label for="feature3_title" class="block text-sm font-medium text-gray-700">Title</label>
                                            <input type="text" name="feature3_title" id="feature3_title" 
                                                   value="{{ $settings['qr_purchase']['feature3_title'] ?? 'Mobile Optimized' }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label for="feature3_description" class="block text-sm font-medium text-gray-700">Description</label>
                                            <input type="text" name="feature3_description" id="feature3_description" 
                                                   value="{{ $settings['qr_purchase']['feature3_description'] ?? 'Perfect viewing experience on all devices' }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ Section -->
                            <div class="mb-6 p-4 bg-yellow-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">Frequently Asked Questions</h4>
                                <p class="text-sm text-gray-600 mb-4">Customize the FAQ section displayed on your QR purchase page.</p>
                                
                                <!-- FAQ 1 -->
                                <div class="mb-4 p-3 bg-white rounded border">
                                    <h5 class="font-medium text-gray-800 mb-2">❓ FAQ 1</h5>
                                    <div class="space-y-3">
                                        <div>
                                            <label for="faq1_question" class="block text-sm font-medium text-gray-700">Question</label>
                                            <input type="text" name="faq1_question" id="faq1_question" 
                                                   value="{{ $settings['qr_purchase']['faq1_question'] ?? 'How do QR codes work?' }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label for="faq1_answer" class="block text-sm font-medium text-gray-700">Answer</label>
                                            <textarea name="faq1_answer" id="faq1_answer" rows="2" 
                                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $settings['qr_purchase']['faq1_answer'] ?? 'Each QR code is unique and can be claimed by scanning it. Once claimed, it becomes a permanent digital profile that you can customize and share.' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ 2 -->
                                <div class="mb-4 p-3 bg-white rounded border">
                                    <h5 class="font-medium text-gray-800 mb-2">❓ FAQ 2</h5>
                                    <div class="space-y-3">
                                        <div>
                                            <label for="faq2_question" class="block text-sm font-medium text-gray-700">Question</label>
                                            <input type="text" name="faq2_question" id="faq2_question" 
                                                   value="{{ $settings['qr_purchase']['faq2_question'] ?? 'Can I print the QR codes?' }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label for="faq2_answer" class="block text-sm font-medium text-gray-700">Answer</label>
                                            <textarea name="faq2_answer" id="faq2_answer" rows="2" 
                                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $settings['qr_purchase']['faq2_answer'] ?? 'Yes! You can download your QR codes in high-resolution PNG or SVG format, perfect for printing on business cards, stickers, or any physical item.' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ 3 -->
                                <div class="mb-4 p-3 bg-white rounded border">
                                    <h5 class="font-medium text-gray-800 mb-2">❓ FAQ 3</h5>
                                    <div class="space-y-3">
                                        <div>
                                            <label for="faq3_question" class="block text-sm font-medium text-gray-700">Question</label>
                                            <input type="text" name="faq3_question" id="faq3_question" 
                                                   value="{{ $settings['qr_purchase']['faq3_question'] ?? 'What currencies do you accept?' }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label for="faq3_answer" class="block text-sm font-medium text-gray-700">Answer</label>
                                            <textarea name="faq3_answer" id="faq3_answer" rows="2" 
                                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $settings['qr_purchase']['faq3_answer'] ?? 'We support multiple currencies including USD, EUR, GBP, NGN, and many others through our secure payment gateway. Prices are automatically converted based on your settings.' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQ 4 -->
                                <div class="mb-4 p-3 bg-white rounded border">
                                    <h5 class="font-medium text-gray-800 mb-2">❓ FAQ 4</h5>
                                    <div class="space-y-3">
                                        <div>
                                            <label for="faq4_question" class="block text-sm font-medium text-gray-700">Question</label>
                                            <input type="text" name="faq4_question" id="faq4_question" 
                                                   value="{{ $settings['qr_purchase']['faq4_question'] ?? 'What happens after purchase?' }}"
                                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <div>
                                            <label for="faq4_answer" class="block text-sm font-medium text-gray-700">Answer</label>
                                            <textarea name="faq4_answer" id="faq4_answer" rows="2" 
                                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $settings['qr_purchase']['faq4_answer'] ?? 'Your QR codes will be immediately available in your dashboard. You can download them, view analytics, and manage your digital profiles.' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Purchase Statistics -->
                            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">Purchase Statistics (Read-only)</h4>
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-blue-600">{{ $purchaseStats['total_purchases'] ?? '0' }}</div>
                                        <div class="text-sm text-gray-600">Total Purchases</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-green-600">{{ $purchaseStats['total_qr_codes'] ?? '0' }}</div>
                                        <div class="text-sm text-gray-600">QR Codes Sold</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-purple-600">{{ $purchaseStats['total_revenue'] ?? '$0.00' }}</div>
                                        <div class="text-sm text-gray-600">Total Revenue</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-orange-600">{{ $purchaseStats['avg_order_value'] ?? '$0.00' }}</div>
                                        <div class="text-sm text-gray-600">Avg Order Value</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 text-right">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded">Save QR Purchase Settings</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- System Upgrade -->
                
                <!-- SMTP Configuration Section -->
                <form method="POST" action="{{ route('admin.settings.update') }}" id="smtp-form">
                    @csrf
                    <div id="smtp-section" class="settings-section bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6" style="display: none;">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">SMTP Configuration</h3>
                            <p class="text-sm text-gray-600 mb-6">Configure SMTP settings for sending emails. These settings control how the system sends welcome emails, expiry warnings, and payment receipts.</p>
                            
                            <!-- Current SMTP Status -->
                            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">📧 Current SMTP Status</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-700"><strong>MAIL_MAILER:</strong> {{ config('mail.default') }}</p>
                                        <p class="text-sm text-gray-700"><strong>MAIL_HOST:</strong> {{ config('mail.mailers.smtp.host') ?: 'Not configured' }}</p>
                                        <p class="text-sm text-gray-700"><strong>MAIL_PORT:</strong> {{ config('mail.mailers.smtp.port') ?: 'Not configured' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-700"><strong>MAIL_FROM_ADDRESS:</strong> {{ config('mail.from.address') ?: 'Not configured' }}</p>
                                        <p class="text-sm text-gray-700"><strong>MAIL_FROM_NAME:</strong> {{ config('mail.from.name') ?: 'Not configured' }}</p>
                                        <p class="text-sm text-gray-700"><strong>MAIL_ENCRYPTION:</strong> {{ config('mail.mailers.smtp.encryption') ?: 'None' }}</p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    @if(config('mail.mailers.smtp.host') && config('mail.from.address'))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            ✓ SMTP Configured
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            ⚠ SMTP Not Configured
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- SMTP Configuration Form -->
                            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">⚙️ SMTP Settings</h4>
                                <p class="text-sm text-gray-600 mb-4">Configure your SMTP server settings. These will update your .env file automatically.</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- SMTP Host -->
                                    <div>
                                        <label for="smtp_host" class="block text-sm font-medium text-gray-700">SMTP Host</label>
                                        <input type="text" name="smtp_host" id="smtp_host" 
                                               value="{{ config('mail.mailers.smtp.host') }}"
                                               placeholder="smtp.gmail.com"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <p class="text-xs text-gray-500 mt-1">Your SMTP server hostname</p>
                                    </div>

                                    <!-- SMTP Port -->
                                    <div>
                                        <label for="smtp_port" class="block text-sm font-medium text-gray-700">SMTP Port</label>
                                        <select name="smtp_port" id="smtp_port" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="587" {{ config('mail.mailers.smtp.port') == '587' ? 'selected' : '' }}>587 (TLS)</option>
                                            <option value="465" {{ config('mail.mailers.smtp.port') == '465' ? 'selected' : '' }}>465 (SSL)</option>
                                            <option value="25" {{ config('mail.mailers.smtp.port') == '25' ? 'selected' : '' }}>25 (No encryption)</option>
                                            <option value="2525" {{ config('mail.mailers.smtp.port') == '2525' ? 'selected' : '' }}>2525 (Alternative)</option>
                                        </select>
                                        <p class="text-xs text-gray-500 mt-1">Common SMTP ports</p>
                                    </div>

                                    <!-- SMTP Username -->
                                    <div>
                                        <label for="smtp_username" class="block text-sm font-medium text-gray-700">SMTP Username</label>
                                        <input type="text" name="smtp_username" id="smtp_username" 
                                               value="{{ config('mail.mailers.smtp.username') }}"
                                               placeholder="your-email@domain.com"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <p class="text-xs text-gray-500 mt-1">Usually your email address</p>
                                    </div>

                                    <!-- SMTP Password -->
                                    <div>
                                        <label for="smtp_password" class="block text-sm font-medium text-gray-700">SMTP Password</label>
                                        <input type="password" name="smtp_password" id="smtp_password" 
                                               value="{{ config('mail.mailers.smtp.password') ? '••••••••' : '' }}"
                                               placeholder="Enter SMTP password"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <p class="text-xs text-gray-500 mt-1">Your email password or app password</p>
                                    </div>

                                    <!-- SMTP Encryption -->
                                    <div>
                                        <label for="smtp_encryption" class="block text-sm font-medium text-gray-700">Encryption</label>
                                        <select name="smtp_encryption" id="smtp_encryption" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="tls" {{ config('mail.mailers.smtp.encryption') == 'tls' ? 'selected' : '' }}>TLS (Recommended)</option>
                                            <option value="ssl" {{ config('mail.mailers.smtp.encryption') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                            <option value="" {{ !config('mail.mailers.smtp.encryption') ? 'selected' : '' }}>None</option>
                                        </select>
                                        <p class="text-xs text-gray-500 mt-1">Security protocol for SMTP</p>
                                    </div>

                                    <!-- From Address -->
                                    <div>
                                        <label for="mail_from_address" class="block text-sm font-medium text-gray-700">From Email Address</label>
                                        <input type="email" name="mail_from_address" id="mail_from_address" 
                                               value="{{ config('mail.from.address') }}"
                                               placeholder="noreply@yourdomain.com"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <p class="text-xs text-gray-500 mt-1">Email address that appears as sender</p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label for="mail_from_name" class="block text-sm font-medium text-gray-700">From Name</label>
                                    <input type="text" name="mail_from_name" id="mail_from_name" 
                                           value="{{ config('mail.from.name') }}"
                                           placeholder="{{ config('app.name') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="text-xs text-gray-500 mt-1">Name that appears as sender</p>
                                </div>
                            </div>

                            <!-- Common SMTP Providers -->
                            <div class="mb-6 p-4 bg-yellow-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">📋 Common SMTP Providers</h4>
                                <p class="text-sm text-gray-600 mb-4">Quick setup for popular email providers:</p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <!-- Gmail -->
                                    <div class="bg-white p-3 rounded border">
                                        <h5 class="font-medium text-gray-800 mb-2">📧 Gmail</h5>
                                        <div class="text-xs text-gray-600 space-y-1">
                                            <p><strong>Host:</strong> smtp.gmail.com</p>
                                            <p><strong>Port:</strong> 587</p>
                                            <p><strong>Encryption:</strong> TLS</p>
                                            <p><strong>Note:</strong> Use App Password</p>
                                        </div>
                                        <button type="button" onclick="setGmailConfig()" class="mt-2 w-full bg-blue-500 hover:bg-blue-700 text-white text-xs px-2 py-1 rounded">
                                            Use Gmail Settings
                                        </button>
                                    </div>

                                    <!-- Hostinger -->
                                    <div class="bg-white p-3 rounded border">
                                        <h5 class="font-medium text-gray-800 mb-2">🌐 Hostinger</h5>
                                        <div class="text-xs text-gray-600 space-y-1">
                                            <p><strong>Host:</strong> smtp.hostinger.com</p>
                                            <p><strong>Port:</strong> 587</p>
                                            <p><strong>Encryption:</strong> TLS</p>
                                            <p><strong>Note:</strong> Use email password</p>
                                        </div>
                                        <button type="button" onclick="setHostingerConfig()" class="mt-2 w-full bg-purple-500 hover:bg-purple-700 text-white text-xs px-2 py-1 rounded">
                                            Use Hostinger Settings
                                        </button>
                                    </div>

                                    <!-- Outlook/Hotmail -->
                                    <div class="bg-white p-3 rounded border">
                                        <h5 class="font-medium text-gray-800 mb-2">📨 Outlook</h5>
                                        <div class="text-xs text-gray-600 space-y-1">
                                            <p><strong>Host:</strong> smtp-mail.outlook.com</p>
                                            <p><strong>Port:</strong> 587</p>
                                            <p><strong>Encryption:</strong> TLS</p>
                                            <p><strong>Note:</strong> Use account password</p>
                                        </div>
                                        <button type="button" onclick="setOutlookConfig()" class="mt-2 w-full bg-blue-600 hover:bg-blue-800 text-white text-xs px-2 py-1 rounded">
                                            Use Outlook Settings
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Test Email Section -->
                            <div class="mb-6 p-4 bg-green-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">🧪 Test SMTP Configuration</h4>
                                <p class="text-sm text-gray-600 mb-4">Send a test email to verify your SMTP settings are working correctly.</p>
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <div class="flex-1">
                                        <input type="email" name="test_email_address" id="test_email_address" 
                                               placeholder="Enter email address to test"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <button type="button" onclick="sendTestEmail()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded whitespace-nowrap">
                                        Send Test Email
                                    </button>
                                </div>
                                <div id="test-email-result" class="mt-3 hidden"></div>
                            </div>

                            <!-- Important Notes -->
                            <div class="mb-6 p-4 bg-red-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">⚠️ Important Notes</h4>
                                <ul class="text-sm text-gray-700 space-y-2">
                                    <li class="flex items-start">
                                        <span class="text-red-500 mr-2">•</span>
                                        <span><strong>Gmail Users:</strong> You must use an App Password, not your regular Gmail password. Enable 2FA and generate an App Password in your Google Account settings.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-red-500 mr-2">•</span>
                                        <span><strong>Security:</strong> These settings will be stored in your .env file. Make sure your server is secure.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-red-500 mr-2">•</span>
                                        <span><strong>Testing:</strong> Always test your configuration before relying on it for important emails.</span>
                                    </li>
                                    <li class="flex items-start">
                                        <span class="text-red-500 mr-2">•</span>
                                        <span><strong>Backup:</strong> Keep a backup of your working .env file before making changes.</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-6 text-right">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded">Save SMTP Settings</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- JavaScript for SMTP Configuration -->
                <script>
                    function setGmailConfig() {
                        document.getElementById('smtp_host').value = 'smtp.gmail.com';
                        document.getElementById('smtp_port').value = '587';
                        document.getElementById('smtp_encryption').value = 'tls';
                        alert('Gmail SMTP settings applied! Don\'t forget to:\n1. Enable 2-Factor Authentication\n2. Generate an App Password\n3. Use the App Password in the password field');
                    }

                    function setHostingerConfig() {
                        document.getElementById('smtp_host').value = 'smtp.hostinger.com';
                        document.getElementById('smtp_port').value = '587';
                        document.getElementById('smtp_encryption').value = 'tls';
                        alert('Hostinger SMTP settings applied! Use your email account password.');
                    }

                    function setOutlookConfig() {
                        document.getElementById('smtp_host').value = 'smtp-mail.outlook.com';
                        document.getElementById('smtp_port').value = '587';
                        document.getElementById('smtp_encryption').value = 'tls';
                        alert('Outlook SMTP settings applied! Use your Microsoft account password.');
                    }

                    function sendTestEmail() {
                        const testEmail = document.getElementById('test_email_address').value;
                        const resultDiv = document.getElementById('test-email-result');
                        
                        if (!testEmail) {
                            alert('Please enter an email address to test');
                            return;
                        }

                        // Show loading state
                        resultDiv.className = 'mt-3 p-3 bg-blue-100 border border-blue-300 rounded';
                        resultDiv.innerHTML = '<p class="text-blue-700">🔄 Sending test email...</p>';
                        resultDiv.classList.remove('hidden');

                        // Send test email via AJAX
                        fetch('/admin/emails/test', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                test_email: testEmail
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                resultDiv.className = 'mt-3 p-3 bg-green-100 border border-green-300 rounded';
                                resultDiv.innerHTML = '<p class="text-green-700">✅ Test email sent successfully! Check the inbox for ' + testEmail + '</p>';
                            } else {
                                resultDiv.className = 'mt-3 p-3 bg-red-100 border border-red-300 rounded';
                                resultDiv.innerHTML = '<p class="text-red-700">❌ Failed to send test email: ' + (data.message || 'Unknown error') + '</p>';
                            }
                        })
                        .catch(error => {
                            resultDiv.className = 'mt-3 p-3 bg-red-100 border border-red-300 rounded';
                            resultDiv.innerHTML = '<p class="text-red-700">❌ Error sending test email: ' + error.message + '</p>';
                        });
                    }
                </script>

                <!-- Email Management Section -->
                <div id="emails-section" class="settings-section bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6" style="display: none;">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Email Management</h3>
                        <p class="text-sm text-gray-600 mb-6">Manage email functionality including welcome emails, expiry warnings, and payment receipts. Emails use the SMTP configuration from your .env file.</p>
                        
                        <!-- Email Configuration Status -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-3">📧 Email Configuration Status</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-700"><strong>MAIL_MAILER:</strong> {{ config('mail.default') }}</p>
                                    <p class="text-sm text-gray-700"><strong>MAIL_HOST:</strong> {{ config('mail.mailers.smtp.host') }}</p>
                                    <p class="text-sm text-gray-700"><strong>MAIL_PORT:</strong> {{ config('mail.mailers.smtp.port') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-700"><strong>MAIL_FROM_ADDRESS:</strong> {{ config('mail.from.address') }}</p>
                                    <p class="text-sm text-gray-700"><strong>MAIL_FROM_NAME:</strong> {{ config('mail.from.name') }}</p>
                                    <p class="text-sm text-gray-700"><strong>MAIL_ENCRYPTION:</strong> {{ config('mail.mailers.smtp.encryption') ?? 'None' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Test Email Configuration -->
                        <div class="mb-6 p-4 bg-green-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-3">🧪 Test Email Configuration</h4>
                            <p class="text-sm text-gray-600 mb-4">Send a test email to verify your SMTP configuration is working correctly.</p>
                            <form method="POST" action="/admin/emails/test" class="flex flex-col sm:flex-row gap-3">
                                @csrf
                                <div class="flex-1">
                                    <input type="email" name="test_email" id="test_email" 
                                           placeholder="Enter email address to test"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           required>
                                </div>
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded whitespace-nowrap">
                                    Send Test Email
                                </button>
                            </form>
                        </div>

                        <!-- Welcome Emails -->
                        <div class="mb-6 p-4 bg-purple-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-3">🎉 Welcome Emails</h4>
                            <p class="text-sm text-gray-600 mb-4">Welcome emails are automatically sent when users claim QR codes. They include login credentials and getting started information.</p>
                            <div class="bg-white p-3 rounded border">
                                <h5 class="font-medium text-gray-800 mb-2">Email Features:</h5>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Login link (https://smart-keyholder.click/login)
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Username and password
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        QR code details and claim information
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Getting started guide and feature overview
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Trial information and upgrade options
                                    </li>
                                </ul>
                                <div class="mt-3 text-xs text-gray-500">
                                    <strong>Trigger:</strong> Automatically sent when a user successfully claims a QR code
                                </div>
                            </div>
                        </div>

                        <!-- Expiry Warning Emails -->
                        <div class="mb-6 p-4 bg-yellow-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-3">⏰ Expiry Warning Emails</h4>
                            <p class="text-sm text-gray-600 mb-4">Send warning emails to free trial users before their trial expires. These can be sent manually or scheduled automatically.</p>
                            
                            <div class="bg-white p-3 rounded border mb-4">
                                <h5 class="font-medium text-gray-800 mb-2">Email Schedule:</h5>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        7 days before expiry
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        3 days before expiry
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        1 day before expiry
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        On expiry day
                                    </li>
                                </ul>
                            </div>

                            <form method="POST" action="/admin/emails/send-expiry-warnings" class="space-y-3">
                                @csrf
                                <div>
                                    <label for="warning_days" class="block text-sm font-medium text-gray-700">Warning Days (comma-separated)</label>
                                    <input type="text" name="warning_days" id="warning_days" 
                                           value="7,3,1,0"
                                           placeholder="7,3,1,0"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="text-xs text-gray-500 mt-1">Days before expiry to send warnings (0 = expired users)</p>
                                </div>
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Send Expiry Warning Emails Now
                                </button>
                            </form>

                            <div class="mt-4 p-3 bg-gray-50 rounded">
                                <h6 class="font-medium text-gray-800 mb-2">Automatic Scheduling:</h6>
                                <p class="text-xs text-gray-600">
                                    Expiry warning emails are automatically scheduled to run daily at 9:00 AM. 
                                    To enable automatic sending, make sure your Laravel scheduler is running:
                                </p>
                                <code class="text-xs bg-gray-200 px-2 py-1 rounded mt-1 block">php artisan schedule:work</code>
                            </div>
                        </div>

                        <!-- Payment Receipt Emails -->
                        <div class="mb-6 p-4 bg-indigo-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-3">💳 Payment Receipt Emails</h4>
                            <p class="text-sm text-gray-600 mb-4">Receipt emails are automatically sent to users when they make payments or renew subscriptions.</p>
                            <div class="bg-white p-3 rounded border">
                                <h5 class="font-medium text-gray-800 mb-2">Email Features:</h5>
                                <ul class="text-sm text-gray-600 space-y-1">
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Payment receipt with transaction details
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Subscription details and duration
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Premium features overview
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Getting started with premium features
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Support and contact information
                                    </li>
                                </ul>
                                <div class="mt-3 text-xs text-gray-500">
                                    <strong>Trigger:</strong> Automatically sent when payment is successfully processed
                                </div>
                            </div>
                        </div>

                        <!-- Email Templates -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-3">📝 Email Templates</h4>
                            <p class="text-sm text-gray-600 mb-4">All email templates are professionally designed and mobile-responsive. They include your branding and can be customized.</p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-white p-3 rounded border text-center">
                                    <div class="text-2xl mb-2">🎉</div>
                                    <h5 class="font-medium text-gray-800">Welcome Email</h5>
                                    <p class="text-xs text-gray-600 mt-1">Sent on QR claim</p>
                                </div>
                                <div class="bg-white p-3 rounded border text-center">
                                    <div class="text-2xl mb-2">⏰</div>
                                    <h5 class="font-medium text-gray-800">Expiry Warning</h5>
                                    <p class="text-xs text-gray-600 mt-1">Sent before trial expires</p>
                                </div>
                                <div class="bg-white p-3 rounded border text-center">
                                    <div class="text-2xl mb-2">💳</div>
                                    <h5 class="font-medium text-gray-800">Payment Receipt</h5>
                                    <p class="text-xs text-gray-600 mt-1">Sent after payment</p>
                                </div>
                            </div>
                        </div>

                        <!-- Email Statistics -->
                        <div class="mb-6 p-4 bg-red-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-3">📊 Email Statistics</h4>
                            <p class="text-sm text-gray-600 mb-4">Email sending statistics and logs are available in your Laravel logs. Check <code>storage/logs/laravel.log</code> for detailed email sending information.</p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-white p-3 rounded border text-center">
                                    <div class="text-lg font-bold text-green-600">✓</div>
                                    <p class="text-sm text-gray-600">Successful Sends</p>
                                    <p class="text-xs text-gray-500">Check logs for details</p>
                                </div>
                                <div class="bg-white p-3 rounded border text-center">
                                    <div class="text-lg font-bold text-red-600">✗</div>
                                    <p class="text-sm text-gray-600">Failed Sends</p>
                                    <p class="text-xs text-gray-500">Check logs for errors</p>
                                </div>
                                <div class="bg-white p-3 rounded border text-center">
                                    <div class="text-lg font-bold text-blue-600">📋</div>
                                    <p class="text-sm text-gray-600">Queue Status</p>
                                    <p class="text-xs text-gray-500">Emails are queued</p>
                                </div>
                            </div>
                        </div>

                        <!-- Command Line Tools -->
                        <div class="mb-6 p-4 bg-orange-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-3">🛠️ Command Line Tools</h4>
                            <p class="text-sm text-gray-600 mb-4">Use these Artisan commands to manage emails from the command line:</p>
                            <div class="space-y-2">
                                <div class="bg-white p-2 rounded border">
                                    <code class="text-sm">php artisan email:test your@email.com</code>
                                    <p class="text-xs text-gray-500 mt-1">Send a test email to verify configuration</p>
                                </div>
                                <div class="bg-white p-2 rounded border">
                                    <code class="text-sm">php artisan email:send-expiry-warnings</code>
                                    <p class="text-xs text-gray-500 mt-1">Send expiry warnings manually</p>
                                </div>
                                <div class="bg-white p-2 rounded border">
                                    <code class="text-sm">php artisan queue:work</code>
                                    <p class="text-xs text-gray-500 mt-1">Process email queue (run continuously)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Upgrade Section -->
                <div id="system-section" class="settings-section bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6" style="display: none;">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">System Upgrade</h3>
                        <p class="text-sm text-gray-600 mb-6">Upload a new version of the system to upgrade your installation. Please backup your data before proceeding.</p>
                        
                        <!-- Current System Information -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-3">Current System Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Current Version</label>
                                    <p class="mt-1 text-sm text-gray-900 font-mono">{{ config('app.version', '1.0.0') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Laravel Version</label>
                                    <p class="mt-1 text-sm text-gray-900 font-mono">{{ app()->version() }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">PHP Version</label>
                                    <p class="mt-1 text-sm text-gray-900 font-mono">{{ PHP_VERSION }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Upgrade Upload Form -->
                        <form method="POST" action="#" enctype="multipart/form-data" id="upgrade-form">
                            @csrf
                            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">Important Warning</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <ul class="list-disc list-inside space-y-1">
                                                <li>Always backup your database and files before upgrading</li>
                                                <li>Ensure the uploaded file is from a trusted source</li>
                                                <li>The system will be temporarily unavailable during upgrade</li>
                                                <li>Only upload official upgrade packages</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-3">Upload Upgrade Package</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label for="upgrade_file" class="block text-sm font-medium text-gray-700 mb-2">Select Upgrade File</label>
                                        <div class="flex items-center justify-center w-full">
                                            <label for="upgrade_file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <svg class="w-8 h-8 mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                    </svg>
                                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                    <p class="text-xs text-gray-500">ZIP files only (MAX. 100MB)</p>
                                                </div>
                                                <input id="upgrade_file" name="upgrade_file" type="file" accept=".zip" class="hidden" required>
                                            </label>
                                        </div>
                                        <div id="file-info" class="mt-2 text-sm text-gray-600" style="display: none;"></div>
                                    </div>

                                    <div>
                                        <label for="upgrade_notes" class="block text-sm font-medium text-gray-700">Upgrade Notes (Optional)</label>
                                        <textarea name="upgrade_notes" id="upgrade_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter any notes about this upgrade..."></textarea>
                                    </div>

                                    <div class="flex items-center">
                                        <input type="checkbox" name="backup_confirmation" id="backup_confirmation" required class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <label for="backup_confirmation" class="ml-2 text-sm text-gray-700">I confirm that I have backed up my database and files</label>
                                    </div>

                                    <div class="flex items-center">
                                        <input type="checkbox" name="trusted_source" id="trusted_source" required class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <label for="trusted_source" class="ml-2 text-sm text-gray-700">I confirm this upgrade package is from a trusted source</label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    <p>Last upgrade: <span class="font-medium">{{ $settings['system']['last_upgrade'] ?? 'Never' }}</span></p>
                                </div>
                                <div class="flex space-x-3">
                                    <button type="button" onclick="validateUpgrade()" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                        Validate Package
                                    </button>
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirmUpgrade()">
                                        Start Upgrade
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Upgrade History -->
                        <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-3">Recent Upgrade History</h4>
                            <div class="space-y-2">
                                @if(isset($upgradeHistory) && count($upgradeHistory) > 0)
                                    @foreach($upgradeHistory as $upgrade)
                                        <div class="flex items-center justify-between py-2 px-3 bg-white rounded border">
                                            <div>
                                                <span class="text-sm font-medium">{{ $upgrade['version'] }}</span>
                                                <span class="text-xs text-gray-500 ml-2">{{ $upgrade['date'] }}</span>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded {{ $upgrade['status'] === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($upgrade['status']) }}
                                            </span>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-sm text-gray-500 text-center py-4">No upgrade history available</p>
                                @endif
                            </div>
                        </div>

                        <!-- System Maintenance -->
                        <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-3">System Maintenance</h4>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">Put the system in maintenance mode during upgrades</p>
                                    <p class="text-xs text-gray-500">Users will see a maintenance page</p>
                                </div>
                                <div class="flex space-x-2">
                                    <button onclick="enableMaintenance()" class="bg-orange-500 hover:bg-orange-700 text-white text-sm px-3 py-1 rounded">
                                        Enable Maintenance
                                    </button>
                                    <button onclick="disableMaintenance()" class="bg-green-500 hover:bg-green-700 text-white text-sm px-3 py-1 rounded">
                                        Disable Maintenance
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pricing Plan Modal -->
<div id="pricing-plan-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900" id="modal-title">Add New Pricing Plan</h3>
            <button onclick="closePricingModal()" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form id="pricing-plan-form" method="POST" action="{{ route('admin.pricing-plans.store') }}">
            @csrf
            <input type="hidden" id="plan-id" name="id">
            <input type="hidden" name="_method" id="form-method" value="POST">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="plan-name" class="block text-sm font-medium text-gray-700">Plan Name</label>
                    <input type="text" id="plan-name" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="plan-slug" class="block text-sm font-medium text-gray-700">Plan Slug</label>
                    <input type="text" id="plan-slug" name="slug" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">Unique identifier (e.g., "basic", "premium")</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="plan-price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" id="plan-price" name="price" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="plan-billing-cycle" class="block text-sm font-medium text-gray-700">Billing Cycle</label>
                    <select id="plan-billing-cycle" name="billing_cycle" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="month">Monthly</option>
                        <option value="year">Yearly</option>
                        <option value="week">Weekly</option>
                        <option value="day">Daily</option>
                        <option value="one-time">One-time</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="plan-description" class="block text-sm font-medium text-gray-700">Description</label>
                <input type="text" id="plan-description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="plan-button-text" class="block text-sm font-medium text-gray-700">Button Text</label>
                    <input type="text" id="plan-button-text" name="button_text" placeholder="Choose Plan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label for="plan-badge-text" class="block text-sm font-medium text-gray-700">Badge Text</label>
                    <input type="text" id="plan-badge-text" name="badge_text" placeholder="Best Value" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            </div>
            
            <!-- Plan Features Limits -->
            <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                <h4 class="font-medium text-gray-900 mb-3">Feature Limits</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="plan-max-social-links" class="block text-sm font-medium text-gray-700">Social Media Links Limit</label>
                        <input type="number" id="plan-max-social-links" name="max_social_links" min="-1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="text-xs text-gray-500 mt-1">Use -1 for unlimited, 0 to disable, or a positive number for the limit</p>
                    </div>
                    <div>
                        <label for="plan-max-gallery-images" class="block text-sm font-medium text-gray-700">Photo Gallery Images Limit</label>
                        <input type="number" id="plan-max-gallery-images" name="max_gallery_images" min="-1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="text-xs text-gray-500 mt-1">Use -1 for unlimited, 0 to disable, or a positive number for the limit</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="plan-has-analytics" name="has_analytics" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <label for="plan-has-analytics" class="ml-2 text-sm text-gray-700">Include Analytics</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="plan-has-custom-themes" name="has_custom_themes" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <label for="plan-has-custom-themes" class="ml-2 text-sm text-gray-700">Custom Themes</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="plan-has-priority-support" name="has_priority_support" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <label for="plan-has-priority-support" class="ml-2 text-sm text-gray-700">Priority Support</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="plan-has-qr-customization" name="has_qr_customization" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <label for="plan-has-qr-customization" class="ml-2 text-sm text-gray-700">QR Customization</label>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="plan-features" class="block text-sm font-medium text-gray-700">Features Display (one per line)</label>
                <textarea id="plan-features" name="features" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Custom QR Profile&#10;Social Media Links (5)&#10;Photo Gallery (10 images)&#10;Basic Analytics"></textarea>
                <p class="text-xs text-gray-500 mt-1">These features will be displayed on the pricing page. Make sure they match the limits set above.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="flex items-center">
                    <input type="checkbox" id="plan-is-popular" name="is_popular" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label for="plan-is-popular" class="ml-2 text-sm text-gray-700">Mark as Popular</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="plan-is-free-trial" name="is_free_trial" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label for="plan-is-free-trial" class="ml-2 text-sm text-gray-700">Free Trial Plan</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="plan-is-active" name="is_active" value="1" checked class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label for="plan-is-active" class="ml-2 text-sm text-gray-700">Active Plan</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="plan-has-whatsapp-store" name="has_whatsapp_store" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label for="plan-has-whatsapp-store" class="ml-2 text-sm text-gray-700">Include WhatsApp Store</label>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closePricingModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Cancel
                </button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Save Plan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Settings navigation
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.settings-nav-link');
    const sections = document.querySelectorAll('.settings-section');
    
    // Function to show a specific section
    function showSection(targetId) {
        // Hide all sections
        sections.forEach(section => {
            section.style.display = 'none';
        });
        
        // Remove active class from all nav links
        navLinks.forEach(link => {
            link.classList.remove('bg-gray-100', 'text-gray-900');
            link.classList.add('text-gray-700');
        });
        
        // Show target section
        const targetSection = document.getElementById(targetId + '-section');
        if (targetSection) {
            targetSection.style.display = 'block';
        }
        
        // Add active class to clicked nav link
        const activeLink = document.querySelector(`[data-target="${targetId}"]`);
        if (activeLink) {
            activeLink.classList.remove('text-gray-700');
            activeLink.classList.add('bg-gray-100', 'text-gray-900');
        }
    }
    
    // Add click event listeners to nav links
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = this.getAttribute('data-target');
            showSection(target);
        });
    });
    
    // Show first section by default
    if (navLinks.length > 0) {
        const firstTarget = navLinks[0].getAttribute('data-target');
        showSection(firstTarget);
    }
});

// Color picker synchronization
document.addEventListener('DOMContentLoaded', function() {
    // Primary color sync
    const primaryColor = document.getElementById('primary_color');
    const primaryColorHex = document.getElementById('primary_color_hex');
    
    if (primaryColor && primaryColorHex) {
        primaryColor.addEventListener('input', function() {
            primaryColorHex.value = this.value;
        });
        
        primaryColorHex.addEventListener('input', function() {
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                primaryColor.value = this.value;
            }
        });
    }
    
    // Secondary color sync
    const secondaryColor = document.getElementById('secondary_color');
    const secondaryColorHex = document.getElementById('secondary_color_hex');
    
    if (secondaryColor && secondaryColorHex) {
        secondaryColor.addEventListener('input', function() {
            secondaryColorHex.value = this.value;
        });
        
        secondaryColorHex.addEventListener('input', function() {
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                secondaryColor.value = this.value;
            }
        });
    }
    
    // Accent color sync
    const accentColor = document.getElementById('accent_color');
    const accentColorHex = document.getElementById('accent_color_hex');
    
    if (accentColor && accentColorHex) {
        accentColor.addEventListener('input', function() {
            accentColorHex.value = this.value;
        });
        
        accentColorHex.addEventListener('input', function() {
            if (/^#[0-9A-F]{6}$/i.test(this.value)) {
                accentColor.value = this.value;
            }
        });
    }
});

// File upload handling
document.addEventListener('DOMContentLoaded', function() {
    const upgradeFileInput = document.getElementById('upgrade_file');
    const fileInfo = document.getElementById('file-info');
    
    if (upgradeFileInput && fileInfo) {
        upgradeFileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
                fileInfo.innerHTML = `
                    <strong>Selected file:</strong> ${file.name}<br>
                    <strong>Size:</strong> ${fileSize} MB<br>
                    <strong>Type:</strong> ${file.type}
                `;
                fileInfo.style.display = 'block';
            } else {
                fileInfo.style.display = 'none';
            }
        });
    }
});

// Pricing Plans Functions
function openPricingModal() {
    document.getElementById('pricing-plan-modal').classList.remove('hidden');
}

function closePricingModal() {
    document.getElementById('pricing-plan-modal').classList.add('hidden');
    document.getElementById('pricing-plan-form').reset();
    document.getElementById('plan-id').value = '';
    document.getElementById('modal-title').textContent = 'Add New Pricing Plan';
    
    // Reset form method and action
    document.getElementById('form-method').value = 'POST';
    document.getElementById('pricing-plan-form').action = "{{ route('admin.pricing-plans.store') }}";
}

function editPricingPlan(planId) {
    // Set modal title
    document.getElementById('modal-title').textContent = 'Edit Pricing Plan';
    
    // Set plan ID in hidden field
    document.getElementById('plan-id').value = planId;
    
    // Change form method and action for update
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('pricing-plan-form').action = `/admin/pricing-plans/${planId}`;
    
    // Make AJAX request to get plan details
    fetch(`/admin/pricing-plans/${planId}`)
        .then(response => response.json())
        .then(data => {
            // Populate form fields with plan data
            document.getElementById('plan-name').value = data.name;
            document.getElementById('plan-slug').value = data.slug;
            document.getElementById('plan-price').value = data.price;
            document.getElementById('plan-billing-cycle').value = data.billing_cycle;
            document.getElementById('plan-description').value = data.description;
            document.getElementById('plan-button-text').value = data.button_text;
            document.getElementById('plan-badge-text').value = data.badge_text;
            
            // Set feature limits
            document.getElementById('plan-max-social-links').value = data.max_social_links;
            document.getElementById('plan-max-gallery-images').value = data.max_gallery_images;
            
            // Set feature checkboxes
            document.getElementById('plan-has-analytics').checked = data.has_analytics;
            document.getElementById('plan-has-custom-themes').checked = data.has_custom_themes;
            document.getElementById('plan-has-priority-support').checked = data.has_priority_support;
            document.getElementById('plan-has-qr-customization').checked = data.has_qr_customization;
            
            // Set plan status checkboxes
            document.getElementById('plan-is-popular').checked = data.is_popular;
            document.getElementById('plan-is-free-trial').checked = data.is_free_trial;
            document.getElementById('plan-is-active').checked = data.is_active;
            document.getElementById('plan-has-whatsapp-store').checked = data.has_whatsapp_store;
            
            // Set features
            if (data.features && data.features.length > 0) {
                document.getElementById('plan-features').value = data.features.join('\n');
            }
            
            // Show modal
            openPricingModal();
        })
        .catch(error => {
            console.error('Error fetching plan details:', error);
            alert('Failed to load plan details. Please try again.');
        });
}

function enableDragDrop() {
    alert('Drag and drop reordering functionality needs to be implemented.');
    document.getElementById('save-order-btn').style.display = 'inline-block';
}

function savePlanOrder() {
    alert('Save plan order functionality needs to be implemented.');
    document.getElementById('save-order-btn').style.display = 'none';
}

// System Upgrade Functions
function validateUpgrade() {
    const fileInput = document.getElementById('upgrade_file');
    if (!fileInput.files[0]) {
        alert('Please select an upgrade file first.');
        return;
    }
    
    alert('Package validation functionality needs to be implemented. This would check the uploaded file for validity.');
}

function enableMaintenance() {
    if (confirm('Are you sure you want to enable maintenance mode? Users will not be able to access the system.')) {
        alert('Maintenance mode enable functionality needs to be implemented.');
    }
}

function disableMaintenance() {
    if (confirm('Are you sure you want to disable maintenance mode?')) {
        alert('Maintenance mode disable functionality needs to be implemented.');
    }
}

function confirmUpgrade() {
    const confirmMessage = `
        ⚠️ CRITICAL WARNING ⚠️
        
        You are about to upgrade the system. This action:
        • Will overwrite existing files
        • May cause temporary downtime
        • May cause data loss if not properly backed up
        • Cannot be easily reversed
        
        Are you absolutely sure you want to proceed?
        
        Type "UPGRADE" to confirm:
    `;
    
    const userInput = prompt(confirmMessage);
    
    if (userInput !== 'UPGRADE') {
        alert('Upgrade cancelled. You must type "UPGRADE" exactly to proceed.');
        return false;
    }
    
    // For now, show a message that backend routes need to be implemented
    alert('System upgrade feature is ready! Backend routes need to be implemented by the developer.');
    return false;
}
</script>
@endsection