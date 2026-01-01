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
        
        .section-card { background: white; border-radius: 16px; border: 1px solid #E5E7EB; margin-bottom: 24px; overflow: hidden; }
        .section-header-static { padding: 20px 24px; border-bottom: 1px solid #E5E7EB; display: flex; align-items: center; gap: 12px; }
        .section-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 16px; }
        .section-icon.orange { background: var(--primary-orange-light); color: var(--primary-orange); }
        .section-title { font-size: 16px; font-weight: 600; color: #1F2937; }
        .section-subtitle { font-size: 13px; color: #6B7280; margin-top: 2px; }
        .section-body-inner { padding: 24px; }
        
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .form-grid .full-width { grid-column: span 2; }
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
        .btn-primary:hover { background: var(--primary-orange-dark); transform: translateY(-1px); }
        
        .checkbox-group { display: flex; flex-wrap: wrap; gap: 16px; }
        .checkbox-item { display: flex; align-items: center; gap: 8px; cursor: pointer; }
        .checkbox-item input[type="checkbox"] { width: 18px; height: 18px; accent-color: var(--primary-orange); }
        
        .color-picker-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
        .color-picker-item input[type="color"] { width: 100%; height: 40px; border: 2px solid #E5E7EB; border-radius: 8px; cursor: pointer; padding: 2px; }
        
        .alert { padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; }
        .alert-success { background: #ECFDF5; border-left: 4px solid #10B981; color: #065F46; }
        .alert-error { background: #FEF2F2; border-left: 4px solid #EF4444; color: #991B1B; }
        
        @media (max-width: 1024px) {
            .form-grid { grid-template-columns: 1fr; }
            .form-grid .full-width { grid-column: span 1; }
            .color-picker-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); }
            .main-content { margin-left: 0 !important; }
            .content-area { padding: 16px; }
            .top-header { padding: 16px; }
            .mobile-menu-btn { display: flex !important; }
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
                    <a href="{{ route('dashboard.store.settings') }}" class="nav-link active">
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
                    <h1 class="page-title">Store Settings</h1>
                </div>
                <div class="header-actions">
                    <a href="{{ route('store.show', $user->qrCode->uuid) }}" target="_blank" class="header-btn header-btn-primary">
                        <i class="fas fa-external-link-alt"></i>
                        <span class="hidden sm:inline">View Store</span>
                    </a>
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

                <div class="section-card">
                    <div class="section-header-static">
                        <div class="section-icon orange"><i class="fas fa-cog"></i></div>
                        <div>
                            <div class="section-title">Store Settings</div>
                            <div class="section-subtitle">Configure your store appearance and preferences</div>
                        </div>
                    </div>
                    <div class="section-body-inner">
                        <form action="{{ route('dashboard.store-settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-grid">
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

                                <div class="full-width" style="border-top: 1px solid #E5E7EB; padding-top: 20px; margin-top: 8px;">
                                    <label class="form-label">🖼️ Store Banner Sliders</label>
                                    <p style="font-size: 12px; color: #6B7280; margin-bottom: 12px;">Upload multiple images to create an attractive banner slider for your store homepage</p>
                                    
                                    <!-- Existing Sliders -->
                                    <div id="slidersContainer" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
                                        @foreach($user->storeBanners()->ordered()->get() as $banner)
                                            <div class="slider-item" data-banner-id="{{ $banner->id }}" style="position: relative; border: 2px solid #E5E7EB; border-radius: 12px; overflow: hidden; background: #F9FAFB;">
                                                <img src="{{ $banner->image_url }}" alt="Banner" style="width: 100%; height: 120px; object-fit: cover;">
                                                <div style="padding: 8px;">
                                                    <input type="text" name="existing_banner_titles[{{ $banner->id }}]" value="{{ $banner->title }}" placeholder="Slider title" class="form-input" style="font-size: 12px; padding: 6px 8px; margin-bottom: 4px;">
                                                    <div style="display: flex; gap: 4px;">
                                                        <button type="button" class="btn-remove-existing" data-banner-id="{{ $banner->id }}" style="flex: 1; padding: 4px 8px; background: #EF4444; color: white; border: none; border-radius: 6px; font-size: 11px; cursor: pointer;">
                                                            <i class="fas fa-trash"></i> Remove
                                                        </button>
                                                        <input type="checkbox" name="delete_banners[]" value="{{ $banner->id }}" style="display: none;" class="delete-banner-checkbox-{{ $banner->id }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <!-- New Sliders Upload -->
                                    <div id="newSlidersContainer" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-bottom: 12px;"></div>
                                    
                                    <!-- Add Slider Button -->
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <input type="file" id="sliderImageInput" accept="image/*" style="display: none;" multiple>
                                        <button type="button" onclick="document.getElementById('sliderImageInput').click()" class="btn-add-slider" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; background: var(--primary-orange); color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                                            <i class="fas fa-plus"></i> Add Slider Image
                                        </button>
                                        <span style="font-size: 12px; color: #6B7280;">Recommended: 800x400px, Max 2MB each</span>
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
                                    <label class="form-label">Featured Section Display</label>
                                    <select name="featured_products_type" class="form-input">
                                        <option value="top_selling" {{ ($profile->featured_products_type ?? 'top_selling') === 'top_selling' ? 'selected' : '' }}>Top Selling Products</option>
                                        <option value="trending" {{ ($profile->featured_products_type ?? 'top_selling') === 'trending' ? 'selected' : '' }}>Trending Products</option>
                                        <option value="featured" {{ ($profile->featured_products_type ?? 'top_selling') === 'featured' ? 'selected' : '' }}>Featured Products</option>
                                    </select>
                                    <small style="color: #6B7280; font-size: 12px; display: block; margin-top: 4px;">Choose what to display in the featured products section on your store</small>
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
        </main>
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
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('sidebar-collapsed') === 'true') {
                document.getElementById('sidebar').classList.add('collapsed');
            }
        });

        // Slider Image Management
        let sliderCount = 0;
        const sliderImageInput = document.getElementById('sliderImageInput');
        const newSlidersContainer = document.getElementById('newSlidersContainer');

        // Handle multiple file selection
        sliderImageInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            files.forEach(file => {
                if (file && file.type.startsWith('image/')) {
                    addSliderPreview(file);
                }
            });
            // Reset input to allow selecting same file again
            e.target.value = '';
        });

        function addSliderPreview(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const sliderId = `slider_${sliderCount++}`;
                
                const sliderDiv = document.createElement('div');
                sliderDiv.className = 'slider-preview';
                sliderDiv.id = sliderId;
                sliderDiv.style.cssText = 'position: relative; border: 2px solid #10B981; border-radius: 12px; overflow: hidden; background: #F9FAFB;';
                
                sliderDiv.innerHTML = `
                    <img src="${e.target.result}" alt="Slider Preview" style="width: 100%; height: 120px; object-fit: cover;">
                    <div style="padding: 8px;">
                        <input type="text" name="slider_titles[]" placeholder="Slider title (optional)" class="form-input" style="font-size: 12px; padding: 6px 8px; margin-bottom: 4px;">
                        <input type="text" name="slider_subtitles[]" placeholder="Subtitle (optional)" class="form-input" style="font-size: 11px; padding: 5px 8px; margin-bottom: 4px;">
                        <button type="button" onclick="removeSlider('${sliderId}')" style="width: 100%; padding: 4px 8px; background: #EF4444; color: white; border: none; border-radius: 6px; font-size: 11px; cursor: pointer;">
                            <i class="fas fa-times"></i> Remove
                        </button>
                    </div>
                    <input type="file" name="slider_images[]" style="display: none;" class="slider-file-input">
                `;
                
                newSlidersContainer.appendChild(sliderDiv);
                
                // Convert file to input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                sliderDiv.querySelector('.slider-file-input').files = dataTransfer.files;
            };
            reader.readAsDataURL(file);
        }

        function removeSlider(sliderId) {
            const sliderDiv = document.getElementById(sliderId);
            if (sliderDiv) {
                sliderDiv.remove();
            }
        }

        // Handle existing banner removal
        document.querySelectorAll('.btn-remove-existing').forEach(btn => {
            btn.addEventListener('click', function() {
                const bannerId = this.getAttribute('data-banner-id');
                const sliderItem = this.closest('.slider-item');
                
                if (confirm('Are you sure you want to remove this slider?')) {
                    // Mark for deletion
                    document.querySelector('.delete-banner-checkbox-' + bannerId).checked = true;
                    // Hide the item
                    sliderItem.style.opacity = '0.5';
                    sliderItem.style.pointerEvents = 'none';
                    this.innerHTML = '<i class="fas fa-undo"></i> Undo';
                    this.style.background = '#6B7280';
                    this.onclick = function() {
                        document.querySelector('.delete-banner-checkbox-' + bannerId).checked = false;
                        sliderItem.style.opacity = '1';
                        sliderItem.style.pointerEvents = 'auto';
                        this.innerHTML = '<i class="fas fa-trash"></i> Remove';
                        this.style.background = '#EF4444';
                        this.onclick = null;
                        // Re-attach event listener
                        document.querySelectorAll('.btn-remove-existing').forEach(btn => {
                            if (btn.getAttribute('data-banner-id') === bannerId) {
                                btn.addEventListener('click', arguments.callee);
                            }
                        });
                    };
                }
            });
        });
    </script>
</x-app-layout>
