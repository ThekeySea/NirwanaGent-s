@extends('layouts.public')

@section('title', 'About - Nirwana Gents')
@section('meta_description', 'Cerita, filosofi, nilai, dan suasana Nirwana Gents. Data resmi bertanda TBD sampai final.')

@section('content')
<div class="mx-auto max-w-6xl px-5 pt-28 pb-16 md:pt-44">
    <x-section-intro
        eyebrow="About"
        title="Barbershop klasik untuk gaya yang tahan lama."
        description="Nirwana Gents adalah ruang potong dan grooming pria. Fokus kami sederhana: potong rapi, proses jelas, dan produk yang bisa dipakai di rumah."
    />

    <div class="mt-12 grid gap-5 md:grid-cols-12">
        <figure class="overflow-hidden rounded-shell border border-espresso/10 md:col-span-7">
            <img src="/images/hero-interior.jpg" alt="Interior barbershop hangat dengan kursi dan cermin (sample)" class="aspect-[16/10] w-full object-cover" loading="lazy">
            <figcaption class="bg-near-black px-5 py-3 text-xs uppercase tracking-widest text-brass">Suasana ruang (sample)</figcaption>
        </figure>
        <figure class="overflow-hidden rounded-shell border border-espresso/10 md:col-span-5">
            <img src="/images/gallery-tools.jpg" alt="Clipper, gunting, sisir, dan pomade tertata (sample)" class="aspect-[16/10] h-full w-full object-cover md:aspect-auto md:min-h-full" loading="lazy">
            <figcaption class="bg-near-black px-5 py-3 text-xs uppercase tracking-widest text-brass">Detail alat (sample)</figcaption>
        </figure>
    </div>

    <div class="mt-5 grid gap-5 md:grid-cols-2">
        <div class="rounded-shell border border-espresso/10 bg-white/40 p-6 md:p-8">
            <h2 class="font-display text-2xl">Filosofi</h2>
            <p class="mt-3 text-sm leading-relaxed text-espresso/80">Potong yang baik terlihat rapi dari semua sisi dan tetap rapi setelah beberapa minggu. Kami mengutamakan konsultasi singkat, eksekusi presisi, dan finishing yang sesuai gaya harian.</p>
        </div>
        <div class="rounded-shell border border-espresso/10 bg-near-black p-6 text-warm-cream md:p-8">
            <h2 class="font-display text-2xl">Suasana</h2>
            <p class="mt-3 text-sm leading-relaxed text-warm-cream/75">Ruang hangat dengan material kayu, kulit, dan aksen brass. Foto di atas ilustrasi sample. Datang, duduk, dan tahu apa yang terjadi berikutnya.</p>
        </div>
    </div>

    <div class="mt-5 rounded-shell border border-espresso/10 bg-white/40 p-6 md:p-8">
        <h2 class="font-display text-2xl">Nilai yang dipegang</h2>
        <ul class="mt-4 grid gap-3 text-sm leading-relaxed text-espresso/80 md:grid-cols-3">
            <li><span class="font-semibold text-espresso">Jujur di data.</span> Harga, durasi, dan stock mengikuti sistem.</li>
            <li><span class="font-semibold text-espresso">Jelas di proses.</span> Booking punya status yang bisa dilacak.</li>
            <li><span class="font-semibold text-espresso">Tenang di ruang.</span> Tanpa antre yang tidak pasti.</li>
        </ul>
    </div>

    <div class="mt-5 grid gap-5 md:grid-cols-2">
        <div class="rounded-shell border border-espresso/10 bg-white/40 p-6 md:p-8">
            <h2 class="font-display text-2xl">Visi</h2>
            <p class="mt-3 text-sm leading-relaxed text-espresso/80">Menjadi tempat grooming pria yang bisa diandalkan untuk potong rutin dan perawatan harian.</p>
            <h3 class="mt-6 font-display text-xl">Misi</h3>
            <ul class="mt-3 list-disc space-y-2 pl-5 text-sm text-espresso/80">
                <li>Menulis harga dan durasi secara terbuka.</li>
                <li>Menjaga slot booking tanpa bentrok.</li>
                <li>Menjual produk dengan stock yang benar.</li>
            </ul>
        </div>
        <div class="rounded-shell border border-dashed border-espresso/25 bg-warm-cream p-6 md:p-8">
            <h2 class="font-display text-2xl">Info bisnis (TBD)</h2>
            <dl class="mt-4 space-y-3 text-sm">
                <div><dt class="text-taupe">Alamat</dt><dd class="font-semibold">TBD (data resmi menyusul)</dd></div>
                <div><dt class="text-taupe">Jam operasional</dt><dd class="font-semibold">TBD</dd></div>
                <div><dt class="text-taupe">Kontak</dt><dd class="font-semibold">TBD, gunakan form di /contact</dd></div>
                <div><dt class="text-taupe">Tahun berdiri</dt><dd class="font-semibold">Tidak ditampilkan sampai data resmi ada</dd></div>
            </dl>
        </div>
    </div>

    <div class="mt-10">
        <x-booking-cta />
    </div>
</div>
@endsection
