@extends('layouts.admin')

@section('title', ($product->exists ? 'Edit' : 'Tambah') . ' Produk - Nirwana Gents')
@section('heading', ($product->exists ? 'Edit' : 'Tambah') . ' Produk')

@section('content')
@if ($errors->any())
    <div role="alert" class="mb-4 rounded-core border border-red-900/20 bg-red-50 px-4 py-3 text-sm">
        @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
@endif

<form method="POST" action="{{ $product->exists ? '/admin/products/' . $product->id : '/admin/products' }}" class="grid max-w-2xl gap-4 rounded-shell border border-espresso/10 bg-white/40 p-6" aria-label="Form produk">
    @csrf
    @if ($product->exists)
        @method('PATCH')
    @endif
    <div>
        <label for="name" class="text-sm font-semibold">Nama</label>
        <input id="name" name="name" value="{{ old('name', $product->name) }}" required maxlength="150" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label for="slug" class="text-sm font-semibold">Slug (kosongkan untuk otomatis)</label>
            <input id="slug" name="slug" value="{{ old('slug', $product->slug) }}" maxlength="150" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
        </div>
        <div>
            <label for="category_id" class="text-sm font-semibold">Kategori</label>
            <select id="category_id" name="category_id" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
                <option value="">Tanpa kategori</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}" @selected((string) old('category_id', $product->category_id) === (string) $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label for="price" class="text-sm font-semibold">Harga (rupiah, angka)</label>
            <input id="price" name="price" type="number" min="0" max="100000000" value="{{ old('price', $product->price) }}" required class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
        </div>
        <div>
            <label for="stock" class="text-sm font-semibold">Stock</label>
            <input id="stock" name="stock" type="number" min="0" max="1000000" value="{{ old('stock', $product->stock) }}" required class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
        </div>
    </div>
    <div>
        <label for="description" class="text-sm font-semibold">Deskripsi</label>
        <textarea id="description" name="description" rows="3" maxlength="2000" class="mt-1 w-full rounded-core border border-espresso/20 bg-warm-cream px-4 py-3 text-sm">{{ old('description', $product->description) }}</textarea>
    </div>
    <div>
        <label for="usage_instructions" class="text-sm font-semibold">Cara pakai</label>
        <textarea id="usage_instructions" name="usage_instructions" rows="2" maxlength="2000" class="mt-1 w-full rounded-core border border-espresso/20 bg-warm-cream px-4 py-3 text-sm">{{ old('usage_instructions', $product->usage_instructions) }}</textarea>
    </div>
    <div>
        <label for="image_url" class="text-sm font-semibold">Image URL (opsional)</label>
        <input id="image_url" name="image_url" value="{{ old('image_url', $product->image_url) }}" maxlength="500" class="mt-1 min-h-[44px] w-full rounded-core border border-espresso/20 bg-warm-cream px-4 text-sm">
    </div>
    <label class="flex items-center gap-2 text-sm font-semibold">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active)) class="size-4 accent-[#B18A4A]"> Aktif (nonaktif = tidak bisa dibeli)
    </label>
    <div class="flex gap-2">
        <button type="submit" class="inline-flex min-h-[44px] items-center rounded-pill bg-near-black px-6 py-2 text-sm font-semibold text-warm-cream hover:bg-espresso">Simpan</button>
        <a href="/admin/products" class="inline-flex min-h-[44px] items-center rounded-pill border border-espresso/25 px-6 py-2 text-sm font-semibold">Batal</a>
    </div>
</form>
@endsection
