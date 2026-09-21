<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'usage_instructions',
        'price', 'stock', 'image_url', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'stock' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function formattedPrice(): string
    {
        return 'Rp '.number_format($this->price, 0, ',', '.');
    }

    public function stockState(): array
    {
        if (! $this->is_active) {
            return ['status' => 'inactive', 'label' => 'Nonaktif'];
        }
        if ($this->stock <= 0) {
            return ['status' => 'cancelled', 'label' => 'Habis'];
        }
        if ($this->stock <= 3) {
            return ['status' => 'low', 'label' => "Sisa {$this->stock}"];
        }

        return ['status' => 'active', 'label' => "Tersedia ({$this->stock})"];
    }
}
