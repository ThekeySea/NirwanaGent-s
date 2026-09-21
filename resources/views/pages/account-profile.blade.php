@extends('layouts.transactional')

@section('title', 'Profil - Nirwana Gents')
@section('step_label', 'Account / Profil')

@section('content')
<x-section-intro eyebrow="Profil" title="Ubah data dasar." description="Hanya nama, email, dan telepon. Role tidak bisa diubah dari sini." />

<form method="POST" action="/account/profile" class="mt-8 rounded-shell border border-espresso/10 bg-white/40 p-6 md:p-8" aria-label="Form profil">
    @csrf
    @method('PATCH')
    <div class="grid gap-4">
        <div>
            <label for="name" class="text-sm font-semibold">Nama</label>
            <input id="name" name="name" value="{{ old('name', $user->name) }}" required maxlength="100" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
            @error('name')<p class="mt-1 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label for="email" class="text-sm font-semibold">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required maxlength="150" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
                @error('email')<p class="mt-1 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="phone" class="text-sm font-semibold">Telepon</label>
                <input id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required maxlength="30" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
                @error('phone')<p class="mt-1 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            <button type="submit" class="inline-flex min-h-[44px] items-center justify-center rounded-pill bg-near-black px-6 py-3 text-sm font-semibold text-warm-cream hover:bg-espresso">Simpan profil</button>
            <a href="/account" class="inline-flex min-h-[44px] items-center justify-center rounded-pill border border-espresso/25 px-6 py-3 text-sm font-semibold">Kembali</a>
        </div>
    </div>
</form>
@endsection
