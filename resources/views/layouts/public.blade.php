<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Nirwana Gents'))</title>
    <meta name="description" content="@yield('meta_description', 'Nirwana Gents: barbershop premium untuk potong rambut, grooming, dan produk perawatan pria.')">
    <link rel="canonical" href="{{ url()->current() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-warm-cream text-espresso font-sans antialiased">
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-3 focus:left-3 focus:z-50 focus:bg-near-black focus:text-warm-cream focus:px-4 focus:py-2 focus:rounded-full">Lewati ke konten utama</a>

    @include('layouts.partials.site-header')

    <main id="main">
        @yield('content')
    </main>

    @include('layouts.partials.site-footer')

    @stack('scripts')
</body>
</html>
