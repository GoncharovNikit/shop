<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sizes', 'size_id', 'product_vendorCode');
    }
    public function basket()
    {
        return $this->belongsToMany(Basket::class);
    }
}
