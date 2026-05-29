@extends('front.layouts.app')

@section('title', 'Kontak — Akha Interior')

@section('content')
<div style="max-width:1100px; margin:0 auto; padding:64px 32px 80px;">

    <div style="display:grid; grid-template-columns:1fr 1.2fr; gap:64px; align-items:start;">

        {{-- Info kiri --}}
        <div>
            <div style="font-size:11px; letter-spacing:0.10em; text-transform:uppercase; font-weight:600; color:var(--fg-muted); margin-bottom:12px;">Hubungi Akha</div>
            <h1 style="font-family:var(--font-display); font-size:clamp(32px,4.5vw,56px); line-height:1.05; letter-spacing:-0.02em; font-weight:400; color:var(--fg); margin:0 0 20px;">
                Kami senang mendengar tentang<br>
                <em style="font-style:italic; color:var(--accent);">ruang Anda.</em>
            </h1>
            <p style="font-size:15px; line-height:1.65; color:var(--fg-muted); margin:0 0 36px; max-width:400px;">
                Mau bertanya tentang produk, ukuran khusus, atau jadwal pengiriman? Tinggalkan pesan dan tim Akha akan menghubungi Anda kembali dalam 1×24 jam kerja.
            </p>

            <dl style="display:flex; flex-direction:column; gap:20px;">
                <div>
                    <dt style="font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--fg-muted); margin-bottom:4px;">Email</dt>
                    <dd style="font-size:15px; color:var(--fg); font-weight:500; margin:0;">halo@akhainterior.id</dd>
                </div>
                <div>
                    <dt style="font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--fg-muted); margin-bottom:4px;">WhatsApp</dt>
                    <dd style="font-size:15px; color:var(--fg); font-weight:500; margin:0;">+62 812-0000-0000</dd>
                </div>
                <div>
                    <dt style="font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--fg-muted); margin-bottom:4px;">Showroom</dt>
                    <dd style="font-size:15px; color:var(--fg); font-weight:500; margin:0 0 2px;">Jakarta Selatan</dd>
                    <dd style="font-size:13px; color:var(--fg-muted); margin:0;">Senin – Sabtu, 10.00 – 18.00 WIB</dd>
                </div>
            </dl>

            {{-- Quote --}}
            <blockquote style="font-family:var(--font-display); font-size:20px; line-height:1.3; letter-spacing:-0.01em; font-style:italic; color:var(--fg); border-left:3px solid var(--accent); padding-left:16px; margin:40px 0 0;">
                "Setiap furniture Akha lahir dari diskusi panjang tentang kebutuhan rumah Anda."
            </blockquote>
        </div>

        {{-- Form kanan --}}
        <div style="background:var(--bg-elev); border:1px solid var(--border); border-radius:18px; padding:36px;">

            @if ($errors->any())
                <div style="background:#FFF4EC; border:1px solid #FFE3CC; border-radius:10px; padding:14px 16px; margin-bottom:20px; font-size:13px; color:#8A350B;">
                    <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:4px;">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div style="background:#DDEAD8; border:1px solid #3F7A4E; border-radius:10px; padding:14px 16px; margin-bottom:20px; font-size:13px; color:#2D6248;">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('front.contact.store') }}" style="display:flex; flex-direction:column; gap:18px;">
                @csrf

                <div>
                    <label for="name" style="display:block; font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--fg-muted); margin-bottom:6px;">Nama *</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                           style="width:100%; border:1px solid var(--border); border-radius:8px; background:var(--bg); padding:10px 14px; font-size:14px; color:var(--fg); font-family:var(--font-sans); outline:none; box-sizing:border-box; transition:border-color .15s;"
                           onfocus="this.style.borderColor='var(--fg)'" onblur="this.style.borderColor='var(--border)'">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                    <div>
                        <label for="email" style="display:block; font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--fg-muted); margin-bottom:6px;">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}"
                               style="width:100%; border:1px solid var(--border); border-radius:8px; background:var(--bg); padding:10px 14px; font-size:14px; color:var(--fg); font-family:var(--font-sans); outline:none; box-sizing:border-box;"
                               onfocus="this.style.borderColor='var(--fg)'" onblur="this.style.borderColor='var(--border)'">
                    </div>
                    <div>
                        <label for="phone" style="display:block; font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--fg-muted); margin-bottom:6px;">No. Telepon</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                               style="width:100%; border:1px solid var(--border); border-radius:8px; background:var(--bg); padding:10px 14px; font-size:14px; color:var(--fg); font-family:var(--font-sans); outline:none; box-sizing:border-box;"
                               onfocus="this.style.borderColor='var(--fg)'" onblur="this.style.borderColor='var(--border)'">
                    </div>
                </div>

                <div>
                    <label for="subject" style="display:block; font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--fg-muted); margin-bottom:6px;">Subjek</label>
                    <input id="subject" name="subject" type="text" value="{{ old('subject', request('subject')) }}"
                           style="width:100%; border:1px solid var(--border); border-radius:8px; background:var(--bg); padding:10px 14px; font-size:14px; color:var(--fg); font-family:var(--font-sans); outline:none; box-sizing:border-box;"
                           onfocus="this.style.borderColor='var(--fg)'" onblur="this.style.borderColor='var(--border)'">
                </div>

                <div>
                    <label for="message" style="display:block; font-size:11px; font-weight:600; letter-spacing:0.08em; text-transform:uppercase; color:var(--fg-muted); margin-bottom:6px;">Pesan *</label>
                    <textarea id="message" name="message" rows="5" required
                              style="width:100%; border:1px solid var(--border); border-radius:8px; background:var(--bg); padding:10px 14px; font-size:14px; color:var(--fg); font-family:var(--font-sans); outline:none; box-sizing:border-box; resize:vertical; transition:border-color .15s;"
                              onfocus="this.style.borderColor='var(--fg)'" onblur="this.style.borderColor='var(--border)'">{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="btn-primary" style="align-self:flex-start; padding:12px 32px;">
                    Kirim Pesan →
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
