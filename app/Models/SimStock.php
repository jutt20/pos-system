<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'sim_number',
        'iccid',
        'sim_type',
        'vendor',
        'brand',
        'cost',
        'status',
        'pin1',
        'puk1',
        'pin2',
        'puk2',
        'qr_activation_code',
        'batch_id',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
    ];
}
