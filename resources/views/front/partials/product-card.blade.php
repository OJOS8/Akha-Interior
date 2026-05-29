@php
    /** @var \App\Models\Product $product */
    $hasDiscount = $product->discount_price && $product->discount_price < $product->price;
    $finalPrice  = $hasDiscount ? $product->discount_price : $product->price;
    $discountPct = $hasDiscount ? (int) round(100 - ($product->discount_price / max($product->price, 1) * 100)) : 0;
    $img = $product->thumbnail
        ? (str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : asset('storage/' . $product->thumbnail))
        : null;
@endphp

<div class="group">
    <a href="{{ route('front.shop.show', $product->slug) }}" style="display:block; text-decoration:none;">

        {{-- Image --}}
        <div style="position:relative; aspect-ratio:4/5; border-radius:12px; overflow:hidden; background:#E6E6EA;">
            @if ($img)
                <img src="{{ $img }}" alt="{{ $product->name }}"
                     style="width:100%; height:100%; object-fit:cover; transition:transform .5s;"
                     class="group-hover:scale-105"
                     onerror="this.style.display='none'">
            @else
                <div style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center; padding:16px; text-align:center;">
                    <span style="font-family:var(--font-display); font-size:18px; color:var(--fg-muted);">{{ $product->name }}</span>
                </div>
            @endif

            {{-- Badge --}}
            @if ($hasDiscount)
                <span style="position:absolute; top:12px; left:12px; background:var(--accent); color:var(--accent-fg); font-size:11px; font-weight:700; padding:4px 10px; border-radius:999px;">
                    &minus;{{ $discountPct }}%
                </span>
            @elseif ($product->is_featured)
                <span style="position:absolute; top:12px; left:12px; background:var(--fg); color:var(--bg-elev); font-size:11px; font-weight:700; padding:4px 10px; border-radius:999px;">
                    Pilihan
                </span>
            @endif
        </div>

        {{-- Info --}}
        <div style="margin-top:12px; padding:0 2px;">
            @if ($product->category)
                <p style="font-size:11px; font-weight:600; letter-spacing:0.07em; text-transform:uppercase; color:var(--fg-muted); margin-bottom:4px;">{{ $product->category->name }}</p>
            @endif
            <h3 style="font-family:var(--font-display); font-size:17px; line-height:1.25; color:var(--fg); margin:0; transition:color .15s;"
                class="group-hover:text-ember-600">{{ $product->name }}</h3>
            <div style="margin-top:8px; display:flex; align-items:baseline; gap:8px;">
                <span style="font-size:14px; font-weight:600; font-variant-numeric:tabular-nums; color:var(--fg);">{{ \App\Support\Money::idr($finalPrice) }}</span>
                @if ($hasDiscount)
                    <span style="font-size:12px; text-decoration:line-through; color:var(--fg-muted);">{{ \App\Support\Money::idr($product->price) }}</span>
                @endif
            </div>
        </div>
    </a>
</div>
