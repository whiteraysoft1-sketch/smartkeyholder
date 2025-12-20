@extends('layouts.app')

@section('content')
<style>
    /* Hide default navigation for admin dashboard */
    body > div > nav {
        display: none;
    }
    .cyber-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .cyber-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .cyber-sidebar {
        background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
    }
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .chart-container {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    }
</style>

<div class="flex min-h-screen bg-gray-50 -mt-16">
    <!-- Sidebar -->
    <aside class="cyber-sidebar w-64 min-h-screen flex-shrink-0 fixed left-0 top-0 z-30">
        <div class="p-6">
            <!-- Logo -->
            <div class="flex items-center mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-2 rounded-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="6" height="6" rx="1"/>
                        <rect x="15" y="3" width="6" height="6" rx="1"/>
                        <rect x="3" y="15" width="6" height="6" rx="1"/>
                        <rect x="15" y="15" width="6" height="6" rx="1"/>
                    </svg>
                </div>
                <h1 class="ml-3 text-xl font-bold text-white">SmartKey</h1>
            </div>

            <!-- Navigation -->
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 bg-gradient-to-r from-blue-500/20 to-purple-600/20 text-blue-400 rounded-lg">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    Home
                </a>
                <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87"/><circle cx="9" cy="7" r="4"/>
                    </svg>
                    Affiliates
                </a>
                <a href="{{ route('admin.qr-codes') }}" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="6" height="6"/><rect x="15" y="3" width="6" height="6"/><rect x="3" y="15" width="6" height="6"/>
                    </svg>
                    ID Monitoring
                </a>
                <a href="{{ route('admin.subscriptions') }}" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 7h16M4 12h16M4 17h16"/>
                    </svg>
                    Database
                </a>
                <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                    </svg>
                    Apps
                </a>
                <div class="relative">
                    <a href="#" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3"/><path d="M12 1v6m0 6v6M4.22 4.22l4.24 4.24m5.08 5.08l4.24 4.24M1 12h6m6 0h6M4.22 19.78l4.24-4.24m5.08-5.08l4.24-4.24"/>
                        </svg>
                        Integration
                    </a>
                    <span class="absolute right-4 top-3 bg-orange-500 text-white text-xs px-2 py-0.5 rounded-full">!</span>
                </div>
                <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-lg transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Log out
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-x-hidden ml-64">
        <!-- Top Header -->
        <header class="bg-white shadow-sm sticky top-0 z-20">
            <div class="px-6 py-4 flex items-center justify-between">
                <div class="flex-1 max-w-2xl">
                    <div class="relative">
                        <input type="text" placeholder="Search project, folder or file" class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center space-x-4 ml-6">
                    <button class="text-gray-500 hover:text-gray-700 text-sm">Last Week</button>
                    <button class="text-gray-500 hover:text-gray-700 text-sm">Last Month</button>
                    <button class="relative p-2 text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </button>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold">
                        A
                    </div>
                </div>
            </div>
        </header>

        <div class="p-8 bg-gray-50">
            <!-- Stats Cards Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 mb-8">
                <!-- Claimed QR Codes Card -->
                <div class="stat-card bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <div class="flex items-start justify-between mb-6">
                        <div class="bg-purple-100 p-4 rounded-2xl">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/><path d="M9 12l2 2l4-4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-sm font-medium text-gray-500 mb-2">Claimed QR Codes</div>
                    <div class="text-5xl font-bold text-gray-900">{{ $stats['claimed_qr_codes'] }}</div>
                </div>

                <!-- Active Subscriptions Card -->
                <div class="stat-card bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                    <div class="flex items-start justify-between mb-6">
                        <div class="bg-yellow-100 p-4 rounded-2xl">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-sm font-medium text-gray-500 mb-2">Active Subscriptions</div>
                    <div class="text-5xl font-bold text-gray-900">{{ $stats['active_subscriptions'] }}</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 mb-8">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                    <a href="{{ route('admin.qr-codes') }}" class="flex flex-col items-center justify-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-6 px-4 rounded-2xl shadow-md transition-all hover:shadow-lg hover:scale-105">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6zm12 6h6v-6h-6v6z"/></svg>
                        <span class="text-sm">Manage QR Codes</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex flex-col items-center justify-center bg-green-500 hover:bg-green-600 text-white font-semibold py-6 px-4 rounded-2xl shadow-md transition-all hover:shadow-lg hover:scale-105">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                        <span class="text-sm">Manage Users</span>
                    </a>
                    <a href="{{ route('admin.subscriptions') }}" class="flex flex-col items-center justify-center bg-purple-500 hover:bg-purple-600 text-white font-semibold py-6 px-4 rounded-2xl shadow-md transition-all hover:shadow-lg hover:scale-105">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/></svg>
                        <span class="text-sm">Subscriptions</span>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex flex-col items-center justify-center bg-orange-500 hover:bg-orange-600 text-white font-semibold py-6 px-4 rounded-2xl shadow-md transition-all hover:shadow-lg hover:scale-105">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M12 1v6m0 6v6M4.22 4.22l4.24 4.24m5.08 5.08l4.24 4.24M1 12h6m6 0h6M4.22 19.78l4.24-4.24m5.08-5.08l4.24-4.24"/></svg>
                        <span class="text-sm">Settings</span>
                    </a>
                    <a href="{{ route('admin.qr-codes.export') }}" class="flex flex-col items-center justify-center bg-gray-700 hover:bg-gray-800 text-white font-semibold py-6 px-4 rounded-2xl shadow-md transition-all hover:shadow-lg hover:scale-105">
                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span class="text-sm">Export QR Codes</span>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <!-- Recent Subscriptions -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="flex items-center mb-6">
                    <div class="bg-purple-100 p-2 rounded-xl mr-3">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Recent Subscriptions</h3>
                </div>
                <div class="space-y-4">
                    @foreach($recentSubscriptions as $subscription)
                        <div class="flex items-start justify-between py-3 border-b border-gray-100 last:border-0">
                            <div class="flex-1">
                                <div class="flex items-center mb-1">
                                    <span class="font-semibold text-gray-900 text-base">{{ $subscription->user->name }}</span>
                                </div>
                                <div class="text-sm text-gray-500">{{ $subscription->plan_name }} - ${{ number_format($subscription->amount, 2) }}</div>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $subscription->status === 'active' ? 'bg-green-100 text-green-700' : ($subscription->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
                                    {{ ucfirst($subscription->status) }}
                                </span>
                                <span class="text-xs text-gray-400 mt-1">{{ $subscription->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
    </main>
</div>

<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
    @csrf
</form>
@endsection
