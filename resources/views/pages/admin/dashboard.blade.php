@extends('layouts.admin')

@section('title', 'Admin Dashboard - Nirwana Gents')
@section('heading', 'Dashboard')

@section('content')
<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="rounded-core border border-espresso/10 bg-white/50 p-5">
        <p class="text-xs uppercase tracking-widest text-taupe">Booking hari ini</p>
        <p class="mt-1 font-display text-4xl">{{ $todayCount }}</p>
    </div>
    <div class="rounded-core border border-espresso/10 bg-white/50 p-5">
        <p class="text-xs uppercase tracking-widest text-taupe">Booking pending</p>
        <p class="mt-1 font-display text-4xl">{{ $pendingBookings }}</p>
        <a href="/admin/bookings?status=pending" class="mt-2 inline-flex min-h-[44px] items-center text-sm font-semibold underline underline-offset-4 decoration-brass decoration-2">Proses</a>
    </div>
    <div class="rounded-core border border-espresso/10 bg-white/50 p-5">
        <p class="text-xs uppercase tracking-widest text-taupe">Order pending</p>
        <p class="mt-1 font-display text-4xl">{{ $pendingOrders }}</p>
        <a href="/admin/orders?status=pending" class="mt-2 inline-flex min-h-[44px] items-center text-sm font-semibold underline underline-offset-4 decoration-brass decoration-2">Proses</a>
    </div>
    <div class="rounded-core border border-espresso/10 bg-white/50 p-5">
        <p class="text-xs uppercase tracking-widest text-taupe">Revenue hari ini</p>
        <p class="mt-1 font-display text-4xl">Rp {{ number_format($revenueToday, 0, ',', '.') }}</p>
        <p class="mt-1 text-xs text-taupe">Dari order tersimpan, bukan proyeksi.</p>
    </div>
</div>

<div class="mt-6 grid gap-4 lg:grid-cols-2">
    <div class="rounded-shell border border-espresso/10 bg-white/40 p-5">
        <h2 class="font-display text-xl">Jadwal hari ini</h2>
        @if ($todayBookings->isEmpty())
            <p class="mt-2 text-sm text-espresso/70">Tidak ada jadwal hari ini.</p>
        @else
            <ul class="mt-3 space-y-2 text-sm">
                @foreach ($todayBookings as $b)
                    <li class="flex items-center justify-between gap-2 border-b border-espresso/10 pb-2">
                        <span>{{ substr($b->start_time, 0, 5) }} {{ $b->service->name }} ({{ $b->barber->name }})</span>
                        <a href="/admin/bookings/{{ $b->id }}" class="font-semibold underline underline-offset-4 decoration-brass decoration-2">{{ $b->status }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <div class="rounded-shell border border-espresso/10 bg-white/40 p-5">
        <h2 class="font-display text-xl">Stock menipis (maks 3)</h2>
        @if ($lowStock->isEmpty())
            <p class="mt-2 text-sm text-espresso/70">Semua stock aman.</p>
        @else
            <ul class="mt-3 space-y-2 text-sm">
                @foreach ($lowStock as $p)
                    <li class="flex items-center justify-between gap-2 border-b border-espresso/10 pb-2">
                        <span>{{ $p->name }} ({{ $p->stock }})</span>
                        <a href="/admin/products/{{ $p->id }}/edit" class="font-semibold underline underline-offset-4 decoration-brass decoration-2">Kelola</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<div class="mt-4 grid gap-4 lg:grid-cols-2">
    <div class="rounded-shell border border-espresso/10 bg-white/40 p-5">
        <h2 class="font-display text-xl">Order terbaru</h2>
        <ul class="mt-3 space-y-2 text-sm">
            @forelse ($recentOrders as $o)
                <li class="flex items-center justify-between gap-2 border-b border-espresso/10 pb-2">
                    <span class="font-mono">{{ $o->reference }}</span>
                    <a href="/admin/orders/{{ $o->id }}" class="font-semibold underline underline-offset-4 decoration-brass decoration-2">{{ $o->status }}</a>
                </li>
            @empty
                <li class="text-espresso/70">Belum ada order.</li>
            @endforelse
        </ul>
    </div>
    <div class="rounded-shell border border-espresso/10 bg-white/40 p-5">
        <h2 class="font-display text-xl">Pesan kontak ({{ $unreadMessages }} belum dibaca)</h2>
        <ul class="mt-3 space-y-2 text-sm">
            @forelse ($recentMessages as $m)
                <li class="border-b border-espresso/10 pb-2"><strong>{{ $m->name }}</strong> <span class="text-taupe">({{ $m->email }})</span><br>{{ \Illuminate\Support\Str::limit($m->message, 90) }}</li>
            @empty
                <li class="text-espresso/70">Belum ada pesan.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
