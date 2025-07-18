<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'employee_id',
        'invoice_date',
        'due_date',
        'subtotal',
        'tax_amount',
        'total_amount',
        'status',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    // 🔁 Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    // 🔖 Optional accessor to get bootstrap badge class
    public function getStatusBadgeAttribute()
    {
        return [
            'draft' => 'secondary',
            'sent' => 'info',
            'paid' => 'success',
            'overdue' => 'danger',
            'cancelled' => 'dark'
        ][$this->status] ?? 'secondary';
    }

    // 🔎 Scopes
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeUnpaid($query)
    {
        return $query->whereIn('status', ['draft', 'sent', 'overdue']);
    }

    // 🔢 Custom invoice number generator (month-based)
    public static function generateInvoiceNumber()
    {
        $prefix = 'INV-' . now()->format('Ym'); // e.g., "INV-202507"

        $latestInvoice = self::where('invoice_number', 'like', "$prefix-%")
            ->orderByDesc('invoice_number')
            ->first();

        $lastNumber = $latestInvoice
            ? (int) substr($latestInvoice->invoice_number, -4)
            : 0;

        $nextNumber = $lastNumber + 1;

        return $prefix . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
