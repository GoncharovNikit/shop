<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoneColor extends Model
{
    public function products()
    {
        return $this->hasMany(Product::class, 'stoneColor_id');
    }
}
