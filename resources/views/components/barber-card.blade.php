{{-- Kartu barber: foto, peran, spesialisasi. Tanpa tahun pengalaman fiktif. --}}
@props([
    'name' => 'Nama barber (SAMPLE)',
    'role' => 'Barber',
    'specialties' => 'Classic cut, beard trim',
    'href' => '/barbers/sample',
    'image' => null,
    'imageAlt' => '',
    'isSample' => true,
])

<article class="group overflow-hidden rounded-shell border border-espresso/10 bg-near-black text-warm-cream">
    <div class="aspect-[4/5] overflow-hidden bg-espresso">
        @if ($image)
            <img src="{{ $image }}" alt="{{ $imageAlt ?: 'Foto ' . $name }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-[1.03]" loading="lazy">
        @else
            <div class="flex h-full w-full items-center justify-center bg-espresso text-center" role="img" aria-label="Foto {{ $name }} (placeholder)">
                <span class="font-display text-5xl text-brass/70">{{ substr($name, 0, 1) }}</span>
            </div>
        @endif
    </div>
    <div class="p-6">
        <div class="flex items-start justify-between gap-3">
            <div>
                <h3 class="font-display text-2xl leading-tight">{{ $name }}</h3>
                <p class="mt-1 text-sm text-brass">{{ $role }}</p>
            </div>
            @if ($isSample)
                <x-status-badge status="sample" />
            @endif
        </div>
        <p class="mt-3 text-sm leading-relaxed text-warm-cream/70">{{ $specialties }}</p>
        <a href="{{ $href }}" class="mt-5 inline-flex min-h-[44px] items-center gap-2 text-sm font-semibold text-warm-cream underline underline-offset-4 decoration-brass decoration-2 hover:text-brass" aria-label="Booking dengan {{ $name }}">
            Book dengan {{ $name }}
            <span aria-hidden="true" class="transition-transform duration-300 group-hover:translate-x-1">&rarr;</span>
        </a>
    </div>
</article>
