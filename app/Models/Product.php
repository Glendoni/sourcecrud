<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'type', 'rental_price', 'term','install'];

    function scopeProduct($query, $products){

        return $query->whereIn('name', $products);
    }

    function scopeSelectProduct($query, $products){

        return $query->select($products);
    }

}
