<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'user_id',
        'shipping_address',
        'postal_code',
        'total_price',
    ];

    /**
     * Get the user that owns the invoice.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the invoice.
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'invoice_item')
            ->withPivot('quantity', 'subtotal')
            ->withTimestamps();
    }
}
