@extends('layouts.admin')

@section('title', 'QR Code Management')
@section('page-title', 'QR Code Management')
@section('page-description', 'Generate, manage, and export printable QR codes')

@section('styles')
<style>
    /* Page-specific styles */
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
    
    .stat-card.teal {
        background: linear-gradient(135deg, #0d9488 0%, #14b8a6 50%, #5eead4 100%);
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
    
    .stat-card.red {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
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
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.8;
        }
    }
    
    .stat-card .stat-icon i {
        animation: pulse 2s ease-in-out infinite;
    }
    
    /* Content Cards */
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
    
    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
        gap: 8px;
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
    
    .btn-success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }
    
    .btn-secondary {
        background: var(--card-bg);
        color: var(--text-primary);
        border: 1px solid var(--card-border);
    }
    
    .btn-secondary:hover {
        background: var(--hover-bg);
    }
    
    .btn-sm {
        padding: 6px 12px;
        font-size: 12px;
        border-radius: 8px;
    }
    
    .btn-danger-outline {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    
    .btn-danger-outline:hover {
        background: rgba(239, 68, 68, 0.2);
    }
    
    .btn-success-outline {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    
    .btn-success-outline:hover {
        background: rgba(16, 185, 129, 0.2);
    }
    
    .btn-warning-outline {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    
    .btn-warning-outline:hover {
        background: rgba(245, 158, 11, 0.2);
    }
    
    .btn-info-outline {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }
    
    .btn-info-outline:hover {
        background: rgba(59, 130, 246, 0.2);
    }
    
    /* Form Controls */
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
        background: var(--bg-primary);
    }
    
    .form-control::placeholder {
        color: var(--text-muted);
        opacity: 0.6;
    }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 8px;
    }
    
    .form-hint {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 6px;
        display: block;
    }
    
    /* Filter Bar */
    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        padding: 24px;
        align-items: flex-end;
        background: var(--bg-primary);
        border-radius: 16px;
    }
    
    .filter-group {
        flex: 1;
        min-width: 200px;
    }
    
    .filter-group .form-control {
        height: 48px;
        padding-left: 16px;
        font-size: 14px;
        border-radius: 12px;
        border: 2px solid var(--card-border);
        background: var(--card-bg);
        transition: all 0.3s ease;
    }
    
    .filter-group .form-control:hover {
        border-color: #94a3b8;
    }
    
    .filter-group .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        transform: translateY(-1px);
    }
    
    .filter-group .form-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .filter-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    
    .filter-actions .btn {
        height: 48px;
        padding: 0 24px;
        font-weight: 600;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .filter-actions .btn:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    /* Table Styles */
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
    
    /* QR Code Preview */
    .qr-preview {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        border: 1px solid var(--card-border);
        background: white;
        padding: 4px;
    }
    
    /* Status Badges */
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
    
    .badge-info {
        background: rgba(59, 130, 246, 0.15);
        color: #3b82f6;
    }
    
    .badge-danger {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
    }
    
    /* Dropdown */
    .dropdown {
        position: relative;
        display: inline-block;
    }
    
    .dropdown-menu {
        position: absolute;
        right: 0;
        top: 100%;
        margin-top: 8px;
        min-width: 180px;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        z-index: 100;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.2s ease;
    }
    
    .dropdown-menu.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        color: var(--text-primary);
        text-decoration: none;
        font-size: 13px;
        transition: background 0.2s ease;
    }
    
    .dropdown-item:hover {
        background: var(--hover-bg);
    }
    
    .dropdown-item:first-child {
        border-radius: 12px 12px 0 0;
    }
    
    .dropdown-item:last-child {
        border-radius: 0 0 12px 12px;
    }
    
    /* Modal */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(8px);
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        animation: fadeIn 0.2s ease;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    
    .modal-overlay.show {
        display: flex !important;
    }
    
    .modal {
        background: var(--card-bg);
        border-radius: 20px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 25px 80px rgba(0,0,0,0.3);
        animation: modalSlideIn 0.3s ease;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(-30px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    
    .modal-header {
        padding: 24px 28px;
        border-bottom: 1px solid var(--card-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .modal-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .modal-close {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        border: none;
        background: var(--hover-bg);
        color: var(--text-muted);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        font-size: 18px;
    }
    
    .modal-close:hover {
        background: rgba(239, 68, 68, 0.15);
        color: #ef4444;
        transform: rotate(90deg);
    }
    
    .modal-body {
        padding: 28px;
    }
    
    .modal-footer {
        padding: 20px 28px;
        border-top: 1px solid var(--card-border);
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        background: var(--hover-bg);
    }
    
    /* Action Buttons Group */
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    /* Pagination */
    .pagination-wrapper {
        padding: 16px 24px;
        border-top: 1px solid var(--card-border);
    }
    
    /* Empty State */
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
    
    /* Page Header Actions */
    .page-header-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    
    /* Mobile Responsive */
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
        
        .filter-bar {
            flex-direction: column;
        }
        
        .filter-group {
            min-width: 100%;
        }
        
        .data-table {
            display: block;
            overflow-x: auto;
        }
        
        .page-header-actions {
            width: 100%;
            flex-direction: column;
        }
        
        .page-header-actions .btn {
            width: 100%;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .action-buttons .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('header-actions')
<div class="page-header-actions">
    <button onclick="openGenerateModal()" class="btn btn-primary">
        <i class="fas fa-plus"></i>
        <span>Generate QR Codes</span>
    </button>
    <button onclick="openExportModal()" class="btn btn-success">
        <i class="fas fa-download"></i>
        <span>Bulk Export</span>
    </button>
</div>
@endsection

@section('content')
<!-- Stats Grid -->
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 32px;">
    <div class="stat-card teal">
        <div class="stat-icon">
            <i class="fas fa-qrcode"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $qrCodes->total() }}</div>
            <div class="stat-label">Total QR Codes</div>
        </div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $qrCodes->where('is_claimed', true)->count() }}</div>
            <div class="stat-label">Claimed</div>
        </div>
    </div>
    <div class="stat-card amber">
        <div class="stat-icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $qrCodes->where('is_claimed', false)->count() }}</div>
            <div class="stat-label">Available</div>
        </div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon">
            <i class="fas fa-ban"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value">{{ $qrCodes->where('is_active', false)->count() }}</div>
            <div class="stat-label">Inactive</div>
        </div>
    </div>
</div>

<!-- Filters Card -->
<div class="content-card" style="margin-bottom: 32px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
    <form method="GET" class="filter-bar">
        <div class="filter-group" style="flex: 2;">
            <label class="form-label">
                <i class="fas fa-search" style="margin-right: 6px; color: #3b82f6;"></i>
                Search
            </label>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}" 
                   placeholder="Search by code, user email..." 
                   class="form-control"
                   style="padding-left: 16px;">
        </div>
        <div class="filter-group" style="flex: 1; min-width: 180px;">
            <label class="form-label">
                <i class="fas fa-filter" style="margin-right: 6px; color: #10b981;"></i>
                Status
            </label>
            <select name="status" class="form-control">
                <option value="">All Status</option>
                <option value="claimed" {{ request('status') == 'claimed' ? 'selected' : '' }}>✓ Claimed</option>
                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>○ Available</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>✕ Inactive</option>
            </select>
        </div>
        <div class="filter-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Filter
            </button>
            <a href="{{ route('admin.qr-codes') }}" class="btn btn-secondary">
                <i class="fas fa-redo"></i>
                Clear
            </a>
        </div>
    </form>
