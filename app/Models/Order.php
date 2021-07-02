<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'status'];

    function orders()
    {
        return $this->hasMany(OrderItem::class);
    }

    function scopeJoinOrderItems($query)
    {
        return $query->leftJoin('order_items as ot', 'orders.id', '=', 'ot.order_id');
    }

    function scopeJoinProducts($query)
    {
        return $query->leftJoin('products', 'ot.product_id', '=', 'products.id');
    }
}
