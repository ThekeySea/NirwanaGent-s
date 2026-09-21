{{-- Grid galeri editorial asimetris. Terima array images: src, alt. Alt wajib bermakna, dekoratif pakai alt kosong. --}}
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
        <figure role="listitem" class="reveal overflow-hidden rounded-shell border border-espresso/10 bg-espresso {{ $span }}">
            @if (!empty($img['src']))
                <img src="{{ $img['src'] }}" alt="{{ $img['alt'] ?? '' }}" class="aspect-[4/3] h-full w-full object-cover" loading="lazy">
            @else
                <div class="flex aspect-[4/3] h-full min-h-[220px] w-full flex-col justify-end bg-near-black p-6 {{ $i === 0 ? 'md:aspect-auto md:min-h-[440px]' : '' }}" role="img" aria-label="{{ $img['alt'] ?? 'Foto galeri placeholder' }}">
                    <span class="font-display text-2xl text-warm-cream">{{ $img['caption'] ?? 'Sample' }}</span>
                    <span class="mt-1 text-xs uppercase tracking-widest text-brass">Sample (foto final menyusul)</span>
                </div>
            @endif
        </figure>
    @endforeach
</div>
