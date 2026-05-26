@extends('layouts.admin')

@section('title', 'Product Movements - ' . $product->name . ' - Optiqueue')

@section('page-header')
    <div class="flex items-end justify-between w-full gap-5">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.products.edit', $product->id) }}"
                class="w-9 h-9 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 hover:text-gray-700 transition-all">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <p class="text-xs text-gray-500 font-medium">Product Movements</p>
                <h2 class="text-xl lg:text-2xl font-bold font-serif text-gray-900">{{ $product->name }}</h2>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="badge badge-info text-[10px]">
                <i class="fa-solid fa-box"></i>
                {{ $product->stocks }} in stock
            </span>
        </div>
    </div>
@endsection

@section('header-actions')
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-ghost !py-2 !px-4 !text-xs !rounded-xl">
            <i class="fa-solid fa-pen-to-square"></i>
            <span class="hidden sm:inline">Edit Product</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="p-6 lg:p-8">

        <!-- Tabs -->
        <div class="mb-8">
            <div class="flex border-b border-gray-200 gap-1">
                <a href="{{ route('admin.products.edit', $product->id) }}" id="tab-0"
                    class="tab-button px-6 py-3.5 text-sm font-semibold text-gray-500 hover:text-gray-700 transition-all duration-300 border-b-2 border-transparent hover:border-gray-300 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Product Details
                </a>
                <a href="{{ route('admin.products.movements', $product->id) }}" id="tab-1"
                    class="tab-button px-6 py-3.5 text-sm font-semibold transition-all duration-300 border-b-2 border-[#f4d03f] text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-arrows-up-down"></i>
                    Product Movement
                </a>
            </div>
        </div>

        <!-- Product Movement Content -->
        <div class="space-y-6">

            <!-- Movement Summary -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 stagger-children">
                <div class="admin-card p-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                            <i class="fa-solid fa-arrow-up text-green-600"></i>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-gray-900" id="totalIn">{{ $totalIn }}</div>
                            <div class="text-xs text-gray-500">Stock In</div>
                        </div>
                    </div>
                </div>
                <div class="admin-card p-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center">
                            <i class="fa-solid fa-arrow-down text-red-600"></i>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-gray-900" id="totalOut">{{ $totalOut }}</div>
                            <div class="text-xs text-gray-500">Stock Out</div>
                        </div>
                    </div>
                </div>
                <div class="admin-card p-5">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                            <i class="fa-solid fa-box text-blue-600"></i>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-gray-900" id="currentStock">{{ $product->stocks }}</div>
                            <div class="text-xs text-gray-500">Current Stock</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Movement Table -->
            <div class="admin-card overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold font-serif text-gray-900">Movement History</h3>
                        <p class="text-[11px] text-gray-500 mt-0.5">All stock changes for this product</p>
                    </div>
                    <button onclick="showAddMovementModal()" class="btn-dark !py-2 !px-4 !text-xs !rounded-xl">
                        <i class="fa-solid fa-plus"></i>
                        Add Movement
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full admin-table">
                        <thead>
                            <tr>
                                <th>Movement Type</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Reference</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="movementsTableBody">
                            @forelse ($movements as $movement)
                                <tr>
                                    <td>
                                        @if ($movement->movement_type === 'in')
                                            <span class="badge badge-success">
                                                <i class="fa-solid fa-arrow-up"></i>
                                                Stock In
                                            </span>
                                        @elseif ($movement->movement_type === 'out')
                                            <span class="badge badge-danger">
                                                <i class="fa-solid fa-arrow-down"></i>
                                                Stock Out
                                            </span>
                                        @else
                                            <span class="badge badge-warning">
                                                <i class="fa-solid fa-triangle-exclamation"></i>
                                                Adjustment
                                            </span>
                                        @endif
                                    </td>
                                    <td class="font-semibold {{ $movement->movement_type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $movement->movement_type === 'in' ? '+' : '-' }}{{ $movement->quantity }}
                                    </td>
                                    <td class="text-gray-500">{{ ucwords(str_replace('_', ' ', $movement->movement_category)) }}</td>
                                    <td class="text-gray-400 font-mono text-xs">
                                        {{ $movement->reference_id ?? '—' }}
                                    </td>
                                    <td class="text-gray-400 text-xs">{{ $movement->movement_date->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-10 text-gray-400">
                                        <i class="fa-solid fa-box-open text-2xl mb-2 block"></i>
                                        No movements recorded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Movement Modal -->
    <div id="addMovementModal"
        class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 transform transition-all duration-300 scale-95 opacity-0"
            id="movement-modal-content">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b border-gray-100 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center">
                        <i class="fa-solid fa-arrows-up-down text-amber-600"></i>
                    </div>
                    <h3 class="text-lg font-bold font-serif text-gray-900">Add Movement</h3>
                </div>
                <button onclick="closeAddMovementModal()"
                    class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <form id="addMovementForm">
                @csrf
                <div class="p-6 space-y-5">

                    <!-- Movement Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Movement Type <span class="text-red-500">*</span></label>
                        <div class="flex gap-3">
                            <label
                                class="flex-1 flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-green-400 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50/50 justify-center">
                                <input type="radio" name="movement_type" value="in" checked onchange="updateMovementCategories()" class="accent-green-500">
                                <i class="fa-solid fa-arrow-up text-green-600"></i>
                                <span class="text-sm font-medium">Stock In</span>
                            </label>
                            <label
                                class="flex-1 flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-red-400 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50/50 justify-center">
                                <input type="radio" name="movement_type" value="out" onchange="updateMovementCategories()" class="accent-red-500">
                                <i class="fa-solid fa-arrow-down text-red-600"></i>
                                <span class="text-sm font-medium">Stock Out</span>
                            </label>
                        </div>
                    </div>

                    <!-- Movement Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Category <span class="text-red-500">*</span></label>
                        <select name="movement_category" id="movementCategory" class="admin-input" required>
                            <option value="">Select category...</option>
                            <option value="purchase_order">Purchase Order</option>
                            <option value="initial_stock">Initial Stock</option>
                            <option value="return_from_customer">Return from Customer</option>
                            <option value="transfer_in">Transfer In</option>
                        </select>
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Quantity <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" min="1" class="admin-input" placeholder="Enter quantity" required>
                    </div>

                    <!-- Movement Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Movement Date <span class="text-red-500">*</span></label>
                        <input type="date" name="movement_date" class="admin-input" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <!-- Reference ID -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Reference ID</label>
                        <input type="text" name="reference_id" class="admin-input" placeholder="e.g. PO-2026-001, ORD-12345">
                        <p class="text-xs text-gray-400 mt-1">Optional: Order #, PO number, transfer slip, etc.</p>
                    </div>

                    <!-- Actions -->
                    <div class="pt-4 flex gap-3 border-t border-gray-100">
                        <button type="button" onclick="closeAddMovementModal()" class="flex-1 btn-ghost justify-center !py-3">Cancel</button>
                        <button type="submit" id="submitMovementBtn" class="flex-1 btn-primary justify-center !py-3">
                            <i class="fa-solid fa-check"></i>
                            Record Movement
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Movement category options per type
            const categoryOptions = {
                'in': [
                    { value: 'purchase_order', label: 'Purchase Order' },
                    { value: 'initial_stock', label: 'Initial Stock' },
                    { value: 'return_from_customer', label: 'Return from Customer' },
                    { value: 'transfer_in', label: 'Transfer In' },
                ],
                'out': [
                    { value: 'sale', label: 'Sale' },
                    { value: 'damage', label: 'Damaged / Broken' },
                    { value: 'expired', label: 'Expired / Obsolete' },
                    { value: 'sample', label: 'Sample / Display' },
                    { value: 'transfer_out', label: 'Transfer Out' },
                ],
            };

            function updateMovementCategories() {
                const selectedType = document.querySelector('input[name="movement_type"]:checked').value;
                const select = document.getElementById('movementCategory');
                const options = categoryOptions[selectedType] || [];

                select.innerHTML = '<option value="">Select category...</option>';
                options.forEach(opt => {
                    const option = document.createElement('option');
                    option.value = opt.value;
                    option.textContent = opt.label;
                    select.appendChild(option);
                });
            }

            function showAddMovementModal() {
                const modal = document.getElementById('addMovementModal');
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                updateMovementCategories();
                setTimeout(() => {
                    const content = document.getElementById('movement-modal-content');
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 50);
            }

            function closeAddMovementModal() {
                const modal = document.getElementById('addMovementModal');
                const content = document.getElementById('movement-modal-content');
                content.classList.add('scale-95', 'opacity-0');
                content.classList.remove('scale-100', 'opacity-100');
                document.body.style.overflow = '';
                setTimeout(() => modal.classList.add('hidden'), 200);
            }

            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('addMovementForm');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        addMovement();
                    });
                }
            });

            function addMovement() {
                const form = document.getElementById('addMovementForm');
                const formData = new FormData(form);
                formData.append('_token', document.querySelector('input[name="_token"]').value);

                const submitBtn = document.getElementById('submitMovementBtn');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

                fetch('{{ route('admin.products.movements.store', $product->id) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeAddMovementModal();
                        showToast('✅ ' + data.message, 'success');
                        // Reload to show updated movements
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        showToast('❌ Error: ' + (data.message || 'Something went wrong'), 'danger');
                    }
                })
                .catch(error => {
                    showToast('❌ Network error. Please try again.', 'danger');
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            }

            // Toast notification
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

            // Close modal on outside click
            document.getElementById('addMovementModal').addEventListener('click', function(e) {
                if (e.target === this) closeAddMovementModal();
            });
        </script>
    @endpush
@endsection
