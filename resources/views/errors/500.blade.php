@extends('layouts.transactional')

@section('title', 'Gangguan server - Nirwana Gents')
@section('step_label', 'Error 500')

@section('content')
<x-section-intro eyebrow="Error 500" title="Ada gangguan di server." description="Coba lagi beberapa saat. Bila booking atau order sudah terkirim, cek status di akun sebelum mengulang." />
<div class="mt-8 flex flex-wrap gap-3">
    <x-button href="/account" variant="primary">Cek akun saya</x-button>
    <x-button href="/" variant="outline">Kembali ke beranda</x-button>
</div>
@endsection
