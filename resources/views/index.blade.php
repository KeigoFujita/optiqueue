@extends('layouts.app')

@section('title', 'Optiqueue — Premium Eyewear | See Clearly, Look Confidently')

@section('content')

    {{-- ============================================================
    HERO SECTION
    ============================================================ --}}
    <section
        class="relative min-h-screen flex items-center bg-gradient-to-br from-[#f8faf7] via-white to-[#f0f5f0] pt-20 md:pt-24 overflow-hidden"
        aria-label="Hero">
        {{-- Decorative background elements --}}
        <div class="absolute top-[-10%] right-[-5%] w-[60%] h-[60%] bg-[#1a3c2e]/[0.03] rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[50%] h-[50%] bg-[#f4d03f]/[0.08] rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                {{-- Hero Text --}}
                <div class="reveal stagger-1 pt-8 lg:pt-0">
                    <span
                        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-wider text-[#1a3c2e] bg-[#1a3c2e]/[0.08] rounded-full mb-6 uppercase">Spring
                        Collection 2026</span>
                    <h1
                        class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold font-serif text-[#1a3c2e] leading-[1.1] tracking-tight">
                        See Clearly,
                        <span class="block text-[#f4d03f]">Look</span>
                        <span class="block">Confidently</span>
                    </h1>
                    <p class="mt-6 text-base sm:text-lg text-gray-600 leading-relaxed max-w-lg">
                        Discover premium eyewear crafted for the modern individual.
                        Precision optics meet timeless design — find your perfect frame today.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="#bestsellers"
                            class="group inline-flex items-center justify-center px-8 py-3.5 text-sm font-semibold text-white bg-[#1a3c2e] rounded-full hover:bg-[#2a5c3e] transition-all duration-300 shadow-lg shadow-[#1a3c2e]/20 hover:shadow-xl hover:shadow-[#1a3c2e]/30 hover:-translate-y-0.5">
                            Shop Best Sellers
                            <svg class="w-4 h-4 ml-2 transition-transform group-hover:translate-x-1" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>

                    {{-- Trust badges --}}
                    <div class="mt-10 flex flex-wrap items-center gap-x-8 gap-y-3">
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            30-Day Returns
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            2-Year Warranty
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Free Shipping
                        </div>
                    </div>
                </div>

                {{-- Hero Image --}}
                <div class="relative reveal stagger-2">
                    <div class="relative z-10">
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl shadow-[#1a3c2e]/10">
                            <img src="https://images.unsplash.com/photo-1574258495973-f010dfbb5371?w=800&q=80&auto=format&fit=crop"
                                alt="Elegant eyewear frame collection displayed on a minimal white surface"
                                class="w-full h-auto object-cover aspect-[4/5] md:aspect-[3/4]" loading="eager">
                            {{-- Overlay gradient --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-[#1a3c2e]/20 via-transparent to-transparent">
                            </div>
                        </div>
                        {{-- Floating badge 1 --}}
                        <div
                            class="absolute -bottom-4 -left-4 bg-white rounded-2xl shadow-xl p-4 flex items-center gap-3 reveal stagger-3">
                            <div class="w-10 h-10 bg-[#f4d03f]/20 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#f4d03f]" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">4.9/5</p>
                                <p class="text-xs text-gray-500">from 2,400+ reviews</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
    VALUE PROPOSITION STRIP
    ============================================================ --}}
    <section class="relative bg-white border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 md:gap-8 justify-items-center">
                <div class="flex items-center gap-3 reveal">
                    <div class="w-10 h-10 bg-[#1a3c2e]/[0.08] rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-[#1a3c2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">30-Day Returns</p>
                        <p class="text-xs text-gray-500">No questions asked</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 reveal">
                    <div class="w-10 h-10 bg-[#1a3c2e]/[0.08] rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-[#1a3c2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">2-Year Warranty</p>
                        <p class="text-xs text-gray-500">Quality guaranteed</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 reveal">
                    <div class="w-10 h-10 bg-[#1a3c2e]/[0.08] rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-[#1a3c2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Free Shipping</p>
                        <p class="text-xs text-gray-500">On orders over $50</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
    FEATURED CATEGORIES
    ============================================================ --}}
    <section class="relative py-16 md:py-24 bg-[#f8faf7]" aria-labelledby="categories-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal">
                <span
                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-wider text-[#1a3c2e] bg-[#1a3c2e]/[0.08] rounded-full mb-4 uppercase">Collections</span>
                <h2 id="categories-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold font-serif text-gray-900">
                    Shop by Category</h2>
                <p class="mt-3 text-gray-600 max-w-lg mx-auto">Find your perfect frame from our curated collections</p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                {{-- Men's --}}
                <a href="{{ route('frames.men') }}" class="group relative rounded-2xl overflow-hidden aspect-[3/4] reveal">
                    <img src="https://images.unsplash.com/photo-1591076482161-42ce6da69f67?w=600&q=80&auto=format&fit=crop"
                        alt="Collection of men's eyewear frames in modern designs"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-5 md:p-6">
                        <h3 class="text-lg md:text-xl font-bold text-white">Men's</h3>
                        <p class="text-sm text-white/80 mt-1">{{ $menCount }} styles</p>
                    </div>
                </a>

                {{-- Women's --}}
                <a href="{{ route('frames.women') }}" class="group relative rounded-2xl overflow-hidden aspect-[3/4] reveal">
                    <img src="https://images.unsplash.com/photo-1591076482161-42ce6da69f67?w=600&q=80&auto=format&fit=crop"
                        alt="Collection of women's eyewear frames in elegant styles"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-5 md:p-6">
                        <h3 class="text-lg md:text-xl font-bold text-white">Women's</h3>
                        <p class="text-sm text-white/80 mt-1">{{ $womenCount }} styles</p>
                    </div>
                </a>

                {{-- Lens --}}
                <a href="{{ route('home') }}" class="group relative rounded-2xl overflow-hidden aspect-[3/4] reveal">
                    <img src="https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=600&q=80&auto=format&fit=crop"
                        alt="Premium lens collection for crystal clear vision"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-5 md:p-6">
                        <h3 class="text-lg md:text-xl font-bold text-white">Lens</h3>
                        <p class="text-sm text-white/80 mt-1">{{ $lensCount }} types</p>
                    </div>
                </a>

                {{-- Accessories --}}
                <a href="{{ route('home') }}" class="group relative rounded-2xl overflow-hidden aspect-[3/4] reveal">
                    <img src="https://images.unsplash.com/photo-1574258495973-f010dfbb5371?w=600&q=80&auto=format&fit=crop"
                        alt="Eyewear accessories and care products"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-5 md:p-6">
                        <h3 class="text-lg md:text-xl font-bold text-white">Accessories</h3>
                        <p class="text-sm text-white/80 mt-1">{{ $accessoriesCount }} styles</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- ============================================================
    BEST SELLERS GRID
    ============================================================ --}}
    <section id="bestsellers" class="relative py-16 md:py-24 bg-white" aria-labelledby="bestsellers-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 reveal">
                <div>
                    <span
                        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-wider text-[#1a3c2e] bg-[#1a3c2e]/[0.08] rounded-full mb-4 uppercase">Best
                        Sellers</span>
                    <h2 id="bestsellers-heading"
                        class="text-3xl md:text-4xl lg:text-5xl font-bold font-serif text-gray-900">Most Loved Frames</h2>
                </div>
                <a href="{{ route('home') }}"
                    class="group inline-flex items-center gap-2 mt-4 md:mt-0 text-sm font-semibold text-[#1a3c2e] hover:text-[#2a5c3e] transition-colors">
                    View All
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @forelse ($bestSellers as $product)
                    <x-product-card :product-id="$product->id" :image="asset('storage/' . $product->image_path)" :name="$product->name" :description="$product->description" :price="$product->price"
                        :old-price="$product->old_price" :badge="$product->badge" :badge-color="$product->badge_color"
                        :stocks="$product->stocks" />
                @empty
                    <p class="col-span-full text-center text-gray-500 py-12">No products available at the moment.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ============================================================
    FEATURES / WHY CHOOSE US
    ============================================================ --}}
    <section class="relative py-16 md:py-24 bg-[#1a3c2e] overflow-hidden" aria-labelledby="features-heading">
        {{-- Decorative elements --}}
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-white/[0.02] rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
        </div>
        <div
            class="absolute bottom-0 left-0 w-64 h-64 bg-[#f4d03f]/[0.04] rounded-full blur-3xl translate-y-1/2 -translate-x-1/2">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 reveal">
                <span
                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-wider text-[#f4d03f] bg-[#f4d03f]/[0.12] rounded-full mb-4 uppercase">Why
                    Optiqueue</span>
                <h2 id="features-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold font-serif text-white">
                    Experience the Difference</h2>
                <p class="mt-3 text-gray-300 max-w-lg mx-auto">Every detail matters when it comes to your vision and style
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 md:gap-10">
                <div class="bg-white/[0.06] backdrop-blur-sm rounded-2xl p-8 reveal border border-white/[0.08]">
                    <div class="w-12 h-12 bg-[#f4d03f]/20 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-[#f4d03f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Premium Quality</h3>
                    <p class="text-sm text-gray-300 leading-relaxed">Handcrafted with precision materials — Japanese
                        titanium, Italian acetate, and Zeiss-certified lenses for crystal-clear vision.</p>
                </div>

                <div class="bg-white/[0.06] backdrop-blur-sm rounded-2xl p-8 reveal border border-white/[0.08]">
                    <div class="w-12 h-12 bg-[#f4d03f]/20 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-[#f4d03f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Premium Materials</h3>
                    <p class="text-sm text-gray-300 leading-relaxed">Every frame is crafted from high-quality acetate, titanium, and stainless steel for lasting durability and comfort.</p>
                </div>

                <div class="bg-white/[0.06] backdrop-blur-sm rounded-2xl p-8 reveal border border-white/[0.08]">
                    <div class="w-12 h-12 bg-[#f4d03f]/20 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-[#f4d03f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Free Home Trial</h3>
                    <p class="text-sm text-gray-300 leading-relaxed">Try 4 frames at home for free. Keep what you love,
                        return the rest with 30-day guarantee.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
    TESTIMONIALS
    ============================================================ --}}
    <section class="relative py-16 md:py-24 bg-[#f8faf7]" aria-labelledby="testimonials-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 reveal">
                <span
                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-wider text-[#1a3c2e] bg-[#1a3c2e]/[0.08] rounded-full mb-4 uppercase">Testimonials</span>
                <h2 id="testimonials-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold font-serif text-gray-900">
                    Loved by Thousands</h2>
                <p class="mt-3 text-gray-600 max-w-lg mx-auto">Hear from our customers about their Optiqueue experience</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 md:gap-8">
                {{-- Testimonial 1 --}}
                <div
                    class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 reveal hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center gap-1 mb-4">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 leading-relaxed text-sm">"The virtual try-on feature is a game-changer! I found
                        the perfect frames without leaving my house. The quality exceeded my expectations."</p>
                    <div class="mt-6 flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-[#1a3c2e] flex items-center justify-center text-white text-sm font-bold">
                            SM</div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Sarah M.</p>
                            <p class="text-xs text-gray-400">Verified Buyer</p>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 2 --}}
                <div
                    class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 reveal hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center gap-1 mb-4">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 leading-relaxed text-sm">"I was hesitant buying glasses online, but Optiqueue
                        made it effortless. The frames arrived in 3 days and they're absolutely stunning. Will definitely
                        order again!"</p>
                    <div class="mt-6 flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-amber-600 flex items-center justify-center text-white text-sm font-bold">
                            JD</div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">James D.</p>
                            <p class="text-xs text-gray-400">Verified Buyer</p>
                        </div>
                    </div>
                </div>

                {{-- Testimonial 3 --}}
                <div
                    class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 reveal hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center gap-1 mb-4">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 leading-relaxed text-sm">"The free home trial made choosing so easy. I tried 4
                        frames, kept 2! The quality is remarkable — you can feel the craftsmanship. Highly recommend."</p>
                    <div class="mt-6 flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-[#1a3c2e] flex items-center justify-center text-white text-sm font-bold">
                            AL</div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Alex L.</p>
                            <p class="text-xs text-gray-400">Verified Buyer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
    NEWSLETTER / CTA SECTION
    ============================================================ --}}
    <section class="relative py-16 md:py-24 bg-white" aria-labelledby="newsletter-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-[#1a3c2e] to-[#0f2a1e] rounded-3xl overflow-hidden reveal">
                {{-- Decorative --}}
                <div class="absolute top-0 right-0 w-72 h-72 bg-[#f4d03f]/[0.06] rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/[0.03] rounded-full blur-3xl"></div>

                <div class="relative px-6 py-14 md:px-16 md:py-20 text-center">
                    <span
                        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-wider text-[#f4d03f] bg-[#f4d03f]/[0.12] rounded-full mb-4 uppercase">Stay
                        Connected</span>
                    <h2 id="newsletter-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold font-serif text-white">
                        Join the Optiqueue Community</h2>
                    <p class="mt-3 text-gray-300 max-w-xl mx-auto">Subscribe for exclusive access to new collections, style
                        tips, and <strong class="text-white">15% off your first order</strong>.</p>

                    <form class="mt-8 max-w-lg mx-auto flex flex-col sm:flex-row gap-3" id="newsletter-form"
                        aria-label="Newsletter signup">
                        <label for="newsletter-email" class="sr-only">Email address</label>
                        <input type="email" id="newsletter-email" placeholder="Enter your email" required
                            autocomplete="email"
                            class="flex-1 px-5 py-3.5 bg-white/10 border border-white/20 rounded-full text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#f4d03f] focus:border-transparent text-sm transition-all">
                        <button type="submit"
                            class="px-8 py-3.5 bg-[#f4d03f] text-[#1a3c2e] font-semibold text-sm rounded-full hover:bg-[#e5c234] transition-all duration-300 shadow-lg shadow-[#f4d03f]/20 hover:shadow-xl hover:shadow-[#f4d03f]/30 whitespace-nowrap">
                            Subscribe
                        </button>
                    </form>
                    <p class="mt-4 text-xs text-gray-400">No spam, ever. Unsubscribe anytime. By subscribing, you agree to
                        our Privacy Policy.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
    CUSTOM STYLES
    ============================================================ --}}
    @push('styles')
        <style>
            /* ===== Reveal Animation Classes ===== */
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

            .reveal.stagger-1 {
                transition-delay: 0.05s;
            }

            .reveal.stagger-2 {
                transition-delay: 0.15s;
            }

            .reveal.stagger-3 {
                transition-delay: 0.25s;
            }

            .reveal.stagger-4 {
                transition-delay: 0.35s;
            }

            /* ===== Smooth scroll ===== */
            html {
                scroll-behavior: smooth;
            }

            /* ===== Header scroll effect ===== */
            .header-scrolled {
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
            }

            /* ===== Focus styles for accessibility ===== */
            a:focus-visible,
            button:focus-visible,
            input:focus-visible {
                outline: 2px solid #1a3c2e;
                outline-offset: 2px;
                border-radius: 4px;
            }

            /* ===== Reduced motion ===== */
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

            /* ===== Selection color ===== */
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

                // ============================
                // 1. INTERSECTION OBSERVER — Scroll Reveal Animations
                // ============================
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

                // ============================
                // 2. HEADER SCROLL EFFECT
                // ============================
                const header = document.getElementById('site-header');
                let lastScrollY = 0;

                if (header) {
                    window.addEventListener('scroll', () => {
                        const scrollY = window.scrollY;

                        if (scrollY > 50) {
                            header.classList.add('header-scrolled');
                            header.classList.remove('bg-white/80');
                            header.classList.add('bg-white/95');
                        } else {
                            header.classList.remove('header-scrolled');
                            header.classList.remove('bg-white/95');
                            header.classList.add('bg-white/80');
                        }

                        lastScrollY = scrollY;
                    }, {
                        passive: true
                    });
                }

                // ============================
                // 3. MOBILE MENU TOGGLE
                // ============================
                const menuBtn = document.getElementById('mobile-menu-btn');
                const mobileMenu = document.getElementById('mobile-menu');
                const menuIcon = document.getElementById('menu-icon');

                if (menuBtn && mobileMenu) {
                    menuBtn.addEventListener('click', () => {
                        const isOpen = mobileMenu.classList.toggle('hidden');
                        menuBtn.setAttribute('aria-expanded', !isOpen);

                        if (isOpen) {
                            // Hamburger
                            menuIcon.innerHTML =
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>';
                        } else {
                            // Close X
                            menuIcon.innerHTML =
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>';
                        }
                    });

                    // Close menu on link click
                    mobileMenu.querySelectorAll('a').forEach(link => {
                        link.addEventListener('click', () => {
                            mobileMenu.classList.add('hidden');
                            menuBtn.setAttribute('aria-expanded', 'false');
                            menuIcon.innerHTML =
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>';
                        });
                    });
                }

                // ============================
                // 4. NEWSLETTER FORM HANDLER
                // ============================
                const newsletterForm = document.getElementById('newsletter-form');
                if (newsletterForm) {
                    newsletterForm.addEventListener('submit', (e) => {
                        e.preventDefault();
                        const email = document.getElementById('newsletter-email').value.trim();
                        if (email) {
                            // Show success state
                            const btn = newsletterForm.querySelector('button[type="submit"]');
                            const originalText = btn.textContent;
                            btn.textContent = 'Subscribed! ✓';
                            btn.style.backgroundColor = '#22c55e';
                            btn.style.color = 'white';
                            btn.disabled = true;

                            setTimeout(() => {
                                btn.textContent = originalText;
                                btn.style.backgroundColor = '';
                                btn.style.color = '';
                                btn.disabled = false;
                                newsletterForm.reset();
                            }, 3000);
                        }
                    });
                }

                // ============================
                // 5. PRODUCT "ADD TO CART" FEEDBACK
                // ============================
                document.querySelectorAll('.group button').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        const originalText = this.textContent;
                        const originalClasses = this.className;

                        this.textContent = '✓ Added';
                        this.style.backgroundColor = '#22c55e';
                        this.style.color = 'white';

                        setTimeout(() => {
                            this.textContent = originalText;
                            this.style.backgroundColor = '';
                            this.style.color = '';
                        }, 2000);
                    });
                });

            })();
        </script>
    @endpush
@endsection
