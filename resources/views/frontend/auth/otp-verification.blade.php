@extends('layouts.auth')

@section('content')
<style>
@keyframes glow {
    0% {
        box-shadow: 0 0 20px rgba(239, 68, 68, 0.3), 0 0 40px rgba(239, 68, 68, 0.2), inset 0 0 0 1px rgba(239, 68, 68, 0.2);
    }
    100% {
        box-shadow: 0 0 30px rgba(239, 68, 68, 0.5), 0 0 60px rgba(239, 68, 68, 0.3), inset 0 0 0 1px rgba(239, 68, 68, 0.4);
    }
}

.otp-input {
    width: 50px;
    height: 50px;
    text-align: center;
    font-size: 1.5rem;
    font-weight: bold;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    background: rgba(249, 250, 251, 0.8);
    transition: all 0.3s ease;
}

.otp-input:focus {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    outline: none;
}

.otp-input.filled {
    border-color: #10b981;
    background: rgba(16, 185, 129, 0.1);
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>

<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-orange-50 to-red-50 flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Background Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Decorative circles -->
        <div class="absolute top-20 left-10 w-32 h-32 bg-red-200/30 rounded-full blur-xl"></div>
        <div class="absolute top-40 right-20 w-24 h-24 bg-yellow-200/40 rounded-full blur-lg"></div>
        <div class="absolute bottom-32 left-1/4 w-40 h-40 bg-orange-200/20 rounded-full blur-2xl"></div>
        <div class="absolute bottom-20 right-10 w-28 h-28 bg-red-300/25 rounded-full blur-xl"></div>
        
        <!-- Geometric shapes -->
        <div class="absolute top-32 left-1/3 w-16 h-16 bg-gradient-to-br from-red-400 to-red-500 rotate-45 opacity-10 rounded-lg"></div>
        <div class="absolute bottom-40 right-1/3 w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-400 rotate-12 opacity-15 rounded-full"></div>
        
        <!-- Festival pattern -->
        <div class="absolute top-1/4 right-1/4 w-8 h-8 bg-red-400/20 rounded-full"></div>
        <div class="absolute top-1/3 right-1/5 w-4 h-4 bg-yellow-400/30 rounded-full"></div>
        <div class="absolute bottom-1/3 left-1/5 w-6 h-6 bg-orange-400/25 rounded-full"></div>
    </div>

    <!-- Home button positioned on the left side -->
    <div class="absolute top-4 left-4 sm:top-8 sm:left-8 z-20">
        <a href="{{ route('home') }}" class="group flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-white/90 backdrop-blur-sm rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 hover:scale-110">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600 group-hover:text-red-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
    </div>

    <!-- Logo positioned on the right side -->
    <div class="absolute top-4 right-4 sm:top-8 sm:right-8 z-20">
        <div class="py-0">
            <img src="{{ asset('assets/logo.png') }}" alt="Tarahara Utsav" class="h-10 sm:h-12 lg:h-16 w-auto">
        </div>
    </div>

    <!-- OTP Verification Container -->
    <div class="relative z-10 w-full max-w-sm sm:max-w-md px-4 sm:px-0">
        <!-- Form Header -->
        <div class="text-center mb-6 sm:mb-8 mt-16 sm:mt-0">
            <div class="mb-4">
                <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-2">Verify Your Email</h1>
            <p class="text-sm sm:text-base text-gray-600">We've sent a 6-digit code to</p>
            <p class="text-sm sm:text-base font-semibold text-red-600">{{ session('email') ?? 'your email' }}</p>
        </div>

        <!-- OTP Form Card -->
        <div class="bg-white/90 backdrop-blur-xl rounded-2xl sm:rounded-3xl shadow-2xl shadow-red-500/10 p-4 sm:p-6 lg:p-8 border border-red-200/50 shadow-lg" style="animation: glow 2s ease-in-out infinite alternate; box-shadow: 0 0 20px rgba(239, 68, 68, 0.3), 0 0 40px rgba(239, 68, 68, 0.2), inset 0 0 0 1px rgba(239, 68, 68, 0.2);">
            <form method="POST" action="{{ route('otp.verify') }}" class="space-y-6">
                @csrf
                
                <!-- OTP Input Fields -->
                <div class="space-y-4">
                    <label class="block text-sm font-semibold text-gray-700 text-center">Enter the 6-digit code</label>
                    <div class="flex justify-center space-x-2 sm:space-x-3">
                        @for ($i = 1; $i <= 6; $i++)
                            <input type="text" 
                                   name="otp[]" 
                                   id="otp-{{ $i }}" 
                                   maxlength="1" 
                                   class="otp-input"
                                   data-index="{{ $i }}"
                                   autocomplete="off"
                                   required>
                        @endfor
                    </div>
                    @error('otp')
                        <p class="text-red-600 text-xs text-center mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Timer and Resend -->
                <div class="text-center space-y-3">
                    <div id="timer" class="text-sm text-gray-600">
                        <span id="countdown">05:00</span> remaining
                    </div>
                    <button type="button" 
                            id="resend-btn" 
                            class="text-sm text-red-600 hover:text-red-500 font-medium transition-colors hidden"
                            onclick="resendOTP()">
                        Resend Code
                    </button>
                </div>

                <!-- Verify Button -->
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-red-600 to-red-500 text-white font-semibold py-3 sm:py-4 px-6 rounded-xl sm:rounded-2xl shadow-lg shadow-red-500/25 hover:shadow-xl hover:shadow-red-500/35 transition-all duration-300 hover:-translate-y-0.5 hover:from-red-700 hover:to-red-600 transform text-sm sm:text-base touch-manipulation">
                    Verify Email
                </button>

                <!-- Back to Login -->
                <div class="text-center">
                    <p class="text-xs sm:text-sm text-gray-600">
                        Didn't receive the code? 
                        <a href="{{ route('login') }}" class="text-red-600 hover:text-red-500 font-semibold transition-colors">
                            Back to login
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Festival Note -->
        <div class="text-center mt-4 sm:mt-6">
            <p class="text-xs text-gray-500 leading-relaxed">
                Join us for Tarahara Utsav 2024<br class="sm:hidden"> • December 15-17 • Central City Park
            </p>
        </div>
    </div>
</div>

<script>
// OTP Input Handling
document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('.otp-input');
    
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', function(e) {
            const value = e.target.value;
            
            // Only allow numbers
            if (!/^\d*$/.test(value)) {
                e.target.value = '';
                return;
            }
            
            // Move to next input if value is entered
            if (value && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
            
            // Update filled state
            if (value) {
                e.target.classList.add('filled');
            } else {
                e.target.classList.remove('filled');
            }
        });
        
        input.addEventListener('keydown', function(e) {
            // Move to previous input on backspace
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
        
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').slice(0, 6);
            
            if (/^\d{6}$/.test(pastedData)) {
                otpInputs.forEach((input, i) => {
                    input.value = pastedData[i] || '';
                    if (pastedData[i]) {
                        input.classList.add('filled');
                    } else {
                        input.classList.remove('filled');
                    }
                });
            }
        });
    });
});

// Timer functionality
let timeLeft = 300; // 5 minutes in seconds
const timerElement = document.getElementById('countdown');
const resendBtn = document.getElementById('resend-btn');
const timerContainer = document.getElementById('timer');

function updateTimer() {
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    
    if (timeLeft <= 0) {
        timerContainer.classList.add('hidden');
        resendBtn.classList.remove('hidden');
    } else {
        timeLeft--;
        setTimeout(updateTimer, 1000);
    }
}

function resendOTP() {
    fetch('{{ route("otp.resend") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            timeLeft = 300;
            timerContainer.classList.remove('hidden');
            resendBtn.classList.add('hidden');
            updateTimer();
            
            // Clear OTP inputs
            document.querySelectorAll('.otp-input').forEach(input => {
                input.value = '';
                input.classList.remove('filled');
            });
            document.getElementById('otp-1').focus();
        }
    });
}

// Start timer
updateTimer();
</script>
@endsection 