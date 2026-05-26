@props([
    'id' => null,
    'numid' => null,
    'name' => 'Accessory',
    'price' => 0,
    'icon' => '📦',
    'description' => '',
    'value' => '',
    'selected' => false,
])

@php
    $id = 'accessory-' . Str::slug($value ?: $name);
@endphp

<label for="{{ $id }}"
    class="accessory-card relative border-2 rounded-2xl p-4 md:p-5 text-center cursor-pointer transition-all duration-300 bg-white hover:shadow-md hover:shadow-[#1a3c2e]/10 hover:border-[#1a3c2e]/30 group
    {{ $selected ? 'border-[#1a3c2e] bg-[#1a3c2e]/[0.08] shadow-md shadow-[#1a3c2e]/10' : 'border-gray-200' }}"
    onclick="selectAccessory('{{ $value }}', {{ $price }}, '{{ $name }}', '{{ $id ?? 'null' }}', {{ $numid }})">
    <input type="radio" name="accessory" id="{{ $id }}" value="{{ $value }}" class="sr-only"
        {{ $selected ? 'checked' : '' }}>

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

    {{-- Price --}}
    @if ($price > 0)
        <p class="text-xs font-medium text-[#1a3c2e] mt-1.5">+${{ $price }}</p>
    @else
        <p class="text-xs font-medium text-gray-400 mt-1.5">Free</p>
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
