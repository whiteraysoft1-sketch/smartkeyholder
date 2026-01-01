@extends('layouts.admin')

@section('title', 'Users Management')
@section('page-title', 'Users Management')
@section('page-description', 'View and manage all registered users')

@section('styles')
<style>
    /* Modern Stat Cards */
    .stat-card {
        border-radius: 20px;
        padding: 24px;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 120px;
        height: 120px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transform: translate(40%, -40%);
        transition: all 0.4s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
    }
    
    .stat-card:hover::before {
        transform: translate(30%, -30%) scale(1.2);
    }
    
    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
    }
    
    .stat-card.blue {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%);
        color: white;
    }
    
    .stat-card.green {
        background: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
        color: white;
    }
    
    .stat-card.amber {
        background: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #fbbf24 100%);
        color: white;
    }
    
    .stat-card.purple {
        background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 50%, #a78bfa 100%);
        color: white;
    }
    
    .stat-card .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: rgba(255,255,255,0.25);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 16px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        position: relative;
        z-index: 1;
    }
    
    .stat-card .stat-content {
        position: relative;
        z-index: 1;
    }
    
    .stat-card .stat-value {
        font-size: 36px;
        font-weight: 800;
        margin: 0 0 6px 0;
        letter-spacing: -1px;
        text-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .stat-card .stat-label {
        font-size: 14px;
        opacity: 0.95;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
    
    .stat-card .stat-icon i {
        animation: pulse 2s ease-in-out infinite;
    }
    
    /* Content Card */
    .content-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }
    
    .content-card:hover {
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }
    
    .content-card-header {
        padding: 24px 28px;
        border-bottom: 1px solid var(--card-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        background: var(--bg-primary);
    }
    
    .content-card-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .content-card-body {
        padding: 0;
    }
    
    /* Modern Table */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table thead {
        background: var(--bg-primary);
        border-bottom: 2px solid var(--card-border);
    }
    
    .data-table th {
        padding: 16px 24px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
    }
    
    .data-table td {
        padding: 20px 24px;
        border-bottom: 1px solid var(--card-border);
        color: var(--text-primary);
        font-size: 14px;
        vertical-align: middle;
    }
    
    .data-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .data-table tbody tr:hover {
        background: var(--hover-bg);
        transform: scale(1.001);
    }
    
    .data-table tbody tr:last-child td {
        border-bottom: none;
    }
    
    /* User Avatar */
    .user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 700;
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        transition: all 0.3s ease;
    }
    
    .user-avatar:hover {
        transform: scale(1.1);
    }
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    
    .user-details .user-name {
        font-weight: 600;
        font-size: 15px;
        color: var(--text-primary);
        margin-bottom: 4px;
    }
    
    .user-details .user-email {
        font-size: 13px;
        color: var(--text-muted);
    }
    
    /* Modern Badges */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge-success {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
    }
    
    .badge-warning {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
    }
    
    .badge-info {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
    }
    
    .badge-danger {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }
    
    .badge-gray {
        background: rgba(107, 114, 128, 0.15);
        color: #6b7280;
    }
    
    /* Action Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        gap: 6px;
        text-decoration: none;
    }
    
    .btn-primary {
        background: rgba(59, 130, 246, 0.12);
        color: #3b82f6;
        border: 1.5px solid rgba(59, 130, 246, 0.3);
    }
    
    .btn-primary:hover {
        background: rgba(59, 130, 246, 0.2);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }
    
    .btn-success {
        background: rgba(16, 185, 129, 0.12);
        color: #10b981;
        border: 1.5px solid rgba(16, 185, 129, 0.3);
    }
    
    .btn-success:hover {
        background: rgba(16, 185, 129, 0.2);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    /* QR Code Info */
    .qr-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .qr-code-badge {
        font-weight: 600;
        font-size: 13px;
        color: var(--text-primary);
        font-family: 'Courier New', monospace;
    }
    
    /* Subscription Info */
    .subscription-info .plan-name {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 2px;
    }
    
    .subscription-info .plan-price {
        font-size: 12px;
        color: var(--text-muted);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: var(--text-muted);
    }
    
    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.3;
    }
    
    .empty-state h3 {
        font-size: 20px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 8px;
    }
    
    .empty-state p {
        font-size: 14px;
    }
    
    /* Pagination */
    .pagination-wrapper {
        padding: 20px 28px;
        border-top: 1px solid var(--card-border);
        background: var(--bg-primary);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        .stat-card {
            padding: 20px;
        }
        
        .stat-card .stat-value {
            font-size: 28px;
        }
        
        .data-table {
            display: block;
            overflow-x: auto;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<!-- Stats Grid -->
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 32px;">
    <div class="stat-card blue">
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $users->total() }}</div>
            <div class="stat-label">Total Users</div>
        </div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $users->where('is_subscribed', true)->count() }}</div>
            <div class="stat-label">Subscribed</div>
        </div>
    </div>
    <div class="stat-card amber">
        <div class="stat-icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $users->filter(fn($u) => $u->trial_ends_at && $u->trial_ends_at > now())->count() }}</div>
            <div class="stat-label">On Trial</div>
        </div>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon">
            <i class="fas fa-qrcode"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $users->whereNotNull('qr_code_id')->count() }}</div>
            <div class="stat-label">With QR Codes</div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="content-card">
    <div class="content-card-header">
        <h3 class="content-card-title">
            <i class="fas fa-users" style="color: #3b82f6;"></i>
            Users List
        </h3>
        <span style="font-size: 13px; color: var(--text-muted); font-weight: 500;">
            Showing {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} of {{ $users->total() }}
        </span>
    </div>
    <div class="content-card-body">
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>USER</th>
                        <th>QR CODE</th>
                        <th>SUBSCRIPTION</th>
                        <th>STATUS</th>
                        <th>JOINED</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div class="user-details">
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-email">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($user->qrCode)
                                <div class="qr-info">
                                    <span class="qr-code-badge">{{ $user->qrCode->code }}</span>
                                    <span class="badge {{ $user->qrCode->is_active ? 'badge-success' : 'badge-danger' }}">
                                        {{ $user->qrCode->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            @else
                                <span style="color: var(--text-muted); font-size: 13px;">No QR Code</span>
                            @endif
                        </td>
                        <td>
                            @if($user->activeSubscription)
                                <div class="subscription-info">
                                    <div class="plan-name">{{ $user->activeSubscription->plan_name }}</div>
                                    <div class="plan-price">${{ $user->activeSubscription->amount }}/month</div>
                                </div>
                            @elseif($user->trial_ends_at && $user->trial_ends_at > now())
                                <div>
                                    <div style="font-weight: 600; font-size: 13px; color: var(--text-primary); margin-bottom: 2px;">Free Trial</div>
                                    <div style="font-size: 12px; color: var(--text-muted);">$0.00/month</div>
                                </div>
                            @else
                                <span style="color: var(--text-muted); font-size: 13px;">No Subscription</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_subscribed)
                                <span class="badge badge-success">SUBSCRIBED</span>
                            @elseif($user->trial_ends_at && $user->trial_ends_at > now())
                                <span class="badge badge-info">FREE</span>
                            @else
                                <span class="badge badge-gray">FREE</span>
                            @endif
                        </td>
                        <td>
                            <span style="color: var(--text-secondary); font-weight: 500;">{{ $user->created_at->format('M d, Y') }}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.users.details', $user) }}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i>
                                    View Details
                                </a>
                                @if($user->qrCode)
                                    <a href="{{ $user->qrCode->url }}" target="_blank" class="btn btn-success">
                                        <i class="fas fa-external-link-alt"></i>
                                        View Profile
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fas fa-users"></i>
                                <h3>No users found</h3>
                                <p>No registered users yet</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="pagination-wrapper">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
