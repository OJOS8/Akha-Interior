@extends('front.layouts.app')

@section('title', 'Akha Interior — Furniture Kayu Solid untuk Rumah Hangat')

@section('content')
    {{-- Hero --}}
    @php
        $hero = $banners->first();
        $heroImg = $hero?->image
            ? (str_starts_with($hero->image, 'http') ? $hero->image : asset('storage/' . $hero->image))
            : null;
    @endphp
    <section class="relative">
        <div class="relative h-[78vh] min-h-[520px] {{ $heroImg ? '' : 'hero-grain' }}"
             @if($heroImg) style="background-image: linear-gradient(rgba(47,42,38,.55), rgba(47,42,38,.55)), url('{{ $heroImg }}'); background-size:cover; background-position:center;" @endif>
            <div class="max-w-7xl mx-auto h-full px-4 sm:px-6 lg:px-8 flex items-center">
                <div class="max-w-2xl text-akha-50">
                    <p class="uppercase tracking-[0.3em] text-xs text-akha-200 mb-4">Akha Interior — Est. 2024</p>
                    <h1 class="font-serif-display text-4xl sm:text-5xl lg:text-6xl leading-tight mb-6">
                        {{ $hero?->title ?? 'Furniture kayu solid yang menua dengan anggun.' }}
                    </h1>
                    <p class="text-akha-100/90 text-base sm:text-lg leading-relaxed mb-8">
                        {{ $hero?->subtitle ?? 'Setiap meja, kursi, dan lemari Akha dibuat untuk menemani momen makan, tertawa, dan beristirahat — selama bertahun-tahun ke depan.' }}
                    </p>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ $hero?->link ?? route('front.shop.index') }}" class="inline-flex items-center px-6 py-3 rounded-full bg-akha-50 text-akha-900 font-medium hover:bg-akha-100 transition">
                            Jelajahi Koleksi
                        </a>
                        <a href="{{ route('front.about') }}" class="inline-flex items-center px-6 py-3 rounded-full border border-akha-100/60 text-akha-50 font-medium hover:bg-akha-50/10 transition">
                            Cerita Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Categories --}}
    @if ($categories->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <p class="uppercase tracking-[0.3em] text-xs text-akha-600 mb-2">Koleksi</p>
                    <h2 class="font-serif-display text-3xl sm:text-4xl text-akha-900">Mulai dari ruang favorit Anda</h2>
                </div>
                <a href="{{ route('front.shop.index') }}" class="hidden sm:inline-flex items-center text-sm font-medium text-akha-700 hover:text-akha-900">
                    Lihat semua
                    <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                @foreach ($categories as $i => $category)
                    @php
                        $catImg = $category->image
                            ? (str_starts_with($category->image, 'http') ? $category->image : asset('storage/' . $category->image))
                            : null;
                        $stock = [
                            'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?auto=format&fit=crop&w=900&q=80',
                            'https://images.unsplash.com/photo-1538688525198-9b88f6f53126?auto=format&fit=crop&w=900&q=80',
                            'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?auto=format&fit=crop&w=900&q=80',
                            'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=900&q=80',
                            'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=900&q=80',
                            'https://images.unsplash.com/photo-1486946255434-2466348c2166?auto=format&fit=crop&w=900&q=80',
                        ];
                        $img = $catImg ?? $stock[$i % count($stock)];
                    @endphp
                    <a href="{{ route('front.categories.show', $category->slug) }}"
                       class="group relative block overflow-hidden rounded-xl aspect-[4/5]">
                        <img src="{{ $img }}" alt="{{ $category->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-akha-900/80 via-akha-900/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-5 text-akha-50">
                            <p class="text-xs uppercase tracking-widest text-akha-200 mb-1">{{ $category->products_count ?? 0 }} produk</p>
                            <h3 class="font-serif-display text-2xl">{{ $category->name }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Featured products --}}
    @if ($featuredProducts->isNotEmpty())
        <section class="bg-akha-100/60 border-y border-akha-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="flex items-end justify-between mb-10">
                    <div>
                        <p class="uppercase tracking-[0.3em] text-xs text-akha-600 mb-2">Pilihan Akha</p>
                        <h2 class="font-serif-display text-3xl sm:text-4xl text-akha-900">Furniture yang banyak disukai</h2>
                    </div>
                    <a href="{{ route('front.shop.index') }}" class="hidden sm:inline-flex items-center text-sm font-medium text-akha-700 hover:text-akha-900">
                        Lihat semua
                        <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($featuredProducts as $product)
                        @include('front.partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Why us --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 grid md:grid-cols-3 gap-8">
        @php
            $values = [
                ['title' => 'Kayu Pilihan', 'desc' => 'Hanya kayu solid bersertifikat dengan finish ramah lingkungan.', 'icon' => 'M12 2l3 7h7l-5.5 4.5L18 21l-6-4-6 4 1.5-7.5L2 9h7z'],
                ['title' => 'Dibuat Tangan', 'desc' => 'Setiap sambungan dirakit dan dihaluskan oleh pengrajin berpengalaman.', 'icon' => 'M3 7l9-4 9 4v10l-9 4-9-4V7z'],
                ['title' => 'Garansi 5 Tahun', 'desc' => 'Kami percaya pada kualitas yang menua dengan baik di rumah Anda.', 'icon' => 'M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ];
        @endphp
        @foreach ($values as $v)
            <div class="p-8 rounded-2xl bg-white ring-1 ring-akha-200">
                <div class="w-12 h-12 rounded-full bg-akha-900 text-akha-50 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="{{ $v['icon'] }}"></path></svg>
                </div>
                <h3 class="font-serif-display text-xl text-akha-900 mb-2">{{ $v['title'] }}</h3>
                <p class="text-sm text-akha-700 leading-relaxed">{{ $v['desc'] }}</p>
            </div>
        @endforeach
    </section>

    {{-- New products --}}
    @if ($newProducts->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <p class="uppercase tracking-[0.3em] text-xs text-akha-600 mb-2">Baru tiba</p>
                    <h2 class="font-serif-display text-3xl sm:text-4xl text-akha-900">Koleksi terbaru</h2>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($newProducts as $product)
                    @include('front.partials.product-card', ['product' => $product])
                @endforeach
            </div>
        </section>
    @endif

    {{-- Testimonials --}}
    @if ($testimonials->isNotEmpty())
        <section class="bg-akha-900 text-akha-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <p class="uppercase tracking-[0.3em] text-xs text-akha-300 mb-2 text-center">Cerita pelanggan</p>
                <h2 class="font-serif-display text-3xl sm:text-4xl text-center mb-12">Mereka sudah merasakan</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach ($testimonials as $t)
                        <div class="p-8 rounded-2xl bg-akha-800/60 ring-1 ring-akha-700">
                            <div class="flex items-center gap-1 mb-3 text-akha-300">
                                @for ($i = 0; $i < (int) $t->rating; $i++)
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.05 2.927c.3-.921 1.6-.921 1.9 0l1.286 3.957a1 1 0 00.95.69h4.16c.969 0 1.371 1.24.588 1.81l-3.366 2.446a1 1 0 00-.363 1.118l1.286 3.957c.3.921-.755 1.688-1.539 1.118l-3.366-2.446a1 1 0 00-1.176 0l-3.366 2.446c-.784.57-1.838-.197-1.539-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.567 9.384c-.783-.57-.38-1.81.588-1.81h4.16a1 1 0 00.95-.69L9.05 2.927z"/></svg>
                                @endfor
                            </div>
                            <p class="text-akha-100 leading-relaxed mb-6">“{{ $t->review ?? 'Sangat puas dengan kualitas dan desainnya.' }}”</p>
                            <p class="text-sm text-akha-300">— {{ optional($t->user)->name ?? 'Pelanggan Akha' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="rounded-3xl overflow-hidden bg-akha-200/70 ring-1 ring-akha-300 grid md:grid-cols-2">
            <div class="p-10 sm:p-14">
                <p class="uppercase tracking-[0.3em] text-xs text-akha-600 mb-2">Konsultasi gratis</p>
                <h2 class="font-serif-display text-3xl sm:text-4xl text-akha-900 mb-4">
                    Butuh bantuan memilih furniture untuk ruang Anda?
                </h2>
                <p class="text-akha-700 mb-6 leading-relaxed">
                    Tim Akha siap membantu rekomendasi ukuran, material, dan finishing yang paling cocok dengan rumah dan gaya hidup Anda.
                </p>
                <a href="{{ route('front.contact') }}" class="inline-flex items-center px-6 py-3 rounded-full bg-akha-900 text-akha-50 font-medium hover:bg-akha-700 transition">
                    Hubungi Kami
                </a>
            </div>
            <div class="hidden md:block bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?auto=format&fit=crop&w=1200&q=80');"></div>
        </div>
    </section>
@endsection
