@extends('layouts.public')

@section('title', 'Nirwana Gents - Classic Style. Timeless Confidence.')
@section('meta_description', 'Nirwana Gents: company profile, booking barber, dan grooming store. Harga dan jadwal final mengikuti data sistem.')

@section('content')
<x-hero
    eyebrow="Barbershop premium"
    title="Classic Style. Timeless Confidence."
    description="Potong presisi dan grooming pria dalam ruang hangat. Pilih layanan, barber, dan jam yang pas, lalu booking dalam beberapa langkah."
    primaryLabel="Book an Appointment"
    primaryHref="/booking"
    secondaryLabel="View Services"
    secondaryHref="/services"
>
    <div class="flex min-h-[320px] flex-col justify-end bg-near-black p-7 md:min-h-[420px]">
        <p class="font-display text-3xl text-warm-cream">Ruang potong yang tenang dan terang.</p>
        <p class="mt-2 text-xs uppercase tracking-widest text-brass">Foto interior final menyusul (sample)</p>
    </div>
</x-hero>

<section class="mx-auto max-w-6xl px-5 py-6" aria-label="Layanan unggulan">
    <x-section-intro
        eyebrow="Layanan (sample)"
        title="Mulai dari potong klasik sampai perawatan jenggot."
        description="Harga dan durasi di bawah masih sample. Data final ditulis setelah daftar resmi tersedia."
    />
    <div class="mt-8 grid gap-5 md:grid-cols-2">
        <x-service-card
            name="Classic Haircut (SAMPLE)"
            price="Rp TBD"
            duration="45 menit (sample)"
            description="Potong presisi, cuci, dan styling akhir."
            href="/services/sample"
        />
        <x-service-card
            name="Beard Trim (SAMPLE)"
            price="Rp TBD"
            duration="30 menit (sample)"
            description="Garis jenggot rapi, towel hangat, finishing oil."
            href="/services/sample"
        />
    </div>
</section>

<div class="mt-10">
    <x-booking-cta />
</div>

<section class="mx-auto max-w-6xl px-5 py-14" aria-label="Status fondasi">
    <div class="rounded-shell border border-espresso/10 bg-white/40 p-6 text-sm leading-relaxed md:p-8">
        <p class="font-semibold">Fase 1 selesai: design system dasar siap dipakai Fase 2.</p>
        <p class="mt-2 text-espresso/75">Lihat semua varian di <a class="underline underline-offset-4 decoration-brass decoration-2" href="/design">/design</a> (non-production). Token: espresso, near-black, warm-cream, brass, taupe. Font: Cormorant Garamond + Manrope (self-hosted).</p>
    </div>
</section>
@endsection
