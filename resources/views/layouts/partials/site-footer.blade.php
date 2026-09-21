<footer class="mt-24 bg-near-black text-warm-cream">
    <div class="mx-auto grid max-w-6xl gap-10 px-5 py-14 md:grid-cols-[1.4fr_1fr_1fr]">
        <div>
            <p class="font-display text-2xl">Nirwana Gent&rsquo;s</p>
            <p class="mt-3 max-w-sm text-sm leading-relaxed text-warm-cream/70">Classic Style. Timeless Confidence. Potong rambut, grooming, dan produk perawatan pria dalam satu tempat.</p>
            <p class="mt-4 text-xs text-warm-cream/50">Alamat, jam buka, dan harga final menyusul dan akan ditulis di sini setelah data resmi tersedia (TBD).</p>
        </div>
        <nav aria-label="Navigasi footer">
            <p class="text-sm font-semibold text-brass">Jelajah</p>
            <ul class="mt-3 space-y-2 text-sm">
                <li><a class="hover:text-brass" href="{{ url('/about') }}">About</a></li>
                <li><a class="hover:text-brass" href="{{ url('/services') }}">Services</a></li>
                <li><a class="hover:text-brass" href="{{ url('/barbers') }}">Barbers</a></li>
                <li><a class="hover:text-brass" href="{{ url('/gallery') }}">Gallery</a></li>
            </ul>
        </nav>
        <nav aria-label="Layanan footer">
            <p class="text-sm font-semibold text-brass">Layanan</p>
            <ul class="mt-3 space-y-2 text-sm">
                <li><a class="hover:text-brass" href="{{ url('/booking') }}">Book an Appointment</a></li>
                <li><a class="hover:text-brass" href="{{ url('/shop') }}">Grooming Store</a></li>
                <li><a class="hover:text-brass" href="{{ url('/cart') }}">Cart</a></li>
                <li><a class="hover:text-brass" href="{{ url('/contact') }}">Contact</a></li>
            </ul>
        </nav>
    </div>
    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-6xl flex-col gap-2 px-5 py-5 text-xs text-warm-cream/50 sm:flex-row sm:items-center sm:justify-between">
            <p>&copy; {{ date('Y') }} Nirwana Gent&rsquo;s. Seluruh hak cipta dilindungi.</p>
            <p>Harga dan ketersediaan mengikuti data sistem, bukan materi promosi.</p>
        </div>
    </div>
</footer>
