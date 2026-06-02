@php
$faqs = [
    [
        'q' => 'How do I place an order?',
        'a' => 'Browse our frames, select one you like, then choose a lens and accessory (optional). Enter your email to receive a one-time passcode (OTP), verify it, fill in your details, and confirm your order. You&rsquo;ll receive an order number like <strong>ORD-XXXXXX</strong>.',
    ],
    [
        'q' => 'How does the OTP verification work?',
        'a' => 'After entering your email on the order page, we send a 6-digit code to your inbox. Enter that code to verify your identity. The code expires in 5 minutes &mdash; you can click &ldquo;Resend Code&rdquo; if you need a new one.',
    ],
    [
        'q' => 'What happens after I place my order?',
        'a' => 'You&rsquo;ll receive a confirmation email with your order number. We process your order and send status updates by email as it progresses. No account needed &mdash; everything is handled via email.',
    ],
    [
        'q' => 'Can I change or cancel my order?',
        'a' => 'Orders cannot be modified once submitted. If you need assistance, please email <strong>angelfaithibasco@gmail.com</strong> immediately and we&rsquo;ll try to help.',
    ],
    [
        'q' => 'How do I track my order?',
        'a' => 'Order status updates are sent to your email automatically. If you have questions, contact us at <strong>angelfaithibasco@gmail.com</strong>.',
    ],
    [
        'q' => 'What is your return policy?',
        'a' => 'We offer <strong>30-day returns</strong> on unused frames in their original condition. Contact us to initiate a return.',
    ],
    [
        'q' => 'Do you offer a warranty?',
        'a' => 'Yes! All frames come with a <strong>2-year warranty</strong> against manufacturing defects.',
    ],
    [
        'q' => 'How long does delivery take?',
        'a' => 'Standard delivery takes <strong>5&ndash;7 business days</strong>. You&rsquo;ll receive tracking information via email once shipped.',
    ],
    [
        'q' => 'What if a product is out of stock?',
        'a' => 'Out-of-stock items are clearly marked on product cards. Check back later or email <strong>angelfaithibasco@gmail.com</strong> for restock inquiries.',
    ],
    [
        'q' => 'What products do you offer?',
        'a' => 'We offer <strong>men&rsquo;s and women&rsquo;s frames</strong>, <strong>prescription lenses</strong>, and <strong>accessories</strong>. Browse our collection from the navigation menu.',
    ],
    [
        'q' => 'How does the Resend Code work?',
        'a' => 'If your OTP expires or you didn&rsquo;t receive it, click &ldquo;Resend Code&rdquo; on the verification screen. A new 6-digit code will be sent to your email, and the timer resets.',
    ],
];
@endphp

