@extends('layouts.public')

@section('title', 'Nirwana Gents - Classic Style. Timeless Confidence.')
@section('meta_description', 'Nirwana Gents: company profile, booking barber, dan grooming store. Fondasi Fase 0 siap untuk pengembangan Fase 1.')

@section('content')
<section class="mx-auto max-w-6xl px-5 pt-36 pb-16 md:pt-44">
    <div class="grid items-end gap-10 md:grid-cols-[1.2fr_0.8fr]">
        <div class="reveal">
            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-brass">Fase 0: Fondasi</p>
            <h1 class="mt-4 font-display text-5xl leading-[1.02] tracking-tight md:text-7xl">Classic Style.<br>Timeless Confidence.</h1>
            <p class="mt-6 max-w-xl leading-relaxed text-espresso/80">Layout public, transaksional, dan admin sudah tersedia. Token warna, tipografi, dan motion dasar mengikuti Nirwana-docs. Konten lengkap, booking, dan shop dibangun di fase berikutnya.</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ url('/booking') }}" class="rounded-pill bg-near-black px-6 py-3 text-sm font-semibold text-warm-cream hover:bg-espresso active:scale-[0.99]">Book an Appointment</a>
                <a href="{{ url('/services') }}" class="rounded-pill border border-espresso/20 px-6 py-3 text-sm font-semibold hover:border-espresso/50">View Services</a>
            </div>
        </div>
        <div class="reveal rounded-shell border border-espresso/10 bg-near-black p-8 text-warm-cream">
            <p class="text-sm text-brass">Status setup</p>
            <ul class="mt-3 space-y-2 text-sm leading-relaxed">
                <li>Database: MySQL <code>nirwanagents</code> termigrasi</li>
                <li>Storage: <code>public/storage</code> terhubung</li>
                <li>Token: espresso, near-black, warm-cream, brass, taupe</li>
                <li>Font: self-hosted placeholder di <code>public/fonts</code></li>
            </ul>
        </div>
    </div>
</section>
@endsection
