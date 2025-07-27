@extends('layouts.app')

@section('content')
<div class="min-h-screen flex justify-center items-start py-12 px-2 sm:px-6 lg:px-8">
    <div class="max-w-3xl w-full mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">Flutterwave Payment Test</h2>
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4">Flutterwave Configuration Status</h3>
                
                <div id="config-status" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-center text-gray-500">Loading configuration status...</p>
                </div>

                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-4">Test Payment</h3>
                    <p class="text-sm text-gray-600 mb-4">This will simulate a payment flow using Flutterwave. No actual charges will be made in sandbox mode.</p>
                    
                    <form method="POST" action="{{ route('payment.initialize') }}" class="space-y-4">
                        @csrf
                        <input type="hidden" name="plan" value="test_plan">
                        
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">Test Amount</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="amount" id="amount" value="10.00" min="1" step="0.01" 
                                       class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" id="test-payment-btn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" disabled>
                                Test Payment Flow
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4">Troubleshooting Steps</h3>
                
                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <h4 class="font-medium text-gray-900 mb-2">1. Check Configuration</h4>
                        <p class="text-sm text-gray-600">Ensure that Flutterwave is properly configured in Admin Settings:</p>
                        <ul class="list-disc list-inside text-sm text-gray-600 mt-2 ml-4">
                            <li>Flutterwave is set to "Active"</li>
                            <li>Public Key is correctly entered</li>
                            <li>Secret Key is correctly entered</li>
                            <li>Encryption Key is correctly entered</li>
                            <li>Environment is set to "Sandbox" for testing</li>
                        </ul>
                    </div>
                    
                    <div class="p-4 bg-green-50 rounded-lg">
                        <h4 class="font-medium text-gray-900 mb-2">2. Check Logs</h4>
                        <p class="text-sm text-gray-600">If payment flow fails, check the Laravel logs for detailed error messages:</p>
                        <pre class="bg-gray-800 text-green-400 p-3 rounded mt-2 text-xs overflow-x-auto">
tail -f storage/logs/laravel.log
                        </pre>
                    </div>
                    
                    <div class="p-4 bg-yellow-50 rounded-lg">
                        <h4 class="font-medium text-gray-900 mb-2">3. Verify Flutterwave Dashboard</h4>
                        <p class="text-sm text-gray-600">Login to your Flutterwave dashboard to verify API keys and test transactions:</p>
                        <a href="https://dashboard.flutterwave.com" target="_blank" class="text-blue-600 hover:underline text-sm mt-2 inline-block">
                            Flutterwave Dashboard →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fetch configuration status
    fetch('{{ route("test.flutterwave.admin") }}')
        .then(response => response.json())
        .then(data => {
            const configStatus = document.getElementById('config-status');
            const testPaymentBtn = document.getElementById('test-payment-btn');
            
            let statusHtml = '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">';
            
            // Configuration status
            statusHtml += `
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Configuration</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <span class="w-32 text-sm text-gray-600">Active:</span>
                            <span class="${data.config.active === 'Yes' ? 'text-green-600' : 'text-red-600'} font-medium">${data.config.active}</span>
                        </li>
                        <li class="flex items-center">
                            <span class="w-32 text-sm text-gray-600">Public Key:</span>
                            <span class="${data.config.public_key === 'Set' ? 'text-green-600' : 'text-red-600'} font-medium">${data.config.public_key}</span>
                        </li>
                        <li class="flex items-center">
                            <span class="w-32 text-sm text-gray-600">Secret Key:</span>
                            <span class="${data.config.secret_key === 'Set' ? 'text-green-600' : 'text-red-600'} font-medium">${data.config.secret_key}</span>
                        </li>
                        <li class="flex items-center">
                            <span class="w-32 text-sm text-gray-600">Encryption Key:</span>
                            <span class="${data.config.encryption_key === 'Set' ? 'text-green-600' : 'text-red-600'} font-medium">${data.config.encryption_key}</span>
                        </li>
                        <li class="flex items-center">
                            <span class="w-32 text-sm text-gray-600">Environment:</span>
                            <span class="font-medium">${data.config.environment}</span>
                        </li>
                    </ul>
                </div>`;
            
            // API connection status
            statusHtml += `
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">API Connection</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <span class="w-32 text-sm text-gray-600">Connection Test:</span>
                            <span class="${data.config.connection_test === 'Attempted' ? 'text-green-600' : 'text-red-600'} font-medium">${data.config.connection_test}</span>
                        </li>
                        <li class="flex items-center">
                            <span class="w-32 text-sm text-gray-600">API Status:</span>
                            <span class="${data.config.api_status === 'Connected' ? 'text-green-600' : 'text-red-600'} font-medium">${data.config.api_status}</span>
                        </li>
                        <li class="flex items-center">
                            <span class="w-32 text-sm text-gray-600">Overall Status:</span>
                            <span class="${data.is_configured ? 'text-green-600' : 'text-red-600'} font-medium">${data.is_configured ? 'Ready' : 'Not Configured'}</span>
                        </li>
                    </ul>
                </div>`;
            
            statusHtml += '</div>';
            
            // Add summary message
            if (data.is_configured) {
                statusHtml += `
                    <div class="mt-4 p-3 bg-green-100 text-green-800 rounded-lg">
                        <p class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Flutterwave is properly configured and ready to process payments.
                        </p>
                    </div>`;
                
                // Enable test payment button
                testPaymentBtn.disabled = false;
            } else {
                statusHtml += `
                    <div class="mt-4 p-3 bg-red-100 text-red-800 rounded-lg">
                        <p class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Flutterwave is not properly configured. Please check the settings above.
                        </p>
                    </div>`;
                
                // Keep test payment button disabled
                testPaymentBtn.disabled = true;
            }
            
            configStatus.innerHTML = statusHtml;
        })
        .catch(error => {
            console.error('Error fetching configuration status:', error);
            document.getElementById('config-status').innerHTML = `
                <div class="p-3 bg-red-100 text-red-800 rounded-lg">
                    <p>Error fetching configuration status. Please try again.</p>
                </div>`;
        });
});
</script>
@endsection