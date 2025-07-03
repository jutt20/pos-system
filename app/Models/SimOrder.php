<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'vendor',
        'brand',
        'sim_type',
        'quantity',
        'order_date',
        'cost_per_sim',
        'total_cost',
        'status',
        'tracking_number',
        'invoice_file',
        'employee_id',
    ];

    protected $casts = [
        'order_date' => 'date',
        'cost_per_sim' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public static function generateOrderNumber()
    {
        $lastOrder = self::latest()->first();
        $number = $lastOrder ? intval(substr($lastOrder->order_number, 3)) + 1 : 1;
        return 'SO-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}
