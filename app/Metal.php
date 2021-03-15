<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metal extends Model
{
    public $timestamps = FALSE;
    
    public function products()
    {
        return $this->hasMany(Product::class, 'metal_id');
    }
}
