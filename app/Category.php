<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = FALSE;
    
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
