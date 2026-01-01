@extends('layouts.admin')

@section('title', 'Subscriptions Management')
@section('page-title', 'Subscriptions Management')
@section('page-description', 'View and manage all user subscriptions')

@section('styles')
<style>
    .stat-card {
        border-radius: 16px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .stat-card.green {
        background: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
        color: white;
    }
    
    .stat-card.amber {
        background: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #fbbf24 100%);
        color: white;
    }
    
    .stat-card.red {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
        color: white;
    }
    
    .stat-card.blue {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%);
        color: white;
    }
    
    .stat-card .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    
    .stat-card .stat-value {
        font-size: 28px;
        font-weight: 700;
        margin: 8px 0 4px 0;
    }
    
    .stat-card .stat-label {
        font-size: 13px;
        opacity: 0.9;
    }
    
    .content-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .content-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .content-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--card-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }
    
    .content-card-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-primary);
    }
    
    .content-card-body {
        padding: 0;
    }
    
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .data-table thead {
        background: var(--hover-bg);
    }
    
    .data-table th {
        padding: 14px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        border-bottom: 1px solid var(--card-border);
    }
    
    .data-table td {
        padding: 16px 20px;
        border-bottom: 1px solid var(--card-border);
        color: var(--text-primary);
        font-size: 14px;
    }
    
    .data-table tbody tr {
        transition: background 0.2s ease;
    }
    
    .data-table tbody tr:hover {
        background: var(--hover-bg);
    }
    
    .data-table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 600;
        color: white;
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    
    .badge-success {
        background: rgba(16, 185, 129, 0.15);
        color: #10b981;
    }
    
    .badge-warning {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
    }
    
    .badge-danger {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }
    
    .badge-gray {
        background: rgba(107, 114, 128, 0.15);
        color: #6b7280;
    }
    
    .badge-info {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        gap: 6px;
        text-decoration: none;
    }
    
    .btn-primary {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }
    
    .btn-primary:hover {
        background: rgba(59, 130, 246, 0.2);
    }
    
    .btn-info {
        background: rgba(14, 165, 233, 0.1);
        color: #0ea5e9;
        border: 1px solid rgba(14, 165, 233, 0.3);
    }
    
    .btn-info:hover {
        background: rgba(14, 165, 233, 0.2);
    }
    
    .pagination-wrapper {
        padding: 16px 24px;
        border-top: 1px solid var(--card-border);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: var(--text-muted);
    }
    
    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }
    
    .empty-state h3 {
        font-size: 18px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 8px;
    }
    
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        
        .stat-card {
            padding: 16px;
        }
        
        .stat-card .stat-value {
            font-size: 22px;
        }
        
        .data-table {
            display: block;
            overflow-x: auto;
        }
    }
</style>
@endsection

@section('content')
<!-- Stats Grid -->
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 24px;">
    <div class="stat-card green">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-value">{{ $subscriptions->where('status', 'active')->count() }}</div>
        <div class="stat-label">Active Subscriptions</div>
    </div>
    <div class="stat-card amber">
        <div class="stat-icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-value">{{ $subscriptions->where('status', 'pending')->count() }}</div>
        <div class="stat-label">Pending Subscriptions</div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="stat-value">{{ $subscriptions->where('status', 'cancelled')->count() }}</div>
        <div class="stat-label">Cancelled Subscriptions</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="stat-value">${{ number_format($subscriptions->where('status', 'active')->sum('amount'), 2) }}</div>
        <div class="stat-label">Monthly Revenue</div>
    </div>
</div>

<!-- Subscriptions Table -->
<div class="content-card">
    <div class="content-card-header">
        <h3 class="content-card-title">
            <i class="fas fa-credit-card" style="margin-right: 10px; color: #3b82f6;"></i>
            Subscriptions List
        </h3>
        <span style="font-size: 13px; color: var(--text-muted);">
            Showing {{ $subscriptions->firstItem() ?? 0 }} - {{ $subscriptions->lastItem() ?? 0 }} of {{ $subscriptions->total() }}
        </span>
    </div>
    <div class="content-card-body">
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Payment Method</th>
                        <th>Started</th>
                        <th>Next Billing</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $subscription)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($subscription->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 500;">{{ $subscription->user->name }}</div>
                                    <div style="font-size: 12px; color: var(--text-muted);">{{ $subscription->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div style="font-weight: 500;">{{ $subscription->plan_name }}</div>
                                @if($subscription->plan_description)
                                    <div style="font-size: 12px; color: var(--text-muted);">{{ $subscription->plan_description }}</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div>
                                <div style="font-weight: 600; color: #10b981;">${{ number_format($subscription->amount, 2) }}</div>
                                <div style="font-size: 12px; color: var(--text-muted);">{{ $subscription->billing_cycle ?? 'monthly' }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="badge 
                                @if($subscription->status === 'active') badge-success
                                @elseif($subscription->status === 'pending') badge-warning
                                @elseif($subscription->status === 'cancelled') badge-danger
                                @elseif($subscription->status === 'expired') badge-gray
                                @else badge-info
                                @endif">
                                {{ ucfirst($subscription->status) }}
                            </span>
                        </td>
                        <td>
                            <span style="color: var(--text-secondary);">{{ $subscription->payment_method ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span style="color: var(--text-secondary);">{{ $subscription->created_at->format('M d, Y') }}</span>
                        </td>
                        <td>
                            <span style="color: var(--text-secondary);">
                                @if($subscription->next_billing_date)
                                    {{ \Carbon\Carbon::parse($subscription->next_billing_date)->format('M d, Y') }}
                                @elseif($subscription->status === 'active')
                                    {{ $subscription->created_at->addMonth()->format('M d, Y') }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                <a href="{{ route('admin.users.details', $subscription->user) }}" class="btn btn-primary">
                                    <i class="fas fa-user"></i>
                                    View User
                                </a>
                                @if($subscription->stripe_subscription_id)
                                    <a href="https://dashboard.stripe.com/subscriptions/{{ $subscription->stripe_subscription_id }}" target="_blank" class="btn btn-info">
                                        <i class="fab fa-stripe-s"></i>
                                        View in Stripe
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-credit-card"></i>
                                <h3>No subscriptions found</h3>
                                <p>No active subscriptions yet</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($subscriptions->hasPages())
        <div class="pagination-wrapper">
            {{ $subscriptions->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
