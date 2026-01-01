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
        }
        .sidebar-brand {
            font-size: 20px;
            font-weight: 700;
            color: #1F2937;
        }
        .sidebar.collapsed .sidebar-brand,
        .sidebar.collapsed .nav-text,
        .sidebar.collapsed .sidebar-footer-text {
            display: none;
        }
        .sidebar.collapsed .sidebar-header {
            justify-content: center;
            padding: 24px 16px;
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
        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 14px;
        }
        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }
        .sidebar.collapsed .nav-section-title {
            display: none;
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
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }
        .sidebar.collapsed + .main-content {
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
        .stat-change.positive {
            background: #ECFDF5;
            color: #10B981;
        }
        .stat-change.negative {
            background: #FEF2F2;
            color: #EF4444;
        }
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
        .section-icon.red { background: #FEF2F2; color: #EF4444; }
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
        }
        .section-toggle {
            color: #9CA3AF;
            transition: transform 0.3s ease;
        }
        .section-toggle.rotated {
            transform: rotate(180deg);
        }
        .section-body {
            padding: 24px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1), padding 0.3s ease;
        }
        .section-body.active {
            max-height: 5000px;
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
        .form-group {
            margin-bottom: 0;
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
        .form-input::placeholder {
            color: #9CA3AF;
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
        .btn-secondary {
            background: #F3F4F6;
            color: #4B5563;
        }
        .btn-secondary:hover {
            background: #E5E7EB;
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
        .status-badge.active {
            background: #ECFDF5;
            color: #10B981;
        }
        .status-badge.inactive {
            background: #FEF2F2;
            color: #EF4444;
        }
        .status-badge.featured {
            background: #FEF3C7;
            color: #D97706;
        }
        
        /* Two Column Layout */
        .two-column {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .form-grid {
                grid-template-columns: 1fr;
            }
            .form-grid .full-width {
                grid-column: span 1;
            }
            .two-column {
                grid-template-columns: 1fr;
            }
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
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .content-area {
                padding: 16px;
            }
            .top-header {
                padding: 16px;
            }
            .cards-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Checkbox Styles */
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
        .color-picker-group {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }
        .color-picker-item {
            text-align: center;
        }
        .color-picker-item input[type="color"] {
            width: 60px;
            height: 40px;
            border: 2px solid #E5E7EB;
            border-radius: 8px;
            cursor: pointer;
        }
        .color-picker-label {
            font-size: 12px;
            color: #6B7280;
            margin-top: 6px;
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
        .empty-state-title {
            font-size: 16px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        
        /* File Upload */
        .file-upload {
            border: 2px dashed #D1D5DB;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .file-upload:hover {
            border-color: var(--primary-orange);
            background: var(--primary-orange-light);
        }
        .file-upload input {
            display: none;
        }
        .file-upload-icon {
            font-size: 32px;
            color: #9CA3AF;
            margin-bottom: 8px;
        }
        .file-upload-text {
            font-size: 14px;
            color: #6B7280;
        }
        
        /* Preview Image */
        .preview-image {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid #E5E7EB;
        }
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
                    <a href="#" class="nav-link" onclick="scrollToSection('recentOrders'); return false;">
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
                    <a href="#" class="nav-link" onclick="scrollToSection('storeSettings'); return false;">
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
        <main class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div>
                    <button class="header-btn header-btn-secondary" onclick="toggleMobileSidebar()" style="display: none;" id="mobileMenuBtn">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="page-title">Store Management</h1>
                </div>
                <div class="header-actions">
                    <a href="{{ route('store.show', $user->qrCode->uuid) }}" target="_blank" class="header-btn header-btn-primary">
                        <i class="fas fa-external-link-alt"></i>
                        View Store
                    </a>
                    <a href="{{ route('dashboard') }}" class="header-btn header-btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Back
                    </a>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div style="background: #ECFDF5; border-left: 4px solid #10B981; padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-check-circle" style="color: #10B981; font-size: 20px;"></i>
                        <span style="color: #065F46; font-weight: 500;">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div style="background: #FEF2F2; border-left: 4px solid #EF4444; padding: 16px; border-radius: 8px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-exclamation-circle" style="color: #EF4444; font-size: 20px;"></i>
                        <span style="color: #991B1B; font-weight: 500;">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Stats Cards -->
                <div class="stats-grid" id="stats-section">
                    <div class="stat-card-new highlight">
                        <div class="stat-header">
                            <span class="stat-title">Total Products</span>
                            <div class="stat-icon">
                                <i class="fas fa-box"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $products->count() }}</div>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up" style="margin-right: 4px;"></i>
                            Active Store
                        </span>
                    </div>
                    
                    <div class="stat-card-new">
                        <div class="stat-header">
                            <span class="stat-title">Categories</span>
                            <div class="stat-icon blue">
                                <i class="fas fa-layer-group"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $categories->count() }}</div>
                        <span class="stat-change positive">
                            <i class="fas fa-folder" style="margin-right: 4px;"></i>
                            Organized
                        </span>
                    </div>
                    
                    <div class="stat-card-new">
                        <div class="stat-header">
                            <span class="stat-title">Pending Orders</span>
                            <div class="stat-icon orange">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $orders->where('status', 'pending')->count() }}</div>
                        <span class="stat-change {{ $orders->where('status', 'pending')->count() > 0 ? 'negative' : 'positive' }}">
                            <i class="fas fa-hourglass-half" style="margin-right: 4px;"></i>
                            Awaiting
                        </span>
                    </div>
                    
                    <div class="stat-card-new">
                        <div class="stat-header">
                            <span class="stat-title">Total Orders</span>
                            <div class="stat-icon purple">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="stat-value">{{ $orders->count() }}</div>
                        <span class="stat-change positive">
                            <i class="fas fa-chart-line" style="margin-right: 4px;"></i>
                            All Time
                        </span>
                    </div>
                </div>
                                    <option value="ZAR" {{ ($profile->currency ?? '') === 'ZAR' ? 'selected' : '' }}>ZAR (R) - South African Rand</option>
                                    <option value="KES" {{ ($profile->currency ?? '') === 'KES' ? 'selected' : '' }}>KES (KSh) - Kenyan Shilling</option>
                                    <option value="GHS" {{ ($profile->currency ?? '') === 'GHS' ? 'selected' : '' }}>GHS (₵) - Ghanaian Cedi</option>
                                    <option value="UGX" {{ ($profile->currency ?? '') === 'UGX' ? 'selected' : '' }}>UGX (USh) - Ugandan Shilling</option>
                                </select>
                            </div>

                            <!-- Color Customization -->
                            <div class="md:col-span-2 border-t pt-4 mt-2">
                                <h4 class="text-sm font-semibold text-gray-700 mb-3">🎨 Color Customization</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Primary Color</label>
                                        <div class="flex items-center space-x-2">
                                            <input type="color" name="store_primary_color" value="{{ $profile->store_primary_color ?? '#3B82F6' }}" class="h-10 w-16 rounded border border-gray-300">
                                            <input type="text" value="{{ $profile->store_primary_color ?? '#3B82F6' }}" readonly class="flex-1 text-xs rounded border-gray-300">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Secondary Color</label>
                                        <div class="flex items-center space-x-2">
                                            <input type="color" name="store_secondary_color" value="{{ $profile->store_secondary_color ?? '#10B981' }}" class="h-10 w-16 rounded border border-gray-300">
                                            <input type="text" value="{{ $profile->store_secondary_color ?? '#10B981' }}" readonly class="flex-1 text-xs rounded border-gray-300">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Text Color</label>
                                        <div class="flex items-center space-x-2">
                                            <input type="color" name="store_text_color" value="{{ $profile->store_text_color ?? '#1F2937' }}" class="h-10 w-16 rounded border border-gray-300">
                                            <input type="text" value="{{ $profile->store_text_color ?? '#1F2937' }}" readonly class="flex-1 text-xs rounded border-gray-300">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Background Color</label>
                                        <div class="flex items-center space-x-2">
                                            <input type="color" name="store_background_color" value="{{ $profile->store_background_color ?? '#FFFFFF' }}" class="h-10 w-16 rounded border border-gray-300">
                                            <input type="text" value="{{ $profile->store_background_color ?? '#FFFFFF' }}" readonly class="flex-1 text-xs rounded border-gray-300">
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">💡 Tip: Choose colors that match your brand identity</p>
                                
                                <!-- Live Preview -->
                                <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-xs font-semibold text-gray-700 mb-3">Preview:</p>
                                    <div id="theme-preview" class="space-y-2">
                                        <div class="flex items-center space-x-2">
                                            <button type="button" id="preview-primary-btn" class="px-4 py-2 rounded-lg text-white font-semibold text-sm" style="background-color: {{ $profile->store_primary_color ?? '#3B82F6' }}">Primary Button</button>
                                            <button type="button" id="preview-secondary-btn" class="px-4 py-2 rounded-lg text-white font-semibold text-sm" style="background-color: {{ $profile->store_secondary_color ?? '#10B981' }}">Secondary Button</button>
                                        </div>
                                        <div id="preview-text" class="text-sm" style="color: {{ $profile->store_text_color ?? '#1F2937' }}">Sample text with your selected color</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delivery Settings -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Minimum Order ({{ $profile->currency_symbol ?? '$' }})</label>
                                <input type="number" name="minimum_order" value="{{ $profile->minimum_order ?? 0 }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Delivery Fee ({{ $profile->currency_symbol ?? '$' }})</label>
                                <input type="number" name="delivery_fee" value="{{ $profile->delivery_fee ?? 0 }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>

                            <!-- Options -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Options</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="store_enabled" value="1" {{ $profile->store_enabled ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        <span class="ml-2 text-sm text-gray-700">Enable Store</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="delivery_available" value="1" {{ $profile->delivery_available ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        <span class="ml-2 text-sm text-gray-700">Delivery Available</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="pickup_available" value="1" {{ $profile->pickup_available ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm">
                                        <span class="ml-2 text-sm text-gray-700">Pickup Available</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="submit" class="modern-button bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white">
                                <i class="fas fa-save mr-2"></i>
                                💾 Save Store Settings
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="modern-card mb-8 overflow-hidden" id="quickActions-section">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b border-gray-200 collapse-header" onclick="toggleSection('quickActions')" style="cursor: pointer;">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                <i class="fas fa-bolt mr-3 text-emerald-600"></i>
                                ⚡ Quick Actions
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">Add new categories and products quickly</p>
                        </div>
                        <div class="ml-4">
                            <i class="fas fa-chevron-down text-gray-600 text-2xl collapse-icon" id="icon-quickActions" style="display: inline-block;"></i>
                        </div>
                    </div>
                </div>
                <div class="collapsible-content active" id="content-quickActions">
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Add Category -->
                <div class="modern-card overflow-hidden">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-folder-plus mr-3 text-green-600"></i>
                            Add Category
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Create a new product category</p>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('dashboard.store.categories.add') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Category Name</label>
                                    <input type="text" name="name" required placeholder="e.g., Electronics" class="modern-input">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                    <input type="text" name="description" placeholder="Optional description" class="modern-input">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Icon (emoji or text)</label>
                                    <input type="text" name="icon" placeholder="🍕" class="modern-input text-2xl">
                                </div>
                                <button type="submit" class="modern-button bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white">
                                    <i class="fas fa-plus-circle mr-2"></i>
                                    Add Category
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Add Product -->
                <div class="modern-card overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center">
                            <i class="fas fa-plus-square mr-3 text-blue-600"></i>
                            Add Product
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Add a new product to your store</p>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('dashboard.store.products.add') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Product Name</label>
                                    <input type="text" name="name" required placeholder="Enter product name" class="modern-input">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                    <textarea name="description" rows="2" class="modern-input" placeholder="Describe your product..."></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                                    <select name="category_id" class="modern-input">
                                        <option value="">No Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Price ({{ $profile->currency_symbol ?? '$' }})</label>
                                        <input type="number" name="price" step="0.01" min="0" required placeholder="0.00" class="modern-input">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Original Price</label>
                                        <input type="number" name="original_price" step="0.01" min="0" placeholder="Optional" class="modern-input">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Product Image</label>
                                    <input type="file" name="image" accept="image/*" class="modern-input">
                                </div>
                                <div class="flex items-center space-x-6">
                                    <input type="hidden" name="is_available" value="0">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_available" value="1" checked class="rounded border-gray-300 text-blue-600 shadow-sm w-5 h-5">
                                        <span class="ml-2 text-sm font-medium text-gray-700">✅ Available</span>
                                    </label>
                                    <input type="hidden" name="is_featured" value="0">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-yellow-500 shadow-sm w-5 h-5">
                                        <span class="ml-2 text-sm font-medium text-gray-700">⭐ Featured</span>
                                    </label>
                                </div>
                                <button type="submit" class="modern-button bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white">
                                    <i class="fas fa-plus-circle mr-2"></i>
                                    Add Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="modern-card mb-8 overflow-hidden" id="categories-section">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200 collapse-header" onclick="toggleSection('categories')" style="cursor: pointer;">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                <i class="fas fa-layer-group mr-3 text-purple-600"></i>
                                Categories <span class="ml-2 bg-purple-200 text-purple-800 px-2 py-1 rounded-full text-xs font-bold">{{ $categories->count() }}</span>
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">Manage your product categories</p>
                        </div>
                        <div class="ml-4">
                            <i class="fas fa-chevron-down text-gray-600 text-2xl collapse-icon" id="icon-categories" style="display: inline-block;"></i>
                        </div>
                    </div>
                </div>
                <div class="collapsible-content active" id="content-categories">
                    <div class="p-6">
                    @if($categories->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($categories as $category)
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl p-5 hover:shadow-lg hover:border-purple-300 transition-all duration-200">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="text-3xl">{{ $category->icon }}</div>
                                            <div>
                                                <h4 class="font-bold text-gray-800">{{ $category->name }}</h4>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    <i class="fas fa-box mr-1"></i>
                                                    {{ $category->products->count() }} products
                                                </p>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $category->is_active ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-red-100 text-red-700 border border-red-300' }}">
                                            {{ $category->is_active ? '✓ Active' : '✗ Inactive' }}
                                        </span>
                                    </div>
                                    @if($category->description)
                                        <p class="text-sm text-gray-600 mb-3">{{ $category->description }}</p>
                                    @endif
                                    <div class="flex items-center gap-2 pt-3 border-t border-gray-300">
                                        <a href="{{ route('dashboard.store.categories.edit', $category) }}" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold rounded-lg transition-all">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <form action="{{ route('dashboard.store.categories.delete', $category) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition-all">
                                                <i class="fas fa-trash mr-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
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
            </div>

            <!-- Products -->
            <div class="modern-card mb-8 overflow-hidden" id="products-section">
                <div class="bg-gradient-to-r from-indigo-50 to-blue-50 px-6 py-4 border-b border-gray-200 collapse-header" onclick="toggleSection('products')" style="cursor: pointer;">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                <i class="fas fa-boxes mr-3 text-indigo-600"></i>
                                Products <span class="ml-2 bg-indigo-200 text-indigo-800 px-2 py-1 rounded-full text-xs font-bold">{{ $products->count() }}</span>
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">Manage your store inventory</p>
                        </div>
                        <div class="ml-4">
                            <i class="fas fa-chevron-down text-gray-600 text-2xl collapse-icon" id="icon-products" style="display: inline-block;"></i>
                        </div>
                    </div>
                </div>
                <div class="collapsible-content active" id="content-products">
                    <div class="p-6">
                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach($products as $product)
                                <div class="bg-white border-2 border-gray-200 rounded-xl overflow-hidden hover:shadow-xl hover:border-blue-300 transition-all duration-200 group">
                                    <div class="relative">
                                        @if($product->image)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-40 sm:h-48 object-cover group-hover:scale-105 transition-transform duration-200">
                                        @else
                                            <div class="w-full h-40 sm:h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                <i class="fas fa-image text-4xl text-gray-400"></i>
                                            </div>
                                        @endif
                                        @if($product->is_featured)
                                            <div class="absolute top-2 right-2 bg-yellow-400 text-yellow-900 px-2 py-1 rounded-full text-xs font-bold flex items-center shadow-lg">
                                                <i class="fas fa-star mr-1"></i> Featured
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h4 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2">{{ $product->name }}</h4>
                                        @if($product->category)
                                            <p class="text-xs text-gray-500 mb-2 flex items-center">
                                                <i class="fas fa-tag mr-1"></i>
                                                {{ $product->category->name }}
                                            </p>
                                        @endif
                                        <div class="flex items-center justify-between mb-3">
                                            <div class="flex flex-col">
                                                <span class="font-bold text-green-600 text-lg">{{ $product->formatted_price }}</span>
                                                @if($product->is_on_sale)
                                                    <span class="text-xs text-gray-500 line-through">{{ $product->formatted_original_price }}</span>
                                                @endif
                                            </div>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $product->is_available ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-red-100 text-red-700 border border-red-300' }}">
                                                {{ $product->is_available ? '✓ Available' : '✗ Unavailable' }}
                                            </span>
                                        </div>
                                        <div class="flex gap-2 pt-3 border-t border-gray-200">
                                            <a href="{{ route('dashboard.store.products.edit', $product) }}" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold rounded-lg transition-all">
                                                <i class="fas fa-edit mr-1"></i> Edit
                                            </a>
                                            <form action="{{ route('dashboard.store.products.delete', $product) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full inline-flex items-center justify-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-semibold rounded-lg transition-all">
                                                    <i class="fas fa-trash mr-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg font-medium">No products added yet</p>
                            <p class="text-gray-400 text-sm mt-2">Start adding products to your store!</p>
                        </div>
                    @endif
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="modern-card overflow-hidden" id="recentOrders-section">
                <div class="bg-gradient-to-r from-orange-50 to-amber-50 px-6 py-4 border-b border-gray-200 collapse-header" onclick="toggleSection('recentOrders')" style="cursor: pointer;">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                <i class="fas fa-receipt mr-3 text-orange-600"></i>
                                Recent Orders <span class="ml-2 bg-orange-200 text-orange-800 px-2 py-1 rounded-full text-xs font-bold">{{ $recentOrders->count() }}</span>
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">Latest customer orders</p>
                        </div>
                        <div class="ml-4">
                            <i class="fas fa-chevron-down text-gray-600 text-2xl collapse-icon" id="icon-recentOrders" style="display: inline-block;"></i>
                        </div>
                    </div>
                </div>
                <div class="collapsible-content active" id="content-recentOrders">
                    <div class="p-6">
                    @if($recentOrders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentOrders as $order)
                                <div class="bg-gradient-to-r from-gray-50 to-white border-2 border-gray-200 rounded-xl p-5 hover:shadow-lg hover:border-orange-300 transition-all duration-200">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <h4 class="font-bold text-gray-800 text-lg">Order #{{ $order->order_number }}</h4>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-700 border border-{{ $order->status_color }}-300">
                                                    {{ $order->status_label }}
                                                </span>
                                            </div>
                                            <div class="space-y-1">
                                                <p class="text-sm text-gray-700 flex items-center">
                                                    <i class="fas fa-user mr-2 text-gray-400"></i>
                                                    <span class="font-medium">{{ $order->customer_name }}</span>
                                                </p>
                                                <p class="text-sm text-gray-600 flex items-center">
                                                    <i class="fas fa-phone mr-2 text-gray-400"></i>
                                                    {{ $order->customer_phone }}
                                                </p>
                                                <p class="text-xs text-gray-500 flex items-center">
                                                    <i class="fas fa-clock mr-2 text-gray-400"></i>
                                                    {{ $order->created_at->format('M d, Y h:i A') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end gap-3">
                                            <p class="font-bold text-2xl text-green-600">{{ $order->formatted_total }}</p>
                                            <form action="{{ route('dashboard.store.orders.status', $order) }}" method="POST" class="w-full sm:w-auto">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()" class="w-full sm:w-auto px-3 py-2 text-sm font-medium border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                                    <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                                                    <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>👨‍🍳 Preparing</option>
                                                    <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>📦 Ready</option>
                                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>🚚 Delivered</option>
                                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                                </select>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-gray-200 flex flex-wrap items-center gap-4 text-sm">
                                        <span class="text-gray-600 flex items-center">
                                            <i class="fas fa-box mr-2 text-gray-400"></i>
                                            <strong class="text-gray-800">{{ $order->total_items }}</strong>&nbsp;items
                                        </span>
                                        @if($order->notes)
                                            <span class="text-gray-600 flex items-center flex-1">
                                                <i class="fas fa-comment mr-2 text-gray-400"></i>
                                                <span class="italic">{{ Str::limit($order->notes, 50) }}</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-shopping-bag text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg font-medium">No orders yet</p>
                            <p class="text-gray-400 text-sm mt-2">Orders will appear here when customers place them</p>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarNav');
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('sidebar-collapsed', sidebar.classList.contains('collapsed'));
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
        
        // Restore sidebar state
        document.addEventListener('DOMContentLoaded', function() {
            const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
            if (isCollapsed) {
                document.getElementById('sidebarNav').classList.add('collapsed');
            }
        });

        // Collapsible section toggle
        function toggleSection(sectionId) {
            const content = document.getElementById('content-' + sectionId);
            const icon = document.getElementById('icon-' + sectionId);
            
            content.classList.toggle('active');
            icon.classList.toggle('rotated');
            
            // Save state to localStorage
            const isActive = content.classList.contains('active');
            localStorage.setItem('collapse-' + sectionId, isActive ? 'open' : 'closed');
        }
        
        // Restore collapse states on page load
        document.addEventListener('DOMContentLoaded', function() {
            const sections = ['storeSettings', 'quickActions', 'categories', 'products', 'recentOrders'];
            sections.forEach(sectionId => {
                const state = localStorage.getItem('collapse-' + sectionId);
                if (state === 'closed') {
                    const content = document.getElementById('content-' + sectionId);
                    const icon = document.getElementById('icon-' + sectionId);
                    content.classList.remove('active');
                    icon.classList.add('rotated');
                }
            });
        });
        
        // Color picker synchronization and live preview
        document.addEventListener('DOMContentLoaded', function() {
            const colorInputs = document.querySelectorAll('input[type="color"]');
            
            colorInputs.forEach(colorInput => {
                const textInput = colorInput.parentElement.querySelector('input[type="text"]');
                
                if (textInput) {
                    // Update text input when color picker changes
                    colorInput.addEventListener('input', function() {
                        textInput.value = this.value.toUpperCase();
                        updatePreview();
                    });
                }
            });
            
            // Update live preview
            function updatePreview() {
                const primaryColor = document.querySelector('input[name="store_primary_color"]').value;
                const secondaryColor = document.querySelector('input[name="store_secondary_color"]').value;
                const textColor = document.querySelector('input[name="store_text_color"]').value;
                
                document.getElementById('preview-primary-btn').style.backgroundColor = primaryColor;
                document.getElementById('preview-secondary-btn').style.backgroundColor = secondaryColor;
                document.getElementById('preview-text').style.color = textColor;
            }
        });
    </script>
</x-app-layout>
