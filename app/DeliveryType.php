<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryType extends Model
{
    public $timestamps = FALSE;

    public function orders()
    {
        return $this->hasMany(Order::class, 'delivery_type_id');
    }
}
