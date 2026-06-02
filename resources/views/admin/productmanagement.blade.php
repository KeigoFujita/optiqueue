@extends('layouts.admin')

@section('title', 'Edit ' . $product->name . ' - Optiqueue')

@section('page-header')
    <div class="flex items-end justify-between w-full gap-5">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.products') }}"
                class="w-9 h-9 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 hover:text-gray-700 transition-all">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <p class="text-xs text-gray-500 font-medium">Manage Product</p>
                <h2 class="text-xl lg:text-2xl font-bold font-serif text-gray-900">{{ $product->name }}</h2>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="badge {{ $product->status === 'active' ? 'badge-success' : 'badge-neutral' }} text-[10px]">
                <span class="w-1.5 h-1.5 rounded-full {{ $product->status === 'active' ? 'bg-green-500' : 'bg-gray-400' }} mr-1"></span>
                {{ ucfirst($product->status) }}
            </span>
        </div>
    </div>
@endsection

@section('header-actions')
    <div class="flex items-center gap-2">
        {{-- No delete button --}}
    </div>
@endsection

@section('content')
    <div class="p-6 lg:p-8">

        <!-- Tabs -->
        <div class="mb-8">
            <div class="flex border-b border-gray-200 gap-1">
                <a href="{{ route('admin.products.edit', $product->id) }}" id="tab-0"
                    class="tab-button px-6 py-3.5 text-sm font-semibold transition-all duration-300 border-b-2 border-[#f4d03f] text-gray-900 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Product Details
                </a>
                <a href="{{ route('admin.products.movements', $product->id) }}" id="tab-1"
                    class="tab-button px-6 py-3.5 text-sm font-semibold text-gray-500 hover:text-gray-700 transition-all duration-300 border-b-2 border-transparent hover:border-gray-300 flex items-center gap-2">
                    <i class="fa-solid fa-arrows-up-down"></i>
                    Product Movement
                </a>
            </div>
        </div>

        <!-- Product Details Tab -->
        <div>
            <form id="editProductForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="type" id="productType" value="{{ $product->type }}">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left: Product Image -->
                    <div class="lg:col-span-1">
                        <div class="admin-card overflow-hidden">
                            <div class="relative">
                                @php
                                    $imageUrl = $product->image_path
                                        ? asset('storage/' . $product->image_path)
                                        : 'https://picsum.photos/seed/' . $product->id . '/600/600';
                                @endphp
                                <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
                                    class="w-full h-64 lg:h-80 object-cover" id="productImagePreview">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                                <button type="button" onclick="document.getElementById('imageUpload').click()"
                                    class="absolute bottom-4 right-4 px-4 py-2 rounded-xl bg-white/90 backdrop-blur-sm shadow-lg text-sm font-medium text-gray-700 hover:bg-white transition-all flex items-center gap-2">
                                    <i class="fa-solid fa-camera"></i>
                                    Change Photo
                                </button>
                                <input type="file" name="image" id="imageUpload" accept="image/*" class="hidden"
                                    onchange="previewImage(this)">
                            </div>
                            <div class="p-5 space-y-3">
                                <h4 class="text-xs font-semibold uppercase tracking-wider text-gray-500">Product Summary
                                </h4>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="p-3 rounded-xl bg-gray-50">
                                        <p class="text-[10px] text-gray-500">Price</p>
                                        <p class="text-base font-bold text-gray-900">₱{{ number_format($product->price, 2) }}</p>
                                    </div>
                                    <div class="p-3 rounded-xl bg-gray-50">
                                        <p class="text-[10px] text-gray-500">Stock</p>
                                        <p class="text-base font-bold text-gray-900">{{ $product->stocks }} units</p>
                                    </div>
                                    <div class="p-3 rounded-xl bg-gray-50">
                                        <p class="text-[10px] text-gray-500">Category</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ ucfirst($product->type) }}</p>
                                    </div>
                                    <div class="p-3 rounded-xl bg-gray-50">
                                        <p class="text-[10px] text-gray-500">ID</p>
                                        <p class="text-sm font-semibold text-gray-900 font-mono">#{{ $product->id }}</p>
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
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="productName" value="{{ $product->name }}" class="admin-input" required>
                                </div>

                                <!-- Category -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Category <span class="text-red-500">*</span></label>
                                    <div class="flex gap-3">
                                        <label
                                            class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#f4d03f] transition-colors has-[:checked]:border-[#f4d03f] has-[:checked]:bg-amber-50/50 flex-1 justify-center">
                                            <input type="radio" name="category" value="frame" {{ $product->type === 'frame' ? 'checked' : '' }} onchange="toggleFields()" class="accent-[#f4d03f]">
                                            <i class="fa-solid fa-glasses text-gray-400"></i>
                                            <span class="text-sm font-medium">Frame</span>
                                        </label>
                                        <label
                                            class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#f4d03f] transition-colors has-[:checked]:border-[#f4d03f] has-[:checked]:bg-amber-50/50 flex-1 justify-center">
                                            <input type="radio" name="category" value="lens" {{ $product->type === 'lens' ? 'checked' : '' }} onchange="toggleFields()" class="accent-[#f4d03f]">
                                            <i class="fa-solid fa-eye text-gray-400"></i>
                                            <span class="text-sm font-medium">Lens</span>
                                        </label>
                                        <label
                                            class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#f4d03f] transition-colors has-[:checked]:border-[#f4d03f] has-[:checked]:bg-amber-50/50 flex-1 justify-center">
                                            <input type="radio" name="category" value="accessory" {{ $product->type === 'accessory' ? 'checked' : '' }} onchange="toggleFields()" class="accent-[#f4d03f]">
                                            <i class="fa-solid fa-bag-shopping text-gray-400"></i>
                                            <span class="text-sm font-medium">Accessories</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Frame Type (Men / Women) - shown only when Frame is selected -->
                                <div id="frameTypeGroup" class="{{ $product->type !== 'frame' ? 'hidden' : '' }}">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Frame Type <span class="text-red-500">*</span></label>
                                    <div class="flex gap-3">
                                        <label
                                            class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#f4d03f] transition-colors has-[:checked]:border-[#f4d03f] has-[:checked]:bg-amber-50/50 flex-1 justify-center">
                                            <input type="radio" name="frame_type" value="men" {{ $product->category === 'men' ? 'checked' : '' }} class="accent-[#f4d03f]">
                                            <i class="fa-solid fa-person text-gray-400"></i>
                                            <span class="text-sm font-medium">Men</span>
                                        </label>
                                        <label
                                            class="flex items-center gap-2 p-3 rounded-xl border border-gray-200 cursor-pointer hover:border-[#f4d03f] transition-colors has-[:checked]:border-[#f4d03f] has-[:checked]:bg-amber-50/50 flex-1 justify-center">
                                            <input type="radio" name="frame_type" value="women" {{ $product->category === 'women' ? 'checked' : '' }} class="accent-[#f4d03f]">
                                            <i class="fa-solid fa-person-dress text-gray-400"></i>
                                            <span class="text-sm font-medium">Women</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Description <span class="text-red-500">*</span></label>
                                    <textarea rows="4" name="description" id="productDesc" class="admin-input resize-none" required>{{ $product->description }}</textarea>
                                </div>

                                <!-- Price & Old Price Row -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Price ($) <span class="text-red-500">*</span></label>
                                        <input type="number" step="0.01" min="0" name="price" id="productPrice" value="{{ $product->price }}" class="admin-input" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Old Price ($)</label>
                                        <input type="number" step="0.01" min="0" name="old_price" value="{{ $product->old_price }}" class="admin-input" placeholder="0.00">
                                    </div>
                                </div>

                                <!-- Stock & Status -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Stock Quantity</label>
                                        <input type="number" name="stocks" value="{{ $product->stocks }}" min="0" class="admin-input">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                                        <select name="status" id="productStatus" class="admin-input cursor-pointer">
                                            <option value="active" {{ $product->status === 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="archived" {{ $product->status === 'archived' ? 'selected' : '' }}>Archived</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Badge & Badge Color — shown only for Frames -->
                                <div id="badgeFields" class="{{ $product->type !== 'frame' ? 'hidden' : '' }}">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Badge</label>
                                            <input type="text" name="badge" id="productBadge" value="{{ $product->badge }}" class="admin-input" placeholder="e.g. Bestseller, New, Sale">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Badge Color</label>
                                            <input type="color" name="badge_color" id="productBadgeColor" class="admin-input !h-10 !p-1" value="{{ $product->badge_color ?? '#1a3c2e' }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Icon — shown only for Lens / Accessory -->
                                <div id="iconField" class="{{ $product->type === 'frame' ? 'hidden' : '' }}">
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Icon (emoji)</label>
                                    <input type="text" name="icon" id="productIcon" value="{{ $product->icon }}" class="admin-input" placeholder="e.g. 👓, 🔵, 📦">
                                </div>

                                <!-- Save Changes — Bottom Right -->
                                <div class="pt-6 flex justify-end gap-3 border-t border-gray-100">
                                    <button type="button" onclick="window.location.href='{{ route('admin.products') }}'" class="btn-ghost !py-3 !px-6">Cancel</button>
                                    <button type="submit" id="saveProductBtn" class="btn-primary !py-3 !px-6">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
            // Toggle conditional fields based on selected category
            function toggleFields() {
                const frameTypeGroup = document.getElementById('frameTypeGroup');
                const badgeFields = document.getElementById('badgeFields');
                const iconField = document.getElementById('iconField');
                const typeInput = document.getElementById('productType');
                const selectedCategory = document.querySelector('input[name="category"]:checked').value;

                if (selectedCategory === 'frame') {
                    frameTypeGroup.classList.remove('hidden');
                    badgeFields.classList.remove('hidden');
                    iconField.classList.add('hidden');
                    typeInput.value = 'frame';
                } else {
                    frameTypeGroup.classList.add('hidden');
                    badgeFields.classList.add('hidden');
                    iconField.classList.remove('hidden');
                    typeInput.value = selectedCategory === 'lens' ? 'lens' : 'accessory';
                }
            }

            const MAX_IMAGE_SIZE = 2 * 1024 * 1024; // 2MB in bytes

            function previewImage(input) {
                if (input.files && input.files[0]) {
                    const file = input.files[0];

                    // Check file size
                    if (file.size > MAX_IMAGE_SIZE) {
                        showToast('❌ Image must be less than 2MB. Please choose a smaller file.', 'danger');
                        input.value = ''; // Clear the file input
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('productImagePreview').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }

            // Initialize field visibility and form submission
            document.addEventListener('DOMContentLoaded', function() {
                toggleFields();

                const imageInput = document.getElementById('imageUpload');
                if (imageInput) {
                    imageInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            // Check file size before preview
                            if (file.size > MAX_IMAGE_SIZE) {
                                showToast('❌ Image must be less than 2MB. Please choose a smaller file.', 'danger');
                                imageInput.value = ''; // Clear the file input
                                return;
                            }

                            const reader = new FileReader();
                            reader.onload = function(ev) {
                                document.getElementById('productImagePreview').src = ev.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                }

                const form = document.getElementById('editProductForm');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        saveProduct();
                    });
                }
            });

            function saveProduct() {
                const form = document.getElementById('editProductForm');
                const formData = new FormData(form);

                // Determine correct category value for frame types
                const category = document.querySelector('input[name="category"]:checked').value;
                if (category === 'frame') {
                    const frameType = document.querySelector('input[name="frame_type"]:checked').value;
                    formData.set('category', frameType); // men or women
                }

                // Laravel PUT method spoofing via POST
                formData.set('_method', 'PUT');

                const submitBtn = document.getElementById('saveProductBtn');
                const originalHtml = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

                fetch('{{ route('admin.products.update', $product->id) }}', {
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
                        // Success state
                        submitBtn.innerHTML = '<i class="fa-solid fa-check"></i> Saved!';
                        submitBtn.classList.remove('btn-primary');
                        submitBtn.classList.add('bg-green-500', 'hover:bg-green-600', 'text-white', 'border-none');

                        showToast('✅ ' + data.message, 'success');

                        setTimeout(() => {
                            submitBtn.innerHTML = originalHtml;
                            submitBtn.classList.remove('bg-green-500', 'hover:bg-green-600');
                            submitBtn.classList.add('btn-primary');
                            submitBtn.disabled = false;
                        }, 2000);

                        // Reload after short delay if needed
                        setTimeout(() => window.location.reload(), 1500);
                    } else {
                        showToast('❌ Error: ' + (data.message || 'Something went wrong'), 'danger');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalHtml;
                    }
                })
                .catch(error => {
                    showToast('❌ Network error. Please try again.', 'danger');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;
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
        </script>
    @endpush
@endsection
