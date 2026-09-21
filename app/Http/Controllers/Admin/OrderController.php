<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public const TRANSITIONS = [
        'pending' => ['confirmed', 'cancelled'],
        'confirmed' => ['processing', 'cancelled'],
        'processing' => ['ready', 'cancelled'],
        'ready' => ['completed', 'cancelled'],
        'completed' => [],
        'cancelled' => [],
    ];

    public function index(Request $request)
    {
        $query = Order::with('user')->orderBy('id', 'desc');

        if ($request->filled('status') && in_array($request->string('status')->toString(), Order::STATUSES, true)) {
            $query->where('status', $request->string('status')->toString());
        }

        return view('pages.admin.orders-index', [
            'orders' => $query->paginate(20)->withQueryString(),
            'status' => $request->string('status')->toString(),
        ]);
    }

    public function show(int $id)
    {
        $order = Order::with(['items', 'user'])->findOrFail($id);

        return view('pages.admin.orders-show', [
            'order' => $order,
            'allowed' => self::TRANSITIONS[$order->status] ?? [],
        ]);
    }

    public function updateStatus(Request $request, int $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,confirmed,processing,ready,completed,cancelled'],
            'payment_status' => ['nullable', 'string', 'in:pending,paid,failed,refunded'],
        ]);

        $allowed = self::TRANSITIONS[$order->status] ?? [];

        if (! in_array($validated['status'], $allowed, true)) {
            return back()->withErrors(['status' => 'Transisi dari '.$order->status.' ke '.$validated['status'].' tidak diizinkan.']);
        }

        $order->update([
            'status' => $validated['status'],
            'payment_status' => $validated['payment_status'] ?? $order->payment_status,
        ]);

        return redirect('/admin/orders/'.$order->id)->with('status', 'Order '.$order->reference.' menjadi '.$order->status.'.');
    }
}
