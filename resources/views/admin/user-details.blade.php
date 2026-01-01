@extends('layouts.admin')

@section('title', 'User Details')
@section('page-title', 'User Details: ' . $user->name)

@section('header-actions')
<div style="display: flex; gap: 12px;">
    <a href="{{ route('admin.users') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        <span>Back to Users</span>
    </a>
    @if($user->qrCode)
        <a href="{{ $user->qrCode->url }}" target="_blank" class="btn btn-primary" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none;">
            <i class="fas fa-external-link-alt"></i>
            <span>View Profile</span>
        </a>
    @endif
</div>
@endsection

@section('styles')
<style>
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        gap: 8px;
        text-decoration: none;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        color: white;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    }
    
    .btn-secondary {
        background: var(--card-bg);
        color: var(--text-primary);
        border: 1px solid var(--card-border);
    }
    
    .btn-secondary:hover {
        background: var(--hover-bg);
    }
    
    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }
    
    .btn-danger:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    }
    
    .info-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .info-card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    
    .info-card-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .info-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    
    .info-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .info-value {
        font-size: 14px;
        font-weight: 500;
        color: var(--text-primary);
    }
    
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
    
    .badge-danger {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }
    
    .badge-warning {
        background: rgba(245, 158, 11, 0.15);
        color: #f59e0b;
    }
    
    .badge-info {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
    }
    
    .badge-gray {
        background: rgba(107, 114, 128, 0.15);
        color: #6b7280;
    }
    
    .status-card {
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 16px;
        border: 2px solid;
    }
    
    .status-card.active {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.05));
        border-color: #10b981;
        color: #065f46;
    }
    
    .status-card.trial {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(37, 99, 235, 0.05));
        border-color: #3b82f6;
        color: #1e40af;
    }
    
    .status-card.inactive {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.05));
        border-color: #ef4444;
        color: #991b1b;
    }
    
    .status-card-title {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    
    .status-card-text {
        font-size: 13px;
        margin: 4px 0;
    }
    
    .form-group {
        margin-bottom: 16px;
    }
    
    .form-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-control {
        width: 100%;
        padding: 12px 16px;
        background: var(--card-bg);
        border: 2px solid var(--card-border);
        border-radius: 10px;
        color: var(--text-primary);
        font-size: 14px;
        transition: all 0.2s ease;
        font-family: inherit;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }
    
    .action-section {
        background: var(--bg-primary);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 16px;
    }
    
    .action-section-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 16px;
    }
    
    .history-item {
        border-left: 4px solid;
        padding-left: 16px;
        margin-bottom: 16px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--card-border);
    }
    
    .history-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .history-item.active {
        border-left-color: #10b981;
    }
    
    .history-item.cancelled {
        border-left-color: #ef4444;
    }
    
    .history-item.pending {
        border-left-color: #6b7280;
    }
    
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    .gallery-item {
        aspect-ratio: 1;
        background: var(--hover-bg);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .gallery-item:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .qr-code-display {
        background: var(--bg-primary);
        padding: 16px;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 16px;
    }
    
    .qr-code-value {
        font-family: 'Courier New', monospace;
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
        word-break: break-all;
    }
    
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endsection

@section('content')
@section('content')
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
    <!-- Left Column -->
    <div>
        <!-- User Information -->
        <div class="info-card">
            <h3 class="info-card-title">
                <i class="fas fa-user" style="color: #3b82f6;"></i>
                User Information
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Name</span>
                    <span class="info-value">{{ $user->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Joined</span>
                    <span class="info-value">{{ $user->created_at->format('M d, Y H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email Verified</span>
                    <div class="info-value">
                        @if($user->email_verified_at)
                            <span class="badge badge-success">✓ Verified</span>
                        @else
                            <span class="badge badge-danger">✗ Not verified</span>
                        @endif
                    </div>
                </div>
                @if($user->trial_ends_at)
                    <div class="info-item">
                        <span class="info-label">Subscription Status</span>
                        <div class="info-value">
                            @if($user->is_subscribed)
                                <span class="badge badge-success">✓ Subscribed</span>
                            @else
                                <span class="badge badge-gray">Not subscribed</span>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="info-item">
                        <span class="info-label">Subscription Status</span>
                        <div class="info-value">
                            @if($user->is_subscribed)
                                <span class="badge badge-success">✓ Subscribed</span>
                            @else
                                <span class="badge badge-gray">Not subscribed</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Profile Information -->
        @if($user->profile)
            <div class="info-card">
                <h3 class="info-card-title">
                    <i class="fas fa-id-card" style="color: #10b981;"></i>
                    Profile Information
                </h3>
                <div class="info-grid">
                    @if($user->profile->business_name)
                        <div class="info-item">
                            <span class="info-label">Business Name</span>
                            <span class="info-value">{{ $user->profile->business_name }}</span>
                        </div>
                    @endif
                    @if($user->profile->phone)
                        <div class="info-item">
                            <span class="info-label">Phone</span>
                            <span class="info-value">{{ $user->profile->phone }}</span>
                        </div>
                    @endif
                    @if($user->profile->website)
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <span class="info-label">Website</span>
                            <a href="{{ $user->profile->website }}" target="_blank" class="info-value" style="color: #3b82f6; text-decoration: none;">
                                {{ $user->profile->website }} <i class="fas fa-external-link-alt" style="font-size: 10px;"></i>
                            </a>
                        </div>
                    @endif
                    @if($user->profile->location)
                        <div class="info-item">
                            <span class="info-label">Location</span>
                            <span class="info-value">{{ $user->profile->location }}</span>
                        </div>
                    @endif
                </div>
                @if($user->profile->bio)
                    <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--card-border);">
                        <span class="info-label">Bio</span>
                        <p class="info-value" style="margin-top: 8px; line-height: 1.6;">{{ $user->profile->bio }}</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Social Links -->
        @if($user->socialLinks && $user->socialLinks->count() > 0)
            <div class="info-card">
                <h3 class="info-card-title">
                    <i class="fas fa-share-alt" style="color: #8b5cf6;"></i>
                    Social Links
                </h3>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($user->socialLinks as $link)
                        <div style="display: flex; align-items: center; justify-between; padding: 12px; background: var(--bg-primary); border-radius: 10px;">
                            <div style="flex: 1;">
                                <div style="font-weight: 600; font-size: 13px; color: var(--text-primary); margin-bottom: 4px;">
                                    <i class="fab fa-{{ strtolower($link->platform) }}" style="margin-right: 8px; color: #3b82f6;"></i>
                                    {{ ucfirst($link->platform) }}
                                </div>
                                <a href="{{ $link->url }}" target="_blank" style="font-size: 12px; color: var(--text-muted); text-decoration: none; word-break: break-all;">
                                    {{ $link->url }}
                                </a>
                            </div>
                            <span style="font-size: 11px; color: var(--text-muted); margin-left: 12px;">
                                {{ $link->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Right Column (Sidebar) -->
    <div>
        <!-- QR Code Information -->
        <div class="info-card">
            <h3 class="info-card-title">
                <i class="fas fa-qrcode" style="color: #f59e0b;"></i>
                QR Code
            </h3>
            @if($user->qrCode)
                <div class="qr-code-display">
                    <div class="qr-code-value">{{ $user->qrCode->code }}</div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <div class="info-value">
                            <span class="badge {{ $user->qrCode->is_active ? 'badge-success' : 'badge-danger' }}">
                                {{ $user->qrCode->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Claimed</span>
                        <span class="info-value">{{ $user->qrCode->claimed_at ? $user->qrCode->claimed_at->format('M d, Y H:i') : 'Not claimed' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">URL</span>
                        <a href="{{ $user->qrCode->url }}" target="_blank" style="font-size: 12px; color: #3b82f6; text-decoration: none; word-break: break-all;">
                            {{ $user->qrCode->url }} <i class="fas fa-external-link-alt" style="font-size: 10px;"></i>
                        </a>
                    </div>
                </div>
            @else
                <p style="font-size: 13px; color: var(--text-muted); text-align: center; padding: 20px 0;">
                    No QR code assigned to this user.
                </p>
            @endif
        </div>

        <!-- Subscription Status -->
        <div class="info-card">
            <h3 class="info-card-title">
                <i class="fas fa-crown" style="color: #f59e0b;"></i>
                Subscription Status
            </h3>
            
            @if($user->isOnTrial())
                <div class="status-card trial">
                    <div class="status-card-title">Active Subscription</div>
                    <div class="status-card-text">Plan: Lion</div>
                    <div class="status-card-text">$11.00/month</div>
                    <div class="status-card-text">Expires: {{ $user->trial_ends_at->format('M d, Y H:i') }}</div>
                    <div class="status-card-text" style="font-size: 11px; margin-top: 4px;">{{ $user->trial_ends_at->diffForHumans() }}</div>
                </div>
            @elseif($user->hasActiveSubscription())
                <div class="status-card active">
                    <div class="status-card-title">Active Subscription</div>
                    <div class="status-card-text">Plan: {{ $user->activeSubscription->plan_name }}</div>
                    <div class="status-card-text">${{ $user->activeSubscription->amount }}/month</div>
                    <div class="status-card-text">Expires: {{ $user->subscription_ends_at->format('M d, Y H:i') }}</div>
                    <div class="status-card-text" style="font-size: 11px; margin-top: 4px;">{{ $user->subscription_ends_at->diffForHumans() }}</div>
                </div>
            @else
                <div class="status-card inactive">
                    <div class="status-card-title">No Active Subscription</div>
                    <div class="status-card-text">User needs to subscribe to access the service</div>
                </div>
            @endif

            <!-- Admin Actions -->
            <div style="margin-top: 20px;">
                <h4 class="info-label" style="margin-bottom: 16px; font-size: 14px;">Admin Actions</h4>
                
                <!-- Upgrade/Change Plan -->
                <div class="action-section">
                    <div class="action-section-title">Upgrade/Change Plan</div>
                    <form action="{{ route('admin.users.upgrade', $user) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Select Plan</label>
                            <select name="plan_id" class="form-control" required>
                                <option value="">Choose a plan...</option>
                                @foreach($availablePlans as $plan)
                                    <option value="{{ $plan->id }}">
                                        {{ $plan->name }} - ${{ number_format($plan->price, 2) }}
                                        @if($plan->is_free_trial) (Free Trial) @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Duration (months)</label>
                            <select name="duration_months" class="form-control">
                                <option value="1">1 Month</option>
                                <option value="3">3 Months</option>
                                <option value="6">6 Months</option>
                                <option value="12">12 Months</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            <i class="fas fa-arrow-up"></i>
                            Upgrade User
                        </button>
                    </form>
                </div>

                @if($user->hasActiveSubscription())
                    <!-- Extend Subscription -->
                    <div class="action-section">
                        <div class="action-section-title">Extend Current Subscription</div>
                        <form action="{{ route('admin.users.extend', $user) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Extend by (months)</label>
                                <select name="extend_months" class="form-control" required>
                                    <option value="1">1 Month</option>
                                    <option value="2">2 Months</option>
                                    <option value="3">3 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">12 Months</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success" style="width: 100%;">
                                <i class="fas fa-calendar-plus"></i>
                                Extend Subscription
                            </button>
                        </form>
                    </div>

                    <!-- Cancel Subscription -->
                    <div class="action-section" style="background: rgba(239, 68, 68, 0.05);">
                        <div class="action-section-title" style="color: #dc2626;">Cancel Subscription</div>
                        <form action="{{ route('admin.users.cancel-subscription', $user) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to cancel this user\'s subscription? This action cannot be undone.')">
                            @csrf
                            <button type="submit" class="btn btn-danger" style="width: 100%;">
                                <i class="fas fa-times-circle"></i>
                                Cancel Subscription
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <!-- Subscription History -->
        @if($user->subscriptions && $user->subscriptions->count() > 0)
            <div class="info-card">
                <h3 class="info-card-title">
                    <i class="fas fa-history" style="color: #6b7280;"></i>
                    Subscription History
                </h3>
                <div>
                    @foreach($user->subscriptions as $subscription)
                        <div class="history-item {{ $subscription->status }}">
                            <div style="display: flex; align-items: center; justify-between; margin-bottom: 6px;">
                                <div style="font-weight: 600; font-size: 14px; color: var(--text-primary);">
                                    {{ $subscription->plan_name }}
                                </div>
                                <span class="badge 
                                    @if($subscription->status === 'active') badge-success
                                    @elseif($subscription->status === 'cancelled') badge-danger
                                    @else badge-gray
                                    @endif">
                                    {{ ucfirst($subscription->status) }}
                                </span>
                            </div>
                            <div style="font-size: 13px; color: var(--text-secondary); margin-bottom: 4px;">
                                ${{ number_format($subscription->amount, 2) }}/month
                            </div>
                            <div style="font-size: 11px; color: var(--text-muted);">
                                Started: {{ $subscription->created_at->format('M d, Y') }}
                                @if($subscription->ends_at)
                                    | Ends: {{ $subscription->ends_at->format('M d, Y') }}
                                @endif
                            </div>
                            @if(isset($subscription->metadata['type']) && $subscription->metadata['type'] === 'admin_upgrade')
                                <div style="margin-top: 6px;">
                                    <span class="badge badge-info">
                                        <i class="fas fa-user-shield"></i> Admin Upgrade
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Gallery Items -->
        <div class="info-card">
            <h3 class="info-card-title">
                <i class="fas fa-images" style="color: #ec4899;"></i>
                Gallery Items
            </h3>
            @if($user->galleryItems && $user->galleryItems->count() > 0)
                <div class="gallery-grid">
                    @foreach($user->galleryItems as $item)
                        <div class="gallery-item">
                            @if($item->type === 'image')
                                <img src="{{ Storage::url($item->file_path) }}" alt="Gallery item" loading="lazy">
                            @elseif($item->type === 'video')
                                <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.05));">
                                    <i class="fas fa-play-circle" style="font-size: 32px; color: #ef4444; margin-bottom: 8px;"></i>
                                    <span style="font-size: 10px; color: var(--text-muted); font-weight: 600;">VIDEO</span>
                                </div>
                            @else
                                <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; background: var(--hover-bg);">
                                    <i class="fas fa-file" style="font-size: 28px; color: var(--text-muted); margin-bottom: 8px;"></i>
                                    <span style="font-size: 10px; color: var(--text-muted); font-weight: 600;">{{ strtoupper($item->type) }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--card-border); text-align: center;">
                    <span style="font-size: 12px; color: var(--text-muted); font-weight: 500;">
                        <i class="fas fa-layer-group" style="margin-right: 4px;"></i>
                        {{ $user->galleryItems->count() }} {{ Str::plural('item', $user->galleryItems->count()) }}
                    </span>
                </div>
            @else
                <div style="text-align: center; padding: 40px 20px; background: var(--bg-primary); border-radius: 12px;">
                    <i class="fas fa-images" style="font-size: 48px; color: var(--text-muted); opacity: 0.3; margin-bottom: 12px; display: block;"></i>
                    <p style="font-size: 13px; color: var(--text-muted); margin: 0;">No gallery items yet</p>
                    <p style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">User hasn't uploaded any media</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection