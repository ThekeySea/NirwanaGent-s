@extends('layouts.admin')

@section('title', 'Admin Customers - Nirwana Gents')
@section('heading', 'Customers')

@section('content')
<form method="GET" action="/admin/customers" class="mb-4 flex gap-2" role="search" aria-label="Cari customer">
    <input type="search" name="q" value="{{ $q }}" placeholder="Cari nama atau email" class="min-h-[44px] rounded-pill border border-espresso/20 bg-warm-cream px-4 text-sm">
    <button type="submit" class="inline-flex min-h-[44px] items-center rounded-pill border border-espresso/25 px-5 py-2 text-sm font-semibold">Cari</button>
</form>

<div class="overflow-x-auto rounded-shell border border-espresso/10 bg-white/40">
    <table class="w-full min-w-[680px] text-left text-sm">
        <thead>
            <tr class="border-b border-espresso/10 text-xs uppercase tracking-widest text-taupe">
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Kontak</th>
                <th class="px-4 py-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $c)
                <tr class="border-b border-espresso/5">
                    <td class="px-4 py-3 font-semibold"><a href="/admin/customers/{{ $c->id }}" class="underline underline-offset-4 decoration-brass decoration-2">{{ $c->name }}</a></td>
                    <td class="px-4 py-3">{{ $c->email }}<br><span class="text-taupe">{{ $c->phone ?? '-' }}</span></td>
                    <td class="px-4 py-3"><a href="/admin/customers/{{ $c->id }}/edit" class="inline-flex min-h-[44px] items-center rounded-pill border border-espresso/25 px-4 py-1 font-semibold">Edit</a></td>
                </tr>
            @empty
                <tr><td colspan="3" class="px-4 py-6 text-espresso/70">Tidak ada customer.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $customers->links() }}</div>
@endsection
