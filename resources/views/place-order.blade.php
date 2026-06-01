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
                <a href="{{ route('home') }}" class="hover:text-[#1a3c2e] transition-colors duration-300">Home</a>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('checkout', ['frame_id' => $frame ? $frame->id : null ]) }}" class="hover:text-[#1a3c2e] transition-colors duration-300">Customize</a>
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
                                            <p class="text-sm text-gray-500" id="summary-frame">{{ $frame ? $frame->name : '—' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500" id="summary-frame-price">${{ $framePrice }}</p>
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
                                            <p class="text-sm text-gray-500" id="summary-lens">{{ $lens ? $lens->name : 'Standard' }}</p>
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
                                                {{ $accessory ? $accessory->name : 'Default Case' }}</p>
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
                                    <p id="email-error" class="text-xs text-red-500 mt-1 hidden"></p>
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
                                    <p id="otp-error" class="text-xs text-red-500 mt-1 hidden"></p>
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
                                <p id="personal-error" class="text-xs text-red-500 mt-1 hidden"></p>
                            </div>
                        </div>

                        {{-- Confirmation Modal (before placing order) --}}
                        <div id="confirmOrderModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
                            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
                                <div class="p-8 text-center">
                                    <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-[#1a3c2e]/10 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-[#1a3c2e]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Confirm Order</h3>
                                    <p class="text-gray-600 leading-relaxed mb-6">
                                        Are you sure you want to place this order?<br>
                                        <span class="font-semibold text-[#1a3c2e]">Total: ${{ $total }}</span>
                                    </p>
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <button onclick="closeConfirmModal()"
                                            class="flex-1 py-3.5 border-2 border-gray-200 hover:border-gray-300 rounded-xl font-medium text-gray-600 hover:text-gray-800 transition-all duration-300">
                                            Cancel
                                        </button>
                                        <button onclick="submitOrder()" id="confirmOrderBtn"
                                            class="flex-1 py-3.5 bg-[#1a3c2e] hover:bg-[#2a5c3e] text-white rounded-xl font-semibold transition-all duration-300 shadow-sm hover:shadow-md">
                                            Confirm Order
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Place Order Button --}}
                        <div class="reveal flex flex-col sm:flex-row items-center gap-4">
                            <a href="{{ $frameId ? route('checkout', ['frame_id' => $frameId]) : route('checkout') }}"
                                class="w-full sm:w-auto text-center py-4 px-10 border-2 border-[#1a3c2e]/20 hover:border-[#1a3c2e] rounded-xl font-medium text-gray-600 hover:text-[#1a3c2e] hover:bg-[#1a3c2e]/[0.02] transition-all duration-300">
                                ← Back to Customize
                            </a>
                            <button type="button" id="placeOrderBtn" onclick="showConfirmModal()" disabled
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
    OTP RESENT SUCCESS MODAL
    ============================================================ --}}
    <div id="otpResentModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 overflow-hidden transform transition-all duration-300 scale-95"
            id="otpResentModalContent">
            <div class="p-10 text-center">
                <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">OTP Resent Successfully!</h3>
                <p class="text-gray-600 leading-relaxed mb-6">
                    A new 6-digit verification code has been sent to <span class="font-semibold text-[#1a3c2e]" id="resent-email-display">your@email.com</span>
                </p>
                <button onclick="closeOtpResentModal()"
                    class="w-full bg-[#1a3c2e] hover:bg-[#2a5c3e] text-white px-10 py-4 rounded-2xl font-semibold transition-all duration-300 shadow-sm hover:shadow-md">
                    Got It
                </button>
            </div>
        </div>
    </div>

    {{-- ============================================================
    INVALID OTP MODAL
    ============================================================ --}}
    <div id="invalidOtpModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center z-50">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
            <div class="p-10 text-center">
                <div class="w-16 h-16 mx-auto mb-6 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Invalid OTP</h3>
                <p class="text-gray-600 leading-relaxed mb-6">
                    The OTP you entered is invalid or has expired. Please try again.
                </p>
                <button onclick="closeInvalidOtpModal()"
                    class="w-full bg-[#1a3c2e] hover:bg-[#2a5c3e] text-white px-10 py-4 rounded-2xl font-semibold transition-all duration-300 shadow-sm hover:shadow-md">
                    Try Again
                </button>
            </div>
        </div>
    </div>

    {{-- ============================================================
    SUCCESS MODAL (after order placed) - NOT CLOSEABLE OUTSIDE
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
                <p class="text-gray-600 leading-relaxed mb-4">
                    Your order has been placed. Please check your email for confirmation.
                </p>
                <p class="text-sm text-gray-500 mb-8" id="success-order-no"></p>
                <a href="{{ route('home') }}"
                    class="inline-block w-full bg-[#1a3c2e] hover:bg-[#2a5c3e] text-white px-10 py-4 rounded-2xl font-semibold transition-all duration-300 shadow-sm hover:shadow-md text-center">
                    Back to Homepage
                </a>
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
                    customerId: null,
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
                const emailError = document.getElementById('email-error');
                const otpError = document.getElementById('otp-error');
                const personalError = document.getElementById('personal-error');

                // ============================================================
                // CSRF TOKEN HELPER
                // ============================================================
                function getCsrfToken() {
                    return document.querySelector('input[name="_token"]').value;
                }

                // ============================================================
                // AJAX HELPER
                // ============================================================
                function ajaxPost(url, data, onSuccess, onError) {
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(data),
                    })
                    .then(function(response) {
                        return response.json().then(function(json) {
                            if (!response.ok) {
                                throw { status: response.status, body: json };
                            }
                            return json;
                        });
                    })
                    .then(function(json) {
                        if (onSuccess) onSuccess(json);
                    })
                    .catch(function(err) {
                        if (onError) onError(err);
                    });
                }

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
                // HANDLE VERIFY EMAIL - Send OTP via AJAX
                // ============================================================
                window.handleVerifyEmail = function() {
                    const email = emailInput.value.trim();

                    // Basic email validation
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!email) {
                        showError(emailError, 'Please enter your email address first.');
                        return;
                    }
                    if (!emailRegex.test(email)) {
                        showError(emailError, 'Please enter a valid email address.');
                        return;
                    }

                    hideError(emailError);

                    // Disable button and show loading
                    verifyEmailBtn.disabled = true;
                    verifyEmailBtn.textContent = 'Sending...';
                    verifyEmailBtn.classList.add('opacity-60', 'cursor-not-allowed');

                    state.email = email;

                    ajaxPost(
                        '{{ route("order.sendOtp") }}',
                        { email: email },
                        function(response) {
                            // Success - show OTP sent modal
                            verifyEmailBtn.textContent = 'Verify';
                            state.otpSent = true;
                            otpEmailDisplay.textContent = email;
                            modalEmailDisplay.textContent = email;

                            const modal = document.getElementById('otpSentModal');
                            modal.classList.remove('hidden');
                            setTimeout(function() {
                                const content = document.getElementById('otpModalContent');
                                if (content) content.classList.remove('scale-95');
                            }, 10);
                        },
                        function(error) {
                            verifyEmailBtn.disabled = false;
                            verifyEmailBtn.textContent = 'Verify';
                            verifyEmailBtn.classList.remove('opacity-60', 'cursor-not-allowed');
                            showError(emailError, error.body && error.body.message ? error.body.message : 'Failed to send OTP. Please try again.');
                        }
                    );
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
                // HANDLE VERIFY OTP - Verify via AJAX
                // ============================================================
                window.handleVerifyOtp = function() {
                    let code = '';
                    otpInputs.forEach(function(inp) {
                        code += inp.value;
                    });

                    if (code.length !== 6) {
                        showError(otpError, 'Please enter the complete 6-digit OTP code.');
                        return;
                    }

                    hideError(otpError);

                    // Disable button
                    verifyOtpBtn.disabled = true;
                    verifyOtpBtn.textContent = 'Verifying...';
                    verifyOtpBtn.classList.add('opacity-60', 'cursor-not-allowed');

                    ajaxPost(
                        '{{ route("order.verifyOtp") }}',
                        {
                            email: state.email,
                            otp: code,
                        },
                        function(response) {
                            // OTP verified successfully
                            state.otpVerified = true;
                            state.customerId = response.customer_id;

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
                        },
                        function(error) {
                            // OTP invalid or expired
                            verifyOtpBtn.disabled = false;
                            verifyOtpBtn.textContent = 'Verify OTP';
                            verifyOtpBtn.classList.remove('opacity-60', 'cursor-not-allowed');

                            // Show invalid OTP modal
                            document.getElementById('invalidOtpModal').classList.remove('hidden');

                            // Clear OTP inputs
                            otpInputs.forEach(function(inp) {
                                inp.value = '';
                            });
                            state.otpCode = '';
                            if (otpInputs.length > 0) otpInputs[0].focus();
                        }
                    );
                };

                // ============================================================
                // CLOSE INVALID OTP MODAL
                // ============================================================
                window.closeInvalidOtpModal = function() {
                    document.getElementById('invalidOtpModal').classList.add('hidden');
                };

                // ============================================================
                // RESEND OTP - via AJAX
                // ============================================================
                window.resendOtp = function() {
                    if (!state.email) return;

                    const resendBtns = document.querySelectorAll('button[onclick="resendOtp()"]');
                    const resendBtn = resendBtns.length > 0 ? resendBtns[0] : null;
                    if (resendBtn) {
                        resendBtn.disabled = true;
                        resendBtn.textContent = 'Sending...';
                    }

                    ajaxPost(
                        '{{ route("order.resendOtp") }}',
                        { email: state.email },
                        function(response) {
                            if (resendBtn) {
                                resendBtn.disabled = false;
                                resendBtn.textContent = 'Resend';
                            }

                            // Clear OTP inputs
                            otpInputs.forEach(function(inp) {
                                inp.value = '';
                            });
                            state.otpCode = '';
                            if (otpInputs.length > 0) otpInputs[0].focus();
                            startOtpTimer();

                            // Show resent success modal
                            document.getElementById('resent-email-display').textContent = state.email;
                            const modal = document.getElementById('otpResentModal');
                            modal.classList.remove('hidden');
                            setTimeout(function() {
                                const content = document.getElementById('otpResentModalContent');
                                if (content) content.classList.remove('scale-95');
                            }, 10);
                        },
                        function(error) {
                            if (resendBtn) {
                                resendBtn.disabled = false;
                                resendBtn.textContent = 'Resend';
                            }
                            showError(otpError, error.body && error.body.message ? error.body.message : 'Failed to resend OTP.');
                        }
                    );
                };

                // ============================================================
                // CLOSE OTP RESENT MODAL
                // ============================================================
                window.closeOtpResentModal = function() {
                    const modal = document.getElementById('otpResentModal');
                    modal.classList.add('hidden');
                };

                // ============================================================
                // SHOW CONFIRM MODAL (before placing order)
                // ============================================================
                window.showConfirmModal = function() {
                    const name = nameInput.value.trim();
                    const contact = contactInput.value.trim();

                    if (!name) {
                        showError(personalError, 'Please enter your full name.');
                        nameInput.focus();
                        return;
                    }
                    if (!contact) {
                        showError(personalError, 'Please enter your contact number.');
                        contactInput.focus();
                        return;
                    }
                    if (!state.otpVerified) {
                        showError(personalError, 'Please verify your email address first.');
                        return;
                    }

                    hideError(personalError);

                    // Show confirmation modal
                    document.getElementById('confirmOrderModal').classList.remove('hidden');
                };

                // ============================================================
                // CLOSE CONFIRM MODAL
                // ============================================================
                window.closeConfirmModal = function() {
                    document.getElementById('confirmOrderModal').classList.add('hidden');
                };

                // ============================================================
                // SUBMIT ORDER - via AJAX with DB transaction
                // ============================================================
                window.submitOrder = function() {
                    const confirmBtn = document.getElementById('confirmOrderBtn');
                    confirmBtn.disabled = true;
                    confirmBtn.textContent = 'Placing Order...';

                    ajaxPost(
                        '{{ route("order.store") }}',
                        {
                            email: state.email,
                            name: nameInput.value.trim(),
                            contact: contactInput.value.trim(),
                            frame_id: {{ $frameId ?? 'null' }},
                            lens_id: {{ $lensId ?? 'null' }},
                            accessory_id: {{ $accessoryId ?? 'null' }},
                        },
                        function(response) {
                            // Success - close confirm modal, show success modal
                            document.getElementById('confirmOrderModal').classList.add('hidden');

                            const successModal = document.getElementById('successModal');
                            document.getElementById('success-order-no').textContent = 'Order #' + response.order_no;
                            successModal.classList.remove('hidden');
                        },
                        function(error) {
                            confirmBtn.disabled = false;
                            confirmBtn.textContent = 'Confirm Order';
                            showError(personalError, error.body && error.body.message ? error.body.message : 'Failed to place order. Please try again.');
                            document.getElementById('confirmOrderModal').classList.add('hidden');
                        }
                    );
                };

                // ============================================================
                // ERROR DISPLAY HELPERS
                // ============================================================
                function showError(element, message) {
                    if (element) {
                        element.textContent = message;
                        element.classList.remove('hidden');
                    }
                }

                function hideError(element) {
                    if (element) {
                        element.classList.add('hidden');
                        element.textContent = '';
                    }
                }

                // ============================================================
                // MODAL CLOSE ON BACKGROUND CLICK
                // ============================================================
                document.getElementById('otpSentModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        // Don't close on background click, user must click "I've Got It"
                    }
                });

                document.getElementById('invalidOtpModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        // Don't close on background click, user must click "Try Again"
                    }
                });

                document.getElementById('confirmOrderModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        // Don't close on background click
                    }
                });

                // Success modal - NOT closeable outside (no background click handler)

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
