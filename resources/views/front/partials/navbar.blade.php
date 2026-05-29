@php
    $navCategories = $navCategories ?? collect();
    $cartCount = session('cart.items') ? array_sum(array_column(session('cart.items'), 'qty')) : 0;
@endphp

{{-- Promo strip --}}
<div style="background: var(--fg); color: #F4F3F0; font-size: 12px; letter-spacing: 0.02em; padding: 8px 16px; text-align: center;">
    Pengiriman Jabodetabek &middot; Konsultasi furnitur gratis &middot; Garansi rangka 5 tahun
</div>

<header x-data="{ open: false, catOpen: false }"
        class="sticky top-0 z-40"
        style="background: color-mix(in srgb, var(--bg) 88%, transparent); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: 1px solid var(--border);">

    <div class="max-w-site mx-auto px-6 sm:px-8"
         style="display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; gap: 16px; padding-top: 14px; padding-bottom: 14px;">

        {{-- Left nav --}}
        <nav class="hidden md:flex items-center gap-6">
            <a href="{{ route('front.shop.index') }}"
               style="color: {{ request()->routeIs('front.shop.*') ? 'var(--fg)' : 'var(--fg-muted)' }}; text-decoration: none; font-size: 14px; font-weight: 500; border-bottom: 1px solid {{ request()->routeIs('front.shop.*') ? 'var(--fg)' : 'transparent' }}; padding-bottom: 2px;">
                Katalog
            </a>

            <div class="relative" x-data="{ catOpen: false }">
                <button @click="catOpen = !catOpen" @click.outside="catOpen = false"
                        style="display: flex; align-items: center; gap: 4px; color: var(--fg-muted); background: none; border: none; cursor: pointer; font-size: 14px; font-weight: 500; font-family: var(--font-sans); padding-bottom: 2px; border-bottom: 1px solid transparent;">
                    Kategori
                    <svg style="width:12px;height:12px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="catOpen" x-cloak
                     style="position:absolute; left:0; top:calc(100% + 8px); min-width:210px; background: var(--bg-elev); border: 1px solid var(--border); border-radius: 12px; box-shadow: var(--shadow-md); z-index: 50; overflow: hidden;">
                    @forelse ($navCategories as $cat)
                        <a href="{{ route('front.categories.show', $cat->slug) }}"
                           style="display:block; padding: 10px 16px; font-size: 13px; color: var(--fg); text-decoration: none; transition: background .1s;"
                           onmouseover="this.style.background='var(--bg-sunken)'" onmouseout="this.style.background='transparent'">
                            {{ $cat->name }}
                        </a>
                    @empty
                        <span style="display:block; padding: 10px 16px; font-size: 13px; color: var(--fg-muted);">Belum ada kategori</span>
                    @endforelse
                </div>
            </div>

            <a href="{{ route('front.about') }}"
               style="color: {{ request()->routeIs('front.about') ? 'var(--fg)' : 'var(--fg-muted)' }}; text-decoration: none; font-size: 14px; font-weight: 500; border-bottom: 1px solid {{ request()->routeIs('front.about') ? 'var(--fg)' : 'transparent' }}; padding-bottom: 2px;">
                Tentang
            </a>
        </nav>

        {{-- Logo (centered) --}}
        <a href="{{ route('front.home') }}" style="text-decoration: none; text-align: center; display: flex; flex-direction: column; align-items: center;">
            <span style="font-family: var(--font-display); font-size: 20px; letter-spacing: -0.01em; color: var(--fg); line-height: 1;">Akha Interior</span>
            <span style="font-size: 10px; letter-spacing: 0.12em; text-transform: uppercase; color: var(--fg-subtle); margin-top: 2px;">Est. 2024</span>
        </a>

        {{-- Right --}}
        <div class="hidden md:flex items-center justify-end gap-3">
            <a href="{{ route('front.contact') }}"
               style="color: {{ request()->routeIs('front.contact') ? 'var(--fg)' : 'var(--fg-muted)' }}; text-decoration: none; font-size: 14px; font-weight: 500; border-bottom: 1px solid {{ request()->routeIs('front.contact') ? 'var(--fg)' : 'transparent' }}; padding-bottom: 2px;">
                Kontak
            </a>

            <div style="width:1px;height:18px;background:var(--border);margin:0 4px;"></div>

            <a href="{{ route('front.cart.index') }}"
               aria-label="Keranjang ({{ $cartCount }})"
               style="position:relative; display:flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:999px; color:var(--fg); text-decoration:none; transition:background .15s;"
               onmouseover="this.style.background='var(--bg-sunken)'" onmouseout="this.style.background='transparent'">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/>
                </svg>
                @if ($cartCount > 0)
                    <span style="position:absolute; top:-2px; right:-2px; min-width:18px; height:18px; border-radius:999px; background:var(--accent); color:var(--accent-fg); font-size:10px; font-weight:700; display:flex; align-items:center; justify-content:center; padding:0 3px;">{{ $cartCount }}</span>
                @endif
            </a>

            <a href="{{ route('front.shop.index') }}" class="btn-primary" style="padding: 8px 20px; font-size: 13px;">
                Belanja Sekarang
            </a>
        </div>

        {{-- Mobile: cart + hamburger --}}
        <div class="md:hidden flex items-center justify-end gap-2">
            <a href="{{ route('front.cart.index') }}"
               style="position:relative; display:flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:999px; color:var(--fg); text-decoration:none;">
                <svg style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/>
                </svg>
                @if ($cartCount > 0)
                    <span style="position:absolute; top:-2px; right:-2px; min-width:16px; height:16px; border-radius:999px; background:var(--accent); color:var(--accent-fg); font-size:9px; font-weight:700; display:flex; align-items:center; justify-content:center; padding:0 2px;">{{ $cartCount }}</span>
                @endif
            </a>
            <button @click="open = !open"
                    style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; border-radius:8px; background:none; border:none; cursor:pointer; color:var(--fg);">
                <svg x-show="!open" style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" x-cloak style="width:20px;height:20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-cloak
         style="border-top: 1px solid var(--border); background: var(--bg-elev);">
        <div class="max-w-site mx-auto px-6 py-4 space-y-1">
            <a href="{{ route('front.home') }}" style="display:block; padding:10px 12px; border-radius:8px; font-size:14px; font-weight:500; color:var(--fg); text-decoration:none;">Beranda</a>
            <a href="{{ route('front.shop.index') }}" style="display:block; padding:10px 12px; border-radius:8px; font-size:14px; font-weight:500; color:var(--fg); text-decoration:none;">Katalog</a>
            @foreach ($navCategories as $cat)
                <a href="{{ route('front.categories.show', $cat->slug) }}" style="display:block; padding:8px 12px 8px 28px; border-radius:8px; font-size:13px; color:var(--fg-muted); text-decoration:none;">{{ $cat->name }}</a>
            @endforeach
            <a href="{{ route('front.about') }}" style="display:block; padding:10px 12px; border-radius:8px; font-size:14px; font-weight:500; color:var(--fg); text-decoration:none;">Tentang</a>
            <a href="{{ route('front.contact') }}" style="display:block; padding:10px 12px; border-radius:8px; font-size:14px; font-weight:500; color:var(--fg); text-decoration:none;">Kontak</a>
        </div>
    </div>
</header>

@once
@push('head')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
@endonce
