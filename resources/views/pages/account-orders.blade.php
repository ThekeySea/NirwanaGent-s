@extends('layouts.public')

@section('title', 'My Orders - Nirwana Gents')
@section('meta_description', 'Riwayat order customer Nirwana Gents.')

@section('content')
<div class="mx-auto max-w-6xl px-5 pt-28 pb-16 md:pt-44">
    <x-section-intro eyebrow="Account" title="My Orders." description="Harga tersimpan sebagai snapshot saat checkout, tetap benar walau produk berubah." />

    @if ($orders->isEmpty())
        <div class="mt-8 rounded-shell border border-espresso/10 bg-white/40 p-6 text-sm">
            <p class="font-semibold">Belum ada order.</p>
            <div class="mt-4"><x-button href="/shop" variant="primary">Lihat Shop</x-button></div>
        </div>
    @else
        <ul class="mt-8 grid gap-4 md:grid-cols-2">
            @foreach ($orders as $order)
                <li class="rounded-shell border border-espresso/10 bg-white/40 p-5 text-sm">
                    <div class="flex items-center justify-between gap-2">
                        <span class="font-mono font-semibold">{{ $order->reference }}</span>
                        <x-status-badge :status="$order->status" />
                    </div>
                    <p class="mt-3 font-semibold">{{ $order->formattedTotal() }} <span class="font-normal text-taupe">({{ $order->payment_method }})</span></p>
                    <a href="/account/orders/{{ $order->id }}" class="mt-3 inline-flex min-h-[44px] items-center font-semibold underline underline-offset-4 decoration-brass decoration-2">Detail order</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
