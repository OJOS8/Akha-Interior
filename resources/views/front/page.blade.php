@extends('front.layouts.app')

@section('title', $page->title . ' — Akha Interior')

@section('content')
    <section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <p class="uppercase tracking-[0.3em] text-xs text-akha-600 mb-2">Akha</p>
        <h1 class="font-serif-display text-3xl sm:text-4xl text-akha-900 mb-8">{{ $page->title }}</h1>
        <article class="prose prose-stone max-w-none text-akha-800 leading-relaxed">
            {!! $page->content !!}
        </article>
    </section>
@endsection
