@extends('layouts.store')
@section('title', $profile->store_name ?? 'E-Commerce Store')
@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Mobile Header -->
    <header class="bg-white shadow-sm sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Mobile Layout -->
            <div class="flex items-center justify-between h-14 md:h-16">
                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="md:hidden p-2 rounded-lg hover:bg-gray-100 touch-target">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <!-- Store Name -->
                <div class="flex items-center space-x-2 md:space-x-4">
                    <h1 class="text-lg md:text-2xl font-bold text-gray-900 truncate">{{ $profile->store_name ?? 'Store' }}</h1>
                </div>
                
                <!-- Header Actions -->
                <div class="flex items-center space-x-2 md:space-x-4">
                    <!-- Search Button (Mobile) -->
                    <button onclick="toggleMobileSearch()" class="md:hidden p-2 rounded-lg hover:bg-gray-100 touch-target">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                    
                    <!-- Wishlist -->
                    <button onclick="toggleWishlist()" class="relative p-2 md:p-3 rounded-lg hover:bg-gray-100 touch-target transition">
                        <i class="fas fa-heart text-lg md:text-xl text-gray-600 hover:text-red-500"></i>
                        <span id="wishlist-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 md:h-6 md:w-6 flex items-center justify-center hidden">0</span>
                    </button>
                    
                    <!-- Cart -->
                    <button onclick="toggleCart()" class="relative p-2 md:p-3 rounded-lg hover:bg-gray-100 touch-target transition">
                        <i class="fas fa-shopping-cart text-lg md:text-xl text-gray-600 hover:text-blue-600"></i>
                        <span id="cart-count" class="absolute -top-1 -right-1 bg-blue-500 text-white text-xs font-bold rounded-full h-5 w-5 md:h-6 md:w-6 flex items-center justify-center hidden">0</span>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Search Bar (Hidden by default) -->
            <div id="mobile-search" class="hidden md:hidden pb-4">
                <div class="relative">
                    <input type="text" id="mobile-search-input" placeholder="Search products..." class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 text-base">
                    <button onclick="searchProducts()" class="absolute right-2 top-2 bg-blue-600 text-white p-2 rounded-lg hover:bg-blue-700 transition touch-target">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="toggleMobileMenu()">
        <div class="fixed left-0 top-0 h-full w-80 bg-white shadow-2xl transform -translate-x-full transition-transform duration-300" onclick="event.stopPropagation()">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold">Menu</h3>
                    <button onclick="toggleMobileMenu()" class="p-2 rounded-lg hover:bg-gray-100 touch-target">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <!-- Mobile Categories -->
                <div class="space-y-3">
                    <button onclick="filterByCategory('all'); toggleMobileMenu();" class="w-full text-left p-3 rounded-lg hover:bg-blue-50 touch-target">All Products</button>
                    @if(isset($categories) && $categories->count())
                        @foreach($categories as $category)
                            <button onclick="filterByCategory('{{ $category->id }}'); toggleMobileMenu();" class="w-full text-left p-3 rounded-lg hover:bg-blue-50 touch-target">{{ $category->name }}</button>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Banner -->
    <section class="bg-gradient-to-r from-blue-600 to-purple-700 text-white py-8 md:py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-2xl md:text-4xl lg:text-6xl font-bold mb-2 md:mb-4">Welcome to Our Store</h2>
            <p class="text-base md:text-xl mb-4 md:mb-8 opacity-90">Discover amazing products at unbeatable prices</p>
            <!-- Desktop Search -->
            <div class="hidden md:block max-w-2xl mx-auto">
                <div class="relative">
                    <input type="text" id="search-input" placeholder="Search for products..." class="w-full px-6 py-4 rounded-full text-gray-900 text-lg focus:outline-none focus:ring-4 focus:ring-white/30">
                    <button onclick="searchProducts()" class="absolute right-2 top-2 bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition touch-target">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters & Categories (Desktop) -->
    <section class="hidden md:block bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap gap-2">
                    <button onclick="filterByCategory('all')" class="category-filter active px-4 py-2 rounded-full bg-blue-100 text-blue-700 font-medium hover:bg-blue-200 transition touch-target">All Products</button>
                    @if(isset($categories) && $categories->count())
                        @foreach($categories as $category)
                            <button onclick="filterByCategory('{{ $category->id }}')" class="category-filter px-4 py-2 rounded-full bg-gray-100 text-gray-700 font-medium hover:bg-blue-200 transition touch-target">{{ $category->name }}</button>
                        @endforeach
                    @endif
                </div>
                <div class="flex items-center space-x-4">
                    <select id="sort-select" onchange="sortProducts()" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 touch-target">
                        <option value="name">Sort by Name</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="newest">Newest First</option>
                    </select>
                    <div class="flex border rounded-lg">
                        <button onclick="setViewMode('grid')" id="grid-view" class="p-3 bg-blue-100 text-blue-600 rounded-l-lg touch-target">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button onclick="setViewMode('list')" id="list-view" class="p-3 text-gray-600 hover:bg-gray-100 rounded-r-lg touch-target">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile Filters -->
    <section class="md:hidden bg-white border-b px-4 py-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <button onclick="toggleMobileFilters()" class="flex items-center space-x-2 px-4 py-2 bg-gray-100 rounded-lg touch-target">
                    <i class="fas fa-filter"></i>
                    <span class="text-sm font-medium">Filters</span>
                </button>
                <button onclick="toggleMobileSort()" class="flex items-center space-x-2 px-4 py-2 bg-gray-100 rounded-lg touch-target">
                    <i class="fas fa-sort"></i>
                    <span class="text-sm font-medium">Sort</span>
                </button>
            </div>
            <span id="mobile-product-count" class="text-sm text-gray-600">{{ $products->count() }} items</span>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-4 md:py-8">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Desktop Product Count -->
            <div class="hidden md:flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Products</h3>
                <span id="product-count" class="text-gray-600">{{ $products->count() }} products found</span>
            </div>
            
            <!-- Products Grid -->
            <div id="products-container" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-6">
                @foreach($products as $product)
                <div class="product-card bg-white rounded-xl md:rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group" data-category="{{ $product->category_id ?? 'all' }}" data-price="{{ $product->price }}" data-name="{{ $product->name }}">
                    <div class="relative">
                        <!-- Product Image -->
                        <div class="aspect-square bg-gray-100 overflow-hidden cursor-pointer touch-target" onclick='showProductModal(@json($product))'>
                            @if($product->image)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-2xl md:text-4xl"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Wishlist Button -->
                        <button onclick='toggleWishlistItem(@json($product))' class="absolute top-2 right-2 w-8 h-8 md:w-10 md:h-10 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-gray-600 hover:text-red-500 transition touch-target">
                            <i class="fas fa-heart text-sm md:text-base"></i>
                        </button>
                        
                        <!-- Stock Badge -->
                        @if($product->stock_quantity && $product->stock_quantity < 10)
                            <span class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">Low Stock</span>
                        @endif
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-3 md:p-4">
                        <h4 class="font-bold text-sm md:text-lg text-gray-900 mb-1 md:mb-2 line-clamp-2">{{ $product->name }}</h4>
                        <p class="text-gray-600 text-xs md:text-sm mb-2 md:mb-3 line-clamp-2 hidden md:block">{{ $product->description }}</p>
                        
                        <!-- Price and Rating -->
                        <div class="flex items-center justify-between mb-2 md:mb-3">
                            <span class="text-lg md:text-2xl font-bold text-blue-600">{{ $profile->currency_symbol ?? '$' }}{{ number_format($product->price, 2) }}</span>
                            <div class="hidden md:flex items-center text-yellow-400">
                                <i class="fas fa-star text-xs"></i>
                                <i class="fas fa-star text-xs"></i>
                                <i class="fas fa-star text-xs"></i>
                                <i class="fas fa-star text-xs"></i>
                                <i class="fas fa-star-half-alt text-xs"></i>
                                <span class="text-gray-600 text-xs ml-1">(4.5)</span>
                            </div>
                        </div>
                        
                        <!-- Add to Cart Button -->
                        <button onclick='addToCart(@json($product))' class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 md:py-3 rounded-lg md:rounded-xl transition-colors duration-200 flex items-center justify-center text-sm md:text-base touch-target">
                            <i class="fas fa-cart-plus mr-1 md:mr-2 text-sm"></i>
                            <span class="hidden md:inline">Add to Cart</span>
                            <span class="md:hidden">Add</span>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            @if($products->isEmpty())
                <div class="text-center py-12 md:py-16">
                    <i class="fas fa-box-open text-4xl md:text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg md:text-xl font-semibold text-gray-600 mb-2">No products found</h3>
                    <p class="text-gray-500">Try adjusting your search or filters</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Cart Sidebar -->
    <div id="cart-sidebar" class="fixed inset-y-0 right-0 w-full md:w-96 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50">
        <div class="flex flex-col h-full">
            <!-- Cart Header -->
            <div class="flex items-center justify-between p-4 md:p-6 border-b">
                <h3 class="text-lg md:text-xl font-bold text-gray-900">Shopping Cart</h3>
                <button onclick="toggleCart()" class="p-2 rounded-lg hover:bg-gray-100 touch-target">
                    <i class="fas fa-times text-lg md:text-xl text-gray-500"></i>
                </button>
            </div>
            
            <!-- Cart Items -->
            <div id="cart-items" class="flex-1 overflow-y-auto p-4 md:p-6 space-y-3 md:space-y-4">
                <!-- Cart items will be populated here -->
            </div>
            
            <!-- Cart Footer -->
            <div class="border-t p-4 md:p-6 bg-gray-50">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-lg font-semibold">Total:</span>
                    <span id="cart-total" class="text-xl md:text-2xl font-bold text-blue-600">$0.00</span>
                </div>
                <button onclick="checkout()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 md:py-4 rounded-xl transition-colors duration-200 flex items-center justify-center text-base md:text-lg touch-target">
                    <i class="fab fa-whatsapp mr-2 md:mr-3 text-lg md:text-xl"></i>
                    Checkout via WhatsApp
                </button>
            </div>
        </div>
    </div>

    <!-- Wishlist Sidebar -->
    <div id="wishlist-sidebar" class="fixed inset-y-0 right-0 w-full md:w-96 bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-50" style="display:none;">
        <div class="flex flex-col h-full">
            <!-- Wishlist Header -->
            <div class="flex items-center justify-between p-4 md:p-6 border-b">
                <h3 class="text-lg md:text-xl font-bold text-gray-900">Wishlist</h3>
                <button onclick="toggleWishlist()" class="p-2 rounded-lg hover:bg-gray-100 touch-target">
                    <i class="fas fa-times text-lg md:text-xl text-gray-500"></i>
                </button>
            </div>
            
            <!-- Wishlist Items -->
            <div id="wishlist-items" class="flex-1 overflow-y-auto p-4 md:p-6 space-y-3 md:space-y-4">
                <!-- Wishlist items will be populated here -->
            </div>
        </div>
    </div>

    <!-- Product Modal -->
    <div id="product-modal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl md:rounded-3xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <div class="grid md:grid-cols-2 gap-4 md:gap-8 p-4 md:p-8">
                <!-- Product Image -->
                <div>
                    <div id="modal-image" class="aspect-square bg-gray-100 rounded-xl md:rounded-2xl overflow-hidden mb-4">
                        <!-- Product image -->
                    </div>
                </div>
                
                <!-- Product Details -->
                <div>
                    <button onclick="closeProductModal()" class="float-right p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-gray-700 mb-4 touch-target">
                        <i class="fas fa-times text-lg md:text-2xl"></i>
                    </button>
                    
                    <h2 id="modal-title" class="text-xl md:text-3xl font-bold text-gray-900 mb-3 md:mb-4"></h2>
                    
                    <!-- Rating (Desktop only) -->
                    <div class="hidden md:flex items-center mb-4">
                        <div class="flex text-yellow-400 mr-2">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="text-gray-600">(4.5) • 127 reviews</span>
                    </div>
                    
                    <p id="modal-price" class="text-2xl md:text-3xl font-bold text-blue-600 mb-4 md:mb-6"></p>
                    <p id="modal-description" class="text-gray-700 mb-4 md:mb-6 leading-relaxed text-sm md:text-base"></p>
                    
                    <!-- Quantity Selector -->
                    <div class="flex items-center space-x-4 mb-4 md:mb-6">
                        <span class="font-semibold">Quantity:</span>
                        <div class="flex items-center border rounded-lg">
                            <button onclick="decreaseModalQuantity()" class="p-2 md:px-3 md:py-2 hover:bg-gray-100 touch-target">
                                <i class="fas fa-minus text-sm"></i>
                            </button>
                            <input id="modal-quantity" type="number" value="1" min="1" class="w-12 md:w-16 text-center border-0 focus:ring-0 text-sm md:text-base">
                            <button onclick="increaseModalQuantity()" class="p-2 md:px-3 md:py-2 hover:bg-gray-100 touch-target">
                                <i class="fas fa-plus text-sm"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4">
                        <button id="modal-add-to-cart" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 md:py-4 rounded-xl transition touch-target">
                            <i class="fas fa-cart-plus mr-2"></i>
                            Add to Cart
                        </button>
                        <button onclick="toggleModalWishlist()" class="md:px-6 py-3 md:py-4 border-2 border-gray-300 rounded-xl hover:border-red-500 hover:text-red-500 transition touch-target">
                            <i class="fas fa-heart"></i>
                            <span class="md:hidden ml-2">Add to Wishlist</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black/50 z-40 hidden" onclick="closeAllModals()"></div>

    <!-- Mobile Bottom Navigation (Optional) -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-4 py-2 z-30">
        <div class="flex justify-around">
            <button onclick="scrollToTop()" class="flex flex-col items-center py-2 touch-target">
                <i class="fas fa-home text-lg text-gray-600"></i>
                <span class="text-xs text-gray-600 mt-1">Home</span>
            </button>
            <button onclick="toggleMobileSearch()" class="flex flex-col items-center py-2 touch-target">
                <i class="fas fa-search text-lg text-gray-600"></i>
                <span class="text-xs text-gray-600 mt-1">Search</span>
            </button>
            <button onclick="toggleWishlist()" class="flex flex-col items-center py-2 touch-target relative">
                <i class="fas fa-heart text-lg text-gray-600"></i>
                <span class="text-xs text-gray-600 mt-1">Wishlist</span>
                <span id="mobile-wishlist-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center hidden">0</span>
            </button>
            <button onclick="toggleCart()" class="flex flex-col items-center py-2 touch-target relative">
                <i class="fas fa-shopping-cart text-lg text-gray-600"></i>
                <span class="text-xs text-gray-600 mt-1">Cart</span>
                <span id="mobile-cart-count" class="absolute -top-1 -right-1 bg-blue-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center hidden">0</span>
            </button>
        </div>
    </div>
