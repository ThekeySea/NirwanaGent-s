{{-- Floating detached header untuk halaman public. Navigasi tetap usable tanpa motion. --}}
@php
$mainNav = [
    ['label' => 'About', 'href' => url('/about'), 'pattern' => 'about'],
    ['label' => 'Services', 'href' => url('/services'), 'pattern' => 'services*'],
    ['label' => 'Barbers', 'href' => url('/barbers'), 'pattern' => 'barbers*'],
    ['label' => 'Shop', 'href' => url('/shop'), 'pattern' => 'shop*'],
    ['label' => 'Contact', 'href' => url('/contact'), 'pattern' => 'contact'],
];
@endphp
<div class="pointer-events-none fixed inset-x-0 top-0 z-40 px-4 pt-4 sm:px-6">
    <header class="pointer-events-auto mx-auto flex max-w-6xl items-center justify-between gap-2 lg:gap-4 rounded-pill border border-espresso/10 bg-near-black/95 py-3 pl-5 pr-3 lg:pl-6 text-warm-cream shadow-[0_18px_50px_-24px_rgba(17,16,14,0.7)] backdrop-blur-sm">
        <a href="{{ url('/') }}" class="shrink-0 font-display text-lg tracking-tight" aria-label="Nirwana Gents - beranda">Nirwana Gent&rsquo;s</a>

        <nav class="hidden items-center gap-4 lg:gap-6 text-sm md:flex" aria-label="Navigasi utama">
            @foreach ($mainNav as $link)
                @php $active = request()->is($link['pattern']); @endphp
                <a href="{{ $link['href'] }}" @if ($active) aria-current="page" @endif class="nav-link {{ $active ? 'nav-link-active' : '' }}">{{ $link['label'] }}</a>
            @endforeach
        </nav>

        <div class="flex items-center gap-2">
            @auth
                @php $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity'); @endphp
                <a href="{{ url('/cart') }}" class="rounded-pill px-4 py-2 text-sm hover:bg-white/10" aria-label="Keranjang belanja, {{ $cartCount }} item">Cart{{ $cartCount > 0 ? ' (' . $cartCount . ')' : '' }}</a>
            @else
                <a href="{{ url('/cart') }}" class="rounded-pill px-4 py-2 text-sm hover:bg-white/10" aria-label="Keranjang belanja">Cart</a>
            @endauth
            @auth
                <a href="{{ auth()->user()->role === 'admin' ? url('/admin') : url('/account') }}" class="rounded-pill px-4 py-2 text-sm hover:bg-white/10">{{ auth()->user()->role === 'admin' ? 'Admin' : 'Account' }}</a>
            @else
                <a href="{{ url('/login') }}" class="rounded-pill px-4 py-2 text-sm hover:bg-white/10">Masuk</a>
            @endauth
            <a href="{{ url('/booking') }}" class="hidden rounded-pill bg-brass px-4 lg:px-5 py-2 text-sm font-semibold text-near-black hover:brightness-110 active:brightness-95 md:inline-flex"><span class="hidden lg:inline">Book an Appointment</span><span class="lg:hidden">Book</span></a>
        </div>
    </header>
</div>
