<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    public $timestamps = FALSE;
    protected $guarded = ['id'];
}
