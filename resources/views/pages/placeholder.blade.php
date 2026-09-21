@extends('layouts.transactional')

@section('title', $title ?? 'Segera hadir - Nirwana Gents')

@section('step_label', 'Info')

@section('content')
<x-section-intro eyebrow="Info" :title="$title ?? 'Segera hadir'" :description="$message ?? ''" />
<div class="mt-8 flex flex-wrap gap-3">
    <x-button href="/services" variant="primary">View Services</x-button>
    <x-button href="/shop" variant="outline">Lihat Shop</x-button>
</div>
@endsection
