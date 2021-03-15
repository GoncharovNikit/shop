<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'vendorCode';
    protected $keyType = 'char';
    const UPDATED_AT = null;
    
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function metals()
    {
        return $this->belongsTo(Metal::class, 'metal_id');
    }
    public function stone_colors()
    {
        return $this->belongsTo(StoneColor::class, 'stoneColor_id');
    }
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes', 'product_vendorCode', 'size_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'basket', 'product_vendorCode', 'user_id');
    }
    public function basket()
    {
        return $this->belongsToMany(Basket::class);
    }
}
