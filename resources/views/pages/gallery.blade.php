@extends('layouts.public')

@section('title', 'Gallery - Nirwana Gents')
@section('meta_description', 'Galeri suasana dan detail kerja Nirwana Gents. Foto final menyusul.')

@section('content')
<div class="mx-auto max-w-6xl px-5 pt-28 pb-16 md:pt-44">
    <x-section-intro
        eyebrow="Gallery"
        title="Lihat ruang dan detailnya."
        description="Grid di bawah memakai placeholder sampai foto resmi tersedia. Setiap gambar punya alt yang menjelaskan isi."
    />
    <div class="mt-8">
        <x-gallery-grid :images="$items->map(fn ($m) => ['src' => $m->path ?: null, 'alt' => $m->alt, 'caption' => $m->caption])->all()" />
    </div>
</div>
@endsection
