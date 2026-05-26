@extends('layouts.app')
@section('title', 'Customize Your Frame - Optiqueue')
@section('content')
    {{-- ============================================================
    PAGE HEADER
    ============================================================ --}}
    <section class="relative pt-24 md:pt-28 pb-8 bg-[#1a3c2e]/5 border-b border-gray-100 overflow-hidden">
        {{-- Decorative background --}}
        <div class="absolute top-[-20%] right-[-10%] w-[40%] h-[40%] bg-[#1a3c2e]/[0.02] rounded-full blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6" aria-label="Breadcrumb">
                <a href="/" class="hover:text-[#1a3c2e] transition-colors duration-300">Home</a>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ url()->previous() }}" class="hover:text-[#1a3c2e] transition-colors duration-300">Frames</a>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-[#1a3c2e] font-medium">{{ $product ? $product['name'] : 'Customize' }}</span>
            </nav>
            {{-- Title --}}
            <div class="reveal">
                <span
                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-wider text-[#1a3c2e] bg-[#1a3c2e]/[0.08] rounded-full mb-4 uppercase">Customize</span>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold font-serif text-[#1a3c2e] leading-tight">
                    Build Your Perfect Pair
                </h1>
                <p class="mt-3 text-gray-500 max-w-xl">
                    Choose your lens and accessories to personalize your eyewear.
                </p>
            </div>
        </div>
    </section>

    {{-- ============================================================
    MAIN CONTENT
    ============================================================ --}}
    <main class="bg-[#f8faf7] min-h-screen pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12">
                {{-- ============================================================
                LEFT COLUMN - Frame Preview
                ============================================================ --}}
                <div class="lg:col-span-5">
                    <div class="lg:sticky lg:top-28">
                        {{-- Frame Display Card --}}
                        <div
                            class="bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-sm hover:shadow-md transition-shadow duration-300">
                            {{-- Frame Image --}}
                            <div
                                class="bg-[#f8faf7] rounded-xl overflow-hidden aspect-[4/3] flex items-center justify-center border border-gray-100">
                                <img src="storage/{{ $product ? $product['image_path'] : 'https://images.unsplash.com/photo-1574258495973-f010dfbb5371?w=600&q=80&auto=format&fit=crop' }}"
                                    alt="{{ $product ? $product['name'] : 'Selected Frame' }}"
                                    class="w-full max-w-[280px] h-auto object-contain p-4">
                            </div>
                            {{-- Frame Details --}}
                            <div class="mt-6 text-center">
                                @if ($product)
                                    <h2 class="text-2xl font-bold font-serif text-[#1a3c2e]">{{ $product['name'] }}</h2>
                                    <p class="text-gray-500 mt-1 text-sm">{{ $product['description'] }}</p>
                                    <div
                                        class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-[#1a3c2e]/[0.08] rounded-full">
                                        <span class="font-bold text-[#1a3c2e]">${{ $product['price'] }}</span>
                                        <span class="text-sm text-gray-500">Frame</span>
                                    </div>
                                @else
                                    <h2 class="text-2xl font-bold font-serif text-[#1a3c2e]">Your Frame</h2>
                                    <p class="text-gray-500 mt-1 text-sm">Select a frame to get started</p>
                                @endif
                            </div>
                            {{-- Selection Summary --}}
                            <div class="mt-6 pt-6 border-t border-gray-100 space-y-3">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Frame</span>
                                    <span class="font-medium text-[#1a3c2e]" id="selected-frame-display">
                                        {{ $product ? $product['name'] : '—' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Lens</span>
                                    <span class="font-medium text-[#1a3c2e]" id="selected-lens-display">Standard</span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-500">Accessory</span>
                                    <span class="font-medium text-[#1a3c2e]" id="selected-accessory-display">Default
                                        Case</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ============================================================
                RIGHT COLUMN - Customization Options
                ============================================================ --}}
                <div class="lg:col-span-7">
                    {{-- Lens Selection --}}
                    <div class="mb-10 reveal">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold font-serif text-[#1a3c2e]">Choose Your Lens</h3>
                            <span
                                class="text-xs font-semibold tracking-wider text-[#1a3c2e] bg-[#1a3c2e]/[0.08] px-3 py-1.5 rounded-full uppercase">Required</span>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                            @foreach ($lenses as $lens)
                                <x-lens-option
                                    :id="$lens->id"
                                    :numid="$lens->id"
                                    name="{{ $lens->name }}"
                                    value="{{ Str::slug($lens->name) }}"
                                    price="{{ $lens->price }}"
                                    icon="{{ $lens->icon ?? '👓' }}"
                                    description="{{ $lens->description }}"
                                    :stocks="$lens->stocks"
                                    :selected="$loop->first" />
                            @endforeach
                        </div>
                    </div>

                    {{-- Accessories Selection --}}
                    <div class="mb-10 reveal">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold font-serif text-[#1a3c2e]">Choose Your Accessories</h3>
                            <span
                                class="text-xs font-semibold tracking-wider text-gray-500 bg-gray-100 px-3 py-1.5 rounded-full">Optional</span>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                            @foreach ($accessories as $accessory)
                                <x-accessory-option
                                    :id="$accessory->id"
                                    :numid="$accessory->id"
                                    name="{{ $accessory->name }}"
                                    value="{{ Str::slug($accessory->name) }}"
                                    price="{{ $accessory->price }}"
                                    icon="{{ $accessory->icon ?? '📦' }}"
                                    description="{{ $accessory->description }}"
                                    :stocks="$accessory->stocks"
                                    :selected="$loop->first" />
                            @endforeach
                        </div>
                    </div>

                    {{-- Price Summary & Actions --}}
                    <div class="reveal">
                        <div
                            class="bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-sm hover:shadow-md transition-shadow duration-300">
                            {{-- Price Breakdown --}}
                            <h4 class="text-lg font-semibold font-serif text-[#1a3c2e] mb-4">Order Summary</h4>
                            <div class="space-y-3 text-sm">
                                <div class="flex items-center justify-between py-1">
                                    <span class="text-gray-500">Frame</span>
                                    <span class="font-medium text-[#1a3c2e]" id="frame-price-display">
                                        ${{ $product ? $product['price'] : '0' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between py-1">
                                    <span class="text-gray-500">Lens</span>
                                    <span class="font-medium text-[#1a3c2e]" id="lens-price-display">$0</span>
                                </div>
                                <div class="flex items-center justify-between py-1">
                                    <span class="text-gray-500">Accessory</span>
                                    <span class="font-medium text-[#1a3c2e]" id="accessory-price-display">$0</span>
                                </div>
                                <div class="border-t border-gray-100 pt-4 mt-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-base font-bold text-[#1a3c2e]">Total</span>
                                        <span class="text-2xl font-bold text-[#1a3c2e]" id="total-price-display">
                                            ${{ $product ? $product['price'] : '0' }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-end gap-1.5 mt-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                        </svg>
                                        <p class="text-xs text-gray-400">Free shipping on all orders</p>
                                    </div>
                                </div>
                            </div>
                            {{-- Action Buttons --}}
                            <div class="flex flex-col sm:flex-row gap-3 mt-6">
                                <a href="{{ url()->previous() }}"
                                    class="flex-1 text-center py-3.5 border-2 border-[#1a3c2e]/20 hover:border-[#1a3c2e] rounded-full font-medium text-gray-600 hover:text-[#1a3c2e] hover:bg-[#1a3c2e]/[0.02] transition-all duration-300">
                                    ← Back
                                </a>
                                <button onclick="proceedToCheckout()"
                                    class="flex-[2] text-center py-3.5 bg-[#1a3c2e] hover:bg-[#2a5c3e] text-white rounded-full font-semibold text-base transition-all duration-300 shadow-lg shadow-[#1a3c2e]/20 hover:shadow-xl hover:shadow-[#1a3c2e]/30 hover:-translate-y-0.5 active:scale-[0.98]">
                                    Proceed to Order →
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- ============================================================
    SCRIPTS
    ============================================================ --}}
    @push('scripts')
        <script>
            (function() {
                'use strict';
                // ============================================================
                // STATE
                // ============================================================
                const state = {
                    frameId: {{ $product ? $product['id'] : 'null' }},
                    framePrice: {{ $product ? $product['price'] : 0 }},
                    lensId: {{ $lenses->first() ? $lenses->first()->id : 'null' }},
                    lensPrice: {{ $lenses->first() ? $lenses->first()->price : 0 }},
                    lensName: '{{ $lenses->first() ? $lenses->first()->name : 'Standard' }}',
                    accessoryId: {{ $accessories->first() ? $accessories->first()->id : 'null' }},
                    accessoryPrice: {{ $accessories->first() ? $accessories->first()->price : 0 }},
                    accessoryName: '{{ $accessories->first() ? $accessories->first()->name : 'Default Case' }}',
                };
                // DOM refs
                const lensPriceDisplay = document.getElementById('lens-price-display');
                const accessoryPriceDisplay = document.getElementById('accessory-price-display');
                const totalPriceDisplay = document.getElementById('total-price-display');
                const selectedLensDisplay = document.getElementById('selected-lens-display');
                const selectedAccessoryDisplay = document.getElementById('selected-accessory-display');
                // ============================================================
                // UPDATE UI
                // ============================================================
                function updatePriceDisplay() {
                    const total = state.framePrice + state.lensPrice + state.accessoryPrice;
                    if (lensPriceDisplay) lensPriceDisplay.textContent = '$' + state.lensPrice;
                    if (accessoryPriceDisplay) accessoryPriceDisplay.textContent = '$' + state.accessoryPrice;
                    if (totalPriceDisplay) totalPriceDisplay.textContent = '$' + total;
                    if (selectedLensDisplay) selectedLensDisplay.textContent = state.lensName;
                    if (selectedAccessoryDisplay) selectedAccessoryDisplay.textContent = state.accessoryName;
                }
                // ============================================================
                // SELECTION HANDLERS
                // ============================================================
                window.selectLens = function(value, price, name, id, numId) {
                    state.lensPrice = price;
                    state.lensName = name;
                    state.lensId = numId;
                    document.querySelectorAll('.lens-card').forEach(function(card) {
                        card.classList.remove('border-[#1a3c2e]', 'bg-[#1a3c2e]/[0.08]', 'shadow-md',
                            'shadow-[#1a3c2e]/10');
                        card.classList.add('border-gray-200');
                        const check = card.querySelector('.check-indicator');
                        if (check) {
                            check.classList.remove('bg-[#1a3c2e]', 'border-[#1a3c2e]');
                            check.classList.add('border-gray-300');
                            check.innerHTML = '';
                        }
                    });
                    const activeCards = document.querySelectorAll('.lens-card');
                    activeCards.forEach(function(card) {
                        const input = card.querySelector('input[name="lens"]');
                        if (input && input.value === value) {
                            card.classList.remove('border-gray-200');
                            card.classList.add('border-[#1a3c2e]', 'bg-[#1a3c2e]/[0.08]', 'shadow-md',
                                'shadow-[#1a3c2e]/10');
                            input.checked = true;
                            const check = card.querySelector('.check-indicator');
                            if (check) {
                                check.classList.remove('border-gray-300');
                                check.classList.add('bg-[#1a3c2e]', 'border-[#1a3c2e]');
                                check.innerHTML =
                                    '<svg class="w-full h-full text-white p-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>';
                            }
                        }
                    });
                    updatePriceDisplay();
                };
                window.selectAccessory = function(value, price, name, id, numid) {
                    state.accessoryPrice = price;
                    state.accessoryName = name;
                    state.accessoryId = numid;
                    document.querySelectorAll('.accessory-card').forEach(function(card) {
                        card.classList.remove('border-[#1a3c2e]', 'bg-[#1a3c2e]/[0.08]', 'shadow-md',
                            'shadow-[#1a3c2e]/10');
                        card.classList.add('border-gray-200');
                        const check = card.querySelector('.check-indicator');
                        if (check) {
                            check.classList.remove('bg-[#1a3c2e]', 'border-[#1a3c2e]');
                            check.classList.add('border-gray-300');
                            check.innerHTML = '';
                        }
                    });
                    const activeCards = document.querySelectorAll('.accessory-card');
                    activeCards.forEach(function(card) {
                        const input = card.querySelector('input[name="accessory"]');
                        if (input && input.value === value) {
                            card.classList.remove('border-gray-200');
                            card.classList.add('border-[#1a3c2e]', 'bg-[#1a3c2e]/[0.08]', 'shadow-md',
                                'shadow-[#1a3c2e]/10');
                            input.checked = true;
                            const check = card.querySelector('.check-indicator');
                            if (check) {
                                check.classList.remove('border-gray-300');
                                check.classList.add('bg-[#1a3c2e]', 'border-[#1a3c2e]');
                                check.innerHTML =
                                    '<svg class="w-full h-full text-white p-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>';
                            }
                        }
                    });
                    updatePriceDisplay();
                };
                // ============================================================
                // PROCEED TO CHECKOUT
                // ============================================================
                window.proceedToCheckout = function() {
                    const params = new URLSearchParams();
                    if (state.frameId !== null) params.set('frame_id', state.frameId);
                    if (state.lensId !== null) params.set('lens_id', state.lensId);
                    if (state.accessoryId !== null) params.set('accessory_id', state.accessoryId);
                    window.location.href = '/order?' + params.toString();
                };
                // ============================================================
                // SCROLL REVEAL ANIMATIONS
                // ============================================================
                const revealElements = document.querySelectorAll('.reveal');
                if (revealElements.length > 0) {
                    const revealObserver = new IntersectionObserver(function(entries) {
                        entries.forEach(function(entry) {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('visible');
                                revealObserver.unobserve(entry.target);
                            }
                        });
                    }, {
                        threshold: 0.1,
                        rootMargin: '0px 0px -50px 0px'
                    });
                    revealElements.forEach(function(el) {
                        revealObserver.observe(el);
                    });
                }
            })();
        </script>
    @endpush

    {{-- ============================================================
    CUSTOM STYLES
    ============================================================ --}}
    @push('styles')
        <style>
            .reveal {
                opacity: 0;
                transform: translateY(30px);
                transition: opacity 0.7s cubic-bezier(0.16, 1, 0.3, 1),
                    transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .reveal.visible {
                opacity: 1;
                transform: translateY(0);
            }

            html {
                scroll-behavior: smooth;
            }

            a:focus-visible,
            button:focus-visible,
            input:focus-visible {
                outline: 2px solid #1a3c2e;
                outline-offset: 2px;
                border-radius: 4px;
            }

            @media (prefers-reduced-motion: reduce) {
                .reveal {
                    opacity: 1;
                    transform: none;
                    transition: none;
                }

                html {
                    scroll-behavior: auto;
                }

                *,
                *::before,
                *::after {
                    animation-duration: 0.01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: 0.01ms !important;
                }
            }

            ::selection {
                background-color: #1a3c2e;
                color: white;
            }
        </style>
    @endpush
@endsection
