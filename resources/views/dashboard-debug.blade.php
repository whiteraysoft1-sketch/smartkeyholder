<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Debug</title>
    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Dashboard Debug Information</h1>
        
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">User Information</h2>
            @if(auth()->check())
                <p><strong>Authenticated:</strong> Yes</p>
                <p><strong>User ID:</strong> {{ auth()->id() }}</p>
                <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Is Admin:</strong> {{ auth()->user()->is_admin ? 'Yes' : 'No' }}</p>
                <p><strong>Trial Ends At:</strong> {{ auth()->user()->trial_ends_at ? auth()->user()->trial_ends_at->format('Y-m-d H:i:s') : 'Not set' }}</p>
                <p><strong>Is Subscribed:</strong> {{ auth()->user()->is_subscribed ? 'Yes' : 'No' }}</p>
                <p><strong>Subscription Ends At:</strong> {{ auth()->user()->subscription_ends_at ? auth()->user()->subscription_ends_at->format('Y-m-d H:i:s') : 'Not set' }}</p>
                <p><strong>Can Access Dashboard:</strong> {{ auth()->user()->canAccessDashboard() ? 'Yes' : 'No' }}</p>
                <p><strong>Is On Trial:</strong> {{ auth()->user()->isOnTrial() ? 'Yes' : 'No' }}</p>
                <p><strong>Has Active Subscription:</strong> {{ auth()->user()->hasActiveSubscription() ? 'Yes' : 'No' }}</p>
            @else
                <p class="text-red-600">Not authenticated</p>
            @endif
        </div>

        @if(auth()->check())
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Profile Information</h2>
            @if(auth()->user()->profile)
                <p><strong>Profile exists:</strong> Yes</p>
                <p><strong>Display Name:</strong> {{ auth()->user()->profile->display_name ?? 'Not set' }}</p>
                <p><strong>Bio:</strong> {{ auth()->user()->profile->bio ?? 'Not set' }}</p>
                <p><strong>Is Public:</strong> {{ auth()->user()->profile->is_public ? 'Yes' : 'No' }}</p>
            @else
                <p class="text-red-600">No profile found</p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">QR Code Information</h2>
            @if(auth()->user()->qrCode)
                <p><strong>QR Code exists:</strong> Yes</p>
                <p><strong>Code:</strong> {{ auth()->user()->qrCode->code }}</p>
                <p><strong>UUID:</strong> {{ auth()->user()->qrCode->uuid }}</p>
                <p><strong>Is Active:</strong> {{ auth()->user()->qrCode->is_active ? 'Yes' : 'No' }}</p>
                <p><strong>Claimed At:</strong> {{ auth()->user()->qrCode->claimed_at ? auth()->user()->qrCode->claimed_at->format('Y-m-d H:i:s') : 'Not claimed' }}</p>
            @else
                <p class="text-red-600">No QR code found</p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Social Links</h2>
            @if(auth()->user()->socialLinks->count() > 0)
                <p><strong>Count:</strong> {{ auth()->user()->socialLinks->count() }}</p>
                @foreach(auth()->user()->socialLinks as $link)
                    <p>{{ $link->platform }}: {{ $link->url }}</p>
                @endforeach
            @else
                <p>No social links found</p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Actions</h2>
            <a href="{{ route('dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                Go to Dashboard
            </a>
            <a href="{{ route('billing') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">
                Go to Billing
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Logout
                </button>
            </form>
        </div>
        @endif
    </div>
</body>
</html>