</div>

<!-- QR Codes Table -->
<div class="content-card">
    <div class="content-card-header">
        <h3 class="content-card-title">
            <i class="fas fa-qrcode" style="margin-right: 10px; color: #3b82f6;"></i>
            QR Codes List
        </h3>
        <span style="font-size: 13px; color: var(--text-muted);">
            Showing {{ $qrCodes->firstItem() ?? 0 }} - {{ $qrCodes->lastItem() ?? 0 }} of {{ $qrCodes->total() }}
        </span>
    </div>
    <div class="content-card-body">
        <div style="overflow-x: auto;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>QR Code</th>
                        <th>Preview</th>
                        <th>Status</th>
                        <th>User</th>
                        <th>Scans</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($qrCodes as $qrCode)
                    <tr>
                        <td>
                            <div>
                                <div style="font-weight: 600; margin-bottom: 2px;">{{ $qrCode->code }}</div>
                                <div style="font-size: 12px; color: var(--text-muted);">{{ $qrCode->uuid }}</div>
                            </div>
                        </td>
                        <td>
                            <img src="{{ route('qr.generate', $qrCode->uuid) }}" alt="QR Code" class="qr-preview">
                        </td>
                        <td>
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                @if($qrCode->is_claimed)
                                    <span class="badge badge-success">Claimed</span>
                                @else
                                    <span class="badge badge-warning">
