<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\User;
use App\Models\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    /**
     * Get Flutterwave API base URL
     */
    private function getFlutterwaveBaseUrl()
    {
        // Get environment from admin settings
        $paymentSettings = \App\Models\Setting::getByGroup('payment');
        
        // Handle if $paymentSettings is a Collection
        if ($paymentSettings instanceof \Illuminate\Support\Collection) {
            $paymentSettings = $paymentSettings->toArray();
        }
        
        $environment = $paymentSettings['flutterwave_environment'] ?? config('services.flutterwave.environment', 'sandbox');
        
        \Log::info('Getting Flutterwave base URL', [
            'environment' => $environment,
            'from_settings' => isset($paymentSettings['flutterwave_environment']) ? 'Yes' : 'No'
        ]);
        
        // Note: Currently both URLs are the same, but this allows for future changes
        $baseUrl = 'https://api.flutterwave.com/v3';
        
        \Log::info('Using Flutterwave base URL', ['url' => $baseUrl, 'environment' => $environment]);
        
        return $baseUrl;
    }

    /**
     * Make Flutterwave API request
     */
    private function makeFlutterwaveRequest($endpoint, $data = [], $method = 'POST')
    {
        // Get secret key from admin settings
        $paymentSettings = \App\Models\Setting::getByGroup('payment');
        
        // Handle if $paymentSettings is a Collection
        if ($paymentSettings instanceof \Illuminate\Support\Collection) {
            $paymentSettings = $paymentSettings->toArray();
        }
        
        $secretKey = $paymentSettings['flutterwave_secret_key'] ?? config('services.flutterwave.secret_key');
        
        \Log::info('Making Flutterwave API request', [
            'endpoint' => $endpoint,
            'method' => $method,
            'has_secret_key' => !empty($secretKey) ? 'Yes' : 'No',
            'base_url' => $this->getFlutterwaveBaseUrl(),
            'data_keys' => array_keys($data)
        ]);
        
        if (!$secretKey) {
            \Log::error('Flutterwave secret key not configured');
            throw new \Exception('Flutterwave secret key not configured. Please check your admin settings or environment variables.');
        }

        try {
            // Create HTTP client with SSL verification disabled for development environments
            $http = Http::withHeaders([
                'Authorization' => 'Bearer ' . $secretKey,
                'Content-Type' => 'application/json',
            ]);
            
            // Disable SSL verification in development environment
            if (app()->environment('local', 'development', 'testing')) {
                $http = $http->withoutVerifying();
                \Log::warning('SSL verification disabled for Flutterwave API in development environment');
            }
            
            $response = $http->$method($this->getFlutterwaveBaseUrl() . $endpoint, $data);
            
            \Log::info('Flutterwave API response received', [
                'status_code' => $response->status(),
                'successful' => $response->successful() ? 'Yes' : 'No',
                'body_preview' => substr($response->body(), 0, 500) // Log first 500 chars of response
            ]);

            if ($response->failed()) {
                \Log::error('Flutterwave API request failed', [
                    'status_code' => $response->status(),
                    'body' => $response->body(),
                    'endpoint' => $endpoint
                ]);
                throw new \Exception('Flutterwave API request failed: ' . $response->body());
            }

            return $response->json();
        } catch (\Exception $e) {
            \Log::error('Exception in Flutterwave API request', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'endpoint' => $endpoint
            ]);
            throw $e;
        }
    }

    /**
     * Check if Flutterwave is properly configured
     */
    private function isFlutterwaveConfigured()
    {
        // Check admin settings first, then fall back to config
        $paymentSettings = \App\Models\Setting::getByGroup('payment');
        
        // Convert to array if it's a Collection
        if ($paymentSettings instanceof \Illuminate\Support\Collection) {
            $settingsArray = $paymentSettings->toArray();
            \Log::info('Checking Flutterwave configuration', [
                'payment_settings_keys' => array_keys($settingsArray),
                'is_collection' => true
            ]);
        } else {
            \Log::info('Checking Flutterwave configuration', [
                'payment_settings_keys' => is_array($paymentSettings) ? array_keys($paymentSettings) : 'Not an array',
                'payment_settings_type' => gettype($paymentSettings)
            ]);
        }
        
        // Check if Flutterwave is explicitly enabled in admin settings
        $isActive = isset($paymentSettings['flutterwave_active']) && $paymentSettings['flutterwave_active'];
        
        // Check if API keys are configured
        $secretKey = $paymentSettings['flutterwave_secret_key'] ?? config('services.flutterwave.secret_key');
        $publicKey = $paymentSettings['flutterwave_public_key'] ?? config('services.flutterwave.public_key');
        $encryptionKey = $paymentSettings['flutterwave_encryption_key'] ?? null;
        $hasKeys = !empty($secretKey) && !empty($publicKey);
        
        \Log::info('Flutterwave configuration status', [
            'active' => $isActive ? 'Yes' : 'No',
            'has_public_key' => !empty($publicKey) ? 'Yes' : 'No',
            'has_secret_key' => !empty($secretKey) ? 'Yes' : 'No',
            'has_encryption_key' => !empty($encryptionKey) ? 'Yes' : 'No',
            'is_configured' => ($isActive && $hasKeys) ? 'Yes' : 'No'
        ]);
        
        // Flutterwave is configured if it's active and has valid API keys
        return $isActive && $hasKeys;
    }

    /**
     * Get the default currency from settings
     */
    private function getDefaultCurrency()
    {
        return setting('default_currency', 'USD');
    }

    /**
     * Get supported currencies for Flutterwave
     */
    private function getSupportedCurrencies()
    {
        return [
            'USD', 'EUR', 'GBP', 'NGN', 'KES', 'GHS', 'ZAR', 'XAF', 'XOF', 
            'UGX', 'TZS', 'RWF', 'ZMW', 'MWK', 'SLL', 'LRD'
        ];
    }

    /**
     * Validate currency against Flutterwave supported currencies
     */
    private function validateCurrency($currency)
    {
        $supportedCurrencies = $this->getSupportedCurrencies();
        
        if (!in_array($currency, $supportedCurrencies)) {
            // Fallback to USD if currency is not supported
            return 'USD';
        }
        
        return $currency;
    }

    /**
     * Get currency symbol
     */
    private function getCurrencySymbol($currency = null)
    {
        // First try to get the symbol from admin settings
        $currencySettings = \App\Models\Setting::getByGroup('currency');
        $customSymbol = $currencySettings['currency_symbol'] ?? null;
        
        if ($customSymbol) {
            return $customSymbol;
        }
        
        // Fallback to predefined currency symbols
        $currency = $currency ?: $this->getDefaultCurrency();
        $currencies = \App\Models\UserProfile::getCurrencyOptions();
        
        return $currencies[$currency]['symbol'] ?? '$';
    }
    
    /**
     * Get currency position (before or after amount)
     */
    private function getCurrencyPosition()
    {
        $currencySettings = \App\Models\Setting::getByGroup('currency');
        return $currencySettings['currency_position'] ?? 'before';
    }

    /**
     * Show billing page
     */
    public function billing()
    {
        $user = auth()->user();
        $activeSubscription = $user->activeSubscription;
        $subscriptions = $user->subscriptions()->latest()->get();
        
        // Get available pricing plans from admin settings
        $availablePlans = \App\Models\PricingPlan::active();
        
        // Get currency settings
        $defaultCurrency = $this->getDefaultCurrency();
        $validatedCurrency = $this->validateCurrency($defaultCurrency);
        $currencySymbol = $this->getCurrencySymbol($validatedCurrency);
        $currencyPosition = $this->getCurrencyPosition();
        
        // Format plans for display
        $formattedPlans = [];
        foreach ($availablePlans as $plan) {
            $convertedPrice = $this->convertPrice($plan->price, $validatedCurrency);
            
            $formattedPlans[] = [
                'id' => $plan->id,
                'name' => $plan->name,
                'slug' => $plan->slug,
                'price' => $convertedPrice,
                'original_price' => $plan->price,
                'currency' => $validatedCurrency,
                'currency_symbol' => $currencySymbol,
                'currency_position' => $currencyPosition,
                'billing_cycle' => $plan->billing_cycle,
                'billing_cycle_text' => $plan->billing_cycle_text,
                'description' => $plan->description,
                'features' => $plan->features ?: [],
                'is_popular' => $plan->is_popular,
                'is_free_trial' => $plan->is_free_trial,
                'trial_days' => $plan->trial_days,
                'button_text' => $plan->button_text ?: 'Choose Plan',
                'badge_text' => $plan->badge_text,
                'has_whatsapp_store' => $plan->has_whatsapp_store,
                'max_social_links' => $plan->max_social_links,
                'max_gallery_images' => $plan->max_gallery_images,
                'has_analytics' => $plan->has_analytics,
                'has_custom_themes' => $plan->has_custom_themes,
                'has_priority_support' => $plan->has_priority_support,
                'has_qr_customization' => $plan->has_qr_customization,
            ];
        }
        
        // Check if user's trial is about to expire (within 3 days)
        $trialExpiringSoon = false;
        if ($user->isOnTrial() && $user->trial_ends_at) {
            $daysUntilExpiry = now()->diffInDays($user->trial_ends_at, false);
            $trialExpiringSoon = $daysUntilExpiry <= 3 && $daysUntilExpiry >= 0;
        }

        return view('billing.index', compact(
            'user', 
            'activeSubscription', 
            'subscriptions', 
            'formattedPlans',
            'trialExpiringSoon'
        ));
    }

    /**
     * Show subscription plans
     */
    public function plans()
    {
        $defaultCurrency = $this->getDefaultCurrency();
        $validatedCurrency = $this->validateCurrency($defaultCurrency);
        $currencySymbol = $this->getCurrencySymbol($validatedCurrency);

        // Get plans from database
        $dbPlans = \App\Models\PricingPlan::active();
        
        $plans = [];
        foreach ($dbPlans as $plan) {
            // Convert price based on currency
            $convertedPrice = $this->convertPrice($plan->price, $validatedCurrency);
            
            $plans[] = [
                'id' => $plan->id,
                'name' => $plan->name,
                'slug' => $plan->slug,
                'price' => $convertedPrice,
                'currency' => $validatedCurrency,
                'currency_symbol' => $currencySymbol,
                'duration' => $plan->billing_cycle_text,
                'plan_type' => $plan->slug,
                'description' => $plan->description,
                'features' => $plan->features ?: [],
                'is_popular' => $plan->is_popular,
                'is_free_trial' => $plan->is_free_trial,
                'button_text' => $plan->button_text ?: 'Choose Plan',
                'badge_text' => $plan->badge_text,
                'has_whatsapp_store' => $plan->has_whatsapp_store,
            ];
        }

        // If no plans in database, use fallback
        if (empty($plans)) {
            $plans = [
                [
                    'name' => 'Free Trial',
                    'price' => 0,
                    'currency' => $validatedCurrency,
                    'currency_symbol' => $currencySymbol,
                    'duration' => '1 month free',
                    'plan_type' => 'free',
                    'features' => [
                        'Custom QR Profile',
                        'Up to 3 Social Links',
                        'Photo Gallery (5 images)',
                        'Basic Analytics',
                        'Mobile Responsive',
                        '1 Month Free Access'
                    ]
                ],
                [
                    'name' => 'Basic',
                    'price' => $validatedCurrency === 'NGN' ? 3999 : ($validatedCurrency === 'EUR' ? 8.99 : 9.99),
                    'currency' => $validatedCurrency,
                    'currency_symbol' => $currencySymbol,
                    'duration' => 'monthly',
                    'plan_type' => 'basic',
                    'features' => [
                        'Custom QR Profile',
                        'Unlimited Social Links',
                        'Photo Gallery (10 images)',
                        'Basic Analytics',
                        'Mobile Responsive'
                    ]
                ]
            ];
        }

        return view('billing.plans', compact('plans'));
    }

    /**
     * Convert price based on currency
     */
    private function convertPrice($basePrice, $targetCurrency)
    {
        // Simple currency conversion - in production, you'd use real exchange rates
        $conversionRates = [
            'USD' => 1.0,
            'EUR' => 0.85,
            'GBP' => 0.73,
            'NGN' => 400.0,
            'KES' => 110.0,
            'GHS' => 6.0,
            'ZAR' => 15.0,
        ];

        $rate = $conversionRates[$targetCurrency] ?? 1.0;
        return round($basePrice * $rate, $targetCurrency === 'NGN' ? 0 : 2);
    }

    /**
     * Show QR code purchase options
     */
    public function qrCodePurchase()
    {
        // Get currency settings from Admin Settings - Currency Settings
        $defaultCurrency = $this->getDefaultCurrency();
        $validatedCurrency = $this->validateCurrency($defaultCurrency);
        $currencySymbol = $this->getCurrencySymbol($validatedCurrency);
        $currencyPosition = $this->getCurrencyPosition();

        // Get QR Purchase settings from Admin Settings
        $qrSettings = \App\Models\Setting::getByGroup('qr_purchase');
        
        // Build packages from admin settings
        $packages = [
            [
                'name' => 'Single QR Code',
                'quantity' => 1,
                'price' => $this->getQrPrice($qrSettings, 'single', $validatedCurrency),
                'currency' => $validatedCurrency,
                'currency_symbol' => $currencySymbol,
                'currency_position' => $currencyPosition,
                'description' => $qrSettings['single_qr_description'] ?? 'Perfect for individuals'
            ],
            [
                'name' => 'Business Pack',
                'quantity' => 10,
                'price' => $this->getQrPrice($qrSettings, 'business', $validatedCurrency),
                'currency' => $validatedCurrency,
                'currency_symbol' => $currencySymbol,
                'currency_position' => $currencyPosition,
                'description' => $qrSettings['business_pack_description'] ?? 'Great for small businesses',
                'savings' => $qrSettings['business_pack_savings'] ?? '20% off'
            ],
            [
                'name' => 'Enterprise Pack',
                'quantity' => 50,
                'price' => $this->getQrPrice($qrSettings, 'enterprise', $validatedCurrency),
                'currency' => $validatedCurrency,
                'currency_symbol' => $currencySymbol,
                'currency_position' => $currencyPosition,
                'description' => $qrSettings['enterprise_pack_description'] ?? 'Perfect for large organizations',
                'savings' => $qrSettings['enterprise_pack_savings'] ?? '40% off',
                'popular' => !empty($qrSettings['enterprise_pack_popular'])
            ]
        ];

        // Get page content settings
        $pageSettings = [
            'title' => $qrSettings['qr_purchase_page_title'] ?? 'Purchase Additional QR Codes',
            'subtitle' => $qrSettings['qr_purchase_page_subtitle'] ?? 'Get more QR codes for your business or organization',
            'currency_info_text' => $qrSettings['currency_info_text'] ?? 'Prices are automatically adjusted based on your region and preferred currency settings.',
            'features' => [
                [
                    'title' => $qrSettings['feature1_title'] ?? 'Permanent & Secure',
                    'description' => $qrSettings['feature1_description'] ?? 'Each QR code is unique and permanently yours once claimed',
                    'icon' => 'lock'
                ],
                [
                    'title' => $qrSettings['feature2_title'] ?? 'Analytics Included',
                    'description' => $qrSettings['feature2_description'] ?? 'Track scans, views, and engagement for each QR code',
                    'icon' => 'chart'
                ],
                [
                    'title' => $qrSettings['feature3_title'] ?? 'Mobile Optimized',
                    'description' => $qrSettings['feature3_description'] ?? 'Perfect viewing experience on all devices',
                    'icon' => 'mobile'
                ]
            ],
            'faqs' => [
                [
                    'question' => $qrSettings['faq1_question'] ?? 'How do QR codes work?',
                    'answer' => $qrSettings['faq1_answer'] ?? 'Each QR code is unique and can be claimed by scanning it. Once claimed, it becomes a permanent digital profile that you can customize and share.'
                ],
                [
                    'question' => $qrSettings['faq2_question'] ?? 'Can I print the QR codes?',
                    'answer' => $qrSettings['faq2_answer'] ?? 'Yes! You can download your QR codes in high-resolution PNG or SVG format, perfect for printing on business cards, stickers, or any physical item.'
                ],
                [
                    'question' => $qrSettings['faq3_question'] ?? 'What currencies do you accept?',
                    'answer' => $qrSettings['faq3_answer'] ?? 'We support multiple currencies including USD, EUR, GBP, NGN, and many others through our secure payment gateway. Prices are automatically converted based on your settings.'
                ],
                [
                    'question' => $qrSettings['faq4_question'] ?? 'What happens after purchase?',
                    'answer' => $qrSettings['faq4_answer'] ?? 'Your QR codes will be immediately available in your dashboard. You can download them, view analytics, and manage your digital profiles.'
                ]
            ]
        ];

        return view('billing.qr-purchase', compact('packages', 'pageSettings'));
    }

    /**
     * Get QR code price based on package type from settings
     */
    private function getQrPrice($qrSettings, $packageType, $currency)
    {
        // Use single price field for each package
        if ($packageType === 'single') {
            // First try to get the price from the settings
            $price = $qrSettings['single_qr_price'] ?? null;
            
            // If price is not set in settings, use default
            if ($price === null) {
                $price = 4.99;
            }
            
            return $price;
        } elseif ($packageType === 'business') {
            $price = $qrSettings['business_pack_price'] ?? null;
            
            if ($price === null) {
                $price = 39.99;
            }
            
            return $price;
        } elseif ($packageType === 'enterprise') {
            $price = $qrSettings['enterprise_pack_price'] ?? null;
            
            if ($price === null) {
                $price = 149.99;
            }
            
            return $price;
        }
        
        return 4.99;
    }

    /**
     * Initialize QR code purchase payment
     */
    public function initializeQrCodePayment(Request $request)
    {
        $request->validate([
            'package' => 'required|string|in:single,business,enterprise',
        ]);

        // Check if Flutterwave is configured
        if (!$this->isFlutterwaveConfigured()) {
            return back()->with('error', 'Payment system is not configured. Please contact support.');
        }

        $user = auth()->user();
        $defaultCurrency = $this->getDefaultCurrency();
        $validatedCurrency = $this->validateCurrency($defaultCurrency);
        $currencySymbol = $this->getCurrencySymbol($validatedCurrency);
        $currencyPosition = $this->getCurrencyPosition();
        
        // Get Flutterwave public key from admin settings
        $paymentSettings = \App\Models\Setting::getByGroup('payment');
        
        // Handle if $paymentSettings is a Collection
        if ($paymentSettings instanceof \Illuminate\Support\Collection) {
            $paymentSettings = $paymentSettings->toArray();
        }
        
        $publicKey = $paymentSettings['flutterwave_public_key'] ?? config('services.flutterwave.public_key');
        
        // Get QR Purchase settings from Admin Settings
        $qrSettings = \App\Models\Setting::getByGroup('qr_purchase');
        
        $packages = [
            'single' => [
                'name' => 'Single QR Code',
                'quantity' => 1,
                'amount' => $this->getQrPrice($qrSettings, 'single', $validatedCurrency),
                'currency_symbol' => $currencySymbol,
                'currency_position' => $currencyPosition
            ],
            'business' => [
                'name' => 'Business Pack',
                'quantity' => 10,
                'amount' => $this->getQrPrice($qrSettings, 'business', $validatedCurrency),
                'currency_symbol' => $currencySymbol,
                'currency_position' => $currencyPosition
            ],
            'enterprise' => [
                'name' => 'Enterprise Pack',
                'quantity' => 50,
                'amount' => $this->getQrPrice($qrSettings, 'enterprise', $validatedCurrency),
                'currency_symbol' => $currencySymbol,
                'currency_position' => $currencyPosition
            ],
        ];

        $selectedPackage = $packages[$request->package];
        $reference = 'QR_' . Str::random(10) . '_' . time();

        $payload = [
            'tx_ref' => $reference,
            'amount' => $selectedPackage['amount'],
            'currency' => $validatedCurrency,
            'redirect_url' => route('payment.qr-callback'),
            'payment_options' => 'card,mobilemoney,ussd,banktransfer,barter,payattitude',
            'customer' => [
                'email' => $user->email,
                'name' => $user->name,
                'phonenumber' => $user->profile->phone ?? '',
            ],
            'customizations' => [
                'title' => 'Whiteray Smart Tag - QR Codes',
                'description' => $selectedPackage['name'] . ' - ' . $selectedPackage['quantity'] . ' QR Code(s)',
                'logo' => asset('images/logo.png'),
            ],
            'meta' => [
                'user_id' => $user->id,
                'package' => $request->package,
                'package_name' => $selectedPackage['name'],
                'quantity' => $selectedPackage['quantity'],
                'type' => 'qr_purchase',
                'amount' => $selectedPackage['amount'],
                'currency' => $validatedCurrency,
            ],
        ];

        try {
            $response = $this->makeFlutterwaveRequest('/payments', $payload);
            
            if (isset($response['status']) && $response['status'] === 'success') {
                // Store payment record for tracking
                \DB::table('qr_purchases')->insert([
                    'user_id' => $user->id,
                    'package_name' => $selectedPackage['name'],
                    'quantity' => $selectedPackage['quantity'],
                    'amount' => $selectedPackage['amount'],
                    'currency' => $validatedCurrency,
                    'status' => 'pending',
                    'flutterwave_reference' => $reference,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return redirect($response['data']['link']);
            }

            return back()->with('error', 'Payment initialization failed. Please try again.');
        } catch (\Exception $e) {
            return back()->with('error', 'Payment service unavailable: ' . $e->getMessage());
        }
    }

    /**
     * Handle QR code purchase callback
     */
    public function qrCodePaymentCallback(Request $request)
    {
        $transactionId = $request->transaction_id;
        $reference = $request->tx_ref;

        if (!$transactionId || !$reference) {
            return redirect()->route('billing')->with('error', 'Invalid payment response.');
        }

        try {
            $response = $this->makeFlutterwaveRequest("/transactions/{$transactionId}/verify", [], 'GET');

            if (isset($response['status']) && $response['status'] === 'success' &&
                isset($response['data']['status']) && $response['data']['status'] === 'successful') {
                $purchase = \DB::table('qr_purchases')->where('flutterwave_reference', $reference)->first();

                if ($purchase) {
                    // Update purchase status
                    \DB::table('qr_purchases')->where('id', $purchase->id)->update([
                        'status' => 'completed',
                        'flutterwave_transaction_id' => $transactionId,
                        'updated_at' => now(),
                    ]);

                    // Get the updated purchase record
                    $purchase = \DB::table('qr_purchases')->where('id', $purchase->id)->first();

                    // Generate QR codes for the user
                    $user = User::find($purchase->user_id);
                    for ($i = 0; $i < $purchase->quantity; $i++) {
                        QrCode::create([
                            'user_id' => $user->id,
                            'is_claimed' => true,
                            'claimed_at' => now(),
                        ]);
                    }

                    // Redirect to QR purchase success page
                    return view('payment.qr-success', compact('purchase'));
                }
            }

            return redirect()->route('billing')->with('error', 'Payment verification failed.');
        } catch (\Exception $e) {
            return redirect()->route('billing')->with('error', 'Payment verification failed. Please contact support.');
        }
    }

    /**
     * Activate free trial
     */
    public function activateFreeTrial(Request $request, $plan = null)
    {
        $user = auth()->user();
        
        // Check if user already has an active subscription or trial
        if ($user->hasActiveSubscription() || $user->isOnTrial()) {
            return back()->with('error', 'You already have an active subscription or trial.');
        }

        $defaultCurrency = $this->getDefaultCurrency();
        $validatedCurrency = $this->validateCurrency($defaultCurrency);

        // Determine trial duration
        $trialDays = 30; // Default
        $planName = 'Free Trial';
        
        if ($plan && isset($plan->trial_days) && $plan->trial_days > 0) {
            $trialDays = $plan->trial_days;
            $planName = $plan->name;
        }

        // Create free trial subscription
        Subscription::create([
            'user_id' => $user->id,
            'plan_name' => $planName,
            'amount' => 0,
            'currency' => $validatedCurrency,
            'status' => 'active',
            'flutterwave_reference' => 'FREE_TRIAL_' . Str::random(10),
            'starts_at' => now(),
            'ends_at' => now()->addDays($trialDays),
            'metadata' => [
                'type' => 'free_trial',
                'plan_id' => $plan ? $plan->id : null,
                'trial_days' => $trialDays
            ],
        ]);

        // Update user trial status
        $user->update([
            'trial_ends_at' => now()->addDays($trialDays),
            'is_subscribed' => false,
        ]);

        $message = "Free trial activated! You have {$trialDays} days of free access.";
        return redirect()->route('dashboard')->with('success', $message);
    }

    /**
     * Initialize payment
     */
    public function initializePayment(Request $request)
    {
        $request->validate([
            'plan' => 'required|string',
            'plan_id' => 'nullable|integer|exists:pricing_plans,id',
            'amount' => 'nullable|numeric|min:1',
        ]);

        $user = auth()->user();
        
        // Special case for test payment
        if ($request->plan === 'test_plan') {
            \Log::info('Initiating test payment flow', [
                'user_id' => $user->id,
                'amount' => $request->amount ?? 10.00
            ]);
            
            // Check if Flutterwave is configured
            if (!$this->isFlutterwaveConfigured()) {
                return back()->with('error', 'Flutterwave is not properly configured. Please check your settings.');
            }
            
            // Create a test plan object
            $plan = new \stdClass();
            $plan->id = 'test_' . time();
            $plan->name = 'Test Plan';
            $plan->slug = 'test_plan';
            $plan->price = $request->amount ?? 10.00;
            $plan->description = 'This is a test payment for Flutterwave integration';
            $plan->billing_cycle = 'month';
            $plan->is_active = true;
            $plan->is_popular = false;
            $plan->is_free_trial = false;
            $plan->has_whatsapp_store = false;
            
            \Log::info('Created test plan object', [
                'plan' => json_encode($plan)
            ]);
        } else {
            // Get the plan from database - prefer plan_id if provided
            if ($request->plan_id) {
                $plan = \App\Models\PricingPlan::where('id', $request->plan_id)
                    ->where('is_active', true)
                    ->first();
            } else {
                $plan = \App\Models\PricingPlan::where('slug', $request->plan)
                    ->where('is_active', true)
                    ->first();
            }

            if (!$plan) {
                return back()->with('error', 'Selected plan not found or is not available. Please contact support if this issue persists.');
            }
            
            \Log::info('Found pricing plan for payment', [
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
                'plan_slug' => $plan->slug,
                'plan_price' => $plan->price,
                'user_id' => $user->id
            ]);
        }

        // Handle free trial
        if (isset($plan->is_free_trial) && $plan->is_free_trial || $request->plan === 'free' || $request->plan === 'free-trial') {
            return $this->activateFreeTrial($request, $plan);
        }

        // Check if Flutterwave is configured for paid plans
        if (!$this->isFlutterwaveConfigured()) {
            // Add detailed error logging
            $paymentSettings = \App\Models\Setting::getByGroup('payment');
            
            // Handle if $paymentSettings is a Collection
            if ($paymentSettings instanceof \Illuminate\Support\Collection) {
                $paymentSettings = $paymentSettings->toArray();
            }
            
            $isActive = isset($paymentSettings['flutterwave_active']) && $paymentSettings['flutterwave_active'];
            $secretKey = $paymentSettings['flutterwave_secret_key'] ?? config('services.flutterwave.secret_key');
            $publicKey = $paymentSettings['flutterwave_public_key'] ?? config('services.flutterwave.public_key');
            $hasKeys = !empty($secretKey) && !empty($publicKey);
            
            \Log::error('Flutterwave configuration check failed', [
                'flutterwave_active' => $isActive ? 'Yes' : 'No',
                'has_public_key' => !empty($publicKey) ? 'Yes' : 'No',
                'has_secret_key' => !empty($secretKey) ? 'Yes' : 'No',
                'all_settings' => $paymentSettings
            ]);
            
            return back()->with('error', 'Payment system is not configured. Please contact support or try the free trial. Details: Active=' . ($isActive ? 'Yes' : 'No') . ', Keys=' . ($hasKeys ? 'Yes' : 'No'));
        }

        $defaultCurrency = $this->getDefaultCurrency();
        $validatedCurrency = $this->validateCurrency($defaultCurrency);
        
        // Get Flutterwave public key from admin settings
        $paymentSettings = \App\Models\Setting::getByGroup('payment');
        
        // Handle if $paymentSettings is a Collection
        if ($paymentSettings instanceof \Illuminate\Support\Collection) {
            $paymentSettings = $paymentSettings->toArray();
        }
        
        $publicKey = $paymentSettings['flutterwave_public_key'] ?? config('services.flutterwave.public_key');
        
        // Convert plan price to user's currency
        $convertedPrice = $this->convertPrice($plan->price, $validatedCurrency);
        
        $reference = 'WS_' . Str::random(10) . '_' . time();

        $payload = [
            'tx_ref' => $reference,
            'amount' => $convertedPrice,
            'currency' => $validatedCurrency,
            'redirect_url' => route('payment.callback'),
            'payment_options' => 'card,mobilemoney,ussd,banktransfer,barter,payattitude',
            'customer' => [
                'email' => $user->email,
                'name' => $user->name,
                'phonenumber' => $user->profile->phone ?? '',
            ],
            'customizations' => [
                'title' => 'Whiteray Smart Tag - ' . $plan->name,
                'description' => $plan->name . ' Plan Subscription - ' . $plan->description,
                'logo' => asset('images/logo.png'),
            ],
            'meta' => [
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'plan_slug' => $plan->slug,
                'plan_name' => $plan->name,
                'original_amount' => $plan->price,
                'converted_amount' => $convertedPrice,
                'currency' => $validatedCurrency,
                'billing_cycle' => $plan->billing_cycle,
                'subscription_type' => 'plan_subscription',
            ],
        ];

        try {
            // Log before making the request
            \Log::info('Attempting Flutterwave payment initialization', [
                'payload' => $payload,
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
                'flutterwave_active' => $isActive ?? 'unknown',
                'has_keys' => $hasKeys ?? 'unknown'
            ]);
            
            $response = $this->makeFlutterwaveRequest('/payments', $payload);
            
            // Log the response
            \Log::info('Flutterwave payment initialization response', [
                'response' => $response,
                'status' => $response['status'] ?? 'unknown',
                'has_link' => isset($response['data']['link']) ? 'Yes' : 'No'
            ]);
            
            if (isset($response['status']) && $response['status'] === 'success') {
                // Log successful response
                \Log::info('Flutterwave payment initialization successful', [
                    'redirect_link' => $response['data']['link'] ?? 'No link provided',
                    'reference' => $reference
                ]);
                
                // Create pending subscription record
                $subscription = Subscription::create([
                    'user_id' => $user->id,
                    'plan_name' => $plan->name,
                    'amount' => $convertedPrice,
                    'currency' => $validatedCurrency,
                    'status' => 'pending',
                    'flutterwave_reference' => $reference,
                    'starts_at' => now(),
                    'ends_at' => $this->calculateEndDate($plan),
                    'metadata' => $payload,
                ]);
                
                \Log::info('Created pending subscription', [
                    'subscription_id' => $subscription->id,
                    'user_id' => $user->id,
                    'plan_name' => $plan->name
                ]);

                // Redirect to Flutterwave payment page
                $redirectUrl = $response['data']['link'];
                \Log::info('Redirecting to Flutterwave', ['url' => $redirectUrl]);
                return redirect($redirectUrl);
            }

            // Log the response for debugging
            \Log::error('Flutterwave payment initialization failed', [
                'response' => $response,
                'payload' => $payload,
                'user_id' => $user->id,
                'plan_id' => $plan->id
            ]);

            return back()->with('error', 'Payment initialization failed. Please try again. Response: ' . json_encode($response));
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Flutterwave payment exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $payload,
                'user_id' => $user->id,
                'plan_id' => $plan->id
            ]);

            return back()->with('error', 'Payment service unavailable: ' . $e->getMessage());
        }
    }

    /**
     * Calculate subscription end date based on plan billing cycle
     */
    private function calculateEndDate($plan)
    {
        $startDate = now();
        
        switch ($plan->billing_cycle) {
            case 'year':
                return $startDate->addYear();
            case 'month':
                return $startDate->addMonth();
            case 'week':
                return $startDate->addWeek();
            case 'day':
                return $startDate->addDay();
            default:
                return $startDate->addMonth();
        }
    }

    /**
     * Handle payment callback
     */
    public function paymentCallback(Request $request)
    {
        $transactionId = $request->transaction_id;
        $reference = $request->tx_ref;

        if (!$transactionId || !$reference) {
            return redirect()->route('billing')->with('error', 'Invalid payment response.');
        }

        try {
            $response = $this->makeFlutterwaveRequest("/transactions/{$transactionId}/verify", [], 'GET');

            if (isset($response['status']) && $response['status'] === 'success' &&
                isset($response['data']['status']) && $response['data']['status'] === 'successful') {
                $subscription = Subscription::where('flutterwave_reference', $reference)->first();

                if ($subscription) {
                    // Update subscription
                    $subscription->update([
                        'status' => 'active',
                        'flutterwave_transaction_id' => $transactionId,
                    ]);

                    // Update user subscription status
                    $user = $subscription->user;
                    $user->update([
                        'is_subscribed' => true,
                        'subscription_ends_at' => $subscription->ends_at,
                    ]);

                    // Redirect to payment success page with subscription details
                    return view('payment.success', compact('subscription'));
                }
            }

            return redirect()->route('billing')->with('error', 'Payment verification failed.');
        } catch (\Exception $e) {
            return redirect()->route('billing')->with('error', 'Payment verification failed. Please contact support.');
        }
    }

    /**
     * Handle webhook
     */
    public function webhook(Request $request)
    {
        $signature = $request->header('verif-hash');
        
        // Get secret hash from admin settings or config
        $paymentSettings = \App\Models\Setting::getByGroup('payment');
        
        // Handle if $paymentSettings is a Collection
        if ($paymentSettings instanceof \Illuminate\Support\Collection) {
            $paymentSettings = $paymentSettings->toArray();
        }
        
        $secretHash = $paymentSettings['flutterwave_encryption_key'] ?? config('services.flutterwave.secret_hash');
        
        \Log::info('Flutterwave webhook received', [
            'has_signature' => !empty($signature) ? 'Yes' : 'No',
            'has_secret_hash' => !empty($secretHash) ? 'Yes' : 'No',
            'payload' => $request->all()
        ]);

        if (!$signature || $signature !== $secretHash) {
            \Log::warning('Flutterwave webhook unauthorized', [
                'received_signature' => $signature,
                'expected_hash' => $secretHash ? 'Set (not shown for security)' : 'Not Set'
            ]);
            return response('Unauthorized', 401);
        }

        $payload = $request->all();

        if ($payload['event'] === 'charge.completed' && $payload['data']['status'] === 'successful') {
            $reference = $payload['data']['tx_ref'];
            $transactionId = $payload['data']['id'];
            
            \Log::info('Processing successful Flutterwave payment webhook', [
                'reference' => $reference,
                'transaction_id' => $transactionId
            ]);

            $subscription = Subscription::where('flutterwave_reference', $reference)->first();

            if ($subscription && $subscription->status === 'pending') {
                \Log::info('Updating subscription from webhook', [
                    'subscription_id' => $subscription->id,
                    'user_id' => $subscription->user_id
                ]);
                
                $subscription->update([
                    'status' => 'active',
                    'flutterwave_transaction_id' => $transactionId,
                ]);

                // Update user subscription status
                $user = $subscription->user;
                $user->update([
                    'is_subscribed' => true,
                    'subscription_ends_at' => $subscription->ends_at,
                ]);
                
                \Log::info('Subscription activated via webhook', [
                    'subscription_id' => $subscription->id,
                    'user_id' => $user->id,
                    'ends_at' => $subscription->ends_at
                ]);
            } else {
                \Log::warning('Subscription not found or not pending', [
                    'reference' => $reference,
                    'found' => $subscription ? 'Yes' : 'No',
                    'status' => $subscription ? $subscription->status : 'N/A'
                ]);
            }
        } else {
            \Log::info('Non-completed charge webhook event', [
                'event' => $payload['event'] ?? 'unknown',
                'status' => $payload['data']['status'] ?? 'unknown'
            ]);
        }

        return response('OK', 200);
    }
    
    /**
     * Test Flutterwave configuration
     */
    public function testFlutterwaveConfig()
    {
        $paymentSettings = \App\Models\Setting::getByGroup('payment');
        
        // Handle if $paymentSettings is a Collection
        if ($paymentSettings instanceof \Illuminate\Support\Collection) {
            $paymentSettings = $paymentSettings->toArray();
        }
        
        $isActive = isset($paymentSettings['flutterwave_active']) && $paymentSettings['flutterwave_active'];
        $secretKey = $paymentSettings['flutterwave_secret_key'] ?? config('services.flutterwave.secret_key');
        $publicKey = $paymentSettings['flutterwave_public_key'] ?? config('services.flutterwave.public_key');
        $encryptionKey = $paymentSettings['flutterwave_encryption_key'] ?? null;
        $environment = $paymentSettings['flutterwave_environment'] ?? config('services.flutterwave.environment', 'sandbox');
        $hasKeys = !empty($secretKey) && !empty($publicKey);
        
        // Test the API connection if keys are available
        $connectionTest = 'Not attempted';
        $apiStatus = 'Unknown';
        $sslVerification = app()->environment('local', 'development', 'testing') ? 'Disabled' : 'Enabled';
        
        if ($hasKeys) {
            try {
                // Make a simple API call to test the connection
                $response = $this->makeFlutterwaveRequest('/ping', [], 'GET');
                $connectionTest = 'Attempted';
                $apiStatus = isset($response['status']) && $response['status'] === 'success' ? 'Connected' : 'Failed';
            } catch (\Exception $e) {
                $connectionTest = 'Failed';
                $apiStatus = 'Error: ' . $e->getMessage();
            }
        }
        
        return response()->json([
            'message' => 'Flutterwave Configuration Status (Admin Settings)',
            'config' => [
                'active' => $isActive ? 'Yes' : 'No',
                'public_key' => !empty($publicKey) ? 'Set' : 'Not Set',
                'secret_key' => !empty($secretKey) ? 'Set' : 'Not Set',
                'encryption_key' => !empty($encryptionKey) ? 'Set' : 'Not Set',
                'environment' => $environment,
                'ssl_verification' => $sslVerification,
                'connection_test' => $connectionTest,
                'api_status' => $apiStatus
            ],
            'is_configured' => $isActive && $hasKeys,
            'all_settings' => $paymentSettings
        ]);
    }

    /**
     * Cancel subscription
     */
    public function cancelSubscription()
    {
        $user = auth()->user();
        $subscription = $user->activeSubscription;

        if ($subscription) {
            $subscription->cancel();
            
            return back()->with('success', 'Subscription cancelled successfully.');
        }

        return back()->with('error', 'No active subscription found.');
    }
}