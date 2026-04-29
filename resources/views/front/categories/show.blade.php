@extends('front.layouts.app')

@section('title', $category->name . ' — Akha Interior')

@section('content')
    <section class="bg-akha-100/60 border-b border-akha-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <p class="uppercase tracking-[0.3em] text-xs text-akha-600 mb-2">Kategori</p>
            <h1 class="font-serif-display text-3xl sm:text-4xl text-akha-900">{{ $category->name }}</h1>
            @if ($category->description)
                <p class="mt-3 text-akha-700 max-w-2xl">{{ $category->description }}</p>
            @endif
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if ($products->isEmpty())
            <div class="rounded-2xl bg-white ring-1 ring-akha-200 p-12 text-center">
                <p class="font-serif-display text-2xl text-akha-900 mb-2">Belum ada produk di kategori ini</p>
                <a href="{{ route('front.shop.index') }}" class="inline-flex items-center mt-4 px-5 py-2.5 rounded-full bg-akha-900 text-akha-50 text-sm font-medium hover:bg-akha-700">
                    Lihat semua produk
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    @include('front.partials.product-card', ['product' => $product])
                @endforeach
            </div>
            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @endif
    </section>
@endsection
