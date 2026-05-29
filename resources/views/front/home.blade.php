@extends('front.layouts.app')

@section('title', 'Akha Interior — Furniture Kayu Solid untuk Rumah Hangat')

@section('content')
@php
    $hero    = $banners->first();
    $heroImg = $hero?->image
        ? (str_starts_with($hero->image, 'http') ? $hero->image : asset('storage/' . $hero->image))
        : 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1400&q=80';
    $stockImgs = [
        'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1538688525198-9b88f6f53126?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1486946255434-2466348c2166?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1506439773649-6e0eb8cfb237?auto=format&fit=crop&w=900&q=80',
    ];
@endphp

{{-- ══════════════════════════════════════════
     HERO — editorial 2 kolom
══════════════════════════════════════════ --}}
<section style="max-width:1320px; margin:0 auto; padding:28px 32px 0;">
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:48px; align-items:stretch;" class="grid-cols-1 md:grid-cols-2">

        {{-- Kiri: headline + trust --}}
        <div style="padding-top:24px; padding-bottom:32px; display:flex; flex-direction:column;">
            <div style="font-size:11px; letter-spacing:0.10em; text-transform:uppercase; font-weight:600; color:#8A350B;">
                Akha Interior &mdash; Est. 2024
            </div>
            <h1 style="font-family:var(--font-display); font-size:clamp(52px,6vw,88px); line-height:0.98; letter-spacing:-0.025em; font-weight:400; margin-top:24px; margin-bottom:0; color:var(--fg);">
                {{ $hero?->title ?? 'Furniture' }}<br>
                <em style="font-style:italic; color:var(--accent);">{{ $hero?->subtitle ? '' : 'kayu solid,' }}</em><br>
                {{ $hero?->subtitle ? $hero->subtitle : 'untuk rumah hangat.' }}
            </h1>
            <p style="font-size:17px; line-height:1.55; color:var(--fg-muted); margin-top:28px; max-width:440px;">
                Setiap meja, kursi, dan lemari Akha dibuat dari kayu solid pilihan, dirakit pengrajin lokal, untuk menemani momen makan, tertawa, dan beristirahat.
            </p>
            <div style="display:flex; gap:12px; margin-top:32px; flex-wrap:wrap;">
                <a href="{{ route('front.shop.index') }}" class="btn-primary">
                    Jelajahi Katalog →
                </a>
                <a href="{{ route('front.about') }}" class="btn-ghost">
                    Cerita Kami
                </a>
            </div>

            {{-- Trust badges --}}
            <div style="display:flex; gap:32px; margin-top:auto; padding-top:48px; flex-wrap:wrap;">
                @php
                    $trusts = [
                        ['icon'=>'M5 13l4 4L19 7', 'label'=>'Kayu Solid Pilihan', 'body'=>'Bersertifikat & ramah lingkungan'],
                        ['icon'=>'M3 7l9-4 9 4v10l-9 4-9-4V7z', 'label'=>'Dibuat Tangan', 'body'=>'Oleh pengrajin berpengalaman'],
                        ['icon'=>'M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label'=>'Garansi 5 Tahun', 'body'=>'Untuk setiap rangka produk'],
                    ];
                @endphp
                @foreach ($trusts as $t)
                    <div style="display:flex; gap:10px; align-items:flex-start;">
                        <div style="width:32px; height:32px; border-radius:999px; background:var(--bg-elev); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $t['icon'] }}"/>
                            </svg>
                        </div>
                        <div>
                            <div style="font-size:13px; font-weight:600; color:var(--fg);">{{ $t['label'] }}</div>
                            <div style="font-size:12px; color:var(--fg-muted); margin-top:1px;">{{ $t['body'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Kanan: gambar hero --}}
        <div style="position:relative; min-height:560px;">
            <div style="position:absolute; inset:0; border-radius:18px; overflow:hidden; background:#a78b6f;">
                <img src="{{ $heroImg }}" alt="Akha Interior"
                     style="width:100%; height:100%; object-fit:cover;">
            </div>
            {{-- Caption card --}}
            <div style="position:absolute; left:20px; bottom:20px; right:20px; display:flex; justify-content:space-between; align-items:flex-end; gap:12px;">
                <div style="background:color-mix(in srgb,var(--bg) 92%,transparent); backdrop-filter:blur(10px); -webkit-backdrop-filter:blur(10px); padding:14px 16px; border-radius:12px; max-width:280px;">
                    <div style="font-size:10px; letter-spacing:0.06em; text-transform:uppercase; font-weight:600; color:var(--fg-muted);">Dari koleksi</div>
                    <div style="font-family:var(--font-display); font-size:19px; line-height:1.2; letter-spacing:-0.01em; margin-top:4px; color:var(--fg);">
                        Akha <em style="font-style:italic;">Ruang Makan</em> Series
                    </div>
                </div>
                <a href="{{ route('front.shop.index') }}"
                   style="background:var(--fg); color:var(--bg-elev); padding:10px 18px; border-radius:999px; font-size:13px; font-weight:600; text-decoration:none; white-space:nowrap;">
                    Lihat Katalog
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     KATEGORI
══════════════════════════════════════════ --}}
@if ($categories->isNotEmpty())
<section style="max-width:1320px; margin:0 auto; padding:96px 32px 0;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:32px; gap:16px;">
        <div>
            <div style="font-size:11px; letter-spacing:0.10em; text-transform:uppercase; font-weight:600; color:var(--fg-muted);">Telusuri</div>
            <h2 style="font-family:var(--font-display); font-size:clamp(28px,3.5vw,44px); line-height:1.1; letter-spacing:-0.02em; font-weight:400; margin-top:6px; color:var(--fg);">
                Mulai dari ruang favorit Anda.
            </h2>
        </div>
        <a href="{{ route('front.shop.index') }}"
           style="font-size:13px; font-weight:600; color:var(--fg-muted); text-decoration:none; white-space:nowrap; flex-shrink:0;"
           onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--fg-muted)'">
            Lihat semua →
        </a>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:14px;">
        @foreach ($categories as $i => $category)
            @php
                $catImg = $category->image
                    ? (str_starts_with($category->image, 'http') ? $category->image : asset('storage/' . $category->image))
                    : ($stockImgs[$i % count($stockImgs)]);
            @endphp
            <a href="{{ route('front.categories.show', $category->slug) }}"
               style="position:relative; aspect-ratio:5/7; border-radius:12px; overflow:hidden; display:block; text-decoration:none; background:#C8C8D0;">
                <img src="{{ $catImg }}" alt="{{ $category->name }}"
                     style="width:100%; height:100%; object-fit:cover; transition:transform .6s;"
                     onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
                <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(11,11,12,.72) 0%, rgba(11,11,12,0) 50%);"></div>
                <div style="position:absolute; left:12px; right:12px; bottom:12px; color:#FAF9F6;">
                    <div style="font-size:10px; letter-spacing:0.08em; text-transform:uppercase; font-weight:600; opacity:.75;">0{{ $i + 1 }}</div>
                    <div style="font-size:15px; font-weight:600; margin-top:3px; line-height:1.25;">{{ $category->name }}</div>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════
     PRODUK UNGGULAN
