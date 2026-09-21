<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public const TRANSITIONS = [
        'pending' => ['confirmed', 'cancelled'],
        'confirmed' => ['completed', 'cancelled'],
        'completed' => [],
        'cancelled' => [],
    ];

    public function index(Request $request)
    {
        $query = Booking::with(['service', 'barber', 'user'])->orderBy('appointment_date', 'desc')->orderBy('start_time', 'desc');

        if ($request->filled('status') && in_array($request->string('status')->toString(), Booking::STATUSES, true)) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('date')) {
            $query->where('appointment_date', $request->string('date')->toString());
        }

        return view('pages.admin.bookings-index', [
            'bookings' => $query->paginate(20)->withQueryString(),
            'status' => $request->string('status')->toString(),
            'date' => $request->string('date')->toString(),
        ]);
    }

    public function show(int $id)
    {
        $booking = Booking::with(['service', 'barber', 'user'])->findOrFail($id);

        return view('pages.admin.bookings-show', [
            'booking' => $booking,
            'allowed' => self::TRANSITIONS[$booking->status] ?? [],
        ]);
    }

    public function updateStatus(Request $request, int $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,confirmed,completed,cancelled'],
        ]);

        $allowed = self::TRANSITIONS[$booking->status] ?? [];

        if (! in_array($validated['status'], $allowed, true)) {
            return back()->withErrors(['status' => 'Transisi dari '.$booking->status.' ke '.$validated['status'].' tidak diizinkan.']);
        }

        $booking->update(['status' => $validated['status']]);

        return redirect('/admin/bookings/'.$booking->id)->with('status', 'Booking '.$booking->reference.' menjadi '.$booking->status.'.');
    }
}
