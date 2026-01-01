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
            background: white;
            border-bottom: 1px solid #F0F0F0;
            position: sticky; top: 0; z-index: 40;
            padding: 16px 32px;
        }
        .top-header-secondary {
            display: flex; align-items: center; gap: 16px;
            justify-content: space-between;
        }
        .page-title { font-size: 20px; font-weight: 600; color: #111827; margin: 0; }
        .page-title { font-size: 20px; font-weight: 600; color: #111827; margin: 0; }
        .user-menu {
            display: flex; align-items: center; gap: 12px;
            padding: 8px 16px 8px 8px;
            background: #F9FAFB;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid #E5E7EB;
            position: relative;
        }
        .user-menu:hover { background: #F3F4F6; }
        .user-dropdown {
            position: absolute;
            top: 60px;
            right: 32px;
            background: white;
            border: 1px solid #E5E7EB;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            min-width: 200px;
            display: none;
            z-index: 1000;
        }
        .user-dropdown.active { display: block; }
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 14px;
        }
        .dropdown-item:hover { background: #F9FAFB; }
        .dropdown-item i { width: 18px; text-align: center; color: #6B7280; }
        .dropdown-divider { height: 1px; background: #E5E7EB; margin: 4px 0; }
        .user-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-orange), #FB923C);
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 600; font-size: 14px;
        }
        .user-name { font-size: 14px; font-weight: 500; color: #374151; }
        .search-bar-wrapper {
            flex: 1;
            max-width: 600px;
            position: relative;
        }
        .search-bar {
            width: 100%;
            padding: 10px 16px 10px 42px;
            border: 1px solid #E5E7EB;
            border-radius: 10px;
            font-size: 14px;
            background: white;
            transition: all 0.2s;
        }
        .search-bar:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }
        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #9CA3AF;
            font-size: 16px;
        }
        .header-icon-btns {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .header-icon-btn {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: white;
            border: 1px solid #E5E7EB;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6B7280;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        .header-icon-btn:hover {
            background: #F9FAFB;
            color: var(--primary-orange);
        }
        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 18px;
            height: 18px;
            background: #EF4444;
            border-radius: 50%;
            color: white;
            font-size: 11px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }
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
        
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 32px; }
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #E5E7EB;
            transition: all 0.3s ease;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(0,0,0,0.08); }
        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; margin-bottom: 16px;
        }
        .stat-icon.orange { background: var(--primary-orange-light); color: var(--primary-orange); }
        .stat-icon.blue { background: #EBF5FF; color: #3B82F6; }
        .stat-icon.green { background: #ECFDF5; color: #10B981; }
        .stat-icon.purple { background: #F3E8FF; color: #8B5CF6; }
        .stat-value { font-size: 28px; font-weight: 700; color: #1F2937; margin-bottom: 4px; }
        .stat-label { font-size: 14px; color: #6B7280; }
        
        .quick-actions-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 32px; }
        .quick-action-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #E5E7EB;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
        }
        .quick-action-card:hover { transform: translateY(-4px); box-shadow: 0 12px 24px rgba(0,0,0,0.1); border-color: var(--primary-orange); }
        .quick-action-icon {
            width: 64px; height: 64px;
            margin: 0 auto 16px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px;
        }
        .quick-action-icon.products { background: linear-gradient(135deg, var(--primary-orange), #FB923C); color: white; }
        .quick-action-icon.categories { background: linear-gradient(135deg, #3B82F6, #60A5FA); color: white; }
        .quick-action-icon.orders { background: linear-gradient(135deg, #10B981, #34D399); color: white; }
        .quick-action-icon.settings { background: linear-gradient(135deg, #8B5CF6, #A78BFA); color: white; }
        .quick-action-title { font-size: 16px; font-weight: 600; color: #1F2937; margin-bottom: 4px; }
        .quick-action-desc { font-size: 13px; color: #6B7280; }
        
        .section-card { background: white; border-radius: 16px; border: 1px solid #E5E7EB; margin-bottom: 24px; overflow: hidden; }
        .section-header { padding: 20px 24px; border-bottom: 1px solid #E5E7EB; display: flex; align-items: center; justify-content: space-between; }
        .section-title { font-size: 18px; font-weight: 600; color: #1F2937; }
        .section-body { padding: 24px; }
        
        .recent-orders-table { width: 100%; border-collapse: collapse; }
        .recent-orders-table th { text-align: left; padding: 12px 16px; font-weight: 600; color: #374151; font-size: 13px; background: #F9FAFB; }
        .recent-orders-table td { padding: 16px; border-bottom: 1px solid #E5E7EB; color: #4B5563; font-size: 14px; }
        .recent-orders-table tr:last-child td { border-bottom: none; }
        
        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 12px; border-radius: 20px;
            font-size: 12px; font-weight: 500;
        }
        .status-pending { background: #FEF3C7; color: #D97706; }
        .status-confirmed { background: #DBEAFE; color: #2563EB; }
        .status-delivered { background: #ECFDF5; color: #10B981; }
        .status-cancelled { background: #FEE2E2; color: #DC2626; }
        
        .empty-state { text-align: center; padding: 40px 20px; color: #6B7280; }
        .empty-state i { font-size: 48px; color: #D1D5DB; margin-bottom: 12px; }
        
        .store-status { display: flex; align-items: center; gap: 8px; }
        .status-dot { width: 10px; height: 10px; border-radius: 50%; }
        .status-dot.active { background: #10B981; }
        .status-dot.inactive { background: #EF4444; }
        
        @media (max-width: 1200px) {
            .stats-grid, .quick-actions-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); }
            .main-content { margin-left: 0 !important; }
            .content-area { padding: 16px; }
            .top-header { padding: 16px; }
            .mobile-menu-btn { display: flex !important; }
            .stats-grid, .quick-actions-grid { grid-template-columns: 1fr; }
            .stat-card { padding: 16px; }
            .stat-value { font-size: 24px; }
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
                    <a href="{{ route('dashboard.store') }}" class="nav-link active">
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
                <div class="top-header-secondary">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <button class="header-icon-btn mobile-menu-btn" onclick="toggleMobileSidebar()">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 class="page-title">Dashboard</h1>
                    </div>
                    
                    <div class="search-bar-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-bar" placeholder="Search...">
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div class="header-icon-btns">
                            <button class="header-icon-btn" title="Notifications" onclick="alert('Notifications feature coming soon!')">
                                <i class="fas fa-bell"></i>
                                <span class="notification-badge">3</span>
                            </button>
                            <button class="header-icon-btn" title="Messages" onclick="alert('Messages feature coming soon!')">
                                <i class="fas fa-comment"></i>
                            </button>
                            <button class="header-icon-btn" title="Settings" onclick="window.location.href='{{ route('dashboard.store.settings') }}'">
                                <i class="fas fa-cog"></i>
                            </button>
                        </div>
                        
                        <div class="store-status">
                            <span class="status-dot {{ $profile->store_enabled ? 'active' : 'inactive' }}"></span>
                            <span style="font-size: 13px; color: {{ $profile->store_enabled ? '#10B981' : '#EF4444' }};">
                                {{ $profile->store_enabled ? 'Online' : 'Offline' }}
                            </span>
                        </div>

                        <div class="user-menu" onclick="toggleUserMenu()" id="userMenu">
                            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down" style="font-size: 12px; color: #9CA3AF;"></i>
                        </div>
                        <div class="user-dropdown" id="userDropdown">
                            <a href="{{ route('dashboard') }}" class="dropdown-item">
                                <i class="fas fa-th-large"></i>
                                <span>Main Dashboard</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <i class="fas fa-user"></i>
                                <span>Profile</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="dropdown-item" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
                <div class="header-actions">
                    @if($user->qrCode)
                        <a href="{{ route('store.show', $user->qrCode->uuid) }}" target="_blank" class="header-btn header-btn-primary">
                            <i class="fas fa-external-link-alt"></i>
                            <span>View Store</span>
                        </a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="header-btn header-btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </header>

            <div class="content-area">
                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon orange"><i class="fas fa-box"></i></div>
                        <div class="stat-value">{{ $products->count() }}</div>
                        <div class="stat-label">Total Products</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon blue"><i class="fas fa-layer-group"></i></div>
                        <div class="stat-value">{{ $categories->count() }}</div>
                        <div class="stat-label">Categories</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green"><i class="fas fa-shopping-cart"></i></div>
                        <div class="stat-value">{{ $orders->count() }}</div>
                        <div class="stat-label">Total Orders</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon purple"><i class="fas fa-clock"></i></div>
                        <div class="stat-value">{{ $orders->where('status', 'pending')->count() }}</div>
                        <div class="stat-label">Pending Orders</div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions-grid">
                    <a href="{{ route('dashboard.store.products.index') }}" class="quick-action-card">
                        <div class="quick-action-icon products"><i class="fas fa-box"></i></div>
                        <div class="quick-action-title">Products</div>
                        <div class="quick-action-desc">Manage your products</div>
                    </a>
                    <a href="{{ route('dashboard.store.categories.index') }}" class="quick-action-card">
                        <div class="quick-action-icon categories"><i class="fas fa-layer-group"></i></div>
                        <div class="quick-action-title">Categories</div>
                        <div class="quick-action-desc">Organize your catalog</div>
                    </a>
                    <a href="{{ route('dashboard.store.orders.index') }}" class="quick-action-card">
                        <div class="quick-action-icon orders"><i class="fas fa-receipt"></i></div>
                        <div class="quick-action-title">Orders</div>
                        <div class="quick-action-desc">View all orders</div>
                    </a>
                    <a href="{{ route('dashboard.store.settings') }}" class="quick-action-card">
                        <div class="quick-action-icon settings"><i class="fas fa-cog"></i></div>
                        <div class="quick-action-title">Settings</div>
                        <div class="quick-action-desc">Configure your store</div>
                    </a>
                </div>

                <!-- Recent Orders -->
                <div class="section-card">
                    <div class="section-header">
                        <h3 class="section-title">Recent Orders</h3>
                        <a href="{{ route('dashboard.store.orders.index') }}" class="header-btn header-btn-secondary" style="padding: 8px 16px; font-size: 13px;">
                            View All <i class="fas fa-arrow-right" style="margin-left: 4px;"></i>
                        </a>
                    </div>
                    <div class="section-body" style="padding: 0;">
                        @if($recentOrders->count() > 0)
                            <table class="recent-orders-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td style="font-weight: 600;">#{{ $order->order_number }}</td>
                                            <td>{{ $order->customer_name }}</td>
                                            <td style="font-weight: 600; color: var(--primary-orange);">{{ $profile->currency_symbol }}{{ number_format($order->total, 2) }}</td>
                                            <td>
                                                <span class="status-badge status-{{ $order->status }}">
                                                    <i class="fas fa-circle" style="font-size: 6px;"></i>
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $order->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>No orders yet. Share your store to start receiving orders!</p>
                            </div>
                        @endif
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
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('active');
        }
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const dropdown = document.getElementById('userDropdown');
            if (userMenu && dropdown && !userMenu.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('sidebar-collapsed') === 'true') {
                document.getElementById('sidebar').classList.add('collapsed');
            }
        });
    </script>
</x-app-layout>
