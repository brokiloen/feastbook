<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Feastbook') }} - @yield('title', 'Средновековни рецепти')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .header-banner {
            background: url('{{ asset("images/header.webp") }}');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="parchment-bg font-body text-wood antialiased min-h-screen">
    <!-- Navigation -->
    <nav class="bg-parchment/95 backdrop-blur-sm border-b border-parchment-dark/30 shadow-sm">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/image.png') }}" alt="Feastbook" class="h-12 w-12">
                <span class="font-logo text-2xl font-bold text-burgundy">Feastbook</span>
            </a>
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="font-medieval-bg text-xl text-wood hover:text-burgundy transition-colors">Рецепти</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="font-medieval-bg text-xl text-wood hover:text-burgundy transition-colors">Админ</a>
                @else
                    <a href="{{ route('login') }}" class="font-medieval-bg text-xl text-wood hover:text-burgundy transition-colors">Вход</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Header Banner -->
    <header class="header-banner h-80 md:h-96"></header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-wood text-parchment py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <div class="font-logo text-gold text-xl mb-2">Feastbook</div>
            <p class="text-parchment-dark text-lg font-medieval">&copy; {{ date('Y') }} Feastbook. Всички рецепти, събрани от цялото царство.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

