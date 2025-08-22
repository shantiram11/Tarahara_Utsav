@extends('layouts.auth')

@section('content')
<style>
@keyframes glow {
    0% { box-shadow: 0 0 20px rgba(239, 68, 68, 0.3), 0 0 40px rgba(239, 68, 68, 0.2), inset 0 0 0 1px rgba(239, 68, 68, 0.2); }
    100% { box-shadow: 0 0 30px rgba(239, 68, 68, 0.5), 0 0 60px rgba(239, 68, 68, 0.3), inset 0 0 0 1px rgba(239, 68, 68, 0.4); }
}
</style>
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-orange-50 to-red-50 flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Background Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-10 w-32 h-32 bg-red-200/30 rounded-full blur-xl"></div>
        <div class="absolute top-40 right-20 w-24 h-24 bg-yellow-200/40 rounded-full blur-lg"></div>
        <div class="absolute bottom-32 left-1/4 w-40 h-40 bg-orange-200/20 rounded-full blur-2xl"></div>
        <div class="absolute bottom-20 right-10 w-28 h-28 bg-red-300/25 rounded-full blur-xl"></div>
        <div class="absolute top-32 left-1/3 w-16 h-16 bg-gradient-to-br from-red-400 to-red-500 rotate-45 opacity-10 rounded-lg"></div>
        <div class="absolute bottom-40 right-1/3 w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-400 rotate-12 opacity-15 rounded-full"></div>
        <div class="absolute top-1/4 right-1/4 w-8 h-8 bg-red-400/20 rounded-full"></div>
        <div class="absolute top-1/3 right-1/5 w-4 h-4 bg-yellow-400/30 rounded-full"></div>
        <div class="absolute bottom-1/3 left-1/5 w-6 h-6 bg-orange-400/25 rounded-full"></div>
    </div>

    <!-- Home button -->
    <div class="absolute top-4 left-4 sm:top-8 sm:left-8 z-20">
        <a href="{{ route('home') }}" class="group flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 bg-white/90 backdrop-blur-sm rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 hover:scale-110">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600 group-hover:text-red-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
    </div>

    <!-- Logo -->
    <div class="absolute top-4 right-4 sm:top-8 sm:right-8 z-20">
        <div class="py-0">
            <img src="{{ asset('assets/Logo.png') }}" alt="Tarahara Utsav" class="h-10 sm:h-12 lg:h-16 w-auto">
        </div>
    </div>

    <!-- Card -->
    <div class="relative z-10 w-full max-w-sm sm:max-w-md px-4 sm:px-0">
        <div class="text-center mb-6 sm:mb-8 mt-16 sm:mt-0">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-2">Forgot your password?</h1>
            <p class="text-sm sm:text-base text-gray-600">Enter your email and we'll send you an OTP code.</p>
        </div>

        <div class="bg-white/90 backdrop-blur-xl rounded-2xl sm:rounded-3xl shadow-2xl shadow-red-500/10 p-4 sm:p-6 lg:p-8 border border-red-200/50 shadow-lg" style="animation: glow 2s ease-in-out infinite alternate; box-shadow: 0 0 20px rgba(239, 68, 68, 0.3), 0 0 40px rgba(239, 68, 68, 0.2), inset 0 0 0 1px rgba(239, 68, 68, 0.2);">
            @if (session('status'))
                <div class="mb-4 text-xs sm:text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg p-2 sm:p-3">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.otp.send') }}" class="space-y-4 sm:space-y-6">
                @csrf

                <div class="space-y-1 sm:space-y-2">
                    <label for="email" class="block text-xs sm:text-sm font-semibold text-gray-700">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input id="email" name="email" type="email" required autofocus
                               value="{{ old('email') }}"
                               class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-3 sm:py-4 bg-gray-50/80 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }} rounded-xl sm:rounded-2xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300 placeholder-gray-400 text-sm sm:text-base"
                               placeholder="Enter your email">
                    </div>
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-gradient-to-r from-red-600 to-red-500 text-white font-semibold py-3 sm:py-4 px-6 rounded-xl sm:rounded-2xl shadow-lg shadow-red-500/25 hover:shadow-xl hover:shadow-red-500/35 transition-all duration-300 hover:-translate-y-0.5 hover:from-red-700 hover:to-red-600 transform text-sm sm:text-base touch-manipulation">
                    Send OTP
                </button>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-xs sm:text-sm text-red-600 hover:text-red-500 font-medium transition-colors">Back to sign in</a>
                </div>
            </form>
        </div>

        <div class="text-center mt-4 sm:mt-6">
            <p class="text-xs text-gray-500 leading-relaxed">Use the OTP sent to your email to reset your password.</p>
        </div>
    </div>
</div>
@endsection
