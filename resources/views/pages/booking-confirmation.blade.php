@extends('layouts.transactional')

@section('title', 'Booking ' . $booking->reference . ' - Nirwana Gents')
@section('step_label', 'Confirmed')

@section('content')
<x-section-intro eyebrow="Confirmed" title="Booking tercatat." description="Tunjukkan referensi ini saat datang. Status bisa dipantau di My Appointments." />

<div class="mt-8 rounded-shell border border-espresso/10 bg-white/40 p-6 md:p-8">
    <div class="flex flex-wrap items-center gap-2">
        <x-status-badge :status="$booking->status" />
        <span class="font-mono text-sm font-semibold">{{ $booking->reference }}</span>
    </div>
    <dl class="mt-6 grid gap-4 text-sm md:grid-cols-2">
        <div><dt class="text-taupe">Service</dt><dd class="font-semibold">{{ $booking->service->name }} ({{ $booking->service->formattedPrice() }})</dd></div>
        <div><dt class="text-taupe">Barber</dt><dd class="font-semibold">{{ $booking->barber->name }}</dd></div>
        <div><dt class="text-taupe">Tanggal</dt><dd class="font-semibold">{{ $booking->appointment_date->format('Y-m-d') }}</dd></div>
        <div><dt class="text-taupe">Jam</dt><dd class="font-semibold">{{ substr($booking->start_time, 0, 5) }} sampai {{ substr($booking->end_time, 0, 5) }}</dd></div>
    </dl>
    @if ($booking->notes)
        <p class="mt-4 text-sm"><span class="font-semibold">Catatan:</span> {{ $booking->notes }}</p>
    @endif
    <div class="mt-6 flex flex-wrap gap-3">
        <x-button href="/account/appointments" variant="primary">Lihat My Appointments</x-button>
        <x-button href="/" variant="outline">Kembali ke beranda</x-button>
    </div>
</div>
@endsection
