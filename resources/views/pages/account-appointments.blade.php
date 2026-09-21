@extends('layouts.public')

@section('title', 'My Appointments - Nirwana Gents')
@section('meta_description', 'Riwayat appointment customer Nirwana Gents.')

@section('content')
<div class="mx-auto max-w-6xl px-5 pt-28 pb-16 md:pt-44">
    <x-section-intro eyebrow="Account" title="My Appointments." description="Batal mandiri bisa sampai 3 jam sebelum mulai. Setelah itu hubungi barbershop." />

    @if (session('status'))
        <p role="status" class="mt-6 rounded-core border border-emerald-900/25 bg-emerald-900/10 px-4 py-3 text-sm">{{ session('status') }}</p>
    @endif
    @if ($errors->any())
        <div role="alert" class="mt-6 rounded-core border border-red-900/20 bg-red-50 px-4 py-3 text-sm">
            @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
        </div>
    @endif

    @php
    $groups = ['upcoming' => $upcoming, 'completed' => $completed, 'cancelled' => $cancelled];
    @endphp

    @foreach ($groups as $label => $list)
        <h2 class="mt-10 font-display text-2xl capitalize">{{ $label }} ({{ $list->count() }})</h2>
        @if ($list->isEmpty())
            <p class="mt-3 text-sm text-espresso/70">Tidak ada appointment {{ $label }}.</p>
        @else
            <ul class="mt-4 grid gap-4 md:grid-cols-2">
                @foreach ($list as $b)
                    <li class="rounded-shell border border-espresso/10 bg-white/40 p-5 text-sm">
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-mono font-semibold">{{ $b->reference }}</span>
                            <x-status-badge :status="$b->status" />
                        </div>
                        <p class="mt-3 font-display text-xl">{{ $b->service->name }}</p>
                        <p class="mt-1 text-espresso/75">{{ $b->barber->name }} | {{ $b->appointment_date->format('Y-m-d') }} {{ substr($b->start_time, 0, 5) }}</p>
                        @if ($label === 'upcoming' && $b->canBeCancelledByCustomer())
                            <form method="POST" action="/account/appointments/{{ $b->id }}/cancel" class="mt-4">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex min-h-[44px] items-center rounded-pill border border-red-900/30 px-5 py-2 font-semibold text-red-950 hover:bg-red-900/5">Cancel appointment</button>
                            </form>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    @endforeach
</div>
@endsection
