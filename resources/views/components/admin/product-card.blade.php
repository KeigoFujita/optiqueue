@props([
    'product' => null,
])

@php
    if (!$product) return;

    $isLensOrAccessory = in_array($product->type, ['lens', 'accessory']);

    // Determine the display image
    if ($isLensOrAccessory && $product->icon) {
        // Use the icon as a large emoji/icon display for lens/accessory products
        $useIcon = true;
        $image = null;
    } else {
        $useIcon = false;
        $image = $product->image_path
            ? asset('storage/' . $product->image_path)
            : 'https://picsum.photos/seed/' . $product->id . '/400/300';
    }

    // Determine the display category label
    if ($product->type === 'frame') {
        $categoryLabel = ucfirst($product->category); // "Men" or "Women"
        $categoryIcon = 'fa-glasses';
    } elseif ($product->type === 'lens') {
        $categoryLabel = 'Lenses';
        $categoryIcon = 'fa-eye';
    } else {
        $categoryLabel = 'Accessories';
        $categoryIcon = 'fa-bag-shopping';
    }

    $stockPercent = $product->stocks > 0 ? min($product->stocks, 100) : 0;
    $isLowStock = $product->stocks > 0 && $product->stocks <= 10;
    $isOutOfStock = $product->stocks <= 0;
@endphp

<div class="admin-card overflow-hidden group product-card"
     data-category="{{ $product->type }}"
     data-name="{{ strtolower($product->name) }}"
     data-description="{{ strtolower($product->description) }}">
    <!-- Product Image -->
    <div class="relative h-44 bg-gray-50 overflow-hidden flex items-center justify-center">
        @if ($useIcon)
            <span class="text-6xl" style="filter: grayscale(0.2);">{{ $product->icon }}</span>
        @else
            <img src="{{ $image }}" alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                 loading="lazy"
                 onerror="this.src='https://picsum.photos/seed/{{ $product->id }}/400/300'">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>

        <!-- Category Badge -->
        <span class="absolute top-3 left-3 inline-flex items-center gap-1.5 badge badge-neutral text-[10px] bg-white/90 backdrop-blur-sm shadow-sm">
            <i class="fa-solid {{ $categoryIcon }}"></i>
            {{ $categoryLabel }}
        </span>

        <!-- Price Badge -->
        <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm shadow-sm text-gray-900 font-bold text-xs px-3 py-1 rounded-full">
            @if ($product->old_price)
                <span class="line-through text-gray-400 mr-1">${{ $product->old_price }}</span>
            @endif
            ${{ $product->price }}
        </span>

        {{-- Out of stock overlay --}}
        @if ($isOutOfStock)
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                <span class="px-3 py-1.5 bg-white/90 backdrop-blur-sm text-gray-900 text-xs font-bold rounded-full uppercase tracking-wider shadow-lg">
                    Out of Stock
                </span>
            </div>
        @endif
    </div>

    <!-- Product Info -->
    <div class="p-4">
        <h4 class="text-sm font-semibold text-gray-900 truncate mb-1" title="{{ $product->name }}">
            {{ $product->name }}
        </h4>
        <p class="text-xs text-gray-400 line-clamp-2 mb-3">
            {{ $product->description }}
        </p>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-1.5 text-xs">
                <i class="fa-solid fa-box text-gray-400"></i>
                <span class="text-gray-500">Stock: </span>
                <span class="font-semibold {{ $isLowStock ? 'text-red-600' : ($isOutOfStock ? 'text-gray-400' : 'text-gray-700') }}">
                    {{ $isOutOfStock ? '0' : $product->stocks }}
                </span>
            </div>
            <a href="{{ route('admin.products.edit', $product->id) }}"
               class="text-xs font-medium text-[#0F3D2A] hover:text-[#f4d03f] transition-colors flex items-center gap-1">
                <i class="fa-solid fa-pen-to-square"></i>
                Edit
            </a>
        </div>

        <!-- Stock bar -->
        <div class="mt-2.5 h-1 bg-gray-100 rounded-full overflow-hidden">
            <div class="h-full rounded-full {{ $isOutOfStock ? 'bg-gray-300' : 'bg-gradient-to-r from-[#0F3D2A] to-[#f4d03f]' }}"
                 style="width: {{ $stockPercent }}%">
            </div>
        </div>

        <!-- Type indicator for frames -->
        @if ($product->type === 'frame' && $product->badge)
            <div class="mt-2 flex items-center gap-1">
                <span class="text-[10px] px-2 py-0.5 rounded-full font-medium"
                      @if ($product->badge_color) style="background-color: {{ $product->badge_color }}15; color: {{ $product->badge_color }}" @endif>
                    {{ $product->badge }}
                </span>
            </div>
        @endif
    </div>
</div>
