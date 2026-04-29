@extends('front.layouts.app')

@section('title', 'Kontak — Akha Interior')

@section('content')
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid lg:grid-cols-2 gap-12">
        <div>
            <p class="uppercase tracking-[0.3em] text-xs text-akha-600 mb-2">Hubungi Akha</p>
            <h1 class="font-serif-display text-3xl sm:text-4xl text-akha-900 mb-4">
                Kami senang mendengar tentang ruang Anda.
            </h1>
            <p class="text-akha-700 leading-relaxed mb-8">
                Mau bertanya tentang produk, ukuran khusus, atau jadwal pengiriman? Tinggalkan pesan di bawah dan tim Akha akan menghubungi Anda kembali — biasanya dalam 1×24 jam pada hari kerja.
            </p>

            <dl class="space-y-4 text-sm">
                <div>
                    <dt class="text-xs uppercase tracking-widest text-akha-600">Email</dt>
                    <dd class="text-akha-900 mt-1">halo@akhainterior.id</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-widest text-akha-600">WhatsApp</dt>
                    <dd class="text-akha-900 mt-1">+62 812-0000-0000</dd>
                </div>
                <div>
                    <dt class="text-xs uppercase tracking-widest text-akha-600">Showroom</dt>
                    <dd class="text-akha-900 mt-1">Senin – Sabtu, 10.00 – 18.00 WIB</dd>
                </div>
            </dl>
        </div>

        <div class="rounded-2xl bg-white ring-1 ring-akha-200 p-8">
            @if ($errors->any())
                <div class="rounded-lg bg-akha-100 ring-1 ring-akha-300 px-4 py-3 mb-4 text-sm text-akha-900">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('front.contact.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-xs uppercase tracking-widest text-akha-600 mb-1">Nama</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                           class="w-full rounded-lg border-akha-200 bg-akha-50/40 focus:border-akha-600 focus:ring-akha-600">
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-xs uppercase tracking-widest text-akha-600 mb-1">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}"
                               class="w-full rounded-lg border-akha-200 bg-akha-50/40 focus:border-akha-600 focus:ring-akha-600">
                    </div>
                    <div>
                        <label for="phone" class="block text-xs uppercase tracking-widest text-akha-600 mb-1">No. Telepon</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                               class="w-full rounded-lg border-akha-200 bg-akha-50/40 focus:border-akha-600 focus:ring-akha-600">
                    </div>
                </div>
                <div>
                    <label for="subject" class="block text-xs uppercase tracking-widest text-akha-600 mb-1">Subjek</label>
                    <input id="subject" name="subject" type="text" value="{{ old('subject', request('subject')) }}"
                           class="w-full rounded-lg border-akha-200 bg-akha-50/40 focus:border-akha-600 focus:ring-akha-600">
                </div>
                <div>
                    <label for="message" class="block text-xs uppercase tracking-widest text-akha-600 mb-1">Pesan</label>
                    <textarea id="message" name="message" rows="5" required
                              class="w-full rounded-lg border-akha-200 bg-akha-50/40 focus:border-akha-600 focus:ring-akha-600">{{ old('message') }}</textarea>
                </div>
                <button type="submit" class="inline-flex items-center px-6 py-3 rounded-full bg-akha-900 text-akha-50 font-medium hover:bg-akha-700 transition">
                    Kirim Pesan
                </button>
            </form>
        </div>
    </section>
@endsection