</div>

<script>
// Global variables
let cart = JSON.parse(localStorage.getItem('ecommerce_cart')) || [];
let wishlist = JSON.parse(localStorage.getItem('ecommerce_wishlist')) || [];
let currentProduct = null;
let viewMode = 'grid';
const currencySymbol = "{{ $profile->currency_symbol ?? '$' }}";
const whatsappNumber = "{{ preg_replace('/[^0-9]/', '', $profile->store_whatsapp ?? $profile->phone) }}";

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Always hide wishlist sidebar and overlay on page load
    document.getElementById('wishlist-sidebar').classList.add('translate-x-full');
    document.getElementById('wishlist-sidebar').style.display = 'none';
    document.getElementById('overlay').classList.add('hidden');
    updateCartUI();
    updateWishlistUI();
    setupMobileSearch();
});

// Mobile Navigation Functions
function toggleMobileMenu() {
    const menu = document.getElementById('mobile-menu');
    const menuPanel = menu.querySelector('div');
    
    if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        setTimeout(() => menuPanel.classList.remove('-translate-x-full'), 10);
    } else {
        menuPanel.classList.add('-translate-x-full');
        setTimeout(() => menu.classList.add('hidden'), 300);
    }
}

function toggleMobileSearch() {
    const searchBar = document.getElementById('mobile-search');
    searchBar.classList.toggle('hidden');
    if (!searchBar.classList.contains('hidden')) {
        document.getElementById('mobile-search-input').focus();
    }
}

