<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Barber extends Model
{
    protected $fillable = [
        'name', 'slug', 'role', 'bio', 'specialties', 'image_url', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'barber_service');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
