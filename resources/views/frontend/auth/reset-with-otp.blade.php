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
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-2">Set New Password</h1>
            <p class="text-sm sm:text-base text-gray-600">Your email is locked for security.</p>
        </div>

        <div class="bg-white/90 backdrop-blur-xl rounded-2xl sm:rounded-3xl shadow-2xl shadow-red-500/10 p-4 sm:p-6 lg:p-8 border border-red-200/50 shadow-lg">
            @if (session('status'))
                <div class="mb-4 text-xs sm:text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg p-2 sm:p-3">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.otp.reset') }}" class="space-y-4 sm:space-y-6">
                @csrf

                <div class="space-y-1 sm:space-y-2">
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" value="{{ $email }}" readonly class="w-full pr-3 sm:pr-4 py-3 sm:py-4 bg-gray-100 border border-gray-200 rounded-xl sm:rounded-2xl text-gray-500">
                </div>

                <div class="space-y-1 sm:space-y-2">
                    <label for="password" class="block text-xs sm:text-sm font-semibold text-gray-700">New Password</label>
                    <input id="password" name="password" type="password" required class="w-full pr-3 sm:pr-4 py-3 sm:py-4 bg-gray-50/80 border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-200' }} rounded-xl sm:rounded-2xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300 placeholder-gray-400 text-sm sm:text-base" placeholder="********">
                    @error('password')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1 sm:space-y-2">
                    <label for="password_confirmation" class="block text-xs sm:text-sm font-semibold text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full pr-3 sm:pr-4 py-3 sm:py-4 bg-gray-50/80 border border-gray-200 rounded-xl sm:rounded-2xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300 placeholder-gray-400 text-sm sm:text-base" placeholder="********">
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-500 text-white font-semibold py-3 sm:py-4 px-6 rounded-xl sm:rounded-2xl shadow-lg shadow-red-500/25 hover:shadow-xl hover:shadow-red-500/35 transition-all duration-300 hover:-translate-y-0.5 hover:from-red-700 hover:to-red-600 transform text-sm sm:text-base touch-manipulation">
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
