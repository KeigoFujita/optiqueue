@extends('layouts.app')

@section('title', 'Your Order - Optiqueue')

@section('content')
    {{-- ============================================================
    PAGE HEADER
    ============================================================ --}}
    <section class="relative pt-24 md:pt-28 pb-8 bg-[#1a3c2e]/5 border-b border-gray-100 overflow-hidden">
        <div class="absolute top-[-20%] right-[-10%] w-[40%] h-[40%] bg-[#1a3c2e]/[0.02] rounded-full blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-gray-400 mb-6" aria-label="Breadcrumb">
                <a href="/" class="hover:text-[#1a3c2e] transition-colors duration-300">Home</a>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="/checkout" class="hover:text-[#1a3c2e] transition-colors duration-300">Customize</a>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-[#1a3c2e] font-medium">Order</span>
            </nav>
            <div class="reveal">
                <span
                    class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-wider text-[#1a3c2e] bg-[#1a3c2e]/[0.08] rounded-full mb-4 uppercase">Review</span>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold font-serif text-[#1a3c2e] leading-tight">
                    Place Your Order
                </h1>
                <p class="mt-3 text-gray-500 max-w-xl">
                    Review your selection and provide your details to complete the order.
                </p>
            </div>
        </div>
    </section>

    {{-- ============================================================
    MAIN CONTENT
    ============================================================ --}}
    <main class="bg-[#f8faf7] min-h-screen pb-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <form id="orderForm" action="#" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12">
                    <div class="lg:col-span-12 space-y-8">

                        {{-- SECTION 1: Order Summary --}}
                        <div class="reveal bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-sm">
                            <h3 class="text-xl font-bold font-serif text-[#1a3c2e] mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-[#1a3c2e]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Order Summary
                            </h3>
                            <div class="space-y-4">
                                {{-- Frame Row --}}
                                <div class="flex items-center justify-between py-3 px-4 bg-[#1a3c2e]/[0.03] rounded-xl">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-[#1a3c2e]/10 flex items-center justify-center text-lg">
                                            👓</div>
                                        <div>
                                            <p class="font-semibold text-gray-900">Frame</p>
                                            <p class="text-sm text-gray-500" id="summary-frame">{{ $frame ?: '—' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500" id="summary-frame-price">
                                            ${{ $total - $lensPrice - $accessoryPrice }}</p>
                                    </div>
                                </div>

                                {{-- Lens Row --}}
                                <div class="flex items-center justify-between py-3 px-4 bg-[#1a3c2e]/[0.03] rounded-xl">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-[#1a3c2e]/10 flex items-center justify-center text-lg">
                                            🔵</div>
                                        <div>
                                            <p class="font-semibold text-gray-900">Lens</p>
                                            <p class="text-sm text-gray-500" id="summary-lens">{{ $lens ?: 'Standard' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500" id="summary-lens-price">${{ $lensPrice }}</p>
                                    </div>
                                </div>

                                {{-- Accessory Row --}}
                                <div class="flex items-center justify-between py-3 px-4 bg-[#1a3c2e]/[0.03] rounded-xl">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-[#1a3c2e]/10 flex items-center justify-center text-lg">
                                            📦</div>
                                        <div>
                                            <p class="font-semibold text-gray-900">Accessory</p>
                                            <p class="text-sm text-gray-500" id="summary-accessory">
                                                {{ $accessory ?: 'Default Case' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500" id="summary-accessory-price">${{ $accessoryPrice }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Divider --}}
                                <div class="border-t border-gray-100 pt-4 mt-2">
                                    <div class="flex items-center justify-between px-4">
                                        <span class="text-lg font-bold text-[#1a3c2e]">Total</span>
                                        <span class="text-2xl font-bold text-[#1a3c2e]"
                                            id="summary-total">${{ $total }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION 2: Customer Information --}}
                        <div class="reveal bg-white rounded-2xl border border-gray-100 p-6 md:p-8 shadow-sm">
                            <h3 class="text-xl font-bold font-serif text-[#1a3c2e] mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-[#1a3c2e]" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Customer Information
                            </h3>

                            {{-- Step Indicator --}}
                            <div class="flex items-center gap-2 mb-8">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-[#1a3c2e] text-white flex items-center justify-center text-sm font-semibold"
                                        id="step-1-indicator">1</div>
                                    <span class="text-sm font-medium text-gray-700">Verify Email</span>
                                </div>
                                <div class="w-12 h-0.5 bg-gray-200" id="step-connector-1"></div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center text-sm font-semibold"
                                        id="step-2-indicator">2</div>
                                    <span class="text-sm font-medium text-gray-400" id="step-2-label">Enter OTP</span>
                                </div>
                                <div class="w-12 h-0.5 bg-gray-200" id="step-connector-2"></div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center text-sm font-semibold"
                                        id="step-3-indicator">3</div>
                                    <span class="text-sm font-medium text-gray-400" id="step-3-label">Personal
                                        Details</span>
                                </div>
                            </div>

                            {{-- Step 1: Email --}}
                            <div id="step-1" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <div class="flex gap-3">
                                        <input type="email" name="email" id="email" required
                                            class="flex-1 px-5 py-3.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1a3c2e] focus:border-transparent transition-all duration-300"
                                            placeholder="your@email.com">
                                        <button type="button" id="verifyEmailBtn" onclick="handleVerifyEmail()"
                                            class="px-8 py-3.5 bg-[#1a3c2e] hover:bg-[#2a5c3e] text-white font-semibold rounded-xl transition-all duration-300 shadow-sm hover:shadow-md whitespace-nowrap">
                                            Verify
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-2">We'll send a 6-digit verification code to this
                                        email.</p>
                                </div>
                            </div>

                            {{-- Step 2: OTP (hidden initially) --}}
                            <div id="step-2" class="hidden space-y-4 mt-6 pt-6 border-t border-gray-100">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Enter OTP Code</label>
                                    <p class="text-sm text-gray-500 mb-4">A 6-digit code has been sent to <span
                                            id="otp-email-display" class="font-semibold text-[#1a3c2e]"></span></p>
                                    <div class="flex gap-3 justify-center mb-4" id="otp-inputs">
                                        @for ($i = 0; $i < 6; $i++)
                                            <input type="text" maxlength="1"
                                                class="otp-input w-12 h-14 text-center text-xl font-bold border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1a3c2e] focus:border-transparent transition-all duration-300"
                                                data-index="{{ $i }}" inputmode="numeric" pattern="[0-9]">
                                        @endfor
                                    </div>
                                    <div class="flex items-center justify-between mt-2">
                                        <p class="text-xs text-gray-400">Didn't receive the code? <button type="button"
                                                onclick="resendOtp()"
                                                class="text-[#1a3c2e] font-semibold hover:underline">Resend</button></p>
                                        <p class="text-xs text-gray-400" id="otp-timer">Expires in <span
                                                class="font-semibold text-[#1a3c2e]" id="otp-countdown">05:00</span></p>
                                    </div>
                                    <button type="button" id="verifyOtpBtn" onclick="handleVerifyOtp()"
                                        class="mt-4 w-full py-3.5 bg-[#1a3c2e] hover:bg-[#2a5c3e] text-white font-semibold rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                                        Verify OTP
                                    </button>
                                </div>
                            </div>

                            {{-- Step 3: Name & Contact (hidden until OTP verified) --}}
                            <div id="step-3" class="hidden space-y-4 mt-6 pt-6 border-t border-gray-100">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm font-medium text-green-700">Email verified successfully</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                        <input type="text" name="name" id="name" required
                                            class="w-full px-5 py-3.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1a3c2e] focus:border-transparent transition-all duration-300"
                                            placeholder="Enter your full name">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Contact Number</label>
                                        <input type="tel" name="contact" id="contact" required
                                            class="w-full px-5 py-3.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1a3c2e] focus:border-transparent transition-all duration-300"
                                            placeholder="+65 9123 4567">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Place Order Button --}}
                        <div class="reveal flex flex-col sm:flex-row items-center gap-4">
                            <a href="/checkout"
                                class="w-full sm:w-auto text-center py-4 px-10 border-2 border-[#1a3c2e]/20 hover:border-[#1a3c2e] rounded-xl font-medium text-gray-600 hover:text-[#1a3c2e] hover:bg-[#1a3c2e]/[0.02] transition-all duration-300">
                                ← Back to Customize
                            </a>
                            <button type="button" id="placeOrderBtn" onclick="placeOrder()" disabled
                                class="w-full sm:flex-1 py-4 px-10 bg-gray-300 text-gray-500 rounded-xl font-semibold transition-all duration-300 cursor-not-allowed">
                                Please complete your information
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </main>

    {{-- ============================================================
    OTP SENT MODAL
    ============================================================ --}}
    <div id="otpSentModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 overflow-hidden transform transition-all duration-300 scale-95"
            id="otpModalContent">
            <div class="p-10 text-center">
                <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-[#1a3c2e]/10 flex items-center justify-center">
                    <svg class="w-8 h-8 text-[#1a3c2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">OTP Sent Successfully!</h3>
                <p class="text-gray-600 leading-relaxed mb-2">
                    A 6-digit verification code has been sent to
                </p>
                <p class="font-semibold text-[#1a3c2e] mb-6" id="modal-email-display">your@email.com</p>
                <button onclick="closeOtpSentModal()"
                    class="w-full bg-[#1a3c2e] hover:bg-[#2a5c3e] text-white px-10 py-4 rounded-2xl font-semibold transition-all duration-300 shadow-sm hover:shadow-md">
                    I've Got It
                </button>
            </div>
        </div>
    </div>

    {{-- ============================================================
    SUCCESS MODAL (after order placed)
    ============================================================ --}}
    <div id="successModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
            <div class="p-10 text-center">
                <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-4">Order Placed Successfully!</h3>
                <p class="text-gray-600 leading-relaxed mb-8">
                    Please check your email for order confirmation.<br>
                    Download your receipt below.
                </p>
                <button onclick="downloadReceipt()"
                    class="w-full bg-[#1a3c2e] hover:bg-[#2a5c3e] text-white px-10 py-4 rounded-2xl font-semibold transition-all duration-300 shadow-sm hover:shadow-md">
                    Download Receipt
                </button>
            </div>
        </div>
    </div>

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
                    email: '',
                    emailVerified: false,
                    otpVerified: false,
                    otpSent: false,
                    otpCode: '',
                    timerInterval: null,
                    countdown: 300, // 5 minutes in seconds
                };

                // ============================================================
                // DOM REFS
                // ============================================================
                const step1 = document.getElementById('step-1');
                const step2 = document.getElementById('step-2');
                const step3 = document.getElementById('step-3');
                const step1Indicator = document.getElementById('step-1-indicator');
                const step2Indicator = document.getElementById('step-2-indicator');
                const step3Indicator = document.getElementById('step-3-indicator');
                const stepConnector1 = document.getElementById('step-connector-1');
                const stepConnector2 = document.getElementById('step-connector-2');
                const step2Label = document.getElementById('step-2-label');
                const step3Label = document.getElementById('step-3-label');
                const otpEmailDisplay = document.getElementById('otp-email-display');
                const modalEmailDisplay = document.getElementById('modal-email-display');
                const otpInputs = document.querySelectorAll('.otp-input');
                const verifyEmailBtn = document.getElementById('verifyEmailBtn');
                const verifyOtpBtn = document.getElementById('verifyOtpBtn');
                const placeOrderBtn = document.getElementById('placeOrderBtn');
                const emailInput = document.getElementById('email');
                const nameInput = document.getElementById('name');
                const contactInput = document.getElementById('contact');

                // ============================================================
                // STEP INDICATOR UPDATES
                // ============================================================
                function updateStepIndicator(step) {
                    // Reset all
                    [step1Indicator, step2Indicator, step3Indicator].forEach(el => {
                        el.className =
                            'w-8 h-8 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center text-sm font-semibold';
                    });
                    stepConnector1.className = 'w-12 h-0.5 bg-gray-200';
                    stepConnector2.className = 'w-12 h-0.5 bg-gray-200';
                    step2Label.className = 'text-sm font-medium text-gray-400';
                    step3Label.className = 'text-sm font-medium text-gray-400';

                    if (step >= 1) {
                        step1Indicator.className =
                            'w-8 h-8 rounded-full bg-[#1a3c2e] text-white flex items-center justify-center text-sm font-semibold';
                    }
                    if (step >= 2) {
                        stepConnector1.className = 'w-12 h-0.5 bg-[#1a3c2e]';
                        step2Indicator.className =
                            'w-8 h-8 rounded-full bg-[#1a3c2e] text-white flex items-center justify-center text-sm font-semibold';
                        step2Label.className = 'text-sm font-medium text-[#1a3c2e]';
                    }
                    if (step >= 3) {
                        stepConnector2.className = 'w-12 h-0.5 bg-[#1a3c2e]';
                        step3Indicator.className =
                            'w-8 h-8 rounded-full bg-[#1a3c2e] text-white flex items-center justify-center text-sm font-semibold';
                        step3Label.className = 'text-sm font-medium text-[#1a3c2e]';
                    }
                }

                // ============================================================
                // OTP TIMER
                // ============================================================
                function startOtpTimer() {
                    state.countdown = 300;
                    const countdownEl = document.getElementById('otp-countdown');
                    if (state.timerInterval) clearInterval(state.timerInterval);
                    state.timerInterval = setInterval(function() {
                        state.countdown--;
                        if (state.countdown <= 0) {
                            clearInterval(state.timerInterval);
                            state.timerInterval = null;
                            if (countdownEl) countdownEl.textContent = '00:00';
                            return;
                        }
                        const mins = Math.floor(state.countdown / 60);
                        const secs = state.countdown % 60;
                        if (countdownEl) countdownEl.textContent =
                            String(mins).padStart(2, '0') + ':' + String(secs).padStart(2, '0');
                    }, 1000);
                }

                // ============================================================
                // HANDLE VERIFY EMAIL
                // ============================================================
                window.handleVerifyEmail = function() {
                    const email = emailInput.value.trim();

                    // Basic email validation
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!email) {
                        alert('Please enter your email address first.');
                        return;
                    }
                    if (!emailRegex.test(email)) {
                        alert('Please enter a valid email address.');
                        return;
                    }

                    state.email = email;
                    state.otpSent = true;
                    otpEmailDisplay.textContent = email;
                    modalEmailDisplay.textContent = email;

                    // Show OTP sent modal
                    const modal = document.getElementById('otpSentModal');
                    modal.classList.remove('hidden');
                    setTimeout(function() {
                        const content = document.getElementById('otpModalContent');
                        if (content) content.classList.remove('scale-95');
                    }, 10);
                };

                // ============================================================
                // CLOSE OTP SENT MODAL & SHOW OTP INPUTS
                // ============================================================
                window.closeOtpSentModal = function() {
                    const modal = document.getElementById('otpSentModal');
                    modal.classList.add('hidden');

                    // Show step 2
                    step2.classList.remove('hidden');
                    updateStepIndicator(2);

                    // Focus first OTP input
                    if (otpInputs.length > 0) otpInputs[0].focus();

                    // Start timer
                    startOtpTimer();

                    // Disable email input and verify button
                    emailInput.disabled = true;
                    emailInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                    verifyEmailBtn.disabled = true;
                    verifyEmailBtn.classList.add('opacity-60', 'cursor-not-allowed');
                };

                // ============================================================
                // OTP INPUT AUTO-TAB
                // ============================================================
                otpInputs.forEach(function(input, index) {
                    input.addEventListener('input', function(e) {
                        const value = this.value;
                        if (value && index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                        // Update state
                        let code = '';
                        otpInputs.forEach(function(inp) {
                            code += inp.value;
                        });
                        state.otpCode = code;
                    });

                    input.addEventListener('keydown', function(e) {
                        if (e.key === 'Backspace' && !this.value && index > 0) {
                            otpInputs[index - 1].focus();
                        }
                    });

                    // Only allow digits
                    input.addEventListener('keypress', function(e) {
                        if (!/^\d$/.test(e.key)) {
                            e.preventDefault();
                        }
                    });

                    // Paste support
                    input.addEventListener('paste', function(e) {
                        e.preventDefault();
                        const paste = (e.clipboardData || window.clipboardData).getData('text');
                        const digits = paste.replace(/\D/g, '').substring(0, 6);
                        digits.split('').forEach(function(digit, i) {
                            if (otpInputs[i]) {
                                otpInputs[i].value = digit;
                            }
                        });
                        if (digits.length > 0) {
                            const focusIndex = Math.min(digits.length, 5);
                            otpInputs[focusIndex].focus();
                        }
                        let code = '';
                        otpInputs.forEach(function(inp) {
                            code += inp.value;
                        });
                        state.otpCode = code;
                    });
                });

                // ============================================================
                // HANDLE VERIFY OTP
                // ============================================================
                window.handleVerifyOtp = function() {
                    let code = '';
                    otpInputs.forEach(function(inp) {
                        code += inp.value;
                    });

                    if (code.length !== 6) {
                        alert('Please enter the complete 6-digit OTP code.');
                        return;
                    }

                    // In a real app, this would verify against the server
                    // For demo, any 6-digit code works
                    state.otpVerified = true;
                    state.otpCode = code;

                    // Stop timer
                    if (state.timerInterval) {
                        clearInterval(state.timerInterval);
                        state.timerInterval = null;
                    }

                    // Show step 3
                    step3.classList.remove('hidden');
                    updateStepIndicator(3);

                    // Enable place order button
                    placeOrderBtn.disabled = false;
                    placeOrderBtn.className =
                        'w-full sm:flex-1 py-4 px-10 bg-[#1a3c2e] hover:bg-[#2a5c3e] text-white rounded-xl font-semibold transition-all duration-300 shadow-sm hover:shadow-md';
                    placeOrderBtn.textContent = 'Place Order — ${{ $total }}';

                    // Disable OTP inputs
                    otpInputs.forEach(function(inp) {
                        inp.disabled = true;
                        inp.classList.add('bg-gray-100', 'cursor-not-allowed');
                    });
                    verifyOtpBtn.disabled = true;
                    verifyOtpBtn.classList.add('opacity-60', 'cursor-not-allowed');

                    // Show success on OTP button
                    verifyOtpBtn.textContent = '✓ Verified';
                    verifyOtpBtn.className =
                        'mt-4 w-full py-3.5 bg-green-600 text-white font-semibold rounded-xl transition-all duration-300';

                    // Focus name field
                    if (nameInput) nameInput.focus();
                };

                // ============================================================
                // RESEND OTP
                // ============================================================
                window.resendOtp = function() {
                    if (!state.email) return;
                    alert('A new OTP has been sent to ' + state.email);
                    // Clear OTP inputs
                    otpInputs.forEach(function(inp) {
                        inp.value = '';
                    });
                    state.otpCode = '';
                    if (otpInputs.length > 0) otpInputs[0].focus();
                    startOtpTimer();
                };

                // ============================================================
                // PLACE ORDER
                // ============================================================
                window.placeOrder = function() {
                    const name = nameInput.value.trim();
                    const contact = contactInput.value.trim();

                    if (!name) {
                        alert('Please enter your full name.');
                        nameInput.focus();
                        return;
                    }
                    if (!contact) {
                        alert('Please enter your contact number.');
                        contactInput.focus();
                        return;
                    }
                    if (!state.emailVerified && !state.otpVerified) {
                        alert('Please verify your email address first.');
                        return;
                    }

                    // Show success modal
                    const modal = document.getElementById('successModal');
                    modal.classList.remove('hidden');
                };

                // ============================================================
                // DOWNLOAD RECEIPT
                // ============================================================
                window.downloadReceipt = function() {
                    alert('📄 Receipt downloaded successfully! (Demo)');
                    // In real implementation: window.location.href = '/receipt/download';
                };

                // ============================================================
                // MODAL CLOSE ON BACKGROUND CLICK
                // ============================================================
                document.getElementById('otpSentModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        // Don't close on background click, user must click "I've Got It"
                    }
                });

                document.getElementById('successModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.add('hidden');
                    }
                });

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

            /* OTP input styling */
            .otp-input::-webkit-outer-spin-button,
            .otp-input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            .otp-input[type=text] {
                -moz-appearance: textfield;
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
