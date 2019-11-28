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

    public function buying()
    {
        return $this->belongsTo('App\Buying');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    public function generation()
    {
        return $this->belongsTo('App\Generation');
    }
}
