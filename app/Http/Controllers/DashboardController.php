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
        $profile = $user->profile; // This will get fresh profile data
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
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max for background
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
        if ($request->filled('currency')) $profile->currency = $request->currency;
        
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($profile->profile_image) {
                \Storage::disk('public')->delete($profile->profile_image);
            }
            
            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile_images', $filename, 'public');
            $profile->profile_image = $path;
        }

        if ($request->hasFile('background_image')) {
            // Delete old background image if exists
            if ($profile->background_image) {
                \Storage::disk('public')->delete($profile->background_image);
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
            'url' => 'required|url|max:255',
        ]);
        Auth::user()->socialLinks()->create($request->only(['platform', 'url']));
        return redirect()->back()->with('success', 'Social link added.');
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
        ]);
        $socialLink->update($request->only(['platform', 'url']));
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
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('gallery', $filename, 'public');
        
        Auth::user()->galleryItems()->create([
            'title' => $request->title ?: 'Gallery Image',
            'image_path' => $path,
        ]);
        return redirect()->back()->with('success', 'Gallery item added.');
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
        $profile = Auth::user()->profile;
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
        ]);
        $profile->store_enabled = $request->boolean('store_enabled');
        $profile->store_name = $request->store_name;
        $profile->store_description = $request->store_description;
        $profile->store_whatsapp = $request->store_whatsapp;
        $profile->store_address = $request->store_address;
        $profile->store_hours = $request->store_hours;
        $profile->delivery_fee = $request->delivery_fee;
        $profile->minimum_order = $request->minimum_order;
        $profile->delivery_available = $request->boolean('delivery_available');
        $profile->pickup_available = $request->boolean('pickup_available');
        $profile->currency = $request->currency;
        $profile->save();
        return redirect()->back()->with('success', 'Store settings updated.');
    }

    // Store Category Management
    public function addStoreCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
        ]);

        Auth::user()->storeCategories()->create([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'is_active' => true,
        ]);

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
            'is_active' => 'nullable|boolean',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'icon' => $request->icon,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('dashboard.store')->with('success', 'Category updated successfully.');
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
            // Delete old image if exists
            if ($product->image) {
                \Storage::disk('public')->delete($product->image);
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

        // Delete the image file from storage
        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
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
            // Delete the image file from storage
            \Storage::disk('public')->delete($profile->profile_image);
            
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
            // Delete the image file from storage
            \Storage::disk('public')->delete($profile->background_image);
            
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
        ];
        if (!in_array($template, $availableTemplates)) {
            abort(404, 'Template not found');
        }

        return view("vcardTemplates.{$template}", compact('user', 'profile', 'socialLinks', 'galleryItems', 'storeProducts', 'qrCode'));
    }

    public function selectVcardTemplate(Request $request)
    {
        $request->validate([
            'template' => 'required|string|in:vcard_professional,vcard_retail,vcard_skilled_trades,vcard_health_wellness,vcard_education_training,vcard_transport_logistics,vcard_food_hospitality,vcard_corporate_industrial,vcard_car_dealer,vcard_agriculture,vcard_media_entertainment,vcard_ngos_community,vcard_massage,vcard_spa,vcard_taxi_driver,vcard_modern_business,vcard_creative_portfolio',
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
