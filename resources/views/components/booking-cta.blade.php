{{-- Pita CTA booking full-width. Copy konkret, tanpa filler AI. --}}
@props([
    'title' => 'Siap potong? Pilih layanan, barber, dan jam yang pas.',
    'description' => 'Booking tercatat sebagai appointment dengan status jelas. Slot yang sudah diambil tidak bisa dipilih lagi.',
    'primaryLabel' => 'Book an Appointment',
    'primaryHref' => '/booking',
])

<section class="mx-auto max-w-6xl px-5" aria-label="Ajakan booking">
    <div class="reveal rounded-shell bg-near-black p-8 text-warm-cream md:p-14">
        <div class="grid gap-8 md:grid-cols-[1.2fr_0.8fr] md:items-center">
            <div>
                <h2 class="font-display text-3xl leading-tight md:text-5xl">{{ $title }}</h2>
                <p class="mt-4 max-w-xl leading-relaxed text-warm-cream/70">{{ $description }}</p>
            </div>
            <div class="flex flex-col gap-3 md:items-end">
                <x-button href="{{ $primaryHref }}" variant="brass" class="w-full md:w-auto">{{ $primaryLabel }}</x-button>
                <a href="/services" class="inline-flex min-h-[44px] items-center text-sm font-semibold text-warm-cream/80 underline underline-offset-4 hover:text-brass">View Services</a>
            </div>
        </div>
    </div>
</section>
