<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $items = CartItem::with('product')
            ->where('user_id', $request->user()->id)
            ->orderBy('id')
            ->get();

        $subtotal = $items->sum(fn ($i) => $i->product ? $i->product->price * $i->quantity : 0);

        return view('pages.cart-index', ['items' => $items, 'subtotal' => $subtotal]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if (! $product->is_active) {
            return back()->withErrors(['product' => 'Produk nonaktif dan tidak bisa ditambahkan.']);
        }

        if ($product->stock <= 0) {
            return back()->withErrors(['product' => 'Stock habis. Tidak bisa ditambahkan.']);
        }

        if ($validated['quantity'] > $product->stock) {
            return back()->withErrors(['product' => 'Quantity melebihi stock ('.$product->stock.'). Kurangi jumlah.']);
        }

        $item = CartItem::firstOrNew([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
        ]);

        $newQty = ($item->exists ? $item->quantity : 0) + $validated['quantity'];

        if ($newQty > $product->stock) {
            return back()->withErrors(['product' => 'Total di keranjang melebihi stock ('.$product->stock.').']);
        }

        $item->quantity = $newQty;
        $item->save();

        return redirect('/cart')->with('status', $product->name.' masuk keranjang.');
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $item = CartItem::with('product')
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if (! $item->product || ! $item->product->is_active) {
            $item->delete();

            return redirect('/cart')->withErrors(['product' => 'Produk sudah nonaktif dan dihapus dari keranjang.']);
        }

        if ($validated['quantity'] > $item->product->stock) {
            return back()->withErrors(['product' => 'Quantity melebihi stock ('.$item->product->stock.').']);
        }

        $item->update(['quantity' => $validated['quantity']]);

        return redirect('/cart')->with('status', 'Quantity diperbarui.');
    }

    public function destroy(Request $request, int $id)
    {
        $item = CartItem::where('id', $id)->where('user_id', $request->user()->id)->firstOrFail();
        $item->delete();

        return redirect('/cart')->with('status', 'Item dihapus dari keranjang.');
    }
}
