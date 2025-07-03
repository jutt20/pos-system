<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'employee';

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
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

    public function assignedCustomers()
    {
        return $this->hasMany(Customer::class, 'assigned_employee_id');
    }

    public function uploadedDocuments()
    {
        return $this->hasMany(CustomerDocument::class, 'uploaded_by');
    }

    // Helper methods for role checking
    public function isSuperAdmin()
    {
        return $this->hasRole('Super Admin');
    }

    public function isAdmin()
    {
        return $this->hasAnyRole(['Super Admin', 'Admin']);
    }

    public function isManager()
    {
        return $this->hasAnyRole(['Super Admin', 'Admin', 'Manager']);
    }
}