function setupMobileSearch() {
    // Sync mobile and desktop search
    const mobileInput = document.getElementById('mobile-search-input');
    const desktopInput = document.getElementById('search-input');
    
    if (mobileInput && desktopInput) {
        mobileInput.addEventListener('input', () => {
            desktopInput.value = mobileInput.value;
        });
        desktopInput.addEventListener('input', () => {
            mobileInput.value = desktopInput.value;
        });
    }
}

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Cart functions
function addToCart(product, quantity = 1) {
    const existingItem = cart.find(item => item.id === product.id);
    if (existingItem) {
        existingItem.quantity += quantity;
    } else {
        cart.push({...product, quantity});
    }
    saveCart();
    updateCartUI();
    showNotification('Product added to cart!', 'success');
}

function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    saveCart();
    updateCartUI();
}

function updateCartQuantity(productId, quantity) {
    const item = cart.find(item => item.id === productId);
    if (item) {
        item.quantity = Math.max(1, quantity);
        saveCart();
        updateCartUI();
    }
}

function saveCart() {
    localStorage.setItem('ecommerce_cart', JSON.stringify(cart));
}

function updateCartUI() {
    const cartCount = document.getElementById('cart-count');
    const mobileCartCount = document.getElementById('mobile-cart-count');
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    const totalPrice = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    
    // Update counts
    [cartCount, mobileCartCount].forEach(element => {
        if (element) {
            element.textContent = totalItems;
            element.classList.toggle('hidden', totalItems === 0);
        }
    });
    
    cartTotal.textContent = `${currencySymbol}${totalPrice.toFixed(2)}`;
    
    if (cart.length === 0) {
        cartItems.innerHTML = '<p class="text-gray-500 text-center py-8">Your cart is empty</p>';
    } else {
        cartItems.innerHTML = cart.map(item => `
            <div class="flex items-center space-x-3 p-3 border rounded-lg">
                <img src="/storage/${item.image || 'default.jpg'}" alt="${item.name}" class="w-12 h-12 md:w-16 md:h-16 object-cover rounded-lg">
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-sm truncate">${item.name}</h4>
                    <p class="text-blue-600 font-bold text-sm">${currencySymbol}${parseFloat(item.price).toFixed(2)}</p>
                    <div class="flex items-center space-x-2 mt-1">
                        <button onclick="updateCartQuantity(${item.id}, ${item.quantity - 1})" class="w-6 h-6 bg-gray-200 rounded-full text-sm touch-target">-</button>
                        <span class="text-sm px-2">${item.quantity}</span>
                        <button onclick="updateCartQuantity(${item.id}, ${item.quantity + 1})" class="w-6 h-6 bg-gray-200 rounded-full text-sm touch-target">+</button>
                    </div>
                </div>
                <button onclick="removeFromCart(${item.id})" class="p-2 text-red-500 hover:text-red-700 touch-target">
                    <i class="fas fa-trash text-sm"></i>
                </button>
            </div>
        `).join('');
    }
}

