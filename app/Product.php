<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Product extends Model
{
    const UPDATED_AT = null;
    protected $guarded = ['id'];
    
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function metals()
    {
        return $this->belongsTo(Metal::class, 'metal_id');
    }
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes', 'product_id', 'size_id');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'product_orders', 'product_id', 'order_id');
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'id', 'product_id');
    }

    public function getDescriptionAttribute()
    {
        return LaravelLocalization::getCurrentLocale() == 'uk' ? $this->description_uk : $this->description_ru;
    }
}
