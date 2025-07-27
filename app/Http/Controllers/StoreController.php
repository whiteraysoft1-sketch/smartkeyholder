<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreCategory;
use App\Models\StoreProduct;
use App\Models\StoreOrder;
use App\Models\QrCode;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    /**
     * Display store for a QR code
     */
    public function show($uuid)
    {
        $qrCode = QrCode::where('uuid', $uuid)->first();
        
        if (!$qrCode || !$qrCode->user || !$qrCode->user->profile) {
            abort(404, 'Store not found');
        }

        $user = $qrCode->user;
        $profile = $user->profile;

        // Check if store is enabled
        if (!$profile->store_enabled) {
            abort(404, 'Store not available');
        }

        $products = $user->storeProducts()->available()->ordered()->get();
        $categories = $user->storeCategories()->active()->ordered()->get();
        return view('store.show', compact('profile', 'products', 'categories'));
    }

    /**
     * Place an order
     */
    public function placeOrder(Request $request, $uuid)
    {
        $qrCode = QrCode::where('uuid', $uuid)->first();
        
        if (!$qrCode || !$qrCode->user || !$qrCode->user->profile) {
            return response()->json(['error' => 'Store not found'], 404);
        }

        $user = $qrCode->user;
        $profile = $user->profile;

        if (!$profile->store_enabled) {
            return response()->json(['error' => 'Store not available'], 404);
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'customer_address' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:store_products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string|max:255',
            'delivery_type' => 'required|in:pickup,delivery',
            'notes' => 'nullable|string|max:500',
        ]);

        // Calculate order totals
        $items = [];
        $subtotal = 0;

        foreach ($request->items as $item) {
            $product = StoreProduct::where('id', $item['product_id'])
                ->where('user_id', $user->id)
                ->available()
                ->first();

            if (!$product) {
                return response()->json(['error' => 'Product not available'], 400);
            }

            // Check stock if tracking is enabled
            if ($product->track_stock && $product->stock_quantity < $item['quantity']) {
                return response()->json(['error' => "Insufficient stock for {$product->name}"], 400);
            }

            $itemTotal = $product->price * $item['quantity'];
            $subtotal += $itemTotal;

            $items[] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $item['quantity'],
                'total' => $itemTotal,
                'notes' => $item['notes'] ?? null,
            ];

            // Update stock if tracking is enabled
            if ($product->track_stock) {
                $product->decrement('stock_quantity', $item['quantity']);
            }
        }

        // Calculate delivery fee
        $deliveryFee = 0;
        if ($request->delivery_type === 'delivery' && $profile->delivery_available) {
            $deliveryFee = $profile->delivery_fee;
        }

        $totalAmount = $subtotal + $deliveryFee;

        // Check minimum order
        if ($profile->minimum_order > 0 && $subtotal < $profile->minimum_order) {
            return response()->json([
                'error' => "Minimum order amount is {$profile->currency_symbol}" . number_format($profile->minimum_order, 2)
            ], 400);
        }

        // Create order
        $order = StoreOrder::create([
            'user_id' => $user->id,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'customer_address' => $request->delivery_type === 'delivery' ? $request->customer_address : null,
            'items' => $items,
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'total_amount' => $totalAmount,
            'currency' => $profile->currency,
            'notes' => $request->notes,
        ]);

        // Generate WhatsApp message
        $whatsappMessage = $order->generateWhatsAppMessage();
        $whatsappNumber = $profile->store_whatsapp ?: $profile->phone;
        
        if ($whatsappNumber) {
            // Clean phone number (remove non-digits)
            $cleanNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);
            $whatsappUrl = "https://wa.me/{$cleanNumber}?text=" . urlencode($whatsappMessage);
            
            // Mark as sent
            $order->update(['whatsapp_sent_at' => now()]);
        } else {
            $whatsappUrl = null;
        }

        return response()->json([
            'success' => true,
            'order' => $order,
            'whatsapp_url' => $whatsappUrl,
            'message' => 'Order placed successfully!'
        ]);
    }

    /**
     * Get product details
     */
    public function getProduct($uuid, $productId)
    {
        $qrCode = QrCode::where('uuid', $uuid)->first();
        
        if (!$qrCode || !$qrCode->user) {
            return response()->json(['error' => 'Store not found'], 404);
        }

        $product = StoreProduct::where('id', $productId)
            ->where('user_id', $qrCode->user->id)
            ->available()
            ->with('category')
            ->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }
}