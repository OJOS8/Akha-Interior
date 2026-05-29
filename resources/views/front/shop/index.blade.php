@extends('front.layouts.app')

@section('title', 'Katalog Produk — Akha Interior')

@section('content')

{{-- Hero --}}
<section style="border-bottom:1px solid var(--border); background:var(--bg-elev);">
    <div style="max-width:1320px; margin:0 auto; padding:56px 32px 48px;">
        <div style="font-size:11px; letter-spacing:0.10em; text-transform:uppercase; font-weight:600; color:var(--fg-muted); margin-bottom:8px;">Katalog</div>
        <h1 style="font-family:var(--font-display); font-size:clamp(32px,5vw,56px); line-height:1.0; letter-spacing:-0.02em; font-weight:400; color:var(--fg); margin:0;">
            Semua furniture Akha.
        </h1>
        <p style="margin-top:14px; font-size:16px; color:var(--fg-muted); max-width:500px; line-height:1.55;">
            Dirakit dengan kayu solid pilihan, dirancang untuk menua bersama rumah Anda.
        </p>
    </div>
</section>

<div style="max-width:1320px; margin:0 auto; padding:48px 32px;">
    <div style="display:grid; grid-template-columns:220px 1fr; gap:40px; align-items:start;" class="md:grid-cols-[220px_1fr] grid-cols-1">

        {{-- ── Sidebar filter ── --}}
        <aside>

            {{-- Search --}}
            <form method="GET" action="{{ route('front.shop.index') }}" style="margin-bottom:28px;">
                <label style="font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--fg-muted); display:block; margin-bottom:8px;">Cari</label>
                <div style="position:relative;">
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                           style="width:100%; border:1px solid var(--border); border-radius:999px; background:var(--bg-elev); padding:9px 40px 9px 16px; font-size:13px; color:var(--fg); font-family:var(--font-sans); outline:none; box-sizing:border-box;"
                           onfocus="this.style.borderColor='var(--fg)'" onblur="this.style.borderColor='var(--border)'">
                    <button type="submit" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:var(--fg-muted); display:flex; align-items:center;">
                        <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Kategori --}}
            <div style="margin-bottom:28px;">
                <div style="font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--fg-muted); margin-bottom:12px;">Kategori</div>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:4px;">
                    <li>
                        <a href="{{ route('front.shop.index', request()->except('category', 'page')) }}"
                           style="display:block; padding:6px 10px; border-radius:8px; font-size:13px; text-decoration:none; font-weight:{{ !request('category') ? '600' : '400' }}; color:{{ !request('category') ? 'var(--fg)' : 'var(--fg-muted)' }}; background:{{ !request('category') ? 'var(--bg-sunken)' : 'transparent' }};">
                            Semua produk
                        </a>
                    </li>
                    @foreach ($categories as $cat)
                        <li>
                            <a href="{{ route('front.shop.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}"
                               style="display:block; padding:6px 10px; border-radius:8px; font-size:13px; text-decoration:none; font-weight:{{ request('category') === $cat->slug ? '600' : '400' }}; color:{{ request('category') === $cat->slug ? 'var(--fg)' : 'var(--fg-muted)' }}; background:{{ request('category') === $cat->slug ? 'var(--bg-sunken)' : 'transparent' }};">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Urutkan --}}
            <div>
                <div style="font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--fg-muted); margin-bottom:12px;">Urutkan</div>
                <form method="GET" action="{{ route('front.shop.index') }}">
                    @foreach (request()->except(['sort', 'page']) as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <select name="sort" onchange="this.form.submit()"
                            style="width:100%; border:1px solid var(--border); border-radius:8px; background:var(--bg-elev); padding:9px 12px; font-size:13px; color:var(--fg); font-family:var(--font-sans); outline:none; cursor:pointer;">
                        <option value="latest" @selected(!request('sort') || request('sort') === 'latest')>Terbaru</option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>Harga termurah</option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>Harga tertinggi</option>
                        <option value="name" @selected(request('sort') === 'name')>Nama A–Z</option>
                    </select>
                </form>
            </div>
        </aside>

        {{-- ── Produk grid ── --}}
        <div>
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
                <p style="font-size:13px; color:var(--fg-muted);">
                    Menampilkan <span style="font-weight:600; color:var(--fg);">{{ $products->total() }}</span> produk
                </p>
            </div>

            @if ($products->isEmpty())
                <div style="background:var(--bg-elev); border:1px solid var(--border); border-radius:16px; padding:64px 32px; text-align:center;">
                    <div style="font-family:var(--font-display); font-size:28px; letter-spacing:-0.01em; color:var(--fg); margin-bottom:8px;">Belum ada produk yang cocok</div>
                    <p style="font-size:14px; color:var(--fg-muted);">Coba ubah pencarian atau pilih kategori lain.</p>
                </div>
            @else
                <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:28px 22px;">
                    @foreach ($products as $product)
                        @include('front.partials.product-card', ['product' => $product])
                    @endforeach
                </div>

                <div style="margin-top:40px;">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
