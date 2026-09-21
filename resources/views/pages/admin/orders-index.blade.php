@extends('layouts.admin')

@section('title', 'Admin Orders - Nirwana Gents')
@section('heading', 'Orders')

@section('content')
<form method="GET" action="/admin/orders" class="mb-4 flex flex-wrap gap-2" aria-label="Filter orders">
    <select name="status" class="min-h-[44px] rounded-pill border border-espresso/20 bg-warm-cream px-4 text-sm">
        <option value="">Semua status</option>
        @foreach (['pending', 'confirmed', 'processing', 'ready', 'completed', 'cancelled'] as $s)
            <option value="{{ $s }}" @selected($status === $s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <button type="submit" class="inline-flex min-h-[44px] items-center rounded-pill border border-espresso/25 px-5 py-2 text-sm font-semibold">Filter</button>
</form>

<div class="overflow-x-auto rounded-shell border border-espresso/10 bg-white/40">
    <table class="w-full min-w-[760px] text-left text-sm">
        <thead>
            <tr class="border-b border-espresso/10 text-xs uppercase tracking-widest text-taupe">
                <th class="px-4 py-3">Ref</th>
                <th class="px-4 py-3">Total</th>
                <th class="px-4 py-3">Bayar</th>
                <th class="px-4 py-3">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $o)
                <tr class="border-b border-espresso/5">
                    <td class="px-4 py-3 font-mono font-semibold"><a href="/admin/orders/{{ $o->id }}" class="underline underline-offset-4 decoration-brass decoration-2">{{ $o->reference }}</a><br><span class="font-sans text-xs font-normal text-taupe">{{ $o->user->name ?? '' }}</span></td>
                    <td class="px-4 py-3 font-semibold">{{ $o->formattedTotal() }}</td>
                    <td class="px-4 py-3">{{ $o->payment_method }} ({{ $o->payment_status }})</td>
                    <td class="px-4 py-3"><x-status-badge :status="$o->status" /></td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-espresso/70">Tidak ada order untuk filter ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $orders->links() }}</div>
@endsection
