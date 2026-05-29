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
    <meta name="description" content="@yield('meta_description', 'Akha Interior menghadirkan furniture kayu solid dengan desain minimalis modern untuk rumah Indonesia.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            display: ['"Instrument Serif"', 'Georgia', 'serif'],
            sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
          },
          colors: {
            ink: {
              0:  '#0B0B0C',
              1:  '#131316',
              2:  '#1C1C20',
              3:  '#2A2A30',
              4:  '#45454F',
              5:  '#6B6B78',
              6:  '#9A9AA6',
              7:  '#C8C8D0',
              8:  '#E6E6EA',
              9:  '#F4F3F0',
              10: '#FAF9F6',
            },
            ember: {
              50:  '#FFF4EC',
              100: '#FFE3CC',
              200: '#FFC394',
              300: '#FF9D55',
              400: '#F57A22',
              500: '#E25C0B',
              600: '#B8470A',
              700: '#8A350B',
              800: '#5C240A',
            },
          },
          maxWidth: {
            site: '1320px',
          },
          borderRadius: {
            pill: '999px',
          },
        },
      },
    };
    </script>

    <style>
      :root {
        --bg:         #F4F3F0;
        --bg-elev:    #FAF9F6;
        --bg-sunken:  #EFEDE7;
        --fg:         #0B0B0C;
        --fg-muted:   #45454F;
        --fg-subtle:  #6B6B78;
        --border:     #E2DFD8;
        --accent:     #E25C0B;
        --accent-fg:  #FAF9F6;
        --shadow-sm:  0 1px 2px rgba(20,14,10,.06), 0 0 0 1px rgba(20,14,10,.04);
        --shadow-md:  0 4px 12px rgba(20,14,10,.06), 0 1px 2px rgba(20,14,10,.04);
        --shadow-lg:  0 12px 32px rgba(20,14,10,.10), 0 2px 4px rgba(20,14,10,.04);
        --font-display: 'Instrument Serif', Georgia, serif;
        --font-sans:    Inter, -apple-system, sans-serif;
      }

      html, body {
        background: var(--bg);
        color: var(--fg);
        font-family: var(--font-sans);
        font-size: 15px;
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
      }

      .font-display { font-family: var(--font-display); }

      .product-img-fallback {
        background: linear-gradient(135deg, #F4F3F0 0%, #C8C8D0 100%);
      }

      .btn-primary {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 12px 24px; border-radius: 999px;
        background: var(--fg); color: var(--bg-elev);
        font-size: 14px; font-weight: 600; font-family: var(--font-sans);
        text-decoration: none; border: none; cursor: pointer;
        transition: opacity .15s;
      }
      .btn-primary:hover { opacity: .85; }

      .btn-ghost {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 12px 24px; border-radius: 999px;
        background: transparent; color: var(--fg);
        font-size: 14px; font-weight: 600; font-family: var(--font-sans);
        text-decoration: none; border: 1px solid var(--border); cursor: pointer;
        transition: background .15s;
      }
      .btn-ghost:hover { background: var(--bg-sunken); }

      .btn-accent {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 12px 24px; border-radius: 999px;
        background: var(--accent); color: var(--accent-fg);
        font-size: 14px; font-weight: 600; font-family: var(--font-sans);
        text-decoration: none; border: none; cursor: pointer;
        transition: opacity .15s;
      }
      .btn-accent:hover { opacity: .9; }

      [x-cloak] { display: none !important; }
    </style>

    @stack('head')
</head>
<body class="min-h-screen flex flex-col antialiased">

    @include('front.partials.navbar')

    <main class="flex-1">
        @if (session('status'))
            <div style="background: #FFF4EC; border-left: 4px solid var(--accent); color: #8A350B; padding: 12px 24px; font-size: 14px;">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

    @include('front.partials.footer')

    @stack('scripts')
</body>
</html>
