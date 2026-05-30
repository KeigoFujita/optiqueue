<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Optiqueue Admin Login — Secure access for administrators">
    <meta name="robots" content="noindex, nofollow">

    <title>Admin Login — Optiqueue</title>

    <!-- Vite + Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #0F3D2A;
            --primary-dark: #072217;
            --accent: #E8B923;
            --accent-glow: rgba(232, 185, 35, 0.3);
        }

        body {
            font-family: 'Inter', system-ui, sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', Georgia, serif;
        }

        /* ──────────────────────────────────────────────
           Animated mesh gradient background
           ────────────────────────────────────────────── */
        @keyframes meshShift {
            0% {
                background-position: 0% 0%;
            }

            25% {
                background-position: 100% 0%;
            }

            50% {
                background-position: 100% 100%;
            }

            75% {
                background-position: 0% 100%;
            }

            100% {
                background-position: 0% 0%;
            }
        }

        .mesh-bg {
            background:
                radial-gradient(ellipse 80% 60% at 0% 20%, rgba(232, 185, 35, 0.07) 0%, transparent 60%),
                radial-gradient(ellipse 60% 80% at 100% 80%, rgba(15, 61, 42, 0.4) 0%, transparent 60%),
                radial-gradient(ellipse 70% 50% at 50% 0%, rgba(232, 185, 35, 0.04) 0%, transparent 60%),
                linear-gradient(145deg, #0a2a1e 0%, #072217 40%, #0d3526 70%, #061a12 100%);
            background-size: 200% 200%;
            animation: meshShift 30s ease-in-out infinite;
        }

        /* ──────────────────────────────────────────────
           Floating gradient orbs
           ────────────────────────────────────────────── */
        @keyframes orbFloat1 {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(40px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 30px) scale(0.95);
            }
        }

        @keyframes orbFloat2 {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(-30px, 40px) scale(0.9);
            }

            66% {
                transform: translate(20px, -20px) scale(1.05);
            }
        }

        @keyframes orbFloat3 {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.4;
            }

            50% {
                transform: translate(60px, -30px) scale(1.2);
                opacity: 0.7;
            }
        }

        .orb-1 {
            animation: orbFloat1 25s ease-in-out infinite;
            opacity: 0.65;
        }

        .orb-2 {
            animation: orbFloat2 20s ease-in-out infinite;
            opacity: 0.75;
        }

        .orb-3 {
            animation: orbFloat3 18s ease-in-out infinite;
            opacity: 0.5;
        }

        /* ──────────────────────────────────────────────
           Noise texture overlay
           ────────────────────────────────────────────── */
        .noise-overlay::after {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 256px 256px;
        }

        /* ──────────────────────────────────────────────
           Glass card
           ────────────────────────────────────────────── */
        .glass-card {
            background: rgba(255, 255, 255, 0.035);
            backdrop-filter: blur(40px) saturate(1.2);
            -webkit-backdrop-filter: blur(40px) saturate(1.2);
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow:
                0 25px 60px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.06);
        }

        /* ──────────────────────────────────────────────
           Form inputs — dark glass style
           ────────────────────────────────────────────── */
        .login-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #f1f5f9;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .login-input::placeholder {
            color: rgba(148, 163, 184, 0.45);
        }

        .login-input:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(255, 255, 255, 0.12);
        }

        .login-input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--accent);
            box-shadow:
                0 0 0 3px var(--accent-glow),
                0 4px 20px rgba(0, 0, 0, 0.25);
            outline: none;
        }

        .login-input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 30px #0d3526 inset !important;
            -webkit-text-fill-color: #f1f5f9 !important;
            border-color: rgba(232, 185, 35, 0.3) !important;
        }

        /* Input icon styling */
        .input-icon {
            color: rgba(148, 163, 184, 0.4);
            transition: color 0.3s ease;
        }

        .input-group:focus-within .input-icon {
            color: var(--accent);
        }

        /* ──────────────────────────────────────────────
           Submit button — glass + gold accent
           ────────────────────────────────────────────── */
        .btn-submit {
            position: relative;
            background: linear-gradient(135deg, var(--accent), #f4d03f);
            color: #072217;
            font-weight: 700;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #f4d03f, #d4a820);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow:
                0 12px 35px rgba(232, 185, 35, 0.35),
                0 4px 15px rgba(232, 185, 35, 0.2);
        }

        .btn-submit:hover::after {
            opacity: 1;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit>* {
            position: relative;
            z-index: 1;
        }

        /* ──────────────────────────────────────────────
           Logo glow pulse
           ────────────────────────────────────────────── */
        @keyframes logoPulse {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(232, 185, 35, 0.15), 0 0 60px rgba(232, 185, 35, 0.05);
            }

            50% {
                box-shadow: 0 0 35px rgba(232, 185, 35, 0.3), 0 0 80px rgba(232, 185, 35, 0.1);
            }
        }

        .logo-glow {
            animation: logoPulse 4s ease-in-out infinite;
        }

        /* ──────────────────────────────────────────────
           Card entrance stagger
           ────────────────────────────────────────────── */
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            opacity: 0;
            animation: fadeSlideUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        .delay-3 {
            animation-delay: 0.3s;
        }

        .delay-4 {
            animation-delay: 0.4s;
        }

        .delay-5 {
            animation-delay: 0.5s;
        }

        /* ──────────────────────────────────────────────
           Shake on error
           ────────────────────────────────────────────── */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        .shake {
            animation: shake 0.6s ease-in-out;
        }

        /* ──────────────────────────────────────────────
           Password toggle icon
           ────────────────────────────────────────────── */
        .toggle-btn {
            color: rgba(148, 163, 184, 0.4);
            transition: color 0.2s ease;
        }

        .toggle-btn:hover {
            color: rgba(148, 163, 184, 0.7);
        }

        /* ──────────────────────────────────────────────
           Decorative lines / particles
           ────────────────────────────────────────────── */
        @keyframes lineDrift {
            0% {
                transform: translateX(-100%) rotate(0deg);
            }

            100% {
                transform: translateX(400%) rotate(15deg);
            }
        }

        .drift-line {
            animation: lineDrift 12s linear infinite;
        }

        .drift-line:nth-child(2) {
            animation-delay: -4s;
            animation-duration: 15s;
        }

        .drift-line:nth-child(3) {
            animation-delay: -8s;
            animation-duration: 18s;
        }

        /* Scrollbar hide */
        ::-webkit-scrollbar {
            display: none;
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
        }
    </style>
</head>

<body class="mesh-bg min-h-screen noise-overlay">

    <!-- Decorative drifting lines -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden opacity-[0.03]">
        <div class="drift-line absolute top-1/4 left-0 w-32 h-px bg-[#E8B923]"></div>
        <div class="drift-line absolute top-2/3 left-0 w-48 h-px bg-[#E8B923]"></div>
        <div class="drift-line absolute top-1/3 left-0 w-24 h-px bg-white"></div>
    </div>

    <!-- Floating gradient orbs -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="orb-1 absolute -top-40 -right-40 w-[35rem] h-[35rem] rounded-full bg-[#E8B923]/8 blur-[120px]">
        </div>
        <div class="orb-2 absolute -bottom-48 -left-40 w-[40rem] h-[40rem] rounded-full bg-[#0F3D2A]/30 blur-[120px]">
        </div>
        <div
            class="orb-3 absolute top-1/3 left-1/2 -translate-x-1/2 w-[50rem] h-[50rem] rounded-full bg-[#E8B923]/5 blur-[150px]">
        </div>
    </div>

    <!-- Main container -->
    <div class="relative min-h-screen flex items-center justify-center px-4 py-12">

        <div class="w-full max-w-md">

            <!-- Logo badge -->
            <div class="text-center mb-8 animate-in delay-1">
                <div
                    class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full border border-white/10 bg-white/5 text-white/40 text-[10px] font-semibold uppercase tracking-[0.25em] backdrop-blur-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#E8B923] animate-pulse"></span>
                    Admin Access
                </div>
            </div>

            <!-- Glass Card -->
            <div class="glass-card rounded-3xl overflow-hidden animate-in delay-2">

                <!-- Brand header -->
                <div class="relative px-10 pt-12 pb-6 text-center overflow-hidden">
                    <!-- Inner card glow -->
                    <div
                        class="absolute -top-20 left-1/2 -translate-x-1/2 w-64 h-32 bg-[#E8B923]/10 rounded-full blur-[60px]">
                    </div>

                    <div class="relative">
                        <!-- Logo -->
                        <div
                            class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#E8B923] to-[#f4d03f] flex items-center justify-center mx-auto mb-5 logo-glow">
                            <svg class="w-8 h-8 text-[#072217]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </div>

                        <h1 class="text-3xl font-serif font-bold text-white tracking-[0.12em]">
                            Optiqueue
                        </h1>
                        <div
                            class="w-8 h-0.5 bg-gradient-to-r from-transparent via-[#E8B923] to-transparent mx-auto my-3 rounded-full">
                        </div>
                        <p class="text-sm font-medium text-white/60">Sign in to continue</p>
                    </div>
                </div>

                <!-- Form -->
                <div class="px-10 pb-10">
                    <form action="{{ route('admin.login') }}" method="POST" class="space-y-5">
                        @csrf

                        <!-- Email -->
                        <div class="input-group">
                            <label for="email"
                                class="block text-xs font-medium text-white/50 mb-2 tracking-wider uppercase">
                                Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="input-icon fa-regular fa-envelope text-sm"></i>
                                </div>
                                <input type="email" id="email" name="email" required autocomplete="email"
                                    autofocus
                                    class="login-input w-full pl-11 pr-5 py-3.5 rounded-2xl text-sm placeholder:text-white/30"
                                    placeholder="admin@optiqueue.com">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="input-group">
                            <label for="password"
                                class="block text-xs font-medium text-white/50 mb-2 tracking-wider uppercase">
                                Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="input-icon fa-solid fa-lock text-sm"></i>
                                </div>
                                <input type="password" id="password" name="password" required
                                    autocomplete="current-password"
                                    class="login-input w-full pl-11 pr-12 py-3.5 rounded-2xl text-sm placeholder:text-white/30"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword()"
                                    class="toggle-btn absolute inset-y-0 right-0 pr-4 flex items-center">
                                    <i class="fa-regular fa-eye text-sm" id="toggleIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="pt-2">
                            <button type="submit"
                                class="btn-submit w-full py-3.5 rounded-2xl text-sm tracking-wider flex items-center justify-center gap-3">
                                <span>Sign In</span>
                                <i
                                    class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                            </button>
                        </div>

                        <!-- Error handling -->
                        @if ($errors->any())
                            <div class="mt-4 p-3 rounded-xl bg-red-500/10 border border-red-500/20 shake">
                                <p class="text-xs text-red-300 text-center">
                                    <i class="fa-solid fa-circle-exclamation mr-1.5"></i>
                                    Invalid credentials. Please try again.
                                </p>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-center gap-4 mt-8 animate-in delay-5">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 text-white/20 hover:text-white/50 transition-colors text-xs font-medium">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Back to Website</span>
                </a>
                <span class="text-white/10 text-[10px]">&copy; {{ date('Y') }}</span>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Remove shake class after animation ends
        document.querySelectorAll('.shake').forEach(el => {
            el.addEventListener('animationend', () => el.classList.remove('shake'));
        });
    </script>

</body>

</html>
