<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    public $timestamps = FALSE;

    public function orders()
    {
        return $this->hasMany(Order::class, 'payment_type_id');
    }
}
