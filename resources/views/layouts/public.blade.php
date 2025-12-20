<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Feastbook') }} - @yield('title', 'Medieval Recipes')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        parchment: '#f4e4bc',
                        'parchment-dark': '#e8d4a8',
                        burgundy: '#722f37',
                        'burgundy-dark': '#5a252c',
                        wood: '#3d2314',
                        'wood-light': '#5c3a2d',
                        gold: '#c9a227',
                        'gold-light': '#dbb84d',
                    },
                    fontFamily: {
                        'medieval': ['Cinzel', 'serif'],
                        'body': ['Crimson Text', 'serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #f4e4bc;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23d4c4a0' fill-opacity='0.3'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .header-banner {
            background: 
                linear-gradient(135deg, rgba(61, 35, 20, 0.95) 0%, rgba(114, 47, 55, 0.9) 50%, rgba(61, 35, 20, 0.95) 100%),
                repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(201, 162, 39, 0.05) 10px, rgba(201, 162, 39, 0.05) 20px);
            position: relative;
        }
        .header-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23c9a227' fill-opacity='0.08'%3E%3Cpath d='M40 0L20 20L40 40L20 60L40 80L60 60L40 40L60 20L40 0zM20 0L0 20L20 40L0 60L20 80L40 60L20 40L40 20L20 0z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }
        .recipe-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .recipe-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(61, 35, 20, 0.3);
        }
    </style>
</head>
<body class="font-body text-wood antialiased min-h-screen">
    <!-- Header Banner -->
    <header class="header-banner text-parchment">
        <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.svg') }}" alt="Feastbook" class="h-12 w-12">
                <span class="font-medieval text-2xl font-bold text-gold">Feastbook</span>
            </a>
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="font-medieval hover:text-gold transition-colors">Recipes</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="font-medieval hover:text-gold transition-colors">Admin</a>
                @else
                    <a href="{{ route('login') }}" class="font-medieval hover:text-gold transition-colors">Login</a>
                @endauth
            </div>
        </nav>
        
        <div class="container mx-auto px-4 py-16 text-center">
            <h1 class="font-medieval text-5xl md:text-6xl font-bold text-gold mb-4">@yield('header-title', 'Feastbook')</h1>
            <p class="font-body text-xl text-parchment-dark italic">@yield('header-subtitle', 'A Collection of Medieval Feasts & Recipes')</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-wood text-parchment py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <div class="font-medieval text-gold text-xl mb-2">Feastbook</div>
            <p class="text-parchment-dark text-sm">&copy; {{ date('Y') }} Feastbook. All recipes gathered from across the realm.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

