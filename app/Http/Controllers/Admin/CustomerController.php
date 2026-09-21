<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')->orderBy('name');

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->string('q').'%')
                    ->orWhere('email', 'like', '%'.$request->string('q').'%');
            });
        }

        return view('pages.admin.customers-index', [
            'customers' => $query->paginate(20)->withQueryString(),
            'q' => $request->string('q')->toString(),
        ]);
    }

    public function show(int $id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);

        return view('pages.admin.customers-show', [
            'customer' => $customer,
            'bookings' => Booking::with(['service', 'barber'])
                ->where('user_id', $customer->id)->orderBy('id', 'desc')->take(5)->get(),
            'orders' => Order::where('user_id', $customer->id)->orderBy('id', 'desc')->take(5)->get(),
        ]);
    }

    public function edit(int $id)
    {
        return view('pages.admin.customers-form', [
            'customer' => User::where('role', 'customer')->findOrFail($id),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $customer = User::where('role', 'customer')->findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:30'],
        ]);

        $customer->update($validated);

        return redirect('/admin/customers/'.$customer->id)->with('status', 'Customer diperbarui.');
    }
}
