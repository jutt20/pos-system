<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'employee_id',
        'created_by',
        'brand',
        'plan',
        'sku',
        'quantity',
        'price',
        'cost',
        'profit',
        'activation_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'activation_date' => 'date',
        'price' => 'decimal:2',
        'cost' => 'decimal:2',
        'profit' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'active' => 'green',
            'suspended' => 'orange',
            'terminated' => 'red',
            default => 'gray'
        };
    }
}
