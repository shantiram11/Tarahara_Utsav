@extends('layouts.app')

@section('title', 'Reset Password - Tarahara Utsab 2024')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background: linear-gradient(135deg, #dc2626 0%, #ea580c 50%, #f59e0b 100%);">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl p-8 border border-white/20">
            <div class="text-center">
                <img src="{{ asset('assets/logo.png') }}" alt="Tarahara Utsab 2024" class="mx-auto h-16 w-auto mb-4">
                <h2 class="text-3xl font-extrabold text-white mb-2">
                    Reset Password
                </h2>
                <p class="text-white/80 text-sm">
                    Enter your new password below.
                </p>
            </div>

            <form class="mt-8 space-y-6" action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <input id="email" name="email" type="email" required readonly
                           class="relative block w-full px-3 py-3 border border-white/30 placeholder-white/60 text-white rounded-xl bg-white/5 backdrop-blur-sm focus:outline-none sm:text-sm"
                           placeholder="Email address"
                           value="{{ $email ?? old('email') }}">
                    @error('email')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="sr-only">New Password</label>
                    <input id="password" name="password" type="password" required
                           class="relative block w-full px-3 py-3 border border-white/30 placeholder-white/60 text-white rounded-xl bg-white/10 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent focus:z-10 sm:text-sm transition-all duration-300"
                           placeholder="New Password">
                    @error('password')
                        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="sr-only">Confirm New Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="relative block w-full px-3 py-3 border border-white/30 placeholder-white/60 text-white rounded-xl bg-white/10 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent focus:z-10 sm:text-sm transition-all duration-300"
                           placeholder="Confirm New Password">
                </div>

                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-red-700 bg-gradient-to-r from-yellow-400 to-orange-400 hover:from-yellow-500 hover:to-orange-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                        Reset Password
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="font-medium text-yellow-300 hover:text-yellow-200 transition-colors duration-300">
                        ← Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection