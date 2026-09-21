@extends('layouts.transactional')

@section('title', 'Order ' . $order->reference . ' - Nirwana Gents')
@section('step_label', 'Success')

@section('content')
<x-section-intro eyebrow="Success" title="Order tersimpan." description="Tunjukkan referensi ini saat ambil atau konfirmasi pembayaran ke admin." />

<div class="mt-8 rounded-shell border border-espresso/10 bg-white/40 p-6 md:p-8">
    <div class="flex flex-wrap items-center gap-2">
        <x-status-badge :status="$order->status" />
        <span class="font-mono text-sm font-semibold">{{ $order->reference }}</span>
    </div>
    <ul class="mt-6 space-y-2 text-sm">
        @foreach ($order->items as $item)
            <li class="flex justify-between gap-2"><span>{{ $item->product_name_snapshot }} x {{ $item->quantity }}</span><strong>Rp {{ number_format($item->line_total, 0, ',', '.') }}</strong></li>
        @endforeach
    </ul>
    <dl class="mt-6 space-y-1 text-sm">
        <div class="flex justify-between"><dt class="text-taupe">Subtotal</dt><dd>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</dd></div>
        <div class="flex justify-between"><dt class="text-taupe">Ongkir ({{ $order->fulfillment }})</dt><dd>Rp {{ number_format($order->shipping_fee, 0, ',', '.') }}</dd></div>
        <div class="flex justify-between font-semibold"><dt>Total</dt><dd>{{ $order->formattedTotal() }}</dd></div>
        <div class="flex justify-between"><dt class="text-taupe">Pembayaran</dt><dd>{{ $order->payment_method }} ({{ $order->payment_status }})</dd></div>
    </dl>
    <div class="mt-6 flex flex-wrap gap-3">
        <x-button href="/account/orders" variant="primary">Lihat My Orders</x-button>
        <x-button href="/shop" variant="outline">Lanjut belanja</x-button>
    </div>
</div>
@endsection
