<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'quantity',
        'photo',
    ];

    /**
     * Get the category that owns the item.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the invoices for the item.
     */
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_item')
            ->withPivot('quantity', 'subtotal')
            ->withTimestamps();
    }
}
