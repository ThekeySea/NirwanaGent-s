@extends('layouts.transactional')

@section('title', 'Masuk - Nirwana Gents')
@section('step_label', 'Masuk')

@section('content')
<x-section-intro eyebrow="Masuk" title="Masuk ke akunmu." description="Booking dan order tersimpan di akun. Admin masuk lewat halaman yang sama." />

<form method="POST" action="/login" class="mt-8 rounded-shell border border-espresso/10 bg-white/40 p-6 md:p-8" aria-label="Form masuk">
    @csrf
    <div class="grid gap-4">
        <div>
            <label for="email" class="text-sm font-semibold">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
            @error('email')<p class="mt-1 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="password" class="text-sm font-semibold">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
            @error('password')<p class="mt-1 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
        </div>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="remember" value="1" class="size-4 accent-[#B18A4A]"> Ingat saya
        </label>
        <button type="submit" class="inline-flex min-h-[44px] items-center justify-center rounded-pill bg-near-black px-6 py-3 text-sm font-semibold text-warm-cream hover:bg-espresso">Masuk</button>
    </div>
</form>

<p class="mt-4 text-sm text-espresso/75">Belum punya akun? <a class="font-semibold underline underline-offset-4 decoration-brass decoration-2" href="/register">Daftar</a>. Lupa password? <a class="font-semibold underline underline-offset-4 decoration-brass decoration-2" href="/forgot-password">Reset di sini</a>.</p>
@endsection
