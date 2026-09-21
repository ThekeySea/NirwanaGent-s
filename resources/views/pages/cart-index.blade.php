@extends('layouts.transactional')

@section('title', 'Cart - Nirwana Gents')
@section('step_label', 'Browse, Cart, Checkout')

@section('content')
<x-section-intro eyebrow="Cart" title="Periksa isi keranjang." description="Quantity dibatasi stock dan dihitung ulang sistem saat checkout." />

@if (session('status'))
    <p role="status" class="mt-6 rounded-core border border-emerald-900/25 bg-emerald-900/10 px-4 py-3 text-sm">{{ session('status') }}</p>
@endif
@if ($errors->any())
    <div role="alert" class="mt-6 rounded-core border border-red-900/20 bg-red-50 px-4 py-3 text-sm">
        @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

@if ($items->isEmpty())
    <div class="mt-8 rounded-shell border border-espresso/10 bg-white/40 p-6 text-sm">
        <p class="font-semibold">Keranjang kosong.</p>
        <p class="mt-1 text-espresso/75">Tambah produk dari katalog shop.</p>
        <div class="mt-4"><x-button href="/shop" variant="primary">Lihat Shop</x-button></div>
    </div>
@else
    <ul class="mt-8 grid gap-4">
        @foreach ($items as $item)
            <li class="rounded-shell border border-espresso/10 bg-white/40 p-5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="font-display text-xl">{{ $item->product->name }}</p>
                        <p class="mt-1 text-sm font-semibold">Rp {{ number_format($item->product->price, 0, ',', '.') }} <span class="font-normal text-taupe">x {{ $item->quantity }}</span></p>
                        <p class="text-xs text-taupe">Stock tersisa: {{ $item->product->stock }}</p>
                    </div>
                    <p class="text-sm font-semibold">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                </div>
                <div class="mt-4 flex flex-wrap items-center gap-2">
                    <form method="POST" action="/cart/items/{{ $item->id }}" class="flex items-center gap-2" aria-label="Ubah quantity {{ $item->product->name }}">
                        @csrf
                        @method('PATCH')
                        <label class="sr-only" for="qty-{{ $item->id }}">Quantity</label>
                        <input id="qty-{{ $item->id }}" type="number" name="quantity" min="1" max="{{ max($item->product->stock, 1) }}" value="{{ $item->quantity }}" class="min-h-[44px] w-24 rounded-pill border border-espresso/20 bg-warm-cream px-4 text-sm">
                        <button type="submit" class="inline-flex min-h-[44px] items-center rounded-pill border border-espresso/25 px-5 py-2 text-sm font-semibold hover:border-espresso/60">Update</button>
                    </form>
                    <form method="POST" action="/cart/items/{{ $item->id }}" aria-label="Hapus {{ $item->product->name }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex min-h-[44px] items-center rounded-pill border border-red-900/30 px-5 py-2 text-sm font-semibold text-red-950 hover:bg-red-900/5">Remove</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>

    <div class="mt-6 rounded-shell bg-near-black p-6 text-warm-cream">
        <div class="flex items-center justify-between text-sm"><span class="text-warm-cream/70">Subtotal</span><strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></div>
        <p class="mt-2 text-xs text-warm-cream/60">Ongkir dihitung di checkout: pickup gratis, delivery Rp 15.000 (sample sampai tarif resmi ada).</p>
        <div class="mt-4 flex flex-wrap gap-3">
            <x-button href="/checkout" variant="brass">Proceed to Checkout</x-button>
            <x-button href="/shop" variant="on-dark">Lanjut belanja</x-button>
        </div>
    </div>
@endif
@endsection
