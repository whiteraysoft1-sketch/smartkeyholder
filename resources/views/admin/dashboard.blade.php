@extends('layouts.app')

@section('content')
<style>
    /* Hide default navigation for admin dashboard */
    body > div > nav {
        display: none !important;
    }
    body > div.min-h-screen {
        background: transparent !important;
        padding: 0 !important;
    }
    .admin-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
    }
    .cyber-sidebar {
        background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        transition: transform 0.3s ease-in-out;
        width: 224px;
        flex-shrink: 0;
    }
    .cyber-sidebar.collapsed {
        transform: translateX(-100%);
    }
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -5px rgba(0, 0, 0, 0.1);
    }
    .main-content {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        transition: margin-left 0.3s ease-in-out;
    }
    .main-content.expanded {
        margin-left: -224px;
    }
    .bonus-card {
        background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
    }
    .chart-bar {
        transition: height 0.5s ease-out;
    }
    .protection-circle {
        stroke-dasharray: 251;
        stroke-dashoffset: 50;
        transition: stroke-dashoffset 1s ease-out;
    }
</style>

<div class="admin-wrapper bg-gray-100">
    <!-- Overlay for mobile -->
    <div id="sidebarOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-20" onclick="toggleSidebar()"></div>
    
    <!-- Sidebar -->
    <aside id="sidebar" class="cyber-sidebar h-full overflow-y-auto">
        <div class="p-5">
            <!-- Logo -->
            <div class="flex items-center mb-10">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-2 rounded-xl">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="6" height="6" rx="1"/>
                        <rect x="15" y="3" width="6" height="6" rx="1"/>
                        <rect x="3" y="15" width="6" height="6" rx="1"/>
                        <rect x="15" y="15" width="6" height="6" rx="1"/>
                    </svg>
                </div>
                <h1 class="ml-3 text-xl font-bold text-white">SmartKey</h1>
            </div>

            <!-- Navigation -->
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 bg-blue-600 text-white rounded-xl font-medium">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.qr-codes') }}" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-xl transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="6" height="6"/><rect x="15" y="3" width="6" height="6"/><rect x="3" y="15" width="6" height="6"/><rect x="15" y="15" width="6" height="6"/>
                    </svg>
                    QR Codes
                </a>
                <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-xl transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87"/><circle cx="9" cy="7" r="4"/><circle cx="17" cy="7" r="4"/>
                    </svg>
                    Users
                </a>
                <a href="{{ route('admin.subscriptions') }}" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-xl transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/>
                    </svg>
                    Subscriptions
                </a>
                <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-xl transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
                    </svg>
                    Settings
                </a>
                <a href="{{ route('admin.qr-codes.export') }}" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-xl transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Export
                </a>
                <div class="pt-6 mt-6 border-t border-slate-700">
                    <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-4 py-3 text-gray-400 hover:text-white hover:bg-slate-700/50 rounded-xl transition">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Log out
                    </a>
                </div>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main id="mainContent" class="main-content">
        <!-- Top Header -->
        <header class="bg-white shadow-sm sticky top-0 z-20">
            <div class="px-8 py-4 flex items-center justify-between">
                <!-- Mobile Menu Toggle -->
                <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-gray-100 mr-4">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="flex-1 max-w-lg">
                    <div class="relative">
                        <input type="text" placeholder="Search project, folder or file" class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border-0 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center space-x-3 ml-6">
                    <span class="text-sm text-gray-500 hidden md:block">Last Week</span>
                    <span class="text-sm text-gray-500 hidden md:block">Last Month</span>
                    <button class="relative p-2 text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </button>
                    <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-purple-200">
                        <div class="w-full h-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold">
                            A
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="p-8">
            <!-- Stats Cards Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <!-- Total Users -->
                <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87"/><circle cx="9" cy="7" r="4"/><circle cx="17" cy="7" r="4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Total Users</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $stats['total_users'] }}</div>
                </div>

                <!-- Total QR Codes -->
                <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="6" height="6"/><rect x="15" y="3" width="6" height="6"/><rect x="3" y="15" width="6" height="6"/><rect x="15" y="15" width="6" height="6"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Total QR Codes</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $stats['total_qr_codes'] }}</div>
                </div>

                <!-- Claimed QR Codes -->
                <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="bg-purple-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"/><path d="M9 12l2 2l4-4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Claimed QR Codes</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $stats['claimed_qr_codes'] }}</div>
                </div>

                <!-- Active Subscriptions -->
                <div class="stat-card bg-white rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="bg-yellow-100 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/>
                            </svg>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">Active Subs</div>
                    <div class="text-3xl font-bold text-gray-900">{{ $stats['active_subscriptions'] }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Bonus Card -->
                <div class="lg:col-span-2 bonus-card rounded-3xl p-8 text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <div class="text-sm font-medium text-purple-200 mb-2">Welcome Admin</div>
                        <h2 class="text-3xl font-bold mb-2">Manage Your Platform</h2>
                        <p class="text-purple-200 mb-6">{{ $stats['total_users'] }} Users • {{ $stats['total_qr_codes'] }} QR Codes</p>
                        <a href="{{ route('admin.qr-codes') }}" class="inline-flex items-center bg-white text-purple-600 px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-purple-50 transition">
                            Manage QR Codes
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    <!-- Decorative elements -->
                    <div class="absolute top-4 right-8 text-purple-300/30">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-purple-400/20 rounded-full"></div>
                </div>

                <!-- Trial Users Card -->
                <div class="bg-white rounded-3xl p-6 shadow-sm">
                    <div class="text-center mb-4">
                        <div class="text-sm text-gray-500 mb-2">Trial Users</div>
                        <div class="relative inline-flex items-center justify-center">
                            <svg class="w-32 h-32 transform -rotate-90">
                                <circle cx="64" cy="64" r="56" stroke="#e5e7eb" stroke-width="12" fill="none"/>
                                <circle cx="64" cy="64" r="56" stroke="#8b5cf6" stroke-width="12" fill="none" 
                                    stroke-dasharray="352" 
                                    stroke-dashoffset="{{ 352 - (352 * min(($stats['trial_users'] / max($stats['total_users'], 1)) * 100, 100) / 100) }}"
                                    stroke-linecap="round"/>
                            </svg>
                            <div class="absolute text-3xl font-bold text-purple-600">{{ $stats['trial_users'] }}</div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-sm font-medium text-gray-900">Active Trials</div>
                        <p class="text-xs text-gray-500">Users in trial period</p>
                    </div>
                    <a href="{{ route('admin.users') }}" class="mt-4 flex items-center justify-center text-sm text-purple-600 hover:text-purple-700 font-medium">
                        View Details
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Users -->
                <div class="bg-white rounded-3xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-2 rounded-xl mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87"/><circle cx="9" cy="7" r="4"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Recent Users</h3>
                        </div>
                        <a href="{{ route('admin.users') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
                    </div>
                    <div class="space-y-4">
                        @foreach($recentUsers as $user)
                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center text-white font-semibold text-sm mr-3">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 text-sm">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Subscriptions -->
                <div class="bg-white rounded-3xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="bg-purple-100 p-2 rounded-xl mr-3">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Recent Subscriptions</h3>
                        </div>
                        <a href="{{ route('admin.subscriptions') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">View All</a>
                    </div>
                    <div class="space-y-4">
                        @foreach($recentSubscriptions as $subscription)
                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-400 to-pink-500 flex items-center justify-center text-white font-semibold text-sm mr-3">
                                        {{ strtoupper(substr($subscription->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 text-sm">{{ $subscription->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $subscription->plan_name }} - ${{ number_format($subscription->amount, 2) }}</div>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $subscription->status === 'active' ? 'bg-green-100 text-green-700' : ($subscription->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
                                    {{ ucfirst($subscription->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 bg-white rounded-3xl p-6 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Quick Actions</h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                    <a href="{{ route('admin.qr-codes') }}" class="flex flex-col items-center justify-center bg-gradient-to-br from-blue-500 to-blue-600 text-white font-semibold py-5 px-4 rounded-2xl shadow-md transition-all hover:shadow-lg hover:scale-105">
                        <svg class="w-7 h-7 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6zm12 6h6v-6h-6v6z"/></svg>
                        <span class="text-sm">QR Codes</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex flex-col items-center justify-center bg-gradient-to-br from-green-500 to-green-600 text-white font-semibold py-5 px-4 rounded-2xl shadow-md transition-all hover:shadow-lg hover:scale-105">
                        <svg class="w-7 h-7 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
                        <span class="text-sm">Users</span>
                    </a>
                    <a href="{{ route('admin.subscriptions') }}" class="flex flex-col items-center justify-center bg-gradient-to-br from-purple-500 to-purple-600 text-white font-semibold py-5 px-4 rounded-2xl shadow-md transition-all hover:shadow-lg hover:scale-105">
                        <svg class="w-7 h-7 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/></svg>
                        <span class="text-sm">Subscriptions</span>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex flex-col items-center justify-center bg-gradient-to-br from-orange-500 to-orange-600 text-white font-semibold py-5 px-4 rounded-2xl shadow-md transition-all hover:shadow-lg hover:scale-105">
                        <svg class="w-7 h-7 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M12 1v6m0 6v6M4.22 4.22l4.24 4.24m5.08 5.08l4.24 4.24M1 12h6m6 0h6M4.22 19.78l4.24-4.24m5.08-5.08l4.24-4.24"/></svg>
                        <span class="text-sm">Settings</span>
                    </a>
                    <a href="{{ route('admin.qr-codes.export') }}" class="flex flex-col items-center justify-center bg-gradient-to-br from-gray-600 to-gray-700 text-white font-semibold py-5 px-4 rounded-2xl shadow-md transition-all hover:shadow-lg hover:scale-105">
                        <svg class="w-7 h-7 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span class="text-sm">Export</span>
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>

<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
    @csrf
</form>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const overlay = document.getElementById('sidebarOverlay');
        
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
        
        if (window.innerWidth < 1024) {
            overlay.classList.toggle('hidden');
        }
    }
</script>
@endsection
