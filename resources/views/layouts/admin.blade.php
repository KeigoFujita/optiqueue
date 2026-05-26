<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Optiqueue - Admin Panel">
    <meta name="author" content="Optiqueue">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin - Optiqueue')</title>

    <!-- Vite + Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome 6 (Free) for comprehensive icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #0F3D2A;
            --primary-light: #1a5c3e;
            --primary-dark: #0a2a1e;
            --accent: #f4d03f;
            --accent-dark: #e8b923;
            --sidebar-bg: #0F3D2A;
            --sidebar-hover: #1a5c3e;
            --content-bg: #f0f2f5;
            --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.06);
            --card-shadow-hover: 0 10px 40px rgba(0, 0, 0, 0.08), 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--content-bg);
            color: #1e293b;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Playfair Display', Georgia, serif;
        }

        /* Scroll reveal animation */
        .content-fade-in {
            animation: contentFadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes contentFadeIn {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Staggered children animations */
        .stagger-children>* {
            opacity: 0;
            animation: staggerItem 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .stagger-children>*:nth-child(1) {
            animation-delay: 0.03s;
        }

        .stagger-children>*:nth-child(2) {
            animation-delay: 0.06s;
        }

        .stagger-children>*:nth-child(3) {
            animation-delay: 0.09s;
        }

        .stagger-children>*:nth-child(4) {
            animation-delay: 0.12s;
        }

        .stagger-children>*:nth-child(5) {
            animation-delay: 0.15s;
        }

        .stagger-children>*:nth-child(6) {
            animation-delay: 0.18s;
        }

        .stagger-children>*:nth-child(7) {
            animation-delay: 0.21s;
        }

        .stagger-children>*:nth-child(8) {
            animation-delay: 0.24s;
        }

        @keyframes staggerItem {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Card styles */
        .admin-card {
            background: white;
            border-radius: 1.25rem;
            border: 1px solid rgba(0, 0, 0, 0.04);
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .admin-card:hover {
            box-shadow: var(--card-shadow-hover);
            border-color: rgba(0, 0, 0, 0.06);
        }

        /* Table styles */
        .admin-table th {
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            padding: 1rem 1.5rem;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .admin-table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            color: #475569;
            font-size: 0.875rem;
        }

        .admin-table tbody tr {
            transition: all 0.2s ease;
        }

        .admin-table tbody tr:hover {
            background: #f8fafc;
        }

        .admin-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badge styles */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1.5;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-neutral {
            background: #f1f5f9;
            color: #475569;
        }

        /* Form styles */
        .admin-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            background: white;
            color: #1e293b;
        }

        .admin-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(244, 208, 63, 0.15);
        }

        .admin-input::placeholder {
            color: #94a3b8;
        }

        /* Button styles */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: var(--accent);
            color: #1e293b;
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(244, 208, 63, 0.25);
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: var(--accent-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(244, 208, 63, 0.35);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-dark {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: var(--primary);
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(15, 61, 42, 0.2);
            border: none;
            cursor: pointer;
        }

        .btn-dark:hover {
            background: var(--primary-light);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(15, 61, 42, 0.3);
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: transparent;
            color: #475569;
            font-weight: 500;
            font-size: 0.875rem;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            border: 1.5px solid #e2e8f0;
            cursor: pointer;
        }

        .btn-ghost:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        /* Focus styles for accessibility */
        a:focus-visible,
        button:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
            border-radius: 0.5rem;
        }

        /* Selection color */
        ::selection {
            background-color: var(--primary);
            color: white;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }

            .content-fade-in,
            .stagger-children>* {
                animation: none !important;
                opacity: 1 !important;
            }

            .sidebar-animate {
                animation: none !important;
            }
        }

        /* Smooth sidebar toggle */
        .sidebar-collapsed #admin-sidebar {
            width: 4.5rem;
        }

        .sidebar-collapsed .nav-label,
        .sidebar-collapsed .nav-badge,
        .sidebar-collapsed .sidebar-footer-text,
        .sidebar-collapsed .sidebar-logo-text,
        .sidebar-collapsed .sidebar-subtitle {
            display: none;
        }

        .sidebar-collapsed .sidebar-nav-item {
            justify-content: center;
            padding: 0.75rem;
        }

        .sidebar-collapsed .sidebar-icon-wrap {
            margin: 0;
        }

        .sidebar-collapsed .sidebar-stats,
        .sidebar-collapsed .sidebar-section-label {
            display: none;
        }

        /* Glass effect */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>

    @stack('styles')
</head>

<body class="antialiased">

    <div class="flex h-screen overflow-hidden bg-[#f0f2f5]" id="admin-app">

        <!-- Sidebar -->
        <x-admin.sidebar :activeRoute="request()->route()->getName()" />

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col overflow-hidden min-w-0" id="admin-main-content">

            @hasSection('page-header')
                <!-- Top Header Bar -->
                <header class="bg-white border-b border-gray-200/60 shrink-0 relative z-10">
                    <div class="px-8 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <!-- Mobile menu toggle -->
                            <button id="mobileSidebarToggle"
                                class="lg:hidden w-9 h-9 rounded-xl bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-500 hover:text-gray-700 transition-all">
                                <i class="fas fa-bars text-sm"></i>
                            </button>
                            <div class="content-fade-in">
                                @yield('page-header')
                            </div>
                        </div>
                        @hasSection('header-actions')
                            <div class="flex items-center gap-3 content-fade-in" style="animation-delay: 0.1s">
                                @yield('header-actions')
                            </div>
                        @endif
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto">
                <div class="content-fade-in" style="animation-duration: 0.4s;">
                    @yield('content')
                </div>
            </div>

        </main>

    </div>

    @stack('scripts')

    <script>
        (function() {
            'use strict';

            // Close modals on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.fixed.inset-0.z-50').forEach(modal => {
                        if (!modal.classList.contains('hidden')) {
                            modal.classList.add('hidden');
                        }
                    });
                }
            });

            // Prevent body scroll when modal is open
            const modalObserver = new MutationObserver(() => {
                const hasOpenModal = document.querySelector('.fixed.inset-0.z-50:not(.hidden)');
                document.body.style.overflow = hasOpenModal ? 'hidden' : '';
            });

            document.querySelectorAll('.fixed.inset-0.z-50').forEach(modal => {
                modalObserver.observe(modal, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            });

            // Mobile sidebar toggle
            const mobileToggle = document.getElementById('mobileSidebarToggle');
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            if (mobileToggle && sidebar) {
                mobileToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                    if (overlay) {
                        overlay.classList.toggle('hidden');
                        overlay.classList.toggle('flex');
                    }
                });

                if (overlay) {
                    overlay.addEventListener('click', function() {
                        sidebar.classList.add('-translate-x-full');
                        overlay.classList.add('hidden');
                        overlay.classList.remove('flex');
                    });
                }
            }

            // Sidebar collapse toggle (desktop)
            const collapseToggle = document.getElementById('sidebarCollapseToggle');
            if (collapseToggle) {
                collapseToggle.addEventListener('click', function() {
                    document.getElementById('admin-app').classList.toggle('sidebar-collapsed');
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('fa-chevron-left');
                        icon.classList.toggle('fa-chevron-right');
                    }
                });
            }

            // Auto-hide flash messages
            document.querySelectorAll('.flash-message').forEach(msg => {
                setTimeout(() => {
                    msg.style.opacity = '0';
                    msg.style.transform = 'translateY(-10px)';
                    setTimeout(() => msg.remove(), 300);
                }, 4000);
            });

        })();
    </script>

</body>

</html>
