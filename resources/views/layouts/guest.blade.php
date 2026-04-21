<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coop Shop</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-900">
    @php
        $homeUrl = Route::has('coop-shop.home') ? route('coop-shop.home') : url('/');
    @endphp

    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-8">
        <a href="{{ $homeUrl }}" class="mb-6 block">
            <x-application-logo />
        </a>

        <div class="w-full sm:max-w-md overflow-hidden rounded-2xl bg-white px-6 py-6 shadow-xl sm:px-8">
            {{ $slot }}
        </div>
    </div>
</body>
</html>