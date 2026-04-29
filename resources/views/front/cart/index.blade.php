@extends('front.layouts.app')

@section('title', 'Keranjang Belanja — Akha Interior')

@section('content')
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="font-serif-display text-3xl sm:text-4xl text-akha-900 mb-8">Keranjang Belanja</h1>

        @if (empty($items))
            <div class="rounded-2xl bg-white ring-1 ring-akha-200 p-12 text-center">
                <p class="font-serif-display text-2xl text-akha-900 mb-2">Keranjang masih kosong</p>
                <p class="text-akha-700 mb-6">Mulai jelajahi koleksi furniture Akha untuk ruang Anda.</p>
                <a href="{{ route('front.shop.index') }}" class="inline-flex items-center px-6 py-3 rounded-full bg-akha-900 text-akha-50 font-medium hover:bg-akha-700 transition">
                    Lihat Katalog
                </a>
            </div>
        @else
            <div class="grid lg:grid-cols-[1fr_360px] gap-10">
                <div class="rounded-2xl bg-white ring-1 ring-akha-200 divide-y divide-akha-200">
                    @foreach ($items as $row)
                        @php
                            /** @var \App\Models\Product $p */
                            $p = $row['product'];
                            $img = $p->thumbnail
                                ? (str_starts_with($p->thumbnail, 'http') ? $p->thumbnail : asset('storage/' . $p->thumbnail))
                                : null;
                        @endphp
                        <div class="p-5 flex gap-5 items-center">
                            <a href="{{ route('front.shop.show', $p->slug) }}" class="w-24 h-24 rounded-xl overflow-hidden product-img-fallback shrink-0">
                                @if ($img)
                                    <img src="{{ $img }}" alt="{{ $p->name }}" class="w-full h-full object-cover">
                                @endif
                            </a>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('front.shop.show', $p->slug) }}" class="font-serif-display text-lg text-akha-900 hover:text-akha-600">{{ $p->name }}</a>
                                @if ($p->category)
                                    <p class="text-xs uppercase tracking-widest text-akha-600 mt-1">{{ $p->category->name }}</p>
                                @endif
                                <p class="text-sm text-akha-700 mt-1">{{ \App\Support\Money::idr($row['price']) }} / unit</p>
                            </div>
                            <form method="POST" action="{{ route('front.cart.update', $p) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="qty" min="0" value="{{ $row['qty'] }}"
                                       class="w-16 rounded-full border-akha-200 bg-white text-sm text-center focus:border-akha-600 focus:ring-akha-600">
                                <button type="submit" class="text-xs text-akha-700 hover:text-akha-900 underline underline-offset-4">Update</button>
                            </form>
                            <p class="w-28 text-right font-medium text-akha-900">{{ \App\Support\Money::idr($row['subtotal']) }}</p>
                            <form method="POST" action="{{ route('front.cart.remove', $p) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-akha-500 hover:text-akha-900" aria-label="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <aside class="rounded-2xl bg-akha-900 text-akha-100 p-6 h-fit">
                    <h2 class="font-serif-display text-xl text-akha-50 mb-4">Ringkasan</h2>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-akha-200">Subtotal</dt>
                            <dd class="text-akha-50 font-medium">{{ \App\Support\Money::idr($subtotal) }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-akha-200">Ongkir</dt>
                            <dd class="text-akha-300">Dihitung saat checkout</dd>
                        </div>
                    </dl>
                    <div class="border-t border-akha-700 mt-4 pt-4 flex justify-between text-base">
                        <span class="text-akha-100">Total</span>
                        <span class="text-akha-50 font-semibold">{{ \App\Support\Money::idr($subtotal) }}</span>
                    </div>
                    <a href="{{ route('front.contact') }}?subject={{ urlencode('Checkout pesanan saya') }}"
                       class="mt-6 inline-flex w-full items-center justify-center px-5 py-3 rounded-full bg-akha-50 text-akha-900 font-medium hover:bg-akha-100 transition">
                        Lanjut ke Checkout
                    </a>
                    <a href="{{ route('front.shop.index') }}" class="mt-3 inline-flex w-full items-center justify-center text-sm text-akha-200 hover:text-akha-50">
                        Lanjut belanja
                    </a>
                    <form method="POST" action="{{ route('front.cart.clear') }}" class="mt-3 text-center">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-akha-300 hover:text-akha-100 underline underline-offset-4">Kosongkan keranjang</button>
                    </form>
                </aside>
            </div>
        @endif
    </section>
@endsection
