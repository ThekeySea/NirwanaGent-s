@extends('layouts.transactional')

@section('title', 'Sesi kedaluwarsa - Nirwana Gents')
@section('step_label', 'Error 419')

@section('content')
<x-section-intro eyebrow="Error 419" title="Sesi kedaluwarsa." description="Halaman terlalu lama terbuka. Muat ulang dan kirim lagi, data slot dan harga diambil baru dari sistem." />
<div class="mt-8 flex flex-wrap gap-3">
    <x-button href="/booking" variant="primary">Muat ulang booking</x-button>
    <x-button href="/" variant="outline">Kembali ke beranda</x-button>
</div>
@endsection
