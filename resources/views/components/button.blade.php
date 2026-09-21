{{-- CTA utama. Varian: primary (near-black), brass, outline. Selalu min-height 44px, ada hover, focus, pressed. --}}
@props([
    'href' => '#',
    'variant' => 'primary',
    'type' => 'link',
])

@php
$base = 'inline-flex min-h-[44px] items-center justify-center gap-2 rounded-pill px-6 py-3 text-sm font-semibold transition-all duration-300 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brass active:scale-[0.99]';
$variants = [
    'primary' => 'bg-near-black text-warm-cream hover:bg-espresso',
    'brass' => 'bg-brass text-near-black hover:brightness-110 active:brightness-95',
    'outline' => 'border border-espresso/25 text-espresso hover:border-espresso/60 hover:bg-espresso/5',
    'on-dark' => 'bg-warm-cream text-near-black hover:bg-white',
];
$classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp

@if ($type === 'button')
    <button {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@else
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@endif
