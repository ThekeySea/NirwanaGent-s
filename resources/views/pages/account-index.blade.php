@extends('layouts.public')

@section('title', 'Akun - Nirwana Gents')
@section('meta_description', 'Ringkasan akun customer Nirwana Gents.')

@section('content')
<div class="mx-auto max-w-6xl px-5 pt-28 pb-16 md:pt-44">
    <x-section-intro eyebrow="Account" title="Halo, {{ $user->name }}." description="Kelola profil, lihat appointment dan order." />

    <div class="mt-8 grid gap-5 md:grid-cols-3">
        <div class="rounded-shell border border-espresso/10 bg-white/40 p-6">
            <p class="font-display text-xl">Profil</p>
            <p class="mt-2 text-sm text-espresso/75">{{ $user->email }}<br>{{ $user->phone ?? 'Telepon belum diisi' }}</p>
            <a href="/account/profile" class="mt-4 inline-flex min-h-[44px] items-center text-sm font-semibold underline underline-offset-4 decoration-brass decoration-2">Ubah profil</a>
        </div>
        <div class="rounded-shell border border-espresso/10 bg-white/40 p-6">
            <p class="font-display text-xl">Appointments</p>
            <p class="mt-2 text-sm text-espresso/75">Upcoming, completed, dan cancelled.</p>
            <a href="/account/appointments" class="mt-4 inline-flex min-h-[44px] items-center text-sm font-semibold underline underline-offset-4 decoration-brass decoration-2">Lihat appointments</a>
        </div>
        <div class="rounded-shell border border-espresso/10 bg-white/40 p-6">
            <p class="font-display text-xl">Orders</p>
            <p class="mt-2 text-sm text-espresso/75">Riwayat order dan status pembayaran.</p>
            <a href="/account/orders" class="mt-4 inline-flex min-h-[44px] items-center text-sm font-semibold underline underline-offset-4 decoration-brass decoration-2">Lihat orders</a>
        </div>
    </div>

    <form method="POST" action="/logout" class="mt-8">
        @csrf
        <button type="submit" class="inline-flex min-h-[44px] items-center justify-center rounded-pill border border-espresso/25 px-6 py-3 text-sm font-semibold hover:border-espresso/60">Keluar</button>
    </form>
</div>
@endsection
