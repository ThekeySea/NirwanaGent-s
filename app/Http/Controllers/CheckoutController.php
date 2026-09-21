<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public const DELIVERY_FEE = 15000;

    public function index(Request $request)
    {
        $items = CartItem::with('product')
            ->where('user_id', $request->user()->id)
            ->orderBy('id')
            ->get()
            ->filter(fn ($i) => $i->product && $i->product->is_active);

        if ($items->isEmpty()) {
            return redirect('/cart')->withErrors(['cart' => 'Keranjang kosong. Tambah produk dulu.']);
        }

        $subtotal = $items->sum(fn ($i) => $i->product->price * $i->quantity);

        return view('pages.checkout-index', [
            'items' => $items,
            'subtotal' => $subtotal,
            'user' => $request->user(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'fulfillment' => ['required', 'in:pickup,delivery'],
            'shipping_address' => ['required_if:fulfillment,delivery', 'nullable', 'string', 'max:500'],
            'payment_method' => ['required', 'in:qris,transfer,cash_on_pickup'],
        ]);

        if ($validated['fulfillment'] === 'pickup' && $validated['payment_method'] === 'transfer') {
            // Tetap boleh, tidak ada larangan bisnis. Lanjut.
        }

        try {
            $order = DB::transaction(function () use ($validated, $request) {
                $items = CartItem::where('user_id', $request->user()->id)
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->get();

                if ($items->isEmpty()) {
                    throw new \DomainException('Keranjang kosong. Tambah produk dulu.');
                }

                $productIds = $items->pluck('product_id')->all();
                $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

                $subtotal = 0;
                $lines = [];

                foreach ($items as $item) {
                    $product = $products->get($item->product_id);

                    if (! $product || ! $product->is_active) {
                        throw new \DomainException('Ada produk nonaktif di keranjang. Hapus dulu sebelum checkout.');
                    }

                    if ($item->quantity < 1 || $item->quantity > 99) {
                        throw new \DomainException('Quantity tidak valid. Periksa keranjang.');
                    }

                    if ($item->quantity > $product->stock) {
                        throw new \DomainException($product->name.': stock tersisa '.$product->stock.'. Kurangi quantity.');
                    }

                    // Harga selalu dari database, bukan dari browser.
                    $lineTotal = $product->price * $item->quantity;
                    $subtotal += $lineTotal;

                    $lines[] = [
                        'product' => $product,
                        'quantity' => $item->quantity,
                        'unit_price' => $product->price,
                        'line_total' => $lineTotal,
                    ];
                }

                $shippingFee = $validated['fulfillment'] === 'delivery' ? self::DELIVERY_FEE : 0;

                $order = Order::create([
                    'reference' => Order::makeReference(),
                    'user_id' => $request->user()->id,
                    'subtotal' => $subtotal,
                    'shipping_fee' => $shippingFee,
                    'total' => $subtotal + $shippingFee,
                    'fulfillment' => $validated['fulfillment'],
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => 'pending',
                    'status' => 'pending',
                    'customer_name' => $validated['customer_name'],
                    'customer_phone' => $validated['customer_phone'],
                    'shipping_address' => $validated['fulfillment'] === 'delivery' ? $validated['shipping_address'] : null,
                ]);

                foreach ($lines as $line) {
                    $order->items()->create([
                        'product_id' => $line['product']->id,
                        'product_name_snapshot' => $line['product']->name,
                        'unit_price' => $line['unit_price'],
                        'quantity' => $line['quantity'],
                        'line_total' => $line['line_total'],
                    ]);

                    $line['product']->decrement('stock', $line['quantity']);
                }

                CartItem::where('user_id', $request->user()->id)->delete();

                return $order;
            });
        } catch (\DomainException $e) {
            return redirect('/cart')->withErrors(['cart' => $e->getMessage()]);
        }

        return redirect('/checkout/success?reference='.$order->reference);
    }

    public function success(Request $request)
    {
        $order = Order::with('items')
            ->where('reference', $request->query('reference', ''))
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return view('pages.checkout-success', ['order' => $order]);
    }
}
