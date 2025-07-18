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

    // ✅ Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    // ✅ Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'secondary',
            'active' => 'success',
            'suspended' => 'warning',
            'terminated' => 'danger',
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    // ✅ Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }
}