function toggleCart() {
    const sidebar = document.getElementById('cart-sidebar');
    const overlay = document.getElementById('overlay');
    const isOpen = !sidebar.classList.contains('translate-x-full');
    
    if (isOpen) {
        sidebar.classList.add('translate-x-full');
        overlay.classList.add('hidden');
    } else {
        closeAllModals();
        sidebar.classList.remove('translate-x-full');
        overlay.classList.remove('hidden');
    }
}

// Wishlist functions
function toggleWishlistItem(product) {
    const existingIndex = wishlist.findIndex(item => item.id === product.id);
    if (existingIndex > -1) {
        wishlist.splice(existingIndex, 1);
        showNotification('Removed from wishlist', 'info');
    } else {
        wishlist.push(product);
        showNotification('Added to wishlist!', 'success');
    }
    saveWishlist();
    updateWishlistUI();
}

function saveWishlist() {
    localStorage.setItem('ecommerce_wishlist', JSON.stringify(wishlist));
}

function updateWishlistUI() {
    const wishlistCount = document.getElementById('wishlist-count');
    const mobileWishlistCount = document.getElementById('mobile-wishlist-count');
    const wishlistItems = document.getElementById('wishlist-items');
    
    // Update counts
    [wishlistCount, mobileWishlistCount].forEach(element => {
        if (element) {
            element.textContent = wishlist.length;
            element.classList.toggle('hidden', wishlist.length === 0);
        }
    });
    
    if (wishlist.length === 0) {
        wishlistItems.innerHTML = '<p class="text-gray-500 text-center py-8">Your wishlist is empty</p>';
    } else {
        wishlistItems.innerHTML = wishlist.map(item => `
            <div class="flex items-center space-x-3 p-3 border rounded-lg">
                <img src="/storage/${item.image || 'default.jpg'}" alt="${item.name}" class="w-12 h-12 md:w-16 md:h-16 object-cover rounded-lg">
                <div class="flex-1 min-w-0">
                    <h4 class="font-semibold text-sm truncate">${item.name}</h4>
                    <p class="text-blue-600 font-bold text-sm">${currencySymbol}${parseFloat(item.price).toFixed(2)}</p>
                </div>
                <div class="flex flex-col space-y-1">
                    <button onclick="addToCart(${JSON.stringify(item).replace(/"/g, '&quot;')})" class="p-2 text-blue-600 hover:text-blue-800 touch-target">
                        <i class="fas fa-cart-plus text-sm"></i>
                    </button>
                    <button onclick="toggleWishlistItem(${JSON.stringify(item).replace(/"/g, '&quot;')})" class="p-2 text-red-500 hover:text-red-700 touch-target">
                        <i class="fas fa-trash text-sm"></i>
                    </button>
                </div>
            </div>
        `).join('');
    }
}

