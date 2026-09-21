@extends('layouts.admin')

@section('title', 'Admin Products - Nirwana Gents')
@section('heading', 'Products')

@section('content')
@if (session('status'))
    <p role="status" class="mb-4 rounded-core border border-emerald-900/25 bg-emerald-900/10 px-4 py-3 text-sm">{{ session('status') }}</p>
@endif
@if ($errors->any())
    <div role="alert" class="mb-4 rounded-core border border-red-900/20 bg-red-50 px-4 py-3 text-sm">
        @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<div class="mb-4 flex flex-wrap gap-2">
    <a href="/admin/products/create" class="inline-flex min-h-[44px] items-center rounded-pill bg-near-black px-5 py-2 text-sm font-semibold text-warm-cream hover:bg-espresso">Tambah produk</a>
    <form method="GET" action="/admin/products" class="flex gap-2" role="search" aria-label="Cari produk admin">
        <input type="search" name="q" value="{{ $q }}" placeholder="Cari nama" class="min-h-[44px] rounded-pill border border-espresso/20 bg-warm-cream px-4 text-sm">
        <button type="submit" class="inline-flex min-h-[44px] items-center rounded-pill border border-espresso/25 px-5 py-2 text-sm font-semibold">Cari</button>
    </form>
</div>

<div class="overflow-x-auto rounded-shell border border-espresso/10 bg-white/40">
    <table class="w-full min-w-[760px] text-left text-sm">
        <thead>
            <tr class="border-b border-espresso/10 text-xs uppercase tracking-widest text-taupe">
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Harga</th>
                <th class="px-4 py-3">Stock</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $p)
                <tr class="border-b border-espresso/5">
                    <td class="px-4 py-3 font-semibold">{{ $p->name }}<br><span class="font-mono text-xs font-normal text-taupe">{{ $p->slug }}</span></td>
                    <td class="px-4 py-3">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">{{ $p->stock }}</td>
                    <td class="px-4 py-3"><x-status-badge :status="$p->is_active ? ($p->stock <= 3 ? 'low' : 'active') : 'inactive'" /></td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="/admin/products/{{ $p->id }}/edit" class="inline-flex min-h-[44px] items-center rounded-pill border border-espresso/25 px-4 py-1 font-semibold">Edit</a>
                            <form method="POST" action="/admin/products/{{ $p->id }}" onsubmit="return confirm('Hapus produk ini? Batalkan bila masih di cart atau order.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex min-h-[44px] items-center rounded-pill border border-red-900/30 px-4 py-1 font-semibold text-red-950">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-6 text-espresso/70">Tidak ada produk.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $products->links() }}</div>
@endsection
