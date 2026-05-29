@extends('front.layouts.app')

@section('title', $category->name . ' — Akha Interior')

@section('content')

{{-- Hero --}}
<section style="border-bottom:1px solid var(--border); background:var(--bg-elev);">
    <div style="max-width:1320px; margin:0 auto; padding:56px 32px 48px;">
        <div style="font-size:11px; letter-spacing:0.10em; text-transform:uppercase; font-weight:600; color:var(--fg-muted); margin-bottom:8px;">Kategori</div>
        <h1 style="font-family:var(--font-display); font-size:clamp(32px,5vw,56px); line-height:1.0; letter-spacing:-0.02em; font-weight:400; color:var(--fg); margin:0;">
            {{ $category->name }}
        </h1>
        @if ($category->description)
            <p style="margin-top:14px; font-size:16px; color:var(--fg-muted); max-width:520px; line-height:1.55;">
                {{ $category->description }}
            </p>
        @endif
    </div>
</section>

<div style="max-width:1320px; margin:0 auto; padding:48px 32px 80px;">

    @if ($products->isEmpty())
        <div style="background:var(--bg-elev); border:1px solid var(--border); border-radius:16px; padding:64px 32px; text-align:center;">
            <div style="font-family:var(--font-display); font-size:28px; letter-spacing:-0.01em; color:var(--fg); margin-bottom:8px;">
                Belum ada produk di kategori ini
            </div>
            <p style="font-size:14px; color:var(--fg-muted); margin:0 0 24px;">Cek kembali nanti atau jelajahi semua katalog kami.</p>
            <a href="{{ route('front.shop.index') }}" class="btn-primary">
                Lihat Semua Produk →
            </a>
        </div>
    @else
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
            <p style="font-size:13px; color:var(--fg-muted);">
                Menampilkan <span style="font-weight:600; color:var(--fg);">{{ $products->total() }}</span> produk
            </p>
            <a href="{{ route('front.shop.index') }}"
               style="font-size:13px; font-weight:600; color:var(--fg-muted); text-decoration:none;"
               onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--fg-muted)'">
                ← Semua Produk
            </a>
        </div>

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

@endsection
