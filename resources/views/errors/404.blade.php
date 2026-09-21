@extends('layouts.transactional')

@section('title', 'Halaman tidak ditemukan - Nirwana Gents')
@section('step_label', 'Error 404')

@section('content')
<x-section-intro eyebrow="Error 404" title="Halaman tidak ada." description="Alamat mungkin salah ketik atau konten sudah dipindah. Pilih jalan berikut." />
<div class="mt-8 flex flex-wrap gap-3">
    <x-button href="/" variant="primary">Kembali ke beranda</x-button>
    <x-button href="/services" variant="outline">View Services</x-button>
</div>
@endsection
