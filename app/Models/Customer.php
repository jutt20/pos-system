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
        'address',
        'city',
        'state',
        'zip_code',
        'id_number',
        'id_type',
        'date_of_birth',
        'created_by'
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

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getTotalSpentAttribute()
    {
        return $this->invoices()->where('status', 'paid')->sum('total_amount');
    }
}
