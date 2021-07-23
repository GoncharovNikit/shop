<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    public $timestamps = FALSE;
    protected $guarded = ['id'];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'sale_sizes', 'sale_id', 'size_id');
    }
}
