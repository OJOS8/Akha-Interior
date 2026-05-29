@extends('front.layouts.app')

@section('title', 'Keranjang Belanja — Akha Interior')

@section('content')
<div style="max-width:1100px; margin:0 auto; padding:48px 32px 80px;">

    <div style="margin-bottom:32px;">
        <div style="font-size:11px; letter-spacing:0.10em; text-transform:uppercase; font-weight:600; color:var(--fg-muted); margin-bottom:8px;">Keranjang Anda</div>
        <h1 style="font-family:var(--font-display); font-size:clamp(28px,4vw,48px); line-height:1.0; letter-spacing:-0.02em; font-weight:400; color:var(--fg); margin:0;">
            @if (!empty($items))
                {{ array_sum(array_column($items, 'qty')) }} {{ array_sum(array_column($items, 'qty')) === 1 ? 'barang' : 'barang' }} di keranjang.
            @else
                Keranjang masih kosong.
            @endif
        </h1>
    </div>

    @if (empty($items))
        {{-- Empty state --}}
        <div style="background:var(--bg-elev); border:1px solid var(--border); border-radius:18px; padding:72px 32px; text-align:center; max-width:480px; margin:0 auto;">
            <div style="width:56px; height:56px; border-radius:999px; background:var(--bg-sunken); display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
                <svg style="width:24px;height:24px; color:var(--fg-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"/>
                </svg>
            </div>
            <p style="font-size:14px; color:var(--fg-muted); line-height:1.6; margin:0 0 24px;">
                Mulai jelajahi koleksi furniture Akha dan temukan yang cocok untuk ruang Anda.
            </p>
            <a href="{{ route('front.shop.index') }}" class="btn-primary">
                Lihat Katalog →
            </a>
        </div>

    @else
        <div style="display:grid; grid-template-columns:1fr 340px; gap:32px; align-items:start;">

            {{-- Items --}}
            <div style="background:var(--bg-elev); border:1px solid var(--border); border-radius:16px; overflow:hidden;">
                @foreach ($items as $row)
                    @php
                        /** @var \App\Models\Product $p */
                        $p   = $row['product'];
                        $img = $p->thumbnail
                            ? (str_starts_with($p->thumbnail, 'http') ? $p->thumbnail : asset('storage/' . $p->thumbnail))
                            : null;
                    @endphp
                    <div style="display:grid; grid-template-columns:88px 1fr auto auto auto; gap:16px; align-items:center; padding:20px 24px; border-bottom:1px solid var(--border);">
                        {{-- Thumbnail --}}
                        <a href="{{ route('front.shop.show', $p->slug) }}"
                           style="display:block; border-radius:10px; overflow:hidden; background:#E6E6EA; aspect-ratio:1/1;">
                            @if ($img)
                                <img src="{{ $img }}" alt="{{ $p->name }}" style="width:100%; height:100%; object-fit:cover;">
                            @endif
                        </a>

                        {{-- Info --}}
                        <div style="min-width:0;">
                            @if ($p->category)
                                <div style="font-size:10px; font-weight:600; letter-spacing:0.07em; text-transform:uppercase; color:var(--fg-muted);">{{ $p->category->name }}</div>
                            @endif
                            <a href="{{ route('front.shop.show', $p->slug) }}"
                               style="display:block; font-family:var(--font-display); font-size:17px; color:var(--fg); text-decoration:none; margin-top:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"
                               onmouseover="this.style.color='var(--accent)'" onmouseout="this.style.color='var(--fg)'">
                                {{ $p->name }}
                            </a>
                            <div style="font-size:13px; color:var(--fg-muted); margin-top:2px;">{{ \App\Support\Money::idr($row['price']) }} / unit</div>
                        </div>

                        {{-- Qty update --}}
                        <form method="POST" action="{{ route('front.cart.update', $p) }}" style="display:flex; align-items:center; gap:6px;">
                            @csrf
                            @method('PATCH')
                            <div style="display:inline-flex; align-items:center; border:1px solid var(--border); border-radius:999px; background:var(--bg);">
                                <button type="button" onclick="let i=this.parentElement.querySelector('input'); i.value=Math.max(0,parseInt(i.value)-1)"
                                        style="width:30px; height:30px; border:none; background:none; cursor:pointer; font-size:16px; color:var(--fg); display:flex; align-items:center; justify-content:center;">−</button>
                                <input type="number" name="qty" min="0" value="{{ $row['qty'] }}"
                                       style="width:36px; text-align:center; border:none; background:transparent; font-size:13px; font-weight:600; color:var(--fg); font-family:var(--font-sans); outline:none; padding:0;">
                                <button type="button" onclick="let i=this.parentElement.querySelector('input'); i.value=parseInt(i.value)+1"
                                        style="width:30px; height:30px; border:none; background:none; cursor:pointer; font-size:16px; color:var(--fg); display:flex; align-items:center; justify-content:center;">+</button>
                            </div>
                            <button type="submit"
                                    style="font-size:12px; font-weight:600; color:var(--fg-muted); background:none; border:none; cursor:pointer; text-decoration:underline; text-underline-offset:2px; font-family:var(--font-sans);">
                                Update
                            </button>
                        </form>

                        {{-- Subtotal --}}
                        <span style="font-size:14px; font-weight:600; font-variant-numeric:tabular-nums; color:var(--fg); white-space:nowrap;">
                            {{ \App\Support\Money::idr($row['subtotal']) }}
                        </span>

                        {{-- Hapus --}}
                        <form method="POST" action="{{ route('front.cart.remove', $p) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    style="width:30px; height:30px; border:none; background:none; cursor:pointer; color:var(--fg-muted); display:flex; align-items:center; justify-content:center; border-radius:999px; transition:color .15s; transition:background .15s;"
                                    onmouseover="this.style.color='var(--fg)'; this.style.background='var(--bg-sunken)'" onmouseout="this.style.color='var(--fg-muted)'; this.style.background='none'"
                                    aria-label="Hapus">
                                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach

                {{-- Kosongkan keranjang --}}
                <div style="padding:14px 24px; display:flex; justify-content:flex-end;">
                    <form method="POST" action="{{ route('front.cart.clear') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                style="font-size:12px; color:var(--fg-muted); background:none; border:none; cursor:pointer; text-decoration:underline; text-underline-offset:2px; font-family:var(--font-sans);">
                            Kosongkan keranjang
                        </button>
                    </form>
                </div>
            </div>

            {{-- Ringkasan --}}
            <aside style="background:var(--fg); border-radius:16px; padding:28px; position:sticky; top:100px;">
                <h2 style="font-family:var(--font-display); font-size:20px; font-weight:400; color:#FAF9F6; margin:0 0 20px;">Ringkasan Pesanan</h2>

                <dl style="display:flex; flex-direction:column; gap:10px; font-size:14px;">
                    <div style="display:flex; justify-content:space-between; color:#C8C8D0;">
                        <dt>Subtotal</dt>
                        <dd style="font-variant-numeric:tabular-nums; color:#F4F3F0; font-weight:600;">{{ \App\Support\Money::idr($subtotal) }}</dd>
                    </div>
                    <div style="display:flex; justify-content:space-between; color:#C8C8D0;">
                        <dt>Ongkir</dt>
                        <dd style="color:#9A9AA6;">Dihitung saat checkout</dd>
                    </div>
                </dl>

                <div style="border-top:1px solid #2A2A30; margin:16px 0; padding-top:16px; display:flex; justify-content:space-between; align-items:baseline;">
                    <span style="font-size:14px; font-weight:600; color:#F4F3F0;">Total</span>
                    <span style="font-size:22px; font-weight:600; font-variant-numeric:tabular-nums; color:#FAF9F6;">{{ \App\Support\Money::idr($subtotal) }}</span>
                </div>

                <a href="{{ route('front.contact') }}?subject={{ urlencode('Checkout pesanan saya') }}"
                   style="display:flex; align-items:center; justify-content:center; width:100%; padding:14px; border-radius:999px; background:#FAF9F6; color:#0B0B0C; font-size:14px; font-weight:600; text-decoration:none; margin-top:4px; box-sizing:border-box;">
                    Lanjut ke Checkout →
                </a>
                <a href="{{ route('front.shop.index') }}"
                   style="display:block; text-align:center; margin-top:10px; font-size:13px; color:#9A9AA6; text-decoration:none;"
                   onmouseover="this.style.color='#F4F3F0'" onmouseout="this.style.color='#9A9AA6'">
                    Lanjut belanja
                </a>
            </aside>
        </div>
    @endif
</div>
@endsection
