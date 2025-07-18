<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'delivery_method',
        'pickup_retailer_id',
        'delivery_address',
        'delivery_city',
        'delivery_state',
        'delivery_zip',
        'delivery_phone',
        'delivery_service',
        'tracking_number',
        'delivery_service_url',
        'delivery_cost',
        'estimated_delivery_date',
        'status',
        'admin_notes',
        'customer_notes',
        'approved_by',
        'approved_at',
        'processed_by',
        'processed_at',
        'shipped_at',
        'delivered_at'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'delivery_cost' => 'decimal:2',
        'estimated_delivery_date' => 'date',
        'approved_at' => 'datetime',
        'processed_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = 'OSO-' . strtoupper(uniqid());
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function pickupRetailer()
    {
        return $this->belongsTo(Employee::class, 'pickup_retailer_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }

    public function processedBy()
    {
        return $this->belongsTo(Employee::class, 'processed_by');
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'info',
            'processing' => 'primary',
            'shipped' => 'success',
            'delivered' => 'success',
            'ready_for_pickup' => 'info',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    public function getStatusIconAttribute()
    {
        return match($this->status) {
            'pending' => 'fas fa-clock',
            'approved' => 'fas fa-check-circle',
            'processing' => 'fas fa-cog fa-spin',
            'shipped' => 'fas fa-shipping-fast',
            'delivered' => 'fas fa-check-double',
            'ready_for_pickup' => 'fas fa-store',
            'cancelled' => 'fas fa-times-circle',
            default => 'fas fa-question-circle'
        };
    }

    public function getTrackingUrlAttribute()
    {
        if (!$this->tracking_number || !$this->delivery_service_url) {
            return null;
        }
        
        return str_replace('{tracking_number}', $this->tracking_number, $this->delivery_service_url);
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'approved']);
    }

    public function canBeApproved()
    {
        return $this->status === 'pending';
    }

    public function canBeProcessed()
    {
        return $this->status === 'approved';
    }

    public function canBeShipped()
    {
        return $this->status === 'processing';
    }
}
