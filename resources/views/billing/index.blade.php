<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                {{ __('Billing & Subscription') }}
            </h2>
            <div class="hidden sm:flex items-center space-x-2 text-sm text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <span>Secure Payment</span>
            </div>
        </div>
    </x-slot>

    <!-- Enhanced CSS -->
    <link rel="stylesheet" href="{{ asset('css/billing-enhancements.css') }}">

    <!-- Background Pattern -->
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))] -z-10"></div>
        <div class="absolute top-0 right-0 -translate-y-12 translate-x-12">
            <div class="w-96 h-96 bg-gradient-to-br from-blue-400/20 to-purple-600/20 rounded-full blur-3xl"></div>
        </div>
        <div class="absolute bottom-0 left-0 translate-y-12 -translate-x-12">
            <div class="w-96 h-96 bg-gradient-to-tr from-indigo-400/20 to-cyan-600/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative py-8 sm:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Messages -->
                @if (session('success'))
                    <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl shadow-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-red-800 px-6 py-4 rounded-2xl shadow-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="font-medium">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Trial Expiring Soon Warning -->
                @if(isset($trialExpiringSoon) && $trialExpiringSoon)
                    <div class="mb-8 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-2xl shadow-lg overflow-hidden">
                        <div class="p-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="text-lg font-bold text-amber-900">Trial Expiring Soon!</h3>
                                    <p class="text-amber-800 mt-1">Your trial expires on <strong>{{ $user->trial_ends_at->format('M d, Y') }}</strong>. Choose a plan below to continue using the service.</p>
                                    <div class="mt-4">
                                        <a href="#plans" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-lg hover:from-amber-600 hover:to-orange-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                            Choose Plan
                                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Current Status -->
                <div class="bg-white/80 backdrop-blur-sm border border-white/20 shadow-xl rounded-3xl mb-8 overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">Current Status</h3>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full pulse-dot"></div>
                                <span class="text-sm text-gray-600">Live</span>
                            </div>
                        </div>
                        
                        @if($user->isOnTrial())
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-100 border border-blue-200 rounded-2xl p-6 relative overflow-hidden">
                                <!-- Background Pattern -->
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-600/5"></div>
                                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/10 to-indigo-600/10 rounded-full -translate-y-16 translate-x-16"></div>
                                
                                <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-blue-900">Free Trial Active</h4>
                                            <p class="text-blue-700 mt-1">Your trial expires on <strong>{{ $user->trial_ends_at->format('M d, Y') }}</strong></p>
                                            <div class="flex items-center mt-2">
                                                @php
                                                    $daysLeft = now()->diffInDays($user->trial_ends_at, false);
                                                    $totalTrialDays = 14; // Assuming 14-day trial
                                                    $progressPercentage = max(0, (($totalTrialDays - $daysLeft) / $totalTrialDays) * 100);
                                                @endphp
                                                <div class="flex-1 max-w-xs">
                                                    <div class="flex items-center justify-between text-sm text-blue-600 mb-1">
                                                        <span>Trial Progress</span>
                                                        <span>{{ $daysLeft }} days left</span>
                                                    </div>
                                                    <div class="w-full bg-blue-200 rounded-full h-2">
                                                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 rounded-full transition-all duration-500" style="width: {{ $progressPercentage }}%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center sm:text-right">
                                        <div class="text-3xl font-bold text-blue-600">FREE</div>
                                        <div class="text-sm text-blue-500">Trial Period</div>
                                    </div>
                                </div>
                            </div>
                        @elseif($user->hasActiveSubscription())
                            <div class="bg-gradient-to-br from-emerald-50 to-green-100 border border-emerald-200 rounded-2xl p-6 relative overflow-hidden">
                                <!-- Background Pattern -->
                                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-green-600/5"></div>
                                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-400/10 to-green-600/10 rounded-full -translate-y-16 translate-x-16"></div>
                                
                                <div class="relative flex flex-col space-y-4 sm:space-y-0 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl shadow-lg">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-emerald-900">Active Subscription</h4>
                                            <p class="text-emerald-700 mt-1">Plan: <strong>{{ $activeSubscription->plan_name }}</strong></p>
                                            <p class="text-emerald-700">Next billing: <strong>{{ $user->subscription_ends_at->format('M d, Y') }}</strong></p>
                                            <p class="text-emerald-700">Amount: <strong>${{ number_format($activeSubscription->amount, 2) }}/{{ $activeSubscription->billing_cycle ?? 'month' }}</strong></p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                                        <a href="{{ route('plans') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                            </svg>
                                            Change Plan
                                        </a>
                                        <form action="{{ route('subscription.cancel') }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-red-500 to-rose-600 text-white font-medium rounded-lg hover:from-red-600 hover:to-rose-700 transition-all duration-200 shadow-md hover:shadow-lg"
                                                    onclick="return confirm('Are you sure you want to cancel your subscription? You will lose access at the end of your current billing period.')">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Cancel
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="bg-gradient-to-br from-gray-50 to-slate-100 border border-gray-200 rounded-2xl p-6 text-center">
                                <div class="flex items-center justify-center w-16 h-16 bg-gradient-to-br from-gray-400 to-slate-500 rounded-2xl mx-auto mb-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">No Active Subscription</h4>
                                <p class="text-gray-600 mb-4">Choose a plan below to get started with premium features.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Available Plans -->
                @if(!$user->hasActiveSubscription() || $user->isOnTrial())
                <div id="plans" class="bg-white/80 backdrop-blur-sm border border-white/20 shadow-xl rounded-3xl mb-8 overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <div class="text-center mb-8">
                            <h3 class="text-3xl font-bold text-gray-900 mb-4">
                                @if($user->hasActiveSubscription())
                                    Upgrade Your Plan
                                @else
                                    Choose Your Perfect Plan
                                @endif
                            </h3>
                            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                                @if($user->hasActiveSubscription())
                                    Unlock more features and capabilities with our premium plans
                                @else
                                    Select the plan that best fits your needs and start your journey with us
                                @endif
                            </p>
                        </div>
                        
                        @if(isset($formattedPlans) && count($formattedPlans) > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ min(4, count($formattedPlans)) }} gap-6 lg:gap-8">
                                @foreach($formattedPlans as $plan)
                                    <div class="relative group">
                                        <!-- Popular Badge -->
                                        @if($plan['is_popular'])
                                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-10">
                                                <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                        </svg>
                                                        {{ $plan['badge_text'] ?: 'Most Popular' }}
                                                    </span>
                                                </div>
                                            </div>
                                        @elseif($plan['is_free_trial'])
                                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-10">
                                                <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ $plan['badge_text'] ?: 'Free Trial' }}
                                                    </span>
                                                </div>
                                            </div>
                                        @elseif($plan['badge_text'])
                                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-10">
                                                <div class="bg-gradient-to-r from-purple-500 to-pink-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                                                    {{ $plan['badge_text'] }}
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Plan Card -->
                                        <div class="plan-card relative h-full bg-white border-2 {{ $plan['is_popular'] ? 'border-blue-500 shadow-2xl scale-105 gradient-border' : 'border-gray-200 hover:border-gray-300' }} rounded-3xl overflow-hidden">
                                            <!-- Background Gradient -->
                                            @if($plan['is_popular'])
                                                <div class="absolute inset-0 bg-gradient-to-br from-blue-50/50 to-purple-50/50"></div>
                                            @endif
                                            
                                            <div class="relative p-6 sm:p-8">
                                                <!-- Plan Header -->
                                                <div class="text-center mb-8">
                                                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gradient-to-br {{ $plan['is_popular'] ? 'from-blue-500 to-purple-600' : ($plan['is_free_trial'] ? 'from-green-500 to-emerald-600' : 'from-gray-500 to-slate-600') }} rounded-2xl shadow-lg">
                                                        @if($plan['is_free_trial'])
                                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        @elseif($plan['is_popular'])
                                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                            </svg>
                                                        @else
                                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                            </svg>
                                                        @endif
                                                    </div>
                                                    
                                                    <h4 class="text-2xl font-bold text-gray-900 mb-4">{{ $plan['name'] }}</h4>
                                                    
                                                    <div class="flex items-center justify-center mb-4">
                                                        @if($plan['is_free_trial'] || $plan['price'] == 0)
                                                            <span class="text-4xl font-bold text-gray-900">Free</span>
                                                            @if($plan['trial_days'])
                                                                <span class="text-lg text-gray-500 ml-2">for {{ $plan['trial_days'] }} days</span>
                                                            @endif
                                                        @else
                                                            <div class="flex items-baseline">
                                                                @if($plan['currency_position'] === 'before')
                                                                    <span class="text-lg text-gray-500">{{ $plan['currency_symbol'] }}</span>
                                                                @endif
                                                                <span class="text-5xl font-bold text-gray-900">{{ number_format($plan['price'], $plan['currency'] === 'NGN' ? 0 : 2) }}</span>
                                                                @if($plan['currency_position'] === 'after')
                                                                    <span class="text-lg text-gray-500 ml-1">{{ $plan['currency_symbol'] }}</span>
                                                                @endif
                                                                <span class="text-lg text-gray-500 ml-2">{{ $plan['billing_cycle_text'] }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    @if($plan['description'])
                                                        <p class="text-gray-600 mb-2">{{ $plan['description'] }}</p>
                                                    @endif
                                                    @if($plan['currency'] !== 'USD')
                                                        <p class="text-blue-600 text-sm font-medium">({{ $plan['currency'] }})</p>
                                                    @endif
                                                </div>

                                                <!-- Features List -->
                                                <ul class="space-y-4 mb-8">
                                                    @if(is_array($plan['features']) && count($plan['features']) > 0)
                                                        @foreach($plan['features'] as $feature)
                                                            <li class="flex items-start">
                                                                <div class="flex-shrink-0 w-5 h-5 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mt-0.5 mr-3">
                                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                                    </svg>
                                                                </div>
                                                                <span class="text-gray-700 font-medium">{{ $feature }}</span>
                                                            </li>
                                                        @endforeach
                                                    @else
                                                        <!-- Default features based on plan capabilities -->
                                                        <li class="flex items-start">
                                                            <div class="flex-shrink-0 w-5 h-5 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mt-0.5 mr-3">
                                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                            </div>
                                                            <span class="text-gray-700 font-medium">Custom QR Profile</span>
                                                        </li>
                                                        @if($plan['max_social_links'])
                                                            <li class="flex items-start">
                                                                <div class="flex-shrink-0 w-5 h-5 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mt-0.5 mr-3">
                                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                                    </svg>
                                                                </div>
                                                                <span class="text-gray-700 font-medium">
                                                                    @if($plan['max_social_links'] == -1)
                                                                        Unlimited Social Links
                                                                    @else
                                                                        Up to {{ $plan['max_social_links'] }} Social Links
                                                                    @endif
                                                                </span>
                                                            </li>
                                                        @endif
                                                        @if($plan['max_gallery_images'])
                                                            <li class="flex items-start">
                                                                <div class="flex-shrink-0 w-5 h-5 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mt-0.5 mr-3">
                                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                                    </svg>
                                                                </div>
                                                                <span class="text-gray-700 font-medium">
                                                                    @if($plan['max_gallery_images'] == -1)
                                                                        Unlimited Gallery Images
                                                                    @else
                                                                        Up to {{ $plan['max_gallery_images'] }} Gallery Images
                                                                    @endif
                                                                </span>
                                                            </li>
                                                        @endif
                                                        @if($plan['has_whatsapp_store'])
                                                            <li class="flex items-start">
                                                                <div class="flex-shrink-0 w-5 h-5 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mt-0.5 mr-3">
                                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                                    </svg>
                                                                </div>
                                                                <span class="text-gray-700 font-medium">WhatsApp Store</span>
                                                            </li>
                                                        @endif
                                                        @if($plan['has_analytics'])
                                                            <li class="flex items-start">
                                                                <div class="flex-shrink-0 w-5 h-5 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mt-0.5 mr-3">
                                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                                    </svg>
                                                                </div>
                                                                <span class="text-gray-700 font-medium">Analytics Dashboard</span>
                                                            </li>
                                                        @endif
                                                        @if($plan['has_custom_themes'])
                                                            <li class="flex items-start">
                                                                <div class="flex-shrink-0 w-5 h-5 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mt-0.5 mr-3">
                                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                                    </svg>
                                                                </div>
                                                                <span class="text-gray-700 font-medium">Custom Themes</span>
                                                            </li>
                                                        @endif
                                                        @if($plan['has_priority_support'])
                                                            <li class="flex items-start">
                                                                <div class="flex-shrink-0 w-5 h-5 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mt-0.5 mr-3">
                                                                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                                    </svg>
                                                                </div>
                                                                <span class="text-gray-700 font-medium">Priority Support</span>
                                                            </li>
                                                        @endif
                                                    @endif
                                                </ul>

                                                <!-- CTA Button -->
                                                <div class="text-center">
                                                    <form action="{{ route('payment.initialize') }}" method="POST" class="w-full">
                                                        @csrf
                                                        <input type="hidden" name="plan" value="{{ $plan['slug'] }}">
                                                        <input type="hidden" name="plan_id" value="{{ $plan['id'] }}">
                                                        @php
                                                            $buttonClass = 'btn-enhanced focus-enhanced w-full text-white py-4 px-6 rounded-2xl font-bold text-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl relative overflow-hidden group';
                                                            if ($plan['is_free_trial']) {
                                                                $buttonClass .= ' bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700';
                                                            } elseif ($plan['is_popular']) {
                                                                $buttonClass .= ' bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700';
                                                            } else {
                                                                $buttonClass .= ' bg-gradient-to-r from-gray-700 to-slate-800 hover:from-gray-800 hover:to-slate-900';
                                                            }
                                                        @endphp
                                                        <button type="submit" class="{{ $buttonClass }}">
                                                            <span class="relative z-10 flex items-center justify-center">
                                                                {{ $plan['button_text'] }}
                                                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                                                </svg>
                                                            </span>
                                                            <!-- Button shine effect -->
                                                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="flex items-center justify-center w-16 h-16 bg-gray-100 rounded-2xl mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Plans Available</h3>
                                <p class="text-gray-600">Please contact support for available subscription plans.</p>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Subscription History -->
                @if(isset($subscriptions) && $subscriptions->count() > 0)
                <div class="bg-white/80 backdrop-blur-sm border border-white/20 shadow-xl rounded-3xl overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Subscription History</h3>
                        <div class="overflow-x-auto">
                            <table class="enhanced-table min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 rounded-lg">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($subscriptions as $subscription)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="font-medium text-gray-900">{{ $subscription->plan_name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-gray-900 font-semibold">${{ number_format($subscription->amount, 2) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="status-badge inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                                    {{ $subscription->status === 'active' ? 'bg-green-100 text-green-800' : 
                                                       ($subscription->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                                                        'bg-gray-100 text-gray-800') }}">
                                                    {{ ucfirst($subscription->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $subscription->starts_at->format('M d, Y') }} - {{ $subscription->ends_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $subscription->created_at->format('M d, Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Floating Action Button -->
    @if(!$user->hasActiveSubscription() || $user->isOnTrial())
    <div class="fab no-print">
        <a href="#plans" class="flex items-center justify-center w-14 h-14 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
        </a>
    </div>
    @endif

    <!-- Custom Styles -->
    <style>
        .bg-grid-slate-100 {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(148 163 184 / 0.05)'%3e%3cpath d='m0 .5h32m-32 32v-32'/%3e%3c/svg%3e");
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .animate-shimmer {
            animation: shimmer 2s infinite;
        }
    </style>
</x-app-layout>