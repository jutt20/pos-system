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
        'cnic',
        'balance',
        'prepaid_status',
        'status',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function documents()
    {
        return $this->hasMany(CustomerDocument::class);
    }

    public function activations()
    {
        return $this->hasMany(Activation::class);
    }
}
