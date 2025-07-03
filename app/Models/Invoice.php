<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'notes'
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

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

    public static function generateInvoiceNumber()
    {
        $lastInvoice = self::latest()->first();
        $number = $lastInvoice ? intval(substr($lastInvoice->invoice_number, 4)) + 1 : 1;
        return 'INV-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }

    public function getFormattedInvoiceDateAttribute()
    {
        return $this->invoice_date ? $this->invoice_date->format('M d, Y') : 'N/A';
    }

    public function getFormattedDueDateAttribute()
    {
        return $this->due_date ? $this->due_date->format('M d, Y') : 'N/A';
    }

    public function isOverdue()
    {
        return $this->due_date && $this->due_date->isPast() && $this->status !== 'paid';
    }
}
