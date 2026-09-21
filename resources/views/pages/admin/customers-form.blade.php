@extends('layouts.admin')

@section('title', 'Edit Customer - Nirwana Gents')
@section('heading', 'Edit Customer')

@section('content')
@if ($errors->any())
    <div role="alert" class="mb-4 rounded-core border border-red-900/20 bg-red-50 px-4 py-3 text-sm">
        @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<form method="POST" action="/admin/customers/{{ $customer->id }}" class="grid max-w-xl gap-4 rounded-shell border border-espresso/10 bg-white/40 p-6" aria-label="Form customer">
    @csrf
    @method('PATCH')
    <div>
        <label for="name" class="text-sm font-semibold">Nama</label>
        <input id="name" name="name" value="{{ old('name', $customer->name) }}" required maxlength="100" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
    </div>
    <div>
        <label for="phone" class="text-sm font-semibold">Telepon</label>
        <input id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" required maxlength="30" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
    </div>
    <p class="text-xs text-taupe">Email dan role tidak bisa diubah dari sini untuk keamanan.</p>
    <div class="flex gap-2">
        <button type="submit" class="inline-flex min-h-[44px] items-center rounded-pill bg-near-black px-6 py-2 text-sm font-semibold text-warm-cream hover:bg-espresso">Simpan</button>
        <a href="/admin/customers/{{ $customer->id }}" class="inline-flex min-h-[44px] items-center rounded-pill border border-espresso/25 px-6 py-2 text-sm font-semibold">Batal</a>
    </div>
</form>
@endsection
