<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'address',
        'balance',
        'prepaid_status',
        'assigned_employee_id',
        'status',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function assignedEmployee()
    {
        return $this->belongsTo(Employee::class, 'assigned_employee_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function activations()
    {
        return $this->hasMany(Activation::class);
    }

    public function documents()
    {
        return $this->hasMany(CustomerDocument::class);
    }

    public function getTotalSpentAttribute()
    {
        return $this->invoices()->where('status', 'paid')->sum('total_amount');
    }

    public function getActiveActivationsAttribute()
    {
        return $this->activations()->where('status', 'active')->count();
    }
}
