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
                        'medieval-bg': ['Akathistos', 'Cinzel', 'serif'],
                        'body': ['Crimson Text', 'serif'],
                    },
                }
            }
        }
    </script>
    <style>
        @font-face {
            font-family: 'Akathistos';
            src: url('{{ asset("fonts/AkathUcs8.ttf") }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
        body {
            background-color: #f4e4bc;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23d4c4a0' fill-opacity='0.3'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .header-banner {
            background: url('{{ asset("images/header.webp") }}');
            background-size: cover;
            background-position: center;
        }
        .recipe-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .recipe-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(61, 35, 20, 0.3);
        }
        /* Quill editor content styles */
        .recipe-instructions {
            font-family: 'Crimson Text', serif;
            font-size: 1.125rem;
            line-height: 1.75rem;
            color: rgba(61, 35, 20, 0.8);
        }
        .recipe-instructions p {
            margin-bottom: 1rem;
        }
        .recipe-instructions h1, .recipe-instructions h2, .recipe-instructions h3 {
            font-family: 'Cinzel', serif;
            color: #3d2314;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        .recipe-instructions h1 { font-size: 2rem; }
        .recipe-instructions h2 { font-size: 1.5rem; }
        .recipe-instructions h3 { font-size: 1.25rem; }
        .recipe-instructions ul, .recipe-instructions ol {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
            list-style-position: outside;
        }
        .recipe-instructions ul {
            list-style-type: disc;
        }
        .recipe-instructions ol {
            list-style-type: decimal;
        }
        .recipe-instructions li {
            margin-bottom: 0.5rem;
            color: rgba(61, 35, 20, 0.8);
        }
        .recipe-instructions ol li::marker,
        .recipe-instructions ul li::marker {
            color: #3d2314;
            font-weight: 600;
        }
        .recipe-instructions a {
            color: #722f37;
            text-decoration: underline;
        }
        .recipe-instructions a:hover {
            color: #5a252c;
        }
        .recipe-instructions blockquote {
            border-left: 4px solid #c9a227;
            padding-left: 1rem;
            margin-left: 0;
            margin-bottom: 1rem;
            font-style: italic;
            color: rgba(61, 35, 20, 0.7);
        }
        .recipe-instructions strong {
            font-weight: 600;
            color: #3d2314;
        }
        .recipe-instructions img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1rem 0;
        }
    </style>
</head>
<body class="font-body text-wood antialiased min-h-screen">
    <!-- Navigation -->
    <nav class="bg-parchment/95 backdrop-blur-sm border-b border-parchment-dark/30 shadow-sm">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/image.png') }}" alt="Feastbook" class="h-12 w-12">
                <span class="font-medieval text-2xl font-bold text-burgundy">Feastbook</span>
            </a>
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="font-medieval-bg text-lg text-wood hover:text-burgundy transition-colors">Рецепти</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="font-medieval-bg text-lg text-wood hover:text-burgundy transition-colors">Админ</a>
                @else
                    <a href="{{ route('login') }}" class="font-medieval-bg text-lg text-wood hover:text-burgundy transition-colors">Вход</a>
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
            <div class="font-medieval text-gold text-xl mb-2">Feastbook</div>
            <p class="text-parchment-dark text-base font-medieval-bg">&copy; {{ date('Y') }} Feastbook. Всички рецепти, събрани от цялото царство.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

