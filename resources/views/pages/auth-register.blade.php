@extends('layouts.transactional')

@section('title', 'Daftar - Nirwana Gents')
@section('step_label', 'Daftar')

@section('content')
<x-section-intro eyebrow="Daftar" title="Buat akun customer." description="Nama, email, telepon, dan password. Role selalu customer, tidak bisa dipilih." />

<form method="POST" action="/register" class="mt-8 rounded-shell border border-espresso/10 bg-white/40 p-6 md:p-8" aria-label="Form daftar">
    @csrf
    <div class="grid gap-4">
        <div>
            <label for="name" class="text-sm font-semibold">Nama</label>
            <input id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" maxlength="100" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
            @error('name')<p class="mt-1 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label for="email" class="text-sm font-semibold">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" maxlength="150" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
                @error('email')<p class="mt-1 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="phone" class="text-sm font-semibold">Telepon</label>
                <input id="phone" name="phone" value="{{ old('phone') }}" required autocomplete="tel" maxlength="30" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
                @error('phone')<p class="mt-1 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label for="password" class="text-sm font-semibold">Password (min 8 karakter)</label>
                <input id="password" name="password" type="password" required autocomplete="new-password" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
                @error('password')<p class="mt-1 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password_confirmation" class="text-sm font-semibold">Ulangi password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
            </div>
        </div>
        <button type="submit" class="inline-flex min-h-[44px] items-center justify-center rounded-pill bg-near-black px-6 py-3 text-sm font-semibold text-warm-cream hover:bg-espresso">Buat akun</button>
    </div>
</form>

<p class="mt-4 text-sm text-espresso/75">Sudah punya akun? <a class="font-semibold underline underline-offset-4 decoration-brass decoration-2" href="/login">Masuk</a>.</p>
@endsection
