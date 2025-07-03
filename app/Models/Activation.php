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
        'brand',
        'plan',
        'sku',
        'quantity',
        'activation_date',
        'price',
        'cost',
        'profit',
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
}
