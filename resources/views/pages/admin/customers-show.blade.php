@extends('layouts.admin')

@section('title', 'Customer ' . $customer->name . ' - Nirwana Gents')
@section('heading', $customer->name)

@section('content')
@if (session('status'))
    <p role="status" class="mb-4 rounded-core border border-emerald-900/25 bg-emerald-900/10 px-4 py-3 text-sm">{{ session('status') }}</p>
@endif

<div class="grid gap-4 lg:grid-cols-2">
    <div class="rounded-shell border border-espresso/10 bg-white/40 p-6 text-sm">
        <p><span class="text-taupe">Email:</span> <strong>{{ $customer->email }}</strong></p>
        <p class="mt-1"><span class="text-taupe">Telepon:</span> <strong>{{ $customer->phone ?? '-' }}</strong></p>
        <a href="/admin/customers/{{ $customer->id }}/edit" class="mt-4 inline-flex min-h-[44px] items-center rounded-pill border border-espresso/25 px-5 py-2 font-semibold">Edit nama/telepon</a>
    </div>
    <div class="rounded-shell border border-espresso/10 bg-white/40 p-6 text-sm">
        <h2 class="font-display text-xl">5 booking terakhir</h2>
        <ul class="mt-3 space-y-2">
            @forelse ($bookings as $b)
                <li class="flex justify-between gap-2 border-b border-espresso/10 pb-2"><span class="font-mono">{{ $b->reference }}</span><span>{{ $b->status }}</span></li>
            @empty
                <li class="text-espresso/70">Belum ada booking.</li>
            @endforelse
        </ul>
        <h2 class="mt-5 font-display text-xl">5 order terakhir</h2>
        <ul class="mt-3 space-y-2">
            @forelse ($orders as $o)
                <li class="flex justify-between gap-2 border-b border-espresso/10 pb-2"><span class="font-mono">{{ $o->reference }}</span><span>{{ $o->status }}</span></li>
            @empty
                <li class="text-espresso/70">Belum ada order.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
