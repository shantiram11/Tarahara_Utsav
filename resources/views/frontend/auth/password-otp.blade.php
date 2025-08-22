@extends('layouts.auth')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-orange-50 to-red-50 flex items-center justify-center p-4 relative overflow-hidden">
    <div class="absolute top-4 left-4 sm:top-8 sm:left-8 z-20">
        <a href="{{ route('home') }}" class="group flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-white/90 backdrop-blur-sm rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 hover:scale-110">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600 group-hover:text-red-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
    </div>

    <div class="absolute top-4 right-4 sm:top-8 sm:right-8 z-20">
        <div class="py-0">
            <img src="{{ asset('assets/Logo.png') }}" alt="Tarahara Utsav" class="h-10 sm:h-12 lg:h-16 w-auto">
        </div>
    </div>

    <div class="relative z-10 w-full max-w-sm sm:max-w-md px-4 sm:px-0">
        <div class="text-center mb-6 sm:mb-8 mt-16 sm:mt-0">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-2">Enter OTP</h1>
            <p class="text-sm sm:text-base text-gray-600">Enter the OTP sent to your email to continue.</p>
        </div>

        <div class="bg-white/90 backdrop-blur-xl rounded-2xl sm:rounded-3xl shadow-2xl shadow-red-500/10 p-4 sm:p-6 lg:p-8 border border-red-200/50 shadow-lg">
            @if (session('status'))
                <div class="mb-4 text-xs sm:text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg p-2 sm:p-3">
                    {{ session('status') }}
                </div>
            @endif

            <form id="otp-form" method="POST" action="{{ route('password.otp.verify') }}" class="space-y-4 sm:space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700">OTP</label>
                    <div class="flex items-center justify-center gap-2 sm:gap-3">
                        <input type="tel" inputmode="numeric" maxlength="1" class="otp-input h-12 sm:h-14 w-10 sm:w-12 text-center text-xl sm:text-2xl rounded-xl border {{ $errors->has('otp') ? 'border-red-500' : 'border-gray-200' }} bg-white shadow-sm focus:ring-2 focus:ring-red-500 focus:border-transparent" aria-label="Digit 1">
                        <input type="tel" inputmode="numeric" maxlength="1" class="otp-input h-12 sm:h-14 w-10 sm:w-12 text-center text-xl sm:text-2xl rounded-xl border {{ $errors->has('otp') ? 'border-red-500' : 'border-gray-200' }} bg-white shadow-sm focus:ring-2 focus:ring-red-500 focus:border-transparent" aria-label="Digit 2">
                        <input type="tel" inputmode="numeric" maxlength="1" class="otp-input h-12 sm:h-14 w-10 sm:w-12 text-center text-xl sm:text-2xl rounded-xl border {{ $errors->has('otp') ? 'border-red-500' : 'border-gray-200' }} bg-white shadow-sm focus:ring-2 focus:ring-red-500 focus:border-transparent" aria-label="Digit 3">
                        <input type="tel" inputmode="numeric" maxlength="1" class="otp-input h-12 sm:h-14 w-10 sm:w-12 text-center text-xl sm:text-2xl rounded-xl border {{ $errors->has('otp') ? 'border-red-500' : 'border-gray-200' }} bg-white shadow-sm focus:ring-2 focus:ring-red-500 focus:border-transparent" aria-label="Digit 4">
                        <input type="tel" inputmode="numeric" maxlength="1" class="otp-input h-12 sm:h-14 w-10 sm:w-12 text-center text-xl sm:text-2xl rounded-xl border {{ $errors->has('otp') ? 'border-red-500' : 'border-gray-200' }} bg-white shadow-sm focus:ring-2 focus:ring-red-500 focus:border-transparent" aria-label="Digit 5">
                        <input type="tel" inputmode="numeric" maxlength="1" class="otp-input h-12 sm:h-14 w-10 sm:w-12 text-center text-xl sm:text-2xl rounded-xl border {{ $errors->has('otp') ? 'border-red-500' : 'border-gray-200' }} bg-white shadow-sm focus:ring-2 focus:ring-red-500 focus:border-transparent" aria-label="Digit 6">
                    </div>
                    <input type="hidden" id="otp" name="otp" value="">
                    @error('otp')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-[10px] sm:text-xs text-gray-400">Tip: Paste the entire code — we’ll fill the boxes.</p>
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-red-600 to-red-500 text-white font-semibold py-3 sm:py-4 px-6 rounded-xl sm:rounded-2xl shadow-lg shadow-red-500/25 hover:shadow-xl hover:shadow-red-500/35 transition-all duration-300 hover:-translate-y-0.5 hover:from-red-700 hover:to-red-600 transform text-sm sm:text-base touch-manipulation">
                    Continue
                </button>


                @if(!empty($email))
                <div class="text-center space-y-2">
                    <form id="resend-form" method="POST" action="{{ route('password.otp.send') }}" class="inline">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <button id="resend-btn" type="submit" disabled class="text-xs sm:text-sm text-red-600 disabled:text-gray-400 font-medium transition-colors">Resend OTP in <span id="resend-timer">30</span>s</button>
                    </form>
                </div>
                @endif
            </form>
        </div>

        <div class="text-center mt-4 sm:mt-6">
            <p class="text-xs text-gray-500 leading-relaxed">The OTP expires in 10 minutes.</p>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputs = Array.from(document.querySelectorAll('.otp-input'));
    const hidden = document.getElementById('otp');
    const form = document.getElementById('otp-form');
    const submitBtn = document.getElementById('otp-submit');
    const resendBtn = document.getElementById('resend-btn');
    const resendTimer = document.getElementById('resend-timer');

    function setHidden() {
        hidden.value = inputs.map(i => i.value.replace(/\D/g, '')).join('');
    }

    if (inputs.length) { inputs[0].focus(); }

    inputs.forEach((input, idx) => {
        input.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/\D/g, '').slice(0,1);
            if (e.target.value && idx < inputs.length - 1) {
                inputs[idx + 1].focus();
                inputs[idx + 1].select();
            }
            setHidden();
            submitBtn.disabled = hidden.value.length !== inputs.length;
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value && idx > 0) {
                inputs[idx - 1].focus();
                inputs[idx - 1].select();
            }
        });

        input.addEventListener('paste', (e) => {
            const pasted = (e.clipboardData || window.clipboardData).getData('text');
            const digits = pasted.replace(/\D/g, '').slice(0, inputs.length).split('');
            if (digits.length > 1) {
                e.preventDefault();
                inputs.forEach((i, j) => { i.value = digits[j] || ''; });
                const next = inputs[Math.min(digits.length, inputs.length - 1)];
                next.focus();
                next.select();
                setHidden();
            }
        });
    });

    form.addEventListener('submit', (e) => {
        setHidden();
        if (hidden.value.length !== inputs.length) {
            e.preventDefault();
            inputs[0].focus();
        }
    });

    // Resend countdown
    if (resendBtn && resendTimer) {
        let remaining = 30;
        const tick = () => {
            remaining -= 1;
            if (remaining <= 0) {
                resendBtn.disabled = false;
                resendBtn.textContent = 'Resend OTP';
                return;
            }
            resendTimer.textContent = remaining.toString();
            setTimeout(tick, 1000);
        };
        setTimeout(tick, 1000);
    }
});
</script>
@endsection
