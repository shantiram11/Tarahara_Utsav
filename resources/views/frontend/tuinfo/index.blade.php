@extends('layouts.app')
@section('content')
<div class="w-full pt-16 pb-12">
    <!-- Top horizontal advertisement banner -->
    <div class="mb-8 border-0 overflow-hidden bg-white">
        <img src="{{ asset('assets/image (1).png') }}" alt="Advertisement" class="w-full h-auto object-cover">
    </div>

    <style>
      @import url('https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&display=swap');
      .tu-title{font-family:'Oswald',Arial,Helvetica,sans-serif;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:#3b4652;font-size:1.125rem;}
      .tu-subtitle{font-family:'Oswald',Arial,Helvetica,sans-serif;font-weight:400;letter-spacing:.2em;text-transform:uppercase;color:#8b949e;font-size:.65rem;}
    </style>



        <!-- Clean partners strip with flex -->
        <div class="mb-12 px-16">
            <div class="flex flex-col lg:flex-row justify-between items-start">
                <!-- Partners section -->
                <div class="flex flex-wrap gap-x-16 gap-y-6 flex-1">
                    <!-- Patrons -->
                    <div>
                        <div class="text-[11px] text-gray-600 mb-2">PATRONS</div>
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/Logo.png') }}" class="h-5" alt="patron">
                            <img src="{{ asset('assets/Logo.png') }}" class="h-5" alt="patron">
                            <img src="{{ asset('assets/Logo.png') }}" class="h-5" alt="patron">
                        </div>
                    </div>

                <!-- Event By -->
                <div>
                    <div class="text-[11px] text-gray-600 mb-2">AN EVENT BY</div>
                    <img src="{{ asset('assets/Logo.png') }}" class="h-5" alt="event by">
                </div>

                <!-- Presenter -->
                <div>
                    <div class="text-[11px] text-gray-600 mb-2">PRESENTER</div>
                    <img src="{{ asset('assets/Logo.png') }}" class="h-5" alt="presenter">
                </div>

                <!-- Organizer -->
                <div>
                    <div class="text-[11px] text-gray-600 mb-2">ORGANIZER</div>
                    <img src="{{ asset('assets/Logo.png') }}" class="h-5" alt="organizer">
                </div>

                <!-- Digital Worldwide -->
                <div>
                    <div class="text-[11px] text-gray-600 mb-2">DIGITAL WORLDWIDE</div>
                    <img src="{{ asset('assets/Logo.png') }}" class="h-5" alt="digital">
                </div>

                <!-- Website -->
                <div>
                    <div class="text-[11px] text-gray-600 mb-2">WEBSITE</div>
                    <img src="{{ asset('assets/Logo.png') }}" class="h-5" alt="website">
                </div>

                <!-- Page -->
                <div>
                    <div class="text-[11px] text-gray-600 mb-2">PAGE</div>
                    <img src="{{ asset('assets/Logo.png') }}" class="h-5" alt="page">
                </div>

                <!-- News -->
                <div>
                    <div class="text-[11px] text-gray-600 mb-2">NEWS</div>
                    <img src="{{ asset('assets/Logo.png') }}" class="h-5" alt="news">
                </div>
            </div>
        </div>
    </div>

    <!-- Title and buttons -->
    <div class="px-16 mb-8">
        <div class="flex items-center justify-between">
            <div class="flex flex-col leading-tight">
                <h1 class="tu-title">TARAHARA UTSAV 2025</h1>
                <div class="tu-subtitle">HONORS, CELEBRATIONS & TOGETHERNESS</div>
            </div>
            <div class="flex items-center gap-3">
                <a href="#" class="px-4 py-1.5 bg-gray-200 text-gray-700 text-xs">TU 2024</a>
                <a href="{{ route('home') }}" class="px-4 py-1.5 bg-gray-200 text-gray-700 text-xs">HOME</a>
            </div>
        </div>
    </div>

    <!-- Photo grid matching reference design -->
    <div class="px-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($items as $item)
        <a href="{{ route('tuinfo.show', $item['slug']) }}" class="block group">
            <div class="flex flex-col items-center">
                <!-- Square container with border (reduced size) -->
                <div class="w-full max-w-[300px] aspect-square border border-gray-300 group-hover:border-gray-400 transition-colors">
                    <div class="w-full h-full flex items-center justify-center">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="max-w-full max-h-full object-contain p-2">
                    </div>
                </div>
                <!-- Caption exactly like reference -->
                <div class="mt-2 text-center">
                    <div class="flex items-center justify-center gap-1">
                        <span class="text-[11px] text-gray-500">□</span>
                        <span class="text-[11px] text-gray-500">TU INFO</span>
                    </div>
                    <div class="text-[11px] text-gray-500">(Public Picks)</div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
</div>
@endsection
