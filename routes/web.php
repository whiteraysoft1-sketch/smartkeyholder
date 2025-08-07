<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PwaController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

// Public routes - Root route with explicit methods
Route::match(['GET', 'HEAD'], '/', function () {
    return view('welcome');
})->name('home');

// Debug route to test routing
Route::get('/debug-route', function () {
    return response()->json([
        'message' => 'Routing is working!',
        'timestamp' => now(),
        'environment' => app()->environment(),
        'laravel_version' => app()->version(),
    ]);
})->name('debug.route');

// PWA routes (for dashboard and profiles)
Route::get('/pwa/manifest/{uuid?}', [PwaController::class, 'manifest'])->name('pwa.manifest');
Route::get('/pwa/sw/{uuid?}', [PwaController::class, 'serviceWorker'])->name('pwa.service-worker');
Route::get('/offline', function () {
    return view('pwa.offline');
})->name('pwa.offline');

Route::get('/dashboard-status', function () {
    return view('dashboard-status');
})->name('dashboard.status');

// QR Code public routes
Route::get('/qr/{uuid}', [QrCodeController::class, 'view'])->name('qr.view');
Route::get('/qr/{uuid}/claim', [QrCodeController::class, 'showClaim'])->name('qr.claim');
Route::post('/qr/{uuid}/claim', [QrCodeController::class, 'claim'])->name('qr.claim.process');
Route::get('/qr/{uuid}/generate', [QrCodeController::class, 'generate'])->name('qr.generate');
Route::get('/qr/{uuid}/download', [QrCodeController::class, 'download'])->name('qr.download');
Route::get('/qr/{uuid}/download-svg', [QrCodeController::class, 'downloadSvg'])->name('qr.download.svg');






// Payment webhook (public)
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');

// Test route for Flutterwave configuration
Route::get('/test-flutterwave', function () {
    $config = [
        'public_key' => config('services.flutterwave.public_key') ? 'Set' : 'Not Set',
        'secret_key' => config('services.flutterwave.secret_key') ? 'Set' : 'Not Set',
        'secret_hash' => config('services.flutterwave.secret_hash') ? 'Set' : 'Not Set',
        'environment' => config('services.flutterwave.environment', 'Not Set'),
    ];
    
    return response()->json([
        'message' => 'Flutterwave Configuration Status',
        'config' => $config,
        'ready' => $config['public_key'] === 'Set' && $config['secret_key'] === 'Set'
    ]);
})->name('test.flutterwave');

// Test route for Flutterwave configuration from admin settings
Route::get('/test-flutterwave-admin', [PaymentController::class, 'testFlutterwaveConfig'])->name('test.flutterwave.admin');

// Test page for Flutterwave payment flow
Route::get('/test-flutterwave-payment', function() {
    return view('payment.test-flutterwave');
})->name('test.flutterwave.payment')->middleware(['auth', 'admin']);

// Dashboard routes (protected by subscription middleware)
Route::middleware(['auth', 'subscribed'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // PWA Settings management
    Route::post('/dashboard/pwa-settings', [PwaController::class, 'updateDashboardSettings'])->name('dashboard.pwa-settings.update');
    
    // Profile management
    Route::post('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('dashboard.profile.update');
    Route::delete('/dashboard/profile/image', [DashboardController::class, 'removeProfileImage'])->name('dashboard.profile.remove-image');
    Route::delete('/dashboard/profile/background', [DashboardController::class, 'removeBackgroundImage'])->name('dashboard.profile.remove-background');
    

    
    // Social links management
    Route::post('/dashboard/social-links', [DashboardController::class, 'addSocialLink'])->name('dashboard.social-links.add');
    Route::put('/dashboard/social-links/{socialLink}', [DashboardController::class, 'updateSocialLink'])->name('dashboard.social-links.update');
    Route::delete('/dashboard/social-links/{socialLink}', [DashboardController::class, 'deleteSocialLink'])->name('dashboard.social-links.delete');
    
    // Gallery management
    Route::post('/dashboard/gallery', [DashboardController::class, 'addGalleryItem'])->name('dashboard.gallery.add');
    Route::put('/dashboard/gallery/{galleryItem}', [DashboardController::class, 'updateGalleryItem'])->name('dashboard.gallery.update');
    Route::delete('/dashboard/gallery/{galleryItem}', [DashboardController::class, 'deleteGalleryItem'])->name('dashboard.gallery.delete');
});

// Payment routes (authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/billing', [PaymentController::class, 'billing'])->name('billing');
    Route::get('/plans', [PaymentController::class, 'plans'])->name('plans');
    Route::get('/qr-purchase', [PaymentController::class, 'qrCodePurchase'])->name('qr-purchase');
    Route::post('/payment/initialize', [PaymentController::class, 'initializePayment'])->name('payment.initialize');
    Route::post('/payment/qr-initialize', [PaymentController::class, 'initializeQrCodePayment'])->name('payment.qr-initialize');
    Route::get('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');
    Route::get('/payment/qr-callback', [PaymentController::class, 'qrCodePaymentCallback'])->name('payment.qr-callback');
    Route::post('/subscription/cancel', [PaymentController::class, 'cancelSubscription'])->name('subscription.cancel');
    
    // Debug route
    Route::get('/dashboard-debug', function () {
        return view('dashboard-debug');
    })->name('dashboard.debug');
    
    // Simple dashboard route (for testing without Vite assets)
    Route::get('/dashboard-simple', function () {
        $user = auth()->user();
        
        // Ensure user has a profile
        if (!$user->profile) {
            $user->profile()->create([
                'user_id' => $user->id,
                'is_public' => true,
            ]);
            $user->refresh();
        }
        
        $profile = $user->profile;
        $qrCode = $user->qrCode;
        $socialLinks = $user->socialLinks()->get();
        $galleryItems = $user->galleryItems()->get();
        $subscription = $user->activeSubscription;

        return view('dashboard-simple', compact('user', 'profile', 'qrCode', 'socialLinks', 'galleryItems', 'subscription'));
    })->name('dashboard.simple');
    
    // Test dashboard without subscription middleware
    Route::get('/dashboard-test-access', [DashboardController::class, 'index'])->name('dashboard.test.access');
});

