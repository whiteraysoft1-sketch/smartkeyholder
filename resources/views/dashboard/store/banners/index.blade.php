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
        
        .banners-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 24px; }
        
        .banner-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #E5E7EB;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }
        .banner-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.1); }
        .banner-card.inactive { opacity: 0.6; }
        .banner-preview {
            width: 100%; height: 160px;
            position: relative;
            overflow: hidden;
        }
        .banner-preview img { width: 100%; height: 100%; object-fit: cover; }
        .banner-preview-placeholder {
            width: 100%; height: 100%;
            display: flex; align-items: center; justify-content: center; flex-direction: column;
            gap: 8px; color: white;
        }
        .banner-preview-text { position: absolute; inset: 0; padding: 20px; display: flex; flex-direction: column; justify-content: center; background: rgba(0,0,0,0.3); }
        .banner-preview-subtitle { font-size: 11px; color: rgba(255,255,255,0.9); margin-bottom: 4px; }
        .banner-preview-title { font-size: 18px; font-weight: 700; color: white; }
        .banner-preview-btn { display: inline-block; margin-top: 12px; padding: 6px 14px; background: var(--primary-orange); color: white; border-radius: 6px; font-size: 12px; font-weight: 500; }
        .banner-status { position: absolute; top: 12px; right: 12px; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .banner-status.active { background: #ECFDF5; color: #059669; }
        .banner-status.inactive { background: #FEE2E2; color: #DC2626; }
        .banner-body { padding: 16px; }
        .banner-title { font-size: 16px; font-weight: 600; color: #1F2937; margin-bottom: 4px; }
        .banner-subtitle { font-size: 13px; color: #6B7280; }
        .banner-link { font-size: 12px; color: #3B82F6; margin-top: 8px; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .banner-actions { display: flex; gap: 8px; margin-top: 12px; padding-top: 12px; border-top: 1px solid #E5E7EB; }
        .banner-action-btn {
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
        
        .empty-state { text-align: center; padding: 60px 20px; background: white; border-radius: 16px; border: 1px solid #E5E7EB; }
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
        
        .color-input-wrap { display: flex; gap: 8px; }
        .color-input-wrap input[type="color"] { width: 50px; height: 44px; border: none; border-radius: 8px; cursor: pointer; }
        .color-input-wrap input[type="text"] { flex: 1; }
        
        .image-upload {
            border: 2px dashed #D1D5DB;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .image-upload:hover { border-color: var(--primary-orange); background: #FFF7ED; }
        .image-upload i { font-size: 32px; color: #9CA3AF; margin-bottom: 8px; }
        .image-upload p { font-size: 14px; color: #6B7280; }
        .image-upload span { font-size: 12px; color: #9CA3AF; }
        .image-upload-preview { max-width: 200px; margin: 0 auto 16px; border-radius: 8px; overflow: hidden; }
        .image-upload-preview img { width: 100%; }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
        .checkbox-group input[type="checkbox"] { width: 20px; height: 20px; accent-color: var(--primary-orange); }
        
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); }
            .main-content { margin-left: 0 !important; }
            .top-header { padding: 16px; }
            .content-area { padding: 16px; }
            .banners-grid { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
            .mobile-menu-btn { display: block !important; }
        }
        .mobile-menu-btn { display: none; background: none; border: none; font-size: 24px; color: #374151; cursor: pointer; }
    </style>

    <div class="store-dashboard">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-store"></i>
                </div>
                <span class="sidebar-brand">Store Manager</span>
            </div>
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Store</div>
                    <a href="{{ route('dashboard.store') }}" class="nav-link">
                        <i class="fas fa-th-large"></i>
                        <span class="nav-text">Overview</span>
                    </a>
                    <a href="{{ route('dashboard.store.products.index') }}" class="nav-link">
                        <i class="fas fa-box"></i>
                        <span class="nav-text">Products</span>
                    </a>
                    <a href="{{ route('dashboard.store.categories.index') }}" class="nav-link">
                        <i class="fas fa-folder"></i>
                        <span class="nav-text">Categories</span>
                    </a>
                    <a href="{{ route('dashboard.store.orders.index') }}" class="nav-link">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="nav-text">Orders</span>
                    </a>
                    <a href="{{ route('dashboard.store.banners') }}" class="nav-link active">
                        <i class="fas fa-images"></i>
                        <span class="nav-text">Banners/Ads</span>
                    </a>
                    <a href="{{ route('dashboard.store.settings') }}" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                </div>
                <div class="nav-section">
                    <div class="nav-section-title">Quick Links</div>
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="fas fa-arrow-left"></i>
                        <span class="nav-text">Back to Dashboard</span>
                    </a>
                    @if(auth()->user()->qrCode)
                    <a href="{{ route('store.show', auth()->user()->qrCode->uuid) }}" class="nav-link" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                        <span class="nav-text">View Store</span>
                    </a>
                    @endif
                </div>
            </nav>
            <div class="sidebar-footer">
                <button class="sidebar-toggle-btn" onclick="toggleSidebar()">
                    <i class="fas fa-chevron-left"></i>
                    <span class="sidebar-footer-text" style="margin-left: 8px;">Collapse</span>
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="top-header">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title">Banners & Ads</h1>
                </div>
                <div class="header-actions">
                    <button class="header-btn header-btn-primary" onclick="openAddModal()">
                        <i class="fas fa-plus"></i> Add Banner
                    </button>
                </div>
            </header>

            <div class="content-area">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                @if($banners->count() > 0)
                    <div class="banners-grid" id="banners-grid">
                        @foreach($banners as $banner)
                        <div class="banner-card {{ !$banner->is_active ? 'inactive' : '' }}" data-id="{{ $banner->id }}">
                            <div class="banner-preview" style="background: {{ $banner->background_color ?? 'linear-gradient(135deg, #667eea, #764ba2)' }};">
                                @if($banner->image)
                                    <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}">
                                @else
                                    <div class="banner-preview-placeholder">
                                        <i class="fas fa-image" style="font-size: 32px;"></i>
                                        <span>No Image</span>
                                    </div>
                                @endif
                                <div class="banner-preview-text">
                                    @if($banner->subtitle)
                                        <span class="banner-preview-subtitle">{{ $banner->subtitle }}</span>
                                    @endif
                                    <span class="banner-preview-title">{{ $banner->title }}</span>
                                    @if($banner->button_text)
                                        <span class="banner-preview-btn">{{ $banner->button_text }}</span>
                                    @endif
                                </div>
                                <span class="banner-status {{ $banner->is_active ? 'active' : 'inactive' }}">
                                    {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="banner-body">
                                <h4 class="banner-title">{{ $banner->title }}</h4>
                                @if($banner->subtitle)
                                    <p class="banner-subtitle">{{ $banner->subtitle }}</p>
                                @endif
                                @if($banner->button_link)
                                    <a href="{{ $banner->button_link }}" class="banner-link" target="_blank">
                                        <i class="fas fa-link"></i> {{ $banner->button_link }}
                                    </a>
                                @endif
                                <div class="banner-actions">
                                    <button class="banner-action-btn btn-edit" onclick='openEditModal(@json($banner))'>
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('dashboard.store.banners.destroy', $banner) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Delete this banner?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="banner-action-btn btn-delete" style="width: 100%;">
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
                        <i class="fas fa-images"></i>
                        <h3>No Banners Yet</h3>
                        <p>Create banners to showcase promotions and highlight products in your store slider</p>
                        <button class="btn btn-primary" onclick="openAddModal()">
                            <i class="fas fa-plus"></i> Add Your First Banner
                        </button>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Add Banner Modal -->
    <div class="modal-overlay" id="add-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add New Banner</h3>
                <button class="modal-close" onclick="closeAddModal()">&times;</button>
            </div>
            <form action="{{ route('dashboard.store.banners.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Banner Image</label>
                        <div class="image-upload" onclick="document.getElementById('add-banner-image').click()">
                            <div id="add-image-preview" class="image-upload-preview" style="display: none;"></div>
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Click to upload banner image</p>
                            <span>Recommended: 1200 x 400 pixels, JPG/PNG/WebP (max 2MB)</span>
                        </div>
                        <input type="file" id="add-banner-image" name="image" accept="image/*" style="display: none;" onchange="previewImage(this, 'add-image-preview')">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Title *</label>
                        <input type="text" name="title" class="form-input" placeholder="e.g. Summer Sale - Up to 50% Off" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Subtitle</label>
                        <input type="text" name="subtitle" class="form-input" placeholder="e.g. Limited Time Offer">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Button Text</label>
                            <input type="text" name="button_text" class="form-input" placeholder="e.g. Shop Now">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Button Link</label>
                            <input type="url" name="button_link" class="form-input" placeholder="https://...">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Background Color</label>
                            <div class="color-input-wrap">
                                <input type="color" value="#667eea" onchange="document.getElementById('add-bg-color').value = this.value">
                                <input type="text" id="add-bg-color" name="background_color" class="form-input" value="#667eea" placeholder="#667eea">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Text Color</label>
                            <div class="color-input-wrap">
                                <input type="color" value="#ffffff" onchange="document.getElementById('add-text-color').value = this.value">
                                <input type="text" id="add-text-color" name="text_color" class="form-input" value="#ffffff" placeholder="#ffffff">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Banner</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Banner Modal -->
    <div class="modal-overlay" id="edit-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Banner</h3>
                <button class="modal-close" onclick="closeEditModal()">&times;</button>
            </div>
            <form id="edit-form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Banner Image</label>
                        <div class="image-upload" onclick="document.getElementById('edit-banner-image').click()">
                            <div id="edit-image-preview" class="image-upload-preview" style="display: none;"></div>
                            <i class="fas fa-cloud-upload-alt" id="edit-upload-icon"></i>
                            <p id="edit-upload-text">Click to upload new image</p>
                            <span>Leave empty to keep current image</span>
                        </div>
                        <input type="file" id="edit-banner-image" name="image" accept="image/*" style="display: none;" onchange="previewImage(this, 'edit-image-preview')">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Title *</label>
                        <input type="text" name="title" id="edit-title" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Subtitle</label>
                        <input type="text" name="subtitle" id="edit-subtitle" class="form-input">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Button Text</label>
                            <input type="text" name="button_text" id="edit-button-text" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Button Link</label>
                            <input type="url" name="button_link" id="edit-button-link" class="form-input">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Background Color</label>
                            <div class="color-input-wrap">
                                <input type="color" id="edit-bg-color-picker" onchange="document.getElementById('edit-bg-color').value = this.value">
                                <input type="text" id="edit-bg-color" name="background_color" class="form-input">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Text Color</label>
                            <div class="color-input-wrap">
                                <input type="color" id="edit-text-color-picker" onchange="document.getElementById('edit-text-color').value = this.value">
                                <input type="text" id="edit-text-color" name="text_color" class="form-input">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" name="is_active" id="edit-is-active" value="1">
                            <label for="edit-is-active" style="font-weight: 500; color: #374151;">Active (visible in store)</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
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
        
        function toggleMobileMenu() {
            document.getElementById('sidebar').classList.toggle('mobile-open');
        }
        
        // Restore sidebar state
        if (localStorage.getItem('sidebar-collapsed') === 'true') {
            document.getElementById('sidebar').classList.add('collapsed');
        }
        
        function openAddModal() {
            document.getElementById('add-modal').classList.add('active');
        }
        
        function closeAddModal() {
            document.getElementById('add-modal').classList.remove('active');
        }
        
        function openEditModal(banner) {
            const form = document.getElementById('edit-form');
            form.action = `/dashboard/store/banners/${banner.id}`;
            
            document.getElementById('edit-title').value = banner.title || '';
            document.getElementById('edit-subtitle').value = banner.subtitle || '';
            document.getElementById('edit-button-text').value = banner.button_text || '';
            document.getElementById('edit-button-link').value = banner.button_link || '';
            document.getElementById('edit-bg-color').value = banner.background_color || '#667eea';
            document.getElementById('edit-bg-color-picker').value = banner.background_color || '#667eea';
            document.getElementById('edit-text-color').value = banner.text_color || '#ffffff';
            document.getElementById('edit-text-color-picker').value = banner.text_color || '#ffffff';
            document.getElementById('edit-is-active').checked = banner.is_active;
            
            // Show current image if exists
            const preview = document.getElementById('edit-image-preview');
            const icon = document.getElementById('edit-upload-icon');
            const text = document.getElementById('edit-upload-text');
            
            if (banner.image_url) {
                preview.innerHTML = `<img src="${banner.image_url}" alt="Current banner">`;
                preview.style.display = 'block';
                icon.style.display = 'none';
                text.textContent = 'Click to change image';
            } else {
                preview.style.display = 'none';
                icon.style.display = 'block';
                text.textContent = 'Click to upload image';
            }
            
            document.getElementById('edit-modal').classList.add('active');
        }
        
        function closeEditModal() {
            document.getElementById('edit-modal').classList.remove('active');
        }
        
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                    preview.style.display = 'block';
                    // Hide the icon and update text
                    const parent = preview.parentElement;
                    const icon = parent.querySelector('i');
                    const text = parent.querySelector('p');
                    if (icon) icon.style.display = 'none';
                    if (text) text.textContent = 'Click to change image';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Close modals on escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddModal();
                closeEditModal();
            }
        });
        
        // Close modals on outside click
        document.getElementById('add-modal').addEventListener('click', function(e) {
            if (e.target === this) closeAddModal();
        });
        document.getElementById('edit-modal').addEventListener('click', function(e) {
            if (e.target === this) closeEditModal();
        });
    </script>
</x-app-layout>
