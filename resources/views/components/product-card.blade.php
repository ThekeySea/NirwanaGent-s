{{-- Kartu produk: nama, harga numerik tampil, status stock jujur. Tanpa rating palsu. --}}
@props([
    'name' => 'Produk (SAMPLE)',
    'price' => 'TBD',
    'stockLabel' => 'Stock TBD',
    'stockStatus' => 'sample',
    'href' => '/shop/sample',
    'image' => null,
    'imageAlt' => '',
    'isSample' => true,
    'productId' => null,
    'canAdd' => false,
])

<article class="group rounded-shell border border-espresso/10 bg-white/50 p-3">
    <div class="rounded-core overflow-hidden bg-warm-cream ring-1 ring-inset ring-espresso/5">
        <div class="aspect-square overflow-hidden">
            @if ($image)
                <img src="{{ $image }}" alt="{{ $imageAlt ?: $name }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-[1.03]" loading="lazy">
            @else
                <div class="flex h-full w-full items-center justify-center bg-espresso/5" role="img" aria-label="{{ $name }} (foto placeholder)">
                    <span class="font-display text-4xl text-taupe">{{ substr($name, 0, 1) }}</span>
                </div>
            @endif
        </div>
        <div class="p-5">
            <div class="flex items-start justify-between gap-2">
                <h3 class="font-display text-xl leading-tight">{{ $name }}</h3>
                <x-status-badge :status="$stockStatus" />
            </div>
            <p class="mt-2 text-sm font-semibold">{{ $price }}</p>
            <p class="mt-1 text-xs text-taupe">{{ $stockLabel }}@if ($isSample) (sample)@endif</p>
            <div class="mt-4 flex gap-2">
                <a href="{{ $href }}" class="inline-flex min-h-[44px] flex-1 items-center justify-center rounded-pill border border-espresso/20 px-4 py-2 text-sm font-semibold hover:border-espresso/60">Detail</a>
                @if ($productId && $canAdd)
                    <form method="POST" action="/cart/items" class="flex-1">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $productId }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="inline-flex min-h-[44px] w-full items-center justify-center rounded-pill bg-near-black px-4 py-2 text-sm font-semibold text-warm-cream hover:bg-espresso" aria-label="Tambah {{ $name }} ke keranjang">Add to Cart</button>
                    </form>
                @else
                    <button type="button" disabled class="inline-flex min-h-[44px] flex-1 items-center justify-center rounded-pill bg-near-black/40 px-4 py-2 text-sm font-semibold text-warm-cream" aria-disabled="true" title="Tidak bisa ditambahkan">Add to Cart</button>
                @endif
            </div>
        </div>
    </div>
</article>
