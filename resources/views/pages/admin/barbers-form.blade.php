@extends('layouts.admin')

@section('title', ($barber->exists ? 'Edit' : 'Tambah') . ' Barber - Nirwana Gents')
@section('heading', ($barber->exists ? 'Edit' : 'Tambah') . ' Barber')

@section('content')
@if ($errors->any())
    <div role="alert" class="mb-4 rounded-core border border-red-900/20 bg-red-50 px-4 py-3 text-sm">
        @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<form method="POST" action="{{ $barber->exists ? '/admin/barbers/' . $barber->id : '/admin/barbers' }}" class="grid max-w-2xl gap-4 rounded-shell border border-espresso/10 bg-white/40 p-6" aria-label="Form barber">
    @csrf
    @if ($barber->exists)
        @method('PATCH')
    @endif
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label for="name" class="text-sm font-semibold">Nama</label>
            <input id="name" name="name" value="{{ old('name', $barber->name) }}" required maxlength="100" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
        </div>
        <div>
            <label for="role" class="text-sm font-semibold">Role</label>
            <input id="role" name="role" value="{{ old('role', $barber->role) }}" required maxlength="50" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
        </div>
    </div>
    <div>
        <label for="slug" class="text-sm font-semibold">Slug (kosongkan untuk otomatis)</label>
        <input id="slug" name="slug" value="{{ old('slug', $barber->slug) }}" maxlength="120" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
    </div>
    <div>
        <label for="specialties" class="text-sm font-semibold">Spesialisasi</label>
        <input id="specialties" name="specialties" value="{{ old('specialties', $barber->specialties) }}" maxlength="255" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
    </div>
    <div>
        <label for="bio" class="text-sm font-semibold">Bio singkat (tanpa klaim fiktif)</label>
        <textarea id="bio" name="bio" rows="3" maxlength="2000" class="mt-1 w-full rounded-core border border-espresso/20 bg-warm-cream px-4 py-3 text-sm">{{ old('bio', $barber->bio) }}</textarea>
    </div>
    <div>
        <label for="image_url" class="text-sm font-semibold">Image URL (opsional)</label>
        <input id="image_url" name="image_url" value="{{ old('image_url', $barber->image_url) }}" maxlength="500" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
    </div>
    <fieldset>
        <legend class="text-sm font-semibold">Service yang didukung</legend>
        <div class="mt-2 grid gap-2">
            @foreach ($services as $s)
                <label class="flex items-center gap-2 rounded-core border border-espresso/15 px-4 py-2 text-sm">
                    <input type="checkbox" name="services[]" value="{{ $s->id }}" @checked(in_array($s->id, old('services', $selected))) class="size-4 accent-[#B18A4A]"> {{ $s->name }}
                </label>
            @endforeach
        </div>
    </fieldset>
    <label class="flex items-center gap-2 text-sm font-semibold">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $barber->is_active)) class="size-4 accent-[#B18A4A]"> Aktif
    </label>
    <div class="flex gap-2">
        <button type="submit" class="inline-flex min-h-[44px] items-center rounded-pill bg-near-black px-6 py-2 text-sm font-semibold text-warm-cream hover:bg-espresso">Simpan</button>
        <a href="/admin/barbers" class="inline-flex min-h-[44px] items-center rounded-pill border border-espresso/25 px-6 py-2 text-sm font-semibold">Batal</a>
    </div>
</form>
@endsection
