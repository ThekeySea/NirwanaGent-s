@extends('layouts.public')

@section('title', 'Services - Nirwana Gents')
@section('meta_description', 'Daftar layanan Nirwana Gents dengan harga dan durasi tertulis. Data sample ditandai jelas.')

@section('content')
<div class="mx-auto max-w-6xl px-5 pt-36 pb-16 md:pt-44">
    <x-section-intro
        eyebrow="Services"
        title="Pilih layanan sesuai kebutuhan."
        description="Semua entri di bawah berasal dari database. Entri bertanda sample masih menunggu daftar resmi."
    />
    <div class="mt-8 grid gap-5 md:grid-cols-2">
        @forelse ($services as $service)
            <x-service-card
                :name="$service->name"
                :price="$service->formattedPrice()"
                :duration="$service->duration_minutes . ' menit'"
                :description="$service->description"
                :href="'/services/' . $service->slug"
                :isSample="str_contains($service->slug, 'sample')"
            />
        @empty
            <p class="text-sm text-espresso/70">Belum ada layanan aktif.</p>
        @endforelse
    </div>
</div>
@endsection
