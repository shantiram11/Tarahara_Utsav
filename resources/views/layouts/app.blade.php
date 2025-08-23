<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Tarahara Utsav') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] antialiased">
    @includeIf('frontend.partials._header')

    @yield('content')

    @includeIf('frontend.partials._footer')
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
