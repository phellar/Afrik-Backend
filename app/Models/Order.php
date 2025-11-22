<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable =
     [
        'Ref',
        'customer_name',
        'customer_phone',
        'customer_email',
        'address',
        'total'
    ];

    public function items()
{
    return $this->hasMany(OrderItem::class, 'order_id');
}

}
