<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('vCard Template Preview') }}
        </h2>
    </x-slot>

    <style>
        .template-preview {
            transform: scale(0.8);
            transform-origin: top center;
            pointer-events: none;
            border: 3px solid transparent;
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        
        .template-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .template-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .template-card.selected {
            border-color: #3B82F6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .template-card.selected .template-preview {
            border-color: #3B82F6;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Template Selection Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">🎨 Choose Your vCard Template</h3>
                        <p class="text-gray-600">Select a design that represents your style and personality</p>
                    </div>

                    <form action="{{ route('dashboard.vcard-templates.select') }}" method="POST" id="templateForm">
                        @csrf
                        <input type="hidden" name="template" id="selectedTemplate" value="{{ $profile->selected_template ?? 'vcard_professional' }}">
                        
                        <!-- Template Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                            <!-- Professional Template -->
                            <div class="template-card bg-white rounded-2xl shadow-lg p-6 {{ ($profile->selected_template ?? 'vcard_professional') === 'vcard_professional' ? 'selected' : '' }}" 
                                 onclick="selectTemplate('vcard_professional')">
                                <div class="template-preview bg-gradient-to-br from-blue-50 to-white rounded-xl overflow-hidden">
                                    <!-- Classic Template Preview -->
                                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-20 relative">
                                        <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                                    </div>
                                    <div class="p-4 -mt-8 relative">
                                        <div class="w-16 h-16 bg-gray-300 rounded-full mx-auto mb-3 border-4 border-white"></div>
                                        <div class="text-center">
                                            <div class="h-3 bg-gray-300 rounded mb-2 w-24 mx-auto"></div>
                                            <div class="h-2 bg-gray-200 rounded mb-3 w-16 mx-auto"></div>
                                            <div class="grid grid-cols-2 gap-2 mb-3">
                                                <div class="h-6 bg-green-500 rounded text-xs"></div>
                                                <div class="h-6 bg-blue-500 rounded text-xs"></div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-1">
                                                <div class="h-8 bg-gray-200 rounded"></div>
                                                <div class="h-8 bg-gray-200 rounded"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 text-center">
                                    <h4 class="font-bold text-lg text-gray-900">Professional</h4>
                                    <p class="text-gray-600 text-sm">Professional services design</p>
                                    <div class="mt-2 flex justify-center">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Business</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Retail Template -->
                            <div class="template-card bg-white rounded-2xl shadow-lg p-6 {{ ($profile->selected_template ?? '') === 'vcard_retail' ? 'selected' : '' }}" 
                                 onclick="selectTemplate('vcard_retail')">
                                <div class="template-preview bg-gradient-to-br from-purple-100 to-blue-50 rounded-xl overflow-hidden">
                                    <!-- Modern Template Preview -->
                                    <div class="bg-gradient-to-r from-purple-600 to-blue-400 p-4 text-center">
                                        <div class="w-14 h-14 bg-white rounded-full mx-auto mb-2"></div>
                                        <div class="h-3 bg-white rounded mb-1 w-20 mx-auto"></div>
                                        <div class="h-2 bg-white/80 rounded w-16 mx-auto"></div>
                                    </div>
                                    <div class="p-4">
                                        <div class="h-2 bg-gray-200 rounded mb-2"></div>
                                        <div class="flex gap-2 mb-3">
                                            <div class="h-6 bg-green-500 rounded flex-1"></div>
                                            <div class="h-6 bg-blue-500 rounded flex-1"></div>
                                            <div class="h-6 bg-gray-800 rounded flex-1"></div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-1">
                                            <div class="h-8 bg-gray-200 rounded"></div>
                                            <div class="h-8 bg-gray-200 rounded"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 text-center">
                                    <h4 class="font-bold text-lg text-gray-900">Retail</h4>
                                    <p class="text-gray-600 text-sm">Retail & wholesale design</p>
                                    <div class="mt-2 flex justify-center">
                                        <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">Retail</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Health & Wellness Template -->
                            <div class="template-card bg-white rounded-2xl shadow-lg p-6 {{ ($profile->selected_template ?? '') === 'vcard_health_wellness' ? 'selected' : '' }}" 
                                 onclick="selectTemplate('vcard_health_wellness')">
                                <div class="template-preview bg-gray-50 rounded-xl overflow-hidden border border-gray-200">
                                    <!-- Minimalist Template Preview -->
                                    <div class="p-4 text-center border-b border-gray-200">
                                        <div class="w-12 h-12 bg-gray-300 rounded-full mx-auto mb-2 border-2 border-gray-300"></div>
                                        <div class="h-3 bg-gray-800 rounded mb-1 w-16 mx-auto"></div>
                                        <div class="h-2 bg-gray-600 rounded w-12 mx-auto"></div>
                                    </div>
                                    <div class="p-4">
                                        <div class="h-1 bg-gray-300 rounded mb-3"></div>
                                        <div class="space-y-1 mb-3">
                                            <div class="h-2 bg-gray-800 rounded w-20"></div>
                                            <div class="h-2 bg-gray-800 rounded w-24"></div>
                                            <div class="h-2 bg-gray-800 rounded w-16"></div>
                                        </div>
                                        <div class="flex gap-1 justify-center">
                                            <div class="w-8 h-2 bg-gray-600 rounded"></div>
                                            <div class="w-8 h-2 bg-gray-600 rounded"></div>
                                            <div class="w-8 h-2 bg-gray-600 rounded"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 text-center">
                                    <h4 class="font-bold text-lg text-gray-900">Health & Wellness</h4>
                                    <p class="text-gray-600 text-sm">Health & wellness design</p>
                                    <div class="mt-2 flex justify-center">
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">Wellness</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-center space-x-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition duration-300 transform hover:scale-105">
                                💾 Save Template Choice
                            </button>
                            @if($qrCode)
                                <a href="{{ route('qr.view', $qrCode->uuid) }}" target="_blank" class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl transition duration-300 transform hover:scale-105">
                                    👀 Preview Profile
                                </a>
                            @else
                                <span class="bg-gray-400 text-white font-bold py-3 px-8 rounded-xl cursor-not-allowed">
                                    👀 Preview Profile (QR Code Required)
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Template Features Comparison -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 text-center">Template Features Comparison</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 font-semibold text-gray-900">Feature</th>
                                    <th class="text-center py-3 px-4 font-semibold text-blue-600">Professional</th>
                                    <th class="text-center py-3 px-4 font-semibold text-purple-600">Retail</th>
                                    <th class="text-center py-3 px-4 font-semibold text-green-600">Health & Wellness</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr>
                                    <td class="py-3 px-4 font-medium">Design Style</td>
                                    <td class="py-3 px-4 text-center">Professional & Clean</td>
                                    <td class="py-3 px-4 text-center">Retail Focused</td>
                                    <td class="py-3 px-4 text-center">Wellness & Health</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 font-medium">Color Scheme</td>
                                    <td class="py-3 px-4 text-center">Blue Gradient</td>
                                    <td class="py-3 px-4 text-center">Purple to Blue</td>
                                    <td class="py-3 px-4 text-center">Green & Natural</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 font-medium">Best For</td>
                                    <td class="py-3 px-4 text-center">Professional Services</td>
                                    <td class="py-3 px-4 text-center">Retail & Wholesale</td>
                                    <td class="py-3 px-4 text-center">Health & Wellness</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 font-medium">Mobile Optimized</td>
                                    <td class="py-3 px-4 text-center">✅</td>
                                    <td class="py-3 px-4 text-center">✅</td>
                                    <td class="py-3 px-4 text-center">✅</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 font-medium">Social Links</td>
                                    <td class="py-3 px-4 text-center">✅</td>
                                    <td class="py-3 px-4 text-center">✅</td>
                                    <td class="py-3 px-4 text-center">✅</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 font-medium">Photo Gallery</td>
                                    <td class="py-3 px-4 text-center">✅</td>
                                    <td class="py-3 px-4 text-center">✅</td>
                                    <td class="py-3 px-4 text-center">✅</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectTemplate(template) {
            // Remove selected class from all cards
            document.querySelectorAll('.template-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Add selected class to clicked card
            event.currentTarget.classList.add('selected');
            
            // Update hidden input
            document.getElementById('selectedTemplate').value = template;
            
            // Show visual feedback
            const templateNames = {
                'vcard_professional': 'Professional',
                'vcard_retail': 'Retail',
                'vcard_health_wellness': 'Health & Wellness'
            };
            const templateName = templateNames[template] || template;
            
            // Create temporary notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300';
            notification.innerHTML = `✅ ${templateName} template selected!`;
            document.body.appendChild(notification);
            
            // Remove notification after 2 seconds
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 2000);
        }

        // Auto-submit form when template is selected (optional)
        document.addEventListener('DOMContentLoaded', function() {
            // Add click handlers for better UX
            document.querySelectorAll('.template-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</x-app-layout>