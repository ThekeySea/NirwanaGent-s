<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Models\Booking;
use App\Models\Service;
use App\Services\BookingAvailability;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.booking-index', [
            'services' => Service::active()->orderBy('price')->get(),
            'barbers' => Barber::active()->orderBy('name')->get(),
            'selectedService' => $request->query('service'),
            'selectedBarber' => $request->query('barber'),
        ]);
    }

    public function availability(Request $request, BookingAvailability $availability)
    {
        $validated = $request->validate([
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'barber_id' => ['nullable', 'integer', 'exists:barbers,id'],
            'date' => ['required', 'date', 'after_or_equal:today', 'before:'.now()->addDays(30)->format('Y-m-d')],
        ]);

        $service = Service::active()->findOrFail($validated['service_id']);
        $barber = isset($validated['barber_id'])
            ? Barber::active()->findOrFail($validated['barber_id'])
            : null;

        if ($barber && ! $barber->services()->where('services.id', $service->id)->exists()) {
            return response()->json(['message' => 'Barber tidak melayani service ini. Pilih barber lain.'], 422);
        }

        return response()->json([
            'slots' => $availability->slots($service, $barber, $validated['date']),
        ]);
    }

    public function store(Request $request, BookingAvailability $availability)
    {
        $validated = $request->validate([
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'barber_id' => ['nullable', 'integer', 'exists:barbers,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'start' => ['required', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:500'],
            'name' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $service = Service::active()->findOrFail($validated['service_id']);

        $startFull = $validated['start'].':00';
        $endFull = Carbon::parse($validated['date'].' '.$validated['start'])
            ->addMinutes($service->duration_minutes)->format('H:i:s');

        if (Carbon::parse($validated['date'].' '.$validated['start'])->lt(now()->addMinutes(60))) {
            return back()->withErrors(['start' => 'Waktu sudah lewat atau terlalu mepet. Pilih slot lain.'])->withInput();
        }

        try {
            $booking = DB::transaction(function () use ($validated, $service, $startFull, $endFull, $availability, $request) {
                if (! empty($validated['barber_id'])) {
                    $barber = Barber::active()->findOrFail($validated['barber_id']);

                    if (! $barber->services()->where('services.id', $service->id)->exists()) {
                        throw new \DomainException('Barber tidak melayani service ini. Pilih barber lain.');
                    }

                    $conflict = Booking::activeBlock()
                        ->where('barber_id', $barber->id)
                        ->where('appointment_date', $validated['date'])
                        ->lockForUpdate()
                        ->get()
                        ->contains(fn ($b) => BookingAvailability::overlaps(
                            $startFull, $endFull,
                            substr($b->start_time, 0, 8), substr($b->end_time, 0, 8)
                        ));

                    if ($conflict) {
                        throw new \DomainException('Slot '.$validated['start'].' baru saja diambil. Pilih waktu lain.');
                    }
                } else {
                    $barber = $availability->findFreeBarber($service, $validated['date'], $startFull, $endFull);
                    if (! $barber) {
                        throw new \DomainException('Slot '.$validated['start'].' baru saja diambil. Pilih waktu lain.');
                    }
                }

                // Lengkapi profil bila guest checkout dengan nama/telepon? Fase 4 wajib login,
                // jadi nama/telepon opsional hanya jadi notes.
                $notes = $validated['notes'] ?? null;

                return Booking::create([
                    'reference' => Booking::makeReference(),
                    'user_id' => $request->user()->id,
                    'service_id' => $service->id,
                    'barber_id' => $barber->id,
                    'appointment_date' => $validated['date'],
                    'start_time' => $startFull,
                    'end_time' => $endFull,
                    'status' => 'pending',
                    'notes' => $notes,
                ]);
            });
        } catch (\DomainException $e) {
            return back()->withErrors(['start' => $e->getMessage()])->withInput();
        }

        return redirect('/booking/confirmation?reference='.$booking->reference);
    }

    public function confirmation(Request $request)
    {
        $booking = Booking::with(['service', 'barber'])
            ->where('reference', $request->query('reference', ''))
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return view('pages.booking-confirmation', ['booking' => $booking]);
    }

    public function appointments(Request $request)
    {
        $bookings = Booking::with(['service', 'barber'])
            ->where('user_id', $request->user()->id)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get()
            ->groupBy(fn ($b) => match ($b->status) {
                'pending', 'confirmed' => 'upcoming',
                'completed' => 'completed',
                default => 'cancelled',
            });

        return view('pages.account-appointments', [
            'upcoming' => $bookings->get('upcoming', collect()),
            'completed' => $bookings->get('completed', collect()),
            'cancelled' => $bookings->get('cancelled', collect()),
        ]);
    }

    public function cancel(Request $request, int $id)
    {
        $booking = Booking::where('id', $id)->where('user_id', $request->user()->id)->firstOrFail();

        if (! $booking->canBeCancelledByCustomer()) {
            $reason = in_array($booking->status, ['completed', 'cancelled'], true)
                ? 'Appointment sudah '.$booking->status.' dan tidak bisa dibatalkan.'
                : 'Batas batal minimal 3 jam sebelum mulai. Hubungi barbershop untuk perubahan mepet.';

            return back()->withErrors(['booking' => $reason]);
        }

        $booking->update(['status' => 'cancelled']);

        return redirect('/account/appointments')->with('status', 'Appointment '.$booking->reference.' dibatalkan.');
    }
}
