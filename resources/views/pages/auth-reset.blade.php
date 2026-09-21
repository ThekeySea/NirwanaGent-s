@extends('layouts.transactional')

@section('title', 'Reset password - Nirwana Gents')
@section('step_label', 'Password baru')

@section('content')
<x-section-intro eyebrow="Reset password" title="Tulis password baru." description="Token dari email hanya berlaku terbatas. Minta link baru bila kedaluwarsa." />

<form method="POST" action="/reset-password" class="mt-8 rounded-shell border border-espresso/10 bg-white/40 p-6 md:p-8" aria-label="Form reset password">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="grid gap-4">
        <div>
            <label for="email" class="text-sm font-semibold">Email akun</label>
            <input id="email" name="email" type="email" value="{{ old('email', $email) }}" required class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
            @error('email')<p class="mt-1 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label for="password" class="text-sm font-semibold">Password baru (min 8)</label>
                <input id="password" name="password" type="password" required autocomplete="new-password" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
                @error('password')<p class="mt-1 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="password_confirmation" class="text-sm font-semibold">Ulangi password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
            </div>
        </div>
        <button type="submit" class="inline-flex min-h-[44px] items-center justify-center rounded-pill bg-near-black px-6 py-3 text-sm font-semibold text-warm-cream hover:bg-espresso">Simpan password baru</button>
    </div>
</form>
@endsection
