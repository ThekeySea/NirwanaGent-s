{{-- Status badge dengan teks, bukan warna saja (aksesibilitas). --}}
@props(['status' => 'pending'])

@php
$map = [
    'pending' => 'bg-brass/15 text-espresso border-brass/30',
    'confirmed' => 'bg-emerald-900/10 text-emerald-950 border-emerald-900/25',
    'processing' => 'bg-sky-900/10 text-sky-950 border-sky-900/25',
    'ready' => 'bg-emerald-900/10 text-emerald-950 border-emerald-900/25',
    'completed' => 'bg-near-black text-warm-cream border-near-black',
    'cancelled' => 'bg-red-900/10 text-red-950 border-red-900/25',
    'active' => 'bg-emerald-900/10 text-emerald-950 border-emerald-900/25',
    'inactive' => 'bg-espresso/5 text-taupe border-espresso/15',
    'low' => 'bg-red-900/10 text-red-950 border-red-900/25',
    'sample' => 'bg-espresso/5 text-taupe border-dashed border-espresso/25',
];
$classes = $map[$status] ?? $map['pending'];
$label = ucfirst($status);
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 rounded-pill border px-3 py-1 text-xs font-semibold ' . $classes]) }}>
    <span class="size-1.5 rounded-full bg-current" aria-hidden="true"></span>
    {{ $label }}
</span>
