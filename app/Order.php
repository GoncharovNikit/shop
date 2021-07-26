<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];
    
    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }
    public function delivery_type()
    {
        return $this->belongsTo(DeliveryType::class, 'delivery_type_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_orders', 'order_id', 'product_id')->withPivot(['product_count', 'size']);
    }
}
