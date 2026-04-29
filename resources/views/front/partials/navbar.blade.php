@php
    /** @var \Illuminate\Support\Collection|null $navCategories */
    $navCategories = $navCategories ?? collect();
    $cartCount = session('cart.items') ? array_sum(array_column(session('cart.items'), 'qty')) : 0;
@endphp
<header x-data="{ open: false }" class="sticky top-0 z-40 bg-akha-50/90 backdrop-blur border-b border-akha-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <a href="{{ route('front.home') }}" class="flex items-center gap-2">
                <span class="w-9 h-9 rounded-full bg-akha-900 text-akha-50 flex items-center justify-center font-serif-display text-lg">A</span>
                <span class="font-serif-display text-xl tracking-wide">Akha <span class="text-akha-600">Interior</span></span>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-akha-900">
                <a href="{{ route('front.home') }}" class="hover:text-akha-600 transition">Beranda</a>
                <a href="{{ route('front.shop.index') }}" class="hover:text-akha-600 transition">Katalog</a>
                <div class="relative group">
                    <button class="flex items-center gap-1 hover:text-akha-600 transition">
                        Kategori
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-lg ring-1 ring-akha-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition">
                        <div class="py-2">
                            @forelse ($navCategories as $cat)
                                <a href="{{ route('front.categories.show', $cat->slug) }}" class="block px-4 py-2 text-sm text-akha-900 hover:bg-akha-50">
                                    {{ $cat->name }}
                                </a>
                            @empty
                                <span class="block px-4 py-2 text-sm text-akha-600">Belum ada kategori</span>
                            @endforelse
                        </div>
                    </div>
                </div>
                <a href="{{ route('front.about') }}" class="hover:text-akha-600 transition">Tentang</a>
                <a href="{{ route('front.contact') }}" class="hover:text-akha-600 transition">Kontak</a>
            </nav>

            <div class="flex items-center gap-4">
                <a href="{{ route('front.cart.index') }}" class="relative inline-flex items-center justify-center w-10 h-10 rounded-full hover:bg-akha-100 transition" aria-label="Keranjang">
                    <svg class="w-5 h-5 text-akha-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.6 8h13.2M9 21a1 1 0 100-2 1 1 0 000 2zm9 0a1 1 0 100-2 1 1 0 000 2z"></path>
                    </svg>
                    @if ($cartCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center w-5 h-5 text-[10px] font-semibold text-white bg-akha-600 rounded-full">{{ $cartCount }}</span>
                    @endif
                </a>
                <a href="{{ route('front.shop.index') }}" class="hidden sm:inline-flex items-center px-4 py-2 rounded-full bg-akha-900 text-akha-50 text-sm font-medium hover:bg-akha-700 transition">
                    Belanja Sekarang
                </a>
                <button @click="open = !open" class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded hover:bg-akha-100" aria-label="Menu">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <div x-show="open" x-cloak class="md:hidden pb-4 space-y-1" style="display:none">
            <a href="{{ route('front.home') }}" class="block px-3 py-2 rounded text-akha-900 hover:bg-akha-100">Beranda</a>
            <a href="{{ route('front.shop.index') }}" class="block px-3 py-2 rounded text-akha-900 hover:bg-akha-100">Katalog</a>
            @foreach ($navCategories as $cat)
                <a href="{{ route('front.categories.show', $cat->slug) }}" class="block pl-6 pr-3 py-2 rounded text-akha-700 hover:bg-akha-100 text-sm">— {{ $cat->name }}</a>
            @endforeach
            <a href="{{ route('front.about') }}" class="block px-3 py-2 rounded text-akha-900 hover:bg-akha-100">Tentang</a>
            <a href="{{ route('front.contact') }}" class="block px-3 py-2 rounded text-akha-900 hover:bg-akha-100">Kontak</a>
        </div>
    </div>
</header>

@once
    @push('head')
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <style>[x-cloak]{display:none !important;}</style>
    @endpush
@endonce
