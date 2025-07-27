@extends('layouts.app')

@section('content')
<div class="py-8 px-2 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="liquid-glass bg-white/20 backdrop-blur-lg border border-white/30 rounded-xl p-6 mb-8 flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">QR Code Management</h1>
                <p class="text-gray-600 mt-2">Generate, manage, and export printable QR codes for new users</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="openGenerateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold">
                    <i class="fas fa-plus mr-2"></i>Generate QR Codes
                </button>
                <button onclick="openExportModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold">
                    <i class="fas fa-download mr-2"></i>Bulk Export
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
            <div class="liquid-glass bg-white/20 backdrop-blur-md border border-white/30 rounded-xl p-6 flex items-center space-x-4 hover:shadow-xl transition-all duration-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-qrcode text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total QR Codes</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $qrCodes->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Claimed</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $qrCodes->where('is_claimed', true)->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Available</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $qrCodes->where('is_claimed', false)->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600">
                        <i class="fas fa-ban text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Inactive</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $qrCodes->where('is_active', false)->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="liquid-glass bg-white/20 backdrop-blur-lg border border-white/30 rounded-xl mb-6">
            <div class="p-6">
                <form method="GET" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-64">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search by code, user email..." 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All Status</option>
                            <option value="claimed" {{ request('status') == 'claimed' ? 'selected' : '' }}>Claimed</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                    </div>
                    <div>
                        <a href="{{ route('admin.qr-codes') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg">
                            <i class="fas fa-times mr-2"></i>Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- QR Codes Table -->
        <div class="liquid-glass bg-white/20 backdrop-blur-md border border-white/30 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QR Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preview</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scans</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($qrCodes as $qrCode)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $qrCode->code }}</div>
                                    <div class="text-sm text-gray-500">{{ $qrCode->uuid }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <img src="{{ route('qr.generate', $qrCode->uuid) }}" alt="QR Code" class="w-12 h-12 border rounded">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-1">
                                    @if($qrCode->is_claimed)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Claimed
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Available
                                        </span>
                                    @endif
                                    @if($qrCode->is_active)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($qrCode->user)
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $qrCode->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $qrCode->user->email }}</div>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-400">Not claimed</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $qrCode->scan_count ?? 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $qrCode->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <!-- View/Download Dropdown -->
                                    <div class="relative inline-block text-left">
                                        <button onclick="toggleDropdown('dropdown-{{ $qrCode->id }}')" class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1 rounded text-xs">
                                            <i class="fas fa-download mr-1"></i>Download
                                        </button>
                                        <div id="dropdown-{{ $qrCode->id }}" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                                            <div class="py-1">
                                                <a href="{{ route('qr.view', $qrCode->uuid) }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fas fa-eye mr-2"></i>View Profile
                                                </a>
                                                <a href="{{ route('qr.download', $qrCode->uuid) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fas fa-file-image mr-2"></i>Download PNG
                                                </a>
                                                <a href="{{ route('qr.download.svg', $qrCode->uuid) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    <i class="fas fa-vector-square mr-2"></i>Download SVG
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status Toggle -->
                                    @if($qrCode->is_active)
                                        <form method="POST" action="{{ route('admin.qr-codes.deactivate', $qrCode) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded text-xs" 
                                                    onclick="return confirm('Are you sure you want to deactivate this QR code?')">
                                                <i class="fas fa-ban mr-1"></i>Deactivate
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.qr-codes.activate', $qrCode) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-green-100 hover:bg-green-200 text-green-700 px-3 py-1 rounded text-xs">
                                                <i class="fas fa-check mr-1"></i>Activate
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Reassign Button -->
                                    <button onclick="openReassignModal('{{ $qrCode->id }}', '{{ $qrCode->code }}', '{{ $qrCode->user ? $qrCode->user->email : '' }}')" 
                                            class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-1 rounded text-xs">
                                        <i class="fas fa-user-edit mr-1"></i>Reassign
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-qrcode text-4xl mb-4"></i>
                                <p class="text-lg font-medium">No QR codes found</p>
                                <p class="text-sm">Generate your first batch of QR codes to get started</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($qrCodes->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $qrCodes->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Generate QR Codes Modal -->
<div id="generateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Generate QR Codes</h3>
                    <button onclick="closeGenerateModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.qr-codes.generate') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                            <input type="number" name="quantity" min="1" max="1000" value="10" required
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Maximum 1000 QR codes per batch</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prefix (Optional)</label>
                            <input type="text" name="prefix" value="WS" maxlength="5"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Prefix for QR code identifiers (e.g., WS_ABC123)</p>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeGenerateModal()" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-plus mr-2"></i>Generate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Export Modal -->
<div id="exportModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Bulk Export QR Codes</h3>
                    <button onclick="closeExportModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.qr-codes.bulk-export') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Export Type</label>
                            <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="all">All QR Codes</option>
                                <option value="available">Available Only</option>
                                <option value="claimed">Claimed Only</option>
                                <option value="active">Active Only</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
                            <select name="format" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="png">PNG (Raster)</option>
                                <option value="svg">SVG (Vector - Print Ready)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Size (pixels)</label>
                            <select name="size" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="200">200x200 (Small)</option>
                                <option value="300" selected>300x300 (Medium)</option>
                                <option value="500">500x500 (Large)</option>
                                <option value="1000">1000x1000 (Print Quality)</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeExportModal()" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                            <i class="fas fa-download mr-2"></i>Export ZIP
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Reassign Modal -->
<div id="reassignModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Reassign QR Code</h3>
                    <button onclick="closeReassignModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="reassignForm" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">QR Code</label>
                            <input type="text" id="reassignQrCode" readonly 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current User</label>
                            <input type="text" id="currentUser" readonly 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">New User Email (Optional)</label>
                            <input type="email" name="user_email" placeholder="Leave empty to unclaim"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Enter user email to reassign, or leave empty to make available</p>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeReassignModal()" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700">
                            <i class="fas fa-user-edit mr-2"></i>Reassign
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Modal functions
function openGenerateModal() {
    document.getElementById('generateModal').classList.remove('hidden');
}

function closeGenerateModal() {
    document.getElementById('generateModal').classList.add('hidden');
}

function openExportModal() {
    document.getElementById('exportModal').classList.remove('hidden');
}

function closeExportModal() {
    document.getElementById('exportModal').classList.add('hidden');
}

function openReassignModal(qrCodeId, qrCode, currentUser) {
    document.getElementById('reassignQrCode').value = qrCode;
    document.getElementById('currentUser').value = currentUser || 'Not claimed';
    document.getElementById('reassignForm').action = `/admin/qr-codes/${qrCodeId}/reassign`;
    document.getElementById('reassignModal').classList.remove('hidden');
}

function closeReassignModal() {
    document.getElementById('reassignModal').classList.add('hidden');
}

// Dropdown toggle
function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    dropdown.classList.toggle('hidden');
    
    // Close other dropdowns
    document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
        if (el.id !== dropdownId) {
            el.classList.add('hidden');
        }
    });
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('[onclick*="toggleDropdown"]')) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
            el.classList.add('hidden');
        });
    }
});

// Close modals when clicking outside
document.addEventListener('click', function(event) {
    const modals = ['generateModal', 'exportModal', 'reassignModal'];
    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });
});
</script>
@endsection
