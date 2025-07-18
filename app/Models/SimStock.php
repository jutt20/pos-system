<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SimStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'sim_number',
        'iccid',
        'category',
        'sim_type',
        'vendor',
        'brand',
        'network_provider',
        'plan_type',
        'monthly_cost',
        'cost',
        'status',
        'stock_level',
        'minimum_stock',
        'pin1',
        'puk1',
        'pin2',
        'puk2',
        'qr_activation_code',
        'batch_id',
        'expiry_date',
        'serial_number',
        'activation_data',
        'activated_at',
        'activated_by',
        'color_code',
        'warehouse_location',
        'shelf_position',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'monthly_cost' => 'decimal:2',
        'activation_data' => 'array',
        'activated_at' => 'datetime',
        'expiry_date' => 'date',
    ];

    // Define SIM categories with their properties
    public static function getCategories()
    {
        return [
            'nexitel_purple_physical' => [
                'name' => 'Nexitel Purple Physical SIM',
                'color' => '#8B5CF6',
                'type' => 'Physical',
                'description' => 'Nexitel Purple branded physical SIM card'
            ],
            'nexitel_purple_esim' => [
                'name' => 'Nexitel Purple eSIM',
                'color' => '#8B5CF6',
                'type' => 'eSIM',
                'description' => 'Nexitel Purple branded electronic SIM'
            ],
            'nexitel_blue_physical' => [
                'name' => 'Nexitel Blue Physical SIM',
                'color' => '#3B82F6',
                'type' => 'Physical',
                'description' => 'Nexitel Blue branded physical SIM card'
            ],
            'nexitel_blue_esim' => [
                'name' => 'Nexitel Blue eSIM',
                'color' => '#3B82F6',
                'type' => 'eSIM',
                'description' => 'Nexitel Blue branded electronic SIM'
            ],
            'esim_only' => [
                'name' => 'Generic eSIM',
                'color' => '#10B981',
                'type' => 'eSIM',
                'description' => 'Generic electronic SIM card'
            ],
        ];
    }

    public function getCategoryInfoAttribute()
    {
        $categories = self::getCategories();
        return $categories[$this->category] ?? null;
    }

    public function getColorCodeAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        $categoryInfo = $this->category_info;
        return $categoryInfo ? $categoryInfo['color'] : '#6B7280';
    }

    public function isPhysicalSim()
    {
        return in_array($this->category, ['nexitel_purple_physical', 'nexitel_blue_physical']);
    }

    public function isESim()
    {
        return in_array($this->category, ['nexitel_purple_esim', 'nexitel_blue_esim', 'esim_only']);
    }

    public function isNexitelBrand()
    {
        return str_contains($this->category, 'nexitel');
    }

    public function isLowStock()
    {
        return $this->stock_level <= $this->minimum_stock;
    }

    public function isExpired()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    // Relationships
    public function movements(): HasMany
    {
        return $this->hasMany(SimStockMovement::class);
    }

    public function activatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'activated_by');
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('stock_level <= minimum_stock');
    }

    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', now());
    }

    public function scopeNexitelPurple($query)
    {
        return $query->whereIn('category', ['nexitel_purple_physical', 'nexitel_purple_esim']);
    }

    public function scopeNexitelBlue($query)
    {
        return $query->whereIn('category', ['nexitel_blue_physical', 'nexitel_blue_esim']);
    }

    public function scopeESims($query)
    {
        return $query->whereIn('category', ['nexitel_purple_esim', 'nexitel_blue_esim', 'esim_only']);
    }

    public function scopePhysicalSims($query)
    {
        return $query->whereIn('category', ['nexitel_purple_physical', 'nexitel_blue_physical']);
    }
}