<div id="faq-chat-widget" class="fixed bottom-6 right-6 z-[9999] flex flex-col items-end">
    {{-- Chat Panel --}}
    <div id="faq-chat-panel"
        class="w-[380px] max-w-[calc(100vw-3rem)] bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden mb-4 transition-all duration-300 ease-out opacity-0 invisible translate-y-4 scale-95 origin-bottom-right">

        <div class="divide-y divide-gray-100">
            {{-- Header --}}
            <div class="p-4 bg-[#1a3c2e] text-white">
                <div class="flex items-center justify-between">
                    <h3 class="font-semibold text-lg">How can we help?</h3>
                    <button onclick="toggleFaqChat()"
                        class="text-white/70 hover:text-white transition-colors p-1 rounded-lg hover:bg-white/10 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="mt-1 h-0.5 w-12 bg-[#f4d03f] rounded-full"></div>
            </div>

            {{-- Search --}}
            <div class="p-3">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" id="faq-search" placeholder="Search questions..."
                        class="w-full pl-10 pr-4 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1a3c2e]/20 focus:border-[#1a3c2e] focus:bg-white transition-all placeholder:text-gray-400">
                </div>
            </div>

            {{-- List Area --}}
            <div class="overflow-y-auto" style="max-height: 360px;">
                {{-- Thinking Animation --}}
                <div id="faq-thinking" class="hidden flex items-center justify-center gap-1.5 py-8">
                    <span class="w-2 h-2 bg-[#1a3c2e] rounded-full animate-bounce" style="animation-delay: 0s;"></span>
                    <span class="w-2 h-2 bg-[#1a3c2e] rounded-full animate-bounce" style="animation-delay: 0.15s;"></span>
                    <span class="w-2 h-2 bg-[#1a3c2e] rounded-full animate-bounce" style="animation-delay: 0.3s;"></span>
                </div>

                {{-- FAQ Items --}}
                <div id="faq-items" class="p-1">
                    @foreach($faqs as $faq)
                        <div class="faq-item">
                            <button onclick="toggleFaqAnswer(this)"
                                class="w-full text-left px-3 py-3 rounded-xl hover:bg-gray-50 transition-colors group cursor-pointer">
                                <div class="flex items-start justify-between gap-3">
                                    <span class="text-sm font-medium text-gray-800 group-hover:text-[#1a3c2e] transition-colors leading-snug">{{ $faq['q'] }}</span>
                                    <svg class="faq-chevron w-4 h-4 mt-0.5 text-gray-400 group-hover:text-[#1a3c2e] transition-all shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                                <div class="faq-answer overflow-hidden transition-all duration-300 ease-out" style="max-height: 0;">
                                    <p class="mt-3 text-sm text-gray-500 leading-relaxed">{!! $faq['a'] !!}</p>
                                </div>
                            </button>
                        </div>
                    @endforeach
                </div>

                {{-- Fallback --}}
                <div id="faq-fallback" class="hidden flex flex-col items-center py-8 px-6 text-center">
                    <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="text-sm text-gray-500 mb-1">No matching questions found.</p>
                    <p class="text-xs text-gray-400 leading-relaxed">
                        Please contact the administrator:<br>
                        <a href="mailto:angelfaithibasco@gmail.com" class="text-[#1a3c2e] font-medium hover:underline">angelfaithibasco@gmail.com</a>
                    </p>
                </div>
            </div>

            {{-- Footer --}}
            <div class="p-3 bg-gray-50 text-center">
                <p class="text-xs text-gray-400">
                    Need more help?
                    <a href="mailto:angelfaithibasco@gmail.com" class="text-[#1a3c2e] font-medium hover:underline">angelfaithibasco@gmail.com</a>
                </p>
            </div>
        </div>
    </div>

    {{-- Bubble Button --}}
    <button id="faq-chat-bubble" onclick="toggleFaqChat()"
        class="w-14 h-14 rounded-full bg-[#1a3c2e] shadow-lg hover:shadow-xl flex items-center justify-center text-white transition-all duration-300 hover:scale-105 active:scale-95 relative cursor-pointer">
        <svg id="faq-bubble-icon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        <svg id="faq-bubble-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        <span class="faq-dot absolute -top-0.5 -right-0.5 w-4 h-4 bg-[#f4d03f] rounded-full border-[3px] border-white"></span>
    </button>
</div>

<script>
(function () {
    'use strict';

    let faqOpen = false;
    const panel = document.getElementById('faq-chat-panel');
    const chatIcon = document.getElementById('faq-bubble-icon');
    const closeIcon = document.getElementById('faq-bubble-close');
    const dot = document.querySelector('.faq-dot');
    const searchInput = document.getElementById('faq-search');
    const thinking = document.getElementById('faq-thinking');
    const fallback = document.getElementById('faq-fallback');
    const itemsContainer = document.getElementById('faq-items');

    window.toggleFaqChat = function () {
        faqOpen = !faqOpen;

        if (faqOpen) {
            panel.classList.remove('opacity-0', 'invisible', 'translate-y-4', 'scale-95');
            chatIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
            if (dot) dot.classList.add('hidden');
            setTimeout(function () {
                if (searchInput) searchInput.focus();
            }, 300);
        } else {
            panel.classList.add('opacity-0', 'invisible', 'translate-y-4', 'scale-95');
            chatIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
        }
    };

    window.toggleFaqAnswer = function (btn) {
        var answer = btn.querySelector('.faq-answer');
        var chevron = btn.querySelector('.faq-chevron');
        if (!answer) return;

        var isOpen = answer.style.maxHeight !== '0px' && answer.style.maxHeight !== '';

        document.querySelectorAll('.faq-answer').forEach(function (el) {
            el.style.maxHeight = '0';
        });
        document.querySelectorAll('.faq-chevron').forEach(function (el) {
            el.classList.remove('rotate-180');
        });

        if (!isOpen) {
            answer.style.maxHeight = answer.scrollHeight + 'px';
            if (chevron) chevron.classList.add('rotate-180');
        }
    };

    function levenshtein(a, b) {
        var m = a.length, n = b.length;
        var matrix = [];
        for (var i = 0; i <= m; i++) matrix[i] = [i];
        for (var j = 0; j <= n; j++) matrix[0][j] = j;
        for (var i = 1; i <= m; i++) {
            for (var j = 1; j <= n; j++) {
                var cost = a[i - 1] === b[j - 1] ? 0 : 1;
                matrix[i][j] = Math.min(
                    matrix[i - 1][j] + 1,
                    matrix[i][j - 1] + 1,
                    matrix[i - 1][j - 1] + cost
                );
            }
        }
        return matrix[m][n];
    }

    function fuzzyScore(queryTokens, text) {
        if (queryTokens.length === 0) return -1;
        var totalScore = 0;

        for (var t = 0; t < queryTokens.length; t++) {
            var token = queryTokens[t];
            var bestScore = 0;

            var words = text.split(/\s+/);
            for (var w = 0; w < words.length; w++) {
                var word = words[w];
                if (word.length < 2) continue;

                if (word === token) {
                    bestScore = Math.max(bestScore, 1);
                    continue;
                }

                var dist = levenshtein(token, word);
                if (dist === 0) bestScore = Math.max(bestScore, 1);
                else if (dist === 1) bestScore = Math.max(bestScore, 0.8);
                else if (dist === 2) bestScore = Math.max(bestScore, 0.5);
                else if (dist === 3) bestScore = Math.max(bestScore, 0.25);
            }

            totalScore += bestScore;
        }

        return totalScore / queryTokens.length;
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            var query = this.value.toLowerCase().trim();

            document.querySelectorAll('.faq-answer').forEach(function (el) {
                el.style.maxHeight = '0';
            });
            document.querySelectorAll('.faq-chevron').forEach(function (el) {
                el.classList.remove('rotate-180');
            });

            if (itemsContainer) itemsContainer.classList.add('hidden');
            if (thinking) thinking.classList.remove('hidden');

            clearTimeout(this._timer);
            this._timer = setTimeout(function () {
                var items = document.querySelectorAll('.faq-item');
                var enableFuzzy = query.length > 0;
                var queryTokens = enableFuzzy ? query.split(/\s+/).filter(function (t) {
                    return t.length > 0 && ['a', 'an', 'the', 'to', 'for', 'in', 'on', 'at', 'is', 'of', 'and', 'or', 'do', 'does', 'can', 'will', 'how', 'what', 'why', 'when', 'where', 'i', 'my', 'me', 'be', 'by', 'with', 'it', 'its', 'if', 'no', 'not', 'so', 'up', 'as'].indexOf(t) === -1;
                }) : [];

                var scored = [];
                items.forEach(function (item) {
                    if (!enableFuzzy) {
                        item.classList.remove('hidden');
                        scored.push({ item: item, score: 0 });
                        return;
                    }
                    var text = item.textContent.toLowerCase();
                    var score = fuzzyScore(queryTokens, text);
                    item.classList.add('hidden');
                    if (score > 0.25 || queryTokens.length === 0) {
                        scored.push({ item: item, score: score });
                    }
                });

                if (enableFuzzy) {
                    scored.sort(function (a, b) { return b.score - a.score; });
                }

                scored.forEach(function (entry) {
                    entry.item.classList.remove('hidden');
                });

                var count = scored.length;

                if (thinking) thinking.classList.add('hidden');
                if (itemsContainer) itemsContainer.classList.remove('hidden');
                if (fallback) fallback.classList.toggle('hidden', count > 0);
            }, 350);
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && faqOpen) window.toggleFaqChat();
    });

    document.addEventListener('click', function (e) {
        var widget = document.getElementById('faq-chat-widget');
        if (faqOpen && widget && !widget.contains(e.target)) {
            window.toggleFaqChat();
        }
    });
})();
</script>
