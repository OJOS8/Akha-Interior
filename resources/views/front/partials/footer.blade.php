@php
    $navCategories = $navCategories ?? collect();
@endphp
<footer class="bg-akha-900 text-akha-100 mt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid gap-10 md:grid-cols-4">
        <div class="md:col-span-2">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-9 h-9 rounded-full bg-akha-50 text-akha-900 flex items-center justify-center font-serif-display text-lg">A</span>
                <span class="font-serif-display text-xl">Akha Interior</span>
            </div>
            <p class="text-sm text-akha-200/80 max-w-md leading-relaxed">
                Furniture kayu solid dengan desain bersih dan hangat untuk rumah modern Indonesia.
                Dirancang dan dikerjakan dengan teliti, untuk teman seumur hidup ruang Anda.
            </p>
            <div class="flex items-center gap-3 mt-6">
                <a href="#" aria-label="Instagram" class="w-9 h-9 rounded-full border border-akha-700 hover:bg-akha-700 inline-flex items-center justify-center">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.2c3.2 0 3.6 0 4.8.1 1.2.1 1.9.2 2.3.4.6.2 1 .5 1.5 1s.7.9 1 1.5c.2.4.4 1.1.4 2.3.1 1.2.1 1.6.1 4.8s0 3.6-.1 4.8c-.1 1.2-.2 1.9-.4 2.3-.2.6-.5 1-1 1.5s-.9.7-1.5 1c-.4.2-1.1.4-2.3.4-1.2.1-1.6.1-4.8.1s-3.6 0-4.8-.1c-1.2-.1-1.9-.2-2.3-.4-.6-.2-1-.5-1.5-1s-.7-.9-1-1.5c-.2-.4-.4-1.1-.4-2.3-.1-1.2-.1-1.6-.1-4.8s0-3.6.1-4.8c.1-1.2.2-1.9.4-2.3.2-.6.5-1 1-1.5s.9-.7 1.5-1c.4-.2 1.1-.4 2.3-.4 1.2-.1 1.6-.1 4.8-.1zM12 0C8.7 0 8.3 0 7.1.1 5.8.1 5 .3 4.3.6c-.7.3-1.4.7-2 1.3s-1 1.3-1.3 2c-.3.7-.5 1.5-.5 2.8C.4 8.3.4 8.7.4 12s0 3.7.1 5c.1 1.3.3 2.1.6 2.8.3.7.7 1.4 1.3 2s1.3 1 2 1.3c.7.3 1.5.5 2.8.6 1.2.1 1.6.1 4.9.1s3.7 0 5-.1c1.3-.1 2.1-.3 2.8-.6.7-.3 1.4-.7 2-1.3s1-1.3 1.3-2c.3-.7.5-1.5.6-2.8.1-1.2.1-1.6.1-4.9s0-3.7-.1-5c-.1-1.3-.3-2.1-.6-2.8-.3-.7-.7-1.4-1.3-2s-1.3-1-2-1.3c-.7-.3-1.5-.5-2.8-.6C15.7 0 15.3 0 12 0zm0 5.8a6.2 6.2 0 100 12.4 6.2 6.2 0 000-12.4zm0 10.2a4 4 0 110-8 4 4 0 010 8zm6.4-10.4a1.4 1.4 0 11-2.9 0 1.4 1.4 0 012.9 0z"/></svg>
                </a>
                <a href="#" aria-label="WhatsApp" class="w-9 h-9 rounded-full border border-akha-700 hover:bg-akha-700 inline-flex items-center justify-center">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.5 3.5A11.8 11.8 0 0012 0C5.4 0 .1 5.3.1 11.9c0 2.1.5 4.2 1.6 6L0 24l6.3-1.6c1.7.9 3.7 1.4 5.7 1.4 6.6 0 11.9-5.3 11.9-11.9 0-3.2-1.2-6.2-3.4-8.4zM12 21.8c-1.8 0-3.6-.5-5.1-1.4l-.4-.2-3.7 1 1-3.6-.2-.4a9.8 9.8 0 01-1.5-5.3c0-5.5 4.5-9.9 9.9-9.9 2.6 0 5.1 1 7 2.9a9.9 9.9 0 012.9 7c0 5.5-4.5 9.9-9.9 9.9zm5.4-7.4c-.3-.2-1.7-.9-2-1s-.5-.2-.7.1c-.2.3-.8 1-1 1.2-.2.2-.4.2-.7.1-.3-.1-1.3-.5-2.5-1.5-.9-.8-1.5-1.8-1.7-2.1-.2-.3 0-.5.1-.7l.4-.5c.1-.2.2-.3.3-.5.1-.2 0-.4 0-.5l-.7-1.7c-.2-.4-.4-.4-.5-.4h-.5c-.2 0-.5.1-.7.3-.3.3-1 1-1 2.4s1 2.8 1.1 3c.1.2 2.1 3.2 5 4.5 1.7.7 2.4.8 3.3.7.5-.1 1.7-.7 1.9-1.4.2-.7.2-1.3.2-1.4-.1-.1-.3-.2-.6-.3z"/></svg>
                </a>
            </div>
        </div>

        <div>
            <h4 class="font-serif-display text-base mb-4">Belanja</h4>
            <ul class="space-y-2 text-sm text-akha-200/80">
                <li><a href="{{ route('front.shop.index') }}" class="hover:text-akha-50">Semua Produk</a></li>
                @foreach ($navCategories->take(5) as $cat)
                    <li><a href="{{ route('front.categories.show', $cat->slug) }}" class="hover:text-akha-50">{{ $cat->name }}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            <h4 class="font-serif-display text-base mb-4">Akha</h4>
            <ul class="space-y-2 text-sm text-akha-200/80">
                <li><a href="{{ route('front.about') }}" class="hover:text-akha-50">Tentang Kami</a></li>
                <li><a href="{{ route('front.contact') }}" class="hover:text-akha-50">Kontak</a></li>
                <li><a href="{{ route('front.cart.index') }}" class="hover:text-akha-50">Keranjang</a></li>
            </ul>
        </div>
    </div>
    <div class="border-t border-akha-700/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between text-xs text-akha-200/70 gap-2">
            <p>&copy; {{ date('Y') }} Akha Interior. Seluruh hak cipta.</p>
            <p>Dibuat dengan rasa hangat di Indonesia.</p>
        </div>
    </div>
</footer>
