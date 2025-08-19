@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-8">
    <div class="max-w-md w-full bg-white rounded-2xl shadow p-8 text-center">
        <h1 class="text-2xl font-bold mb-2">Verify your email</h1>
        <p class="text-gray-600 mb-6">We have sent a verification link to your email address.</p>
        @if (session('status') == 'verification-link-sent')
            <div class="text-green-600 text-sm mb-4">A new verification link has been sent to your email address.</div>
        @endif
        <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
            @csrf
            <button class="px-4 py-2 rounded-lg bg-red-600 text-white">Resend Verification Email</button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-gray-600 underline">Log out</button>
        </form>
    </div>
    </div>
@endsection
