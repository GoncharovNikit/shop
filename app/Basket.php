<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    public $timestamps = FALSE;
    protected $table = 'basket';

    protected $guarded = [];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_vendorCode');
    }
    public function sizes()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
}
