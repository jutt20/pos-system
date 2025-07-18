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
        'previous_stock',
        'new_stock',
        'reason',
        'notes',
        'created_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function simStock(): BelongsTo
    {
        return $this->belongsTo(SimStock::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function recordMovement(
        int $simStockId,
        string $movementType,
        int $quantity,
        int $previousStock,
        int $newStock,
        string $reason = null,
        string $notes = null,
        int $createdBy = null
    ): self {
        return self::create([
            'sim_stock_id' => $simStockId,
            'movement_type' => $movementType,
            'quantity' => $quantity,
            'previous_stock' => $previousStock,
            'new_stock' => $newStock,
            'reason' => $reason,
            'notes' => $notes,
            'created_by' => $createdBy,
        ]);
    }
}
