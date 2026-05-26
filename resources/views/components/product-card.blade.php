@props([
    'image' => 'https://images.unsplash.com/photo-1574258495973-f010dfbb5371?w=400&q=80&auto=format&fit=crop',
    'name' => 'Product Name',
    'description' => 'Product Description',
    'price' => 199,
    'oldPrice' => null,
    'rating' => 5,
    'reviews' => 0,
    'badge' => null,
    'badgeColor' => '#1a3c2e',
    'productId' => null,
])

@php
    $modalId = 'image-modal-' . ($productId ?? Str::random(6));
@endphp

<div
    class="group bg-white rounded-2xl border border-gray-100 hover:border-gray-200 transition-all duration-500 hover:shadow-xl hover:shadow-gray-200/50 overflow-hidden reveal">
    <div class="relative bg-[#f8faf7] p-8 flex items-center justify-center aspect-[4/3] overflow-hidden cursor-pointer"
        onclick="openImageModal('{{ $modalId }}')">
        <img src="{{ $image }}" alt="{{ $name }}"
            class="w-full max-w-[220px] h-auto object-contain transition-all duration-700 group-hover:scale-110 group-hover:rotate-[2deg]"
            loading="lazy">
        {{-- Hover overlay - Zoom icon --}}
        <div
            class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-500 flex items-center justify-center opacity-0 group-hover:opacity-100">
            <span
                class="inline-flex items-center justify-center w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full text-gray-900 shadow-lg shadow-black/10 scale-75 group-hover:scale-100 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                </svg>
            </span>
        </div>
        {{-- Badge --}}
        @if ($badge)
            <span
                class="absolute top-3 left-3 px-2.5 py-1 text-white text-[10px] font-bold rounded-full uppercase tracking-wider"
                style="background-color: {{ $badgeColor }}">{{ $badge }}</span>
        @endif
    </div>
    <div class="p-5 md:p-6">
        <div class="flex items-center gap-1 mb-2">
            @for ($i = 0; $i < min(5, $rating); $i++)
                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            @endfor
            @if ($reviews > 0)
                <span class="text-xs text-gray-400 ml-1">({{ $reviews }})</span>
            @endif
        </div>
        <h3 class="text-lg font-semibold text-gray-900">{{ $name }}</h3>
        <p class="text-sm text-gray-500 mt-0.5">{{ $description }}</p>
        <div class="flex items-center justify-between mt-4">
            <span class="text-lg font-bold text-gray-900">
                @if ($oldPrice)
                    <span class="text-gray-400 line-through text-sm mr-1">${{ $oldPrice }}</span>
                @endif
                ${{ $price }}
            </span>
            <a href="{{ $productId ? '/checkout?product=' . $productId : '/checkout' }}"
                class="inline-flex items-center px-4 py-1.5 text-xs font-semibold text-[#1a3c2e] bg-[#1a3c2e]/[0.08] rounded-full hover:bg-[#1a3c2e] hover:text-white transition-all duration-300">
                Select Frame
            </a>
        </div>
    </div>
</div>

{{-- Image Modal --}}
<div id="{{ $modalId }}"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/80 backdrop-blur-sm"
    onclick="closeImageModal('{{ $modalId }}')">
    <div class="relative max-w-4xl w-full mx-4 max-h-[90vh] flex items-center justify-center"
        onclick="event.stopPropagation()">
        <button onclick="closeImageModal('{{ $modalId }}')"
            class="absolute -top-12 right-0 text-white/80 hover:text-white transition-colors p-1">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <img src="{{ $image }}" alt="{{ $name }}"
            class="max-w-full max-h-[85vh] w-auto h-auto object-contain rounded-2xl shadow-2xl">
    </div>
</div>

@once
    <script>
        window.openImageModal = function(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        };

        window.closeImageModal = function(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }
        };

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id^="image-modal-"]').forEach(function(modal) {
                    if (!modal.classList.contains('hidden')) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        document.body.style.overflow = '';
                    }
                });
            }
        });
    </script>
@endonce
