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
        
        .categories-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }
        
        .category-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #E5E7EB;
            padding: 20px;
            transition: all 0.3s ease;
            display: flex; align-items: center; justify-content: space-between;
        }
        .category-card:hover { box-shadow: 0 8px 16px rgba(0,0,0,0.08); }
        .category-info { display: flex; align-items: center; gap: 16px; }
        .category-icon {
            width: 50px; height: 50px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
            overflow: hidden;
            flex-shrink: 0;
        }
        .category-name { font-size: 16px; font-weight: 600; color: #1F2937; }
        .category-count { font-size: 13px; color: #6B7280; margin-top: 2px; }
        .category-actions { display: flex; gap: 8px; }
        .action-btn {
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.2s ease;
            border: none; font-size: 14px;
        }
        .action-btn-edit { background: #EBF5FF; color: #3B82F6; }
        .action-btn-edit:hover { background: #DBEAFE; }
        .action-btn-delete { background: #FEE2E2; color: #EF4444; }
        .action-btn-delete:hover { background: #FECACA; }
        
        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state i { font-size: 64px; color: #D1D5DB; margin-bottom: 16px; }
        .empty-state h3 { font-size: 18px; font-weight: 600; color: #6B7280; margin-bottom: 8px; }
        .empty-state p { font-size: 14px; color: #9CA3AF; margin-bottom: 24px; }
        
        .alert { padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; }
        .alert-success { background: #ECFDF5; border-left: 4px solid #10B981; color: #065F46; }
        
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
            width: 100%; max-width: 500px;
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
        
        .icon-grid { display: grid; grid-template-columns: repeat(8, 1fr); gap: 8px; margin-top: 8px; }
        .icon-option { 
            width: 40px; height: 40px;
            border: 2px solid #E5E7EB; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.2s ease; font-size: 18px;
        }
        .icon-option:hover { border-color: var(--primary-orange); }
        .icon-option.selected { border-color: var(--primary-orange); background: var(--primary-orange-light); }
        
        .color-options { display: flex; gap: 8px; margin-top: 8px; }
        .color-option {
            width: 36px; height: 36px;
            border-radius: 50%; cursor: pointer;
            border: 3px solid transparent; transition: all 0.2s ease;
        }
        .color-option:hover, .color-option.selected { border-color: #1F2937; transform: scale(1.1); }
        
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); }
            .main-content { margin-left: 0 !important; }
            .content-area { padding: 16px; }
            .top-header { padding: 16px; }
            .mobile-menu-btn { display: flex !important; }
            .categories-grid { grid-template-columns: 1fr; }
            .icon-grid { grid-template-columns: repeat(6, 1fr); }
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
                    <a href="{{ route('dashboard.store.products.index') }}" class="nav-link">
                        <i class="fas fa-box"></i>
                        <span class="nav-text">Products</span>
                    </a>
                    <a href="{{ route('dashboard.store.categories.index') }}" class="nav-link active">
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
                    <h1 class="page-title">Categories</h1>
                </div>
                <div class="header-actions">
                    <button onclick="openAddModal()" class="header-btn header-btn-primary">
                        <i class="fas fa-plus"></i>
                        <span>Add Category</span>
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

                @if($categories->count() > 0)
                    <div class="categories-grid">
                        @foreach($categories as $category)
                            <div class="category-card">
                                <div class="category-info">
                                    <div class="category-icon" style="background: {{ $category->color ?? '#F3F4F6' }}20; color: {{ $category->color ?? '#6B7280' }};">
                                        @if($category->image)
                                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
                                        @else
                                            <i class="fas fa-{{ $category->icon ?? 'folder' }}"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="category-name">{{ $category->name }}</div>
                                        <div class="category-count">{{ $category->products_count ?? 0 }} products</div>
                                    </div>
                                </div>
                                <div class="category-actions">
                                    <button class="action-btn action-btn-edit" onclick="openEditModal({{ json_encode($category) }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('dashboard.store.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Delete this category?')" style="display: inline-block; margin: 0;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn action-btn-delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-layer-group"></i>
                        <h3>No categories yet</h3>
                        <p>Create categories to organize your products.</p>
                        <button onclick="openAddModal()" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Category
                        </button>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Add Category Modal -->
    <div class="modal-overlay" id="addModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add New Category</h3>
                <button class="modal-close" onclick="closeAddModal()">&times;</button>
            </div>
            <form action="{{ route('dashboard.store.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Category Name *</label>
                        <input type="text" name="name" class="form-input" required placeholder="e.g., Electronics, Clothing">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Category Image</label>
                        <div style="margin-bottom: 12px;">
                            <input type="file" name="image" id="addCategoryImage" accept="image/*" class="form-input" style="padding: 8px;" onchange="previewCategoryImage(this, 'addImagePreview')">
                            <p style="font-size: 12px; color: #6B7280; margin-top: 4px;">Upload a custom image or select an icon below. Recommended: 200x200px, Max 2MB</p>
                        </div>
                        <div id="addImagePreview" style="display: none; margin-bottom: 12px;">
                            <img src="" alt="Preview" style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover; border: 2px solid #E5E7EB;">
                            <button type="button" onclick="clearCategoryImage('add')" style="display: block; margin-top: 8px; padding: 4px 12px; background: #EF4444; color: white; border: none; border-radius: 6px; font-size: 12px; cursor: pointer;">
                                <i class="fas fa-times"></i> Remove Image
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Icon (if no image)</label>
                        <input type="hidden" name="icon" id="addIcon" value="folder">
                        <div class="icon-grid">
                            @foreach(['folder', 'box', 'shopping-bag', 'tshirt', 'utensils', 'mobile-alt', 'laptop', 'headphones', 'camera', 'gift', 'gem', 'shoe-prints', 'couch', 'book', 'palette', 'football-ball'] as $icon)
                                <div class="icon-option {{ $icon === 'folder' ? 'selected' : '' }}" data-icon="{{ $icon }}" onclick="selectIcon(this, 'add')">
                                    <i class="fas fa-{{ $icon }}"></i>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Color</label>
                        <input type="hidden" name="color" id="addColor" value="#6B7280">
                        <div class="color-options">
                            @foreach(['#EF4444', '#F97316', '#EAB308', '#22C55E', '#14B8A6', '#3B82F6', '#8B5CF6', '#EC4899', '#6B7280'] as $color)
                                <div class="color-option {{ $color === '#6B7280' ? 'selected' : '' }}" style="background: {{ $color }};" data-color="{{ $color }}" onclick="selectColor(this, 'add')"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal-overlay" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Category</h3>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Category Name *</label>
                        <input type="text" name="name" id="editName" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Category Image</label>
                        <div id="editCurrentImage" style="display: none; margin-bottom: 12px;">
                            <img src="" alt="Current" style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover; border: 2px solid #E5E7EB;">
                            <button type="button" onclick="removeCurrentImage()" style="display: block; margin-top: 8px; padding: 4px 12px; background: #EF4444; color: white; border: none; border-radius: 6px; font-size: 12px; cursor: pointer;">
                                <i class="fas fa-trash"></i> Delete Current Image
                            </button>
                            <input type="hidden" name="delete_image" id="deleteImageFlag" value="0">
                        </div>
                        <div style="margin-bottom: 12px;">
                            <input type="file" name="image" id="editCategoryImage" accept="image/*" class="form-input" style="padding: 8px;" onchange="previewCategoryImage(this, 'editImagePreview')">
                            <p style="font-size: 12px; color: #6B7280; margin-top: 4px;">Upload a new image or select an icon below. Recommended: 200x200px, Max 2MB</p>
                        </div>
                        <div id="editImagePreview" style="display: none; margin-bottom: 12px;">
                            <img src="" alt="Preview" style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover; border: 2px solid #E5E7EB;">
                            <button type="button" onclick="clearCategoryImage('edit')" style="display: block; margin-top: 8px; padding: 4px 12px; background: #EF4444; color: white; border: none; border-radius: 6px; font-size: 12px; cursor: pointer;">
                                <i class="fas fa-times"></i> Remove New Image
                            </button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Icon (if no image)</label>
                        <input type="hidden" name="icon" id="editIcon" value="folder">
                        <div class="icon-grid" id="editIconGrid">
                            @foreach(['folder', 'box', 'shopping-bag', 'tshirt', 'utensils', 'mobile-alt', 'laptop', 'headphones', 'camera', 'gift', 'gem', 'shoe-prints', 'couch', 'book', 'palette', 'football-ball'] as $icon)
                                <div class="icon-option" data-icon="{{ $icon }}" onclick="selectIcon(this, 'edit')">
                                    <i class="fas fa-{{ $icon }}"></i>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Color</label>
                        <input type="hidden" name="color" id="editColor" value="#6B7280">
                        <div class="color-options" id="editColorGrid">
                            @foreach(['#EF4444', '#F97316', '#EAB308', '#22C55E', '#14B8A6', '#3B82F6', '#8B5CF6', '#EC4899', '#6B7280'] as $color)
                                <div class="color-option" style="background: {{ $color }};" data-color="{{ $color }}" onclick="selectColor(this, 'edit')"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
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
        
        function openAddModal() { document.getElementById('addModal').classList.add('active'); }
        function closeAddModal() { document.getElementById('addModal').classList.remove('active'); }
        
        function openEditModal(category) {
            document.getElementById('editForm').action = `/dashboard/store/categories/${category.id}`;
            document.getElementById('editName').value = category.name;
            document.getElementById('editIcon').value = category.icon || 'folder';
            document.getElementById('editColor').value = category.color || '#6B7280';
            
            // Show current image if exists
            if (category.image) {
                const currentImageDiv = document.getElementById('editCurrentImage');
                currentImageDiv.style.display = 'block';
                currentImageDiv.querySelector('img').src = category.image_url;
                document.getElementById('deleteImageFlag').value = '0';
            } else {
                document.getElementById('editCurrentImage').style.display = 'none';
            }
            
            // Reset previews
            document.getElementById('editImagePreview').style.display = 'none';
            document.getElementById('editCategoryImage').value = '';
            
            document.querySelectorAll('#editIconGrid .icon-option').forEach(el => {
                el.classList.toggle('selected', el.dataset.icon === (category.icon || 'folder'));
            });
            document.querySelectorAll('#editColorGrid .color-option').forEach(el => {
                el.classList.toggle('selected', el.dataset.color === (category.color || '#6B7280'));
            });
            
            document.getElementById('editModal').classList.add('active');
        }
        function closeEditModal() { document.getElementById('editModal').classList.remove('active'); }
        
        function previewCategoryImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.querySelector('img').src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        function clearCategoryImage(type) {
            const input = document.getElementById(type + 'CategoryImage');
            const preview = document.getElementById(type + 'ImagePreview');
            input.value = '';
            preview.style.display = 'none';
        }
        
        function removeCurrentImage() {
            if (confirm('Are you sure you want to delete the current image?')) {
                document.getElementById('deleteImageFlag').value = '1';
                document.getElementById('editCurrentImage').style.display = 'none';
            }
        }
        
        function selectIcon(el, type) {
            el.parentElement.querySelectorAll('.icon-option').forEach(o => o.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById(type + 'Icon').value = el.dataset.icon;
        }
        
        function selectColor(el, type) {
            el.parentElement.querySelectorAll('.color-option').forEach(o => o.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById(type + 'Color').value = el.dataset.color;
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('sidebar-collapsed') === 'true') {
                document.getElementById('sidebar').classList.add('collapsed');
            }
        });
    </script>
</x-app-layout>
