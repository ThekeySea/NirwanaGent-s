<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Nirwana Gents'))</title>
    <meta name="description" content="@yield('meta_description', 'Selesaikan booking atau checkout Nirwana Gents.')">
    <meta name="robots" content="noindex, nofollow">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-warm-cream text-espresso font-sans antialiased">
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:top-3 focus:left-3 focus:z-50 focus:bg-near-black focus:text-warm-cream focus:px-4 focus:py-2 focus:rounded-full">Lewati ke konten utama</a>

    <header class="border-b border-espresso/10 bg-warm-cream">
        <div class="mx-auto flex max-w-3xl items-center justify-between px-5 py-4">
            <a href="{{ url('/') }}" class="font-display text-xl tracking-tight" aria-label="Nirwana Gents - beranda">Nirwana Gent&rsquo;s</a>
            <span class="text-sm text-taupe">@yield('step_label', 'Langkah')</span>
        </div>
    </header>

    <main id="main" class="mx-auto w-full max-w-3xl px-5 pt-10 pb-28 md:pb-10">
        @if (session('status'))
            <div role="status" class="mb-6 rounded-core border border-espresso/15 bg-white/60 px-4 py-3 text-sm">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div role="alert" class="mb-6 rounded-core border border-red-900/20 bg-red-50 px-4 py-3 text-sm">
                <p class="font-semibold">Periksa kembali isian berikut:</p>
                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    @include('layouts.partials.bottom-navbar')
</body>
</html>
