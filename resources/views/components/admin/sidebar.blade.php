@props(['activeRoute' => ''])

@php
    $navItems = [
        [
            'route' => 'admin.dashboard',
            'label' => 'Dashboard',
            'icon' => 'fa-solid fa-chart-pie',
        ],
        [
            'route' => 'admin.orders',
            'label' => 'Orders',
            'icon' => 'fa-solid fa-receipt',
            'badge' => '12',
        ],
        [
            'route' => 'admin.products',
            'label' => 'Products',
            'icon' => 'fa-solid fa-box-open',
        ],
        [
            'route' => 'admin.inventory',
            'label' => 'Inventory',
            'icon' => 'fa-solid fa-warehouse',
        ],
    ];

    $isActive = function ($route) use ($activeRoute) {
        return $activeRoute === $route || request()->routeIs($route);
    };
@endphp

<!-- Mobile Overlay -->
<div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-40 lg:hidden"></div>

<!-- Sidebar -->
<aside id="admin-sidebar"
    class="fixed lg:relative z-50 w-64 h-screen bg-gradient-to-b from-[#0a2a1e] via-[#0F3D2A] to-[#0d3526] flex flex-col shrink-0 transition-all duration-300 ease-in-out -translate-x-full lg:translate-x-0 sidebar-animate"
    aria-label="Admin navigation">

    <!-- Logo / Header -->
    <div class="relative overflow-hidden">
        <!-- Decorative gradient orbs -->
        <div class="absolute -top-16 -right-16 w-32 h-32 bg-[#f4d03f]/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-white/5 rounded-full blur-2xl"></div>

        <div class="relative px-6 pt-6 pb-5">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#f4d03f] to-[#e8b923] flex items-center justify-center shadow-lg shadow-[#f4d03f]/20 group-hover:shadow-[#f4d03f]/30 transition-all duration-300 group-hover:scale-105">
                    <svg class="w-5 h-5 text-[#0F3D2A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                    </svg>
                </div>
                <div>
                    <h1 class="sidebar-logo-text text-2xl font-serif font-bold tracking-wider text-white">
                        Optiqueue
                    </h1>
                    <p class="sidebar-subtitle text-[9px] uppercase tracking-[0.25em] text-[#f4d03f]/60 font-medium">
                        Admin Panel
                    </p>
                </div>
            </a>
        </div>
    </div>

    <!-- Navigation Label -->
    <div class="px-6 mb-2">
        <p class="sidebar-section-label text-[10px] uppercase tracking-[0.2em] text-white/20 font-semibold">Main Menu
        </p>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-3 pb-4 space-y-0.5 overflow-y-auto overflow-x-hidden" aria-label="Sidebar navigation">
        @foreach ($navItems as $item)
            @php $active = $isActive($item['route']); @endphp
            <a href="{{ route($item['route']) }}"
                class="sidebar-nav-item group flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ $active ? 'bg-[#f4d03f]/10 text-[#f4d03f] shadow-sm shadow-[#f4d03f]/5' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                <!-- Icon -->
                <span
                    class="sidebar-icon-wrap w-5 h-5 flex items-center justify-center shrink-0 {{ $active ? '' : 'group-hover:scale-110' }} transition-all duration-200">
                    <i
                        class="{{ $item['icon'] }} text-sm {{ $active ? 'text-[#f4d03f]' : 'text-white/40 group-hover:text-white/70' }}"></i>
                </span>
                <!-- Label -->
                <span class="nav-label flex-1">{{ $item['label'] }}</span>
                <!-- Badge -->
                @if (isset($item['badge']))
                    <span
                        class="nav-badge px-2 py-0.5 rounded-full bg-[#f4d03f]/15 text-[#f4d03f] text-[10px] font-bold">
                        {{ $item['badge'] }}
                    </span>
                @endif
                <!-- Active Indicator -->
                @if ($active)
                    <span class="w-1.5 h-1.5 rounded-full bg-[#f4d03f] animate-pulse-soft shrink-0"></span>
                @endif
            </a>
        @endforeach

        <!-- Divider -->
        <div class="my-4 border-t border-white/5"></div>

        <!-- Secondary nav label -->
        <p class="sidebar-section-label px-3 mb-2 text-[10px] uppercase tracking-[0.2em] text-white/20 font-semibold">
            Management</p>

        <!-- Quick Stats -->
        <div class="sidebar-stats px-4 py-3 mt-2 rounded-xl bg-white/5 border border-white/5">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs text-white/40">Today's Revenue</span>
                <span class="text-xs font-semibold text-[#f4d03f]">+12.5%</span>
            </div>
            <p class="text-lg font-bold text-white">$2,847</p>
            <div class="mt-2 h-1 bg-white/10 rounded-full overflow-hidden">
                <div class="h-full w-3/4 bg-gradient-to-r from-[#f4d03f] to-[#e8b923] rounded-full"></div>
            </div>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="px-3 pb-4 border-t border-white/5 pt-3">
        <!-- Collapse toggle (desktop) -->
        <button id="sidebarCollapseToggle"
            class="hidden lg:flex items-center gap-3 w-full px-4 py-2.5 rounded-xl text-sm font-medium text-white/40 hover:text-white hover:bg-white/5 transition-all duration-200 mb-1">
            <i class="fa-solid fa-chevron-left text-xs"></i>
            <span class="nav-label">Collapse</span>
        </button>

        <a href="/admin/login"
            class="group flex items-center gap-3 w-full px-4 py-2.5 rounded-xl text-sm font-medium text-white/40 hover:text-red-300 hover:bg-red-500/10 transition-all duration-200">
            <span class="w-5 h-5 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-right-from-bracket text-sm group-hover:translate-x-0.5 transition-transform"></i>
            </span>
            <span class="sidebar-footer-text">Log Out</span>
        </a>
    </div>
</aside>

@pushOnce('styles')
    <style>
        /* Sidebar slide-in animation */
        .sidebar-animate {
            animation: sidebarSlideIn 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes sidebarSlideIn {
            from {
                opacity: 0;
                transform: translateX(-24px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Soft pulse for active indicator */
        .animate-pulse-soft {
            animation: pulseSoft 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulseSoft {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.5;
                transform: scale(0.8);
            }
        }

        /* Sidebar scrollbar */
        #admin-sidebar nav::-webkit-scrollbar {
            width: 3px;
        }

        #admin-sidebar nav::-webkit-scrollbar-track {
            background: transparent;
        }

        #admin-sidebar nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
        }

        /* Active nav item glow effect */
        .sidebar-nav-item.bg-\\[\\#f4d03f\\]\\/10 {
            position: relative;
        }

        .sidebar-nav-item.bg-\\[\\#f4d03f\\]\\/10::after {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: #f4d03f;
            border-radius: 0 3px 3px 0;
        }

        /* Mobile responsive */
        @media (max-width: 1023px) {
            #admin-sidebar {
                box-shadow: 4px 0 24px rgba(0, 0, 0, 0.2);
            }
        }
    </style>
@endpushOnce
