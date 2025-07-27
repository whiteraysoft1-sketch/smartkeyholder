@extends('layouts.app')
@section('title', $product->name . ' - ' . ($profile->store_name ?: $profile->display_name ?: $user->name))
@section('content')
<div class="bg-gray-50 min-h-screen py-6">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row gap-8">
            <!-- Image Gallery -->
            <div class="flex-1 flex flex-col items-center">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full max-w-xs h-80 object-cover rounded-xl mb-4 bg-white">
                @if($product->gallery && count($product->gallery) > 1)
                <div class="flex space-x-2 mt-2">
                    @foreach($product->gallery as $img)
                        <img src="{{ $img->full_image_url }}" alt="Gallery" class="w-16 h-16 object-cover rounded border hover:ring-2 hover:ring-orange-500 cursor-pointer" onclick="document.getElementById('mainProductImg').src='{{ $img->full_image_url }}'">
                    @endforeach
                </div>
                @endif
            </div>
            <!-- Product Info -->
            <div class="flex-1 flex flex-col">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                <div class="flex items-center mb-2">
                    <span class="text-2xl font-bold text-orange-600 mr-2">{{ $profile->currency_symbol ?? '$' }}{{ number_format($product->price, 2) }}</span>
                    @if($product->original_price && $product->original_price > $product->price)
                        <span class="text-lg text-gray-400 line-through mr-2">{{ $profile->currency_symbol ?? '$' }}{{ number_format($product->original_price, 2) }}</span>
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold">-{{ round(100 - ($product->price / $product->original_price * 100)) }}%</span>
                    @endif
                </div>
                @if($product->track_stock && $product->stock_quantity !== null)
                    <div class="mb-2">
                        <span class="text-sm {{ $product->stock_quantity > 0 ? 'text-green-600' : 'text-red-500' }} font-semibold">
                            {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>
                @endif
                <div class="flex items-center space-x-2 mb-4">
                    <button onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ $product->price }}', '{{ $product->full_image_url ?? asset('images/default-product.png') }}')" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded-xl shadow transition flex items-center">
                        <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                    </button>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->store_whatsapp ?: $profile->phone) }}?text={{ urlencode('I am interested in ' . $product->name . ' for ' . ($profile->currency_symbol ?? '$') . number_format($product->price, 2)) }}" target="_blank" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-xl shadow flex items-center">
                        <i class="fab fa-whatsapp mr-2"></i> Order via WhatsApp
                    </a>
                </div>
                @if($product->description)
                    <div class="mb-4">
                        <h2 class="text-lg font-semibold mb-1">Product Description</h2>
                        <p class="text-gray-700">{{ $product->description }}</p>
                    </div>
                @endif
                @if($product->features)
                    <div class="mb-4">
                        <h2 class="text-lg font-semibold mb-1">Key Features</h2>
                        <ul class="list-disc list-inside text-gray-700">
                            @foreach(explode("\n", $product->features) as $feature)
                                @if(trim($feature) !== '')
                                    <li>{{ $feature }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
