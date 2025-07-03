<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'phone',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
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

    // Role checking methods
    public function isSuperAdmin()
    {
        return $this->role === 'Super Admin';
    }

    public function isAdmin()
    {
        return in_array($this->role, ['Super Admin', 'Admin']);
    }

    public function isManager()
    {
        return in_array($this->role, ['Super Admin', 'Admin', 'Manager']);
    }

    public function canManageEmployees()
    {
        return in_array($this->role, ['Super Admin', 'Admin']);
    }

    public function canViewReports()
    {
        return in_array($this->role, ['Super Admin', 'Admin', 'Manager']);
    }

    public function canManageCustomers()
    {
        return in_array($this->role, ['Super Admin', 'Admin', 'Manager', 'Sales Agent']);
    }

    public function canCreateInvoices()
    {
        return in_array($this->role, ['Super Admin', 'Admin', 'Manager', 'Sales Agent', 'Cashier']);
    }
}