// Profile routes (Breeze default)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin authentication routes
Route::get('/admin/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [\App\Http\Controllers\Admin\AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [\App\Http\Controllers\Admin\AdminAuthController::class, 'logout'])->name('admin.logout');

// Install Wizard
Route::get('/install-wizard', [\App\Http\Controllers\InstallWizardController::class, 'showForm'])->name('install-wizard.form');
Route::post('/install-wizard/upload', [\App\Http\Controllers\InstallWizardController::class, 'upload'])->name('install-wizard.upload');
Route::get('/install-wizard/confirm/{zip}', [\App\Http\Controllers\InstallWizardController::class, 'confirm'])->name('install-wizard.confirm');
Route::post('/install-wizard/extract/{zip}', [\App\Http\Controllers\InstallWizardController::class, 'extract'])->name('install-wizard.extract');

// In-app PWA notification (in-app message)


// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // QR Code management
    Route::get('/qr-codes', [AdminController::class, 'qrCodes'])->name('qr-codes');
    Route::post('/qr-codes/generate', [AdminController::class, 'generateQrCodes'])->name('qr-codes.generate');
    Route::get('/qr-codes/export', [AdminController::class, 'exportQrCodes'])->name('qr-codes.export');
    Route::post('/qr-codes/bulk-export', [AdminController::class, 'bulkExportQrCodes'])->name('qr-codes.bulk-export');
    Route::post('/qr-codes/{qrCode}/deactivate', [AdminController::class, 'deactivateQrCode'])->name('qr-codes.deactivate');
    Route::post('/qr-codes/{qrCode}/activate', [AdminController::class, 'activateQrCode'])->name('qr-codes.activate');
    Route::post('/qr-codes/{qrCode}/reassign', [AdminController::class, 'reassignQrCode'])->name('qr-codes.reassign');
    
    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'userDetails'])->name('users.details');
    Route::post('/users/{user}/upgrade', [AdminController::class, 'upgradeUserSubscription'])->name('users.upgrade');
    Route::post('/users/{user}/extend', [AdminController::class, 'extendUserSubscription'])->name('users.extend');
    Route::post('/users/{user}/cancel-subscription', [AdminController::class, 'cancelUserSubscription'])->name('users.cancel-subscription');
    
    // Subscription management
    Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('subscriptions');
    
    // Settings management
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::post('/settings/logo', [AdminController::class, 'uploadLogo'])->name('settings.logo.upload');
    Route::delete('/settings/logo', [AdminController::class, 'deleteLogo'])->name('settings.logo.delete');
    
    // Pricing plans management
    Route::get('/pricing-plans/{pricingPlan}', [AdminController::class, 'getPricingPlan'])->name('pricing-plans.get');
    Route::post('/pricing-plans', [AdminController::class, 'storePricingPlan'])->name('pricing-plans.store');
    Route::put('/pricing-plans/{pricingPlan}', [AdminController::class, 'updatePricingPlan'])->name('pricing-plans.update');
    Route::delete('/pricing-plans/{pricingPlan}', [AdminController::class, 'deletePricingPlan'])->name('pricing-plans.delete');
    Route::patch('/pricing-plans/{pricingPlan}/toggle', [AdminController::class, 'togglePricingPlan'])->name('pricing-plans.toggle');
    Route::post('/pricing-plans/order', [AdminController::class, 'updatePricingPlansOrder'])->name('pricing-plans.order');
});

require __DIR__.'/auth.php';
// Store routes (public)
Route::get('/qr/{uuid}/store', [\App\Http\Controllers\StoreController::class, 'show'])->name('store.show');
Route::post('/qr/{uuid}/store/order', [\App\Http\Controllers\StoreController::class, 'placeOrder'])->name('store.order');
Route::get('/qr/{uuid}/store/product/{product}', [\App\Http\Controllers\StoreController::class, 'getProduct'])->name('store.product');