Available</span>
                                @endif
                                @if($qrCode->is_active)
                                    <span class="badge badge-info">Active</span>
                                @else
                                    <span class="badge badge-danger">Inactive</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($qrCode->user)
                                <div>
                                    <div style="font-weight: 500;">{{ $qrCode->user->name }}</div>
                                    <div style="font-size: 12px; color: var(--text-muted);">{{ $qrCode->user->email }}</div>
                                </div>
                            @else
                                <span style="color: var(--text-muted);">Not claimed</span>
                            @endif
                        </td>
                        <td>
                            <span style="font-weight: 600; color: #3b82f6;">{{ $qrCode->scan_count ?? 0 }}</span>
                        </td>
                        <td>
                            <span style="color: var(--text-secondary);">{{ $qrCode->created_at->format('M d, Y') }}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <!-- Download Dropdown -->
                                <div class="dropdown">
                                    <button onclick="toggleDropdown('dropdown-{{ $qrCode->id }}')" class="btn btn-sm btn-info-outline">
                                        <i class="fas fa-download"></i>
                                        Download
                                    </button>
                                    <div id="dropdown-{{ $qrCode->id }}" class="dropdown-menu">
                                        <a href="{{ route('qr.view', $qrCode->uuid) }}" target="_blank" class="dropdown-item">
                                            <i class="fas fa-eye"></i>
                                            View Profile
                                        </a>
                                        <a href="{{ route('qr.download', $qrCode->uuid) }}" class="dropdown-item">
                                            <i class="fas fa-file-image"></i>
                                            Download PNG
                                        </a>
                                        <a href="{{ route('qr.download.svg', $qrCode->uuid) }}" class="dropdown-item">
                                            <i class="fas fa-vector-square"></i>
                                            Download SVG
                                        </a>
                                    </div>
                                </div>

                                <!-- Status Toggle -->
                                @if($qrCode->is_active)
                                    <form method="POST" action="{{ route('admin.qr-codes.deactivate', $qrCode) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger-outline" 
                                                onclick="return confirm('Are you sure you want to deactivate this QR code?')">
                                            <i class="fas fa-ban"></i>
                                            Deactivate
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.qr-codes.activate', $qrCode) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success-outline">
                                            <i class="fas fa-check"></i>
                                            Activate
                                        </button>
                                    </form>
                                @endif

                                <!-- Reassign Button -->
                                <button onclick="openReassignModal('{{ $qrCode->id }}', '{{ $qrCode->code }}', '{{ $qrCode->user ? $qrCode->user->email : '' }}')" 
                                        class="btn btn-sm btn-warning-outline">
                                    <i class="fas fa-user-edit"></i>
                                    Reassign
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-qrcode"></i>
                                <h3>No QR codes found</h3>
                                <p>Generate your first batch of QR codes to get started</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($qrCodes->hasPages())
        <div class="pagination-wrapper">
            {{ $qrCodes->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Generate QR Codes Modal -->
<div id="generateModal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fas fa-plus-circle" style="color: #3b82f6;"></i>
                Generate QR Codes
            </h3>
            <button onclick="closeGenerateModal()" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.qr-codes.generate') }}">
            @csrf
            <div class="modal-body">
                <div style="margin-bottom: 24px;">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" min="1" max="1000" value="10" required class="form-control" placeholder="Enter quantity">
                    <span class="form-hint">Maximum 1000 QR codes per batch</span>
                </div>
                <div>
                    <label class="form-label">Prefix (Optional)</label>
                    <input type="text" name="prefix" value="WS" maxlength="5" class="form-control" placeholder="e.g., WS">
                    <span class="form-hint">Prefix for QR code identifiers (e.g., WS_ABC123)</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeGenerateModal()" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none;">
                    <i class="fas fa-plus"></i>
                    Generate
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Export Modal -->
<div id="exportModal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fas fa-download" style="color: #10b981;"></i>
                Bulk Export QR Codes
            </h3>
            <button onclick="closeExportModal()" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.qr-codes.bulk-export') }}">
            @csrf
            <div class="modal-body">
                <div style="margin-bottom: 24px;">
                    <label class="form-label">Export Type</label>
                    <select name="type" class="form-control">
                        <option value="all">All QR Codes</option>
                        <option value="available">Available Only</option>
                        <option value="claimed">Claimed Only</option>
                        <option value="active">Active Only</option>
                    </select>
                </div>
                <div style="margin-bottom: 24px;">
                    <label class="form-label">Format</label>
                    <select name="format" class="form-control">
                        <option value="png">PNG (Raster)</option>
                        <option value="svg">SVG (Vector - Print Ready)</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Size (pixels)</label>
                    <select name="size" class="form-control">
                        <option value="200">200x200 (Small)</option>
                        <option value="300" selected>300x300 (Medium)</option>
                        <option value="500">500x500 (Large)</option>
                        <option value="1000">1000x1000 (Print Quality)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeExportModal()" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <button type="submit" class="btn btn-success" style="background: linear-gradient(135deg, #10b981, #059669); color: white; border: none;">
                    <i class="fas fa-download"></i>
                    Export ZIP
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Reassign Modal -->
<div id="reassignModal" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fas fa-user-edit" style="color: #f59e0b;"></i>
                Reassign QR Code
            </h3>
            <button onclick="closeReassignModal()" class="modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="reassignForm" method="POST">
            @csrf
            <div class="modal-body">
                <div style="margin-bottom: 24px;">
                    <label class="form-label">QR Code</label>
                    <input type="text" id="reassignQrCode" readonly class="form-control" style="background: var(--hover-bg); cursor: not-allowed;">
                </div>
                <div style="margin-bottom: 24px;">
                    <label class="form-label">Current User</label>
                    <input type="text" id="currentUser" readonly class="form-control" style="background: var(--hover-bg); cursor: not-allowed;">
                </div>
                <div>
                    <label class="form-label">New User Email (Optional)</label>
                    <input type="email" name="user_email" placeholder="Leave empty to unclaim" class="form-control">
                    <span class="form-hint">Enter user email to reassign, or leave empty to make available</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeReassignModal()" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border: none;">
                    <i class="fas fa-user-edit"></i>
                    Reassign
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Modal functions
function openGenerateModal() {
    document.getElementById('generateModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeGenerateModal() {
    document.getElementById('generateModal').classList.remove('show');
    document.body.style.overflow = '';
}

function openExportModal() {
    document.getElementById('exportModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeExportModal() {
    document.getElementById('exportModal').classList.remove('show');
    document.body.style.overflow = '';
}

function openReassignModal(qrCodeId, qrCode, currentUser) {
    document.getElementById('reassignQrCode').value = qrCode;
    document.getElementById('currentUser').value = currentUser || 'Not claimed';
    document.getElementById('reassignForm').action = `/admin/qr-codes/${qrCodeId}/reassign`;
    document.getElementById('reassignModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeReassignModal() {
    document.getElementById('reassignModal').classList.remove('show');
    document.body.style.overflow = '';
}

// Dropdown toggle
function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    const isOpen = dropdown.classList.contains('show');
    
    // Close all dropdowns
    document.querySelectorAll('.dropdown-menu').forEach(el => {
        el.classList.remove('show');
    });
    
    // Toggle current dropdown
    if (!isOpen) {
        dropdown.classList.add('show');
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-menu').forEach(el => {
            el.classList.remove('show');
        });
    }
});

// Close modals when clicking overlay
document.querySelectorAll('.modal-overlay').forEach(modal => {
    modal.addEventListener('click', function(event) {
        if (event.target === this) {
            this.classList.remove('show');
            document.body.style.overflow = '';
        }
    });
});

// Close modals with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.show').forEach(modal => {
            modal.classList.remove('show');
        });
        document.body.style.overflow = '';
    }
});
</script>
@endsection
