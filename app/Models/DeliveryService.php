<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'base_cost',
        'per_item_cost',
        'estimated_days',
        'tracking_url',
        'is_active',
        'description',
    ];

    protected $casts = [
        'base_cost' => 'decimal:2',
        'per_item_cost' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function onlineSimOrders(): HasMany
    {
        return $this->hasMany(OnlineSimOrder::class);
    }

    public function calculateCost(int $quantity = 1): float
    {
        return $this->base_cost + ($this->per_item_cost * $quantity);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
