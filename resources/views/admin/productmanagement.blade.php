@extends('layouts.admin')

@section('title', 'Manage Product - Optiqueue')

@section('page-header')
    <div class="flex items-center justify-between w-full">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.products') }}"
                class="w-9 h-9 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 hover:text-gray-700 transition-all">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <p class="text-xs text-gray-500 font-medium">Manage Product</p>
                <h2 class="text-xl lg:text-2xl font-bold font-serif text-gray-900">Aurel Burgundy Gold</h2>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="badge badge-success text-[10px]">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1"></span>
                Active
            </span>
        </div>
    </div>
@endsection

@section('header-actions')
    <div class="flex items-center gap-2">
        <button class="btn-ghost !py-2 !px-4 !text-xs !rounded-xl">
            <i class="fa-solid fa-trash-can"></i>
            <span class="hidden sm:inline">Delete</span>
        </button>
        <button onclick="saveProduct()" class="btn-primary !py-2 !px-4 !text-xs !rounded-xl" id="saveBtn">
            <i class="fa-solid fa-floppy-disk"></i>
            <span>Save Changes</span>
        </button>
    </div>
@endsection

@section('content')
    <div class="p-6 lg:p-8">

        <!-- Tabs -->
        <div class="mb-8">
            <div class="flex border-b border-gray-200 gap-1">
                <button onclick="switchTab(0)" id="tab-0"
                    class="tab-button px-6 py-3.5 text-sm font-semibold transition-all duration-300 border-b-2 border-[#f4d03f] text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Product Details
                </button>
                <button onclick="switchTab(1)" id="tab-1"
                    class="tab-button px-6 py-3.5 text-sm font-semibold text-gray-500 hover:text-gray-700 transition-all duration-300 border-b-2 border-transparent hover:border-gray-300 flex items-center gap-2">
                    <i class="fa-solid fa-arrows-up-down"></i>
                    Product Movement
                </button>
            </div>
        </div>

        <!-- Tab Contents -->
        <div>

            <!-- Product Details Tab -->
            <div id="content-0" class="tab-content">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left: Product Image -->
                    <div class="lg:col-span-1">
                        <div class="admin-card overflow-hidden">
                            <div class="relative">
                                <img src="https://picsum.photos/id/201/600/600" alt="Product Image"
                                    class="w-full h-64 lg:h-80 object-cover" id="productImagePreview">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                                <button onclick="document.getElementById('imageUpload').click()"
                                    class="absolute bottom-4 right-4 px-4 py-2 rounded-xl bg-white/90 backdrop-blur-sm shadow-lg text-sm font-medium text-gray-700 hover:bg-white transition-all flex items-center gap-2">
                                    <i class="fa-solid fa-camera"></i>
                                    Change Photo
                                </button>
                                <input type="file" id="imageUpload" accept="image/*" class="hidden"
                                    onchange="previewImage(this)">
                            </div>
                            <div class="p-5 space-y-3">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-gray-500">Product Summary
                                </h4>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="p-3 rounded-xl bg-gray-50">
                                        <p class="text-[10px] text-gray-500">Price</p>
                                        <p class="text-base font-bold text-gray-900">$168.00</p>
                                    </div>
                                    <div class="p-3 rounded-xl bg-gray-50">
                                        <p class="text-[10px] text-gray-500">Stock</p>
                                        <p class="text-base font-bold text-gray-900">50 units</p>
                                    </div>
                                    <div class="p-3 rounded-xl bg-gray-50">
                                        <p class="text-[10px] text-gray-500">Category</p>
                                        <p class="text-sm font-semibold text-gray-900">Frame</p>
                                    </div>
                                    <div class="p-3 rounded-xl bg-gray-50">
                                        <p class="text-[10px] text-gray-500">SKU</p>
                                        <p class="text-sm font-semibold text-gray-900 font-mono">FRM-001</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Product Details Form -->
                    <div class="lg:col-span-2">
                        <div class="admin-card p-6 lg:p-8">
                            <div class="space-y-6">
                                <!-- Product Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Name</label>
                                    <input type="text" value="Aurel Burgundy Gold" class="admin-input">
                                </div>

                                <!-- Category -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Category</label>
                                    <div class="flex gap-3">
                                        <label
                                            class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#f4d03f] transition-colors has-[:checked]:border-[#f4d03f] has-[:checked]:bg-amber-50/50 flex-1 justify-center">
                                            <input type="radio" name="category" value="frame" checked
                                                class="accent-[#f4d03f]">
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
                                            <input type="radio" name="category" value="accessory"
                                                class="accent-[#f4d03f]">
                                            <i class="fa-solid fa-bag-shopping text-gray-400"></i>
                                            <span class="text-sm font-medium">Accessories</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                                    <textarea rows="4" class="admin-input resize-none">Premium acetate frame with elegant gold accents. Perfect for modern and professional looks. Features adjustable nose pads and spring hinges for lasting comfort.</textarea>
                                </div>

                                <!-- Price & Stock Row -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Price</label>
                                        <div class="relative">
                                            <span
                                                class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">$</span>
                                            <input type="text" value="168.00" class="admin-input !pl-7">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Stock
                                            Quantity</label>
                                        <input type="number" value="50" min="0" class="admin-input">
                                    </div>
                                </div>

                                <!-- SKU & Status -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">SKU</label>
                                        <input type="text" value="FRM-001" class="admin-input font-mono">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                                        <select class="admin-input cursor-pointer">
                                            <option value="active" selected>Active</option>
                                            <option value="draft">Draft</option>
                                            <option value="archived">Archived</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Movement Tab -->
            <div id="content-1" class="tab-content hidden">
                <div class="space-y-6">
                    <!-- Movement Summary -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 stagger-children">
                        <div class="admin-card p-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                                    <i class="fa-solid fa-arrow-up text-green-600"></i>
                                </div>
                                <div>
                                    <div class="text-lg font-bold text-gray-900">24</div>
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
                                    <div class="text-lg font-bold text-gray-900">18</div>
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
                                    <div class="text-lg font-bold text-gray-900">50</div>
                                    <div class="text-xs text-gray-500">Current Stock</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Movement + Table -->
                    <div class="admin-card overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-bold font-serif text-gray-900">Movement History</h3>
                                <p class="text-[11px] text-gray-500 mt-0.5">All stock changes for this product</p>
                            </div>
                            <button onclick="addMovement()" class="btn-dark !py-2 !px-4 !text-xs !rounded-xl">
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
                                <tbody>
                                    <tr>
                                        <td>
                                            <span class="badge badge-success">
                                                <i class="fa-solid fa-arrow-up"></i>
                                                Stock In
                                            </span>
                                        </td>
                                        <td class="font-semibold text-gray-900">+20</td>
                                        <td class="text-gray-500">Initial Inventory</td>
                                        <td class="text-gray-400 font-mono text-xs">PO-2026-001</td>
                                        <td class="text-gray-400 text-xs">May 20, 2026</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-danger">
                                                <i class="fa-solid fa-arrow-down"></i>
                                                Stock Out
                                            </span>
                                        </td>
                                        <td class="font-semibold text-gray-900">-3</td>
                                        <td class="text-gray-500">Customer Order</td>
                                        <td class="text-gray-400 font-mono text-xs">#095401</td>
                                        <td class="text-gray-400 text-xs">May 22, 2026</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-success">
                                                <i class="fa-solid fa-arrow-up"></i>
                                                Stock In
                                            </span>
                                        </td>
                                        <td class="font-semibold text-gray-900">+10</td>
                                        <td class="text-gray-500">Supplier Restock</td>
                                        <td class="text-gray-400 font-mono text-xs">PO-2026-002</td>
                                        <td class="text-gray-400 text-xs">May 25, 2026</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="badge badge-danger">
                                                <i class="fa-solid fa-arrow-down"></i>
                                                Stock Out
                                            </span>
                                        </td>
                                        <td class="font-semibold text-gray-900">-1</td>
                                        <td class="text-gray-500">Damaged</td>
                                        <td class="text-gray-400 font-mono text-xs">ADJ-001</td>
                                        <td class="text-gray-400 text-xs">May 26, 2026</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Save Success Toast -->
    <div id="saveToast"
        class="hidden fixed top-6 right-6 z-[100] px-5 py-3.5 rounded-xl shadow-2xl text-sm font-medium bg-green-50 text-green-800 border border-green-200 flex items-center gap-3 transition-all duration-500">
        <i class="fa-solid fa-circle-check text-green-600"></i>
        <span>Changes saved successfully!</span>
    </div>

    @push('scripts')
        <script>
            function switchTab(tab) {
                document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
                document.getElementById(`content-${tab}`).classList.remove('hidden');

                document.querySelectorAll('.tab-button').forEach((btn, index) => {
                    if (index === tab) {
                        btn.classList.add('border-[#f4d03f]', 'text-gray-900');
                        btn.classList.remove('border-transparent', 'text-gray-500');
                    } else {
                        btn.classList.remove('border-[#f4d03f]', 'text-gray-900');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    }
                });
            }

            function previewImage(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('productImagePreview').src = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function saveProduct() {
                const btn = document.getElementById('saveBtn');
                const originalHtml = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
                btn.classList.remove('btn-primary');
                btn.classList.add('bg-gray-400', 'text-white', 'rounded-xl', '!py-2', '!px-4', '!text-xs', 'border-none',
                    'cursor-not-allowed');

                setTimeout(() => {
                    // Success state
                    btn.innerHTML = '<i class="fa-solid fa-check"></i> Saved!';
                    btn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                    btn.classList.add('bg-green-500', 'hover:bg-green-600');

                    showToast('✅ All changes saved successfully!', 'success');

                    setTimeout(() => {
                        btn.innerHTML = originalHtml;
                        btn.classList.remove('bg-green-500', 'hover:bg-green-600');
                        btn.classList.add('btn-primary');
                        btn.disabled = false;
                    }, 2000);
                }, 1500);
            }

            function addMovement() {
                showToast('📦 Add movement dialog would open here.', 'info');
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

            // Initialize default tab
            document.addEventListener('DOMContentLoaded', () => {
                switchTab(0);
            });
        </script>
    @endpush
@endsection
