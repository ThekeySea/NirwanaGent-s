@extends('layouts.transactional')

@section('title', 'Lupa password - Nirwana Gents')
@section('step_label', 'Reset password')

@section('content')
<x-section-intro eyebrow="Lupa password" title="Minta link reset." description="Masukkan email akun. Link dikirim bila alamat terdaftar. Email pengirim memakai log di development." />

<form method="POST" action="/forgot-password" class="mt-8 rounded-shell border border-espresso/10 bg-white/40 p-6 md:p-8" aria-label="Form lupa password">
    @csrf
    <div class="grid gap-4">
        <div>
            <label for="email" class="text-sm font-semibold">Email akun</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
            @error('email')<p class="mt-1 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
        </div>
        <button type="submit" class="inline-flex min-h-[44px] items-center justify-center rounded-pill bg-near-black px-6 py-3 text-sm font-semibold text-warm-cream hover:bg-espresso">Kirim link reset</button>
    </div>
</form>

<p class="mt-4 text-sm text-espresso/75"><a class="font-semibold underline underline-offset-4 decoration-brass decoration-2" href="/login">Kembali masuk</a>.</p>
@endsection