function toggleWishlist() {
    const sidebar = document.getElementById('wishlist-sidebar');
    const overlay = document.getElementById('overlay');
    const isOpen = !sidebar.classList.contains('translate-x-full');
    
    if (isOpen) {
        sidebar.classList.add('translate-x-full');
        sidebar.style.display = 'none';
        overlay.classList.add('hidden');
    } else {
        // Only close other modals, not all sidebars
        document.getElementById('cart-sidebar').classList.add('translate-x-full');
        document.getElementById('product-modal').classList.add('hidden');
        sidebar.classList.remove('translate-x-full');
        sidebar.style.display = 'block';
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }
}

// Product modal functions
function showProductModal(product) {
    currentProduct = product;
    const modal = document.getElementById('product-modal');
    const overlay = document.getElementById('overlay');
    
    document.getElementById('modal-image').innerHTML = product.image_url 
        ? `<img src="${product.image_url}" alt="${product.name}" class="w-full h-full object-cover">`
        : '<div class="w-full h-full flex items-center justify-center text-gray-400"><i class="fas fa-image text-4xl md:text-6xl"></i></div>';
    
    document.getElementById('modal-title').textContent = product.name;
    document.getElementById('modal-price').textContent = `${currencySymbol}${parseFloat(product.price).toFixed(2)}`;
    document.getElementById('modal-description').textContent = product.description || 'No description available.';
    document.getElementById('modal-quantity').value = 1;
    
    document.getElementById('modal-add-to-cart').onclick = () => {
        const quantity = parseInt(document.getElementById('modal-quantity').value);
        addToCart(product, quantity);
        closeProductModal();
    };
    
    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

function closeProductModal() {
    document.getElementById('product-modal').classList.add('hidden');
    document.getElementById('overlay').classList.add('hidden');
    document.body.style.overflow = ''; // Restore scrolling
}

function increaseModalQuantity() {
    const input = document.getElementById('modal-quantity');
    input.value = parseInt(input.value) + 1;
}

function decreaseModalQuantity() {
    const input = document.getElementById('modal-quantity');
    input.value = Math.max(1, parseInt(input.value) - 1);
}

// Search and filter functions
function searchProducts() {
    const searchTerm = (document.getElementById('search-input')?.value || document.getElementById('mobile-search-input')?.value || '').toLowerCase();
    const products = document.querySelectorAll('.product-card');
    let visibleCount = 0;
    
    products.forEach(product => {
        const name = product.dataset.name.toLowerCase();
        const isVisible = name.includes(searchTerm);
        product.style.display = isVisible ? 'block' : 'none';
        if (isVisible) visibleCount++;
    });
    
    // Update both desktop and mobile counters
    const desktopCounter = document.getElementById('product-count');
    const mobileCounter = document.getElementById('mobile-product-count');
    
    [desktopCounter, mobileCounter].forEach(counter => {
        if (counter) {
            counter.textContent = `${visibleCount} ${visibleCount === 1 ? 'product' : 'products'} found`;
        }
    });
}

function filterByCategory(categoryId) {
    const products = document.querySelectorAll('.product-card');
    const buttons = document.querySelectorAll('.category-filter');
    let visibleCount = 0;
    
    buttons.forEach(btn => btn.classList.remove('active', 'bg-blue-100', 'text-blue-700'));
    if (event?.target) {
        event.target.classList.add('active', 'bg-blue-100', 'text-blue-700');
    }
    
    products.forEach(product => {
        const productCategory = product.dataset.category;
        const isVisible = categoryId === 'all' || productCategory === categoryId;
        product.style.display = isVisible ? 'block' : 'none';
        if (isVisible) visibleCount++;
    });
    
    // Update counters
    const desktopCounter = document.getElementById('product-count');
    const mobileCounter = document.getElementById('mobile-product-count');
    
    [desktopCounter, mobileCounter].forEach(counter => {
        if (counter) {
            counter.textContent = `${visibleCount} ${visibleCount === 1 ? 'product' : 'products'} found`;
        }
    });
}

function sortProducts() {
    const sortBy = document.getElementById('sort-select').value;
    const container = document.getElementById('products-container');
    const products = Array.from(container.children);
    
    products.sort((a, b) => {
        switch (sortBy) {
            case 'price-low':
                return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
            case 'price-high':
                return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
            case 'name':
                return a.dataset.name.localeCompare(b.dataset.name);
            default:
                return 0;
        }
    });
    
    products.forEach(product => container.appendChild(product));
}

function setViewMode(mode) {
    viewMode = mode;
    const container = document.getElementById('products-container');
    const gridBtn = document.getElementById('grid-view');
    const listBtn = document.getElementById('list-view');
    
    if (mode === 'grid') {
        container.className = 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-6';
        gridBtn?.classList.add('bg-blue-100', 'text-blue-600');
        listBtn?.classList.remove('bg-blue-100', 'text-blue-600');
    } else {
        container.className = 'space-y-4';
        listBtn?.classList.add('bg-blue-100', 'text-blue-600');
        gridBtn?.classList.remove('bg-blue-100', 'text-blue-600');
    }
}

// Checkout function
function checkout() {
    if (cart.length === 0) {
        showNotification('Your cart is empty!', 'error');
        return;
    }
    
    let message = "🛒 *NEW ORDER REQUEST*\n";
    message += "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    let total = 0;
    
    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        message += `📦 *${item.name}*\n`;
        message += `   • Quantity: ${item.quantity}\n`;
        message += `   • Unit Price: ${currencySymbol}${parseFloat(item.price).toFixed(2)}\n`;
        message += `   • Subtotal: ${currencySymbol}${itemTotal.toFixed(2)}\n`;
        message += "   ─────────────────────────────────────\n";
    });
    
    message += `\n💰 *TOTAL AMOUNT: ${currencySymbol}${total.toFixed(2)}*\n\n`;
    message += "📋 *Next Steps:*\n";
    message += "• Please confirm this order\n";
    message += "• Provide your delivery address\n";
    message += "• Share your preferred delivery time\n\n";
    message += "Thank you for your order! 🙏";
    
    const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
}

