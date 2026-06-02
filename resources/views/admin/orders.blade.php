@extends('layouts.admin')

@section('title', 'Manage Orders - Optiqueue')

@section('page-header')
    <div>
        <h2 class="text-xl lg:text-2xl font-bold font-serif text-gray-900">Orders</h2>
        <p class="text-sm text-gray-500 mt-0.5">Manage and track customer orders</p>
    </div>
@endsection

@section('header-actions')
    {{-- Removed filter/export buttons per requirements --}}
@endsection

@section('content')
    <div class="p-6 lg:p-8 space-y-6">

        <!-- Orders Overview Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 stagger-children">
            <div class="admin-card p-4 lg:p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                        <i class="fa-solid fa-receipt text-blue-600"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-gray-900">{{ number_format($totalOrders) }}</div>
                        <div class="text-xs text-gray-500">Total Orders</div>
                    </div>
                </div>
            </div>
            <div class="admin-card p-4 lg:p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                        <i class="fa-solid fa-hourglass-half text-purple-600"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-gray-900">{{ number_format($pendingCount) }}</div>
                        <div class="text-xs text-gray-500">Pending</div>
                    </div>
                </div>
            </div>
            <div class="admin-card p-4 lg:p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                        <i class="fa-solid fa-gear text-amber-600"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-gray-900">{{ number_format($processingCount) }}</div>
                        <div class="text-xs text-gray-500">Processing</div>
                    </div>
                </div>
            </div>
            <div class="admin-card p-4 lg:p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                        <i class="fa-solid fa-check-circle text-green-600"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-gray-900">{{ number_format($readyCount) }}</div>
                        <div class="text-xs text-gray-500">Ready for Pickup</div>
                    </div>
                </div>
            </div>
            <div class="admin-card p-4 lg:p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center">
                        <i class="fa-solid fa-box text-gray-600"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-gray-900">{{ number_format($pickedUpCount) }}</div>
                        <div class="text-xs text-gray-500">Picked Up</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search + Status Filter Tabs -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <!-- Status Filter Tabs -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.orders', array_merge(request()->except('status', 'page'), ['status' => 'all'])) }}"
                    class="status-filter px-4 py-2 rounded-xl text-xs font-semibold transition-all {{ !request('status') || request('status') === 'all' ? 'bg-[#0F3D2A] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    All Orders
                </a>
                <a href="{{ route('admin.orders', array_merge(request()->except('status', 'page'), ['status' => 'processing'])) }}"
                    class="status-filter px-4 py-2 rounded-xl text-xs font-medium transition-all {{ request('status') === 'processing' ? 'bg-[#0F3D2A] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Processing
                </a>
                <a href="{{ route('admin.orders', array_merge(request()->except('status', 'page'), ['status' => 'ready'])) }}"
                    class="status-filter px-4 py-2 rounded-xl text-xs font-medium transition-all {{ request('status') === 'ready' ? 'bg-[#0F3D2A] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Ready
                </a>
                <a href="{{ route('admin.orders', array_merge(request()->except('status', 'page'), ['status' => 'picked-up'])) }}"
                    class="status-filter px-4 py-2 rounded-xl text-xs font-medium transition-all {{ request('status') === 'picked-up' ? 'bg-[#0F3D2A] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Picked Up
                </a>
                <a href="{{ route('admin.orders', array_merge(request()->except('status', 'page'), ['status' => 'cancelled'])) }}"
                    class="status-filter px-4 py-2 rounded-xl text-xs font-medium transition-all {{ request('status') === 'cancelled' ? 'bg-[#0F3D2A] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Cancelled
                </a>
            </div>

            <!-- Search (moved to right side above table) -->
            <div class="relative sm:w-64">
                <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" id="searchInput" placeholder="Search by name, email, or ticket no..."
                    value="{{ request('search') }}"
                    class="admin-input !w-full !py-2 !pl-9 !pr-3 !text-sm !rounded-xl bg-gray-50">
            </div>
        </div>

        <!-- Orders Table -->
        <div class="admin-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full admin-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Ticket No.</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="ordersTable">
                        @forelse ($orders as $order)
                            @php
                                $status = $order->status;
                                $isTerminal = in_array($status, ['picked-up', 'cancelled']);
                                $badgeClass = match($status) {
                                    'ready' => 'badge-success',
                                    'processing' => 'badge-info',
                                    'pending' => 'badge-warning',
                                    'picked-up' => 'badge-neutral',
                                    'cancelled' => 'badge-danger',
                                    default => 'badge-info',
                                };
                                $dotClass = match($status) {
                                    'ready' => 'bg-green-500',
                                    'processing' => 'bg-blue-500',
                                    'pending' => 'bg-yellow-500',
                                    'picked-up' => 'bg-gray-500',
                                    'cancelled' => 'bg-red-500',
                                    default => 'bg-blue-500',
                                };
                                $statusLabel = $statusLabels[$status] ?? ucfirst($status);
                            @endphp
                            <tr class="order-row" data-status="{{ $status }}" data-id="{{ $order->id }}">
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gradient-to-br from-[#0F3D2A] to-[#1a5c3e] flex items-center justify-center text-white text-xs font-bold">
                                            {{ substr($order->customer->name ?? '?', 0, 2) }}
                                        </div>
                                        <span class="font-medium text-gray-900">{{ $order->customer->name ?? 'Unknown' }}</span>
                                    </div>
                                </td>
                                <td class="text-gray-500">{{ $order->customer->email }}</td>
                                <td class="font-mono text-sm text-gray-700">{{ $order->order_no }}</td>
                                <td class="font-semibold text-gray-900">₱{{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="status-badge badge {{ $badgeClass }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                        <span class="status-text">{{ $statusLabel }}</span>
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2 actions-cell">
                                        <button onclick="openManageModal({{ $order->id }})"
                                            class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-800 text-xs font-medium transition-all">
                                            <i class="fa-solid fa-gear mr-1"></i>Manage
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12 text-gray-400">
                                    <i class="fa-solid fa-receipt text-3xl mb-3 block text-gray-300"></i>
                                    <p class="text-sm font-medium">No orders found</p>
                                    <p class="text-xs mt-1">Try adjusting your search or filter criteria.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer / Pagination -->
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                <span>
                    Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} orders
                </span>
                <div class="flex items-center gap-2">
                    @if ($orders->onFirstPage())
                        <button disabled class="px-3 py-1.5 rounded-lg bg-gray-50 text-gray-300 cursor-not-allowed">
                            <i class="fa-solid fa-chevron-left text-[10px]"></i>
                        </button>
                    @else
                        <a href="{{ $orders->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                            <i class="fa-solid fa-chevron-left text-[10px]"></i>
                        </a>
                    @endif

                    @foreach ($orders->getUrlRange(max(1, $orders->currentPage() - 2), min($orders->lastPage(), $orders->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}"
                            class="px-3 py-1.5 rounded-lg transition-colors {{ $page === $orders->currentPage() ? 'bg-[#0F3D2A] text-white font-medium' : 'bg-gray-100 hover:bg-gray-200 text-gray-600' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    @if ($orders->hasMorePages())
                        <a href="{{ $orders->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    @else
                        <button disabled class="px-3 py-1.5 rounded-lg bg-gray-50 text-gray-300 cursor-not-allowed">
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details / Manage Modal -->
    <div id="orderDetailsModal"
        class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 transform transition-all duration-300 scale-95 opacity-0 max-h-[90vh] overflow-y-auto"
            id="modal-content">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b border-gray-100 px-6 py-4 sticky top-0 bg-white z-10">
                <div class="flex items-center gap-3">
                    <h3 class="text-lg font-bold font-serif text-gray-900">Order Details</h3>
                    <span class="badge badge-info" id="modalOrderNo">#---</span>
                </div>
                <button onclick="closeModal()"
                    class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-6">
                <!-- Loading State -->
                <div id="modalLoading" class="text-center py-8">
                    <i class="fa-solid fa-spinner fa-spin text-2xl text-gray-400"></i>
                    <p class="text-sm text-gray-500 mt-2">Loading order details...</p>
                </div>

                <!-- Order Content (hidden until loaded) -->
                <div id="modalContent" class="hidden space-y-6">
                    <!-- Customer Info -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-3 rounded-xl bg-gray-50">
                            <p class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold mb-1">Order No.</p>
                            <p class="text-sm font-semibold text-gray-900 font-mono" id="modalOrderNoValue">---</p>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50">
                            <p class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold mb-1">Customer</p>
                            <p class="text-sm font-semibold text-gray-900" id="modalCustomerName">---</p>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50">
                            <p class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold mb-1">Email</p>
                            <p class="text-sm text-gray-700 truncate" id="modalCustomerEmail">---</p>
                        </div>
                        <div class="p-3 rounded-xl bg-gray-50">
                            <p class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold mb-1">Contact</p>
                            <p class="text-sm font-semibold text-gray-900" id="modalCustomerPhone">---</p>
                        </div>
                    </div>

                    <!-- Date -->
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Date Ordered</p>
                        <p class="text-sm text-gray-700" id="modalDate">---</p>
                    </div>

                    <!-- Items (Frame / Lens / Accessories) -->
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Order Items</p>
                        <div class="space-y-2" id="modalItemsContainer">
                            {{-- Populated by AJAX --}}
                        </div>
                    </div>

                    <!-- Total & Status Management -->
                    <div class="border-t border-gray-100 pt-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Total Amount</p>
                            <p class="text-2xl font-bold text-gray-900" id="modalTotalAmount">$0.00</p>
                        </div>
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                            <!-- Status Dropdown -->
                            <div class="flex items-center gap-2">
                                <label for="modalStatusSelect" class="text-xs text-gray-500 font-medium whitespace-nowrap">Status:</label>
                                <select id="modalStatusSelect"
                                    class="text-sm rounded-xl px-3 py-2.5 border border-gray-200 focus:ring-1 focus:ring-[#f4d03f] cursor-pointer bg-white min-w-[140px]">
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="ready">Ready</option>
                                    <option value="picked-up">Picked Up</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <button id="saveStatusBtn"
                                class="btn-dark !py-2.5 !px-5 !text-sm whitespace-nowrap">
                                <i class="fa-solid fa-floppy-disk"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Change Confirmation Modal -->
    <div id="statusConfirmModal"
        class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-[60]">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0"
            id="status-confirm-modal-content">
            <div class="p-8 text-center">
                <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center mx-auto mb-5">
                    <i class="fa-solid fa-envelope-circle-check text-amber-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold font-serif text-gray-900 mb-2">Change Order Status?</h3>
                <p class="text-gray-500 text-sm mb-2" id="statusConfirmMessage">
                    This will send an email notification to the customer about the status update.
                </p>
                <p class="text-xs text-gray-400 mb-8">
                    From: <span id="confirmOldStatus" class="font-semibold">---</span>
                    → To: <span id="confirmNewStatus" class="font-semibold">---</span>
                </p>
                <div class="flex gap-4">
                    <button onclick="closeStatusConfirmModal()"
                        class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium text-sm transition-colors">Cancel</button>
                    <button id="confirmStatusChangeBtn"
                        class="flex-1 py-3 bg-[#0F3D2A] hover:bg-[#1a5c3e] text-white rounded-xl font-medium text-sm transition-colors">
                        <i class="fa-solid fa-check mr-1"></i> Confirm & Send Email
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // ── State ──────────────────────────────────────────────────────
            let _currentOrderId = null;

            /**
             * Get the CSS badge class and dot color for a given status value.
             */
            function getStatusClasses(status) {
                const map = {
                    'pending': { badge: 'badge-warning', dot: 'bg-yellow-500', label: 'Pending' },
                    'processing': { badge: 'badge-info', dot: 'bg-blue-500', label: 'Processing' },
                    'ready': { badge: 'badge-success', dot: 'bg-green-500', label: 'Ready' },
                    'picked-up': { badge: 'badge-neutral', dot: 'bg-gray-500', label: 'Picked Up' },
                    'cancelled': { badge: 'badge-danger', dot: 'bg-red-500', label: 'Cancelled' },
                };
                return map[status] || map['pending'];
            }

            /**
             * Update the status badge in the table row.
             */
            function syncStatusBadge(row, newStatus) {
                const badge = row.querySelector('.status-badge');
                const dot = badge.querySelector('span:first-child');
                const text = badge.querySelector('.status-text');
                const cls = getStatusClasses(newStatus);

                badge.className = 'status-badge badge ' + cls.badge;
                dot.className = 'w-1.5 h-1.5 rounded-full ' + cls.dot;
                text.textContent = cls.label;
            }

            // ── Search with debounce + query string ───────────────────────
            let searchTimeout = null;
            document.getElementById('searchInput')?.addEventListener('keyup', function() {
                clearTimeout(searchTimeout);
                const value = this.value.trim();
                searchTimeout = setTimeout(() => {
                    const url = new URL(window.location.href);
                    if (value) {
                        url.searchParams.set('search', value);
                    } else {
                        url.searchParams.delete('search');
                    }
                    url.searchParams.delete('page');
                    window.location.href = url.toString();
                }, 400);
            });

            // ── Manage Modal ──────────────────────────────────────────────
            function openManageModal(orderId) {
                _currentOrderId = orderId;
                const modal = document.getElementById('orderDetailsModal');
                modal.classList.remove('hidden');

                // Show loading, hide content
                document.getElementById('modalLoading').classList.remove('hidden');
                document.getElementById('modalContent').classList.add('hidden');

                // Animate in
                setTimeout(() => {
                    document.getElementById('modal-content')
                        .classList.remove('scale-95', 'opacity-0');
                    document.getElementById('modal-content')
                        .classList.add('scale-100', 'opacity-100');
                }, 50);

                // Fetch order details
                fetch(`/admin/orders/${orderId}`)
                    .then(res => {
                        if (!res.ok) throw new Error('Failed to fetch order details');
                        return res.json();
                    })
                    .then(data => {
                        if (!data.success) throw new Error(data.message || 'Unknown error');
                        const order = data.order;
                        populateModal(order);
                    })
                    .catch(err => {
                        showToast(err.message || 'Failed to load order details', 'danger');
                        closeModal();
                    });
            }

            function populateModal(order) {
                // Order info
                document.getElementById('modalOrderNo').textContent = '#' + order.order_no;
                document.getElementById('modalOrderNoValue').textContent = order.order_no;
                document.getElementById('modalCustomerName').textContent = order.customer.name;
                document.getElementById('modalCustomerEmail').textContent = order.customer.email;
                document.getElementById('modalCustomerPhone').textContent = order.customer.phone_number;
                document.getElementById('modalDate').textContent = order.created_at;
                document.getElementById('modalTotalAmount').textContent = '₱' + order.total_amount;

                // Items
                document.getElementById('modalItemsContainer').innerHTML = order.items_html;

                // Status dropdown
                const statusSelect = document.getElementById('modalStatusSelect');
                statusSelect.value = order.status;

                // If terminal status, disable the dropdown
                const isTerminal = ['picked-up', 'cancelled'].includes(order.status);
                statusSelect.disabled = isTerminal;
                if (isTerminal) {
                    statusSelect.classList.add('opacity-60', 'cursor-not-allowed');
                    document.getElementById('saveStatusBtn').disabled = true;
                    document.getElementById('saveStatusBtn').classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    statusSelect.classList.remove('opacity-60', 'cursor-not-allowed');
                    document.getElementById('saveStatusBtn').disabled = false;
                    document.getElementById('saveStatusBtn').classList.remove('opacity-50', 'cursor-not-allowed');
                }

                // Hide loading, show content
                document.getElementById('modalLoading').classList.add('hidden');
                document.getElementById('modalContent').classList.remove('hidden');
            }

            function closeModal() {
                const modal = document.getElementById('orderDetailsModal');
                const content = document.getElementById('modal-content');
                content.classList.add('scale-95', 'opacity-0');
                content.classList.remove('scale-100', 'opacity-100');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.getElementById('modalContent').classList.add('hidden');
                    document.getElementById('modalLoading').classList.remove('hidden');
                }, 200);
                _currentOrderId = null;
            }

            // ── Save Status Change ────────────────────────────────────────
            document.getElementById('saveStatusBtn')?.addEventListener('click', function() {
                const statusSelect = document.getElementById('modalStatusSelect');
                const newStatus = statusSelect.value;
                const row = document.querySelector(`.order-row[data-id="${_currentOrderId}"]`);
                if (!row) return;

                const currentStatus = row.dataset.status;

                // If same status, do nothing
                if (newStatus === currentStatus) {
                    showToast('No changes to save.', 'info');
                    return;
                }

                // Show confirmation modal
                const oldLabel = getStatusClasses(currentStatus).label;
                const newLabel = getStatusClasses(newStatus).label;

                document.getElementById('confirmOldStatus').textContent = oldLabel;
                document.getElementById('confirmNewStatus').textContent = newLabel;
                document.getElementById('statusConfirmMessage').innerHTML =
                    'You are about to change the status from <strong>' + oldLabel + '</strong> to <strong>' + newLabel +
                    '</strong>. An email notification will be sent to the customer.';

                const confirmModal = document.getElementById('statusConfirmModal');
                confirmModal.classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('status-confirm-modal-content')
                        .classList.remove('scale-95', 'opacity-0');
                    document.getElementById('status-confirm-modal-content')
                        .classList.add('scale-100', 'opacity-100');
                }, 50);

                // Store pending action
                window._pendingStatusChange = {
                    orderId: _currentOrderId,
                    newStatus: newStatus,
                    row: row,
                };
            });

            document.getElementById('confirmStatusChangeBtn')?.addEventListener('click', function() {
                const pending = window._pendingStatusChange;
                if (!pending) return;

                const btn = this;
                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-1"></i> Saving...';

                fetch(`/admin/orders/${pending.orderId}/status`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ status: pending.newStatus }),
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (!data.success) throw new Error(data.message || 'Failed to update status');

                        // Update the table row
                        const row = pending.row;
                        row.dataset.status = pending.newStatus;
                        syncStatusBadge(row, pending.newStatus);

                        // Update modal state
                        const statusSelect = document.getElementById('modalStatusSelect');
                        const isTerminal = ['picked-up', 'cancelled'].includes(pending.newStatus);
                        if (isTerminal) {
                            statusSelect.disabled = true;
                            statusSelect.classList.add('opacity-60', 'cursor-not-allowed');
                            document.getElementById('saveStatusBtn').disabled = true;
                            document.getElementById('saveStatusBtn').classList.add('opacity-50', 'cursor-not-allowed');
                        }

                        showToast(data.message || 'Status updated successfully!', 'success');

                        // Close confirmation modal
                        closeStatusConfirmModal();

                        // Close the main modal after a brief delay
                        setTimeout(() => closeModal(), 800);
                    })
                    .catch(err => {
                        showToast(err.message || 'Failed to update status', 'danger');
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fa-solid fa-check mr-1"></i> Confirm & Send Email';
                        window._pendingStatusChange = null;
                    });
            });

            // ── Modal Close Helpers ───────────────────────────────────────
            function closeStatusConfirmModal() {
                window._pendingStatusChange = null;
                const modal = document.getElementById('statusConfirmModal');
                const content = document.getElementById('status-confirm-modal-content');
                content.classList.add('scale-95', 'opacity-0');
                content.classList.remove('scale-100', 'opacity-100');
                setTimeout(() => modal.classList.add('hidden'), 200);
            }

            // Close modals on outside click
            document.getElementById('orderDetailsModal')?.addEventListener('click', function(e) {
                if (e.target === this) closeModal();
            });
            document.getElementById('statusConfirmModal')?.addEventListener('click', function(e) {
                if (e.target === this) closeStatusConfirmModal();
            });

            // ── Toast System ──────────────────────────────────────────────
            function showToast(message, type = 'success') {
                const existing = document.querySelector('.toast-notification');
                if (existing) existing.remove();

                const toast = document.createElement('div');
                toast.className =
                    `toast-notification fixed top-6 right-6 z-[100] px-5 py-3.5 rounded-xl shadow-2xl text-sm font-medium flex items-center gap-3 transition-all duration-500`;

                const colors = {
                    success: 'bg-green-50 text-green-800 border border-green-200',
                    danger: 'bg-red-50 text-red-800 border border-red-200',
                    info: 'bg-blue-50 text-blue-800 border border-blue-200',
                };

                toast.className += ' ' + (colors[type] || colors.success);

                const icons = {
                    success: 'fa-circle-check text-green-600',
                    danger: 'fa-circle-exclamation text-red-600',
                    info: 'fa-circle-info text-blue-600',
                };

                toast.innerHTML = `
                    <i class="fa-solid ${icons[type] || icons.success}"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.remove()" class="ml-2 opacity-50 hover:opacity-100">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                `;

                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100px)';
                    setTimeout(() => toast.remove(), 300);
                }, 4000);
            }
        </script>
    @endpush
@endsection
