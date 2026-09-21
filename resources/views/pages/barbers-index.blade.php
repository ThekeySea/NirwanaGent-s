@extends('layouts.public')

@section('title', 'Barbers - Nirwana Gents')
@section('meta_description', 'Daftar barber Nirwana Gents dengan spesialisasi jelas. Tanpa klaim pengalaman fiktif.')

@section('content')
<div class="mx-auto max-w-6xl px-5 pt-36 pb-16 md:pt-44">
    <x-section-intro
        eyebrow="Barbers"
        title="Pilih yang memotong rambutmu."
        description="Spesialisasi tertulis apa adanya. Pengalaman dan rating tidak ditampilkan sampai data resmi tersedia."
    />
    <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($barbers as $barber)
            <x-barber-card
                :name="$barber->name"
                :role="$barber->role"
                :specialties="$barber->specialties ?? 'Spesialisasi menyusul'"
                :href="'/barbers/' . $barber->slug"
                :isSample="str_contains($barber->slug, 'sample')"
            />
        @empty
            <p class="text-sm text-espresso/70">Belum ada barber aktif.</p>
        @endforelse
    </div>
</div>
@endsection
