<?php

namespace App\Services;

use App\Models\Barber;
use App\Models\BarberTimeOff;
use App\Models\Booking;
use App\Models\BusinessHour;
use App\Models\Service;
use Carbon\Carbon;

class BookingAvailability
{
    public const SLOT_STEP_MINUTES = 30;

    public static function overlaps(string $aStart, string $aEnd, string $bStart, string $bEnd): bool
    {
        return $aStart < $bEnd && $aEnd > $bStart;
    }

    /**
     * @return array<int, array{start: string, end: string, available: bool}>
     */
    public function slots(Service $service, ?Barber $barber, string $date): array
    {
        $day = Carbon::parse($date);
        $hours = BusinessHour::where('day_of_week', (int) $day->format('w'))->first();

        if (! $hours || $hours->is_closed || ! $hours->open_time || ! $hours->close_time) {
            return [];
        }

        $barbers = $this->eligibleBarbers($service, $barber);
        if ($barbers->isEmpty()) {
            return [];
        }

        $open = Carbon::parse($date.' '.$hours->open_time);
        $close = Carbon::parse($date.' '.$hours->close_time);
        $duration = (int) $service->duration_minutes;

        $existing = Booking::activeBlock()
            ->where('appointment_date', $date)
            ->whereIn('barber_id', $barbers->pluck('id')->all())
            ->get(['barber_id', 'start_time', 'end_time']);

        $offs = BarberTimeOff::where('date', $date)
            ->whereIn('barber_id', $barbers->pluck('id')->all())
            ->get();

        $slots = [];
        $cursor = $open->copy();

        while ($cursor->copy()->addMinutes($duration) <= $close) {
            $start = $cursor->format('H:i');
            $end = $cursor->copy()->addMinutes($duration)->format('H:i');
            $startFull = $start.':00';
            $endFull = strlen($end) === 5 ? $end.':00' : $end;

            $available = false;

            if (! $this->isPast($date, $start)) {
                foreach ($barbers as $b) {
                    if ($this->barberFree($b->id, $date, $startFull, $endFull, $existing, $offs)) {
                        $available = true;
                        break;
                    }
                }
            }

            $slots[] = ['start' => $start, 'end' => $end, 'available' => $available];
            $cursor->addMinutes(self::SLOT_STEP_MINUTES);
        }

        return $slots;
    }

    public function eligibleBarbers(Service $service, ?Barber $barber)
    {
        $eligible = Barber::active()
            ->whereHas('services', fn ($q) => $q->where('services.id', $service->id))
            ->get();

        if ($barber) {
            return $eligible->where('id', $barber->id)->values();
        }

        return $eligible->values();
    }

    public function findFreeBarber(Service $service, string $date, string $startFull, string $endFull): ?Barber
    {
        $barbers = Barber::active()
            ->whereHas('services', fn ($q) => $q->where('services.id', $service->id))
            ->orderBy('id')
            ->get();

        $existing = Booking::activeBlock()
            ->where('appointment_date', $date)
            ->whereIn('barber_id', $barbers->pluck('id')->all())
            ->lockForUpdate()
            ->get(['barber_id', 'start_time', 'end_time']);

        $offs = BarberTimeOff::where('date', $date)
            ->whereIn('barber_id', $barbers->pluck('id')->all())
            ->get();

        foreach ($barbers as $b) {
            if ($this->barberFree($b->id, $date, $startFull, $endFull, $existing, $offs)) {
                return $b;
            }
        }

        return null;
    }

    private function barberFree(int $barberId, string $date, string $startFull, string $endFull, $existing, $offs): bool
    {
        foreach ($offs->where('barber_id', $barberId) as $off) {
            if (! $off->start_time || ! $off->end_time) {
                return false;
            }
            if (self::overlaps($startFull, $endFull, substr($off->start_time, 0, 8), substr($off->end_time, 0, 8))) {
                return false;
            }
        }

        foreach ($existing->where('barber_id', $barberId) as $book) {
            if (self::overlaps($startFull, $endFull, substr($book->start_time, 0, 8), substr($book->end_time, 0, 8))) {
                return false;
            }
        }

        return true;
    }

    private function isPast(string $date, string $start): bool
    {
        $startAt = Carbon::parse($date.' '.$start);

        // Buffer 60 menit agar barber punya waktu siap.
        return $startAt->lt(now()->addMinutes(60));
    }
}
