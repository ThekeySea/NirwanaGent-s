@extends('layouts.public')

@section('title', 'Order ' . $order->reference . ' - Nirwana Gents')

@section('content')
<div class="mx-auto max-w-3xl px-5 pt-28 pb-16 md:pt-44">
    <a href="/account/orders" class="inline-flex min-h-[44px] items-center text-sm font-semibold text-taupe hover:text-espresso">&larr; Semua orders</a>
    <div class="mt-4 flex flex-wrap items-center gap-2">
        <h1 class="font-display text-4xl">{{ $order->reference }}</h1>
        <x-status-badge :status="$order->status" />
    </div>
    <div class="mt-6 rounded-shell border border-espresso/10 bg-white/40 p-6">
        <ul class="space-y-2 text-sm">
            @foreach ($order->items as $item)
                <li class="flex justify-between gap-2"><span>{{ $item->product_name_snapshot }} x {{ $item->quantity }} <span class="text-taupe">(@ Rp {{ number_format($item->unit_price, 0, ',', '.') }})</span></span><strong>Rp {{ number_format($item->line_total, 0, ',', '.') }}</strong></li>
            @endforeach
        </ul>
        <dl class="mt-4 space-y-1 text-sm">
            <div class="flex justify-between"><dt class="text-taupe">Subtotal</dt><dd>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</dd></div>
            <div class="flex justify-between"><dt class="text-taupe">Ongkir</dt><dd>Rp {{ number_format($order->shipping_fee, 0, ',', '.') }}</dd></div>
            <div class="flex justify-between font-semibold"><dt>Total</dt><dd>{{ $order->formattedTotal() }}</dd></div>
            <div class="flex justify-between"><dt class="text-taupe">Penerima</dt><dd>{{ $order->customer_name }} ({{ $order->customer_phone }})</dd></div>
            @if ($order->shipping_address)
                <div><dt class="text-taupe">Alamat</dt><dd>{{ $order->shipping_address }}</dd></div>
            @endif
        </dl>
    </div>
</div>
@endsection
