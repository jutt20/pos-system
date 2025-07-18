<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'customer';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'company',
        'address',
        'balance',
        'prepaid_status',
        'assigned_employee_id',
        'status',
        'created_by',
        'city',
        'state',
        'zip_code',
        'id_number',
        'id_type',
        'date_of_birth',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'password' => 'hashed',
    ];

    // 🔁 Relationships

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

    public function createdBy()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }

    public function assignedEmployee()
    {
        return $this->belongsTo(Employee::class, 'assigned_employee_id');
    }

    // 🧠 Accessors

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getTotalSpentAttribute()
    {
        return $this->invoices()->where('status', 'paid')->sum('total_amount');
    }
}
