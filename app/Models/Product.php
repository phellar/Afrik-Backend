<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'product_name',
        'product_desc',
        'price',
        'category',
        'product_image'
    ];

    // A product can appear in many order items
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
