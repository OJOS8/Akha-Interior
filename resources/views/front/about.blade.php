@extends('front.layouts.app')

@section('title', 'Tentang Akha Interior')

@section('content')
    <section class="bg-akha-100/60 border-b border-akha-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <p class="uppercase tracking-[0.3em] text-xs text-akha-600 mb-2">Tentang Kami</p>
            <h1 class="font-serif-display text-4xl sm:text-5xl text-akha-900 leading-tight">
                Furniture yang menua dengan anggun, untuk rumah yang tumbuh bersama Anda.
            </h1>
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid md:grid-cols-2 gap-10 items-start">
        <div class="space-y-5 text-akha-800 leading-relaxed">
            <p>Akha Interior lahir dari keinginan sederhana: membuat furniture kayu solid yang jujur — tidak berlebihan, tidak cepat usang, dan terasa hangat setiap kali Anda duduk atau makan di sekitarnya.</p>
            <p>Setiap produk dirancang bersama pengrajin lokal, dengan kayu yang dipilih dari sumber bersertifikat. Kami percaya pada sambungan yang rapi, finishing yang ramah lingkungan, dan bentuk yang tidak terikat tren.</p>
            <p>Kami sedang membangun katalog Akha — dari ruang makan, ruang tamu, sampai penyimpanan rumah. Terima kasih sudah singgah lebih awal.</p>
        </div>
        <div class="rounded-2xl overflow-hidden">
            <img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=900&q=80" alt="Akha Interior" class="w-full h-full object-cover">
        </div>
    </section>

    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 grid md:grid-cols-3 gap-6">
        @php
            $stats = [
                ['n' => '15+', 'l' => 'Pengrajin lokal'],
                ['n' => '100%', 'l' => 'Kayu solid bersertifikat'],
                ['n' => '5 Tahun', 'l' => 'Garansi rangka'],
            ];
        @endphp
        @foreach ($stats as $s)
            <div class="p-8 rounded-2xl bg-white ring-1 ring-akha-200 text-center">
                <p class="font-serif-display text-3xl text-akha-900">{{ $s['n'] }}</p>
                <p class="text-sm text-akha-700 mt-1">{{ $s['l'] }}</p>
            </div>
        @endforeach
    </section>
@endsection
