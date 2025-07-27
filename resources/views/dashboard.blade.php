<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Subscription Alert -->
            <x-subscription-alert :user="auth()->user()" />
            
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Welcome back, {{ auth()->user()->name }}!</h3>
                            <p class="text-gray-600">Manage your QR profile and track your engagement.</p>
                        </div>
                        <div class="text-right">
                            @php
                                $status = auth()->user()->subscription_status;
                            @endphp
                            <div class="text-sm text-gray-500">Current Plan</div>
                            <div class="text-lg font-semibold {{ $status['status'] === 'active' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $status['plan_name'] ?? 'No Plan' }}
                            </div>
                            @if($status['status'] === 'active')
                                <div class="text-xs text-gray-500">{{ $status['message'] }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
                <!-- QR Code Status -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0">
                            <div class="flex-shrink-0 self-center sm:self-start">
                                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M12 12h-4.01M12 12v4m6-4h.01M12 8h.01M12 8h4.01M12 8H7.99"></path>
                                </svg>
                            </div>
                            <div class="sm:ml-4 text-center sm:text-left">
                                <div class="text-xs sm:text-sm font-medium text-gray-500">QR Code</div>
                                <div class="text-lg sm:text-2xl font-bold text-gray-900">
                                    @if(auth()->user()->qrCode)
                                        <span class="text-green-600">Active</span>
                                    @else
                                        <span class="text-red-600">None</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0">
                            <div class="flex-shrink-0 self-center sm:self-start">
                                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                            <div class="sm:ml-4 text-center sm:text-left">
                                <div class="text-xs sm:text-sm font-medium text-gray-500">Social Links</div>
                                <div class="text-lg sm:text-2xl font-bold text-gray-900">{{ auth()->user()->socialLinks->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gallery Items -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0">
                            <div class="flex-shrink-0 self-center sm:self-start">
                                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="sm:ml-4 text-center sm:text-left">
                                <div class="text-xs sm:text-sm font-medium text-gray-500">Gallery Items</div>
                                <div class="text-lg sm:text-2xl font-bold text-gray-900">{{ auth()->user()->galleryItems->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp Store -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0">
                            <div class="flex-shrink-0 self-center sm:self-start">
                                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div class="sm:ml-4 text-center sm:text-left">
                                <div class="text-xs sm:text-sm font-medium text-gray-500">WhatsApp Store</div>
                                <div class="text-lg sm:text-2xl font-bold text-gray-900">
                                    @if(auth()->user()->canAccessWhatsAppStore())
                                        <span class="text-green-600">Available</span>
                                    @else
                                        <span class="text-gray-400">Locked</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                        @if(auth()->user()->qrCode)
                            <a href="{{ auth()->user()->qrCode->url }}" target="_blank" 
                               class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                                <div>
                                    <div class="font-medium text-blue-900">View Your Profile</div>
                                    <div class="text-sm text-blue-600">See how others see your QR profile</div>
                                </div>
                            </a>
                        @endif

                        <a href="{{ route('profile.edit') }}" 
                           class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <div>
                                <div class="font-medium text-green-900">Edit Profile</div>
                                <div class="text-sm text-green-600">Update your information and settings</div>
                            </div>
                        </a>

                        <a href="{{ route('billing') }}" 
                           class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <svg class="w-6 h-6 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            <div>
                                <div class="font-medium text-purple-900">Manage Subscription</div>
                                <div class="text-sm text-purple-600">View plans and billing information</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
