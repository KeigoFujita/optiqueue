<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Optiqueue - Premium Eyewear & Optical Clinic | See Clearly, Look Confidently">
    <meta name="keywords" content="eyewear, glasses, optical clinic, prescription glasses, sunglasses, fashion frames">
    <meta name="author" content="Optiqueue">

    <title>@yield('title', 'Optiqueue - Premium Eyewear')</title>

    <!-- Vite + Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Fonts (Optional - you can remove if not needed) -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        :root {
            --primary: #1a3c2e;
            --accent: #f4d03f;
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', sans-serif;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-white text-gray-900">

    {{-- ============================================================
    NAVIGATION
    ============================================================ --}}
    <header
        class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-100/50 transition-all duration-300"
        id="site-header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20">
                {{-- Logo --}}
                <a href="/" class="flex items-center gap-2 group" aria-label="Optiqueue Home">
                    <span
                        class="text-2xl md:text-3xl font-bold font-serif tracking-widest text-[#1a3c2e] group-hover:text-[#2a5c3e] transition-colors">Optiqueue</span>
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex items-center gap-x-10" aria-label="Main navigation">
                    @php
                        $navLinks = [
                            ['href' => '/frames/men', 'label' => 'Men'],
                            ['href' => '/frames/women', 'label' => 'Women'],
                            ['href' => '/about', 'label' => 'About Us'],
                        ];
                    @endphp
                    @foreach ($navLinks as $link)
                        @php $isActive = request()->is(ltrim($link['href'], '/')) @endphp
                        <a href="{{ $link['href'] }}"
                            class="text-sm font-medium transition-colors relative after:absolute after:bottom-[-4px] after:left-0 after:h-[2px] after:bg-[#1a3c2e] after:transition-all {{ $isActive ? 'text-[#1a3c2e] after:w-full' : 'text-gray-600 hover:text-[#1a3c2e] after:w-0 hover:after:w-full' }}">{{ $link['label'] }}</a>
                    @endforeach
                </nav>

                {{-- Right Actions --}}
                <div class="flex items-center gap-x-4 md:gap-x-6">
                    <a href="{{ route('admin.login') }}"
                        class="hidden sm:inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-[#1a3c2e] rounded-full hover:bg-[#2a5c3e] transition-all duration-300 shadow-sm hover:shadow-md">
                        Log In
                    </a>
                    {{-- Mobile Menu Toggle --}}
                    <button class="md:hidden p-2 text-gray-600 hover:text-[#1a3c2e] transition-colors"
                        id="mobile-menu-btn" aria-label="Toggle menu" aria-expanded="false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="menu-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div class="md:hidden hidden border-t border-gray-100 bg-white" id="mobile-menu">
            <div class="px-4 py-6 space-y-4">
                @php
                    $mobileNavLinks = [
                        ['href' => '/frames/men', 'label' => 'Men'],
                        ['href' => '/frames/women', 'label' => 'Women'],
                        ['href' => '/about', 'label' => 'About Us'],
                    ];
                @endphp
                @foreach ($mobileNavLinks as $link)
                    @php $isActive = request()->is(ltrim($link['href'], '/')) @endphp
                    <a href="{{ $link['href'] }}"
                        class="block py-2 text-base font-medium transition-colors {{ $isActive ? 'text-[#1a3c2e] font-semibold' : 'text-gray-600 hover:text-[#1a3c2e]' }}">{{ $link['label'] }}</a>
                @endforeach
                <hr class="border-gray-100">
                <a href="{{ route('admin.login') }}"
                    class="block w-full text-center px-4 py-2.5 text-sm font-medium text-white bg-[#1a3c2e] rounded-full transition-colors hover:bg-[#2a5c3e]">Log
                    In</a>
            </div>
        </div>
    </header>


    @yield('content')

    @stack('scripts')

    <footer class="bg-[#1a3c2e] text-gray-300">
        <div class="max-w-7xl mx-auto px-6 py-16">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <h3
                        class="text-white text-lg font-medium mb-4 relative after:absolute after:bottom-[-8px] after:left-0 after:w-10 after:h-[2px] after:bg-[#f4d03f]">
                        Optiqueue</h3>
                    <p class="text-sm">Premium eyewear crafted with precision and style.</p>
                </div>

                <div>
                    <h4 class="text-white font-medium mb-4">Shop</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/frames/men" class="hover:text-white transition-colors">Men's Frames</a></li>
                        <li><a href="/frames/women" class="hover:text-white transition-colors">Women's Frames</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Best Sellers</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">New Arrivals</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-medium mb-4">Company</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/about" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Our Story</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Sustainability</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-medium mb-4">Support</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Track Order</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Returns</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">FAQs</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Size Guide</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 mt-12 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} Optiqueue. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>
