@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-12">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center space-x-2">
            <a href="{{ route('tuinfo.index') }}" class="px-3 py-1.5 rounded-md border text-xs">TU 2025</a>
            <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-md border text-xs">Home</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left content -->
        <div class="lg:col-span-2 space-y-4">
            <div class="border rounded-xl overflow-hidden bg-white">
                <div class="px-4 sm:px-6 py-4 border-b">
                    <div class="text-xs uppercase tracking-wide text-gray-500">{{ $tuInfo['subtitle'] }}</div>
                    <div class="font-bold">{{ $tuInfo['title'] }}</div>
                </div>
                <div class="p-4 sm:p-6">
                    <div class="mb-4 border rounded-lg">
                        <div class="w-full bg-gray-50 text-center py-6 font-extrabold tracking-widest">ADVERTISEMENT</div>
                    </div>

                    <img src="{{ $tuInfo['image'] }}" alt="{{ $tuInfo['title'] }}" class="w-full h-auto rounded-lg object-cover">

                    <div class="mt-4 mb-4 border rounded-lg">
                        <div class="w-full bg-gray-50 text-center py-6 font-extrabold tracking-widest">ADVERTISEMENT</div>
                    </div>

                    <div class="prose prose-sm max-w-none leading-relaxed">
                        <p>The reward is intended for women who demonstrate diligence, perseverance, and positive impact in their personal or professional lives. Instead of focusing on a single, major achievement, the "Journey Rewards" can be given to women who are:</p>
                        <p>The reward is intended for women who demonstrate diligence, perseverance, and positive impact in their personal or professional lives. Instead of focusing on a single, major achievement, the "Journey Rewards" can be given to women who are:</p>
                        <div class="mt-4 mb-4 border rounded-lg">
                            <div class="w-full bg-gray-50 text-center py-6 font-extrabold tracking-widest">ADVERTISEMENT</div>
                        </div>
                        <p>The reward is intended for women who demonstrate diligence, perseverance, and positive impact in their personal or professional lives. Instead of focusing on a single, major achievement, the "Journey Rewards" can be given to women who are:given to women who are:</p>
                        <div class="text-[11px] mt-3">
                            <div>Story by– TU Team</div>
                            <div>Photo– Amit Chaudhary</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right sidebar -->
        <div class="space-y-4">
            <div class="border rounded-xl overflow-hidden bg-white">
                <div class="px-4 py-3 border-b font-semibold">TU 2025 Honorees</div>
                <div class="divide-y">
                    @foreach($honorees as $person)
                    <div class="flex items-center space-x-3 p-3">
                        <img src="{{ $person['image'] }}" class="h-12 w-12 rounded object-cover" alt="{{ $person['name'] }}">
                        <div class="text-xs leading-tight">
                            <div class="font-semibold">{{ $person['name'] }}</div>
                            <div class="text-[11px] text-gray-500">({{ $person['tag'] }})</div>
                            <div class="text-[11px] text-gray-500">aa;df;ajfa;fdja af;af;df;adf;af; af;af;ja;ajfk (More)</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="border rounded-xl overflow-hidden bg-white">
                <div class="w-full bg-gray-50 text-center py-16 font-extrabold tracking-widest">ADVERTISEMENT</div>
            </div>
        </div>
    </div>
</div>
@endsection
