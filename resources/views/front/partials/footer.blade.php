@php
    $navCategories = $navCategories ?? collect();
@endphp

<footer style="background: var(--fg); color: var(--bg); margin-top: 80px;">
    <div class="max-w-site mx-auto px-6 sm:px-8" style="padding-top: 80px; padding-bottom: 32px;">

        {{-- Main grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1fr] gap-10 lg:gap-12">

            {{-- Brand + tagline + subscribe --}}
            <div>
                <div style="font-family: var(--font-display); font-size: 22px; letter-spacing: -0.01em; color: #FAF9F6;">Akha Interior</div>
                <p style="font-family: var(--font-display); font-size: 26px; line-height: 1.15; letter-spacing: -0.01em; margin-top: 20px; max-width: 300px; color: #FAF9F6;">
                    Furniture yang menua bersama rumah Anda.
                </p>
                <p style="font-size: 13px; color: #C8C8D0; margin-top: 14px; line-height: 1.6; max-width: 300px;">
                    Kayu solid dari pengrajin lokal pilihan. Dirakit dengan teliti untuk menemani momen sehari-hari Anda selama bertahun-tahun.
                </p>

                {{-- Email subscribe --}}
                <form style="margin-top: 24px; display: flex; gap: 8px; align-items: center; background: #1C1C20; padding: 5px 5px 5px 14px; border-radius: 999px; max-width: 340px;">
                    @csrf
                    <input type="email" placeholder="Email untuk info koleksi baru"
                           style="flex:1; background:transparent; border:none; outline:none; color:#F4F3F0; font-size:13px; font-family:var(--font-sans); min-width:0;">
                    <button type="submit"
                            style="background:var(--accent); color:#FAF9F6; border:none; border-radius:999px; padding:9px 16px; font-size:13px; font-weight:600; cursor:pointer; font-family:var(--font-sans); white-space:nowrap; flex-shrink:0;">
                        Daftar
                    </button>
                </form>
            </div>

            {{-- Belanja --}}
            <div>
                <div style="font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase; font-weight: 600; color: #9A9AA6; margin-bottom: 18px;">Belanja</div>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:10px;">
                    <li><a href="{{ route('front.shop.index') }}" style="color:#E6E6EA; text-decoration:none; font-size:13.5px; transition:color .15s;" onmouseover="this.style.color='#FAF9F6'" onmouseout="this.style.color='#E6E6EA'">Semua Produk</a></li>
                    @foreach ($navCategories->take(5) as $cat)
                        <li><a href="{{ route('front.categories.show', $cat->slug) }}" style="color:#E6E6EA; text-decoration:none; font-size:13.5px;" onmouseover="this.style.color='#FAF9F6'" onmouseout="this.style.color='#E6E6EA'">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Layanan --}}
            <div>
                <div style="font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase; font-weight: 600; color: #9A9AA6; margin-bottom: 18px;">Layanan</div>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:10px;">
                    <li><a href="{{ route('front.contact') }}" style="color:#E6E6EA; text-decoration:none; font-size:13.5px;" onmouseover="this.style.color='#FAF9F6'" onmouseout="this.style.color='#E6E6EA'">Konsultasi Gratis</a></li>
                    <li><a href="{{ route('front.contact') }}" style="color:#E6E6EA; text-decoration:none; font-size:13.5px;" onmouseover="this.style.color='#FAF9F6'" onmouseout="this.style.color='#E6E6EA'">Kustomisasi Ukuran</a></li>
                    <li><a href="{{ route('front.cart.index') }}" style="color:#E6E6EA; text-decoration:none; font-size:13.5px;" onmouseover="this.style.color='#FAF9F6'" onmouseout="this.style.color='#E6E6EA'">Keranjang</a></li>
                    <li><a href="#" style="color:#E6E6EA; text-decoration:none; font-size:13.5px;" onmouseover="this.style.color='#FAF9F6'" onmouseout="this.style.color='#E6E6EA'">Pengiriman & Instalasi</a></li>
                    <li><a href="#" style="color:#E6E6EA; text-decoration:none; font-size:13.5px;" onmouseover="this.style.color='#FAF9F6'" onmouseout="this.style.color='#E6E6EA'">Garansi 5 Tahun</a></li>
                </ul>
            </div>

            {{-- Studio --}}
            <div>
                <div style="font-size: 11px; letter-spacing: 0.08em; text-transform: uppercase; font-weight: 600; color: #9A9AA6; margin-bottom: 18px;">Studio</div>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:10px;">
                    <li><a href="{{ route('front.about') }}" style="color:#E6E6EA; text-decoration:none; font-size:13.5px;" onmouseover="this.style.color='#FAF9F6'" onmouseout="this.style.color='#E6E6EA'">Tentang Akha</a></li>
                    <li><a href="{{ route('front.contact') }}" style="color:#E6E6EA; text-decoration:none; font-size:13.5px;" onmouseover="this.style.color='#FAF9F6'" onmouseout="this.style.color='#E6E6EA'">Kontak</a></li>
                    <li><a href="#" style="color:#E6E6EA; text-decoration:none; font-size:13.5px;" onmouseover="this.style.color='#FAF9F6'" onmouseout="this.style.color='#E6E6EA'">Showroom Jakarta</a></li>
                    <li><a href="#" style="color:#E6E6EA; text-decoration:none; font-size:13.5px;" onmouseover="this.style.color='#FAF9F6'" onmouseout="this.style.color='#E6E6EA'">Instagram</a></li>
                    <li><a href="#" style="color:#E6E6EA; text-decoration:none; font-size:13.5px;" onmouseover="this.style.color='#FAF9F6'" onmouseout="this.style.color='#E6E6EA'">WhatsApp</a></li>
                </ul>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div style="border-top: 1px solid #2A2A30; margin-top: 56px; padding-top: 24px; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 12px; font-size: 12px; color: #9A9AA6;">
            <span>&copy; {{ date('Y') }} Akha Interior &middot; Jakarta, Indonesia</span>
            <span style="display:flex; gap:20px;">
                <a href="#" style="color:inherit; text-decoration:none;">Kebijakan Privasi</a>
                <a href="#" style="color:inherit; text-decoration:none;">Syarat &amp; Ketentuan</a>
            </span>
        </div>
    </div>
</footer>
