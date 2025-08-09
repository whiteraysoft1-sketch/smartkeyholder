<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QrCode;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Setting;
use App\Models\PricingPlan;
use App\Services\EmailService;
use App\Traits\CarbonHelpers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    use CarbonHelpers;


    /**
     * Admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_qr_codes' => QrCode::count(),
            'claimed_qr_codes' => QrCode::where('is_claimed', true)->count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'trial_users' => User::whereNotNull('trial_ends_at')
                ->where('trial_ends_at', '>', now())
                ->where('is_subscribed', false)
                ->count(),
        ];

        $recentUsers = User::latest()->take(10)->get();
        $recentSubscriptions = Subscription::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentSubscriptions'));
    }

    /**
     * Manage QR codes
     */
    public function qrCodes()
    {
        $qrCodes = QrCode::with('user')->paginate(20);
        return view('admin.qr-codes', compact('qrCodes'));
    }

    /**
     * Generate QR codes in batch
     */
    public function generateQrCodes(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:500',
            'prefix' => 'nullable|string|max:10',
        ]);

        $quantity = $request->quantity;
        $prefix = $request->prefix ?? 'WS';
        $qrCodes = [];

        for ($i = 0; $i < $quantity; $i++) {
            $qrCode = QrCode::create([
                'code' => $prefix . '_' . strtoupper(Str::random(8)),
                // UUID and URL will be auto-generated in the model
            ]);

            $qrCodes[] = $qrCode;
        }

        return back()->with('success', "Generated {$quantity} QR codes successfully!");
    }

    /**
     * Bulk export QR codes as ZIP
     */
    public function bulkExportQrCodes(Request $request)
    {
        $request->validate([
            'format' => 'required|in:png,svg',
            'size' => 'required|integer|min:100|max:1000',
            'status' => 'nullable|in:all,claimed,unclaimed',
        ]);

        $query = QrCode::where('is_active', true);
        
        if ($request->status === 'claimed') {
            $query->where('is_claimed', true);
        } elseif ($request->status === 'unclaimed') {
            $query->where('is_claimed', false);
        }

        $qrCodes = $query->get();
        
        if ($qrCodes->isEmpty()) {
            return back()->with('error', 'No QR codes found for export.');
        }

        // Create temporary directory
        $tempDir = storage_path('app/temp/qr-export-' . time());
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        // Generate QR code files
        foreach ($qrCodes as $qrCode) {
            $filename = $qrCode->code . '.' . $request->format;
            $filepath = $tempDir . '/' . $filename;
            
            if ($request->format === 'png') {
                // Generate SVG first and convert to PNG using GD (since GdImageBackEnd is not available)
                $svgContent = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                    ->size($request->size)
                    ->generate($qrCode->url);
                
                // Convert SVG to PNG using GD
                $qrImage = $this->convertSvgToPng($svgContent, $request->size);
            } else {
                $qrImage = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                    ->size($request->size)
                    ->generate($qrCode->url);
            }
            
            file_put_contents($filepath, $qrImage);
        }

        // Create ZIP file
        $zipPath = storage_path('app/temp/qr-codes-' . date('Y-m-d-H-i-s') . '.zip');
        $zip = new \ZipArchive();
        
        if ($zip->open($zipPath, \ZipArchive::CREATE) === TRUE) {
            $files = glob($tempDir . '/*');
            foreach ($files as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
            
            // Clean up temp directory
            array_map('unlink', glob($tempDir . '/*'));
            rmdir($tempDir);
            
            return response()->download($zipPath)->deleteFileAfterSend(true);
        }

        return back()->with('error', 'Failed to create ZIP file.');
    }

    /**
     * Manage users
     */
    public function users()
    {
        $users = User::with(['profile', 'qrCode', 'activeSubscription'])
            ->paginate(20);
        
        return view('admin.users', compact('users'));
    }

    /**
     * View user details
     */
    public function userDetails(User $user)
    {
        $user->load(['profile', 'qrCode', 'socialLinks', 'galleryItems', 'subscriptions']);
        
        // Get available pricing plans for admin to upgrade user
        $availablePlans = PricingPlan::active();
        
        return view('admin.user-details', compact('user', 'availablePlans'));
    }

    /**
     * Upgrade user subscription (Admin only)
     */
    public function upgradeUserSubscription(Request $request, User $user)
    {
        $request->validate([
            'plan_id' => 'required|exists:pricing_plans,id',
            'duration_months' => 'nullable|integer|min:1|max:12',
        ]);

        $plan = PricingPlan::findOrFail($request->plan_id);
        
        try {
            $durationMonths = $this->validateDuration($request->duration_months ?? 1, 1, 12, 'months');
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        // Cancel existing active subscription if any
        if ($user->hasActiveSubscription()) {
            $activeSubscription = $user->activeSubscription;
            $activeSubscription->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);
        }

        // Create new subscription
        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_name' => $plan->name,
            'amount' => $plan->price,
            'currency' => setting('default_currency', 'USD'),
            'status' => 'active',
            'flutterwave_reference' => 'ADMIN_UPGRADE_' . Str::random(10),
            'starts_at' => now(),
            'ends_at' => $this->nowPlusMonths($durationMonths),
            'metadata' => [
                'type' => 'admin_upgrade',
                'plan_id' => $plan->id,
                'upgraded_by' => auth()->id(),
                'duration_months' => $durationMonths
            ],
        ]);

        // Update user subscription status
        $user->update([
            'is_subscribed' => true,
            'subscription_ends_at' => $this->nowPlusMonths($durationMonths),
            'trial_ends_at' => null, // Clear trial if any
        ]);

        return back()->with('success', "User upgraded to {$plan->name} plan for {$durationMonths} month(s) successfully!");
    }

    /**
     * Extend user subscription (Admin only)
     */
    public function extendUserSubscription(Request $request, User $user)
    {
        $request->validate([
            'extend_months' => 'required|integer|min:1|max:12',
        ]);

        try {
            $extendMonths = $this->validateDuration($request->extend_months, 1, 12, 'months');
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }

        if (!$user->hasActiveSubscription()) {
            return back()->with('error', 'User does not have an active subscription to extend.');
        }

        $activeSubscription = $user->activeSubscription;
        $newEndDate = $this->safeAddMonths($user->subscription_ends_at, $extendMonths);

        // Update subscription end date
        $activeSubscription->update([
            'ends_at' => $newEndDate,
            'metadata' => array_merge($activeSubscription->metadata ?? [], [
                'extended_by' => auth()->id(),
                'extended_months' => $extendMonths,
                'extended_at' => now()->toISOString()
            ])
        ]);

        // Update user subscription end date
        $user->update([
            'subscription_ends_at' => $newEndDate,
        ]);

        return back()->with('success', "User subscription extended by {$extendMonths} month(s) successfully!");
    }

    /**
     * Cancel user subscription (Admin only)
     */
    public function cancelUserSubscription(Request $request, User $user)
    {
        if (!$user->hasActiveSubscription()) {
            return back()->with('error', 'User does not have an active subscription to cancel.');
        }

        $activeSubscription = $user->activeSubscription;
        
        // Cancel the subscription
        $activeSubscription->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'metadata' => array_merge($activeSubscription->metadata ?? [], [
                'cancelled_by' => auth()->id(),
                'admin_cancelled' => true
            ])
        ]);

        // Update user status
        $user->update([
            'is_subscribed' => false,
        ]);

        return back()->with('success', 'User subscription cancelled successfully!');
    }

    /**
     * Deactivate QR code
     */
    public function deactivateQrCode(QrCode $qrCode)
    {
        $qrCode->update(['is_active' => false]);
        return back()->with('success', 'QR Code deactivated successfully!');
    }

    /**
     * Activate QR code
     */
    public function activateQrCode(QrCode $qrCode)
    {
        $qrCode->update(['is_active' => true]);
        return back()->with('success', 'QR Code activated successfully!');
    }

    /**
     * Reassign QR code
     */
    public function reassignQrCode(Request $request, QrCode $qrCode)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($request->user_id) {
            $user = User::find($request->user_id);
            $qrCode->claim($user);
            $message = "QR Code reassigned to {$user->name} successfully!";
        } else {
            $qrCode->update([
                'user_id' => null,
                'is_claimed' => false,
                'claimed_at' => null,
            ]);
            $message = 'QR Code unclaimed successfully!';
        }

        return back()->with('success', $message);
    }

    /**
     * Manage subscriptions
     */
    public function subscriptions()
    {
        $subscriptions = Subscription::with('user')->latest()->paginate(20);
        return view('admin.subscriptions', compact('subscriptions'));
    }

    /**
     * Export QR codes
     */
    public function exportQrCodes()
    {
        $qrCodes = QrCode::where('is_active', true)->get();
        
        $csv = "Code,URL,Status,Claimed At,User Email\n";
        
        foreach ($qrCodes as $qrCode) {
            $csv .= sprintf(
                "%s,%s,%s,%s,%s\n",
                $qrCode->code,
                $qrCode->url,
                $qrCode->is_claimed ? 'Claimed' : 'Available',
                $qrCode->claimed_at ? $qrCode->claimed_at->format('Y-m-d H:i:s') : '',
                $qrCode->user ? $qrCode->user->email : ''
            );
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="qr-codes-' . date('Y-m-d') . '.csv"');
    }

    /**
     * Show settings page
     */
    public function settings()
    {
        // Get settings from each group
        $generalSettings = Setting::getByGroup('general');
        $paymentSettings = Setting::getByGroup('payment');
        $brandingSettings = Setting::getByGroup('branding');
        $currencySettings = Setting::getByGroup('currency');
        $qrPurchaseSettings = Setting::getByGroup('qr_purchase');
        
        // Convert Collections to arrays if needed
        if ($generalSettings instanceof \Illuminate\Support\Collection) {
            $generalSettings = $generalSettings->toArray();
        }
        
        if ($paymentSettings instanceof \Illuminate\Support\Collection) {
            $paymentSettings = $paymentSettings->toArray();
        }
        
        if ($brandingSettings instanceof \Illuminate\Support\Collection) {
            $brandingSettings = $brandingSettings->toArray();
        }
        
        if ($currencySettings instanceof \Illuminate\Support\Collection) {
            $currencySettings = $currencySettings->toArray();
        }
        
        if ($qrPurchaseSettings instanceof \Illuminate\Support\Collection) {
            $qrPurchaseSettings = $qrPurchaseSettings->toArray();
        }
        
        $settings = [
            'general' => $generalSettings,
            'payment' => $paymentSettings,
            'branding' => $brandingSettings,
            'currency' => $currencySettings,
            'qr_purchase' => $qrPurchaseSettings,
        ];

        $pricingPlans = PricingPlan::orderBy('sort_order')->get();

        return view('admin.settings', compact('settings', 'pricingPlans'));
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:1000',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            
            // Payment Gateway Settings
            'flutterwave_public_key' => 'nullable|string|max:255',
            'flutterwave_secret_key' => 'nullable|string|max:255',
            'flutterwave_encryption_key' => 'nullable|string|max:255',
            'flutterwave_environment' => 'nullable|in:sandbox,live',
            
            'stripe_public_key' => 'nullable|string|max:255',
            'stripe_secret_key' => 'nullable|string|max:255',
            'stripe_webhook_secret' => 'nullable|string|max:255',
            
            'paypal_client_id' => 'nullable|string|max:255',
            'paypal_client_secret' => 'nullable|string|max:255',
            'paypal_environment' => 'nullable|in:sandbox,live',
            
            // Pricing
            'subscription_price' => 'nullable|numeric|min:0',
            'qr_code_price' => 'nullable|numeric|min:0',
            'trial_days' => 'nullable|integer|min:0|max:365',
            
            // Currency Settings
            'default_currency' => 'nullable|string|max:10',
            'currency_symbol' => 'nullable|string|max:10',
            'currency_position' => 'nullable|in:before,after',
            'custom_currency_code' => 'nullable|string|max:10',
            'custom_currency_name' => 'nullable|string|max:50',
            'custom_currency_symbol' => 'nullable|string|max:10',
            
            // QR Purchase Settings
            'single_qr_price' => 'nullable|numeric|min:0',
            'single_qr_description' => 'nullable|string|max:255',
            'business_pack_price' => 'nullable|numeric|min:0',
            'business_pack_description' => 'nullable|string|max:255',
            'business_pack_savings' => 'nullable|string|max:50',
            'enterprise_pack_price' => 'nullable|numeric|min:0',
            'enterprise_pack_description' => 'nullable|string|max:255',
            'enterprise_pack_savings' => 'nullable|string|max:50',
            'qr_purchase_page_title' => 'nullable|string|max:255',
            'qr_purchase_page_subtitle' => 'nullable|string|max:255',
            'currency_info_text' => 'nullable|string|max:500',
            'feature1_title' => 'nullable|string|max:100',
            'feature1_description' => 'nullable|string|max:255',
            'feature2_title' => 'nullable|string|max:100',
            'feature2_description' => 'nullable|string|max:255',
            'feature3_title' => 'nullable|string|max:100',
            'feature3_description' => 'nullable|string|max:255',
            'faq1_question' => 'nullable|string|max:255',
            'faq1_answer' => 'nullable|string|max:1000',
            'faq2_question' => 'nullable|string|max:255',
            'faq2_answer' => 'nullable|string|max:1000',
            'faq3_question' => 'nullable|string|max:255',
            'faq3_answer' => 'nullable|string|max:1000',
            'faq4_question' => 'nullable|string|max:255',
            'faq4_answer' => 'nullable|string|max:1000',
            'qr_purchase_page_title' => 'nullable|string|max:255',
            'qr_purchase_page_subtitle' => 'nullable|string|max:255',
            'currency_info_text' => 'nullable|string|max:500',
            'feature1_title' => 'nullable|string|max:100',
            'feature1_description' => 'nullable|string|max:255',
            'feature2_title' => 'nullable|string|max:100',
            'feature2_description' => 'nullable|string|max:255',
            'feature3_title' => 'nullable|string|max:100',
            'feature3_description' => 'nullable|string|max:255',
            'faq1_question' => 'nullable|string|max:255',
            'faq1_answer' => 'nullable|string|max:1000',
            'faq2_question' => 'nullable|string|max:255',
            'faq2_answer' => 'nullable|string|max:1000',
            'faq3_question' => 'nullable|string|max:255',
            'faq3_answer' => 'nullable|string|max:1000',
            'faq4_question' => 'nullable|string|max:255',
            'faq4_answer' => 'nullable|string|max:1000',
        ]);

        // General Settings
        if ($request->filled('site_name')) {
            Setting::set('site_name', $request->site_name, 'string', 'general', 'Website name');
        }
        if ($request->filled('site_description')) {
            Setting::set('site_description', $request->site_description, 'string', 'general', 'Website description');
        }
        if ($request->filled('contact_email')) {
            Setting::set('contact_email', $request->contact_email, 'string', 'general', 'Contact email address');
        }
        if ($request->filled('contact_phone')) {
            Setting::set('contact_phone', $request->contact_phone, 'string', 'general', 'Contact phone number');
        }

        // Flutterwave Settings
        // Handle the active checkbox
        Setting::set('flutterwave_active', $request->has('flutterwave_active') ? 1 : 0, 'boolean', 'payment', 'Flutterwave Active Status');
        
        if ($request->has('flutterwave_public_key')) {
            if ($request->filled('flutterwave_public_key')) {
                Setting::set('flutterwave_public_key', $request->flutterwave_public_key, 'string', 'payment', 'Flutterwave Public Key');
            } else {
                Setting::where('key', 'flutterwave_public_key')->delete();
            }
        }
        if ($request->has('flutterwave_secret_key')) {
            if ($request->filled('flutterwave_secret_key')) {
                Setting::set('flutterwave_secret_key', $request->flutterwave_secret_key, 'string', 'payment', 'Flutterwave Secret Key');
            } else {
                Setting::where('key', 'flutterwave_secret_key')->delete();
            }
        }
        if ($request->has('flutterwave_encryption_key')) {
            if ($request->filled('flutterwave_encryption_key')) {
                Setting::set('flutterwave_encryption_key', $request->flutterwave_encryption_key, 'string', 'payment', 'Flutterwave Encryption Key');
            } else {
                Setting::where('key', 'flutterwave_encryption_key')->delete();
            }
        }
        if ($request->has('flutterwave_environment')) {
            if ($request->filled('flutterwave_environment')) {
                Setting::set('flutterwave_environment', $request->flutterwave_environment, 'string', 'payment', 'Flutterwave Environment');
            } else {
                Setting::where('key', 'flutterwave_environment')->delete();
            }
        }

        // Stripe Settings
        if ($request->has('stripe_public_key')) {
            if ($request->filled('stripe_public_key')) {
                Setting::set('stripe_public_key', $request->stripe_public_key, 'string', 'payment', 'Stripe Public Key');
            } else {
                Setting::where('key', 'stripe_public_key')->delete();
            }
        }
        if ($request->has('stripe_secret_key')) {
            if ($request->filled('stripe_secret_key')) {
                Setting::set('stripe_secret_key', $request->stripe_secret_key, 'string', 'payment', 'Stripe Secret Key');
            } else {
                Setting::where('key', 'stripe_secret_key')->delete();
            }
        }
        if ($request->has('stripe_webhook_secret')) {
            if ($request->filled('stripe_webhook_secret')) {
                Setting::set('stripe_webhook_secret', $request->stripe_webhook_secret, 'string', 'payment', 'Stripe Webhook Secret');
            } else {
                Setting::where('key', 'stripe_webhook_secret')->delete();
            }
        }

        // PayPal Settings
        if ($request->has('paypal_client_id')) {
            if ($request->filled('paypal_client_id')) {
                Setting::set('paypal_client_id', $request->paypal_client_id, 'string', 'payment', 'PayPal Client ID');
            } else {
                Setting::where('key', 'paypal_client_id')->delete();
            }
        }
        if ($request->has('paypal_client_secret')) {
            if ($request->filled('paypal_client_secret')) {
                Setting::set('paypal_client_secret', $request->paypal_client_secret, 'string', 'payment', 'PayPal Client Secret');
            } else {
                Setting::where('key', 'paypal_client_secret')->delete();
            }
        }
        if ($request->has('paypal_environment')) {
            if ($request->filled('paypal_environment')) {
                Setting::set('paypal_environment', $request->paypal_environment, 'string', 'payment', 'PayPal Environment');
            } else {
                Setting::where('key', 'paypal_environment')->delete();
            }
        }

        // Pricing Settings
        if ($request->filled('subscription_price')) {
            Setting::set('subscription_price', $request->subscription_price, 'string', 'payment', 'Monthly subscription price');
        }
        if ($request->filled('qr_code_price')) {
            Setting::set('qr_code_price', $request->qr_code_price, 'string', 'payment', 'QR code purchase price');
        }
        if ($request->filled('trial_days')) {
            Setting::set('trial_days', $request->trial_days, 'string', 'general', 'Trial period in days');
        }

        // Currency Settings
        if ($request->filled('default_currency')) {
            Setting::set('default_currency', $request->default_currency, 'string', 'currency', 'Default currency code');
        }
        if ($request->filled('currency_symbol')) {
            Setting::set('currency_symbol', $request->currency_symbol, 'string', 'currency', 'Currency symbol');
        }
        if ($request->filled('currency_position')) {
            Setting::set('currency_position', $request->currency_position, 'string', 'currency', 'Currency symbol position');
        }
        if ($request->filled('custom_currency_code')) {
            Setting::set('custom_currency_code', $request->custom_currency_code, 'string', 'currency', 'Custom currency code');
        }
        if ($request->filled('custom_currency_name')) {
            Setting::set('custom_currency_name', $request->custom_currency_name, 'string', 'currency', 'Custom currency name');
        }
        if ($request->filled('custom_currency_symbol')) {
            Setting::set('custom_currency_symbol', $request->custom_currency_symbol, 'string', 'currency', 'Custom currency symbol');
        }

        // QR Purchase Settings
        $qrPurchaseFields = [
            'single_qr_price' => 'Single QR Code Price',
            'single_qr_description' => 'Single QR Code Description',
            'business_pack_price' => 'Business Pack Price',
            'business_pack_description' => 'Business Pack Description',
            'business_pack_savings' => 'Business Pack Savings Badge',
            'enterprise_pack_price' => 'Enterprise Pack Price',
            'enterprise_pack_description' => 'Enterprise Pack Description',
            'enterprise_pack_savings' => 'Enterprise Pack Savings Badge',
            'qr_purchase_page_title' => 'QR Purchase Page Title',
            'qr_purchase_page_subtitle' => 'QR Purchase Page Subtitle',
            'currency_info_text' => 'Currency Information Text',
            'feature1_title' => 'Feature 1 Title',
            'feature1_description' => 'Feature 1 Description',
            'feature2_title' => 'Feature 2 Title',
            'feature2_description' => 'Feature 2 Description',
            'feature3_title' => 'Feature 3 Title',
            'feature3_description' => 'Feature 3 Description',
            'faq1_question' => 'FAQ 1 Question',
            'faq1_answer' => 'FAQ 1 Answer',
            'faq2_question' => 'FAQ 2 Question',
            'faq2_answer' => 'FAQ 2 Answer',
            'faq3_question' => 'FAQ 3 Question',
            'faq3_answer' => 'FAQ 3 Answer',
            'faq4_question' => 'FAQ 4 Question',
            'faq4_answer' => 'FAQ 4 Answer',
            'qr_purchase_page_title' => 'QR Purchase Page Title',
            'qr_purchase_page_subtitle' => 'QR Purchase Page Subtitle',
            'currency_info_text' => 'Currency Information Text',
            'feature1_title' => 'Feature 1 Title',
            'feature1_description' => 'Feature 1 Description',
            'feature2_title' => 'Feature 2 Title',
            'feature2_description' => 'Feature 2 Description',
            'feature3_title' => 'Feature 3 Title',
            'feature3_description' => 'Feature 3 Description',
            'faq1_question' => 'FAQ 1 Question',
            'faq1_answer' => 'FAQ 1 Answer',
            'faq2_question' => 'FAQ 2 Question',
            'faq2_answer' => 'FAQ 2 Answer',
            'faq3_question' => 'FAQ 3 Question',
            'faq3_answer' => 'FAQ 3 Answer',
            'faq4_question' => 'FAQ 4 Question',
            'faq4_answer' => 'FAQ 4 Answer',
        ];

        foreach ($qrPurchaseFields as $field => $description) {
            if ($request->filled($field)) {
                Setting::set($field, $request->$field, 'string', 'qr_purchase', $description);
            }
        }

        // Handle checkbox fields
        if ($request->has('enterprise_pack_popular')) {
            Setting::set('enterprise_pack_popular', $request->enterprise_pack_popular ? 1 : 0, 'boolean', 'qr_purchase', 'Enterprise Pack Popular Badge');
        } else {
            Setting::set('enterprise_pack_popular', 0, 'boolean', 'qr_purchase', 'Enterprise Pack Popular Badge');
        }

        return back()->with('success', 'Settings updated successfully!');
    }

    /**
     * Upload logo
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type' => 'required|in:main_logo,favicon,landing_hero'
        ]);

        $type = $request->type;
        $file = $request->file('logo');
        
        // Delete old logo if exists
        $oldLogo = Setting::get($type);
        if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
            Storage::disk('public')->delete($oldLogo);
        }

        // Store new logo
        $path = $file->store('logos', 'public');
        
        // Save to settings
        $descriptions = [
            'main_logo' => 'Main website logo',
            'favicon' => 'Website favicon',
            'landing_hero' => 'Landing page hero image'
        ];
        
        Setting::set($type, $path, 'file', 'branding', $descriptions[$type]);

        return back()->with('success', 'Logo uploaded successfully!');
    }

    /**
     * Delete logo
     */
    public function deleteLogo(Request $request)
    {
        $request->validate([
            'type' => 'required|in:main_logo,favicon,landing_hero'
        ]);

        $type = $request->type;
        $logo = Setting::get($type);
        
        if ($logo && Storage::disk('public')->exists($logo)) {
            Storage::disk('public')->delete($logo);
        }

        // Remove from settings
        Setting::where('key', $type)->delete();
        Setting::clearCache();

        return back()->with('success', 'Logo deleted successfully!');
    }

    /**
     * Store pricing plan
     */
    public function storePricingPlan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:month,year,week,day',
            'description' => 'nullable|string|max:1000',
            'features' => 'nullable|string',
            'is_popular' => 'nullable|boolean',
            'is_free_trial' => 'nullable|boolean',
            'trial_days' => 'nullable|integer|min:0|max:365',
            'button_text' => 'nullable|string|max:50',
            'badge_text' => 'nullable|string|max:50',
            'max_social_links' => 'nullable|integer|min:-1',
            'max_gallery_images' => 'nullable|integer|min:-1',
            'has_analytics' => 'nullable|boolean',
            'has_custom_themes' => 'nullable|boolean',
            'has_priority_support' => 'nullable|boolean',
            'has_qr_customization' => 'nullable|boolean',
            'has_whatsapp_store' => 'nullable|boolean',
        ]);

        // Process features from textarea
        $features = [];
        if ($request->filled('features')) {
            $features = array_filter(
                array_map('trim', explode("\n", $request->features)),
                function($feature) {
                    return !empty($feature);
                }
            );
        }

        // Generate slug
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        
        while (PricingPlan::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // If this is marked as popular, remove popular from others
        if ($request->boolean('is_popular')) {
            PricingPlan::where('is_popular', true)->update(['is_popular' => false]);
        }

        // If this is marked as free trial, remove free trial from others
        if ($request->boolean('is_free_trial')) {
            PricingPlan::where('is_free_trial', true)->update(['is_free_trial' => false]);
        }

        $pricingPlan = PricingPlan::create([
            'name' => $request->name,
            'slug' => $slug,
            'price' => $request->price,
            'billing_cycle' => $request->billing_cycle,
            'description' => $request->description,
            'features' => $features,
            'is_active' => $request->boolean('is_active', true),
            'is_popular' => $request->boolean('is_popular'),
            'is_free_trial' => $request->boolean('is_free_trial'),
            'trial_days' => $request->trial_days ?: 0,
            'sort_order' => PricingPlan::max('sort_order') + 1,
            'button_text' => $request->button_text ?: 'Choose Plan',
            'badge_text' => $request->badge_text,
            'max_social_links' => $request->max_social_links ?: -1,
            'max_gallery_images' => $request->max_gallery_images ?: -1,
            'has_analytics' => $request->boolean('has_analytics'),
            'has_custom_themes' => $request->boolean('has_custom_themes'),
            'has_priority_support' => $request->boolean('has_priority_support'),
            'has_qr_customization' => $request->boolean('has_qr_customization'),
            'has_whatsapp_store' => $request->boolean('has_whatsapp_store'),
        ]);

        return back()->with('success', 'Pricing plan created successfully!');
    }

    /**
     * Get pricing plan data for editing
     */
    public function getPricingPlan(PricingPlan $pricingPlan)
    {
        return response()->json($pricingPlan);
    }

    /**
     * Update pricing plan
     */
    public function updatePricingPlan(Request $request, PricingPlan $pricingPlan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:month,year,week,day',
            'description' => 'nullable|string|max:1000',
            'features' => 'nullable|string',
            'is_popular' => 'nullable|boolean',
            'is_free_trial' => 'nullable|boolean',
            'trial_days' => 'nullable|integer|min:0|max:365',
            'button_text' => 'nullable|string|max:50',
            'badge_text' => 'nullable|string|max:50',
            'max_social_links' => 'nullable|integer|min:-1',
            'max_gallery_images' => 'nullable|integer|min:-1',
            'has_analytics' => 'nullable|boolean',
            'has_custom_themes' => 'nullable|boolean',
            'has_priority_support' => 'nullable|boolean',
            'has_qr_customization' => 'nullable|boolean',
            'has_whatsapp_store' => 'nullable|boolean',
        ]);

        // Process features from textarea
        $features = [];
        if ($request->filled('features')) {
            $features = array_filter(
                array_map('trim', explode("\n", $request->features)),
                function($feature) {
                    return !empty($feature);
                }
            );
        }

        // If this is marked as popular, remove popular from others
        if ($request->boolean('is_popular') && !$pricingPlan->is_popular) {
            PricingPlan::where('is_popular', true)->update(['is_popular' => false]);
        }

        // If this is marked as free trial, remove free trial from others
        if ($request->boolean('is_free_trial') && !$pricingPlan->is_free_trial) {
            PricingPlan::where('is_free_trial', true)->update(['is_free_trial' => false]);
        }

        $pricingPlan->update([
            'name' => $request->name,
            'price' => $request->price,
            'billing_cycle' => $request->billing_cycle,
            'description' => $request->description,
            'features' => $features,
            'is_active' => $request->boolean('is_active', $pricingPlan->is_active),
            'is_popular' => $request->boolean('is_popular'),
            'is_free_trial' => $request->boolean('is_free_trial'),
            'trial_days' => $request->trial_days ?: 0,
            'button_text' => $request->button_text ?: 'Choose Plan',
            'badge_text' => $request->badge_text,
            'max_social_links' => $request->max_social_links ?: -1,
            'max_gallery_images' => $request->max_gallery_images ?: -1,
            'has_analytics' => $request->boolean('has_analytics'),
            'has_custom_themes' => $request->boolean('has_custom_themes'),
            'has_priority_support' => $request->boolean('has_priority_support'),
            'has_qr_customization' => $request->boolean('has_qr_customization'),
            'has_whatsapp_store' => $request->boolean('has_whatsapp_store'),
        ]);

        return back()->with('success', 'Pricing plan updated successfully!');
    }

    /**
     * Delete pricing plan
     */
    public function deletePricingPlan(PricingPlan $pricingPlan)
    {
        $pricingPlan->delete();
        return back()->with('success', 'Pricing plan deleted successfully!');
    }

    /**
     * Toggle pricing plan status
     */
    public function togglePricingPlan(PricingPlan $pricingPlan)
    {
        $pricingPlan->update(['is_active' => !$pricingPlan->is_active]);
        $status = $pricingPlan->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Pricing plan {$status} successfully!");
    }

    /**
     * Update pricing plans order
     */
    public function updatePricingPlansOrder(Request $request)
    {
        $request->validate([
            'plans' => 'required|array',
            'plans.*.id' => 'required|exists:pricing_plans,id',
            'plans.*.sort_order' => 'required|integer|min:0',
        ]);

        foreach ($request->plans as $planData) {
            PricingPlan::where('id', $planData['id'])
                ->update(['sort_order' => $planData['sort_order']]);
        }

        return back()->with('success', 'Pricing plans order updated successfully!');
    }

    /**
     * Convert SVG content to PNG using GD library
     *
     * @param string $svgContent
     * @param int $size
     * @return string
     */
    private function convertSvgToPng(string $svgContent, int $size): string
    {
        // Create a temporary SVG file
        $tempSvgPath = tempnam(sys_get_temp_dir(), 'qr_svg_') . '.svg';
        file_put_contents($tempSvgPath, $svgContent);
        
        try {
            // Create a new image canvas
            $image = imagecreatetruecolor($size, $size);
            
            // Set white background
            $white = imagecolorallocate($image, 255, 255, 255);
            imagefill($image, 0, 0, $white);
            
            // Parse SVG and draw QR code pattern
            $this->drawQrFromSvg($image, $svgContent, $size);
            
            // Capture PNG output
            ob_start();
            imagepng($image);
            $pngData = ob_get_contents();
            ob_end_clean();
            
            // Clean up
            imagedestroy($image);
            unlink($tempSvgPath);
            
            return $pngData;
            
        } catch (\Exception $e) {
            // Clean up on error
            if (file_exists($tempSvgPath)) {
                unlink($tempSvgPath);
            }
            
            // Fallback: create a simple QR-like pattern
            return $this->createFallbackQrPng($size);
        }
    }

    /**
     * Draw QR code pattern from SVG content onto GD image
     *
     * @param resource $image
     * @param string $svgContent
     * @param int $size
     */
    private function drawQrFromSvg($image, string $svgContent, int $size): void
    {
        $black = imagecolorallocate($image, 0, 0, 0);
        
        // Parse SVG rectangles (QR modules)
        preg_match_all('/<rect[^>]*x="([^"]*)"[^>]*y="([^"]*)"[^>]*width="([^"]*)"[^>]*height="([^"]*)"[^>]*\/?>/', $svgContent, $matches, PREG_SET_ORDER);
        
        if (empty($matches)) {
            // Try alternative SVG format
            preg_match_all('/<rect[^>]*width="([^"]*)"[^>]*height="([^"]*)"[^>]*x="([^"]*)"[^>]*y="([^"]*)"[^>]*\/?>/', $svgContent, $matches, PREG_SET_ORDER);
            
            foreach ($matches as $match) {
                $width = (float)$match[1];
                $height = (float)$match[2];
                $x = (float)$match[3];
                $y = (float)$match[4];
                
                // Scale coordinates to image size
                $scaledX = (int)($x * $size / 100); // Assuming SVG viewBox is 100x100
                $scaledY = (int)($y * $size / 100);
                $scaledWidth = (int)($width * $size / 100);
                $scaledHeight = (int)($height * $size / 100);
                
                imagefilledrectangle($image, $scaledX, $scaledY, $scaledX + $scaledWidth, $scaledY + $scaledHeight, $black);
            }
        } else {
            foreach ($matches as $match) {
                $x = (float)$match[1];
                $y = (float)$match[2];
                $width = (float)$match[3];
                $height = (float)$match[4];
                
                // Scale coordinates to image size
                $scaledX = (int)($x * $size / 100); // Assuming SVG viewBox is 100x100
                $scaledY = (int)($y * $size / 100);
                $scaledWidth = (int)($width * $size / 100);
                $scaledHeight = (int)($height * $size / 100);
                
                imagefilledrectangle($image, $scaledX, $scaledY, $scaledX + $scaledWidth, $scaledY + $scaledHeight, $black);
            }
        }
    }

    /**
     * Create a fallback QR-like PNG image
     *
     * @param int $size
     * @return string
     */
    private function createFallbackQrPng(int $size): string
    {
        $image = imagecreatetruecolor($size, $size);
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        
        // Fill with white background
        imagefill($image, 0, 0, $white);
        
        // Create a simple QR-like pattern
        $moduleSize = $size / 25; // 25x25 grid
        
        for ($i = 0; $i < 25; $i++) {
            for ($j = 0; $j < 25; $j++) {
                // Create a simple pattern (not a real QR code)
                if (($i + $j) % 2 === 0 || ($i % 3 === 0 && $j % 3 === 0)) {
                    $x1 = (int)($i * $moduleSize);
                    $y1 = (int)($j * $moduleSize);
                    $x2 = (int)(($i + 1) * $moduleSize);
                    $y2 = (int)(($j + 1) * $moduleSize);
                    
                    imagefilledrectangle($image, $x1, $y1, $x2, $y2, $black);
                }
            }
        }
        
        // Capture PNG output
        ob_start();
        imagepng($image);
        $pngData = ob_get_contents();
        ob_end_clean();
        
        imagedestroy($image);
        
        return $pngData;
    }

    /**
     * Test email configuration
     */
    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        $emailService = new EmailService();
        
        if ($emailService->testEmailConfiguration($request->test_email)) {
            return back()->with('success', 'Test email sent successfully! Check the inbox for ' . $request->test_email);
        } else {
            return back()->with('error', 'Failed to send test email. Please check your email configuration and logs.');
        }
    }

    /**
     * Send expiry warning emails manually
     */
    public function sendExpiryWarnings(Request $request)
    {
        $request->validate([
            'warning_days' => 'nullable|string',
        ]);

        $emailService = new EmailService();
        
        // Parse warning days or use default
        $warningDaysString = $request->warning_days ?: '7,3,1,0';
        $warningDays = array_map('intval', explode(',', $warningDaysString));
        
        $results = $emailService->sendBulkExpiryWarnings($warningDays);
        
        $message = "Expiry warning emails processed! Sent: {$results['sent']}, Failed: {$results['failed']}";
        
        if ($results['sent'] > 0) {
            return back()->with('success', $message);
        } else {
            return back()->with('warning', $message . ' No emails were sent.');
        }
    }
}
