<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.account-orders', [
            'orders' => Order::where('user_id', $request->user()->id)
                ->orderBy('id', 'desc')
                ->get(),
        ]);
    }

    public function show(Request $request, int $id)
    {
        $order = Order::with('items')
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return view('pages.account-order-show', ['order' => $order]);
    }
}
