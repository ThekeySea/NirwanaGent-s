@extends('layouts.transactional')

@section('title', 'Booking - Nirwana Gents')
@section('step_label', 'Service, Barber, Date, Time, Details, Review')

@section('content')
<x-section-intro
    eyebrow="Booking"
    title="Pesan jadwal dalam 6 langkah."
    description="Pilihan tampil di ringkasan kanan bawah pada layar besar dan di bawah form pada mobile. Slot yang sudah diambil otomatis nonaktif."
/>

<form method="POST" action="/bookings" id="booking-form" class="mt-8 grid gap-6 lg:grid-cols-[1fr_320px]" aria-label="Form booking">
    @csrf

    <div class="grid gap-6">
        <fieldset class="rounded-shell border border-espresso/10 bg-white/40 p-6">
            <legend class="px-2 font-display text-xl">1. Service</legend>
            <div class="grid gap-2">
                @foreach ($services as $service)
                    <label class="flex cursor-pointer items-center justify-between gap-3 rounded-core border border-espresso/15 px-4 py-3 has-checked:border-brass has-checked:bg-brass/10">
                        <span>
                            <input type="radio" name="service_id" value="{{ $service->id }}" class="mr-2 accent-[#B18A4A]" @checked((string) $selectedService === (string) $service->id || ($loop->first && ! $selectedService)) required>
                            <strong>{{ $service->name }}</strong>
                            <span class="block text-xs text-taupe">{{ $service->duration_minutes }} menit</span>
                        </span>
                        <span class="text-sm font-semibold">{{ $service->formattedPrice() }}</span>
                    </label>
                @endforeach
            </div>
            @error('service_id')<p class="mt-2 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
        </fieldset>

        <fieldset class="rounded-shell border border-espresso/10 bg-white/40 p-6">
            <legend class="px-2 font-display text-xl">2. Barber</legend>
            <div class="grid gap-2">
                <label class="flex cursor-pointer items-center gap-2 rounded-core border border-espresso/15 px-4 py-3 has-checked:border-brass has-checked:bg-brass/10">
                    <input type="radio" name="barber_id" value="" class="accent-[#B18A4A]" @checked(! $selectedBarber)> <strong>Any Available Barber</strong>
                    <span class="text-xs text-taupe">Sistem pilihkan yang kosong</span>
                </label>
                @foreach ($barbers as $barber)
                    <label class="flex cursor-pointer items-center gap-2 rounded-core border border-espresso/15 px-4 py-3 has-checked:border-brass has-checked:bg-brass/10">
                        <input type="radio" name="barber_id" value="{{ $barber->id }}" class="accent-[#B18A4A]" @checked((string) $selectedBarber === (string) $barber->id)>
                        <strong>{{ $barber->name }}</strong>
                        <span class="text-xs text-taupe">{{ $barber->specialties ?? $barber->role }}</span>
                    </label>
                @endforeach
            </div>
            @error('barber_id')<p class="mt-2 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
        </fieldset>

        <fieldset class="rounded-shell border border-espresso/10 bg-white/40 p-6">
            <legend class="px-2 font-display text-xl">3. Tanggal</legend>
            <input type="date" name="date" id="booking-date" required min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+30 days')) }}" value="{{ old('date', date('Y-m-d', strtotime('+1 day'))) }}" class="min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
            <p class="mt-2 text-xs text-taupe">Senin sampai Sabtu 09:00 sampai 20:00 (sample). Minggu tutup.</p>
            @error('date')<p class="mt-2 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
        </fieldset>

        <fieldset class="rounded-shell border border-espresso/10 bg-white/40 p-6">
            <legend class="px-2 font-display text-xl">4. Jam</legend>
            <p id="slot-status" class="text-sm text-taupe" role="status">Pilih service dan tanggal untuk memuat slot.</p>
            <div id="slot-grid" class="mt-4 grid grid-cols-3 gap-2 sm:grid-cols-4" role="radiogroup" aria-label="Slot waktu"></div>
            @error('start')<p class="mt-2 text-xs text-red-900" role="alert">{{ $message }}</p>@enderror
        </fieldset>

        <fieldset class="rounded-shell border border-espresso/10 bg-white/40 p-6">
            <legend class="px-2 font-display text-xl">5. Detail</legend>
            <label for="notes" class="text-sm font-semibold">Catatan (opsional, maks 500)</label>
            <textarea id="notes" name="notes" rows="3" maxlength="500" class="mt-1 w-full rounded-core border border-espresso/20 bg-warm-cream px-4 py-3 text-sm">{{ old('notes') }}</textarea>
            @auth
                <p class="mt-2 text-xs text-taupe">Booking tercatat atas {{ auth()->user()->name }} ({{ auth()->user()->email }}).</p>
            @else
                <p class="mt-2 text-sm">Simpan butuh login. <a class="font-semibold underline underline-offset-4 decoration-brass decoration-2" href="/login">Masuk</a> atau <a class="font-semibold underline underline-offset-4 decoration-brass decoration-2" href="/register">daftar</a> dulu, pilihanmu tidak hilang setelah kembali.</p>
            @endauth
        </fieldset>

        <div class="rounded-shell border border-espresso/10 bg-near-black p-6 text-warm-cream">
            <h2 class="font-display text-xl">6. Review dan konfirmasi</h2>
            <dl class="mt-3 space-y-1 text-sm" id="booking-review">
                <div class="flex justify-between gap-3"><dt class="text-warm-cream/60">Service</dt><dd id="review-service">-</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-warm-cream/60">Barber</dt><dd id="review-barber">-</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-warm-cream/60">Tanggal</dt><dd id="review-date">-</dd></div>
                <div class="flex justify-between gap-3"><dt class="text-warm-cream/60">Jam</dt><dd id="review-time">-</dd></div>
            </dl>
            <button type="submit" class="mt-5 inline-flex min-h-[44px] w-full items-center justify-center rounded-pill bg-brass px-6 py-3 text-sm font-semibold text-near-black hover:brightness-110">Confirm booking</button>
        </div>
    </div>

    <aside class="lg:sticky lg:top-6 h-fit rounded-shell border border-espresso/10 bg-white/40 p-6" aria-label="Ringkasan pilihan">
        <h2 class="font-display text-xl">Ringkasan</h2>
        <p class="mt-2 text-sm text-espresso/75" id="summary-text">Pilihanmu tampil di sini saat melangkah.</p>
    </aside>
