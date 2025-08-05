<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🛍️ {{ __('Store Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Store Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">{{ $profile->store_name ?: 'Your Store' }}</h3>
                        <div class="flex space-x-3">
                            <a href="{{ route('store.show', $user->qrCode->uuid) }}" target="_blank" class="bg-purple-500 hover:bg-purple-700 text-white px-4 py-2 rounded text-sm">
                                View Store
                            </a>
                            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded text-sm">
                                Back to Dashboard
                            </a>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800">Total Products</h4>
                            <p class="text-2xl font-bold text-blue-600">{{ $products->count() }}</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800">Categories</h4>
                            <p class="text-2xl font-bold text-green-600">{{ $categories->count() }}</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-yellow-800">Pending Orders</h4>
                            <p class="text-2xl font-bold text-yellow-600">{{ $orders->where('status', 'pending')->count() }}</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-800">Total Orders</h4>
                            <p class="text-2xl font-bold text-purple-600">{{ $orders->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Add Category -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Add Category</h3>
                        <form action="{{ route('dashboard.store.categories.add') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Category Name</label>
                                    <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <input type="text" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Icon (emoji or text)</label>
                                    <input type="text" name="icon" placeholder="🍕" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Add Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Add Product -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Add Product</h3>
                        <form action="{{ route('dashboard.store.products.add') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Product Name</label>
                                    <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Category</label>
                                    <select name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="">No Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Price ({{ $profile->currency_symbol ?? '$' }})</label>
                                        <input type="number" name="price" step="0.01" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Original Price ({{ $profile->currency_symbol ?? '$' }})</label>
                                        <input type="number" name="original_price" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Product Image</label>
                                    <input type="file" name="image" accept="image/*" class="mt-1 block w-full">
                                </div>
                                <div class="flex space-x-4">
                                    <input type="hidden" name="is_available" value="0">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_available" value="1" checked class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        <span class="ml-2 text-sm text-gray-700">Available</span>
                                    </label>
                                    <input type="hidden" name="is_featured" value="0">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        <span class="ml-2 text-sm text-gray-700">Featured</span>
                                    </label>
                                </div>
                                <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Add Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Categories</h3>
                    @if($categories->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($categories as $category)
                                <div class="border rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold">{{ $category->icon }} {{ $category->name }}</h4>
                                            @if($category->description)
                                                <p class="text-sm text-gray-600">{{ $category->description }}</p>
                                            @endif
                                            <p class="text-xs text-gray-500">{{ $category->products->count() }} products</p>
                                        </div>
                                        <div class="text-right space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                            <a href="{{ route('dashboard.store.categories.edit', $category) }}" class="text-blue-500 hover:text-blue-700 text-xs font-bold">Edit</a>
                                            <form action="{{ route('dashboard.store.categories.delete', $category) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold ml-2">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No categories created yet.</p>
                    @endif
                </div>
            </div>

            <!-- Products -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Products</h3>
                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($products as $product)
                                <div class="border rounded-lg overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-32 object-cover">
                                    @else
                                        <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                                            <span class="text-gray-500">No Image</span>
                                        </div>
                                    @endif
                                    <div class="p-4">
                                        <h4 class="font-semibold">{{ $product->name }}</h4>
                                        @if($product->category)
                                            <p class="text-xs text-gray-500">{{ $product->category->name }}</p>
                                        @endif
                                        <div class="flex items-center justify-between mt-2">
                                            <div>
                                                <span class="font-bold text-green-600">{{ $product->formatted_price }}</span>
                                                @if($product->is_on_sale)
                                                    <span class="text-sm text-gray-500 line-through ml-2">{{ $product->formatted_original_price }}</span>
                                                @endif
                                            </div>
                                            <div class="flex space-x-1">
                                                @if($product->is_featured)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Featured</span>
                                                @endif
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $product->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $product->is_available ? 'Available' : 'Unavailable' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex justify-end space-x-2 mt-3">
                                            <a href="{{ route('dashboard.store.products.edit', $product) }}" class="text-blue-500 hover:text-blue-700 text-xs font-bold">Edit</a>
                                            <form action="{{ route('dashboard.store.products.delete', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-bold ml-2">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No products added yet.</p>
                    @endif
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Recent Orders</h3>
                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="border rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-semibold">Order #{{ $order->order_number }}</h4>
                                            <p class="text-sm text-gray-600">{{ $order->customer_name }} - {{ $order->customer_phone }}</p>
                                            <p class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold">{{ $order->formatted_total }}</p>
                                            <div class="flex items-center space-x-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800">
                                                    {{ $order->status_label }}
                                                </span>
                                                <form action="{{ route('dashboard.store.orders.status', $order) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" onchange="this.form.submit()" class="text-xs border-gray-300 rounded">
                                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                        <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                                                        <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Ready</option>
                                                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-600">Items: {{ $order->total_items }}</p>
                                        @if($order->notes)
                                            <p class="text-sm text-gray-600">Notes: {{ $order->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No orders yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
