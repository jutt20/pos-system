<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'tracking_url',
        'api_endpoint',
        'api_key',
        'base_cost',
        'per_item_cost',
        'estimated_days',
        'is_active',
        'service_areas',
        'description'
    ];

    protected $casts = [
        'base_cost' => 'decimal:2',
        'per_item_cost' => 'decimal:2',
        'is_active' => 'boolean',
        'service_areas' => 'array'
    ];

    public function calculateCost($quantity = 1)
    {
        return $this->base_cost + ($this->per_item_cost * $quantity);
    }

    public function getTrackingUrl($trackingNumber)
    {
        return str_replace('{tracking_number}', $trackingNumber, $this->tracking_url);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
