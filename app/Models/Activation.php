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
        'sim_number',
        'phone_number',
        'package_type',
        'activation_fee',
        'monthly_fee',
        'status',
        'activation_date',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'activation_date' => 'date',
        'expiry_date' => 'date',
        'activation_fee' => 'decimal:2',
        'monthly_fee' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
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

    public function getIsExpiredAttribute()
    {
        return $this->expiry_date && $this->expiry_date < now();
    }
}
