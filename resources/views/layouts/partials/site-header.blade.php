{{-- Floating detached header untuk halaman public. Navigasi tetap usable tanpa motion. --}}
<div class="pointer-events-none fixed inset-x-0 top-0 z-40 px-4 pt-4 sm:px-6">
    <header class="pointer-events-auto mx-auto flex max-w-6xl items-center justify-between gap-4 rounded-pill border border-espresso/10 bg-near-black/95 py-3 pl-6 pr-3 text-warm-cream shadow-[0_18px_50px_-24px_rgba(17,16,14,0.7)] backdrop-blur-sm">
        <a href="{{ url('/') }}" class="font-display text-lg tracking-tight" aria-label="Nirwana Gents - beranda">Nirwana Gent&rsquo;s</a>

        <nav class="hidden items-center gap-6 text-sm md:flex" aria-label="Navigasi utama">
            <a class="hover:text-brass" href="{{ url('/about') }}">About</a>
            <a class="hover:text-brass" href="{{ url('/services') }}">Services</a>
            <a class="hover:text-brass" href="{{ url('/barbers') }}">Barbers</a>
            <a class="hover:text-brass" href="{{ url('/shop') }}">Shop</a>
            <a class="hover:text-brass" href="{{ url('/contact') }}">Contact</a>
        </nav>

        <div class="flex items-center gap-2">
            <a href="{{ url('/cart') }}" class="rounded-pill px-4 py-2 text-sm hover:bg-white/10" aria-label="Keranjang belanja">Cart</a>
            <a href="{{ url('/booking') }}" class="rounded-pill bg-brass px-5 py-2 text-sm font-semibold text-near-black hover:brightness-110 active:brightness-95">Book an Appointment</a>
        </div>
    </header>

    <nav class="pointer-events-auto mx-auto mt-2 max-w-6xl rounded-shell border border-espresso/10 bg-warm-cream p-2 text-sm md:hidden" aria-label="Navigasi mobile">
        <div class="grid grid-cols-3 gap-1 text-center">
            <a class="rounded-full px-3 py-2 hover:bg-espresso/5" href="{{ url('/services') }}">Services</a>
            <a class="rounded-full px-3 py-2 hover:bg-espresso/5" href="{{ url('/barbers') }}">Barbers</a>
            <a class="rounded-full px-3 py-2 hover:bg-espresso/5" href="{{ url('/shop') }}">Shop</a>
        </div>
    </nav>
</div>
