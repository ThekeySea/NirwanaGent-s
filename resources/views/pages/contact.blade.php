@extends('layouts.public')

@section('title', 'Contact - Nirwana Gents')
@section('meta_description', 'Hubungi Nirwana Gents. Alamat dan jam resmi TBD, gunakan form pesan.')

@section('content')
<div class="mx-auto max-w-6xl px-5 pt-36 pb-16 md:pt-44">
    <x-section-intro
        eyebrow="Contact"
        title="Kirim pesan, kami baca satu per satu."
        description="Alamat, telepon, dan jam operasional resmi masih TBD. Form di bawah tersimpan sebagai contact message dan dibaca admin."
    />

    <div class="mt-10 grid gap-6 lg:grid-cols-[0.9fr_1.1fr]">
        <div class="rounded-shell border border-dashed border-espresso/25 p-6 text-sm leading-relaxed md:p-8">
            <h2 class="font-display text-2xl">Info (TBD)</h2>
            <dl class="mt-4 space-y-3">
                <div><dt class="text-taupe">Alamat</dt><dd class="font-semibold">TBD</dd></div>
                <div><dt class="text-taupe">Jam operasional</dt><dd class="font-semibold">TBD</dd></div>
                <div><dt class="text-taupe">Email balasan</dt><dd class="font-semibold">Melalui email yang kamu isi di form</dd></div>
            </dl>
        </div>

        <form method="POST" action="/contact" class="rounded-shell border border-espresso/10 bg-white/40 p-6 md:p-8" aria-label="Form kontak">
            @csrf
            @if (session('status'))
                <p role="status" class="mb-4 rounded-core border border-emerald-900/25 bg-emerald-900/10 px-4 py-3 text-sm">{{ session('status') }}</p>
            @endif
            <div class="grid gap-4">
                <div>
                    <label for="name" class="text-sm font-semibold">Nama</label>
                    <input id="name" name="name" value="{{ old('name') }}" required maxlength="100" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm" aria-required="true">
                    @error('name')<p class="mt-1 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label for="email" class="text-sm font-semibold">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required maxlength="150" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm" aria-required="true">
                        @error('email')<p class="mt-1 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="phone" class="text-sm font-semibold">Telepon (opsional)</label>
                        <input id="phone" name="phone" value="{{ old('phone') }}" maxlength="30" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
                        @error('phone')<p class="mt-1 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label for="message" class="text-sm font-semibold">Pesan</label>
                    <textarea id="message" name="message" required maxlength="2000" rows="5" class="mt-1 w-full rounded-core border border-espresso/20 bg-warm-cream px-4 py-3 text-sm" aria-required="true">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-1 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="inline-flex min-h-[44px] items-center justify-center rounded-pill bg-near-black px-6 py-3 text-sm font-semibold text-warm-cream hover:bg-espresso">Kirim pesan</button>
            </div>
        </form>
    </div>
</div>
@endsection
