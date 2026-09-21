@extends('layouts.public')

@section('title', $service->name . ' - Nirwana Gents')
@section('meta_description', $service->description ?? 'Detail layanan Nirwana Gents.')

@section('content')
<div class="mx-auto max-w-6xl px-5 pt-28 pb-16 md:pt-44">
    <a href="/services" class="inline-flex min-h-[44px] items-center text-sm font-semibold text-taupe hover:text-espresso">&larr; Semua services</a>

    <div class="mt-6 grid gap-8 lg:grid-cols-[1.1fr_0.9fr]">
        <div>
            <div class="flex flex-wrap items-center gap-2">
                @if (str_contains($service->slug, 'sample'))
                    <x-status-badge status="sample" />
                @else
                    <x-status-badge status="active" />
                @endif
            </div>
            <h1 class="mt-4 font-display text-4xl leading-tight md:text-6xl">{{ $service->name }}</h1>
            <p class="mt-4 max-w-xl leading-relaxed text-espresso/80">{{ $service->description }}</p>

            <dl class="mt-8 grid grid-cols-2 gap-4 rounded-shell border border-espresso/10 bg-white/40 p-6">
                <div><dt class="text-xs uppercase tracking-widest text-taupe">Harga</dt><dd class="mt-1 font-display text-3xl">{{ $service->formattedPrice() }}</dd></div>
                <div><dt class="text-xs uppercase tracking-widest text-taupe">Durasi</dt><dd class="mt-1 font-display text-3xl">{{ $service->duration_minutes }} menit</dd></div>
            </dl>

            @if ($service->inclusions)
                <h2 class="mt-8 font-display text-2xl">Termasuk</h2>
                <ul class="mt-3 list-disc space-y-2 pl-5 text-sm leading-relaxed text-espresso/80">
                    @foreach (preg_split('/\r\n|\r|\n/', $service->inclusions) as $line)
                        @if (trim($line) !== '')
                            <li>{{ trim($line) }}</li>
                        @endif
                    @endforeach
                </ul>
            @endif

            <div class="mt-8 flex flex-wrap gap-3">
                <x-button href="/booking" variant="primary">Book an Appointment</x-button>
                <x-button href="/services" variant="outline">View Services</x-button>
            </div>
        </div>

        <div class="rounded-shell border border-espresso/10 bg-near-black p-6 text-warm-cream">
            <h2 class="font-display text-2xl">Barber untuk layanan ini</h2>
            @if ($service->barbers->count())
                <ul class="mt-4 space-y-3 text-sm">
                    @foreach ($service->barbers as $barber)
                        <li class="flex items-center justify-between gap-3 border-b border-white/10 pb-3">
                            <span>{{ $barber->name }} <span class="text-warm-cream/60">({{ $barber->role }})</span></span>
                            <a href="/barbers/{{ $barber->slug }}" class="underline underline-offset-4 decoration-brass decoration-2 hover:text-brass">Profil</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="mt-4 text-sm text-warm-cream/70">Belum ada barber terdaftar untuk layanan ini.</p>
            @endif
        </div>
    </div>
</div>
@endsection
