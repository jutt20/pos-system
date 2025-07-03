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
        'address',
        'cnic',
        'assigned_employee_id',
        'status',
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

    public function simOrders()
    {
        return $this->hasMany(SimOrder::class);
    }

    public function documents()
    {
        return $this->hasMany(CustomerDocument::class);
    }
}
