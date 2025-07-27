@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Choose Your Plan</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Select the perfect plan for your digital identity needs. Start with our free trial and upgrade anytime.
            </p>
        </div>

        <!-- Plans Grid -->
        <div class="grid grid-cols-1 md:grid-cols-{{ min(4, count($plans)) }} gap-8 max-w-7xl mx-auto">
            @foreach($plans as $index => $plan)
                <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300 {{ isset($plan['is_popular']) && $plan['is_popular'] ? 'ring-4 ring-blue-500' : '' }}">
                    @if(isset($plan['is_popular']) && $plan['is_popular'])
                        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                                {{ $plan['badge_text'] ?? 'Most Popular' }}
                            </span>
                        </div>
                    @endif

                    @if(isset($plan['is_free_trial']) && $plan['is_free_trial'])
                        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <span class="bg-gradient-to-r from-green-500 to-teal-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                                {{ $plan['badge_text'] ?? 'Free Trial' }}
                            </span>
                        </div>
                    @endif

                    @if(isset($plan['badge_text']) && $plan['badge_text'] && !isset($plan['is_popular']) && !isset($plan['is_free_trial']))
                        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <span class="bg-gradient-to-r from-purple-500 to-pink-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                                {{ $plan['badge_text'] }}
                            </span>
                        </div>
                    @endif

                    <div class="p-8">
                        <!-- Plan Header -->
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $plan['name'] }}</h3>
                            <div class="flex items-center justify-center mb-4">
                                @if($plan['price'] == 0)
                                    <span class="text-4xl font-bold text-gray-900">Free</span>
                                @else
                                    <span class="text-lg text-gray-500">{{ $plan['currency_symbol'] ?? '$' }}</span>
                                    <span class="text-4xl font-bold text-gray-900">{{ number_format($plan['price'], $plan['currency'] === 'NGN' ? 0 : 2) }}</span>
                                    <span class="text-lg text-gray-500 ml-1">{{ $plan['duration'] ?? '/month' }}</span>
                                @endif
                            </div>
                            @if(isset($plan['description']) && $plan['description'])
                                <p class="text-gray-600 mb-2">{{ $plan['description'] }}</p>
                            @endif
                            <p class="text-gray-500 text-sm">
                                @if(isset($plan['currency']) && $plan['currency'] !== 'USD') 
                                    <span class="text-blue-600 font-medium">({{ $plan['currency'] }})</span> 
                                @endif
                            </p>
                        </div>

                        <!-- Features List -->
                        <ul class="space-y-4 mb-8">
                            @if(isset($plan['features']) && is_array($plan['features']))
                                @foreach($plan['features'] as $feature)
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-green-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-gray-700">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            @endif
                        </ul>

                        <!-- CTA Button -->
                        <div class="text-center">
                            <form action="{{ route('payment.initialize') }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="plan" value="{{ $plan['plan_type'] ?? $plan['slug'] ?? 'free' }}">
                                @php
                                    $buttonClass = 'w-full text-white py-3 px-6 rounded-xl font-semibold hover:shadow-lg transition-all duration-300 transform hover:scale-105';
                                    if (isset($plan['is_free_trial']) && $plan['is_free_trial']) {
                                        $buttonClass .= ' bg-gradient-to-r from-green-500 to-teal-600';
                                    } elseif (isset($plan['is_popular']) && $plan['is_popular']) {
                                        $buttonClass .= ' bg-gradient-to-r from-blue-500 to-purple-600';
                                    } else {
                                        $buttonClass .= ' bg-gradient-to-r from-gray-700 to-gray-900';
                                    }
                                @endphp
                                <button type="submit" class="{{ $buttonClass }}">
                                    {{ $plan['button_text'] ?? 'Choose ' . $plan['name'] }}
                                </button>
                            </form>
                            
                            @if(!isset($plan['is_free_trial']) || !$plan['is_free_trial'])
                                <div class="mt-3 text-xs text-gray-500">
                                    <div class="flex items-center justify-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                        </svg>
                                        <span>Secure payment via Flutterwave</span>
                                    </div>
                                    <div class="mt-1 text-xs">
                                        Card • Mobile Money • Bank Transfer
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Payment Methods Information -->
        <div class="mt-12 text-center">
            <div class="bg-white rounded-xl p-6 shadow-lg max-w-4xl mx-auto">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">💳 Secure Payment Options</h3>
                <p class="text-gray-600 mb-6">
                    Choose from multiple payment methods when you select a plan. All payments are processed securely through Flutterwave.
                </p>
                
                <!-- Payment Methods Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
                    <div class="flex flex-col items-center p-3 bg-gray-50 rounded-lg">
                        <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <span class="text-xs font-medium">Debit Card</span>
                    </div>
                    <div class="flex flex-col items-center p-3 bg-gray-50 rounded-lg">
                        <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-xs font-medium">MTN MoMo</span>
                    </div>
                    <div class="flex flex-col items-center p-3 bg-gray-50 rounded-lg">
                        <svg class="w-8 h-8 text-red-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-xs font-medium">Airtel Money</span>
                    </div>
                    <div class="flex flex-col items-center p-3 bg-gray-50 rounded-lg">
                        <svg class="w-8 h-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                        </svg>
                        <span class="text-xs font-medium">Bank Transfer</span>
                    </div>
                    <div class="flex flex-col items-center p-3 bg-gray-50 rounded-lg">
                        <svg class="w-8 h-8 text-yellow-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m-9 0h10m-10 0a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2"></path>
                        </svg>
                        <span class="text-xs font-medium">USSD</span>
                    </div>
                    <div class="flex flex-col items-center p-3 bg-gray-50 rounded-lg">
                        <svg class="w-8 h-8 text-indigo-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-xs font-medium">More Options</span>
                    </div>
                </div>

                <!-- Currency Support -->
                <div class="border-t pt-4">
                    <h4 class="text-sm font-semibold text-gray-900 mb-2">💰 Multi-Currency Support</h4>
                    <p class="text-gray-600 text-sm mb-3">
                        Prices automatically adjusted for your region
                    </p>
                    <div class="flex flex-wrap justify-center gap-2 text-sm">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full">USD ($)</span>
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full">EUR (€)</span>
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full">GBP (£)</span>
                        <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full">NGN (₦)</span>
                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full">And more...</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-16 max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">Frequently Asked Questions</h2>
            <div class="space-y-6">
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I change my plan later?</h3>
                    <p class="text-gray-600">Yes, you can upgrade or downgrade your plan at any time from your dashboard. Changes will be reflected in your next billing cycle.</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">What currencies do you accept?</h3>
                    <p class="text-gray-600">We support multiple currencies including USD, EUR, GBP, NGN, and many others. Prices are automatically converted based on your location and preferences.</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">What happens after my free trial ends?</h3>
                    <p class="text-gray-600">After your 30-day free trial, you'll need to choose a paid plan to continue using the service. Your profile will remain active but access will be limited.</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I cancel my subscription anytime?</h3>
                    <p class="text-gray-600">Yes, you can cancel your subscription at any time. You'll continue to have access until the end of your current billing period.</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Do you offer refunds?</h3>
                    <p class="text-gray-600">We offer a 7-day money-back guarantee for all paid plans. Contact our support team if you're not satisfied with the service.</p>
                </div>
            </div>
        </div>

        <!-- Back to Dashboard -->
        <div class="text-center mt-12">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any JavaScript for plan interactions here
    document.addEventListener('DOMContentLoaded', function() {
        // Handle form submissions with loading states
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = form.querySelector('button[type="submit"]');
                const originalText = button.textContent;
                const planInput = form.querySelector('input[name="plan"]');
                const planValue = planInput ? planInput.value : '';
                
                // Check if it's a free trial
                if (planValue.includes('free') || planValue.includes('trial')) {
                    button.textContent = 'Activating Trial...';
                } else {
                    button.textContent = 'Redirecting to Payment...';
                }
                
                button.disabled = true;
                
                // Add loading spinner
                button.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    ${planValue.includes('free') || planValue.includes('trial') ? 'Activating Trial...' : 'Redirecting to Payment...'}
                `;
                
                // Re-enable after 10 seconds in case of issues
                setTimeout(() => {
                    button.textContent = originalText;
                    button.disabled = false;
                }, 10000);
            });
        });
    });
</script>
@endpush