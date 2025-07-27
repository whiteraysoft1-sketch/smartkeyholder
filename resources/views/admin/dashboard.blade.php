@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-100 py-8 px-2 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Stats Cards -->
        <section aria-label="Statistics Overview">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-5 gap-6 mb-8">
            <div class="bg-white shadow-lg rounded-2xl p-6 flex flex-col items-center justify-center hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                <div class="bg-blue-100 p-4 rounded-full mb-3 ring-2 ring-blue-200">
                    <!-- Users Group Icon -->
                    <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87"/><circle cx="9" cy="7" r="4"/><circle cx="17" cy="7" r="4"/></svg>
                </div>
                <div class="text-3xl font-bold text-blue-700">{{ $stats['total_users'] }}</div>
                <div class="text-sm text-gray-500 mt-1">Total Users</div>
            </div>
            <div class="bg-white shadow-lg rounded-2xl p-6 flex flex-col items-center justify-center">
                <div class="bg-green-100 p-3 rounded-full mb-2">
                    <!-- QR Code Icon -->
                    <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="6" height="6"/><rect x="15" y="3" width="6" height="6"/><rect x="3" y="15" width="6" height="6"/><rect x="15" y="15" width="6" height="6"/><rect x="10" y="10" width="4" height="4"/></svg>
                </div>
                <div class="text-3xl font-bold text-green-700">{{ $stats['total_qr_codes'] }}</div>
                <div class="text-sm text-gray-500 mt-1">Total QR Codes</div>
            </div>
            <div class="bg-white shadow-lg rounded-2xl p-6 flex flex-col items-center justify-center">
                <div class="bg-purple-100 p-3 rounded-full mb-2">
                    <!-- Checkmark Badge Icon -->
                    <svg class="w-7 h-7 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9 12l2 2l4-4"/></svg>
                </div>
                <div class="text-3xl font-bold text-purple-700">{{ $stats['claimed_qr_codes'] }}</div>
                <div class="text-sm text-gray-500 mt-1">Claimed QR Codes</div>
            </div>
            <div class="bg-white shadow-lg rounded-2xl p-6 flex flex-col items-center justify-center">
                <div class="bg-yellow-100 p-3 rounded-full mb-2">
                    <!-- Repeat/Sync Icon for Subscriptions -->
                    <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4v5h.582M20 20v-5h-.581M19.418 9A7.978 7.978 0 0 0 12 4a8 8 0 0 0-7.418 5M4.582 15A7.978 7.978 0 0 0 12 20a8 8 0 0 0 7.418-5"/></svg>
                </div>
                <div class="text-3xl font-bold text-yellow-600">{{ $stats['active_subscriptions'] }}</div>
                <div class="text-sm text-gray-500 mt-1">Active Subscriptions</div>
            </div>
            <div class="bg-white shadow-lg rounded-2xl p-6 flex flex-col items-center justify-center">
                <div class="bg-orange-100 p-3 rounded-full mb-2">
                    <!-- Clock Icon for Trial Users -->
                    <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <div class="text-3xl font-bold text-orange-600">{{ $stats['trial_users'] }}</div>
                <div class="text-sm text-gray-500 mt-1">Trial Users</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-gradient-to-r from-blue-100 via-purple-100 to-pink-100 shadow-lg rounded-2xl mb-8">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Quick Actions</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                    <a href="{{ route('admin.qr-codes') }}" class="flex flex-col items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-2 rounded-xl shadow transition">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6zm12 6h6v-6h-6v6z"/></svg>
                        <span class="text-xs sm:text-sm">Manage QR Codes</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex flex-col items-center bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-2 rounded-xl shadow transition">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                        <span class="text-xs sm:text-sm">Manage Users</span>
                    </a>
                    <a href="{{ route('admin.subscriptions') }}" class="flex flex-col items-center bg-purple-500 hover:bg-purple-600 text-white font-semibold py-3 px-2 rounded-xl shadow transition">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/></svg>
                        <span class="text-xs sm:text-sm">Subscriptions</span>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex flex-col items-center bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-2 rounded-xl shadow transition">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/></svg>
                        <span class="text-xs sm:text-sm">Settings</span>
                    </a>
                    <a href="{{ route('admin.qr-codes.export') }}" class="flex flex-col items-center bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-2 rounded-xl shadow transition">
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4v16h16V4H4zm4 4h8v8H8V8z"/></svg>
                        <span class="text-xs sm:text-sm">Export QR Codes</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Recent Users -->
            <div class="bg-white shadow-lg rounded-2xl">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center"><svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87"/><circle cx="9" cy="7" r="4"/></svg>Recent Users</h3>
                    <div class="space-y-3">
                        @foreach($recentUsers as $user)
                            <div class="flex items-center justify-between border-b pb-2">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $user->created_at->diffForHumans() }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Subscriptions -->
            <div class="bg-white shadow-lg rounded-2xl">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 flex items-center"><svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/></svg>Recent Subscriptions</h3>
                    <div class="space-y-3">
                        @foreach($recentSubscriptions as $subscription)
                            <div class="flex items-center justify-between border-b pb-2">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $subscription->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $subscription->plan_name }} - ${{ $subscription->amount }}</div>
                                </div>
                                <div class="text-xs">
                                    <span class="px-2 py-1 rounded text-xs {{ $subscription->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
