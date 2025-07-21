<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'employee_id',
        'delivery_service_id',
        'brand',
        'sim_type',
        'quantity',
        'unit_cost',
        'total_cost',
        'vendor',
        'order_type',
        'delivery_cost',
        'delivery_address',
        'delivery_city',
        'delivery_state',
        'delivery_zip',
        'delivery_phone',
        'tracking_number',
        'estimated_delivery',
        'status',
        'notes',
        'order_date',
        'approved_at',
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'delivery_cost' => 'decimal:2',
        'order_date' => 'date',
        'estimated_delivery' => 'date',
        'approved_at' => 'datetime',
    ];

    /** Relationships */

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function deliveryService()
    {
        return $this->belongsTo(DeliveryService::class);
    }

    /** Accessors */

    public function getOrderNumberAttribute()
    {
        return 'SO-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'pending' => 'warning',
            'delivered' => 'success',
            'cancelled' => 'danger',
            'shipped' => 'info',
            'processing' => 'secondary',
            default => 'dark'
        };
    }

    public function getDeliveryLabelAttribute()
    {
        return $this->order_type === 'pickup' ? 'Pickup' : 'Delivery';
    }

    public function isPickup(): bool
    {
        return $this->order_type === 'pickup';
    }

    public function isDelivery(): bool
    {
        return $this->order_type === 'delivery';
    }
}
