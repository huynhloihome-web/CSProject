@props([
    'title' => 'Coop Shop'
])

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/coop-shop.css') }}">
</head>
<body>
    <x-shop-header />

    <main class="shop-container">
        {{ $slot }}
    </main>
</body>
</html>