// Store management routes (authenticated)
Route::middleware(['auth', 'subscribed'])->group(function () {
    Route::post('/dashboard/store-settings', [DashboardController::class, 'updateStoreSettings'])->name('dashboard.store-settings.update');
    Route::get('/dashboard/store', [DashboardController::class, 'storeManagement'])->name('dashboard.store');
    Route::post('/dashboard/store/categories', [DashboardController::class, 'addStoreCategory'])->name('dashboard.store.categories.add');
    Route::get('/dashboard/store/categories/{category}/edit', [DashboardController::class, 'editStoreCategory'])->name('dashboard.store.categories.edit');
    Route::put('/dashboard/store/categories/{category}', [DashboardController::class, 'updateStoreCategory'])->name('dashboard.store.categories.update');
    Route::delete('/dashboard/store/categories/{category}', [DashboardController::class, 'deleteStoreCategory'])->name('dashboard.store.categories.delete');
    Route::post('/dashboard/store/products', [DashboardController::class, 'addStoreProduct'])->name('dashboard.store.products.add');
    Route::get('/dashboard/store/products/{product}/edit', [DashboardController::class, 'editStoreProduct'])->name('dashboard.store.products.edit');
    Route::put('/dashboard/store/products/{product}', [DashboardController::class, 'updateStoreProduct'])->name('dashboard.store.products.update');
    Route::delete('/dashboard/store/products/{product}', [DashboardController::class, 'deleteStoreProduct'])->name('dashboard.store.products.delete');
    Route::patch('/dashboard/store/orders/{order}/status', [DashboardController::class, 'updateOrderStatus'])->name('dashboard.store.orders.status');
});
Route::get('/dashboard/templates', [DashboardController::class, 'templatePreview'])->name('dashboard.templates')->middleware(['auth', 'subscribed']);
Route::get('/dashboard/vcard-templates', [DashboardController::class, 'vcardTemplates'])->name('dashboard.vcard-templates')->middleware(['auth', 'subscribed']);
Route::get('/dashboard/vcard-templates/preview/{template}', [DashboardController::class, 'previewVcardTemplate'])->name('dashboard.vcard-templates.preview')->middleware(['auth', 'subscribed']);
Route::post('/dashboard/vcard-templates/select', [DashboardController::class, 'selectVcardTemplate'])->name('dashboard.vcard-templates.select')->middleware(['auth', 'subscribed']);

// Test PWA Public Profile Route
Route::get('/test-pwa-public', function() {
    // Get the first QR code for testing
    $qrCode = \App\Models\QrCode::with('user.profile')->first();
    
    if (!$qrCode) {
        return response()->json(['error' => 'No QR codes found for testing']);
    }
    
    $user = $qrCode->user;
    $profile = $user->profile;
    
    return response()->json([
        'qr_code' => $qrCode->code,
        'user_name' => $user->name,
        'profile_exists' => $profile ? true : false,
        'pwa_enabled' => $profile ? $profile->pwa_enabled : false,
        'public_url' => route('qr.view', $qrCode->uuid),
        'manifest_url' => $profile && $profile->pwa_enabled ? route('pwa.manifest', $qrCode->uuid) : null,
        'pwa_settings' => $profile && $profile->pwa_enabled ? [
            'app_name' => $profile->pwa_app_name,
            'short_name' => $profile->pwa_short_name,
            'description' => $profile->pwa_description,
            'theme_color' => $profile->pwa_theme_color,
            'background_color' => $profile->pwa_background_color,
        ] : null,
    ]);
})->name('test.pwa.public');

// Debug PWA Settings Route
Route::get('/debug-pwa-settings', function() {
    $user = auth()->user();
    if (!$user) {
        return redirect()->route('login');
    }
    
    $profile = $user->profile;
    $qrCode = $user->qrCode;
    
    return response()->json([
        'user_id' => $user->id,
        'profile_exists' => $profile ? true : false,
        'pwa_enabled' => $profile ? $profile->pwa_enabled : false,
        'pwa_fields' => $profile ? [
            'pwa_app_name' => $profile->pwa_app_name,
            'pwa_short_name' => $profile->pwa_short_name,
            'pwa_description' => $profile->pwa_description,
            'pwa_theme_color' => $profile->pwa_theme_color,
            'pwa_background_color' => $profile->pwa_background_color,
            'pwa_icon' => $profile->pwa_icon,
        ] : null,
        'qr_code_exists' => $qrCode ? true : false,
        'dashboard_route' => route('dashboard'),
        'pwa_settings_route' => route('dashboard.pwa-settings.update'),
    ]);
})->name('debug.pwa.settings')->middleware('auth');

// General PWA Test Route
Route::get('/test-pwa', function() {
    return view('test-pwa');
})->name('test.pwa');