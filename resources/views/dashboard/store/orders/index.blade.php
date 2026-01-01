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
        
        .orders-table-wrapper { background: white; border-radius: 16px; border: 1px solid #E5E7EB; overflow: hidden; }
        .orders-table { width: 100%; border-collapse: collapse; }
        .orders-table th { background: #F9FAFB; padding: 14px 16px; text-align: left; font-weight: 600; color: #374151; font-size: 13px; border-bottom: 1px solid #E5E7EB; }
        .orders-table td { padding: 16px; border-bottom: 1px solid #E5E7EB; color: #4B5563; font-size: 14px; }
        .orders-table tr:last-child td { border-bottom: none; }
        .orders-table tr:hover { background: #F9FAFB; }
        
        .order-id { font-weight: 600; color: #1F2937; }
        .order-customer { display: flex; flex-direction: column; }
        .customer-name { font-weight: 500; color: #1F2937; }
        .customer-phone { font-size: 12px; color: #6B7280; }
        .order-total { font-weight: 600; color: var(--primary-orange); }
        
        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 12px; border-radius: 20px;
            font-size: 12px; font-weight: 500;
        }
        .status-pending { background: #FEF3C7; color: #D97706; }
        .status-confirmed { background: #DBEAFE; color: #2563EB; }
        .status-preparing { background: #E0E7FF; color: #4F46E5; }
        .status-ready { background: #D1FAE5; color: #059669; }
        .status-delivered { background: #ECFDF5; color: #10B981; }
        .status-cancelled { background: #FEE2E2; color: #DC2626; }
        
        .order-actions { display: flex; gap: 8px; }
        .order-action-btn {
            padding: 8px 12px; border-radius: 8px;
            font-size: 12px; font-weight: 500;
            cursor: pointer; transition: all 0.2s ease;
            border: none;
        }
        .btn-view { background: #F3F4F6; color: #4B5563; }
        .btn-view:hover { background: #E5E7EB; }
        .btn-status { background: var(--primary-orange-light); color: var(--primary-orange); }
        .btn-status:hover { background: #FFEDD5; }
        
        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-state i { font-size: 64px; color: #D1D5DB; margin-bottom: 16px; }
        .empty-state h3 { font-size: 18px; font-weight: 600; color: #6B7280; margin-bottom: 8px; }
        .empty-state p { font-size: 14px; color: #9CA3AF; }
        
        .alert { padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; }
        .alert-success { background: #ECFDF5; border-left: 4px solid #10B981; color: #065F46; }
        
        .filter-bar { display: flex; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
        .filter-item { display: flex; flex-direction: column; gap: 4px; }
        .filter-label { font-size: 12px; font-weight: 500; color: #6B7280; }
        .form-input {
            padding: 10px 14px;
            border: 1px solid #D1D5DB; border-radius: 8px;
            font-size: 14px; transition: all 0.2s ease; background: white;
        }
        .form-input:focus { outline: none; border-color: var(--primary-orange); }
        
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
        
        .order-detail-section { margin-bottom: 20px; }
        .order-detail-title { font-weight: 600; color: #374151; margin-bottom: 12px; font-size: 14px; }
        .order-detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #F3F4F6; }
        .order-detail-row:last-child { border-bottom: none; }
        
        .order-items-list { background: #F9FAFB; border-radius: 12px; padding: 16px; }
        .order-item { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; }
        .order-item-name { font-weight: 500; color: #1F2937; }
        .order-item-qty { color: #6B7280; font-size: 13px; }
        .order-item-price { font-weight: 600; color: var(--primary-orange); }
        
        .status-select { padding: 10px 16px; border-radius: 8px; border: 1px solid #D1D5DB; font-size: 14px; width: 100%; }
        
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
        
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); }
            .main-content { margin-left: 0 !important; }
            .content-area { padding: 16px; }
            .top-header { padding: 16px; }
            .mobile-menu-btn { display: flex !important; }
            .orders-table { display: block; overflow-x: auto; }
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
                    <a href="{{ route('dashboard.store.products.index') }}" class="nav-link">
                        <i class="fas fa-box"></i>
                        <span class="nav-text">Products</span>
                    </a>
                    <a href="{{ route('dashboard.store.categories.index') }}" class="nav-link">
                        <i class="fas fa-layer-group"></i>
                        <span class="nav-text">Categories</span>
                    </a>
                    <a href="{{ route('dashboard.store.orders.index') }}" class="nav-link active">
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
                    <h1 class="page-title">Orders</h1>
                </div>
                <div class="header-actions">
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

                <div class="filter-bar">
                    <div class="filter-item">
                        <span class="filter-label">Status</span>
                        <select id="statusFilter" class="form-input" onchange="filterOrders()">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="preparing">Preparing</option>
                            <option value="ready">Ready</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <span class="filter-label">Date</span>
                        <input type="date" id="dateFilter" class="form-input" onchange="filterOrders()">
                    </div>
                </div>

                @if($orders->count() > 0)
                    <div class="orders-table-wrapper">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="ordersBody">
                                @foreach($orders as $order)
                                    <tr class="order-row" data-status="{{ $order->status }}" data-date="{{ $order->created_at->format('Y-m-d') }}">
                                        <td><span class="order-id">#{{ $order->order_number }}</span></td>
                                        <td>
                                            <div class="order-customer">
                                                <span class="customer-name">{{ $order->customer_name }}</span>
                                                <span class="customer-phone">{{ $order->customer_phone }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $order->items->count() }} items</td>
                                        <td><span class="order-total">{{ $currencySymbol }}{{ number_format($order->total, 2) }}</span></td>
                                        <td>
                                            <span class="status-badge status-{{ $order->status }}">
                                                <i class="fas fa-circle" style="font-size: 6px;"></i>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <div class="order-actions">
                                                <button class="order-action-btn btn-view" onclick='openOrderModal(@json($order->load("items.product")))'>
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="order-action-btn btn-status" onclick="openStatusModal({{ $order->id }}, '{{ $order->status }}')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-receipt"></i>
                        <h3>No orders yet</h3>
                        <p>Orders from your customers will appear here.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Order Details Modal -->
    <div class="modal-overlay" id="orderModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Order Details</h3>
                <button class="modal-close" onclick="closeOrderModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="order-detail-section">
                    <div class="order-detail-title">Order Information</div>
                    <div class="order-detail-row">
                        <span>Order Number</span>
                        <span id="modalOrderNumber" style="font-weight: 600;"></span>
                    </div>
                    <div class="order-detail-row">
                        <span>Status</span>
                        <span id="modalStatus"></span>
                    </div>
                    <div class="order-detail-row">
                        <span>Order Date</span>
                        <span id="modalDate"></span>
                    </div>
                    <div class="order-detail-row">
                        <span>Delivery Type</span>
                        <span id="modalDeliveryType"></span>
                    </div>
                </div>
                
                <div class="order-detail-section">
                    <div class="order-detail-title">Customer</div>
                    <div class="order-detail-row">
                        <span>Name</span>
                        <span id="modalCustomerName"></span>
                    </div>
                    <div class="order-detail-row">
                        <span>Phone</span>
                        <span id="modalCustomerPhone"></span>
                    </div>
                    <div class="order-detail-row">
                        <span>Address</span>
                        <span id="modalAddress"></span>
                    </div>
                </div>
                
                <div class="order-detail-section">
                    <div class="order-detail-title">Items</div>
                    <div class="order-items-list" id="modalItems"></div>
                </div>
                
                <div class="order-detail-section">
                    <div class="order-detail-row" style="font-size: 16px;">
                        <span style="font-weight: 600;">Total</span>
                        <span id="modalTotal" style="font-weight: 700; color: var(--primary-orange);"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeOrderModal()">Close</button>
            </div>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div class="modal-overlay" id="statusModal">
        <div class="modal-content" style="max-width: 400px;">
            <div class="modal-header">
                <h3 class="modal-title">Update Order Status</h3>
                <button class="modal-close" onclick="closeStatusModal()">&times;</button>
            </div>
            <form id="statusForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <label class="form-label">Status</label>
                    <select name="status" id="statusSelect" class="status-select">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="preparing">Preparing</option>
                        <option value="ready">Ready</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeStatusModal()">Cancel</button>
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
        
        function filterOrders() {
            const status = document.getElementById('statusFilter').value;
            const date = document.getElementById('dateFilter').value;
            const rows = document.querySelectorAll('.order-row');
            
            rows.forEach(row => {
                const matchStatus = !status || row.dataset.status === status;
                const matchDate = !date || row.dataset.date === date;
                row.style.display = matchStatus && matchDate ? '' : 'none';
            });
        }
        
        function openOrderModal(order) {
            document.getElementById('modalOrderNumber').textContent = '#' + order.order_number;
            document.getElementById('modalStatus').innerHTML = `<span class="status-badge status-${order.status}">${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</span>`;
            document.getElementById('modalDate').textContent = new Date(order.created_at).toLocaleDateString();
            document.getElementById('modalDeliveryType').textContent = order.delivery_type === 'delivery' ? 'Delivery' : 'Pickup';
            document.getElementById('modalCustomerName').textContent = order.customer_name;
            document.getElementById('modalCustomerPhone').textContent = order.customer_phone;
            document.getElementById('modalAddress').textContent = order.delivery_address || '-';
            document.getElementById('modalTotal').textContent = '{{ $currencySymbol }}' + parseFloat(order.total).toFixed(2);
            
            let itemsHtml = '';
            order.items.forEach(item => {
                itemsHtml += `
                    <div class="order-item">
                        <div>
                            <span class="order-item-name">${item.product?.name || 'Product'}</span>
                            <span class="order-item-qty"> × ${item.quantity}</span>
                        </div>
                        <span class="order-item-price">{{ $currencySymbol }}${parseFloat(item.subtotal).toFixed(2)}</span>
                    </div>
                `;
            });
            document.getElementById('modalItems').innerHTML = itemsHtml;
            
            document.getElementById('orderModal').classList.add('active');
        }
        function closeOrderModal() { document.getElementById('orderModal').classList.remove('active'); }
        
        function openStatusModal(orderId, currentStatus) {
            document.getElementById('statusForm').action = `/dashboard/store/orders/${orderId}/status`;
            document.getElementById('statusSelect').value = currentStatus;
            document.getElementById('statusModal').classList.add('active');
        }
        function closeStatusModal() { document.getElementById('statusModal').classList.remove('active'); }
        
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('sidebar-collapsed') === 'true') {
                document.getElementById('sidebar').classList.add('collapsed');
            }
        });
    </script>
</x-app-layout>
