@props([
    'id' => null,
    'numid' => null,
    'name' => 'Lens Option',
    'price' => 0,
    'icon' => '🔵',
    'description' => '',
    'value' => '',
    'selected' => false,
    'stocks' => 0,
])

@php
    $id = 'lens-' . Str::slug($value ?: $name);
    $isOutOfStock = $stocks <= 0;
@endphp

<label for="{{ $id }}"
    class="lens-card relative border-2 rounded-2xl p-4 md:p-5 text-center cursor-pointer transition-all duration-300 bg-white hover:shadow-md hover:shadow-[#1a3c2e]/10 hover:border-[#1a3c2e]/30 group
    {{ $selected ? 'border-[#1a3c2e] bg-[#1a3c2e]/[0.08] shadow-md shadow-[#1a3c2e]/10' : 'border-gray-200' }}
    {{ $isOutOfStock ? 'opacity-60 pointer-events-none' : '' }}"
    onclick="selectLens('{{ $value }}', {{ $price }}, '{{ $name }}', '{{ $id ?? 'null' }}', {{ $numid }})">
    <input type="radio" name="lens" id="{{ $id }}" value="{{ $value }}" class="sr-only"
        {{ $selected ? 'checked' : '' }} {{ $isOutOfStock ? 'disabled' : '' }}>

    {{-- Icon Container --}}
    <div
        class="w-full aspect-square max-h-20 flex items-center justify-center bg-[#f8faf7] rounded-xl mb-3 group-hover:bg-[#edf3ed] transition-colors">
        <span class="text-2xl md:text-3xl">{{ $icon }}</span>
    </div>

    {{-- Name --}}
    <p class="font-semibold text-[#1a3c2e] text-sm md:text-base">{{ $name }}</p>

    {{-- Description --}}
    @if ($description)
        <p class="text-xs text-gray-500 mt-0.5">{{ $description }}</p>
    @endif

    {{-- Stock indicator --}}
    <div class="mt-1.5 flex items-center justify-center gap-1">
        @if ($isOutOfStock)
            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
            <span class="text-[10px] text-red-500 font-medium">Out of Stock</span>
        @else
            <span class="w-1.5 h-1.5 rounded-full {{ $stocks <= 5 ? 'bg-amber-500' : 'bg-green-500' }}"></span>
            <span class="text-[10px] {{ $stocks <= 5 ? 'text-amber-600' : 'text-green-600' }} font-medium">
                {{ $stocks <= 5 ? $stocks . ' left' : $stocks . ' in stock' }}
            </span>
        @endif
    </div>

    {{-- Price --}}
    @if ($price > 0)
        <p class="text-xs font-medium text-[#1a3c2e] mt-1">+₱{{ $price }}</p>
    @else
        <p class="text-xs font-medium text-gray-400 mt-1">Included</p>
    @endif

    {{-- Selected indicator --}}
    <div
        class="check-indicator absolute top-2.5 right-2.5 w-5 h-5 rounded-full border-2 transition-colors duration-300
        {{ $selected ? 'bg-[#1a3c2e] border-[#1a3c2e]' : 'border-gray-300 group-hover:border-[#1a3c2e]/50' }}">
        @if ($selected)
            <svg class="w-full h-full text-white p-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
        @endif
    </div>
</label>
