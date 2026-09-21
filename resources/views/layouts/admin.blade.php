<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin - ' . config('app.name', 'Nirwana Gents'))</title>
    <meta name="robots" content="noindex, nofollow">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-warm-cream text-espresso font-sans antialiased">
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-3 focus:left-3 focus:z-50 focus:bg-near-black focus:text-warm-cream focus:px-4 focus:py-2 focus:rounded-full">Lewati ke konten utama</a>

    <div class="min-h-dvh lg:grid lg:grid-cols-[16rem_1fr]">
        <aside id="admin-sidebar" class="admin-sidebar flex flex-col border-b border-espresso/10 bg-near-black text-warm-cream lg:sticky lg:top-0 lg:h-dvh lg:overflow-y-auto lg:border-b-0 lg:border-r" aria-label="Navigasi admin">
            <div class="flex items-center justify-between px-5 py-5">
                <a href="{{ url('/admin') }}" class="font-display text-lg">Nirwana Gent&rsquo;s <span class="text-brass">Admin</span></a>
                <button type="button" id="admin-close-btn" class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-full hover:bg-white/10 lg:hidden" aria-label="Tutup navigasi admin">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
                </button>
            </div>
            <nav class="flex-1 px-3 pb-5">
                @php
                $adminNav = [
                    ['label' => 'Dashboard', 'href' => url('/admin'), 'pattern' => 'admin'],
                    ['label' => 'Services', 'href' => url('/admin/services'), 'pattern' => 'admin/services*'],
                    ['label' => 'Barbers', 'href' => url('/admin/barbers'), 'pattern' => 'admin/barbers*'],
                    ['label' => 'Products', 'href' => url('/admin/products'), 'pattern' => 'admin/products*'],
                    ['label' => 'Bookings', 'href' => url('/admin/bookings'), 'pattern' => 'admin/bookings*'],
                    ['label' => 'Orders', 'href' => url('/admin/orders'), 'pattern' => 'admin/orders*'],
                    ['label' => 'Customers', 'href' => url('/admin/customers'), 'pattern' => 'admin/customers*'],
                ];
                @endphp
                <ul class="grid gap-1 text-sm lg:grid-cols-1 grid-cols-2">
                    @foreach ($adminNav as $link)
                        @php $active = request()->is($link['pattern']); @endphp
                        <li><a @if ($active) aria-current="page" @endif class="block rounded-full px-4 py-2 focus-visible:bg-white/10 {{ $active ? 'bg-white/10 font-semibold text-brass' : 'hover:bg-white/10' }}" href="{{ $link['href'] }}">{{ $link['label'] }}</a></li>
                    @endforeach
                </ul>
            </nav>
            <div class="mt-auto border-t border-white/10 p-3 text-sm">
                <a href="{{ url('/') }}" class="flex min-h-[44px] items-center gap-3 rounded-full px-4 py-2 hover:bg-white/10 focus-visible:bg-white/10">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg>
                    Lihat situs
                </a>
                <form method="POST" action="{{ url('/logout') }}" id="admin-logout-form">
                    @csrf
                    <button type="submit" id="admin-logout-btn" class="flex min-h-[44px] w-full items-center gap-3 rounded-full px-4 py-2 hover:bg-white/10 focus-visible:bg-white/10">
                        <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 4H6v16h8"/><path d="M10 12h11M18 8l4 4-4 4"/></svg>
                        Keluar akun
                    </button>
                </form>
            </div>
        </aside>

        <div id="admin-backdrop" class="admin-backdrop lg:hidden" aria-hidden="true"></div>

        <div class="min-w-0">
            <header class="border-b border-espresso/10 bg-warm-cream">
                <div class="mx-auto flex max-w-6xl items-center gap-3 px-5 py-4">
                    <button type="button" id="admin-menu-btn" aria-expanded="false" aria-controls="admin-sidebar" aria-label="Buka navigasi admin" class="inline-flex min-h-[44px] min-w-[44px] items-center justify-center rounded-full border border-espresso/20 lg:hidden">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                    </button>
                    <h1 class="font-display text-xl">@yield('heading', 'Dashboard')</h1>
                </div>
            </header>

            <main id="main" class="mx-auto w-full max-w-6xl px-5 py-8">
                @yield('content')
            </main>
        </div>
    </div>
    <div id="logout-modal" class="modal-logout fixed inset-0 z-[60] flex items-center justify-center px-4" role="dialog" aria-modal="true" aria-labelledby="logout-modal-title" aria-hidden="true">
        <div class="absolute inset-0 bg-near-black/70" data-logout-cancel aria-hidden="true"></div>
        <div class="modal-logout-card relative w-full max-w-sm rounded-shell border border-espresso/10 bg-warm-cream p-6 text-espresso md:p-8">
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-brass">Konfirmasi</p>
            <h2 id="logout-modal-title" class="mt-2 font-display text-2xl">Keluar dari akun admin?</h2>
            <p class="mt-2 text-sm leading-relaxed text-espresso/75">Sesi berakhir dan kamu kembali ke beranda. Booking dan order yang tersimpan tidak berubah.</p>
            <div class="mt-6 flex flex-col gap-2 sm:flex-row">
                <button type="button" id="logout-cancel-btn" class="inline-flex min-h-[44px] flex-1 items-center justify-center rounded-pill border border-espresso/25 px-5 py-2 text-sm font-semibold hover:border-espresso/60">Batal</button>
                <button type="button" id="logout-confirm-btn" class="inline-flex min-h-[44px] flex-1 items-center justify-center rounded-pill bg-near-black px-5 py-2 text-sm font-semibold text-warm-cream hover:bg-espresso">Ya, keluar</button>
            </div>
        </div>
    </div>
    <script>
    (function () {
        var btn = document.getElementById('admin-menu-btn');
        var closeBtn = document.getElementById('admin-close-btn');
        var sidebar = document.getElementById('admin-sidebar');
        var backdrop = document.getElementById('admin-backdrop');
        if (!btn || !sidebar || !backdrop) return;

        function setOpen(open) {
            document.body.classList.toggle('admin-nav-open', open);
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            btn.setAttribute('aria-label', open ? 'Tutup navigasi admin' : 'Buka navigasi admin');
            if (!open) btn.focus();
        }

        btn.addEventListener('click', function () {
            setOpen(!document.body.classList.contains('admin-nav-open'));
        });
        closeBtn.addEventListener('click', function () {
            setOpen(false);
        });
        backdrop.addEventListener('click', function () {
            setOpen(false);
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && document.body.classList.contains('admin-nav-open') && !document.body.classList.contains('logout-modal-open')) {
                setOpen(false);
            }
        });
        sidebar.addEventListener('click', function (e) {
            if (e.target.closest('a')) setOpen(false);
        });

        var logoutForm = document.getElementById('admin-logout-form');
        var logoutModal = document.getElementById('logout-modal');
        var logoutCancel = document.getElementById('logout-cancel-btn');
        var logoutConfirm = document.getElementById('logout-confirm-btn');
        var logoutTrigger = document.getElementById('admin-logout-btn');

        function openLogout() {
            document.body.classList.add('logout-modal-open');
            logoutModal.setAttribute('aria-hidden', 'false');
            logoutCancel.focus();
        }

        function closeLogout() {
            document.body.classList.remove('logout-modal-open');
            logoutModal.setAttribute('aria-hidden', 'true');
            if (logoutTrigger) logoutTrigger.focus();
        }

        if (logoutForm && logoutModal) {
            logoutForm.addEventListener('submit', function (e) {
                e.preventDefault();
                openLogout();
            });
            logoutCancel.addEventListener('click', closeLogout);
            logoutModal.querySelector('[data-logout-cancel]').addEventListener('click', closeLogout);
            logoutConfirm.addEventListener('click', function () {
                logoutForm.submit();
            });
        }

        document.addEventListener('keydown', function (e) {
            if (e.key !== 'Escape') return;
            if (document.body.classList.contains('logout-modal-open')) {
                closeLogout();
            }
        });
    })();
    </script>
</body>
</html>
