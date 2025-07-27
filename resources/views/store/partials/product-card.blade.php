<div class="relative bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col h-full group transition-transform duration-200 hover:scale-105 hover:shadow-2xl border border-gray-100">
    <!-- Favorite Icon -->
    <button class="absolute top-3 right-3 z-10 bg-white/80 rounded-full p-2 shadow hover:bg-orange-100 transition">
        <i class="fa fa-heart text-gray-400 group-hover:text-orange-500 transition"></i>
    </button>
    <!-- Product Image -->
    <div class="relative">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-t-2xl transition duration-200">
        @if($product->is_featured)
            <span class="absolute top-2 left-2 bg-yellow-400 text-xs font-bold px-3 py-1 rounded-full shadow">Featured</span>
        @endif
        @if($product->original_price && $product->original_price > $product->price)
            <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full font-bold">-{{ round(100 - ($product->price / $product->original_price * 100)) }}%</span>
        @endif
        <!-- View Details Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
            <span class="text-white text-sm font-semibold bg-black/60 px-4 py-2 rounded-full">View Details</span>
        </div>
    </div>
    <!-- Product Info -->
    <div class="flex-1 flex flex-col p-4">
        <h3 class="text-base font-semibold text-gray-900 mb-1 truncate">{{ $product->name }}</h3>
        <div class="flex items-center mb-2">
            <span class="text-lg font-bold text-orange-600 mr-2">{{ $profile->currency_symbol ?? '$' }}{{ number_format($product->price, 2) }}</span>
            @if($product->original_price && $product->original_price > $product->price)
                <span class="text-xs text-gray-400 line-through">{{ $profile->currency_symbol ?? '$' }}{{ number_format($product->original_price, 2) }}</span>
            @endif
        </div>
        @if($product->description)
            <p class="text-gray-600 text-xs mb-4 line-clamp-2">{{ Str::limit($product->description, 60) }}</p>
        @endif
        <button onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ $product->price }}', '{{ $product->full_image_url ?? asset('images/default-product.png') }}')" class="mt-auto w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-xl transition duration-200 flex items-center justify-center shadow-lg">
            <i class="fas fa-cart-plus mr-2"></i> Add to Cart
        </button>
    </div>
</div>
