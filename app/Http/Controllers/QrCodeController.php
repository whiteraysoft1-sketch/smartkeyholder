<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrCode;
use App\Models\User;
use App\Models\UserProfile;
use App\Services\EmailService;
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
            'vcard_phone_store',
            'vcard_universal_business',
            'vcard_printing_design_branding',
            'vcard_real_estate',
            'vcard_church',
            'vcard_blood_donation',
            'vcard_cloth_store',
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

        return view('qr.claim_simple', compact('qrCode'));
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
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|string|min:8|same:password',
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

            // Send welcome email
            $emailService = new EmailService();
            $emailService->sendWelcomeEmail($user, $qrCode, $request->password);

            // Login the user
            auth()->login($user);

            return redirect()->route('dashboard')->with('success', 'QR Code claimed successfully! You have a 1-month free trial. Check your email for login details.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred while claiming the QR code: ' . $e->getMessage()])
                         ->withInput($request->except(['password', 'password_confirmation']));
        }
    }

    /**
     * Generate QR code image for display
     */
    public function generate($uuid)
    {
        $qrCode = QrCode::byUuid($uuid)->first();

        if (!$qrCode) {
            abort(404, 'QR Code not found');
        }
        
        if (empty($qrCode->url)) {
            abort(500, 'QR Code URL is not set.');
        }

        try {
            // Generate optimized SVG for web display
            $qrCodeSvg = QrCodeGenerator::format('svg')
                ->size(300)
                ->margin(1)
                ->errorCorrection('M')
                ->generate($qrCode->url);
                
            return response($qrCodeSvg)
                ->header('Content-Type', 'image/svg+xml')
                ->header('Cache-Control', 'public, max-age=86400')
                ->header('Expires', gmdate('D, d M Y H:i:s', time() + 86400) . ' GMT');
                
        } catch (\Exception $e) {
            \Log::error('QR Display Generation Error: ' . $e->getMessage(), [
                'qr_code_id' => $qrCode->id,
                'uuid' => $uuid,
                'url' => $qrCode->url
            ]);
            
            // Return a simple fallback SVG
            $fallbackSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="300" height="300" viewBox="0 0 300 300"><rect width="300" height="300" fill="#f3f4f6"/><text x="150" y="150" text-anchor="middle" font-family="Arial" font-size="16" fill="#6b7280">QR Code Error</text></svg>';
            
            return response($fallbackSvg)
                ->header('Content-Type', 'image/svg+xml');
        }
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
        
        // Validate QR code URL
        if (empty($qrCode->url)) {
            abort(500, 'QR Code URL is not set.');
        }
        
        try {
            // First check if Imagick is available for PNG generation
            if (extension_loaded('imagick') || class_exists('Imagick')) {
                try {
                    // Generate high-quality PNG QR code using Imagick
                    $qrCodeImage = QrCodeGenerator::format('png')
                        ->size(500)
                        ->margin(2)
                        ->errorCorrection('H')
                        ->generate($qrCode->url);
                        
                    $filename = 'qr-code-' . $qrCode->code . '.png';
                    
                    return response($qrCodeImage)
                        ->header('Content-Type', 'image/png')
                        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                        ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', '0');
                        
                } catch (\Exception $imagickError) {
                    \Log::warning('Imagick PNG generation failed, falling back to SVG->PNG conversion: ' . $imagickError->getMessage());
                    // Fall through to SVG conversion method
                }
            }
            
            // Fallback: Generate SVG and convert to PNG using GD
            if (extension_loaded('gd')) {
                $svgContent = QrCodeGenerator::format('svg')
                    ->size(500)
                    ->margin(2)
                    ->errorCorrection('H')
                    ->generate($qrCode->url);
                
                // Convert SVG to PNG using basic method
                $pngImage = $this->convertSvgToPng($svgContent, 500);
                
                if ($pngImage) {
                    $filename = 'qr-code-' . $qrCode->code . '.png';
                    
                    return response($pngImage)
                        ->header('Content-Type', 'image/png')
                        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                        ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', '0');
                }
            }
            
            // Last resort: Return SVG with PNG headers (browsers will handle it)
            $svgContent = QrCodeGenerator::format('svg')
                ->size(500)
                ->margin(2)
                ->errorCorrection('H')
                ->generate($qrCode->url);
                
            $filename = 'qr-code-' . $qrCode->code . '.svg';
            
            return response($svgContent)
                ->header('Content-Type', 'image/svg+xml')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
                
        } catch (\Exception $e) {
            \Log::error('QR PNG Generation Error: ' . $e->getMessage(), [
                'qr_code_id' => $qrCode->id,
                'uuid' => $uuid,
                'url' => $qrCode->url
            ]);
            
            abort(500, 'Failed to generate QR code. Please try again later.');
        }
    }
    
    /**
     * Convert SVG to PNG using GD library
     */
    private function convertSvgToPng($svgContent, $size)
    {
        try {
            // Create image canvas
            $image = imagecreatetruecolor($size, $size);
            
            // Set white background
            $white = imagecolorallocate($image, 255, 255, 255);
            $black = imagecolorallocate($image, 0, 0, 0);
            imagefill($image, 0, 0, $white);
            
            // Simple SVG parsing for QR rectangles
            if (preg_match_all('/<rect[^>]*x="([^"]*)"[^>]*y="([^"]*)"[^>]*width="([^"]*)"[^>]*height="([^"]*)"[^>]*\/?>/', $svgContent, $matches, PREG_SET_ORDER)) {
                
                // Parse viewBox for scaling
                $viewBoxScale = 1;
                if (preg_match('/viewBox="[^"]*\s+[^"]*\s+([^"]*)\s+([^"]*)"/', $svgContent, $viewBoxMatches)) {
                    $viewBoxWidth = floatval($viewBoxMatches[1]);
                    if ($viewBoxWidth > 0) {
                        $viewBoxScale = $size / $viewBoxWidth;
                    }
                }
                
                foreach ($matches as $match) {
                    $x = floatval($match[1]) * $viewBoxScale;
                    $y = floatval($match[2]) * $viewBoxScale;
                    $width = floatval($match[3]) * $viewBoxScale;
                    $height = floatval($match[4]) * $viewBoxScale;
                    
                    imagefilledrectangle($image, $x, $y, $x + $width, $y + $height, $black);
                }
            }
            
            // Capture PNG output
            ob_start();
            imagepng($image, null, 9); // Maximum compression
            $pngData = ob_get_contents();
            ob_end_clean();
            
            imagedestroy($image);
            
            return $pngData;
            
        } catch (\Exception $e) {
            \Log::error('SVG to PNG conversion failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Download QR code as SVG (print-ready)
     */
    public function downloadSvg($uuid)
    {
        $qrCode = QrCode::byUuid($uuid)->first();

        if (!$qrCode) {
            abort(404, 'QR Code not found');
        }
        
        // Validate QR code URL
        if (empty($qrCode->url)) {
            abort(500, 'QR Code URL is not set.');
        }

        try {
            // Generate high-quality SVG QR code (perfect for printing)
            $qrCodeSvg = QrCodeGenerator::format('svg')
                ->size(800)
                ->margin(2)
                ->errorCorrection('H')
                ->generate($qrCode->url);
                
            $filename = 'qr-code-' . $qrCode->code . '.svg';

            return response($qrCodeSvg)
                ->header('Content-Type', 'image/svg+xml')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
                
        } catch (\Exception $e) {
            \Log::error('QR SVG Generation Error: ' . $e->getMessage(), [
                'qr_code_id' => $qrCode->id,
                'uuid' => $uuid,
                'url' => $qrCode->url
            ]);
            
            abort(500, 'Failed to generate QR code SVG. Please try again later.');
        }
    }
}
