<x-app-layout>
    <style>
        :root {
            --primary-orange: #F97316;
            --primary-orange-light: #FFF7ED;
            --primary-orange-dark: #EA580C;
            --sidebar-width: 260px;
            --sidebar-collapsed: 80px;
        }
        
        .store-dashboard { display: flex; min-height: 100vh; background: #F8FAFC; }
        
        .sidebar {
            width: var(--sidebar-width);
            background: white;
            border-right: 1px solid #E5E7EB;
            position: fixed;
            left: 0; top: 0;
            height: 100vh;
            z-index: 50;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .sidebar.collapsed { width: var(--sidebar-collapsed); }
        .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid #E5E7EB;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-logo {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--primary-orange), #FB923C);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: bold; font-size: 18px;
            flex-shrink: 0;
        }
        .sidebar-brand { font-size: 18px; font-weight: 700; color: #1F2937; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar.collapsed .sidebar-brand,
        .sidebar.collapsed .nav-text,
        .sidebar.collapsed .sidebar-footer-text,
        .sidebar.collapsed .nav-section-title { display: none; }
        .sidebar.collapsed .sidebar-header { justify-content: center; padding: 24px 16px; }
        .sidebar.collapsed .nav-link { justify-content: center; padding: 14px; }
        .sidebar.collapsed .nav-link i { margin-right: 0; }
        
        .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }
        .nav-section { margin-bottom: 8px; }
        .nav-section-title { font-size: 11px; font-weight: 600; color: #9CA3AF; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px 8px; }
        .nav-link {
            display: flex; align-items: center;
            padding: 12px 16px; margin: 4px 0;
            border-radius: 10px;
            color: #4B5563; font-weight: 500; font-size: 14px;
            cursor: pointer; transition: all 0.2s ease;
            text-decoration: none;
        }
        .nav-link:hover { background: #F3F4F6; color: #1F2937; }
        .nav-link.active { background: var(--primary-orange); color: white; }
        .nav-link i { width: 20px; text-align: center; margin-right: 12px; font-size: 16px; }
        
        .sidebar-footer { padding: 16px; border-top: 1px solid #E5E7EB; }
        .sidebar-toggle-btn {
            display: flex; align-items: center; justify-content: center;
            width: 100%; padding: 10px; border-radius: 8px;
            background: #F3F4F6; color: #6B7280;
            cursor: pointer; transition: all 0.2s ease; border: none;
        }
        .sidebar-toggle-btn:hover { background: #E5E7EB; }
        .sidebar.collapsed .sidebar-toggle-btn i { transform: rotate(180deg); }
        
        .main-content { flex: 1; margin-left: var(--sidebar-width); transition: margin-left 0.3s ease; min-height: 100vh; }
        .sidebar.collapsed ~ .main-content { margin-left: var(--sidebar-collapsed); }
        
        .top-header {
            background: white; padding: 16px 32px;
            border-bottom: 1px solid #E5E7EB;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 40;
        }
        .page-title { font-size: 24px; font-weight: 700; color: #1F2937; }
        .header-actions { display: flex; align-items: center; gap: 12px; }
        .header-btn {
            padding: 10px 20px; border-radius: 10px;
            font-weight: 600; font-size: 14px;
            cursor: pointer; transition: all 0.2s ease;
            display: flex; align-items: center; gap: 8px;
            border: none; text-decoration: none;
        }
        .header-btn-primary { background: var(--primary-orange); color: white; }
        .header-btn-primary:hover { background: var(--primary-orange-dark); }
        .header-btn-secondary { background: #F3F4F6; color: #4B5563; }
        .header-btn-secondary:hover { background: #E5E7EB; }
        
        .content-area { padding: 24px 32px; }
        
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; }
        
        .product-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #E5E7EB;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.1); }
        .product-image {
            width: 100%; height: 180px;
            object-fit: cover; background: #F3F4F6;
        }
        .product-image-placeholder {
            width: 100%; height: 180px;
            background: linear-gradient(135deg, #F3F4F6, #E5E7EB);
            display: flex; align-items: center; justify-content: center;
        }
        .product-body { padding: 16px; }
        .product-name { font-size: 16px; font-weight: 600; color: #1F2937; margin-bottom: 4px; }
        .product-category { font-size: 12px; color: #6B7280; margin-bottom: 8px; }
        .product-price { font-size: 18px; font-weight: 700; color: var(--primary-orange); }
        .product-price-old { font-size: 14px; color: #9CA3AF; text-decoration: line-through; margin-left: 8px; }
        .product-stock { display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 500; margin-top: 8px; }
        .stock-in { background: #ECFDF5; color: #059669; }
        .stock-low { background: #FEF3C7; color: #D97706; }
        .stock-out { background: #FEE2E2; color: #DC2626; }
        .product-actions { display: flex; gap: 8px; margin-top: 12px; padding-top: 12px; border-top: 1px solid #E5E7EB; }
        .product-action-btn {
            flex: 1; padding: 8px; border-radius: 8px;
            font-size: 12px; font-weight: 500;
            cursor: pointer; transition: all 0.2s ease;
            display: flex; align-items: center; justify-content: center; gap: 4px;
            border: none;
        }
        .btn-edit { background: #EBF5FF; color: #3B82F6; }
        .btn-edit:hover { background: #DBEAFE; }
        .btn-delete { background: #FEE2E2; color: #EF4444; }
        .btn-delete:hover { background: #FECACA; }
        
        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state i { font-size: 64px; color: #D1D5DB; margin-bottom: 16px; }
        .empty-state h3 { font-size: 18px; font-weight: 600; color: #6B7280; margin-bottom: 8px; }
        .empty-state p { font-size: 14px; color: #9CA3AF; margin-bottom: 24px; }
        
        .alert { padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; }
        .alert-success { background: #ECFDF5; border-left: 4px solid #10B981; color: #065F46; }
        .alert-error { background: #FEF2F2; border-left: 4px solid #EF4444; color: #991B1B; }
        
        .modal-overlay {
            position: fixed; top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 100;
            display: none; align-items: center; justify-content: center;
            padding: 20px;
        }
        .modal-overlay.active { display: flex; }
        .modal-content {
            background: white; border-radius: 20px;
            width: 100%; max-width: 600px;
            max-height: 90vh; overflow-y: auto;
        }
        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid #E5E7EB;
            display: flex; align-items: center; justify-content: space-between;
        }
        .modal-title { font-size: 18px; font-weight: 600; color: #1F2937; }
        .modal-close { background: none; border: none; font-size: 24px; color: #6B7280; cursor: pointer; }
        .modal-body { padding: 24px; }
        .modal-footer { padding: 16px 24px; border-top: 1px solid #E5E7EB; display: flex; justify-content: flex-end; gap: 12px; }
        
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 14px; font-weight: 500; color: #374151; margin-bottom: 8px; }
        .form-input {
            width: 100%; padding: 12px 16px;
            border: 1px solid #D1D5DB; border-radius: 10px;
            font-size: 14px; transition: all 0.2s ease; background: white;
        }
        .form-input:focus { outline: none; border-color: var(--primary-orange); box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1); }
        
        .btn {
            padding: 12px 24px; border-radius: 10px;
            font-weight: 600; font-size: 14px;
            cursor: pointer; transition: all 0.2s ease;
            display: inline-flex; align-items: center; justify-content: center;
            gap: 8px; border: none;
        }
        .btn-primary { background: var(--primary-orange); color: white; }
        .btn-primary:hover { background: var(--primary-orange-dark); }
        .btn-secondary { background: #F3F4F6; color: #4B5563; }
        .btn-secondary:hover { background: #E5E7EB; }
        
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        
        .filter-bar { display: flex; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
        .search-box { flex: 1; min-width: 200px; position: relative; }
        .search-box input { width: 100%; padding: 12px 16px 12px 44px; }
        .search-box i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #9CA3AF; }
        
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); }
            .main-content { margin-left: 0 !important; }
            .content-area { padding: 16px; }
            .top-header { padding: 16px; }
            .mobile-menu-btn { display: flex !important; }
            .products-grid { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
            .filter-bar { flex-direction: column; }
        }
        .mobile-menu-btn { display: none; }
    </style>

    <div class="store-dashboard">
        <!-- Left Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo"><i class="fas fa-store"></i></div>
                <span class="sidebar-brand">{{ $profile->store_name ?: 'My Store' }}</span>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Main</div>
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="fas fa-th-large"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                    <a href="{{ route('dashboard.store') }}" class="nav-link">
                        <i class="fas fa-chart-bar"></i>
                        <span class="nav-text">Overview</span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Store</div>
                    <a href="{{ route('dashboard.store.products.index') }}" class="nav-link active">
                        <i class="fas fa-box"></i>
                        <span class="nav-text">Products</span>
                    </a>
                    <a href="{{ route('dashboard.store.categories.index') }}" class="nav-link">
                        <i class="fas fa-layer-group"></i>
                        <span class="nav-text">Categories</span>
                    </a>
                    <a href="{{ route('dashboard.store.orders.index') }}" class="nav-link">
                        <i class="fas fa-receipt"></i>
                        <span class="nav-text">Orders</span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Management</div>
                    <a href="{{ route('dashboard.store.settings') }}" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                </div>
            </nav>
            
            <div class="sidebar-footer">
                <button class="sidebar-toggle-btn" onclick="toggleSidebar()">
                    <i class="fas fa-chevron-left" id="sidebarToggleIcon"></i>
                    <span class="sidebar-footer-text" style="margin-left: 8px;">Collapse</span>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <header class="top-header">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <button class="header-btn header-btn-secondary mobile-menu-btn" onclick="toggleMobileSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title">Products</h1>
                </div>
                <div class="header-actions">
                    <button onclick="openAddModal()" class="header-btn header-btn-primary">
                        <i class="fas fa-plus"></i>
                        <span>Add Product</span>
                    </button>
                    <a href="{{ route('dashboard.store') }}" class="header-btn header-btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </header>

            <div class="content-area">
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle" style="font-size: 20px;"></i>
                        <span style="font-weight: 500;">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle" style="font-size: 20px;"></i>
                        <span style="font-weight: 500;">{{ session('error') }}</span>
                    </div>
                @endif

                <div class="filter-bar">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="productSearch" class="form-input" placeholder="Search products...">
                    </div>
                    <select id="categoryFilter" class="form-input" style="width: auto; min-width: 160px;">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                @if($products->count() > 0)
                    <div class="products-grid" id="productsGrid">
                        @foreach($products as $product)
                            <div class="product-card" data-category="{{ $product->category_id }}" data-name="{{ strtolower($product->name) }}">
                                @if($product->image)
                                    <img src="{{ Storage::disk('public')->url($product->image) }}" alt="{{ $product->name }}" class="product-image">
                                @else
                                    <div class="product-image-placeholder">
                                        <i class="fas fa-image" style="font-size: 48px; color: #D1D5DB;"></i>
                                    </div>
                                @endif
                                <div class="product-body">
                                    <h3 class="product-name">{{ $product->name }}</h3>
                                    <p class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                    <div>
                                        <span class="product-price">{{ $currencySymbol }}{{ number_format($product->price, 2) }}</span>
                                        @if($product->original_price && $product->original_price > $product->price)
                                            <span class="product-price-old">{{ $currencySymbol }}{{ number_format($product->original_price, 2) }}</span>
                                        @endif
                                    </div>
                                    @if($product->stock !== null)
                                        @if($product->stock <= 0)
                                            <span class="product-stock stock-out">Out of Stock</span>
                                        @elseif($product->stock <= 5)
                                            <span class="product-stock stock-low">Low Stock ({{ $product->stock }})</span>
                                        @else
                                            <span class="product-stock stock-in">In Stock ({{ $product->stock }})</span>
                                        @endif
                                    @endif
                                    <div class="product-actions">
                                        <button class="product-action-btn btn-edit" onclick="openEditModal({{ json_encode($product) }})">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('dashboard.store.products.destroy', $product->id) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Delete this product?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="product-action-btn btn-delete" style="width: 100%;">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-box-open"></i>
                        <h3>No products yet</h3>
                        <p>Start by adding your first product to your store.</p>
                        <button onclick="openAddModal()" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Product
                        </button>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Add Product Modal -->
    <div class="modal-overlay" id="addProductModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add New Product</h3>
                <button class="modal-close" onclick="closeAddModal()">&times;</button>
            </div>
            <form action="{{ route('dashboard.store.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" class="form-input" required placeholder="Enter product name">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-input" rows="3" placeholder="Describe your product..."></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Price *</label>
                            <input type="number" name="price" class="form-input" step="0.01" min="0" required placeholder="0.00">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Original Price</label>
                            <input type="number" name="original_price" class="form-input" step="0.01" min="0" placeholder="For sale items">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-input">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-input" min="0" placeholder="Leave empty for unlimited">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Product Type</label>
                        <select name="product_type" class="form-input">
                            <option value="">Regular Product</option>
                            <option value="top_selling">Top Selling</option>
                            <option value="trending">Trending</option>
                            <option value="featured">Featured</option>
                        </select>
                        <small style="color: #6B7280; font-size: 12px; display: block; margin-top: 4px;">Mark this product to appear in featured sections</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="image" class="form-input" accept="image/*" style="padding: 10px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Product</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal-overlay" id="editProductModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Product</h3>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <form id="editProductForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Product Name *</label>
                        <input type="text" name="name" id="editName" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editDescription" class="form-input" rows="3"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Price *</label>
                            <input type="number" name="price" id="editPrice" class="form-input" step="0.01" min="0" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Original Price</label>
                            <input type="number" name="original_price" id="editOriginalPrice" class="form-input" step="0.01" min="0">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select name="category_id" id="editCategory" class="form-input">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" id="editStock" class="form-input" min="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Product Type</label>
                        <select name="product_type" id="editProductType" class="form-input">
                            <option value="">Regular Product</option>
                            <option value="top_selling">Top Selling</option>
                            <option value="trending">Trending</option>
                            <option value="featured">Featured</option>
                        </select>
                        <small style="color: #6B7280; font-size: 12px; display: block; margin-top: 4px;">Mark this product to appear in featured sections</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Current Image</label>
                        <div id="editCurrentImage" style="margin-bottom: 8px;"></div>
                        <input type="file" name="image" class="form-input" accept="image/*" style="padding: 10px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Product</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
        }
        function toggleMobileSidebar() {
            document.getElementById('sidebar').classList.toggle('mobile-open');
        }
        
        function openAddModal() { document.getElementById('addProductModal').classList.add('active'); }
        function closeAddModal() { document.getElementById('addProductModal').classList.remove('active'); }
        
        function openEditModal(product) {
            document.getElementById('editProductForm').action = `/dashboard/store/products/${product.id}`;
            document.getElementById('editName').value = product.name;
            document.getElementById('editDescription').value = product.description || '';
            document.getElementById('editPrice').value = product.price;
            document.getElementById('editOriginalPrice').value = product.original_price || '';
            document.getElementById('editCategory').value = product.category_id || '';
            document.getElementById('editStock').value = product.stock || '';
            document.getElementById('editProductType').value = product.product_type || '';
            
            const imageContainer = document.getElementById('editCurrentImage');
            if (product.image_url) {
                imageContainer.innerHTML = `<img src="${product.image_url}" alt="Current" style="width: 80px; height: 80px; border-radius: 8px; object-fit: cover;">`;
            } else {
                imageContainer.innerHTML = '<span style="color: #9CA3AF; font-size: 14px;">No image</span>';
            }
            
            document.getElementById('editProductModal').classList.add('active');
        }
        function closeEditModal() { document.getElementById('editProductModal').classList.remove('active'); }
        
        // Search and Filter
        document.getElementById('productSearch').addEventListener('input', filterProducts);
        document.getElementById('categoryFilter').addEventListener('change', filterProducts);
        
        function filterProducts() {
            const search = document.getElementById('productSearch').value.toLowerCase();
            const category = document.getElementById('categoryFilter').value;
            const cards = document.querySelectorAll('.product-card');
            
            cards.forEach(card => {
                const name = card.dataset.name;
                const cat = card.dataset.category;
                const matchSearch = !search || name.includes(search);
                const matchCategory = !category || cat === category;
                card.style.display = matchSearch && matchCategory ? 'block' : 'none';
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('sidebar-collapsed') === 'true') {
                document.getElementById('sidebar').classList.add('collapsed');
            }
        });
    </script>
</x-app-layout>

