<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->orderBy('name');

        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->string('q').'%');
        }

        return view('pages.admin.products-index', [
            'products' => $query->paginate(20)->withQueryString(),
            'q' => $request->string('q')->toString(),
        ]);
    }

    public function create()
    {
        return view('pages.admin.products-form', [
            'product' => new Product(['is_active' => true, 'stock' => 0]),
            'categories' => ProductCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $product = Product::create($this->validateData($request));

        return redirect('/admin/products')->with('status', $product->name.' tersimpan.');
    }

    public function edit(int $id)
    {
        return view('pages.admin.products-form', [
            'product' => Product::findOrFail($id),
            'categories' => ProductCategory::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $product = Product::findOrFail($id);
        $product->update($this->validateData($request, $product->id));

        return redirect('/admin/products')->with('status', $product->name.' diperbarui, stock '.$product->stock.'.');
    }

    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);

        if ($product->cartItems()->exists() || $product->orderItems()->exists()) {
            return back()->withErrors(['product' => 'Tidak bisa hapus: masih ada di cart atau order. Nonaktifkan saja.']);
        }

        // Relasi cartItems/orderItems didefinisikan di model bila ada. Fallback aman:
        $product->delete();

        return redirect('/admin/products')->with('status', 'Produk dihapus.');
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:150', Rule::unique('products', 'slug')->ignore($ignoreId)],
            'category_id' => ['nullable', 'integer', 'exists:product_categories,id'],
            'description' => ['nullable', 'string', 'max:2000'],
            'usage_instructions' => ['nullable', 'string', 'max:2000'],
            'price' => ['required', 'integer', 'min:0', 'max:100000000'],
            'stock' => ['required', 'integer', 'min:0', 'max:1000000'],
            'image_url' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['slug'] = ($validated['slug'] ?? null) ?: Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
