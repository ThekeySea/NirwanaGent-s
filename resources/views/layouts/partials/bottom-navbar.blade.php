{{-- Bottom navbar pill khusus mobile. Disembunyikan di tablet ke atas. --}}
@php
$isHome = request()->path() === '/';
$bottomNav = [
    [
        'label' => 'Home',
        'href' => url('/'),
        'active' => $isHome,
        'icon' => 'home',
    ],
    [
        'label' => 'Services',
        'href' => url('/services'),
        'active' => request()->is('services*'),
        'icon' => 'scissors',
    ],
    [
        'label' => 'Shop',
        'href' => url('/shop'),
        'active' => request()->is('shop*'),
        'icon' => 'bag',
    ],
    [
        'label' => auth()->check() ? (auth()->user()->role === 'admin' ? 'Admin' : 'Account') : 'Masuk',
        'href' => auth()->check() ? (auth()->user()->role === 'admin' ? url('/admin') : url('/account')) : url('/login'),
        'active' => request()->is('account*', 'login', 'admin*'),
        'icon' => 'user',
    ],
];
$bookActive = request()->is('booking*');
@endphp
<div class="fixed inset-x-0 bottom-0 z-40 px-4 pb-[max(1rem,env(safe-area-inset-bottom))] md:hidden">
    <nav aria-label="Navigasi bawah" class="mx-auto grid max-w-md grid-cols-5 items-end rounded-pill border border-espresso/10 bg-near-black/95 px-2 pb-2 pt-1 text-warm-cream shadow-[0_18px_50px_-24px_rgba(17,16,14,0.7)] backdrop-blur-sm">
        <a href="{{ $bottomNav[0]['href'] }}" @if ($bottomNav[0]['active']) aria-current="page" @endif class="flex min-h-[56px] flex-col items-center justify-center gap-1 px-1 text-[10px] font-medium {{ $bottomNav[0]['active'] ? 'text-brass' : 'text-warm-cream/65 hover:text-warm-cream' }}">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 11.5 12 4l8 7.5"/><path d="M6.5 10v9.5h11V10"/><path d="M10 19.5v-5h4v5"/></svg>
            <span>Home</span>
            <span class="h-1 w-1 rounded-full {{ $bottomNav[0]['active'] ? 'bg-brass' : 'bg-transparent' }}" aria-hidden="true"></span>
        </a>
        <a href="{{ $bottomNav[1]['href'] }}" @if ($bottomNav[1]['active']) aria-current="page" @endif class="flex min-h-[56px] flex-col items-center justify-center gap-1 px-1 text-[10px] font-medium {{ $bottomNav[1]['active'] ? 'text-brass' : 'text-warm-cream/65 hover:text-warm-cream' }}">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="6" cy="7" r="2.4"/><circle cx="6" cy="17" r="2.4"/><path d="M8.2 8.8 20 19M8.2 15.2 20 5"/></svg>
            <span>Services</span>
            <span class="h-1 w-1 rounded-full {{ $bottomNav[1]['active'] ? 'bg-brass' : 'bg-transparent' }}" aria-hidden="true"></span>
        </a>
        <a href="{{ url('/booking') }}" @if ($bookActive) aria-current="page" @endif aria-label="Book an Appointment" class="flex flex-col items-center gap-1 px-1 pb-1 text-[10px] font-semibold {{ $bookActive ? 'text-brass' : 'text-near-black' }}">
            <span class="flex h-14 w-14 -translate-y-4 items-center justify-center rounded-full bg-brass shadow-[0_10px_25px_-8px_rgba(177,138,74,0.8)] transition-transform duration-300 ease-lux active:scale-95 {{ $bookActive ? 'ring-2 ring-warm-cream/70 ring-offset-2 ring-offset-near-black' : '' }}">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4.5" y="6" width="15" height="14" rx="2.5"/><path d="M4.5 10.5h15M9 3.5V7M15 3.5V7"/><path d="M12 13v4M10 15h4"/></svg>
            </span>
            <span class="-mt-3">Book</span>
        </a>
        <a href="{{ $bottomNav[2]['href'] }}" @if ($bottomNav[2]['active']) aria-current="page" @endif class="flex min-h-[56px] flex-col items-center justify-center gap-1 px-1 text-[10px] font-medium {{ $bottomNav[2]['active'] ? 'text-brass' : 'text-warm-cream/65 hover:text-warm-cream' }}">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6.5 8h11l.9 11.2a1 1 0 0 1-1 1.1H6.6a1 1 0 0 1-1-1.1L6.5 8Z"/><path d="M9.5 10V6.8a2.5 2.5 0 0 1 5 0V10"/></svg>
            <span>Shop</span>
            <span class="h-1 w-1 rounded-full {{ $bottomNav[2]['active'] ? 'bg-brass' : 'bg-transparent' }}" aria-hidden="true"></span>
        </a>
        <a href="{{ $bottomNav[3]['href'] }}" @if ($bottomNav[3]['active']) aria-current="page" @endif class="flex min-h-[56px] flex-col items-center justify-center gap-1 px-1 text-[10px] font-medium {{ $bottomNav[3]['active'] ? 'text-brass' : 'text-warm-cream/65 hover:text-warm-cream' }}">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="3.6"/><path d="M5 20c1.2-3.6 3.8-5.4 7-5.4s5.8 1.8 7 5.4"/></svg>
            <span>{{ $bottomNav[3]['label'] }}</span>
            <span class="h-1 w-1 rounded-full {{ $bottomNav[3]['active'] ? 'bg-brass' : 'bg-transparent' }}" aria-hidden="true"></span>
        </a>
    </nav>
</div>