</form>

@push('scripts')
<script>
(function () {
    const form = document.getElementById('booking-form');
    const dateInput = document.getElementById('booking-date');
    const grid = document.getElementById('slot-grid');
    const status = document.getElementById('slot-status');
    const token = form.querySelector('input[name="_token"]').value;
    const oldStart = @json(old('start', ''));

    function selected(name) {
        const el = form.querySelector('input[name="' + name + '"]:checked');
        return el ? el.value : '';
    }

    function serviceName() {
        const el = form.querySelector('input[name="service_id"]:checked');
        return el ? el.closest('label').querySelector('strong').textContent : '-';
    }

    function barberName() {
        const el = form.querySelector('input[name="barber_id"]:checked');
        if (!el) return '-';
        if (!el.value) return 'Any Available Barber';
        return el.closest('label').querySelector('strong').textContent;
    }

    function refreshReview() {
        const start = selected('start');
        document.getElementById('review-service').textContent = serviceName();
        document.getElementById('review-barber').textContent = barberName();
        document.getElementById('review-date').textContent = dateInput.value || '-';
        document.getElementById('review-time').textContent = start || '-';
        document.getElementById('summary-text').textContent =
            serviceName() + ' | ' + barberName() + ' | ' + (dateInput.value || '-') + ' ' + (start || '-');
    }

    async function loadSlots() {
        const serviceId = selected('service_id');
        const date = dateInput.value;
        if (!serviceId || !date) {
            status.textContent = 'Pilih service dan tanggal untuk memuat slot.';
            return;
        }
        status.textContent = 'Memuat slot...';
        grid.innerHTML = '';
        try {
            const res = await fetch('/booking/availability', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token,
                },
                body: JSON.stringify({
                    service_id: Number(serviceId),
                    barber_id: selected('barber_id') ? Number(selected('barber_id')) : null,
                    date: date,
                }),
            });
            const data = await res.json();
            if (!res.ok) {
                const msg = data.message || (data.errors ? Object.values(data.errors).flat().join(' ') : 'Slot tidak bisa dimuat. Coba tanggal lain.');
                status.textContent = msg;
                refreshReview();
                return;
            }
            const slots = data.slots || [];
            if (!slots.length) {
                status.textContent = 'Tutup pada tanggal ini. Pilih tanggal lain.';
                refreshReview();
                return;
            }
            const free = slots.filter((s) => s.available).length;
            status.textContent = free ? free + ' slot tersedia.' : 'Penuh pada tanggal ini. Pilih tanggal lain.';
            slots.forEach((s) => {
                const label = document.createElement('label');
                label.className = 'cursor-pointer rounded-pill border px-3 py-2 text-center text-sm font-semibold has-checked:border-brass has-checked:bg-brass has-checked:text-near-black has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-brass ' +
                    (s.available
                        ? 'border-espresso/20 hover:border-brass'
                        : 'cursor-not-allowed border-espresso/10 text-taupe opacity-50');
                const radio = document.createElement('input');
                radio.type = 'radio';
                radio.name = 'start';
                radio.value = s.start;
                radio.required = true;
                radio.disabled = !s.available;
                radio.className = 'sr-only';
                if (oldStart && oldStart === s.start && s.available) {
                    radio.checked = true;
                }
                const text = document.createElement('span');
                text.textContent = s.start;
                label.appendChild(radio);
                label.appendChild(text);
                grid.appendChild(label);
            });
            refreshReview();
        } catch (e) {
            status.textContent = 'Jaringan bermasalah. Muat ulang halaman.';
            refreshReview();
        }
    }

    form.addEventListener('change', (e) => {
        if (e.target && e.target.name === 'start') {
            refreshReview();
            return;
        }
        loadSlots();
    });
    loadSlots();
})();
</script>
@endpush
@endsection
