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
                <div class="flex items-center gap-3">
                    <label for="sort-select" class="text-sm font-medium text-gray-600 whitespace-nowrap">Sort by</label>
                    <select id="sort-select"
                        class="border border-gray-200 rounded-full px-5 py-2.5 text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-[#1a3c2e] focus:border-transparent shadow-sm hover:border-gray-300 transition-colors">
                        <option value="featured">Featured</option>
                        <option value="low">Price: Low to High</option>
                        <option value="high">Price: High to Low</option>
                        <option value="new">Newest First</option>
                        <option value="popular">Most Popular</option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
    MEN'S FRAMES GRID
    ============================================================ --}}
    <section class="relative py-8 md:py-12 bg-white" aria-labelledby="mens-frames-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                @forelse ($products as $product)
                    <x-product-card :image="$product['image']" :name="$product['name']" :description="$product['description']" :price="$product['price']"
                        :old-price="$product['oldPrice']" :rating="$product['rating']" :reviews="$product['reviews']" :badge="$product['badge']" :badge-color="$product['badgeColor']"
                        :product-id="$product['id']" />
                @empty
                    <p class="col-span-full text-center text-gray-500 py-12">No products available at the moment.</p>
                @endforelse
            </div>

            {{-- Load More --}}
            <div class="mt-14 text-center reveal">
                <button onclick="loadMoreProducts()"
                    class="inline-flex items-center gap-2 px-8 py-3.5 text-sm font-semibold text-[#1a3c2e] bg-[#1a3c2e]/[0.08] rounded-full hover:bg-[#1a3c2e] hover:text-white transition-all duration-300 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Load More Products
                </button>
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

            function loadMoreProducts() {
                alert("In a real application, this would load more products via AJAX.");
            }
        </script>
    @endpush
@endsection
