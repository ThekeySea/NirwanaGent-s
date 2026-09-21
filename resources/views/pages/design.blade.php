@extends('layouts.public')

@section('title', 'Design System - Nirwana Gents (SAMPLE)')
@section('meta_description', 'Preview komponen design system Nirwana Gents. Semua data bertanda sample.')

@section('content')
<div class="mx-auto max-w-6xl px-5 pt-28 pb-20 md:pt-44">
    <x-section-intro
        eyebrow="Fase 1: Design system"
        title="Komponen dasar yang dipakai di semua halaman."
        description="Semua contoh di bawah memakai data sample yang ditandai jelas. Tidak ada klaim harga, rating, atau stok nyata di sini."
    />

    <div class="mt-10 flex flex-wrap items-center gap-2" aria-label="Contoh status">
        <x-status-badge status="pending" />
        <x-status-badge status="confirmed" />
        <x-status-badge status="processing" />
        <x-status-badge status="ready" />
        <x-status-badge status="completed" />
        <x-status-badge status="cancelled" />
        <x-status-badge status="sample" />
    </div>

    <div class="mt-8 flex flex-wrap gap-3">
        <x-button href="/booking" variant="primary">Book an Appointment</x-button>
        <x-button href="/services" variant="outline">View Services</x-button>
        <x-button href="/booking" variant="brass">Book an Appointment</x-button>
    </div>

    <hr class="my-14 border-espresso/10">

    <x-section-intro
        eyebrow="Services (sample)"
        title="Layanan ditampilkan dengan harga dan durasi apa adanya."
    />
    <div class="mt-8 grid gap-5 md:grid-cols-2">
        <x-service-card
            name="Classic Haircut (SAMPLE)"
            price="Rp TBD"
            duration="45 menit (sample)"
            description="Potong presisi, cuci, dan styling akhir sesuai bentuk kepala."
            href="/services/sample"
        />
        <x-service-card
            name="Beard Trim (SAMPLE)"
            price="Rp TBD"
            duration="30 menit (sample)"
            description="Rapikan garis jenggot, towel hangat, dan finishing oil."
            href="/services/sample"
        />
    </div>

    <hr class="my-14 border-espresso/10">

    <x-section-intro
        eyebrow="Barbers (sample)"
        title="Profil singkat tanpa pengalaman fiktif."
    />
    <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <x-barber-card name="Arya (SAMPLE)" role="Barber" specialties="Classic cut, fade" href="/barbers/sample" image="/images/barber-arya.jpg" imageAlt="Foto Arya (SAMPLE)" />
        <x-barber-card name="Bagas (SAMPLE)" role="Senior Barber" specialties="Beard trim, styling" href="/barbers/sample" />
        <x-barber-card name="Cakra (SAMPLE)" role="Barber" specialties="Kids cut, classic cut" href="/barbers/sample" />
    </div>

    <hr class="my-14 border-espresso/10">

    <x-section-intro
        eyebrow="Shop (sample)"
        title="Produk dengan status stock jujur."
    />
    <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <x-product-card name="Pomade Classic (SAMPLE)" price="Rp TBD" stockLabel="12 pcs di sample" stockStatus="active" href="/shop/sample" image="/images/product-pomade.jpg" />
        <x-product-card name="Beard Oil (SAMPLE)" price="Rp TBD" stockLabel="2 pcs, hampir habis (sample)" stockStatus="low" href="/shop/sample" />
        <x-product-card name="Clay Matte (SAMPLE)" price="Rp TBD" stockLabel="Nonaktif di sample" stockStatus="inactive" href="/shop/sample" />
    </div>

    <hr class="my-14 border-espresso/10">

    <x-section-intro
        eyebrow="Gallery (sample)"
        title="Grid editorial, foto final menyusul."
    />
    <div class="mt-8">
        <x-gallery-grid />
    </div>

    <div class="mt-14">
        <x-booking-cta />
    </div>
</div>
@endsection
