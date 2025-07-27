<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrCode;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode as QrCodeGenerator;
use SimpleSoftwareIO\QrCode\Writer\Image\GdImageBackEnd;

class QrCodeController extends Controller
{
    /**
     * Display the QR code view page (public)
     */
    public function view($uuid)
    {
        $qrCode = QrCode::byUuid($uuid)->where('is_active', true)->first();

        if (!$qrCode) {
            abort(404, 'QR Code not found');
        }

        // Track scan
        $qrCode->incrementScanCount();

        // If QR code is not claimed, show claim page
        if (!$qrCode->is_claimed) {
            return view('qr.claim', compact('qrCode'));
        }

        // If claimed, show user profile
        $user = $qrCode->user;
        $profile = $user->profile;
        $socialLinks = $user->socialLinks()->where('is_active', true)->get();
        $galleryItems = $user->galleryItems()->where('is_active', true)->get();
        $storeProducts = $user->availableProducts()->take(6)->get();

        // Check if user has selected a specific template
        $selectedTemplate = $profile->selected_template ?? null;

        // Use different views based on selected template
        $availableTemplates = [
            'vcard_professional',
            'vcard_retail',
            'vcard_skilled_trades',
            'vcard_health_wellness',
            'vcard_education_training',
            'vcard_transport_logistics',
            'vcard_food_hospitality',
            'vcard_corporate_industrial',
            'vcard_car_dealer',
            'vcard_agriculture',
            'vcard_media_entertainment',
            'vcard_ngos_community',
            'vcard_massage',
            'vcard_spa',
            'vcard_taxi_driver',
            'vcard_modern_business',
            'vcard_creative_portfolio',
        ];

        if (in_array($selectedTemplate, $availableTemplates)) {
            return view("vcardTemplates.{$selectedTemplate}", compact('user', 'profile', 'socialLinks', 'galleryItems', 'storeProducts', 'qrCode'));
        } else {
            // Fallback to default profile view
            return view('qr.profile', compact('user', 'profile', 'socialLinks', 'galleryItems', 'storeProducts', 'qrCode'));
        }
    }

    /**
     * Show claim form
     */
    public function showClaim($uuid)
    {
        $qrCode = QrCode::byUuid($uuid)->where('is_active', true)->first();

        if (!$qrCode || !$qrCode->isAvailableForClaim()) {
            abort(404, 'QR Code not found or already claimed');
        }

        return view('qr.claim', compact('qrCode'));
    }

    /**
     * Process QR code claim
     */
    public function claim(Request $request, $uuid)
    {
        // Log the request data for debugging (excluding passwords)
        \Log::info('QR claim request received', [
            'uuid' => $uuid,
            'has_name' => !empty($request->name),
            'has_email' => !empty($request->email),
            'has_password' => !empty($request->password),
            'has_password_confirmation' => !empty($request->password_confirmation),
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'bio' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'location' => 'nullable|string|max:255',
            'profession' => 'nullable|string|max:255',
        ]);

        $qrCode = QrCode::byUuid($uuid)->where('is_active', true)->first();

        if (!$qrCode || !$qrCode->isAvailableForClaim()) {
            return back()->withErrors(['error' => 'QR Code not found or already claimed']);
        }

        // Check if password and confirmation match
        if ($request->password !== $request->password_confirmation) {
            \Log::warning('Password mismatch during QR claim', [
                'password_length' => strlen($request->password),
                'confirmation_length' => strlen($request->password_confirmation),
                'uuid' => $uuid
            ]);

            return back()->withErrors(['password' => 'The password confirmation does not match.'])
                         ->withInput($request->except(['password', 'password_confirmation']));
        }

        try {
            // Create user with 1-month trial
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'trial_ends_at' => now()->addMonth(),
            ]);

            // Create user profile with additional fields
            UserProfile::create([
                'user_id' => $user->id,
                'display_name' => $request->name,
                'bio' => $request->bio,
                'phone' => $request->phone,
                'website' => $request->website,
                'location' => $request->location,
                'profession' => $request->profession,
            ]);

            // Claim the QR code
            $qrCode->claim($user);

            // Login the user
            auth()->login($user);

            return redirect()->route('dashboard')->with('success', 'QR Code claimed successfully! You have a 1-month free trial.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while claiming the QR code: ' . $e->getMessage()])
                         ->withInput($request->except(['password', 'password_confirmation']));
        }
    }

    /**
     * Generate QR code image
     */
    public function generate($uuid)
    {
        $qrCode = QrCode::byUuid($uuid)->first();

        if (!$qrCode) {
            abort(404);
        }

        return response(QrCodeGenerator::size(200)->generate($qrCode->url))
            ->header('Content-Type', 'image/svg+xml');
    }

    /**
     * Download QR code as PNG
     */
    public function download($uuid)
    {
        $qrCode = QrCode::byUuid($uuid)->first();
        if (!$qrCode) {
            abort(404, 'QR Code not found');
        }
        if (!extension_loaded('gd')) {
            abort(500, 'GD extension is not enabled on the server. PNG generation requires GD.');
        }
        if (empty($qrCode->url) || !filter_var($qrCode->url, FILTER_VALIDATE_URL)) {
            abort(500, 'QR Code URL is invalid.');
        }
        try {
            $qrCodeImage = QrCodeGenerator::format('png')
                ->size(300)
                ->generate($qrCode->url);
        } catch (\Exception $e) {
            abort(500, 'Failed to generate QR code PNG: ' . $e->getMessage());
        }
        return response($qrCodeImage)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="qr-code-' . $qrCode->code . '.png"');
    }

    /**
     * Download QR code as SVG (print-ready)
     */
    public function downloadSvg($uuid)
    {
        $qrCode = QrCode::byUuid($uuid)->first();

        if (!$qrCode) {
            abort(404);
        }

        $qrCodeSvg = QrCodeGenerator::format('svg')->size(300)->generate($qrCode->url);

        return response($qrCodeSvg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="qr-code-' . $qrCode->code . '.svg"');
    }
}
