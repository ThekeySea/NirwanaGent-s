{{-- Hero full-background: foto tempat, overlay gelap, teks rata kiri, dua CTA. --}}
@props([
    'eyebrow' => '',
    'title' => '',
    'description' => '',
    'primaryLabel' => 'Book an Appointment',
    'primaryHref' => '/booking',
    'secondaryLabel' => 'View Services',
    'secondaryHref' => '/services',
    'image' => '/images/hero-interior.jpg',
    'imageAlt' => 'Interior barbershop (sample)',
])

<section class="relative overflow-hidden bg-near-black text-warm-cream" aria-label="Intro Nirwana Gents">
    <img src="{{ $image }}" alt="{{ $imageAlt }}" class="absolute inset-0 h-full w-full object-cover" fetchpriority="high">
    <div class="absolute inset-0 bg-gradient-to-r from-near-black/90 via-near-black/60 to-near-black/25" aria-hidden="true"></div>
    <div class="absolute inset-x-0 bottom-0 h-28 bg-gradient-to-t from-near-black/70 to-transparent" aria-hidden="true"></div>

    <div class="relative mx-auto flex min-h-[92dvh] w-full max-w-6xl flex-col justify-end px-5 pb-32 pt-28 md:justify-center md:pb-24 md:pt-44">
        <div class="reveal max-w-2xl">
            @if ($eyebrow)
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-brass">{{ $eyebrow }}</p>
            @endif
            <h1 class="mt-4 font-display text-5xl leading-[1.02] tracking-tight md:text-7xl">{{ $title }}</h1>
            @if ($description)
                <p class="mt-6 max-w-xl leading-relaxed text-warm-cream/85">{{ $description }}</p>
            @endif
            <div class="mt-8 flex flex-wrap gap-3">
                <x-button href="{{ $primaryHref }}" variant="brass">{{ $primaryLabel }}</x-button>
                <x-button href="{{ $secondaryHref }}" variant="on-dark">{{ $secondaryLabel }}</x-button>
            </div>
            <p class="mt-6 text-[11px] uppercase tracking-widest text-warm-cream/50">Foto sample, interior final menyusul</p>
        </div>
    </div>
</section>
