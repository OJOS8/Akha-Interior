@extends('front.layouts.app')

@section('title', $product->name . ' — Akha Interior')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($product->short_description ?? $product->description), 150))

@section('content')
    @php
        $hasDiscount = $product->discount_price && $product->discount_price < $product->price;
        $finalPrice = $hasDiscount ? $product->discount_price : $product->price;
        $thumbnail = $product->thumbnail
            ? (str_starts_with($product->thumbnail, 'http') ? $product->thumbnail : asset('storage/' . $product->thumbnail))
            : null;
        $images = $product->images->map(fn ($i) => str_starts_with($i->image, 'http') ? $i->image : asset('storage/' . $i->image))->all();
        if ($thumbnail) {
            array_unshift($images, $thumbnail);
        }
        $images = array_values(array_unique($images));
        $avgRating = $product->reviews->avg('rating');
    @endphp

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <nav class="text-xs text-akha-600 mb-6 flex items-center gap-2">
            <a href="{{ route('front.home') }}" class="hover:text-akha-900">Beranda</a>
            <span>/</span>
            <a href="{{ route('front.shop.index') }}" class="hover:text-akha-900">Katalog</a>
            @if ($product->category)
                <span>/</span>
                <a href="{{ route('front.categories.show', $product->category->slug) }}" class="hover:text-akha-900">{{ $product->category->name }}</a>
            @endif
            <span>/</span>
            <span class="text-akha-900">{{ $product->name }}</span>
        </nav>

        <div class="grid lg:grid-cols-2 gap-12">
            <div x-data="{ active: '{{ $images[0] ?? '' }}' }">
                <div class="aspect-[4/5] rounded-2xl overflow-hidden product-img-fallback">
                    @if (! empty($images))
                        <img :src="active" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="font-serif-display text-akha-700 text-3xl px-4 text-center">{{ $product->name }}</span>
                        </div>
                    @endif
                </div>
                @if (count($images) > 1)
                    <div class="grid grid-cols-5 gap-3 mt-4">
                        @foreach ($images as $img)
                            <button type="button" @click="active='{{ $img }}'"
                                    class="aspect-square rounded-lg overflow-hidden ring-1 ring-akha-200"
                                    :class="active === '{{ $img }}' ? 'ring-2 ring-akha-700' : ''">
                                <img src="{{ $img }}" alt="" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                @if ($product->category)
                    <a href="{{ route('front.categories.show', $product->category->slug) }}" class="text-xs uppercase tracking-widest text-akha-600 hover:text-akha-900">{{ $product->category->name }}</a>
                @endif
                <h1 class="font-serif-display text-3xl sm:text-4xl text-akha-900 mt-2 mb-3">{{ $product->name }}</h1>

                @if ($avgRating)
                    <div class="flex items-center gap-2 mb-4 text-akha-700 text-sm">
                        <div class="flex items-center text-akha-700">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'text-akha-600' : 'text-akha-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.05 2.927c.3-.921 1.6-.921 1.9 0l1.286 3.957a1 1 0 00.95.69h4.16c.969 0 1.371 1.24.588 1.81l-3.366 2.446a1 1 0 00-.363 1.118l1.286 3.957c.3.921-.755 1.688-1.539 1.118l-3.366-2.446a1 1 0 00-1.176 0l-3.366 2.446c-.784.57-1.838-.197-1.539-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.567 9.384c-.783-.57-.38-1.81.588-1.81h4.16a1 1 0 00.95-.69L9.05 2.927z"/></svg>
                            @endfor
                        </div>
                        <span>{{ number_format($avgRating, 1) }} dari {{ $product->reviews->count() }} ulasan</span>
                    </div>
                @endif

                <div class="flex items-baseline gap-3 mb-6">
                    <span class="text-3xl font-semibold text-akha-900">{{ \App\Support\Money::idr($finalPrice) }}</span>
                    @if ($hasDiscount)
                        <span class="text-base text-akha-500 line-through">{{ \App\Support\Money::idr($product->price) }}</span>
                    @endif
                </div>

                @if ($product->short_description)
                    <p class="text-akha-700 leading-relaxed mb-6">{{ $product->short_description }}</p>
                @endif

                <dl class="grid grid-cols-2 gap-4 text-sm mb-8">
                    @if ($product->material)
                        <div>
                            <dt class="text-xs uppercase tracking-widest text-akha-600">Material</dt>
                            <dd class="text-akha-900 mt-1">{{ $product->material }}</dd>
                        </div>
                    @endif
                    @if ($product->dimensions)
                        <div>
                            <dt class="text-xs uppercase tracking-widest text-akha-600">Dimensi</dt>
                            <dd class="text-akha-900 mt-1">{{ $product->dimensions }}</dd>
                        </div>
                    @endif
                    @if ($product->weight)
                        <div>
                            <dt class="text-xs uppercase tracking-widest text-akha-600">Berat</dt>
                            <dd class="text-akha-900 mt-1">{{ rtrim(rtrim(number_format($product->weight, 2), '0'), '.') }} kg</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-xs uppercase tracking-widest text-akha-600">SKU</dt>
                        <dd class="text-akha-900 mt-1">{{ $product->sku }}</dd>
                    </div>
                </dl>

                <p class="text-sm mb-4">
                    @if ($product->stock > 0)
                        <span class="inline-flex items-center gap-1.5 text-sage-700">
                            <span class="w-2 h-2 rounded-full bg-sage-500"></span>
                            Stok tersedia ({{ $product->stock }} unit)
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-akha-600">
                            <span class="w-2 h-2 rounded-full bg-akha-500"></span>
                            Stok habis — hubungi kami untuk pre-order
                        </span>
                    @endif
                </p>

                <form method="POST" action="{{ route('front.cart.add', $product) }}" class="flex flex-wrap items-center gap-4 mb-8">
                    @csrf
                    <div class="inline-flex items-center rounded-full ring-1 ring-akha-300 bg-white" x-data="{ qty: 1 }">
                        <button type="button" @click="qty = Math.max(1, qty - 1)" class="w-10 h-10 flex items-center justify-center text-akha-700 hover:text-akha-900">−</button>
                        <input type="number" name="qty" min="1" :value="qty" x-model="qty" class="w-12 text-center border-0 bg-transparent focus:ring-0 text-sm">
                        <button type="button" @click="qty = qty + 1" class="w-10 h-10 flex items-center justify-center text-akha-700 hover:text-akha-900">+</button>
                    </div>
                    <button type="submit" class="inline-flex items-center px-7 py-3 rounded-full bg-akha-900 text-akha-50 font-medium hover:bg-akha-700 transition">
                        Tambah ke Keranjang
                    </button>
                    <a href="{{ route('front.contact') }}?subject={{ urlencode('Tanya tentang ' . $product->name) }}"
                       class="inline-flex items-center px-5 py-3 rounded-full ring-1 ring-akha-300 text-akha-900 font-medium hover:bg-akha-100 transition">
                        Tanya Produk
                    </a>
                </form>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="mt-16 grid lg:grid-cols-3 gap-10">
            <div class="lg:col-span-2">
                <h2 class="font-serif-display text-2xl text-akha-900 mb-4">Deskripsi</h2>
                <div class="prose prose-stone max-w-none text-akha-800">
                    {!! nl2br(e($product->description ?? $product->short_description ?? 'Produk Akha Interior dengan kualitas furniture kayu solid yang dirakit dan dihaluskan tangan pengrajin.')) !!}
                </div>

                @if ($product->variants->isNotEmpty())
                    <h3 class="font-serif-display text-xl text-akha-900 mt-10 mb-4">Varian</h3>
                    <ul class="grid sm:grid-cols-2 gap-3 text-sm">
                        @foreach ($product->variants as $v)
                            <li class="px-4 py-3 rounded-lg ring-1 ring-akha-200 bg-white flex items-center justify-between">
                                <span><span class="text-akha-600">{{ $v->name }}:</span> <span class="text-akha-900 font-medium">{{ $v->value }}</span></span>
                                @if ($v->price_addition > 0)
                                    <span class="text-xs text-akha-700">+ {{ \App\Support\Money::idr($v->price_addition) }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif

                <h3 class="font-serif-display text-xl text-akha-900 mt-12 mb-4">Ulasan ({{ $product->reviews->count() }})</h3>
                @if ($product->reviews->isEmpty())
                    <p class="text-sm text-akha-700">Belum ada ulasan untuk produk ini.</p>
                @else
                    <div class="space-y-6">
                        @foreach ($product->reviews as $review)
                            <div class="p-5 rounded-xl bg-white ring-1 ring-akha-200">
                                <div class="flex items-center gap-2 mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-akha-600' : 'text-akha-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.05 2.927c.3-.921 1.6-.921 1.9 0l1.286 3.957a1 1 0 00.95.69h4.16c.969 0 1.371 1.24.588 1.81l-3.366 2.446a1 1 0 00-.363 1.118l1.286 3.957c.3.921-.755 1.688-1.539 1.118l-3.366-2.446a1 1 0 00-1.176 0l-3.366 2.446c-.784.57-1.838-.197-1.539-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.567 9.384c-.783-.57-.38-1.81.588-1.81h4.16a1 1 0 00.95-.69L9.05 2.927z"/></svg>
                                    @endfor
                                    <span class="text-sm text-akha-700 ml-1">{{ optional($review->user)->name ?? 'Pelanggan' }}</span>
                                    <span class="text-xs text-akha-500">· {{ $review->created_at?->diffForHumans() }}</span>
                                </div>
                                @if ($review->review)
                                    <p class="text-akha-800 text-sm leading-relaxed">{{ $review->review }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <aside class="space-y-4 text-sm">
                <div class="p-6 rounded-2xl bg-white ring-1 ring-akha-200">
                    <h4 class="font-serif-display text-lg text-akha-900 mb-3">Pengiriman</h4>
                    <p class="text-akha-700 leading-relaxed">Furniture dikirim dengan armada khusus untuk wilayah Jabodetabek. Untuk luar kota, akan dikoordinasikan oleh tim Akha.</p>
                </div>
                <div class="p-6 rounded-2xl bg-akha-900 text-akha-100">
                    <h4 class="font-serif-display text-lg text-akha-50 mb-2">Konsultasi gratis</h4>
                    <p class="text-akha-200/90 leading-relaxed mb-4">Mau pesan ukuran khusus? Tim Akha bisa bantu kustomisasi.</p>
                    <a href="{{ route('front.contact') }}" class="inline-flex text-sm font-medium underline underline-offset-4">Hubungi Akha →</a>
                </div>
            </aside>
        </div>

        {{-- Related --}}
        @if ($related->isNotEmpty())
            <div class="mt-20">
                <h2 class="font-serif-display text-2xl sm:text-3xl text-akha-900 mb-8">Mungkin juga Anda suka</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($related as $product)
                        @include('front.partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