══════════════════════════════════════════ --}}
@if ($featuredProducts->isNotEmpty())
<section style="max-width:1320px; margin:0 auto; padding:80px 32px 0;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:32px; gap:16px;">
        <div>
            <div style="font-size:11px; letter-spacing:0.10em; text-transform:uppercase; font-weight:600; color:var(--fg-muted);">Pilihan Akha</div>
            <h2 style="font-family:var(--font-display); font-size:clamp(28px,3.5vw,44px); line-height:1.1; letter-spacing:-0.02em; font-weight:400; margin-top:6px; color:var(--fg);">
                Furniture yang banyak disukai.
            </h2>
        </div>
        <a href="{{ route('front.shop.index') }}"
           style="font-size:13px; font-weight:600; color:var(--fg-muted); text-decoration:none; white-space:nowrap; flex-shrink:0;"
           onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--fg-muted)'">
            Buka katalog →
        </a>
    </div>

    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(240px,1fr)); gap:28px 24px;">
        @foreach ($featuredProducts->take(4) as $product)
            @include('front.partials.product-card', ['product' => $product])
        @endforeach
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════
     EDITORIAL DARK — cerita Akha
══════════════════════════════════════════ --}}
<section style="max-width:1320px; margin:0 auto; padding:100px 32px 0;">
    <div style="background:var(--fg); color:#F4F3F0; border-radius:18px; padding:64px; display:grid; grid-template-columns:1fr 1fr; gap:56px; align-items:center; position:relative; overflow:hidden;">
        {{-- glow --}}
        <div style="position:absolute; right:-120px; top:-120px; width:480px; height:480px; border-radius:999px; background:radial-gradient(circle, rgba(226,92,11,.28), transparent 65%); pointer-events:none;"></div>

        <div style="position:relative;">
            <div style="font-size:11px; letter-spacing:0.10em; text-transform:uppercase; font-weight:600; color:#FF9D55;">
                Tentang Akha
            </div>
            <h2 style="font-family:var(--font-display); font-size:clamp(36px,4vw,60px); line-height:1.0; letter-spacing:-0.02em; font-weight:400; margin-top:24px; color:#FAF9F6;">
                Dibuat tangan,<br>
                <em style="font-style:italic; color:#FF9D55;">dengan kayu</em><br>
                pilihan lokal.
            </h2>
            <p style="font-size:16px; line-height:1.6; color:#C8C8D0; margin-top:22px; max-width:440px;">
                Setiap produk Akha lahir dari kolaborasi dengan pengrajin Indonesia yang telah puluhan tahun bekerja dengan kayu solid. Kami tidak terburu-buru — kualitas membutuhkan waktu.
            </p>
            <div style="margin-top:32px; display:flex; gap:12px; flex-wrap:wrap;">
                <a href="{{ route('front.about') }}"
                   style="background:var(--accent); color:#FAF9F6; padding:12px 24px; border-radius:999px; font-size:14px; font-weight:600; text-decoration:none;">
                    Cerita Lengkap →
                </a>
                <a href="{{ route('front.contact') }}"
                   style="background:transparent; color:#F4F3F0; border:1px solid #2A2A30; padding:12px 22px; border-radius:999px; font-size:14px; font-weight:600; text-decoration:none; cursor:pointer;">
                    Konsultasi Gratis
                </a>
            </div>
        </div>

        {{-- 2 gambar berdampingan --}}
        <div style="position:relative; display:grid; grid-template-columns:1fr 1fr; gap:14px;">
            <div style="aspect-ratio:3/4; border-radius:12px; overflow:hidden; background:#b89270; transform:translateY(-20px);">
                <img src="https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?auto=format&fit=crop&w=600&q=80"
                     alt="Pengrajin Akha" style="width:100%; height:100%; object-fit:cover;">
            </div>
            <div style="aspect-ratio:3/4; border-radius:12px; overflow:hidden; background:#4d2f22; transform:translateY(20px);">
                <img src="https://images.unsplash.com/photo-1503602642458-232111445657?auto=format&fit=crop&w=600&q=80"
                     alt="Kayu Akha" style="width:100%; height:100%; object-fit:cover;">
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     PRODUK BARU / TERLARIS
══════════════════════════════════════════ --}}
@if ($newProducts->isNotEmpty())
<section style="max-width:1320px; margin:0 auto; padding:100px 32px 0;">
    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom:32px; gap:16px;">
        <div>
            <div style="font-size:11px; letter-spacing:0.10em; text-transform:uppercase; font-weight:600; color:var(--fg-muted);">Koleksi Terbaru</div>
            <h2 style="font-family:var(--font-display); font-size:clamp(28px,3.5vw,44px); line-height:1.1; letter-spacing:-0.02em; font-weight:400; margin-top:6px; color:var(--fg);">
                Yang baru tiba.
            </h2>
        </div>
        <a href="{{ route('front.shop.index') }}"
           style="font-size:13px; font-weight:600; color:var(--fg-muted); text-decoration:none; white-space:nowrap; flex-shrink:0;"
           onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--fg-muted)'">
            Lihat semua →
        </a>
    </div>

    {{-- List layout 2 kolom ala Omah Apik bestsellers --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px 64px;">
        @foreach ($newProducts->take(6) as $product)
            @php
                $pImg = $product->thumbnail
                    ? (str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : asset('storage/' . $product->thumbnail))
                    : null;
                $pHasDiscount = $product->discount_price && $product->discount_price < $product->price;
                $pPrice = $pHasDiscount ? $product->discount_price : $product->price;
            @endphp
            <a href="{{ route('front.shop.show', $product->slug) }}"
               style="display:grid; grid-template-columns:72px 1fr; gap:14px; align-items:center; padding:16px 0; border-bottom:1px solid var(--border); text-decoration:none;">
                <div style="width:72px; height:72px; border-radius:8px; overflow:hidden; background:#E6E6EA; flex-shrink:0;">
                    @if ($pImg)
                        <img src="{{ $pImg }}" alt="{{ $product->name }}" style="width:100%; height:100%; object-fit:cover;">
                    @endif
                </div>
                <div>
                    @if ($product->category)
                        <div style="font-size:10px; font-weight:600; letter-spacing:0.06em; text-transform:uppercase; color:var(--fg-muted);">{{ $product->category->name }}</div>
                    @endif
                    <div style="font-size:15px; font-weight:600; color:var(--fg); margin-top:2px;">{{ $product->name }}</div>
                    <div style="font-size:13px; font-variant-numeric:tabular-nums; color:var(--fg-muted); margin-top:2px;">{{ \App\Support\Money::idr($pPrice) }}</div>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════
     TESTIMONIAL
══════════════════════════════════════════ --}}
@if ($testimonials->isNotEmpty())
<section style="max-width:1320px; margin:0 auto; padding:100px 32px 0;">
    <div style="text-align:center; margin-bottom:40px;">
        <div style="font-size:11px; letter-spacing:0.10em; text-transform:uppercase; font-weight:600; color:var(--fg-muted);">Cerita Pelanggan</div>
        <h2 style="font-family:var(--font-display); font-size:clamp(28px,3.5vw,44px); line-height:1.1; letter-spacing:-0.02em; font-weight:400; margin-top:8px; color:var(--fg);">
            Mereka sudah merasakan.
        </h2>
    </div>
    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:20px;">
        @foreach ($testimonials->take(3) as $t)
            <div style="background:var(--bg-elev); border:1px solid var(--border); border-radius:16px; padding:28px;">
                <div style="display:flex; gap:3px; margin-bottom:12px;">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg style="width:14px;height:14px; color:{{ $i <= (int)$t->rating ? 'var(--accent)' : 'var(--border)' }}; fill:currentColor;" viewBox="0 0 20 20">
                            <path d="M9.05 2.927c.3-.921 1.6-.921 1.9 0l1.286 3.957a1 1 0 00.95.69h4.16c.969 0 1.371 1.24.588 1.81l-3.366 2.446a1 1 0 00-.363 1.118l1.286 3.957c.3.921-.755 1.688-1.539 1.118l-3.366-2.446a1 1 0 00-1.176 0l-3.366 2.446c-.784.57-1.838-.197-1.539-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.567 9.384c-.783-.57-.38-1.81.588-1.81h4.16a1 1 0 00.95-.69L9.05 2.927z"/>
                        </svg>
                    @endfor
                </div>
                <p style="font-size:14px; line-height:1.65; color:var(--fg); margin:0 0 16px;">"{{ $t->review ?? 'Sangat puas dengan kualitas dan desainnya.' }}"</p>
                <p style="font-size:12px; color:var(--fg-muted);">— {{ optional($t->user)->name ?? 'Pelanggan Akha' }}</p>
            </div>
        @endforeach
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════
     CTA — Konsultasi Gratis
