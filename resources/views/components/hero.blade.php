{{-- Hero editorial split: headline kiri, visual kanan. Mobile jadi single column. --}}
@props([
    'eyebrow' => '',
    'title' => '',
    'description' => '',
    'primaryLabel' => 'Book an Appointment',
    'primaryHref' => '/booking',
    'secondaryLabel' => 'View Services',
    'secondaryHref' => '/services',
])

<section class="mx-auto max-w-6xl px-5 pt-36 pb-14 md:pt-44 md:pb-20">
    <div class="grid items-end gap-10 lg:grid-cols-[1.15fr_0.85fr]">
        <div class="reveal">
            @if ($eyebrow)
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-brass">{{ $eyebrow }}</p>
            @endif
            <h1 class="mt-4 font-display text-5xl leading-[1.02] tracking-tight md:text-7xl">{{ $title }}</h1>
            @if ($description)
                <p class="mt-6 max-w-xl leading-relaxed text-espresso/80">{{ $description }}</p>
            @endif
            <div class="mt-8 flex flex-wrap gap-3">
                <x-button href="{{ $primaryHref }}" variant="primary">{{ $primaryLabel }}</x-button>
                <x-button href="{{ $secondaryHref }}" variant="outline">{{ $secondaryLabel }}</x-button>
            </div>
        </div>
        <div class="reveal rounded-shell border border-espresso/10 bg-near-black p-3">
            <div class="rounded-core overflow-hidden bg-espresso">
                {{ $slot }}
            </div>
        </div>
    </div>
</section>
