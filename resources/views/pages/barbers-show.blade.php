@extends('layouts.public')

@section('title', $barber->name . ' - Nirwana Gents')
@section('meta_description', $barber->bio ?? 'Profil barber Nirwana Gents.')

@section('content')
<div class="mx-auto max-w-6xl px-5 pt-28 pb-16 md:pt-44">
    <a href="/barbers" class="inline-flex min-h-[44px] items-center text-sm font-semibold text-taupe hover:text-espresso">&larr; Semua barbers</a>

    <div class="mt-6 grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
        <div class="overflow-hidden rounded-shell border border-espresso/10 bg-near-black text-warm-cream">
            @if ($barber->image_url)
                <img src="{{ $barber->image_url }}" alt="Foto {{ $barber->name }}" class="aspect-[4/5] w-full object-cover" loading="lazy">
            @else
                <div class="flex aspect-[4/5] items-center justify-center bg-espresso" role="img" aria-label="Foto {{ $barber->name }} (placeholder)">
                    <span class="font-display text-7xl text-brass/70">{{ substr($barber->name, 0, 1) }}</span>
                </div>
            @endif
            <div class="p-6">
                <div class="flex items-center gap-2">
                    @if (str_contains($barber->slug, 'sample'))
                        <x-status-badge status="sample" />
                    @else
                        <x-status-badge status="active" />
                    @endif
                </div>
                <h1 class="mt-3 font-display text-4xl">{{ $barber->name }}</h1>
                <p class="mt-1 text-sm text-brass">{{ $barber->role }}</p>
            </div>
        </div>

        <div>
            <h2 class="font-display text-2xl">Profil singkat</h2>
            <p class="mt-3 leading-relaxed text-espresso/80">{{ $barber->bio ?? 'Bio menyusul.' }}</p>
            <p class="mt-4 text-sm"><span class="font-semibold">Spesialisasi:</span> {{ $barber->specialties ?? 'Menyusul' }}</p>

            <h2 class="mt-8 font-display text-2xl">Layanan yang didukung</h2>
            @if ($barber->services->count())
                <ul class="mt-4 space-y-3">
                    @foreach ($barber->services as $service)
                        <li class="flex items-center justify-between gap-3 rounded-core border border-espresso/10 bg-white/40 px-4 py-3 text-sm">
                            <span>{{ $service->name }} <span class="text-taupe">({{ $service->formattedPrice() }})</span></span>
                            <a href="/services/{{ $service->slug }}" class="font-semibold underline underline-offset-4 decoration-brass decoration-2">Detail</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="mt-4 text-sm text-espresso/70">Belum ada layanan terhubung.</p>
            @endif

            <div class="mt-8">
                <x-button href="/booking" variant="primary">Book dengan {{ $barber->name }}</x-button>
            </div>
        </div>
    </div>
</div>
@endsection
