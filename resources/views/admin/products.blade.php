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
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl mx-4 transform transition-all duration-300 scale-95 opacity-0 max-h-[90vh] overflow-y-auto"
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

            <!-- Modal Body - Two Column Layout -->
            <form id="addProductForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" id="productType" value="frame">

                <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-100">
                    {{-- ============================================================
                    LEFT SECTION — Basic Info & Category
                    ============================================================ --}}
                    <div class="p-6 space-y-5">

                        <!-- Product Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Name <span class="text-red-500">*</span></label>
                            <input type="text" id="productName" name="name" class="admin-input" placeholder="e.g. Aurel Burgundy Gold" required>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Description <span class="text-red-500">*</span></label>
                            <textarea rows="3" id="productDesc" name="description" class="admin-input resize-none"
                                placeholder="Brief description of the product..." required></textarea>
                        </div>

                        <!-- Category -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Product Category <span class="text-red-500">*</span></label>
                            <div class="flex gap-3">
                                <label
                                    class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#f4d03f] transition-colors has-[:checked]:border-[#f4d03f] has-[:checked]:bg-amber-50/50 flex-1 justify-center">
                                    <input type="radio" name="category" value="frame" checked onchange="toggleFields()" class="accent-[#f4d03f]">
                                    <i class="fa-solid fa-glasses text-gray-400"></i>
                                    <span class="text-sm font-medium">Frame</span>
                                </label>
                                <label
                                    class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#f4d03f] transition-colors has-[:checked]:border-[#f4d03f] has-[:checked]:bg-amber-50/50 flex-1 justify-center">
                                    <input type="radio" name="category" value="lens" onchange="toggleFields()" class="accent-[#f4d03f]">
                                    <i class="fa-solid fa-eye text-gray-400"></i>
                                    <span class="text-sm font-medium">Lens</span>
                                </label>
                                <label
                                    class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#f4d03f] transition-colors has-[:checked]:border-[#f4d03f] has-[:checked]:bg-amber-50/50 flex-1 justify-center">
                                    <input type="radio" name="category" value="accessory" onchange="toggleFields()" class="accent-[#f4d03f]">
                                    <i class="fa-solid fa-bag-shopping text-gray-400"></i>
                                    <span class="text-sm font-medium">Accessories</span>
                                </label>
                            </div>
                        </div>

                        <!-- Frame Type (Men / Women) - shown only when Frame is selected -->
                        <div id="frameTypeGroup">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Frame Type <span class="text-red-500">*</span></label>
                            <div class="flex gap-3">
                                <label
                                    class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#f4d03f] transition-colors has-[:checked]:border-[#f4d03f] has-[:checked]:bg-amber-50/50 flex-1 justify-center">
                                    <input type="radio" name="frame_type" value="men" checked class="accent-[#f4d03f]">
                                    <i class="fa-solid fa-person text-gray-400"></i>
                                    <span class="text-sm font-medium">Men</span>
                                </label>
                                <label
                                    class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#f4d03f] transition-colors has-[:checked]:border-[#f4d03f] has-[:checked]:bg-amber-50/50 flex-1 justify-center">
                                    <input type="radio" name="frame_type" value="women" class="accent-[#f4d03f]">
                                    <i class="fa-solid fa-person-dress text-gray-400"></i>
                                    <span class="text-sm font-medium">Women</span>
                                </label>
                            </div>
                        </div>

                        <!-- Status (dropdown) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                            <select name="status" id="productStatus" class="admin-input">
                                <option value="active" selected>Active</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>

                    </div>

                    {{-- ============================================================
                    RIGHT SECTION — Media, Pricing & Extras
                    ============================================================ --}}
                    <div class="p-6 space-y-5">

                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Image</label>
                            <div class="relative">
                                <input type="file" id="productImage" name="image" accept="image/jpeg,image/png,image/jpg,image/webp,image/avif"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 transition-colors cursor-pointer">
                            </div>
                            <div id="imagePreview" class="hidden mt-3">
                                <img src="" alt="Preview" class="w-32 h-32 object-cover rounded-xl border border-gray-200">
                            </div>
                            <p class="text-xs text-gray-400 mt-1.5">Accepted: JPEG, PNG, JPG, WebP, AVIF (max 2MB)</p>
                        </div>

                        <!-- Price & Old Price -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Price ($) <span class="text-red-500">*</span></label>
                                <input type="number" step="0.01" min="0" id="productPrice" name="price" class="admin-input" placeholder="0.00" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Old Price ($)</label>
                                <input type="number" step="0.01" min="0" id="productOldPrice" name="old_price" class="admin-input" placeholder="0.00">
                            </div>
                        </div>

                        <!-- Badge & Badge Color — shown only for Frames -->
                        <div id="badgeFields">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Badge</label>
                                    <input type="text" id="productBadge" name="badge" class="admin-input" placeholder="e.g. Bestseller, New, Sale">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Badge Color</label>
                                    <input type="color" id="productBadgeColor" name="badge_color" class="admin-input !h-10 !p-1" value="#1a3c2e">
                                </div>
                            </div>
                        </div>

                        <!-- Icon — shown only for Lens / Accessory -->
                        <div id="iconField">
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Icon (emoji)</label>
                            <input type="text" id="productIcon" name="icon" class="admin-input" placeholder="e.g. 👓, 🔵, 📦">
                        </div>

                        <!-- Actions -->
                        <div class="pt-4 flex gap-3 border-t border-gray-100">
                            <button type="button" onclick="closeAddModal()" class="flex-1 btn-ghost justify-center !py-3">Cancel</button>
                            <button type="submit" id="submitProductBtn" class="flex-1 btn-primary justify-center !py-3">
                                <i class="fa-solid fa-check"></i>
                                Add Product
                            </button>
                        </div>
                    </div>
                </div>
            </form>
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
                document.body.style.overflow = 'hidden';
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
                document.body.style.overflow = '';
                setTimeout(() => modal.classList.add('hidden'), 200);
            }

            // Toggle conditional fields based on selected category
            function toggleFields() {
                const frameTypeGroup = document.getElementById('frameTypeGroup');
                const badgeFields = document.getElementById('badgeFields');
                const iconField = document.getElementById('iconField');
                const typeInput = document.getElementById('productType');
                const selectedCategory = document.querySelector('input[name="category"]:checked').value;

                if (selectedCategory === 'frame') {
                    // Frame: show frame type + badge fields, hide icon
                    frameTypeGroup.classList.remove('hidden');
                    badgeFields.classList.remove('hidden');
                    iconField.classList.add('hidden');
                    typeInput.value = 'frame';
                } else {
                    // Lens or Accessory: hide frame type + badge, show icon
                    frameTypeGroup.classList.add('hidden');
                    badgeFields.classList.add('hidden');
                    iconField.classList.remove('hidden');
                    typeInput.value = selectedCategory === 'lens' ? 'lens' : 'accessory';
                }
            }

            // Initialize field visibility on page load
            document.addEventListener('DOMContentLoaded', function() {
                toggleFields();

                const imageInput = document.getElementById('productImage');
                if (imageInput) {
                    imageInput.addEventListener('change', function(e) {
                        const preview = document.getElementById('imagePreview');
                        const img = preview.querySelector('img');
                        const file = e.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(ev) {
                                img.src = ev.target.result;
                                preview.classList.remove('hidden');
                            };
                            reader.readAsDataURL(file);
                        } else {
                            preview.classList.add('hidden');
                            img.src = '';
                        }
                    });
                }

                // Handle form submission
                const form = document.getElementById('addProductForm');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        addNewProduct();
                    });
                }
            });

            function addNewProduct() {
                const form = document.getElementById('addProductForm');
                const formData = new FormData(form);

                // Determine correct category value for frame types
                const category = document.querySelector('input[name="category"]:checked').value;
                if (category === 'frame') {
                    const frameType = document.querySelector('input[name="frame_type"]:checked').value;
                    formData.set('category', frameType); // men or women
                }

                const submitBtn = document.getElementById('submitProductBtn');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

                fetch('{{ route('admin.products.store') }}', {
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
                        closeAddModal();
                        showToast('✅ Product "' + data.product.name + '" added successfully!', 'success');
                        // Reload page after short delay to show updated list
                        setTimeout(() => window.location.reload(), 1500);
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
            document.getElementById('addProductModal').addEventListener('click', function(e) {
                if (e.target === this) closeAddModal();
            });
        </script>
    @endpush
@endsection
