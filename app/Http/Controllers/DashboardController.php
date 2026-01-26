<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserProfile;
use App\Models\SocialLink;
use App\Models\GalleryItem;
use App\Models\StoreCategory;
use App\Models\StoreProduct;
use App\Models\StoreOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DashboardController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $user = Auth::user()->fresh(); // Get fresh user data
        
        // Ensure user has a profile - create one if it doesn't exist
        $profile = $user->profile;
        if (!$profile) {
            $profile = $user->profile()->create([
                'user_id' => $user->id,
                'is_public' => true,
                'store_enabled' => false,
                'currency' => 'USD',
            ]);
            $user->refresh(); // Refresh user to get the new profile relationship
        }
        
        $socialLinks = $user->socialLinks()->get();
        $galleryItems = $user->galleryItems()->orderBy('created_at', 'desc')->get();
        $subscription = $user->activeSubscription;
        $currencies = UserProfile::getCurrencyOptions();
        $qrCode = $user->qrCode;
        
        // Add cache-busting headers
        $response = response()->view('dashboard.index', compact('user', 'profile', 'socialLinks', 'galleryItems', 'subscription', 'currencies', 'qrCode'));
        $response->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', '0');
        
        return $response;
    }
    public function storeManagement()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $products = $user->storeProducts()->with('category')->ordered()->get();
        $categories = $user->storeCategories()->with('products')->ordered()->get();
        $orders = $user->storeOrders()->get();
        $recentOrders = $user->storeOrders()->latest()->take(5)->get();
        return view('dashboard.store', compact('user', 'profile', 'products', 'categories', 'orders', 'recentOrders'));
    }
    
    /**
     * Store Settings Page
     */
    public function storeSettings()
    {
        $user = Auth::user();
        $profile = $user->profile;
        return view('dashboard.store.settings', compact('user', 'profile'));
    }
    
    /**
     * Products Page
     */
    public function storeProducts()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $products = $user->storeProducts()->with('category')->ordered()->get();
        $categories = $user->storeCategories()->ordered()->get();
        $currencySymbol = $profile->currency_symbol ?? '$';
        return view('dashboard.store.products.index', compact('user', 'profile', 'products', 'categories', 'currencySymbol'));
    }
    
    /**
     * Categories Page
     */
    public function storeCategories()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $categories = $user->storeCategories()->withCount('products')->ordered()->get();
        return view('dashboard.store.categories.index', compact('user', 'profile', 'categories'));
    }
    
    /**
     * Orders Page
     */
    public function storeOrders()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $orders = $user->storeOrders()->with(['items.product'])->latest()->get();
        $currencySymbol = $profile->currency_symbol ?? '$';
        return view('dashboard.store.orders.index', compact('user', 'profile', 'orders', 'currencySymbol'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile ?? $user->profile()->create([]);
        
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $user->id,
            'display_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:32',
            'website' => 'nullable|url|max:255',
            'location' => 'nullable|string|max:255',
            'profession' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'contact' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:8',
            'business_name' => 'nullable|string|max:255',
            'business_phone' => 'nullable|string|max:32',
            'business_email' => 'nullable|email|max:255',
            'business_address' => 'nullable|string|max:500',
            'pwa_enabled' => 'nullable|boolean',
            'pwa_app_name' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1128000', // Allow up to 1128MB
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1128000', // Allow up to 1128MB
        ]);
        
        // Only update user fields if provided
        if ($request->filled('name')) {
            $user->name = $request->name;
        }
        if ($request->filled('email')) {
            $user->email = $request->email;
        }
        $user->save();
        
        // Update profile fields
        if ($request->filled('display_name')) $profile->display_name = $request->display_name;
        if ($request->filled('phone')) $profile->phone = $request->phone;
        if ($request->filled('website')) $profile->website = $request->website;
        if ($request->filled('location')) $profile->location = $request->location;
        if ($request->filled('profession')) $profile->profession = $request->profession;
        if ($request->filled('bio')) $profile->bio = $request->bio;
        if ($request->filled('contact')) $profile->contact = $request->contact;
        if ($request->filled('currency')) {
            $profile->currency = $request->currency;
        }
        
        // Update business information fields
        if ($request->filled('business_name')) $profile->business_name = $request->business_name;
        if ($request->filled('business_phone')) $profile->business_phone = $request->business_phone;
        if ($request->filled('business_email')) $profile->business_email = $request->business_email;
        if ($request->filled('business_address')) $profile->business_address = $request->business_address;
        
        // Handle PWA settings
        $profile->pwa_enabled = $request->boolean('pwa_enabled');
        if ($request->filled('pwa_app_name')) {
            $profile->pwa_app_name = $request->pwa_app_name;
        }
        
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($profile->profile_image) {
                $oldPath = $profile->profile_image;
                if (strpos($oldPath, 'profile_images/') === 0) {
                    \Storage::disk('public')->delete($oldPath);
                } else {
                    \Storage::disk('public')->delete('profile_images/' . ltrim($oldPath, '/'));
                }
            }
            
            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile_images', $filename, 'public');
            $profile->profile_image = $path;
        }

        if ($request->hasFile('background_image')) {
            // Delete old background image if exists
            if ($profile->background_image) {
                $oldPath = $profile->background_image;
                if (strpos($oldPath, 'background_images/') === 0) {
                    \Storage::disk('public')->delete($oldPath);
                } else {
                    \Storage::disk('public')->delete('background_images/' . ltrim($oldPath, '/'));
                }
            }
            
            $file = $request->file('background_image');
            $filename = time() . '_bg_' . $file->getClientOriginalName();
            $path = $file->storeAs('background_images', $filename, 'public');
            $profile->background_image = $path;
        }
        
        $profile->save();
        
        return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
    }



    // Social Links
    public function addSocialLink(Request $request)
    {
        $request->validate([
            'platform' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'display_name' => 'nullable|string|max:50',
        ]);
        
        // Clean and validate URL
        $url = $request->url;
        
        // If URL doesn't start with protocol, validate it as a basic URL format
        if (!preg_match('/^https?:\/\//', $url)) {
            // Validate that it looks like a valid URL without protocol
            if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9-_]*\.[a-zA-Z]{2,}/', $url)) {
                return redirect()->back()->withErrors(['url' => 'Please enter a valid URL or website address.']);
            }
        } else {
            // If it has protocol, validate as full URL
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                return redirect()->back()->withErrors(['url' => 'Please enter a valid URL.']);
            }
        }
        
        Auth::user()->socialLinks()->create($request->only(['platform', 'url', 'display_name']));
        return redirect()->back()->with('success', 'Social link added successfully!');
    }

    public function updateSocialLink(Request $request, SocialLink $socialLink)
    {
        // Check if user owns this social link
        if ($socialLink->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        $request->validate([
            'platform' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'display_name' => 'nullable|string|max:50',
        ]);
        $socialLink->update($request->only(['platform', 'url', 'display_name']));
        return redirect()->back()->with('success', 'Social link updated.');
    }

    public function deleteSocialLink(SocialLink $socialLink)
    {
        // Check if user owns this social link
        if ($socialLink->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        $socialLink->delete();
        return redirect()->back()->with('success', 'Social link deleted.');
    }

    // Gallery
    public function addGalleryItem(Request $request)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB limit per image
            'titles' => 'nullable|array',
            'titles.*' => 'nullable|string|max:255',
        ]);
        
        try {
            $images = $request->file('images');
            $titles = $request->input('titles', []);
            $uploadedCount = 0;
            
            foreach ($images as $index => $file) {
                $filename = time() . '_' . $index . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('gallery_images', $filename, 'public');
                
                $title = $titles[$index] ?? 'Gallery Image';
                
                Auth::user()->galleryItems()->create([
                    'title' => $title,
                    'image_path' => $path,
                ]);
                
                $uploadedCount++;
            }
            
            $message = $uploadedCount > 1 ? "{$uploadedCount} photos uploaded successfully!" : "Photo uploaded successfully!";
            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    public function updateGalleryItem(Request $request, GalleryItem $galleryItem)
    {
        // Check if user owns this gallery item
        if ($galleryItem->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);
        $data = ['title' => $request->title];
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('gallery', 'public');
            $data['image_path'] = $path;
        }
        $galleryItem->update($data);
        return redirect()->back()->with('success', 'Gallery item updated.');
    }

    public function deleteGalleryItem(GalleryItem $galleryItem)
    {
        // Check if user owns this gallery item
        if ($galleryItem->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        // Delete the image file from storage
        if ($galleryItem->image_path) {
            \Storage::disk('public')->delete($galleryItem->image_path);
        }
        
        $galleryItem->delete();
        return redirect()->back()->with('success', 'Gallery item deleted.');
    }



    // WhatsApp Store Settings
    public function updateStoreSettings(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile ?? $user->profile()->create([
            'user_id' => $user->id,
            'is_public' => true,
            'store_enabled' => false,
            'currency' => 'USD',
        ]);
        
        $request->validate([
            'store_enabled' => 'nullable|boolean',
            'store_name' => 'nullable|string|max:255',
            'store_description' => 'nullable|string|max:1000',
            'store_whatsapp' => 'nullable|string|max:32',
            'store_address' => 'nullable|string|max:255',
            'store_hours' => 'nullable|array',
            'delivery_fee' => 'nullable|numeric|min:0',
            'minimum_order' => 'nullable|numeric|min:0',
            'delivery_available' => 'nullable|boolean',
            'pickup_available' => 'nullable|boolean',
            'currency' => 'nullable|string|max:8',
            'store_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'store_theme' => 'nullable|string|in:default,modern,minimal,vibrant,dark',
            'store_primary_color' => 'nullable|string|max:7',
            'store_secondary_color' => 'nullable|string|max:7',
            'store_text_color' => 'nullable|string|max:7',
            'store_background_color' => 'nullable|string|max:7',
            'slider_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'slider_titles.*' => 'nullable|string|max:255',
            'slider_subtitles.*' => 'nullable|string|max:255',
            'delete_banners.*' => 'nullable|integer|exists:store_banners,id',
            'existing_banner_titles.*' => 'nullable|string|max:255',
        ]);
        $profile->store_enabled = $request->boolean('store_enabled');
        $profile->store_name = $request->store_name;
        $profile->store_description = $request->store_description;
        $profile->store_whatsapp = $request->store_whatsapp;
        $profile->store_address = $request->store_address;
        $profile->store_hours = $request->store_hours;
        $profile->delivery_fee = $request->delivery_fee ?? 0;
        $profile->minimum_order = $request->minimum_order ?? 0;
        $profile->delivery_available = $request->boolean('delivery_available');
        $profile->pickup_available = $request->boolean('pickup_available');
        
        // Handle store logo upload
        if ($request->hasFile('store_logo')) {
            // Delete old logo if exists
            if ($profile->store_logo) {
                \Storage::disk('public')->delete($profile->store_logo);
            }
            $file = $request->file('store_logo');
            $filename = time() . '_store_logo_' . $file->getClientOriginalName();
            $path = $file->storeAs('store_logos', $filename, 'public');
            $profile->store_logo = $path;
        }
        
        // Update theme and color settings
        if ($request->filled('store_theme')) {
            $profile->store_theme = $request->store_theme;
        }
        if ($request->filled('store_primary_color')) {
            $profile->store_primary_color = $request->store_primary_color;
        }
        if ($request->filled('store_secondary_color')) {
            $profile->store_secondary_color = $request->store_secondary_color;
        }
        if ($request->filled('store_text_color')) {
            $profile->store_text_color = $request->store_text_color;
        }
        if ($request->filled('store_background_color')) {
            $profile->store_background_color = $request->store_background_color;
        }
        
        // Update currency and automatically set currency symbol
        if ($request->filled('currency')) {
            $profile->currency = $request->currency;
        }
        $profile->save();

        // Handle Store Banner Sliders
        // Delete marked banners
        if ($request->has('delete_banners')) {
            foreach ($request->delete_banners as $bannerId) {
                $banner = \App\Models\StoreBanner::where('id', $bannerId)
                    ->where('user_id', $user->id)
                    ->first();
                if ($banner) {
                    // Delete image file
                    if ($banner->image) {
                        \Storage::disk('public')->delete($banner->image);
                    }
                    $banner->delete();
                }
            }
        }

        // Update existing banner titles
        if ($request->has('existing_banner_titles')) {
            foreach ($request->existing_banner_titles as $bannerId => $title) {
                $banner = \App\Models\StoreBanner::where('id', $bannerId)
                    ->where('user_id', $user->id)
                    ->first();
                if ($banner) {
                    $banner->title = $title;
                    $banner->save();
                }
            }
        }

        // Handle new slider images upload
        if ($request->hasFile('slider_images')) {
            $sliderImages = $request->file('slider_images');
            $sliderTitles = $request->slider_titles ?? [];
            $sliderSubtitles = $request->slider_subtitles ?? [];
            
            foreach ($sliderImages as $index => $image) {
                // Validate individual image
                if ($image->isValid() && in_array($image->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'])) {
                    // Store the image
                    $filename = time() . '_' . $index . '_' . $image->getClientOriginalName();
                    $path = $image->storeAs('store_banners', $filename, 'public');
                    
                    // Get the next sort order
                    $sortOrder = $user->storeBanners()->count();
                    
                    // Create banner record
                    \App\Models\StoreBanner::create([
                        'user_id' => $user->id,
                        'title' => $sliderTitles[$index] ?? '',
                        'subtitle' => $sliderSubtitles[$index] ?? '',
                        'image' => $path,
                        'sort_order' => $sortOrder,
                        'is_active' => true,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Store settings and sliders updated successfully.');
    }

    // Store Category Management
    public function addStoreCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon ?? 'folder',
            'color' => $request->color ?? '#6B7280',
            'is_active' => true,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_category_' . $file->getClientOriginalName();
            $path = $file->storeAs('store_categories', $filename, 'public');
            $data['image'] = $path;
        }

        Auth::user()->storeCategories()->create($data);

        return redirect()->back()->with('success', 'Category added successfully.');
    }

    public function editStoreCategory(StoreCategory $category)
    {
        // Check if user owns this category
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('dashboard.store.categories.edit', compact('category'));
    }

    public function updateStoreCategory(Request $request, StoreCategory $category)
    {
        // Check if user owns this category
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:10',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'delete_image' => 'nullable|boolean',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon ?? 'folder',
            'color' => $request->color ?? '#6B7280',
            'is_active' => $request->boolean('is_active'),
        ];

        // Handle image deletion
        if ($request->boolean('delete_image') && $category->image) {
            \Storage::disk('public')->delete($category->image);
            $data['image'] = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image) {
                \Storage::disk('public')->delete($category->image);
            }
            $file = $request->file('image');
            $filename = time() . '_category_' . $file->getClientOriginalName();
            $path = $file->storeAs('store_categories', $filename, 'public');
            $data['image'] = $path;
        }

        $category->update($data);

        return redirect()->route('dashboard.store.categories.index')->with('success', 'Category updated successfully.');
    }

    public function deleteStoreCategory(StoreCategory $category)
    {
        // Check if user owns this category
        if ($category->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category with products. Please move or delete products first.');
        }

        // Delete category image if exists
        if ($category->image) {
            \Storage::disk('public')->delete($category->image);
        }

        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }

    // Store Product Management
    public function addStoreProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:store_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'category_id' => $request->category_id,
            'is_available' => $request->boolean('is_available'),
            'is_featured' => $request->boolean('is_featured'),
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('store_products', $filename, 'public');
            $data['image'] = $path;
        }

        Auth::user()->storeProducts()->create($data);

        return redirect()->back()->with('success', 'Product added successfully.');
    }

    public function editStoreProduct(StoreProduct $product)
    {
        // Check if user owns this product
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $categories = Auth::user()->storeCategories()->get();
        return view('dashboard.store.products.edit', compact('product', 'categories'));
    }

    public function updateStoreProduct(Request $request, StoreProduct $product)
    {
        // Check if user owns this product
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:store_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'original_price' => $request->original_price,
            'category_id' => $request->category_id,
            'is_available' => $request->boolean('is_available'),
            'is_featured' => $request->boolean('is_featured'),
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists with path normalization
            if ($product->image) {
                $oldPath = $product->image;
                if (strpos($oldPath, 'store_products/') !== 0) {
                    $oldPath = 'store_products/' . ltrim($oldPath, '/');
                }
                \Storage::disk('public')->delete($oldPath);
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('store_products', $filename, 'public');
            $data['image'] = $path;
        }

        $product->update($data);

        return redirect()->route('dashboard.store')->with('success', 'Product updated successfully.');
    }

    public function deleteStoreProduct(StoreProduct $product)
    {
        // Check if user owns this product
        if ($product->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Delete the image file from storage with path normalization
        if ($product->image) {
            $path = $product->image;
            if (strpos($path, 'store_products/') !== 0) {
                $path = 'store_products/' . ltrim($path, '/');
            }
            \Storage::disk('public')->delete($path);
        }

        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    // Store Order Management
    public function updateOrderStatus(Request $request, StoreOrder $order)
    {
        // Check if user owns this order (through their store)
        if ($order->store_user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    // Profile Image Management
    public function removeProfileImage()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if ($profile && $profile->profile_image) {
            // Delete the image file from storage with path normalization
            $path = $profile->profile_image;
            if (strpos($path, 'profile_images/') !== 0) {
                $path = 'profile_images/' . ltrim($path, '/');
            }
            \Storage::disk('public')->delete($path);
            
            // Remove the image path from database
            $profile->profile_image = null;
            $profile->save();

            return redirect()->back()->with('success', 'Profile image removed successfully.');
        }

        return redirect()->back()->with('error', 'No profile image to remove.');
    }

    public function removeBackgroundImage()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if ($profile && $profile->background_image) {
            // Delete the image file from storage with path normalization
            $path = $profile->background_image;
            if (strpos($path, 'background_images/') !== 0) {
                $path = 'background_images/' . ltrim($path, '/');
            }
            \Storage::disk('public')->delete($path);
            
            // Remove the image path from database
            $profile->background_image = null;
            $profile->save();

            return redirect()->back()->with('success', 'Background image removed successfully.');
        }

        return redirect()->back()->with('error', 'No background image to remove.');
    }

    // vCard Template Methods
    public function vcardTemplates()
    {
        $user = Auth::user();
        $profile = $user->profile;
        
        // Available templates
        $templates = [
            ['file' => 'vcard_professional', 'name' => 'Professional Services'],
            ['file' => 'vcard_retail', 'name' => 'Retail & Wholesale'],
            ['file' => 'vcard_skilled_trades', 'name' => 'Skilled Trades & Services'],
            ['file' => 'vcard_health_wellness', 'name' => 'Health & Wellness'],
            ['file' => 'vcard_education_training', 'name' => 'Education & Training'],
            ['file' => 'vcard_transport_logistics', 'name' => 'Transport & Logistics'],
            ['file' => 'vcard_food_hospitality', 'name' => 'Food & Hospitality'],
            ['file' => 'vcard_corporate_industrial', 'name' => 'Corporate & Industrial'],
            ['file' => 'vcard_car_dealer', 'name' => 'Car Dealer & Vehicle Seller'],
            ['file' => 'vcard_agriculture', 'name' => 'Agriculture'],
            ['file' => 'vcard_media_entertainment', 'name' => 'Media & Entertainment'],
            ['file' => 'vcard_ngos_community', 'name' => 'NGOs & Community Groups'],
            ['file' => 'vcard_massage', 'name' => 'Massage & Therapy'],
            ['file' => 'vcard_spa', 'name' => 'Spa & Wellness'],
            ['file' => 'vcard_taxi_driver', 'name' => 'Taxi Driver'],
            ['file' => 'vcard_modern_business', 'name' => 'Modern Business'],
            ['file' => 'vcard_creative_portfolio', 'name' => 'Creative Portfolio'],
            ['file' => 'vcard_printing_design_branding', 'name' => 'Printing, Design & Branding'],
            ['file' => 'vcard_real_estate', 'name' => 'Real Estate & Property Management'],
            ['file' => 'vcard_phone_store', 'name' => 'Phone Store & Mobile Shop'],
            ['file' => 'vcard_church', 'name' => 'Church & Ministry'],
            ['file' => 'vcard_blood_donation', 'name' => 'Blood Donation Center'],
            ['file' => 'vcard_cloth_store', 'name' => 'Cloth & Fashion Store'],
            ['file' => 'vcard_tours_travel', 'name' => 'Tours & Travel'],
        ];
        return view('dashboard.vcard-templates', compact('user', 'profile', 'templates'));
    }

    public function previewVcardTemplate($template)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $socialLinks = $user->socialLinks()->where('is_active', true)->get();
        $galleryItems = $user->galleryItems()->where('is_active', true)->get();
        $storeProducts = $user->availableProducts()->take(6)->get();
        $qrCode = $user->qrCode;

        // Validate template exists
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
            'vcard_printing_design_branding',
            'vcard_real_estate',
            'vcard_phone_store',
            'vcard_universal_business',
            'vcard_church',
            'vcard_blood_donation',
            'vcard_cloth_store',
            'vcard_tours_travel',
        ];
        if (!in_array($template, $availableTemplates)) {
            abort(404, 'Template not found');
        }

        return view("vcardTemplates.{$template}", compact('user', 'profile', 'socialLinks', 'galleryItems', 'storeProducts', 'qrCode'));
    }

    public function selectVcardTemplate(Request $request)
    {
        $request->validate([
            'template' => 'required|string|in:vcard_professional,vcard_retail,vcard_skilled_trades,vcard_health_wellness,vcard_education_training,vcard_transport_logistics,vcard_food_hospitality,vcard_corporate_industrial,vcard_car_dealer,vcard_agriculture,vcard_media_entertainment,vcard_ngos_community,vcard_massage,vcard_spa,vcard_taxi_driver,vcard_modern_business,vcard_creative_portfolio,vcard_printing_design_branding,vcard_real_estate,vcard_phone_store,vcard_universal_business,vcard_church,vcard_blood_donation,vcard_cloth_store,vcard_tours_travel',
        ]);

        $user = Auth::user();
        $profile = $user->profile ?? $user->profile()->create([]);
        
        $profile->selected_template = $request->template;
        $profile->save();

        return redirect()->route('dashboard.vcard-templates')->with('success', 'Template selected successfully!');
    }

    public function templatePreview()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $qrCode = $user->qrCode;
        
        return view('dashboard.template-preview', compact('user', 'profile', 'qrCode'));
    }
}

    // PWA Settings Management