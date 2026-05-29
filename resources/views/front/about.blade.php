@extends('front.layouts.app')

@section('title', 'Tentang Akha Interior')

@section('content')

{{-- Hero --}}
<section style="border-bottom:1px solid var(--border); background:var(--bg-elev);">
    <div style="max-width:1100px; margin:0 auto; padding:80px 32px;">
        <div style="font-size:11px; letter-spacing:0.10em; text-transform:uppercase; font-weight:600; color:var(--fg-muted); margin-bottom:12px;">Tentang Kami</div>
        <h1 style="font-family:var(--font-display); font-size:clamp(36px,5.5vw,72px); line-height:1.0; letter-spacing:-0.025em; font-weight:400; color:var(--fg); margin:0; max-width:800px;">
            Furniture yang menua dengan anggun,<br>
            untuk rumah yang <em style="font-style:italic; color:var(--accent);">tumbuh bersama Anda.</em>
        </h1>
    </div>
</section>

{{-- Cerita --}}
<section style="max-width:1100px; margin:0 auto; padding:80px 32px 0;">
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:64px; align-items:center;">
        <div style="display:flex; flex-direction:column; gap:18px; font-size:16px; line-height:1.7; color:var(--fg-muted);">
            <p>Akha Interior lahir dari keinginan sederhana: membuat furniture kayu solid yang jujur — tidak berlebihan, tidak cepat usang, dan terasa hangat setiap kali Anda duduk atau makan di sekitarnya.</p>
            <p>Setiap produk dirancang bersama pengrajin lokal, dengan kayu yang dipilih dari sumber bersertifikat. Kami percaya pada sambungan yang rapi, finishing yang ramah lingkungan, dan bentuk yang tidak terikat tren.</p>
            <p>Kami sedang membangun katalog Akha — dari ruang makan, ruang tamu, sampai penyimpanan rumah. Terima kasih sudah singgah lebih awal.</p>

            <div style="margin-top:8px;">
                <a href="{{ route('front.shop.index') }}" class="btn-primary" style="align-self:flex-start; display:inline-flex;">
                    Jelajahi Katalog →
                </a>
            </div>
        </div>

        <div style="border-radius:16px; overflow:hidden; aspect-ratio:4/5;">
            <img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=900&q=80"
                 alt="Workshop Akha Interior" style="width:100%; height:100%; object-fit:cover;">
        </div>
    </div>
</section>

{{-- Stats --}}
<section style="max-width:1100px; margin:0 auto; padding:80px 32px 0;">
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px;">
        @php
            $stats = [
                ['n' => '15+',   'l' => 'Pengrajin lokal mitra'],
                ['n' => '100%',  'l' => 'Kayu solid bersertifikat'],
                ['n' => '5 Thn', 'l' => 'Garansi rangka produk'],
            ];
        @endphp
        @foreach ($stats as $s)
            <div style="background:var(--bg-elev); border:1px solid var(--border); border-radius:16px; padding:32px; text-align:center;">
                <div style="font-family:var(--font-display); font-size:40px; line-height:1; letter-spacing:-0.02em; color:var(--fg);">{{ $s['n'] }}</div>
                <div style="font-size:14px; color:var(--fg-muted); margin-top:8px;">{{ $s['l'] }}</div>
            </div>
        @endforeach
    </div>
</section>

{{-- Nilai --}}
<section style="max-width:1100px; margin:0 auto; padding:80px 32px 0;">
    <div style="font-size:11px; letter-spacing:0.10em; text-transform:uppercase; font-weight:600; color:var(--fg-muted); margin-bottom:12px;">Nilai Kami</div>
    <h2 style="font-family:var(--font-display); font-size:clamp(28px,4vw,48px); line-height:1.1; letter-spacing:-0.02em; font-weight:400; color:var(--fg); margin:0 0 40px;">
        Prinsip di balik setiap produk.
    </h2>

    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:20px;">
        @php
            $values = [
                ['title' => 'Kayu Pilihan', 'desc' => 'Hanya kayu solid dari sumber bersertifikat dengan finish ramah lingkungan.', 'icon' => 'M5 13l4 4L19 7'],
                ['title' => 'Dibuat Tangan', 'desc' => 'Setiap sambungan dirakit dan dihaluskan oleh pengrajin berpengalaman kami.', 'icon' => 'M3 7l9-4 9 4v10l-9 4-9-4V7z'],
                ['title' => 'Garansi 5 Tahun', 'desc' => 'Kami percaya pada kualitas yang menua dengan baik di rumah Anda.', 'icon' => 'M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['title' => 'Desain Abadi', 'desc' => 'Bentuk yang tidak terikat tren — relevan puluhan tahun ke depan.', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'],
            ];
        @endphp
        @foreach ($values as $v)
            <div style="background:var(--bg-elev); border:1px solid var(--border); border-radius:16px; padding:28px;">
                <div style="width:40px; height:40px; border-radius:999px; background:var(--fg); display:flex; align-items:center; justify-content:center; margin-bottom:16px;">
                    <svg style="width:18px;height:18px; color:#FAF9F6;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $v['icon'] }}"/>
                    </svg>
                </div>
                <h3 style="font-family:var(--font-display); font-size:20px; font-weight:400; color:var(--fg); margin:0 0 8px;">{{ $v['title'] }}</h3>
                <p style="font-size:14px; color:var(--fg-muted); line-height:1.6; margin:0;">{{ $v['desc'] }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- CTA --}}
<section style="max-width:1100px; margin:0 auto; padding:80px 32px 80px;">
    <div style="background:var(--fg); border-radius:18px; padding:64px; display:grid; grid-template-columns:1fr auto; gap:32px; align-items:center;">
        <div>
            <h2 style="font-family:var(--font-display); font-size:clamp(28px,4vw,48px); line-height:1.05; letter-spacing:-0.02em; font-weight:400; color:#FAF9F6; margin:0 0 16px;">
                Siap menemukan furniture<br>
                <em style="font-style:italic; color:#FF9D55;">yang tepat?</em>
            </h2>
            <p style="font-size:15px; color:#C8C8D0; line-height:1.6; margin:0; max-width:440px;">
                Jelajahi katalog Akha atau hubungi kami untuk konsultasi gratis tentang kebutuhan ruang Anda.
            </p>
        </div>
        <div style="display:flex; flex-direction:column; gap:12px; flex-shrink:0;">
            <a href="{{ route('front.shop.index') }}"
               style="display:flex; align-items:center; justify-content:center; padding:12px 28px; border-radius:999px; background:#FAF9F6; color:#0B0B0C; font-size:14px; font-weight:600; text-decoration:none; white-space:nowrap;">
                Lihat Katalog →
            </a>
            <a href="{{ route('front.contact') }}"
               style="display:flex; align-items:center; justify-content:center; padding:12px 28px; border-radius:999px; background:transparent; color:#F4F3F0; border:1px solid #2A2A30; font-size:14px; font-weight:600; text-decoration:none; white-space:nowrap;">
                Hubungi Kami
            </a>
        </div>
    </div>
</section>

@endsection
