<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Selling extends Model
{
    protected $table = 'sellings';

    protected $guarded = [];

    public function stockDistribution()
    {
        return $this->hasMany('App\StockDistribution');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
