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
        'order_number',
        'sim_type',
        'quantity',
        'unit_price',
        'total_amount',
        'status',
        'order_date',
        'expected_delivery',
        'notes',
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery' => 'date',
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
