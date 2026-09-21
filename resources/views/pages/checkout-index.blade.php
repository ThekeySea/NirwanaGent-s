@extends('layouts.transactional')

@section('title', 'Checkout - Nirwana Gents')
@section('step_label', 'Cart, Checkout, Success')

@section('content')
<x-section-intro eyebrow="Checkout" title="Isi data dan pastikan order." description="Harga dihitung ulang dari database. Pembayaran simulasi, status diatur admin." />

@if ($errors->any())
    <div role="alert" class="mt-6 rounded-core border border-red-900/20 bg-red-50 px-4 py-3 text-sm">
        @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<div class="mt-8 grid gap-6 lg:grid-cols-[1fr_320px]">
    <form method="POST" action="/checkout" class="grid gap-6" aria-label="Form checkout">
        @csrf
        <fieldset class="rounded-shell border border-espresso/10 bg-white/40 p-6">
            <legend class="px-2 font-display text-xl">Data penerima</legend>
            <div class="grid gap-4">
                <div>
                    <label for="customer_name" class="text-sm font-semibold">Nama</label>
                    <input id="customer_name" name="customer_name" value="{{ old('customer_name', $user->name) }}" required maxlength="100" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
                </div>
                <div>
                    <label for="customer_phone" class="text-sm font-semibold">Telepon</label>
                    <input id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $user->phone) }}" required maxlength="30" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
                </div>
            </div>
        </fieldset>

        <fieldset class="rounded-shell border border-espresso/10 bg-white/40 p-6">
            <legend class="px-2 font-display text-xl">Pengambilan</legend>
            <div class="grid gap-2">
                <label class="flex cursor-pointer items-center gap-2 rounded-core border border-espresso/15 px-4 py-3 has-checked:border-brass has-checked:bg-brass/10">
                    <input type="radio" name="fulfillment" value="pickup" class="accent-[#B18A4A]" @checked(old('fulfillment', 'pickup') === 'pickup') required> <strong>Ambil di tempat</strong> <span class="text-xs text-taupe">Gratis</span>
                </label>
                <label class="flex cursor-pointer items-center gap-2 rounded-core border border-espresso/15 px-4 py-3 has-checked:border-brass has-checked:bg-brass/10">
                    <input type="radio" name="fulfillment" value="delivery" class="accent-[#B18A4A]" @checked(old('fulfillment') === 'delivery') required> <strong>Diantar</strong> <span class="text-xs text-taupe">Rp 15.000 (sample)</span>
                </label>
            </div>
            <div class="mt-4">
                <label for="shipping_address" class="text-sm font-semibold">Alamat (wajib bila diantar)</label>
                <textarea id="shipping_address" name="shipping_address" rows="3" maxlength="500" class="mt-1 w-full rounded-core border border-espresso/20 bg-warm-cream px-4 py-3 text-sm">{{ old('shipping_address') }}</textarea>
            </div>
        </fieldset>

        <fieldset class="rounded-shell border border-espresso/10 bg-white/40 p-6">
            <legend class="px-2 font-display text-xl">Pembayaran (simulasi)</legend>
            <div class="grid gap-2">
                <label class="flex cursor-pointer items-center gap-2 rounded-core border border-espresso/15 px-4 py-3 has-checked:border-brass has-checked:bg-brass/10">
                    <input type="radio" name="payment_method" value="qris" class="accent-[#B18A4A]" @checked(old('payment_method', 'qris') === 'qris') required> <strong>QRIS</strong> <span class="text-xs text-taupe">Simulasi, tunjukkan bukti ke admin</span>
                </label>
                <label class="flex cursor-pointer items-center gap-2 rounded-core border border-espresso/15 px-4 py-3 has-checked:border-brass has-checked:bg-brass/10">
                    <input type="radio" name="payment_method" value="transfer" class="accent-[#B18A4A]" @checked(old('payment_method') === 'transfer') required> <strong>Transfer bank</strong> <span class="text-xs text-taupe">Simulasi</span>
                </label>
                <label class="flex cursor-pointer items-center gap-2 rounded-core border border-espresso/15 px-4 py-3 has-checked:border-brass has-checked:bg-brass/10">
                    <input type="radio" name="payment_method" value="cash_on_pickup" class="accent-[#B18A4A]" @checked(old('payment_method') === 'cash_on_pickup') required> <strong>Cash on pickup</strong> <span class="text-xs text-taupe">Bayar saat ambil</span>
                </label>
            </div>
        </fieldset>

        <button type="submit" class="inline-flex min-h-[44px] items-center justify-center rounded-pill bg-near-black px-6 py-3 text-sm font-semibold text-warm-cream hover:bg-espresso">Place order</button>
    </form>

    <aside class="h-fit rounded-shell border border-espresso/10 bg-white/40 p-6 lg:sticky lg:top-6" aria-label="Ringkasan order">
        <h2 class="font-display text-xl">Order summary</h2>
        <ul class="mt-3 space-y-2 text-sm">
            @foreach ($items as $item)
                <li class="flex justify-between gap-2"><span>{{ $item->product->name }} x {{ $item->quantity }}</span><strong>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</strong></li>
            @endforeach
        </ul>
        <p class="mt-4 flex justify-between text-sm"><span>Subtotal</span><strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></p>
        <p class="mt-1 text-xs text-taupe">Total final = subtotal + ongkir, dihitung server.</p>
    </aside>
</div>
@endsection
