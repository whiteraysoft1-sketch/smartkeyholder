<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-100 via-white to-purple-100 flex flex-col items-center px-2 py-2 sm:px-0">
        <div class="w-full max-w-md mx-auto space-y-6 pb-8 pt-8">
            <!-- Success Card -->
            <div class="liquid-glass p-8 rounded-xl shadow-lg">
                <div class="flex flex-col items-center text-center">
                    <!-- Success Icon -->
                    <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center mb-6">
                        <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    
                    <!-- Success Message -->
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Payment Successful!</h2>
                    <p class="text-gray-600 mb-6">Your QR code purchase has been completed successfully.</p>
                    
                    <!-- Purchase Details -->
                    <div class="w-full bg-white/50 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-gray-700 mb-3">Purchase Details</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Package:</span>
                                <span class="font-medium text-gray-800">{{ $purchase->package_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quantity:</span>
                                <span class="font-medium text-gray-800">{{ $purchase->quantity }} QR Code(s)</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Amount:</span>
                                <span class="font-medium text-gray-800">{{ $purchase->currency }} {{ number_format($purchase->amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-medium text-green-600">Completed</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Transaction ID:</span>
                                <span class="font-medium text-gray-800">{{ $purchase->flutterwave_transaction_id }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- What's Next Section -->
                    <div class="w-full bg-blue-50 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-blue-700 mb-2">What's Next?</h3>
                        <ul class="text-sm text-blue-800 space-y-2 list-disc list-inside">
                            <li>Your QR codes have been added to your account</li>
                            <li>You can view and manage your QR codes from your dashboard</li>
                            <li>Download your QR codes as PNG or SVG files</li>
                            <li>Share your QR codes with others</li>
                        </ul>
                    </div>
                    
                    <!-- Dashboard Button -->
                    <a href="{{ route('dashboard') }}" class="w-full py-4 px-6 rounded-full font-bold text-white text-lg bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Go to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>