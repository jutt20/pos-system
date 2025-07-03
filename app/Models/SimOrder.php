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
        'brand',
        'sim_type',
        'quantity',
        'unit_cost',
        'total_cost',
        'vendor',
        'status',
        'notes',
        'order_date'
    ];

    protected $casts = [
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'order_date' => 'date'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getOrderNumberAttribute()
    {
        return 'SO-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'delivered' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }
}
