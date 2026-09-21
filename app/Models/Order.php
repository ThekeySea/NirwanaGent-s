<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    public const STATUSES = ['pending', 'confirmed', 'processing', 'ready', 'completed', 'cancelled'];

    public const PAYMENT_METHODS = ['qris', 'transfer', 'cash_on_pickup'];

    public const FULFILLMENTS = ['pickup', 'delivery'];

    protected $fillable = [
        'reference', 'user_id', 'subtotal', 'shipping_fee', 'total',
        'fulfillment', 'payment_method', 'payment_status', 'status',
        'customer_name', 'customer_phone', 'shipping_address',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'integer',
            'shipping_fee' => 'integer',
            'total' => 'integer',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function makeReference(): string
    {
        do {
            $ref = 'NO-'.strtoupper(Str::random(6));
        } while (self::where('reference', $ref)->exists());

        return $ref;
    }

    public function formattedTotal(): string
    {
        return 'Rp '.number_format($this->total, 0, ',', '.');
    }
}
