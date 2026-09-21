@extends('layouts.admin')

@section('title', ($service->exists ? 'Edit' : 'Tambah') . ' Service - Nirwana Gents')
@section('heading', ($service->exists ? 'Edit' : 'Tambah') . ' Service')

@section('content')
@if ($errors->any())
    <div role="alert" class="mb-4 rounded-core border border-red-900/20 bg-red-50 px-4 py-3 text-sm">
        @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<form method="POST" action="{{ $service->exists ? '/admin/services/' . $service->id : '/admin/services' }}" class="grid max-w-2xl gap-4 rounded-shell border border-espresso/10 bg-white/40 p-6" aria-label="Form service">
    @csrf
    @if ($service->exists)
        @method('PATCH')
    @endif
    <div>
        <label for="name" class="text-sm font-semibold">Nama</label>
        <input id="name" name="name" value="{{ old('name', $service->name) }}" required maxlength="100" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
    </div>
    <div>
        <label for="slug" class="text-sm font-semibold">Slug (kosongkan untuk otomatis)</label>
        <input id="slug" name="slug" value="{{ old('slug', $service->slug) }}" maxlength="120" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label for="price" class="text-sm font-semibold">Harga (rupiah, angka)</label>
            <input id="price" name="price" type="number" min="0" max="100000000" value="{{ old('price', $service->price) }}" required class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
        </div>
        <div>
            <label for="duration_minutes" class="text-sm font-semibold">Durasi (menit)</label>
            <input id="duration_minutes" name="duration_minutes" type="number" min="5" max="480" value="{{ old('duration_minutes', $service->duration_minutes) }}" required class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
        </div>
    </div>
    <div>
        <label for="description" class="text-sm font-semibold">Deskripsi</label>
        <textarea id="description" name="description" rows="3" maxlength="2000" class="mt-1 w-full rounded-core border border-espresso/20 bg-warm-cream px-4 py-3 text-sm">{{ old('description', $service->description) }}</textarea>
    </div>
    <div>
        <label for="inclusions" class="text-sm font-semibold">Termasuk (satu per baris)</label>
        <textarea id="inclusions" name="inclusions" rows="3" maxlength="2000" class="mt-1 w-full rounded-core border border-espresso/20 bg-warm-cream px-4 py-3 text-sm">{{ old('inclusions', $service->inclusions) }}</textarea>
    </div>
    <div>
        <label for="image_url" class="text-sm font-semibold">Image URL (opsional)</label>
        <input id="image_url" name="image_url" value="{{ old('image_url', $service->image_url) }}" maxlength="500" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
    </div>
    <fieldset>
        <legend class="text-sm font-semibold">Barber yang melayani</legend>
        <div class="mt-2 grid gap-2">
            @foreach ($barbers as $b)
                <label class="flex items-center gap-2 rounded-core border border-espresso/15 px-4 py-2 text-sm">
                    <input type="checkbox" name="barbers[]" value="{{ $b->id }}" @checked(in_array($b->id, old('barbers', $selected))) class="size-4 accent-[#B18A4A]"> {{ $b->name }}
                </label>
            @endforeach
        </div>
    </fieldset>
    <label class="flex items-center gap-2 text-sm font-semibold">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service->is_active)) class="size-4 accent-[#B18A4A]"> Aktif
    </label>
    <div class="flex gap-2">
        <button type="submit" class="inline-flex min-h-[44px] items-center rounded-pill bg-near-black px-6 py-2 text-sm font-semibold text-warm-cream hover:bg-espresso">Simpan</button>
        <a href="/admin/services" class="inline-flex min-h-[44px] items-center rounded-pill border border-espresso/25 px-6 py-2 text-sm font-semibold">Batal</a>
    </div>
</form>
@endsection
