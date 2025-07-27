@extends('layouts.app')

@section('content')
<div class="container py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">User Details: {{ $user->name }}</h2>
                    <div class="space-x-2">
                        <a href="{{ route('admin.users') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Users
                        </a>
                        @if($user->qrCode)
                            <a href="{{ $user->qrCode->url }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                View Profile
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- User Information -->
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">User Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Joined</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email Verified</label>
                                <p class="mt-1 text-sm">
                                    @if($user->email_verified_at)
                                        <span class="text-green-600">✓ Verified on {{ $user->email_verified_at->format('M d, Y') }}</span>
                                    @else
                                        <span class="text-red-600">✗ Not verified</span>
                                    @endif
                                </p>
                            </div>
                            @if($user->trial_ends_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Trial Status</label>
                                    <p class="mt-1 text-sm">
                                        @if($user->trial_ends_at > now())
                                            <span class="text-yellow-600">Active (ends {{ $user->trial_ends_at->format('M d, Y') }})</span>
                                        @else
                                            <span class="text-gray-600">Expired on {{ $user->trial_ends_at->format('M d, Y') }}</span>
                                        @endif
                                    </p>
                                </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Subscription Status</label>
                                <p class="mt-1 text-sm">
                                    @if($user->is_subscribed)
                                        <span class="text-green-600">✓ Subscribed</span>
                                    @else
                                        <span class="text-gray-600">Not subscribed</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Information -->
                @if($user->profile)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Profile Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($user->profile->business_name)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Business Name</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $user->profile->business_name }}</p>
                                    </div>
                                @endif
                                @if($user->profile->phone)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $user->profile->phone }}</p>
                                    </div>
                                @endif
                                @if($user->profile->website)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Website</label>
                                        <p class="mt-1 text-sm text-gray-900">
                                            <a href="{{ $user->profile->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                {{ $user->profile->website }}
                                            </a>
                                        </p>
                                    </div>
                                @endif
                                @if($user->profile->location)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Location</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $user->profile->location }}</p>
                                    </div>
                                @endif
                            </div>
                            @if($user->profile->bio)
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-700">Bio</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->profile->bio }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Social Links -->
                @if($user->socialLinks && $user->socialLinks->count() > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Social Links</h3>
                            <div class="space-y-2">
                                @foreach($user->socialLinks as $link)
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-medium">{{ ucfirst($link->platform) }}:</span>
                                            <a href="{{ $link->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 ml-2">
                                                {{ $link->url }}
                                            </a>
                                        </div>
                                        <span class="text-sm text-gray-500">{{ $link->created_at->format('M d, Y') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- QR Code Information -->
                @if($user->qrCode)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">QR Code</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Code</label>
                                    <p class="mt-1 text-sm text-gray-900 font-mono">{{ $user->qrCode->code }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <p class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->qrCode->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $user->qrCode->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Claimed</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->qrCode->claimed_at ? $user->qrCode->claimed_at->format('M d, Y H:i') : 'Not claimed' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">URL</label>
                                    <p class="mt-1 text-sm">
                                        <a href="{{ $user->qrCode->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 break-all">
                                            {{ $user->qrCode->url }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">QR Code</h3>
                            <p class="text-sm text-gray-500">No QR code assigned to this user.</p>
                        </div>
                    </div>
                @endif

                <!-- Subscription Status & Management -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Subscription Status</h3>
                        
                        @if($user->isOnTrial())
                            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                                <p><strong>Trial Account</strong></p>
                                <p class="text-sm">Expires: {{ $user->trial_ends_at->format('M d, Y H:i') }}</p>
                                <p class="text-xs mt-1">{{ $user->trial_ends_at->diffForHumans() }}</p>
                            </div>
                        @elseif($user->hasActiveSubscription())
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                <p><strong>Active Subscription</strong></p>
                                <p class="text-sm">Plan: {{ $user->activeSubscription->plan_name }}</p>
                                <p class="text-sm">Amount: ${{ $user->activeSubscription->amount }}/month</p>
                                <p class="text-sm">Expires: {{ $user->subscription_ends_at->format('M d, Y H:i') }}</p>
                                <p class="text-xs mt-1">{{ $user->subscription_ends_at->diffForHumans() }}</p>
                            </div>
                        @else
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                <p><strong>No Active Subscription</strong></p>
                                <p class="text-sm">User needs to subscribe to access the service</p>
                            </div>
                        @endif

                        <!-- Admin Subscription Management -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-900">Admin Actions</h4>
                            
                            <!-- Upgrade/Change Plan -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h5 class="text-sm font-medium text-gray-900 mb-3">Upgrade/Change Plan</h5>
                                <form action="{{ route('admin.users.upgrade', $user) }}" method="POST">
                                    @csrf
                                    <div class="space-y-3">
                                        <div>
                                            <label for="plan_id" class="block text-xs font-medium text-gray-700">Select Plan</label>
                                            <select name="plan_id" id="plan_id" class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                <option value="">Choose a plan...</option>
                                                @foreach($availablePlans as $plan)
                                                    <option value="{{ $plan->id }}">
                                                        {{ $plan->name }} - ${{ number_format($plan->price, 2) }}
                                                        @if($plan->is_free_trial) (Free Trial) @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="duration_months" class="block text-xs font-medium text-gray-700">Duration (months)</label>
                                            <select name="duration_months" id="duration_months" class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="1">1 Month</option>
                                                <option value="3">3 Months</option>
                                                <option value="6">6 Months</option>
                                                <option value="12">12 Months</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-2 px-3 rounded-md transition-colors">
                                            Upgrade User
                                        </button>
                                    </div>
                                </form>
                            </div>

                            @if($user->hasActiveSubscription())
                                <!-- Extend Subscription -->
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h5 class="text-sm font-medium text-gray-900 mb-3">Extend Current Subscription</h5>
                                    <form action="{{ route('admin.users.extend', $user) }}" method="POST">
                                        @csrf
                                        <div class="space-y-3">
                                            <div>
                                                <label for="extend_months" class="block text-xs font-medium text-gray-700">Extend by (months)</label>
                                                <select name="extend_months" id="extend_months" class="mt-1 block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                    <option value="1">1 Month</option>
                                                    <option value="2">2 Months</option>
                                                    <option value="3">3 Months</option>
                                                    <option value="6">6 Months</option>
                                                    <option value="12">12 Months</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white text-sm font-medium py-2 px-3 rounded-md transition-colors">
                                                Extend Subscription
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Cancel Subscription -->
                                <div class="border border-red-200 rounded-lg p-4">
                                    <h5 class="text-sm font-medium text-red-900 mb-3">Cancel Subscription</h5>
                                    <form action="{{ route('admin.users.cancel-subscription', $user) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to cancel this user\'s subscription? This action cannot be undone.')">
                                        @csrf
                                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white text-sm font-medium py-2 px-3 rounded-md transition-colors">
                                            Cancel Subscription
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Subscription History -->
                @if($user->subscriptions && $user->subscriptions->count() > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Subscription History</h3>
                            <div class="space-y-4">
                                @foreach($user->subscriptions as $subscription)
                                    <div class="border-l-4 {{ $subscription->status === 'active' ? 'border-green-400' : 'border-gray-400' }} pl-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="font-medium">{{ $subscription->plan_name }}</p>
                                                <p class="text-sm text-gray-600">${{ number_format($subscription->amount, 2) }}/month</p>
                                            </div>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($subscription->status === 'active') bg-green-100 text-green-800
                                                @elseif($subscription->status === 'cancelled') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($subscription->status) }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Started: {{ $subscription->created_at->format('M d, Y') }}
                                            @if($subscription->ends_at)
                                                | Ends: {{ $subscription->ends_at->format('M d, Y') }}
                                            @endif
                                        </p>
                                        @if(isset($subscription->metadata['type']) && $subscription->metadata['type'] === 'admin_upgrade')
                                            <p class="text-xs text-blue-600 mt-1">
                                                <i class="fas fa-user-shield"></i> Admin Upgrade
                                            </p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Gallery Items -->
                @if($user->galleryItems && $user->galleryItems->count() > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Gallery Items</h3>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($user->galleryItems->take(4) as $item)
                                    <div class="aspect-square bg-gray-200 rounded-lg overflow-hidden">
                                        @if($item->type === 'image')
                                            <img src="{{ $item->url }}" alt="Gallery item" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <span class="text-xs text-gray-500">{{ strtoupper($item->type) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            @if($user->galleryItems->count() > 4)
                                <p class="text-sm text-gray-500 mt-2">
                                    +{{ $user->galleryItems->count() - 4 }} more items
                                </p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection