@extends('layouts.admin')

@section('title', 'Products - Optiqueue')

@section('page-header')
    <div>
        <h2 class="text-xl lg:text-2xl font-bold font-serif text-gray-900">Products</h2>
        <p class="text-sm text-gray-500 mt-0.5">Manage your product catalog</p>
    </div>
@endsection

@section('header-actions')
    <div class="flex items-center gap-3">
        <div class="relative">
            <form method="GET" action="{{ route('admin.products') }}" id="searchForm">
                {{-- Preserve the current filter when searching --}}
                @if ($currentFilter !== 'all')
                    <input type="hidden" name="filter" value="{{ $currentFilter }}">
                @endif
                <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" placeholder="Search products..."
                    value="{{ $currentSearch }}"
                    class="admin-input !w-48 !py-2 !pl-9 !pr-3 !text-sm !rounded-xl bg-gray-50"
                    onkeydown="if(event.key === 'Enter') this.closest('form').submit();">
            </form>
        </div>
        <button onclick="showAddProductModal()" class="btn-primary !py-2 !px-4 !text-xs !rounded-xl">
            <i class="fa-solid fa-plus"></i>
            <span>Add Product</span>
        </button>
    </div>
@endsection

@section('content')
    <div class="p-6 lg:p-8 space-y-6">

        <!-- Category Quick Filters (server-side via URL query) -->
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.products', ['search' => $currentSearch]) }}"
                class="px-4 py-2 rounded-xl text-xs font-semibold transition-all
                {{ $currentFilter === 'all' ? 'bg-[#0F3D2A] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 font-medium' }}">
                All Products
            </a>
            <a href="{{ route('admin.products', ['filter' => 'frame', 'search' => $currentSearch]) }}"
                class="px-4 py-2 rounded-xl text-xs font-semibold transition-all
                {{ $currentFilter === 'frame' ? 'bg-[#0F3D2A] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 font-medium' }}">
                <i class="fa-solid fa-glasses mr-1.5"></i>Frames
            </a>
            <a href="{{ route('admin.products', ['filter' => 'lens', 'search' => $currentSearch]) }}"
                class="px-4 py-2 rounded-xl text-xs font-semibold transition-all
                {{ $currentFilter === 'lens' ? 'bg-[#0F3D2A] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 font-medium' }}">
                <i class="fa-solid fa-eye mr-1.5"></i>Lenses
            </a>
            <a href="{{ route('admin.products', ['filter' => 'accessory', 'search' => $currentSearch]) }}"
                class="px-4 py-2 rounded-xl text-xs font-semibold transition-all
                {{ $currentFilter === 'accessory' ? 'bg-[#0F3D2A] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 font-medium' }}">
                <i class="fa-solid fa-bag-shopping mr-1.5"></i>Accessories
            </a>
        </div>

        <!-- Products Grid -->
        @if ($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 stagger-children" id="productsGrid">
                @foreach ($products as $product)
                    <x-admin.product-card :product="$product" />
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <i class="fa-solid fa-box-open text-3xl text-gray-300"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-500 mb-1">No products found</h3>
                <p class="text-sm text-gray-400">
                    @if ($currentFilter !== 'all' || $currentSearch)
                        Try adjusting your filters or search term.
                    @else
                        No products have been added yet.
                    @endif
                </p>
            </div>
        @endif
    </div>

    <!-- Add New Product Modal -->
    <div id="addProductModal"
        class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 transform transition-all duration-300 scale-95 opacity-0"
            id="add-modal-content">
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b border-gray-100 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center">
                        <i class="fa-solid fa-plus text-amber-600"></i>
                    </div>
                    <h3 class="text-lg font-bold font-serif text-gray-900">Add New Product</h3>
                </div>
                <button onclick="closeAddModal()"
                    class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-5">
                <!-- Product Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Name</label>
                    <input type="text" id="productName" class="admin-input" placeholder="e.g. Aurel Burgundy Gold">
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Category</label>
                    <div class="flex gap-3">
                        <label
                            class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#f4d03f] transition-colors has-[:checked]:border-[#f4d03f] has-[:checked]:bg-amber-50/50 flex-1 justify-center">
                            <input type="radio" name="category" value="frame" checked class="accent-[#f4d03f]">
                            <i class="fa-solid fa-glasses text-gray-400"></i>
                            <span class="text-sm font-medium">Frame</span>
                        </label>
                        <label
                            class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#f4d03f] transition-colors has-[:checked]:border-[#f4d03f] has-[:checked]:bg-amber-50/50 flex-1 justify-center">
                            <input type="radio" name="category" value="lens" class="accent-[#f4d03f]">
                            <i class="fa-solid fa-eye text-gray-400"></i>
                            <span class="text-sm font-medium">Lens</span>
                        </label>
                        <label
                            class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#f4d03f] transition-colors has-[:checked]:border-[#f4d03f] has-[:checked]:bg-amber-50/50 flex-1 justify-center">
                            <input type="radio" name="category" value="accessory" class="accent-[#f4d03f]">
                            <i class="fa-solid fa-bag-shopping text-gray-400"></i>
                            <span class="text-sm font-medium">Accessories</span>
                        </label>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                    <textarea rows="3" id="productDesc" class="admin-input resize-none"
                        placeholder="Brief description of the product..."></textarea>
                </div>

                <!-- Image URL -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Image URL</label>
                    <input type="text" id="productImage" class="admin-input" placeholder="https://example.com/image.jpg">
                </div>

                <!-- Price & Stock -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Price</label>
                        <div class="relative">
                            <span
                                class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">$</span>
                            <input type="text" id="productPrice" class="admin-input !pl-7" placeholder="0.00">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Stock Qty</label>
                        <input type="number" id="productStock" class="admin-input" placeholder="0" min="0">
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-2 flex gap-3">
                    <button onclick="closeAddModal()" class="flex-1 btn-ghost justify-center !py-3">Cancel</button>
                    <button onclick="addNewProduct()" class="flex-1 btn-primary justify-center !py-3">
                        <i class="fa-solid fa-check"></i>
                        Add Product
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Toast -->
    <div id="successToast"
        class="hidden fixed top-6 right-6 z-[100] px-5 py-3.5 rounded-xl shadow-2xl text-sm font-medium bg-green-50 text-green-800 border border-green-200 flex items-center gap-3 transition-all duration-500">
        <i class="fa-solid fa-circle-check text-green-600"></i>
        <span id="toastMessage">Product added successfully!</span>
    </div>

    @push('scripts')
        <script>
            function showAddProductModal() {
                const modal = document.getElementById('addProductModal');
                modal.classList.remove('hidden');
                setTimeout(() => {
                    const content = document.getElementById('add-modal-content');
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }, 50);
            }

            function closeAddModal() {
                const modal = document.getElementById('addProductModal');
                const content = document.getElementById('add-modal-content');
                content.classList.add('scale-95', 'opacity-0');
                content.classList.remove('scale-100', 'opacity-100');
                setTimeout(() => modal.classList.add('hidden'), 200);
            }

            function addNewProduct() {
                const name = document.getElementById('productName').value.trim();
                if (!name) {
                    showToast('Please enter a product name.', 'info');
                    document.getElementById('productName').focus();
                    return;
                }

                closeAddModal();
                setTimeout(() => {
                    showToast('✅ Product "' + name + '" added successfully!', 'success');
                    // Reset form
                    document.getElementById('productName').value = '';
                    document.getElementById('productDesc').value = '';
                    document.getElementById('productImage').value = '';
                    document.getElementById('productPrice').value = '';
                    document.getElementById('productStock').value = '';
                }, 300);
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
            document.getElementById('addProductModal').addEventListener('click', function(e) {
                if (e.target === this) closeAddModal();
            });
        </script>
    @endpush
@endsection
