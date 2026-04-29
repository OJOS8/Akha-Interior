@php
    $siteName = config('app.name', 'Akha Interior');
@endphp
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Akha Interior — Furniture Kayu Solid untuk Rumah Hangat')</title>
    <meta name="description" content="@yield('meta_description', 'Akha Interior menghadirkan furniture kayu solid dengan desain minimalis modern untuk ruang makan, ruang tamu, dan penyimpanan rumah Anda.')">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700|inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        serif: ['"Playfair Display"', 'ui-serif', 'Georgia', 'serif'],
                    },
                    colors: {
                        akha: {
                            50:  '#faf6f0',
                            100: '#f1e9dc',
                            200: '#e2d2b6',
                            300: '#d0b58a',
                            400: '#bd9963',
                            500: '#a98049',
                            600: '#8b6738',
                            700: '#6f5230',
                            800: '#54402a',
                            900: '#2f2a26',
                        },
                        sage: {
                            500: '#6b7e6f',
                            700: '#4d5e51',
                        },
                    },
                },
            },
        };
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #faf6f0; color: #2f2a26; }
        .font-serif-display { font-family: 'Playfair Display', serif; letter-spacing: -0.01em; }
        .hero-grain {
            background-image: linear-gradient(rgba(47,42,38,.55), rgba(47,42,38,.55)),
                url('https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?auto=format&fit=crop&w=1800&q=80');
            background-size: cover;
            background-position: center;
        }
        .product-img-fallback {
            background: linear-gradient(135deg, #f1e9dc 0%, #d0b58a 100%);
        }
    </style>

    @stack('head')
</head>
<body class="min-h-screen flex flex-col antialiased">
    @include('front.partials.navbar')

    <main class="flex-1">
        @if (session('status'))
            <div class="bg-sage-500/10 border-l-4 border-sage-500 text-sage-700 px-6 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

    @include('front.partials.footer')

    @stack('scripts')
</body>
</html>
