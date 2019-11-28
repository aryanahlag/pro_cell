<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $guarded = [];

    public function selling()
    {
        return $this->hasMany('App\Selling');
    }
}
