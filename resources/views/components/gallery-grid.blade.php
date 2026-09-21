{{-- Grid galeri editorial asimetris. Terima array images: src, alt. Alt wajib bermakna, dekoratif pakai alt kosong. --}}
{{-- Hover/fokus: foto menggelap, teks singkat muncul. Bisa keyboard via tabindex. --}}
@props(['images' => []])

@php
$defaults = [
    ['src' => null, 'alt' => 'Suasana kursi barber Nirwana Gents (sample)', 'caption' => 'Ruang potong'],
    ['src' => null, 'alt' => 'Detail alat potong tertata (sample)', 'caption' => 'Detail alat'],
    ['src' => null, 'alt' => 'Cermin dan pencahayaan hangat barbershop (sample)', 'caption' => 'Interior'],
];
$items = count($images) ? $images : $defaults;
@endphp

<div class="grid gap-4 md:grid-cols-12" role="list" aria-label="Galeri Nirwana Gents">
    @foreach ($items as $i => $img)
        @php
        $span = $i === 0 ? 'md:col-span-7 md:row-span-2' : 'md:col-span-5';
        @endphp
        <figure role="listitem" tabindex="0" class="reveal group relative overflow-hidden rounded-shell border border-espresso/10 bg-espresso {{ $span }}">
            @if (!empty($img['src']))
                <img src="{{ $img['src'] }}" alt="{{ $img['alt'] ?? '' }}" class="aspect-[4/3] h-full w-full object-cover transition duration-500 ease-lux group-hover:brightness-[0.45] group-focus-within:brightness-[0.45] {{ $i === 0 ? 'md:aspect-auto md:min-h-[440px]' : '' }}" loading="lazy">
                <figcaption class="absolute inset-0 flex translate-y-3 flex-col justify-end bg-gradient-to-t from-near-black/85 via-near-black/20 to-transparent p-6 opacity-0 transition duration-500 ease-lux group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:translate-y-0 group-focus-within:opacity-100">
                    <span class="font-display text-2xl leading-tight text-warm-cream">{{ $img['caption'] ?? 'Galeri' }}</span>
                    <span class="mt-2 max-w-md text-sm leading-relaxed text-warm-cream/80">{{ $img['alt'] ?? '' }}</span>
                </figcaption>
            @else
                <div class="flex aspect-[4/3] h-full min-h-[220px] w-full flex-col justify-end bg-near-black p-6 {{ $i === 0 ? 'md:aspect-auto md:min-h-[440px]' : '' }}" role="img" aria-label="{{ $img['alt'] ?? 'Foto galeri placeholder' }}">
                    <span class="font-display text-2xl text-warm-cream">{{ $img['caption'] ?? 'Sample' }}</span>
                    <span class="mt-1 text-xs uppercase tracking-widest text-brass">Sample (foto final menyusul)</span>
                </div>
            @endif
        </figure>
    @endforeach
</div>
