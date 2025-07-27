@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-100 py-8 px-2 sm:px-6 lg:px-8">
<div class="max-w-7xl mx-auto">
<div class="flex flex-col md:flex-row md:items-start gap-6">
<!-- Sidebar Navigation -->
<aside class="w-full md:w-64 md:min-h-[600px] md:sticky md:top-8 mb-4 md:mb-0">
<div class="bg-white shadow-lg rounded-2xl p-6 h-full">
<div class="flex items-center justify-between mb-6">
<h2 class="text-xl font-bold text-gray-800">Settings</h2>
<button id="settings-menu-toggle" class="md:hidden p-2 rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-400">
<svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
</button>
</div>
<nav id="settings-menu" class="space-y-2 md:block hidden transition-all duration-300 ease-in-out">
<a href="#general" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-700 hover:bg-blue-50 settings-nav-link" data-target="general">
<span class="inline-flex items-center"><svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>General</span>
</a>
<a href="#payment" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-700 hover:bg-blue-50 settings-nav-link" data-target="payment">
<span class="inline-flex items-center"><svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 9V7a5 5 0 0 0-10 0v2"/><rect x="5" y="11" width="14" height="10" rx="2"/></svg>Payment</span>
</a>
<a href="#branding" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-700 hover:bg-blue-50 settings-nav-link" data-target="branding">
<span class="inline-flex items-center"><svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>Branding</span>
</a>
<a href="#pricing" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-700 hover:bg-blue-50 settings-nav-link" data-target="pricing">
<span class="inline-flex items-center"><svg class="w-4 h-4 mr-2 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M16 3v4M8 3v4M3 9h18"/></svg>Pricing</span>
</a>
<a href="#currency" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-700 hover:bg-blue-50 settings-nav-link" data-target="currency">
<span class="inline-flex items-center"><svg class="w-4 h-4 mr-2 text-indigo-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v8m0 0a4 4 0 1 0 0-8v8z"/></svg>Currency</span>
</a>
<a href="#system" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-700 hover:bg-blue-50 settings-nav-link" data-target="system">
<span class="inline-flex items-center"><svg class="w-4 h-4 mr-2 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8v4l3 3"/><circle cx="12" cy="12" r="10"/></svg>System</span>
</a>
</nav>
</div>
</aside>
<!-- Main Content -->
<main class="flex-1 min-w-0 md:pl-2">
<div class="bg-white shadow-lg rounded-2xl p-4 sm:p-6 mb-6">
@include('admin.settings_backup')
</div>
</main>
</div>
</div>
</div>
<script>
// Responsive sidebar toggle
const menuToggle = document.getElementById('settings-menu-toggle');
const menu = document.getElementById('settings-menu');
if(menuToggle && menu) {
    menuToggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        menu.classList.toggle('block');
    });
}
// Section navigation
const navLinks = document.querySelectorAll('.settings-nav-link');
const sections = document.querySelectorAll('.settings-section');
navLinks.forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        navLinks.forEach(l => l.classList.remove('bg-blue-100', 'text-blue-700'));
        this.classList.add('bg-blue-100', 'text-blue-700');
        sections.forEach(section => section.style.display = 'none');
        const target = this.getAttribute('data-target');
        const targetSection = document.getElementById(target + '-section');
        if (targetSection) {
            targetSection.style.display = 'block';
        }
    });
});
if (navLinks.length > 0) {
    navLinks[0].click();
}
</script>
@endsection
