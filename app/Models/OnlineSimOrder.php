<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnlineSimOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_id',
        'brand',
        'sim_type',
        'quantity',
        'unit_price',
        'total_amount',
        'delivery_option',
        'delivery_service_id',
        'delivery_cost',
        'delivery_address',
        'delivery_city',
        'delivery_state',
        'delivery_zip',
        'delivery_phone',
        'status',
        'tracking_number',
        'estimated_delivery',
        'notes',
        'admin_notes',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'estimated_delivery' => 'datetime',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'delivery_cost' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function deliveryService(): BelongsTo
    {
        return $this->belongsTo(DeliveryService::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'pending' => 'bg-warning',
            'approved' => 'bg-info',
            'processing' => 'bg-primary',
            'shipped' => 'bg-success',
            'delivered' => 'bg-dark',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    public function getTrackingUrl(): ?string
    {
        if (!$this->tracking_number || !$this->deliveryService?->tracking_url) {
            return null;
        }

        return str_replace('{tracking_number}', $this->tracking_number, $this->deliveryService->tracking_url);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = 'OSO-' . strtoupper(uniqid());
            }
        });
    }
}
