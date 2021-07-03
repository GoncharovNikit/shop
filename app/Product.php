<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    public function stone_colors()
    {
        return $this->belongsTo(StoneColor::class, 'stoneColor_id');
    }
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes', 'product_id', 'size_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'basket', 'product_id', 'user_id');
    }
    public function images()
    {
        dd($this->with('categories'));

    }
}
