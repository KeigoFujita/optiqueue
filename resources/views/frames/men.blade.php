@extends('layouts.app')

@section('title', "Men's Frames - Optiqueue")

@section('content')

    {{-- ============================================================
    PAGE HEADER
    ============================================================ --}}
    <section class="relative pt-24 md:pt-28 pb-8 md:pb-12 bg-gradient-to-br from-[#f8faf7] via-white to-[#f0f5f0]"
        aria-label="Men's frames header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 reveal">
                <div>
                    <span
                        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-wider text-[#1a3c2e] bg-[#1a3c2e]/[0.08] rounded-full mb-4 uppercase">Collection</span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold font-serif text-gray-900 leading-tight">
                        Men's Frames</h1>
                    <p class="mt-2 text-gray-600 max-w-lg">Discover our curated collection of premium frames designed for
                        the modern man.</p>
                </div>

                {{-- Sort By Dropdown --}}
                <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-3">
                    @if (request('filter') && request('filter') !== 'all')
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                    @endif
                    <label for="sort-select" class="text-sm font-medium text-gray-600 whitespace-nowrap">Sort by</label>
                    <select id="sort-select" name="sort" onchange="this.form.submit()"
                        class="border border-gray-200 rounded-full px-5 py-2.5 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-[#1a3c2e] focus:border-transparent shadow-sm hover:border-gray-300 transition-colors">
                        <option value="low" {{ $currentSort === 'low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="high" {{ $currentSort === 'high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </form>
            </div>
        </div>
    </section>

    {{-- ============================================================
    MEN'S FRAMES GRID
    ============================================================ --}}
    <section class="relative py-8 md:py-12 bg-white" aria-labelledby="mens-frames-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Filter Chips --}}
            <div class="flex flex-wrap items-center gap-3 mb-8 reveal" id="filter-bar">
                <span class="text-sm font-medium text-gray-600 mr-1">Filter:</span>

                @php
                    $filterOptions = [
                        'all' => 'All',
                        'Bestseller' => 'Best Seller',
                        'New' => 'New',
                        'Sale' => 'Sale',
                    ];
                @endphp

                @foreach ($filterOptions as $value => $label)
                    <a href="{{ url()->current() }}?filter={{ $value }}&sort={{ $currentSort }}"
                        class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-300 shadow-sm
                        {{ $currentFilter === $value ? 'bg-[#1a3c2e] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                @forelse ($products as $product)
                    <x-product-card :image="asset('storage/' . $product->image_path)" :name="$product->name" :description="$product->description" :price="$product->price"
                        :old-price="$product->old_price" :badge="$product->badge" :badge-color="$product->badge_color"
                        :product-id="$product->id" :stocks="$product->stocks" />
                @empty
                    <p class="col-span-full text-center text-gray-500 py-12">No products available at the moment.</p>
                @endforelse
            </div>
        </div>
    </section>

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

    {{-- ============================================================
    SCRIPTS
    ============================================================ --}}
    @push('scripts')
        <script>
            (function() {
                'use strict';

                // Scroll Reveal Animations
                const revealElements = document.querySelectorAll('.reveal');
                if (revealElements.length > 0) {
                    const revealObserver = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('visible');
                                revealObserver.unobserve(entry.target);
                            }
                        });
                    }, {
                        threshold: 0.1,
                        rootMargin: '0px 0px -50px 0px'
                    });
                    revealElements.forEach(el => revealObserver.observe(el));
                }

            })();
        </script>
    @endpush
@endsection
