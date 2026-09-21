@extends('layouts.public')

@section('title', 'Shop - Nirwana Gents')
@section('meta_description', 'Katalog produk grooming Nirwana Gents dengan harga dan stock tertulis. Checkout penuh hadir di Fase 5.')

@section('content')
<div class="mx-auto max-w-6xl px-5 pt-36 pb-16 md:pt-44">
    <x-section-intro
        eyebrow="Grooming store"
        title="Belanja produk perawatan."
        description="Fase 2 masih read-only. Tombol Add to Cart aktif penuh di Fase 5 setelah cart dan checkout dibangun."
    />

    <form method="GET" action="/shop" class="mt-8 flex flex-col gap-3 rounded-shell border border-espresso/10 bg-white/40 p-4 md:flex-row md:items-center" role="search" aria-label="Cari produk">
        <label class="flex-1">
            <span class="sr-only">Cari produk</span>
            <input type="search" name="q" value="{{ $q }}" placeholder="Cari pomade, oil, clay" class="min-h-[44px] w-full rounded-pill border border-espresso/20 bg-warm-cream px-5 text-sm focus:border-brass focus:outline-none">
        </label>
        <label>
            <span class="sr-only">Kategori</span>
            <select name="category" class="min-h-[44px] rounded-pill border border-espresso/20 bg-warm-cream px-5 text-sm">
                <option value="">Semua kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->slug }}" @selected($activeCategory === $cat->slug)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </label>
        <button type="submit" class="inline-flex min-h-[44px] items-center justify-center rounded-pill bg-near-black px-6 text-sm font-semibold text-warm-cream hover:bg-espresso">Cari</button>
    </form>

    <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($products as $product)
            @php $state = $product->stockState(); @endphp
            <x-product-card
                :name="$product->name"
                :price="$product->formattedPrice()"
                :stockLabel="$state['label']"
                :stockStatus="$state['status']"
                :href="'/shop/' . $product->slug"
                :isSample="str_contains($product->slug, 'sample')"
            />
        @empty
            <p class="text-sm text-espresso/70">Tidak ada produk untuk filter ini. <a class="underline" href="/shop">Tampilkan semua.</a></p>
        @endforelse
    </div>
</div>
@endsection
