@extends('layouts.admin')

@section('title', 'Manage Orders - Optiqueue')

@section('page-header')
    <div>
        <h2 class="text-xl lg:text-2xl font-bold font-serif text-gray-900">Orders</h2>
        <p class="text-sm text-gray-500 mt-0.5">Manage and track customer orders</p>
    </div>
@endsection

@section('header-actions')
    <div class="flex items-center gap-3">
        <div class="relative">
            <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" id="searchInput" placeholder="Search ticket no..."
                class="admin-input !w-56 !py-2 !pl-9 !pr-3 !text-sm !rounded-xl bg-gray-50">
        </div>
        <button class="btn-ghost !py-2 !px-3 !text-xs">
            <i class="fa-solid fa-filter"></i>
            <span class="hidden sm:inline">Filter</span>
        </button>
        <button class="btn-dark !py-2 !px-4 !text-xs">
            <i class="fa-solid fa-arrow-down"></i>
            <span class="hidden sm:inline">Export</span>
        </button>
    </div>
@endsection

@section('content')
    <div class="p-6 lg:p-8 space-y-6">

        <!-- Orders Overview Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 stagger-children">
            <div class="admin-card p-4 lg:p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                        <i class="fa-solid fa-receipt text-blue-600"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-gray-900">1,284</div>
                        <div class="text-xs text-gray-500">Total Orders</div>
                    </div>
                </div>
            </div>
            <div class="admin-card p-4 lg:p-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                        <i class="fa-solid fa-gear text-amber-600"></i>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-gray-900">342</div>
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
                        <div class="text-lg font-bold text-gray-900">128</div>
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
                        <div class="text-lg font-bold text-gray-900">814</div>
                        <div class="text-xs text-gray-500">Picked Up</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Filter Tabs -->
        <div class="flex flex-wrap gap-2">
            <button
                class="status-filter active px-4 py-2 rounded-xl bg-[#0F3D2A] text-white text-xs font-semibold transition-all">
                All Orders
            </button>
            <button
                class="status-filter px-4 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 text-xs font-medium transition-all">
                Processing
            </button>
            <button
                class="status-filter px-4 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 text-xs font-medium transition-all">
                Ready
            </button>
            <button
                class="status-filter px-4 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 text-xs font-medium transition-all">
                Picked Up
            </button>
            <button
                class="status-filter px-4 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 text-xs font-medium transition-all">
                Cancelled
            </button>
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
                        @foreach (range(1, 8) as $i)
                            @php
                                $statuses = ['processing', 'ready', 'picked-up', 'cancelled'];
                                $status = $statuses[$i % 4];
                                $amounts = [248, 186, 324, 159, 412, 275, 198, 350];
                                $isTerminal = in_array($status, ['picked-up', 'cancelled']);
                            @endphp
                            <tr class="order-row" data-status="{{ $status }}">
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gradient-to-br from-[#0F3D2A] to-[#1a5c3e] flex items-center justify-center text-white text-xs font-bold">
                                            {{ substr('Customer ' . $i, 0, 2) }}
                                        </div>
                                        <span class="font-medium text-gray-900">Customer {{ $i }}</span>
                                    </div>
                                </td>
                                <td class="text-gray-500">customer{{ $i }}@example.com</td>
                                <td class="font-mono text-sm text-gray-700">0954{{ 400 + $i }}</td>
                                <td class="font-semibold text-gray-900">${{ $amounts[$i - 1] }}.00</td>
                                <td>
                                    <span
                                        class="status-badge badge
                                        badge-{{ $status === 'ready' ? 'success' : ($status === 'processing' ? 'info' : ($status === 'picked-up' ? 'neutral' : 'danger')) }}">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full
                                            {{ $status === 'ready' ? 'bg-green-500' : ($status === 'processing' ? 'bg-blue-500' : ($status === 'picked-up' ? 'bg-gray-500' : 'bg-red-500')) }}">
                                        </span>
                                        <span class="status-text">{{ ucfirst($status) }}</span>
                                    </span>
                                </td>
                                <td>
                                    <div class="flex items-center gap-2 actions-cell">
                                        @if ($isTerminal)
                                            <div
                                                class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 text-xs font-medium">
                                                <i class="fa-solid fa-triangle-exclamation"></i>
                                                <span>Final —
                                                    {{ $status === 'picked-up' ? 'Picked Up' : 'Cancelled' }}</span>
                                            </div>
                                        @else
                                            <button onclick="showOrderDetails({{ $i }})"
                                                class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-800 text-xs font-medium transition-all">
                                                <i class="fa-solid fa-eye mr-1"></i>View
                                            </button>
                                            <select onchange="updateStatus(this, {{ $i }})"
                                                class="status-select text-xs rounded-lg px-2 py-1.5 border border-gray-200 focus:ring-1 focus:ring-[#f4d03f] cursor-pointer bg-white">
                                                <option value="processing"
                                                    {{ $status === 'processing' ? 'selected' : '' }}>
                                                    Processing</option>
                                                <option value="ready" {{ $status === 'ready' ? 'selected' : '' }}>Ready
                                                </option>
                                                <option value="picked-up" {{ $status === 'picked-up' ? 'selected' : '' }}>
                                                    Picked Up</option>
                                                <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>
                                                    Cancelled</option>
                                            </select>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Table Footer -->
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                <span>Showing 1 to 8 of 1,284 orders</span>
                <div class="flex items-center gap-2">
                    <button class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i>
                    </button>
                    <span class="px-3 py-1.5 rounded-lg bg-[#0F3D2A] text-white font-medium">1</span>
                    <button class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">2</button>
                    <button class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">3</button>
                    <span class="px-1">...</span>
                    <button class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">42</button>
                    <button class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="orderDetailsModal"
        class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 transform transition-all duration-300 scale-95 opacity-0"
            id="modal-content">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b border-gray-100 px-6 py-4">
                <div class="flex items-center gap-3">
                    <h3 class="text-lg font-bold font-serif text-gray-900">Order Details</h3>
                    <span class="badge badge-info">#095402</span>
                </div>
                <button onclick="closeModal()"
                    class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-6">
                <!-- Customer Info -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-3 rounded-xl bg-gray-50">
                        <p class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold mb-1">Order No.</p>
                        <p class="text-sm font-semibold text-gray-900 font-mono">095402</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50">
                        <p class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold mb-1">Customer</p>
                        <p class="text-sm font-semibold text-gray-900">Sample Name</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50">
                        <p class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold mb-1">Email</p>
                        <p class="text-sm text-gray-700 truncate">sample@gmail.com</p>
                    </div>
                    <div class="p-3 rounded-xl bg-gray-50">
                        <p class="text-[10px] uppercase tracking-wider text-gray-500 font-semibold mb-1">Frame</p>
                        <p class="text-sm font-semibold text-gray-900">Aurel - Burgundy</p>
                    </div>
                </div>

                <!-- Lens Selection -->
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Lens Options</p>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                        @php
                            $lenses = ['Blue Lens', 'Transition Lens', 'Computer Progressive', 'Ultra Thin'];
                        @endphp
                        @foreach ($lenses as $idx => $lens)
                            <label
                                class="flex items-center gap-2.5 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#f4d03f] transition-colors has-[:checked]:border-[#f4d03f] has-[:checked]:bg-amber-50/50">
                                <input type="radio" name="modal-lens" {{ $idx === 0 ? 'checked' : '' }}
                                    class="accent-[#f4d03f]">
                                <span class="text-sm">{{ $lens }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Accessories -->
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-3">Accessories</p>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                        @php
                            $accessories = ['Default', 'Luxe Case', 'Eyeglass Chain', 'Cleaning Spray'];
                        @endphp
                        @foreach ($accessories as $idx => $acc)
                            <label
                                class="flex items-center gap-2.5 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#f4d03f] transition-colors has-[:checked]:border-[#f4d03f] has-[:checked]:bg-amber-50/50">
                                <input type="radio" name="modal-accessory" {{ $idx === 0 ? 'checked' : '' }}
                                    class="accent-[#f4d03f]">
                                <span class="text-sm">{{ $acc }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Total & Actions -->
                <div class="border-t border-gray-100 pt-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Total Amount</p>
                        <p class="text-2xl font-bold text-gray-900">$248.00</p>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="closeModal()" class="btn-ghost !py-2.5 !px-5 !text-sm">Close</button>
                        <button class="btn-dark !py-2.5 !px-5 !text-sm">
                            <i class="fa-solid fa-check"></i> Update Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pickup Confirmation Modal -->
    <div id="pickupModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0"
            id="pickup-modal-content">
            <div class="p-8 text-center">
                <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center mx-auto mb-5">
                    <i class="fa-solid fa-check text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold font-serif text-gray-900 mb-2">Mark as Ready for Pickup?</h3>
                <p class="text-gray-500 text-sm mb-8">
                    The customer will be notified via email. This action can be reversed.
                </p>
                <div class="flex gap-4">
                    <button onclick="closePickupModal()"
                        class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium text-sm transition-colors">Cancel</button>
                    <button onclick="confirmPickup()"
                        class="flex-1 py-3 bg-[#0F3D2A] hover:bg-[#1a5c3e] text-white rounded-xl font-medium text-sm transition-colors">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Terminal Status Confirmation Modal (Picked Up / Cancelled) -->
    <div id="terminalConfirmModal"
        class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0"
            id="terminal-modal-content">
            <div class="p-8 text-center">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-5" id="terminalModalIcon">
                    <i class="fa-solid fa-triangle-exclamation text-2xl" id="terminalModalIconEl"></i>
                </div>
                <h3 class="text-xl font-bold font-serif text-gray-900 mb-2" id="terminalModalTitle">Confirm Action</h3>
                <p class="text-gray-500 text-sm mb-8" id="terminalModalMessage">
                    This action cannot be undone. Are you sure?
                </p>
                <div class="flex gap-4">
                    <button onclick="closeTerminalModal()"
                        class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium text-sm transition-colors">Cancel</button>
                    <button onclick="confirmTerminalAction()"
                        class="flex-1 py-3 text-white rounded-xl font-medium text-sm transition-colors"
                        id="terminalModalConfirmBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            /**
             * Get the CSS badge class and dot color for a given status value.
             */
            function getStatusClasses(status) {
                const map = {
                    'processing': {
                        badge: 'badge-info',
                        dot: 'bg-blue-500',
                        label: 'Processing'
                    },
                    'ready': {
                        badge: 'badge-success',
                        dot: 'bg-green-500',
                        label: 'Ready'
                    },
                    'picked-up': {
                        badge: 'badge-neutral',
                        dot: 'bg-gray-500',
                        label: 'Picked Up'
                    },
                    'cancelled': {
                        badge: 'badge-danger',
                        dot: 'bg-red-500',
                        label: 'Cancelled'
                    },
                };
                return map[status] || map['processing'];
            }

            /**
             * Update the status badge in the row's Status column to match the select value.
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

            /**
             * Replace the actions cell with a locked "Final" warning when terminal status is reached.
             */
            function lockActionsCell(row, status) {
                const actionsCell = row.querySelector('.actions-cell');
                const label = status === 'picked-up' ? 'Picked Up' : 'Cancelled';
                actionsCell.innerHTML = `
                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 text-xs font-medium">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>Final — ${label}</span>
                    </div>
                `;
            }

            /**
             * Shared function to finalize a terminal status change (picked-up / cancelled).
             */
            function applyTerminalStatus(row, id, status) {
                syncStatusBadge(row, status);
                lockActionsCell(row, status);
                row.dataset.status = status;
                const cls = getStatusClasses(status);
                showToast(`Order #0954${400 + id} marked as ${cls.label}`, status === 'cancelled' ? 'danger' : 'success');
            }

            /**
             * Handle status dropdown changes.
             */
            function updateStatus(select, id) {
                const row = select.closest('tr');
                const value = select.value;

                // === Ready → Show pickup confirmation modal ===
                if (value === 'ready') {
                    const modal = document.getElementById('pickupModal');
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        document.getElementById('pickup-modal-content')
                            .classList.remove('scale-95', 'opacity-0');
                        document.getElementById('pickup-modal-content')
                            .classList.add('scale-100', 'opacity-100');
                    }, 50);

                    window._pendingAction = {
                        row,
                        select,
                        status: 'ready'
                    };
                    return;
                }

                // === Picked Up / Cancelled → Show terminal confirmation modal ===
                if (value === 'picked-up' || value === 'cancelled') {
                    const isCancelled = value === 'cancelled';
                    const title = isCancelled ? 'Cancel This Order?' : 'Mark as Picked Up?';
                    const message = isCancelled ?
                        'This order will be cancelled and cannot be reversed. The customer will be notified.' :
                        'This order will be marked as picked up. The status cannot be changed afterward.';
                    const iconColor = isCancelled ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600';
                    const icon = isCancelled ? 'fa-ban' : 'fa-box';
                    const btnColor = isCancelled ? 'bg-red-600 hover:bg-red-700' : 'bg-amber-600 hover:bg-amber-700';

                    document.getElementById('terminalModalIcon').className =
                        'w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-5 ' + iconColor;
                    document.getElementById('terminalModalIconEl').className = 'fa-solid ' + icon + ' text-2xl';
                    document.getElementById('terminalModalTitle').textContent = title;
                    document.getElementById('terminalModalMessage').textContent = message;
                    document.getElementById('terminalModalConfirmBtn').className =
                        'flex-1 py-3 text-white rounded-xl font-medium text-sm transition-colors ' + btnColor;

                    const modal = document.getElementById('terminalConfirmModal');
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        document.getElementById('terminal-modal-content')
                            .classList.remove('scale-95', 'opacity-0');
                        document.getElementById('terminal-modal-content')
                            .classList.add('scale-100', 'opacity-100');
                    }, 50);

                    window._pendingAction = {
                        row,
                        select,
                        id,
                        status: value
                    };
                    return;
                }

                // === Non-terminal status (processing) — update immediately ===
                syncStatusBadge(row, value);
                row.dataset.status = value;
                showToast(`Order #0954${400 + id} updated to ${getStatusClasses(value).label}`, 'success');
            }

            /**
             * Confirm "Ready for Pickup" from the pickup modal.
             */
            function confirmPickup() {
                const pending = window._pendingAction;
                if (!pending || pending.status !== 'ready') return;

                const {
                    row,
                    select
                } = pending;
                const value = 'ready';
                syncStatusBadge(row, value);
                row.dataset.status = value;
                showToast('✅ Order marked as Ready for Pickup! Email notification sent.', 'success');
                closePickupModal();
                window._pendingAction = null;
            }

            /**
             * Confirm terminal action (Picked Up / Cancelled).
             */
            function confirmTerminalAction() {
                const pending = window._pendingAction;
                if (!pending) return;
                applyTerminalStatus(pending.row, pending.id, pending.status);
                closeTerminalModal();
                window._pendingAction = null;
            }

            /**
             * Confirm "Ready for Pickup".
             */
            function confirmPickup() {
                const pending = window._pendingAction;
                if (!pending || pending.status !== 'ready') return;

                const {
                    row,
                    select
                } = pending;
                syncStatusBadge(row, 'ready');
                row.dataset.status = 'ready';
                showToast('✅ Order marked as Ready for Pickup! Email notification sent.', 'success');
                closePickupModal();
                window._pendingAction = null;
            }

            // ---------- Modal helpers ----------

            function showOrderDetails(id) {
                const modal = document.getElementById('orderDetailsModal');
                modal.classList.remove('hidden');
                setTimeout(() => {
                    const content = document.getElementById('modal-content');
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 50);
            }

            function closeModal() {
                const modal = document.getElementById('orderDetailsModal');
                const content = document.getElementById('modal-content');
                content.classList.add('scale-95', 'opacity-0');
                content.classList.remove('scale-100', 'opacity-100');
                setTimeout(() => modal.classList.add('hidden'), 200);
            }

            function closePickupModal() {
                const pending = window._pendingAction;
                if (pending && pending.status === 'ready') {
                    pending.select.value = pending.row.dataset.status || 'processing';
                }
                window._pendingAction = null;

                const modal = document.getElementById('pickupModal');
                const content = document.getElementById('pickup-modal-content');
                content.classList.add('scale-95', 'opacity-0');
                content.classList.remove('scale-100', 'opacity-100');
                setTimeout(() => modal.classList.add('hidden'), 200);
            }

            function closeTerminalModal() {
                const pending = window._pendingAction;
                if (pending && (pending.status === 'picked-up' || pending.status === 'cancelled')) {
                    pending.select.value = pending.row.dataset.status || 'processing';
                }
                window._pendingAction = null;

                const modal = document.getElementById('terminalConfirmModal');
                const content = document.getElementById('terminal-modal-content');
                content.classList.add('scale-95', 'opacity-0');
                content.classList.remove('scale-100', 'opacity-100');
                setTimeout(() => modal.classList.add('hidden'), 200);
            }

            // ---------- Toast system ----------

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

            // ---------- Event bindings ----------

            // Close modals on outside click
            document.getElementById('orderDetailsModal')?.addEventListener('click', function(e) {
                if (e.target === this) closeModal();
            });
            document.getElementById('pickupModal')?.addEventListener('click', function(e) {
                if (e.target === this) closePickupModal();
            });
            document.getElementById('terminalConfirmModal')?.addEventListener('click', function(e) {
                if (e.target === this) closeTerminalModal();
            });

            // Status filter tabs
            document.querySelectorAll('.status-filter').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.status-filter').forEach(b => {
                        b.classList.remove('bg-[#0F3D2A]', 'text-white');
                        b.classList.add('bg-gray-100', 'text-gray-600');
                    });
                    this.classList.remove('bg-gray-100', 'text-gray-600');
                    this.classList.add('bg-[#0F3D2A]', 'text-white');

                    const filter = this.textContent.trim().toLowerCase();
                    document.querySelectorAll('.order-row').forEach(row => {
                        const status = (row.dataset.status || '').toLowerCase();
                        if (filter === 'all orders') {
                            row.style.display = '';
                        } else {
                            const normalizedFilter = filter.replace(/\s+/g, '-');
                            row.style.display = status === normalizedFilter ? '' : 'none';
                        }
                    });
                });
            });

            // Search functionality
            document.getElementById('searchInput')?.addEventListener('keyup', function() {
                const query = this.value.toLowerCase();
                document.querySelectorAll('.order-row').forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(query) ? '' : 'none';
                });
            });
        </script>
    @endpush
@endsection
