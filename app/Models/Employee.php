<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'position',
        'salary',
        'hire_date',
        'status',
        'employee_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'hire_date' => 'date',
        'salary' => 'decimal:2',
    ];

    public function isSuperAdmin()
    {
        return $this->hasRole('Super Admin');
    }

    public function isAdmin()
    {
        return $this->hasRole(['Super Admin', 'Admin']);
    }

    public function canManageEmployees()
    {
        return $this->hasPermissionTo('manage employees') || $this->isSuperAdmin();
    }

    public function canManageCustomers()
    {
        return $this->hasPermissionTo('manage customers') || $this->isSuperAdmin();
    }

    public function canManageInvoices()
    {
        return $this->hasPermissionTo('manage invoices') || $this->isSuperAdmin();
    }

    public function canManageActivations()
    {
        return $this->hasPermissionTo('manage activations') || $this->isSuperAdmin();
    }

    public function canManageOrders()
    {
        return $this->hasPermissionTo('manage orders') || $this->isSuperAdmin();
    }

    public function canViewReports()
    {
        return $this->hasPermissionTo('view reports') || $this->isSuperAdmin();
    }

    // Relationships
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'created_by');
    }

    public function activations()
    {
        return $this->hasMany(Activation::class, 'created_by');
    }

    public function simOrders()
    {
        return $this->hasMany(SimOrder::class, 'created_by');
    }
}
