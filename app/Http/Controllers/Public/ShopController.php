<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with('category')->where('is_active', true);

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->string('q') . '%');
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->string('category')));
        }

        return view('pages.shop-index', [
            'products' => $query->orderBy('name')->get(),
            'categories' => ProductCategory::orderBy('name')->get(),
            'q' => $request->string('q')->toString(),
            'activeCategory' => $request->string('category')->toString(),
        ]);
    }

    public function show(string $slug)
    {
        $product = Product::with('category')->where('slug', $slug)->firstOrFail();
        abort_if(! $product->is_active, 404);

        return view('pages.shop-show', ['product' => $product]);
    }
}
