@extends('layouts.admin')

@section('title', 'Admin Bookings - Nirwana Gents')
@section('heading', 'Bookings')

@section('content')
<form method="GET" action="/admin/bookings" class="mb-4 flex flex-wrap gap-2" aria-label="Filter bookings">
    <select name="status" class="min-h-[44px] rounded-pill border border-espresso/20 bg-warm-cream px-4 text-sm">
        <option value="">Semua status</option>
        @foreach (['pending', 'confirmed', 'completed', 'cancelled'] as $s)
            <option value="{{ $s }}" @selected($status === $s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <input type="date" name="date" value="{{ $date }}" class="min-h-[44px] rounded-pill border border-espresso/20 bg-warm-cream px-4 text-sm" aria-label="Filter tanggal">
    <button type="submit" class="inline-flex min-h-[44px] items-center rounded-pill border border-espresso/25 px-5 py-2 text-sm font-semibold">Filter</button>
</form>

<div class="overflow-x-auto rounded-shell border border-espresso/10 bg-white/40">
    <table class="w-full min-w-[820px] text-left text-sm">
        <thead>
            <tr class="border-b border-espresso/10 text-xs uppercase tracking-widest text-taupe">
                <th class="px-4 py-3">Ref</th>
                <th class="px-4 py-3">Jadwal</th>
                <th class="px-4 py-3">Service / Barber</th>
                <th class="px-4 py-3">Customer</th>
                <th class="px-4 py-3">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $b)
                <tr class="border-b border-espresso/5">
                    <td class="px-4 py-3 font-mono font-semibold"><a href="/admin/bookings/{{ $b->id }}" class="underline underline-offset-4 decoration-brass decoration-2">{{ $b->reference }}</a></td>
                    <td class="px-4 py-3">{{ $b->appointment_date }} {{ substr($b->start_time, 0, 5) }}</td>
                    <td class="px-4 py-3">{{ $b->service->name }}<br><span class="text-taupe">{{ $b->barber->name }}</span></td>
                    <td class="px-4 py-3">{{ $b->user->name ?? '-' }}</td>
                    <td class="px-4 py-3"><x-status-badge :status="$b->status" /></td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-6 text-espresso/70">Tidak ada booking untuk filter ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $bookings->links() }}</div>
@endsection