// Utility functions
function closeAllModals() {
    document.getElementById('cart-sidebar').classList.add('translate-x-full');
    document.getElementById('wishlist-sidebar').classList.add('translate-x-full');
    document.getElementById('product-modal').classList.add('hidden');
    document.getElementById('overlay').classList.add('hidden');
    document.body.style.overflow = '';
    
    // Close mobile menu
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
        toggleMobileMenu();
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-4 md:px-6 py-3 rounded-lg text-white font-semibold max-w-sm ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 'bg-blue-500'
    }`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Search on Enter key
document.addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && (e.target.id === 'search-input' || e.target.id === 'mobile-search-input')) {
        searchProducts();
    }
});

// Handle window resize
window.addEventListener('resize', function() {
    if (window.innerWidth >= 768) {
        // Close mobile menu on desktop
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
            toggleMobileMenu();
        }
    }
});
</script>

<style>
/* Touch-friendly targets */
.touch-target {
    min-height: 44px;
    min-width: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Line clamping */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Aspect ratio */
.aspect-square {
    aspect-ratio: 1 / 1;
}

/* Smooth transitions */
* {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
}

/* Mobile optimizations */
@media (max-width: 768px) {
    /* Full width sidebars on mobile */
    #cart-sidebar, #wishlist-sidebar {
        width: 100vw;
    }
    
    /* Larger touch targets on mobile */
    .touch-target {
        min-height: 48px;
        min-width: 48px;
    }
    
    /* Better spacing for mobile */
    .product-card {
        min-height: 280px;
    }
    
    /* Prevent zoom on input focus */
    input[type="text"], input[type="number"], select, textarea {
        font-size: 16px;
    }
}

/* Desktop optimizations */
@media (min-width: 768px) {
    /* Hover effects only on desktop */
    .hover\:scale-110:hover {
        transform: scale(1.1);
    }
    
    /* Better grid spacing */
    .product-card {
        min-height: 350px;
    }
}

/* Loading states */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

/* Focus states for accessibility */
button:focus, input:focus, select:focus {
    outline: 2px solid #3B82F6;
    outline-offset: 2px;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Hide scrollbar but keep functionality */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
@endsection