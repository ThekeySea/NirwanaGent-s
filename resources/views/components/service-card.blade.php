{{-- Kartu layanan dengan pola nested shell/core. Harga dan durasi tampil apa adanya, tanpa klaim. --}}
@props([
    'name' => 'Nama layanan (SAMPLE)',
    'price' => 'TBD',
    'duration' => 'TBD',
    'description' => '',
    'href' => '/services/sample',
    'isSample' => true,
])

<article class="group rounded-shell border border-espresso/10 bg-white/50 p-3 transition-transform duration-500 hover:-translate-y-1">
    <div class="rounded-core bg-warm-cream p-6 ring-1 ring-inset ring-espresso/5">
        <div class="flex items-start justify-between gap-3">
            <h3 class="font-display text-2xl leading-tight">{{ $name }}</h3>
            @if ($isSample)
                <x-status-badge status="sample" />
            @endif
        </div>
        @if ($description)
            <p class="mt-3 text-sm leading-relaxed text-espresso/75">{{ $description }}</p>
        @endif
        <dl class="mt-5 flex flex-wrap gap-x-6 gap-y-2 text-sm">
            <div>
                <dt class="text-xs uppercase tracking-widest text-taupe">Harga</dt>
                <dd class="font-semibold">{{ $price }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-widest text-taupe">Durasi</dt>
                <dd class="font-semibold">{{ $duration }}</dd>
            </div>
        </dl>
        <a href="{{ $href }}" class="mt-6 inline-flex min-h-[44px] items-center gap-2 text-sm font-semibold text-espresso underline underline-offset-4 decoration-brass decoration-2 hover:text-near-black" aria-label="Lihat detail {{ $name }}">
            Pilih layanan
            <span aria-hidden="true" class="transition-transform duration-300 group-hover:translate-x-1">&rarr;</span>
        </a>
    </div>
</article>
