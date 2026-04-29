@extends('front.layouts.app')

@section('title', 'Katalog Produk — Akha Interior')

@section('content')
    <section class="bg-akha-100/60 border-b border-akha-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <p class="uppercase tracking-[0.3em] text-xs text-akha-600 mb-2">Katalog</p>
            <h1 class="font-serif-display text-3xl sm:text-4xl text-akha-900">Semua furniture Akha</h1>
            <p class="mt-3 text-akha-700 max-w-xl">Dirakit dengan kayu solid pilihan, dirancang untuk menua bersama rumah Anda.</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid lg:grid-cols-[260px_1fr] gap-10">
        <aside class="space-y-8">
            <form method="GET" action="{{ route('front.shop.index') }}" class="space-y-3">
                <label class="block text-xs uppercase tracking-widest text-akha-600">Cari</label>
                <div class="relative">
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                           class="w-full rounded-full border-akha-200 bg-white text-sm focus:border-akha-600 focus:ring-akha-600 pr-10">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-akha-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </div>
            </form>

            <div>
                <p class="text-xs uppercase tracking-widest text-akha-600 mb-3">Kategori</p>
                <ul class="space-y-1.5">
                    <li>
                        <a href="{{ route('front.shop.index', request()->except('category', 'page')) }}"
                           class="text-sm {{ request('category') ? 'text-akha-700 hover:text-akha-900' : 'text-akha-900 font-medium' }}">
                            Semua produk
                        </a>
                    </li>
                    @foreach ($categories as $cat)
                        <li>
                            <a href="{{ route('front.shop.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}"
                               class="text-sm {{ request('category') === $cat->slug ? 'text-akha-900 font-medium' : 'text-akha-700 hover:text-akha-900' }}">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <div>
            <div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
                <p class="text-sm text-akha-700">
                    Menampilkan <span class="font-medium text-akha-900">{{ $products->total() }}</span> produk
                </p>
                <form method="GET" action="{{ route('front.shop.index') }}" class="flex items-center gap-2">
                    @foreach (request()->except(['sort', 'page']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <label for="sort" class="text-sm text-akha-700">Urutkan</label>
                    <select id="sort" name="sort" onchange="this.form.submit()"
                            class="rounded-full border-akha-200 bg-white text-sm focus:border-akha-600 focus:ring-akha-600">
                        <option value="latest" @selected(request('sort') === 'latest' || ! request('sort'))>Terbaru</option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>Harga termurah</option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>Harga tertinggi</option>
                        <option value="name" @selected(request('sort') === 'name')>Nama A–Z</option>
                    </select>
                </form>
            </div>

            @if ($products->isEmpty())
                <div class="rounded-2xl bg-white ring-1 ring-akha-200 p-12 text-center">
                    <p class="font-serif-display text-2xl text-akha-900 mb-2">Belum ada produk yang cocok</p>
                    <p class="text-sm text-akha-700">Coba ubah pencarian atau filter kategori.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        @include('front.partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
