@php
    /** @var \App\Models\Product $product */
    $hasDiscount = $product->discount_price && $product->discount_price < $product->price;
    $finalPrice = $hasDiscount ? $product->discount_price : $product->price;
    $discountPct = $hasDiscount ? (int) round(100 - ($product->discount_price / max($product->price, 1) * 100)) : 0;
    $img = $product->thumbnail
        ? (str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : asset('storage/' . $product->thumbnail))
        : null;
@endphp
<a href="{{ route('front.shop.show', $product->slug) }}" class="group block bg-white rounded-xl overflow-hidden ring-1 ring-akha-200 hover:ring-akha-400 hover:shadow-lg transition">
    <div class="relative aspect-[4/5] product-img-fallback overflow-hidden">
        @if ($img)
            <img src="{{ $img }}" alt="{{ $product->name }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                 onerror="this.style.display='none'">
        @else
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="font-serif-display text-akha-700 text-3xl px-4 text-center">{{ $product->name }}</span>
            </div>
        @endif

        @if ($hasDiscount)
            <span class="absolute top-3 left-3 bg-akha-900 text-akha-50 text-xs font-medium px-2.5 py-1 rounded-full">
                -{{ $discountPct }}%
            </span>
        @elseif ($product->is_featured)
            <span class="absolute top-3 left-3 bg-sage-500 text-white text-xs font-medium px-2.5 py-1 rounded-full">
                Pilihan
            </span>
        @endif
    </div>
    <div class="p-5">
        @if ($product->category)
            <p class="text-xs uppercase tracking-wider text-akha-600 mb-1">{{ $product->category->name }}</p>
        @endif
        <h3 class="font-serif-display text-lg text-akha-900 group-hover:text-akha-600 transition">{{ $product->name }}</h3>
        <div class="mt-3 flex items-end justify-between">
            <div>
                <p class="text-base font-semibold text-akha-900">{{ \App\Support\Money::idr($finalPrice) }}</p>
                @if ($hasDiscount)
                    <p class="text-xs text-akha-500 line-through">{{ \App\Support\Money::idr($product->price) }}</p>
                @endif
            </div>
            <span class="text-xs text-akha-600 group-hover:text-akha-900 transition flex items-center gap-1">
                Lihat
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </span>
        </div>
    </div>
</a>
