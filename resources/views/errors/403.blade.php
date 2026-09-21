@extends('layouts.transactional')

@section('title', 'Akses ditolak - Nirwana Gents')
@section('step_label', 'Error 403')

@section('content')
<x-section-intro eyebrow="Error 403" title="Kamu tidak punya akses." description="Halaman admin hanya untuk admin. Bila kamu customer, kembali ke akun atau beranda." />
<div class="mt-8 flex flex-wrap gap-3">
    <x-button href="/account" variant="primary">Ke akun saya</x-button>
    <x-button href="/" variant="outline">Kembali ke beranda</x-button>
</div>
@endsection
