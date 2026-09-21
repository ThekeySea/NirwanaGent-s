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
        <aside class="border-b border-espresso/10 bg-near-black text-warm-cream lg:border-b-0 lg:border-r lg:min-h-dvh" aria-label="Navigasi admin">
            <div class="px-5 py-5">
                <a href="{{ url('/admin') }}" class="font-display text-lg">Nirwana Gent&rsquo;s <span class="text-brass">Admin</span></a>
            </div>
            <nav class="px-3 pb-5">
                <ul class="grid gap-1 text-sm lg:grid-cols-1 grid-cols-2">
                    <li><a class="block rounded-full px-4 py-2 hover:bg-white/10 focus-visible:bg-white/10" href="{{ url('/admin') }}">Dashboard</a></li>
                    <li><a class="block rounded-full px-4 py-2 hover:bg-white/10 focus-visible:bg-white/10" href="{{ url('/admin/services') }}">Services</a></li>
                    <li><a class="block rounded-full px-4 py-2 hover:bg-white/10 focus-visible:bg-white/10" href="{{ url('/admin/barbers') }}">Barbers</a></li>
                    <li><a class="block rounded-full px-4 py-2 hover:bg-white/10 focus-visible:bg-white/10" href="{{ url('/admin/products') }}">Products</a></li>
                    <li><a class="block rounded-full px-4 py-2 hover:bg-white/10 focus-visible:bg-white/10" href="{{ url('/admin/bookings') }}">Bookings</a></li>
                    <li><a class="block rounded-full px-4 py-2 hover:bg-white/10 focus-visible:bg-white/10" href="{{ url('/admin/orders') }}">Orders</a></li>
                    <li><a class="block rounded-full px-4 py-2 hover:bg-white/10 focus-visible:bg-white/10" href="{{ url('/admin/customers') }}">Customers</a></li>
                </ul>
            </nav>
        </aside>

        <div class="min-w-0">
            <header class="border-b border-espresso/10 bg-warm-cream">
                <div class="mx-auto flex max-w-6xl items-center justify-between px-5 py-4">
                    <h1 class="font-display text-xl">@yield('heading', 'Dashboard')</h1>
                    <a href="{{ url('/') }}" class="text-sm text-taupe underline underline-offset-4 hover:text-espresso">Lihat situs</a>
                </div>
            </header>

            <main id="main" class="mx-auto w-full max-w-6xl px-5 py-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