══════════════════════════════════════════ --}}
<section style="max-width:1320px; margin:0 auto; padding:100px 32px 0;">
    <div style="background:var(--bg-elev); border:1px solid var(--border); border-radius:18px; padding:56px; display:grid; grid-template-columns:1.2fr 1fr; gap:40px; align-items:center; overflow:hidden;">
        <div>
            <div style="font-size:11px; letter-spacing:0.10em; text-transform:uppercase; font-weight:600; color:var(--fg-muted);">Konsultasi Gratis</div>
            <h2 style="font-family:var(--font-display); font-size:clamp(32px,4vw,52px); line-height:1.05; letter-spacing:-0.02em; font-weight:400; margin-top:18px; color:var(--fg);">
                Butuh bantuan memilih<br>
                <em style="font-style:italic; color:var(--accent);">furniture</em> yang tepat?
            </h2>
            <p style="font-size:15px; line-height:1.6; color:var(--fg-muted); margin-top:18px; max-width:420px;">
                Tim Akha siap membantu rekomendasi ukuran, material, dan finishing yang paling cocok dengan rumah dan gaya hidup Anda.
            </p>
            <div style="margin-top:28px;">
                <a href="{{ route('front.contact') }}" class="btn-primary">
                    Hubungi Kami →
                </a>
            </div>
        </div>
        <div style="border-radius:12px; overflow:hidden; aspect-ratio:4/3;">
            <img src="https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?auto=format&fit=crop&w=800&q=80"
                 alt="Showroom Akha" style="width:100%; height:100%; object-fit:cover;">
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════
     QUOTE EDITORIAL
══════════════════════════════════════════ --}}
<section style="max-width:880px; margin:0 auto; padding:120px 32px 0; text-align:center;">
    <blockquote style="font-family:var(--font-display); font-size:clamp(28px,4vw,46px); line-height:1.2; letter-spacing:-0.02em; margin:0; font-weight:400; color:var(--fg);">
        <em style="font-style:italic;">
            "Kami tidak menjual apapun yang tidak akan kami taruh di rumah kami sendiri. Itu seluruh kebijakannya."
        </em>
    </blockquote>
    <div style="margin-top:24px; font-size:13px; color:var(--fg-muted); letter-spacing:0.04em;">
        Pendiri &middot; Akha Interior &middot; Jakarta
    </div>
</section>

<div style="height:80px;"></div>
@endsection
