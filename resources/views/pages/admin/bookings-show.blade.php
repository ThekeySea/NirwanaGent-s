@extends('layouts.admin')

@section('title', 'Booking ' . $booking->reference . ' - Nirwana Gents')
@section('heading', 'Booking ' . $booking->reference)

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
        <div class="flex items-center gap-2"><x-status-badge :status="$booking->status" /><span class="font-mono font-semibold">{{ $booking->reference }}</span></div>
        <dl class="mt-4 space-y-2">
            <div><dt class="text-taupe">Customer</dt><dd class="font-semibold">{{ $booking->user->name }} ({{ $booking->user->email }}, {{ $booking->user->phone ?? '-' }})</dd></div>
            <div><dt class="text-taupe">Service</dt><dd class="font-semibold">{{ $booking->service->name }}</dd></div>
            <div><dt class="text-taupe">Barber</dt><dd class="font-semibold">{{ $booking->barber->name }}</dd></div>
            <div><dt class="text-taupe">Jadwal</dt><dd class="font-semibold">{{ $booking->appointment_date }} {{ substr($booking->start_time, 0, 5) }} sampai {{ substr($booking->end_time, 0, 5) }}</dd></div>
            @if ($booking->notes)<div><dt class="text-taupe">Catatan</dt><dd>{{ $booking->notes }}</dd></div>@endif
        </dl>
    </div>
    <div class="h-fit rounded-shell border border-espresso/10 bg-white/40 p-6">
        <h2 class="font-display text-xl">Ubah status</h2>
        @if (empty($allowed))
            <p class="mt-2 text-sm text-espresso/70">Status final ({{ $booking->status }}). Tidak bisa diubah lagi tanpa proses yang jelas.</p>
        @else
            <form method="POST" action="/admin/bookings/{{ $booking->id }}/status" class="mt-3 grid gap-2">
                @csrf
                @method('PATCH')
                <label class="text-sm font-semibold" for="status">Status baru</label>
                <select id="status" name="status" class="min-h-[44px] rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
                    @foreach ($allowed as $s)
                        <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="inline-flex min-h-[44px] items-center justify-center rounded-pill bg-near-black px-5 py-2 text-sm font-semibold text-warm-cream hover:bg-espresso">Simpan status</button>
            </form>
            <p class="mt-2 text-xs text-taupe">Aturan: pending ke confirmed/cancelled, confirmed ke completed/cancelled.</p>
        @endif
    </div>
</div>
@endsection
