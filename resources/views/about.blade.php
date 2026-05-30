@extends('layouts.app')

@section('title', 'About Us - Optiqueue')

@section('content')

    {{-- ============================================================
    HERO / PAGE HEADER
    ============================================================ --}}
    <section
        class="relative min-h-[60vh] flex items-center bg-gradient-to-br from-[#f8faf7] via-white to-[#f0f5f0] pt-20 md:pt-24 overflow-hidden"
        aria-label="About Us hero">
        <div class="absolute top-[-10%] right-[-5%] w-[60%] h-[60%] bg-[#1a3c2e]/[0.03] rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[50%] h-[50%] bg-[#f4d03f]/[0.08] rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-3xl mx-auto text-center reveal stagger-1">
                <span
                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-wider text-[#1a3c2e] bg-[#1a3c2e]/[0.08] rounded-full mb-6 uppercase">About
                    Us</span>
                <h1
                    class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold font-serif text-[#1a3c2e] leading-[1.1] tracking-tight">
                    See Clearly,
                    <span class="block text-[#f4d03f]">Look</span>
                    <span class="block">Confidently</span>
                </h1>
                <p class="mt-6 text-base sm:text-lg text-gray-600 leading-relaxed max-w-2xl mx-auto">
                    At Optiqueue, we believe premium eyewear is more than just vision correction — it's an expression of
                    your identity. Every frame we curate is selected with precision, craftsmanship, and your unique style in
                    mind.
                </p>
            </div>
        </div>
    </section>

    {{-- ============================================================
    OUR STORY
    ============================================================ --}}
    <section class="relative py-16 md:py-24 bg-white" aria-labelledby="story-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="reveal">
                    <span
                        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-wider text-[#1a3c2e] bg-[#1a3c2e]/[0.08] rounded-full mb-4 uppercase">Our
                        Story</span>
                    <h2 id="story-heading"
                        class="text-3xl md:text-4xl lg:text-5xl font-bold font-serif text-gray-900 leading-tight">
                        Crafted with Passion,<br>Designed for You
                    </h2>
                    <div class="mt-6 space-y-4 text-gray-600 leading-relaxed">
                        <p>
                            Founded in 2020, Optiqueue started with a simple mission: to make premium eyewear accessible
                            without compromising on quality or style. What began as a small boutique has grown into a
                            destination for discerning individuals who value craftsmanship and design.
                        </p>
                        <p>
                            Every frame in our collection is hand-picked from the finest manufacturers across the globe —
                            from the acetate artisans of Italy to the titanium craftsmen of Japan. We pair each frame with
                            Zeiss-certified lenses to ensure your vision is as sharp as your style.
                        </p>
                        <p>
                            But we didn't stop there. Our AI-powered Virtual Try-On technology lets you experience frames
                            from the comfort of your home, while our Free Home Trial program ensures you find the perfect
                            fit — no pressure, no hassle.
                        </p>
                    </div>
                </div>
                <div class="relative reveal stagger-2">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl shadow-[#1a3c2e]/10">
                        <img src="https://images.unsplash.com/photo-1591076482161-42ce6da69f67?w=800&q=80&auto=format&fit=crop"
                            alt="Our premium eyewear collection displayed on a minimal surface"
                            class="w-full h-auto object-cover aspect-[4/5] md:aspect-[3/4]" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#1a3c2e]/20 via-transparent to-transparent">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
    GALLERY
    ============================================================ --}}
    <section class="relative py-16 md:py-24 bg-[#f8faf7]" aria-labelledby="gallery-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal">
                <span
                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-wider text-[#1a3c2e] bg-[#1a3c2e]/[0.08] rounded-full mb-4 uppercase">Moments</span>
                <h2 id="gallery-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold font-serif text-gray-900">
                    Our Community</h2>
                <p class="mt-3 text-gray-600 max-w-lg mx-auto">Real people, real style — see how Optiqueue fits into your
                    life</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 md:gap-8">
                <div class="group rounded-2xl overflow-hidden shadow-lg reveal">
                    <div class="overflow-hidden aspect-square">
                        <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=600&q=80&auto=format&fit=crop"
                            alt="Happy customer wearing Optiqueue frames"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                </div>
                <div class="group rounded-2xl overflow-hidden shadow-lg reveal stagger-2">
                    <div class="overflow-hidden aspect-square">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&q=80&auto=format&fit=crop"
                            alt="Stylish eyewear on display"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                </div>
                <div class="group rounded-2xl overflow-hidden shadow-lg reveal stagger-3">
                    <div class="overflow-hidden aspect-square">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=600&q=80&auto=format&fit=crop"
                            alt="Customer enjoying their new glasses"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
    VALUES / WHY CHOOSE US
    ============================================================ --}}
    <section class="relative py-16 md:py-24 bg-[#1a3c2e] overflow-hidden" aria-labelledby="values-heading">
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-white/[0.02] rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
        </div>
        <div
            class="absolute bottom-0 left-0 w-64 h-64 bg-[#f4d03f]/[0.04] rounded-full blur-3xl translate-y-1/2 -translate-x-1/2">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 reveal">
                <span
                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-wider text-[#f4d03f] bg-[#f4d03f]/[0.12] rounded-full mb-4 uppercase">Our
                    Values</span>
                <h2 id="values-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold font-serif text-white">
                    What We Stand For</h2>
                <p class="mt-3 text-gray-300 max-w-lg mx-auto">Every decision we make is guided by these core principles
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
                    <h3 class="text-lg font-semibold text-white mb-2">Uncompromising Quality</h3>
                    <p class="text-sm text-gray-300 leading-relaxed">We source only the finest materials — Japanese
                        titanium, Italian acetate, and Zeiss-certified optics — ensuring every frame meets our exacting
                        standards.</p>
                </div>

                <div class="bg-white/[0.06] backdrop-blur-sm rounded-2xl p-8 reveal border border-white/[0.08]">
                    <div class="w-12 h-12 bg-[#f4d03f]/20 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-[#f4d03f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Customer First</h3>
                    <p class="text-sm text-gray-300 leading-relaxed">From free home trials to 30-day returns, we put your
                        satisfaction at the heart of everything we do. Your perfect frame is out there — we'll help you find
                        it.</p>
                </div>

                <div class="bg-white/[0.06] backdrop-blur-sm rounded-2xl p-8 reveal border border-white/[0.08]">
                    <div class="w-12 h-12 bg-[#f4d03f]/20 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-[#f4d03f]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Innovation Driven</h3>
                    <p class="text-sm text-gray-300 leading-relaxed">Our AI-powered Virtual Try-On and seamless online
                        experience make finding your perfect pair easier than ever — no appointment needed.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
    CTA SECTION
    ============================================================ --}}
    <section class="relative py-16 md:py-24 bg-white" aria-labelledby="cta-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-[#1a3c2e] to-[#0f2a1e] rounded-3xl overflow-hidden reveal">
                <div class="absolute top-0 right-0 w-72 h-72 bg-[#f4d03f]/[0.06] rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/[0.03] rounded-full blur-3xl"></div>

                <div class="relative px-6 py-14 md:px-16 md:py-20 text-center">
                    <span
                        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-wider text-[#f4d03f] bg-[#f4d03f]/[0.12] rounded-full mb-4 uppercase">Get
                        Started</span>
                    <h2 id="cta-heading" class="text-3xl md:text-4xl lg:text-5xl font-bold font-serif text-white">
                        Ready to See the Difference?</h2>
                    <p class="mt-3 text-gray-300 max-w-xl mx-auto">Explore our collection and find the frames that
                        perfectly express your style. Experience the Optiqueue difference today.</p>

                    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('frames.men') }}"
                            class="inline-flex items-center justify-center px-8 py-3.5 text-sm font-semibold text-[#1a3c2e] bg-[#f4d03f] rounded-full hover:bg-[#e5c234] transition-all duration-300 shadow-lg shadow-[#f4d03f]/20 hover:shadow-xl hover:shadow-[#f4d03f]/30 hover:-translate-y-0.5">
                            Shop Men's Frames
                        </a>
                        <a href="{{ route('frames.women') }}"
                            class="inline-flex items-center justify-center px-8 py-3.5 text-sm font-semibold text-white bg-white/10 border border-white/20 rounded-full hover:bg-white/20 transition-all duration-300">
                            Shop Women's Frames
                        </a>
                    </div>
                </div>
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

            .reveal.stagger-1 {
                transition-delay: 0.05s;
            }

            .reveal.stagger-2 {
                transition-delay: 0.15s;
            }

            .reveal.stagger-3 {
                transition-delay: 0.25s;
            }

            @media (prefers-reduced-motion: reduce) {
                .reveal {
                    opacity: 1;
                    transform: none;
                    transition: none;
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
