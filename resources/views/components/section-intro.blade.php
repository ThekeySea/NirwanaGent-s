{{-- Intro section editorial. Default rata kiri, bukan centered, agar sesuai rules anti-template. --}}
@props([
    'eyebrow' => '',
    'title' => '',
    'description' => '',
    'dark' => false,
])

<div class="max-w-2xl">
    @if ($eyebrow)
        <p class="text-xs font-semibold uppercase tracking-[0.22em] {{ $dark ? 'text-brass' : 'text-brass' }}">{{ $eyebrow }}</p>
    @endif
    @if ($title)
        <h2 class="mt-3 font-display text-3xl leading-tight tracking-tight md:text-5xl {{ $dark ? 'text-warm-cream' : 'text-espresso' }}">{{ $title }}</h2>
    @endif
    @if ($description)
        <p class="mt-4 leading-relaxed {{ $dark ? 'text-warm-cream/70' : 'text-espresso/75' }}">{{ $description }}</p>
    @endif
</div>
