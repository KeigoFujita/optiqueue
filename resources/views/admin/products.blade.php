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
            <i class="fa-solid fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" id="searchProduct" placeholder="Search products..."
                class="admin-input !w-48 !py-2 !pl-9 !pr-3 !text-sm !rounded-xl bg-gray-50">
        </div>
        <button onclick="showAddProductModal()" class="btn-primary !py-2 !px-4 !text-xs !rounded-xl">
            <i class="fa-solid fa-plus"></i>
            <span>Add Product</span>
        </button>
    </div>
@endsection

@section('content')
    <div class="p-6 lg:p-8 space-y-6">

        <!-- Category Quick Filters -->
        <div class="flex flex-wrap gap-2">
            <button
                class="cat-filter active px-4 py-2 rounded-xl bg-[#0F3D2A] text-white text-xs font-semibold transition-all">
                All Products
            </button>
            <button
                class="cat-filter px-4 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 text-xs font-medium transition-all">
                <i class="fa-solid fa-glasses mr-1.5"></i>Frames
            </button>
            <button
                class="cat-filter px-4 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 text-xs font-medium transition-all">
                <i class="fa-solid fa-eye mr-1.5"></i>Lenses
            </button>
            <button
                class="cat-filter px-4 py-2 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 text-xs font-medium transition-all">
                <i class="fa-solid fa-bag-shopping mr-1.5"></i>Accessories
            </button>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 stagger-children" id="productsGrid">
            @foreach (range(1, 8) as $i)
                @php
                    $names = [
                        'Aurel Burgundy Gold',
                        'Kairo Matte Black',
                        'Vienna Crystal',
                        'Milan Tortoise',
                        'Oslo Gunmetal',
                        'Paris Rose Gold',
                        'Tokyo Blue',
                        'Venice Green',
                    ];
                    $categories = ['Frame', 'Frame', 'Frame', 'Frame', 'Lens', 'Accessories', 'Lens', 'Accessories'];
                    $prices = [168, 145, 198, 175, 89, 45, 120, 35];
                    $stocks = [50, 65, 30, 42, 80, 89, 55, 120];
                @endphp
                <div class="admin-card overflow-hidden group product-card"
                    data-category="{{ strtolower($categories[$i - 1]) }}">
                    <!-- Product Image -->
                    <div class="relative h-44 bg-gray-50 overflow-hidden">
                        <img src="https://picsum.photos/id/{{ 200 + $i }}/400/300" alt="{{ $names[$i - 1] }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        <!-- Category Badge -->
                        <span
                            class="absolute top-3 left-3 badge badge-neutral text-[10px] bg-white/90 backdrop-blur-sm shadow-sm">
                            {{ $categories[$i - 1] }}
                        </span>
                        <!-- Price Badge -->
                        <span
                            class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm shadow-sm text-gray-900 font-bold text-xs px-3 py-1 rounded-full">
                            ${{ $prices[$i - 1] }}
                        </span>
                    </div>
                    <!-- Product Info -->
                    <div class="p-4">
                        <h4 class="text-sm font-semibold text-gray-900 truncate mb-1">{{ $names[$i - 1] }}</h4>
                        <p class="text-xs text-gray-400 line-clamp-2 mb-3">
                            Premium {{ strtolower($categories[$i - 1]) }} with elegant design and high-quality materials.
                        </p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1.5 text-xs">
                                <i class="fa-solid fa-box text-gray-400"></i>
                                <span class="text-gray-500">Stock: </span>
                                <span class="font-semibold text-gray-700">{{ $stocks[$i - 1] }}</span>
                            </div>
                            <a href="{{ route('admin.productmanagement') }}"
                                class="text-xs font-medium text-[#0F3D2A] hover:text-[#f4d03f] transition-colors flex items-center gap-1">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Edit
                            </a>
                        </div>
                        <!-- Stock bar -->
                        <div class="mt-2.5 h-1 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-[#0F3D2A] to-[#f4d03f]"
                                style="width: {{ min($stocks[$i - 1], 100) }}%">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
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

            // Category filter
            document.querySelectorAll('.cat-filter').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.cat-filter').forEach(b => {
                        b.classList.remove('bg-[#0F3D2A]', 'text-white');
                        b.classList.add('bg-gray-100', 'text-gray-600');
                    });
                    this.classList.remove('bg-gray-100', 'text-gray-600');
                    this.classList.add('bg-[#0F3D2A]', 'text-white');

                    const filter = this.textContent.trim().toLowerCase();
                    document.querySelectorAll('.product-card').forEach(card => {
                        if (filter === 'all products') {
                            card.style.display = '';
                        } else {
                            const category = card.dataset.category;
                            card.style.display = category && filter.includes(category) ? '' : 'none';
                        }
                    });
                });
            });

            // Product search
            document.getElementById('searchProduct')?.addEventListener('keyup', function() {
                const query = this.value.toLowerCase();
                document.querySelectorAll('.product-card').forEach(card => {
                    const title = card.querySelector('h4').textContent.toLowerCase();
                    const desc = card.querySelector('p').textContent.toLowerCase();
                    card.style.display = title.includes(query) || desc.includes(query) ? '' : 'none';
                });
            });

            // Close modal on outside click
            document.getElementById('addProductModal').addEventListener('click', function(e) {
                if (e.target === this) closeAddModal();
            });
        </script>
    @endpush
@endsection
