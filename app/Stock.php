<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    public function generation()
    {
        return $this->belongsTo('App\Generation');
    }

    public function stockDistribution()
    {
        return $this->hasMany('App\StockDistribution');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
