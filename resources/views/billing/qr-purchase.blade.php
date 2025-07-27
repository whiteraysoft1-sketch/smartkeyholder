<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Purchase QR Codes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $pageSettings['title'] }}</h1>
                <p class="text-gray-600">{{ $pageSettings['subtitle'] }}</p>
            </div>

            <!-- Error/Success Messages -->
            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Packages -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($packages as $index => $package)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden {{ (!empty($package['popular']) || $index === 1) ? 'ring-2 ring-blue-500 transform scale-105' : '' }}">
                        @if(!empty($package['popular']) || $index === 1)
                            <div class="bg-blue-500 text-white text-center py-2 text-sm font-semibold">
                                Most Popular
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <div class="text-center mb-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $package['name'] }}</h3>
                                <div class="text-3xl font-bold text-blue-600 mb-1">
                                    @if(($package['currency_position'] ?? 'before') === 'before')
                                        {{ $package['currency_symbol'] ?? '$' }}{{ number_format($package['price'], $package['currency'] === 'NGN' ? 0 : 2) }}
                                    @else
                                        {{ number_format($package['price'], $package['currency'] === 'NGN' ? 0 : 2) }}{{ $package['currency_symbol'] ?? '$' }}
                                    @endif
                                </div>
                                <div class="text-gray-600 text-sm">
                                    {{ $package['quantity'] }} QR Code{{ $package['quantity'] > 1 ? 's' : '' }}
                                    @if(isset($package['currency']) && $package['currency'] !== 'USD')
                                        <span class="text-blue-600 font-medium">({{ $package['currency'] }})</span>
                                    @endif
                                </div>
                                @if(isset($package['savings']))
                                    <div class="text-green-600 text-sm font-semibold">{{ $package['savings'] }}</div>
                                @endif
                            </div>

                            <div class="text-center mb-6">
                                <p class="text-gray-600">{{ $package['description'] }}</p>
                            </div>

                            <div class="mb-6">
                                <div class="text-center text-gray-600 text-sm">
                                    @if(($package['currency_position'] ?? 'before') === 'before')
                                        {{ $package['currency_symbol'] ?? '$' }}{{ number_format($package['price'] / $package['quantity'], $package['currency'] === 'NGN' ? 0 : 2) }} per QR code
                                    @else
                                        {{ number_format($package['price'] / $package['quantity'], $package['currency'] === 'NGN' ? 0 : 2) }}{{ $package['currency_symbol'] ?? '$' }} per QR code
                                    @endif
                                </div>
                            </div>

                            <form action="{{ route('payment.qr-initialize') }}" method="POST">
                                @csrf
                                <input type="hidden" name="package" value="{{ strtolower(str_replace(' ', '', explode(' ', $package['name'])[0])) }}">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200">
                                    Purchase Now
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Currency Information -->
            <div class="mt-8 text-center">
                <div class="bg-blue-50 rounded-lg p-4 max-w-2xl mx-auto">
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">💰 Multi-Currency Support</h3>
                    <p class="text-blue-700 text-sm">
                        {{ $pageSettings['currency_info_text'] }}
                    </p>
                </div>
            </div>

            <!-- Features -->
            <div class="mt-12 bg-gray-50 rounded-lg p-8">
                <h3 class="text-xl font-bold text-center text-gray-900 mb-6">What You Get</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($pageSettings['features'] as $index => $feature)
                        <div class="text-center">
                            <div class="bg-{{ $index === 0 ? 'blue' : ($index === 1 ? 'green' : 'purple') }}-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                                @if($feature['icon'] === 'lock')
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                @elseif($feature['icon'] === 'chart')
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                @endif
                            </div>
                            <h4 class="font-semibold mb-2">{{ $feature['title'] }}</h4>
                            <p class="text-gray-600 text-sm">{{ $feature['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- FAQ -->
            <div class="mt-12">
                <h3 class="text-xl font-bold text-center text-gray-900 mb-6">Frequently Asked Questions</h3>
                <div class="space-y-4">
                    @foreach($pageSettings['faqs'] as $faq)
                        <div class="bg-white rounded-lg p-6 shadow">
                            <h4 class="font-semibold mb-2">{{ $faq['question'] }}</h4>
                            <p class="text-gray-600">{{ $faq['answer'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>