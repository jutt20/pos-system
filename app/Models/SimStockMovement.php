<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SimStockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'sim_stock_id',
        'movement_type',
        'quantity',
        'reference_number',
        'notes',
        'user_id',
        'location_from',
        'location_to',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function simStock(): BelongsTo
    {
        return $this->belongsTo(SimStock::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getMovementTypeNameAttribute()
    {
        $types = [
            'in' => 'Stock In',
            'out' => 'Stock Out',
            'transfer' => 'Transfer',
            'adjustment' => 'Adjustment',
            'damaged' => 'Damaged',
            'expired' => 'Expired',
        ];

        return $types[$this->movement_type] ?? $this->movement_type;
    }
}
