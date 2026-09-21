@extends('layouts.public')

@section('title', $product->name . ' - Nirwana Gents')
@section('meta_description', $product->description ?? 'Detail produk Nirwana Gents.')

@section('content')
<div class="mx-auto max-w-6xl px-5 pt-36 pb-16 md:pt-44">
    <a href="/shop" class="inline-flex min-h-[44px] items-center text-sm font-semibold text-taupe hover:text-espresso">&larr; Semua produk</a>

    <div class="mt-6 grid gap-8 lg:grid-cols-2">
        <div class="flex aspect-square items-center justify-center rounded-shell border border-espresso/10 bg-espresso/5" role="img" aria-label="{{ $product->name }} (foto placeholder)">
            <span class="font-display text-7xl text-taupe">{{ substr($product->name, 0, 1) }}</span>
        </div>
        <div>
            <div class="flex flex-wrap gap-2">
                @php $state = $product->stockState(); @endphp
                <x-status-badge :status="$state['status']" />
                @if (str_contains($product->slug, 'sample'))
                    <x-status-badge status="sample" />
                @endif
            </div>
            <h1 class="mt-4 font-display text-4xl leading-tight md:text-5xl">{{ $product->name }}</h1>
            <p class="mt-2 text-sm text-taupe">Kategori: {{ $product->category->name ?? 'Tanpa kategori' }}</p>
            <p class="mt-4 font-display text-3xl">{{ $product->formattedPrice() }}</p>
            <p class="mt-1 text-sm text-espresso/70">Status: {{ $state['label'] }}. Harga final dihitung ulang sistem saat checkout (Fase 5).</p>

            <p class="mt-6 leading-relaxed text-espresso/80">{{ $product->description }}</p>

            @if ($product->usage_instructions)
                <h2 class="mt-6 font-display text-2xl">Cara pakai</h2>
                <p class="mt-2 text-sm leading-relaxed text-espresso/80">{{ $product->usage_instructions }}</p>
            @endif

            <form class="mt-8 flex max-w-sm items-center gap-3" aria-label="Jumlah produk">
                <label class="flex-1">
                    <span class="sr-only">Jumlah</span>
                    <input type="number" min="1" max="{{ max($product->stock, 1) }}" value="1" disabled class="min-h-[44px] w-full rounded-pill border border-espresso/20 bg-warm-cream px-5 text-sm opacity-60" aria-describedby="cart-note">
                </label>
                <button type="button" disabled class="inline-flex min-h-[44px] flex-1 items-center justify-center rounded-pill bg-near-black/40 px-4 py-2 text-sm font-semibold text-warm-cream" aria-disabled="true">Add to Cart</button>
            </form>
            <p id="cart-note" class="mt-2 text-xs text-taupe">Cart aktif di Fase 5. Quantity dibatasi stock dan divalidasi server.</p>
        </div>
    </div>
</div>
@endsection
