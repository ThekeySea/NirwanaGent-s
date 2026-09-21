@extends('layouts.admin')

@section('title', 'Order ' . $order->reference . ' - Nirwana Gents')
@section('heading', 'Order ' . $order->reference)

@section('content')
@if (session('status'))
    <p role="status" class="mb-4 rounded-core border border-emerald-900/25 bg-emerald-900/10 px-4 py-3 text-sm">{{ session('status') }}</p>
@endif
@if ($errors->any())
    <div role="alert" class="mb-4 rounded-core border border-red-900/20 bg-red-50 px-4 py-3 text-sm">
        @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<div class="grid gap-4 lg:grid-cols-[1fr_320px]">
    <div class="rounded-shell border border-espresso/10 bg-white/40 p-6 text-sm">
        <div class="flex items-center gap-2"><x-status-badge :status="$order->status" /><span class="font-mono font-semibold">{{ $order->reference }}</span></div>
        <ul class="mt-4 space-y-2">
            @foreach ($order->items as $item)
                <li class="flex justify-between gap-2"><span>{{ $item->product_name_snapshot }} x {{ $item->quantity }}</span><strong>Rp {{ number_format($item->line_total, 0, ',', '.') }}</strong></li>
            @endforeach
        </ul>
        <dl class="mt-4 space-y-1">
            <div class="flex justify-between"><dt class="text-taupe">Subtotal</dt><dd>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</dd></div>
            <div class="flex justify-between"><dt class="text-taupe">Ongkir</dt><dd>Rp {{ number_format($order->shipping_fee, 0, ',', '.') }}</dd></div>
            <div class="flex justify-between font-semibold"><dt>Total</dt><dd>{{ $order->formattedTotal() }}</dd></div>
            <div class="flex justify-between"><dt class="text-taupe">Customer</dt><dd>{{ $order->customer_name }} ({{ $order->customer_phone }})</dd></div>
            @if ($order->shipping_address)<div><dt class="text-taupe">Alamat</dt><dd>{{ $order->shipping_address }}</dd></div>@endif
        </dl>
    </div>
    <div class="h-fit rounded-shell border border-espresso/10 bg-white/40 p-6">
        <h2 class="font-display text-xl">Ubah status</h2>
        @if (empty($allowed))
            <p class="mt-2 text-sm text-espresso/70">Status final ({{ $order->status }}). Tidak bisa diubah lagi.</p>
        @else
            <form method="POST" action="/admin/orders/{{ $order->id }}/status" class="mt-3 grid gap-3">
                @csrf
                @method('PATCH')
                <div>
                    <label class="text-sm font-semibold" for="status">Status baru</label>
                    <select id="status" name="status" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
                        @foreach ($allowed as $s)
                            <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold" for="payment_status">Payment status</label>
                    <select id="payment_status" name="payment_status" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
                        @foreach (['pending', 'paid', 'failed', 'refunded'] as $p)
                            <option value="{{ $p }}" @selected($order->payment_status === $p)>{{ ucfirst($p) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="inline-flex min-h-[44px] items-center justify-center rounded-pill bg-near-black px-5 py-2 text-sm font-semibold text-warm-cream hover:bg-espresso">Simpan status</button>
            </form>
            <p class="mt-2 text-xs text-taupe">Aturan: pending ke confirmed/cancelled, confirmed ke processing, processing ke ready, ready ke completed.</p>
        @endif
    </div>
</div>
@endsection
