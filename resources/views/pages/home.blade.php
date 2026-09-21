@extends('layouts.public')

@section('title', 'Nirwana Gents - Classic Style. Timeless Confidence.')
@section('meta_description', 'Nirwana Gents: potong rambut presisi, grooming pria, dan produk perawatan. Lihat layanan, barber, dan katalog shop.')

@section('content')
<x-hero
    eyebrow="Barbershop premium"
    title="Classic Style. Timeless Confidence."
    description="Potong presisi dan grooming pria dalam ruang hangat. Pilih layanan, barber, dan jam yang pas, lalu booking dalam beberapa langkah."
    primaryLabel="Book an Appointment"
    primaryHref="/booking"
    secondaryLabel="View Services"
    secondaryHref="/services"
>
    <div class="flex min-h-[320px] flex-col justify-end bg-near-black p-7 md:min-h-[420px]">
        <p class="font-display text-3xl text-warm-cream">Ruang potong yang tenang dan terang.</p>
        <p class="mt-2 text-xs uppercase tracking-widest text-brass">Foto interior final menyusul (sample)</p>
    </div>
</x-hero>

<section class="mx-auto max-w-6xl px-5 py-8" aria-label="Cerita singkat">
    <div class="grid gap-8 md:grid-cols-2 md:items-center">
        <x-section-intro
            eyebrow="Brand"
            title="Tempat potong yang rapi dan tenang."
            description="Nirwana Gents berfokus pada tiga hal: hasil potong yang presisi, proses yang jelas, dan ruang yang nyaman. Alamat dan jam operasional resmi ditulis TBD sampai data final tersedia."
        />
        <div class="rounded-shell border border-espresso/10 bg-white/40 p-6 text-sm leading-relaxed md:p-8">
            <p class="font-semibold">Yang kamu dapat di sini:</p>
            <ul class="mt-3 list-disc space-y-2 pl-5 text-espresso/80">
                <li>Daftar layanan dengan harga dan durasi tertulis.</li>
                <li>Profil barber dengan spesialisasi jelas.</li>
                <li>Katalog produk dengan status stock jujur.</li>
                <li>Booking dengan status appointment yang bisa dilacak.</li>
            </ul>
        </div>
    </div>
</section>

<section class="mx-auto max-w-6xl px-5 py-8" aria-label="Layanan unggulan">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <x-section-intro
            eyebrow="Services"
            title="Layanan yang paling sering dipilih."
        />
        <a href="/services" class="inline-flex min-h-[44px] items-center text-sm font-semibold underline underline-offset-4 decoration-brass decoration-2">Semua services</a>
    </div>
    <div class="mt-8 grid gap-5 md:grid-cols-2">
        @forelse ($featuredServices as $service)
            <x-service-card
                :name="$service->name"
                :price="$service->formattedPrice()"
                :duration="$service->duration_minutes . ' menit'"
                :description="$service->description"
                :href="'/services/' . $service->slug"
                :isSample="str_contains($service->slug, 'sample')"
            />
        @empty
            <p class="text-sm text-espresso/70">Belum ada layanan aktif.</p>
        @endforelse
    </div>
</section>

<section class="mx-auto max-w-6xl px-5 py-8" aria-label="Kenapa Nirwana Gents">
    <x-section-intro
        eyebrow="Kenapa di sini"
        title="Proses jelas, hasil bisa dinilai."
    />
    <div class="mt-8 grid gap-5 md:grid-cols-3">
        <div class="rounded-shell border border-espresso/10 bg-white/40 p-6">
            <p class="font-display text-xl">Harga tertulis di awal</p>
            <p class="mt-2 text-sm leading-relaxed text-espresso/75">Total mengikuti data sistem saat checkout dan booking. Tidak ada biaya tersembunyi di luar daftar.</p>
        </div>
        <div class="rounded-shell border border-espresso/10 bg-white/40 p-6">
            <p class="font-display text-xl">Slot yang diambil terkunci</p>
            <p class="mt-2 text-sm leading-relaxed text-espresso/75">Slot yang sudah diambil tidak bisa dipilih lagi. Status appointment tampil di akun.</p>
        </div>
        <div class="rounded-shell border border-espresso/10 bg-white/40 p-6">
            <p class="font-display text-xl">Stock jujur</p>
            <p class="mt-2 text-sm leading-relaxed text-espresso/75">Produk nonaktif tidak bisa dibeli. Quantity di atas stock ditolak sistem.</p>
        </div>
    </div>
</section>

<section class="mx-auto max-w-6xl px-5 py-8" aria-label="Barber unggulan">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <x-section-intro eyebrow="Barbers" title="Kenali yang memotong rambutmu." />
        <a href="/barbers" class="inline-flex min-h-[44px] items-center text-sm font-semibold underline underline-offset-4 decoration-brass decoration-2">Semua barbers</a>
    </div>
    <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($featuredBarbers as $barber)
            <x-barber-card
                :name="$barber->name"
                :role="$barber->role"
                :specialties="$barber->specialties ?? 'Spesialisasi menyusul'"
                :href="'/barbers/' . $barber->slug"
                :isSample="str_contains($barber->slug, 'sample')"
            />
        @empty
            <p class="text-sm text-espresso/70">Belum ada barber aktif.</p>
        @endforelse
    </div>
</section>

<section class="mx-auto max-w-6xl px-5 py-8" aria-label="Toko grooming">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <x-section-intro eyebrow="Grooming store" title="Produk untuk perawatan di rumah." />
        <a href="/shop" class="inline-flex min-h-[44px] items-center text-sm font-semibold underline underline-offset-4 decoration-brass decoration-2">Semua produk</a>
    </div>
    <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($featuredProducts as $product)
            @php $state = $product->stockState(); @endphp
            <x-product-card
                :name="$product->name"
                :price="$product->formattedPrice()"
                :stockLabel="$state['label']"
                :stockStatus="$state['status']"
                :href="'/shop/' . $product->slug"
                :isSample="str_contains($product->slug, 'sample')"
            />
        @empty
            <p class="text-sm text-espresso/70">Belum ada produk aktif.</p>
        @endforelse
    </div>
</section>

<section class="mx-auto max-w-6xl px-5 py-8" aria-label="Galeri">
    <x-section-intro eyebrow="Gallery" title="Suasana ruang dan detail kerja." />
    <div class="mt-8">
        <x-gallery-grid :images="$gallery->map(fn ($m) => ['src' => $m->path ?: null, 'alt' => $m->alt, 'caption' => $m->caption])->all()" />
    </div>
</section>

<div class="mt-6 pb-4">
    <x-booking-cta />
</div>
@endsection
