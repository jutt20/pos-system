<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'document_type',
        'document_name',
        'file_path',
        'file_size',
        'mime_type',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
