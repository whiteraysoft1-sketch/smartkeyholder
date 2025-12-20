@extends('layouts.app')

@section('content')
<style>
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

<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="cyber-sidebar w-64 min-h-screen flex-shrink-0 hidden lg:block">
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
    <main class="flex-1 overflow-x-hidden">
        <!-- Top Header -->
        <header class="bg-white shadow-sm sticky top-0 z-10">
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

        <div class="p-6">
            <!-- Stats Cards -->
            <section aria-label="Statistics Overview">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Local Items Card -->
                <div class="stat-card cyber-card rounded-2xl p-6 border-l-4 border-purple-500">
                    <div class="flex items-center justify-between mb-3">
                        <div class="bg-purple-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500 mb-1">Local Items</div>
                    <div class="text-3xl font-bold text-gray-900 mb-1">WINPOR-24</div>
                </div>

                <!-- Registered On Card -->
                <div class="stat-card cyber-card rounded-2xl p-6 border-l-4 border-teal-500">
                    <div class="flex items-center justify-between mb-3">
                        <div class="bg-teal-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500 mb-1">Registered On</div>
                    <div class="text-2xl font-bold text-gray-900 mb-1">2023-01-02 2PM</div>
                </div>

                <!-- Scheduled Assets Card -->
                <div class="stat-card cyber-card rounded-2xl p-6 border-l-4 border-orange-500">
                    <div class="flex items-center justify-between mb-3">
                        <div class="bg-orange-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500 mb-1">Scheduled Assets</div>
                    <div class="text-3xl font-bold text-gray-900 mb-1">131 (Subdomain - 5)</div>
                </div>

                <!-- Agent Card -->
                <div class="stat-card cyber-card rounded-2xl p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between mb-3">
                        <div class="bg-green-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-sm text-gray-500 mb-1">Agent</div>
                    <div class="text-3xl font-bold text-gray-900 mb-1">v1.0.0.8</div>
                </div>
            </div>

            <!-- Bonus & Chart Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Bonus Card -->
                <div class="lg:col-span-2">
                    <div class="cyber-gradient rounded-2xl p-8 text-white relative overflow-hidden">
                        <div class="relative z-10">
                            <div class="text-sm mb-2 opacity-90">Bonus of the month</div>
                            <h2 class="text-3xl font-bold mb-1">You have Bonus $100</h2>
                            <p class="text-xl mb-4">10 Free Spins</p>
                            <button class="bg-white text-purple-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition flex items-center">
                                Claim Bonus
                                <svg class="w-4 h-4 ml-2" fill="currentColor" viewBox="0 0 20 20">
                                    <circle cx="10" cy="10" r="8"/>
                                </svg>
                            </button>
                        </div>
                        <div class="absolute right-0 top-0 opacity-20">
                            <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <div class="absolute right-8 bottom-8">
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'%3E%3Ccircle cx='60' cy='60' r='50' fill='%23FCD34D'/%3E%3Ctext x='60' y='75' font-size='40' text-anchor='middle' fill='%23F59E0B'%3E$%3C/text%3E%3C/svg%3E" alt="Coins" class="w-24 h-24">
                        </div>
                    </div>
                </div>

                <!-- Protection Status Card -->
                <div class="cyber-card rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-800">IP Conflicts Report</h3>
                        <button class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium">Private IP</span>
                            </div>
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-purple-100 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium">Public IP</span>
                            </div>
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="relative pt-4">
                        <div class="text-center mb-6">
                            <div class="inline-flex items-center justify-center">
                                <svg class="w-32 h-32">
                                    <circle cx="64" cy="64" r="52" fill="none" stroke="#E5E7EB" stroke-width="12"/>
                                    <circle cx="64" cy="64" r="52" fill="none" stroke="url(#gradient)" stroke-width="12" stroke-dasharray="327" stroke-dashoffset="65" transform="rotate(-90 64 64)" stroke-linecap="round"/>
                                    <defs>
                                        <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                                            <stop offset="100%" style="stop-color:#764ba2;stop-opacity:1" />
                                        </linearGradient>
                                    </defs>
                                    <text x="64" y="74" text-anchor="middle" class="text-3xl font-bold fill-gray-800">80%</text>
                                </svg>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm font-semibold text-gray-800 mb-1">Average Protection</div>
                            <div class="text-xs text-gray-500">Check what you can do to be fully protected</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart & Issues Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Chart -->
            <!-- Chart & Issues Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Chart -->
                <div class="lg:col-span-2 cyber-card rounded-2xl p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <div class="flex items-center space-x-6 mb-2">
                                <div>
                                    <div class="text-3xl font-bold text-gray-900">{{ $stats['total_qr_codes'] }}k</div>
                                    <div class="text-sm text-gray-500">Total Files</div>
                                </div>
                                <div class="h-12 w-px bg-gray-200"></div>
                                <div>
                                    <div class="text-3xl font-bold text-gray-900">{{ $stats['claimed_qr_codes'] }}k</div>
                                    <div class="text-sm text-gray-500">Scanned Files</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-medium">
                            Nov 2023
                        </div>
                    </div>
                    
                    <!-- Simple Bar Chart -->
                    <div class="chart-container rounded-xl p-4">
                        <div class="flex items-end justify-between h-48 space-x-2">
                            @php
                                $months = ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'];
                                $colors = ['bg-purple-500', 'bg-teal-500', 'bg-purple-400', 'bg-pink-400', 'bg-purple-600', 'bg-red-400', 'bg-purple-700', 'bg-green-500', 'bg-purple-500', 'bg-pink-500', 'bg-gray-400', 'bg-purple-400'];
                                $heights = [30, 45, 35, 50, 60, 40, 75, 85, 70, 90, 65, 55];
                            @endphp
                            @foreach($months as $index => $month)
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-full {{ $colors[$index] }} rounded-t-lg transition-all hover:opacity-80" style="height: {{ $heights[$index] }}%"></div>
                                    <div class="text-xs text-gray-500 mt-2">{{ $month }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Issues Panel -->
                <div class="cyber-card rounded-2xl p-6">
                    <h3 class="font-semibold text-gray-800 mb-6">{{ $stats['trial_users'] + $stats['active_subscriptions'] }} issues total</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600">Simple</span>
                                <span class="font-semibold text-gray-800">50%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-red-400 h-2 rounded-full" style="width: 50%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600">Medium</span>
                                <span class="font-semibold text-gray-800">25%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full" style="width: 25%"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600">Complex</span>
                                <span class="font-semibold text-gray-800">10%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-orange-400 h-2 rounded-full" style="width: 10%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-semibold text-gray-700 mb-4">Recent Users</h4>
                        <div class="space-y-3">
                            @foreach($recentUsers->take(5) as $user)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white text-xs font-semibold">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($user->name, 15) }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Subscriptions -->
            <div class="mt-6 cyber-card rounded-2xl p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Recent Subscriptions</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">User</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Plan</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Amount</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Status</th>
                                <th class="text-left py-3 px-4 text-sm font-semibold text-gray-600">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSubscriptions->take(8) as $subscription)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-500 to-pink-600 flex items-center justify-center text-white text-xs font-semibold">
                                                {{ substr($subscription->user->name, 0, 1) }}
                                            </div>
                                            <span class="ml-3 text-sm font-medium text-gray-900">{{ $subscription->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ $subscription->plan_name }}</td>
                                    <td class="py-3 px-4 text-sm font-semibold text-gray-900">${{ $subscription->amount }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $subscription->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                            {{ ucfirst($subscription->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-500">{{ $subscription->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
    @csrf
</form>
@endsection
