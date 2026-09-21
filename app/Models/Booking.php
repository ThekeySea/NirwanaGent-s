<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Booking extends Model
{
    public const STATUSES = ['pending', 'confirmed', 'completed', 'cancelled'];

    protected $fillable = [
        'reference', 'user_id', 'service_id', 'barber_id',
        'appointment_date', 'start_time', 'end_time', 'status', 'notes',
    ];

    protected function casts(): array
    {
        return ['appointment_date' => 'date:Y-m-d'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function barber(): BelongsTo
    {
        return $this->belongsTo(Barber::class);
    }

    public function scopeActiveBlock($query)
    {
        return $query->whereIn('status', ['pending', 'confirmed']);
    }

    public static function makeReference(): string
    {
        do {
            $ref = 'NG-'.strtoupper(Str::random(6));
        } while (self::where('reference', $ref)->exists());

        return $ref;
    }

    public function canBeCancelledByCustomer(): bool
    {
        if (in_array($this->status, ['completed', 'cancelled'], true)) {
            return false;
        }

        // Batas batal H-1 jam 20:00 waktu lokal. Sederhana: tolak bila kurang dari 3 jam sebelum mulai.
        $start = strtotime($this->appointment_date->format('Y-m-d').' '.$this->start_time);

        return $start - time() >= 3 * 3600;
    }
}
