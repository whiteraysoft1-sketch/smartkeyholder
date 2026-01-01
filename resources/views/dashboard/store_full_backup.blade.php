<x-app-layout>
    <style>
        :root {
            --primary-orange: #F97316;
            --primary-orange-light: #FFF7ED;
            --primary-orange-dark: #EA580C;
            --sidebar-width: 260px;
            --sidebar-collapsed: 80px;
        }
        
        /* Main Layout */
        .store-dashboard {
            display: flex;
            min-height: 100vh;
            background: #F8FAFC;
        }
        
        /* Left Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: white;
            border-right: 1px solid #E5E7EB;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 50;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }
        .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid #E5E7EB;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-orange), #FB923C);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
            flex-shrink: 0;
        }
        .sidebar-brand {
            font-size: 18px;
            font-weight: 700;
            color: #1F2937;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar.collapsed .sidebar-brand,
        .sidebar.collapsed .nav-text,
        .sidebar.collapsed .sidebar-footer-text,
        .sidebar.collapsed .nav-section-title {
            display: none;
        }
        .sidebar.collapsed .sidebar-header {
            justify-content: center;
            padding: 24px 16px;
        }
        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 14px;
        }
        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }
        
        /* Navigation */
        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }
        .nav-section {
            margin-bottom: 8px;
        }
        .nav-section-title {
            font-size: 11px;
            font-weight: 600;
            color: #9CA3AF;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 16px 8px;
        }
        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            margin: 4px 0;
            border-radius: 10px;
            color: #4B5563;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .nav-link:hover {
            background: #F3F4F6;
            color: #1F2937;
        }
        .nav-link.active {
            background: var(--primary-orange);
            color: white;
        }
        .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 12px;
            font-size: 16px;
        }
        
        /* Sidebar Footer */
        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid #E5E7EB;
        }
        .sidebar-toggle-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            background: #F3F4F6;
            color: #6B7280;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }
        .sidebar-toggle-btn:hover {
            background: #E5E7EB;
        }
        .sidebar.collapsed .sidebar-toggle-btn i {
            transform: rotate(180deg);
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }
        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed);
        }
        
        /* Top Header */
        .top-header {
            background: white;
            padding: 16px 32px;
            border-bottom: 1px solid #E5E7EB;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
        }
        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #1F2937;
        }
        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .header-btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            border: none;
            text-decoration: none;
        }
        .header-btn-primary {
            background: var(--primary-orange);
            color: white;
        }
        .header-btn-primary:hover {
            background: var(--primary-orange-dark);
        }
        .header-btn-secondary {
            background: #F3F4F6;
            color: #4B5563;
        }
        .header-btn-secondary:hover {
            background: #E5E7EB;
        }
        
        /* Content Area */
        .content-area {
            padding: 24px 32px;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }
        .stat-card-new {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #E5E7EB;
            transition: all 0.2s ease;
        }
        .stat-card-new:hover {
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }
        .stat-card-new.highlight {
            background: linear-gradient(135deg, var(--primary-orange), #FB923C);
            border: none;
            color: white;
        }
        .stat-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        .stat-title {
            font-size: 14px;
            color: #6B7280;
            font-weight: 500;
        }
        .stat-card-new.highlight .stat-title {
            color: rgba(255,255,255,0.9);
        }
        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .stat-icon.orange { background: var(--primary-orange-light); color: var(--primary-orange); }
        .stat-icon.blue { background: #EFF6FF; color: #3B82F6; }
        .stat-icon.green { background: #ECFDF5; color: #10B981; }
        .stat-icon.purple { background: #F5F3FF; color: #8B5CF6; }
        .stat-card-new.highlight .stat-icon {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #1F2937;
            line-height: 1;
        }
        .stat-card-new.highlight .stat-value {
            color: white;
        }
        .stat-change {
            display: inline-flex;
            align-items: center;
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
            padding: 4px 8px;
            border-radius: 6px;
        }
        .stat-change.positive { background: #ECFDF5; color: #10B981; }
        .stat-change.negative { background: #FEF2F2; color: #EF4444; }
        .stat-card-new.highlight .stat-change {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        
        /* Section Cards */
        .section-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #E5E7EB;
            margin-bottom: 24px;
            overflow: hidden;
        }
        .section-header {
            padding: 20px 24px;
            border-bottom: 1px solid #E5E7EB;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: background 0.2s ease;
        }
        .section-header:hover {
            background: #FAFAFA;
        }
        .section-title-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
        .section-icon.orange { background: var(--primary-orange-light); color: var(--primary-orange); }
        .section-icon.blue { background: #EFF6FF; color: #3B82F6; }
        .section-icon.green { background: #ECFDF5; color: #10B981; }
        .section-icon.purple { background: #F5F3FF; color: #8B5CF6; }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #1F2937;
        }
        .section-subtitle {
            font-size: 13px;
            color: #6B7280;
            margin-top: 2px;
        }
        .section-badge {
            background: var(--primary-orange-light);
            color: var(--primary-orange);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
        }
        .section-toggle {
            color: #9CA3AF;
            font-size: 16px;
            transition: transform 0.3s ease;
        }
        .section-toggle.rotated {
            transform: rotate(180deg);
        }
        .section-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .section-body.active {
            max-height: 5000px;
        }
        .section-body-inner {
            padding: 24px;
        }
        
        /* Form Styles */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .form-grid .full-width {
            grid-column: span 2;
        }
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #D1D5DB;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.2s ease;
            background: white;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }
        
        /* Buttons */
        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
        }
        .btn-primary {
            background: var(--primary-orange);
            color: white;
        }
        .btn-primary:hover {
            background: var(--primary-orange-dark);
            transform: translateY(-1px);
        }
        .btn-success {
            background: #10B981;
            color: white;
        }
        .btn-success:hover {
            background: #059669;
        }
        .btn-danger {
            background: #EF4444;
            color: white;
        }
        .btn-danger:hover {
            background: #DC2626;
        }
        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
        }
        .btn-block {
            width: 100%;
        }
        
        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        .item-card {
            background: white;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.2s ease;
        }
        .item-card:hover {
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            border-color: var(--primary-orange);
        }
        .item-card-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
            background: #F3F4F6;
        }
        .item-card-body {
            padding: 16px;
        }
        .item-card-title {
            font-size: 15px;
            font-weight: 600;
            color: #1F2937;
            margin-bottom: 4px;
        }
        .item-card-meta {
            font-size: 13px;
            color: #6B7280;
            margin-bottom: 12px;
        }
        .item-card-price {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-orange);
        }
        .item-card-actions {
            display: flex;
            gap: 8px;
            padding-top: 12px;
            border-top: 1px solid #E5E7EB;
            margin-top: 12px;
        }
        
        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-badge.active { background: #ECFDF5; color: #10B981; }
        .status-badge.inactive { background: #FEF2F2; color: #EF4444; }
        .status-badge.featured { background: #FEF3C7; color: #D97706; }
        
        /* Two Column Layout */
        .two-column {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
        
        /* Checkbox */
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }
        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        .checkbox-item input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--primary-orange);
        }

        /* Color Picker */
        .color-picker-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }
        .color-picker-item input[type="color"] {
            width: 100%;
            height: 40px;
            border: 2px solid #E5E7EB;
            border-radius: 8px;
            cursor: pointer;
            padding: 2px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: #6B7280;
        }
        .empty-state-icon {
            font-size: 48px;
            color: #D1D5DB;
            margin-bottom: 16px;
        }
        
        /* Alert Messages */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .alert-success {
            background: #ECFDF5;
            border-left: 4px solid #10B981;
            color: #065F46;
        }
        .alert-error {
            background: #FEF2F2;
            border-left: 4px solid #EF4444;
            color: #991B1B;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .form-grid { grid-template-columns: 1fr; }
            .form-grid .full-width { grid-column: span 1; }
            .two-column { grid-template-columns: 1fr; }
            .color-picker-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0 !important;
            }
            .stats-grid { grid-template-columns: 1fr; }
            .content-area { padding: 16px; }
            .top-header { padding: 16px; }
            .cards-grid { grid-template-columns: 1fr; }
            .mobile-menu-btn { display: flex !important; }
        }
        .mobile-menu-btn { display: none; }
    </style>

    <div class="store-dashboard">
        <!-- Left Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-store"></i>
                </div>
                <span class="sidebar-brand">{{ $profile->store_name ?: 'My Store' }}</span>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Main</div>
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="fas fa-th-large"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                    <a href="#" class="nav-link active" onclick="scrollToSection('stats'); return false;">
                        <i class="fas fa-chart-bar"></i>
                        <span class="nav-text">Overview</span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Store</div>
                    <a href="#" class="nav-link" onclick="scrollToSection('products'); return false;">
                        <i class="fas fa-box"></i>
                        <span class="nav-text">Products</span>
                    </a>
                    <a href="#" class="nav-link" onclick="scrollToSection('categories'); return false;">
                        <i class="fas fa-layer-group"></i>
                        <span class="nav-text">Categories</span>
                    </a>
                    <a href="#" class="nav-link" onclick="scrollToSection('orders'); return false;">
                        <i class="fas fa-receipt"></i>
                        <span class="nav-text">Orders</span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Management</div>
                    <a href="#" class="nav-link" onclick="scrollToSection('quickActions'); return false;">
                        <i class="fas fa-plus-circle"></i>
                        <span class="nav-text">Quick Add</span>
                    </a>
                    <a href="#" class="nav-link" onclick="scrollToSection('settings'); return false;">
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
            <!-- Top Header -->
            <header class="top-header">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <button class="header-btn header-btn-secondary mobile-menu-btn" onclick="toggleMobileSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title">Store Management</h1>
                </div>
                <div class="header-actions">
                    <a href="{{ route('store.show', $user->qrCode->uuid) }}" target="_blank" class="header-btn header-btn-primary">
                        <i class="fas fa-external-link-alt"></i>
                        <span class="hidden sm:inline">View Store</span>
                    </a>
                    <a href="{{ route('dashboard') }}" class="header-btn header-btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Success/Error Messages -->
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

                <!-- Stats Cards -->
                <div class="stats-grid" id="stats-section">
                    <div class="stat-card-new highlight">
                        <div class="stat-header">
                            <span class="stat-title">Total Products</span>
                            <div class="stat-icon"><i class="fas fa-box"></i></div>
                        </div>
                        <div class="stat-value">{{ $products->count() }}</div>
                        <span class="stat-change positive">
                            <i class="fas fa-check" style="margin-right: 4px;"></i> Active Store
                        </span>
                    </div>
                    
                    <div class="stat-card-new">
                        <div class="stat-header">
                            <span class="stat-title">Categories</span>
                            <div class="stat-icon blue"><i class="fas fa-layer-group"></i></div>
                        </div>
                        <div class="stat-value">{{ $categories->count() }}</div>
                        <span class="stat-change positive">
                            <i class="fas fa-folder" style="margin-right: 4px;"></i> Organized
                        </span>
                    </div>
                    
                    <div class="stat-card-new">
                        <div class="stat-header">
                            <span class="stat-title">Pending Orders</span>
                            <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
                        </div>
                        <div class="stat-value">{{ $orders->where('status', 'pending')->count() }}</div>
                        <span class="stat-change {{ $orders->where('status', 'pending')->count() > 0 ? 'negative' : 'positive' }}">
                            <i class="fas fa-hourglass-half" style="margin-right: 4px;"></i> Awaiting
                        </span>
                    </div>
                    
                    <div class="stat-card-new">
                        <div class="stat-header">
                            <span class="stat-title">Total Orders</span>
                            <div class="stat-icon purple"><i class="fas fa-shopping-cart"></i></div>
                        </div>
                        <div class="stat-value">{{ $orders->count() }}</div>
                        <span class="stat-change positive">
                            <i class="fas fa-chart-line" style="margin-right: 4px;"></i> All Time
                        </span>
                    </div>
                </div>

                <!-- Store Settings Section -->
                <div class="section-card" id="settings-section">
                    <div class="section-header" onclick="toggleSection('settings')">
                        <div class="section-title-group">
                            <div class="section-icon orange"><i class="fas fa-cog"></i></div>
                            <div>
                                <div class="section-title">Store Settings</div>
                                <div class="section-subtitle">Configure your store appearance and preferences</div>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down section-toggle" id="icon-settings"></i>
                    </div>
                    <div class="section-body active" id="content-settings">
                        <div class="section-body-inner">
                            <form action="{{ route('dashboard.store-settings.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-grid">
                                    <!-- Store Logo -->
                                    <div class="full-width">
                                        <label class="form-label">Store Logo</label>
                                        <div style="display: flex; align-items: center; gap: 16px;">
                                            @if($profile->store_logo)
                                                <img src="{{ Storage::disk('public')->url($profile->store_logo) }}" alt="Logo" style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover; border: 2px solid #E5E7EB;">
                                            @else
                                                <div style="width: 80px; height: 80px; border-radius: 12px; background: #F3F4F6; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-image" style="font-size: 24px; color: #9CA3AF;"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <input type="file" name="store_logo" accept="image/*" class="form-input" style="padding: 8px;">
                                                <p style="font-size: 12px; color: #6B7280; margin-top: 4px;">Recommended: 200x200px, Max 2MB</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="form-label">Store Name</label>
                                        <input type="text" name="store_name" value="{{ $profile->store_name ?? '' }}" class="form-input" placeholder="Your store name">
                                    </div>

                                    <div>
                                        <label class="form-label">WhatsApp Number</label>
                                        <input type="text" name="store_whatsapp" value="{{ $profile->store_whatsapp ?? $profile->phone }}" class="form-input" placeholder="+1234567890">
                                    </div>

                                    <div class="full-width">
                                        <label class="form-label">Store Description</label>
                                        <textarea name="store_description" rows="2" class="form-input" placeholder="Describe your store...">{{ $profile->store_description ?? '' }}</textarea>
                                    </div>

                                    <div class="full-width">
                                        <label class="form-label">Store Address</label>
                                        <input type="text" name="store_address" value="{{ $profile->store_address ?? '' }}" class="form-input" placeholder="Your store address">
                                    </div>

                                    <div>
                                        <label class="form-label">Store Theme</label>
                                        <select name="store_theme" class="form-input">
                                            <option value="default" {{ ($profile->store_theme ?? 'default') === 'default' ? 'selected' : '' }}>Default (Blue)</option>
                                            <option value="modern" {{ ($profile->store_theme ?? '') === 'modern' ? 'selected' : '' }}>Modern (Purple)</option>
                                            <option value="minimal" {{ ($profile->store_theme ?? '') === 'minimal' ? 'selected' : '' }}>Minimal (Gray)</option>
                                            <option value="vibrant" {{ ($profile->store_theme ?? '') === 'vibrant' ? 'selected' : '' }}>Vibrant (Orange)</option>
                                            <option value="dark" {{ ($profile->store_theme ?? '') === 'dark' ? 'selected' : '' }}>Dark (Black)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="form-label">Currency</label>
                                        <select name="currency" class="form-input">
                                            @foreach(['USD' => 'USD ($)', 'EUR' => 'EUR (€)', 'GBP' => 'GBP (£)', 'JPY' => 'JPY (¥)', 'CAD' => 'CAD (C$)', 'AUD' => 'AUD (A$)', 'CHF' => 'CHF', 'CNY' => 'CNY (¥)', 'INR' => 'INR (₹)', 'NGN' => 'NGN (₦)', 'ZAR' => 'ZAR (R)', 'KES' => 'KES (KSh)', 'GHS' => 'GHS (₵)', 'UGX' => 'UGX (USh)'] as $code => $label)
                                                <option value="{{ $code }}" {{ ($profile->currency ?? 'USD') === $code ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Color Customization -->
                                    <div class="full-width" style="border-top: 1px solid #E5E7EB; padding-top: 20px; margin-top: 8px;">
                                        <label class="form-label">🎨 Color Customization</label>
                                        <div class="color-picker-grid">
                                            <div class="color-picker-item">
                                                <label style="font-size: 12px; color: #6B7280; display: block; margin-bottom: 4px;">Primary</label>
                                                <input type="color" name="store_primary_color" value="{{ $profile->store_primary_color ?? '#3B82F6' }}">
                                            </div>
                                            <div class="color-picker-item">
                                                <label style="font-size: 12px; color: #6B7280; display: block; margin-bottom: 4px;">Secondary</label>
                                                <input type="color" name="store_secondary_color" value="{{ $profile->store_secondary_color ?? '#10B981' }}">
                                            </div>
                                            <div class="color-picker-item">
                                                <label style="font-size: 12px; color: #6B7280; display: block; margin-bottom: 4px;">Text</label>
                                                <input type="color" name="store_text_color" value="{{ $profile->store_text_color ?? '#1F2937' }}">
                                            </div>
                                            <div class="color-picker-item">
                                                <label style="font-size: 12px; color: #6B7280; display: block; margin-bottom: 4px;">Background</label>
                                                <input type="color" name="store_background_color" value="{{ $profile->store_background_color ?? '#FFFFFF' }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="form-label">Minimum Order ({{ $profile->currency_symbol ?? '$' }})</label>
                                        <input type="number" name="minimum_order" value="{{ $profile->minimum_order ?? 0 }}" step="0.01" min="0" class="form-input">
                                    </div>

                                    <div>
                                        <label class="form-label">Delivery Fee ({{ $profile->currency_symbol ?? '$' }})</label>
                                        <input type="number" name="delivery_fee" value="{{ $profile->delivery_fee ?? 0 }}" step="0.01" min="0" class="form-input">
                                    </div>

                                    <div class="full-width">
                                        <label class="form-label">Options</label>
                                        <div class="checkbox-group">
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="store_enabled" value="1" {{ $profile->store_enabled ? 'checked' : '' }}>
                                                <span>Enable Store</span>
                                            </label>
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="delivery_available" value="1" {{ $profile->delivery_available ? 'checked' : '' }}>
                                                <span>Delivery Available</span>
                                            </label>
                                            <label class="checkbox-item">
                                                <input type="checkbox" name="pickup_available" value="1" {{ $profile->pickup_available ? 'checked' : '' }}>
                                                <span>Pickup Available</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div style="margin-top: 24px;">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Section -->
                <div class="section-card" id="quickActions-section">
                    <div class="section-header" onclick="toggleSection('quickActions')">
                        <div class="section-title-group">
                            <div class="section-icon green"><i class="fas fa-plus-circle"></i></div>
                            <div>
                                <div class="section-title">Quick Actions</div>
                                <div class="section-subtitle">Add new categories and products</div>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down section-toggle" id="icon-quickActions"></i>
                    </div>
                    <div class="section-body active" id="content-quickActions">
                        <div class="section-body-inner">
                            <div class="two-column">
                                <!-- Add Category -->
                                <div class="section-card" style="margin-bottom: 0;">
                                    <div style="padding: 20px; background: #ECFDF5; border-bottom: 1px solid #D1FAE5;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <i class="fas fa-folder-plus" style="color: #10B981; font-size: 20px;"></i>
                                            <div>
                                                <div style="font-weight: 600; color: #065F46;">Add Category</div>
                                                <div style="font-size: 13px; color: #047857;">Create a new product category</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="padding: 20px;">
                                        <form action="{{ route('dashboard.store.categories.add') }}" method="POST">
                                            @csrf
                                            <div style="display: flex; flex-direction: column; gap: 16px;">
                                                <div>
                                                    <label class="form-label">Category Name</label>
                                                    <input type="text" name="name" required placeholder="e.g., Electronics" class="form-input">
                                                </div>
                                                <div>
                                                    <label class="form-label">Description</label>
                                                    <input type="text" name="description" placeholder="Optional description" class="form-input">
                                                </div>
                                                <div>
                                                    <label class="form-label">Icon (emoji)</label>
                                                    <input type="text" name="icon" placeholder="🍕" class="form-input" style="font-size: 24px;">
                                                </div>
                                                <button type="submit" class="btn btn-success btn-block">
                                                    <i class="fas fa-plus"></i> Add Category
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Add Product -->
                                <div class="section-card" style="margin-bottom: 0;">
                                    <div style="padding: 20px; background: #EFF6FF; border-bottom: 1px solid #DBEAFE;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <i class="fas fa-plus-square" style="color: #3B82F6; font-size: 20px;"></i>
                                            <div>
                                                <div style="font-weight: 600; color: #1E40AF;">Add Product</div>
                                                <div style="font-size: 13px; color: #1D4ED8;">Add a new product to your store</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="padding: 20px;">
                                        <form action="{{ route('dashboard.store.products.add') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div style="display: flex; flex-direction: column; gap: 16px;">
                                                <div>
                                                    <label class="form-label">Product Name</label>
                                                    <input type="text" name="name" required placeholder="Product name" class="form-input">
                                                </div>
                                                <div>
                                                    <label class="form-label">Description</label>
                                                    <textarea name="description" rows="2" class="form-input" placeholder="Describe your product..."></textarea>
                                                </div>
                                                <div>
                                                    <label class="form-label">Category</label>
                                                    <select name="category_id" class="form-input">
                                                        <option value="">No Category</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                                                    <div>
                                                        <label class="form-label">Price ({{ $profile->currency_symbol ?? '$' }})</label>
                                                        <input type="number" name="price" step="0.01" min="0" required placeholder="0.00" class="form-input">
                                                    </div>
                                                    <div>
                                                        <label class="form-label">Original Price</label>
                                                        <input type="number" name="original_price" step="0.01" min="0" placeholder="Optional" class="form-input">
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="form-label">Product Image</label>
                                                    <input type="file" name="image" accept="image/*" class="form-input" style="padding: 8px;">
                                                </div>
                                                <div class="checkbox-group">
                                                    <input type="hidden" name="is_available" value="0">
                                                    <label class="checkbox-item">
                                                        <input type="checkbox" name="is_available" value="1" checked>
                                                        <span>Available</span>
                                                    </label>
                                                    <input type="hidden" name="is_featured" value="0">
                                                    <label class="checkbox-item">
                                                        <input type="checkbox" name="is_featured" value="1">
                                                        <span>Featured</span>
                                                    </label>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block">
                                                    <i class="fas fa-plus"></i> Add Product
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories Section -->
                <div class="section-card" id="categories-section">
                    <div class="section-header" onclick="toggleSection('categories')">
                        <div class="section-title-group">
                            <div class="section-icon purple"><i class="fas fa-layer-group"></i></div>
                            <div>
                                <div class="section-title">Categories <span class="section-badge">{{ $categories->count() }}</span></div>
                                <div class="section-subtitle">Manage your product categories</div>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down section-toggle" id="icon-categories"></i>
                    </div>
                    <div class="section-body active" id="content-categories">
                        <div class="section-body-inner">
                            @if($categories->count() > 0)
                                <div class="cards-grid">
                                    @foreach($categories as $category)
                                        <div class="item-card">
                                            <div class="item-card-body">
                                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                                    <div style="display: flex; align-items: center; gap: 12px;">
                                                        <span style="font-size: 32px;">{{ $category->icon }}</span>
                                                        <div>
                                                            <div class="item-card-title">{{ $category->name }}</div>
                                                            <div class="item-card-meta"><i class="fas fa-box" style="margin-right: 4px;"></i>{{ $category->products->count() }} products</div>
                                                        </div>
                                                    </div>
                                                    <span class="status-badge {{ $category->is_active ? 'active' : 'inactive' }}">
                                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </div>
                                                @if($category->description)
                                                    <p style="font-size: 13px; color: #6B7280; margin-bottom: 12px;">{{ $category->description }}</p>
                                                @endif
                                                <div class="item-card-actions">
                                                    <a href="{{ route('dashboard.store.categories.edit', $category) }}" class="btn btn-sm btn-primary" style="flex: 1;">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('dashboard.store.categories.delete', $category) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Delete this category?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger btn-block">
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
                                    <div class="empty-state-icon"><i class="fas fa-folder-open"></i></div>
                                    <div style="font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 8px;">No categories yet</div>
                                    <p>Create your first category using Quick Actions above</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="section-card" id="products-section">
                    <div class="section-header" onclick="toggleSection('products')">
                        <div class="section-title-group">
                            <div class="section-icon blue"><i class="fas fa-box"></i></div>
                            <div>
                                <div class="section-title">Products <span class="section-badge">{{ $products->count() }}</span></div>
                                <div class="section-subtitle">Manage your store inventory</div>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down section-toggle" id="icon-products"></i>
                    </div>
                    <div class="section-body active" id="content-products">
                        <div class="section-body-inner">
                            @if($products->count() > 0)
                                <div class="cards-grid">
                                    @foreach($products as $product)
                                        <div class="item-card">
                                            @if($product->image)
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="item-card-image">
                                            @else
                                                <div class="item-card-image" style="display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-image" style="font-size: 48px; color: #D1D5DB;"></i>
                                                </div>
                                            @endif
                                            <div class="item-card-body">
                                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                                                    <div>
                                                        <div class="item-card-title">{{ $product->name }}</div>
                                                        @if($product->category)
                                                            <div class="item-card-meta"><i class="fas fa-tag" style="margin-right: 4px;"></i>{{ $product->category->name }}</div>
                                                        @endif
                                                    </div>
                                                    @if($product->is_featured)
                                                        <span class="status-badge featured"><i class="fas fa-star" style="margin-right: 4px;"></i>Featured</span>
                                                    @endif
                                                </div>
                                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                                    <div>
                                                        <div class="item-card-price">{{ $product->formatted_price }}</div>
                                                        @if($product->is_on_sale)
                                                            <span style="font-size: 12px; color: #9CA3AF; text-decoration: line-through;">{{ $product->formatted_original_price }}</span>
                                                        @endif
                                                    </div>
                                                    <span class="status-badge {{ $product->is_available ? 'active' : 'inactive' }}">
                                                        {{ $product->is_available ? 'Available' : 'Unavailable' }}
                                                    </span>
                                                </div>
                                                <div class="item-card-actions">
                                                    <a href="{{ route('dashboard.store.products.edit', $product) }}" class="btn btn-sm btn-primary" style="flex: 1;">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('dashboard.store.products.delete', $product) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Delete this product?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger btn-block">
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
                                    <div class="empty-state-icon"><i class="fas fa-box-open"></i></div>
                                    <div style="font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 8px;">No products yet</div>
                                    <p>Add your first product using Quick Actions above</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Orders Section -->
                <div class="section-card" id="orders-section">
                    <div class="section-header" onclick="toggleSection('orders')">
                        <div class="section-title-group">
                            <div class="section-icon orange"><i class="fas fa-receipt"></i></div>
                            <div>
                                <div class="section-title">Recent Orders <span class="section-badge">{{ $recentOrders->count() }}</span></div>
                                <div class="section-subtitle">Latest customer orders</div>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down section-toggle" id="icon-orders"></i>
                    </div>
                    <div class="section-body active" id="content-orders">
                        <div class="section-body-inner">
                            @if($recentOrders->count() > 0)
                                <div class="cards-grid">
                                    @foreach($recentOrders as $order)
                                        <div class="item-card">
                                            <div class="item-card-body">
                                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                                                    <div>
                                                        <div class="item-card-title">Order #{{ $order->id }}</div>
                                                        <div class="item-card-meta">{{ $order->customer_name }}</div>
                                                    </div>
                                                    <span class="status-badge {{ $order->status === 'completed' ? 'active' : ($order->status === 'pending' ? 'featured' : 'inactive') }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </div>
                                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                                    <div class="item-card-price">{{ $profile->currency_symbol ?? '$' }}{{ number_format($order->total, 2) }}</div>
                                                    <div style="font-size: 12px; color: #6B7280;">{{ $order->created_at->diffForHumans() }}</div>
                                                </div>
                                                <form action="{{ route('dashboard.store.orders.update-status', $order) }}" method="POST" style="display: flex; gap: 8px;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" class="form-input" style="flex: 1; padding: 8px 12px;">
                                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                                        <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>🔄 Processing</option>
                                                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>📦 Shipped</option>
                                                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>🎉 Delivered</option>
                                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>✔️ Completed</option>
                                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state">
                                    <div class="empty-state-icon"><i class="fas fa-shopping-bag"></i></div>
                                    <div style="font-size: 16px; font-weight: 600; color: #374151; margin-bottom: 8px;">No orders yet</div>
                                    <p>Orders will appear here when customers place them</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
        }
        
        // Mobile sidebar toggle
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('mobile-open');
        }
        
        // Section toggle
        function toggleSection(sectionId) {
            const content = document.getElementById('content-' + sectionId);
            const icon = document.getElementById('icon-' + sectionId);
            
            content.classList.toggle('active');
            icon.classList.toggle('rotated');
            
            localStorage.setItem('section-' + sectionId, content.classList.contains('active') ? 'open' : 'closed');
        }
        
        // Scroll to section
        function scrollToSection(sectionId) {
            const section = document.getElementById(sectionId + '-section');
            if (section) {
                section.scrollIntoView({ behavior: 'smooth', block: 'start' });
                
                // Expand the section if collapsed
                const content = document.getElementById('content-' + sectionId);
                const icon = document.getElementById('icon-' + sectionId);
                if (content && !content.classList.contains('active')) {
                    content.classList.add('active');
                    if (icon) icon.classList.remove('rotated');
                }
            }
        }
        
        // Restore states on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Restore sidebar state
            const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
            if (isCollapsed) {
                document.getElementById('sidebar').classList.add('collapsed');
            }
            
            // Restore section states
            const sections = ['settings', 'quickActions', 'categories', 'products', 'orders'];
            sections.forEach(sectionId => {
                const state = localStorage.getItem('section-' + sectionId);
                if (state === 'closed') {
                    const content = document.getElementById('content-' + sectionId);
                    const icon = document.getElementById('icon-' + sectionId);
                    if (content) content.classList.remove('active');
                    if (icon) icon.classList.add('rotated');
                }
            });
            
            // Show mobile menu button on small screens
            if (window.innerWidth <= 768) {
                const mobileBtn = document.querySelector('.mobile-menu-btn');
                if (mobileBtn) mobileBtn.style.display = 'flex';
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            const mobileBtn = document.querySelector('.mobile-menu-btn');
            if (mobileBtn) {
                if (window.innerWidth <= 768) {
                    mobileBtn.style.display = 'flex';
                } else {
                    mobileBtn.style.display = 'none';
                    document.getElementById('sidebar').classList.remove('mobile-open');
                }
            }
        });
    </script>
</x-app-layout>
