@extends('layouts.admin')

@section('title', 'Admin Services - Nirwana Gents')
@section('heading', 'Services')

@section('content')
@if (session('status'))
    <p role="status" class="mb-4 rounded-core border border-emerald-900/25 bg-emerald-900/10 px-4 py-3 text-sm">{{ session('status') }}</p>
@endif
@if ($errors->any())
    <div role="alert" class="mb-4 rounded-core border border-red-900/20 bg-red-50 px-4 py-3 text-sm">
        @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<div class="mb-4">
    <a href="/admin/services/create" class="inline-flex min-h-[44px] items-center rounded-pill bg-near-black px-5 py-2 text-sm font-semibold text-warm-cream hover:bg-espresso">Tambah service</a>
</div>

<div class="overflow-x-auto rounded-shell border border-espresso/10 bg-white/40">
    <table class="w-full min-w-[720px] text-left text-sm">
        <thead>
            <tr class="border-b border-espresso/10 text-xs uppercase tracking-widest text-taupe">
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Harga</th>
                <th class="px-4 py-3">Durasi</th>
                <th class="px-4 py-3">Aktif</th>
                <th class="px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($services as $s)
                <tr class="border-b border-espresso/5">
                    <td class="px-4 py-3 font-semibold">{{ $s->name }}<br><span class="font-mono text-xs font-normal text-taupe">{{ $s->slug }}</span></td>
                    <td class="px-4 py-3">Rp {{ number_format($s->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">{{ $s->duration_minutes }} mnt</td>
                    <td class="px-4 py-3"><x-status-badge :status="$s->is_active ? 'active' : 'inactive'" /></td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="/admin/services/{{ $s->id }}/edit" class="inline-flex min-h-[44px] items-center rounded-pill border border-espresso/25 px-4 py-1 font-semibold">Edit</a>
                            <form method="POST" action="/admin/services/{{ $s->id }}" onsubmit="return confirm('Hapus service ini? Batalkan bila masih terhubung.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex min-h-[44px] items-center rounded-pill border border-red-900/30 px-4 py-1 font-semibold text-red-950">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-6 text-espresso/70">Belum ada service.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $services->links() }}</div>
@endsection
