@extends('front.layouts.app')

@section('title', $product->name . ' — Akha Interior')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($product->short_description ?? $product->description), 150))

@section('content')
@php
    $hasDiscount = $product->discount_price && $product->discount_price < $product->price;
    $finalPrice  = $hasDiscount ? $product->discount_price : $product->price;
    $thumbnail   = $product->thumbnail
        ? (str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : asset('storage/' . $product->thumbnail))
        : null;
    $images = $product->images->map(fn($i) => str_starts_with($i->image, 'http') ? $i->image : asset('storage/' . $i->image))->all();
    if ($thumbnail) array_unshift($images, $thumbnail);
    $images    = array_values(array_unique($images));
    $avgRating = $product->reviews->avg('rating');
@endphp

<div style="max-width:1320px; margin:0 auto; padding:32px 32px 0;">

    {{-- Breadcrumb --}}
    <nav style="display:flex; align-items:center; gap:6px; font-size:12px; color:var(--fg-muted); margin-bottom:32px; flex-wrap:wrap;">
        <a href="{{ route('front.home') }}" style="color:var(--fg-muted); text-decoration:none;" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--fg-muted)'">Beranda</a>
        <span>/</span>
        <a href="{{ route('front.shop.index') }}" style="color:var(--fg-muted); text-decoration:none;" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--fg-muted)'">Katalog</a>
        @if ($product->category)
            <span>/</span>
            <a href="{{ route('front.categories.show', $product->category->slug) }}" style="color:var(--fg-muted); text-decoration:none;" onmouseover="this.style.color='var(--fg)'" onmouseout="this.style.color='var(--fg-muted)'">{{ $product->category->name }}</a>
        @endif
        <span>/</span>
        <span style="color:var(--fg);">{{ $product->name }}</span>
    </nav>

    {{-- Main: gambar + info --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:56px; align-items:start;"
         x-data="{ active: '{{ $images[0] ?? '' }}' }">

        {{-- Galeri gambar --}}
        <div>
            <div style="aspect-ratio:4/5; border-radius:16px; overflow:hidden; background:#E6E6EA;">
                @if (!empty($images))
                    <img :src="active" alt="{{ $product->name }}"
                         style="width:100%; height:100%; object-fit:cover;">
                @else
                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; padding:32px; text-align:center;">
                        <span style="font-family:var(--font-display); font-size:28px; color:var(--fg-muted);">{{ $product->name }}</span>
                    </div>
                @endif
            </div>

            @if (count($images) > 1)
                <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:10px; margin-top:12px;">
                    @foreach ($images as $img)
                        <button type="button" @click="active='{{ $img }}'"
                                style="aspect-ratio:1/1; border-radius:8px; overflow:hidden; cursor:pointer; padding:0; transition:outline .1s;"
                                :style="active === '{{ $img }}' ? 'outline:2px solid var(--fg); outline-offset:2px;' : 'outline:1px solid var(--border);'">
                            <img src="{{ $img }}" alt="" style="width:100%; height:100%; object-fit:cover;">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Info produk --}}
        <div style="position:sticky; top:100px;">
            @if ($product->category)
                <a href="{{ route('front.categories.show', $product->category->slug) }}"
                   style="font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--fg-muted); text-decoration:none;">
                    {{ $product->category->name }}
                </a>
            @endif

            <h1 style="font-family:var(--font-display); font-size:clamp(28px,3.5vw,44px); line-height:1.1; letter-spacing:-0.02em; font-weight:400; color:var(--fg); margin:8px 0 0;">
                {{ $product->name }}
            </h1>

            {{-- Rating --}}
            @if ($avgRating)
                <div style="display:flex; align-items:center; gap:8px; margin-top:10px; font-size:13px; color:var(--fg-muted);">
                    <div style="display:flex; gap:2px;">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg style="width:13px;height:13px; fill:{{ $i <= round($avgRating) ? 'var(--accent)' : 'var(--border)' }}; color:{{ $i <= round($avgRating) ? 'var(--accent)' : 'var(--border)' }};" viewBox="0 0 20 20">
                                <path d="M9.05 2.927c.3-.921 1.6-.921 1.9 0l1.286 3.957a1 1 0 00.95.69h4.16c.969 0 1.371 1.24.588 1.81l-3.366 2.446a1 1 0 00-.363 1.118l1.286 3.957c.3.921-.755 1.688-1.539 1.118l-3.366-2.446a1 1 0 00-1.176 0l-3.366 2.446c-.784.57-1.838-.197-1.539-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.567 9.384c-.783-.57-.38-1.81.588-1.81h4.16a1 1 0 00.95-.69L9.05 2.927z"/>
                            </svg>
                        @endfor
                    </div>
                    {{ number_format($avgRating, 1) }} &middot; {{ $product->reviews->count() }} ulasan
                </div>
            @endif

            {{-- Harga --}}
            <div style="display:flex; align-items:baseline; gap:12px; margin-top:20px;">
                <span style="font-size:32px; font-weight:600; font-variant-numeric:tabular-nums; color:var(--fg);">{{ \App\Support\Money::idr($finalPrice) }}</span>
                @if ($hasDiscount)
                    <span style="font-size:16px; text-decoration:line-through; color:var(--fg-muted);">{{ \App\Support\Money::idr($product->price) }}</span>
                @endif
            </div>

            @if ($product->short_description)
                <p style="font-size:15px; line-height:1.6; color:var(--fg-muted); margin-top:16px;">{{ $product->short_description }}</p>
            @endif

            {{-- Spesifikasi singkat --}}
            <dl style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:20px; font-size:13px;">
                @if ($product->material)
                    <div>
                        <dt style="font-size:11px; font-weight:600; letter-spacing:0.07em; text-transform:uppercase; color:var(--fg-muted);">Material</dt>
                        <dd style="color:var(--fg); margin-top:3px; font-weight:500;">{{ $product->material }}</dd>
                    </div>
                @endif
                @if ($product->dimensions)
                    <div>
                        <dt style="font-size:11px; font-weight:600; letter-spacing:0.07em; text-transform:uppercase; color:var(--fg-muted);">Dimensi</dt>
                        <dd style="color:var(--fg); margin-top:3px; font-weight:500;">{{ $product->dimensions }}</dd>
                    </div>
                @endif
                @if ($product->weight)
                    <div>
                        <dt style="font-size:11px; font-weight:600; letter-spacing:0.07em; text-transform:uppercase; color:var(--fg-muted);">Berat</dt>
                        <dd style="color:var(--fg); margin-top:3px; font-weight:500;">{{ rtrim(rtrim(number_format($product->weight, 2), '0'), '.') }} kg</dd>
                    </div>
                @endif
                <div>
                    <dt style="font-size:11px; font-weight:600; letter-spacing:0.07em; text-transform:uppercase; color:var(--fg-muted);">SKU</dt>
                    <dd style="color:var(--fg); margin-top:3px; font-weight:500;">{{ $product->sku }}</dd>
                </div>
            </dl>

            {{-- Stok --}}
            <div style="margin-top:16px;">
                @if ($product->stock > 0)
                    <span style="display:inline-flex; align-items:center; gap:6px; font-size:13px; color:#3F7A4E;">
                        <span style="width:7px; height:7px; border-radius:999px; background:#3F7A4E; flex-shrink:0;"></span>
                        Stok tersedia ({{ $product->stock }} unit)
                    </span>
                @else
                    <span style="display:inline-flex; align-items:center; gap:6px; font-size:13px; color:var(--fg-muted);">
                        <span style="width:7px; height:7px; border-radius:999px; background:var(--fg-muted); flex-shrink:0;"></span>
                        Stok habis — hubungi kami untuk pre-order
                    </span>
                @endif
            </div>

            {{-- Tambah ke keranjang --}}
            <form method="POST" action="{{ route('front.cart.add', $product) }}"
                  style="display:flex; flex-wrap:wrap; gap:12px; align-items:center; margin-top:24px;"
                  x-data="{ qty: 1 }">
                @csrf
                {{-- Qty stepper --}}
                <div style="display:inline-flex; align-items:center; border:1px solid var(--border); border-radius:999px; background:var(--bg-elev);">
                    <button type="button" @click="qty = Math.max(1, qty - 1)"
                            style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; background:none; border:none; cursor:pointer; font-size:18px; color:var(--fg);">−</button>
                    <input type="number" name="qty" min="1" :value="qty" x-model="qty"
                           style="width:40px; text-align:center; border:none; background:transparent; font-size:14px; font-weight:600; color:var(--fg); outline:none; font-family:var(--font-sans);">
                    <button type="button" @click="qty = qty + 1"
                            style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; background:none; border:none; cursor:pointer; font-size:18px; color:var(--fg);">+</button>
                </div>

                <button type="submit" class="btn-primary" style="flex:1; min-width:160px;">
                    Tambah ke Keranjang
                </button>
            </form>

            <div style="margin-top:10px;">
                <a href="{{ route('front.contact') }}?subject={{ urlencode('Tanya tentang ' . $product->name) }}"
                   class="btn-ghost" style="width:100%; text-align:center;">
                    Tanya Produk
                </a>
            </div>

            {{-- Trust strip --}}
            <div style="display:flex; gap:20px; margin-top:24px; padding-top:20px; border-top:1px solid var(--border); flex-wrap:wrap;">
                <div style="display:flex; gap:6px; align-items:center; font-size:12px; color:var(--fg-muted);">
                    <svg style="width:14px;height:14px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    Kayu solid pilihan
                </div>
                <div style="display:flex; gap:6px; align-items:center; font-size:12px; color:var(--fg-muted);">
                    <svg style="width:14px;height:14px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4v10l-9 4-9-4V7z"/></svg>
                    Garansi 5 tahun
                </div>
                <div style="display:flex; gap:6px; align-items:center; font-size:12px; color:var(--fg-muted);">
                    <svg style="width:14px;height:14px;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Konsultasi gratis
                </div>
            </div>
        </div>
    </div>

    {{-- Deskripsi + Varian + Ulasan --}}
    <div style="display:grid; grid-template-columns:1fr 320px; gap:40px; margin-top:64px; align-items:start;" x-data>

        <div>
            {{-- Deskripsi --}}
            <h2 style="font-family:var(--font-display); font-size:28px; letter-spacing:-0.01em; font-weight:400; color:var(--fg); margin:0 0 16px;">Deskripsi</h2>
            <div style="font-size:15px; line-height:1.7; color:var(--fg-muted);">
                {!! nl2br(e($product->description ?? $product->short_description ?? 'Produk Akha Interior dengan kualitas furniture kayu solid.')) !!}
            </div>

            {{-- Varian --}}
            @if ($product->variants->isNotEmpty())
                <h3 style="font-family:var(--font-display); font-size:22px; letter-spacing:-0.01em; font-weight:400; color:var(--fg); margin:40px 0 14px;">Varian</h3>
                <ul style="display:grid; grid-template-columns:1fr 1fr; gap:10px; list-style:none; padding:0; margin:0;">
                    @foreach ($product->variants as $v)
                        <li style="padding:12px 16px; border-radius:10px; border:1px solid var(--border); background:var(--bg-elev); display:flex; align-items:center; justify-content:space-between; font-size:13px;">
                            <span>
                                <span style="color:var(--fg-muted);">{{ $v->name }}:</span>
                                <span style="color:var(--fg); font-weight:600; margin-left:4px;">{{ $v->value }}</span>
                            </span>
                            @if ($v->price_addition > 0)
                                <span style="font-size:12px; color:var(--fg-muted);">+ {{ \App\Support\Money::idr($v->price_addition) }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif

            {{-- Ulasan --}}
            <h3 style="font-family:var(--font-display); font-size:22px; letter-spacing:-0.01em; font-weight:400; color:var(--fg); margin:40px 0 14px;">
                Ulasan ({{ $product->reviews->count() }})
            </h3>
            @if ($product->reviews->isEmpty())
                <p style="font-size:14px; color:var(--fg-muted);">Belum ada ulasan untuk produk ini.</p>
            @else
                <div style="display:flex; flex-direction:column; gap:14px;">
                    @foreach ($product->reviews as $review)
                        <div style="background:var(--bg-elev); border:1px solid var(--border); border-radius:12px; padding:20px;">
                            <div style="display:flex; align-items:center; gap:8px; margin-bottom:8px;">
                                <div style="display:flex; gap:2px;">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg style="width:13px;height:13px; fill:{{ $i <= $review->rating ? 'var(--accent)' : 'var(--border)' }};" viewBox="0 0 20 20">
                                            <path d="M9.05 2.927c.3-.921 1.6-.921 1.9 0l1.286 3.957a1 1 0 00.95.69h4.16c.969 0 1.371 1.24.588 1.81l-3.366 2.446a1 1 0 00-.363 1.118l1.286 3.957c.3.921-.755 1.688-1.539 1.118l-3.366-2.446a1 1 0 00-1.176 0l-3.366 2.446c-.784.57-1.838-.197-1.539-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.567 9.384c-.783-.57-.38-1.81.588-1.81h4.16a1 1 0 00.95-.69L9.05 2.927z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span style="font-size:13px; font-weight:600; color:var(--fg);">{{ optional($review->user)->name ?? 'Pelanggan' }}</span>
                                <span style="font-size:12px; color:var(--fg-muted);">&middot; {{ $review->created_at?->diffForHumans() }}</span>
                            </div>
                            @if ($review->review)
                                <p style="font-size:14px; line-height:1.65; color:var(--fg-muted); margin:0;">{{ $review->review }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Sidebar info --}}
        <aside style="position:sticky; top:100px; display:flex; flex-direction:column; gap:14px;">
            <div style="background:var(--bg-elev); border:1px solid var(--border); border-radius:14px; padding:22px;">
                <h4 style="font-family:var(--font-display); font-size:18px; font-weight:400; color:var(--fg); margin:0 0 10px;">Pengiriman</h4>
                <p style="font-size:13px; line-height:1.6; color:var(--fg-muted); margin:0;">Furniture dikirim dengan armada khusus untuk wilayah Jabodetabek. Untuk luar kota, akan dikoordinasikan oleh tim Akha.</p>
            </div>
            <div style="background:var(--fg); border-radius:14px; padding:22px;">
                <h4 style="font-family:var(--font-display); font-size:18px; font-weight:400; color:#FAF9F6; margin:0 0 8px;">Konsultasi gratis</h4>
                <p style="font-size:13px; line-height:1.6; color:#C8C8D0; margin:0 0 16px;">Mau pesan ukuran khusus? Tim Akha bisa bantu kustomisasi.</p>
                <a href="{{ route('front.contact') }}"
                   style="font-size:13px; font-weight:600; color:#FAF9F6; text-decoration:underline; text-underline-offset:3px;">
                    Hubungi Akha →
                </a>
            </div>
        </aside>
    </div>

    {{-- Produk terkait --}}
    @if ($related->isNotEmpty())
        <div style="margin-top:80px; padding-bottom:80px;">
            <div style="font-size:11px; letter-spacing:0.10em; text-transform:uppercase; font-weight:600; color:var(--fg-muted); margin-bottom:8px;">Produk Terkait</div>
            <h2 style="font-family:var(--font-display); font-size:clamp(24px,3vw,36px); letter-spacing:-0.02em; font-weight:400; color:var(--fg); margin:0 0 28px;">
                Mungkin juga Anda suka.
            </h2>
            <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:28px 22px;">
                @foreach ($related as $prod)
                    @include('front.partials.product-card', ['product' => $prod])
                @endforeach
            </div>
        </div>
    @endif
</div>

@endsection
